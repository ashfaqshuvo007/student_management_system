@extends('layouts.master4')

@section('content')
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<script defer type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
<script type="text/javascript">

//Deadline for taking attendance in Hours (24)
deadline = 23;
op = -1;
var timer;
var startDisabled = false;
var endDisabled = false;


window.onload = function() {
  if(new Date().getHours() >= deadline){
    document.getElementById("attendance_button").classList.add("btn-disabled");
  }
  if(startDisabled){
    document.getElementById("start_button").classList.add("btn-disabled");
    document.getElementById("start_button").classList.remove("mcard");
  }
  if(endDisabled){
    document.getElementById("end_button").classList.add("btn-disabled");
    document.getElementById("end_button").classList.remove("mcard");
  }
  else {
    document.getElementById("end_button").classList.remove("btn-disabled");
  } 

};

function fadeOut(){
  $('#msg').css('opacity', op);
  op -= 0.1;
  if(op < -0.1){
    op = -1;
    clearInterval(timer);
  }
}

function reRouteStart(){
  if(startDisabled){
    return false;
  }
  else{
    window.location.href = "/teacherAttendanceStartPage";
  }
}


function reRouteEnd(){ 
  if(endDisabled){
    return false;
  }
  else{
    window.location.href = "/teacherAttendanceEndPage";
  }
}


function check_3pm(){
  if(new Date().getHours() >= deadline){
    if(op < 0){
      $('#msg').show();
      op = 2;
      timer = setInterval(function(){ fadeOut(op) }, 100);
    }
    return false
  }
  else{
    window.location.href = "/studentAttendance";
  }
}




function clossesModal(){
  document.getElementById("myModal").style.display="none";
}



function clossesModal2(){
  document.getElementById("myModal2").style.display="none";
}

</script>



<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  border-radius:15px;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}












.moodal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.moodal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  border-radius:15px;
}

/* The Close Button */
.cloose {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.cloose:hover,
.cloose:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}





















</style>



@if ( (Auth::guard('teacher')->check()) )
    <p class="text-muted ml-1">
      <tbody  class="table-bordered">
        @php
        //dd($results);
        //dd($logout);
        if(!(empty($results))){
          echo "<script type=\"text/javascript\">startDisabled = true;</script>";
        }
        else{
          echo "<script type=\"text/javascript\">startDisabled = false;</script>";
        }
        @endphp
       
        @if(!empty($results))
          {{-- Login Time : --}}
          <tr>
            {{-- <td>{{ $results->login ? date('h:i:s a m/d/Y', strtotime($results->login)) : '' }}</td> --}}
          </tr>
        @endif 
      </tbody>
    </p>

    <p class="text-muted ml-1">
      <tbody  class="table-bordered"> 
        @php
        if(!empty($logout)){
          echo "<script type=\"text/javascript\">endDisabled = true;</script>";
        }else{
          echo "<script type=\"text/javascript\">endDisabled = false;</script>";
        }
        @endphp
         @if(!empty($logout))
        {{-- Logout Time : --}}
          <tr>
            {{-- <td>{{ $logout->logout ? date('h:i:s a m/d/Y', strtotime($logout->logout)) : '' }}</td> --}}
          </tr> 
          @endif
      </tbody>
    </p>
  @endif









<!-- MY CODES DOWN -->
@if(session()->has('message'))
<div class="successBox">
  <div class="d-flex flex-col flex-wrap center txt_cntr">
    <div style="background: #81C784;color: white;border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">{!! session()->get('message') !!}
    </div> 
  </div>
</div>
@endif


<div id="dashboard" class="panel d-flex flex-col flex-wrap">
        <div class="panel d-flex flex-row flex-wrap dflex_row_spacearound pt_5 xsm-flex-col">

          {{-- LEFT SIDE  --}}

            <div class="halves d-flex flex-col flex-wrap xsm-panel100 content_center item_center">
                        
                        <div class="xsm-panel80p tb-panel80p panel50p">
                                        <div class="cards d-flex flex-col flex-wrap center self_start white mt_0 pd_1 xsm-self-center">
                                            
                                            
                                            {{-- ADMIN NAME AND ROLE --}}
                                            <div class="label_login white d-flex flex-col flex-wrap">
                                                <h4 class="normal white smalltext">LOGGED IN AS</h4>
                                            </div>
                                            <div class=" d-flex flex-row flex-wrap">
                                            

                                                @if(Auth::check())
                                                <h2 class="mt_0 mb_0 newf">{{Auth::user()->firstName}}</h2>    
                                                
                                                @endif
                                                @if ( (Auth::guard('teacher')->check()) )
                                                <h2 class="mt_0 mb_0 newf">{{Auth::guard('teacher')->user()->firstName}}</h2>
                                                @endif
                                            </div>
                                                @if(Auth::check())
                                                <h4 class="normal white smalltext">Role: Admin</h4>
                                                @endif
                                                @if ( (Auth::guard('teacher')->check()) )
                                                <h4 class="normal white smalltext">Role: Teacher</h4>
                                                <h4 class="normal white smalltext">Assigned To : {{ $numSection }} Sections</h4>
                                                @endif



                                        </div>
                        </div>


                  <div class="xsm-panel80p tb-panel80p panel50p">
                        @if(Auth::check())
{{-- Total Student Attendance TAKEN --}}
                        <div class="mt_1">
                            <div class="cards new-card d-flex flex-row flex-wrap self_start xscol tb-100p mt_1 pd_1 white">
                                <div class="d-flex flex-row flex-wrap nocenter panel100p">
                                    <h4 class="bold">{{$totalAttendances}}</h4>&nbsp;<h5>/ {{$totalStudents}}</h5>
                                </div>
                                <div class="d-flex flex-row flex-wrap center nocenter xsm-pl0 onlypad">
                                    <h5 class="normal smalltext d-flex flex-col center">TOTAL STUDENT ATTENDANCE TAKEN</h5>
                                </div>
                            </div>

{{-- Total Student PRESENT--}}

                            <div class="mt_1 cards new-card d-flex flex-row flex-wrap self_start xscol tb-100p pd_1 white">
                                <div class="d-flex flex-row flex-wrap nocenter panel100p">
                                    <h4 class="mt_0 mb_0 bold">{{$teachersPresent }}</h4>&nbsp;<h5>/ {{$numTeacher}}</h5>
                                </div>
                                <div class="d-flex flex-row flex-wrap nocenter tb-100p xsm-pl0 onlypad">
                                    <h5 class="mt_0 mb_0 normal smalltext d-flex flex-col center">TEACHERS PRESENT TODAY</h5>
                                </div>
                            </div>
                            {{-- Teacher Attendance --}}
                            <div class="mt_1 cards new-card d-flex flex-row flex-wrap self_start xscol tb-100p pd_1 white">
                                <div class="d-flex flex-row flex-wrap nocenter panel100p">
                                    <h4 class="mt_0 mb_0 bold">{{$stdPresent }}</h4>&nbsp;<h5>/ {{$totalAttendances}}</h5>
                                </div>
                                <div class="d-flex flex-row flex-wrap nocenter tb-100p xsm-pl0 onlypad">
                                    <h5 class="mt_0 mb_0 normal smalltext d-flex flex-col center">STUDENTS PRESENT TODAY</h5>
                                </div>
                            </div>

{{-- PERCENTILE PRESENT --}}

                            @if($percentile != null)
                            <div class="mt_1 cards new-card d-flex flex-row flex-wrap self_start xscol tb-100p pd_1 white">

                             
                                  <canvas id="countries" width="200" ></canvas>
                            <div class="canvasDiv">
                                <div class="d-flex flex-row flex-wrap nocenter panel100p ">
                                    <h4 class="bold">{{$percentile}}</h4>&nbsp;<h5>%</h5>
                                </div>
                                <div class="d-flex flex-row flex-wrap nocenter xsm-pl0 onlypad">
                                    <h5 class="normal smalltext d-flex flex-col center">PERCENTILE PRESENT</h5>
                                </div>
                            </div>

                            </div>
                            @else
                            <div class="mt_1 cards new-card d-flex flex-row flex-wrap self_start xscol tb-100p pd_1 white">
                                <div class="d-flex flex-row flex-wrap center nocenter xsm-pl0 onlypad">
                                    <h5 class="normal smalltext d-flex flex-col center">ATTENDANCE NOT TAKEN YET</h5>
                                </div>
                            </div>
                            @endif


                          
{{-- Inventory --}}

                           

                        </div>
                        

                        @elseif(Auth::guard('teacher')->check())
                        <div class="mt_1">
                          <div style="overflow-x:auto;" class="cards new-card mt_1 pd_1 white d-flex flex-row flex-wrap self_startscol tb-100p dflex_row_space_evenly tb-panel70p">
                            
                              <table class="panel100p">
                                  <thead class="thead-inverse">
                                    <tr>
                                      <th>Section</th>
                                      <th>Class</th>
                                      <th>Attendance Ratio</th>
                                    </tr>
                                  </thead>
                                  <tbody  class="table-bordered">
                                    @foreach($teacherSecInfo as $d)
                                   
                                    @php 
                                      $attendance = DB::table('attendance_taken')->where('section_id',$d->id)->whereDay('date_taken',date("d"))->first();
                                        // dd($attendance);
                                    @endphp
                                    <tr>
                                      <td>{{ $d->name}}</td>
                                      <td>{{ $d->class}}</td>
                                      <td>
                                      <?php if(isset($attendance)){?>

                                        {{ $attendance->students_present}} / {{ $attendance->students_total}}
                                      <?php }else{?>
                                        Attendance Not Taken
                                      <?php }?>
                                    </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                          </div>
                         
                        
                        </div>
                        @endif
                </div>
               
          </div>
            

          {{-- RIGHT SIDE  --}}
            <div class="d-flex flex-row flex-wrap dflex_row_end xsm-center xsm-panel100p">
                <div id="quickLinks" class="halves d-flex flex-col flex-wrap xsm-panel80p content_space_evenly">
                    <ul id="dashboard-list" class="lstyle center d-flex flex-col flex-wrap dflex_row_space-evenly tbaligncenter tb-pd_0 pd_0 xsm-panel100p ">
                        <li>
                            @if ( (Auth::guard('teacher')->check()) )
                            <a href="javascript:void(0)" id="myBtn">
                            <div id="start_button" 
                                class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">

                                <div class="svg self_center">        
                                    <i class="material-icons material-icons d-flex align-content-center">access_time</i>
                                </div>
                                <div class="d-flex flex-row flex-wrap w70p">
                                    <h5 class="user_slc">START MY DAY</h5>
                                </div>

                            </div>
                            </a>
                            @endif
                        </li>

                        <li>
                            <a href="/studentAttendance" onclick="check_3pm();" id="attendance_button">
                            <div
                                class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">
                                <div class="svg self_center">

                                        <i class="material-icons d-flex align-content-center mr-2">group_add</i>
                                </div>
                                <div class="d-flex flex-row flex-wrap w70p">
                                    <h5 class="user_slc">TAKE ATTENDANCE</h5>
                                </div>
                            </div>
                            </a>
                        </li>

                        {{-- SECTIONS WITHOUT ATTENDANCE --}}
                        @if ( (Auth::check()) )

                        <li>
                            <div class="cards pd_1 mt_1 new-card d-flex flex-row flex-wrap self_start xsm-flex-col tb-flex-col white panel70p tb-panel80pi panel80pi" style="overflow-y: auto;">
                              <div class="d-flex flex-row flex-wrap">
                              <h5 class="mb_1" style="text-transform: uppercase;">Sections with no attendance Yet</h5>
                              </div>  
                              
                              <div style="height:20vh;" class="panel100p">
                                <table class="panel100p mb_1">
                                    <thead class="thead-inverse">
                                      <tr>
                                        <th>Section</th>
                                        <th>Class</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody  class="table-bordered">
                                      @foreach($sections as $d)
                                      @php 
                                        $secAttendance = DB::table('sections')->where('id',$d->section_id)->first();
                                        // dd($d);
                                      @endphp
                                      <tr>
                                      <td><?php if(isset($d)){?>{{ $d->name}}<?php }?></td>
                                        <td><?php if(isset($d)){?>{{ $d->class}}<?php }?></td>
                                        {{-- <td>{{ $d->students_present}} / {{ $d->students_total}}</td> --}}
                                        <td><a href="{{ URL::to('/studentAttendance/getStudents/s='.$d->id)}}" class="blue_text">Take Attendance</a></td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                              </div>  
                            </div>
                        </li>
                        @endif
                        {{-- LATE TEAHCERS --}}
                        @if ( (Auth::check()) )

                        <li>
                            <div class="cards mt_1 new-card d-flex flex-col self_start xsm-flex-col tb-100p white panel70p xsm-panel100pi tb-pd_1 tb-panel80pi panel80pi" style="height: 20vh;
                            overflow-y: auto;">
                                <div class="d-flex flex-row">
                                 <h5  style="text-transform: uppercase;" class="xsm-mt_1 mt_1">Teacher Status</h5>
                                </div>
                                <table class="mb_1">
                                    <thead class="thead-inverse">
                                      <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>PHONE</th>
                                        <th>EMAIL</th>
                                        <th>Login</th>
                                      </tr>
                                    </thead>
                                    <tbody  class="table-bordered">
                                        {{-- @php
                                            dd($lateComer);
                                        @endphp --}}

                                      @foreach($lateComer as $d)
                                      <tr>
                                      <td>{{ $d['id']}}</td>
                                        <td>{{ $d['name']}}</td>
                                        <td>{{ $d['phoneNumber']}}</td>
                                        <td>{{ $d['email']}}</td>
                                      <td>{{ date('H:i:s',strtotime($d['login']))}} &nbsp; <?php if(isset($d['is_late']) && $d['is_late'] === 1){?><span style="background:red;border-radius:5px;color:#fff;padding:5px;">late<span><?php }?></td>
                                      </tr>
                                      @endforeach
                                      
                                    </tbody>
                                </table>
                                 
                            </div>
                        </li>
                        @endif
                      @if ( (Auth::guard('teacher')->check()) )

                        <li>
                          <a href="/studentAttendance/getTable" >
                          <div
                              class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">
                              <div class="svg self_center">
                                <i class="material-icons">
                                  assessment
                                  </i>
                              </div>
                              <div class="d-flex flex-row flex-wrap w70p">
                                  <h5 class="user_slc">ATTENDANCE ANALYTICS</h5>
                              </div>
                          </div>
                          </a>
                       </li>
                       
                       <li>
                        <a href="/studentAttendance/show" >
                        <div
                            class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">
                            <div class="svg self_center">
                              <i class="material-icons">
                                history
                                </i>
                            </div>
                            <div class="d-flex flex-row flex-wrap w70p">
                                <h5 class="user_slc">ATTENDANCE HISTORY</h5>
                            </div>
                        </div>
                        </a>
                     </li>

                        <li>
                            <a href="/quiz/create">
                            <div
                                class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">
                                <div class="svg self_center">

                                        <i class="material-icons d-flex align-content-center mr-2">
                                                ballot
                                        </i>

                                </div>
                                <div class="d-flex flex-row flex-wrap w70p">
                                    <h5 class="user_slc">CREATE CLASS TEST</h5>
                                </div>
                            </div>
                            </a>
                        </li>

                        <li>
                            <a href="/exams/listExams" >
                            <div
                                class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">
                                <div class="svg self_center">

                                    <svg viewBox="0 0 661.543 661.544">
                                        <g>
                                            <g>
                                                 <path d="M628.351,389.866l-49.869-49.868c-6.797-6.798-14.244-10.038-22.989-10.038c-7.447,0-14.196,2.963-20.075,8.746
                        l-39.824,39.182L336.599,536.876c-2.915,3.564-4.407,6.507-4.856,8.096l-26.555,94.225c-0.552,1.969-0.967,3.883-0.967,5.831
                        c0,8.096,7.771,16.517,17.809,16.517c2.266,0,3.896-0.276,5.181-0.649l93.583-27.203c3.171-0.919,5.823-1.948,7.771-3.883
                        l159.962-159.637l39.175-39.183c5.181-5.181,8.097-11.66,9.07-19.425C636.772,402.819,633.857,395.372,628.351,389.866z
                         M406.867,601.313l-58.932,16.517l17.159-58.932l143.127-143.127l42.415,41.772L406.867,601.313z M575.892,432.281l-42.415-41.772
                        l22.665-22.665l41.772,41.772L575.892,432.281z" />
                                                <path d="M383.552,311.502H105.078c-10.038,0-17.809,7.771-17.809,17.809s7.771,18.133,17.809,18.133h278.475
                        c10.037,0,17.809-8.096,17.809-18.133S393.589,311.502,383.552,311.502z" />
                                                <path d="M401.361,409.616c0-10.037-7.771-17.809-17.809-17.809H105.078c-10.038,0-17.809,7.771-17.809,17.809
                        s7.771,18.134,17.809,18.134h278.475C393.589,427.75,401.361,419.653,401.361,409.616z" />
                                                <path d="M234.278,471.464h-129.2c-10.038,0-17.809,7.771-17.809,17.809s7.771,17.809,17.809,17.809h129.2
                        c10.037,0,18.133-7.771,18.133-17.809S244.315,471.464,234.278,471.464z" />
                                                <path d="M234.278,551.77h-129.2c-10.038,0-17.809,7.771-17.809,17.809s7.771,17.809,17.809,17.809h129.2
                        c10.037,0,18.133-7.771,18.133-17.809S244.315,551.77,234.278,551.77z" />
                                                <path d="M60.714,622.68V38.857c0-2.266,0.974-3.24,3.24-3.24h132.765v192.346c0,22.022,16.835,39.832,38.851,39.832h192.346v108.8
                        h35.942v-108.8v-35.942h-0.649L232.336,0.649L231.687,0h-34.968h53.954C52.943,0,43.555,3.882,36.108,11.336
                        c-7.454,7.447-11.336,16.835-11.336,27.521V622.68c0,22.022,17.16,38.857,39.182,38.857h211.447V625.92h53.954
                        C61.688,625.92,60.714,624.952,60.714,622.68z M232.336,51.485l180.361,180.361H235.569c-2.266,0-3.233-1.299-3.233-3.882V51.485
                        L232.336,51.485z" />
                                            </g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                    </svg>

                                </div>
                                <div class="d-flex flex-row flex-wrap w70p">
                                    <h5 class="user_slc">EDIT EXAMS/CLASS TESTS</h5>
                                </div>
                            </div>
                            </a>
                        </li>

                        <li>
                            <a href="/exams/select" >
                            <div
                                class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">
                                <div class="svg self_center"><i class="material-icons d-flex align-content-center mr-2">exit_to_app</i></div>
                                <div class="d-flex flex-row flex-wrap w70p">
                                    <h5 class="user_slc">SUBMIT MARKS</h5>
                                </div>
                            </div>
                            </a>
                        </li>


                        <li>
                          <a href="{{ URL::to('/teacher/sectionSelect')}}">
                          <div
                              class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">
                              <div class="svg self_center">

                                <i class="material-icons">list</i>

                              </div>
                              <div class="d-flex flex-row flex-wrap w70p">
                                  <h5 class="user_slc">STUDENT LIST</h5>
                              </div>
                          </div>
                          </a>
                      </li>

                      {{-- <li>
                          <a href="{{ URL::to('/teacher/examsList')}}">
                          <div
                              class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 ">
                              <div class="svg self_center">

                                <i class="material-icons">list</i>

                              </div>
                              <div class="d-flex flex-row flex-wrap w70p">
                                  <h5 class="user_slc">Exams LIST</h5>
                              </div>
                          </div>
                          </a>
                      </li> --}}

                      
                      <li>
                        <a href="javascript:void(0)" id="myBtn2" >
                        
                                
                            

                        <div id="end_button" 
                            class="mcard d-flex flex-row flex-wrap w80p txt_cntr bg-w curve_edges blk dflex_row_spacearound pd_1 xsm-mt_1 mt_1">
                            <div class="svg self_center">

                                    <i class="material-icons">hourglass_empty</i>

                            </div>
                            <div class="d-flex flex-row flex-wrap w70p">
                                <h5 class="user_slc">END DAY</h5>
                            </div>
                        </div>
                    

                        </a>
                    </li>
                      @endif
                    </ul>
                </div>
            </div>
            <p id="msg" style="opacity:0">Attendance disabled <br /> at this time!</p>












{{-- END DAY MODAL --}}

<div id="myModal2" class="moodal">

  <!-- Modal content -->
  <div class="moodal-content">
    <span class="cloose">&times;</span>
    <p>Confirm End Time?</p>

{{--  --}}

    <div class="d-flex dflex_row_space_evenly">
    <button type='submit' class="d-flex justify-content-center w-100 btn_submit panel40p txt_cntr center item_center" onclick="clossesModal2()"><i class="material-icons d-flex align-content-center mr-2">clear</i>NO</button>
  
    <div class="d-flex panel40p">    
    <form class="panel100p" action="/teacherAttendanceStart/logout" method="POST">
    {{ csrf_field() }}



    <div class="form-group panel100p">
    <button type='submit' class="d-flex justify-content-center w-100 btn_submit panel90p txt_cntr center item_center"><i class="material-icons d-flex align-content-center mr-2">done</i>Yes</button>

    {{-- <a href="/dashboard" class="d-flex justify-content-center"><button class="d-flex btn_submit panel30p"><i class="material-icons d-flex align-content-center mr-2">account_box</i>NO</button></a> --}}
    </div>

    @include('layouts.errors')

    </div>
    </form>

    










    {{-- onclick="reRouteEnd();" --}}
    {{-- onclick="reRouteStart();"--}}


    </div>










      {{--  --}}
    </div>

</div>













{{-- ATTENDANCE FOR TEACHER MODAL --}}

<div id="myModal" class="modal bg-w">

  <!-- Modal content -->
  <div class="modal-content">
  <span class="close">&times;</span>
  <p>Give Your Attendance for the Day!</p>
  <p class="text-center">Confirm Attendance?</p>


  <div class="d-flex dflex_row_space_evenly">
  <button type='submit' class="d-flex justify-content-center w-100 btn_submit panel40p txt_cntr center item_center" onclick="clossesModal()"><i class="material-icons d-flex align-content-center mr-2">clear</i>NO</button>

  <div class="d-flex panel40p">    
  <form class="panel100p" action="/teacherAttendanceStart" method="POST">
  {{ csrf_field() }}



  <div class="form-group panel100p">
  <button type='submit' class="d-flex justify-content-center w-100 btn_submit panel90p txt_cntr center item_center"><i class="material-icons d-flex align-content-center mr-2">done</i>Yes</button>

  {{-- <a href="/dashboard" class="d-flex justify-content-center"><button class="d-flex btn_submit panel30p"><i class="material-icons d-flex align-content-center mr-2">account_box</i>NO</button></a> --}}
  </div>

  @include('layouts.errors')

  </div>
  </form>












  {{-- onclick="reRouteEnd();" --}}
  {{-- onclick="reRouteStart();"--}}


  </div>



          </div>
</div>























<?php if(Auth::check()) {?>
<script>


 var phpunit = '{{$percentile}}';
 console.log('{{$percentile}}');

  // pie chart data
 
            var pieData = [
                {
                    value: '{{$percentile}}',
                    color:"#03A9F4",
                    legend: 'PRESENT percentile'
                   
                },
                {
                    value : 100 - '{{$percentile}}',
                    color : "#F8F2F0",
                    legend: 'ABESENT percentile'
                  
                },
               
               
            ];
              
           
               
            // pie chart options
            var pieOptions = {
                 segmentShowStroke : false,
                 animateScale : true
            };
            // get pie chart canvas
            var countries= document.getElementById("countries").getContext("2d");
            {{-- console.log(document.getElementById("countries")); --}}

            // draw pie chart
             {{-- new Chart(countries , {
            type: 'pie',
            data: pieData,pieOptions 
        }); --}}
            new Chart(countries).Pie(pieData, pieOptions);

</script>
<?php } ?>
{{-- start day modal --}}
<script>
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks the button, open the modal 
  btn.onclick = function() {
  modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
  modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
  if (event.target == modal) {
  modal.style.display = "none";
  }
  }
</script>

{{-- end day modal --}}

<script>
  // Get the modal
  var modal2 = document.getElementById("myModal2");

  // Get the button that opens the modal
  var btn2 = document.getElementById("myBtn2");

  // Get the <span> element that closes the modal
  var span2 = document.getElementsByClassName("cloose")[0];

  // When the user clicks the button, open the modal 
  btn2.onclick = function() {
  modal2.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span2.onclick = function() {
  modal2.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
  if (event.target == modal2) {
  modal2.style.display = "none";
  }
  }
</script>





@endsection

