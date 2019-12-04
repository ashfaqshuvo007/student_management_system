<?php

namespace App\Http\Controllers;

use App\Teacher;
use Auth;
use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

require 'vendor/autoload.php';

class RegistrationController extends Controller
{ 

    //Teacher Registration view
    public function create(){
      if ( !(Auth::check() )) {
          return redirect()->action('HomeController@index');
      }
      return view('registration.teacherRegister');
    }

    //Teacher Registration Store info to DB

    public function store(){

      //validate the form
      $this->validate(request(),[
        'email' => 'required|email',
        'password' => 'required|min:8|regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[;,.\/~@^&()_+{}:<>?\\\=\-!$#%]).*$/|confirmed' //confirm field will check it the input matches password_confirmation
      ]);

      //Check if duplicate entry exists
      $teacherExists = Teacher::select('email')->where('email', request('email'))->get()->toArray();
      print_r($teacherExists);
      if(empty($teacherExists)){                  
        //create and save a teacher
        $teacher = Teacher::create([
        'firstName' => request('firstName'),
        'lastName' => request('lastName'),
        'gender' => request('gender'),
        'salary' => request('salary'),
        'phoneNumber' => request('phoneNumber'),
        'address' => request('address'),
        'type' => request('type'),
        'email' => request('email'),
        'password' => bcrypt(request('password')),
        ]);

        $successMsg = "Successfully added Teacher: " . request('firstName') . " " . request('lastName');

        //redirect to the home page for example
        return redirect()->back()->with('message', $successMsg);
      }else{
        return Redirect::back()->with('errMessage','Teacher already exists!');
      }
    }


    // Teacher BULK UPLOAD
    public function parse(){
      if(!(array_key_exists('extension', pathinfo($_FILES["fileTload"]['name'])))){
        return Redirect::back()->withErrors(['Error', 'Upload a valid excel file!']);
      }
      //Checking for type of uploaded file =  xls or xlsx
      //Will reject otherwise
      //Create appropriate reader for format and load the file
      if (pathinfo($_FILES["fileTload"]['name'])['extension'] === 'xlsx'){
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet =  $reader->load($_FILES["fileTload"]['tmp_name']);
      }

      elseif (pathinfo($_FILES["fileTload"]['name'])['extension'] === 'xls'){
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $reader->setReadDataOnly(true);
        $spreadsheet =  $reader->load($_FILES["fileTload"]['tmp_name']);
      }

      else{
        return Redirect::back()->withErrors(['Error', 'Upload a valid excel file!']);
      }

      //Rejection criteria
      //Read the active sheet
      if (isset($reader)){
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

        //index = 0 of sheetdata contains the header informaition
        //Parsing through it to determine location of categories (name, mothername etc.)
        //Storing the indices in an array (-1 indicates not set)
        //indices follow the sequence of db columns
        //indices 10 and 11 are for section and class name respectively
        $indices = [-1,-1,-1,-1,-1,-1,-1];
        $categories = sizeof($indices);
        for($i=0;$i<sizeof($sheetData[0]);$i++){
          $haystack = strtolower($sheetData[0][$i]);

          if(strpos($haystack,"first")!==false){
            $indices[0] = $i;
          }
          elseif(strpos($haystack,"last")!==false){
            $indices[1] = $i;
          }
          elseif(strpos($haystack,"gender")!==false){
            $indices[2] = $i;
          }
          elseif(strpos($haystack,"salary")!==false){
            $indices[3] = $i;
          }
          elseif(strpos($haystack,"add")!==false){
            $indices[5] = $i;
          }
          elseif((strpos($haystack,"cont")!==false)  || (strpos($haystack,"phone")!==false)  || (strpos($haystack,"mobile")!==false) || (strpos($haystack,"number")!==false)){
            $indices[4] = $i;
          }
          elseif(strpos($haystack,"mail")!==false){
            $indices[6] = $i;
          }
        }

        //Checking to see if all categories found
        if (in_array(-1, $indices)){
          $errors = ['First Name','Last Name','Gender','Salary','Phone Number','Address','Email'];
          $error_msg = 'Missing column label(s): ';
          for($i=0; $i<sizeof($indices); $i++){
            if($indices[$i] === -1){
              $error_msg = $error_msg . $errors[$i] .", ";
            }
          }
          $error_msg = substr($error_msg, 0, -2);
          return Redirect::back()->withErrors(['Error', $error_msg]);
        }

        // Removing white spaces from Gender, Salary, Phone Number and Email
        for($col=2; $col < 7 ; $col++){
          for($row=1;$row<sizeof($sheetData);$row++){
            if(!(is_null($sheetData[$row][$col]))){
              $sheetData[$row][$col] = preg_replace('/\s+/', '', $sheetData[$row][$col]);
            }
          }
        }

        $teachers = array();
        $invalids = array();
        //Iterate over the other rows, validate data and create student objects
        for($i=1;$i<sizeof($sheetData);$i++){
          //Check gender input
          $gender = strtolower($sheetData[$i][$indices[2]]);
          if (($gender === '1') || ($gender === 'm') || ($gender === 'male') || ($gender === 'boy')){
            $gender = '1';
          }
          elseif(($gender === '2') || ($gender === 'f') || ($gender === 'female') || ($gender === 'girl')){
            $gender = '2';
          }
          else{
            $gender = "false";
          }
          

          //Valid even if only First Name, Last Name, Phone Number and Email provided
          $valid = is_string($sheetData[$i][$indices[0]]) &&
          is_string($sheetData[$i][$indices[1]]) &&
          (is_numeric($gender) || is_null($sheetData[$i][$indices[2]])) &&
          (is_numeric($sheetData[$i][$indices[3]]) || is_null($sheetData[$i][$indices[3]])) &&
          is_numeric($sheetData[$i][$indices[4]]) &&
          (is_string($sheetData[$i][$indices[5]]) || is_null($sheetData[$i][$indices[5]])) &&
          filter_var($sheetData[$i][$indices[6]], FILTER_VALIDATE_EMAIL);

          //Adding students to push to db
          if($valid){
            array_push($teachers, array("firstName"=>$sheetData[$i][$indices[0]],
            "lastName"=>$sheetData[$i][$indices[1]],
            "gender"=>$gender,
            "salary"=>$sheetData[$i][$indices[3]],
            "number"=>$sheetData[$i][$indices[4]],
            "address"=>$sheetData[$i][$indices[5]],
            "email"=>$sheetData[$i][$indices[6]]));
          }

          //Adding errors to notify user
          else{
            if(!(is_string($sheetData[$i][$indices[0]]))){
              array_push($invalids, array("row"=>$i+1, "col"=>"A"));
            }
            if(!(is_string($sheetData[$i][$indices[1]]))){
              array_push($invalids, array("row"=>$i+1, "col"=>"B"));
            }
            if(!(is_numeric($gender) || is_null($sheetData[$i][$indices[2]]))){
              array_push($invalids, array("row"=>$i+1, "col"=>"C"));
            }
            if(!(is_numeric($sheetData[$i][$indices[3]]) || is_null($sheetData[$i][$indices[3]]))){
              array_push($invalids, array("row"=>$i+1, "col"=>"D"));
            }
            if(!(is_numeric($sheetData[$i][$indices[4]]))){
              array_push($invalids, array("row"=>$i+1, "col"=>"E"));
            }
            if(!(is_string($sheetData[$i][$indices[5]]) || is_null($sheetData[$i][$indices[5]]))){
              array_push($invalids, array("row"=>$i+1, "col"=>"F"));
            }
            if(!(filter_var($sheetData[$i][$indices[6]], FILTER_VALIDATE_EMAIL))){
              array_push($invalids, array("row"=>$i+1, "col"=>"G"));
            }
          }
          
          $duplicates = array();
          $insertions = array();
          foreach($teachers as $teacher){
            //Checking for duplicate
            $duplicate = DB::table('teachers')->
            where('email', $teacher['email'])->
            get();

            //Dont create record if duplicate exists
            if (sizeof($duplicate) > 0){
              array_push($duplicates, $teacher['firstName'] . " " . $teacher['lastName']);
            }
            else{
              $teacher_entry = Teacher::create([
                'firstName' => $teacher['firstName'],
                'lastName' => $teacher['lastName'],
                'gender' => $teacher['gender'],
                'salary' => $teacher['salary'],
                'phoneNumber' => $teacher['number'],
                'address' => $teacher['address'],
                'email' => $teacher['email']
              ]);

              array_push($insertions, $teacher['firstName'] . " " . $teacher['lastName']);
            }
          }
        }
        
        $messages = array();
        //Pass back duplicates if any duplicate found
        if(sizeof($duplicates) > 0){
          $duplicate_msg = "Duplicate Record found for names: ";
          foreach($duplicates as $duplicate){
            $duplicate_msg = $duplicate_msg . $duplicate . ', ';
          }
          $duplicate_msg = substr($duplicate_msg, 0, -2);
          array_push($messages, $duplicate_msg);
        }
        // dd("!");
        //Pass back student enrolled
        if(sizeof($insertions) > 0){
          $enrolled_msg = "Teachers successfully registered: ";
          foreach($insertions as $enrolled){
            $enrolled_msg = $enrolled_msg . $enrolled . ', ';
          }
          $enrolled_msg = substr($enrolled_msg, 0, -2);
          array_push($messages, $enrolled_msg);
        }

        //Pass back invalid array if any invalid field found
        if(sizeof($invalids) > 0){
          $invalid_msg = "Invalid data cells: ";
          foreach($invalids as $invalid){
            $invalid_msg = $invalid_msg . $invalid['col'] . $invalid['row'] . ', ';
          }
          $invalid_msg = substr($invalid_msg, 0, -2);
          array_push($messages, $invalid_msg);
          return Redirect::back()->withErrors($messages);
        }

        else{
          $ret_message = "";
          foreach($messages as $message){
            $ret_message = $ret_message . $message . '<br>';
          }
          return redirect()->action('DashboardController@show')->with('message', $ret_message);
        }
      }
    }

    // To make users download the demo excel file
  public function sample(){
    return response()->download(storage_path("app/public/sample_teacher_input.xlsx"));
  }
}
