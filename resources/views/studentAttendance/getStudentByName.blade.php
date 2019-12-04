@extends('layouts.master')

@section('content')
<div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12 blog-main">
      <h1>Enter the Student ID: </h1>
      <hr>
      <div class="row">
        <div class="col-sm-4 blog-main">
          <form method="POST" action="/studentAttendance/postUpdateInfo">
            {{ csrf_field() }}
            <div class="form-group">
              <input type="text" name="id">
            </div>
            <div class="form-group mt-3">
              <button type="submit" id="submit" class="btn btn-twitter mt-2">Submit</button>
            </div>
            @include('layouts.errors')
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
