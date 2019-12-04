@extends('layouts.master')

@section('content')
<div class="row d-flex justify-content-center">
  <div class="card mb-2 mb-md-5 mx-2 p-4 w-75">
    <form action="/teacherAttendanceStart/logout" method="POST">
      {{ csrf_field() }}

      <p class="text-center">Confirm End Time?</p>

      <div class="form-group">
          <button  type='submit' class="btn p-3 btn-green mb-3 d-flex justify-content-center w-100"><i class="material-icons d-flex align-content-center mr-2">account_box</i>Yes</button>
        <a href="/dashboard" class="btn p-3 btn-earth mb-3 d-flex justify-content-center"><i class="material-icons d-flex align-content-center mr-2">account_box</i>NO</a>
      </div>

      @include('layouts.errors')

    </div>
  </form>
</div>
</div>

@endsection
