@extends('layouts.master3')

@section('content')
  

<div id="log_container" class="d-flex flex-col flex-wrap">
        <div id="log_screen" class="d-flex flex-row flex-wrap">
            {{-- ADMIN LOGIN --}}
            <a href="{{ URL::to('/admin-login')}}" style="height:100vh;">
                <div class="halves d-flex flex-row flex-wrap xsm-panel100 dnone" style="height:100%;">
                    <div class="panel d-flex flex-col flex-wrap bg_img_cntnt dflex_row_spacearound">
                        <div class="d-flex flex-row flex-wrap center bold white">
                            <h1 class="Xl">ADMIN</h1>
                        </div>
                    </div>
                </div>
            </a>
            {{-- TEACHER LOGIN --}}
            <a href="{{ URL::to('/TeacherLogin')}}" style="height:100vh;">
                <div class="halves d-flex flex-row flex-wrap bg_clr xsm-panel100 bg-w" style="height:100%;">
                    <div class="panel d-flex flex-col flex-wrap dflex_row_spacearound">
                        <div class="pd-2 self_center center">
                            {{-- <div class="label_login txt_cntr normal">
                                <h2 class="sm_fs normal">LOGIN AS</h2>
                            </div> --}}
                            <div class="txt_cntr">
                                <h1 class="lt_2p bold blue_text mt_0 Xl">TEACHER</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
      

</div>

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

@endsection
