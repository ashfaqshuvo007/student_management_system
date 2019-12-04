<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<script>

//Calculate Birthday according parsable string bday
function calculateAge(birthday) {
  var bday = birthday.split("-");
  bday = new Date(bday[0],bday[1],bday[2])
  var age = new Date(new Date() - bday);
  return age.getUTCFullYear()-1970;
}
//Modify student table to display results 
function tableRows(students)
{
  if(students.length < 1)
  {
    $('#studentList > tbody').empty();
    $('#studentList').hide();
    return false;
  }
  $('#studentList > tbody').empty();
  students.forEach(function(student)
  {
    if(student.DOB != null)
      var age = calculateAge(student.DOB);
    else
      var age = "";
    var gender = 'yo';
    (student.gender == 2) ? gender= 'Female' : gender = 'Male';
    if(student.gender == null)
      gender = "";
    if(student.rollNumber == null)
      student.rollNumber = "";
    $('#studentList > tbody').append('<tr class="hover-pointer"><td>' + student.id + '</td><td>' + student.name + '</td><td>' + age + '</td><td>' + gender + '</td><td>' + student.rollNumber + '</td></tr>');
  });
  $('#studentList').show();
}
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

};
</script>

@extends('layouts.master2')

@section('content')



<div style="height:70%;" class="d-flex center">
  <div class="d-flex flex-col center panel80p">
    <form class="panel100p d-flex flex-col" method="POST" action="/assignSingleStudent" id="addStudentToSection">
      {{ csrf_field() }}
      <div class="panel100p">
          @if(session()->has('message'))
          <div id="ssbox" style="height:20px; color:white; text-align:center" class="alert alert-success pd_1">
            {!! session()->get('message') !!}
          </div>
          @endif
  
          @if(session()->has('errMessage'))
          <div style="height:20px; color:white; text-align:center" class="alert alert-danger pd_1"  id="errbox">
            {!! session()->get('errMessage') !!}
          </div>
          @endif
        <div>
          <label for="sectionID">Section</label>
          <select class="inpt_tg mt_1 back-w" name="sectionID" id="sectionID" required>
              <option value="">Select Section</option>

            @foreach($section as $id)
              @php
              $className = ($id->class);
              if ($id->class==100) {
                $className='Preschool';
              }
              @endphp
              <option value="{{ $id->id }}">[ Class: {{ $className }} ] Section: {{ $id->name }}</option>
            @endforeach
            
          </select>
        </div>
        <div class="mt_1">
          <label for="student_id">Student ID</label>
          <input type="text" class="inpt_tg mt_1 back-w" name="student_id" value="{{ $studentInfo->id }}" readonly>
        </div>
        <div class="mt_1">
          <label for="sectionID">Student Name</label>
          <input type="text" class="inpt_tg mt_1 back-w" id="studentName" name="studentName" value="{{ $studentInfo->name }}" readonly>
        </div>
        
        
        <div class="panel100p d-flex center">
          <button type="submit" class="btn_submit mt_1 panel100p" id="btncheck">Assign</button>
        </div>

        @include('layouts.errors')
      </div>
    </form>

  </div>

</div>

@endsection
