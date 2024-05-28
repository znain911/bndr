<?php 
$connect = mysqli_connect('localhost','bndr','nDYqzGnJZyWgyTPD','bndr');

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData, true);

$guide_book = $DecodedData["GuideBook"];
$password = $DecodedData["Password"];


$query = "SELECT patient_id,patient_entryid as bndr_id,patient_name,patient_phone,additional_number,patient_guide_book, patient_gender,patient_idby_center,patient_email,org_name,
date_format(patient_create_date, '%d-%c-%Y') as patient_create_date,date_format(patient_dateof_birth, '%d-%c-%Y') as patient_dateof_birth,patient_age,
patient_nid,division_name,district_name,division_id,district_id,upazila_id,upazila_name,patient_address,patient_postal_code,profinfo_mothly_income,profinfo_profession
,profinfo_education,patient_marital_status,starter_centers.orgcenter_name,starter_centers_visit.orgcenter_name as visit_center
,fbg,t_chol,2hag as twohag,rbg,tg,esr,ldl_c,hdl_c,post_meal_bg,s_creatinine,hba1c,sgpt,urine_albumin,
ecg_abnormals,urine_acetone,usg_abnormals,hb,tc,dc_e,dc_m,dc_n,dc_z,date_format(eyeexam_date, '%d %b, %Y') as eyeexam_date,eyeexam_doctor_name
,eyeexam_left_eye,eyeexam_right_eye,eyeexam_treatment,eyeexam_other,date_format(footexm_date, '%d %b, %Y') as footexm_date
,footexm_doctor_name,footexmprfl_arteria_dorsalis_predis_present_left,footexmprfl_arteria_dorsalis_predis_present_right,footexmprfl_arteria_dorsalis_predis_absent_left
,footexmprfl_arteria_dorsalis_predis_absent_right,footexmprfl_posterior_tribila_present_left,footexmprfl_posterior_tribila_present_right
,footexmprfl_posterior_tribila_absent_left,footexmprfl_posterior_tribila_absent_right,footexmsns_monofilament_present_left,footexmsns_monofilament_present_right
,footexmsns_monofilament_absent_left,footexmsns_monofilament_absent_right,footexmsns_tuning_fork_present_left,footexmsns_tuning_fork_present_right
,footexmsns_tuning_fork_absent_left,footexmsns_tuning_fork_absent_right,height,weight,hip,waist,sitting_sbp,sitting_dbp,standing_sbp,standing_dbp,password, date_format(visit_date, '%d %b, %Y') as visit_date,visit_number 

FROM bndr.starter_patients
left join bndr.starter_patient_visit on bndr.starter_patient_visit.visit_patient_id = bndr.starter_patients.patient_id
left join bndr.starter_visit_general_examinations_new on bndr.starter_visit_general_examinations_new.generalexam_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_centers_visit on bndr.starter_centers_visit.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
left join bndr.starter_visit_laboratory_main on bndr.starter_visit_laboratory_main.labinvs_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_eye_examinations on bndr.starter_visit_eye_examinations.eyeexam_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_foot_examinations on bndr.starter_visit_foot_examinations.footexm_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_foot_examinations_periferals on bndr.starter_visit_foot_examinations_periferals.footexmprfl_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_visit_foot_examinations_sensation on bndr.starter_visit_foot_examinations_sensation.footexmsns_visit_id = bndr.starter_patient_visit.visit_id
left join bndr.starter_organizations on bndr.starter_organizations.org_id = bndr.starter_patients.patient_org_id
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patients.patient_org_centerid
left join bndr.starter_divisions on bndr.starter_divisions.division_id = bndr.starter_patients.patient_division_id
left join bndr.starter_districts on bndr.starter_districts.district_id = bndr.starter_patients.patient_district_id
left join bndr.starter_upazilas on bndr.starter_upazilas.upazila_id = bndr.starter_patients.patient_upazila_id
left join bndr.starter_patient_profinfo on bndr.starter_patient_profinfo.profinfo_patient_id = bndr.starter_patients.patient_id
where ( patient_guide_book = '$guide_book' or patient_idby_center = '$guide_book' or patient_phone = '$guide_book'
	or patient_nid = '$guide_book' ) and password = '$password' 
order by visit_number desc";

$query_run = mysqli_query($connect,$query);

if (mysqli_num_rows($query_run) > 0){
	while($row = mysqli_fetch_array($query_run)){
     $json[] = $row;
}
	$rowCount = count($json);
	$json[0]['rowcount'] = $rowCount;
	$Response[]=$json;
	echo json_encode($Response);
}else {
	$bndr_id = "No Data"; 
	
	$Response[]=array("bndr_id" => $bndr_id);
	echo json_encode($Response);
}
?>