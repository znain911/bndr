<?php 
$connect = mysqli_connect('localhost','bndr','nDYqzGnJZyWgyTPD','bndr');

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData, true);

$GuideBook = $DecodedData["GuideBook"];
$patientId = $DecodedData["patientId"];
$phoneNumber = $DecodedData["phoneNumber"];
$email = $DecodedData["email"];
$maritalStatus = $DecodedData["maritalStatus"];
$date = $DecodedData["date"];
$age = $DecodedData["age"];
$gender = $DecodedData["gender"];
$division = $DecodedData["division"];
$district = $DecodedData["district"];
$upazila = $DecodedData["upazila"];
$address = $DecodedData["address"];
$postalCode = $DecodedData["postalCode"];
$expense = $DecodedData["expense"];
$employment = $DecodedData["employment"];
$education = $DecodedData["education"];

$query1 = "update bndr.starter_patients

set additional_number = '$phoneNumber',
patient_email = '$email',
patient_marital_status = '$maritalStatus',
patient_dateof_birth = '$date',
patient_age = '$age',
patient_gender ='$gender',
patient_division_id = '$division',
patient_district_id = '$district',
patient_upazila_id = '$upazila',
patient_address = '$address',
patient_postal_code = '$postalCode'

where bndr.starter_patients.patient_id = '$patientId';";

$query_run = mysqli_query($connect,$query1);

$profcheck = "SELECT profinfo_patient_id FROM starter_patient_profinfo
		where profinfo_patient_id = '$patientId'";
	
	$profrun = mysqli_query($connect,$profcheck);
	if($profrun !== null){
		$updtaeprofile = "update starter_patient_profinfo
			set profinfo_mothly_income = '$expense',
			profinfo_education = '$education',
			profinfo_profession = '$employment'
			where profinfo_patient_id = '$patientId';
		";
		$updateprofile_run = mysqli_query($connect,$updtaeprofile);
	}

if (mysqli_affected_rows($connect) > 0){
	
		$message = "Data Changed";

}else {
	$message = "No Data";
}	
	$Response[]=array("Message" => $message);
	echo json_encode($Response);

?>