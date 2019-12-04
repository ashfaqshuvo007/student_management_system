<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Inventory;
use DB;
use App\studentAttendance;
use App\Student;
use App\Section;
use App\sectionHasStudent;

class InventoryController extends Controller
{
  // Creating the inventory list view
  public function create(){
    if ( !(Auth::check() )) {
      return redirect()->action('HomeController@index');
    }
    $presentForDay = DB::select("SELECT CurrentQuantity FROM inventories ORDER BY inventory_id DESC LIMIT 1");
    $inventory = Inventory::all();
    return view('inventory.create', compact('inventory','presentForDay'));
  }

  //Soting the inventory data for theb day  to DB. Which is reduced as per Student attendance
  public function store(){
    date_default_timezone_set('Asia/Dhaka');
    $day = date("Y-m-d");

    $newAmount =  request('amount');
    $currentAmount = request('current');
    $currentAmount = $currentAmount + $newAmount;


      $inventory = Inventory::create([
      'StartQuantity' =>$newAmount,
      'CurrentQuantity' => $currentAmount

    ]);

    return redirect()->action('DashboardController@show');
  }

}
