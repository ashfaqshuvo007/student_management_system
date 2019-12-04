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
    <form  class="d-flex flex-col panel100p pd_2" action="/section/update" method="POST">
      {{ csrf_field() }}

      <input type="hidden" name="section_id" value="{{$secInfo->id}}">
      <div class="panel100p d-flex flex-col content_center">
        <div class="mt_1">
          <label class="mt_1" for="name">Name:</label class="mt_1">
          <input type="text" class="inpt_tg mt_1 xsm-panel90pi" id="name" value="{{$secInfo->name}}" name="name" required>
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
