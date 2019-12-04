<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('js/ajax_scripts.js') }}"></script>
    <script type="text/javascript">
      window.onload = function() {
        $('#sectionID').change(function() {
          console.log($(this).val());
          var a = getSectionSubjects($(this).val());
          console.log(a);
        });
      }
    </script>
</head>
@extends('layouts.master2')

@section('content')

@if(Session::has('message'))
  <div class="successBox">
      <div class="d-flex flex-col flex-wrap center txt_cntr">
          <div id="ssbox" style="background: #81C784;
          border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1 color-white">{{ session::get('message')}}</div> 
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

<div class="panel d-flex flex-col center align_center item_center dflex_row_spacearound">
    <div class="ftclr txt_cntr"><h2>Add Subject To Section :</h2>
    </div> 
      <div class="panel80p xsm-panel90p d-flex center">
          <form class="d-flex flex-col panel50 xsm-panel100p" method="POST" action="/assignSubjectToSection">
            {{ csrf_field() }}
              <label for="sectionID"> SECTION NAME : </label>
              <select class="mt_1" id="sectionID" name="sectionID" required>
                  <option value="">
                    Select Section
                  </option>
                    @foreach ($sections as $section )
                    @php
                      $className = ($section->class);
                      if ($section->class=="100") {
                        $className='Preschool';
                      }
                    @endphp
                    @if($section->name != "N/A")
                    <option value="{{ $section->id }}">[ Class: {{ $className }} ] Section: {{ $section->name }}</option>
                    @else
                    <option value="{{ $section->id }}">[ Class: {{ $className }} ]</option>
                    @endif
                    @endforeach
              </select>


              <label class="mt_1" for="subjectID"> SELECT SUBJECT : </label>
              <select class="mt_1" id="subjectID" name="subjectID" required>
                <option value="">
                  Select Subject
                </option>
                @foreach ($subjects as $subject )
                <option value="{{ $subject->id }}">{{$subject->name}}</option>
                @endforeach
              </select>

             
              
              <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">
              <button style="width:100%;" type="submit" id="submit" class="btn_submit txt_cntr mt_1 self_center normal">SET SUBJECT</button>
                  {{-- <input class="btn_submit txt_cntr mt_1 self_center" type="submit" value="CONFIRM"> --}}
              </div>
              @include('layouts.errors')
          </form>
      </div>
</div>




@endsection
