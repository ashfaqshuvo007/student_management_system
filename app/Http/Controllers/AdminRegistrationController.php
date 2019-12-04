<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
  public function create(){
    // if ( !(Auth::check() )) {
    //     return redirect()->action('HomeController@index');
    // }
    return view('registration.adminRegister');
  }

  public function store(){
    // if ( !(Auth::check() )) {
    //     return redirect()->action('HomeController@index');
    // }
    //validate the form
    //Password validated to be at least 8 chars with at least 1 upper, 1 lower, 1 special and 1 number
    $this->validate(request()->all,[
      'email' => 'required|email',
      'password' => 'required|min:8|regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[;,.\/~@^&()_+{}:<>?\\\=\-!$#%]).*$/|confirmed' // this confirm field will check it the input matches password_confirmation
    ]);

    //create and save a users
      $user = User::create([
      'firstName' => request('firstName'),
      'lastName' => request('lastName'),
      'gender' => request('gender'),
      'salary' => request('salary'),
      'phoneNumber' => request('phoneNumber'),
      'address' => request('address'),
      // 'type' => request('type'),
      'email' => request('email'),
      'password' => bcrypt(request('password')),
      // 'teacher_id' => request('teacher_id'),
      ]);

    //sign them in
    auth()->login($user);

    //redirect to the home page for example
    return redirect()->action('DashboardController@show');
      }
}
