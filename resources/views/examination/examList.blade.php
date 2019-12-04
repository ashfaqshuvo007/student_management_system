<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@extends('layouts.master2') 
@section('content')

<script type="text/javascript">
    var connectionActive = false;
    var checked = false;
    var teacherId = "";
    var section_persistent;
    var subject_persistent;
    window.onload = function() {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $("#modalCloseSpan").click(function() {
          document.getElementById("myModal").style.display = "none";
      })

        $('#getMarks').click(function() {
            document.getElementById("examId").value = this.value;
            if(document.getElementById("sectionList").length > 1){
                $('<input />').attr('type', 'hidden')
                .attr('name', "sectionId")
                .attr('value', $('#sectionList').find(":selected").val())
                .appendTo('#formy');
            }
            if(document.getElementById("subjectList").length > 1){
                $('<input />').attr('type', 'hidden')
                .attr('name', "subjectId")
                .attr('value', $('#subjectList').find(":selected").val())
                .appendTo('#formy');
            }

            document.getElementById("formy").submit();
        })
    }

    function showSections(row){
        document.getElementById("getMarks").value = row.value;        
        section_persistent = $(row).parent().parent().children()[2].innerHTML;
        subject_persistent = $(row).parent().parent().children()[3].innerHTML;
        //Call DB if sectionID is not null
        var xmcnct = false;
        if(section_persistent=="All"){
            subjectID = null;
            if(!xmcnct){
                $.ajax({
                    beforeSend: function(xhr)
                    {
                        xmcnct = true;
                    },
                    type:'POST',
                    url: "/exams/getSections",
                    data: {examId:row.value},
                    success:function(data)
                    {
                        xmcnct = false;
                        console.log(data);
                        // console.log(data.msg[0].name);
                        // console.log(data.msg.length);
                        //Check if valid subject list returned
                        if(data.msg.length > 0)
                        {
                            //Clear current list of subjects
                            $("#sectionList").find('option').remove();
                            var option = document.createElement("option");
                            option.text = "";
                            $("#sectionList").append(option);
                            for (i = 0; i < data.msg.length; i++) {
                                option = document.createElement("option");
                                option.text = `Class: ${data.msg[i].class} Section: ${data.msg[i].name}`;
                                option.value = data.msg[i].id;
                                $("#sectionList").append(option);
                            }
                            //Show the list
                            document.getElementById("sectionList").style.display = "block";
                            document.getElementById("myModal").style.display = "block";
                            document.getElementById("subjectList").style.display = "none";
                            document.getElementById("getMarks").style.display = "none";
                            if(subject_persistent != "All"){
                                $("#subjectList").find('option').remove();
                                option = document.createElement("option");
                                option.text = subject_persistent;
                                option.value = $(row).parent().parent().children()[6].value;
                                $("#subjectList").append(option);
                                document.getElementById("subjectList").style.display = "block";
                            }
                        }
                        else{
                            document.getElementById("sectionList").style.display = "none";
                            document.getElementById("getMarks").style.display = "none";
                        }
                    }
                });
            }
        }
        else if(subject_persistent=="All"){
            $("#sectionList").find('option').remove();
            option = document.createElement("option");
            option.text = `Class: ${$(row).parent().parent().children()[1].innerHTML}, Section: ${section_persistent}` ;
            option.value = $(row).parent().parent().children()[5].value;
            $("#sectionList").append(option);
            document.getElementById("subjectList").style.display = "block";
            document.getElementById("myModal").style.display = "block";
            document.getElementById("sectionList").style.display = "block";
            document.getElementById("getMarks").style.display = "none";
            var connectionActive = false;
            var subjectListSelect = document.getElementById("subjectList");
            $.ajax({
                beforeSend: function(xhr)
                {
                    connectionActive = true;
                },
                type:'POST',
                url: "/marks/getSubjects",
                data: {sectionID:"all", examId:row.value},
                success:function(data)
                {
                    connectionActive = false;
                    //Check if valid subject list returned
                    if(data.msg.length > 0){
                        //Clear current list of subjects
                        $("#subjectList").find('option').remove();
                        document.getElementById("getMarks").style.display = "none";
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
                    }
                    else{
                        $("#subjectList").find('option').remove();
                        document.getElementById("subjectList").style.display = "none";
                        document.getElementById("getMarks").style.display = "none";
                    }
                }
            });
            //document.getElementById("sectionList").style.display = "none";\
        }
        else{
            // console.log(row.value);
            $("#examId").val(row.value);
            console.log($("#examId").val());
            document.getElementById("formy").submit();
        }
    }

    //Function to show submit button once a section and subject has been selected
    function showSubmit(){
        if($('#subjectList').find(":selected").text() != ""){
            document.getElementById("getMarks").style.display = "block";
        }
        else{
            document.getElementById("getMarks").style.display = "none";
        }
    }

    //Function to get subjects once a section has been selected
    function getSubjects(section){
        //Get the section ID
        var sectionID = section.options[section.selectedIndex].value;
        var subjectListSelect = document.getElementById("subjectList");
        //document.getElementById("examList").style.display = "none";
        var connectionActive = false;
        //Call DB if sectionID is not null
        if (sectionID != ""){
            if(subject_persistent == "All"){
                $("#subjectList").find('option').remove();
                document.getElementById("getMarks").style.display = "none";
                if(!connectionActive){
                    $.ajax({
                        beforeSend: function(xhr)
                        {
                            connectionActive = true;
                        },
                        type:'POST',
                        url: "/marks/getSubjects",
                        data: {sectionID:sectionID, examId:document.getElementById("getMarks").value},
                        success:function(data)
                        {
                            connectionActive = false;
                            //Check if valid subject list returned
                            if(data.msg.length > 0){
                                //Clear current list of subjects
                                
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
                            }
                            else{
                                $("#subjectList").find('option').remove();
                                document.getElementById("subjectList").style.display = "none";
                                document.getElementById("getMarks").style.display = "none";
                            }
                        }
                    });
                }
            }
            else{
                document.getElementById("getMarks").style.display = "block";
            }   
        }
        
        else{
            document.getElementById("getMarks").style.display = "none";
        }
        // }
    }
</script>


<style>


    /* The Modal (background) */
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
    background-color: rgb(250,251,252); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    
    }

    /* Modal Content */
    .modal-content {
    background-color: rgb(250,251,252);
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius:12px;
    }

    /* The Close Button */
    .close {
    color: #aaaaaa;
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
</style>



<form id="formy" action="/exams/editMarks" method="POST">
  {{ csrf_field() }}
  <input type="hidden" id="examId" name="examId" value="-1">
</form>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">


    <span id="modalCloseSpan" class="close">&times;</span>
    <h5 class="ftclr mb_1">Select Section and Subject to edit marks</h5>
    <!-- <select class="inpt_tg pd_1" name="sectionList" id="sectionList" onchange="getSubjects(this)>
    </select> -->
    <label for="" class="mt_2">SELECT SECTION</label>
    <select style="margin-bottom:1rem;" class="inpt_tg mt_1 pd_1 back-w" name="sectionList" id="sectionList" onchange="getSubjects(this)">
        
    </select>

    <label for="" class="mt_1">SELECT SUBJECT</label>
    <select class="inpt_tg mt_1 pd_1 back-w" name="subjectList" id="subjectList" onchange="showSubmit()" style="display:none">
    
    </select>

    <button id="getMarks" class="btn_submit mt_1 panel100p mb_1">Get Marks</button>



  </div>

</div>








<!-- *************************** EXAM List Table *************************** -->
@if(session()->has('message'))
<div class="successBox">
<div class="d-flex flex-col flex-wrap">
<div style="background: #81C784;
color: white;
border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">{!! session()->get('message') !!}
</div> 
</div>
</div>
<br><br>

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
<br><br>
@endif

<div class="d-flex flex-row flex-wrap center">
       
       
        <div class="panel80p d-flex flex-col listTable mb_1 item_center xsm-panel100 tb-panel100p">


            <div style="overflow-x: auto;" class="panel100p bg-w d-flex flex-col flex-wrap item_center dflex_row_spaceBetween nobdrad"> 
                <table class="panel100p">
                <thead>
                   
                        <th>EXAM NAME</th>
                        <th>CLASS</th>
                        <th>SECTION</th>
                        <th>SUBJECT</th>
                        <th>DATE</th>
                        <th>ACTION</th>

                   
                </thead>
                    @if(isset($examList))
                      <tbody  id="examlist_table">
                      @foreach($examList as $key=>$examName)
                            <tr>

                    @if($examName->quiz == 1)
                    <td>{{ $examName->name }} [Class Test]</td>
                    @else
                    <td>{{ $examName->name }}</td>
                    @endif
                    <td>{{ $examName->class }}</td>
                    <td>{{ $examName->section }}</td>
                    <td>{{ $examName->subject }}</td>
                    <td>{{ $examName->date }}</td>
                    <input type="hidden" value="{{ $examName->section_id }}" name="section_id" id="sectionID{{ $key }}">
                    <input type="hidden" value="{{ $examName->subject_id }}" name="subject_id" id="subjectID{{ $key }}">

                            
                            <td class="d-flex flex-row center">
                                @if($examName->delete)
                                <form action="/exams/editExam" method="POST">
                                {{ csrf_field() }}
                                
                                <button type="submit" class="btn_submit1" value="{{ $examName->id }}" name="examID"><img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit"></button>
                                </form>
                                <form class="mx-1" action="/exams/deleteExam" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn_submit1" value="{{ $examName->id }}" name="examId"><img class="icnimg" src="/img/delete.png" alt="delete"></button>
                                </form>
                                @else
                                <button class="btn_submit1" value="{{ $examName->id }}" name="examId" id="editMark{{ $key }}" onClick="showSections(this);"><img id="viewProfileBtn" class="icnimg" src="/img/eye.png" alt="eye"></button>
                                @endif
                                   
                                </form>
                            </td>

                          </tr>
                        @endforeach
                      </tbody>
                    @endif
                </table>
        </div>    
        
    


   
</div>









@endsection
