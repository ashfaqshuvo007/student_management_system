<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Student;
use App\Section;
use App\sectionHasStudent;
use DB;
use function GuzzleHttp\json_encode;

class SectionHasStudentController extends Controller
{
  //Assign to section view
  public function create()
  {
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }
    $section = Section::orderBy('class', 'asc')->get();
    date_default_timezone_set('Asia/Dhaka');
    return view('sectionHasStudent.create', compact('section'));
  }

  // //A function that returns a list of students (studentList) with attributes (request('attributes')) based on an request('sectionID') section id
  // public function getSectionStudents(Request $r)
  // {
  //   // dd($r->all());
  //   if (!(Auth::check())) {
  //     if (!Auth::guard('teacher')->check()) {                       === === === ===
  //       return redirect()->action('HomeController@index');          ===NOT IN USE===
  //     }                                                             === === === === 
  //   }
  //   // return response()->json(request('sectionID'), 200); 
  //   if (request('sectionID') === null) {
  //     if (request('attributes') === null) {
  //       $studentList = DB::table('students')->get();
  //     } else {
  //       $studentList = Student::select(request('attributes'))->get();
  //     }
  //   } else {

  //     if (request('attributes') === null) {
  //       $studentList = Student::whereIn('id', sectionHasStudent::where('section_id', request('sectionID'))->pluck('student_id'))->get();
  //     } else {
  //       $studentList = Student::select(request('attributes'))->whereIn('id', sectionHasStudent::where('section_id', request('sectionID'))->pluck('student_id'))->get();
  //     }
  //   }
  //   return response()->json($studentList, 200);
  // }

  //--------- Modified this method ----------//
  public function store(Request $req)
  {

    $stdList = $req->students;

    foreach ($stdList as $data) {

      if (!empty($data)) {
          $secStudents[] = [
            'section_id'  => $req->sectionID,
            'student_id' => $data,
            'year' =>  date('Y')
          ];
        
      }
    }
    DB::table('section_has_students')
      ->insert($secStudents);


    // $query = ;

    return redirect('/assignStudent')->with('message', 'Student(s) added to section successfully! ');
  }


  //-------------------Finalized SEARCH SEUTDENTS -----------------------//
  public function getSearchedStudent(Request $req)
  {
    if ($req->ajax()) {
      $output = '';
      $query = $req->get('query');

      if ($query != '') {
        $students = DB::table('students')
          ->where('name', 'like', '%' . $query . '%')
          ->where('is_shown', 1)
          ->get();
      }
      $student_sections = [];

      $total_row = $students->count();
      if ($total_row > 0) {
        foreach ($students as $row) {
          $paisi = sectionHasStudent::where('student_id', $row->id)->whereYear('created_at', date("Y"))->pluck('section_id')->toArray();
          $sectionId = $paisi[0];
          $sectiondetails = DB::table('sections')->where('id', $sectionId)->get()->toArray();
          $student_sections = $sectiondetails[0]->name;
          // dd($student_sections);
          if (!$student_sections) {
            $output .= '
          <tr>
          <input type="hidden" value="' . $row->id . '">
           <td>' . $row->id . '</td>
           <td>' . $row->name . '</td>
           <td>Section : ' . $student_sections . '</td>
           <td class="text-center" onclick="return alert(\'Student already in another section!\')"><input type="checkbox" id="student" name="students[]" value="' . $row->id . '"></td>
          </tr>
          ';
          } else {
            $output .= '
          <tr>
          <input type="hidden" value="' . $row->id . '">
           <td>' . $row->id . '</td>
           <td>' . $row->name . '</td>
           <td>Section : ' . $student_sections . '</td>
           <td class="text-center"><input type="checkbox" id="student" name="students[]" value="' . $row->id . '"></td>
          </tr>
          ';
          }
        }
      } else {
        $output = '
       <tr>
        <td align="center" colspan="5">No students Found</td>
       </tr>
       ';
      }
      $students = array(
        'table_data'  => $output,
        'total_data'  => $total_row
      );


      return response()->json($students);
    }
  }


  //Assign Single Student View
  public function singleAssignView($student_id)
  {
    if (!(Auth::check())) {
      return redirect()->action('HomeController@index');
    }
    $studentInfo = Student::where('id', $student_id)->first();
    $sections = Section::all();
    return view('sectionHasStudent.singleAssignView')->with('studentInfo', $studentInfo)->with('section', $sections);
  }

  //Assign Single Student
  public function singleAssign(Request $request)
  {

    $this->validate($request, [
      'sectionID' => 'required',
    ]);

    $year = Date("Y");
    $student_id = sectionHasStudent::pluck('student_id');
    $studentInfo = Student::where('id', $request->student_id)->first();
    $sectionInfo = Section::where('id', $request->sectionID)->first();

    $insert = DB::table('section_has_students')->insert([
      'section_id' => $request->sectionID,
      'student_id' => $request->student_id,
      'year'  => $year
    ]);
    return redirect()->back()->with('message', $studentInfo->name . ' Assigned to Class: ' . $sectionInfo->class . ' Section: ' . $sectionInfo->name . ' successfully! ');
  }
}
