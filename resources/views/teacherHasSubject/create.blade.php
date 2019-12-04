@extends('layouts.master')

@section('content')

<div class="row">
  <div class="card col-sm-12 col-md-8 col-lg-6 col-xl-6 mb-2 mb-md-5 mx-2">
    <div class="p-3">
      <form method="POST" action="/assignSubject">
        {{ csrf_field() }}

        <div class="form-group">
          <label for="teacherID">Teacher Name :</label>
          <select type="text" class="form-control" id="teacherID" name="teacherID" >
            <option value="">
              Select Teacher
            </option>
            @foreach ($teacher as $id )
            <option value="{{ $id->id }}"> {{ $id->firstName }} {{ $id->lastName }} </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="Title">Subject Name</label>
          <select type="text" class="form-control" id="teacherID" name="subjectID" >
            <option value="">
              Select Subject
            </option>
            @foreach ($subject as $id )
            <option value="{{ $id->id }}">Subject: {{ $id->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Set Subject</button>
        </div>

        @if (Session::has('success'))
          <div class="alert alert-success">
              <ul>
                  <li>{!! \Session::get('success') !!}</li>
              </ul>
          </div>
          @endif
        @include('layouts.errors')
      </form>
    </div>
  </div>
</div>






@endsection
