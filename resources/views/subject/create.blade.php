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

@if (\Session::has('success'))







<div class="successBox">
<div class="d-flex flex-col flex-wrap center txt_cntr">
<div id="ssbox" style="background: #81C784;
border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1 color-white">{!! \Session::get('success') !!}</div> 
</div>
</div>
@endif









<div class="d-flex flex-col center item_center margin-1 nobdrad xsm-margin-0 xsm-panel100p">
    <div class="bg-w panel40p tb-panel70p xsm-panel100p pd_1 margin-1 nobdrad xsm-margin-0 xsm-pd_0">

      <div class="d-flex center">
        <table id="add_subject_table" class="pd_1 mt_1 panel90p">
          <thead class="thead-inverse">
            <th>Subject Name</th>
            <th>Action</th>
          </thead>
          <tbody  class="table-bordered">
            @foreach ($subjects as $subject )
            <tr>
              <td>
                {{ $subject->name }}
              </td>
            @if($subject->delete)
              <td class="pd_0"> 
                <form action="/deleteSubject" method="POST">
                  {{ csrf_field() }}
                    <button type="submit" class="btn_submit" style="background:transparent!important; border:none;" name="subject_id" value="{{ $subject->id }}">
                      <img class="icnimg" src="/img/delete.png" alt="delete">
                    </button>
                </form>
              </td>
            @else
              <td>
              </td>
            @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
      <div class="d-flex flex-col panel90p pd_1 margin-1 background-grey xsm-margin-0">
            <form class="d-flex flex-col" method="POST" action="/subject">
              {{ csrf_field() }}
              <div class="d-flex panel100p flex-row dflex_row_spaceBetween">
              {{-- input tg --}}
                <div class="d-flex flex-col panel70p">
                  <label class="d-flex flex-col center bold ftclr" for="Title">Add Subject :</label>
                    <input type="text" class="inpt_tg2 mt_1 back-w" id="exampleInputEmail1" name="subjectName" required>
                </div>
              {{-- btn --}}
                <div class="d-flex flex-col dflex_row_end content_end item_end panel30p center">
                  <button type="submit" class="btn_submit panel70p xsm-panel80p mt_1">Submit</button>
                </div>

                  @include('layouts.errors')
              </div>
            </form>
        </div>
      </div>


    </div>

    

</div>















  
</div>
@endsection
