<?php 
$connect = mysqli_connect('localhost','bndr','nDYqzGnJZyWgyTPD','bndr');

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData, true);

$guide_book = $DecodedData["GuideBook"];

$query = "SELECT patient_entryid,patient_name,patient_phone,patient_guide_book,patient_idby_center,orgcenter_name FROM bndr.starter_patients
left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patients.patient_org_centerid
where patient_guide_book = '$guide_book' or patient_idby_center = '$guide_book' or patient_phone = '$guide_book'
	or patient_nid = '$guide_book';";

$query_run = mysqli_query($connect,$query);

if (mysqli_num_rows($query_run) > 0){
	$row = mysqli_fetch_assoc($query_run);
	$bndr_id = $row["patient_entryid"];
	$patient_name = $row["patient_name"];
	$patient_phone = $row["patient_phone"];
	$patient_guide_book_no = $row["patient_guide_book"];
	$patient_idby_center = $row["patient_idby_center"];
	$center_name = $row["orgcenter_name"];
	
	$Response[]=array("bndr_id" => $bndr_id, "patient_name" => $patient_name, "patient_phone" => $patient_phone, "patient_guide_book_no" => $patient_guide_book_no, "patient_idby_center" => $patient_idby_center, "center_name" => $center_name);
	echo json_encode($Response);
}else {
	$bndr_id = "No Data"; 
	
	$Response[]=array("bndr_id" => $bndr_id);
	echo json_encode($Response);
}
?>