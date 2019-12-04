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


<div class="d-flex dflex_row_space_evenly pd_1">

  <div class="d-flex center panel50p xsm-panel100p pd_1 bg-w margin-1">
    <form  class="d-flex flex-col panel100p pd_2" action="/teacher/updateTeacher" method="POST">
      {{ csrf_field() }}

      <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
      <div class="panel100p d-flex flex-col content_center">
        <div class="mt_1">
          <label class="mt_1" for="firstName">First Name:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 xsm-panel90pi" id="firstName" value="{{$teacher->firstName}}" name="firstName" required>
        </div>

        <div class="mt_1">
          <label class="mt_1" for="lastName">Last Name:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 xsm-panel90pi" id="lastName" value="{{$teacher->lastName}}" name="lastName" required>
        </div>

        {{-- Radio button for Gender --}}
        <div class="mt_1 d-flex">
          <label class="" for="gender">Gender: &nbsp &nbsp</label class="mt_1">
          <div class="">
            <label class="mt_1" class="">
              <input class="" type="radio" name="gender" id="inlineRadio1" value="1" <?php if($teacher->gender === 1) echo "checked";?> required> Male
            </label class="mt_1">
          </div>
          <div class="">
            <label class="mt_1" class="">
              <input class="" type="radio" name="gender" id="inlineRadio2" value="2" <?php if($teacher->gender === 2) echo "checked";?> required > Female
            </label class="mt_1">
          </div>
        </div>

        {{-- <div class="mt_1">
          <label class="mt_1" for="salary">Salary:</label class="mt_1">
          <input type="number" class="inpt_tg mt_1 panel100p" id="salary" value="{{$teacher->salary}}" name="salary" required>
        </div> --}}

        <div class="mt_1">
          <label class="mt_1" for="phoneNumber">Phone Number:</label class="mt_1">
          <input type="number" class="inpt_tg mt_1 xsm-panel90pi" id="phoneNumber" value="{{$teacher->phoneNumber}}" name="phoneNumber" required>
        </div>

        <div class="mt_1">
          <label class="mt_1" for="address">Address:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 xsm-panel90pi" id="address" value="{{$teacher->address}}" name="address" required>
        </div>


        <div class="mt_1">
          <label class="mt_1" for="email">Email:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 xsm-panel90pi" id="email" value="{{$teacher->email}}"  name="email" required>
        </div>

        <div class="mt_1">
            <button type="submit" class="btn_submit xsm-panel90pi panel100p mt_1">Update</button>
        </div>
      </div>

      @include('layouts.errors')

    </form>
  </div>



</div>

@endsection
