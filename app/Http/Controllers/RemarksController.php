<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Remark;
use Illuminate\Support\Facades\Session;
use DB;
use function GuzzleHttp\json_encode;
use App\RemarkCategory;

class RemarksController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //Store the remarks for the logged in user(Admin/teacher)
    public function store(Request $req)
    {

        $userEmail = Session::get('userEmail');
        $name = Session::get('name');
        // dd($name);
        $users = DB::table('users')->pluck('email');
        $teachers = DB::table('teachers')->pluck('email');
        $role = "";
        if ($users->contains($userEmail)) {
            $role = "Admin";
        } elseif ($teachers->contains($userEmail)) {
            $role = "Teacher";
        }

        //getting previous categories
        $cat = DB::table('remark_category')->pluck('remark_title');
        $this->validate($req, [
            'remark_title' => 'required| min:6',
            'remark_body' => 'required'
        ]); 

        //if it is a new Remark Title
        if (!$cat->contains($req->remark_title)) {
            // dd($req->all());
            DB::table('remark_category')->insert([
                'remark_title' => $req->remark_title
            ]);

            DB::table('remarks')->insert([
                'student_id' => $req->student_id,
                'sender_email' => $req->userEmail,
                'role' => $role,
                'sender_name' => $name,
                'remark_title' => $req->remark_title,
                'remarks' => $req->remark_body,
            ]);
        } else {
            // dd($req->all());
            DB::table('remarks')->insert([
                'student_id' => $req->student_id,
                'sender_email' => $req->userEmail,
                'role' => $role,
                'sender_name' => $name,
                'remark_title' => $req->remark_title,
                'remarks' => $req->remark_body,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Edit remarks view
    public function edit($id)
    {
        $cat = DB::table('remark_category')->get();
       $remark = Remark::findOrFail($id);
       
        return view('student.updateRemarks',compact('remark','cat'));
    }

    //Update remarks method

    public function update(Request $r)
    {
        $userEmail = Session::get('userEmail');
    //    dd($r->all());
       $this->validate($r, [
        'remark_title' => 'required| min:6',
        'remark_body' => 'required'
        ]);

        DB::table('remarks')
            ->where('id', $r->remark_id)
            ->where('sender_email',$userEmail)
            ->update([
                'remark_title' => $r->remark_title,
                'remarks' =>$r->remark_body
            ]);


        return redirect('/student/profile/id='.$r->student_id);
    }

    // IF the remark belong to logged in user he/she can delete remarks
    public function destroy($id){
        Remark::destroy($id);
       
        return redirect()->back();
    }
}
