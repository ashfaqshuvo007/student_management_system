<!-- takeAttendanceSelect -->

@extends('layouts.master2')

@section('content')
<script type="text/javascript">
  var sections = <?php echo sizeof($section);?>;
  window.onload = function() {
    if(sections == 0){
      document.getElementById("submit").classList.add("btn-disabled");
      document.getElementById("submit").disabled = true;
    }


  }

  function check_3pm(){
    alert("You can retake after 3 pm today!");
  }


</script>



<div class="xsm-d-flex xsm-flex-col xsm-item-center">
  <div class="ftclr d-flex center xsm-start"><h2>Select Class:</h2></div>
  <form id="form-id" class="d-flex flex-row" method="POST" action="/studentAttendance/store">
    {{ csrf_field() }}
  <div class="d-flex dflex_row_space_evenly flex-wrap xsm-flex-col panel100p">

{{-- WRITE FOR LOOP HERE --}}
@if($section)

    @if(session()->has('message'))
    <div class="successBox">
        <div class="d-flex flex-col flex-wrap center txt_cntr">
            <div id="ssbox" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1"><h5> {!! session()->get('message') !!}</h5></div> 
        </div>
    </div>
    @endif
    @if(session()->has('errMessage'))
        <div class="errorBox">
            <div class="d-flex flex-col flex-wrap center txt_cntr">
                <div id="errbox" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1"><h5>{!! session()->get('errMessage') !!}</h5></div> 
            </div>
        </div>
    @endif

    @foreach($section as $id)
    <?php 
      if(Auth::guard('teacher')->check()){ 
        $date = date("Y-m-d");
        $sec_info = DB::table('sections')->where('id',$id->section_id)->first();
        $numStudents = DB::table('section_has_students')->where('section_id',$id->section_id)->pluck('student_id');
        $att_taken = DB::table('student_attendances')->whereIn('student_id',$numStudents)->whereDate('created_at',$date)->first();

        $retake_time = strtotime("15:00:00");
        // dd(time());
        $count = count($numStudents);

      }else{
        $sec_info = DB::table('sections')->where('id',$id->id)->first();
        $numStudents = DB::table('section_has_students')->where('section_id',$id->id)->pluck('student_id');
        $count = count($numStudents);

      }  

      $className = ($sec_info->class);
      if ($sec_info->class==100) {
        $className='Preschool';
      }


    ?>
  <?php  if(!isset($att_taken) && ( time() < $retake_time)){?>  
  <a href="/studentAttendance/getStudents/s=<?php if(Auth::guard('teacher')->check()){echo $id->section_id; }else{echo $id->id;}?>">
  <?php }?>  
    <div class="section_card" id="card" >
        <div class="d-flex flex-row panel25 tb-panel40 xsm-panel90 mt_1">
            <div class="d-flex flex-col flex-wrap panel100p borders_section pd_0 tb-pd_1" <?php if(isset($att_taken) && ( time() < $retake_time) ){ echo "style='background: #ddd; box-shadow: 0px 5px #000;' onclick='check_3pm();'";}?>>
                <div class="d-flex flex-row mt_1">
                    <div class="pl_1 tb-pl_0 xsm-pl_1 tb-pl_0 tb-pl_1 tb-pl_0">
                        <h4 class="normal ftclr">CLASS: <b>{{ $className }}</b></h4>
                    </div>
                </div>
                <div class="d-flex flex-col flex-wrap mt_2">
                    <div class="d-flex flex-row present_icon content_end">
                        <div class="panel50p d-flex flex-col content_end dflex_row_end pl_1 tb-pl_0">
                            <h5 class="normal mb_1 ftclr">Section: <b>{{ $sec_info->name }}</b></h5>
                        </div>
                        <div class="d-flex flex-col flex-wrap content_end dflex_row_end panel50p">
                            <ul id="attendance_list" class="d-flex flex-row flex-wrap lstyle self_end mt_0 pr_1 dflex_row_end">
                                
                                <li class="normal ftclr">No. of Students: <b>{{ $count }}</b></li>
                                
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
  </a>
    @endforeach
{{-- endloop --}}

@endif
  </div>
</form>
</div>

@endsection


