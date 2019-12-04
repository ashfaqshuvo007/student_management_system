@extends('layouts.master')

@section('content')
<script type="text/javascript">
  var sections = <?php echo sizeof($section);?>;
  window.onload = function() {
    if(sections == 0){
      document.getElementById("submit").classList.add("btn-disabled");
      document.getElementById("submit").disabled = true;
    }
  }
</script>


<div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12 blog-main">
      <h1>Student Attendace History:</h1>
      <hr>
      <div class="row">
        <div class="col-sm-4 blog-main">
          <form method="POST" action="/studentAttendance/postAnalytics">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="sectionID">Select Section :</label>
              <select class="form-control" name="sectionID" id="sectionID">
                @foreach($section as $id)
                <option value="{{ $id->id }}">[ Class: {{ $id->class}} ] Section: {{ $id->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group mt-3">
              <button type="submit" id="submit" class="btn btn-twitter mt-2">See Students</button>
            </div>
            @include('layouts.errors')
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
