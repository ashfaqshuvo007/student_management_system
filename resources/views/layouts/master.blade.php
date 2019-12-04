<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="description" content="">

  <meta name="author" content="">
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script> -->
  <script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>

  <link rel="icon" href="\img\chalkboard.ico">

  {{-- {{-- <link href="https://fonts.googleapis.com/css?family=Bungee|Poppins:400,600,700" rel="stylesheet"> --}}
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  {{-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet"> --}} --}}
  <link href="{{ asset('css/bungee_poppins_font.min.css') }}" rel="stylesheet">
  {{-- <link href="{{ asset('css/material_icons.min.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('css/montserrat.min.css') }}" rel="stylesheet">

  <title>Nahar Education | Chalkboard</title>



  <!-- Bootstrap core CSS -->

  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"> --}}
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Custom styles for this template -->

  
  <link rel="stylesheet" href="/css/navbarstyle.css">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/loginstyle.css">
  <link rel="stylesheet" href="/css/form.css">
  <link rel="stylesheet" href="/css/attendance_cards.css">
  <link rel="stylesheet" href="/css/attendanceanalysis.css">
  <link rel="stylesheet" href="/css/home_page.css">
  <link rel="stylesheet" href="/css/SelectionScreen.css">
  <link rel="stylesheet" href="/css/student_list.css">
  <link rel="stylesheet" href="/css/style1.css">


</head>



<body class="mb-md-5">

  @include('layouts.head')
  
  <div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        @if (Auth::check() )

          @include('layouts.nav')

        @endif

      </div>

    </div>

    <div class="row">

      <div class="col-sm-12 pb-5 pb-md-0 mt_1">

        @yield('content')

      </div>

    </div>



  </div>



  @include('layouts.footer')



  <!-- Bootstrap core JavaScript

  ================================================== -->

  <!-- Placed at the end of the document so the pages load faster -->

  <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script> -->
  <script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script> --}}
  <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>

  {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script> --}}
  <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
  


  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

  <script src="../../../../assets/js/ie10-viewport-bug-workaround.js"></script>


  <script>
function openNav() {
document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
document.getElementById("myNav").style.width = "0%";
}

function myFunction() {
var input = document.getElementById("Search");
var filter = input.value.toLowerCase();
var nodes = document.getElementsByClassName('target');

for (i = 0; i < nodes.length; i++) {
if (nodes[i].innerText.toLowerCase().includes(filter)) {
nodes[i].style.display = "flex";
} else {
nodes[i].style.display = "none";
}
}
}




// function openMenu2(){

// }

// function openMenu3(){

// }

// function openMenu4(){

// }







</script>

</body>

</html>

