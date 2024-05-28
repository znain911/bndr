<?php 
$connect = mysqli_connect('localhost','bndr','nDYqzGnJZyWgyTPD','bndr');

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData, true);

$pid = $DecodedData["pid"];
$vdate = $DecodedData["vdate"];
$date1 = null;
$date2 = null;
if (substr_count( $vdate,",") === 1){
						list($dayMonth,$year) = explode(',', $vdate);
						list($day,$month) = explode(' ', $dayMonth);
						$fnvd= $year.'-'.$month.'-'.$day;
						$date1 = date("Y-m-d", strtotime($fnvd));
						$date2 = date("d/m/Y", strtotime($fnvd));
					}

$query = "SELECT * FROM `pres_image` where patient_id = '$pid' and visit_date = '$date1' ";

$query_run = mysqli_query($connect,$query);

if (mysqli_num_rows($query_run) > 0){
	$rows = mysqli_fetch_all($query_run);
	$images = [];
	
	foreach($rows as $row){
		if($row[2] === 'Case History'){
			$link = 'https://app.bndr-org.com.bd/caseHistory/'.$row[1].'/'.$row[4];
		}else{
			$link = 'https://app.bndr-org.com.bd/progress/'.$row[1].'/'.$row[4];
		}
		//$link = 'https://app.bndr-org.com.bd/'.$row[2].'/'.$row[1].'/'.$row[4];
		array_push($images, ['url' => $link]);
	}
	
	
	echo json_encode($images);
}else {
	$query = "SELECT * FROM `pres_image` where patient_id = '$pid' and visit_date = '$date2' ";
	
	$query_run = mysqli_query($connect,$query);

	if (mysqli_num_rows($query_run) > 0){
		$rows = mysqli_fetch_all($query_run);
		$images = [];
		
		foreach($rows as $row){
			if($row[2] === 'Case History'){
			$link = 'https://app.bndr-org.com.bd/caseHistory/'.$row[1].'/'.$row[4];
		}else{
			$link = 'https://app.bndr-org.com.bd/progress/'.$row[1].'/'.$row[4];
		}
			array_push($images, ['url' => $link]);
		}
		
		
		echo json_encode($images);
	}else{
	$bndr_id = "No Data"; 
	
	$Response[]=array("bndr_id" => $bndr_id);
	echo json_encode($Response);
	}
}
?>