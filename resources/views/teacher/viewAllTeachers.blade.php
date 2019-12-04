<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
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
.modal {
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
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}
</style>

<script>

function clossesModal2(){
  document.getElementById("myModal2").style.display="none";
}

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






<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Modal Header</h2>
    </div>
    <div class="modal-body">
      <p>Some text in the Modal Body</p>
      <p>Some other text...</p>
    </div>
    <div class="modal-footer">
      <h3>Modal Footer</h3>
    </div>
  </div>

</div>



<!-- *************************** Teacher List Table *************************** -->

@if(session()->has('message'))
<div class="successBox">
<div class="d-flex flex-col flex-wrap">
<div style="background: #81C784;
color: white;
border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">{!! session()->get('message') !!}
</div> 
</div>
</div>
@endif

@if(session()->has('errMessage'))
<div class="errorBox">
<div class="d-flex flex-col flex-wrap">
<div style="background: #FF6564;
color: white;
border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">{!! session()->get('errMessage') !!}
</div> 
</div>
</div>

@endif
<div class="d-flex flex-row flex-wrap center mt_1">
        <!-- list -->
        <div class="panel100p d-flex center">
        <div class="panel70 d-flex flex-col listTable bg-w xsm-panel100p nobdrad xsm-margin-0">

            <div style="overflow-x: auto;" class="panel100p d-flex flex-col flex-wrap item_center dflex_row_spaceBetween bg-w nobdrad"> 
                <table id="teacherList" class="panel100p bg-w nobdrad">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>GENDER</th>
                        <th>CONTACT</th>
                        <th>EMAIL</th> 
                        <th>ACTION</th>
                        {{-- <th>BIRTHDAY</th>
                        <th>CONTACT</th>
                        <th>ADDRESS</th>

                        <th>ACTION</th> --}}
                      </tr>
                    </thead>
                      <tbody  id="teacherList">
                        @foreach($teachers as $t)
                        <tr>
                          <td>{{$t->id}}</td>
                          <td>{{$t->firstName}} {{$t->lastName}} </td>
                          @php
                           if($t->gender === 1){
                             $gender = 'Male';
                           }else{
                             $gender = 'Female';
                           }   
                          @endphp
                          <td>{{$gender}}</td>
                          <td>{{$t->phoneNumber}}</td>
                          <td>{{$t->email }}</td>

                          <td>
                              <ul class="panel100p d-flex flex-row center dflex_row_space_evenly pd_0 lstyle">
                                  <li><a href="{{ URL::to('/teacher/update/t_id='.$t->id)}}"><img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit"></a></li>
                                 
                                  {{-- <li><a href="{{ URL::to('/teacher/profile/t_id='.$t->id)}}"><img id="viewProfileBtn" class="icnimg" src="/img/user2.png" alt="user2"></li> --}}
                                
                                  {{-- <li><a href="{{ URL::to('/assignStudent/id='.$t->id)}}"><img id="viewProfileBtn" class="icnimg" src="/img/user.png" alt="user"></a></li> --}}
                                    
                                  {{-- <li><img id="viewProfileBtn" class="icnimg" src="/img/user2.png" alt="user2"></li> --}}
                                  <li><a href="#" onclick=somefunction("{{ URL::to('/teacher/delete/t_id='.$t->id)}}")><img id="deleteModal" class="icnimg" src="/img/delete.png" alt="delete" ></a></li>
        
                                  
                              </ul>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>

                </table>
        </div>    
        
        <div>
                <div class="d-flex flex-row center content_center">
                
                  <div style="background:white;" id="paginationn" class="d-flex justify-content-center align-items-center flex-wrap">
                    {{$teachers->links()}}
                  </div>
                    
                </div>
        </div>
        
        </div>
        </div>


        {{-- <!-- right side panel -->
        <div class="panel20 d-flex flex-col item_center flex-wrap tb-panel30p">
            <div style="height:70%;" class="bg-w panel50p pt_1 pd_2 d-flex flex-col dflex_row_space_evenly item_center">
                <div class="d-flex flex-row flex-wrap center txt_cntr">
                    <div><h5 class="bold ftclr lt_2p tb-lt0">SCHOOL<br>OVERVIEW</h5></div>
                </div>

                <div style="border-bottom: 1px solid #DFDFDF;" class="d-flex flex-row flex-wrap center txt_cntr mt_1 panel80p">
                    <div class="panel100p"><img class="stiw" src="/img/stlist_i1.png" alt="stlist_i1"></div>
                    <div class="panel100p d-flex flex-col mt_0 mb_0">
                        <h3 class="mt_0 mb_0 ftclr bold">{{ $student->total() }}</h3>
                        <h5 class="normal mt_0 smh5 ftclr lt_1p pb_1">Total Students</h5>
                    </div>
                </div>

                <div style="border-bottom: 1px solid #DFDFDF;" class="d-flex flex-row flex-wrap center txt_cntr panel80p">
                    <div class="panel100p pt_2"><img class="stiw" src="/img/stlist_i2.png" alt="stlist_i2"></div>
                    <div class="panel100p d-flex flex-col mt_0 mb_0">
                        <h3 class="mt_0 mb_0 ftclr bold">{{ $totalNumSections}}</h3>
                        <h5 class="normal mt_0 smh5 ftclr lt_1p pb_1">Total Sections</h5>
                    </div>
                </div>

                <div style="border-bottom: 1px solid #DFDFDF; border-width: 90%;" class="d-flex flex-row flex-wrap center txt_cntr panel80p">
                    <div class="panel100p pt_2"><img class="stiw" src="/img/stlist_i3.png" alt="stlist_i3"></div>
                    <div class="panel100p d-flex flex-col mt_0 mb_0">
                        <h3 class="mt_0 mb_0 ftclr bold">13</h3>
                        <h5 class="normal mt_0 smh5 ftclr lt_1p pb_2">Total Grades/Classes</h5>
                    </div>
                </div>
                
            </div>
        </div> --}}
   
</div>

@endsection
