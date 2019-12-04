<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Subject;
use App\Section;
use Carbon\Carbon;
use \stdClass;
use App\teacherHasSection;

class ExamController extends Controller
{

    //Marks Module
    //...............................................................................
    public function createExam()
    {
        if (!(Auth::check())) {
            return redirect()->action('HomeController@index');
        }
        $sections = Section::get();
        $subjects = Subject::select('name', 'id')->get();
        return view('examination.create', compact('subjects', 'sections'));
    }

    public function editExam(Request $r)
    {
        // dd($r->all());
        //Do nothing if neither admin nor teacher
        if (!(Auth::check())) {
            if (!Auth::guard('teacher')->check()) {
                return "";
            }
        }
        //Get exam info using exam id and subjects and return to the edit exam page
        $examInfo = DB::table('exams')->where([
            ['id', request('examID')]
        ])->get();
        if ($examInfo[0]->quiz == 1) {
            if (Auth::guard('teacher')->check()) {
                $teacher_id = Auth::guard('teacher')->id();

                $teacher_sections = DB::table('teacher_has_sections')->where('teacher_id', $teacher_id)->pluck('section_id');

                $sections = Section::whereIn('id', $teacher_sections)->get();
                return view('examination.createQuiz', compact('sections', 'examInfo', 'teacher_id'));
            } else {
                $sections = Section::select('name', 'class', 'id')->get();
                return view('examination.createQuiz', compact('sections', 'examInfo'));
            }
        } else {
            $subjects = Subject::select('id', 'name')->get();
            return view('examination.create', compact('subjects', 'examInfo'));
        }
    }

    //Returns a list of sections based on teacher or admin
    public function getSections()
    {
        if (!(Auth::check())) {
            if (Auth::guard('teacher')->check()) {
                $teacher_id = Auth::guard('teacher')->id();
                if (!is_null(request("examId"))) {
                    $section_ids_teacher = DB::table('teacher_has_sections')->where('teacher_id', $teacher_id)->pluck('section_id');
                    $section_ids_marked = DB::table('marks')->where('exam_id', request("examId"))->groupBy('section_id')->pluck('section_id');
                    $section_ids = array_intersect($section_ids_teacher, $section_ids_marked);
                    $sections = Section::select('name', 'class', 'id')->whereIn('id', $section_ids)->get();
                }
            } else {
                return redirect()->action('HomeController@index');
            }
        } else {
            if (!is_null(request("examId"))) {
                $sectionIds = DB::table('marks')
                    ->where('exam_id', request("examId"))
                    ->groupBy('section_id')
                    ->pluck('section_id');
                $sections = Section::select('name', 'class', 'id')
                    ->whereIn('id', $sectionIds)
                    ->get();
            } else {
                $sections = Section::select('name', 'class', 'id')->get();
            }
        }
        return response()->json(['msg' => $sections], 200);
    }

    //Returns a list of subjects based on restrictions such as section or teacher
    public function getSubjects()
    {
        // return response()->json(['msg' => 'asdf'], 200); 
        if (!(Auth::check())) {
            if (Auth::guard('teacher')->check()) {
                $secID = request('sectionID');
                $teacher_id = Auth::guard('teacher')->id();
                $isClassTeacher = DB::table('teacher_has_sections')->where('teacher_id', $teacher_id)->where('section_id', $secID)->where('class_teacher', '1')->get();

                if (sizeof($isClassTeacher) > 0) {
                    $subject_ids = DB::table('section_has_subjects')->where("section_id", $secID)->pluck('subject_id');
                    $subjectNames = Subject::select('name', 'id')->whereIn('id', $subject_ids)->get();
                    return response()->json(['msg' => $subjectNames], 200);
                }

                if ($secID === "all") {
                    $subject_ids = DB::table('section_has_subjects')->pluck('subject_id');
                } else {
                    // $subject_ids = DB::table('section_has_subjects')->where('section_id', $secID)->pluck('subject_id');
                    $subject_ids_section = DB::table('section_has_subjects')->where('section_id', $secID)->pluck('subject_id');
                    $subject_ids_teacher = DB::table('teacher_has_subjects')->where('teacher_id', $teacher_id)->pluck('subject_id');
                    if (is_array($subject_ids_section) && is_array($subject_ids_teacher)) {
                        $subject_ids = array_intersect($subject_ids_teacher, $subject_ids_section);
                    } else if (is_array($subject_ids_section) && in_array($subject_ids_teacher, $subject_ids_section)) {
                        $subject_ids = $subject_ids_teacher;
                    } else if (is_array($subject_ids_teacher) && in_array($subject_ids_section, $subject_ids_teacher)) {
                        $subject_ids = $subject_ids_section;
                    } else if ($subject_ids_section == $subject_ids_teacher) {
                        $subject_ids = $subject_ids_section;
                    } else {
                        $subject_ids = [];
                    }
                }
                if (!is_null(request("examId"))) {
                    $subject_ids_filtered_teacher = DB::table('teacher_has_subjects')->whereIn('subject_id', $subject_ids)->where('teacher_id', $teacher_id)->pluck('subject_id')->toArray();
                    $subject_ids_marked = DB::table('marks')->where('exam_id', request("examId"))->groupBy('subject_id')->pluck('subject_id')->toArray();
                    $subject_ids = array_intersect($subject_ids_filtered_teacher, $subject_ids_marked);
                } else {
                    $subject_ids = DB::table('section_has_subjects')->whereIn('subject_id', $subject_ids)->pluck('subject_id');
                }
                $subjectNames = Subject::select('name', 'id')->whereIn('id', $subject_ids)->get();
            } else {
                return "先生ではありません";
            }
        } else {

            $secID = request('sectionID');
            if ($secID === "all") {
                if (!is_null(request("examId"))) {
                    $subject_ids = DB::table('marks')
                        ->where('exam_id', request("examId"))
                        ->groupBy('subject_id')
                        ->pluck('subject_id');

                    $subjectNames = Subject::select('name', 'id')
                        ->whereIn('id', $subject_ids)
                        ->get();
                } else {
                    $subjectNames = Subject::select('name', 'id')->get();
                }
            } else {
                if (!is_null(request("examId"))) {
                    $subject_ids_section = DB::table('section_has_subjects')->where('section_id', $secID)->pluck('subject_id')->toArray();
                    $subject_ids_marked = DB::table('marks')->where('exam_id', request("examId"))->groupBy('subject_id')->pluck('subject_id')->toArray();
                    $subject_ids = array_intersect($subject_ids_section, $subject_ids_marked);
                    $subjectNames = Subject::select('name', 'id')->whereIn('id', $subject_ids)->get();
                } else {
                    $subject_ids_section = DB::table('section_has_subjects')->where('section_id', $secID)->pluck('subject_id')->toArray();
                    $subjectNames = Subject::select('name', 'id')->whereIn('id', $subject_ids_section)->get();
                }
            }
        }
        return response()->json(['msg' => $subjectNames], 200);
    }


    public function storeExam(Request $r)

    {
        // dd($r->all());   
        if (!(Auth::check())) {
            if (Auth::guard('teacher')->check()) {

                $examID = request('examId');
                $ajaxDuplicateCheck = request('ajax');
                $sectionID = request('sectionID');
                $subjectID = request('subjectID');
                $topic = request('topic');
            } else {
                return redirect()->action('HomeController@index');
            }
        } else {
            $examID = request('examId');
            $ajaxDuplicateCheck = request('ajax');
            $sectionID = request('sectionID');
            $subjectID = request('subjectID');
            $topic = request('topic');
        }

        if ($sectionID === "all") {
            $sectionID = NULL;
            $sectionName = "";
            $className = "";
        } else {
            $sectionName = Section::select('name')->where('id', $sectionID)->get()[0]->name;
            $className = Section::select('class')->where('id', $sectionID)->get()[0]->class;
        }

        if ($subjectID === "all") {
            $subjectID = NULL;
            $subjectName = "";
        } else {
            $subjectName = Subject::select('name')->where('id', $subjectID)->get()[0]->name;
        }

        $examName = request('examName');
        $totalMark = request('totalMark');
        $examDate = request('examDate');
        $quiz = request('quiz');
        if (!isset($quiz)) {
            $quiz = 0;
        }

        if (isset($ajaxDuplicateCheck)) {
            $checkDuplicate = DB::table('exams')->where([
                ['name', $examName],
                ['section_id', $sectionID],
                ['subject_id', $subjectID],
                ['quiz_topic', $topic]
            ])->get();
            return response()->json(['msg' => $checkDuplicate], 200);
        } elseif (isset($examID)) {
            DB::table('exams')
                ->where('id', $examID)
                ->update([
                    'name' => $examName,
                    'max_grade' => $totalMark,
                    'date' => $examDate,
                    'subject_id' => $subjectID,
                    'section_id' => $sectionID,
                    'quiz' => $quiz
                ]);
            $successMsg = "Updated " . $examName . " " . $subjectName . " exam.";
            return redirect('/exams/listExams')->with('message', $successMsg);
        } else {
            if ($examName == "") {
                $successMsg = "Exam name cannot be empty";
                return redirect('/exams/editExam')->with('message', $successMsg);
            }
            $insertId = DB::table('exams')->insertGetId([
                'name' => $examName,
                'max_grade' => $totalMark,
                'date' => $examDate,
                'subject_id' => $subjectID,
                'section_id' => $sectionID,
                'quiz' => $quiz,
                'quiz_topic' => $topic
            ]);

            // DB::table('exam_dates')->insert(
            //     [
            //         'exam_id' => $insertId,
            //         'date' => $examDate,
            //         'subject_id' => $subjectID,
            //         'section_id' => $sectionID,

            //     ]
            // );




            if (!isset($quiz)) {
                $successMsg = "Created " . $examName . " for Subject: " . $subjectName . " exam.";
            } else {
                $successMsg = "Created Class test :" . $examName . " For (" . $topic . ") Subject: " . $subjectName . " for class: " . $className . ", section:" . $sectionName;
            }
            return redirect('/exams/listExams')->with('message', $successMsg);
        }
    }

    //Admin Exam List Creation
    //...............................................................................
    public function getExams()
    {
        $sec_id = request('sectionID');
        $sub_id = request('subjectID');
        //Admin Check
        if (!(Auth::check())) {
            if (Auth::guard('teacher')->check()) {
                $teacher_id = Auth::guard('teacher')->id();
                $exams = DB::select(
                    'SELECT
                                        id, name 
                                        FROM 
                                        exams 
                                        WHERE 
                                        (
                                            (subject_id=:sub_id OR subject_id is null) 
                                            AND 
                                            (section_id=:sec_id OR section_id is null)
                                        )
                                        AND
                                        (
                                            id not in (SELECT exam_id from marks where section_id=:sec_id1 group by exam_id)
                                            OR
                                            id not in (SELECT exam_id from marks where subject_id=:sub_id1 group by exam_id)
                                        )
                                        AND
                                        (
                                            (
                                                subject_id in (SELECT subject_id from teacher_has_subjects where teacher_id=:teach_id)
                                                OR
                                                subject_id is NULL
                                            )
                                            AND
                                            (
                                                section_id in (SELECT section_id from teacher_has_sections where teacher_id=:teach_id1)
                                                OR
                                                section_id is NULL
                                            )
                                        )',
                    [
                        'sub_id' => $sub_id,
                        'sec_id' => $sec_id,
                        'sub_id1' => $sub_id,
                        'sec_id1' => $sec_id,
                        'teach_id' => $teacher_id,
                        'teach_id1' => $teacher_id
                    ]
                );
            } else {
                return;
            }
        } else {
            $exams = DB::select(
                'SELECT
                                id, name 
                                FROM 
                                exams 
                                WHERE 
                                (
                                    (subject_id=:sub_id OR subject_id is null) 
                                    and 
                                    (section_id=:sec_id OR section_id is null)
                                )
                                and
                                (
                                    id not in (SELECT exam_id from marks where section_id=:sec_id1 group by exam_id)
                                    OR
                                    id not in (SELECT exam_id from marks where subject_id=:sub_id1 group by exam_id)
                                )',
                [
                    'sub_id' => $sub_id,
                    'sec_id' => $sec_id,
                    'sub_id1' => $sub_id,
                    'sec_id1' => $sec_id
                ]
            );
        }
        return response()->json(['msg' => $exams], 200);
    }

    //Admin Exam List Creation
    //...............................................................................
    public function deleteExam()
    {
        //Do nothing if neither admin nor teacher
        if (!(Auth::check())) {
            if (!Auth::guard('teacher')->check()) {
                return "";
            }
        }

        //Get id of exam to be deleted
        $examId = request('examId');
        $deletedExamInfo = DB::table('exams')->where('id', $examId)->get();
        if (is_null($deletedExamInfo[0]->subject_id)) {
            $subjectName = "";
        } else {
            $subjectName = Subject::select('name')->where('id', $deletedExamInfo[0]->subject_id)->get()[0]->name;
        }

        if (is_null($deletedExamInfo[0]->section_id)) {
            $sectionName = "";
            $className = "";
        } else {
            $sectionName = Section::select('name')->where('id', $deletedExamInfo[0]->section_id)->get()[0]->name;
            $className = Section::select('name')->where('id', $deletedExamInfo[0]->section_id)->get()[0]->class;
        }
        $successMsg = "Deleted " . $deletedExamInfo[0]->name . " " . $subjectName . " exam.";
        DB::table('exams')->where('id', $examId)->delete();
        return redirect()->action('ExamController@listExams')->with('message', $successMsg);
    }

    public function alterMark()
    {
        DB::table('marks')
            ->where('id', request('marksId'))
            ->update([
                'grade' => request('grade'),
                'student_remark' => request('remark')
            ]);

        return response()->json(['msg' => "yo"], 200);
    }

    public function editMarks(Request $r)
    {
        // dd($r->all());
        //Admin Check
        if (!(Auth::check())) {
            if (!Auth::guard('teacher')->check()) {
                return "";
            }
        }

        //Get marks array and insert row by row to the marks table

        $examID = request("examId");
        $sectionId = request("sectionId");


        $examInfo = DB::table("exams")->where("id", request("examId"))->get()[0];
        if (is_null($sectionId)) {
            $sectionId = $examInfo->section_id;
        } else {
            $examInfo->section_id =  $sectionId;
        }
        $subjectId = request("subjectId");
        if (is_null($subjectId)) {
            $subjectId = $examInfo->subject_id;
        } else {
            $examInfo->subject_id =  $subjectId;
        }

        $section = Section::select("name", "class", "id")->where("id", $sectionId)->get()[0];
        $subjectName = Subject::select("name")->where("id", $subjectId)->get()[0]->name;

        $student_ids = DB::table('marks')
            ->select('id', 'student_id', 'grade', 'student_remark')
            ->where('exam_id', $examID)
            ->where('section_id', $sectionId)
            ->where('subject_id', $subjectId)
            ->get();

        $students = [];
        foreach ($student_ids as $stId) {
            $student = DB::table('students')
                ->select('id', 'name', 'rollNumber')
                ->where('id', $stId->student_id)
                ->get()[0];
            $student->grade = $stId->grade;
            $student->remark = $stId->student_remark;
            $student->mark_id = $stId->id;
            $students[] = $student;
        }
        return view('examination.setMarksTable', compact('section', 'subjectName', 'students', 'examInfo'));
    }






    public function submitMarks(Request $r)
    {
        // dd($r->all());
        //Admin Check
        if (!(Auth::check())) {
            if (!Auth::guard('teacher')->check()) {
                return "";
            }
        }
        // dd($r->all());

        //Get marks array and insert row by row to the marks table
        $examId = request("examId");
        $examInfo = DB::table("exams")->where("id", request("examId"))->get()[0];
        $examName = request("examName");
        $class = request("class");
        $sectionID = request("sectionId");
        $subjectID = request("subjectId");
        $sectionName = request("section");
        $subjectName = request("subject");
        $marks = request("marks");

        foreach ($marks as $mark) {
            DB::table('marks')->insert([
                'grade' => $mark['grade'],
                'student_id' => $mark['studentId'],
                'student_remark' => $mark['remark'],
                'exam_id' => $examId,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'section_id' => $sectionID,
                'subject_id' => $subjectID
            ]);
        }

        $students = [];

        $studentIDs = DB::table('marks')->where('exam_id', $examId)->get();
        foreach ($studentIDs as $stId) {
            $student = DB::table('students')
                ->select('id', 'name', 'rollNumber')
                ->where('id', $stId->student_id)
                ->get()[0];
            $student->grade = $stId->grade;
            $student->remark = $stId->student_remark;
            $student->mark_id = $stId->id;
            $students[] = $student;
        }
        // dd($students);

        $section = [
            'id' => $sectionID,
            'name' => $sectionName,
            'class' => $class
        ];

        if (!Auth::check()) {
            return view('examination.setMarksTableTeacher', compact('section', 'students', 'examInfo', 'subjectName', 'subjectID'));
        } else {

            return view('examination.setMarksAdminTable', compact('section', 'students', 'examInfo', 'subjectName', 'subjectID'));
        }
    }

    public function createQuiz()
    {
        //Admin Check

        if (Auth::guard('teacher')->check()) {
            // echo "先生";
            $teacher_id = Auth::guard('teacher')->id();
            $section_ids = DB::table('teacher_has_sections')->where('teacher_id', $teacher_id)->pluck('section_id');
            $sections = Section::whereIn('id', $section_ids)->orderBy('class', 'asc')->get();
            return view('examination.createQuiz', compact('sections', 'teacher_id'));
        } else {
            // echo "あづみぬさま";
            $sections = DB::table('sections')->orderBy('class', 'asc')->get();
            return view('examination.createQuiz', compact('sections'));
            // return;   
        }
    }

    public function selectExam()
    {
        //Admin Check
        if (!(Auth::check())) {
            if (Auth::guard('teacher')->check()) {
                $teacher_id = Auth::guard('teacher')->id();                
                $section_ids = DB::table('teacher_has_sections')->where('teacher_id', $teacher_id)->pluck('section_id');
                $subject_ids_teacher = DB::table('teacher_has_subjects')->where('teacher_id', $teacher_id)->pluck('subject_id')->toArray();                
                $section_has_subjects = DB::table('section_has_subjects')->select('subject_id', 'section_id')->get()->toArray();
                $sections = Section::whereIn('id', $section_ids)->orderBy('class', 'asc')->get()->toArray();
                $quizzes = DB::table('exams')->whereIn('section_id', $section_ids)->where('quiz', 1)->get()->toArray();
                
                $globalExams = DB::table('exams')->where('section_id', null)->get()->toArray();

                $examList = [];
                foreach ($globalExams as $exam) {
                    foreach ($sections as $section) {
                        $tempExam = clone $exam;
                        $tempExam->section_id = $section["id"];
                        if ($tempExam->subject_id === null) {
                            foreach ($subject_ids_teacher as $Tsubject) {
                                foreach ($section_has_subjects as $Ssubject) {
                                    if ($Tsubject == $Ssubject->subject_id) {
                                        $tempExam->subject_id = $Tsubject;
                                        array_push($examList, clone $tempExam);
                                        break;
                                    }
                                }
                            }

                        } else {
                            // print_r($tempExam1);
                            array_push($examList, clone $tempExam);
                        }
                    }
                }


                $allExams = array_merge($examList, $quizzes);

                $marked = DB::table('marks')->whereIn('exam_id', array_column($allExams, "id"))->groupBy('exam_id')->pluck('exam_id')->toArray();

                $subjectDetails = DB::table('subjects')->whereIn('id', array_column($allExams, 'subject_id'))->get()->unique()->toArray();
                $sectionDetails = DB::table('sections')->whereIn('id', array_column($allExams, 'section_id'))->get()->unique()->toArray();
                // dd($sectionDetails);

                // dump($allExams);
                foreach ($allExams as $exam) {
                    $exam->marked = (in_array($exam->id, $marked) && in_array($exam->section_id,$marked)) ? true : false;
                    $subjectIndex = array_search($exam->subject_id, array_column($subjectDetails, 'id'));
                    $exam->subjectName = $subjectIndex !== false ? $subjectDetails[$subjectIndex]->name : null;


                    // dump(array_column($sectionDetails,'id'));
                    $sectionIndex = array_search($exam->section_id, array_column($sectionDetails, 'id'));

                    // dump($sectionIndex);
                    // dump($sectionDetails[$sectionIndex]->name);
                    $exam->sectionName = $sectionIndex !== false ? $sectionDetails[$sectionIndex]->name : null;
                    $exam->class = $sectionIndex !== false ? $sectionDetails[$sectionIndex]->class : null;
                    // dump($exam->sectionName);
                }
                // die();
                // // dd($allExams);
                // dd($allExams);
                // return;
                return view('examination.selectExamTeacher', compact('sections', 'teacher_id', 'allExams'));
            } else {
                return "";
            }
        } else {
            // dd($exams);
            $sections = DB::table('sections')->orderBy('class', 'asc')->get();
            return view('examination.selectExamAdmin', compact('sections'));
        }
    }

    public function listExams()
    {
        if (!(Auth::check())) {
            if (Auth::guard('teacher')->check()) {
                $teacher_id = Auth::guard('teacher')->id();
                $exams = DB::table('exams')
                    ->select('id', 'name', 'max_grade', 'date', 'subject_id', 'section_id', 'quiz')
                    ->whereIn('section_id', DB::table('teacher_has_sections')
                        ->where('teacher_id', $teacher_id)
                        ->pluck('section_id'))
                    ->whereIn('subject_id', DB::table('section_has_subjects')
                        ->pluck('subject_id'))
                    ->get()->toArray();
            } else {
                return redirect()->action('HomeController@index');
            }
        } else {
            $exams = DB::table('exams')->select('id', 'name', 'max_grade', 'date', 'subject_id', 'section_id', 'quiz')->get()->toArray();
        }

        $examList = [];
        foreach ($exams as $exam) {
            $object = new stdClass();
            $object->id = $exam->id;
            $object->name = $exam->name;
            $object->max_grade = $exam->max_grade;
            $object->date = $exam->date;
            $object->quiz = $exam->quiz;

            //Checking if exam can be deleted
            $delete = DB::table('marks')
                ->select('exam_id')
                ->where('exam_id', $exam->id)
                ->groupBy('exam_id')
                ->get()
                ->toArray();

            //Remove delete if exam has already been graded
            sizeof($delete) > 0 ? $object->delete = false : $object->delete = true;

            if (is_null($exam->section_id)) {
                $object->section = "All";
                $object->class = "All";
                $object->section_id = NULL;
            } else {
                $secInfo = Section::orderBy('class', 'asc')->get()[0];
                $object->section = Section::select("name")->where('id', $exam->section_id)->get()[0]->name;
                $object->class = Section::select("class")->where('id', $exam->section_id)->get()[0]->class;
                // $object->section = $secInfo->name;
                // $object->class = $secInfo->class;
                $object->section_id = $exam->section_id;
            }

            if (is_null($exam->subject_id)) {
                $object->subject = "All";
                $object->subject_id = NULL;
            } else {
                $object->subject = Subject::select("name")->where('id', $exam->subject_id)->get()[0]->name;
                $object->subject_id = $exam->subject_id;
            }
            $examList[] = $object;
        }
        // ksort($examList);
        // dd($examList);
        return view('examination.examList', compact('examList'));
    }


    //Populate list of students for grading
    public function getStudents(Request $r)
    {


        //Return to home screen if not teacher or admin
        if (!(Auth::check()) && !Auth::guard('teacher')->check()) {
            return redirect()->action('HomeController@index');
        }


        if (Auth::guard('teacher')->check()) {
            // dd($r->all());

            $examId = $r->examId;
            //Get the section id based on given exam id
            $examInfo = DB::table("exams")->where("id", $examId)->first();
            $subjectID = $r->subject_id;

            $subjectName = $r->subject_name;

            $section = [
                'name' => $r->section_name,
                'class' => $r->class,
                'id' => $r->section_id,
            ];

            $students = DB::table("students")
                ->select("id", "name", "rollNumber")
                ->whereIn(
                    "id",
                    DB::table("section_has_students")
                        ->where("section_id", $r->section_id)
                        ->pluck("student_id")
                )
                ->get();

            return view('examination.setMarksTableTeacher', compact('section', 'subjectID', 'subjectName', 'students', 'examInfo'));
        } elseif (Auth::check()) {
            // dd($r->all());


            $studentIds = DB::table('section_has_students')->where('section_id', $r->sectionID)->where('year', date("Y"))->pluck('student_id');
            $students = DB::table('students')->whereIn('id', $studentIds)->get();
            $sectionDetails = DB::table("sections")->where('id', $r->sectionID)->first();

            $subject = DB::table('subjects')->where('id', $r->subjectID)->first();
            $section = [
                'id' => $sectionDetails->id,
                'name' => $sectionDetails->name,
                'class' => $sectionDetails->class
            ];

            // dd($section);

            $examInfo = DB::table('exams')->where('id', $r->examId)->first();

            if (!empty($studentIds)) {
                return view('examination.setMarksAdminTable')
                    ->with('examInfo', $examInfo)
                    ->with('students', $students)
                    ->with('subjectID', $subject->id)
                    ->with('subjectName', $subject->name)
                    ->with('section', $section);
            } elseif (empty($students->id)) {
                return redirect()->back()->with('errMessage', 'No students in the section!');
            }
        }
    }



    //Teacher Exams List view
    public function teacherExams()
    {
        if (!Auth::guard('teacher')->check()) {
            return redirect()->action('HomeController@index');
        }
        $teacherID = Auth::guard('teacher')->id();
        // dd($teacherID);

        $teacherSections = DB::table('teacher_has_sections')->where('teacher_id', $teacherID)->get();

        return view('teacher.selectSection', compact('teacherSections'));
    }

    // //List of all exams for the section
    // public function viewExams(Request $req)
    // {
    //     // dd($req->all());

    //     $secGlobalExams = DB::table('exam_dates')->where('section_id', null)->get();
    //     $secQuiz = DB::dd($secGlobalExams);


    //     return view('teacher.teacherExams');
    // }

    //Marks Report Table
    public function marksReport($id)
    {
        $teacherId = Auth::guard('teacher')->user()->id;
        // dump($teacherId);
        $teacherSections = teacherHasSection::where('teacher_id', $teacherId)->pluck('section_id');
        // dump($teacherSections);

        $teacherStudents = DB::table('section_has_students')->whereIn('section_id', $teacherSections)->pluck('student_id');
        // dump($teacherStudents);


        $examInfo = DB::table('exams')->where('id', $id)->whereYear('date', date("Y"))->first();
        // dump($examInfo);

        $marks = DB::table('marks')->where('exam_id', $id)->whereIn('student_id', $teacherStudents)->whereYear('created_at', date("Y"))->groupBy('student_id')->distinct()->get();
        // dump($marks);
        // die();

        return view('marks.reportMarks', compact('marks', 'examInfo'));
    }
}
