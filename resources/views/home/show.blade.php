
@extends('layouts.master2')

@section('content')
  <div class="d-flex center">
    <a href="/TeacherLogin" id="TeacherHomeLoginBtn" class="btn_submit d-flex center item_center panel50p"><i class="material-icons mr-2 txt_cntr">school</i>Teacher Login</a>
    <!-- <a href="/UserLogin" class="btn p-4 btn-green home-btn"><i class="material-icons mr-2 align-middle">settings</i>Admin Login</a> -->
  </div>

  <div class="col-md-8">
    @if (Auth::check())
        <h3>welcome <strong>User </strong> {{ Auth::user()->lastName }} </h3>
    @endif
       @if (Auth::guard('teacher')->check())
          <h3>welcome <strong>Teacher </strong> {{ Auth::guard('teacher')->user()->lastName }} </h3>
       @endif
  </div>

@endsection
