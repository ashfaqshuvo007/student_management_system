<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use User;
use DB;
class UserSessionsController extends Controller
{

  // public function __construct(){
  //   $this->middleware('guest', ['except' => 'destroy'] ); //this prevents logged in user to see the login page
  // }

  public function create(){
    // if (!(Auth::check() || Auth::guard('teacher')->check())) {
    //     return redirect()->action('HomeController@index');
    // }
    $invalidLogin = NULL;
    return view('sessions.adminLogin', compact('invalidLogin'));
  }

  public function store(Request $request){
    // if (!(Auth::check() || Auth::guard('teacher')->check())) {
    //     return redirect()->action('HomeController@index');
    // }
    // Attempt to authenticate the user, if so then, then sign them in.
    // if(! auth()->attempt(request(['email','password']))){
    //    return back()->withErrors([
    //      'message' => 'Check your Credentials'
    //    ]);
    // }

    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required'
    ]);
    
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
     
      $user_info = DB::table('users')->where('email',$request->email)->first();
      $name = $user_info->firstName." ".$user_info->lastName;
      // dd($user_info);
        Session::put('userEmail',$request->email);
        Session::put('name',$name);
       return redirect()->action('DashboardController@show');
    }else{
      $invalidLogin = 'Wrong email or password. Please try again!';
      return view('sessions.adminLogin', compact('invalidLogin'));
    }
    // // Redirect to the home page
    // return redirect()->action('HomeController@index');
  }

  public function destroy(){
    auth()->logout();
    return redirect()->action('SessionsController@create');
    return back();
  } 
}
