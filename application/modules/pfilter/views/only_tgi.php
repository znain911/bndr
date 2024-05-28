<?php $type2dm = [];
  $type1dm = [];
  $igt = [];
  $ifg = [];
  $gdm = [];
  $others = [];
	foreach($get_tgi as $key => $value) {
		if($value['dhistory_type_of_glucose'] === 'Type 2 DM') {
        array_push($type2dm, [$key => $value]);
    }
	if($value['dhistory_type_of_glucose'] === 'Type 1 DM') {
        array_push($type1dm, [$key => $value]);
    }
	if($value['dhistory_type_of_glucose'] === 'IGT') {
        array_push($igt, [$key => $value]);
    }
	if($value['dhistory_type_of_glucose'] === 'IFG') {
        array_push($ifg, [$key => $value]);
    }
	if($value['dhistory_type_of_glucose'] === 'GDM') {
        array_push($gdm, [$key => $value]);
    }
	if($value['dhistory_type_of_glucose'] === 'Others') {
        array_push($others, [$key => $value]);
    }
	}
	
$type2dm_count = count($type2dm);
  $type1dm_count = count($type1dm);
  $igt_count = count($igt);
  $ifg_count = count($ifg);
  $gdm_count = count($gdm);
  $others_count = count($others);?>
  
  <canvas id="myChart3" width="400"></canvas>
	  
	  
		  <script type="text/javascript"> 

			  var ctx = document.getElementById("myChart3").getContext("2d");

			  var data = {
				labels: ["Type 2 DM", "Type 1 DM", "IGT", "IFG", "GDM", "Others"],
				datasets: [{
				  label: " <?php 
				if ($yeartgi){
					echo '('.$yeartgi.')';
				}
				elseif ($tgiMonth){
					
					list($year,$month)= explode('-',$tgiMonth);
					$month = intval($month);
					
					$dateObj   = DateTime::createFromFormat('!m', $month);
					$monthName = $dateObj->format('F'); 
					echo '('.$monthName.'  '.$year.')';
				}elseif ($from){
					list($date1,$month1,$year1)= explode('-',$from);
					list($date2,$month2,$year2)= explode('-',$to);
					
					$month1 = intval($month1);
					$month2 = intval($month2);
					
					$dateObj1   = DateTime::createFromFormat('!m', $month1);
					$dateObj2   = DateTime::createFromFormat('!m', $month2);
					
					$monthName1 = $dateObj1->format('F'); 
					$monthName2 = $dateObj2->format('F'); 
					echo '( From  '.$date1.' '.$monthName1.' '.$year1.'  to  '.$date2.' '.$monthName2.' '.$year2.')';
				}
				
				
				// setcookie ("yeartgi", "", time() - 5);
				// setcookie ("tgiMonth", "", time() - 5);
				// setcookie ("tgifrom", "", time() - 5);
				// setcookie ("tgito", "", time() - 5);
				
				
			?>",
				  backgroundColor: "#703BD9",
				  data: [<?php echo $type2dm_count;?>, <?php echo $type1dm_count;?>, <?php echo $igt_count;?>, <?php echo $ifg_count;?> ,<?php echo $gdm_count;?> ,<?php echo $others_count;?>]
				}]
			  };

			  var myChart3 = new Chart(ctx, {
				type: 'bar',
				data: data,
				options: {
				  barValueSpacing: 5,
				  
				  scales: {
					xAxes: [{
							barThickness: 50,
							
						  }],
					yAxes: [{
					  ticks: {
						min: 0,
					  }
					}]
				  
				  }
				}
			  });

			</script>