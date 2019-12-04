<?php

namespace App\Http\Controllers;

use App\Attendance;
use Auth;
use Redirect;
use Carbon\Carbon;
use DateTimeZone;
use DB;
;



class AttendanceController extends Controller
{

  public function index(){
    if (!(Auth::check() || Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }
    //Fetching teacher attendance
    $attendance = DB::select("SELECT attendances.teacher_id as teacherID, attendances.login as attLogin, attendances.logout as attLogout, teachers.firstName as firstName,  teachers.lastName as lastName 
                              FROM attendances ,teachers
                              WHERE attendances.teacher_id=teachers.id ");

                              
    return view('teacher.myattendance', compact('attendance'));
  }


  //Teacher Logout
  public function createLogout(){
    if (!(Auth::check() || Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }
    $now = Carbon::now();
    $nowInDhaka = Carbon::now(new DateTimeZone('Asia/Dhaka'));
    return view('attendance.teacherOut', compact('nowInDhaka'));
  }

  public function create(){
    if (!(Auth::check() || Auth::guard('teacher')->check())) { 
      return redirect()->action('HomeController@index');
    }
    $now = Carbon::now();
    $nowInDhaka = Carbon::now(new DateTimeZone('Asia/Dhaka'));
    return view('attendance.teacherIn', compact('nowInDhaka'));
  }

  //Storing login time for teacher
  public function store(){
    if (!(Auth::check() || Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }
    $now = Carbon::now();
    $nowInDhaka = Carbon::now(new DateTimeZone('Asia/Dhaka'));

    DB::table('attendances')->insert(
      ['login' => $nowInDhaka, 'teacher_id' => Auth::guard('teacher')->user()->id, 'created_at' => $nowInDhaka, 'updated_at' => $nowInDhaka]
    );
    return redirect()->action('DashboardController@show');

  }

  public function logout(){
    if (!(Auth::check() || Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }
    $now = Carbon::now();
    $nowInDhaka = Carbon::now(new DateTimeZone('Asia/Dhaka'));
    $record = DB::table('attendances')->where('teacher_id', Auth::guard('teacher')->user()->id)->where('logout', '')->update(['logout' => $nowInDhaka]);
    return redirect()->action('DashboardController@show');
  }

}
