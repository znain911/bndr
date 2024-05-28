<?php 
$connect = mysqli_connect('localhost','bndr','nDYqzGnJZyWgyTPD','bndr');

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData, true);

$guide_book = $DecodedData["GuideBook"];
$pass = $DecodedData["Password"];

$query = "update bndr.starter_patients
	set password = '$pass'
	where bndr.starter_patients.patient_guide_book = '$guide_book' or patient_idby_center = '$guide_book' or patient_phone = '$guide_book'
	or patient_nid = '$guide_book';";

$query_run = mysqli_query($connect,$query);

if (mysqli_affected_rows($connect) > 0){
	$message = "New password inserted";
	
	
}else {
	$message = "New password insert failed";
}	
	$Response[]=array("Message" => $message);
	echo json_encode($Response);

?>