@if(count($errors))
  <div class="errorBox">
    <div class="d-flex flex-col flex-wrap center txt_cntr">
      <ul>
          @foreach ($errors->all() as $error)
            <li id="errbox" style="height:40px; position :absolute; top:5%; left:40%; align-items:center;" class="d-flex panel100p center self_center panel30p mt_1 xsm-panel90p pd_1">{{ $error }}</li>
            <?php
          	if (strcmp($error, 'The password format is invalid.') === 0){
          		echo "<li>Please ensure that the password had at least 1 uppercase, 1 lowercase, 1 number and 1 of the following symbols (;,./~@^&()_+{}:<>?\=-!$#%)</li>";     		
          	}
          	?>

          @endforeach
      </ul>
    </div>
  </div>
@endif 
 

 

<!-- {{-- <div> 
<div class="successBox">
    <div class="d-flex flex-col flex-wrap center txt_cntr">
        <div id="ssbox" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1"><h5>Your action has been <br> performed successfully!</h5></div> 
    </div>
</div>

<div class="errorBox">
    <div class="d-flex flex-col flex-wrap center txt_cntr">
        <div id="errbox" class="d-flex center self_center panel30p mt_1 xsm-panel90p pd_1"><h5>Your action could <br> not be performed!</h5></div> 
    </div>
</div>
 --}} -->


