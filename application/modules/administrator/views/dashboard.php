<?php require_once APPPATH.'modules/common/header.php' ?>

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
 $followup_percentage = ($total_followup_count / $total_visit)* 100;
 $casehistory_percentage = ($case_history_count / $total_visit)* 100;
 $followup_percentage = sprintf("%0.2f",$followup_percentage);
 $casehistory_percentage = sprintf("%0.2f",$casehistory_percentage);
 
 //total ptient filter
 
 $patient_female = [];
 $patient_male = [];
 // $today_patient_female = [];
 // $today_patient_male = [];
 //$total_items2024 = [];
 $total_items2023 = [];
 $total_items2022 = [];
 $total_items2021 = [];
 $total_items2020 = [];
 $total_items2019 = [];
 $total_items2018 = [];
 foreach($total_items as $key => $value) {
	// if($value['create_date'] === '2024') {
        // array_push($total_items2024, [$key => $value]);
    // }
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
	// if($value['patient_create_date'] >= date("Y-m-d")  ) {
        // array_push($today_total_reg, [$key => $value]);
    // }
	// if($value['patient_create_date'] >= date("Y-m-d") && $value['patient_gender'] === '1') {
        // array_push($today_patient_female, [$key => $value]);
    // }
	// if($value['patient_create_date'] >= date("Y-m-d") && $value['patient_gender'] === '0') {
        // array_push($today_patient_male, [$key => $value]);
    // }
 }
 
  $patient_female_count = count($patient_female);
  $patient_male_count = count($patient_male);
  $today_total_reg_count = count($total_items);
  
  $female_percentage = ($patient_female_count / $today_total_reg_count)* 100;
 $female_percentage = sprintf("%0.2f",$female_percentage);
 
 $male_percentage = ($patient_male_count / $today_total_reg_count)* 100;
 $male_percentage = sprintf("%0.2f",$male_percentage);
  // $today_patient_female_count = count($today_patient_female);
  // $today_patient_male_count = count($today_patient_male);
  
  
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
  // if(isset($_COOKIE['type2dm_count'])){
	// $type2dm_count= $_COOKIE['type2dm_count'];
	
	// setcookie ("type2dm_count", "", time() - 10);
	
// }
  $type1dm_count = count($type1dm);
  // if(isset($_COOKIE['type1dm_count'])){
	// $type1dm_count= $_COOKIE['type1dm_count'];
	
	// setcookie ("type1dm_count", "", time() - 10);
	
// }
  $igt_count = count($igt);
   
  $ifg_count = count($ifg);

  $gdm_count = count($gdm);

  $others_count = count($others);
  
  
  //comorbidity
  $cad = [];
  $foot = [];
  $gastro = [];
  $stroke = [];
  $nephropathy = [];
  $hypoglycaemia = [];
  $pvd = [];
  $retinopathy = [];
  $dka = [];
  $hypertension = [];
  $neuropathy = [];
  $hhs = [];
  $dyslipidaemia = [];
  $skin = [];
  $others = [];
  foreach($all_comorbidity as $key => $value) {
		if($value['vcomplication_name'] === 'CAD') {
        array_push($cad, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Foot Complications') {
        array_push($foot, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Gastro Complications') {
        array_push($gastro, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Stroke') {
        array_push($stroke, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Nephropathy') {
        array_push($nephropathy, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Hypoglycaemia') {
        array_push($hypoglycaemia, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'PVD') {
        array_push($pvd, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Retinopathy') {
        array_push($retinopathy, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'DKA') {
        array_push($dka, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Hypertension') {
        array_push($hypertension, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Neuropathy') {
        array_push($neuropathy, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'HHS') {
        array_push($hhs, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Dyslipidaemia') {
        array_push($dyslipidaemia, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Skin Disease') {
        array_push($skin, [$key => $value]);
		}
		if($value['vcomplication_name'] === 'Others' || $value['vcomplication_name'] === 'OTHERS' || $value['vcomplication_name'] === 'Other' ) {
        array_push($others, [$key => $value]);
		}
  }
  
  $totat_omorbidity = count($all_comorbidity);
  $cad_count = count($cad);
  $foot_count = count($foot);
  $gastro_count = count($gastro);
  $stroke_count = count($stroke);
  $nephropathy_count = count($nephropathy);
  $hypo_count = count($hypoglycaemia);
  $pvd_count = count($pvd);
  $retino_count = count($retinopathy);
  $dka_count = count($dka);
  $hyper_count = count($hypertension);
  $neuro_count = count($neuropathy);
  $hhs_count = count($hhs);
  $dyslipidaemia_count = count($dyslipidaemia);
  $skin_count = count($skin);
  $others_count = count($others);
  
  $foot_count_percentage = ($foot_count / $totat_omorbidity)* 100;
  $cad_count_percentage = ($cad_count / $totat_omorbidity)* 100;
  $gastro_count_percentage = ($gastro_count / $totat_omorbidity)* 100;
  $stroke_count_percentage = ($stroke_count / $totat_omorbidity)* 100;
  $nephropathy_count_percentage = ($nephropathy_count / $totat_omorbidity)* 100;
  $hypo_count_percentage = ($hypo_count / $totat_omorbidity)* 100;
  $pvd_count_percentage = ($pvd_count / $totat_omorbidity)* 100;
  $retino_count_percentage = ($retino_count / $totat_omorbidity)* 100;
  $dka_count_percentage = ($dka_count / $totat_omorbidity)* 100;
  $hyper_count_percentage = ($hyper_count / $totat_omorbidity)* 100;
  $neuro_count_percentage = ($neuro_count / $totat_omorbidity)* 100;
  $hhs_count_percentage = ($hhs_count / $totat_omorbidity)* 100;
  $dyslipidaemia_count_percentage = ($dyslipidaemia_count / $totat_omorbidity)* 100;
  $skin_count_percentage = ($skin_count / $totat_omorbidity)* 100;
  $others_count_percentage = ($others_count / $totat_omorbidity)* 100;
  
  $cad_count_percentage = sprintf("%0.2f",$cad_count_percentage);
  $foot_count_percentage = sprintf("%0.2f",$foot_count_percentage);
  $gastro_count_percentage = sprintf("%0.2f",$gastro_count_percentage);
  $stroke_count_percentage = sprintf("%0.2f",$stroke_count_percentage);
  $nephropathy_count_percentage = sprintf("%0.2f",$nephropathy_count_percentage);
  $hypo_count_percentage = sprintf("%0.2f",$hypo_count_percentage);
  $pvd_count_percentage = sprintf("%0.2f",$pvd_count_percentage);
  $retino_count_percentage = sprintf("%0.2f",$retino_count_percentage);
  $dka_count_percentage = sprintf("%0.2f",$dka_count_percentage);
  $hyper_count_percentage = sprintf("%0.2f",$hyper_count_percentage);
  $neuro_count_percentage = sprintf("%0.2f",$neuro_count_percentage);
  $hhs_count_percentage = sprintf("%0.2f",$hhs_count_percentage);
  $dyslipidaemia_count_percentage = sprintf("%0.2f",$dyslipidaemia_count_percentage);
  $skin_count_percentage = sprintf("%0.2f",$skin_count_percentage);
  $others_count_percentage = sprintf("%0.2f",$others_count_percentage);
  
  //BMI
  $overweight = 0;
  foreach($bmi as $key => $value) {
	  if($value['height'] !== null && $value['weight'] !== null){
		  list($height, $height_unit)= explode(' ', $value['height']);
		  if ($height_unit === 'cm'){
			  list($weight, $weight_unit)= explode(' ', $value['weight']);
			  
			  $height =intval($height);
			  $weight =intval($weight);
			  if($height >0){
				  $height = $height/100;
			  $bmi_number = ($weight) / ($height*$height);
			  if($bmi_number >= 25){
				  $overweight++;
			  }
			  }
			  
		  }elseif($height_unit === 'ft' || $height_unit === 'feet'){
			  list($foot, $foot_unit,$inch)= explode(' ', $value['height']);
			  
			  list($weight, $weight_unit)= explode(' ', $value['weight']);
			  
			  $foot =intval($foot);
			  $weight =intval($weight);
			  $inch =intval($inch);
			  
			  $foot = $foot * 0.3048;
			  $inch = $inch * 0.0254;
			  $meter = $foot + $inch;
			  if($meter >0){
				  $bmi_number = ($weight) / ($meter*$meter);
				  if($bmi_number >= 25){
				  $overweight++;
			  }
			  }
		  }elseif($height_unit === 'Inch'){
			  list($inch)= explode(' ', $value['height']);
			  
			  list($weight, $weight_unit)= explode(' ', $value['weight']);
			  
			  $inch =intval($inch);
			  $meter = $inch * 0.0254;
			  if($meter >0){
				  $bmi_number = ($weight) / ($meter*$meter);
				  if($bmi_number >= 25){
				  $overweight++;
			  }
			  }
			  
		  }
	  }
	  
  }
$total_bmi = count($bmi);
$bmi_percentage = ($overweight / $total_bmi)* 100;
$bmi_percentage = sprintf("%0.2f",$bmi_percentage);

// blood sugar
$fbg = [];
$twohag = [];
$hba1c = [];
$tchol = [];
$ldlc = [];
$hdlc_m = [];
$hdlc_f = [];
  foreach($bs as $key => $value) {
	  if($value['fbg'] !== null) {
		  $fbg_check = intval($value['fbg']);
		  if($fbg_check < 7){
			  array_push($fbg, [$key => $value]);
		  }
        
		}
		
		if($value['2hag'] !== null) {
		  $twohag_check = intval($value['2hag']);
		  if($twohag_check < 11.1){
			  array_push($twohag, [$key => $value]);
		  }
        
		}
		
		if($value['hba1c'] !== null) {
		  $hba1c_check = intval($value['hba1c']);
		  if($hba1c_check < 7){
			  array_push($hba1c, [$key => $value]);
		  }
        
		}
		
		if($value['t_chol'] !== null) {
		  $tchol_check = intval($value['t_chol']);
		  if($tchol_check < 200){
			  array_push($tchol, [$key => $value]);
		  }
        
		}
		if($value['ldl_c'] !== null) {
		  $ldlc_check = intval($value['ldl_c']);
		  if($ldlc_check < 100){
			  array_push($ldlc, [$key => $value]);
		  }
        
		}
		if($value['hdl_c'] !== null && $value['patient_gender'] !== '0') {
		  $hdlc_m_check = intval($value['hdl_c']);
		  if($hdlc_m_check > 40){
			  array_push($hdlc_m, [$key => $value]);
		  }
        
		}
		if($value['hdl_c'] !== null && $value['patient_gender'] !== '1') {
		  $hdlc_f_check = intval($value['hdl_c']);
		  if($hdlc_f_check > 50){
			  array_push($hdlc_f, [$key => $value]);
		  }
        
		}
  }
  
  $totat_bs = count($bs);
  $fbg_count = count($fbg);
  $hba1c_count = count($hba1c);
  $twohag_count = count($twohag);
  $tchol_count = count($tchol);
  $ldlc_count = count($ldlc);
  $hdlc_m_count = count($hdlc_m);
  $hdlc_f_count = count($hdlc_f);
  
  $fbg_count_percentage = ($fbg_count / $totat_bs)* 100;
  $hba1c_count_percentage = ($hba1c_count / $totat_bs)* 100;
  $twohag_count_percentage = ($twohag_count / $totat_bs)* 100;
  $tchol_count_percentage = ($tchol_count / $totat_bs)* 100;
  $ldlc_count_percentage = ($ldlc_count / $totat_bs)* 100;
  $hdlc_m_count_percentage = ($hdlc_m_count / $totat_bs)* 100;
  $hdlc_f_count_percentage = ($hdlc_f_count / $totat_bs)* 100;
  
  $fbg_count_percentage = sprintf("%0.2f",$fbg_count_percentage);
  $twohag_count_percentage = sprintf("%0.2f",$twohag_count_percentage);
  $hba1c_count_percentage = sprintf("%0.2f",$hba1c_count_percentage);
  $tchol_count_percentage = sprintf("%0.2f",$tchol_count_percentage);
  $hdlc_m_count_percentage = sprintf("%0.2f",$hdlc_m_count_percentage);
  $hdlc_f_count_percentage = sprintf("%0.2f",$hdlc_f_count_percentage);
  $ldlc_count_percentage = sprintf("%0.2f",$ldlc_count_percentage);
  
  //life style 
  $l_style = [];
  
  foreach($ls as $key => $value) {
	  
	  if($value['finaltreat_dietary_advice'] !== null) {
		  $l_style_check = intval($value['finaltreat_dietary_advice']);
		  if($l_style_check > 0){
			  array_push($l_style, [$key => $value]);
		  }
        
		}
	  
  }
  
  $l_style_count = count($l_style);
  
  $l_style_count_percentage = ($l_style_count / $total_followup_count)* 100;
  
  $l_style_count_percentage = sprintf("%0.2f",$l_style_count_percentage);
  
   //oads ,insulin with life style

  $l_style_oads = [];
  $l_style_ins = [];
  $l_style_oadsIns = [];
  
  

  //meds
  $ls_all_meds = [];
  $oads = [];
  $insulin = [];
  $oads_insulin = [];
  foreach($all_med as $key => $value) {
	  
	  if($value['oads_name'] !== null && $value['finaltreat_dietary_advice'] !== null) {
		  
		  
			  $l_style_check = intval($value['finaltreat_dietary_advice']);
		  if($l_style_check > 0){
			  array_push($l_style_oads, [$key => $value]);
		  }
		  
        
		}
		
	if($value['insulin_name'] !== null && $value['finaltreat_dietary_advice'] !== null) {
		  
		  
			  $l_style_check = intval($value['finaltreat_dietary_advice']);
		  if($l_style_check > 0){
			  array_push($l_style_ins, [$key => $value]);
		  }
		  
        
		}
		
	if($value['insulin_name'] !== null && $value['finaltreat_dietary_advice'] !== null && $value['oads_name'] !== null) {
		  
		  
			  $l_style_check = intval($value['finaltreat_dietary_advice']);
		  if($l_style_check > 0){
			  array_push($l_style_oadsIns, [$key => $value]);
		  }
		  
        
		}
		
	  if($value['insulin_name'] !== null || $value['oads_name'] !== null || $value['anti_htn_name'] !== null || $value['anti_lipid_name'] !== null 
	   || $value['anti_obesity_name'] !== null  || $value['other_name'] !== null ) {
		
		
			$all_med_ls_int = intval($value['finaltreat_dietary_advice']);
			if($all_med_ls_int >0){
				array_push($ls_all_meds, [$key => $value]);
			
			
		}
		  
		
		}
		
	if($value['oads_name'] !== null) {
			  array_push($oads, [$key => $value]);
		}
	if($value['insulin_name'] !== null) {
			  array_push($insulin, [$key => $value]);
		}
	if($value['insulin_name'] !== null && $value['oads_name'] !== null) {
			  array_push($oads_insulin, [$key => $value]);
		}
  }
  
  $ls_all_meds_count = count($ls_all_meds);
  $oads_count = count($oads);
  $insulin_count = count($insulin);
  $oads_insulin_count = count($oads_insulin);
  $l_style_oads_count = count($l_style_oads);
  $l_style_ins_count = count($l_style_ins);
  $l_style_oadsIns_count = count($l_style_oadsIns);
  
  $ls_all_meds_count_percentage = ($ls_all_meds_count / $total_followup_count)* 100;
  $oads_count_percentage = ($oads_count / $total_followup_count)* 100;
  $insulin_count_percentage = ($insulin_count / $total_followup_count)* 100;
  $oads_insulin_count_percentage = ($oads_insulin_count / $total_followup_count)* 100;
  $l_style_oads_count_percentage = ($l_style_oads_count / $total_followup_count)* 100;
  $l_style_ins_count_percentage = ($l_style_ins_count / $total_followup_count)* 100;
  $l_style_oadsIns_count_percentage = ($l_style_oadsIns_count / $total_followup_count)* 100;
  
  $ls_all_meds_count_percentage = sprintf("%0.2f",$ls_all_meds_count_percentage);
  $oads_count_percentage = sprintf("%0.2f",$oads_count_percentage);
  $insulin_count_percentage = sprintf("%0.2f",$insulin_count_percentage);
  $oads_insulin_count_percentage = sprintf("%0.2f",$oads_insulin_count_percentage);
  $l_style_oads_count_percentage = sprintf("%0.2f",$l_style_oads_count_percentage);
  $l_style_ins_count_percentage = sprintf("%0.2f",$l_style_ins_count_percentage);
  $l_style_oadsIns_count_percentage = sprintf("%0.2f",$l_style_oadsIns_count_percentage);
  
 
	?>
	<div>
		
		<h2 class="maintext"> Total Registered Patient till <?php echo date("d M Y");?></h2>
			

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
		<h2 class="maintext"> COMPLICATION / COMORBIDITY</h2>
			

		<div class="border-bottom">  </div>
		
		<div class="container margincontainer">
		
			<div class="row">
		
				<div class="col-sm-3">
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style ='margin-right: 40%;'><?php echo $cad_count;?>  (<?php echo $cad_count_percentage;?>%)<br>CAD</h5>

						</div>
				</div>
				<div class="col-sm-3">
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 15%;'><?php echo $foot_count;?>  (<?php echo $foot_count_percentage;?>%)<br> Foot Complications</h5>

						</div>
				</div>
				<div class="col-sm-3">
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 15%;'><?php echo $gastro_count;?>  (<?php echo $gastro_count_percentage;?>%)<br> Gastro  Complications</h5>

						</div>
				</div>
				<div class="col-sm-3">
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 37%;'><?php echo $stroke_count;?>  (<?php echo $stroke_count_percentage;?>%)<br>Stroke</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style ='margin-right: 38%;'><?php echo $nephropathy_count;?>  (<?php echo $nephropathy_count_percentage;?>%)<br>Nephropathy</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style ='margin-right: 27%;'><?php echo $hypo_count;?>  (<?php echo $hypo_count_percentage;?>%)<br>Hypoglycaemia</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 45%;'><?php echo $pvd_count;?>  (<?php echo $pvd_count_percentage;?>%)<br>PVD</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1"><?php echo $retino_count;?>  (<?php echo $retino_count_percentage;?>%)<br>Retinopathy</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 42%;'><?php echo $dka_count;?>  (<?php echo $dka_count_percentage;?>%)<br>DKA</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style ='margin-right: 31%;'><?php echo $hyper_count;?>  (<?php echo $hyper_count_percentage;?>%)<br>Hypertension</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1"><?php echo $neuro_count;?>  (<?php echo $neuro_count_percentage;?>%)<br>Neuropathy</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 40%;'><?php echo $hhs_count;?>  (<?php echo $hhs_count_percentage;?>%)<br>HHS</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1"><?php echo $dyslipidaemia_count;?>  (<?php echo $dyslipidaemia_count_percentage;?>%)<br>Dyslipidaemia</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1"><?php echo $skin_count;?>  (<?php echo $skin_count_percentage;?>%)<br>Skin Disease</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic3.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 40%;'><?php echo $others_count;?>  (<?php echo $others_count_percentage;?>%)<br>Others</h5>

						</div>
				</div>
			
			
			
			</div>
		</div>
			
			

	</div>
	
	<div>
		<h2 class="maintext"> Level Of Control (BMI) </h2>
		<div class="border-bottom">  </div>
		
		<div class="container margincontainer">
		
			<div class="row">
			
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic4.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 30%;'><?php echo $overweight;?>  (<?php echo $bmi_percentage;?>%)<br>BMI(overweight)</h5>

						</div>
				</div>
			
			</div>
		</div>
		
	</div>
	
	<div>
		<h2 class="maintext"> Level Of Control (Blood Sugar) </h2>
		<div class="border-bottom">  </div>
		
		<div class="container margincontainer">
		
			<div class="row">
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic5.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 25%;'><?php echo $fbg_count;?>  (<?php echo $fbg_count_percentage;?>%)<br>Fasting(< 7 mmol)</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic5.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 30%;'><?php echo $twohag_count;?>  (<?php echo $twohag_count_percentage;?>%)<br>ABF(< 11.1 mmol)</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic5.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 40%;'><?php echo $hba1c_count;?>  (<?php echo $hba1c_count_percentage;?>%)<br>Hba1c(< 7 %)</h5>

						</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<div>
		<h2 class="maintext"> Level Of Control (Lipid) </h2>
		<div class="border-bottom">  </div>
		
		<div class="container margincontainer">
		
			<div class="row">
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic5.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 5%;'><?php echo $tchol_count;?>  (<?php echo $tchol_count_percentage;?>%)<br>Cholesterol(< 200 mg/dl)</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic5.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 20%;'><?php echo $ldlc_count;?>  (<?php echo $ldlc_count_percentage;?>%)<br>LDL-C(< 200 mg/dl)</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic5.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 25%;'><?php echo $hdlc_m_count;?>  (<?php echo $hdlc_m_count_percentage;?>%)<br>HDL-C(male > 40)</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic5.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 20%;'><?php echo $hdlc_f_count;?>  (<?php echo $hdlc_f_count_percentage;?>%)<br>HDL-C(female > 50)</h5>

						</div>
				</div>
				
				
			</div>
			
		</div>
	</div>
	
	<div>
		<h2 class="maintext"> Treatment Pattern </h2>
		<div class="border-bottom">  </div>
		
		<div class="container margincontainer">
		
			<div class="row">
			
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic6.png"/>
							<h5 class="float-right textstyle1" ><?php echo $l_style_count;?>  (<?php echo $l_style_count_percentage;?>%)<br>Life Style</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic6.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 25%;'><?php echo $l_style_oads_count;?>  (<?php echo $l_style_oads_count_percentage;?>%)<br>Life Style & OADs</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic6.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 25%;'><?php echo $l_style_ins_count;?>  (<?php echo $l_style_ins_count_percentage;?>%)<br>Life Style & Insulin</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = ''>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic6.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 5%;'><?php echo $l_style_oadsIns_count;?>  (<?php echo $l_style_oadsIns_count_percentage;?>%)<br>Life Style, OADs & Insulin</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic6.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 16%;'><?php echo $ls_all_meds_count;?>  (<?php echo $ls_all_meds_count_percentage;?>%)<br>Life Style & Medicine</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic6.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 30%;'><?php echo $oads_count;?>  (<?php echo $oads_count_percentage;?>%)<br>OADs</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic6.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 35%;'><?php echo $insulin_count;?>  (<?php echo $insulin_count_percentage;?>%)<br>Insulin</h5>

						</div>
				</div>
				
				<div class="col-sm-3" style = 'margin-top: 1%;'>
						<div class="div1">

							<img class="imagefile" src="<?php echo base_url('assets/'); ?>bndrpic6.png"/>
							<h5 class="float-right textstyle1" style = 'margin-right: 33%;'><?php echo $oads_insulin_count;?>  (<?php echo $oads_insulin_count_percentage;?>%)<br>OADs & Insulin</h5>

						</div>
				</div>
				
				
			</div>
		</div>
	</div>
	
		
	<h2 class="maintext">Annual patient Count </h2>
		<div class="border-bottom">  </div>
	<div class="container margincontainer">
		
			<div class="row">
		
		  <div class="col-sm-9">
			<canvas id="myChart1" width="400"></canvas>
		  </div>
			
		  <div class="col-sm-3">
			<h5 class="middle">Patient by Gender</h5>
			<canvas id="myChart2" width="400" Height="400"></canvas>
		  </div>

			</div>
		
	</div>


<div>

		<h2 class="maintext"> Type of glucose intolerance </h2>
		<div class="border-bottom">  </div>
		
		<div class="dropdown" style ="display: inline-block;margin-left: 8%;">
			<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="background: #028000bf; border: 1px solid #043902;color: white;border-radius: 12px;box-shadow: 1px 2px 4px 1px #bebfc3;">
			Select filter type
			<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<li class="dropdown-submenu">
					<a class="test" tabindex="-1" href="#">Weekly <span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li><input name='tgiweek' id = 'tgiweek'  type="week"></li>
					  
					</ul>
				</li>
				<li class="dropdown-submenu">
					<a class="test" tabindex="-1" href="#">Monthly <span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li><input name='tgiMonth'  type="month" id="tgiMonth"></li>
					  
					</ul>
				</li>
				
				<li class="dropdown-submenu">
					<a class="test" tabindex="-1" href="#">Yearly <span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li><input  class="form-control"  name="yeartgi" onload="clearThis(this.value)"  type="text" placeholder="--Year--"  id="yeartgi"></li>
					  
					</ul>
				</li>
				
			</ul>
		</div>
	
      <input type="submit" class="searchbutton1" value="Search" onclick="searchFilter()" style="height: 32px;" />
      <input type="submit" class="searchbutton1" value="All Data" onclick="searchFilter3()" style="height: 32px;" />

</div>


<div class="container margincontainer">
	
  <div class="row">

    <div class="col-sm-12" id = 'tgi1'>
      <canvas id="myChart3" width="400"></canvas>
	  
	  
		  <script type="text/javascript"> 

			  var ctx = document.getElementById("myChart3").getContext("2d");

			  var data = {
				labels: ["Type 2 DM", "Type 1 DM", "IGT", "IFG", "GDM", "Others"],
				datasets: [{
				  label: " <?php if(isset($_COOKIE['yeartgi'])){
				// $yeartgi= $_COOKIE['yeartgi'];
				// $tgiMonth= $_COOKIE['tgiMonth'];
				// $tgifrom= $_COOKIE['tgifrom'];
				// $tgito= $_COOKIE['tgito'];
				// if ($yeartgi){
					// echo '('.$yeartgi.')';
				// }
				// elseif ($tgiMonth){
					
					// echo '('.$tgiMonth.')';
				// }elseif ($tgifrom){
					
					// echo '( From  '.$tgifrom.'  to  '.$tgito.')';
				// }
				
				
				// setcookie ("yeartgi", "", time() - 5);
				// setcookie ("tgiMonth", "", time() - 5);
				// setcookie ("tgifrom", "", time() - 5);
				// setcookie ("tgito", "", time() - 5);
				
				
			}?>",
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
    </div>
  
    <!--<div class="col-sm-3">
      
      <canvas id="myChart4" width="400" Height="400"></canvas>
    </div>-->

  </div>

</div>

	 <div>
		
		<h2 class="maintext"> Organization </h2>
		<div class="border-bottom">  </div>
		
	
		<div style = ''>
			<select style = 'width: 20%;padding: 0px 12px; border: 1px solid #043902;border-radius: 12px;box-shadow: 1px 2px 4px 1px #bebfc3;height: 32px' class="dropdown3" id="selectedOrganization">
				<option value="" selected="selected">Select Organization</option>
					<?php 
						$orgs = $this->Dashboard_model->get_all_organizations();
						foreach($orgs as $org):
					?>
				<option style = 'background: white; color: black;' value="<?php echo $org['org_id']; ?>" ><?php echo $org['org_name']; ?></option>
					<?php endforeach; ?>
			</select>
			  
			<select style = 'width: 20%;padding: 0px 12px; border: 1px solid #043902;border-radius: 12px;box-shadow: 1px 2px 4px 1px #bebfc3;height: 32px' name="center" class="dropdown3" id="cenTers">
				<option  value="" selected="selected">Select Center</option>
			
			
			</select>
		
			<div class="dropdown" style ="display: inline-block;margin-left: 2%;">
				<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="background: #028000bf;padding: 0px 12px; border: 1px solid #043902;color: white;border-radius: 12px;box-shadow: 1px 2px 4px 1px #bebfc3;height: 32px">
				Select filter type
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li class="dropdown-submenu">
						<a class="test" tabindex="-1" href="#">Weekly <span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li><input name='tgiweek_org' id = 'tgiweek_org'  type="week"></li>
						  
						</ul>
					</li>
					<li class="dropdown-submenu">
						<a class="test" tabindex="-1" href="#">Monthly <span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li><input name='tgiMonth_org'  type="month" id="tgiMonth_org"></li>
						  
						</ul>
					</li>
					
					<li class="dropdown-submenu">
						<a class="test" tabindex="-1" href="#">Yearly <span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li><input  class="form-control"  name="yeartgi_org" onload="clearThis(this.value)"  type="text" placeholder="--Year--"  id="yeartgi_org"></li>
						  
						</ul>
					</li>
					
				</ul>
			</div>
			
			 <input type="submit" class="searchbutton1" value="Search" onclick="searchFilter2()" style="height: 32px;" />
		</div>

     

	</div>
	
	<div id = 'organization'>
		<div>
			
			<h2 class="maintext"> Total Registered Patient till <?php echo date("d M Y");?> </h2>
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

			<h2 class="maintext"> Annual Patient Count</h2>
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
		
			<h2 class="maintext"> Type of glucose intolerance </h2>
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
	</div>
	

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">

 function searchFilter() {
				
				var yeartgi = $('#yeartgi').val();
				var tgiMonth = $('#tgiMonth').val();
				var tgiweek = $('#tgiweek').val();
				
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>pfilter/dashboard_filter',
					data:'yeartgi='+yeartgi+'&tgiMonth='+tgiMonth+'&tgiweek='+tgiweek,
					dataType:'json',
					beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						
						 
						 
						// console.log(data.yeartgi);
						// document.cookie = "type2dm_count = " +data.type2dm_count ;
						// document.cookie = "type1dm_count = " +data.type1dm_count ;
						// document.cookie = "igt_count = " +data.igt_count ;
						// document.cookie = "ifg_count = " +data.ifg_count ;
						// document.cookie = "gdm_count = " +data.gdm_count ;
						// document.cookie = "others_count = " +data.others_count ;
						// document.cookie = "yeartgi = " +data.yeartgi ;
						// document.cookie = "tgiMonth = " +data.tgiMonth ;
						// document.cookie = "tgifrom = " +data.tgifrom ;
						// document.cookie = "tgito = " +data.tgito ;
						 // window.location.reload();
						 $('#tgi1').html(data.content);
						 $("#yeartgi").val(null);
						 $("#tgiMonth").val(null);
						 $("#tgiweek").val(null);
						 
					}else
					{
						return false;
					}
				}
					
					
				});
				
			}
	
	 function searchFilter3() {
				
				var yeartgi = $('#yeartgi').val();
				var tgiMonth = $('#tgiMonth').val();
				var tgiweek = $('#tgiweek').val();
				
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>pfilter/dashboard_filter',
					dataType:'json',
					beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						
						 
						 
						
						 $('#tgi1').html(data.content);
						 $("#yeartgi").val(null);
						 $("#tgiMonth").val(null);
						 $("#tgiweek").val(null);
						 
					}else
					{
						return false;
					}
				}
					
					
				});
				
			}
			
	function searchFilter2() {
				
				var yeartgi = $('#yeartgi_org').val();
				var tgiMonth = $('#tgiMonth_org').val();
				var tgiweek = $('#tgiweek_org').val();
				var selectedOrganization = $('#selectedOrganization').val();
				var cenTers = $('#cenTers').val();
				
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>pfilter/dash_org',
					data:'yeartgi='+yeartgi+'&tgiMonth='+tgiMonth+'&tgiweek='+tgiweek+'&selectedOrganization='+selectedOrganization+'&cenTers='+cenTers,
					dataType:'json',
					beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						
						 $('#organization').html(data.content);
						 $("#yeartgi_org").val(null);
						 $("#tgiMonth_org").val(null);
						 $("#tgiweek_org").val(null);
						 
					}else
					{
						return false;
					}
				}
					
					
				});
				
			}

</script>

	<script type="text/javascript">
		$(document).ready(function(){
			//get centers
			$(document).on('change', '#selectedOrganization', function(){
				var org = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "register/get_centers",
					data : {org_id:org},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#cenTers').html(data.content);
							$('#loader').hide();
							return false;
						}else
						{
							//have end check.
						}
						return false;
					}
				});
			});
			});
			
</script>



  <script>

    var ctx = document.getElementById("myChart8").getContext('2d');
    var myChart8 = new Chart(ctx, {
      type: 'pie',
      data: {
        title: ["Patient by Gender"],
        labels: ["Type 2 DM", "Type 1 DM", "IGT", "IGF", "GDM", "Others"],
        datasets: [{
          backgroundColor: [
            "#3ED4A4",
            "#703BD9",
            "#3AB4D9",
            "#C4DA3A",
            "#DB3B3B",
            "#F7B229"
          ],
          data: [3, 2, 2, 3, 4, 2]
        }]
      }
    });

  </script>


  
<script type="text/javascript"> 
    
  var ctx = document.getElementById("myChart1").getContext("2d");

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

  var myChart1 = new Chart(ctx, {
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

<script>

  var ctx = document.getElementById("myChart2").getContext('2d');
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





<script>

  var ctx = document.getElementById("myChart4").getContext('2d');
  var myChart3 = new Chart(ctx, {
    type: 'pie',
    data: {
      title: ["Patient by Gender"],
      labels: ["Type 2 DM <?php echo $type2dm_count;?>", "Type 1 DM <?php echo $type1dm_count;?>", "IGT <?php echo $igt_count;?>", "IFG <?php echo $ifg_count;?> ", "GDM <?php echo $gdm_count;?>", "Others <?php echo $others_count;?>"],
      datasets: [{
        backgroundColor: [
          "#3ED4A4",
          "#703BD9",
          "#3AB4D9",
          "#C4DA3A",
          "#DB3B3B",
          "#F7B229"
          
        ],
        data: [<?php echo $type2dm_count;?>, <?php echo $type1dm_count;?>, <?php echo $igt_count;?>, <?php echo $ifg_count;?> ,<?php echo $gdm_count;?> ,<?php echo $others_count;?>]
      }]
    }
  });

</script>



<script type="text/javascript">
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
  
  
});

</script>

<script type="text/javascript">

    $('#yeartgi').datepicker({
						 minViewMode: 2,
						autoclose: true,
						 format: 'yyyy'
							
					});
					
	$('#yeartgi_org').datepicker({
						 minViewMode: 2,
						autoclose: true,
						 format: 'yyyy'
							
					});

</script>





<?php require_once APPPATH.'modules/common/footer.php' ?>