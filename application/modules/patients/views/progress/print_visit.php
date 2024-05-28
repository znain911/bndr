<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Progress Report</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel=stylesheet>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/2.4.85/css/materialdesignicons.min.css" />
    <!-- Bootstrap Core CSS -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/bower_components/jsgrid/dist/jsgrid.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/bower_components/jsgrid/dist/jsgrid-theme.min.css" />
    <link href="<?php echo base_url('assets/'); ?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/'); ?>plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Date picker plugins css -->
    <link href="<?php echo base_url('assets/'); ?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
	<!-- Menu CSS -->
    <link href="<?php echo base_url('assets/'); ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?php echo base_url('assets/'); ?>css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/'); ?>css/10.css" rel="stylesheet">
    <!-- color CSS -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- jQuery -->
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url('assets/login/'); ?>js/jquery.validate.js"></script>
	<script type="text/javascript">
		var baseUrl = "<?php echo base_url(); ?>";
	</script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-129395078-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-129395078-1');
	</script>
	<style type="text/css">
 
   
    @page {
       size:  auto;  
	   margin-top: 135px;
    }
 
    
</style>
</head>

<body style="  ">
		<?php 
			$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm', 'style' => 'padding:0 1%;');
			
			echo form_open('', $attr);
		?>
		<?php 
			$patientinfo = $this->Progress_model->get_patientinfo($patient_id);
			$center_id = $visit['visit_org_centerid'];
			$visit_center_name = $this->Progress_model->get_centers($center_id);
			
		?>
		 
	
		
	
	
	
	
	
	<div class ="container-fluid">
		<div class ="row">
			
			
			<!-- progress Report Form-->
			<div class="col-md-12 padding" style=" margin-top: 10px;" id ="progress ">
				<div class = "row " style="background: #FFFFFF; padding-bottom: 10px;border-radius: 10px;margin: auto;">
					<!-- Basic INfo-->
					<div style = "display: flex;justify-content: center;">
						<img style="width: 12%; height: 10%;" src="<?php echo base_url('assets/'); ?>tools/badas_bw.png" alt="Logo" class="dark-logo" />
						
					</div> 
					
					<div style = "display: flex;justify-content: center;">
						<h5 style = "margin-top: 5px;margin-bottom: 0px;"><?php echo date('Y');?> &copy; BADAS Nationwide Electronic Registry.</h5>
					</div> 
					
					<div style = "display: flex;justify-content: center;">
						<h5 style = "margin-top: 5px;margin-bottom: 0px;">Diabetic Association of Bangladesh</h5>
					</div> 
					
					<div class = "col-sm-12" style = "height: 25px;">
						<div class="col-sm-1 " style="display: inline-block;padding-right: 0px;" >
							<label  class="">Date :</label>
						</div>
						<div class="col-sm-3" style="display: inline-block;padding-left: 0px;">
							<!--<input  type="text" name="visit_date" value="<?php echo date("d M, Y", strtotime($visit['visit_date'])) ; ?>" class="form-control" readonly> -->
							<h5 ><?php   echo date("d M, Y", strtotime($visit['visit_date'])) ; ?> </h5>
						</div>
						
						<div class="col-sm-4" style="display: inline-block;">
							<p style = "margin-top: 0px;margin-bottom: 0px;"><strong>Gender :</strong> <?php 
							 if ($patientinfo['patient_gender'] === '0'){
								 echo 'Male';
								 
							 }else if ($patientinfo['patient_gender'] === '1'){
								 echo 'Female';
							 }else {
								 echo 'other';
							 }
							  ?></p>
						</div>
						<?php if ($patientinfo['patient_marital_status']):?>
						<div class="col-sm-4"  style="display: inline-block;padding-right: 0px;">
							<p><strong>Marital Status :</strong> <?php echo $patientinfo['patient_marital_status']; ?></p>
						</div>
						<?php endif;?>
					</div>
					
					<div class = "col-sm-12 padding" style = "height: 18px;">
						<div class="col-sm-1 padding" style="display: inline-block;padding-right: 0px;" >
							<label style="" class="">Name :</label>
						</div>
						<div class="col-sm-7 padding" style="display: inline-block;padding-left: 0px;" >
							<!--<input  type="text" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_name']; ?>"  class="form-control" readonly> -->
							<h5 style = "margin-top: 0px;margin-bottom: 0px;"><?php   echo $patientinfo['patient_name']; ?> </h5>
						</div>
						<div class="col-sm-2 padding" style="display: inline-block;padding-right: 0px;" >
							<label style="" class="">Age :</label>
						</div>
						<div class="col-sm-2 padding" style="display: inline-block;padding-left: 0px;">
							<?php if($patientinfo['patient_dateof_birth']):
							 
						  $today = date("Y-m-d");
						  $diff = date_diff(date_create($patientinfo['patient_dateof_birth']), date_create($today));
  
							?>
							<!--<input  type="number" name="finaltreat_next_visit_date" value ="<?php echo $diff->format('%y'); ?>"  class="form-control" readonly> -->
							<h5 style = "margin-top: 0px;margin-bottom: 0px;"><?php   echo $diff->format('%y'); ?> </h5>
							<?php endif;?>
						</div>
					</div>
					
					
					<?php if ($patientinfo['patient_phone']):?>
					<div class = "col-sm-12 padding" style = "height: 18px;">
						<div class="col-sm-2 padding" style=" display: inline-block;padding-right: 0px;" >
							<label style="" class="">Mobile No :</label>
						</div>
						<div class="col-sm-4 padding" style="display: inline-block;padding-left: 0px;">
							<!--<input  type="number" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_phone']; ?>"  class="form-control" readonly> -->
							<h5 style = "margin-top: 0px;margin-bottom: 0px;"><?php   echo $patientinfo['patient_phone'];?> </h5>
						</div>
						<?php if ($patientinfo['patient_entryid']):?>
						<div class="col-sm-2 padding" style="display: inline-block;padding-right: 0px;"  >
							<label style="" class="">BNDR ID :</label>
						</div>
						<div class="col-sm-4 padding" style=" display: inline-block;padding-left: 0px;">
							<!--<input  type="text" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_entryid']; ?>"  class="form-control" readonly>-->
							<h5 style = "margin-top: 0px;margin-bottom: 0px;"><?php   echo $patientinfo['patient_entryid'];?> </h5>
						</div>
						<?php endif;?>
					</div>
					<?php endif;?>
					
					<?php if ($patientinfo['patient_nid']):?>
					<div class = "col-sm-12 padding" style = "height: 18px;">
						<div class="col-sm-4 padding" style=" display: inline-block;padding-right: 0px;" >
							<label style="" class="">National ID :</label>
						</div>
						<div class="col-sm-8 padding" style=" display: inline-block;padding-left: 0px;">
							<!--<input  type="number" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_nid']; ?>"  class="form-control" readonly>-->
							<h5 style = "margin-top: 0px;margin-bottom: 0px;" ><?php   echo $patientinfo['patient_nid'];?> </h5>
						</div>
					</div>
					<?php endif;?>
					
					
					<div class = "col-sm-12 padding" style = "height: 18px;">
						<div class="col-sm-4 padding" style=" display: inline-block;padding-right: 0px;" >
							<label style="" class="">Center :</label>
						</div>
						<div class="col-sm-8 padding" style=" display: inline-block;padding-left: 0px;">
							<!--<input  type="text" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_idby_center']; ?>"  class="form-control" readonly>-->
							<h5 style = "margin-top: 0px;margin-bottom: 0px;"><?php  echo $visit_center_name['orgcenter_name'];?> </h5>
						</div>
					</div>
					
					
					
					<!--<div class = "col-sm-12 padding" style = "height: 18px;" >
						
					</div>-->
					
					
					<div class = "col-sm-12 padding" style="border-bottom: 3px solid #9F9D9E;height: 25px;" >
						<div class="col-sm-1 padding " style="display: inline-block;padding-right: 0px;"  >
							<label style="" class="">Address :</label>
						</div>
						<div class="col-sm-11" style="display: inline-block;padding-left: 0px;" >
							<!--<input  type="text" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_address']; ?>"  class="form-control" readonly>-->
							<h5 style = "margin-top: 0px;margin-bottom: 0px;"><?php   echo $patientinfo['patient_address'];?> </h5>
						</div>
						
					</div>
					
					<!--<div class = "col-sm-12 padding" style="border-bottom: 3px solid #9F9D9E;height: 25px;" >
						
					</div>-->
					
					
					
					<!-- Basic INfo end-->
					
					<!--<div class = "col-sm-12" >
						<div class="col-sm-8" >
							<h5 style="display: inline-block;font-weight: bold;">COMPLICATION / COMORBIDITY </h5>
						</div>
						
					</div>
					
					<div class = "col-sm-12 padding" >
						<table class="table table-bordered table-striped" style = "width: 40%">
							
							<?php foreach($complication as $complications): ?>
							<tr>
								<td><strong><?php echo $complications['vcomplication_name']; ?> </strong></td>
								
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
					
					<div class = "col-sm-12" id = "finalTreatment">
						<div class="col-sm-8" >
							<h5 style="display: inline-block;font-weight: bold;">GENERAL EXAMINATION </h5>
						</div>
						
					</div>
					
					<div class = "col-sm-12 padding " >
						<table class="table table-bordered table-striped" style = "width: 40%">
							<?php if($general): ?>
								<tr>
								<?php if($general['height']): ?>
									<td><strong>Height </strong></td>
									<td><?php echo $general['height']; ?> </td>
								<?php endif; ?>
								</tr>
								
								<tr>
								<?php if($general['weight']): ?>
									<td><strong>Weight </strong></td>
									<td><?php echo $general['weight']; ?> </td>
								<?php endif; ?>
								</tr>
								
								<tr>
								<?php if($general['sitting_sbp']): ?>
									<td><strong>Sitting SBP </strong></td>
									<td><?php echo $general['sitting_sbp']; ?> </td>
								<?php endif; ?>
								</tr>
								
								<tr>
								<?php if($general['sitting_dbp']): ?>
									<td><strong>Sitting DBP </strong></td>
									<td><?php echo $general['sitting_dbp']; ?> </td>
								<?php endif; ?>
								</tr>
							<?php endif; ?>
						</table>
						
					</div>
					
					<div style="border-bottom: 3px solid #9F9D9E;margin-top: 15px;" class = "col-sm-12 " >
					
						
						
					</div>
					<div  class = " page-break" >
					</div> -->
					
					<div style="border-bottom: 3px solid #9F9D9E;padding-bottom:10px" class = "col-sm-12 padding " >
						<div id= "left" class = "col-sm-12 padding" >
						<!--<?php 
						if ($glucose):
						if ($glucose['dhistory_type_of_glucose'] ):  //print_r($glucose);?>
						<div  class = "col-sm-6 p padding" style="display: inline-block;">
							<h5 style="display: inline-block;font-weight: bold;">Type of glucose Intolerance : </h5>
						</div>
						<?php endif;
						endif;?>
							<div  class = "col-sm-6 padding p" style = "width: 60%;display: inline-block;" >
								<?php if ($glucose): ?>
								<h5 style="display: inline-block;"><?php echo $glucose['dhistory_type_of_glucose']; ?> </h5>
								<?php endif;?>
							</div>
							<?php
							if ($glucose):
							if ($glucose['dhistory_duration_of_glucose']!==''): ?>
							<div  class = "col-sm-6 p padding" style="display: inline-block;">
								<h5 style="display: inline-block;font-weight: bold;">Duration :</h5>
							</div>
							<?php 
							endif;
							endif;?>
							<?php if ($glucose): ?>
							<div  class = "col-sm-6 padding p" style = "width: 60%;display: inline-block;" id = "laboratoryInvestigation">
								
								<h5 style="display: inline-block;"><?php echo $glucose['dhistory_duration_of_glucose']; ?> </h5>
								
							</div>
							<?php endif;?>
							<?php if($patientinfo['patient_gender'] === '1'): ?>
							<?php 
							
							if ($glucose): 
							if ($glucose['dhistory_prev_bad_obstetric_history']): 
							
							?>
							<div  class = "col-sm-6 padding p"  style="display: inline-block;">
								<h5 style="display: inline-block;font-weight: bold;">Previous Bad Obstetrical History :</h5>
							</div>
							<div  class = "col-sm-6 padding p" style = "width: 40%;display: inline-block;">
								
								<h5 style="display: inline-block;"><?php echo $glucose['dhistory_prev_bad_obstetric_history']; ?> </h5>
								
							</div>
							<?php 
							endif;
							endif;
							?>
							<?php 
							if ($glucose):
							if ($glucose['dhistory_prev_history_of_gdm']):
							?>
							<div  class = "col-sm-6 padding p" style="display: inline-block;">
								<h5 style="display: inline-block;font-weight: bold;">Previous History of GDM :</h5>
							</div>
							<div  class = "col-sm-6 padding p" style = "width: 60%;display: inline-block;">
								
								<h5 style="display: inline-block;"><?php echo $glucose['dhistory_prev_history_of_gdm']; ?> </h5>
								
							</div>
							<?php 
							endif;
							endif;
							?>
							<?php 
							if ($glucose): 
							if ($glucose['dhistory_past_medical_history']): 
							
							?>
							<div  class = "col-sm-6 padding p" style="display: inline-block;">
								<h5 style="display: inline-block;font-weight: bold;">Past Medical History :</h5>
							</div>
							<div  class = "col-sm-6 padding p" style = "display: inline-block;" >
								
								<h5 style="display: inline-block;"><?php echo $glucose['dhistory_past_medical_history']; ?> </h5>
								
							</div>
							<?php 
							endif;
							endif;
							?>
							<?php endif; ?>
							<?php if($lab['fbg'] || $lab['s_creatinine']|| $lab['2hag']|| $lab['sgpt']|| $lab['rbg']|| $lab['hba1c']
							|| $lab['t_chol']|| $lab['ldl_c']|| $lab['hdl_c']|| $lab['tg']|| $lab['urine_albumin']|| $lab['urine_acetone']
							|| $lab['ecg_type']): ?>
							<div  class = "col-sm-12 padding p" style= "margin-top: 10px;border-bottom: 3px solid #9F9D9E;" >
								<h3 style="display: inline-block;font-weight: bold;">Report</h3>
							</div>
							<?php endif; ?>-->
							<!--<div  id = "criteriaIncTwo" >
								
								<div  class = "col-sm-12 lab-inv-item padding p" >
									<table class="table table-bordered table-striped" style = "width: 100%">
									
										<?php 
										if ($lab):
										if($lab['fbg']): ?>
											<tr>
												<td><strong>FBG </strong></td>
												<td><?php echo $lab['fbg']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['s_creatinine']): ?>
											<tr>
												<td><strong>S. Creatinine </strong></td>
												<td><?php echo $lab['s_creatinine']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['2hag']): ?>
											<tr>
												<td><strong>2hAG </strong></td>
												<td><?php echo $lab['2hag']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['sgpt']): ?>
											<tr>
												<td><strong>SGPT </strong></td>
												<td><?php echo $lab['sgpt']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['rbg']): ?>
											<tr>
												<td><strong>RBG </strong></td>
												<td><?php echo $lab['rbg']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['hba1c']): ?>
											<tr>
												<td><strong>HbA1c </strong></td>
												<td><?php echo $lab['hba1c']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['t_chol']): ?>
											<tr>
												<td><strong>T. Chol </strong></td>
												<td><?php echo $lab['t_chol']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['ldl_c']): ?>
											<tr>
												<td><strong>LDL-C</strong></td>
												<td><?php echo $lab['ldl_c']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['hdl_c']): ?>
											<tr>
												<td><strong>HDL-C</strong></td>
												<td><?php echo $lab['hdl_c']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['tg']): ?>
											<tr>
												<td><strong>TG</strong></td>
												<td><?php echo $lab['tg']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['urine_albumin']): ?>
											<tr>
												<td><strong>U. Albumin</strong></td>
												<td><?php echo $lab['urine_albumin']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['urine_acetone']): ?>
											<tr>
												<td><strong>U. Acetone</strong></td>
												<td><?php echo $lab['urine_acetone']; ?></td>
												
											</tr>
										<?php endif; ?>
										<tr>
										<?php if($lab['ecg_type'] === '0'): ?>
											
												<td><strong>ECG</strong></td>
												<td><?php 
												$ecg_array1 = array('[', ']', '"');
															$ecg_array2 = array('', '', '');
															$labecg_array = str_replace($ecg_array1, $ecg_array2, $lab['ecg_abnormals']);
															echo 'Abnormal ('.$labecg_array.')';
												
												?></td>
												<?php elseif($lab['ecg_type'] === '1'):?>
												<td><strong>ECG : </strong></td>
												<td><?php echo "Normal"; ?></td>
												
											
										<?php endif; ?>
										</tr>
										<tr>
										<?php if($lab['usg_type'] === '0'): ?>
											
												<td><strong>USG</strong></td>
												<td><?php echo 'Abnormal ('.$lab['usg_abnormals'].')'; ?></td>
												<?php elseif($lab['usg_type'] === '1'):?>
												<td><strong>USG</strong></td>
												<td><?php echo "Normal"; ?></td>
											
										<?php endif; ?>
										</tr>
											<?php	endif;?>
										
										<?php 
										if ($lab_add ):
										foreach($lab_add as $lab_adds): ?>
											<tr>
												<td><strong><?php echo $lab_adds['labinvs_name']?> </strong></td>
												<td><?php echo  $lab_adds['labinvs_value'].' ';   echo  $lab_adds['labinvs_unit']; ?></td>
												
											</tr>
										<?php endforeach; 
										endif;?>
									</table>
									
								</div>
							</div> -->
							
							
							
						</div>
						<div   class = "col-sm-12 padding" style="padding-right: 0px;padding-left: 0px;" id = "right">
							
							
							<!--<div   class = "col-sm-12 padding" style="margin-bottom: 2%;padding-right: 0px;padding-left: 0px;">
								<label class="control-label col-sm-4 padding">Date :</label>
								<div class="col-sm-8 padding" style="display: inline-block;">
									<input type="text" name="finaltreat_date" value="<?php echo $investigation? $investigation['finaltreat_date']: null ; ?>" class="form-control text-center " readonly> 
									<h5 ><?php   echo $investigation? $investigation['finaltreat_date']: null ; ?> </h5>
								</div>
							</div>-->
							<?php if($investigation['finaltreat_clinical_info']):?>
							<div   class = "col-sm-12 padding p" style= ''>
								<label class="control-label col-sm-4 padding p" style ="padding-right: 0px;padding-left: 0px;">Added Clinical Info :</label>
								<div class="col-sm-8 padding p" style="display: inline-block;padding-left: 0px;">
									<p  value="" style="width:100%;word-break: break-all;margin-bottom:0px;" readonly><?php echo $investigation? $investigation['finaltreat_clinical_info']: null ; ?></p>
								</div>
								
							</div>
							<?php endif;
							 if($investigation['finaltreat_dietary_advice']):
							?>
							
							<div   class = "col-sm-12 padding p" style = "padding-right: 0px;padding-left: 0px;height: 18px;" >
								<label class="control-label col-sm-4 padding p" style ="padding-right: 0px;">Dietary Advice (Calorie/Day) :</label>
								<div class="col-sm-8 padding p" style="display: inline-block;padding-left: 0px;">
									<h5  value="" style="width:100%;margin-top: 0px;margin-bottom: 0px;" readonly><?php echo $investigation? $investigation['finaltreat_dietary_advice']: null ; ?></h5>
								</div>
							</div>
							<?php endif;
							 if($investigation['finaltreat_physical_acitvity']):
							?>
							<div   class = "col-sm-12 padding p" style = "padding-right: 0px;padding-left: 0px;height: 18px;">
								<label class="control-label col-sm-2 padding p" style ="padding-right: 0px;">Physical Acitvity :</label>
								<div class="col-sm-10 padding p" style="display: inline-block;padding-left: 0px;">
									<h5 value=""  style="width:100%;margin-top: 0px;margin-bottom: 0px;"> <?php echo $investigation? $investigation['finaltreat_physical_acitvity']: null ; ?></h5>
								</div>
							</div>
							<?php endif;
							 if($investigation['finaltreat_other_advice']):
							?>
							<div   class = "col-sm-12 padding p" style = "padding-right: 0px;padding-left: 0px;height: 18px;">
								<label class="control-label col-sm-2 padding p" style ="padding-right: 0px;">Other Advice:</label>
								<div class="col-sm-10 padding p" style="display: inline-block;padding-left: 0px;">
									<h5 value=""  style="width:100%;margin-top: 0px;margin-bottom: 0px;"> <?php echo $investigation? $investigation['finaltreat_other_advice']: null ; ?></h5>
								</div>
							</div>
							<?php endif;
							 if($investigation['finaltreat_diet_no']):
							?>
							<div   class = "col-sm-12 padding p" style = "padding-right: 0px;padding-left: 0px;height: 18px;">
								<label class="control-label col-sm-2 padding p" style ="padding-right: 0px;">Diet No :</label>
								<div class="col-sm-4 padding p" style="display: inline-block;padding-left: 0px;">
									<!--<input type="number" class = "finaltreat_diet_no" value="<?php echo $investigation? $investigation['finaltreat_diet_no']: null ; ?>" class="" readonly />-->
									<h5 style = "margin-top: 0px;margin-bottom: 0px;"><?php   echo $investigation? $investigation['finaltreat_diet_no']: null ; ?> </h5>
								</div>
								<label class="control-label col-sm-2 padding p" style ="padding-right: 0px;">Page No :</label>
								<div class="col-sm-4 padding p" style="display: inline-block;padding-left: 0px;">
									<!--<input type="number" class = "finaltreat_diet_no" value="<?php echo $investigation? $investigation['finaltreat_page_no']: null ; ?>"  class="" readonly />-->
									<h5 style = "margin-top: 0px;margin-bottom: 0px;"><?php   echo $investigation? $investigation['finaltreat_page_no']: null ; ?> </h5>
								</div>
							</div>
							<?php endif;
							?>
							
							
							
							<?php if ($oads):?>
							<div class = "col-sm-12 padding input-row-fields-9-cntr" style="display: block;margin-top: 2%" >
								<!--<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h5 style="text-align: center;font-weight: bold;">OADs</h5>
								</div>-->
								
								<?php foreach($oads as $oad):
								
								if ($oad['oads_advice_codition_apply'] !== null):?>
										
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 60px;"  class = "col-sm-12 padding"  >
								<?php else:?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 30px;"  class = "col-sm-12 padding"  >
								<?php endif;?>
									<div style= ""  class = "col-sm-12 padding" >
										<div class="col-sm-6 padding p">
											<label style = "font-weight: bold;font-size: 16px;"> <?php echo $oad['oads_name'];?> </label>
											<?php if ($oad['oads_dose']):?> 
											<label style = "font-weight: bold;font-size: 16px;">( <?php echo $oad['oads_dose'];?> )</label>
											<?php endif;?>
										</div>
											
									</div>
									<?php if ($oad['oads_advice_codition_time'] !== null):?>
									<div style= ""  class = "col-sm-12 padding" >
										
										<label style = "font-size: 16px;padding-left: 15px;font-weight: 100;">খাওয়ার  &nbsp;<?php if($oad['oads_advice_codition_time']){ echo $oad['oads_advice_codition_time'];?> &nbsp;
										<?php echo $oad['oads_advice_codition_time_type']; } ?> <?php echo $oad['oads_advice_codition_apply'];?> &nbsp;   চলবে  &nbsp;   <?php if($oad['oads_duration']): echo $oad['oads_duration'];?>  &nbsp; 
										<?php echo $oad['oads_duration_type']; endif;?></label>
										
										
									</div>
									<?php endif;?>
								</div>
								<?php endforeach;?>
										
								
								
							</div>
							<?php endif;?>
							<?php if ($insuline): ?>
							<div class = "col-sm-12 padding input-row-fields-10-cntr p" style="display: block;" >
								<!--<div style= ""  class = "col-sm-12 padding" >
									<h5 style="text-align: center;font-weight: bold;">Insulin</h5>
								</div>-->
								
								<?php foreach($insuline as $insulines):
									if ($insulines['insulin_advice_codition_time'] !== null || $insulines['insulin_before_sleep'] === '1' || $insulines['insulin_week_days']):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 60px;"  class = "col-sm-12 padding"  >
								<?php else:?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 30px;"  class = "col-sm-12 padding"  >
								<?php endif;?>
									<div style= ""  class = "col-sm-12 padding" >
										<div class="col-sm-7">
											<label style = "font-weight: bold;font-size: 16px;"> <?php echo $insulines['insulin_name'];?> </label>
											<?php if ($insulines['insulin_dose']):?> 
											<label style = "font-weight: bold;font-size: 16px;">( <?php echo $insulines['insulin_dose'];?> )</label>
											<?php endif;?>
										</div>
											
									</div>
									
									<div style= ""  class = "col-sm-12 padding p" >
										<?php if ($insulines['insulin_advice_codition_time'] !== null):?>
										<label style = "font-size: 16px;padding-left: 15px;font-weight: 100;">খাওয়ার   &nbsp; <?php echo $insulines['insulin_advice_codition_time'];?> &nbsp;    <?php echo $insulines['insulin_advice_codition_time_type'];?>  &nbsp; 
										<?php echo $insulines['insulin_advice_codition_apply'];?>  &nbsp;    চলবে     &nbsp; <?php if($insulines['insulin_duration']): echo $insulines['insulin_duration'];?>   &nbsp;  
										<?php echo $insulines['insulin_duration_type']; endif;?></label>
										<?php elseif ($insulines['insulin_before_sleep'] === '1'):?>
										<label style = "font-size: 16px;padding-left: 15px;font-weight: 100;">&nbsp;ঘুমানোর &nbsp; আগে &nbsp; চলবে</label>
										<?php elseif ($insulines['insulin_week_days']):?>
										<label style = "font-size: 16px;padding-left: 15px;font-weight: 100;">&nbsp;সপ্তাহে &nbsp; <?php echo $insulines['insulin_week_days'];?> &nbsp; দিন &nbsp;(<?php echo $insulines['insulin_days_list'];?>) </label>
										<?php endif;?>
										
									
									</div>
								
								</div>
								<?php endforeach; ?>
									
								
							</div>
							<?php endif;?>
							<?php if ($htn): ?>
							<div class = "col-sm-12 padding input-row-fields-cntr p" style="display: block;" >
								<!--<div style= ""  class = "col-sm-12 padding" >
									<h5 style="text-align: center;font-weight: bold;">Anti-HTN</h5>
								</div>-->
								
								<?php foreach($htn as $htns):
								if ($htns['anti_htn_advice_codition_time'] !== null):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 60px;"  class = "col-sm-12 padding"  >
								<?php else:?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 30px;"  class = "col-sm-12 padding"  >
								<?php endif;?>
									<div style= ""  class = "col-sm-12 padding" >
										<div class="col-sm-6">
											<label style = "font-weight: bold;font-size: 16px;"> <?php echo $htns['anti_htn_name'];?> </label>
											<?php if ($htns['anti_htn_dose']):?> 
											<label style = "font-weight: bold;font-size: 16px;">( <?php echo $htns['anti_htn_dose'];?> )</label>
											<?php endif;?>
										</div>
											
									</div>
									
									<div style= ""  class = "col-sm-12 padding" >
										<?php if ($htns['anti_htn_advice_codition_time'] !== null):?>
										<label style = "font-size: 16px;padding-left: 15px;font-weight: 100;">খাওয়ার   &nbsp; <?php echo $htns['anti_htn_advice_codition_time'];?> &nbsp;    <?php echo $htns['anti_htn_advice_codition_time_type'];?>  &nbsp; 
										<?php echo $htns['anti_htn_advice_codition_apply'];?>  &nbsp;    চলবে     &nbsp; <?php if($htns['anti_htn_duration']): echo $htns['anti_htn_duration'];?>   &nbsp;  
										<?php echo $htns['anti_htn_duration_type']; endif;?></label>
										<?php endif;?>
									</div>
								
								</div>
								<?php endforeach; ?>
									
								
							</div>
							<?php endif;?>
							<?php if ($lipid): ?>
							<div class = "col-sm-12 padding input-row-fields-2-cntr p" style="display: block;" >
								<!--<div style= ""  class = "col-sm-12 padding" >
									<h5 style="text-align: center;font-weight: bold;">Anti-lipid</h5>
								</div>-->
								
								<?php foreach($lipid as $lipids):
								if ($lipids['anti_lipid_dose']):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 60px;"  class = "col-sm-12 padding"  >
								<?php else:?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 30px;"  class = "col-sm-12 padding"  >
								<?php endif;?>
									<div style= ""  class = "col-sm-12 padding" >
										<div class="col-sm-6">
											
											<label style = "font-weight: bold;font-size: 16px;"> <?php echo $lipids['anti_lipid_name'];?> </label>
										
											<?php if ($lipids['anti_lipid_dose']):?> 
											<label style = "font-weight: bold;font-size: 16px;">( <?php echo $lipids['anti_lipid_dose'];?> )</label>
											<?php endif;?>
										</div>
											
									</div>
									
									<div style= ""  class = "col-sm-12 padding p" >
										<?php if ($lipids['anti_lipid_advice_codition_time'] !== null):?>
										<label style = "font-size: 16px;padding-left: 15px;font-weight: 100;">খাওয়ার   &nbsp; <?php echo $lipids['anti_lipid_advice_codition_time'];?> &nbsp;    <?php echo $lipids['anti_lipid_advice_codition_time_type'];?>  &nbsp; 
										<?php echo $lipids['anti_lipid_advice_codition_apply'];?>  &nbsp;    চলবে     &nbsp; <?php if($lipids['anti_lipid_duration']): echo $lipids['anti_lipid_duration'];?>   &nbsp;  
										<?php echo $lipids['anti_lipid_duration_type']; endif;?></label>
										<?php endif;?>
										
										
									</div>
								
								</div>
								<?php endforeach; ?>
									
								
								
							</div>
							<?php endif;?>
							<?php if ($antiplatelet):?>
							<div class = "col-sm-12 padding input-row-fields-3-cntr p" style="display: block;" >
								<!--<div style= ""  class = "col-sm-12 padding" >
									<h5 style="text-align: center;font-weight: bold;">Anti-platelet</h5>
								</div>-->
								
								<?php foreach($antiplatelet as $antiplatelets):
								if ($antiplatelets['antiplatelets_dose']):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 60px;"  class = "col-sm-12 padding"  >
								<?php else:?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 30px;"  class = "col-sm-12 padding"  >
								<?php endif;?>
									<div style= ""  class = "col-sm-12 padding p" >
										<div class="col-sm-6 ">
											
											<label style = "font-weight: bold;font-size: 16px;"> <?php echo $antiplatelets['antiplatelets_name'];?> </label>
										
											<?php if ($antiplatelets['antiplatelets_dose']):?> 
											<label style = "font-weight: bold;font-size: 16px;">( <?php echo $antiplatelets['antiplatelets_dose'];?> )</label>
											<?php endif;?>
											</div>
											
									</div>
									
									<div style= ""  class = "col-sm-12 padding" >
										<?php if ($antiplatelets['antiplatelets_advice_codition_time'] !== null):?>
										<label style = "font-size: 16px;padding-left: 15px;font-weight: 100;">খাওয়ার   &nbsp; <?php echo $antiplatelets['antiplatelets_advice_codition_time'];?> &nbsp;    <?php echo $antiplatelets['antiplatelets_advice_codition_time_type'];?>  &nbsp; 
										<?php echo $antiplatelets['antiplatelets_advice_codition_apply'];?>  &nbsp;    চলবে     &nbsp; <?php  if($antiplatelets['antiplatelets_duration']): echo $antiplatelets['antiplatelets_duration'];?>   &nbsp;  
										<?php echo $antiplatelets['antiplatelets_duration_type']; endif;?></label>
										<?php endif;?>
										
										
										
									</div>
								
								</div>
								<?php endforeach; ?>
									
								
								
							</div>
							<?php endif;?>
							<?php if ($obesity): ?>
							<div class = "col-sm-12 padding input-row-fields-4-cntr" style="display: block;" >
								<!--<div style= ""  class = "col-sm-12 padding" >
									<h5 style="text-align: center;font-weight: bold;">Anti-obesity</h5>
								</div>-->
								
								<?php foreach($obesity as $obesitys):
								if ($obesitys['anti_obesity_dose']):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 60px;"  class = "col-sm-12 padding"  >
								<?php else:?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 30px;"  class = "col-sm-12 padding"  >
								<?php endif;?>
									<div style= ""  class = "col-sm-12 padding p" >
										<div class="col-sm-6">
											
											<label style = "font-weight: bold;font-size: 16px;"> <?php echo $obesitys['anti_obesity_name'];?> </label>
										
											<?php if ($obesitys['anti_obesity_dose']):?> 
											<label style = "font-weight: bold;font-size: 16px;">( <?php echo $obesitys['anti_obesity_dose'];?> )</label>
											<?php endif;?>
										</div>
											
									</div>
									
									<div style= ""  class = "col-sm-12 padding p" >
										
										<?php if ($obesitys['anti_obesity_advice_codition_time'] !== null):?>
										<label style = "font-size: 15px;padding-left: 15px;font-weight: 100;">খাওয়ার   &nbsp; <?php echo $obesitys['anti_obesity_advice_codition_time'];?> &nbsp;    <?php echo $obesitys['anti_obesity_advice_codition_time_type'];?>  &nbsp; 
										<?php echo $obesitys['anti_obesity_advice_codition_apply'];?>  &nbsp;    চলবে     &nbsp; <?php if($obesitys['anti_obesity_duration']): echo $obesitys['anti_obesity_duration'];?>   &nbsp;  
										<?php echo $obesitys['anti_obesity_duration_type']; endif;?></label>
										<?php endif;?>
										
									</div>
								
								</div>
								<?php endforeach;?>
									
								
								
							</div>
							<?php endif;?>
							<?php if ($other):?>
							<div class = "col-sm-12 padding input-row-fields-5-cntr" style="display: block;" >
								<!--<div style= ""  class = "col-sm-12 padding" >
									<h5 style="text-align: center;font-weight: bold;">Others</h5>
								</div>-->
								
								<?php	foreach($other as $others):
								if ($others['other_dose']):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 60px;"  class = "col-sm-12 padding"  >
								<?php else:?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);height: 30px;"  class = "col-sm-12 padding"  >
								<?php endif;?>
									<div style= ""  class = "col-sm-12 padding p" >
										<div class="col-sm-6">
											
											<label style = "font-weight: bold;font-size: 16px;"> <?php echo $others['other_name'];?> </label>
										
											<?php if ($others['other_dose']):?> 
											<label style = "font-weight: bold;font-size: 16px;"> <?php echo $others['other_dose'];?> </label>
											<?php endif;?>
										</div>
											
									</div>
									
									<div style= ""  class = "col-sm-12 padding p" >
										<?php if ($others['other_advice_codition_time'] !== null):?>
										<label style = "font-size: 16px;padding-left: 15px;font-weight: 100;">খাওয়ার   &nbsp; <?php echo $others['other_advice_codition_time'];?> &nbsp;    <?php echo $others['other_advice_codition_time_type'];?>  &nbsp; 
										<?php echo $others['other_advice_codition_apply'];?>  &nbsp;    চলবে     &nbsp; <?php if($others['other_duration']): echo $others['other_duration'];?>   &nbsp;  
										<?php echo $others['other_duration_type']; endif;?></label>
										<?php endif;?>
										
									</div>
								
								</div>
								<?php endforeach;?>
									
								
							</div>
							<?php endif;?>
						</div>
						
						
					</div>
					
					<div  class = "col-sm-12" >
						<div style="" class = "col-sm-12" style = "height: 18px;" >
							<?php if($investigation['finaltreat_next_visit_date']): ?>
							<div class = "col-sm-3" style="display: inline-block;padding-right: 0px;">
								<h5 style="display: inline-block;font-weight: bold;margin-top: 0px;margin-bottom: 0px;">Next visit date :</h5>
								
							</div>
							
							<div class = "col-sm-9" style="display: inline-block;padding-left: 0px;" >
								
								<?php if($investigation): ?>
								
									
									<!--<h5 style="display: inline-block;margin-top: 0px;margin-bottom: 0px;" ><?php   echo date("d M, Y", strtotime($investigation['finaltreat_next_visit_date'])) ; ?> </h5>-->
									<h5 style="display: inline-block;margin-top: 0px;margin-bottom: 0px;" ><?php   if (strpos($investigation['finaltreat_next_visit_date'], '/')!== false) { 
																														
																														$nv_date = str_replace("/", "-", $investigation['finaltreat_next_visit_date']);
																														echo date("d M, Y", strtotime($nv_date));
																													}else{
																														echo date("d M, Y", strtotime($investigation['finaltreat_next_visit_date']));
																													} ?> 
																													
																													</h5>
									
								<?php endif; ?>
									
								
								
							</div>
							<?php endif; ?>
						</div>
						<div style="" class = "col-sm-12" >
							<?php if($investigation['finaltreat_next_investigation']): ?>
							<div class = "col-sm-3" style="display: inline-block;padding-right: 0px;">
								<h5 style="display: inline-block;font-weight: bold;margin-top: 0px;margin-bottom: 0px;"> Next Investigations :</h5>
								
							</div>
							
							<div class = "col-sm-9" style="display: inline-block;padding-left: 0px;">
								
								<?php if($investigation): ?>
								
									<h5 style="display: inline-block;margin-top: 0px;margin-bottom: 0px;"><?php echo $investigation['finaltreat_next_investigation'];?></h5>
									
								<?php endif; ?>
									
								
								
							</div>
							<?php endif; ?>
						</div>
						<?php if($investigation): 
						if($investigation['finaltreat_refer_to']): 
						?>
						<div style="margin-top: 2%;align-items: flex-start; display: flex;" class = "col-sm-12" >
							
							<div class = "col-sm-3" >
								<h5 style="display: inline-block;font-weight: bold;">Refer to </h5>
								
							</div>
							
							<div class = "col-sm-9" >
								
								<?php $myArray = explode(' ', $investigation['finaltreat_refer_to']); 
									foreach($myArray as $row):
									
									if($row !== ''):
									$row = str_replace('_', ' ', $row);
								?>
									
								 	<h4 style="display: inline-block;font-weight: bold;"><?php echo $row;?></h4> <br>
									
							<?php 
							endif;
							endforeach;?>
									
								
								
							</div>
						</div>
						<?php endif; endif; ?>
						<div  class = "col-sm-6" >
						<h4 style="  margin-left: 2.5%;">Doctor Name: <label> <?php echo $visit['visit_doctor']; ?></label></h4>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
	
	<?php echo form_close(); ?>
	<script>
		window.print();
	</script>
	
	<script type="text/javascript">
	// var left = document.getElementById('left').clientHeight;
	// var right = document.getElementById('right').clientHeight;
	// if (left > right){
	// var el = document.getElementById('left');
		// el.setAttribute('style', 'padding-left: 0px;');
	// }else{
		// var el = document.getElementById('right');
		//el.setAttribute('style', 'border-left: 3px solid #9F9D9E;width: 30%;padding-left: 0px;width: 66%;');
	// }
	</script>
	
	

           
            <!-- /.container-fluid 
            <footer class="footer text-center" style = "position: fixed;bottom: 0;overflow:hidden;"><img style="width: 4%;" src="<?php echo base_url('assets/'); ?>tools/badas_bw.png" alt="Logo" class="dark-logo" /> <?php echo date('Y');?> &copy; BADAS Nationwide Electronic Registry. <span style="float: right;">Version 2</span></footer>-->
        
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<!-- Menu Plugin JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--Counter js -->
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>js/jquery.slimscroll.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>js/custom.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>js/dashboard3.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#dataTable').DataTable();
		});
	</script>
	<script type="text/javascript">
		$('.datepicker').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'dd/mm/yyyy',
		});
	</script>
</body>
</html>