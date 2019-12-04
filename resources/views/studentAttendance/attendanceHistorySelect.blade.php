<!-- attendanceHistorySelect -->

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
</script>



<div style="height: 50vh;" class="d-flex flex-col center align_center item_center dflex_row_spacearound">
    <div class="ftclr"><h2>Select Section:</h2>
    </div>
      <div>
        @if($section)
          <form class="d-flex flex-col panel50 xsm-panel90" method="POST" action="/studentAttendance/viewHistory">
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
