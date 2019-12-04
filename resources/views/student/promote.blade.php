<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('js/ajax_scripts.js') }}"></script>
    <script type="text/javascript">
        function noSection(){
            $('.table').remove();
            $('#promoteDiv').hide();
        }

        function promoteStudents(){
            var nextSectionId = $('#nextSectionID').find(':selected').val();
            console.log(nextSectionId);
            if(nextSectionId != undefined){
                var promoteStudentIds = [];
                $('tr').each(function() {
                    if($(this).children()[4] != undefined){
                        if($(this).children()[4].childNodes[0].tagName == 'INPUT'){
                            console.log($(this).children()[4]);
                            if($(this).children()[4].childNodes[0].checked){
                                promoteStudentIds.push($(this).children()[0].innerHTML);
                            }
                        }
                    }
                });
            }
            console.log(promoteStudentIds);
            $('<input type="hidden">').attr({
                name: 'student_ids',
                value: promoteStudentIds
            }).appendTo('#promoteForm'); 
            $('<input type="hidden">').attr({
                name: 'section',
                value: nextSectionId
            }).appendTo('#promoteForm');
            document.getElementById('promoteForm').submit();
        }

        //A function that gets a student list and generates a table based on a template
        function table_controller(student_list){
            
            //Table headers
            var rows = ['ID', 'Name', 'Roll Number', 'Final Exam Mark', 'Promote'];
            //Get list of student ids
            let st_ids = student_list.map(a => a.id);
            //Get marks for the the list of student ids
            
            
            //Check if the array is empty or not 
            if (st_ids === undefined || st_ids.length == 0) {
                // array empty or does not exist
                alert("No students in the section");
                $('.table').remove();
                
            }
            getMarks({return_attributes: ['grade', 'student_id'], filter_attribute: {student_id: st_ids}, ret_func:function(grades){
                
                //Assign grade to student object (Table rows)
                for (let [key, value] of Object.entries(student_list)){
                    console.log(key, value);
                    for (let [key1, value1] of Object.entries(grades)){
                        if(value1.student_id == value.id){
                            student_list[key].Marks = value1.grade;
                            if(value1.grade != null){
                                //Assign checkbox to the student rows
                                student_list[key].promote = '<input type="checkbox" required>';
                            }else{
                                student_list[key].promote = 'Not possible to promote yet';

                            }
                        }
                    }
                }
                //Remove all previously generated tables
                $('.table').remove();

                //Generate table
                var table = generateTable({rows: student_list, header: rows, table_class: "table table-hover table-striped panel100p", table_id: "student_table",th_class: "thead-inverse", tb_class: "table-bordered"});
                //Show table
                $('#sectionID').after(table);
                var sections = <?php echo json_encode($classInfo)?>;
                var selected_index = sections.findIndex(function(section){
                    return section.id == $('#sectionID').find(':selected').val();
                })
                
                $('.promote_section').remove();
                console.log(sections);
                if(selected_index == -1){
                    $('#nextSectionID').hide();
                }else{
                    console.log(sections[selected_index].class);
                    for(i=0;i<sections.length;i++){
                        if(sections[i].class > sections[selected_index].class && sections[i].class!=100){
                            if(sections[i].name != 'N/A'){
                                var option = '<option class="promote_section" value="' + sections[i].id + '">Class: ' +  sections[i].class + ', Section: ' + sections[i].name + '</option>';
                            }else{
                                var option = '<option class="promote_section" value="' + sections[i].id + '">Class: ' +  sections[i].class + '</option>';
                            }
                            $('#nextSectionID').append(option);
                        }
                    }
                    $('#promoteDiv').show();
                }
            }})    
                 
        }
    </script>
</head>
@extends('layouts.master2')
@section('content')

    @if(session()->has('message'))
        <div class="successBox">
            <div class="d-flex flex-col flex-wrap center txt_cntr" style="height:40px; position :absolute; top:5%; left:40%; align-items:center;">
                <div id="ssbox" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1"><h5> {!! session()->get('message') !!}</h5></div> 
            </div>
        </div>
    @endif
    @if(session()->has('errMessage'))
        <div class="errorBox">
            <div class="d-flex flex-col flex-wrap center txt_cntr" style="height:40px; position :absolute; top:5%; left:40%; align-items:center;">
                <div id="errbox" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1"><h5>{!! session()->get('errMessage') !!}</h5></div> 
            </div>
        </div>
    @endif
    




    

<div class="d-flex flex-col margin-1 item_center xsm-margin-0"> 

<div style="overflow-x: auto;" class="d-flex flex-col center panel80p xsm-panel93p bg-w pd_1 nobdrad">
<div><h2 class="bold ftclr">Select Section:</h2></div>

<select class="mt_1 mb_1" name="sectionID" id="sectionID" onchange='this.value!="" ? getSectionStudents({section: this, return_attributes: ["id","name","rollNumber"], ret_func: table_controller}) : noSection();' required>
    <option value=""></option>
    @foreach($classInfo as $section)
        @if($section->name !== 'N/A')
            <option value="{{ $section->id }}">{{ 'Class: ' . $section->class . ', Section: ' . ucfirst(trans($section->name)) }}</option>
        @else
            <option value="{{ $section->id }}">{{ 'Class: ' . $section->class }}</option>
        @endif
    @endforeach
</select>


<div id='promoteDiv' style='display:none' class="mt_1">
    Promote To: 
    <select class="mt_1" name="next_class" id="nextSectionID" required></select>
    <button style="width:100%;" class="btn_submit mt_1" id='promoteStudentBtn' onclick='promoteStudents();'>Promote</button>
    <form id='promoteForm' action="/promotion" method="post">{{ csrf_field() }}</form>
</div>

</div>

</div>


















@endsection