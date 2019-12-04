<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="">

  <meta name="author" content="">
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script> -->
  <script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>

  <link rel="icon" href="\img\chalkboard.ico">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  {{-- <link href="https://fonts.googleapis.com/css?family=Bungee|Poppins:400,600,700" rel="stylesheet"> --}}
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  {{-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet"> --}}
  <link href="{{ asset('css/bungee_poppins_font.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/material_icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/montserrat.min.css') }}" rel="stylesheet">
 
  <title>Nahar Education | Chalkboard</title>



  <!-- Bootstrap core CSS -->

  
  <!-- Custom styles for this template -->

  <link href="/css/sms.css" rel="stylesheet">
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
{{-- @if(!view('404')) --}}
      @include('layouts.head')
 {{-- @endif --}}
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
  

  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script> -->



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







function openMenu1(){

element = document.getElementById("menu_down1");
element2 = document.getElementById("menu_down2");
element3 = document.getElementById("menu_down3");
element4 = document.getElementById("menu_down4");


if(element2.classList.contains('menuUP')){
        element2.classList.add("menudown");
        element2.classList.remove("menuUP");
        console.log("yo");    
}
if(element3.classList.contains('menuUP')){
        element3.classList.add("menudown");
        element3.classList.remove("menuUP");
        console.log("yo");    
}
if(element4.classList.contains('menuUP')){
        element4.classList.add("menudown");
        element4.classList.remove("menuUP");
        console.log("yo");    
}


if(element.classList.contains('menudown')){
  element.classList.add("menuUP");
  element.classList.remove("menudown");

}
else if(element.classList.contains('menuUP')){
 
  
  element.classList.add("menudown");
  element.classList.remove("menuUP");

}
else{
  element.classList.add("menuUP");
}

}

// 
function openMenu2(){

element = document.getElementById("menu_down2");

element2 = document.getElementById("menu_down1");
element3 = document.getElementById("menu_down3");
element4 = document.getElementById("menu_down4");


if(element2.classList.contains('menuUP')){
        element2.classList.add("menudown");
        element2.classList.remove("menuUP");
        console.log("yo");    
}
if(element3.classList.contains('menuUP')){
        element3.classList.add("menudown");
        element3.classList.remove("menuUP");
        console.log("yo");    
}
if(element4.classList.contains('menuUP')){
        element4.classList.add("menudown");
        element4.classList.remove("menuUP");
        console.log("yo");    
}








if(element.classList.contains('menudown')){
 
  element.classList.add("menuUP");
  element.classList.remove("menudown");
}
else if(element.classList.contains('menuUP')){
 
  
  element.classList.add("menudown");
  element.classList.remove("menuUP");

}
else{
  element.classList.add("menuUP");
}

}



// 
function openMenu3(){

element = document.getElementById("menu_down3");
element2 = document.getElementById("menu_down1");
element3 = document.getElementById("menu_down2");
element4 = document.getElementById("menu_down4");


if(element2.classList.contains('menuUP')){
        element2.classList.add("menudown");
        element2.classList.remove("menuUP");
        console.log("yo");    
}
if(element3.classList.contains('menuUP')){
        element3.classList.add("menudown");
        element3.classList.remove("menuUP");
        console.log("yo");    
}
if(element4.classList.contains('menuUP')){
        element4.classList.add("menudown");
        element4.classList.remove("menuUP");
        console.log("yo");    
}



if(element.classList.contains('menudown')){
 
  element.classList.add("menuUP");
  element.classList.remove("menudown");
}
else if(element.classList.contains('menuUP')){
 
  
  element.classList.add("menudown");
  element.classList.remove("menuUP");

}
else{
  element.classList.add("menuUP");
}

}


// 
function openMenu4(){

element = document.getElementById("menu_down4");
element2 = document.getElementById("menu_down1");
element3 = document.getElementById("menu_down2");
element4 = document.getElementById("menu_down3");


if(element2.classList.contains('menuUP')){
        element2.classList.add("menudown");
        element2.classList.remove("menuUP");
        console.log("yo");    
}
if(element3.classList.contains('menuUP')){
        element3.classList.add("menudown");
        element3.classList.remove("menuUP");
        console.log("yo");    
}
if(element4.classList.contains('menuUP')){
        element4.classList.add("menudown");
        element4.classList.remove("menuUP");
        console.log("yo");    
}


if(element.classList.contains('menudown')){
 
  element.classList.add("menuUP");
  element.classList.remove("menudown");
}
else if(element.classList.contains('menuUP')){
 
  
  element.classList.add("menudown");
  element.classList.remove("menuUP");

}
else{
  element.classList.add("menuUP");
}

}

















</script>
<script type="text/javascript" src="{{ asset('js/fontawesome-v5.6.3.js') }}"></script>
<!-- <script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1"
crossorigin="anonymous"></script> -->
</body>

</html>

