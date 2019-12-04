<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use App\Student;
use App\Teacher;
use App\Subject;
use App\Section;
use App\teacherHasSection;
use App\teacherHasSubject;
use App\sectionHasStudent;
use Storage;
use App\User;
use Carbon\Carbon;
use DateTimeZone;
use App\Attendance;
use SplFixedArray;

class TeacherController extends Controller
{

  public function showAllAttendance(){
    if ( !(Auth::check())) {
      return redirect()->action('HomeController@index');
    }
    $teacher = Teacher::all();
    if (Auth::guard('teacher')->check()) {
      $teacherID =  Auth::guard('teacher')->user()->id;
    }else{
      $teacherID =  Auth::user()->id;

    }
    date_default_timezone_set("Asia/Dhaka");
    $day = date("Y-m-");

    //$courseInfo = DB::select("SELECT login, logout FROM attendances WHERE teacher_id='$teacherID' AND created_at LIKE \"$day% %\" ");

    $courseInfo = DB::table('attendances')->where('teacher_id',$teacherID)->where('created_at','LIKE',$day.'%')->pluck('login','logout');
    return view('teacher.show', compact('courseInfo', 'teacher'));
  }

  public function postAllAttendance(){
    $teacher = Teacher::all();
    $teacherID = request('teacherID');
    date_default_timezone_set("Asia/Dhaka");
    //$day = date("Y-m-");
    $day = request('teacherAttendanceForTheMonth');
    //$courseInfo = DB::select(" SELECT login, logout FROM attendances WHERE teacher_id='$teacherID' AND created_at LIKE \"$day-% %\" ");
    $courseInfo = DB::table('attendances')->where('teacher_id','=',$teacherID)->where('created_at','LIKE',$day.'%')->get();
    // var_dump($courseInfo);die();
    $teacherName = DB::select(" SELECT firstName FROM teachers WHERE teachers.id = '$teacherID' ");
    return view('teacher.show', compact('courseInfo','teacher','teacherID','teacherName'));
  }

  public function updateAllAttendance(){
    $now = Carbon::now();
    $nowInDhaka = Carbon::now(new DateTimeZone('Asia/Dhaka'));
    $teacherID = request('teacherID');
    $login=request('login');
    $logout=request('logout');
    $date=request('date');
    $invalid = is_null($teacherID) ||
               is_null($login) ||
               is_null($logout) ||
               is_null($date);

    if($invalid)
      return Redirect::back()->withErrors(array("Please ensure to fill in the values before submitting!"));
    else{
      if(strtotime($login) > strtotime($logout))
        return Redirect::back()->withErrors(array("Logout before Login!"));
      else{
        $login = $date . " " . $login;
        $login = date('Y-m-d H:i:s', strtotime($login));
        $logout = $date . " " . $logout;
        $logout = date('Y-m-d H:i:s', strtotime($logout));
       // $found = DB::select("SELECT id FROM `attendances` WHERE teacher_id='$teacherID' AND login LIKE '$date%' AND logout LIKE '$date%'");

        $found = DB::table('attendances')
                    ->where('teacher_id','=',$teacherID)
                    ->where('login','LIKE',$date.'%')
                    ->where('logout','LIKE',$date.'%')
                    ->pluck('id');

        // dd($found);
        if(sizeof($found) != 1)
          return Redirect::back()->withErrors(array("Multiple Logins found! Please fix database!"));
        else{
            Attendance::where('id', $found)->update(['login' => $login, 'logout' => $logout]);
          return redirect()->action('DashboardController@show')->with('message', "Login/Logout time successfully modified!");
        }
      }
    }
  }

  //Select section for student list 
  public function sectionSelect(){
    $teacherID =  Auth::guard('teacher')->user()->id;

    $teacherSections = DB::table('teacher_has_sections')->where('teacher_id',$teacherID)->get();
    return view('student/teacherSectionSelect',compact('teacherSections','teacherID'));
  }

  //Show Students
  public function showStudents(Request $r){
      // dd($r->all());
    $sectionInfo = DB::table('sections')->where('id',$r->sectionID)->first();
    $student = DB::table('section_has_students')->where('section_id',$r->sectionID)->get();

    return view('student.showTeacherStudent', compact('student','sectionInfo'));
  }

  //view all teacher
  public function viewAllTeachers(){
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }
    $teachers = Teacher::paginate(10);
    return view('teacher.viewAllTeachers',compact('teachers'));
    // dd($teachers);
  }

  //Teacher Profile View
  public function viewSingleTeacher($id){
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }

    $teacher = Teacher::findOrFail($id)->toArray();
    //Get Teacher Subjects
    $teacherSubjectIds = teacherhasSubject::where('teacher_id',$id)->pluck('subject_id');
    $subjectInfo = Subject::whereIn('id',$teacherSubjectIds)->pluck('name')->toArray();

    //Get Teacher Sections
    $teacherSectionIds = teacherHasSection::where('teacher_id',$id)->pluck('section_id');
    $sectionInfo = Section::whereIn('id',$teacherSectionIds)->get()->toArray();

    //Get teacher's attendance for the last month
    // // $months = SplFixedArray(12);
    
    //Make a single array for all info
    $teacherInfo = [
      'details' => $teacher,
      'sections' => $sectionInfo,
      'subjects' => $subjectInfo
    ];
  
    dd($teacherInfo);

  }



  //Update Teacher Info View
  public function updateTeacherInfo($id){
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }

    $teacher = Teacher::findOrFail($id);

    return view('teacher.teacherEditInfo',compact('teacher'));
    // dd($teacher);
  }


//Update DATA of Teacher
  public function updateInfo(Request $r){


    $r->validate([
      'firstName' => 'required',
      'lastName' => 'required',
      'gender' => 'required',
      // 'salary' => 'required',
      'address' => 'required',
      'phoneNumber' => 'required',
      'email' => 'required'
    ]);

    $update = Teacher::where('id',$r->teacher_id)->update([
      'firstName' => $r->firstName,
      'lastName' => $r->lastName,
      'gender' => $r->gender,
      'salary' => $r->salary,
      'address' => $r->address,
      'phoneNumber' => $r->phoneNumber,
      'email' => $r->email
    ]);

    if($update === 1){
      return redirect('/teacher/viewAll')->with('message','Teacher Info Updated!');
    }else{
      return redirect()->withErrors('Error occurred! Update was not Possible!');
    }

  }

  public function deleteTeacher($id){
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }
    // $teacher = Teacher::findOrFail($id);

    $teacherHasSection = DB::table('teacher_has_sections')->where('teacher_id',$id)->first();
    $teacherHasSubject = DB::table('teacher_has_subjects')->where('teacher_id',$id)->first();
    // dd($teacherHasSection);

    if(isset($teacherHasSection) && isset($techerHasSubject)){
      return redirect('/teacher/viewAll')->with('errMessage','Teacher Has sections assigned! So deletion not possible');
    }else{
      $delete = Teacher::where('id',$id)->delete();
      if($delete === 1){
        return redirect('/teacher/viewAll')->with('message','Teacher Deleted!');
      }else{
        return redirect('/teacher/viewAll')->with('errMessage','Teacher can not be Deleted!');
      }
    }

  }

}
