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
</style>
 
<script type="text/javascript">



  // var rowID = -1;
  // var students = <?php echo json_encode($student);?>;
  // var edit = false;
  // students = students.data;
  // var classInfo = <?php echo json_encode($courseInfo);?>;  

  //Flag to detect server response complete
  var connectionActive = false;
  window.onload = function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });



  $(document).ready(function(){
  // fetch_student_data();
 
  function fetch_student_data(query = '')
  {
      $.ajax({
        url:'/getStudent',
        method:'POST', 
        data:{query:query},
        dataType:'json',
        success:function(data)
        {
        $('tbody').html(data.table_data);
        $('#total_records').text(data.total_data);
        }
      })
  }
 
  $(document).on('keyup', '#nameSearch', function(){
    
    if(($(this).val().length) === 0){
      console.log("i am good")
      location.reload();
    }else if(($(this).val().length) >= 3){
      console.log($(this).val());
      // $('#studentList').childnodes('tbody').hide();

      var query = $(this).val();
      fetch_student_data(query);
    }

  });
 
});





    // $('tbody').on("click", "td button.mr-2", function() {
    //   var id = $(this).parents('tr').children().first().html();
    //   //console.log($('#stuID').val());
    //   //console.log($(this).attr('id'));
    //   if($(this).attr('id') == "viewEditBtn"){
    //     $('#stuID').val(id);
    //     document.getElementById("formy").submit();
    //   }

    //   else if($(this).attr('id') == "viewProfileBtn"){
    //     $('#stuID1').val(id);
    //     //console.log($('#stuID1').val());
    //     document.getElementById("formy1").submit();
    //   }
    // });

    // $('tbody').on("click", "td button.btn-earth", function() {
    //   rowID = $(this).parents('tr').children().first().html();
    //   $("#delKeep").hide();
    //   $("#delDelete").hide();
    //   $("#deleteModal").show();
    //   // Stop call to db if last call has not had a response yet

    // });

    // $("span.close").click(function() {
    //   $("#deleteModal").hide();
    // });

    // $(window).click(function(event) {
    //   if(event.target == document.getElementById('deleteModal'))
    //   $("#deleteModal").hide();
    // });

  };



//   function confirmDelete(id)
// {
  // var r = confirm("Are you sure you want to delte this image");
  // if (r==true)
  // {
  // //User Pressed okay. Delete
  // $.ajax({
  //     url: "/student/deleteStudent/",
  //     type: "POST",
  //     data: {id : 5},
  //     dataType: "html", 
  //     success: function() {
  //         alert("It was succesfully deleted!");
  //     }
  // });


  // $.ajax({
  //     type: "POST",
  //     contentType: "application/json; charset=utf-8",
  //     url: "Searching.aspx/Delete_Student_Data",
  //     data: "{'StudentID': '" + studentID + "'}",
  //     dataType: "json",
  //     success: function (data) {
  //         alert("Delete StudentID Successfully");
  //         return true;
  //     }

//   }
//   else
//   {
//   //user pressed cancel. Do nothing
//   }
//  }




function clossesModal2(){
  document.getElementById("myModal2").style.display="none";
}


</script>

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


<form id="formy" action="/studentAttendance/postUpdateInfo" method="POST">
  {{ csrf_field() }}
  <input type="hidden" id="stuID" name="id" value="-1">
</form>

<form id="formy1" action="/students/profile" method="POST">
  {{ csrf_field() }} 
  <input type="hidden" id="stuID1" name="id" value="-1">
</form>

<p id="deleteMsg"></p>

<!-- <div class="modal" id="deleteModal" tabindex="-1">
  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="">
        <h5 class="">Delete Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p>Are you sure you want to delete student?</p>
        <label><input type="checkbox" value="" class="mr-2">Keep Student Records</label>
      </div>

      <div class="modal-footer flex-wrap">
        <button class="btn btn-primary mt-2" data-dismiss="modal" onclick="deleteStudent(1)">Cancel</button>
        <button class="btn btn-earth mt-2"  data-dismiss="modal"  onclick="deleteStudent(2)">Delete</button>
      </div>

    </div>
  
  
  </div>
</div>  -->








<style>
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

<!-- *************************** Student List Table *************************** -->
<div class="d-flex flex-row flex-wrap center">
        <!-- list -->
        <div class="xsm-d-flex xsm-center">
        <div class="panel60 d-flex flex-col listTable bg-w xsm-panel100 nobdrad">
            <div class="d-flex flex-row center content_center">
                <div class="panel100p d-flex flex-col item_center mt_1 mb_1">
                <input style="width:90%" id="nameSearch" class="panel90p mt_1 searchbox inpt_tg1" type="text" placeholder="Search by Name..." name="search">
                </div>
            </div>

            <div style="overflow-x: auto;" class="panel100p d-flex flex-col flex-wrap item_center dflex_row_spaceBetween"> 
                <table class="panel90p mt_1">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>CLASS</th>
                        <th>SECTION</th>
                        <th>ROLL</th> 
                        <th>BIRTHDAY</th>
                        <th>CONTACT</th>
                        <th>ACTION</th>
                      </tr>
                    </thead>
                      <tbody  id="studentList">
                        @foreach ($student as $id)
                            <tr>

                              <td>{{ $id->id }}</td>

                              <td>{{ $id->name }}</td>

                              @php
                              $hasClass = 'Unassigned';
                              $hasSec = 'Unassigned';          
                              @endphp

                            @foreach ($courseInfo as $info )
                              @if($id->id==$info->id)
                                @php
                                $hasClass = $info->className;
                                $hasSec = $info->secName;
                                break;
                                @endphp
                              @endif
                            @endforeach

                              <td>
                              @if($hasClass!='Unassigned')
                                @if ($hasClass==100)
                                  @php
                                  $hasClass='Preschool'
                                  @endphp
                                @endif
                                {{ $hasClass }}
                              @else Unassigned
                              @endif
                            </td>

                            <td>
                              @if($hasSec!='Unassigned')
                                {{ $hasSec }}
                              @else Unassigned
                              @endif
                            </td>

                            <td>{{ $id->rollNumber }}</td>
                            <td>{{ $id->DOB }}</td>
                            <td>{{ $id->contact }}</td>
                            <td>
                                <ul class="d-flex flex-row center dflex_row_spacearound pd_0 lstyle">
                                    <li><a href="{{ URL::to('/student/update/id='.$id->id)}}"><img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit"></a></li>
                                    <?php $std_section  = DB::table('section_has_students')->where('student_id',$id->id)->first();?>
                                    <?php  if(isset($std_section)){ ?>
                                   
                                    <li><a href="{{ URL::to('/student/profile/id='.$id->id)}}"><img id="viewProfileBtn" class="icnimg" src="/img/user2.png" alt="user2"></li>
                                    <?php }else {?>
                                    {{-- <a href="{{ URL::to('/assignStudent/id='.$id->id)}}" class="btn_submit1" >Add to Section</a> --}}
                                  
                                    <li><a href="{{ URL::to('/assignStudent/id='.$id->id)}}"><img id="viewProfileBtn" class="icnimg" src="/img/user.png" alt="user"></a></li>
                                      
                                    <?php }?>
                                    {{-- <li><img id="viewProfileBtn" class="icnimg" src="/img/user2.png" alt="user2"></li> --}}
                                    <li><a href="#" onclick=somefunction("{{ URL::to('/student/deleteStudent/id='.$id->id)}}")><img id="deleteModal" class="icnimg" src="/img/delete.png" alt="delete" ></a></li>
          
                                    
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
                    {{$student->links()}}
                  </div>
                    
                </div>
            </div>
        </div>
        </div>


        <!-- right side panel -->
        <div class="panel20 d-flex flex-col item_center flex-wrap tb-panel30p xsm-d-flex xsm-center xsm-panel80">
            <div class="bg-w panel50p pt_1 pd_2 d-flex flex-col dflex_row_space_evenly item_center xsm-mt_1 xsm-panel80p">
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
        </div>
   
</div>

@endsection
