<!-- takeAttendanceSelect -->
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@extends('layouts.master2')

@section('content')
  <script type="text/javascript">
    var connectionActive = false;
    var checked = false;
    var teacherId = "";
    window.onload = function() {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      teacherId = '<?php echo ((isset($teacher_id)) ? $teacher_id:""); ?>';
    }

    function submitExamId(exam){
      var examID = exam.options[exam.selectedIndex].value;
      document.getElementById("formSubmit").style.display = "block";
      console.log("こんにちは");

    }

    function showExams(subject){
        console.log('おはよう');
        var subjectID = subject.options[subject.selectedIndex].value;
        //Call DB if sectionID is not null
        var xmcnct = false;
        if (subjectID != ""){
          if(subjectID=="all"){
            subjectID = null;
          }
          if(!xmcnct)
          {
            $.ajax({
              beforeSend: function(xhr)
              {
                xmcnct = true;
              },
              type:'POST',
              url: "/exams/getExamList",
              data: {subjectID:subjectID, sectionID:$('#sectionID').find(":selected").val()},
              success:function(data)
              {
                xmcnct = false;
                console.log(data);
                // console.log(data.msg[0].name);
                console.log(data.msg.length);
                //Check if valid subject list returned
                if(data.msg.length > 0)
                {

                  //Clear current list of subjects
                  $("#examId").find('option').remove();
                  var examList = document.getElementById("examId");
                  var option = document.createElement("option");
                  option.text = "";
                  examList.add(option);
                  //var option = document.createElement("option");
                  //option.text = "All";
                  //option.value = "all";
                  //examList.add(option);
                  //Add returned subject list
                  for (i = 0; i < data.msg.length; i++) {
                    option = document.createElement("option");
                    if(data.msg[i].quiz == '1'){
                      option.text = data.msg[i].name + " [Class Test]";
                    }else{
                      option.text = data.msg[i].name;
                    }
                    option.value = data.msg[i].id;
                    examList.add(option);
                  }
                  //Show the list
                  document.getElementById("examList").style.display = "block";
                }
                else{
                  $("#examId").find('option').remove();
                  document.getElementById("examList").style.display = "none";
                }
              }
            });
          }
        }
        else{
            document.getElementById("examList").style.display = "none";
        }
    }

    //Function to get subjects once a section has been selected
    function getSubjects(section){
      //Get the section ID
      var sectionID = section.options[section.selectedIndex].value;
      var subjectListSelect = document.getElementById("subjectID");
      document.getElementById("examList").style.display = "none";

      //Call DB if sectionID is not null
      if (sectionID != "")
      {
        if(!connectionActive)
        {
          $.ajax({
            beforeSend: function(xhr)
            {
              connectionActive = true;
            },
            type:'POST',
            url: "/marks/getSubjects",
            data: {sectionID:sectionID},
            success:function(data)
            {
              connectionActive = false;
              //Check if valid subject list returned
              if(data.msg.length > 0)
              {
                //Clear current list of subjects
                $("#subjectID").find('option').remove();
                var option = document.createElement("option");
                option.text = "";
                subjectListSelect.add(option);
                for (i = 0; i < data.msg.length; i++) {
                  option = document.createElement("option"); 
                  option.text = data.msg[i].name;
                  option.value = data.msg[i].id;
                  subjectListSelect.add(option);
                }
                //Show the list
                document.getElementById("subjectList").style.display = "block";
                document.getElementById("formSubmit").style.display = "none";
              }
              else{
                $("#subjectID").find('option').remove();
                document.getElementById("subjectList").style.display = "none";
                document.getElementById("formSubmit").style.display = "none";
              }
            }
          });
        }
      }
      else
      {
        //Clear current list of subjects
        $("#subjectID").find('option').remove();
        //Hide the list
        document.getElementById("subjectList").style.display = "none";
      }

    }
  </script>

<div class="d-flex xsm-flex-col tb-flex-row center item_center flex-wrap panel100p">

<div class="d-flex flex-col center align_center item_center" >
    <div class="ftclr txt_cntr"><h2>SELECT EXAM TO GRADE:</h2></div>
      <div>
       @if($sections)
          <form class="d-flex flex-col panel50 xsm-panel100p" method="POST" action="/exams/getStudents" id="examForm">
           {{ csrf_field() }}

          <div>
              <label for="sectionID">Select Section : </label>
              <select class="mt_1" name="sectionID" id="sectionID" onchange="getSubjects(this)" required>
              <option value="">
                  Select Section
              </option>
              
                      @foreach($sections as $id)
                        @php
                        $className = ($id->class);
                        if ($id->class===100) {
                          $className='Preschool';
                        }
                        @endphp
                        <option value="{{ $id->id }}">[ Class: {{ $className }} ] Section: {{ $id->name }}</option>
                      @endforeach
              </select>
          </div>

          <div class="mt_1" id="subjectList" style="display:none">
                  <label for="subjectID">Select Subject :</label>
                    <select class="mt_1" name="subjectID" id="subjectID" onchange="showExams(this)">
                    </select>
          </div>

          <div class="mt_1" id="examList" style="display:none">
                  <label for="examId">Select Exam :</label>
                  <select class="mt_1" name="examId" id="examId" onchange="submitExamId(this)">

                  </select>
          </div>
          
      

          <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound" id="formSubmit" style="display:none">
                  <button style="width:100%;" id="submit1" class="btn_submit txt_cntr mt_1 self_center normal">Select</button>
          </div>
              @include('layouts.errors')
          </form>       
        @else
            {{ "No section is assigned." }}
        @endif
      </div>
</div>
</div>

@endsection
