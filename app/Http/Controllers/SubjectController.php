<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Subject;
use DB;
use App\Teacher;

class SubjectController extends Controller
{

    public function create()
    {
        if (!(Auth::check())) {
            return redirect()->action('HomeController@index');
        }
        $subjects = Subject::all();
        foreach ($subjects as $subject) {
            $sec_subjects = DB::table('section_has_subjects')
                ->where('subject_id', $subject->id)
                ->get();
            $teach_subjects = DB::table('teacher_has_subjects')
                ->where('subject_id', $subject->id)
                ->get();
            if (sizeof($sec_subjects) > 0 || sizeof($teach_subjects) > 0) {
                $subject->delete = false;
            } else {
                $subject->delete = true;
            }
        }
        return view('subject.create',  compact('subjects'));
    }
 
    public function delete()
    {
        $name = Subject::where('id', request('subject_id'))->select('name')->get()[0]->name;
        Subject::where('id', request('subject_id'))->delete();
        return redirect()->back()->with('message', "Successfully deleted Subject: " . $name);
    }

    public function store(Request $request)
    { 
        $request->validate([
            'subjectName' => 'required|min:3',
            
        ]);
        $duplicate = Subject::where('name', request('subjectName'))->get();
        if (sizeof($duplicate) > 0) {
            return Redirect::back()->withErrors(["Subject: " . request('subjectName') . ", already exists!"]);
        } else {
            $subject = Subject::create([
                'name' => request('subjectName')
            ]);
            return redirect()->back()->with('success', "Successfully added Subject: " . request('subjectName'));
        }
    }

    //Route to assign subject to section page
    public function assignSubjectToSectionRoute()
    {
        $subjects = Subject::select('name', 'id')->get();
        $sections = DB::table('sections')->select('name', 'id', 'class')->orderBy('class','asc')->get();
        return view('subject.assign',  compact('subjects', 'sections'));
    }

    public function assignSubjectToSection(Request $request)
    {
        $valid_data = $request->validate([
                            'sectionID' => 'required',
                            'subjectID' => 'required',
                        ]);
        $subject_present = DB::table('section_has_subjects')->where('section_id',request('sectionID'))->where('subject_id',request('subjectID'))->first();
        // dd($subject_present);
        
        if(empty($subject_present)){
            DB::table('section_has_subjects')->insert([
                'section_id' => request('sectionID'),
                'subject_id' => request('subjectID'),
            ]);

            $subjectName = DB::table('subjects')->select('name')->where('id', request('subjectID'))->get()[0]->name;
            $sectionName = DB::table('sections')->select('name', 'class')->where('id', request('sectionID'))->get()[0];
            if ($sectionName->name == "N/A") {
                return redirect('/assignSubjectToSection')->with('message', "Successfully assigned $subjectName to Class: $sectionName->class");
            } elseif ($sectionName->class == "100") {
                return redirect('/assignSubjectToSection')->with('message', "Successfully assigned $subjectName to Preschool");
            } else {
                return redirect('/assignSubjectToSection')->with('message', "Successfully assigned $subjectName to Class: $sectionName->class, Section: $sectionName->name");
            }
        }else{
            return redirect('/assignSubjectToSection')->with('errMessage', "Subject already exists in the section!  ");

        }
        
    }

    //Route to assign subject to section page
    public function assignSubjectToTeacherRoute()
    {
        $subjects = Subject::select('name', 'id')->get();
        $teachers = DB::table('teachers')->select('firstName', 'id', 'lastName')->get();
        return view('subject.assignToTeacher',  compact('subjects', 'teachers'));

    }

    //Get valid subject for teacher based on their section
    public function getTeacherSubjects()  
    {
        // var_dump(request('teacherID'));
 
        $teacherId = request('teacherID');
        $teacher_sections = DB::table('teacher_has_sections')->where('teacher_id',$teacherId)->pluck('section_id');
        $teacher_section_subjects = (DB::table('section_has_subjects')->whereIn('section_id',$teacher_sections)->distinct()->pluck('subject_id'))->toArray();
       
        $subjectIds = (DB::table('teacher_has_subjects')->where('teacher_id','=',$teacherId)->pluck('subject_id'))->toArray();

     $unwanted = array_unique(array_merge((array)$teacher_section_subjects,(array) $subjectIds));
    // dd($unwanted);

        return response()->json(['unwanted_ids' => $unwanted]);
                
       
    }

    public function assignSubjectToTeacher(Request $req)
    {
        $req->validate([
            'sectionID' => 'required',
            'subject_id' => 'required'
        ]);
        $teacher_name = DB::table('teachers')->where('id','=',$req->sectionID)->first();
        
        foreach ($req->subject_id as $s_id) {
            DB::table('teacher_has_subjects')->insert([
                'teacher_id' => $req->sectionID,
                'subject_id' => $s_id
            ]);

            $subject_names[] = Subject::where('id', '=', $s_id)->pluck('name');
        }

       
        return redirect()->back()->with('message', "Successfully assigned ". count($subject_names)." Subject(s) to: ". $teacher_name->firstName ." ".$teacher_name->lastName );
    }
}
