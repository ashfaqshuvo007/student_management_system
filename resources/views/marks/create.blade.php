<!-- takeAttendanceSelect -->
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@extends('layouts.master')

@section('content')
  <script type="text/javascript">
    var connectionActive = false;
    var checked = false;
    var exmConnection = false;
    window.onload = function() {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    }

    //Function to show the marks and exam name field once a subject has been selected
    function showExamInfo(subject)
    {
      var subjectName = subject.options[subject.selectedIndex].value;
      console.log(subjectName);
      //Show exam name and total mark fields if a valid subject has been selected
      if(subjectName != "")
      {
        document.getElementById("examNameDiv").style.display = "block";
        document.getElementById("totalMarkDiv").style.display = "block";
        document.getElementById("examSubmitButton").style.display = "block";
      }
      else
      {
        document.getElementById("examNameDiv").style.display = "none";
        document.getElementById("totalMarkDiv").style.display = "none";
        document.getElementById("examSubmitButton").style.display = "none";
      }
    }

    //Function to check if duplicate exam exists before submission
    function checkDuplicateExam(){
      var exmConnection = false;
      var secID = $("#sectionID").find(":selected").val();
      var subID = $("#subjectID").find(":selected").val();
      var examName = $("#examName").val();
      console.log(secID);
      console.log(subID);
      console.log(examName);
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

    //Function to get subjects once a section has been selected
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
              console.log(data.msg[0].name);
              console.log(data.msg.length);
              //Check if valid subject list returned
              if(data.msg.length > 0)
              {
                //Clear current list of subjects
                $("#subjectID").find('option').remove();
                var option = document.createElement("option");
                option.text = "";
                subjectListSelect.add(option);
                option = document.createElement("option");
                option.text = "All subjects";
                option.value = "all";
                subjectListSelect.add(option);
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
      }

    }
  </script>
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-12 blog-main">
        <h2>Enter Exam Information:</h2>
        <hr>
        <div class="row">
          <div class="col-sm-12 col-md-6">
            @if($section)
              <form method="POST" action="/exams/store" id="examForm">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="sectionID">Select Section :</label>
                  <select class="form-control" name="sectionID" id="sectionID" onchange="getSubjects(this)">
                    <option value=""></option>
                    <option value="all">All Sections</option>
                      @foreach($section as $id)
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
                <div class="form-group" id="subjectList" style="display:none">
                  <label for="subjectID">Select Subject :</label>
                  <select class="form-control" name="subjectID" id="subjectID" onchange="showExamInfo(this)">

                  </select>
                </div>
                <div class="form-group" id="examNameDiv" style="display:none">
                  <label for="Title">Exam Name</label>
                  <input type="text" class="form-control" id="examName" name="examName" placeholder="Enter Name Here" required>
                </div>
                <div class="form-group" id="totalMarkDiv" style="display:none">
                  <label for="Title">Total Exam Mark</label>
                  <input type="number" class="form-control" id="totalMark" name="totalMark" value="100" required>
                </div>
                <div class="form-group mt-3" id="formSubmit" style="display:none">
                  <button id="submit1" class="btn btn-twitter mt-2"></button>
                </div>
                @include('layouts.errors')
              </form>
              <div class="form-group mt-3" id="examSubmitButton" style="display:none">
                  <button id="submit" class="btn btn-twitter mt-2" onclick="checkDuplicateExam();">Create Exam</button>
                  <span style="color:red;display:none" id="duplicateErrorMsg">Exam already exists!</span>
                </div>
            @else
              {{ "No section is assigned." }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
