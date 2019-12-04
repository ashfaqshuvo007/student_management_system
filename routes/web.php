<?php
use App\Http\Controllers\RemarksController;
use App\Http\Controllers\StudentController;

//route for the index/home page
Route::get('/', 'HomeController@index')->name('Home');

// handles the route for Dashboard after login
Route::get('/dashboard', 'DashboardController@show')->name('Dashboard');


//handles the route for user registration
//need to fix the view
Route::get('/TeacherRegister','RegistrationController@create')->name('Teacher Registration');
Route::post('/TeacherRegister','RegistrationController@store')->name('Teacher Registration Saved');

//handles the route for admin registration
// need to fix the view
Route::get('/UserRegister','AdminRegistrationController@create')->name('User Registration');
Route::post('/UserRegister','AdminRegistrationController@store')->name('User Registration Saved');


//handles the route for user login
Route::get('/TeacherLogin','TeacherSessionsController@create')->name('Teacher Login');
Route::post('/TeacherLogin','TeacherSessionsController@store')->name('Teacher Login');

/**========== Teacher NEW Routes ============================ */
Route::get('/teacher/viewAll','TeacherController@viewAllTeachers')->name('Teacher List');
Route::get('/teacher/profile/t_id={id}','TeacherController@viewSingleTeacher')->name('Teacher Profile');
Route::get('/teacher/update/t_id={id}','TeacherController@updateTeacherInfo')->name('Update Teacher Info');
Route::post('/teacher/updateTeacher/','TeacherController@updateInfo');

Route::get('/teacher/delete/t_id={id}','TeacherController@deleteTeacher');

/**========== Teacher NEW Routes ============================ */


//handles the route for admin login
Route::get('/admin-login','UserSessionsController@create')->name('Admin Login');
Route::post('/admin-login','UserSessionsController@store')->name('Logged in as Admin');


//handles the route for logout for both user and teacher
Route::get('/logout','TeacherSessionsController@destroy')->name('Succesfully Logged Out');


//handles the route for attendance

Route::get('/teacherAttendanceStartPage','AttendanceController@create')->name('Teacher\'s Attendance');
Route::post('/teacherAttendanceStart','AttendanceController@store')->name('Teacher\'s Login Saved');
Route::get('/teacherAttendanceEndPage','AttendanceController@createLogout')->name('Teacher\'s Logout Page');
// Route::post('/teacherAttendanceEnd','AttendanceController@store')->name('Teacher\'s Logout Save');
Route::post('/teacherAttendanceStart/logout','AttendanceController@logout')->name('Teacher\'s Logout Saved');


//handles the route for attendance list
Route::get('/attendance/show', 'AttendanceController@index')->name('Teacher\'s Attendance Summary');


//Route for creating section
Route::get('/section', 'SectionController@create')->name('Create a New Section');
Route::post('/section', 'SectionController@store')->name('New Section Created');
Route::get('/section/all', 'SectionController@showAll')->name('All Sections');

Route::get('/section/update/id={id}', 'SectionController@edit')->name('Edit Section');
Route::post('/section/update', 'SectionController@update');

Route::get('/section/delete/id={id}', 'SectionController@destroy');




 
//Route for creating new student
Route::get('/student', 'StudentController@create')->name('Enroll New Student');
Route::post('/student', 'StudentController@store')->name('New Student Enrolled');

//Route for showing all the students
Route::get('/student/showAllStudent', 'StudentController@showAllStudent')->name('Student List');
Route::get('/student/deleteStudent/id={id}', 'StudentController@deleteStudent')->name('Delete Student');

//in the list of students table
Route::post('/getStudent','StudentController@getSearchedStudent');
//To view/edit student Information.
Route::get('/student/update/id={id}', 'StudentController@showStudentData')->name('Update Student Info');
Route::post('/student/update/', 'StudentController@updateStudentData')->name('Update Student Info');

//Student Profiles
Route::get('/student/profile/id={id}', 'StudentController@showProfile')->name('Student Profile');
//Route::post('/students/profile', 'StudentController@postShowProfile')->name('Student Profile');

/**================ testing Student Guard =================*/
Route::prefix('studentView')->group(function () {
    Route::get('/profile', 'StudentViewController@viewProfile')->name('Student Profile');
});
/**================ testing Student Guard =================*/


/**=========== Student Profile Cascading Dropdown Routes ========= */

Route::get('/getSections/class={id}','StudentController@get_sections');
Route::get('/getStudents/section={id}','StudentController@get_section_students');
Route::post('/studentInfo','StudentController@studentInfo')->name('Student Profile');


/**=========== Student Profile Cascading Dropdown Routes ========= */

/**============== Remarks Section Routes ===================== */

Route::post('/storeRemarks','RemarksController@store');

Route::get('/remarks/edit/{id}','RemarksController@edit');
Route::post('/updateRemarks','RemarksController@update');
Route::get('/remarks/delete/{id}','RemarksController@destroy');

/**============== Remarks Section Routes ===================== */

/**============== Teacher Student List Routes =============*/
Route::get('/teacher/sectionSelect','TeacherController@sectionSelect')->name('Select Section');
Route::post('/teacher/studentList','TeacherController@showStudents')->name('Student List');
/**============== Teacher Student List Routes =============*/


//Route for creating a new subject
Route::get('/subject', 'SubjectController@create')->name('Manage Subjects'); 
Route::post('/subject', 'SubjectController@store')->name('New Subject Added');
Route::post('/deleteSubject', 'SubjectController@delete');


//Route for assigning a student into a section
Route::get('/assignStudent', 'SectionHasStudentController@create')->name('Add Student to Section');

//-------------------Searched Student Result ----------------------------------------//
Route::post('/getSearchedStudent', 'SectionHasStudentController@getSearchedStudent');
//-------------------Searched Student Result ----------------------------------------//

Route::post('/assignStudent', 'SectionHasStudentController@store')->name('Assign Student To section');
Route::get('/assignStudent/id={id}', 'SectionHasStudentController@singleAssignView')->name('Assign Student To section');
Route::post('/assignSingleStudent', 'SectionHasStudentController@singleAssign')->name('Assign Student To section');


//Route for assigning a teacher to a section
Route::get('/assignTeacher', 'TeacherHasSectionController@create')->name('Set Class Teacher');
Route::post('/assignTeacher', 'TeacherHasSectionController@store')->name('Teacher Added to Section Successfully');


//Route for adding sujbect to a section
Route::get('/assignSubjectToSection', 'SubjectController@assignSubjectToSectionRoute')->name('Add Subject to Section');
Route::post('/assignSubjectToSection', 'SubjectController@assignSubjectToSection');

//Route for adding sujbect to a teacher
Route::get('/assignSubjectToTeacher', 'SubjectController@assignSubjectToTeacherRoute')->name('Add Subject to Teacher');
Route::post('/assignSubjectToTeacher', 'SubjectController@assignSubjectToTeacher');
Route::post('/getTeacherSubjects', 'SubjectController@getTeacherSubjects');
  
//Route for giving attendance
Route::get('/studentAttendance', 'StudentAttendanceController@create')->name('Student Attendance');
Route::get('/studentAttendance/getStudents/s={id}', 'StudentAttendanceController@store')->name('Student Attendance');
Route::post('/studentAttendance/save', 'StudentAttendanceController@save');


//Route for student attendance history
Route::get('/studentAttendance/show', 'StudentAttendanceController@show')->name('Select History For Sections');
Route::post('/studentAttendance/viewHistory', 'StudentAttendanceController@viewHistory')->name('Student Attendance History');


//Route for restoring attendance
Route::get('/studentAttendance/checkStudentExists', 'StudentAttendanceController@checkStudentExists')->name('Update Student Information');
Route::post('/studentAttendance/postUpdateInfo', 'StudentAttendanceController@postUpdateInfo')->name('Submit Updated Information');


//Route for the bigTable of boys and girls
Route::get('/studentAttendance/getTable', 'StudentAttendanceController@getTable')->name('Attendance Analytics');
Route::post('/studentAttendance/postTable', 'StudentAttendanceController@postTable')->name('Attendance Analytics');

Route::post('/studentAttendance/postStudentInfoUpdate', 'StudentAttendanceController@postStudentInfoUpdate')->name('Post Student Info Update');

//Route for inventories of biscuits
Route::get('/intentories/create', 'InventoryController@create')->name('Add New to Inventory');
Route::post('/inventories/store', 'InventoryController@store')->name('Post Inventory Information');

//Route for showing all the students
Route::get('/teacher/showAllAttendance', 'TeacherController@showAllAttendance')->name('Teacher Attendance History');
Route::post('/teacher/showAllAttendance', 'TeacherController@postAllAttendance')->name('Teacher Attendance History');
Route::post('/teacher/updateAttendance', 'TeacherController@updateAllAttendance');
Route::get('/teacher/examsList', 'ExamController@teacherExams')->name('Select Section To view Exams');
// Route::post('/teacher/viewExams', 'ExamController@viewExams')->name('Exams List');

//Exam Stuff CRUD and Grading
Route::get('/exams/create', 'ExamController@createExam')->name('Create Exam');
Route::post('/exams/store', 'ExamController@storeExam');
Route::post('/marks/getSubjects', 'ExamController@getSubjects');
Route::get('/quiz/create', 'ExamController@createQuiz')->name('Create Class Test');; 
// Route::get('/exams/getExams', 'ExamController@getExams')->name('Exam List');
Route::post('/exams/getExamList', 'ExamController@getExams');
Route::post('/exams/editExam', 'ExamController@editExam');
Route::post('/exams/deleteExam', 'ExamController@deleteExam');
Route::post('/exams/gradeExam', 'ExamController@gradeExam')->name('Exam Marking');
Route::get('/exams/gradeQuiz', 'ExamController@gradeExam')->name('Class Test Marking');
Route::post('/exams/submitMarks', 'ExamController@submitMarks');
Route::get('/exams/marksReport/e={id}', 'ExamController@marksReport')->name('Marks report');
Route::get('/exams/select', 'ExamController@selectExam')->name('Select Exam to Submit Mark');
Route::post('/exams/getStudents', 'ExamController@getStudents')->name('Mark Students');
Route::get('/exams/listExams', 'ExamController@listExams')->name('Exam List'); 
// Route::get('/exams/getSections', 'ExamController@getSections')->name('Exam List');
Route::post('/exams/getSections', 'ExamController@getSections')->name('Exam List');
Route::post('/exams/editMarks', 'ExamController@editMarks')->name('Edit Marks');
// Route::get('/exams/editMarks/s_id={s_id}/e_id={e_id}', 'ExamController@editMarks');
Route::post('/exams/alterMark', 'ExamController@alterMark');
 
//.................
//Currently working
//.................


Route::get('/studentParser', 'StudentController@parse')->name('Enroll New Student');
Route::post('/studentParser', 'StudentController@parse')->name('New Student Enrolled');
// Route::get('/studentProfile/id', 'StudentController@showStudentProfile')->name('Student Profile');


Route::get('/sample_input', 'StudentController@sample')->name('Sample Download');

Route::post('/getSectionStudents','SectionHasStudentController@getSectionStudents');

//Teacher Excel Parser links
Route::get('/sample_input1', 'RegistrationController@sample')->name('Sample Download');

Route::get('/teacherParser', 'RegistrationController@parse')->name('Enroll New Student');
Route::post('/teacherParser', 'RegistrationController@parse')->name('New Student Enrolled');


//Student Promotion
Route::post('/getMarks', 'MarksController@getMarks');
Route::get('/promoteStudents', 'StudentController@promote')->name('Promote Students');
Route::post('/promotion', 'StudentController@changeSection')->name('Promote Students');

//Student Report Card
Route::post('/reportCard', 'StudentController@reportCard')->name('Report Card');




//Fallback route if no route matches
Route::Fallback(function(){
    return view('404');
}); 