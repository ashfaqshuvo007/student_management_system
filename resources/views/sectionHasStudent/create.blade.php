<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<script>

//Calculate Birthday according parsable string bday
// function calculateAge(birthday) {
//   var bday = birthday.split("-");
//   bday = new Date(bday[0],bday[1],bday[2])
//   var age = new Date(new Date() - bday);
//   return age.getUTCFullYear()-1970;
// }
// //Modify student table to display results 
// function tableRows(students)
// {
//   if(students.length < 1)
//   {
//     $('#studentList > tbody').empty();
//     $('#studentList').hide();
//     return false;
//   }
//   $('#studentList > tbody').empty();
//   students.forEach(function(student)
//   {
//     if(student.DOB != null)
//       var age = calculateAge(student.DOB);
//     else
//       var age = "";
//     var gender = 'yo';
//     (student.gender == 2) ? gender= 'Female' : gender = 'Male';
//     if(student.gender == null)
//       gender = "";
//     if(student.rollNumber == null)
//       student.rollNumber = "";
//     $('#studentList > tbody').append('<tr class="hover-pointer"><td>' + student.id + '</td><td>' + student.name + '</td><td>' + age + '</td><td>' + gender + '</td><td>' + student.rollNumber + '</td></tr>');
//   });
//   $('#studentList').show();
// }
//Flag to detect server response complete
var connectionActive = false;
window.onload = function()
{
  //Setup ajax for laravel server by providing token
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


/** TESTING STUDENT DATA FETCH FROM DB */
$(document).ready(function(){
  // $('#studentList').hide();
  //fetch_customer_data();
 
  function fetch_customer_data(query = '')
  {
   $.ajax({
    url:'/getSearchedStudent',
    method:'POST', 
    data:{query:query},
    dataType:'json',
    success:function(data)
    {
      console.log(data);
     $('tbody').html(data.table_data);
     $('#total_records').text(data.total_data);
    }
   })
  }
 
  $(document).on('keyup', '#studentName', function(){

    if($(this).val().length > 1){
      
      var query = $(this).val();
      fetch_customer_data(query);
    }
    else{
      $('tbody').html("");
     $('#total_records').text("0");

    }
  });

  $(document).on('change','#sectionID',function(){
    // var index = $(this :selected).text;
    var selected = $(this).children("option:selected").text();
    // total_records

    // var assign = "Will be assigned to "+selected;
    $("#assignedTo").text(selected);

    console.log(selected);
     

  })




 });
/** TESTING STUDENT DATA FETCH FROM DB */


};
// $(document).ready(function() {

// var select = $('select["sectionID"]');

// //when sectiuon is selected
// select.change(function(){
// alert("selected");
// })

// });

</script>

@extends('layouts.master2')

@section('content')

<div class="d-flex flex-col center align_center item_center dflex_row_spacearound">
   
      <div class="bg-w pd_1 nobdrad xsm-margin-0 xsm-panel100p d-flex center">

         @if(session()->has('message'))
          <div class="successBox">
          <div class="d-flex flex-col flex-wrap center txt_cntr">
          <div style="background: #81C784;
        color: white;
        border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">{!! session()->get('message') !!}
        </div> 
        </div>
        </div>
          @endif 
  
          @if(session()->has('errMessage'))
        <div class="errorBox">
        <div class="d-flex flex-col flex-wrap center txt_cntr">
        <div style="background: #FF6564;
        color: white;
        border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">{!! session()->get('errMessage') !!}
        </div> 
        </div>
        </div>

          @endif


{{-- <div class="successBox">
    <div class="d-flex flex-col flex-wrap center txt_cntr">
        <div style="background: #81C784;
        color: white;
        border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1"><h5>Your action has been <br> performed successfully!</h5></div> 
    </div>
</div>

<div class="errorBox">
    <div class="d-flex flex-col flex-wrap center txt_cntr">
        <div style="background: #FF6564;
        color: white;
        border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1"><h5>Your action could <br> not be performed!</h5></div> 
    </div>
</div> --}}




        @if($section)
          <form class="d-flex flex-col panel70 xsm-panel80" method="POST" action="/assignStudent" id="addStudentToSection">
            {{ csrf_field() }}
              <label for="sectionID">SECTION NAME : </label>
              <select class="mt_1" id="sectionID" name="sectionID" required>
                  <option class="pd_1" value="">
                    Select Section
                  </option>
            @foreach($section as $id)
              @php
              $className = ($id->class);
              if ($id->class==100) {
                $className='Preschool';
              }
              @endphp
              <option class="pd_1" value="{{ $id->id }}">[ Class: {{ $className }} ] Section: {{ $id->name }}</option>
            @endforeach
              </select>
              
              <div>
              <div class="form-group mt_1 background-grey pd_1">
                <label for="sectionID">Student Name</label>
                <input style="height:2rem;" type="search" class="inpt_tg mt_1 back-w" id="studentName" name="studentName" placeholder="Type name to select from matches below." required>
              </div>

                <div class="" id="studentList">
                  <p>Total matches found : <span id="total_records"></span></p>
                  <p>Students Will be assigned to : <span id="assignedTo" style="color:#FF6564;"></span></p>
                  <table class="panel100p">
                      <thead>
                          <tr>
                              <th>Student ID</th>
                              <th>Student Name</th>
                              <th>Current Section</th>
                              <th>Select To assign</th>
                          </tr>
                      </thead>
                  <tbody>
            
                  </tbody>
                  </table>
                </div>
              </div>
              
              <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">
              <input type="hidden" name="studentID" value="-1" id="studentID">
              <button style="width:100%;" type="submit" id="btncheck" class="btn_submit txt_cntr mt_1 self_center normal">ASSIGN</button>
                 
              </div>
              @include('layouts.errors')
          </form>
        @else
            {{ "No section is assigned." }}
        @endif
      </div>
</div>


<script>






</script>

@endsection
