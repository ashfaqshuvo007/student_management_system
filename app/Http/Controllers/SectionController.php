<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Section;
use redirect;
use DB;

class SectionController extends Controller
{
    // Create section View
    public function create()
    {
        if (!(Auth::check())) {
            return redirect()->action('HomeController@index');
        }
        return view('section.createSection');
    }

    //Storing to DB
    public function store(Request $r)

    {
        // dd($r->all());
        if (request('class') == null) {
            return redirect()->action('SectionController@create')->withErrors(["Select a Class"]);
        } else {
            // $duplicate = Section::where('name', request('sectionName'))->first();
            // if(isset($duplicate)){
            //     return redirect()->action('SectionController@create')->withErrors([ "Section Name already exists."]);
            // }else{
            $section = Section::create([
                'name' => request('sectionName'),
                'class' => request('class')
            ]);
            return redirect()->back()->with('message', ' Section : ' . request('sectionName') . '  added succesfully for Class: ' . request('class'));
            // }
        }
    }

    // Show ALL sections
    public function showAll()
    { 
        $sections = Section::orderBy('class','asc')->get();

        return view('section.showAll',compact('sections'));
    }

    //Edit Section
    public function edit($id)
    {
       $secInfo = Section::findOrFail($id);

       return view('section.edit',compact('secInfo'));
    }

    //Uodate the section info
    public function update(Request $r)
    {
       $secInfo = Section::where('id',$r->section_id)->update([
           'name' => $r->name
       ]);
       if($secInfo){
        return redirect('/section/all')->with('message','Section update successful');
       }else{
        return redirect()->back()->with('errMessage','Section updated Unsuccessful');

       }
      
    }

    // Delete the section
    public function destroy($id)
    {
        $secStd = DB::table('section_has_students')->where('section_id',$id)->count();
        if($secStd > 0){
            return redirect()->back()->with('errMessage','Section has students! deletion not possible');
        }

        $destroy = Section::destroy($id);

        if($destroy){
            return redirect('/section/all')->with('message','Section update successful');

        }else{
        return redirect()->back()->with('errMessage','Section updated Unsuccessful');

        }
    }



}
