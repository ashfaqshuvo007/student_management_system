@extends('layouts.master')

@section('content')

    <div class="row">
      <div class="card col-sm-12 col-md-8 col-lg-6 col-xl-6 mb-2 mb-md-5 mx-2">
          {{-- @include('posts.post') --}}
          <table class="table table-hover table-striped">
            <thead class="thead-inverse">
              <tr>
                <th>Login</th>
                <th>Logout</th>
                <th>Teacher's ID</th>
                <th>Teacher's Name</th>
              </tr>
            </thead>
              <tbody  class="table-bordered">
                @foreach ($attendance as $id )
                <tr>
                  <td>{{ $id->attLogin }}</td>
                  <td>{{ $id->attLogout }}</td>
                  <td>{{ $id->teacherID }}</td>
                  <td>{{ $id->firstName }} {{ $id->lastName }}</td>
               </tr>
              @endforeach
              </tbody>
          </table>

        </div>
    </div>

@endsection
