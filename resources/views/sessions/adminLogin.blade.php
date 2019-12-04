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
                            <h1 class="lt_2p bold blue_text mt_0 Xl">ADMIN</h1>
                        </div>


                        <div class="d-flex flex-col content_center">
                            <form class="d-flex flex-col flex-wrap" action="/admin-login" method="POST">
                              {{ csrf_field() }}
                                <input class="inpt_tg txt_cntr" type="text" id="email" name="email" placeholder="USER NAME"
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
                                    required><br><br>
                                <input class="inpt_tg txt_cntr" type="password" id="password" name="password" placeholder="PASSWORD"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
                                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters"
                                     required><br><br><br><br>
                                <input style="width:108%;" type="submit" value="LOGIN" class="btn_login normal white txt_cntr">
                                @include('layouts.errors')
                            </form>
                        </div>



                    </div>
                </div>
            </div>


        </div>
      

</div>

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

@endsection
