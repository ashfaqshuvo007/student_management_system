@extends('layouts.master2')

@section('content')
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

@php 
//Error check for no attendance (divided by 0)
($presentNumber + $absentNumber) === 0 ? $attendancePercent = 0 : $attendancePercent = $presentNumber*100/($presentNumber + $absentNumber);
//Show a maximum of seven days of attendance history
sizeof($sevenDayAttendance) > 7 ? $attendanceCount = 7 : $attendanceCount =  sizeof($sevenDayAttendance);
//Convert to JS object
$a = json_encode($sub_grades);
@endphp

<script type="text/javascript">


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



var grades_info;
var cgpaGraph;
var graphs;
var gradeChart;
var activeLocalSubject;
// Get line graph
// Data is the coordinate for each point, label is the label for the graph, everything else changes the appearance of the graph, random randomizes all of the colors
function getGraph({data=[{x:0,y:10}], label = "label", rgbo_background = [0,0,0,1], pointBorderWidth = 3, rgbo_border = [0,0,0,1], lineTension = 0, rgbo_point = [0,0,0,1], rgbo_pointBorder = [0,0,0,1], pointRadius = 3, pointHoverRadius = 5, random = false}){
//Using random to randomize all RGB and Opacity values
if (random){
backgroundColor = 'rgba( ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.random().toString() +')';

borderColor = ['rgba( ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.random().toString().toString() +')'];

pointBackgroundColor = 'rgba( ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.random().toString().toString() +')';

pointBorderColor = 'rgba( ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.floor(Math.random() * 256).toString() + ', ' + Math.random().toString().toString() +')';
}else{
backgroundColor = 'rgba( ' + rgbo_background[0].toString() + ', ' + rgbo_background[1].toString() + ', ' + rgbo_background[2].toString() + ', ' + rgbo_background[3].toString() +')';

borderColor = ['rgba( ' + rgbo_border[0].toString() + ', ' + rgbo_border[1].toString() + ', ' + rgbo_border[2].toString() + ', ' + rgbo_border[3].toString() +')'];

pointBackgroundColor = 'rgba( ' + rgbo_point[0].toString() + ', ' + rgbo_point[1].toString() + ', ' + rgbo_point[2].toString() + ', ' + rgbo_point[3].toString() +')';

pointBorderColor = 'rgba( ' + rgbo_pointBorder[0].toString() + ', ' + rgbo_pointBorder[1].toString() + ', ' + rgbo_pointBorder[2].toString() + ', ' + rgbo_pointBorder[3].toString() +')';
}
//Creating a graph object to return
var graph = { 
data: data,
backgroundColor: backgroundColor,
pointBorderWidth: pointBorderWidth,
borderColor: borderColor,
label: label,
lineTension: lineTension,
pointBackgroundColor: pointBackgroundColor,
pointBorderColor: pointBorderColor,
pointRadius: pointRadius,
pointHoverRadius: pointHoverRadius
};
return graph;
}

//Function to show the graph for a single subject
function subjectGraph(chkbx){
if(chkbx.checked){
$(chkbx).parent().siblings().children('input').prop('checked', false);
var subject = $(chkbx).siblings('label').text();
// console.log(grades_info[subject]);
activeLocalSubject = chkbx; 
graphs = []; 
labels = [];
var subjects = [subject];
var exam_names = ["0"];
var global_grades = [{x:0, y:0}];
x_axis = 0;
//Iterate over exams
for (let [key1, value1] of Object.entries(grades_info[subject])) {
// console.log(subject, key1, value1);
global_grades.push({x:x_axis,y:value1.grade});
x_axis = x_axis + 1;
//Only populate if not present in array
if(!exam_names.includes(key1)){
exam_names.push(key1);
}
}
//Add graph to graphs array using getGraph function
graphs.push(getGraph({data:global_grades, label: subjects, random: true}));
}
else{
graphs = [];
exam_names = [];
}
gradeChart.data.labels = exam_names;
gradeChart.data.datasets = graphs; 
gradeChart.update();

}

//Function to switch between attendance % trend and current year attendance for student
function attendanceSwith(chkbx){            
if(chkbx.checked){
$("#attendanceChart").show();
$("#attendanceTrendChart").hide();
}else{
$("#attendanceChart").hide();
$("#attendanceTrendChart").show();
}
}


//Function to switch between different exam formats to show in graph (Global and Local)
function globalGraph(chkbx){
// console.log(chkbx.checked);
//If global switched on then generate graphs only for global exams
if(chkbx.checked){
$(chkbx).parent().siblings().hide();
$(chkbx).parent().siblings().children('input').prop('checked', false);
graphs = [];
labels = [];
var subjects = [];
var exam_names = ["0"];
var global_grades = [{x:0, y:0}];
// console.log(grades_info);
//Iterate over subjects
for (let [key0, value0] of Object.entries(grades_info)) {
global_grades = [{x:0, y:0}];
subjects = [];
x_axis = 0;
//Iterate over exams
for (let [key1, value1] of Object.entries(grades_info[key0])) {
// console.log(key0, key1, value1);
//If exam is global, populate graph structures (graphs, subjects, exam_names) with necessary values
if(value1.global){
global_grades.push({x:x_axis,y:value1.grade});
x_axis = x_axis + 1;
//Only populate if not present in array
if(!exam_names.includes(key1)){
exam_names.push(key1);
}
if(!subjects.includes(key0)){
subjects.push(key0);
}
}
}
//Add graph to graphs array using getGraph function
graphs.push(getGraph({data:global_grades, label: subjects, random: true}));
}
}

else{
$(chkbx).parent().siblings().show();
graphs = [];
exam_names = [];
}

//Add new chart data
gradeChart.data.labels = exam_names;
gradeChart.data.datasets = graphs;
gradeChart.update();
}   

window.onload = function() {
//Getting the graph DOM object reference for attendance pie chart
var ctxAttendance = document.getElementById("attendanceChart");
var ctxAttendanceTrend = document.getElementById("attendanceTrendChart");
//Creating attendance pie chart with presentNumber and absentNumber indicating the attendance records for the student
var attendanceChart = new Chart(ctxAttendance, {
type: 'doughnut',
data: {
datasets: [{ data: [{{$presentNumber}},{{$absentNumber}}],
backgroundColor: ['rgb(255,193,7)', 'rgba(0, 0, 0, 0.1)'] }],
// These labels appear in the legend and in the tooltips when hovering different arcs
labels: ['Total Present', 'Total Absent']
},
options: {
responsive: true,     
elements: {
arc: {
borderWidth: 0
}
},
title: {
display: true,
position: 'bottom',
fontSize: 14,
text: 'Attendance: ' + {{number_format((float)$attendancePercent, 2, '.', '')}} + '%'
},
rotation: 1 * Math.PI,
circumference: 1 * Math.PI
}
});


var attendance_trend = <?php echo json_encode($yearlyAttendanceAvg);?>;
var yearly_att_avg = [];
var years = [];
var avg_att = 0;
console.log(attendance_trend);
x_axis = 0;
//Iterate over exams
for (let [key1, value1] of Object.entries(attendance_trend)) {
console.log(key1, value1);
years.push(key1);
yearly_att_avg.push({x:x_axis,y:value1});
avg_att = avg_att + value1;
}

avg_att = (avg_att/Object.keys(attendance_trend).length).toFixed(2);

var attendanceTrendChart = new Chart(ctxAttendanceTrend, {
type: 'line',
data: {
datasets: [getGraph({data:yearly_att_avg, label: ["Attendance"], random: true})],
// These labels appear in the legend and in the tooltips when hovering different arcs
labels: years
},
options: {
responsive: true,    
elements: {
arc: {
borderWidth: 0
}
},
title: {
display: true,
position: 'bottom',
fontSize: 14,
text: 'Attendance: ' + avg_att + '%'
}
}
});
grades_info = <?php echo $a;?>;
cgpaGraph = document.getElementById("cgpaGraph");
var avg_grade = 0;
var exam_num = 0;
//Iterate over subjects
for (let [key0, value0] of Object.entries(grades_info)) {
//Iterate over exams
for (let [key1, value1] of Object.entries(grades_info[key0])) {
avg_grade = avg_grade + value1.grade;
exam_num = exam_num + 1;
}
}

avg_grade = Number.parseFloat(avg_grade / exam_num).toFixed(1);
gradeChart = new Chart(cgpaGraph, {
type: 'line',
data: {
datasets: [],
// These labels appear in the legend and in the tooltips when hovering different arcs
labels: []
},
options: {
responsive: true,    
elements: {
arc: {
borderWidth: 0
}
},
title: {
display: true,
position: 'bottom',
fontSize: 14,
text: 'Grade Percentile: ' + avg_grade + '%'
}
}
});
console.log(gradeChart.data);
globalGraph(document.getElementById('globalGrades'));
}  

</script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>-->
<script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/fontawesome-v5.6.3.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

<!--<script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1"
 crossorigin="anonymous"></script>-->


<div class = " d-flex flex-col ">

        <div class = "d-flex">            
            <form action="/studentInfo" method="POST" class="d-flex panel100p dflex_row_space_evenly xsm-flex-col item_center" >
                {{ csrf_field() }}
                <div class = "panel20p xsm-panel90p">
                    <label for="">Class</label>
                    <select name="class_id" id="class_select">
                        <option value="">Select Class</option>
                        @php
                            if(Auth::check()){
                                $i=100;
                                echo"<option value=".$i.">Preschool</option>";
                                for($i=1; $i<=10; $i++){
                                    echo"<option value=".$i.">Class ".$i."</option>";
                                }
                            }elseif(Auth::guard('teacher')->check()){
                                $teacher_id = Auth::guard('teacher')->user()->id;
                                // var_dump($teacher_id);die();
                                $classes = DB::table('teacher_has_sections')->where('teacher_id',$teacher_id)->pluck('section_id');
                                $sectionInfo = DB::table('sections')->whereIn('id',$classes)->get();
                                
                                for($i=0; $i< count($sectionInfo); $i++){
                                    echo"<option value=".$sectionInfo[$i]->class.">Class ".$sectionInfo[$i]->class."</option>";
                                }
                                

                            }
                            
                        @endphp
                    </select>
                </div>

                
                <div class = "panel20p xsm-panel90p">
                    <label for="">Section</label>
                    <select name="section_id" id="section_select">
                        
                    </select>
                </div>




                <div class = "panel20p xsm-panel90p">
                    <label for="">Student</label>
                    <select name="student_id" id="student_id">
                    </select>
                </div>

                <div class = " d-flex flex-col item_center dflex_row_end panel20p xsm-panel90p xsm-mt_1 mt_1">
                    <button style="" class = " btn_submit panel100p">SUBMIT</button>
                </div>


            </form>
        </div>



        <div class = "d-flex flex-row dflex_row_space_evenly panel100p mt_3 xsm-flex-col">
            
            <div class = "d-flex flex-col bg-w panel40p pd_2 xsm-panel80p">

                <div class = "d-flex"><h2 class="blue_text">{{$studentInfo->name}}</h2></div>

                <div class = "d-flex panel80p dflex_row_spaceBetween mt_1 xsm-panel100p tb-panel100p">
                    <div class = "right-border"><h5 class = "ftclr normal">ID : {{$studentInfo->id}}</h5></div>
                    @if ($classInfo->class == 100)
                    <div class = "right-border"><h5 class = "ftclr normal">Class : Preschool</h5></div>
                    @else
                    <div class = "right-border"><h5 class = "ftclr normal">Class : {{$classInfo->class}}</h5></div>
                    @endif
                    
                    <div class = "right-border"><h5 class = "ftclr normal">Section : {{$classInfo->name}}</h5></div>
                    <div><h4 class = "ftclr normal">Roll: {{$studentInfo->rollNumber}}</h4></div>
                </div>

                <div class = "d-flex center"> 
                    <div class = "">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>

                <div class="d-flex dflex_row_space_evenly">
                    <div>
                        <h3 class="ftclr txt_cntr">65%</h3>
                        <label for="">Avg. attendance since</label>
                    </div>
                    <div>
                        <h3 class="ftclr txt_cntr">6%</h3>
                        <label for="">Current Class improvement</label>
                    </div>
                </div>

                <div style="">
                    <form action="/reportCard" method="POST" class="pd_1">
                        {{ csrf_field() }}
                            <input type="text" class="form-control" id="stId" name="stId" value={{ $studentInfo->id }} hidden>
                        <button class="btn_submit panel50p btn-primary xsm-panel100p tb-panel50p" type="submit">Report Card</button>
                    </form>
                </div>


            </div>

            <div class="d-flex flex-col bg-w panel40p pd_2 xsm-panel80p xsm-mt_1">
                <div class = "d-flex panel100p" >
                    <h4 class = "ftclr">Attendance Overview</h4><span class = "ftclr d-flex center item_center ml_1" >for</span> 
                </div>
                    
                <div style = "height:100%;" class = "d-flex center item_center" >
                    <canvas id="attendanceTrendChart"></canvas>
                </div>   

            </div>

        </div>

        


        <div class="d-flex center panel100p mt_3">
    
            <div class = "d-flex bg-w panel90p xsm-flex-col xsm-panel98p">    
                <div class = "panel50p pd_2 d-flex item_center xsm-panel80p">
                    <canvas id="cgpaGraph"></canvas>
                </div>

                <div class="d-flex flex-col pd_2 panel50p xsm-panel80p">
                    <div class="d-flex flex-col">
                                
                                <label for="" class = " mt_1 ">Select Below To Filter Marks Analytics</label>
                                <label for="" class = " mt_1 ">Subjects</label>

                                <div class="panel80p pd_2 d-flex dflex_row_spaceBetween" id="subjectList">
                                    <div>
                                        <input type="checkbox" name="checkbox1" onclick="globalGraph(this);" checked id="globalGrades">
                                        <label for="checkbox1">Global</label>
                                    </div>
                                        @foreach($sub_grades as $subject=>$exam)
                                        <div style="display:none">
                                            <input type="checkbox" name="checkbox1" onclick="subjectGraph(this);">
                                            <label for="checkbox1" >{{$subject}}</label>
                                        </div>
                                        @endforeach
                                </div>

                                
                    </div>

                    <div> 
                        <div class = " background-grey ">
                            <div class = "d-flex panel100p pd_1">
                                <span class = "ftclr" >Average marks based on</span> <h5 class =" ftclr">Current filters</h5>
                            </div>


                            <div class="d-flex">
                                <div class="d-flex flex-col">
                                    <div><h5></h5></div>
                                </div>

                                <div class="d-flex-flex-col center item_center pd_2">
                                    <div><h5 class="normal">Mark</h5></div>
                                    <div><p>Average Marks For Selection</p></div>
                                </div>

                            </div>


                        </div>
                    </div>

                </div>

            </div>

            
        </div>




        <div class = "d-flex pd_1 center mt_3">
            <div class = "d-flex dflex_row_space_evenly bg-w panel90p pd_2 tb-flex-col tb-center xsm-flex-col">

                <div class="d-flex flex-col panel40p tb-panel90p xsm-panel100p">
                    <div><h3 class="ftclr">Student Remarks</h3></div>

                        <form action="/storeRemarks" method="post" class="panel100p" >
                            {{ csrf_field() }}
                                <?php if(Session::has('userEmail')){  $email = Session::get('userEmail');?>
                                    <input type="hidden" name="userEmail" value="{{ $email }}">
                                <?php }?>
                                    <input type="hidden" name="student_id" value="{{ $studentInfo->id }}">

                        
                                <label for="ramark_title"><b>Remark title</b></label>
                                <input type="text" id="remark_title" list="json-datalist" name="remark_title" placeholder="e.g. health issue"  class="inpt_tg mt_1">
                                <datalist id="json-datalist" >
                                @foreach($remark_titles as $value)
                                <option value="{{ $value->remark_title }}" class="form-control"></option>
                                @endforeach
                                </datalist>
                        
                                <div class="d-flex flex-col">
                                    <label for="remark"><b>Remarks:</b></label>
                                    <textarea name="remark_body" rows="5" class="inpt_tg mt_1"></textarea>
                                </div>

                            <button class="btn_submit btn-primary mt_1 panel50p" type="submit">Add remarks</button>
                        </form>
                    



                </div>


                <div style = " overflow-x : auto; overflow-y : auto; " class = "panel50p d-flex tb-panel100p tb-mt_1 xsm-panel100p xsm-mt_1" >

                    <table class="panel100p">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Remark By</td>
                                <td>Title</td>
                                <td>Section</td>
                                <td>Action</td>
                            </tr>
                        </thead>
            
                        <tbody>

                            <?php 

                            $std_remarks = DB::table('remarks')->where('student_id',$studentInfo->id)->get();
                            ?>       
                                @if(isset($std_remarks) && $std_remarks != "")
                                @foreach($std_remarks as $v_r)
                            <tr>
                                <td>{{ date("F j, Y",strtotime($v_r->created_at )) }}</td>
                                <td>{{$v_r->sender_name }} <br><h6><b>{{ $v_r->role }}</b></h6></td>
                                <td>{{$v_r->remark_title}}</td> 
                                <td>{{$v_r->remarks}}</td>
                                <td>
                                @if(Auth::check() || Auth::guard('teacher')->check())
                                @if($v_r->sender_email == Session::get('userEmail') || Auth::check())
                                <ul class="d-flex flex-row center dflex_row_spacearound pd_0 lstyle">

                                <li ><a href="{{ URL::to('/remarks/edit/'.$v_r->id)}}"><img class="icnimg" src="/img/edit.png" alt="edit"></a></li>
                                <li><a href="{{ URL::to('/remarks/delete/'.$v_r->id)}}" onclick="return confirm('Are You Sure You Want To Delete ?')"><img class="icnimg" src="/img/delete.png" alt="delete" ></a></li>
                                </ul>
                                @endif
                                @endif

                                </td>
                            </tr>
                                @endforeach
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
<script>

    //Cascading dropdown problem solve in profile top
     $(function () {
         //Taking the three dropdown into variables
        var classId = $('select[name="class_id"]'),
            section = $('select[name="section_id"]'),
            student = $('select[name="student_id"]');

            //Initially section,student dropdown is disabled
            section.attr('disabled','disabled');
            student.attr('disabled','disabled');

            // When a class is selected
            classId.change(function(){
                var class_id = $(this).val();

                if(class_id){
                    section.attr('disabled','disabled');
                    student.attr('disabled','disabled');
                    
                    //Call to DB when class is selected
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url:'/getSections/class='+class_id,
                        success: function(data){
                            if(data.length > 0 ){
                                var s = '<option value="">Select Section</option>';
                            //looping through each row and concat to Select tag
                            $.each (data, function(i,item){
                                s+= '<option value="'+ data[i].id +'">'+ data[i].name + '</option>';
                            }) 
                            section.removeAttr('disabled');
                            section.html(s);
                            }else{
                                alert("No Section Found");
                            }
                            
                        },
                        error:function(){
                            console.log("No data recieved!");
                        }
                    });
                }
            })

            //When section is selected 
            section.change(function () {
                var section_id = $(this).val();

                if(section_id){
                console.log("Section: "+section_id);
                student.attr('disabled','disabled');
                //Call to DB when class & section both is selected
                     $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url:'/getStudents/section='+section_id,
                        success: function(data){
                            // console.log(data);

                            //Only when data recieved from DB
                            if(data.length > 0){
                                var s = '<option value="">Select Student</option>';
                                //looping through each row and concat to Select tag
                                $.each (data, function(i,item){
                                    s+= '<option value="'+ data[i].id +'">'+ data[i].name + '</option>';
                                }) 
                                student.removeAttr('disabled');
                                student.html(s);
                            }else{
                                alert("No Students Found");
                            }
                           
                        },
                        error:function(){
                            console.log("No data recieved!");
                        }
                    });

                }

            })



    })


</script>



@endsection