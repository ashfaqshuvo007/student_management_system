@extends('layouts.master2')

@section('content')


<div style="height:70vh" class="d-flex flex-col center align_center item_center center" >
        <div class="ftclr"><h2>ENTER CLASS TEST INFORMATION:</h2></div>
          <div>
           @if($teacherSections)
              <form class="d-flex flex-col panel50" method="POST" action="/teacher/viewExams" id="examForm">
               {{ csrf_field() }}
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
              <div>
                  <label for="sectionID">Select Section : </label>
                  <select class="mt_1" name="sectionID" id="sectionID" required>
                  <option value="">
                      Select Section
                  </option>
                          @foreach($teacherSections as $id)

                          @php
                            $sectionInfo = DB::table('sections')->where('id',$id->section_id)->first();
                            $className = ($sectionInfo->class);  
                            if ($sectionInfo->class === 100) {
                              $className='Preschool';
                            }
                            @endphp
                            <option value="{{ $sectionInfo->id }}">[ Class: {{ $className }} ] Section: {{ $sectionInfo->name }}</option>
                          @endforeach
                  </select>
              </div>
              <div class="mt_1" id="SubmitButton">
                    <button id="submit" class="btn_submit panel100p mt_1">Submit</button>
                </div>
                @else
                  {{ "No section is assigned." }}
                @endif

            </form>
            </div>
    
          </div>
    </div>
@endsection