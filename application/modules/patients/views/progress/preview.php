<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Patient Progress Report</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link rel="stylesheet" href="<?php echo base_url('assets/visit/') ?>assets/framework/fontawesome/css/fontawesome-all.min.css" />
  <link rel="stylesheet" href="<?php echo base_url('assets/visit/') ?>assets/framework/bootstrap/css/bootstrap.min.css" />
  
  <link rel="stylesheet" href="<?php echo base_url('assets/visit/') ?>assets/css/normalize.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/visit/') ?>assets/css/main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url('assets/visit/') ?>assets/js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="<?php echo base_url('assets/visit/') ?>assets/js/vendor/jquery-3.3.1.min.js"></script>
  <style type="text/css">
	body{font-size:12px;}
	.visit-description .table td{font-size:12px;}
	.other-heading-title{font-size:20px;}
	.table td, .table th{font-size:13px;}
	a.back-to-anchor {
		position: fixed;
		top: 5px;
		right: 5px;
		font-size: 12px;
	}
	
	.carousel-inner img {
    width: 100%;
    height: 750px;
  }
  </style>
</head>
	<body>
	
	<?php if($images){
		  $sl = 0;
		  ?>
	  <div id="demo" class="carousel slide" data-ride="carousel" data-interval="false" style = 'width: 40%;position: fixed;z-index: 20;top: 1%;right: 0px;'>

			  <!-- Indicators -->
			  <ul class="carousel-indicators">
				<?php foreach($images as $image):?>
					<li data-target="#demo" data-slide-to="<?php echo $sl?>"  class="<?php if ($sl === 0){echo 'active';}?>"></li>
				<?php
					$sl++;
				endforeach;?>
				
			  </ul>
			  
			  <!-- The slideshow -->
			  <div class="carousel-inner">
				
				<?php
					$sl = 0;
					foreach($images as $image):
						if($image['visit_type'] === 'Case History'):
					?>
					
					
					<div class="carousel-item <?php if ($sl === 0){echo 'active';}?>">
					  <img src="<?php echo base_url().'caseHistory/'.$image['patient_id'].'/'.$image['image_name'] ?>" alt="Chicago" width="1100" height="500">
					</div>
					
					<?php else:?>
					
					<div class="carousel-item <?php if ($sl === 0){echo 'active';}?>">
					  <img src="<?php echo base_url().'progress/'.$image['patient_id'].'/'.$image['image_name'] ?>" alt="Chicago" width="1100" height="500">
					</div>
					
				<?php
					endif;
					$sl++;
					endforeach;?>
			  </div>
			  
			  <!-- Left and right controls -->
			  <a class="carousel-control-prev" href="#demo" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			  </a>
			  <a class="carousel-control-next" href="#demo" data-slide="next">
				<span class="carousel-control-next-icon"></span>
			  </a>
		</div>
		
	  <?php }?>
	  <!--[if lte IE 9]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	  <![endif]-->
	  <?php 
	  
	  /************************************************/
	  /***********           Visit Query        *************/
	  /************************************************/
	  //print_r($images);
	  $patient_info = $this->Progress_model->visit_patient_information($patient_id);
	  $visit_info = $this->Progress_model->visit_information($visit_id, $patient_id);
	  $visit_general_examinations = $this->Progress_model->visit_general_examinations($visit_id, $patient_id);
	  $visit_laboratory_investigations = $this->Visit_model->visit_laboratory_investigations($visit_id, $patient_id);
	  $visit_laboratory_main = $this->Visit_model->visit_laboratory_main($visit_id, $patient_id);
	  $visit_laboratory_ecg = $this->Progress_model->visit_laboratory_ecg($visit_id, $patient_id);
	  $visit_complications = $this->Progress_model->visit_complications($visit_id, $patient_id);
	  $visit_personal_habits = $this->Progress_model->visit_personal_habits($visit_id, $patient_id);
	  $visit_family_history = $this->Progress_model->visit_family_history($visit_id, $patient_id);
	  
	  
	  /************************************************/
	  /***********         End  Visit Query        *************/
	  /************************************************/
	  ?>
	  
	  <a href="<?php echo base_url('patients/visit/all/'.$patient_info['patient_id'].'/'.$patient_info['patient_entryid']); ?>" class="btn btn-primary btn-sm back-to-anchor"><i class="fa fa-arrow-left"></i> Back to visits</a>
	  <div class="visit-main-header">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<div class="main-header-cnt">
							<h2 class="main-header-title">Nationwide Electronic Registry</h2>
							<span class="label-text-slogan">Thank you for providing us the opportunity to serve you</span>
						</div>
					</div>
				</div>
			</div>
	  </div>
	  
	  <div class="visit-header-address">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<div class="address-of-visit">
							<h5>
								Birdem General Hospital <br />
								122 Kazi Nazrul Islam Avenue, Shahbagh, Dhaka 1000
							</h5>
						</div>
					</div>
				</div>
			</div>
	  </div>
	  
	  <div class="devider-line">
		<span class="dev-1"></span>
		<span class="dev-1"></span>
	  </div>
	  
	  
	  <div class="patient-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">Patient Information</span>
					</div>
					<div class="col-lg-6">
						<p>
							<strong>ID : </strong> <?php echo $patient_info['patient_entryid']; ?> <br />
							<strong>Name Of Patient : </strong> <?php echo $patient_info['patient_name']; ?> <br />
							<strong>Age : </strong> <?php echo $patient_info['patient_age']; ?> <br />
							<strong>Gender : </strong> <?php echo ($patient_info['patient_gender'] === '0')? 'Male' : 'Female'; ?> <br />
						</p>
					</div>
					<div class="col-lg-6 text-right">
						<p>
							<strong>Patient Registration Center : </strong> <?php echo $patient_info['orgcenter_name']; ?> <br />
							<strong>Visit Center : </strong> <?php echo $visit_info['orgcenter_name']; ?> <br />
							<strong>Visit Date : </strong> <?php echo date("d M, Y", strtotime($visit_info['visit_date'])); ?> <br />
							<strong>Visit Created Date : </strong> <?php echo date("d M, Y", strtotime($visit_info['visit_admit_date'])); ?> <br />
						</p>
					</div>
				</div>
			</div>
	  </div>
	  
	  <div class="devider-line">
		<span class="dev-1"></span>
		<span class="dev-1"></span>
	  </div>
	  
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">DIABETES HISTORY</span>
					</div>
				</div>
				<?php 
					$diabetes_history    = $this->Progress_model->get_visit_diabetes_history($visit_id, $patient_id);
					$visit_complications = $this->Progress_model->get_visit_complications($visit_id, $patient_id);
				?>
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Type of glucose intolarance</th>
								<th>Duration of glucose intolarance</th>
							</tr>
							<tr>
								<td><?php echo ($diabetes_history)? $diabetes_history['dhistory_type_of_glucose'] : '-'; ?></td>
								<td><?php echo ($diabetes_history)? $diabetes_history['dhistory_duration_of_glucose'] : '-'; ?></td>
							</tr>
						</table>
						
						<table class="table table-bordered table-striped">
							<tr>
								<th>Complications / Comorbidity</th>
							</tr>
							<?php
								$complications = '';
								foreach($visit_complications as $complication): 
									$complications .= $complication['vcomplication_name'].', ';
								endforeach; 
							?>
							<tr>
								<td><?php echo rtrim($complications, ','); ?></td>
							</tr>
						</table>
						
						<table class="table table-bordered table-striped">
							<tr>
								<th style="width:20%">Previous Bad Obstetrical History</th>
								<td style="width:30%"><?php echo ($diabetes_history)? $diabetes_history['dhistory_prev_bad_obstetric_history'] : '-'; ?></td>
								<th style="width:20%">Previous History of GDM</th>
								<td style="width:30%"><?php echo ($diabetes_history)? $diabetes_history['dhistory_prev_history_of_gdm'] : '-'; ?></td>
							</tr>
							<tr>
								<th style="width:20%">Past Medical History</th>
								<td style="width:30%" colspan="4"><?php echo ($diabetes_history)? $diabetes_history['dhistory_past_medical_history'] : '-'; ?></td>
							</tr>
						</table>
						
					</div>
				</div>
			</div>
	  </div>
	  
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">GENERAL EXAMINATION</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<?php if ($visit_general_examinations): ?>
							<tr>
								<?php if ($visit_general_examinations['height']):?>
								<td><strong>Height: </strong></td>
								<td><?php echo $visit_general_examinations['height']; ?></td>
								<?php endif;?>
							</tr>	
							<tr>
								<?php if ($visit_general_examinations['weight']):?>
								<td><strong>Weight: </strong></td>
								<td><?php echo $visit_general_examinations['weight']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_general_examinations['sitting_sbp']):?>
								<td><strong>Sitting SBP: </strong></td>
								<td><?php echo $visit_general_examinations['sitting_sbp']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_general_examinations['sitting_dbp']):?>
								<td><strong>Sitting DBP: </strong></td>
								<td><?php echo $visit_general_examinations['sitting_dbp']; ?></td>
								<?php endif;?>
							</tr>
							<?php endif; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">LABORATORY INVESTIGATION</span>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-7">
						<table class="table table-bordered table-striped">
							<?php foreach($visit_laboratory_investigations as $labinvs): ?>
							<tr>
								<td><strong><?php echo $labinvs['labinvs_name']; ?> : </strong></td>
								<td><?php echo $labinvs['labinvs_value']; ?> <?php echo $labinvs['labinvs_unit']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						<table class="table table-bordered table-striped">
							<?php if ($visit_laboratory_main):?>
							<tr>
								<?php if ($visit_laboratory_main['fbg']):?>
								<td><strong>FBG: </strong></td>
								<td><?php echo $visit_laboratory_main['fbg']; ?></td>
								<?php endif;?>
							</tr>	
							<tr>
								<?php if ($visit_laboratory_main['s_creatinine']):?>
								<td><strong>S. Creatinine : </strong></td>
								<td><?php echo $visit_laboratory_main['s_creatinine']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['2hag']):?>
								<td><strong>2hAG : </strong></td>
								<td><?php echo $visit_laboratory_main['2hag']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['sgpt']):?>
								<td><strong>SGPT : </strong></td>
								<td><?php echo $visit_laboratory_main['sgpt']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['post_meal_bg']):?>
								<td><strong>Post-meal BG : </strong></td>
								<td><?php echo $visit_laboratory_main['post_meal_bg']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['hb']):?>
								<td><strong>HB : </strong></td>
								<td><?php echo $visit_laboratory_main['hb']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['rbg']):?>
								<td><strong>RBG : </strong></td>
								<td><?php echo $visit_laboratory_main['rbg']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['tc']):?>
								<td><strong>TC : </strong></td>
								<td><?php echo $visit_laboratory_main['tc']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['hba1c']):?>
								<td><strong>HbA1c : </strong></td>
								<td><?php echo $visit_laboratory_main['hba1c']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['dc_n']):?>
								<td><strong>DC - N : </strong></td>
								<td><?php echo $visit_laboratory_main['dc_n']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['dc_z']):?>
								<td><strong>DC - Z : </strong></td>
								<td><?php echo $visit_laboratory_main['dc_z']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['dc_m']):?>
								<td><strong>DC - M : </strong></td>
								<td><?php echo $visit_laboratory_main['dc_m']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['dc_e']):?>
								<td><strong>DC - E : </strong></td>
								<td><?php echo $visit_laboratory_main['dc_e']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['t_chol']):?>
								<td><strong>T. Chol : </strong></td>
								<td><?php echo $visit_laboratory_main['t_chol']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['esr']):?>
								<td><strong>ESR : </strong></td>
								<td><?php echo $visit_laboratory_main['esr']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['ldl_c']):?>
								<td><strong>LDL-C : </strong></td>
								<td><?php echo $visit_laboratory_main['ldl_c']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['hdl_c']):?>
								<td><strong>HDL-C : </strong></td>
								<td><?php echo $visit_laboratory_main['hdl_c']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['urine_albumin']):?>
								<td><strong>Urine Albumin : </strong></td>
								<td><?php echo $visit_laboratory_main['urine_albumin']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['urine_micro_albumin']):?>
								<td><strong>Urine micro-Albumin : </strong></td>
								<td><?php echo $visit_laboratory_main['urine_micro_albumin']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['tg']):?>
								<td><strong>TG : </strong></td>
								<td><?php echo $visit_laboratory_main['tg']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['urine_acetone']):?>
								<td><strong>Urine Acetone : </strong></td>
								<td><?php echo $visit_laboratory_main['urine_acetone']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['blood_group']):?>
								<td><strong>Blood Group : </strong></td>
								<td><?php echo $visit_laboratory_main['blood_group']; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['ecg_type'] === '0'):?>
								<td><strong>ECG : </strong></td>
								<td><?php 
								$ecg_array1 = array('[', ']', '"');
											$ecg_array2 = array('', '', '');
											$labecg_array = str_replace($ecg_array1, $ecg_array2, $visit_laboratory_main['ecg_abnormals']);
											echo 'Abnormal ('.$labecg_array.')';
								
								?>
								</td>
								<?php elseif ($visit_laboratory_main['ecg_type'] === '1'):?>
								<td><strong>ECG : </strong></td>
								<td><?php echo "Normal"; ?></td>
								<?php endif;?>
							</tr>
							<tr>
								<?php if ($visit_laboratory_main['usg_type'] === '0'):?>
								<td><strong>USG : </strong></td>
								<td><?php echo 'Abnormal ('.$visit_laboratory_main['usg_abnormals'].')'; ?></td>
								<?php elseif ($visit_laboratory_main['usg_type'] === '1'):?>
								<td><strong>USG : </strong></td>
								<td><?php echo "Normal"; ?></td>
								<?php endif;?>
							</tr>
							<?php endif;?>
						</table>
					</div>
					
				</div>
			</div>
	  </div>
	  
	  <?php 
	  
		  /************************************************/
		  /***********           Visit Previous Advice Query        *************/
		  /************************************************/
		  
		  $prev_diatory_history = $this->Progress_model->prev_diatory_history($visit_id, $patient_id);
		  $prev_cooking_oil = $this->Progress_model->prev_cooking_oil($visit_id, $patient_id);
		  $prev_phisical_activities = $this->Progress_model->prev_phisical_activities($visit_id, $patient_id);
		  
		  
		  /************************************************/
		  /***********         End  Visit Query        *************/
		  /************************************************/
		
	  ?>
	  
	  
	  <?php 
		  
		  
		  /************************************************/
		  /***********         End  Visit Query        *************/
		  /************************************************/
		
	  ?>
	  
	  
	  <h2 class="other-heading-title" style = "width: 60%;">FINAL TREATMENT</h2>
	  <?php 
		$crnt_other_oads = $this->Progress_model->crnt_other_oads($visit_id, $patient_id);
		$crnt_other_insuline = $this->Progress_model->crnt_other_insuline($visit_id, $patient_id);
		$crnt_other_antihtn = $this->Progress_model->crnt_other_antihtn($visit_id, $patient_id);
		$crnt_other_antilipids = $this->Progress_model->crnt_other_antilipids($visit_id, $patient_id);
		$crnt_other_antiplatelets = $this->Progress_model->crnt_other_antiplatelets($visit_id, $patient_id);
		$crnt_other_antiobesity = $this->Progress_model->crnt_other_antiobesity($visit_id, $patient_id);
		$crnt_other_medic_other = $this->Progress_model->crnt_other_medic_other($visit_id, $patient_id);
	  ?>
	  <?php 
		$final_treatment_info = $this->Progress_model->get_final_treatment_info($visit_id, $patient_id);
	  ?>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<td style="width:20%"><strong>Name Of Doctor :</strong> </td>
								<td style="width:30%"><?php echo ($final_treatment_info['finaltreat_doctor_name'])? $final_treatment_info['finaltreat_doctor_name'] : '-'; ?></td>
								<td style="width:20%"><strong>Date :</strong> </td>
								<td style="width:30%"><?php echo ($final_treatment_info['finaltreat_date'])? formated_date($final_treatment_info['finaltreat_date']) : '-'; ?></td>
							</tr>
							<tr>
								<td style="width:20%"><strong>Dietary Advice (Calorie/Day) :</strong> </td>
								<td style="width:30%"><?php echo ($final_treatment_info['finaltreat_dietary_advice'])? $final_treatment_info['finaltreat_dietary_advice'] : '-'; ?></td>
								<td style="width:20%"><strong>Physical Acitvity :</strong> </td>
								<td style="width:30%"><?php echo ($final_treatment_info['finaltreat_physical_acitvity'])? $final_treatment_info['finaltreat_physical_acitvity'] : '-'; ?></td>
							</tr>
							<tr>
								<td style="width:20%"><strong>Diet No :</strong> </td>
								<td style="width:30%"><?php echo ($final_treatment_info['finaltreat_diet_no'])? $final_treatment_info['finaltreat_diet_no'] : '-'; ?></td>
								<td style="width:20%"><strong>Page No :</strong> </td>
								<td style="width:30%"><?php echo ($final_treatment_info['finaltreat_page_no'])? $final_treatment_info['finaltreat_page_no'] : '-'; ?></td>
							</tr>
						</table>
					</div>
					<div class="col-lg-12">
						<h2 style="font-size: 16px; font-weight: bold;" class="text-center">OADs</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th style="width:30%">Drug</th>
								<th style="width:30%">Company</th>
								<th style="width:30%">Generic</th>
								<th>Dose</th>
								<th>Advice</th>
								<th>Duration</th>
							</tr>
							<?php 
								foreach($crnt_other_oads as $other_oads): 
								$drug_info = $this->Progress_model->get_drug_info($other_oads['oads_name']);
							?>
							<tr>
								<td><?php echo $other_oads['oads_name']; ?></td>
								<td><?php echo $drug_info['company_name']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_oads['oads_dose']; ?></td>
								<td><?php echo ($other_oads['oads_duration'])? "খাওয়ার "." ".$other_oads['oads_advice_codition_apply'] : null; ?></td>
								<td><?php echo ($other_oads['oads_duration'])? "চলবে ".$other_oads['oads_duration']." ".$other_oads['oads_duration_type'] : null; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 16px; font-weight: bold;" class="text-center">Insulin</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th style="width:30%">Insulin</th>
								<th style="width:30%">Company</th>
								<th style="width:30%">Generic</th>
								<th>Dose</th>
								<th>Advice</th>
								<th>Duration</th>
							</tr>
							<?php 
								foreach($crnt_other_insuline as $other_insuline): 
								$drug_info = $this->Progress_model->get_insulin_info($other_insuline['insulin_name']);
							?>
							<tr>
								<td><?php echo $other_insuline['insulin_name']; ?></td>
								<td><?php echo $drug_info['insuline_company']; ?></td>
								<td><?php echo $drug_info['insuline_generic']; ?></td>
								<td><?php echo $other_insuline['insulin_dose']; ?></td>
								<td><?php echo ($other_insuline['insulin_advice_codition_time'])? "খাওয়ার ".$other_insuline['insulin_advice_codition_time']." ".$other_insuline['insulin_advice_codition_time_type']." ".$other_insuline['insulin_advice_codition_apply'] : null; ?></td>
								<td><?php echo ($other_insuline['insulin_duration'])? "চলবে ".$other_insuline['insulin_duration']." ".$other_insuline['insulin_duration_type'] : null; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					
						<h2 style="font-size: 16px; font-weight: bold;" class="text-center">Anti-HTN</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th style="width:30%">Drug</th>
								<th style="width:30%">Company</th>
								<th style="width:30%">Generic</th>
								<th>Dose</th>
								<th>Advice</th>
								<th>Duration</th>
							</tr>
							<?php 
								foreach($crnt_other_antihtn as $other_antihtn): 
								$drug_info = $this->Progress_model->get_drug_info($other_antihtn['anti_htn_name']);
							?>
							<tr>
								<td><?php echo $other_antihtn['anti_htn_name']; ?></td>
								<td><?php echo $drug_info['company_name']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antihtn['anti_htn_dose']; ?></td>
								<td><?php echo ($other_antihtn['anti_htn_advice_codition_time'])? "খাওয়ার ".$other_antihtn['anti_htn_advice_codition_time']." ".$other_antihtn['anti_htn_advice_codition_time_type']." ".$other_antihtn['anti_htn_advice_codition_apply'] : null; ?></td>
								<td><?php echo ($other_antihtn['anti_htn_duration'])? "চলবে ".$other_antihtn['anti_htn_duration']." ".$other_antihtn['anti_htn_duration_type'] : null; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 16px; font-weight: bold;" class="text-center">Anti-lipid</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th style="width:30%">Drug</th>
								<th style="width:30%">Company</th>
								<th style="width:30%">Generic</th>
								<th>Dose</th>
								<th>Advice</th>
								<th>Duration</th>
							</tr>
							<?php 
								foreach($crnt_other_antilipids as $other_antilipids): 
								$drug_info = $this->Progress_model->get_drug_info($other_antilipids['anti_lipid_name']);
							?>
							<tr>
								<td><?php echo $other_antilipids['anti_lipid_name']; ?></td>
								<td><?php echo $drug_info['company_name']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antilipids['anti_lipid_dose']; ?></td>
								<td><?php echo ($other_antilipids['anti_lipid_advice_codition_time'])? "খাওয়ার ".$other_antilipids['anti_lipid_advice_codition_time']." ".$other_antilipids['anti_lipid_advice_codition_time_type']." ".$other_antilipids['anti_lipid_advice_codition_apply'] : null; ?></td>
								<td><?php echo ($other_antilipids['anti_lipid_duration'])? "চলবে ".$other_antilipids['anti_lipid_duration']." ".$other_antilipids['anti_lipid_duration_type'] : null; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 16px; font-weight: bold;" class="text-center">Anti-platelet</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th style="width:30%">Drug</th>
								<th style="width:30%">Company</th>
								<th style="width:30%">Generic</th>
								<th>Dose</th>
								<th>Advice</th>
								<th>Duration</th>
							</tr>
							<?php 
								foreach($crnt_other_antiplatelets as $other_antiplatelets): 
								$drug_info = $this->Progress_model->get_drug_info($other_antiplatelets['antiplatelets_name']);
							?>
							<tr>
								<td><?php echo $other_antiplatelets['antiplatelets_name']; ?></td>
								<td><?php echo $drug_info['company_name']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antiplatelets['antiplatelets_dose']; ?></td>
								<td><?php echo ($other_antiplatelets['antiplatelets_advice_codition_time'])? "খাওয়ার ".$other_antiplatelets['antiplatelets_advice_codition_time']." ".$other_antiplatelets['antiplatelets_advice_codition_time_type']." ".$other_antiplatelets['antiplatelets_advice_codition_apply'] : null; ?></td>
								<td><?php echo ($other_antiplatelets['antiplatelets_duration'])? "চলবে ".$other_antiplatelets['antiplatelets_duration']." ".$other_antiplatelets['antiplatelets_duration_type'] : null; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 16px; font-weight: bold;" class="text-center">Anti-obesity</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th style="width:30%">Drug</th>
								<th style="width:30%">Company</th>
								<th style="width:30%">Generic</th>
								<th>Dose</th>
								<th>Advice</th>
								<th>Duration</th>
							</tr>
							<?php 
								foreach($crnt_other_antiobesity as $other_antiobesity): 
								$drug_info = $this->Progress_model->get_drug_info($other_antiobesity['anti_obesity_name']);
							?>
							<tr>
								<td><?php echo $other_antiobesity['anti_obesity_name']; ?></td>
								<td><?php echo $drug_info['company_name']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antiobesity['anti_obesity_dose']; ?></td>
								<td><?php echo ($other_antiobesity['anti_obesity_advice_codition_time'])? "খাওয়ার ".$other_antiobesity['anti_obesity_advice_codition_time']." ".$other_antiobesity['anti_obesity_advice_codition_time_type']." ".$other_antiobesity['anti_obesity_advice_codition_apply'] : null; ?></td>
								<td><?php echo ($other_antiobesity['anti_obesity_duration'])? "চলবে ".$other_antiobesity['anti_obesity_duration']." ".$other_antiobesity['anti_obesity_duration_type'] : null; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 16px; font-weight: bold;" class="text-center">Others</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th style="width:30%">Drug</th>
								<th style="width:30%">Company</th>
								<th style="width:30%">Generic</th>
								<th>Dose</th>
								<th>Advice</th>
								<th>Duration</th>
							</tr>
							<?php 
								foreach($crnt_other_medic_other as $other_medic_other): 
								$drug_info = $this->Progress_model->get_drug_info($other_medic_other['other_name']);
							?>
							<tr>
								<td><?php echo $other_medic_other['other_name']; ?></td>
								<td><?php echo $drug_info['company_name']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_medic_other['other_dose']; ?></td>
								<td><?php echo ($other_medic_other['other_advice_codition_time'])? "খাওয়ার ".$other_medic_other['other_advice_codition_time']." ".$other_medic_other['other_advice_codition_time_type']." ".$other_medic_other['other_advice_codition_apply'] : null; ?></td>
								<td><?php echo ($other_medic_other['other_duration'])? "চলবে ".$other_medic_other['other_duration']." ".$other_medic_other['other_duration_type'] : null; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						<br />
						<table class="table table-bordered table-striped">
							<tr>
								<th>Next Visit Date</th>
								<th>Next Investigation</th>
							</tr>
							<tr>
								<td><?php echo ($final_treatment_info['finaltreat_next_visit_date'])? $final_treatment_info['finaltreat_next_visit_date'] : '-'; ?></td>
								<td><?php echo ($final_treatment_info['finaltreat_next_investigation'])? $final_treatment_info['finaltreat_next_investigation'] : '-'; ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  
	  
	  <script src="<?php echo base_url('assets/visit/') ?>assets/framework/bootstrap/js/bootstrap.min.js"></script>
	  <script src="<?php echo base_url('assets/visit/') ?>assets/js/plugins.js"></script>
	  <script src="<?php echo base_url('assets/visit/') ?>assets/js/main.js"></script>
	  <script type="text/javascript">
		$(document).ready(function(){
			<?php if($images){?>
				$(".container").css({"margin": "unset","width": "60%"});
				$(".back-to-anchor").css("margin-right", "45%");
				//$('.bs-example-modal-sm').modal('toggle');
			<?php }?>
			
			});
	</script>
	</body>
</html>