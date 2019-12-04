@extends('layouts.master2')

@section('content')


@if(Session::has('message'))
  <div id="ssbox">
      <div class="d-flex flex-col flex-wrap center txt_cntr">
          <div id="ssbox" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1 color-white">{{ session::get('message')}}</div> 
      </div>
  </div>
  @endif
@if(Session::has('errMessage'))
<div id="errbox">
  <div class="d-flex flex-col flex-wrap center txt_cntr">
      <div class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">
      
      {{ session::get('errMessage')}}
  </div> 
</div>
@endif


<div class="panel d-flex flex-col center align_center item_center dflex_row_spacearound">
    <div class="ftclr"><h2>Set Class Teacher:</h2>
    </div> 
      <div class="panel80p xsm-panel90">
    

        @if($section)
          <form class="d-flex flex-col panel50 panel100p" method="POST" action="/assignTeacher">
            {{ csrf_field() }}
              <label for="sectionID">TEACHER NAME : </label>
              <select class="mt_1" id="teacherID" name="teacherID" >
                  <option value="">
                    Select Teacher
                  </option>
                @foreach ($teacher as $id )
                  <option value="{{ $id->id }}"> {{ $id->firstName }} {{ $id->lastName }}</option>
                @endforeach
              </select>


              <label class="mt_1" for="sectionID">SECTION NAME : </label>
              <select class="mt_1" id="sectionID" name="sectionID" >
                <option value="">
                  Select Section
                </option>
                @foreach($section as $id)
                  @php
                  $className = ($id->class);
                  if ($id->class==100) {
                    $className='Preschool';
                  }
                  @endphp
                  <option value="{{ $id->id }}">[ Class: {{ $className }} ] Section: {{ $id->name }}</option>
                @endforeach
              </select>
              <input type="checkbox" name="class_teacher" value="1"> Class Teacher<br>

              
              <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">
              <button style="width:100%;" type="submit" id="submit" class="btn_submit txt_cntr mt_1 self_center normal">SET TEACHER</button>
                  {{-- <input class="btn_submit txt_cntr mt_1 self_center" type="submit" value="CONFIRM"> --}}
              </div>
              @include('layouts.errors')
          </form>
        @else
            {{ "No section is assigned." }}
        @endif
      </div>
</div>



@endsection
