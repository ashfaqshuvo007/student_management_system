
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
      teacherId = '<?php echo ((isset($teacher_id)) ? $teacher_id:""); ?>';
      console.log(examInfo);
      if(examInfo != "")
      {
        $("#page-title").html("<strong>Edit Class Test</strong>");
        $("div.blog-main > h2").html("Update Class Test Information");
        $('#submit').text('Update');
        examInfo = JSON.parse(examInfo);
        document.getElementById('examDate').value = examInfo[0]['date'];
        examId = examInfo[0]['id'];
        //$("div.blog-main > h2").append();
        var idx = 0;
        //Set Selected Value for Section
        if(examInfo[0]['section_id'] === null){
          idx = 1;
        }else{
          $("#sectionID > option").each(function(){
            if($(this).attr('value') == examInfo[0]['section_id']){
              return false;
            }
            else{
              idx++;
            }
          });
        }
        
        console.log(idx);
        document.getElementById("sectionID").selectedIndex = idx;
        console.log(examInfo[0]["quiz"]);
        console.log($("#isQuiz").val());
        $("#isQuiz").val(examInfo[0]["quiz"]);
        getSubjects(document.getElementById("sectionID"));
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
        document.getElementById("topicDiv").style.display = "block";
        examInfo = "";
        return;
      }

      //Show exam name and total mark fields if a valid subject has been selected
      if(subjectName != "")
      {
        document.getElementById("examNameDiv").style.display = "block";
        document.getElementById("totalMarkDiv").style.display = "block";
        document.getElementById("examSubmitButton").style.display = "block";
        document.getElementById("examDateDiv").style.display = "block";
        document.getElementById("topicDiv").style.display = "block";
      }
      else
      {
        document.getElementById("examNameDiv").style.display = "none";
        document.getElementById("totalMarkDiv").style.display = "none";
        document.getElementById("examSubmitButton").style.display = "none";
        document.getElementById("examDateDiv").style.display = "none";
        document.getElementById("topicDiv").style.display = "none";
      }
    }

    //Function to check if duplicate exam exists before submission
    function checkDuplicateExam(){
      if(examId != ""){
        $('<input />').attr('type', 'hidden')
          .attr('name', "examId")
          .attr('value', examId)
          .appendTo('#examForm');
        // console.log(teacherId);
        $("#submit1").click();
        return;
      }
      var exmConnection = false;
      var secID = $("#sectionID").find(":selected").val();
      var subID = $("#subjectID").find(":selected").val();
      var examName = $("#examName").val();
      var topic = $("#topic").val();
      if(!exmConnection)
      {
        $.ajax({
          beforeSend: function(xhr)
          {
            exmConnection = true;
          },
          type:'POST',
          url: "/exams/store",
          data: {sectionID:secID, subjectID:subID, examName:examName, topic:topic, ajax:true, quiz:'1'},
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
              // $('<input />').attr('type', 'hidden')
              //   .attr('name', "quiz")
              //   .attr('value', '1')
              //   .appendTo('#examForm');
              $("#isQuiz").val("1");
              $("#submit1").click();
            }
          }
        });
      }
    }

    //******  Function to get subjects once a section has been selected *****// 
    function getSubjects(section){
      //Get the section ID
      var sectionID = section.options[section.selectedIndex].value;
      var subjectListSelect = document.getElementById("subjectID");
      
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
              console.log(data);
              //console.log(data.msg[0].name);
              //console.log(data.msg.length);

              //Check if valid subject list returned
              if(data.msg.length > 0)
              {
                //Clear current list of subjects
                $("#subjectID").find('option').remove();
                var option = document.createElement("option");
                option.text = "";
                subjectListSelect.add(option);
                if(teacherId == ""){
                  option = document.createElement("option");
                  option.text = "All subjects";
                  option.value = "all";
                  subjectListSelect.add(option);
                }
                //Add returned subject list
                for (i = 0; i < data.msg.length; i++) {
                  option = document.createElement("option"); 
                  option.text = data.msg[i].name;
                  option.value = data.msg[i].id;
                  subjectListSelect.add(option);
                }
                //Show the list
                document.getElementById("subjectList").style.display = "block";
                document.getElementById("examNameDiv").style.display = "none";
                document.getElementById("totalMarkDiv").style.display = "none";
                document.getElementById("examSubmitButton").style.display = "none";
                document.getElementById("examDateDiv").style.display = "none";
                document.getElementById("topicDiv").style.display = "none";

                var idx = 0;
                if(examInfo != ""){
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
                    })
                  }
                  document.getElementById("subjectID").selectedIndex = idx;
                  showExamInfo(section);
                }
              }
              else{
                //Show the list
                document.getElementById("subjectList").style.display = "none";
                document.getElementById("examNameDiv").style.display = "none";
                document.getElementById("totalMarkDiv").style.display = "none";
                document.getElementById("examSubmitButton").style.display = "none";
                document.getElementById("examDateDiv").style.display = "none";
                document.getElementById("topicDiv").style.display = "none";
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
        document.getElementById("examNameDiv").style.display = "none";
        document.getElementById("totalMarkDiv").style.display = "none";
        document.getElementById("examSubmitButton").style.display = "none";
        document.getElementById("examDateDiv").style.display = "none";
        document.getElementById("examDateDiv").style.display = "none";
        document.getElementById("examDateDiv").style.display = "none";
      }

    }
  </script>




<div class="d-flex flex-col center align_center item_center center" >
    <div class="ftclr txt_cntr"><h2>ENTER CLASS TEST INFORMATION:</h2></div>
      <div>
       @if($sections)
          <form class="d-flex flex-col panel50 xsm-panel100p" method="POST" action="/exams/store" id="examForm">
           {{ csrf_field() }}
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
          <div>
              <label for="sectionID">Select Section : </label>
              <select class="mt_1" name="sectionID" id="sectionID" onchange="getSubjects(this)" required>
              <option value="">
                  Select Section
              </option>
              
              @php
                    
                    if(!isset($teacher_id)){
                      echo '<option value="all">All Sections</option>';
                    }
                    @endphp
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
          
            @if(isset($teacher_id))
            <input type="hidden" name="quiz" value="1">
            @endif
          <div class="mt_1" id="subjectList" style="display:none">
                  <label for="subjectID">Select Subject :</label>
                  <select class="inpt_tg mt_1 back-w" name="subjectID" id="subjectID" onchange="showExamInfo(this)">
                  </select>
          </div>
          <div class="mt_1" id="topicDiv" style="display:none">
            <label for="topic">Class Test Topic</label>
            <input class="inpt_tg mt_1 back-w" type="text" id="topic" name="topic" placeholder="Enter class test topic Here" required>
         </div>

          <div class="mt_1" id="examNameDiv" style="display:none">
                  <label for="Title">Class Test Name</label>
                  <input class="inpt_tg mt_1 back-w" type="text" id="examName" name="examName" placeholder="Enter Name Here" required>
          </div>
                <div class="mt_1" id="totalMarkDiv" style="display:none">
                  <label for="Title">Total Class Test Mark</label>
                  <input class="inpt_tg mt_1 back-w" type="number" id="totalMark" name="totalMark" value="100" required>
                </div>
                <?php 
                
                $day = date("m/d/Y");
                // dd($day);
                
                ?>
          <div class="mt_1" id="examDateDiv" style="display:none">
                  <label for="Title">Class Test Date</label>
                  <input type="date" class="inpt_tg mt_1 back-w" id="examDate" name="examDate" required>
                </div>
                <input type="hidden" id="isQuiz" name="quiz" value="0">
                <div class="form-group mt-3" id="formSubmit" style="display:none">
                  <button id="submit1" class="btn btn-twitter mt-2"></button>
                </div>
                @include('layouts.errors')
              </form>
              <div class="mt_1 mb_1" id="examSubmitButton" style="display:none">
                  <button id="submit" class="btn_submit panel100p mt_1" onclick="checkDuplicateExam();">Create Class Test</button>
                  <span style="color:red;display:none" id="duplicateErrorMsg">Class test already exists!</span>
                </div>
            @else
              {{ "No section is assigned." }}
            @endif
          </div>
            <!-- <div class=panel>
                <button style="width:100%;" type="submit" id="submit" class="btn_submit txt_cntr mt_1 self_center normal" onclick="checkDuplicateExam();">CREATE QUIZ</button><br>
                </div>


            -->
              @include('layouts.errors')
         



      </div>
</div>
  
@endsection
