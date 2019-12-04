@extends('layouts.master2')

@section('content')



  <div style="height: 50vh;" class="panel d-flex flex-col center align_center item_center dflex_row_spacearound">
      <div class="ftclr"><h2>Update Remark:</h2></div>
        <div>
        
            <form class="d-flex flex-col panel50" method="POST" action="/updateRemarks">
             {{ csrf_field() }}
             <input type="hidden" name="remark_id" value="{{ $remark->id }}">
             <input type="hidden" name="student_id" value="{{ $remark->student_id }}">

                <label for="Title">Remark Title: </label>
                <input type="text" id="remark_title" list="json-datalist" name="remark_title" placeholder="e.g. health issue" value="{{$remark->remark_title}}" class="inpt_tg mt_1" required>
                <datalist id="json-datalist" >
                    @foreach($cat as $value)
                    <option value="{{ $value->remark_title }}" class="form-control"></option>
                    @endforeach
                </datalist>

                <label class="mt_1" for="remark"><b>Remarks:</b></label>
                <textarea name="remark_body" rows="5" class="inpt_tg mt_1" required>{{$remark->remarks}}</textarea>

                <div class="d-flex flex-row flex-wrap center align_center dflex_row_spacearound">
                <button style="width:100%;" type="submit" id="submit" class="btn_submit txt_cntr mt_1 self_center normal">Update</button>
                </div>
                @include('layouts.errors')
            </form>

        </div>
    </div>












@endsection
