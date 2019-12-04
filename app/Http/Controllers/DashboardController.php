<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Section;
use App\Teacher;
use App\Http\Resources\Student;

class DashboardController extends Controller
{
  public function show()
  {
    if (!((Auth::check()) || (Auth::guard('teacher')->check()))) {
      return redirect()->action('HomeController@index');
    }

    date_default_timezone_set('Asia/Dhaka');
    $day = date("Y-m-d");

    //raw sql queries
    $results = '';

    if (!empty($results)) {
      $status = "yes";
    } else {
      $status = "no";
    }

    //For teacher dashboard
    if (Auth::guard('teacher')->check()) {
      $teacherID =  Auth::guard('teacher')->user()->id;

      //Login time registered to DB
      $results = DB::table('attendances')
        ->where('attendances.teacher_id', '=', $teacherID)
        ->Where('attendances.login', 'LIKE', $day . '%')
        ->first();

      //Logout time registered to DB
      $logout = DB::table('attendances')
        ->where('attendances.teacher_id', '=', $teacherID)
        ->Where('attendances.logout', 'LIKE', $day . '%')
        ->first();

      $teacherSecIds = DB::table('teacher_has_sections')->where('teacher_id', $teacherID)->pluck('section_id');
      $numSection = count($teacherSecIds); //Counts the number of section for the teacher
      $teacherSecInfo = Section::whereIn('id', $teacherSecIds)->get();
      return view('dashboard.show', compact('status', 'results', 'logout', 'numSection', 'teacherSecInfo'));
    }


    //Admin Dashboard
    $totalStudents = count(DB::table('students')->where('is_shown', 1)->pluck('id'));

    // Student attendance report
    $currentYear = date('Y');
    $stdPresent = count(DB::table('student_attendances')->whereDate('created_at', $day)->where('status', 1)->pluck('status'));
    $totalAttendances = count(DB::table('student_attendances')->whereDate('created_at', $day)->pluck('student_id'));
    if ($totalAttendances != 0) {
      $percentile = floor(($stdPresent / $totalAttendances) * 100); //Percentage of students present
    } else {
      $percentile = null;
    }



    //Section attendance report
    $sectionAttendance = DB::table('attendance_taken')->where('date_taken',date("Y-m-d"))->pluck('section_id');
    $sections = Section::whereNotIn('id',$sectionAttendance)->get();
    $teacherAttendance = DB::table('attendances')->whereDate('created_at',date('Y-m-d'))->get();
    $teachersPresent = count($teacherAttendance);


    $teachers = Teacher::all();
    $numTeacher = count($teachers);//Count number of teachers



    // If the teacher logged in late
    $lateComer = [];
    foreach($teacherAttendance as $tea){
      $time = date("H:i:s", strtotime($tea->login));
      $tea_info = Teacher::where('id',$tea->teacher_id)->first();
      $lateComer = [[
        'id' => $tea->teacher_id,
        'name' => $tea_info->firstName. " ". $tea_info->lastName,
        'email' => $tea_info->email,
        'phoneNumber' => $tea_info->phoneNumber,
        'login' => $tea->login,
      ]];
      if($time > "08:30:00"){
        $lateComer = [[
          'id' => $tea->teacher_id,
          'name' => $tea_info->firstName. " ". $tea_info->lastName,
          'email' => $tea_info->email,
          'phoneNumber' => $tea_info->phoneNumber,
          'login' => $tea->login,
          'is_late' => 1
        ]];
      }
    }

    return view('dashboard.show', compact('status', 'results','lateComer', 'totalStudents', 'stdPresent', 'totalAttendances', 'percentile','sections','teachersPresent','numTeacher'));
  }



  public function logout()
  {
    if (!(Auth::check() || Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }
    $now = Carbon::now();
    $nowInDhaka = Carbon::now(new DateTimeZone('Asia/Dhaka'));
    DB::table('attendances')->insert(
      ['logout' => $nowInDhaka, 'teacher_id' => Auth::user()->id]
    );
    return redirect()->action('DashboardController@show');;
  }
}
