@extends('layouts.master2')

@section('content')







<style>
.moodal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.moodal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  border-radius:15px;
}

/* The Close Button */
.cloose {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.cloose:hover,
.cloose:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>









<script>


var delUrl;

let somefunction = (deleteUrl) => {
  delUrl = deleteUrl;
   // Get the modal
  var modal2 = document.getElementById("myModal2");

  // Get the button that opens the modal
  {{-- var btn2 = document.getElementById("myBtn2"); --}}

  // Get the <span> element that closes the modal
  var span2 = document.getElementsByClassName("cloose")[0];

  // When the user clicks the button, open the modal 
  modal2.style.display = "block";

  // When the user clicks on <span> (x), close the modal
  span2.onclick = function() {
  modal2.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
  if (event.target == modal2) {
  modal2.style.display = "none";
  }
  }
}
 
</script>
<div id="myModal2" class="moodal">

  <!-- Modal content -->
  <div class="moodal-content">
    <span class="cloose">&times;</span>
    <p>Confirm Delete?</p>

{{--  --}}

    <div class="d-flex">

    <div class="d-flex panel50p">    



    <div class="form-group panel100p">
    <script>
    console.log(delUrl);
    </script>
    <button type='button' onclick=window.location.replace(delUrl); class="d-flex justify-content-center w-100 btn_submit panel90p txt_cntr center"><i class="material-icons d-flex align-content-center mr-2">account_box</i>Yes</button>

    {{-- <a href="/dashboard" class="d-flex justify-content-center"><button class="d-flex btn_submit panel30p"><i class="material-icons d-flex align-content-center mr-2">account_box</i>NO</button></a> --}}
    </div>

    @include('layouts.errors')

    </div>

    <button type='submit' class="d-flex justify-content-center w-100 btn_submit panel50p txt_cntr center" onclick="clossesModal2()"><i class="material-icons d-flex align-content-center mr-2">account_box</i>NO</button>











    {{-- onclick="reRouteEnd();" --}}
    {{-- onclick="reRouteStart();"--}}


    </div>










      {{--  --}}
    </div>

</div>








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

<div class="d-flex flex-row flex-wrap center">
    <div class="panel80p d-flex flex-col listTable mb_1 nobdrad xsm-margin-0 xsm-panel100p">
        <div style="overflow-x: auto;" class="panel100p bg-w d-flex flex-col flex-wrap item_center dflex_row_spaceBetween nobdrad xsm-margin-0"> 
            <table class="panel100p">
                <thead>
                    <th>ID</th>
                    <th>SECTION NAME</th>
                    <th>CLASS</th>
                    <th>TOTAL STUDENTS</th>
                    <th>ACTION</th>
                </thead>
                <tbody>
                    @foreach($sections as $sec)
                    @php
                        $Students = DB::table('section_has_students')->where('section_id',$sec->id)->where('year',date('Y'))->pluck('student_id');
                        $numStd = count($Students);
                    @endphp
                    <tr>
                        <td>{{$sec->id}}</td>
                        <td>{{$sec->name}}</td>
                        <td>{{$sec->class}}</td>
                        <td>{{ $numStd }}</td>
                        <td>
                            <a href="{{ URL::to('/section/update/id='.$sec->id)}}"><img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit"></a>&nbsp;
                            <a href="#" onclick= somefunction("{{ URL::to('/section/delete/id='.$sec->id)}}")><img id="deleteModal" class="icnimg" src="/img/delete.png" alt="delete" ></a>    
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>    
</div>
@endsection