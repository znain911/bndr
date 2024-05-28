<?php require_once APPPATH.'modules/common/header.php' ?>
<?php
    $url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 60; URL=$url1");
	$ldate = $this->Dashboard_model->latest_date_raj();
	$date = $ldate[0]['patient_create_date'];
	$date = str_replace(' ', '', $date);
	$date = str_replace(':', 'A', $date);
	
	
	$postData = array(
						"date" => $date, );
	
	$data = http_build_query($postData);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://103.148.74.74/bndrAPI/api.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	// In real life you should use something like:
	// curl_setopt($ch, CURLOPT_POSTFIELDS, 
	//          http_build_query(array('postvar1' => 'value1')));

	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);
	$curlinfo = curl_getinfo($ch);

	curl_close ($ch);
	
	$decode_output = json_decode($server_output);
	
	$decode_output2 = $decode_output[0];
	//print_r($decode_output);
	if(isset($decode_output2->name)){//print_r($decode_output2->name);
		echo "No new data found - ".date('d/m/Y h:i:s a', time());
	}else{
	foreach($decode_output2 as $key => $value) {
		if(isset($value->patient_dateof_birth)){
		$dateof_birth         = $value->patient_dateof_birth;
		}else{
			$dateof_birth =null;
		}
		$diff = null;
		if($dateof_birth || $dateof_birth !== ' '){
		    $today = date("Y-m-d");
			$diff = date_diff(date_create($dateof_birth), date_create($today));
			
		}
		if(isset($value->patient_entryid)){
			
		$patient_form_version         = 'V2';
         $patient_entryid         = $value->patient_entryid;
         $patient_gender         = $value->patient_gender;
         $patient_blood_group         = $value->patient_blood_group;
         $patient_phone         = $value->patient_phone;
         $patient_org_id         = 54;
         $patient_org_centerid   = 86;
         $patient_division_id   = 5;
         $patient_district_id   = 24;
         $patient_name         = $value->patient_name;
         $patient_address         = $value->patient_address;
         $patient_nid         = $value->patient_nid;
         $patient_guide_book         = $value->patient_guide_book;
        //$patient_marital_status         = $value->patient_marital_status;
         $patient_dateof_birth         = $value->patient_dateof_birth;
         $patient_age         = $diff->format('%y');
         $patient_admitted_user_type         = "Operator";
         $patient_regfee_amount         = '20';
         $patient_payment_status         = '1';
         $patient_create_date         = $value->patient_create_date;
         $familyinfo_father_name         = $value->familyinfo_father_name;
         $familyinfo_spouse_name         = $value->familyinfo_spouse_name;
         $patient_is_registered         = 'YES';
		 
		 if($familyinfo_spouse_name){
			 $patient_marital_status = 'Married';
		 }else {
			 $patient_marital_status = 'Unmarried';
		 }
		 
		 $name = $value->patient_admitted_by;
		 if($name){
			 $operator_id = $this->Dashboard_model->get_operator_id($name,$patient_org_id);
			 if($operator_id){
			 $op_id = intval($operator_id['operator_id']);
			 }
		 }
		 
		$data = array(
		'patient_form_version'        => 'V2',
        'patient_entryid'   => $patient_entryid,
        'patient_gender'       => $patient_gender,
        'patient_blood_group'         => $patient_blood_group,
        'patient_phone'         => $patient_phone,
        'patient_org_id'         => 54,
        'patient_org_centerid'   => 86,
        'patient_division_id'  => 5,
        'patient_district_id'   => 24,
        'patient_name'         => $patient_name,
        'patient_address'        => $patient_address,
        'patient_nid'        => $patient_nid,
        'patient_guide_book'         => $patient_guide_book,
        'patient_marital_status'         => $patient_marital_status,
        'patient_dateof_birth'        => $patient_dateof_birth,
        'patient_age'        => $patient_age,
        'patient_admitted_by'        => $op_id,
        'patient_admitted_user_type'         => "Operator",
        'patient_regfee_amount'         => '20',
        'patient_payment_status'        => '1',
        'patient_create_date'         => $patient_create_date,
        'patient_is_registered'         => 'YES',
        
		);
		
		if($data){
			
			$ins_id = $this->Dashboard_model->rajbndr($data);
			$patient_id = $this->db->insert_id($ins_id);
		}
		if($familyinfo_father_name || $familyinfo_spouse_name){
			$pid = $this->Dashboard_model->get_patient_id($patient_entryid);
			$patient_id = $pid['patient_id'];
			$data2 = array(
					
					'familyinfo_patient_id'   => $patient_id,
					'familyinfo_father_name'   => $familyinfo_father_name,
					'familyinfo_spouse_name'   => $familyinfo_spouse_name,
			);
			if($data){
			
			$ins_id = $this->Dashboard_model->rajbndrfamily($data2);
			$patient_id = $this->db->insert_id($ins_id);
		}
			//print_r($data2);
		//echo "<br>";
		}
		}
		// echo $patient_entryid;
		
		// echo "<br>";
		// echo $patient_age;
		//print_r($decode_output2->name);
		//echo "success";
		
		
		
	}
	echo "Rajshahi success - ".date('d/m/Y h:i:s a', time());
	}
	
	//echo $date;
?>

<?php require_once APPPATH.'modules/common/footer.php' ?>