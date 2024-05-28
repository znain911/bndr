<?php

$total_case = [];
		$visit1_2023 = [];
		$visit1_2022 = [];
		$visit1_2021 = [];
		$visit1_2020 = [];
		$visit1_2019 = [];
		$visit1_2018 = [];
		
		$total_followup = [];
		$followup_2023 = [];
		$followup_2022 = [];
		$followup_2021 = [];
		$followup_2020 = [];
		$followup_2019 = [];
		$followup_2018 = [];
		
		$case_history = [];
		$followup_today = [];
		$tomorrow = date("Y-m-d", time() + 86400);
		
foreach($reg_visit1_2022 as $key => $value) {
	//follow up present day
	if($value['visit_is'] === 'PROGRESS_REPORT' ) {
        array_push($followup_today, [$key => $value]);
    }
	
	if($value['visit_is'] === 'CASE_HISTORY' ) {
        array_push($case_history, [$key => $value]);
    }
	
	//cas history filter
	if($value['visit_is'] === 'CASE_HISTORY' ) {
        array_push($total_case, [$key => $value]);
    }
	if($value['visit_is'] === 'CASE_HISTORY' && $value['create_date'] === '2023') {
        array_push($visit1_2023, [$key => $value]);
    }
    if($value['visit_is'] === 'CASE_HISTORY' && $value['create_date'] === '2022') {
        array_push($visit1_2022, [$key => $value]);
    }
	if($value['visit_is'] === 'CASE_HISTORY' && $value['create_date'] === '2021') {
        array_push($visit1_2021, [$key => $value]);
    }
	if($value['visit_is'] === 'CASE_HISTORY' && $value['create_date'] === '2020') {
        array_push($visit1_2020, [$key => $value]);
    }
	if($value['visit_is'] === 'CASE_HISTORY' && $value['create_date'] === '2019') {
        array_push($visit1_2019, [$key => $value]);
    }
	if($value['visit_is'] === 'CASE_HISTORY' && $value['create_date'] === '2018') {
        array_push($visit1_2018, [$key => $value]);
    }
	//progress history filter
	if($value['visit_is'] === 'PROGRESS_REPORT' ) {
        array_push($total_followup, [$key => $value]);
    }
	if($value['visit_is'] === 'PROGRESS_REPORT' && $value['create_date'] === '2023') {
        array_push($followup_2023, [$key => $value]);
    }
	if($value['visit_is'] === 'PROGRESS_REPORT' && $value['create_date'] === '2022') {
        array_push($followup_2022, [$key => $value]);
    }
	if($value['visit_is'] === 'PROGRESS_REPORT' && $value['create_date'] === '2021') {
        array_push($followup_2021, [$key => $value]);
    }
	if($value['visit_is'] === 'PROGRESS_REPORT' && $value['create_date'] === '2020') {
        array_push($followup_2020, [$key => $value]);
    }
	if($value['visit_is'] === 'PROGRESS_REPORT' && $value['create_date'] === '2019') {
        array_push($followup_2019, [$key => $value]);
    }
	if($value['visit_is'] === 'PROGRESS_REPORT' && $value['create_date'] === '2018') {
        array_push($followup_2018, [$key => $value]);
    }
}
 $total_case_count = count($total_case);
 $visit1_2023_count = count($visit1_2023);
 $visit1_2022_count = count($visit1_2022);
 $visit1_2021_count = count($visit1_2021);
 $visit1_2020_count = count($visit1_2020);
 $visit1_2019_count = count($visit1_2019);
 $visit1_2018_count = count($visit1_2018);
 
 $total_followup_count = count($total_followup);
 $followup_2023_count = count($followup_2023);
 $followup_2022_count = count($followup_2022);
 $followup_2021_count = count($followup_2021);
 $followup_2020_count = count($followup_2020);
 $followup_2019_count = count($followup_2019);
 $followup_2018_count = count($followup_2018);
 
 $followup_today_count = count($followup_today);
 $case_history_count = count($case_history);
 $total_visit = count($reg_visit1_2022);
 $followup_percentage = null;
 $casehistory_percentage = null;
 if($total_visit > 0){
 $followup_percentage = ($total_followup_count / $total_visit)* 100;
 $casehistory_percentage = ($case_history_count / $total_visit)* 100;
 $followup_percentage = sprintf("%0.2f",$followup_percentage);
 $casehistory_percentage = sprintf("%0.2f",$casehistory_percentage);
 }
 
 //total ptient filter
 
 $patient_female = [];
 $patient_male = [];
 $total_items2023 = [];
 $total_items2022 = [];
 $total_items2021 = [];
 $total_items2020 = [];
 $total_items2019 = [];
 $total_items2018 = [];
 foreach($total_items as $key => $value) {
	
	if($value['create_date'] === '2023') {
        array_push($total_items2023, [$key => $value]);
    }
	if($value['create_date'] === '2022') {
        array_push($total_items2022, [$key => $value]);
    }
	if($value['create_date'] === '2021') {
        array_push($total_items2021, [$key => $value]);
    }
	if($value['create_date'] === '2020') {
        array_push($total_items2020, [$key => $value]);
    }
	if($value['create_date'] === '2019') {
        array_push($total_items2019, [$key => $value]);
    }
	if($value['create_date'] === '2018') {
        array_push($total_items2018, [$key => $value]);
    }
	 
	 if($value['patient_gender'] === '1' ) {
        array_push($patient_female, [$key => $value]);
    }
	if($value['patient_gender'] === '0' ) {
        array_push($patient_male, [$key => $value]);
    }

 }
 
  $patient_female_count = count($patient_female);
  $patient_male_count = count($patient_male);
  $today_total_reg_count = count($total_items);
  
  $female_percentage = null;
  $male_percentage = null;
  
  if($today_total_reg_count > 0){
	$female_percentage = ($patient_female_count / $today_total_reg_count)* 100;
	$female_percentage = sprintf("%0.2f",$female_percentage);
	 
	$male_percentage = ($patient_male_count / $today_total_reg_count)* 100;
	$male_percentage = sprintf("%0.2f",$male_percentage);
  }
  
  
 
 //$distinct_patient2024 = [];
  $distinct_patient2023 = [];
  $distinct_patient2022 = [];
  $distinct_patient2021 = [];
  $distinct_patient2020 = [];
  $distinct_patient2019 = [];
  $distinct_patient2018 = [];
  foreach($total_distinct_patient as $key => $value) {
	  // if($value['create_date'] === '2024') {
        // array_push($distinct_patient2024, [$key => $value]);
    // }
	if($value['create_date'] === '2023') {
        array_push($distinct_patient2023, [$key => $value]);
    }
	if($value['create_date'] === '2022') {
        array_push($distinct_patient2022, [$key => $value]);
    }
	if($value['create_date'] === '2021') {
        array_push($distinct_patient2021, [$key => $value]);
    }
	if($value['create_date'] === '2020') {
        array_push($distinct_patient2020, [$key => $value]);
    }
	if($value['create_date'] === '2019') {
        array_push($distinct_patient2019, [$key => $value]);
    }
	if($value['create_date'] === '2018') {
        array_push($distinct_patient2018, [$key => $value]);
    }
  }
  
  $total_distinct_patient_count = count($total_distinct_patient);
  
  $witout_v1 = $today_total_reg_count - $total_distinct_patient_count;
  
  $total_items2023_count = count($total_items2023);
  $distinct_patient2023_count = count($distinct_patient2023);
  $witout_v12023 = $total_items2023_count - $distinct_patient2023_count;
  
  $total_items2022_count = count($total_items2022);
  $distinct_patient2022_count = count($distinct_patient2022);
  $witout_v12022 = $total_items2022_count - $distinct_patient2022_count;
  
  $total_items2021_count = count($total_items2021);
  $distinct_patient2021_count = count($distinct_patient2021);
  $witout_v12021 = $total_items2021_count - $distinct_patient2021_count;
  
  $total_items2020_count = count($total_items2020);
  $distinct_patient2020_count = count($distinct_patient2020);
  $witout_v12020 = $total_items2020_count - $distinct_patient2020_count;
  
  $total_items2019_count = count($total_items2019);
  $distinct_patient2019_count = count($distinct_patient2019);
  $witout_v12019 = $total_items2019_count - $distinct_patient2019_count;

  $total_items2018_count = count($total_items2018);
  $distinct_patient2018_count = count($distinct_patient2018);
  $witout_v12018 = $total_items2018_count - $distinct_patient2018_count;
  
  
  //tgi
  $type2dm = [];
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

  $others_count = count($others);
?>


		<div>
			
			<h2 class="maintext"> Total Registered Patient <?php 
				if ($yeartgi){
					echo ' of '.$yeartgi;
				}
				elseif ($tgiMonth){
					
					list($year,$month)= explode('-',$tgiMonth);
					$month = intval($month);
					
					$dateObj   = DateTime::createFromFormat('!m', $month);
					$monthName = $dateObj->format('F'); 
					echo ' of '.$monthName.'  '.$year;
				}elseif ($from){
					
					list($date1,$month1,$year1)= explode('-',$from);
					list($date2,$month2,$year2)= explode('-',$to);
					
					$month1 = intval($month1);
					$month2 = intval($month2);
					
					$dateObj1   = DateTime::createFromFormat('!m', $month1);
					$dateObj2   = DateTime::createFromFormat('!m', $month2);
					
					$monthName1 = $dateObj1->format('F'); 
					$monthName2 = $dateObj2->format('F'); 
					
					
					
					echo '   from  '.$date1.' '.$monthName1.' '.$year1.'   to  '.$date2.' '.$monthName2.' '.$year2;
				}
				
				
				
				
			?> </h2>
			<div class="border-bottom">  </div>

		</div>
	
		<div class="container margincontainer">
		
			<div class="row">
		
				<div class="col-sm-4">
					<div class="div1">
						
						<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic1.png"/>
						<h5 class="float-right textstyle"><?php echo $today_total_reg_count;?><br>Total Registered Patients</h5>

					</div>
				</div>
			
				<div class="col-sm-4">
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic2.png"/>
							<h5 class="float-right textstyle1"><?php echo $total_followup_count;?>  (<?php echo $followup_percentage;?>%)<br>Follow-up Patient</h5>

						</div>
				</div>
				
				<div class="col-sm-4">
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic2.png"/>
							<h5 class="float-right textstyle1"><?php echo $case_history_count;?>  (<?php echo $casehistory_percentage;?>%)<br>Case History Patient</h5>

						</div>
				</div>
				
				<div class="col-sm-4" style= 'margin-top: 2%;'>
					<div class="div1">

						<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic2.png"/>
						<h5 class="float-right textstyle2" style = 'margin-right: 25%;'>Male: <?php echo $patient_male_count;?>  (<?php echo $male_percentage;?>%)<br>Female: <?php echo $patient_female_count;?>  (<?php echo $female_percentage;?>%)<br>Patient by Gender</h5>

					</div>
				</div>

			
		  </div>

		</div>
		
		<div>

			<h2 class="maintext"> Annual Patient Count  <?php 
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
				
				
				
			?></h2>
			<div class="border-bottom">  </div>

		</div>
		<div class="container margincontainer">
		
			<div class="row">
		
			  <div class="col-sm-9">
				<canvas id="myChart5" width="400"></canvas>
			  </div>
				  <script type="text/javascript"> 
					
					var ctx = document.getElementById("myChart5").getContext("2d");

					var data = {
					  labels: ["2018","2019", "2020", "2021", "2022", "total"],
					datasets: [{
					  label: "New registration with visit 1 data",
					  backgroundColor: "#703BD9",
					  data: [<?php echo $visit1_2018_count;?>, <?php echo $visit1_2019_count;?>, <?php echo $visit1_2020_count;?>, <?php echo $visit1_2021_count;?> ,<?php echo $visit1_2022_count;?> ,<?php echo $total_case_count;?>]
					}, {
					  label: "New registration without visit data",
					  backgroundColor: "#3ED4A4",
					  data: [<?php echo $witout_v12018;?>, <?php echo $witout_v12019;?>, <?php echo $witout_v12020;?>, <?php echo $witout_v12021;?> ,<?php echo $witout_v12022;?> ,<?php echo $witout_v1;?>]
					}, {
					  label: "Follow-up Patient",
					  backgroundColor: "#F7B229",
					  data: [<?php echo $followup_2018_count;?>, <?php echo $followup_2019_count;?>, <?php echo $followup_2020_count;?>, <?php echo $followup_2021_count;?> ,<?php echo $followup_2022_count;?> ,<?php echo $total_followup_count;?>]
					}]
				  };

					var myChart5 = new Chart(ctx, {
					  type: 'bar',
					  data: data,
					  options: {
						barValueSpacing: 0,
						scales: {
						  xAxes: [{
								  barThickness: 15,
								  categoryPercentage: .4,
								  barPercentage: .6,
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
				
			  <div class="col-sm-3">
				<h5 class="middle">Patient by Gender</h5>
				<canvas id="myChart6" width="400" Height="400"></canvas>
			  </div>
			  
			  <script>

				var ctx = document.getElementById("myChart6").getContext('2d');
				var chart_div = new Chart(ctx, {
				  type: 'pie',
				  data: {
					title: ["Patient by Gender"],
					labels: ["Male", "Female"],
					datasets: [{
					  backgroundColor: [
						"#4169E1",
					  "#F57373"
					  ],
					  data: [<?php echo $patient_male_count;?>, <?php echo $patient_female_count;?>]
					}]
				  }
				});

			  </script>

			</div>
		</div>
		
		<div>
		
			<h2 class="maintext"> Type of glucose intolerance <?php 
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
				
				
				
			?></h2>
			<div class="border-bottom">  </div>

			

			  <!--<select class="dropdown1">
				<option value=""> </option>
				<option value="Monthly">Monthly</option>
				<option value="Yearly">Yearly</option>
			  </select>

			  <button class="searchbutton1">Search</button>-->

			  

		 </div>
	 
		<div class="container margincontainer">
		
			<div class="row">

			  <div class="col-sm-12">
				<canvas id="myChart7" width="400"></canvas>
			  </div>
		  
			<script type="text/javascript"> 

				var ctx = document.getElementById("myChart7").getContext("2d");

				var data = {
				  labels: ["Type 2 DM", "Type 1 DM", "IGT", "IFG", "GDM", "Others"],
							datasets: [{
							  label: " <?php if(isset($_COOKIE['yeartgi'])){
						}?>",
							  backgroundColor: "#703BD9",
							  data: [<?php echo $type2dm_count;?>, <?php echo $type1dm_count;?>, <?php echo $igt_count;?>, <?php echo $ifg_count;?> ,<?php echo $gdm_count;?> ,<?php echo $others_count;?>]
							}]
				};

				var myChart7 = new Chart(ctx, {
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
			  <!--<div class="col-sm-3">
				<canvas id="myChart8" width="400" Height="400"></canvas>
			  </div>-->

			</div>

		</div>
		
		