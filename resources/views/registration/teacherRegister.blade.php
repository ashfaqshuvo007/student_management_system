@extends('layouts.master2')
<script type="text/javascript">
function invoke_upload(){
  $('#fileTload').click();
}
window.onload = function() {
  $('#fileTload').change(function() {
    console.log($(this).val());
    if($(this).val() != ""){
      $('#fileMsg').text($(this).val().substring(12));
      $('#fileMsg').show();
      $('#fileSubmit').removeClass('btn-disabled');
      $('#fileSubmit').addClass('btn-primary');
      $('#fileSubmit').prop("disabled", false);
    }
    else{
      $('#fileMsg').text("");
      $('#fileMsg').hide();
      $('#fileSubmit').prop("disabled", true);
      $('#fileSubmit').removeClass('btn-primary');
      $('#fileSubmit').addClass('btn-disabled');
    }
  });
}
</script>
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


<div class="d-flex dflex_row_space_evenly pd_1 xsm-flex-col xsm-item-center">

  <div class="d-flex center panel50p pd_1 bg-w margin-1 xsm-panel100p nobdrad xsm-margin-0">
    <form  class="d-flex flex-col panel100p" action="/TeacherRegister" method="POST">
      <div class="panel100p">
        {{ csrf_field() }}
        <div class="mt_1">
          <label class="mt_1" for="firstName">First Name:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 panel100p" id="firstName" name="firstName" required>
        </div>

        <div class="mt_1">
          <label class="mt_1" for="lastName">Last Name:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 panel100p" id="lastName" name="lastName" required>
        </div>

        {{-- Radio button for Gender --}}
        <div class="mt_1 d-flex">
          <label class="" for="gender">Gender: &nbsp &nbsp</label class="mt_1">
          <div class="">
            <label class="mt_1" class="">
              <input class="" type="radio" name="gender" id="inlineRadio1" value="1" required> Male
            </label class="mt_1">
          </div>
          <div class="">
            <label class="mt_1" class="">
              <input class="" type="radio" name="gender" id="inlineRadio2" value="2"> Female
            </label class="mt_1">
          </div>
        </div>

        <div class="mt_1">
          <label class="mt_1" for="salary">Salary:</label class="mt_1">
          <input type="number" class="inpt_tg mt_1 panel100p" id="salary" name="salary" required>
        </div>

        <div class="mt_1">
          <label class="mt_1" for="phoneNumber">Phone Number:</label class="mt_1">
          <input type="number" class="inpt_tg mt_1 panel100p" id="phoneNumber" name="phoneNumber" required>
        </div>

        <div class="mt_1">
          <label class="mt_1" for="address">Address:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 panel100p" id="address" name="address" required>
        </div>


        <div class="mt_1">
          <label class="mt_1" for="email">Email:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 panel100p" id="email" name="email" required>
        </div>

        <div class="mt_1">
          <label class="mt_1" for="password">Password:</label class="mt_1">
          <input type="password" class="inpt_tg mt_1 panel100p" id="password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
        </div>

        <div class="mt_1">
          <label class="mt_1" for="password_confirmation">Password Confirmation:</label class="mt_1">
          <input type="password" class="inpt_tg mt_1 panel100p" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="mt_1">
            <button type="submit" class="btn_submit panel100p mt_1">Create Teacher</button>
        </div>
      </div>

      @include('layouts.errors')

    </form>
  </div>

  <div class="d-flex flex-col panel30p xsm-panel100p">
    <div style="border-radius: 12px; box-shadow: -5px 5px #43A5F3;" class="d-flex flex-col panel50p pd_1 margin-1 bg-w xsm-panel80p">
        {{-- <h3 class="blue_text">Register Multiple</h3> --}}
        <hr>
        <u><a href="/sample_input1">Sample Excel File</a></u>
        <br>

        <form action="/teacherParser" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <p>Upload File:</p>
            <button class="btn_submit panel90p" type="button" name="fileTload" onclick="invoke_upload()">Choose File</button>
            <p id="fileMsg" style="display: none"></p>
            <input class="hidden-input" type="file" name="fileTload" id="fileTload"><br>


            <!-- Change the class below from btn-disabled to btn-primary -->
            <button id="fileSubmit" class="panel90p btn-disabled btn_submit" type="submit" value="Upload" name="submit" disabled="true">Submit</button>
            <input class="hidden-input" type="submit" value="Upload" name="submit">

        </form>
    </div>
  </div>

</div>

@endsection
