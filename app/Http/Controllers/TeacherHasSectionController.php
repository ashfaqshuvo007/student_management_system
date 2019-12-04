<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Teacher;
use App\Section;
use App\teacherHasSection;
use DB;
class TeacherHasSectionController extends Controller
{
  public function create(){
    if ( !(Auth::check())) {
      return redirect()->action('HomeController@index');
    }
    $skipSectionIds = teacherHasSection::where("class_teacher", "1")->pluck("section_id");
    $teacher = Teacher::orderBy('firstName', 'asc')->get(); 
    $section = Section::whereNotIn("id", $skipSectionIds)->orderBy('class','asc')->get();

    return view('teacherHasSection.create', compact('teacher', 'section'));
  }

  public function store(Request $req){
    $teacherID = $req->teacherID;
    $sectionID = $req->sectionID;
    $class_teacher = $req->class_teacher;
    // dd($class_teacher);

    $req->validate([
      'teacherID' => 'required',
      'sectionID' => 'required'
    ]);
    
    // $query = DB::select("SELECT `teacher_id` AS tid FROM `teacher_has_sections` WHERE teacher_id=$teacherID AND section_id ='$sectionID'");

    $query = DB::table('teacher_has_sections')->where('teacher_id','=',$teacherID)->where('section_id','=',$sectionID)->pluck('teacher_id');
    // print_r($query->first());
    // echo empty($query->first) ? "query empty":"query not empty";
    // return;
    //   dd($query);
    if(sizeof($query)===0){
      $teacherHasSection = teacherHasSection::create([
        'teacher_id' => request('teacherID'),
        'section_id' => request('sectionID'),
        'class_teacher' => ($class_teacher==null) ? '0' : '1'
      ]);
      $teacher = Teacher::findOrFail($teacherID);
      $section = Section::findOrFail($sectionID);
      $message = "Successfully Added: ". $teacher->firstName ."to Section: ". $section->Name ."Class: ". $section->class;
      return redirect()->back()->with('message',$message);
    }
    return redirect()->back()->with('errMessage', "Teacher already assigned to section!");

  }
}
