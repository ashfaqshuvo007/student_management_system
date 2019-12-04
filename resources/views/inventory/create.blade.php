@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="card col-sm-12 col-md-8 col-lg-8 col-xl-8 mb-2 mb-md-5 mx-2">
      <form method="POST" action="/inventories/store">
        {{ csrf_field() }}

          <div class="p-3">
            <div class="form-group">
              <label for="Title">Amount :</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="amount">
              @foreach ($presentForDay as $id )
                <input type="hidden" name="current" value="{{ $id->CurrentQuantity }}">
              @endforeach
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
          </div>
         

        @include('layouts.errors')
      </form>
    </div>

    <div class="card col-sm-12 col-md col-lg col-xl mx-2 mb-5 h-100 text-center">
      <h2 class="px-3 pt-3">All Subjects in School</h2>
      <div class="table-responsive-sm">
        <table class="table table-hover table-striped">
          <thead class="thead-inverse">
            <tr>
              <td> Quantity </td>
              <td> UsedPerDayQuantity </td>
              <td> CurrentQuantity </td>
            </tr>
          </thead>
          <tbody  class="table-bordered">
            @foreach ($inventory as $id )

              <tr>
                <td>{{ $id->StartQuantity }}</td>
                <td>{{ $id->UsedPerDayQuantity }}</td>
                <td>{{ $id->CurrentQuantity }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <h1></h1>
        <div class="d-flex flex-wrap justify-content-around">
          @php
          $count = 0;
          @endphp
          <div class="d-flex flex-wrap justify-content-around">
            <h1></h1>
            <form method="POST" action="/inventories/store">

            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
@endsection
