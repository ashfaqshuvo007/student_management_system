<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Illuminate\Support\Facades\Session;
use App\studentAttendance;
use App\Student;
use App\Section;
use App\sectionHasStudent;
use App\Inventory;
use DateTime;
use App\teacherHasSection;

class StudentAttendanceController extends Controller

{

  public function create()
  {

    if (!(Auth::check() || Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }

    if (Auth::check()) {

      $student = Student::all();

      $section = Section::orderBy('class', 'asc')->get();

      $sectionHasStudent = sectionHasStudent::all();


      return view('studentAttendance.takeAttendanceSelect', compact('student', 'section', 'sectionHasStudent'));
    } elseif (Auth::guard('teacher')->check()) {

      $teacherID = Auth::guard('teacher')->user()->id;

      $section = DB::table('teacher_has_sections')->where('teacher_id', $teacherID)->where('class_teacher',1)->get();

      return view('studentAttendance.takeAttendanceSelect', compact('section'));
    }
  }


  public function store($id)
  {

    date_default_timezone_set("Asia/Dhaka");
    $day = date("Y-m-d h:i:s");
    $sectionID = $id;

    //Get last seven attendances                      


    $sec_students = DB::table('section_has_students')
      ->where('section_id', '=', $id)
      ->get();

    if (!empty($sec_students) || $sec_students != '') {
      // dd($sec_students);
      return view('studentAttendance.takeAttendanceTable', compact('sec_students', 'sectionID'));
    } else {
      return redirect()->back();
    }
  }

  // === === === === === === === === === === === === === === === === === === === ===
  // === A LOT OF SHIT HAPPENS HERE , TRY TO REFACTOR IN THE NEXT RELEASE === === === 
  //=== === === === === === === ==== === === === === === ==== === === === === === === 
  public function save(Request $req)
  {
    date_default_timezone_set('Asia/Dhaka');
    $day = date("Y-m-");
    $deleteDate = date("Y-m-d");
    $sectionID = request('secID');
    $sectionName = DB::select("SELECT `name`,`class` FROM `sections` WHERE id = $sectionID");
    

    foreach ($sectionName as $result) {
      $name = $result->name;
      $class = $result->class;
      $countForRestore = DB::select("SELECT count(student_attendances.status) as present
      FROM students, section_has_students, sections, student_attendances WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id
      AND sections.name='$name' AND students.id=student_attendances.student_id AND student_attendances.created_at LIKE \"$day% %\" AND student_attendances.status='1'");
    }

    //Inventory Stock Management Initialization
    //...........................................
    foreach ($countForRestore as $id) {
      $count = $id->present;
    }

    $inventoryUsed = $count;
    $currentInventory = DB::select("SELECT CurrentQuantity FROM inventories ORDER BY inventory_id DESC LIMIT 1");

    foreach ($currentInventory as $id) {
      $currentAmount = ($id->CurrentQuantity) + $inventoryUsed;

      $inventory = Inventory::create([
        'UsedPerDayQuantity' => $inventoryUsed,
        'CurrentQuantity' => $currentAmount
      ]);
    }
    //...................................


    //Delete Student Attendance for update
    //.....................................................................
    $studentAttID = DB::select("SELECT student_attendances.id as studentAttID FROM students, section_has_students, sections, student_attendances
      WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id AND sections.name='$name' AND sections.class='$class' 
      AND students.id=student_attendances.student_id AND student_attendances.created_at LIKE '$deleteDate %' ");

    foreach ($studentAttID as $stuAttID) {
      $ID = $stuAttID->studentAttID;
      $deleteAttendances = DB::delete("DELETE FROM `student_attendances` WHERE student_attendances.id='$ID'");
    }
    //...........................................


    //Insert Student Attendance 
    //........................................
    //working
    // dd($sectionName);

    foreach ($sectionName as $result) {
      $name = $result->name;
      $className = $result->class;


      $allstudent = DB::select("SELECT students.id, students.name, students.rollNumber, students.gender
            FROM students, section_has_students, sections
            WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id AND sections.name='$name'AND sections.class='$className' ");
    }

    $i = 1;
    foreach ($allstudent as $result) {
      $studentId = $result->id;
      if (request($i)) {
        $id = request($i);
        $status = 1;
        $studentAttendance = studentAttendance::create([
          'student_id' => $id,
          'status' => $status,
          'gender' => $result->gender
        ]);
      } else {
        $status = 2;
        $id = $studentId;
        $studentAttendance = studentAttendance::create([
          'student_id' => $id,
          'status' => $status,
          'gender' => $result->gender
        ]);
      }
      $i++;
    }
    //.....................................................................


    //Update Inventory Stock Management
    //.....................................................................
    // used per day is as follows:
    foreach ($sectionName as $result) {
      $name = $result->name;
      $countForRestore = DB::select("SELECT count(student_attendances.status) as present
      FROM students, section_has_students, sections, student_attendances WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id
      AND sections.name='$name' AND students.id=student_attendances.student_id AND student_attendances.created_at LIKE \"$day% %\" AND student_attendances.status='1'");
    }
    foreach ($countForRestore as $id) {
      $count = $id->present;
    }
    $inventoryUsed = $count;

    $currentInventory = DB::select("SELECT CurrentQuantity FROM inventories ORDER BY inventory_id DESC LIMIT 1");
    foreach ($currentInventory as $result) {
      $currentAmount = ($result->CurrentQuantity) - $inventoryUsed;
      $inventory = Inventory::create([
        'UsedPerDayQuantity' => $inventoryUsed,
        'CurrentQuantity' => $currentAmount
      ]);
    }
    //............................................................... ......


    //Update Inventory Stock Management
    //.....................................................................
    // $attendanceRecord = DB::select("SELECT gender,COUNT(gender) AS count FROM `students` WHERE (id IN(SELECT student_id FROM `student_attendances` WHERE (DATE(created_at)='$deleteDate') AND status='1') AND id IN(SELECT student_id FROM `section_has_students` WHERE section_id='$sectionID')) GROUP BY gender");
    $allStudentsinSection = DB::select("SELECT gender,COUNT(gender) AS count FROM `students` WHERE id IN(SELECT student_id FROM `section_has_students` WHERE section_id='$sectionID') GROUP BY gender");
    $successMsg = "Class: " . $sectionName[0]->class . ", Section: " . $sectionName[0]->name . "<br>";
    // var_dump($attendanceRecord);die();
    $boysMsg = "";
    $girlsMsg = "";


    /**===========Trying to Chnage Attendance module ============= */
    $boysPresent = 0;
    $girlsPresent = 0;

    $sec_students = DB::table('section_has_students')->where('section_id', '=', $sectionID)->pluck('student_id');
    // dd($sec_students);
    $boysPresentCount = 0;
    $girlsPresentCount = 0;
    $sectionAttendance = DB::table('student_attendances')->where('created_at', 'LIKE', $deleteDate . '%')->where('status', 1)->get();
    foreach ($sectionAttendance as $s_count) {
      if (($sec_students->contains($s_count->student_id)) && ($s_count->gender === 1)) {
        $boysPresentCount++;
      } else if (($sec_students->contains($s_count->student_id)) && ($s_count->gender === 2)) {
        $girlsPresentCount++;
      }
    }

    if (($sec_students->contains($s_count->student_id)) === false) {
      $successMsg = $successMsg . "HOLIDAY! (No students present)";
      return redirect()->action('DashboardController@show')->with('message', $successMsg);
    }

     /**=================== Attendance data table for Teacher's Sections ============== */
     
     $studentsTotal = count($sec_students);
     $presentToday = DB::table('student_attendances')->whereIn('student_id',$sec_students)->whereDate('created_at',date("Y-m-d"))->where('status',1)->pluck('student_id');
    //  dd($presentToday);
    DB::table('attendance_taken')->insert([
      'section_id' => $sectionID,
      'date_taken' => date("Y-m-d"),
      'students_present' => count($presentToday),
      'students_total' => $studentsTotal,
    ]);


    
    /**=================== Attendance data table for Teacher's Sections ============== */




    /**===========Trying to Change Attendance module ============= */
    foreach ($allStudentsinSection as $record) {
      if ($record->gender === 1) {
        $boysMsg = "Boys Present: " . $boysPresentCount . "/" . $record->count . "<br>";
      } else if ($record->gender === 2) {
        $girlsMsg = "Girls Present: " . $girlsPresentCount . "/" . $record->count;
        // dd($girlsPresent);
      }
    }
    $successMsg = $successMsg . $boysMsg . $girlsMsg;



   



    return redirect()->action('DashboardController@show')->with('message', $successMsg);
    //.....................................................................
  }


  // SELECT SECTION TO SHOW ATTENDANCE HISTORY OF THE SECTION
  public function show()
  {

    if (!(Auth::check()) && !(Auth::guard('teacher')->check())) {

      return redirect()->action('HomeController@index');
    }
    if(Auth::guard('teacher')->check()){

      $teacherID = Auth::guard('teacher')->user()->id;
      $sectionIDs = teacherHasSection::where('teacher_id',$teacherID)->pluck('section_id');
      $section = Section::whereIn('id',$sectionIDs)->get();

    } else{
      $section = Section::orderBy('class', 'asc')->get();
    }

    return view('studentAttendance.attendanceHistorySelect', compact( 'section'));
  }


  // SHOW THE HISTORY
  public function viewHistory(Request $r)
  {
    if (!(Auth::check()) && !(Auth::guard('teacher')->check())) {
      return redirect()->action('HomeController@index');
    }
    date_default_timezone_set("Asia/Dhaka");
    $sectionID = request('sectionID');


    $date = request('attendanceMonth');
    $today = date("Y-m-d");

    if ($date > $today) {
      return redirect('/')->with('errMessage', 'OOPS! Something went wrong! Please check yout inputs');
    } else {

      if ($date != null) {
        $day = date($date);
      } else {
        $day = date("Y-m-d");
      }

      //class information
      $sectionName = DB::table('sections')->where('id', $sectionID)->first();

      $name = $sectionName->name;
      $className = $sectionName->class;

      $allstudent = DB::table('section_has_students')->where('section_id', $sectionID)->get();
      $present = DB::select("SELECT students.id,students.name, student_attendances.status, students.rollNumber FROM students, section_has_students, sections, student_attendances
              WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id AND sections.name='$name' AND students.id=student_attendances.student_id
              AND student_attendances.created_at LIKE \"$day %\"");

      if(isset($present)){
      return view('studentAttendance.attendanceHistoryTable', compact('sectionName', 'present', 'allstudent', 'day', 'sectionID', 'date'));
      }else{
        return redirect()->back()->with('errMessage','Attance Was not taken!');
      }
    }
  }


  //checjk if the studnent exists
  public function checkStudentExists()
  {

    if (!(Auth::check() || Auth::guard('teacher')->check())) {

      return redirect()->action('HomeController@index');
    }

    $students = DB::select("SELECT * FROM `students`");



    return view('studentAttendance.getStudentByName')->with('students', $students);
  }



  public function restoreAttendance()
  {

    if (!(Auth::check() || Auth::guard('teacher')->check())) {

      return redirect()->action('HomeController@index');
    }



    $student = Student::all();

    $section = Section::all();

    $sectionHasStudent = sectionHasStudent::all();

    $studentAttendance = studentAttendance::all();



    date_default_timezone_set("Asia/Dhaka");

    $day = date("Y-m-d");

    $sectionID = request('sectionID');

    $sectionName = DB::select("SELECT `name` FROM `sections` WHERE id = $sectionID");

    foreach ($sectionName as $result) {

      $name = $result->name;

      $results = DB::select(

        "SELECT students.id,students.name

                FROM students, section_has_students, sections

                WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id AND sections.name='$name' "
      );



      $allstudent = DB::select(

        "SELECT students.id,students.name

                  FROM students, section_has_students, sections

                  WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id AND sections.name='$name' "
      );



      $present = DB::select(

        "SELECT students.id,students.name, student_attendances.status FROM students, section_has_students, sections, student_attendances

                    WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id AND sections.name='$name' AND students.id=student_attendances.student_id

                    AND student_attendances.created_at LIKE \"$day %\""
      );
    }

    return view('studentAttendance.update', compact('results', 'studentAttendance', 'student', 'section', 'sectionHasStudent', 'allstudent', 'present'));
  }





  public function getTable()
  {
    // if (!(Auth::check())) {
    //   return redirect()->action('HomeController@index');
    // } 
    if (Auth::guard('teacher')->check()) {
      $teacher_id = Auth::guard('teacher')->user()->id;
      $section_ids = teacherHasSection::where('teacher_id', $teacher_id)->pluck('section_id');
      $section = Section::whereIn('id', $section_ids)->get();
    } else {
      $section = Section::orderBy('class', 'asc')->get();
    }


    return view('studentAttendance.attendanceAnalyticsSelect', compact('section'));
  }


  // Attendance analytics
  public function postTable(Request $r)
  {
    // dd($r->all());
    // //Return to Homepage if not logged in
    // if (!(Auth::check())) {
    //   return redirect()->action('HomeController@index');
    // }

    //Get Class and Date information
    $sectionID = request('sectionID');
    $sectionName = Section::select('name', 'id', 'class')->where('id', $sectionID)->get();
    $date = request('attendanceMonth');

    if ($date != null) {
      $attendance_date = date($date);
    } else {
      $attendance_date = date("Y-m");
    }

    //Get ID of students in section 
    $studentIds = sectionHasStudent::where('section_id', $sectionID)->pluck('student_id')->toArray();

    /**============== SOLVED tattendance table Error ======================*/
    $stu_gender = Student::select('gender')->whereIn('id', $studentIds)->get()->toArray();

    $SectionTotal = count($stu_gender); //Total students in section
    //setting all counts to zero
    $b_count = 0;
    $g_count = 0;
    $o_count = 0;

    //Looping through to find boy/girl/others

    for ($g = 0; $g < $SectionTotal; $g++) {
      if ($stu_gender[$g]['gender'] === 1) {
        $b_count++; //if boy , increase one
      } else if ($stu_gender[$g]['gender'] === 2) {
        $g_count++; //if girl , increase one
      } else {
        $o_count++; // if others, increase one
      }
    }
    /**============== SOLVED tattendance table Error ======================*/



    //Return to dashboard with error if section has no students
    if (!($studentIds)) {
      return Redirect::back()->with('errMessage', 'No students in section!');
    }
    // dd(substr($attendance_date, 0, 4));
    //Loop through the days of the month
    $days = cal_days_in_month(CAL_GREGORIAN, substr($attendance_date, -2), substr($attendance_date, 0, 4));

    if ((substr($attendance_date, 0, 4) == date("Y")) && (substr($attendance_date, -2) == date("m"))) {
      $days = (int) date("d");
    }

    // dd($days);


    $attendance_table = array();
    for ($day = 1; $day < $days + 1; $day++) {

      //Get present students
      $daily_attendance = studentAttendance::select('student_id', 'status', 'gender', 'created_at')
        ->whereIn('student_id', $studentIds)
        ->whereYear('created_at', substr($attendance_date, 0, 4))
        ->whereMonth('created_at', substr($attendance_date, 5, 7))
        ->whereDay('created_at', $day)
        ->where('status', '1')
        ->get()
        ->toArray();

      //Insert Holiday row to attendance table if no students present
      if (sizeof($daily_attendance) === 0) {
        array_push($attendance_table, array(
          "date" => date("jS F, Y", mktime(0, 0, 0, (int) substr($attendance_date, -2), $day, (int) substr($attendance_date, 0, 4))),
          "present_boys" => 0,
          "total_boys" => $b_count,
          "present_girls" => 0,
          "total_girls" => $g_count,
          "present_others" => 0,
          "total_others" => $o_count,
          "present_total" => 0,
          "total" =>  count($stu_gender),
          "holiday" => 1
        ));
      } else {
        //Count present and total genders
        $total_students = studentAttendance::select('student_id', 'status', 'gender', 'created_at')
          ->whereIn('student_id', $studentIds)
          ->whereYear('created_at', substr($attendance_date, 0, 4))
          ->whereMonth('created_at', substr($attendance_date, 5, 7))
          ->whereDay('created_at', $day)
          ->get()
          ->toArray();



        $gender_present = array_count_values(array_column($daily_attendance, 'gender'));
        $gender_total = array_count_values(array_column($total_students, 'gender'));
        $present_boiz = 0;
        $present_girls = 0;
        $present_others = 0;
        $total_boys = $b_count;
        $total_girls = $g_count;
        $total_others = $o_count;

        if (array_key_exists(1, $gender_present)) {
          $present_boiz = $gender_present[1];
        }



        if (array_key_exists(2, $gender_present)) {
          $present_girls = $gender_present[2];
        }


        if (array_key_exists(3, $gender_present)) {
          $present_others = $gender_present[3];
        }


        $present_total = $present_others + $present_boiz + $present_girls;
        $total = $total_others + $total_boys + $total_girls;
        //Add row with counts to attendance table
        array_push($attendance_table, array(
          "date" => date("jS F, Y", mktime(0, 0, 0, (int) substr($attendance_date, -2), $day, (int) substr($attendance_date, 0, 4))),
          "present_boys" => $present_boiz,
          "total_boys" => $total_boys,
          "present_girls" => $present_girls,
          "total_girls" => $total_girls,
          "present_others" => $present_others,
          "total_others" => $total_others,
          "present_total" => $present_total,
          "total" =>  $total,
          "holiday" => 0
        ));
      }
    }

    // dd($attendance_table);

    //Getting students for threshold <20%, 20<=to<50%, 50%<=to<80%, >=80%

    //Set up arrays for student names
    $_20 = array();
    $_50 = array();
    $_80 = array();
    $_100 = array();
    //Get attendance for each student in section
    foreach ($studentIds as $stId) {
      $student_attendace = studentAttendance::select('student_id', 'status')
        ->where('student_id', $stId)
        ->whereYear('created_at', substr($attendance_date, 0, 4))
        ->whereMonth('created_at', substr($attendance_date, 5, 7))
        ->get()
        ->toArray();

      //Add if student has had at least one attendance for the month                                            
      if (sizeof($student_attendace) !== 0) {
        $student_name = Student::select('name')->where('id', $stId)->get();
        //Check to see if student is currently enrolled
        if (sizeof($student_name) === 1) {
          //Calculate and add attendance percentage to the corresponding array
          $status = array_count_values(array_column($student_attendace, 'status'));
          //Check if both present and absent values present
          if (array_key_exists(1, $status) && array_key_exists(2, $status)) {
            $attendance_percentage = number_format((float) (($status[1] * 100) / ($status[1] + $status[2])), 2, '.', '');
            //If only presents (no absent)
          } elseif (array_key_exists(1, $status)) {
            $attendance_percentage = 100;
            //No presents (only absents)
          } else {
            $attendance_percentage = 0;
          }

          switch (true) {
            case $attendance_percentage < 20:
              array_push($_20, $student_name[0]->name);
              break;
            case $attendance_percentage < 50:
              array_push($_50, $student_name[0]->name);
              break;
            case $attendance_percentage < 80:
              array_push($_80, $student_name[0]->name);
              break;
            case $attendance_percentage <= 100:
              array_push($_100, $student_name[0]->name);
              break;
          }
        }
      }
    }
    //Store the arrays in a variable to send to the view
    $thresholds = array(
      20 => $_20,
      50 => $_50,
      80 => $_80,
      100 => $_100,
      "rows" => max(sizeof($_20), sizeof($_50), sizeof($_80), sizeof($_100))
    );
    return view('studentAttendance.attendanceAnalyticsTable', compact('attendance_table', 'sectionName', 'date', 'thresholds'));
  }
}
