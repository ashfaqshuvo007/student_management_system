<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Subject;
use App\Section;
use Carbon\Carbon;

class MarksController extends Controller
{

    

    public function postAdminExamList(Request $request)
    {
        if (!(Auth::check())) {
            return redirect()->action('HomeController@index');
        }
        $examNumber = request('examNumbers');
        $exams = [];
        for ($i = 1; $i <= $examNumber; $i++) {
            $examName = request('exam' . $i);
            array_push($exams, $examName);
        }
        //dd($exams);
        $data = [
            'examNumber' => $examNumber,
            'examName' => $exams,
        ];

        $curl = curl_init();
        echo 'yo';
        return;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost:8080/api/exam/adminExamCreate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $r = json_decode($response);
            //print_r(json_decode($response));
            return redirect()->action('DashboardController@show', compact('r'));
        }

    }

    public function AdminExamList()
    {
        if (!(Auth::check())) {
            return redirect()->action('HomeController@index');
        }
        
        return view('examination.majorExamList', compact('contents'));
    }


    public function DeleteExamList(Request $request)
    {
        if (!(Auth::check())) {
            return redirect()->action('HomeController@index');
        }
        $examNumber = request('examNumber');
        $examName = request('examName'); 
        $data = [
            'examNumber' => $examNumber,
            'examName' => $examName,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://0.0.0.0:8080/api/exam/adminExamDelete",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $r = json_decode($response);
            //print_r(json_decode($response));
            return redirect()->action('MarksController@AdminExamList', compact('r'));
        }


    }

    public function UpdateExamList(Request $request)
    {
        if (!(Auth::check())) {
            return redirect()->action('HomeController@index');
        }
        $examNumber = request('examNumber');

        $examName = request('examName');

        $exams = [];
        for ($i = 1; $i <= $examNumber; $i++) {
            $examName = request('examName' . $i);
            array_push($exams, $examName);
        }

        $newExam = request('newExam');
        array_push($exams, $newExam);
        $data = [
            'examNumber' => $examNumber,
            'examName' => $exams,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://0.0.0.0:8080/api/exam/adminExamUpdate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $r = json_decode($response);
            //print_r(json_decode($response));
            return redirect()->action('MarksController@AdminExamList', compact('r'));
        }


    }
//...............................................................................


    //Get marks based on filter_attributes
    //Returns marks object with attributes based on return_attributes array
    //return_attributes can be ('id', 'grade', 'student_id', 'student_remark', 'created_at', 'updated_at', 'exam_id', 'section_id', 'subject_id')
    //mark can be filtered based on the filter_attribute (key->value) where the key is the attribute to filter with and value to select for the filter
    //Key can be ONE of the four values ('student_id', 'exam_id', 'section_id', 'subject_id')
    public function getMarks() 
    {

        if (!(Auth::check())) {
            if(!Auth::guard('teacher')->check()){
                return redirect()->action('HomeController@index');  
            }
        }        
        
        $filter_col = array_keys(request('filter_attribute'))[0];
        $filter_val = request('filter_attribute')[$filter_col];
        $keys = array('student_id', 'exam_id', 'section_id', 'subject_id');
        $selection = array('id', 'grade', 'student_id', 'student_remark', 'created_at', 'updated_at', 'exam_id', 'section_id', 'subject_id');
        $intersect = array_intersect(request('return_attributes'), $selection);
        $valid = request('return_attributes') == $intersect;
        if($valid){
            if(in_array($filter_col, $keys)){
                $marks = DB::table('marks')
                            ->whereIn($filter_col, $filter_val)
                            ->select($intersect)
                            ->get();
            }else{
                $marks = DB::table('marks')                
                            // ->select(request('return_attributes'))
                            ->select($intersect)
                            ->get();
            }
        }
        else{
            if(in_array($filter_col, $keys)){
                $marks = DB::table('marks')
                            ->whereIn($filter_col, $filter_val)
                            ->get();
            }else{
                $marks = DB::table('marks')
                            ->get();
            }
        }
       
        return response()->json($marks, 200);
    }

    public function postMarksList(Request $request)
    {
        return view('marks.create', compact('contents'));

    }

    //...............................................................................

}
