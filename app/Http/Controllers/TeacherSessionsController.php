<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Session;
class TeacherSessionsController extends Controller
{

  // public function __construct(){
  //   $this->middleware('guest:teacher', ['except' => 'destroy'] ); //this prevents logged in user to see the login page
  // }

  public function create(){
    // if (!(Auth::check() || Auth::guard('teacher')->check())) {
    //     return redirect()->action('HomeController@index');
    // }
    $invalidLogin = NULL;
    return view('sessions.teacherLogin', compact('invalidLogin'));
  }

  public function store(Request $request){
    // if (!(Auth::check() || Auth::guard('teacher')->check())) {
    //     return redirect()->action('HomeController@index');
    // }
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $remember = $request->input('rememberMe');
    if(Auth::guard('teacher')->attempt(['email' => $request->email, 'password' => $request->password],$remember)){
      $teacher_info = DB::table('teachers')->where('email',$request->email)->first();
      Session::put('userEmail',$request->email);
      Session::put('name',$teacher_info->firstName." ".$teacher_info->lastName);
      return redirect()->action('DashboardController@show');
    }else{
      $invalidLogin = 'Wrong email or password. Please try again!';
      return view('sessions.teacherLogin', compact('invalidLogin'));
    }
    // return back();


  }

  public function destroy(){
    Auth::logout();
    Auth::guard('teacher')->logout();
    return redirect()->action('HomeController@index');
    // return back();
  }


} 
