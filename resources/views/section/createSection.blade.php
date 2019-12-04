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
      <div class="ftclr"><h2>Create Section:</h2></div>
        <div class="xsm-panel90p panel80p d-flex center">
        
            <form class="d-flex flex-col panel50 xsm-panel100p" method="POST" action="/section">
             {{ csrf_field() }}
                <label for="Title">Section Name : </label>
                <input type="text" class="inpt_tg2 mt_1 back-w" id="exampleInputEmail1" name="sectionName" placeholder="Enter Name Here" required>






                <label class="mt_1" for="Title">Class</label>
              <select class="mt_1" id="class" name="class" required>
                <option value="">Select Class Here</option>
              @php
              $i=100;
              echo"<option value=".$i.">Preschool</option>";
              for($i=1; $i<=10; $i++){
                echo"<option value=".$i.">Class ".$i."</option>";
              }
              @endphp
              </select>

                <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">
                <button style="width:100%;" type="submit" id="submit" class="btn_submit txt_cntr mt_1 self_center normal">CREATE</button>
                </div>
                @include('layouts.errors')
            </form>

        </div>
    </div>












@endsection
