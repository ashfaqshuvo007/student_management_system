@extends('layouts.master')

@section('content')
  <div class="col-sm-8">
    <h3>Admin Registration</h3>
    <hr>

    <form action="/UserRegister" method="POST">

      {{ csrf_field() }}
      <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" class="form-control" id="firstName" name="firstName" required>
      </div>

      <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" class="form-control" id="lastName" name="lastName" required>
      </div>

      {{-- Radio button for Gender --}}
      <div class="form-group">
        <label for="gender">Gender: </label>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="1" required> Male
          </label>
        </div>
        <div class="form-check form-check-inline">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="2"> Female
          </label>
        </div>
      </div>

      <div class="form-group">
        <label for="salary">Salary:</label>
        <input type="number" class="form-control" id="salary" name="salary" required>
      </div>

      <div class="form-group">
        <label for="phoneNumber">Phone Number:</label>
        <input type="number" class="form-control" id="phoneNumber" name="phoneNumber" required>
      </div>

      <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" class="form-control" id="address" name="address" required>
      </div>



      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Password Confirmation:</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
      </div>

      <br>

      <br>

      <div class="form-group">
          <button type="submit" class="btn btn-primary">Publish</button>
      </div>

        @include('layouts.errors')


    </form>

  </div>
@endsection
