<?php
//Variable Declaration
    //.....................................................................
    date_default_timezone_set('Asia/Dhaka');
    $day = date("Y-m-");
    $deleteDate = date("Y-m-d");
    $sectionID = request('secID');
    $sectionName = DB::select("SELECT `name` FROM `sections` WHERE id = $sectionID");


    foreach ($sectionName as $result) {
      $name = $result->name;
      $countForRestore = DB::select("SELECT count(student_attendances.status) as present
      FROM students, section_has_students, sections, student_attendances WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id
      AND sections.name='$name' AND students.id=student_attendances.student_id AND student_attendances.created_at LIKE \"$day% %\"");
    }
    
    
    //Inventory Stock Management Initialization
    //.....................................................................
    //working
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
    //.....................................................................

    
    //Delete Student Attendance for update
    //.....................................................................
    //working
    $studentAttID = DB::select("SELECT student_attendances.id as studentAttID FROM students, section_has_students, sections, student_attendances
      WHERE students.id=section_has_students.student_id AND sections.id=section_has_students.section_id AND sections.name='$name' 
      AND students.id=student_attendances.student_id AND student_attendances.created_at LIKE '$deleteDate %' ");

    foreach ($studentAttID as $stuAttID) {
      $ID = $stuAttID->studentAttID;
      $deleteAttendances = DB::delete("DELETE FROM `student_attendances` WHERE student_attendances.id='$ID'");
    }
    //.....................................................................

    

    //Insert Student Attendance 
    //.....................................................................
    $count = 0;
    for ($i = 1; $i <= request('counter'); $i++) {
      if (request($i)) {
        $count++;
        $id = request($i);
        $status = 1;
        $studentAttendance = studentAttendance::create([
          'student_id' => $id,
          'status' => $status
        ]);
      }
    }


    //Update Inventory Stock Management
    //.....................................................................
    //working
    $inventoryUsed = $count;
    $currentInventory = DB::select("SELECT CurrentQuantity FROM inventories ORDER BY inventory_id DESC LIMIT 1");
    foreach ($currentInventory as $result) {
      $currentAmount = ($result->CurrentQuantity) - $inventoryUsed;
      $inventory = Inventory::create([
        'UsedPerDayQuantity' => $inventoryUsed,
        'CurrentQuantity' => $currentAmount
      ]);
    }
    //.....................................................................


    //Update Inventory Stock Management
     //.....................................................................
    //working
    $attendanceRecord = DB::select("SELECT gender,COUNT(gender) AS count FROM `students` WHERE (id IN(SELECT student_id FROM `student_attendances` WHERE DATE(created_at)='$deleteDate') AND id IN(SELECT student_id FROM `section_has_students` WHERE section_id='$sectionID')) GROUP BY gender");
    $allStudentsinSection = DB::select("SELECT gender,COUNT(gender) AS count FROM `students` WHERE id IN(SELECT student_id FROM `section_has_students` WHERE section_id='$sectionID') GROUP BY gender");
    $successMsg = "Section: " . $sectionName[0]->name . "<br>";
    $boysMsg = "";
    $girlsMsg = "";
    if (sizeof($attendanceRecord) === 0) {
      $successMsg = $successMsg . "HOLIDAY! (No students present)";
      return redirect()->action('DashboardController@show')->with('message', $successMsg);
    }
    foreach ($attendanceRecord as $record) {
      if ((string)$record->gender === '1') {
        $boysMsg = $boysMsg . "Present Boys: " . $record->count;
      } else {
        $girlsMsg = $girlsMsg . "Present Girls: " . $record->count;
      }
    }
    foreach ($allStudentsinSection as $record) {
      if ((string)$record->gender === '1') {
        $boysMsg = $boysMsg . "/" . $record->count . "<br>";
      } else {
        $girlsMsg = $girlsMsg . "/" . $record->count;
      }
    }
    $successMsg = $successMsg . $boysMsg . $girlsMsg;
    return redirect()->action('DashboardController@show')->with('message', $successMsg);
    //.....................................................................
  