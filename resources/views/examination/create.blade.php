<!-- takeAttendanceSelect -->
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@extends('layouts.master2')

@section('content')
  <script type="text/javascript">
    var connectionActive = false;
    var checked = false;
    var exmConnection = false;
    var examInfo = "";
    var examId = "";
    var teacherId = "";
    window.onload = function() {
      document.getElementById("examDate").min = new Date().toJSON().slice(0,10);
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      examInfo = '<?php echo ((isset($examInfo)) ? $examInfo:""); ?>';
      console.log(examInfo);
      if(examInfo != "")
      {
        $("#page-title").html("<strong>Edit Exam</strong>");
        $("div.blog-main > h2").html("Update Exam Information");
        $('#submit').text('Update');
        examInfo = JSON.parse(examInfo);
        document.getElementById('examDate').value = examInfo[0]['date'];
        examId = examInfo[0]['id'];
        //$("div.blog-main > h2").append();
        var idx = 0;
        //Set Selected Value for Section
        if(examInfo[0]['subject_id'] === null){
          idx = 1;
        }else{
          $("#subjectID > option").each(function(){
            if($(this).attr('value') == examInfo[0]['subject_id']){
              return false;
            }
            else{
              idx++;
            }
          });
        }
        
        console.log(idx);
        document.getElementById("subjectID").selectedIndex = idx;
        showExamInfo(document.getElementById("subjectID"));
      }
      else{
        var today = new Date();
        y = today.getFullYear().toString();
        (today.getMonth()+1) < 10 ? m = "0" + (today.getMonth()+1).toString() : m = (today.getMonth()+1).toString();
        today.getDate() < 10 ? d = "0" + today.getDate().toString() : d = today.getDate().toString();

        today = y.toString() + "-" + m.toString() + "-" + d.toString();
        $("#examDate").attr("value",today);
      }
    }

    //Function to show the marks and exam name field once a subject has been selected
    function showExamInfo(subject)
    {
      var subjectName = subject.options[subject.selectedIndex].value;
      console.log(subjectName);

      if(examInfo != ""){
        document.getElementById("examName").value = examInfo[0]['name'];
        document.getElementById("totalMark").value = examInfo[0]['max_grade'];
        document.getElementById("examNameDiv").style.display = "block";
        document.getElementById("totalMarkDiv").style.display = "block";
        document.getElementById("examSubmitButton").style.display = "block";
        document.getElementById("examDateDiv").style.display = "block";
        examInfo = "";
        return;
      }

      //Show exam name and total mark fields if a valid subject has been selected
      if(subjectName != "")
      {
        console.log("hey");
        document.getElementById("examNameDiv").style.display = "block";
        document.getElementById("totalMarkDiv").style.display = "block";
        document.getElementById("examSubmitButton").style.display = "block";
        document.getElementById("examDateDiv").style.display = "block";
        document.getElementById("sectionDiv").style.display = "block";
        console.log(document.getElementById("examDateDiv"));
        console.log(document.getElementById("examNameDiv"));

      }
      else
      {
        document.getElementById("examNameDiv").style.display = "none";
        document.getElementById("totalMarkDiv").style.display = "none";
        document.getElementById("examSubmitButton").style.display = "none";
        document.getElementById("examDateDiv").style.display = "none";
        document.getElementById("sectionDiv").style.display = "none";

      }
    }

    //Function to check if duplicate exam exists before submission
    function checkDuplicateExam(){
      if(examId != ""){
        $('<input />').attr('type', 'hidden')
          .attr('name', "examId")
          .attr('value', examId)
          .appendTo('#examForm');
        $("#submit1").click();
        return;
      }
      var exmConnection = false;
      var secID = "all";
      var subID = $("#subjectID").find(":selected").val();
      var examName = $("#examName").val();

      if(!exmConnection)
      {
        $.ajax({
          beforeSend: function(xhr)
          {
            connectionActive = true;
          },
          type:'POST',
          url: "/exams/store",
          data: {sectionID:secID, subjectID:subID, examName:examName, ajax:true},
          success:function(data)
          {
            exmConnection = false;
            console.log(data);
            //Check if duplicate exam list returned and submit if list size is 0 (No duplicate exam found)
            if(data.msg.length > 0)
            {
              $("#duplicateErrorMsg").show();
              $("#duplicateErrorMsg").fadeOut(4000);
            }
            else{
              $("#submit1").click();
            }
          } 
        });
      }
    }
  </script> 

<div class="d-flex flex-col center align_center item_center dflex_row_spacearound" >
  <div class="panel70p d-flex flex-col item_center center pd_1 xsm-panel90">
      <div class="ftclr txt_cntr"><h2>ENTER EXAM INFORMATION:</h2></div>
        <div>
        @if($subjects)
            <form class="d-flex flex-col panel50 xsm-panel100p" method="POST" action="/exams/store" id="examForm">
            {{ csrf_field() }}

            <div id="subjectList">
                <label for="sectionID">Select Subject : </label>
                <select class="mt_1" name="subjectID" id="subjectID" onchange="showExamInfo(this)" required>
                <option value="">
                    Select Subject
                </option>
                
                    <option value="all">All Subjects</option>
                    @foreach($subjects as $subject)
                      <option value="{{ $subject->id }}">{{ ucfirst(trans($subject->name)) }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt_1" id="examNameDiv" style="display:none">
                  <label for="Title">Exam Name</label>
                  <input class="inpt_tg mt_1 back-w lt_1p" type="text" id="examName" name="examName" placeholder="Enter Name Here" required>
              
            </div>
            
            <div class="mt_1" id="examDateDiv" style="display:none">
                    <label for="Title">Exam Date</label>
                    <input class="inpt_tg mt_1" type="date"  id="examDate" name="examDate" required>
                  </div>


            <div class="mt_1" id="totalMarkDiv" style="display:none">
                  <label for="Title">Total Exam Mark</label>
                  <input class="inpt_tg mt_1" type="number" id="totalMark" name="totalMark" value="100" required>
                
            </div>
            
        
            <div id="formSubmit" style="display:none">
                    <button id="submit1" class="btn btn-twitter mt-2"></button>
            </div>
            <input hidden type="text" value="all" name="sectionID">

                @include('layouts.errors')
            </form>

            <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound" id="examSubmitButton" style="display:none">
                <button style="width:100%;" type="submit" id="submit" class="btn_submit txt_cntr mt_1 self_center normal" onclick="checkDuplicateExam();">CREATE EXAM</button><br>
                <span style="color:red;display:none" id="duplicateErrorMsg">Exam already exists!</span>

              </div>
          @else
              {{ "No section is assigned." }}
          @endif
        </div>
  </div>

</div>





@endsection
