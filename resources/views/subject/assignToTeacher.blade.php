<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('js/ajax_scripts.js') }}"></script>
    <script type="text/javascript">
      window.onload = function() {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        var subjects = <?php echo json_encode($subjects);?>;
        for (const subject of subjects){
          var chkbx = '<input type="checkbox" name="subject_id[]" value="'+subject.id+'"><span>'+subject.name+'</span><br>';
          $('#subjectCheckBoxes').append(chkbx);
        }

        $('#sectionID').change(function() {
          // console.log($(this).val());
          connectionActive = false;
          if($(this).val()!=""){
            if(!connectionActive)
            {
              $.ajax({
                beforeSend: function(xhr)
                {
                  connectionActive = true;
                },
                type:'POST',
                url: "/getTeacherSubjects", 
                data: {teacherID:$(this).val(), ajax:true},
                success:function(data)
                {
                  connectionActive = false;
                  // console.log(data.unwanted_ids);
                 removeUnwanted(data.unwanted_ids);
                }
              });
            }
          }
        });
      }

      function removeUnwanted(wanted){
        console.log(wanted);
        // for(var i = 0;i< wnated.length)



        $('#subjectCheckBoxes').children('input').each(function() {
          console.log(this.value)
          var id = this.value;
          var keep = false
          Array.from(wanted).forEach(function (arrayItem) {
            if(arrayItem==id){
              keep = true
              console.log("paisi")
            }            
          });
          if(keep){
            // $(this).hide();
            console.log($(this).next().next().hide())
            console.log($(this).next().hide())
            console.log($(this).hide())
          }else{
            console.log($(this).next().next().show())
            console.log($(this).next().show())
            console.log($(this).show())
          }
        });
      }

    </script>
</head>
@extends('layouts.master2')

@section('content')

@if(Session::has('message'))
  <div class="successBox">
      <div class="d-flex flex-col flex-wrap center txt_cntr">
          <div id="ssbox" style="background: #81C784;
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

  <div class="d-flex dflex_row_spacearound panel100p">
    <div class="d-flex flex-col panel90p xsm-panel100p">
      <div class="bg-w margin-1 pd_1 nobdrad xsm-margin-0"> 
        <form method="POST" action="/assignSubjectToTeacher">
          {{ csrf_field() }}

            <div class="d-flex flex-col mt_1">
              <label class="mt_1" for="sectionID">Teachers :</label>
              <select style="padding:8px;" type="text" class="inpt_tg mt_1" id="sectionID" name="sectionID" required>
                <option value="">
                    Select Teacher
                </option>
                @foreach ($teachers as $teacher )
                <option value="{{ $teacher->id }}"> {{ $teacher->firstName }} {{ $teacher->lastName }}</option>
                @endforeach
              </select>
            </div>

            <div class="mt_1 mb_1" id="subjectCheckBoxes">
              <label for="subjectID">Subject:</label><br>
            </div>
            <div class="d-flex center">
              <button type="submit" class="btn_submit panel50p mt_1">Set Subject</button>
            </div>
            @include('layouts.errors')
        </form>
      </div> 
    </div>
  </div>







{{-- new design --}}
<div class="d-flex flex-row flex-wrap dflex_row_space_evenly xsm-flex-col panel100p mt_1">

    <div class="d-flex flex-col flex-wrap panel20p bg-w pd_1 xsm-panel93p nobdrad xsm-mt_1">
        <table id="asiignSubtoTeacherTable">
          <thead>
            <tr>
              <th>Subject Name</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($subjects as $subject )
            <form action="" method ="POST">
              <tr>
                <td>{{ $subject->name }}</td>
              </tr>
            </form>
            @endforeach
          </tbody>
        </table>
    </div>
    
    <div class="d-flex flex-col flex-wrap panel60p bg-w pd_1 xsm-panel93p nobdrad xsm-mt_1">
        <table>
          <thead>
            <tr>
              <th>Teacher Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($teachers as $teacher )
            <tr>
              <td>{{ $teacher->firstName }} {{ $teacher->lastName }}</td>
              <td>
                <form action = "" method = "POST" class="d-flex center panel100p">
                  {{ csrf_field() }}
                  <button type = "submit" class = "btn_submit1"><i class="fas fa-plus ftclr"></i></button>
                  <button type = "submit" class = "btn_submit1"><i class="fas fa-trash-alt ftclr"></i></button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>

        </table>
    </div>

</div>










  
@endsection
