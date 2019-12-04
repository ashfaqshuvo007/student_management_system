@extends('layouts.master2')
<?php

$gender = $studentInfo->gender;

?>
<script type="text/javascript">

function validate_form(){

  year = new Date().getFullYear();

  birth_year = parseInt(document.forms["student_post"]["DOB"].value.split('-')[0]);

  if(((year - birth_year) < 5) || ((year - birth_year) > 100)){

    alert("Invalid Birth Year!");

    return false

  }

  else 

  blood_group = document.forms["student_post"]["bloodGroup"].value;

  console.log(blood_group);

  blood_groups = ["A+", "A-", "B+", "B-", "O+", "O-", "AB+", "AB-"];

  for (i in blood_groups){

    if(blood_groups[i] == blood_group)

    return true

  }

  // alert("Invalid Blood Group! Please ensure the input is in the form of A+,AB- etc.")

  // return false



}

</script>

@section('content')

@php

@endphp
<div class="d-flex center">
<div class="d-flex flex-col bg-w panel60p margin-1">
<div class="d-flex self_center mt_1 ftclr"> <h2 class="bold">Update Student Info</h2></div>

<div class="d-flex self_center center pd_1 mt_1 panel80p">

    <form class="panel90p" name="student_post" method="POST" action="/student/update" onsubmit="return validate_form()">

      

      {{ csrf_field() }}

  
        @if(session()->has('message'))
          <div class="alert alert-success">
            {!! session()->get('message') !!}
          </div>
          @endif
  
          @if(session()->has('errMessage'))
          <div class="alert alert-danger">
            {!! session()->get('errMessage') !!}
          </div>
          @endif
        <div class="d-flex flex-col center">

          <div class="mt_1">

            <label for="Title">Student ID :</label>

            <input type="text" class="inpt_tg pd_1 bd mt_1" name="id" value="{{ $studentInfo->id }}" readonly required>

          </div>



          <div class="mt_1">

            <label for="Title">Student Name :</label>

            <input type="text" class="inpt_tg pd_1 bd mt_1" name="name" value="{{ $studentInfo->name}}" required>

          </div>



          <div class="mt_1">

            <label for="Title">Father's Name :</label>

            <input type="text" class="inpt_tg pd_1 bd mt_1" name="fatherName" value="{{ $studentInfo->fatherName}}">

          </div>



          <div class="mt_1">

            <label for="Title">Mother's Name :</label>

            <input type="text" class="inpt_tg pd_1 bd mt_1" name="motherName" value="{{ $studentInfo->motherName }}">

          </div>

          <div class="mt_1">

            <label for="Title">Date of Birth :</label>

            <input type="date" class="inpt_tg pd_1 bd mt_1" name="DOB" placeholder="day-month-year" value="{{ $studentInfo->DOB }}"> {{-- Type chaned from text to date --}}

          </div>

          {{-- For Future --}}



          <div class="mt_1">

            <label for="gender">Gender: </label>

            <div class="d-flex flex-row">

              <label class=""> &nbsp;

                <input class="" type="radio" name="gender" id="inlineRadio1" value="1" <?php if($gender === 1){ echo "checked";}?>  required> Male
                <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="2" <?php if($gender === 2) {echo 'checked';}?> required> Female


              </label>

            </div>

          </div>



          <div class="mt_1">

            <label for="Title">Address :</label>

            <input type="text" class="inpt_tg pd_1 bd mt_1" name="address" value="{{ $studentInfo->address }}">

          </div>



          <div class="mt_1">

            <label for="Title">Contact Number :</label>

            <input type="number" class="inpt_tg pd_1 bd mt_1" name="contact" value="{{ $studentInfo->contact }}">

          </div>



          <div class="mt_1">

            <label for="Title">Blood Group :</label>

            <input type="text" class="inpt_tg pd_1 bd mt_1" name="bloodGroup" value="{{ $studentInfo->bloodGroup }}">

          </div>





          <div class="mt_1">

            <label for="rollNumber">Roll Number :</label>

            <input id="rollNumber" class="inpt_tg pd_1 bd mt_1" type="text" name="rollNumber" value="{{ $studentInfo->rollNumber }}">

          </div>



          <div class="mt_1">

            <label for="birthCertificate">Birth Certificate :</label>

            <input id="birthCertificate" class="inpt_tg pd_1 bd mt_1" type="text" name="birthCertificate" value="{{ $studentInfo->birthCertificate }}">

          </div>

          {{-- Family Income --}}
          <div class="mt_1">
              <label for="familyIncome">Family Income</label>
              <input type="text" class="inpt_tg pd_1 bd mt_1" id="familyIncome" value="{{ $studentInfo->familyIncome }}" name="familyIncome">
          </div>
          {{-- Father Occupation --}}
          <div class="mt_1">
              <label for="father_occupation">Occupation(father)</label>
              <input type="text" class="inpt_tg pd_1 bd mt_1" id="father_occupation" value="{{ $studentInfo->father_occupation }}" name="father_occupation">
          </div>

          {{-- Mother Occupation --}}
          <div class="mt_1">
              <label for="mother_occupation">Occupation(mother)</label>
              <input type="text" class="inpt_tg pd_1 bd mt_1" id="mother_occupation" value="{{ $studentInfo->mother_occupation }}" name="mother_occupation">
          </div>

          <?php 
          
          if( $studentInfo->height === 0 ||  $studentInfo->weight === 0 || $studentInfo->no_of_siblings === 0){
            $height = "Not set";
            $weight = "Not set";
            $noSiblings = "Not set";
          }else{
            $height = $studentInfo->height;
            $weight = $studentInfo->weight;
            $noSiblings = $studentInfo->no_of_siblings;
          }
          
          
          ?>
          {{-- Height --}}
          <div class="mt_1">
              <label for="height">Height</label>
              <input type="text" class="inpt_tg pd_1 bd mt_1" id="height" value="{{ $height }}" name="height">
          </div>

          {{-- Weight --}}
          <div class="mt_1">
              <label for="weight">Weight</label>
              <input type="text" class="inpt_tg pd_1 bd mt_1" id="weight" value="{{ $weight }}" name="weight">
          </div>

          {{-- Weight --}}
          <div class="mt_1">
              <label for="no_of_siblings">No. of Siblings <span style="color: red;"><?php if($studentInfo->no_of_siblings === 0){ echo "Not set Yet";}?></span></label>
              <input type="number" class="inpt_tg pd_1 bd mt_1" id="no_of_siblings" value="{{ $noSiblings }}"  name="no_of_siblings">
          </div>

          <div class="d-flex center">



            <button type="submit" class="btn_submit panel100p mt_1">Publish</button>

          </div>

        </div>

     
    </form>

</div>


</div>
</div>
@endsection

