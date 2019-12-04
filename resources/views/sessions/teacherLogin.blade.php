@extends('layouts.master3')

@section('content')


@if($invalidLogin)
      <div class="alert alert-danger d-flex flex-col item_center center txt_cntr panel30p" id="errbox" style="height:80px; position :absolute; top:15%; left:35%; ">
        {{$invalidLogin}}
      </div>
@endif

<div id="log_container" class="d-flex flex-col flex-wrap">

        <div id="log_screen" class="d-flex flex-row flex-wrap">
  

  
            <div class="halves d-flex flex-row flex-wrap xsm-panel100 dnone">
                <div class="panel d-flex flex-col flex-wrap bg_img_cntnt dflex_row_spacearound">
                    <div class="d-flex flex-row flex-wrap center bold white">
                        <h1 class="Xl">CHALKBOARD</h1>
                    </div>
                </div>
            </div>

            <div class="halves d-flex flex-row flex-wrap bg_clr xsm-panel100 bg-w">
                <div class="panel d-flex flex-col flex-wrap dflex_row_spacearound">
                    <div class="pd-2 self_center center">

                        <div class="label_login txt_cntr normal">
                            <h2 class="sm_fs normal">LOGIN AS</h2>
                        </div>


                        <div class="txt_cntr">
                            <h1 class="lt_2p bold blue_text mt_0 Xl">TEACHER</h1>
                        </div>


                        <div class="d-flex flex-col content_center">
                            

                              <form class="d-flex flex-col flex-wrap" action="/TeacherLogin" method="POST">
                              {{ csrf_field() }}

                              <div class="d-flex flex-col">
                              
                              <input type="text" class="inpt_tg mt_1 txt_cntr" id="email" name="email" placeholder="USER NAME" required>
                              </div>

                              <div class="d-flex flex-col mt_1">
                             
                              <input type="password" class="inpt_tg mt_1 txt_cntr" id="password" name="password" placeholder="PASSWORD" required>
                              </div>

                              <div class="d-flex">
                              <label><input type="checkbox" class="mt_1" value="" name="rememberMe">Remember Me</label>
                              </div>

                              <div class="d-flex flex-col">
                              <button type="submit" class="btn_login normal white txt_cntr mt_1">Login</button>
                              </div>

                              @include('layouts.errors')

                              </form>
                        </div>



                    </div>
                </div>
            </div>


        </div>
      

</div>

  
  
  
  
  
  
  
  
  
  
  
@endsection



