<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Teacher;
use App\Subject;
use App\teacherHasSubject;

class TeacherHasSubjectController extends Controller
{
  public function create(){
    if ( !(Auth::check())) {
        return redirect()->action('HomeController@index');
    }
    $teacher = Teacher::all();
    $subject = Subject::all();
    $teacherHasSubject = teacherHasSubject::all();
    return view('teacherHasSubject.create', compact('teacher', 'subject','teacherHasSubject'));
  }

  public function store(){
    if (request('teacherID') == null && request('subjectID') == null) {
      return redirect()->action('TeacherHasSubjectController@create')->withErrors([ "Select both the options"]);
    }else{
      $teacher = teacherHasSubject::where('teacher_id', request('teacherID'))->get();
      $subject = teacherHasSubject::where('subject_id', request('subjectID'))->get();
      if(sizeof($teacher) > 0 && sizeof($subject) > 0 ){
        return redirect()->action('TeacherHasSubjectController@create')->withErrors([ "Teacher is already assigned to the subject."]);
      }else{
         $teacherHasSubject = teacherHasSubject::create([
        'teacher_id' => request('teacherID'),
        'subject_id' => request('subjectID')
    ]);
    return redirect()->action('TeacherHasSubjectController@create')->with('success', "Successfully added Subject to the Teacher: " );;
      }
    }
  }
}
