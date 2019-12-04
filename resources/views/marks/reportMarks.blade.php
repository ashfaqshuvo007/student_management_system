<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  @extends('layouts.master2') 
  @section('content')
  
  @if(Session::has('message'))
  <div class="successBox">
      <div class="d-flex flex-col flex-wrap center txt_cntr">
      <div id="ssbox" style="background: #81C784;color:white;
          border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1 color-white">{{ session::get('message')}}</div> 
      </div>
  </div>
  @endif
  @if(Session::has('errMessage'))
  <div class="errorBox">
  <div class="d-flex flex-col flex-wrap center txt_cntr">
      <div style="background: #FF6564;
      color: white;
      border-radius: 15px;" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1">
      
      {{ session::get('errMessage')}}
  </div> 
  </div>
  @endif
  <div class="d-flex flex-row flex-wrap center">
       
       
    <div class="panel80p d-flex flex-col listTable mb_1">
            <h5 class="d-flex flex-col pd_1"> 
                        <div class="text-green">
                            @if($examInfo->quiz == 1)
                            <strong>Exam Name: {{ $examInfo->name }} [ Class Test ]</strong>
                            @else
                            <strong>Exam Name: {{ $examInfo->name }}</strong>
                            @endif
                        </div>
                        @if($examInfo->section_id == null)
                            <div class="text-purple">
                                <strong>Class: All </strong>
                            </div>
                            <div class="text-purple">
                                <strong>Section: All</strong>
                            </div>
                        @else
                            <?php $section = DB::table('sections')->where('id',$examInfo->section_id)->get()[0];?>
                            <div class="text-purple">
                                <strong>Class: {{ $section->class }} </strong>
                            </div>
                            <div class="text-purple">
                                <strong>Section: {{ $section->name }}</strong>
                            </div>
                        @endif
                        
                        <div>
                            <strong>Date: {{ $examInfo->date }} </strong> 
                        </div>
    
                </h5>

        <div style="overflow-x: auto;" class="panel100p bg-w d-flex flex-col flex-wrap item_center dflex_row_spaceBetween"> 
            <table class="panel100p">
                <thead>
            
                    <th>STUDENT</th>
                    <th>MARKS</th>
                    <th>ACTION</th>
                </thead>
                <tbody>
                   @foreach($marks as $d)
                   @php
                       $studentInfo = DB::table('students')->where('id',$d->student_id)->first();
                   @endphp
                    <tr>
                        <td>{{ $studentInfo->name }}</td>

                        @if(is_null($d->grade))
                        <td> <?php echo "Marks not given ";?></td>
                        @else 
                        <td>{{$d->grade}} / {{ $examInfo->max_grade}}</td>

                        @endif
                        <td>
                            <form action="/exams/editMarks" method="POST">
                                {{ csrf_field() }}

                                <input type="hidden" name="examId" value="{{ $examInfo->id}}">
                                <input type="hidden" name="sectionId" value="{{$examInfo->section_id}}">
                                <input type="hidden" name="subjectId" value="{{ $examInfo->subject_id}}">
                                <button type="submit" class="btn_submit1" ><img id="viewEditBtn" class="icnimg" src="/img/edit.png" alt="edit"></button>

                            
                            </form>
                        </td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
    </div>    
    




</div>
  @endsection