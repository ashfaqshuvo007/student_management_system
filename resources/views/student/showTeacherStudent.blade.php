<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@extends('layouts.master2')

@section('content')

<!-- *************************** Student List Table *************************** -->
<div class="d-flex flex-row flex-wrap center">
        <!-- list -->
        <div class="panel90p xsm-panel100p">
          <?php //dd($student);?>
        <div class="d-flex flex-col listTable bg-w mb_1 pd_1">
           
            <h3 class="ftclr"><span>Class: <b>{{$sectionInfo->class}}</b> Section: <b>{{$sectionInfo->name}}</b></span></h3>


            <div style="overflow-x: auto;" class="panel100p d-flex flex-col flex-wrap item_center dflex_row_spaceBetween"> 
                <table class="panel90p mt_2">
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>CLASS</th>
                        <th>SECTION</th>
                        <th>ROLL</th> 
                        <th>BIRTHDAY</th>
                        <th>CONTACT</th>
                        <th>ACTION</th>

                    </tr>
                      <tbody  class="">
                        @foreach ($student as $id)
                        <?php 
                          $stdInfo = DB::table('students')->where('id',$id->student_id)->first();
                          // dd($stdInfo);
                        ?>
                            <tr>

                              <td>{{ $stdInfo->id }}</td>

                              <td>{{ $stdInfo->name }}</td>
                              <td>{{$sectionInfo->class}}</td>
                              <td>{{$sectionInfo->name}}</td>
                            <td>{{ $stdInfo->rollNumber }}</td>
                            <td>{{ $stdInfo->DOB }}</td>
                            <td>{{ $stdInfo->contact }}</td>


                           
                            <td >
                                <ul class="d-flex flex-row center panel100p pd_0 lstyle">
                                    <li><a href="{{ URL::to('/student/profile/id='.$stdInfo->id)}}"><img id="viewProfileBtn" class="icnimg" src="/img/user2.png" alt="user2"></li>
                                </ul>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>

                </table>
        </div>    
        
        <div class="mb_1">
                <div class="d-flex flex-row center content_center">
                
                  <div style="background:white;" id="paginationn" class="d-flex justify-content-center align-items-center flex-wrap">
                   
                  </div>
                    
                </div>
            </div>
        </div>
        </div>


   
</div>

@endsection
