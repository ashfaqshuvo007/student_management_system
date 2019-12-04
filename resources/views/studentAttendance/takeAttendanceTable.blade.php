<!-- takeAttendanceTable -->

@extends('layouts.master2')


@section('content')
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
</div>
@endif


<div class="d-flex flex-col flex-wrap">
<!-- content cards -->
<div class="d-flex flex-row flex-wrap xsm-flex-col">
    <div class="d-flex flex-col tb-pl_2 item_center">
        <div class="panel70 xsm-panel80p">
            <h5 class="labelling normal ml_1 xsm-margin-0">ATTENDANCE FOR</h5>
        </div>
        <?php $classInfo = DB::table('sections')->where('id',$sectionID)->first();?>
        <div class="panel70 xsm-panel80p border_bottom">
            <h4 class="ml_1 xsm-margin-0">CLASS {{ $classInfo->class}}, {{ $classInfo->name }}</h4>
        </div>
    </div>
</div>

<form class="xsm-panel100p" method="POST" action="/studentAttendance/save">
{{ csrf_field() }}

<?php 
// dd($sec_students);
    $count = 0;
    $present = False;

   
?>

<div id="attendance_list" class="d-flex flex-row flex-wrap dflex_row_space_evenly xsm-flex-col tb-panel100p padding075p">
  @foreach ($sec_students as $std )

     @php
              $count++;
              //checking if attendance is taken or not
              $std_present =  DB::table('student_attendances')->where('student_id',$std->student_id)->where('created_at','LIKE','%'.date("Y-m-d").'%')->first();
              if(!empty($std_present) && ($std_present->status == 1)){
                  $checked = "checked";//attendance taken already
                  $present = True; //flag throws alert
              }else{
                  //else not checked and allow taking attendance
                  $checked = ""; 
              }
               $student_info = DB::table('students')->where('id',$std->student_id)->first();
               $lastFourAttendance = DB::table('student_attendances')
                                        // ->select('status')
                                        ->where('student_id',  $std->student_id)
                                        ->orderBy('created_at', 'desc')
                                        ->take(4)
                                        ->get();
                
              @endphp

    <!-- <form action="">cards will need to be in the form</form> -->
    <div class="d-flex dflex_row_space_evenly flex-wrap panel30p tb-panel40p xsm-panel100p">
    <input type="checkbox" class="checkboxx" name="{{$count}}" id="{{ $count }}" value="{{$std->student_id }}" {{$checked }}> {{-- put checked on not depending upon status. --}}
    <label for="{{ $count }}" class="attendancelabel">
    
    <div class="p_card">
        <div class="d-flex flex-row ppanel30 tb-panel40 xsm-panel90 mt_1">
            <!-- cards -->
            <div class="d-flex flex-col flex-wrap panel100p borders pd_0 tb-pd_1">
                <div class="d-flex flex-row mt_1">
                    <div class="present_icon d-flex flex-col self_center pl_1"><img class="svg" src="/img/checked.png"
                            alt="checked"></div>
                    <div class="pl_1 xsm-pl_1 tb-pl_1">
                        <h4 class="normal">{{ $student_info->name }}</h4>
                    </div>
                </div>
                <div class="d-flex flex-col flex-wrap mt_2">
                    <div class="d-flex flex-row present_icon content_end">
                        <div class="panel50p d-flex flex-col content_end pl_1">
                            <h5 class="normal mb_1">ROLL: {{ $student_info->rollNumber}}</h5>
                        </div>
                        <div class="d-flex flex-col flex-wrap content_end dflex_row_end panel50p">
                            <ul id="attendance_list" class="d-flex flex-row flex-wrap lstyle self_end mt_0 pr_1 dflex_row_end">
                                @foreach($lastFourAttendance as $d)
                                @if($d->status === 1)
                                <li class="normal">P</li>
                                @else
                                <li class="normal">A</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="a_card">
        <div class="d-flex flex-row ppanel30 tb-panel40 xsm-panel90 mt_1 ">
            <!-- cards -->
            <div class="d-flex flex-col flex-wrap panel100p bordersa pd_0 tb-pd_1">
                <div class="d-flex flex-row mt_1">
                    <div class="present_icon d-flex flex-col self_center pl_1"><img class="svg" src="/img/cancel.png"
                            alt="cancel"></div>
                    <div class="pl_1 xsm-pl_1 tb-pl_1">
                        <h4 class="normal">{{ $student_info->name }}</h4>
                    </div>
                </div>
                <div class="d-flex flex-col flex-wrap mt_2">
                    <div class="d-flex flex-row present_icon">
                        <div class="panel50p d-flex flex-col content_end pl_1">
                            <h5 class="normal mb_1">ROLL: {{ $student_info->rollNumber}}</h5>
                        </div>
                        <div class="d-flex flex-col flex-wrap content_end dflex_row_end panel50p">
                            <ul id="attendance_list" class="d-flex flex-row flex-wrap lstyle self_end mt_0 pr_1 dflex_row_end">
                                    @foreach($lastFourAttendance as $d)
                                    @if($d->status === 1)
                                    <li class="normal">P</li>
                                    @else
                                    <li class="normal">A</li>
                                    @endif
                                    @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    </label>
    </div>

    @endforeach
</div>
    <!-- hidden passed datas -->
    <input type="hidden" name="counter" value="{{ $count }}">
    <input type="hidden" name="secID" name="secID" value="{{ $sectionID }}">

@php

if($present == True){

    echo '<script type="text/javascript">',

            'alert("Attendance For the day has already been taken! Taking attendance again will rewrite previous entries");',

        '</script>';
 
}

@endphp




<div class="d-flex flex-col flex-wrap center content_center pd_1 self_center">
    <button style="width:50%;" type="submit" id="submit" class="btn_submit mt_5 normal self_center lt_1p full_button mb_5">SUBMIT ATTENDANCE</button>
</div>

</form>



</div>
@endsection


