<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Patient Visit</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link rel="stylesheet" href="<?php echo base_url('assets/visit/') ?>assets/framework/fontawesome/css/fontawesome-all.min.css" />
  <link rel="stylesheet" href="<?php echo base_url('assets/visit/') ?>assets/framework/bootstrap/css/bootstrap.min.css" />
  
  <link rel="stylesheet" href="<?php echo base_url('assets/visit/') ?>assets/css/normalize.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/visit/') ?>assets/css/main.css">
  <script src="<?php echo base_url('assets/visit/') ?>assets/js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="<?php echo base_url('assets/visit/') ?>assets/js/vendor/jquery-3.3.1.min.js"></script>
</head>
	<body>
	  <!--[if lte IE 9]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	  <![endif]-->

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
	  
	  <?php 
	  
	  /************************************************/
	  /***********           Visit Query        *************/
	  /************************************************/
	  
	  $patient_info = $this->Visit_model->visit_patient_information($patient_id);
	  $visit_info = $this->Visit_model->visit_information($visit_id, $patient_id);
	  $visit_general_examinations = $this->Visit_model->visit_general_examinations_old($visit_id, $patient_id);
	  $visit_laboratory_investigations = $this->Visit_model->visit_laboratory_investigations_old($visit_id, $patient_id);
	  $visit_laboratory_ecg = $this->Visit_model->visit_laboratory_ecg($visit_id, $patient_id);
	  $visit_complications = $this->Visit_model->visit_complications($visit_id, $patient_id);
	  $visit_personal_habits = $this->Visit_model->visit_personal_habits($visit_id, $patient_id);
	  $visit_family_history = $this->Visit_model->visit_family_history($visit_id, $patient_id);
	  
	  
	  /************************************************/
	  /***********         End  Visit Query        *************/
	  /************************************************/
	  ?>
	  
	  
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
							<strong>Blood Group : </strong> <?php echo $patient_info['patient_blood_group']; ?>
						</p>
					</div>
					<div class="col-lg-6 text-right">
						<p>
							<strong>Patient Registration Center : </strong> <?php echo $patient_info['orgcenter_name']; ?> <br />
							<strong>Visit Center : </strong> <?php echo $visit_info['visit_visit_center']; ?> <br />
							<strong>Visit Type : </strong> <?php echo $visit_info['visit_type']; ?> <br />
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
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<td><strong>Symptomatic ? : </strong></td>
								<td><?php echo ($visit_info['visit_has_symptomatic'] === '1')? 'Yes' : 'No'; ?></td>
							</tr>
							<?php if($visit_info['visit_has_symptomatic'] === '1'): ?>
							<tr>
								<td><strong>Symptomatic Type : </strong></td>
								<td><?php echo $visit_info['visit_symptomatic_type']; ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td><strong>Patient Type : </strong></td>
								<td><?php echo $visit_info['visit_patient_type']; ?></td>
							</tr>
							<tr>
								<td><strong>Diabetes Duration : </strong></td>
								<td><?php echo $visit_info['visit_diabetes_duration']; ?></td>
							</tr>
							<tr>
								<td><strong>Type Of Diabetes : </strong></td>
								<td><?php echo $visit_info['visit_types_of_diabetes']; ?></td>
							</tr>
							<tr>
								<td><strong>Patient Guide Book No : </strong></td>
								<td><?php echo $visit_info['visit_guidebook_no']; ?></td>
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
							<?php if($visit_general_examinations): foreach($visit_general_examinations as $exam): ?>
							<tr>
								<td><strong><?php echo $exam['generalexam_name']; ?> : </strong></td>
								<td><?php echo $exam['generalexam_value']; ?></td>
							</tr>
							<?php endforeach; endif;?>
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
								<td><?php echo $labinvs['labinvs_value']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
					<div class="col-lg-5">
						<table class="table table-bordered table-striped">
							<tr>
								<td><strong>ECG : </strong></td>
								<td>
									<?php 
										if($visit_laboratory_ecg):
											if($visit_laboratory_ecg['ecg_type'] === '0'):
												$ecg_array1 = array('[', ']', '"');
												$ecg_array2 = array('', '', '');
												$labecg_array = str_replace($ecg_array1, $ecg_array2, $visit_laboratory_ecg['ecg_abnormals']);
												echo 'Abnormal ('.$labecg_array.')';
											else:
												echo 'Normal';
											endif;
										endif;
									?>
								</td>
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
						<span class="label-text-slogan">COMPLICATION</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL.</th>
								<th>Complication</th>
							</tr>
							<?php  
								$xcount = 1;
								foreach($visit_complications as $complication): 
							?>
							<tr>
								<td><?php echo $xcount; ?></td>
								<td><strong><?php echo $complication['vcomplication_name']; ?> </strong></td>
							</tr>
							<?php 
								$xcount++;
								endforeach; 
							?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">PERSONAL HABITS</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Habit</th>
								<th>Type</th>
								<th>Amount</th>
							</tr>
							<?php foreach($visit_personal_habits as $habit): ?>
							<tr>
								<td><?php echo $habit['phabit_name']; ?></td>
								<td><?php echo $habit['phabit_adiction_type']; ?></td>
								<td><?php echo $habit['phabit_amount']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">FAMILY HISTORY</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$family_array = array();
							foreach($visit_family_history as $key => $new_array)
							{
								$family_array[$new_array['fmhistory_label']] = array($new_array['fmhistory_diabetes'], $new_array['fmhistory_htn'], $new_array['fmhistory_ihd'], $new_array['fmhistory_stroke'], $new_array['fmhistory_amupation']);
							}
							
							
							$family_history = array(
												'Grand Parents',
												'Father',
												'Mother',
												'Brother/Sister',
												'Sons/Daughters',
												'Others',
											  );
						?>
						
						<table class="table">
								<thead>
									<tr>
										<th></th>
										<th class="text-center">Diabetes</th>
										<th class="text-center">HTN</th>
										<th class="text-center">IHD/MI</th>
										<th class="text-center">Stroke</th>
										<th class="text-center">Amupation</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$vls = array('1' => 'Yes', '2' => 'No', '3' => 'Unknown');
										foreach($family_history as $key):
									?>
									<tr>
										<td><?php echo $key; ?></td>
										<td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][0]))? $vls[$family_array[$key][0]] : null; ?></td>
										<td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][1]))? $vls[$family_array[$key][1]] : null; ?></td>
										<td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][2]))? $vls[$family_array[$key][2]] : null; ?></td>
										<td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][3]))? $vls[$family_array[$key][3]] : null; ?></td>
										<td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][4]))? $vls[$family_array[$key][4]] : null; ?></td>
									</tr>
									<?php 
										endforeach; 
									?>
								</tbody>
							</table>
					</div>
				</div>
			</div>
	  </div>
	  
	  <?php 
	  
		  /************************************************/
		  /***********           Visit Previous Advice Query        *************/
		  /************************************************/
		  
		  $prev_diatory_history = $this->Visit_model->prev_diatory_history($visit_id, $patient_id);
		  $prev_cooking_oil = $this->Visit_model->prev_cooking_oil($visit_id, $patient_id);
		  $prev_phisical_activities = $this->Visit_model->prev_phisical_activities($visit_id, $patient_id);
		  
		  
		  /************************************************/
		  /***********         End  Visit Query        *************/
		  /************************************************/
		
	  ?>
	  
	  <div class="devider-line">
		<span class="dev-1"></span>
		<span class="dev-1"></span>
	  </div>
	  
	  <h2 class="other-heading-title">Previous Advice</h2>
	  
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">DIETARY HISTORY</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Name</th>
								<th>daily</th>
								<th>weekly</th>
								<th>monthly</th>
								<th>calore</th>
								<th>diet_chart</th>
							</tr>
							<?php foreach($prev_diatory_history as $diatory_history): ?>
							<tr>
								<td><?php echo $diatory_history['diehist_name']; ?></td>
								<td><?php echo $diatory_history['diehist_daily']; ?></td>
								<td><?php echo $diatory_history['diehist_weekly']; ?></td>
								<td><?php echo $diatory_history['diehist_monthly']; ?></td>
								<td><?php echo $diatory_history['diehist_calore']; ?></td>
								<td><?php echo $diatory_history['diehist_diet_chart']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">TYPE OF COOKING OIL</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Oil Name</th>
								<th>Type</th>
								<th>Amount (Per/Month)</th>
							</tr>
							<?php foreach($prev_cooking_oil as $cooking_oil): ?>
							<tr>
								<td><?php echo $cooking_oil['cooking_oil_name']; ?></td>
								<td><?php echo $cooking_oil['cooking_oil_has_used']; ?></td>
								<td><?php echo $cooking_oil['cooking_oil_litr_permonth']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">PHISICAL ACTIVITY</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Type</th>
								<th>Duration (Min/Day)</th>
							</tr>
							<?php foreach($prev_phisical_activities as $phisical_activities): ?>
							<tr>
								<td><?php echo $phisical_activities['physical_act_type']; ?></td>
								<td><?php echo $phisical_activities['physical_act_duration_a_day']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  <?php 
		$prev_other_antihtn = $this->Visit_model->prev_other_antihtn($visit_id, $patient_id);
		$prev_other_antilipids = $this->Visit_model->prev_other_antilipids($visit_id, $patient_id);
		$prev_other_antiobesity = $this->Visit_model->prev_other_antiobesity($visit_id, $patient_id);
		$prev_other_medic_other = $this->Visit_model->prev_other_medic_other($visit_id, $patient_id);
	  ?>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">MEDICATION</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<h2 style="font-size: 20px; font-weight: bold;">Anti HTN</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Drug</th>
								<th>Company</th>
								<th>Generic</th>
								<th>Dose</th>
							</tr>
							<?php 
								foreach($prev_other_antihtn as $other_antihtn): 
								$drug_info = $this->Visit_model->get_drug_info($other_antihtn['anti_htn_name']);
							?>
							<tr>
								<td><?php echo $other_antihtn['anti_htn_name']; ?></td>
								<td><?php // echo $drug_info['company']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antihtn['anti_htn_dose']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 20px; font-weight: bold;">Anti lipids</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Drug</th>
								<th>Company</th>
								<th>Generic</th>
								<th>Dose</th>
							</tr>
							<?php 
								foreach($prev_other_antilipids as $other_antilipids): 
								$drug_info = $this->Visit_model->get_drug_info($other_antilipids['anti_lipid_name']);
							?>
							<tr>
								<td><?php echo $other_antilipids['anti_lipid_name']; ?></td>
								<td><?php //echo $drug_info['company']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antilipids['anti_lipid_dose']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 20px; font-weight: bold;">Anti-obesity</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Drug</th>
								<th>Company</th>
								<th>Generic</th>
								<th>Dose</th>
							</tr>
							<?php 
								foreach($prev_other_antiobesity as $other_antiobesity): 
								$drug_info = $this->Visit_model->get_drug_info($other_antiobesity['anti_obesity_name']);
							?>
							<tr>
								<td><?php echo $other_antiobesity['anti_obesity_name']; ?></td>
								<td><?php //echo $drug_info['company']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antiobesity['anti_obesity_dose']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 20px; font-weight: bold;">Others</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Drug</th>
								<th>Company</th>
								<th>Generic</th>
								<th>Dose</th>
							</tr>
							<?php 
								foreach($prev_other_medic_other as $other_medic_other): 
								$drug_info = $this->Visit_model->get_drug_info($other_medic_other['other_name']);
							?>
							<tr>
								<td><?php echo $other_medic_other['other_name']; ?></td>
								<td><?php //echo $drug_info['company']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_medic_other['other_dose']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  
	  <div class="devider-line">
		<span class="dev-1"></span>
		<span class="dev-1"></span>
	  </div>
	  
	  <?php 
	  
		  /************************************************/
		  /***********           Visit Current Advice Query        *************/
		  /************************************************/
		  
		  $crnt_diatory_history = $this->Visit_model->crnt_diatory_history($visit_id, $patient_id);
		  $crnt_cooking_oil = $this->Visit_model->crnt_cooking_oil($visit_id, $patient_id);
		  $crnt_phisical_activities = $this->Visit_model->crnt_phisical_activities($visit_id, $patient_id);
		  
		  
		  /************************************************/
		  /***********         End  Visit Query        *************/
		  /************************************************/
		
	  ?>
	  
	  
	  <h2 class="other-heading-title">Current Advice</h2>
	  
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">DIATORY HISTORY</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Name</th>
								<th>daily</th>
								<th>weekly</th>
								<th>monthly</th>
								<th>calore</th>
								<th>diet_chart</th>
							</tr>
							<?php foreach($crnt_diatory_history as $diatory_history): ?>
							<tr>
								<td><?php echo $diatory_history['diehist_name']; ?></td>
								<td><?php echo $diatory_history['diehist_daily']; ?></td>
								<td><?php echo $diatory_history['diehist_weekly']; ?></td>
								<td><?php echo $diatory_history['diehist_monthly']; ?></td>
								<td><?php echo $diatory_history['diehist_calore']; ?></td>
								<td><?php echo $diatory_history['diehist_diet_chart']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">TYPE OF COOKING OIL</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Oil Name</th>
								<th>Type</th>
								<th>Amount (Per/Month)</th>
							</tr>
							<?php foreach($crnt_cooking_oil as $cooking_oil): ?>
							<tr>
								<td><?php echo $cooking_oil['cooking_oil_name']; ?></td>
								<td><?php echo $cooking_oil['cooking_oil_has_used']; ?></td>
								<td><?php echo $cooking_oil['cooking_oil_litr_permonth']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">PHISICAL ACTIVITY</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<tr>
								<th>Type</th>
								<th>Duration (Min/Day)</th>
							</tr>
							<?php foreach($crnt_phisical_activities as $phisical_activities): ?>
							<tr>
								<td><?php echo $phisical_activities['physical_act_type']; ?></td>
								<td><?php echo $phisical_activities['physical_act_duration_a_day']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  <?php 
		$crnt_other_antihtn = $this->Visit_model->crnt_other_antihtn($visit_id, $patient_id);
		$crnt_other_antilipids = $this->Visit_model->crnt_other_antilipids($visit_id, $patient_id);
		$crnt_other_antiobesity = $this->Visit_model->crnt_other_antiobesity($visit_id, $patient_id);
		$crnt_other_medic_other = $this->Visit_model->crnt_other_medic_other($visit_id, $patient_id);
	  ?>
	  <div class="visit-description">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<span class="label-text-slogan">MEDICATION</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<h2 style="font-size: 20px; font-weight: bold;">Anti HTN</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Drug</th>
								<th>Company</th>
								<th>Generic</th>
								<th>Dose</th>
							</tr>
							<?php 
								foreach($crnt_other_antihtn as $other_antihtn): 
								$drug_info = $this->Visit_model->get_drug_info($other_antihtn['anti_htn_name']);
							?>
							<tr>
								<td><?php echo $other_antihtn['anti_htn_name']; ?></td>
								<td><?php //echo $drug_info['company']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antihtn['anti_htn_dose']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 20px; font-weight: bold;">Anti lipids</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Drug</th>
								<th>Company</th>
								<th>Generic</th>
								<th>Dose</th>
							</tr>
							<?php 
								foreach($crnt_other_antilipids as $other_antilipids): 
								$drug_info = $this->Visit_model->get_drug_info($other_antilipids['anti_lipid_name']);
							?>
							<tr>
								<td><?php echo $other_antilipids['anti_lipid_name']; ?></td>
								<td><?php// echo $drug_info['company']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antilipids['anti_lipid_dose']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 20px; font-weight: bold;">Anti-obesity</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Drug</th>
								<th>Company</th>
								<th>Generic</th>
								<th>Dose</th>
							</tr>
							<?php 
								foreach($crnt_other_antiobesity as $other_antiobesity): 
								$drug_info = $this->Visit_model->get_drug_info($other_antiobesity['anti_obesity_name']);
							?>
							<tr>
								<td><?php echo $other_antiobesity['anti_obesity_name']; ?></td>
								<td><?php// echo $drug_info['company']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_antiobesity['anti_obesity_dose']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						
						<h2 style="font-size: 20px; font-weight: bold;">Others</h2>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Drug</th>
								<th>Company</th>
								<th>Generic</th>
								<th>Dose</th>
							</tr>
							<?php 
								foreach($crnt_other_medic_other as $other_medic_other): 
								$drug_info = $this->Visit_model->get_drug_info($other_medic_other['other_name']);
							?>
							<tr>
								<td><?php echo $other_medic_other['other_name']; ?></td>
								<td><?php //echo $drug_info['company']; ?></td>
								<td><?php echo $drug_info['generic']; ?></td>
								<td><?php echo $other_medic_other['other_dose']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
	  </div>
	  
	  
	  <script src="<?php echo base_url('assets/visit/') ?>assets/framework/bootstrap/js/bootstrap.min.js"></script>
	  <script src="<?php echo base_url('assets/visit/') ?>assets/js/plugins.js"></script>
	  <script src="<?php echo base_url('assets/visit/') ?>assets/js/main.js"></script>
	</body>
</html>