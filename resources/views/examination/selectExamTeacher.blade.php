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


  <div class="d-flex xsm-flex-col tb-flex-row flex-wrap panel100p">
  @php
    $formCount = 0;
    // dd($allExams);
  @endphp
  @foreach($allExams as $data)
 @php
       $formCount++;
 @endphp
    <form class="d-flex flex-col panel30 tb-panel40 xsm-panel100p xsm-margin-0 margin-1" method="POST" action="/exams/getStudents" id="examForm{{$formCount}}">
    {{ csrf_field() }}
    <div class="section_card panel100p" id="card" <?php if($data->marked === false){?> onclick="document.forms['examForm{{$formCount}}'].submit();" <?php }else {?> onclick="alert('Marks has been already  submitted')"<?php }?>> 
      <input type="hidden" name="examId" value="{{$data->id}}">
      <input type="hidden" name="section_id" value="{{ $data->section_id }}">
      {{-- Subject ID --}}
      <input type="hidden" name="subject_id" value="{{ $data->subject_id }}">
      <input type="hidden" name="subject_name" value="{{$data->subjectName}}">
      <input type="hidden" name="section_name" value="{{$data->sectionName}}">
      <input type="hidden" name="class" value="{{$data->class}}">
      <div class="d-flex flex-row panel25 tb-panel40 xsm-panel90 mt_1">
      <div class="d-flex flex-col flex-wrap panel100p borders_section pd_1 tb-pd_1" <?php if(($data->marked === true )){?> style="background: #ddd; box-shadow: 0px 5px #000;" <?php }?>>
        <div class="d-flex flex-row mt_1">
            <div class="pl_1 tb-pl_0 xsm-pl_1 tb-pl_0 tb-pl_1 tb-pl_0">
                <h4 class="bold ftclr">SUBJECT: {{ $data->subjectName }} </h4>
            </div>
        </div>
            <div class="d-flex flex-row mt_1">
                <div class="pl_1 tb-pl_0 xsm-pl_1 tb-pl_0 tb-pl_1 tb-pl_0">
                    <h4 class="normal ftclr">Total Marks: {{$data->max_grade}}</h4>
                </div>
            </div>

            <div class="d-flex flex-row mt_1">
              <div class="pl_1 tb-pl_0 xsm-pl_1 tb-pl_0 tb-pl_1 tb-pl_0">
                <?php 
                  if($data->class === 100){
                    $class = 'Preschool';
                  }else{
                    $class = $data->class;  
                  }
                ?>
                <h4 class="normal ftclr">CLASS: {{  $class }} </h4>
              </div>
            </div>
            
            <div class="d-flex flex-row mt_1">
                <div class="pl_1 tb-pl_0 xsm-pl_1 tb-pl_0 tb-pl_1 tb-pl_0">
                <h4 class="normal ftclr">Exam Name <?php if($data->quiz === 1) { ?>(Class Test)<?php }?> : <b>{{ $data->name}} </b></h4>
                </div>
            </div>
        </div>
      </div>
    </div>
  </form>
  @endforeach

@endsection
