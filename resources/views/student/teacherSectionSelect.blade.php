<!-- takeAttendanceSelect -->

@extends('layouts.master2')

@section('content')
<script type="text/javascript">
  var teacherSections = <?php echo sizeof($teacherSections);?>;
  window.onload = function() {
    if(teacherSections == 0){
      document.getElementById("submit").classList.add("btn-disabled");
      document.getElementById("submit").disabled = true;
    }
  }
</script>

    <div style="height: 50vh;" class="d-flex flex-col center align_center item_center dflex_row_spacearound">
      <div class="ftclr"><h2>Select section:</h2></div>
        <div class="panel80p xsm-panel100p tb-panel80p">
         @if($teacherSections)
            <form class="d-flex flex-col panel50 panel100p" method="POST" action="/teacher/studentList">
            <input name="teacherID" value="{{ $teacherID}}" type="hidden">
             {{ csrf_field() }}
                <label for="sectionID">Select Section : </label>
                <select class="mt_1" id="sectionID" name="sectionID" required>
                <option value="">
                    Select Class
                  </option>
                      @foreach($teacherSections as $section)
                        <?php $sec_info = DB::table('sections')->where('id',$section->section_id)->first();?>
                      @php
                      $className = ($sec_info->class);
                      if ($sec_info->class==100) {
                        $className='Preschool';
                      }
                      @endphp
                      <option value="{{ $section->section_id }}" >[ Class: {{ $className }} ] Section: {{ $sec_info->name }}</option>
                    @endforeach
                </select>
              

                <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">
                <button style="width:100%;" type="submit" id="submit" class="btn_submit txt_cntr mt_1 self_center normal">CONFIRM</button>
                   
                </div>
                @include('layouts.errors')
            </form>
          @else
              {{ "No section is assigned." }}
          @endif
        </div>
    </div>


  
@endsection


