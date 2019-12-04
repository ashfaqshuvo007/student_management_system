<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@extends('layouts.master2') 
@section('content')
<script type="text/javascript">
    //DOM Input Holders for editing marks
    var markInput;
    var remarkInput;
    //Array of objects to store previous grade and remark for student during editing
    var dataTable = [];
    window.onload = function() {
        //Setting AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Storing the input DOM elements
        markInput = '<input type="number" class="form-control inpt_tg h-100 txt_cntr" name="marks" id="mark" max="{{ $examInfo->max_grade }}" min="0">';
        remarkInput = '<input type="text" class="form-control h-100 inpt_tg txt_cntr" name="remarks" id="remark">';  

        if(window.location.href.indexOf("getStudents") > -1) { // This doesn't work, any suggestions? 
              document.getElementById("_actions").style.display="none"; 
              //console.log("ASADSASD");
        }
    };

    //Validating the fields to ensure at least one of the marks field has been populated before submitting marks
    function validateMarkSubmission()
    {
        var marks = $('#marksTable > tr > td > input');
        // console.log(marks);
        var validInput = false;
        for(i=0;i<marks.length;i++)
        {
            mark = $(marks[i]).val();
            if(mark != ""){
                validInput = true;
            }
        }       

        //Throw error if no mark input has been detected
        if(!validInput){
            document.getElementById("markNotGiven").style.visibility = "visible";
            // $("#markNotGiven").fadeOut(4000);
        }
        return validInput;
    }

    //Function that restores the previous values from the array and replaces the input fields to basic text
    //as well as removing the cancel button and adding the edit button
    function cancelEdit(cancelBtn){
        var submitBtn = $(cancelBtn).siblings()[0];
        $(cancelBtn).parent().siblings()[3].innerHTML = dataTable[submitBtn.value].grade;
        $(cancelBtn).parent().siblings()[4].innerHTML = dataTable[submitBtn.value].remark;
        dataTable[submitBtn.value] = [];
        cancelBtn.style.display = "none";
        submitBtn.innerHTML = '<img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit">';
        submitBtn.onclick = function(){ return editMark(submitBtn); };
    }

    //Function that stores the current text to the array and changes the text to input fields and adds the submit button
    //as well as adding the cancel button
    function editMark(editBtn){
        var $markTmp = $(markInput);
        var $remarkTmp = $(remarkInput);
        $markTmp.attr('value', $(editBtn).parent().siblings()[3].innerHTML);
        $remarkTmp.attr('value', $(editBtn).parent().siblings()[4].innerHTML);
        dataTable[editBtn.value] = {grade: $(editBtn).parent().siblings()[3].innerHTML, remark:$(editBtn).parent().siblings()[4].innerHTML};
        $(editBtn).parent().siblings()[3].innerHTML = $markTmp[0].outerHTML;
        $(editBtn).parent().siblings()[4].innerHTML = $remarkTmp[0].outerHTML;
        editBtn.innerHTML = '<img id="viewEditBtn" class="icnimg" src="/img/check-mark.png" alt="edit">';
        editBtn.onclick = function(){ return submitMark(editBtn); };
        $(editBtn).siblings()[0].style.display = "block";
        console.log(dataTable);
    }

    //Function that takes the values from the current input field and sends AJAX request to update the database
    //as well as removing the previous entry from the array and removes the cancel button and adds the edit button
    function submitMark(submitBtn){
        var connectionActive = false;
        var gradeNew = $(submitBtn).parent().siblings()[3].children[0].value;
        var remarkNew = $(submitBtn).parent().siblings()[4].children[0].value;
        // console.log(gradeNew);
        $.ajax({
            beforeSend: function(xhr)
            {
              connectionActive = true;
            },
            type:'POST',
            url: "/exams/alterMark",
            data: {marksId:submitBtn.value, grade: gradeNew, remark: remarkNew},
            success:function(data)
            {
                connectionActive = false;
                dataTable[submitBtn.value] = [];
                $(submitBtn).parent().siblings()[3].innerHTML = gradeNew;
                $(submitBtn).parent().siblings()[4].innerHTML = remarkNew;
                submitBtn.innerHTML = '<img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit">';
                submitBtn.onclick = function(){ return editMark(submitBtn); };
                $(submitBtn).siblings()[0].style.display = "none";
            }
        });
    }
</script>
 
@if(Session::has('message'))
<div class="successBox">
    <div class="d-flex flex-col flex-wrap center txt_cntr">
    <div id="ssbox" style="background: #81C784;color:white;
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
@php
    // dd($subjectID);
@endphp
<div class="d-flex center">
    <div class="d-flex panel90p bg-w">
        <form action="/exams/submitMarks" class="panel100p" method="POST" onsubmit="return validateMarkSubmission();">
            {{ csrf_field() }}
                <h5 class="d-flex flex-col pd_1"> 
                        @if(isset($examInfo))
                            <div class="text-green">
                                @if($examInfo->quiz == 1)
                                <strong>{{ ucfirst(trans($subjectName)) }} - {{ ucfirst(trans($examInfo->name)) }} [Class Test]</strong>
                                @else
                                <strong>{{ ucfirst(trans($subjectName)) }} - {{ ucfirst(trans($examInfo->name)) }}</strong>
                                @endif
                            </div>
                            @if(isset($section)) 
                                <div class="text-purple">
                                    <strong>Class: {{ $section['class']}}<br> Section: {{$section['name'] }}</strong>
                                </div>
                            @endif            
                            <div>
                                <strong>Date: {{ $examInfo->date }}</strong> 
                            </div>
                            <div>
                                <strong>Full Marks: {{ $examInfo->max_grade}}</strong> 
                            </div>
                        @endif
                </h5>
            <div style="overflow-x:auto;" class="d-flex flex-col pd_1">
                    <table class="table table-hover table-striped">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Student Roll</th>
                                <th>Mark/{{ $examInfo->max_grade }}</th>
                                <th>Remarks</th>
                                <th id="_actions">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-bordered" id="marksTable">
                            @php 
                             $count = 0;
                            @endphp
                            @if(isset($students)) 
                                @foreach($students as $student ) 
                                @php 
                                $count++;                             
                                @endphp
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->rollNumber }}</td>
                                    @if(array_key_exists("grade", $student))
                                    <td>{{ $student->grade }}</td>
                                    <td>{{ $student->remark }}</td>
                                    <td class="d-flex center">
                                        <button class="btn_submit" type="button" style="border:none; background:transparent!important;" value="{{ $student->mark_id }}" onclick="editMark(this);"><img class="icnimg" src="/img/edit.png" alt=""></button>

                                        <!-- <button type="button" class="btn_submit1" value="{{ $student->mark_id }}" onclick="editMark(this);"><img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit"></button> -->
                                        <button class="btn_submit" type="button" style="border:none; background:transparent!important; display:none" onclick="cancelEdit(this)"><img id="viewEditBtn" class="icnimg" src="/img/close.png" alt="close"></button>
                                    
                                    </td>                                                      
                                    @else
                                    <td>
                                        <input type="number" class="inpt_tg2 borderr" name="marks[{{ $count }}][grade]" id="mark{{ $count }}" max="{{ $examInfo->max_grade }}" min="0">    
                                    </td>
                                    <td>
                                        <input type="text" class="inpt_tg2 borderr" name="marks[{{ $count }}][remark]" id="remark{{ $count }}">
                                    </td>
                                    @endif 
                                </tr>
                                <input hidden type="text" value="{{ $student->id }}" name="marks[{{ $count }}][studentId]">
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <input hidden type="text" value="{{ $examInfo->id }}" name="examId">
                <input hidden type="text" value="{{ $subjectID }}" name="subjectId">
                <input hidden type="text" value="{{ $subjectName }}" name="subject">
                <input hidden type="text" value="{{ $examInfo->name }}" name="examName">
                <input hidden type="text" value="{{ $section['class'] }}" name="class">
                <input hidden type="text" value="{{ $section['name'] }}" name="section">
                <input hidden type="text" value="{{ $section['id']}}" name="sectionId">

                <div class="d-flex flex-col center mt_1 pd_1">
                    @if(!array_key_exists("grade", $students[0]))
                    <button class="btn_submit panel50p">Submit Marks</button>                                             
                    @endif
                    <div class="ml-md-2 mt-3 alert alert-danger py-2 pd_1" style="visibility:hidden; position:static" id="markNotGiven">No Marks Assigned</div>
            </div>
        </form>
    </div>
</div>
@endsection