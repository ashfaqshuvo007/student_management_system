@extends('layouts.master2')

@section('content')
<script type="text/javascript">
function invoke_upload(){
  $('#fileToUpload').click();
} 
function validate_form(){
  year = new Date().getFullYear();
  birth_year = parseInt(document.forms["student_post"]["DOB"].value.split('-')[0]);
  if(((year - birth_year) < 5) || ((year - birth_year) > 100)){
    alert("Invalid Birth Year!");
    return false
  }
  else
    blood_group = document.forms["student_post"]["bloodGroup"].value;
    blood_groups = ["A+", "A-", "B+", "B-", "O+", "O-", "AB+", "AB-", ""];
    for (i in blood_groups){
      if(blood_groups[i] == blood_group)
        return true
    }
    alert("Invalid Blood Group! Please ensure the input is in the form of A+,AB- etc.")
    return false 
}

window.onload = function() {
  $('#fileToUpload').change(function() {
    console.log($(this).val());
    if($(this).val() != ""){
      $('#fileMsg').text($(this).val().substring(12));
      $('#fileMsg').show();
      $('#fileSubmit').removeClass('btn-disabled');
      $('#fileSubmit').addClass('btn_submit');
      $('#fileSubmit').prop("disabled", false);
    }
    else{
      $('#fileMsg').text("");
      $('#fileMsg').hide();
      $('#fileSubmit').prop("disabled", true);
      $('#fileSubmit').removeClass('btn_submit');
      $('#fileSubmit').addClass('btn-disabled');
    }
  });
}
</script>

@if(Session::has('message'))
<div class="successBox">
    <div class="d-flex flex-col flex-wrap center txt_cntr">
        <div id="ssbox" style="background: #81C784;
        border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1 color-white">{{ session::get('message')}}
        </div> 
    </div>
</div>
@endif
@if(Session::has('errMessage'))

  @foreach(session::get('errMessage') as $error)
      @php
      echo 
            '<div class="d-flex flex-col flex-wrap center txt_cntr">';
          if(strpos((strtolower($error)), "success")!==false){
            echo 
            '<div style="background: #81C784;
                color: white;
                border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">
                
                ' . $error . '
            </div> 
          </div> ';  
          }elseif(strpos((strtolower($error)), "duplicate")!==false){
            echo 
            '<div style="background: #714cfe;
                color: white;
                border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">
                
                ' . $error . '
            </div> 
          </div> ';
          }else{
            echo 
            '<div style="background: #FF6564;
                color: white;
                border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">
                
                ' . $error . '
            </div> 
          </div> ';
          }
      @endphp

  @endforeach

@endif



{{ csrf_field() }}
<div class="d-flex flex-row flex-wrap dflex_row_space_evenly xsm-flex-col panel100p">

    <!-- 1st section -->
    <div class="panel20p d-flex flex-row flex-wrap dflex_row_space_evenly pd_1 xsm-panel90p">
        <!-- upload pic -->
        <div style="border-radius: 25px; box-shadow: -5px 5px #43A5F3; width: 100%; height:35vh;" class="bg-w d-flex flex-col dflex_row_spacearound flex-wrap panel20p tb-panel30p">
            <div style="background-repeat: no-repeat;
            background-size: 100% 100%;" class="d-flex flex-col center pd_1">
                  
                    <a href="/sample_input">Sample Excel File</a>
                  

                    <form class="xsm-panel100p" action="/studentParser" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <p>Upload File:</p>
                        <button class="btn_submit panel90p" type="button" name="fileToUpload" onclick="invoke_upload()">Choose File</button>
                        <p id="fileMsg" style="display: none"></p>
                        <input class="hidden-input" type="file" name="fileToUpload" id="fileToUpload"><br>


                        <!-- Change the class below from btn-disabled to btn-primary -->
                        <!-- <button id="fileSubmit" class="btn_submit panel90p" type="submit" value="Upload" name="submit" disabled="true">Submit</button>
                        <input class="hidden-input" type="submit" value="Upload" name="submit"> -->


                        <button id="fileSubmit" class="panel90p btn-disabled" type="submit" value="Upload" name="submit" disabled="true">Submit</button>
                        <input class="hidden-input" type="submit" value="Upload" name="submit">


                    </form>
            </div>
        </div>
        <!-- inputs -->
      </div>
  
    <!-- 2nd section -->


<div class="panel60p d-flex flex-row flex-wrap dflex_row_spacearound xsm-panel93p bg-w pd_1 xsm-self-center nobdrad xsm-margin-0">


  <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
  <form class="xsm-panel100p" name="student_post" method="POST" action="/student" onsubmit="return validate_form()" enctype="multipart/form-data"> 
  {{ csrf_field() }}
                  <div class="d-flex flex-col panel100p" action="">
                  {{-- Name --}}
                  <label for="">FULL NAME</label>
                  <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="name" pattern=".{6,}" title="MINIMUM SIX CHARACTERS REQUIRED." required>
                  {{-- Date of Birth --}}
                  <label for="" class="mt_1">DATE OF BIRTH</label>
                  <input class="inpt_tg mt_1" type="date" id="exampleInputEmail1" name="DOB">
                  <label for="" class="mt_1">GENDER</label>
                      <select class="mt_1" id="gender" name="gender" required>
                          <option value=""></option>
                          {{-- Male --}}
                          <option name="gender" id="inlineRadio1" value="1">BOY</option>
                          {{-- Female --}}
                          <option name="gender" id="inlineRadio2" value="2">GIRL</option>
                      </select>
                  </div>
          </div>








          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      {{-- Father's Name --}}
                      <label for="">FATHER'S NAME</label>
                      <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="fatherName" >
                  </div>
          </div>


          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      {{-- Mother's Name --}}
                      <label for="">MOTHER'S NAME</label>
                      <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="motherName" >
                  </div>
          </div>
          
            <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      {{-- Father's Name --}}
                      <label for="">FATHER'S Occupation</label>
                      <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="father_occupation" >
                  </div>
            </div>


          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      {{-- Mother's Name --}}
                      <label for="">MOTHER'S Occupation</label>
                      <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="mother_occupation" >
                  </div>
          </div>



          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                    {{-- Contact Number --}}
                  <label for="Title">Contact Number</label>
                      <input class="inpt_tg mt_1" type="number" id="exampleInputEmail1" name="contact" required>
                  </div>
          </div>




          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                    {{-- Birth Certificate --}}
                      <label for="birthCertificate">Birth Certificate ID</label>
                      <input class="inpt_tg mt_1" type="text" id="birthCertificate" name="birthCertificate" >
                  </div>
          </div>



          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      {{-- Address --}}
                      <label for="">ADDRESS</label>
                      <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="address" >
                  </div>
          </div>


          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
            <div class="d-flex flex-col panel100p" action="">
              {{-- Class --}}
            <label for="Title">Class</label>
                <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="class" required>
            </div>
          </div>

          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
            <div class="d-flex flex-col panel100p" action="">
              {{-- Class --}}
            <label for="Title">Section</label>
                <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="section" required>
            </div>
          </div>




          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      {{-- Blood Group --}}
                      <label for="">BLOOD GROUP</label>
                      <input class="inpt_tg mt_1" type="text" id="exampleInputEmail1" name="bloodGroup" pattern="([AaBbOo]|[Aa][Bb])[+-]" placeholder="Max 3 letters with + or - at the end" >
                  </div>
          </div>


          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      <label for="">MONTHLY HOUSEHOLD INCOME</label>
                      <input class="inpt_tg mt_1" type="number" name="familyIncome" placeholder="" >
                  </div>
          </div>

          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      <label for="">WEIGHT</label>
                      <input class="inpt_tg mt_1" type="number" name="weight" placeholder="In Kg" >
                  </div>
          </div>


          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      <label for="">HEIGHT</label>
                      <input class="inpt_tg mt_1" type="number" name="height" placeholder="In Cm" >
                  </div>
          </div>


          <div class="d-flex flex-col panel90p dflex_row_space_evenly mt_1">
                  <div class="d-flex flex-col panel100p" action="">
                      {{-- Address --}}
                      <label for="">NO OF Siblings</label>
                      <input class="inpt_tg mt_1" type="number" id="exampleInputEmail1" name="no_of_siblings" >
                  </div>
          </div>

          <div class="panel90p d-flex flex-row flex-wrap center align_center">
              <button type="submit" class="btn_submit txt_cntr mt_1 self_center fbtn panel100p" >SUBMIT</button>
          </div>

  </div>


 



</div>





  </form>

    <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">
        <p>
                Enrolling multiple students? Use the <a class="blue_text" href="">batch uploader.</a>
        </p>
    </div>

</div>










@endsection
