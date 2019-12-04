<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;
use App\RemarkCategory;
use App\Remark;
use Response;
use App\Section;
use App\Student;
use App\sectionHasStudent;
use App\studentAttendance;
use Storage;
use App\User;
use Illuminate\Support\Facades\Schema;
use App\Teacher;

require 'vendor/autoload.php';
//use PhpOffice\PhpSpreadsheet\Spreadsheet; 

class StudentController extends Controller
{
  public function create()
  {
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }
    return view('student.newStudent');
  }

  public function sample()
  {
    return response()->download(storage_path("app/public/sample_student_input_section_class.xlsx"));
  }

  public function store(Request $req)
  {
    //Valid even if only name, gender, contact, class, and section provided
    //Just like parser
    $req->validate([
      'name' => 'required',
      'gender' => 'required',
      'contact' => 'required',
      'class' => 'required',
      'section' => 'required',
    ]);
    //Insert student and get the inserted Id
    $createdId = DB::table('students')->insertGetId([
      'name' => request('name'),
      'fatherName' => request('fatherName'),
      'motherName' => request('motherName'),
      'DOB' => request('DOB'),
      'gender' => request('gender'),
      'address' => request('address'),
      'contact' => request('contact'),
      'bloodGroup' => request('bloodGroup'),
      'rollNumber' => request('rollNumber'),
      'birthCertificate' => request('birthCertificate'),
      'familyIncome' => request('familyIncome'),
      'father_occupation' => request('father_occupation'),
      'mother_occupation' => request('mother_occupation'),
      'height' => request('height'),
      'weight' => request('weight'),
      'no_of_siblings' => request('no_of_siblings')
    ]);

    if (!empty($createdId)) {
      //Get the section form user submission
      $section_id = Section::where('name', $req->section)->pluck('id');
      //insert reference into section_has_students DB table
      DB::table('section_has_students')->insert([
        'section_id' => $section_id[0],
        'student_id' => $createdId,
        'year' => date("Y")
      ]);
    }
    return redirect('/student')->with('message', 'Student added successfully!');
  }


  //Student Profile Show
  public function ShowProfile($student_id)
  {

    if (!(Auth::check())) {
      if (!Auth::guard('teacher')->check()) {
        return redirect()->action('HomeController@index');
      }
    }

    $std_section = sectionHasStudent::where('student_id', $student_id)->first();

    if (!isset($std_section) && $std_section == "") {
      return redirect('/student/showAllStudent')->with('errMessage', 'Student not yet assigned to any Section!');
    }

    //Get student info
    $studentInfo = Student::where('id', $student_id)->first();




    //****  For a New Student All Data Are missing *** */

    if (isset($std_section)) {
      $userEmail = Session::get('userEmail');

      //Get Remarks Titles
      $remark_titles = DB::table('remark_category')->get();

      //Teacher Data
      $teachers = Teacher::pluck('email');



      //get All Remarks 
      $remarks = Remark::all();

      //Get section and class name  
      $classInfo = DB::table('sections')->where('id', $std_section->section_id)->first();

      //Get current year present count                        
      $presentNumber = DB::table('student_attendances')
        ->select('status')
        ->where('student_id',  $student_id)
        ->where('status', '1')
        ->whereYear('created_at', '=', date('Y'))
        ->count();

      //Get current year absent count                      
      $absentNumber = DB::table('student_attendances')
        ->select('status')
        ->where('student_id',  $student_id)
        ->where('status', '2')
        ->whereYear('created_at', '=', date('Y'))
        ->count();

      //Get last seven attendances                      
      $sevenDayAttendance = DB::table('student_attendances')
        ->select('status')
        ->where('student_id',  $student_id)
        ->orderBy('created_at', 'desc')
        ->take(7)
        ->get();

      //Get all time attendance grouped by year and present/absent status                      
      $attendanceTrend = DB::select(
        "SELECT 
                                  status, YEAR(created_at) as year, count(status) as att_count
                                  FROM 
                                  `student_attendances` 
                                  WHERE
                                  student_id=:st_id 
                                  group by 
                                  year, status",
        [
          'st_id' => $student_id
        ]
      );

      //Create an array of years where each index has 2 values (1=present, 2=absent) and each of those values hold the number of absents/presents for that respective year
      $attTrend = array();
      foreach ($attendanceTrend as $aTrend) {
        $attTrend[$aTrend->year][$aTrend->status] = $aTrend->att_count;
      }

      $yearlyAttendanceAvg = array();
      foreach ($attTrend as $year => $yearlyAttendance) {
        if (array_key_exists(1, $yearlyAttendance) && array_key_exists(2, $yearlyAttendance)) {
          $yearlyAttendanceAvg[$year] = ($yearlyAttendance[1] * 100) / ($yearlyAttendance[1] + $yearlyAttendance[2]);
        } elseif (array_key_exists(1, $yearlyAttendance)) {
          $yearlyAttendanceAvg[$year] = 100;
        } else {
          $yearlyAttendanceAvg[$year] = 0;
        }
      }

      //Get list of subject names and ids based on which subjects mark has been assigned to the student
      $subjects = DB::table('subjects')
        ->select('id', 'name')
        ->whereIn(
          'id',
          DB::table('marks')
            ->where('student_id', $student_id)
            ->groupBy('subject_id')
            ->pluck('subject_id')
        )
        ->get();

      //Create an array where the values are subject names and each subject names hold a list of exams with each exam holding their grade and the global exam flag
      $sub_grades = array();
      foreach ($subjects as $subject) {
        $grades = DB::table('marks')
          ->select('grade', 'exam_id')
          ->where('student_id', $student_id)
          ->where('subject_id', $subject->id)
          ->get();

        foreach ($grades as $grade) {
          $examInfo = DB::table('exams')
            ->select('name', 'subject_id')
            ->where('id', $grade->exam_id)
            ->get()[0];
          $examInfo->subject_id === NULL ? $global_exam = true : $global_exam = false;
          $sub_grades[$subject->name][$examInfo->name] = array("grade" => $grade->grade, "global" => $global_exam);
        }
      }

      return view('student.studentProfile', compact('studentInfo', 'classInfo', 'presentNumber', 'sevenDayAttendance', 'absentNumber', 'sub_grades', 'yearlyAttendanceAvg', 'remark_titles', 'remarks', 'teachers', 'userEmail'));
    }

    return view('student.studentProfile', compact('studentInfo'));
  }



  //FETHCING ALL STUDENTS DATA
  public function showAllStudent()
  {
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }
    $student = Student::where('is_shown', 1)->sortable()->paginate(10);

    $totalNumSections = Section::count();
    $courseInfo = DB::select("SELECT students.id , sections.name as secName, sections.class as className FROM sections,students,section_has_students
      WHERE sections.id = section_has_students.section_id AND students.id = section_has_students.student_id ");

    return view('student.showAllStudent', compact('student', 'courseInfo', 'totalNumSections'));
  }

  /** ---------- UPDATED DELETE METHOD --------------- */
  public function deleteStudent($std_id)
  {

    $stdInfo = DB::table('section_has_students')->where('student_id', $std_id)->first();

    if (isset($stdInfo)) {
      $update = DB::table('students')
        ->where('id', $std_id)
        ->update([
          'is_shown' => 2
        ]);

      if (isset($update)) {
        return Redirect::back()->with('message', 'Student deleted Successfully!');
      } else {
        return Redirect::back()->with('errMessage', 'Please check again. Error Occurred!');
      }
    } else {
      return Redirect::back()->with('errMessage', 'Student deletion is not possible!');
    }
  }
  /** ---------- UPDATED DELETE METHOD --------------- */

  /**-------------- Get Searched Students -------------------- */
  public function getSearchedStudent(Request $req)
  {

    if ($req->ajax()) {
      $output = '';
      $query = $req->get('query');

      if ($query != '') {
        $result = DB::table('students')
          ->where('is_shown', 1)
          ->where('name', 'LIKE', $query . '%')
          ->get();
      }

      $total_row = $result->count();
      if ($total_row > 0) {
        foreach ($result as $row) {

          $stdInfo = DB::table('section_has_students')->where('student_id', $row->id)->first();
          if (isset($stdInfo) && $stdInfo != "") {
            $secInfo = DB::table('sections')->where('id', $stdInfo->section_id)->first();
            $class = $secInfo->class;
            $secName = $secInfo->name;
            $roll = $row->rollNumber;
          }

          if (isset($secInfo) && $secInfo != "") { } else {
            $class = "Unassigned";
            $secName = "Unassigned";
            $roll = "Unassigned";
          }

          $output .= '
      <tr>
      
       <td>' . $row->id . '</td>
       <td>' . $row->name . '</td>
       <td>' . $class . '</td>
       <td>' . $secName . '</td>
       <td>' . $roll . '</td>
       <td>' . $row->DOB . '</td>
       <td>' . $row->contact . '</td>

      
       <td>
       <ul class="d-flex flex-row center dflex_row_spacearound pd_0 lstyle">
           <li><a href="/student/update/id=' . $row->id . '"><img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit"></a></li>
          <li><a class="btn_submit1 text-white" href="/student/profile/id=' . $row->id . '"><img class="icnimg" src="/img/user2.png" alt="user2"></a></li>
           <li><a href="/student/deleteStudent/id=' . $row->id . '"><img  class="icnimg" src="/img/delete.png" alt="delete"></li>

           
       </ul>
      </td>

      </tr>
      ';
        }
      } else {
        $output = '
     <tr>
      <td align="center" colspan="8">No students Found</td>
     </tr>
     ';
      }

      $students = array(
        'table_data'  => $output,
        'total_data'  => $total_row
      );

      return response()->json($students);
    }
  }

  /**-------------- Get Searched Students -------------------- */


  /**================= View/ Edit Student Data ======================*/

  public function showStudentData($student_id)
  {

    if (!(Auth::check() || Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }

    $student = Student::where('id', $student_id)->first();


    return view('studentAttendance/restore')->with('studentInfo', $student);
  }

  public function updateStudentData(Request $req)
  {
    if (!(Auth::check() || Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }

    $update = DB::table('students')->where('id', request('id'))
      ->update([
        'name' => request('name'),
        'fatherName' => request('fatherName'),
        'motherName' => request('motherName'),
        'DOB' => request('DOB'),
        'address' => request('address'),
        'contact' => request('contact'),
        'bloodGroup' => request('bloodGroup'),
        'rollNumber' => request('rollNumber'),
        'birthCertificate' => request('birthCertificate'),
        'updated_at' => date("Y-m-d H:i:s", time()),
        'gender' => request('gender'),
        'familyIncome' => request('familyIncome'),
        'father_occupation' => request('father_occupation'),
        'mother_occupation' => request('mother_occupation'),
        'height' => request('height'),
        'weight' => request('weight'),
        'no_of_siblings' => request('no_of_siblings')
      ]);

    if ($update === 1) {
      return redirect('/student/showAllStudent')->with('message', 'Student Information Updated');
    } else {
      return redirect('/student/update/id=' . $req->id)->with('errMessage', 'Student Information Update Unsuccessful!');
    }
  }

  /**================= View/ Edit Student Data ======================*/


  public function parse()
  {
    // dd(pathinfo($_FILES["fileToUpload"]['name']));
    if (!(array_key_exists('extension', pathinfo($_FILES["fileToUpload"]['name'])))) {
      return redirect()->back()->with('errMessage', 'Upload a valid excel file!');
    }
    //Checking for type of uploaded file =  xls or xlsx
    //Will reject otherwise
    //Create appropriate reader for format and load the file
    if (pathinfo($_FILES["fileToUpload"]['name'])['extension'] === 'xlsx') {
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      $reader->setReadDataOnly(true);
      $spreadsheet = $reader->load($_FILES["fileToUpload"]['tmp_name']);
    } elseif (pathinfo($_FILES["fileToUpload"]['name'])['extension'] === 'xls') {
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
      $reader->setReadDataOnly(true);
      $spreadsheet = $reader->load($_FILES["fileToUpload"]['tmp_name']);
    } else {
      return Redirect::back()->with('errMessage', 'Upload a valid excel file(.xlsx or .xls)');
    }
    //Rejection criteria
    //Read the active sheet
    if (isset($reader)) {


      $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
      // dd($sheetData);

      //index = 0 of sheetdata contains the header informaition
      //Parsing through it to determine location of categories (name, mothername etc.)
      //Storing the indices in an array (-1 indicates not set)
      //indices follow the sequence of db columns
      //indices 16 and 17 are for section and class name respectively
      $indices = [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1];
      for ($i = 0; $i < sizeof($sheetData[0]); $i++) {
        $haystack = strtolower($sheetData[0][$i]);

        if (strpos($haystack, "name") !== false && strpos($haystack, "father") === false && strpos($haystack, "mother") === false) {
          $indices[0] = $i;
        } elseif (strpos($haystack, "father") !== false  && strpos($haystack, "name") !== false) {
          $indices[1] = $i;
        } elseif (strpos($haystack, "mother") !== false  && strpos($haystack, "name") !== false) {
          $indices[2] = $i;
        } elseif ((strpos($haystack, "date") !== false) || (strpos($haystack, "dob") !== false)) {
          $indices[3] = $i;
        } elseif (strpos($haystack, "add") !== false) {
          $indices[5] = $i;
        } elseif ((strpos($haystack, "cont") !== false) || (strpos($haystack, "phone") !== false) || (strpos($haystack, "mobile") !== false)) {
          $indices[6] = $i;
        } elseif (strpos($haystack, "blood") !== false) {
          $indices[7] = $i;
        } elseif (strpos($haystack, "roll") !== false) {
          $indices[8] = $i;
        } elseif (strpos($haystack, "cert") !== false) {
          $indices[9] = $i;
        } elseif (strpos($haystack, "gend") !== false || (strpos($haystack, "sex") !== false)) {
          $indices[4] = $i;
        } elseif (strpos($haystack, "family") !== false && strpos($haystack, "income") !== false) {
          $indices[10] = $i;
        } elseif ((strpos($haystack, "occupation") !== false || strpos($haystack, "profession") !== false) && strpos($haystack, "father") !== false) {
          $indices[11] = $i;
        } elseif ((strpos($haystack, "occupation") !== false || strpos($haystack, "profession") !== false) && strpos($haystack, "mother") !== false) {
          $indices[12] = $i;
        } elseif (strpos($haystack, "height") !== false) {
          $indices[13] = $i;
        } elseif (strpos($haystack, "weight") !== false) {
          $indices[14] = $i;
        } elseif (strpos($haystack, "sibling") !== false) {
          $indices[15] = $i;
        } elseif (strpos($haystack, "section") !== false) {
          $indices[16] = $i;
        } elseif (strpos($haystack, "class") !== false && strpos($haystack, "previous") === false) {
          $indices[17] = $i;
        }
        // echo $i;
        // print_r($haystack);
        // echo (strpos($haystack, "father") !== false  && strpos($haystack, "name") !== false) ? "fName True" : "fName False";
        // // echo strpos($haystack, "name") === false ? "profession false == True" : "profession true == False";
        // echo "<br>";

      }
      // dd($indices);
      // echo "<br>";
      // return;


      //Checking to see if all categories found
      if (in_array(-1, $indices)) {
        $errors = ['name', 'fatherName', 'motherName', 'DOB', 'gender', 'address', 'contact', 'bloodGroup', 'rollNumber', 'birthCertificate', 'familyIncome', 'father_occupation', 'mother_occupation', 'height', 'weight', 'no_of_siblings', 'section', 'class'];
        $error_msg = 'Missing column label(s): ';
        for ($i = 0; $i < sizeof($indices); $i++) {
          if ($indices[$i] === -1) {
            $error_msg = $error_msg . $errors[$i] . ", ";
          }
        }
        $error_msg = substr($error_msg, 0, -2);
        return Redirect::back()->with('errMessage', $error_msg);
      }
      //Removing white spaces from Date of Birth, Gender, Contact, Blood Group, Roll Number, Birth Certificate and Class
      $no_spaces = [3, 4, 6, 7, 8, 9, 10];
      for ($col = 3; $col < sizeof(array_column($sheetData, 0)); $col++) {
        if (in_array($col, $no_spaces))
          for ($row = 1; $row < sizeof($sheetData); $row++) {
            if (!(is_null($sheetData[$row][$col]))) {
              $sheetData[$row][$col] = preg_replace('/\s+/', '', $sheetData[$row][$col]);
            }
          }
      }
      // dd($sheetData);

      $students = array();
      $invalids = array();
      //Iterate over the other rows, validate data and create student objects
      for ($i = 1; $i < sizeof($sheetData); $i++) {

        //Convert dob from excel date to datetime object
        if (is_numeric($sheetData[$i][$indices[3]])) {
          $dob = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($sheetData[$i][$indices[3]])->format('Y-m-d');
        } else {
          // echo "DOB IS STR";
          $dob = date_create_from_format('m/d/Y', $sheetData[$i][$indices[3]]);
          $dob = is_bool($dob) ? null : $dob->format('Y-m-d');
          if (!$dob) {
            $dob = null;
          }

      

        //Check gender input
        $gender = strtolower($sheetData[$i][$indices[4]]);
        if (($gender === '1') || ($gender === 'm') || ($gender === 'male') || ($gender === 'boy')) {
          $gender = 1;
        } elseif (($gender === '2') || ($gender === 'f') || ($gender === 'female') || ($gender === 'girl')) {
          $gender = 2;
        } else {
          $gender = 3;
        }

        //Check blood group
        $blood_groups = ["A+", "A-", "B+", "B-", "O+", "O-", "AB+", "AB-"];
        $bg = false;
        if (in_array(strtoupper($sheetData[$i][$indices[7]]), $blood_groups)) {
          $bg = true;
        } elseif (is_null($sheetData[$i][$indices[7]])) {
          $bg = true;
        }
        // dd($bg);
        //Valid even if only name, gender, contact, class, and section provided
        $valid = is_string($sheetData[$i][$indices[0]])
          && (is_string($sheetData[$i][$indices[1]]) || is_null($sheetData[$i][$indices[1]]))
          && (is_string($sheetData[$i][$indices[2]]) || is_null($sheetData[$i][$indices[2]]))
          && (is_string($dob) || is_null($dob))
          && (is_numeric($gender))
          && (is_string($sheetData[$i][$indices[5]]) || is_null($sheetData[$i][$indices[5]]))
          && (is_numeric($sheetData[$i][$indices[6]]))
          && ($bg === true)
          && (is_numeric($sheetData[$i][$indices[8]]) || is_null($sheetData[$i][$indices[8]]))
          && (is_numeric($sheetData[$i][$indices[9]]) || is_null($sheetData[$i][$indices[9]]))
          && (is_numeric($sheetData[$i][$indices[10]]) || is_null($sheetData[$i][$indices[10]]))
          && (is_string($sheetData[$i][$indices[11]]) || is_null($sheetData[$i][$indices[11]]))
          && (is_string($sheetData[$i][$indices[12]]) || is_null($sheetData[$i][$indices[12]]))
          && (is_numeric($sheetData[$i][$indices[13]]) || is_null($sheetData[$i][$indices[13]]))
          && (is_numeric($sheetData[$i][$indices[14]]) || is_null($sheetData[$i][$indices[14]]))
          && (is_numeric($sheetData[$i][$indices[15]]) || is_null($sheetData[$i][$indices[15]]))
          && (is_string($sheetData[$i][$indices[16]]) || is_numeric($sheetData[$i][$indices[16]]))
          && (is_string($sheetData[$i][$indices[17]]) || is_numeric($sheetData[$i][$indices[17]]));
        echo $valid ? "Valid<br>" : "Invalid<br>" . $i;
        // dd($valid);
        // echo  $sheetData[$i][$indices[13]];
        // echo (is_numeric($sheetData[$i][$indices[13]])) ? "num":"non num";
        // echo  $sheetData[$i][$indices[14]];
        // echo (is_numeric($sheetData[$i][$indices[14]])) ? "num":"non num";
        //         if(!$valid){
        //           echo is_string($sheetData[$i][$indices[0]]) ? "Name Valid<br>" : "Name Invalid<br>";
        //           echo is_numeric($gender) ? "Gender Valid<br>" : "Gender Invalid<br>";
        //           echo (is_numeric($sheetData[$i][$indices[6]])) ? "Contact Valid<br>" : "Contact Invalid<br>";
        //           echo ((is_string($sheetData[$i][$indices[16]]) || is_numeric($sheetData[$i][$indices[16]]))) ? "Section Valid<br>" : "Section Invalid<br>";
        //           echo (is_string($sheetData[$i][$indices[17]]) || is_numeric($sheetData[$i][$indices[17]])) ? "Class Valid<br>" : "Class Invalid<br>";

        //           // echo $sheetData[$i][$indices[17]] . "<br>";
        //           // echo "INVALID";
        //           // echo $this->letterIndex(12);
        //         }
        //         else{
        //           // echo "VALID";
        //           continue;
        //         }
        // dd($valid);
        //Adding students to push to db
        if ($valid) {

          array_push($students, array(
            "name" => $sheetData[$i][$indices[0]],
            "fatherName" => $sheetData[$i][$indices[1]],
            "motherName" => $sheetData[$i][$indices[2]],
            "DOB" => $dob,
            "gender" => $gender,
            "address" => $sheetData[$i][$indices[5]],
            "contact" => $sheetData[$i][$indices[6]],
            "bloodGroup" => strtoupper($sheetData[$i][$indices[7]]),
            "rollNumber" => $sheetData[$i][$indices[8]],
            "birthCertificate" => $sheetData[$i][$indices[9]],
            "familyIncome" => $sheetData[$i][$indices[10]],
            "father_occupation" => $sheetData[$i][$indices[11]],
            "mother_occupation" => $sheetData[$i][$indices[12]],
            "height" => $sheetData[$i][$indices[13]],
            "weight" => $sheetData[$i][$indices[14]],
            "no_of_siblings" => $sheetData[$i][$indices[15]],
            "section" => $sheetData[$i][$indices[16]],
            "class" => $sheetData[$i][$indices[17]]
          ));
          // dd($students);
        }

        //Adding errors to notify user
        else {

          if (!(is_string($sheetData[$i][$indices[0]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[0])));
          }
          if (!(is_string($sheetData[$i][$indices[1]]) || is_null($sheetData[$i][$indices[1]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[1])));
          }
          if (!(is_string($sheetData[$i][$indices[2]]) || is_null($sheetData[$i][$indices[2]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[2])));
          }
          if (!(is_string($dob) || is_null($dob))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[3])));
          }
          if (!(is_numeric($gender))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[4])));
          }
          if (!(is_string($sheetData[$i][$indices[5]]) || is_null($sheetData[$i][$indices[5]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[5])));
          }
          if (!(is_numeric($sheetData[$i][$indices[6]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[6])));
          }
          if (!($bg)) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[7])));
          }
          if (!(is_numeric($sheetData[$i][$indices[8]]) || is_null($sheetData[$i][$indices[8]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[8])));
          }
          if (!(is_numeric($sheetData[$i][$indices[9]]) || is_null($sheetData[$i][$indices[9]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[9])));
          }
          if (!(is_string($sheetData[$i][$indices[10]]) || is_null($sheetData[$i][$indices[10]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[10])));
          }
          if (!(is_string($sheetData[$i][$indices[11]]) || is_null($sheetData[$i][$indices[11]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[11])));
          }
          if (!(is_string($sheetData[$i][$indices[12]]) || is_null($sheetData[$i][$indices[12]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[12])));
          }
          if (!(is_numeric($sheetData[$i][$indices[13]]) || is_null($sheetData[$i][$indices[13]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[13])));
          }
          if (!(is_numeric($sheetData[$i][$indices[14]]) || is_null($sheetData[$i][$indices[14]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[14])));
          }
          if (!(is_numeric($sheetData[$i][$indices[15]]) || is_null($sheetData[$i][$indices[15]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[15])));
          }
          if (!(is_string($sheetData[$i][$indices[16]]) || is_numeric($sheetData[$i][$indices[16]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[16])));
          }
          if (!(is_string($sheetData[$i][$indices[17]]) || is_numeric($sheetData[$i][$indices[17]]))) {
            array_push($invalids, array("row" => $i + 1, "col" => $this->letterIndex($indices[17])));
          }
        }
      }
      // print_r($invalids);
      // echo "1";
      // return;

      $duplicates = array();
      $students_in_section = array();
      $section_success = array();
      $section_duplicate = array();
      $section_failure = array();
      // dd($students);
      foreach ($students as $student) {
        //Checking for duplicate
        $duplicate = DB::table('students')->where('name', $student['name'])->where('fatherName', $student['fatherName'])->where('motherName', $student['motherName'])->where('DOB', $student['DOB'])->where('gender', $student['gender'])->where('address', $student['address'])->where('contact', $student['contact'])->where('bloodGroup', $student['bloodGroup'])->where('rollNumber', $student['rollNumber'])->where('birthCertificate', $student['birthCertificate'])->where('familyIncome', $student['familyIncome'])->where('father_occupation', $student['father_occupation'])->where('mother_occupation', $student['mother_occupation'])->where('height', $student['height'])->where('weight', $student['weight'])->where('no_of_siblings', $student['no_of_siblings'])->get();

        $section = DB::table('sections')->where('name', $student['section'])->get();

        if (sizeof($section) > 1) {
          foreach ($section as $sec) {
            if ($sec->class == $student['class']) {
              $section = array($sec);
              break;
            }
          }
        }
        $student_id = -1;
        //Dont create record if duplicate exists
        if (sizeof($duplicate) > 0)
          array_push($duplicates, $student['name']);

        else {
          $student_entry = Student::create([
            'name' => $student['name'],
            'fatherName' => $student['fatherName'],
            'motherName' => $student['motherName'],
            'DOB' => $student['DOB'],
            'gender' => $student['gender'],
            'address' => $student['address'],
            'contact' => $student['contact'],
            'bloodGroup' => $student['bloodGroup'],
            'rollNumber' => $student['rollNumber'],
            'birthCertificate' => $student['birthCertificate'],
            "familyIncome" => $student['familyIncome'],
            "father_occupation" => $student['father_occupation'],
            "mother_occupation" => $student['mother_occupation'],
            "height" => $student['height'],
            "weight" => $student['weight'],
            "no_of_siblings" => $student['no_of_siblings']
          ]);
        }

        if (sizeof($section) == 1) {
          if (sizeof($duplicate) > 0) {
            $student_id = $duplicate[0]->id;
          } else {
            $student_id = $student_entry->id;
          }

          if ($student_id > -1) {
            $student_in_section = DB::table('section_has_students')->where('section_id', $section[0]->id)->where('student_id', $student_id)->get();
            if (sizeof($student_in_section) > 0) {
              array_push($students_in_section, $student['name']);
            } else {
              $insert_student_in_section = sectionHasStudent::create([
                'section_id' => $section[0]->id,
                'student_id' => $student_id,
                'year' => date("Y")
              ]);
              array_push($section_success, $student['name']);
            }
          }
        } else {
          if (sizeof($section) > 1) {
            array_push($section_duplicate, $student['section']);
          } else {
            array_push($section_failure, $student['section']);
          }
        }
      }
      // return;

      $messages = array();
      $message_success = true;
      //Pass back invalid array if any invalid field found
      if (sizeof($invalids) > 0) {
        $message_success = false;
        $invalid_msg = "Invalid data cells: ";
        foreach ($invalids as $invalid) {
          $invalid_msg = $invalid_msg . $invalid['col'] . $invalid['row'] . ', ';
        }
        $invalid_msg = substr($invalid_msg, 0, -2);
        array_push($messages, $invalid_msg);
      }
      // dd($messages);

      //Pass back invalid sections
      if (sizeof($section_failure) > 0) {
        $message_success = false;
        $section_fail_message = "Section not Found: ";
        $section_failure = array_unique($section_failure);
        foreach ($section_failure as $failure) {
          $section_fail_message = $section_fail_message . $failure . ', ';
        }
        $section_fail_message = substr($section_fail_message, 0, -2);
        array_push($messages, $section_fail_message);
      }

      //Pass back invalid duplicate sections
      if (sizeof($section_duplicate) > 0) {
        $message_success = false;
        $section_duplicate_message = "Duplicate sections found: ";
        $section_duplicate = array_unique($section_duplicate);
        foreach ($section_duplicate as $duplicate) {
          $section_duplicate_message = $section_duplicate_message . $duplicate . ', ';
        }
        $section_duplicate_message = substr($section_duplicate_message, 0, -2);
        array_push($messages, $section_duplicate_message);
      }

      //Pass back duplicates if any duplicate found
      if (sizeof($duplicates) > 0) {
        $duplicate_msg = "Duplicate Record found for names: ";
        foreach ($duplicates as $duplicate) {
          $duplicate_msg = $duplicate_msg . $duplicate . ', ';
        }
        $duplicate_msg = substr($duplicate_msg, 0, -2);
        array_push($messages, $duplicate_msg);
      }

      //Pass back student already in section
      if (sizeof($students_in_section) > 0) {
        $enrolled_msg = "Students already enrolled in section: ";
        foreach ($students_in_section as $enrolled) {
          $enrolled_msg = $enrolled_msg . $enrolled . ', ';
        }
        $enrolled_msg = substr($enrolled_msg, 0, -2);
        array_push($messages, $enrolled_msg);
      }

      //Pass back student enrolled
      if (sizeof($section_success) > 0) {
        $enrolled_msg = "Students successfully enrolled in section: ";
        foreach ($section_success as $enrolled) {
          $enrolled_msg = $enrolled_msg . $enrolled . ', ';
        }
        $enrolled_msg = substr($enrolled_msg, 0, -2);
        array_push($messages, $enrolled_msg);
      }

      //Pass back successful entries
      if ((sizeof($students) - sizeof($duplicates)) > 0) {
        $creation_message = "Successfully created " . (sizeof($students) - sizeof($duplicates)) . " student records.";
        array_push($messages, $creation_message);
      }
      // dd($messages);
      if ($message_success) {
        $ret_message = "";
        foreach ($messages as $message) {
          $ret_message = $ret_message . $message . '<br>';
        }
        return Redirect::back()->with('message', $ret_message);
      } else {
        return Redirect::back()->with('errMessage', $messages);
      }
    }
  }
}

  private function letterIndex($index)
  {
    switch ($index) {
      case 0:
        return 'A';

      case 1:
        return 'B';

      case 2:
        return 'C';

      case 3:
        return 'D';

      case 4:
        return 'E';

      case 5:
        return 'F';

      case 6:
        return 'G';

      case 7:
        return 'H';

      case 8:
        return 'I';

      case 9:
        return 'J';

      case 10:
        return 'K';

      case 11:
        return 'L';

      case 12:
        return 'M';

      case 13:
        return 'N';

      case 14:
        return 'O';

      case 15:
        return 'P';
    }
  }

  public function promote()
  {
    if (!(Auth::check())) {
      if (!Auth::guard('teacher')->check()) {
        return redirect()->action('HomeController@index');
      } else {
        $teacher_id = Auth::guard('teacher')->id();
      }
    }

    //Get section and class name                              
    if (isset($teacher_id)) {
      $classInfo = DB::table('sections')
        ->select('id', 'name', 'class')
        ->whereIn('id', DB::table('teacher_has_sections')
          ->where('teacher_id', $teacher_id)
          ->pluck('section_id'))
        ->orderBy('class', 'asc')
        ->get();
    } else {
      $classInfo = DB::table('sections')
        ->select('id', 'name', 'class')
        ->orderBy('class', 'asc')
        ->get();
    }
    return view('student.promote', compact('classInfo'));
  }

  public function changeSection(Request $req)
  {

    if (!(Auth::check())) {
      if (!Auth::guard('teacher')->check()) {
        return redirect()->action('HomeController@index');
      }
    }
    $req->validate([
      'student_ids' => 'required'
    ]);
    $student_ids = explode(",", $req->student_ids);
    //dd($student_ids);
    foreach ($student_ids as $id) {
      DB::table('section_has_students')
        ->where('student_id', $id)
        ->update([
          'section_id' => $req->section,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }

    return redirect()->back()->with('message', 'Student(s) Promoted Successfully!');
  }

  //Report Card
  //Marks Module
  //...............................................................................
  public function reportCard(Request $r)
  {
    // dd($r->all());
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }

    $reportCard = array();
    $st_id = request('stId');
    $stInfo = Student::select('id', 'name', 'rollNumber')
      ->where('id', $st_id)
      ->get()[0];

    $classInfo = DB::table('sections')->where(
      'id',
      sectionHasStudent::where('student_id', $st_id)->select('section_id')->get()[0]->section_id
    )->get()[0];

    // $stInfo
    $studentProf = array();
    $studentProf["id"] = $stInfo->id;
    $studentProf["name"] = $stInfo->name;
    $studentProf["rollNumber"] = $stInfo->rollNumber;
    $studentProf["section"] = $classInfo->name;
    $studentProf["class"] = $classInfo->class;
    $reportCard["studentInfo"] = $studentProf;
    // print_r($reportCard);
    // echo '<br>';

    $st_ids = sectionHasStudent::select('student_id')->where('section_id', $classInfo->id)->get();
    $exams = DB::table('exams')->get();
    $reportCardGrades = array();
    foreach ($exams as $exam) {
      //Major Exam and Section Filter
      // print_r($exam);
      // echo '<br>';
      // if($exam->quiz===0){
      //   echo 'true <br>';
      // }
      if ($exam->quiz === 0 && ($exam->section_id === NULL || $exam->section_id === $classInfo->id)) {
        $grades = array();
        $studentGrades = array();
        $marks = DB::table('marks')
          ->where('exam_id', $exam->id)
          ->get();
        // print_r($marks);
        // echo '<br>';           
        foreach ($marks as $mark) {
          array_push($grades, $mark->grade);
          // print_r($mark->student_id);
          // echo '<br>';  
          if ($mark->student_id == $st_id) {
            // echo'paisi<br>';
            $studentGrades['grade'] = $mark->grade;
            $studentGrades['remark'] = $mark->student_remark;
            $studentGrades['letterGrade'] = self::getLetterGrade($mark->grade);
          }
          $studentGrades['classHighest'] = max($grades);
          $subjectName = DB::table('subjects')->select('name')->where('id', $mark->subject_id)->get()[0]->name;
        }
        if (array_key_exists('grade', $studentGrades)) {
          if (array_key_exists($exam->name, $reportCardGrades)) {
            if (array_key_exists($subjectName, $reportCardGrades[$exam->name])) {
              array_push($reportCardGrades[$exam->name][$subjectName], $studentGrades);
            } else {
              $reportCardGrades[$exam->name][$subjectName] = $studentGrades;
            }
          } else {
            $reportCardGrades[$exam->name][$subjectName] = $studentGrades;
          }
        }
      }
    }
    $reportCard['reportCardDetails'] = $reportCardGrades;
    return view('student.reportCard', compact('reportCard'));
  }

  //Convert grade to letterGrade from A-F
  private function getLetterGrade($grade, $aThresh = 90, $bThresh = 80, $cThresh = 70, $dThresh = 60, $eThresh = 50)
  {
    switch ($grade) {
      case $grade >= $aThresh:
        return "A";
        break;
      case $grade >= $bThresh:
        return "B";
        break;
      case $grade >= $cThresh:
        return "C";
        break;
      case $grade >= $dThresh:
        return "D";
        break;
      case $grade >= $eThresh:
        return "E";
        break;
      default:
        return "F";
    }
  }

  /**
   * Student Profile Cascading dropdown handlers
   */

  public function  get_sections($id)
  {

    if ($id) {
      $sections = DB::table('sections')->where('class', $id)->get();
      return response()->json($sections);
    }
  }


  public function  get_section_students($id)
  {

    if ($id) {
      $students = DB::table('section_has_students')->where('section_id', $id)->pluck('student_id');
      $student_info = DB::table('students')->whereIn('id', $students)->get();
      

      return response()->json($student_info);
    }
  }





  public function studentInfo(Request $r)
  {

    $student_id = $r->student_id;


    if (!(Auth::check())) {
      if (!Auth::guard('teacher')->check()) {
        return redirect()->action('HomeController@index');
      }
    }

    $std_section = sectionHasStudent::where('student_id', $student_id)->first();

    if (!isset($std_section) && $std_section == "") {
      return redirect('/student/showAllStudent')->with('errMessage', 'Student not yet assigned to any Section!');
    }

    //Get student info
    $studentInfo = Student::where('id', $student_id)->first();




    //****  For a New Student All Data Are missing *** */

    if (isset($std_section)) {
      $userEmail = Session::get('userEmail');

      //Get Remarks Titles
      $remark_titles = DB::table('remark_category')->get();

      //Teacher Data
      $teachers = Teacher::pluck('email');



      //get All Remarks 
      $remarks = Remark::all();

      //Get section and class name  
      $classInfo = DB::table('sections')->where('id', $std_section->section_id)->first();

      //Get current year present count                        
      $presentNumber = DB::table('student_attendances')
        ->select('status')
        ->where('student_id',  $student_id)
        ->where('status', '1')
        ->whereYear('created_at', '=', date('Y'))
        ->count();

      //Get current year absent count                      
      $absentNumber = DB::table('student_attendances')
        ->select('status')
        ->where('student_id',  $student_id)
        ->where('status', '2')
        ->whereYear('created_at', '=', date('Y'))
        ->count();

      //Get last seven attendances                      
      $sevenDayAttendance = DB::table('student_attendances')
        ->select('status')
        ->where('student_id',  $student_id)
        ->orderBy('created_at', 'desc')
        ->take(7)
        ->get();

      //Get all time attendance grouped by year and present/absent status                      
      $attendanceTrend = DB::select(
        "SELECT 
                                    status, YEAR(created_at) as year, count(status) as att_count
                                    FROM 
                                    `student_attendances` 
                                    WHERE
                                    student_id=:st_id 
                                    group by 
                                    year, status",
        [
          'st_id' => $student_id
        ]
      );

      //Create an array of years where each index has 2 values (1=present, 2=absent) and each of those values hold the number of absents/presents for that respective year
      $attTrend = array();
      foreach ($attendanceTrend as $aTrend) {
        $attTrend[$aTrend->year][$aTrend->status] = $aTrend->att_count;
      }

      $yearlyAttendanceAvg = array();
      foreach ($attTrend as $year => $yearlyAttendance) {
        if (array_key_exists(1, $yearlyAttendance) && array_key_exists(2, $yearlyAttendance)) {
          $yearlyAttendanceAvg[$year] = ($yearlyAttendance[1] * 100) / ($yearlyAttendance[1] + $yearlyAttendance[2]);
        } elseif (array_key_exists(1, $yearlyAttendance)) {
          $yearlyAttendanceAvg[$year] = 100;
        } else {
          $yearlyAttendanceAvg[$year] = 0;
        }
      }

      //Get list of subject names and ids based on which subjects mark has been assigned to the student
      $subjects = DB::table('subjects')
        ->select('id', 'name')
        ->whereIn(
          'id',
          DB::table('marks')
            ->where('student_id', $student_id)
            ->groupBy('subject_id')
            ->pluck('subject_id')
        )
        ->get();

      //Create an array where the values are subject names and each subject names hold a list of exams with each exam holding their grade and the global exam flag
      $sub_grades = array();
      foreach ($subjects as $subject) {
        $grades = DB::table('marks')
          ->select('grade', 'exam_id')
          ->where('student_id', $student_id)
          ->where('subject_id', $subject->id)
          ->get();

        foreach ($grades as $grade) {
          $examInfo = DB::table('exams')
            ->select('name', 'subject_id')
            ->where('id', $grade->exam_id)
            ->get()[0];
          $examInfo->subject_id === NULL ? $global_exam = true : $global_exam = false;
          $sub_grades[$subject->name][$examInfo->name] = array("grade" => $grade->grade, "global" => $global_exam);
        }
      }

      return view('student.studentProfile', compact('studentInfo', 'classInfo', 'presentNumber', 'sevenDayAttendance', 'absentNumber', 'sub_grades', 'yearlyAttendanceAvg', 'remark_titles', 'remarks', 'teachers', 'userEmail'));
    }

    return view('student.studentProfile', compact('studentInfo'));
  }














  /**
   * Student Profile Cascading dropdown handlers
   */
}
