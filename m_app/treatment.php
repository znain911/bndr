<?php 
$connect = mysqli_connect('localhost','bndr','nDYqzGnJZyWgyTPD','bndr');

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData, true);

$pid = $DecodedData["pid"];


$oads = "SELECT visit_id,visit_number,orgcenter_name,visit_patient_id,finaltreat_doctor_name,finaltreat_date,finaltreat_dietary_advice,finaltreat_physical_acitvity,finaltreat_diet_no,finaltreat_page_no,
date_format(finaltreat_next_visit_date, '%d %b, %Y') as finaltreat_next_visit_date,finaltreat_next_investigation,date_format(visit_date, '%d %b, %Y') as visit_date,oads_name as med_name,oads_dose as med_dose,oads_advice_codition_time as med_ct,oads_advice_codition_time_type as med_ctt,
oads_advice_codition_apply as med_ca,oads_duration as med_d,oads_duration_type as med_dt FROM bndr.starter_patient_visit
left join bndr.starter_crntomedication_oads on bndr.starter_crntomedication_oads.oads_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_final_treatment_infos on bndr.starter_visit_final_treatment_infos.finaltreat_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
where visit_patient_id = '$pid' 
order by visit_number ";

$insulin = "SELECT visit_id,visit_number,orgcenter_name,visit_patient_id,finaltreat_doctor_name,finaltreat_date,finaltreat_dietary_advice,finaltreat_physical_acitvity,finaltreat_diet_no,finaltreat_page_no,
date_format(finaltreat_next_visit_date, '%d %b, %Y') as finaltreat_next_visit_date,finaltreat_next_investigation,date_format(visit_date, '%d %b, %Y') as visit_date,insulin_name as med_name,insulin_dose as med_dose,insulin_advice_codition_time as med_ct,insulin_advice_codition_time_type as med_ctt,
insulin_advice_codition_apply as med_ca,insulin_duration as med_d,insulin_duration_type as med_dt , insulin_before_sleep , insulin_week_days , insulin_days_list FROM bndr.starter_patient_visit
left join bndr.starter_crntomedication_insulin on bndr.starter_crntomedication_insulin.insulin_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_final_treatment_infos on bndr.starter_visit_final_treatment_infos.finaltreat_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
where visit_patient_id = '$pid' 
order by visit_number ";

$anti_htn = "SELECT visit_id,visit_number,orgcenter_name,visit_patient_id,finaltreat_doctor_name,finaltreat_date,finaltreat_dietary_advice,finaltreat_physical_acitvity,finaltreat_diet_no,finaltreat_page_no,
date_format(finaltreat_next_visit_date, '%d %b, %Y') as finaltreat_next_visit_date,finaltreat_next_investigation,anti_htn_name as med_name,anti_htn_dose as med_dose,anti_htn_advice_codition_time as med_ct,anti_htn_advice_codition_time_type as med_ctt,
anti_htn_advice_codition_apply  as med_ca,anti_htn_duration as med_d,anti_htn_duration_type as med_dt FROM bndr.starter_patient_visit
left join bndr.starter_crntomedication_anti_htn on bndr.starter_crntomedication_anti_htn.anti_htn_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_final_treatment_infos on bndr.starter_visit_final_treatment_infos.finaltreat_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
where visit_patient_id = '$pid' 
order by visit_number ";

$anti_lipid = "SELECT visit_id,visit_number,orgcenter_name,visit_patient_id,finaltreat_doctor_name,finaltreat_date,finaltreat_dietary_advice,finaltreat_physical_acitvity,finaltreat_diet_no,finaltreat_page_no,
date_format(finaltreat_next_visit_date, '%d %b, %Y') as finaltreat_next_visit_date,finaltreat_next_investigation,date_format(visit_date, '%d %b, %Y') as visit_date,anti_lipid_name as med_name ,anti_lipid_dose as med_dose,anti_lipid_advice_codition_time as med_ct,anti_lipid_advice_codition_time_type as med_ctt,
anti_lipid_advice_codition_apply as med_ca,anti_lipid_duration as med_d,anti_lipid_duration_type as med_dt FROM bndr.starter_patient_visit
left join bndr.starter_crntomedication_anti_lipids on bndr.starter_crntomedication_anti_lipids.anti_lipid_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_final_treatment_infos on bndr.starter_visit_final_treatment_infos.finaltreat_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
where visit_patient_id = '$pid' 
order by visit_number ";

$anti_obesity = "SELECT visit_id,visit_number,orgcenter_name,visit_patient_id,finaltreat_doctor_name,finaltreat_date,finaltreat_dietary_advice,finaltreat_physical_acitvity,finaltreat_diet_no,finaltreat_page_no,
date_format(finaltreat_next_visit_date, '%d %b, %Y') as finaltreat_next_visit_date,finaltreat_next_investigation,date_format(visit_date, '%d %b, %Y') as visit_date,anti_obesity_name as med_name,anti_obesity_dose as med_dose,anti_obesity_advice_codition_time as med_ct,anti_obesity_advice_codition_time_type as med_ctt,
anti_obesity_advice_codition_apply  as med_ca,anti_obesity_duration as med_d,anti_obesity_duration_type as med_dt FROM bndr.starter_patient_visit
left join bndr.starter_crntomedication_anti_obesity on bndr.starter_crntomedication_anti_obesity.anti_obesity_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_final_treatment_infos on bndr.starter_visit_final_treatment_infos.finaltreat_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
where visit_patient_id = '$pid' 
order by visit_number ";

$anti_pla = "SELECT visit_id,visit_number,orgcenter_name,visit_patient_id,finaltreat_doctor_name,finaltreat_date,finaltreat_dietary_advice,finaltreat_physical_acitvity,finaltreat_diet_no,finaltreat_page_no,
date_format(finaltreat_next_visit_date, '%d %b, %Y') as finaltreat_next_visit_date,finaltreat_next_investigation,date_format(visit_date, '%d %b, %Y') as visit_date,antiplatelets_name as med_name,antiplatelets_dose as med_dose,antiplatelets_advice_codition_time as med_ct,antiplatelets_advice_codition_time_type as med_ctt,
antiplatelets_advice_codition_apply  as med_ca,antiplatelets_duration as med_d,antiplatelets_duration_type as med_dt FROM bndr.starter_patient_visit
left join bndr.starter_crntomedication_antiplatelets on bndr.starter_crntomedication_antiplatelets.antiplatelets_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_final_treatment_infos on bndr.starter_visit_final_treatment_infos.finaltreat_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
where visit_patient_id = '$pid' 
order by visit_number";

$others = "SELECT visit_id,visit_number,orgcenter_name,visit_patient_id,finaltreat_doctor_name,finaltreat_date,finaltreat_dietary_advice,finaltreat_physical_acitvity,finaltreat_diet_no,finaltreat_page_no,
date_format(finaltreat_next_visit_date, '%d %b, %Y') as finaltreat_next_visit_date,finaltreat_next_investigation,date_format(visit_date, '%d %b, %Y') as visit_date,other_name as med_name,other_dose as med_dose,other_advice_codition_time as med_ct,other_advice_codition_time_type as med_ctt,
other_advice_codition_apply  as med_ca,other_duration as med_d,other_duration_type as med_dt FROM bndr.starter_patient_visit
left join bndr.starter_crntomedication_others on bndr.starter_crntomedication_others.other_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_final_treatment_infos on bndr.starter_visit_final_treatment_infos.finaltreat_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
where visit_patient_id = '$pid' 
order by visit_number";

$sSQL= 'SET CHARACTER SET utf8'; 

mysqli_query($connect,$sSQL) ;
$oads_run = mysqli_query($connect,$oads);
$insulin_run = mysqli_query($connect,$insulin);
$anti_htn_run = mysqli_query($connect,$anti_htn);
$anti_lipid_run = mysqli_query($connect,$anti_lipid);
$anti_obesity_run = mysqli_query($connect,$anti_obesity);
$anti_pla_run = mysqli_query($connect,$anti_pla);
$others_run = mysqli_query($connect,$others);

$rownumber = 0;
if (mysqli_num_rows($oads_run) > 0 || mysqli_num_rows($insulin_run) > 0 || mysqli_num_rows($anti_htn_run) > 0 || 
mysqli_num_rows($anti_lipid_run) > 0 || mysqli_num_rows($anti_obesity_run) > 0 || mysqli_num_rows($anti_pla_run) > 0){
	
	if (mysqli_num_rows($oads_run) > 0){
	while($row = mysqli_fetch_array($oads_run)){
		if($row['med_ct']){
			$row['med_kha'] = "খাওয়ার";
			if($row['med_d'] === "চলবে"){
				$row['med_cho'] = null;
				$row['med_dt'] = null;
			}elseif($row['med_d'] === " " || $row['med_d'] === ""){
				$row['med_cho'] = "চলবে";
				$row['med_dt'] = null;
			}else{
				$row['med_cho'] = "চলবে";
			}
			
			
		}else{
			$row['med_kha'] = null;
			$row['med_cho'] = null;
			$row['med_ct'] = null;
			$row['med_ctt'] = null;
			$row['med_ca'] = null;
			$row['med_d'] = null;
			$row['med_dt'] = null;
		}
		$row['rowN'] = $rownumber;
     $json[] = $row;
	 $rownumber++;
}
	}
	
	if (mysqli_num_rows($insulin_run) > 0){
	while($row = mysqli_fetch_array($insulin_run)){
		if($row['med_ct']){
			$row['med_kha'] = "খাওয়ার";
			if($row['med_d'] === "চলবে"){
				$row['med_cho'] = null;
				$row['med_dt'] = null;
			}elseif($row['med_d'] === " " || $row['med_d'] === ""){
				$row['med_cho'] = "চলবে";
				$row['med_dt'] = null;
			}else{
				$row['med_cho'] = "চলবে";
			}
		}elseif($row['insulin_before_sleep'] === '1'){
			$row['med_kha'] = 'ঘুমানোর';
			$row['med_cho'] = null;
			$row['med_ct'] = 'আগে';
			$row['med_ctt'] = 'চলবে';
			$row['med_ca'] = null;
			$row['med_d'] = null;
			$row['med_dt'] = null;
		}elseif($row['insulin_week_days']){
			$row['med_kha'] = 'সপ্তাহে';
			$row['med_cho'] = $row['insulin_days_list'];
			$row['med_ct'] = $row['insulin_week_days'];
			$row['med_ctt'] = 'দিন';
			$row['med_ca'] = '(';
			$row['med_d'] = ')';
			$row['med_dt'] = null;
		}else{
			$row['med_kha'] = null;
			$row['med_cho'] = null;
			$row['med_ct'] = null;
			$row['med_ctt'] = null;
			$row['med_ca'] = null;
			$row['med_d'] = null;
			$row['med_dt'] = null;
		}
	$row['rowN'] = $rownumber;
     $json[] = $row;
	 $rownumber++;
}
	}
	
	if (mysqli_num_rows($anti_htn_run) > 0){
	while($row = mysqli_fetch_array($anti_htn_run)){
		if($row['med_ct']){
			$row['med_kha'] = "খাওয়ার";
			if($row['med_d'] === "চলবে"){
				$row['med_cho'] = null;
				$row['med_dt'] = null;
			}elseif($row['med_d'] === " " || $row['med_d'] === ""){
				$row['med_cho'] = "চলবে";
				$row['med_dt'] = null;
			}else{
				$row['med_cho'] = "চলবে";
			}
		}else{
			$row['med_kha'] = null;
			$row['med_cho'] = null;
			$row['med_ct'] = null;
			$row['med_ctt'] = null;
			$row['med_ca'] = null;
			$row['med_d'] = null;
			$row['med_dt'] = null;
		}
	$row['rowN'] = $rownumber;
     $json[] = $row;
	 $rownumber++;
}
	}
	
	if (mysqli_num_rows($anti_lipid_run) > 0){
	while($row = mysqli_fetch_array($anti_lipid_run)){
		if($row['med_ct']){
			$row['med_kha'] = "খাওয়ার";
			if($row['med_d'] === "চলবে"){
				$row['med_cho'] = null;
				$row['med_dt'] = null;
			}elseif($row['med_d'] === " " || $row['med_d'] === ""){
				$row['med_cho'] = "চলবে";
				$row['med_dt'] = null;
			}else{
				$row['med_cho'] = "চলবে";
			}
		}else{
			$row['med_kha'] = null;
			$row['med_cho'] = null;
			$row['med_ct'] = null;
			$row['med_ctt'] = null;
			$row['med_ca'] = null;
			$row['med_d'] = null;
			$row['med_dt'] = null;
		}
	$row['rowN'] = $rownumber;
     $json[] = $row;
	 $rownumber++;
}
	}
	
	if (mysqli_num_rows($anti_obesity_run) > 0){
	while($row = mysqli_fetch_array($anti_obesity_run)){
		if($row['med_ct']){
			$row['med_kha'] = "খাওয়ার";
			if($row['med_d'] === "চলবে"){
				$row['med_cho'] = null;
				$row['med_dt'] = null;
			}elseif($row['med_d'] === " " || $row['med_d'] === ""){
				$row['med_cho'] = "চলবে";
				$row['med_dt'] = null;
			}else{
				$row['med_cho'] = "চলবে";
			}
		}else{
			$row['med_kha'] = null;
			$row['med_cho'] = null;
			$row['med_ct'] = null;
			$row['med_ctt'] = null;
			$row['med_ca'] = null;
			$row['med_d'] = null;
			$row['med_dt'] = null;
		}
	$row['rowN'] = $rownumber;
     $json[] = $row;
	 $rownumber++;
}
	}
	
	if (mysqli_num_rows($anti_pla_run) > 0){
	while($row = mysqli_fetch_array($anti_pla_run)){
		if($row['med_ct']){
			$row['med_kha'] = "খাওয়ার";
			if($row['med_d'] === "চলবে"){
				$row['med_cho'] = null;
				$row['med_dt'] = null;
			}elseif($row['med_d'] === " " || $row['med_d'] === ""){
				$row['med_cho'] = "চলবে";
				$row['med_dt'] = null;
			}else{
				$row['med_cho'] = "চলবে";
			}
		}else{
			$row['med_kha'] = null;
			$row['med_cho'] = null;
			$row['med_ct'] = null;
			$row['med_ctt'] = null;
			$row['med_ca'] = null;
			$row['med_d'] = null;
			$row['med_dt'] = null;
		}
	$row['rowN'] = $rownumber;
     $json[] = $row;
	 $rownumber++;
}
	}
	
	if (mysqli_num_rows($others_run) > 0){
	while($row = mysqli_fetch_array($others_run)){
		if($row['med_ct']){
			$row['med_kha'] = "খাওয়ার";
			if($row['med_d'] === "চলবে"){
				$row['med_cho'] = null;
				$row['med_dt'] = null;
			}elseif($row['med_d'] === " " || $row['med_d'] === ""){
				$row['med_cho'] = "চলবে";
				$row['med_dt'] = null;
			}else{
				$row['med_cho'] = "চলবে";
			}
		}else{
			$row['med_kha'] = null;
			$row['med_cho'] = null;
			$row['med_ct'] = null;
			$row['med_ctt'] = null;
			$row['med_ca'] = null;
			$row['med_d'] = null;
			$row['med_dt'] = null;
		}
	$row['rowN'] = $rownumber;
     $json[] = $row;
	 $rownumber++;
}
	}
$rowCount = sizeof(array_column($json, null, 'visit_number'));
$json[0]['rowcount'] = $rowCount;
	$Response[]=$json;
	echo json_encode($Response);
}else {
	$bndr_id = "No Data"; 
	
	$Response[]=array("bndr_id" => $bndr_id);
	echo json_encode($Response);
}
?>