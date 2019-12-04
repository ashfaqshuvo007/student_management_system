<!-- attendanceHistoryTable -->
@extends('layouts.master2')
@section('content')
  
  
<script type="text/javascript">

window.onload = function() {
  document.getElementById("attendance_date").value = "<?php echo date_format(date_create(str_replace( ",", "", $date)), "Y-m-d");?>";
  document.getElementById("attendance_date").max = new Date().toJSON().slice(0,10);

  // console.log(document.getElementById("attendance_date").max);
}
</script>


  <div class="d-flex panel100p center">
    <div class="d-flex flex-col panel90p xsm-panel100p margin-1 nobdrad xsm-margin-0">
      {{-- @include('posts.post') --}}

      <!-- Form for Date Selection -->
     
      <form class="panel40p tb-panel60p xsm-panel93p nobdrad bg-w pd_1" method="POST" action="/studentAttendance/viewHistory">
        @if(Session::has('message'))
        <div class="successBox">
            <div class="d-flex flex-col flex-wrap center txt_cntr">
                <div style="background: #81C784;
                color: white;
                border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">{{ session::get('Message')}}</div> 
            </div>
        </div>
        @endif
       @if(Session::has('errMessage'))
      <div class="errorBox">
        <div class="d-flex flex-col flex-wrap center txt_cntr">
            <div style="background: #FF6564;
            color: white;
            border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">
            
            {{ session::get('errMessage')}}
        </div> 
      </div>
      @endif
      @php 
          date_default_timezone_set("Asia/Dhaka");
          $max_date =  date("m/d/Y");
      @endphp
        <p>Showing attendance for <strong>{{ $sectionName->name }}</strong>. Select date below:</p>

        {{ csrf_field() }}
        <div class="d-flex flex-wrap flex-md-nowrap">
          <input class="inpt_tg2" id="attendance_date"  type="date" name="attendanceMonth" value="{{date("m/d/Y", strtotime($day))}}" required>
          <input hidden type="text" name="sectionID" id="eg" value="{{ $sectionID }}">
          <input class="panel100p btn_submit mt_1" type="submit">
        </div>
      </form>

      <!-- Table for Showing Student Attendance -->
     <?php
      // $day = date("Y-m-d");
      // dd($present);
      if(!empty($present)){
     ?>
    <div class="bg-w mt_1 pd_1 xsm-panel93p nobdrad">
      <p>Showing attendance for date : <strong>{{ date("F jS, Y", strtotime($day))}}</strong></p>
    <div class="table-responsive " style="overflow-x:auto;">
        <table class="panel100p">
          <thead class="thead-inverse">
            <tr>
              <th>Student Name</th>
              <th>Roll Number</th>
              <th>Attendance Status</th>

            </tr>
          </thead>
          <tbody  class="table-bordered">
            @php
            $count = 0;
            @endphp
            @foreach ($allstudent as $student )


              @php
              $presentValue = 2;
              $count++;
              $student_info = DB::table('students')->where('id',$student->student_id)->first();

              @endphp
              @foreach($present as $pre)
                @php
                
                if($pre->id == $student->student_id){
                  $presentValue = $pre->status;
                  break;
                }
                @endphp
              @endforeach
              <tr class=@if($presentValue==2)"table-danger"@else "table-success"@endif>
                <td>{{ $student_info->name }}</td>
                <td>{{ $student_info->rollNumber }}</td>
                <td>
                  @if($presentValue == 2)
                    Absent
                  @else
                    Present
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    </div>
   <?php 
    }?>
  </div>
</div>


@endsection