<?php 
$connect = mysqli_connect('localhost','bndr','nDYqzGnJZyWgyTPD','bndr');

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData, true);

$p_id = $DecodedData["pid"];


// $query = "SELECT labinvs_patient_id,fbg,hba1c,date_format(visit_date, '%d/%c/%y') as date  FROM bndr.starter_visit_laboratory_main
		// right join bndr.starter_patient_visit on bndr.starter_patient_visit.visit_id = bndr.starter_visit_laboratory_main.labinvs_visit_id
		// where labinvs_patient_id = '$p_id' group by labinvs_visit_id
		// order by labinvs_visit_id desc";

$query = "SELECT labinvs_visit_id, labinvs_patient_id,fbg,hba1c,height,weight,sitting_sbp,sitting_dbp,date_format(visit_date, '%d/%c/%y') as date  FROM bndr.starter_visit_laboratory_main
		right join bndr.starter_patient_visit on bndr.starter_patient_visit.visit_id = bndr.starter_visit_laboratory_main.labinvs_visit_id
		right join bndr.starter_visit_general_examinations_new on bndr.starter_visit_general_examinations_new.generalexam_visit_id  = bndr.starter_visit_laboratory_main.labinvs_visit_id
		where labinvs_patient_id = '$p_id' 
		order by labinvs_visit_id desc";

$query_run = mysqli_query($connect,$query);

if (mysqli_num_rows($query_run) > 0){
	
	$array = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
	$items = array_unique(array_column($array, 'labinvs_visit_id'));
	$filter = array_intersect_key($array, $items);
	
	$fbg = [];
	$hba1c=[];
	$bp_count = 0;
	$bp = [];
	$bmi = [];
	foreach($filter as $key => $value) {
		if($value['fbg'] !== null ) {
        array_push($fbg, ['fbg' => $value['fbg'],'date' =>$value['date']]);
		}
		
		if($value['hba1c'] !== null ) {
        array_push($hba1c, ['hba1c' => $value['hba1c'],'date' =>$value['date']]);
		}
		
		if($value['sitting_sbp'] !== null && $value['sitting_dbp'] !== null ) {
			$sbp = floatval($value['sitting_sbp']);
			$dbp = floatval($value['sitting_dbp']);
			$bp_val = $sbp .'/'.$dbp;
			if($bp_count <= 5){
			array_push($bp, ['date' =>$value['date'],'sbp' => $sbp,'dbp' =>$dbp]);
			$bp_count++;
			}
		}
		
		if($value['height'] !== null && $value['weight'] !== null ) {
			
			if (strpos($value['height'], 'cm') !== false) { 
				$height = floatval($value['height']);
				$cm = $height / 100;
				$weight = floatval($value['weight']);
				$bmI = $weight / ($cm * $cm);
				$bmI = round($bmI, 2);
				
				array_push($bmi, ['bmi' => $bmI,'date' =>$value['date']]);
			}elseif (strpos($value['height'], 'ft') !== false && strpos($value['height'], 'inch') !== false) {
				$ft = substr($value['height'], 0, strpos($value['height'], " "));
				$hVal2 =  strstr($value['height'],"ft");
				$inch = filter_var($hVal2, FILTER_SANITIZE_NUMBER_INT);
				
				$cm = (floatval($ft) /  3.281 ) + ($inch / 39.37);
				
				$weight = floatval($value['weight']);
				$bmI = $weight / ($cm * $cm);
				$bmI = round($bmI, 2);
				
				array_push($bmi, ['bmi' => $bmI,'date' =>$value['date']]);
			}elseif (strpos($value['height'], 'feet') !== false && strpos($value['height'], 'inch') !== false) {
				$ft = substr($value['height'], 0, strpos($value['height'], " "));
				$hVal2 =  strstr($value['height'],"feet");
				$inch = filter_var($hVal2, FILTER_SANITIZE_NUMBER_INT);
				
				$cm = (floatval($ft) /  3.281 ) + ($inch / 39.37);
				
				$weight = floatval($value['weight']);
				$bmI = $weight / ($cm * $cm);
				$bmI = round($bmI, 2);
				
				array_push($bmi, ['bmi' => $bmI,'date' =>$value['date']]);
			}elseif (strpos($value['height'], 'inch') !== false) {
				
				
				$height = floatval($value['height']);
				$cm = $height / 39.37 ;
				$weight = floatval($value['weight']);
				
				$bmI = $weight / ($cm * $cm);
				$bmI = round($bmI, 2);
				
				array_push($bmi, ['bmi' => $bmI,'date' =>$value['date']]);
			}elseif($value['height'] !== ' '){
				$height = floatval($value['height']);
				$cm = $height / 100;
				$weight = floatval($value['weight']);
				$bmI = $weight / ($cm * $cm);
				$bmI = round($bmI, 2);
				
				array_push($bmi, ['bmi' => $bmI,'date' =>$value['date']]);
			}
        //array_push($bp, ['bp' => $bp_val,'date' =>$value['date']]);
		}
	}
	$fbg1 = '';$fbg2 = '';$fbg3 = '';$fbg4 = '';$fbg4 = '';$fbg5 = '';
	$bp1 = '';$bp2 = '';$bp3 = '';$bp4 = '';$bp5 = '';
	$hba1c1 = '';$hba1c2 = '';$hba1c3 = '';$hba1c4 = '';$hba1c5 = '';
	$bmi1 = '';$bmi2 = '';$bmi3 = '';$bmi4 = '';$bmi5 = '';
	
	$fbgDate1 = '';$fbgDate2 = '';$fbgDate3 = '';$fbgDate4 = '';$fbgDate5 = '';
	$hba1cDate1 = '';$hba1cDate2 = '';$hba1cDate3 = '';$hba1cDate4 = '';$hba1cDate5 = '';
	$bpDate1 = '';$bpDate2 = '';$bpDate3 = '';$bpDate4 = '';$bpDate5 = '';
	$bmiDate1 = '';$bmiDate2 = '';$bmiDate3 = '';$bmiDate4 = '';$bmiDate5 = '';
	
	 $fbg_row_count = count($fbg);
	 $hba1c_row_count = count($hba1c);
	 $bp_row_count = count($bp);
	 $bmi_row_count = count($bmi);
	//bmi
	
	if($bmi_row_count >= 5){
		$bmi1 =  $bmi[0]['bmi'];
		$bmi2 =  $bmi[1]['bmi'];
		$bmi3 =  $bmi[2]['bmi'];
		$bmi4 =  $bmi[3]['bmi'];
		$bmi5 =  $bmi[4]['bmi'];
		
		$bmi1 = floatval($bmi1);
		$bmi2 = floatval($bmi2);
		$bmi3 = floatval($bmi3);
		$bmi4 = floatval($bmi4);
		$bmi5 = floatval($bmi5);
		
		$bmiDate1 = $bmi[0]['date'];
		$bmiDate2 = $bmi[1]['date'];
		$bmiDate3 = $bmi[2]['date'];
		$bmiDate4 = $bmi[3]['date'];
		$bmiDate5 = $bmi[4]['date'];
		 
	 }elseif($bmi_row_count === 4){
		$bmi1 =  $bmi[0]['bmi'];
		$bmi2 =  $bmi[1]['bmi'];
		$bmi3 =  $bmi[2]['bmi'];
		$bmi4 =  $bmi[3]['bmi'];
		
		$bmi1 = floatval($bmi1);
		$bmi2 = floatval($bmi2);
		$bmi3 = floatval($bmi3);
		$bmi4 = floatval($bmi4);
		
		$bmiDate1 = $bmi[0]['date'];
		$bmiDate2 = $bmi[1]['date'];
		$bmiDate3 = $bmi[2]['date'];
		$bmiDate4 = $bmi[3]['date'];
	 }elseif($bmi_row_count === 3){
		$bmi1 =  $bmi[0]['bmi'];
		$bmi2 =  $bmi[1]['bmi'];
		$bmi3 =  $bmi[2]['bmi'];
		
		$bmi1 = floatval($bmi1);
		$bmi2 = floatval($bmi2);
		$bmi3 = floatval($bmi3);
		
		$bmiDate1 = $bmi[0]['date'];
		$bmiDate2 = $bmi[1]['date'];
		$bmiDate3 = $bmi[2]['date'];
	 }elseif($bmi_row_count === 2){
		$bmi1 =  $bmi[0]['bmi'];
		$bmi2 =  $bmi[1]['bmi'];
		
		$bmi1 = floatval($bmi1);
		$bmi2 = floatval($bmi2);
		
		$bmiDate1 = $bmi[0]['date'];
		$bmiDate2 = $bmi[1]['date'];
	 }elseif($bmi_row_count === 1){
		$bmi1 =  $bmi[0]['bmi'];
		
		$bmi1 = floatval($bmi1);
		
		$bmiDate1 = $bmi[0]['date'];
	 }
     //bp
	 // if($bp_row_count >= 5){
		// $bp1 =  $bp[0]['bp'];
		// $bp2 =  $bp[1]['bp'];
		// $bp3 =  $bp[2]['bp'];
		// $bp4 =  $bp[3]['bp'];
		// $bp5 =  $bp[4]['bp'];
		
		// $bp1 = floatval($bp1);
		// $bp2 = floatval($bp2);
		// $bp3 = floatval($bp3);
		// $bp4 = floatval($bp4);
		// $bp5 = floatval($bp5);
		
		// $bpDate1 = $bp[0]['date'];
		// $bpDate2 = $bp[1]['date'];
		// $bpDate3 = $bp[2]['date'];
		// $bpDate4 = $bp[3]['date'];
		// $bpDate5 = $bp[4]['date'];
		 
	 // }elseif($bp_row_count === 4){
		// $bp1 =  $bp[0]['bp'];
		// $bp2 =  $bp[1]['bp'];
		// $bp3 =  $bp[2]['bp'];
		// $bp4 =  $bp[3]['bp'];
		
		// $bp1 = floatval($bp1);
		// $bp2 = floatval($bp2);
		// $bp3 = floatval($bp3);
		// $bp4 = floatval($bp4);
		
		// $bpDate1 = $bp[0]['date'];
		// $bpDate2 = $bp[1]['date'];
		// $bpDate3 = $bp[2]['date'];
		// $bpDate4 = $bp[3]['date'];
	 // }elseif($bp_row_count === 3){
		// $bp1 =  $bp[0]['bp'];
		// $bp2 =  $bp[1]['bp'];
		// $bp3 =  $bp[2]['bp'];
		
		// $bp1 = floatval($bp1);
		// $bp2 = floatval($bp2);
		// $bp3 = floatval($bp3);
		
		// $bpDate1 = $bp[0]['date'];
		// $bpDate2 = $bp[1]['date'];
		// $bpDate3 = $bp[2]['date'];
	 // }elseif($bp_row_count === 2){
		// $bp1 =  $bp[0]['bp'];
		// $bp2 =  $bp[1]['bp'];
		
		// $bp1 = floatval($bp1);
		// $bp2 = floatval($bp2);
		
		// $bpDate1 = $bp[0]['date'];
		// $bpDate2 = $bp[1]['date'];
	 // }elseif($bp_row_count === 1){
		// $bp1 =  $bp[0]['bp'];
		
		// $bp1 = floatval($bp1);
		
		// $bpDate1 = $bp[0]['date'];
	 // }
	 
	 //fbg
	 if($fbg_row_count >= 5){
		 $fbg1 =  $fbg[0]['fbg'];
		$fbg2 =  $fbg[1]['fbg'];
		$fbg3 =  $fbg[2]['fbg'];
		$fbg4 =  $fbg[3]['fbg'];
		$fbg5 =  $fbg[4]['fbg'];
		
		$fbg1 = floatval($fbg1);
		$fbg2 = floatval($fbg2);
		$fbg3 = floatval($fbg3);
		$fbg4 = floatval($fbg4);
		$fbg5 = floatval($fbg5);
		
		$fbgDate1 = $fbg[0]['date'];
		$fbgDate2 = $fbg[1]['date'];
		$fbgDate3 = $fbg[2]['date'];
		$fbgDate4 = $fbg[3]['date'];
		$fbgDate5 = $fbg[4]['date'];
	 }elseif($fbg_row_count === 4){
		$fbg1 =  $fbg[0]['fbg'];
		$fbg2 =  $fbg[1]['fbg'];
		$fbg3 =  $fbg[2]['fbg'];
		$fbg4 =  $fbg[3]['fbg'];
		
		$fbg1 = floatval($fbg1);
		$fbg2 = floatval($fbg2);
		$fbg3 = floatval($fbg3);
		$fbg4 = floatval($fbg4);
		
		$fbgDate1 = $fbg[0]['date'];
		$fbgDate2 = $fbg[1]['date'];
		$fbgDate3 = $fbg[2]['date'];
		$fbgDate4 = $fbg[3]['date'];
	 }elseif($fbg_row_count === 3){
		$fbg1 =  $fbg[0]['fbg'];
		$fbg2 =  $fbg[1]['fbg'];
		$fbg3 =  $fbg[2]['fbg'];
		
		$fbg1 = floatval($fbg1);
		$fbg2 = floatval($fbg2);
		$fbg3 = floatval($fbg3);
		
		$fbgDate1 = $fbg[0]['date'];
		$fbgDate2 = $fbg[1]['date'];
		$fbgDate3 = $fbg[2]['date'];
	 }elseif($fbg_row_count === 2){
		$fbg1 =  $fbg[0]['fbg'];
		$fbg2 =  $fbg[1]['fbg'];
		
		$fbg1 = floatval($fbg1);
		$fbg2 = floatval($fbg2);
		
		$fbgDate1 = $fbg[0]['date'];
		$fbgDate2 = $fbg[1]['date'];
	 }elseif($fbg_row_count === 1){
		$fbg1 =  $fbg[0]['fbg'];
		
		$fbg1 = floatval($fbg1);
		
		$fbgDate1 = $fbg[0]['date'];
	 }
	 //hba1c
	 if($hba1c_row_count >= 5){
		 $hba1c1 =  $hba1c[0]['hba1c'];
		$hba1c2 =  $hba1c[1]['hba1c'];
		$hba1c3 =  $hba1c[2]['hba1c'];
		$hba1c4 =  $hba1c[3]['hba1c'];
		$hba1c5 =  $hba1c[4]['hba1c'];
		
		$hba1c1 = floatval($hba1c1);
		$hba1c2 = floatval($hba1c2);
		$hba1c3 = floatval($hba1c3);
		$hba1c4 = floatval($hba1c4);
		$hba1c5 = floatval($hba1c5);
		
		$hba1cDate1 = $hba1c[0]['date'];
		$hba1cDate2 = $hba1c[1]['date'];
		$hba1cDate3 = $hba1c[2]['date'];
		$hba1cDate4 = $hba1c[3]['date'];
		$hba1cDate5 = $hba1c[4]['date'];
	 }elseif($hba1c_row_count === 4){
		$hba1c1 =  $hba1c[0]['hba1c'];
		$hba1c2 =  $hba1c[1]['hba1c'];
		$hba1c3 =  $hba1c[2]['hba1c'];
		$hba1c4 =  $hba1c[3]['hba1c'];
		
		$hba1c1 = floatval($hba1c1);
		$hba1c2 = floatval($hba1c2);
		$hba1c3 = floatval($hba1c3);
		$hba1c4 = floatval($hba1c4);
		
		$hba1cDate1 = $hba1c[0]['date'];
		$hba1cDate2 = $hba1c[1]['date'];
		$hba1cDate3 = $hba1c[2]['date'];
		$hba1cDate4 = $hba1c[3]['date'];
	 }elseif($hba1c_row_count === 3){
		$hba1c1 =  $hba1c[0]['hba1c'];
		$hba1c2 =  $hba1c[1]['hba1c'];
		$hba1c3 =  $hba1c[2]['hba1c'];
		
		$hba1c1 = floatval($hba1c1);
		$hba1c2 = floatval($hba1c2);
		$hba1c3 = floatval($hba1c3);
		
		$hba1cDate1 = $hba1c[0]['date'];
		$hba1cDate2 = $hba1c[1]['date'];
		$hba1cDate3 = $hba1c[2]['date'];
	 }elseif($hba1c_row_count === 2){
		$hba1c1 =  $hba1c[0]['hba1c'];
		$hba1c2 =  $hba1c[1]['hba1c'];
		
		$hba1c1 = floatval($hba1c1);
		$hba1c2 = floatval($hba1c2);
		
		$hba1cDate1 = $hba1c[0]['date'];
		$hba1cDate2 = $hba1c[1]['date'];
	 }elseif($hba1c_row_count === 1){
		$hba1c1 =  $hba1c[0]['hba1c'];
		
		$hba1c1 = floatval($hba1c1);
		
		$hba1cDate1 = $hba1c[0]['date'];
	 }
	
	
$Response[]=array("message" => "ok","fbg_row_count" => $fbg_row_count,"fbg1" => $fbg1,"fbg2" => $fbg2,"fbg3" => $fbg3,"fbg4" => $fbg4,"fbg5" => $fbg5,
			"fbgDate1" => $fbgDate1,"fbgDate2" => $fbgDate2,"fbgDate3" => $fbgDate3,"fbgDate4" => $fbgDate4,"fbgDate5" => $fbgDate5,
			"hba1c1" => $hba1c1,"hba1c2" => $hba1c2,"hba1c3" => $hba1c3,"hba1c4" => $hba1c4,"hba1c5" => $hba1c5,
			"hba1cDate1" => $hba1cDate1,"hba1cDate2" => $hba1cDate2,"hba1cDate3" => $hba1cDate3,"hba1cDate4" => $hba1cDate4,"hba1cDate5" => $hba1cDate5,
			"bp" => $bp,"bp_count" => $bp_count,
			"bmi1" => $bmi1,"bmi2" => $bmi2,"bmi3" => $bmi3,"bmi4" => $bmi4,"bmi5" => $bmi5,
			"bmiDate1" => $bmiDate1,"bmiDate2" => $bmiDate2,"bmiDate3" => $bmiDate3,"bmiDate4" => $bmiDate4,"bmiDate5" => $bmiDate5);
	echo json_encode($Response);
}else {
	$message = "No Data"; 
	
	$Response[]=array("message" => $message);
	echo json_encode($Response);
}
?>