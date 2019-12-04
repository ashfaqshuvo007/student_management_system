@extends('layouts.master')

@section('content')

<script type="text/javascript">
window.onload = function() {
  document.getElementById("analytics_month").value = new Date().toJSON().slice(0,7);
}
</script>
<div class="row">
  <div class="col-sm-12">
    <form action="'/studentAttendance/postTable">
      <p>Showing data and analytics for <strong>Section Name<strong></p>
      <input type="month" name="bdaymonth" id="analytics_month">
      <input type="submit">
    </form>
    @php
    $count = 0;
    @endphp
    <div class="d-flex flex-wrap justify-content-around">
      @foreach ($present as $id )
      @php
      $count++;
      @endphp
      <div>

        <label class="switch" for="{{ $count }}">
          <input type="checkbox" name="{{$count}}" id="{{ $count }}" value="{{$id->id}}" checked>
          <span class="slider text-white">
            <div>
              <span class="text-85">
                {{$count}}
              </span>
              {{ $id->name }}
            </span>
            {{ $id->gender }}
          </span>
          {{ $id->created_at }}
        </div>
        <div>
          Roll - <strong>{{ $id->id}}</strong>
        </div>
      </span>
    </label><br><br>
  </div>
  @endforeach
</div>

</div>
</div>


<div class="row">
  <div class="col-sm-12">
    <h1>Total School Days </h1>
    <div class="d-flex flex-wrap justify-content-around">
      @php
      $count = 0;
      @endphp
      <div class="d-flex flex-wrap justify-content-around">
        <h1></h1>
        @foreach ($totalSchoolDays as $id )

        <?php $count++ ?>
        @endforeach
        <?php echo $count ?>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-sm-12">
    <h1>Presnt girls for the month</h1>
    <div class="d-flex flex-wrap justify-content-around">
      @php
      $count = 0;
      @endphp
      <div class="d-flex flex-wrap justify-content-around">
        <h1></h1>
        @foreach ($presentFemaleForMonth as $id )
        {{ $id->present }}
        @endforeach
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <h1>Presnt boys for the month</h1>
    <div class="d-flex flex-wrap justify-content-around">
      @php
      $count = 0;
      @endphp
      <div class="d-flex flex-wrap justify-content-around">
        <h1></h1>
        @foreach ($presentMaleForMonth as $id )
        {{ $id->present }}
        @endforeach
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-sm-12">
    <h1>Total boys in section</h1>
    <div class="d-flex flex-wrap justify-content-around">
      @php
      $count = 0;
      @endphp
      <div class="d-flex flex-wrap justify-content-around">
        <h1></h1>
        @foreach ($totalBoysInSection as $id )
        {{ $id->boys }}
        @endforeach
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-sm-12">
    <h1>Total girls in section</h1>
    <div class="d-flex flex-wrap justify-content-around">
      @php
      $count = 0;
      @endphp
      <div class="d-flex flex-wrap justify-content-around">
        <h1></h1>
        @foreach ($totalGirlsInSection as $id )
        {{ $id->girls }}
        @endforeach
      </div>
    </div>
  </div>
</div>

<!-- if needeed the table can be placed here -->

@endsection
