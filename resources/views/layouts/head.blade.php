<!-- navbar -->
<div id="navbar" class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">

    


    @if(Auth::check() || Auth::guard('teacher')->check()) 
<div class="d-flex flex-col center" > 
    @if(!Auth::guard('teacher')->check())
    <span class="hamburger" onclick="openNav()">&#9776;</span>
    @endif
</div>

    <div id="myNav" class="overlay d-flex flex-row">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        
        <div style="width: 10%" class="xsm-panel20p"></div>
        
         
<div class="overlay-content d-flex flex-col mt_1">
            
    <div class="panel100p mt_125pp hide_tab">
    <form class="d-flex" action="">
    <input style="background:white;" class="inpt_tg panel50pi" type="text" id="Search" onkeyup="myFunction()" placeholder="Search.." name="search">

    </form>
    </div>
            <!-- SAERCH WORK -->

<!-- menu content  tb-flex-row-->
<div class=" d-flex flex-col mt_1 cont">

<div id="scroll-menu">



<div id="menu_down1">
        <!-- 1st label -->
        <div class="d-flex flex-row target heading" onclick="openMenu1()">
        <h4 class="normal">Student</h4>
        </div>
        
        <!-- 1st row -->
        
        <div class="d-flex flex-row flex-wrap dflex_row_start panel100p startinmods mli_1 tb-panel100p">
        <a href="/studentAttendance">
        <div class="d-flex flex-col mdiv pd_1 target">
        <div>
        <img class="imagebox" src="/img/st/takeattendance.png" alt="takeattendance">
        </div>
        
        <div class="d-flex flex-row center ">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
            Take Attendance
        </h5>
        </div>
        </div>
        </a>
        
        <a href="/student/showAllStudent">
        
        <div class="d-flex flex-col mdiv pd_1 target ">
        <div>
        <img class="imagebox" src="/img/st/view all students.png" alt="view all students">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        view all students
        </h5>
        </div>
        </div>
        
        </a>
        
        <a href="/promoteStudents">
        <div class="d-flex flex-col mdiv pd_1 target">
        <div>
        <img class="imagebox" src="/img/st/promote.png" alt="promote">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Promote Student
        </h5>
        </div>
        </div>
        
        </a>
        
        <a href="/assignStudent">
        <div class="d-flex flex-col mdiv pd_1 target">
        <div>
        <img class="imagebox" src="/img/st/assigntosection.png" alt="assigntosection">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
            Student to Section
        </h5>
        </div>
        </div>
        </a>
        
        
        <a href="/student">
        <div class="d-flex flex-col mdiv pd_1 target">
        <div>
        <img class="imagebox" src="/img/st/addnewst.png" alt="addnewst">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Add New Student
        </h5>
        </div>
        </div>
        
        </a>
        
        
        
        
        </div>
        </div>
</div>

<div id="menu_down2">
    
        <!-- 2nd label -->
        <div class="d-flex flex-row target heading" onclick="openMenu2()">
        <h4 class="normal white-space-nowrap">Class Tests And Exams</h4>
        </div>
        
        <!-- 2nd row -->
        
        <div class="d-flex flex-row flex-wrap dflex_row_start panel100p startinmods mli_1 tb-panel100p">
        <a href="/exams/create">
        <div class="d-flex flex-col mdiv1 pd_1 target">
        <div>
        <img class="imagebox" src="/img/quiz&exams/createexam.png" alt="createexam">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Create  Exam
        </h5>
        </div>
        </div>
        </a>
        
        <a href="/quiz/create">
        
        <div class="d-flex flex-col mdiv1 pd_1 target">
        <div>
        <img class="imagebox" src="/img/quiz&exams/createquiz.png" alt="classtest">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Create  Class Test
        </h5>
        </div>
        </div>
        
        </a>
        
        <a href="/exams/listExams">
        <div class="d-flex flex-col mdiv1 pd_1 target">
        <div>
        <img id="spImgbox2" src="/img/quiz&exams/editexamorquiz.png" alt="editexamorquiz">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Edit Exam Or Class Test
        </h5>
        </div>
        </div>
        
        </a>
        
        <a href="/exams/select">
        <div class="d-flex flex-col mdiv1 pd_1 target">
        <div>
        <img id="spImgbox3" src="/img/quiz&exams/submitmarks.png" alt="submitmarks">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Submit Marks
        </h5>
        </div>
        </div>
        </a>
        
        
        
        
        </div>
        
        
        
        
        
</div>        

<div id="menu_down3">
  
        
        <!-- 3rd label -->
        <div class="d-flex flex-row target heading" onclick="openMenu3()">
        <h4 class="normal">School</h4>
        </div>
        
        <!-- 3rd row -->
        
        <div class="d-flex flex-row flex-wrap dflex_row_start panel100p startinmods mli_1 tb-panel100p">
        
        <a href="/section">
        <div class="d-flex flex-col mdiv2 pd_1 target">
        <div>
        <img class="imagebox" src="/img/school/createsection.png" alt="createsection">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Create Section
        </h5>
        </div>
        </div>
        </a>


        <a href="/section/all">
            <div class="d-flex flex-col mdiv2 pd_1 target">
            <div>
                    <i id="miconftsize" class="material-icons">
                            list
                            </i>
            </div>
            
            <div class="d-flex flex-row center">
            <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
            All Sections
            </h5>
            </div>
            </div>
            </a>





        
        <a href="/subject">
        
        <div class="d-flex flex-col mdiv2 pd_1 target">
        <div>
        <img class="imagebox" src="/img/school/createsubject.png" alt="createsubject">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Create Subject
        </h5>
        </div>
        </div>
        
        </a>
        
        <a href="/assignSubjectToSection">
        <div class="d-flex flex-col mdiv2 pd_1 target">
        <div>
        <img id="spImgbox2" src="/img/school/addsubtosec.png" alt="addsubtosec">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Add Subject To Section
        </h5>
        </div>
        </div>
        
        </a>
        
        <a href="/assignSubjectToTeacher">
        <div class="d-flex flex-col mdiv2 pd_1 target">
        <div>
        <img id="spImgbox2" src="/img/school/setsubtoteach.png" alt="setsubtoteach">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Set Subject To Teacher
        </h5>
        </div>
        </div>
        </a>
        
        
        <a href="/TeacherRegister">
        <div class="d-flex flex-col mdiv2 pd_1 target">
        <div>
        <img id="spImgbox4" src="/img/school/addnewt.png" alt="addnewt">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        Add New Teacher
        </h5>
        </div>
        </div>
        
        </a>

        {{-- View All Teachers  --}}
        
        <a href="/teacher/viewAll">
            <div class="d-flex flex-col mdiv2 pd_1 target">
            <div>
            <img id="spImgbox4" src="/img/st/view all students.png" alt="addnewt">
            </div>
            
            <div class="d-flex flex-row center">
            <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
            View All Teachers
            </h5>
            </div>
            </div>
            
            </a>
        
        
        <a href="/assignTeacher">
        <div class="d-flex flex-col mdiv2 pd_1 target">
        <div>
        <img class="imagebox" src="/img/school/setsubtoteach.png" alt="setsubtoteach">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 100%; ;" class="smh5">
        {{-- Set Class teacher --}}
        Assign Teacher to Section
        </h5>
        </div>
        </div>
        </a>
        
        
        
        </div>
        
        
        
        
        
        
</div>        
        
<div id="menu_down4">
    
        <!-- 4rd label -->
        <div class="d-flex flex-row target heading" onclick="openMenu4()">
        <h4 class="normal white-space-nowrap">History And Analytics</h4>
        </div>
        
        <!-- 4rd row -->
        
        <div class="d-flex flex-row flex-wrap dflex_row_start panel100p startinmods mli_1 tb-panel100p">
        <a href="/studentAttendance/show">
        <div class="d-flex flex-col mdiv3 pd_1 target">
        <div>
        <img id="spImgbox" src="/img/hisandanalytics/statth.png" alt="statth">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 60%; ;" class="smh5">
        Student Attendance History
        </h5>
        </div>
        </div>
        </a>
        
        <a href="/studentAttendance/getTable">
        
        <div class="d-flex flex-col mdiv3 pd_1 target">
        <div>
        <img id="spImgbox5" src="/img/hisandanalytics/stattan.png" alt="stattan">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 60%; ;" class="smh5">
        Student Attendance Analytics
        </h5>
        </div>
        </div>
        
        </a>
        
        
        <a href="/teacher/showAllAttendance">
        <div class="d-flex flex-col mdiv3 pd_1 target">
        <div>
        <img id="spImgbox" src="/img/hisandanalytics/tatt.png" alt="tatt">
        </div>
        
        <div class="d-flex flex-row center">
        <h5 style="margin: 0; padding: 0; font-weight: 400;width: 60%; ;" class="smh5">
        Teacher Attendance History
        </h5>
        </div>
        </div>
        </a>
        
        
        
        
        </div>
        
        
        
</div> 



<!-- menu content end -->
</div>

        
        </div>
        
        
</div>
    
    @endif


    <div style="width:30%;" class="d-flex flex-col center flex-wrap">
    <div class="left_navbar_half d-flex flex-row flex-wrap dflex_row_start">
            <h5 class="blue_text user_slc"><strong>{{Request::route()->getName()}}</strong></h5> 
      
        </div>
    </div>
    <div class="navbar_halves d-flex flex-row flex-wrap dflex_row_space_evenly">
        <div class="panel50p d-flex flex-row flex-wrap dflex_row_end xsm-panel80p">
            <ul class="d-flex flex-row flex-wrap dflex_row_space_evenly content_center lstyle">
            <a href="/">
                <li class="svg"><svg class="fillicon micon" viewBox="0 0 306.773 306.773">
                        <g>
                            <path
                                d="M302.93,149.794c5.561-6.116,5.024-15.49-1.199-20.932L164.63,8.898
                                    c-6.223-5.442-16.2-5.328-22.292,0.257L4.771,135.258c-6.092,5.585-6.391,14.947-0.662,20.902l3.449,3.592
                                    c5.722,5.955,14.971,6.665,20.645,1.581l10.281-9.207v134.792c0,8.27,6.701,14.965,14.965,14.965h53.624
                                    c8.264,0,14.965-6.695,14.965-14.965v-94.3h68.398v94.3c-0.119,8.264,5.794,14.959,14.058,14.959h56.828
                                    c8.264,0,14.965-6.695,14.965-14.965V154.024c0,0,2.84,2.488,6.343,5.567c3.497,3.073,10.842,0.609,16.403-5.513L302.93,149.794z" />
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                    </svg>
                </li>
            </a>
              

                <li class="svg">
                @if (Auth::check() || Auth::guard('teacher')->check())
                <a href="/logout">
                <svg class="fillicon micon" viewBox="0 0 475.085 475.085">
                        <g>
                            <g>
                                <path d="M237.545,255.816c9.899,0,18.468-3.609,25.696-10.848c7.23-7.229,10.854-15.799,10.854-25.694V36.547
                c0-9.9-3.62-18.464-10.854-25.693C256.014,3.617,247.444,0,237.545,0c-9.9,0-18.464,3.621-25.697,10.854
                c-7.233,7.229-10.85,15.797-10.85,25.693v182.728c0,9.895,3.617,18.464,10.85,25.694
                C219.081,252.207,227.648,255.816,237.545,255.816z" />
                                <path
                                    d="M433.836,157.887c-15.325-30.642-36.878-56.339-64.666-77.084c-7.994-6.09-17.035-8.47-27.123-7.139
                c-10.089,1.333-18.083,6.091-23.983,14.273c-6.091,7.993-8.418,16.986-6.994,26.979c1.423,9.998,6.139,18.037,14.133,24.128
                c18.645,14.084,33.072,31.312,43.25,51.678c10.184,20.364,15.27,42.065,15.27,65.091c0,19.801-3.854,38.688-11.561,56.678
                c-7.706,17.987-18.13,33.544-31.265,46.679c-13.135,13.131-28.688,23.551-46.678,31.261c-17.987,7.71-36.878,11.57-56.673,11.57
                c-19.792,0-38.684-3.86-56.671-11.57c-17.989-7.71-33.547-18.13-46.682-31.261c-13.129-13.135-23.551-28.691-31.261-46.679
                c-7.708-17.99-11.563-36.877-11.563-56.678c0-23.026,5.092-44.724,15.274-65.091c10.183-20.364,24.601-37.591,43.253-51.678
                c7.994-6.095,12.703-14.133,14.133-24.128c1.427-9.989-0.903-18.986-6.995-26.979c-5.901-8.182-13.844-12.941-23.839-14.273
                c-9.994-1.332-19.085,1.049-27.268,7.139c-27.792,20.745-49.344,46.442-64.669,77.084c-15.324,30.646-22.983,63.288-22.983,97.927
                c0,29.697,5.806,58.054,17.415,85.082c11.613,27.028,27.218,50.34,46.826,69.948c19.602,19.603,42.919,35.215,69.949,46.815
                c27.028,11.615,55.388,17.426,85.08,17.426c29.693,0,58.052-5.811,85.081-17.426c27.031-11.604,50.347-27.213,69.952-46.815
                c19.602-19.602,35.207-42.92,46.818-69.948s17.412-55.392,17.412-85.082C456.809,221.174,449.16,188.532,433.836,157.887z" />
                            </g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                    </svg>
                    </a>
                  @endif
                </li>
            </ul>
        </div>
    </div>
</div>
