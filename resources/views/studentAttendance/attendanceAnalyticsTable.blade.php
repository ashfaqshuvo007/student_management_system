<!-- attendanceAnalyticsTable -->


@extends('layouts.master2') 
@section('content')
@php 
// dd($attendance_table);
  $present_boys = 0; 
  $present_girls = 0; 
  $present_total = 0;
  $absent_boys = 0; 
  $absent_girls = 0; 
  $absent_total = 0;  
  $school_days = 0;
  foreach($attendance_table as $row){ 
    if($row['holiday'] != '1' && $row['present_total'] != '0'){
      $school_days += 1; 
      $present_boys += $row['present_boys']; 
      $present_girls += $row['present_girls']; 
      $present_total += $row['present_total'];
      $absent_boys = $absent_boys + $row['total_boys'] - $row['present_boys']; 
      $absent_girls = $absent_girls + $row['total_girls'] - $row['present_girls']; 
      $absent_total = $absent_total + $row['total'] - $row['present_total']; 
    } 
  }
  $present_boys + $absent_boys != 0 ? $boys_percent = 100*$present_boys/($present_boys+$absent_boys) : $boys_percent = 0; 
  $present_girls + $absent_girls != 0 ? $girls_percent = 100*$present_girls/($present_girls+$absent_girls) : $girls_percent = 0; 
  $present_total + $absent_total != 0 ? $total_percent = 100*$present_total/($present_total+$absent_total) : $total_percent = 0; 
@endphp
<!-- use $day for displaying current selected month -->
<script type="text/javascript">
  window.onload = function() {
    document.getElementById("analytics_month").value = "<?php echo date_format(date_create(str_replace( ",", "", $attendance_table[0]['date'])), "Y-m");?>";
    document.getElementById("analytics_month").max = new Date().toJSON().slice(0,7);
      console.log(new Date().toJSON().slice(0,7));
    Chart.defaults.global.defaultFontFamily = 'Montserrat';
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = '#90A4AE';


      var ctx = document.getElementById("myChart");
      var attendanceDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          datasets: [{ data: [{{ $present_boys }}, {{ $absent_boys }}],
          backgroundColor: [ 'rgba(3, 169, 244)',
            'rgba(240, 242, 248)'] }],
            // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['Boys Present', 'Boys Absent']
        },
        options: {
          responsive: true,
          title: {
            display: true,
            position: 'bottom',
            fontSize: 18,
            text: 'Boys Present: ' + {{number_format((float)$boys_percent, 2, '.', '')}} + '%'
          },
          rotation: 1 * Math.PI,
          circumference: 1 * Math.PI
        }
      });

      var ctx = document.getElementById("myChart2");
      var attendanceDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: { 
          datasets: [{ data: [{{ $present_girls }}, {{ $absent_girls }}],
          backgroundColor: ['rgba(255, 193, 7)',
            'rgba(240, 242, 248)'] }], 
          // These labels appear in the legend and in the tooltips when hovering different arcs 
          labels: ['Girls Present', 'Girls Absent'],
        },
        options: {
          responsive: true,
          title: {
            display: true,
            position: 'bottom',
            fontSize: 18,
            text: 'Girls Present: ' + {{number_format((float)$girls_percent, 2, '.', '')}} + '%'
          },
          rotation: 1 * Math.PI,
          circumference: 1 * Math.PI
          
        }
        
      });

      var ctx = document.getElementById("myChart3");
      var attendanceDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          datasets: [{ data: [{{ $present_total }}, {{ $absent_total }}],
          backgroundColor: ['rgba(139, 195, 74)',
            'rgba(240, 242, 248)'] }],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['Total Present', 'Total Absent']
        },
        options: {
         responsive: true,
          title: {
            display: true,
            position: 'bottom',
            fontSize: 18,
            text: 'Total Present: ' + {{number_format((float)$total_percent, 2, '.', '')}} + '%'
          },
          rotation: 1 * Math.PI,
          circumference: 1 * Math.PI
        }
      });

      
      if({{ $present_total }} + {{ $absent_total }} == 0){
        // $("#attendancePieCharts").hide();
        // $("#attendancePieCharts").css("cssText", "display: none !important;");
        document.getElementById("attendancePieCharts").style.cssText = "display: none !important;";
      }
  }

</script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>-->
<script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>

<div class="row">
  <div class="d-flex flex-row flex-wrap center">

    <!-- Month Selector -->
<div class="d-flex flex-row center panel100p">
    <form class="tb-panel90p xsm-panel100p nobdrad xsm-margin-0 pd_1 bg-w" method="post" action="/studentAttendance/postTable">
      {{ csrf_field() }} @if(($sectionName[0]->name === "N/A") || is_null($sectionName[0]->name))
      <p>Showing data and analytics for <strong>Class: {{ $sectionName[0]->class }}</strong>. Select month below:</p>
      @elseif($sectionName[0]->class === 100)
      <p>Showing data and analytics for <strong>Class: Pre-School</strong> | <strong>Section: {{ $sectionName[0]->name }}</strong>.
        Select month below:</p>
      @else
      <p>Showing data and analytics for <strong>Class: {{ $sectionName[0]->class }}</strong> | <strong>Section: {{ $sectionName[0]->name }}</strong>.
        Select month below:</p>
      @endif


      <div class="d-flex flex-wrap flex-md-nowrap">
        <input class="inpt_tg panel100p" type="month" name="attendanceMonth" id="analytics_month">
        <input hidden type="text" name="sectionID" value="{{$sectionName[0]->id }}">
        <div class="d-flex justify-content-end panel100p mt_1">
          <input class="btn_submit panel100p" type="submit" value="select">
        </div>
      </div>
    </form>
</div>
    <!-- Attendance Analytics Table -->

    {{--
  @include('posts.post') --}}
    {{-- <div>
      <div class="row d-flex justify-content-around" id="attendancePieCharts">
        <div class="col-sm-12 col-md-3">
          <canvas id="boysChart"></canvas>
        </div>
        <div id="charts" class="col-sm-12 col-md-3 mb-4">
          <canvas id="girlsChart"></canvas>
        </div>
        <div class="col-sm-12 col-md-3">
          <canvas id="totalChart"></canvas>
        </div>
      </div>

      <h4 class="my-5 text-center">Daily Attendance Breakdown</h4>

      <table id="att-day-breakdown" class="table table-hover table-striped">
        <thead class="thead-inverse">
          <tr>
            <th>Date</th>
            <th>Boys Present
            </th>
            <th>Girls Present
            </th>
            <th>Total
            </th>
          </tr>
        </thead>
        <tbody class="table-bordered">
          @foreach($attendance_table as $row)
            <tr>
              <td>
                {{ $row['date'] }}
              </td>
              <td>
                <div class='d-flex flex-wrap'>
                @if ($row['holiday'] == '1' || $row['present_total'] == '0')
                  HOLIDAY
                @else
                  {{$row['present_boys']}}<span class='text-muted'> /</span>{{$row['total_boys']}}
                @endif
                </div>
              </td>
              <td>
                <div class='d-flex flex-wrap'>
                  @if ($row['holiday'] == '1' || $row['present_total'] == '0')
                    HOLIDAY
                  @else
                    {{$row['present_girls']}}<span class='text-muted'> /</span>{{$row['total_girls']}}
                  @endif
                </div>
              </td>
              <td>
                <div class='d-flex flex-wrap'>
                  @if ($row['holiday'] == '1' || $row['present_total'] == '0')
                    HOLIDAY
                  @else
                    {{$row['present_total']}}<span class='text-muted'> /</span>{{$row['total']}}
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <h4 class="my-5 text-center">Percentage Grouped Students</h4>

      <table id="perc-grouped-students" class="table table-hover table-striped">
        <thead class="thead-inverse">
          <tr>
            <th>Below 20%</th>
            <th>20% to 50%</th>
            <th>50% to 80%</th>
            <th>Above 80%</th>
          </tr>
        </thead>
        <tbody class="table-bordered">
          @for($i=0; $i<$thresholds["rows"]; $i++)
            <tr>
              <td>
                @if(array_key_exists($i, $thresholds[20]))
                  {{ $thresholds[20][$i] }}
                @endif
              </td>
              <td>
                <div class='d-flex flex-wrap'>
                  @if(array_key_exists($i, $thresholds[50]))
                    {{ $thresholds[50][$i] }}
                  @endif
                </div>
              </td>
              <td>
                <div class='d-flex flex-wrap'>
                  @if(array_key_exists($i, $thresholds[80]))
                    {{ $thresholds[80][$i] }}
                  @endif
                </div>
              </td>
              <td>
                <div class='d-flex flex-wrap'>
                  @if(array_key_exists($i, $thresholds[100]))
                    {{ $thresholds[100][$i] }}
                  @endif
                </div>
              </td>
            </tr>
          @endfor
        </tbody>
      </table>
   
   
   
    </div>
   --}}
  




  <div class="mt_2 panel100p">
    <!-- section1 -->
    <div class="d-flex flex-row flex-wrap align_center dflex_row_start">
        
        

       
    </div>

    <div class="d-flex flex-row flex-wrap dflex_row_space_evenly mt_2 ">
          
      
      <div id="rel-ative" style="" class="panel90p d-flex flex-row xsm-flex-col tb-flex-col flex-wrap dflex_row_space_evenly tb-panel100 bg-w pd_1 margin-1 item_center xsm-panel100p nobdrad xsm-margin-0">
     
     
      <div id="abs-olute" style="" class="d-flex flex-row flex-wrap dflex_row_space_evenly">
            <div class="panel60p d-flex flex-row flex-wrap dflex_row_start xsm-panel90p">
                <h4 class="xsmfont">ATTENDANCE OVERVIEW</h4>
            </div>
        </div>
     
            <div class="panel30p rl1 tb-panel80p xsm-panel80 xsm-self-center">
                    <canvas id="myChart"></canvas>
                    <div id="boyS" class="panel100p d-flex flex-row self_center txt_cntr center ftclr"><h4 class="m_0 pd_0 normal"></h4></div>
            </div>
            <div class="panel30p rl2 tb-panel80p xsm-panel80 xsm-self-center">
                    <canvas id="myChart2"></canvas>
                    <div id="girlS" class="panel100p d-flex flex-row self_center txt_cntr center ftclr"><h4 class="m_0 pd_0 normal"></h4></div>
            </div>
            <div class="panel30p rl3 tb-panel80p xsm-panel80 xsm-self-center">
                    <canvas id="myChart3"></canvas>
                    <div id="totalS" class="panel100p d-flex flex-row self_center txt_cntr center ftclr"><h4 class="m_0 pd_0 normal"></h4></div>
            </div>

      </div>      



    </div>


    <div class="d-flex flex-row flex-wrap mt_2 center dflex_row_space_evenly margin-1 xsm-margin-0">
        <div style="overflow-x:auto;" class="panel50p tb-panel100p d-flex flex-col dflex_row_start center pd_1 xsm-panel100p bg-w mt_1 nobdrad">
            <div> 
                <h3 class="ftclr">DAILY ATTENDANCE</h3>
            </div>
            <div class="panel100p mt_1">
                <table class="txt_cntr panel100p">
                    <tr>
                        <th>Date</th>
                        <th>Boys Present</th>
                        <th>Girls Present</th>
                        <th>Total Present</th>
                    </tr>
                    
                    <tbody class="table-bordered">
                        @foreach($attendance_table as $row)
                        @php
                          // dd($row['date'])
                        @endphp
                          <tr>
                            <td>
                              {{ $row['date'] }}
                            </td>
                            <td>
                              <div class='d-flex flex-wrap center'>
                              @if ($row['holiday'] == '1' || $row['present_total'] == '0')
                                HOLIDAY
                              @else
                                {{$row['present_boys']}}<span class='text-muted'> /</span>{{$row['total_boys']}}
                              @endif
                              </div>
                            </td>
                            <td>
                              <div class='d-flex flex-wrap center'>
                                @if ($row['holiday'] == '1' || $row['present_total'] == '0')
                                  HOLIDAY
                                @else
                                  {{$row['present_girls']}}<span class='text-muted'> /</span>{{$row['total_girls']}}
                                @endif
                              </div>
                            </td>
                            <td>
                              <div class='d-flex flex-wrap center'>
                                @if ($row['holiday'] == '1' || $row['present_total'] == '0')
                                  HOLIDAY
                                @else
                                  {{$row['present_total']}}<span class='text-muted'> /</span>{{$row['total']}}
                                @endif
                              </div>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>
        <div style="overflow-x:auto;" class="panel40p tb-panel100p d-flex flex-col dflex_row_start center pd_1 xsm-panel100p xsm-mt_1 bg-w mt_1 xsm-margin-0 nobdrad">
          <div> 
            <h3 class="ftclr">PERCENTAGE GROUPED STUDENTS</h3>
        </div>
        <div class="panel100p mt_1">
            <table class="txt_cntr panel100p">
                <tr>
                    <th>Below 20%</th>
                    <th>20% to 50%</th>
                    <th>50% to 80%</th>
                    <th>Above 80%</th>
                </tr>
                
                <tbody class="table-bordered">
                    @for($i=0; $i<$thresholds["rows"]; $i++)
                      <tr>
                        <td>
                          @if(array_key_exists($i, $thresholds[20]))
                            {{ $thresholds[20][$i] }}
                          @endif
                        </td>
                        <td>
                          <div class='d-flex flex-wrap center'>
                            @if(array_key_exists($i, $thresholds[50]))
                              {{ $thresholds[50][$i] }}
                            @endif
                          </div>
                        </td>
                        <td>
                          <div class='d-flex flex-wrap center'>
                            @if(array_key_exists($i, $thresholds[80]))
                              {{ $thresholds[80][$i] }}
                            @endif
                          </div>
                        </td>
                        <td>
                          <div class='d-flex flex-wrap center'>
                            @if(array_key_exists($i, $thresholds[100]))
                              {{ $thresholds[100][$i] }}
                            @endif
                          </div>
                        </td>
                      </tr>
                    @endfor
                  </tbody>


            </table>
        </div>
        </div>
    </div>


</div>






  </div>
</div>
@endsection
