@extends('layouts.master2')

@section('content')
<!-- @php
if($reportCard['studentInfo']['section']=='N/A'){
     echo'Student Name: ' . $reportCard['studentInfo']['name'] . '<br>';
     echo'Student Roll: ' . $reportCard['studentInfo']['rollNumber']. '<br>';
     echo'Student Class: ' . $reportCard['studentInfo']['class']. '<br>';
}else{
    echo 'Student Name: ' . $reportCard['studentInfo']['name']. '<br>';
    echo 'Student Roll: ' . $reportCard['studentInfo']['rollNumber']. '<br>';
    echo 'Student Class: ' . $reportCard['studentInfo']['class']. '<br>';
    echo 'Student Section: ' . $reportCard['studentInfo']['section']. '<br>';
}
@endphp -->


<style>


#reportCardTable tr:nth-child(odd){
    background-color:rgb(189,189,189,0.5);
}



</style>
<div class="d-flex flex-col center mb_1">

    <div class="d-flex flex-col flex-wrap item_center dflex_row_spaceBetween mt_1" style="overflow-x:auto;">

        <table id="reportCardTable" class="panel90p">
            <tr>
                <th>Exam Name</th>
                <th>Highest Mark</th> 
                <th>Student Mark</th>
                <th>Student Remark</th>
                <th>Student Grade</th>
            </tr>
        </table>


    </div>

</div>


{{-- printable section of the report card --}}




<div class="d-flex flex-col bg-w pd_2">
    {{-- student identification div --}}
    <div class="d-flex dflex_row_spaceBetween pd_1">
        {{-- name sec class id --}}
        <div class="d-flex flex-col panel40p">
            <h2 class="blue_text">                            
                @php
                if($reportCard['studentInfo']['section']=='N/A'){
                echo $reportCard['studentInfo']['name'];
                }
                else{
                echo $reportCard['studentInfo']['name'];
                }
                @endphp
            </h2>
        
            <div class="d-flex dflex_row_spaceBetween">

                <div class="right-border">
                    <h5 class="normal ftclr">id :
                         @php
                        if($reportCard['studentInfo']['id']=='N/A'){

                        }
                        else{
                        echo $reportCard['studentInfo']['id'];
                        }
                        @endphp
                    </h5>
                </div>
                <div class="right-border">
                    <h5 class="normal ftclr">class :
                        @php
                        if($reportCard['studentInfo']['section']=='N/A'){
                        echo $reportCard['studentInfo']['class'];
                        }
                        else{
                        echo $reportCard['studentInfo']['class'];
                        }
                        @endphp
                    </h5>
                </div>
                <div class="right-border">
                    <h5 class="normal ftclr">roll :
                        @php
                        if($reportCard['studentInfo']['section']=='N/A'){
                        echo $reportCard['studentInfo']['rollNumber'];
                        }
                        else{
                        echo $reportCard['studentInfo']['rollNumber'];
                        }
                        @endphp
                
                    </h5>
                </div>
                <div class="right-border">
                    <h5 class="normal ftclr">section :
                         @php
                        if($reportCard['studentInfo']['section']=='N/A'){

                        }
                        else{
                        echo $reportCard['studentInfo']['section'];
                        }
                        @endphp
                    </h5>
                </div>

            </div>

        </div>
        {{-- cgpa and print section --}}
        <div class="d-flex  dflex_row_spaceBetween panel40p">

           <div class ="background-grey panel50p d-flex flex-col item_center center">
                <h4 class="blue_text">CGPA : 4.21</h4>
           </div>

           <div class="d-flex dflex_row_space_evenly panel40p item_center">
                <div class="dot d-flex center item_center"><i class="fas fa-download"></i></div>
                <div class="dot d-flex center item_center"><i class="fas fa-print"></i></div>
           </div>

        </div>

    </div>

    <div class="pd_1" style="overflow-x:auto;">
        <table class="bg-w panel100p" id="report-card-table">
            <col>
                <colgroup span="1" style="background: rgb(250,251,252);"></colgroup>
                <colgroup span="1" style="background: rgb(250,251,252);"></colgroup>
                <colgroup span="1" style="background: rgb(250,251,252);"></colgroup>

                <colgroup span="1" style="background:white;"></colgroup>
                <colgroup span="1" style="background:white;"></colgroup>
                <colgroup span="1" style="background:white;"></colgroup>

                <colgroup span="1" style="background: rgb(250,251,252);"></colgroup>
                <colgroup span="1" style="background: rgb(250,251,252);"></colgroup>
                <colgroup span="1" style="background: rgb(250,251,252);"></colgroup>

                <colgroup span="1" style="background:white;"></colgroup>
                <colgroup span="1" style="background:white;"></colgroup>
                <colgroup span="1" style="background:white;"></colgroup>
                
            <tr>
                <td rowspan="2">subject</td>
                <th colspan="3" scope="colgroup">1st quarter</th>
                <th colspan="3" scope="colgroup">2nd quarter</th>
                <th colspan="3" scope="colgroup">3rd quarter</th>
                <th colspan="3" scope="colgroup">4th quarter</th>
            </tr>

            <tr>
                <th scope="col" class="normal ftclr">Highest</th>
                <th scope="col" class="normal ftclr">Your Marks</th>
                <th scope="col" class="normal ftclr">Your Grade</th>

                <th scope="col" class="normal ftclr">Highest</th>
                <th scope="col" class="normal ftclr">Your Marks</th>
                <th scope="col" class="normal ftclr">Your Grade</th>

                <th scope="col" class="normal ftclr">Highest</th>
                <th scope="col" class="normal ftclr">Your Marks</th>
                <th scope="col" class="normal ftclr">Your Grade</th>

                <th scope="col" class="normal ftclr">Highest</th>
                <th scope="col" class="normal ftclr">Your Marks</th>
                <th scope="col" class="normal ftclr">Your Grade</th>
            </tr>

            <tr>
            
                <th scope="row">Bangla</th>
                    <td>96</td>
                    <td>85</td>
                    <td>B+</td>

                    <td>96</td>
                    <td>85</td>
                    <td>B+</td>

                    <td>96</td>
                    <td>85</td>
                    <td>B+</td>

                    <td>96</td>
                    <td>85</td>
                    <td>B+</td>

                    
            </tr>
            
            <tr>
            
                <th scope="row">English</th>
                <td>96</td>
                <td>85</td>
                <td>B+</td>

                <td>96</td>
                <td>85</td>
                <td>B+</td>

                <td></td>
                <td></td>
                <td></td>
            
                <td></td>
                <td></td>
                <td></td>

            </tr>
            
            <tr>
                <th scope="col"></th>
                <td></td>
                <td>CGPA</td>
                <td><h5 class="cgpa">2.31</h5></td>

                <td></td>
                <td>CGPA</td>
                <td><h5 class="cgpa">2.27</h5></td>
            
                <td></td>
                <td>CGPA</td>
                <td><h5 class="cgpa">0.00</h5></td>

                <td></td>
                <td>CGPA</td>
                <td><h5 class="cgpa">4.15</h5></td>



               

            </tr>
            
            <tr>
                <td></td>
                <td colspan="3" style="text-align:center;">teachers remark</td>
                <td colspan="3" style="text-align:center;">teachers remark</td>
                <td colspan="3" style="text-align:center;">teachers remark</td>
                <td colspan="3" style="text-align:center;">teachers remark</td>
                
            </tr>


            <tr>
                <td></td>
                <td colspan="3" style="text-align:center;">Has potential must work hard</td>
                <td colspan="3" style="text-align:center;">Has potential must work hard</td>
                <td colspan="3" style="text-align:center;">Has potential must work hard</td>
                <td colspan="3" style="text-align:center;">Has potential must work hard</td>
               
            </tr>



        </table>
    </div>



</div>
























<script type="text/javascript">
    var reportCard = <?php echo json_encode($reportCard['reportCardDetails']);?>;
    console.log(reportCard);
    const exams = Object.keys(reportCard)
    for (const exam of exams) {
        console.log(exam);
        console.log(reportCard[exam]);
        var row = document.createElement("tr");
        row.appendChild(getRowElement(exam));
        document.getElementById("reportCardTable").appendChild(row);
        const subjects = Object.keys(reportCard[exam])
        for (const subject of subjects) {
            var row = document.createElement("tr");
            row.appendChild(getRowElement(subject));
            row.appendChild(getRowElement(reportCard[exam][subject]['classHighest']));
            row.appendChild(getRowElement(reportCard[exam][subject]['grade']));
            if(reportCard[exam][subject]['remark']!=null) 
                row.appendChild(getRowElement(reportCard[exam][subject]['remark']));
            else{
            row.appendChild(getRowElement(""));
            row.appendChild(getRowElement(reportCard[exam][subject]['letterGrade']));
            document.getElementById("reportCardTable").appendChild(row);}
        }
    }
    function getRowElement(text){
        var tableData = document.createElement("td");
        tableData.appendChild(document.createTextNode(text));
        return tableData;
    }
</script>






<script type="text/javascript">

        let cgpa = document.querySelectorAll(".cgpa"),i;
        for(i=0;i<cgpa.length;i++){
            console.log("cgpa");

            if(cgpa[i].textContent>3){
                cgpa[i].classList.add("back-green");
            }
            else{
                cgpa[i].classList.add("back-yellow");
            }

        }

      
            console.log(cgpa);
      
 
       


</script>



@endsection
