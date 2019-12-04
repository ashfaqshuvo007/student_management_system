@extends('layouts.master2')

@section('content')
<script type="text/javascript">
function _12to24(time){
  var hr = time.substr(0,2);
  if(time.substr(6,7) == "PM"){
    hr = (parseInt(hr)+12).toString();
  }
  return hr + time.substr(2,3)
}
window.onload = function() {
  document.getElementById("analytics_month").value = new Date().toJSON().slice(0,7);
  document.getElementById("analytics_month").max = new Date().toJSON().slice(0,7);

  $('tbody > tr').each(function() {
    $(this).click(function() {
      $('#date').val($(this).children().eq(0).html());
      $('#login').val(_12to24($(this).children().eq(1).html()));
      $('#logout').val(_12to24($(this).children().eq(2).html()));
    });
  });
};
</script>

  <!-- use $day for displaying current selected month -->
<div class="d-flex flex-col item_center center">

    <div class="d-flex flex-col item_center flex-wrap panel90p xsm-panel100p">

      <!-- Teacher Selector -->
<div class="bg-panel panel90p nobdrad xsm-panel100p">
      
      <div class="pd_1">
      <h2 class="ftclr bold">Teacher Attendance History</h2>
      @if ( !(Auth::guard('teacher')->check()) )
        <form method="POST" action="/teacher/showAllAttendance">
          {{ csrf_field() }}
          <p>Select teacher & month to view history:</p>

          <div class="d-flex flex-col dflex_row_spaceBetween">

            <select class="inpt_tg borderr" name="teacherID" id="teacherID" required>
              <option value="null"> Select Teacher </option>
              @foreach($teacher as $id)
                <option value="{{ $id->id }}">[ ID: {{ $id->id}} ] Name: {{ $id->firstName }} {{ $id->lastName }}</option>
              @endforeach
            </select>

            <input class="inpt_tg2 mt_1 borderr" type="month" name="teacherAttendanceForTheMonth" id="analytics_month" required>

            <div class="d-flex">
              <button hidden name=""></button>
              <button class="btn_submit mt_1 panel100p" type="submit">Show</button>
            </div>


          </div>
            
           
        
        </form>
      @endif
      </div>
</div>
      <!-- Teacher Attendance Table -->


      @if (@isset($teacherID))
          
        @foreach ($teacherName as $id)
<div class="bg-panel panel90p mt_1 nobdrad xsm-panel100p">
      <div class="pd_1">
        <div class="mt_1">
          <label class="mt_1 ftclr" for="teacherID">Showing for <strong>Teacher</strong> : <strong>{{ $id->firstName }}</strong></label> <br>
          <label>CLICK ON THE ROW TO EDIT/UPDATE THAT ROW'S INFORMATIONS</label>
        </div>
        @endforeach
        @if(!@empty($teacherName))
        <table class="table table-hover table-striped mt_1 panel100p">
          <thead class="thead-inverse">
            <tr>
              <th> Date </th>
              <th> Login Time </th>
              <th> Logout Time </th>
            </tr>
          </thead> 
          <tbody  class="table-bordered">
            @foreach ($courseInfo as $id)
            <?php $date = substr($id->login, 0, 10); ?>
              <tr class="hover-pointer">
                <td>{{ date("d-m-Y",strtotime($date))}}</td>
                <td>{{ date('h:i A', strtotime(substr($id->login, 11))) }}</td>
                @if(isset($id->logout))
                <td>{{ date('h:i A', strtotime(substr($id->logout, 11))) }}</td>
                @endif
              </tr>
            @endforeach
        </table>

      </div>        
</div>

        <!-- Update Teacher Attendance -->
<div class="mt_2 mb_1 panel90p nobdrad xsm-panel100p">
        <div class="">
        @if ( !(Auth::guard('teacher')->check()) )
          @isset($teacherID)
          <div class="bg-panel pd_1 nobdrad">
            <form method="POST" action="/teacher/updateAttendance" class="mt_1">
              {{ csrf_field() }}
              <div class="">
                <h3 class="ftclr bold">Update Teacher Attendance</h3>
                @foreach ($teacherName as $id)
                <div class="mt_1">
                  <label for="teacherID" class="ftclr">Updating for <strong>Teacher</strong> : <strong>{{ $id->firstName }}</strong></label>
                </div>  
                @endforeach
                <div class="d-flex flex-wrap dflex_row_spaceBetween mt_1">
                  <label for="" class="mt_1 ftclr">DATE</label>
                  <input id="date" class="inpt_tg2 mt_1 borderr"  type="text" name="date" readonly>
                  <label for="" class="mt_1 ftclr">LOG IN TIME</label>
                  <input id="login" class="inpt_tg2 mt_1 borderr" type="time" name="login">
                  <label for="" class="mt_1 ftclr">LOG OUT TIME</label>
                  <input id="logout" class="inpt_tg2 mt_1 borderr" type="time" name="logout">
                </div>
                <input hidden type="text" name="teacherID" value="{{ $teacherID }}">
              </div>
              <div class="mt_1">
                <button class="btn_submit panel100p" type="submit">Update Attendance</button>
              </div>
            </form>
            </div>
          @endisset
        @endif
        </div>         
</div>
        @endif
              @endif
      @include('layouts.errors')


    </div>
</div>
  @endsection
