<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  //Homepage view
  public function index(){
    if ( Auth::check() || Auth::guard('teacher')->check()) {
      return redirect()->action('DashboardController@show');
    }
    // return redirect()->action('HomeController@index');
    return view('home.home');
  }
}
