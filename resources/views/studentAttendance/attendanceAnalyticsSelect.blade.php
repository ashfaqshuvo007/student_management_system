<!-- attendanceAnalyticsSelect -->

@extends('layouts.master2')

@section('content')
<script type="text/javascript">
  var sections = <?php echo sizeof($section);?>;
  window.onload = function() {
    if(sections == 0){
      document.getElementById("submit").classList.add("btn-disabled");
      document.getElementById("submit").disabled = true;
      // alert('This section has no students!');
    }
  }
</script>

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

 
<div class="d-flex flex-col center align_center item_center dflex_row_spacearound">
    <div class="ftclr"><h2>Select Section:</h2>
    </div>
      <div class="d-flex flex-col center panel100p item_center xsm-panel90p">
        @if($section)
          <form class="d-flex flex-col panel50 xsm-panel100p" method="POST" action="/studentAttendance/postTable">
            {{ csrf_field() }}
              <label for="sectionID">Select Section : </label>
              <select class="mt_1" id="sectionID" name="sectionID" required>
                  <option value="">
                    Select Class
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
            
              {{-- <label for="" class="mt_1">SELECTION 2</label>
              <select class="mt_1" id="selection2" name="gender">
                  <option value="select1">select </option>
                  <option value="select2">select</option>
              </select>
            
              <label for="" class="mt_1">SELECTION 3</label>
              <select class="mt_1" id="selection3" name="gender">
                  <option value="select1">select </option>
                  <option value="select2">select</option>
              </select> --}}
              <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">
              <button style="width:100%;" type="submit" id="submit" class="btn_submit txt_cntr mt_1 self_center normal">CONFIRM</button>
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


{{-- <div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12 blog-main">
      <h2>Student Attendance Analytics:</h2>
      <hr>
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <form method="POST" action="/studentAttendance/postTable">
            {{ csrf_field() }}
            <div class="form-group">
              <select class="form-control" name="sectionID" id="sectionID">
                @foreach($section as $id)
                  @php
                    $className = ($id->class);
                    if ($id->class==100) {
                      $className='Prechool';
                    }
                  @endphp
                <option value="{{ $id->id }}">[ Class: {{ $className }} ] Section: {{ $id->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group mt-3">
              <button type="submit" id="submit" class="btn btn-twitter mt-2">See Table</button>
            </div>
            @include('layouts.errors')
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
 --}}