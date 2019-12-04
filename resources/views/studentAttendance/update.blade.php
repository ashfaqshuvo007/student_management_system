<!-- @extends('layouts.master')

@section('content')
<div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12 blog-main">
      <h1>Update Student Information:</h1>
      <hr>
      <div class="row">
        <div class="col-sm-4 blog-main">
          <form method="POST" action="/studentAttendance/postUpdateInfo">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="sectionID">Enter Student ID :</label>
              <input type="text" name="studentID" id="sectionID">
            </div>
            <div class="form-group mt-3">
              <button type="submit" id="submit" class="btn btn-twitter mt-2">Update</button>
            </div>
            @include('layouts.errors')
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection -->
