<?php require_once APPPATH.'modules/common/header.php' ?>

<input type="submit" value="Scan QR Code" data-save-method="save" data-toggle="modal" data-target=".scan" id = "" class = ' qr-gn-scan'  style = '    background-color: #3c4451;color: white;    margin-left: 1%;margin-top: 2%'>
	<input type="hidden" id = "entry" value="<?php echo $entry;?>" name="" />
	<div class="modal fade scan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;height: 100%;">
			<div class="modal-dialog modal-sm" style = "margin: 0px;    height: 100%;">
				<div class="modal-content" style = "height: 100%;">
					<div class="modal-header">
						<h4 class="modal-title" id="mySmallModalLabel" style="font-size: 30px;font-weight: bold;text-align: center;">QR Code Scanner</h4> 
					</div>
					<div class="modal-body text-center" style = "padding: 0px;height: 78%;
">
						<video id="preview" style =" height:100%;display:none;"></video>
					</div>
					<div class="modal-footer" style = "text-align: center;">
						<span class="btn btn-default waves-effect"  data-dismiss="modal">Cancel</span>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<?php 
			$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm', 'style' => 'padding:0 1%;');
			
			echo form_open('', $attr);
		?>
		<?php 
			$patientinfo = $this->Progress_model->get_patientinfo($patient_id);
		?>
		 
	
		
	<div  style = "position: sticky;top: 0;width: 100%;" class="navbar-default sidebar color" role="navigation">
		<div  class="sidebar-nav put-relative" >
		
			<div class ="row" >
				
				
				<div class="col-sm-8 menu" >
					<ul class="nav" id="side-menu">
						<li  class="dhp"><a href = "#progress" style = "background: #2f55c7;padding: 0px;color: #ffffff;">Patient Details</a></li>
						<li  class="dhp dhpm"><a href = "#diabetesHistory" style = "background: #2f55c7;padding: 0px;color: #ffffff;">Complications</a></li>
						<li  class="dhp dhpm"><a href = "#generalExamination" style = "background: #2f55c7;padding: 0px;color: #ffffff;">General Examination</a></li>
						<li  class="dhp dhpm"><a href = "#laboratoryInvestigation" style = "background: #2f55c7;padding: 0px;color: #ffffff;">Report</a></li>
						<li  class="dhp dhpm"><a href = "#finalTreatment" style = "background: #2f55c7;padding: 0px;color: #ffffff;">Final Treatment </a></li>

					</ul>
				</div>
				
				
				
			</div>
			
		</div>
	</div>
	
	
	
	
	<div class ="container-fluid">
		<div class ="row">
			<!-- previous visit info -->
			<div class="col-md-3" >
				<?php
					
					if(count($items) !== 0):
					foreach($items as $item):
				?>
				
				<div class=" panel-default" style="margin-top: 10px;border-radius: 15px;padding-bottom: 15px;overflow: hidden;">
					<div class = "panel-heading" >
						<h4 style="display: inline-block;">Doctor name :- </h4>
						<p style="display: inline-block;font-weight: bold;"><?php echo $item['visit_doctor']; ?> </P>
					</div>
					<div class = "" >
						<h4 style="display: inline-block;">Center :- </h4>
						<p style="display: inline-block;font-weight: bold;"><?php echo $item['orgcenter_name']; ?> </P>
					</div>
					<?php 
			$height = $this->Progress_model->get_height($item['visit_id']);
			$weight = $this->Progress_model->get_weight($item['visit_id']);
			$sbp = $this->Progress_model->get_sbp($item['visit_id']);
			$dbp = $this->Progress_model->get_dbp($item['visit_id']);
		?>
					
					<div class = "" >
						<h4 style="display: inline-block;margin: 0px;">Height :- </h4>
						<p style="display: inline-block;font-weight: bold;margin: 0px;"><?php 
						if ($height){
						echo $height['height'];
						}?></P>
					</div>
					
					<div class = "" >
						<h4 style="display: inline-block;margin: 0px;">Weight :- </h4>
						<p style="display: inline-block;font-weight: bold;margin: 0px;"><?php 
						if ($weight){
						echo $weight['weight'];
						}?></P>
					</div>
					
					<div class = "" >
						<h4 style="display: inline-block;margin: 0px;">Blood pressure :- </h4>
						<p style="display: inline-block;font-weight: bold;margin: 0px;"><?php 
						if ($sbp && $dbp){
							$bp = $sbp['sitting_sbp'] . '  |  ' . $dbp['sitting_dbp'];
						echo $bp;
						}?></P>
					</div>
					<div class = "" >
						<h4 style="display: inline-block;">Previous Visit Date :- </h4>
						<p style="display: inline-block;font-weight: bold;"><?php echo date("d M, Y", strtotime($item['visit_date'])); ?> </P>
					</div>
					<a href="<?php echo base_url('patients/progress/view_visit/'.$item['visit_id'].'/'.$patientinfo['patient_entryid'].'/'.$item['visit_patient_id']); ?>"
					style="margin-left: 2%;color: #FFF;font-size:20px;background:#707CC7;border: 1px solid #707cd2;border-radius: 3px;padding:6px 12px;">
					View Visit Detail</a>
				</div>
				<?php 
					
					endforeach;
					else:
				?>
				<div class=" panel-default" style="margin-top: 10px;border-radius: 15px;padding-bottom: 15px;overflow: hidden;">
					<h4 style="text-align: center;font-weight: bold;">No visit recorded yet</h4>
				</div>
				<?php endif; ?>
			</div>
			<!-- previous visit info end-->
			
			<!-- progress Report Form-->
			<div class="col-md-9 padding" style=" margin-top: 10px;" id ="progress">
				<div class = "row " style="background: #FFFFFF; padding-bottom: 10px;border-radius: 10px;margin: auto;">
					<!-- Basic INfo-->
					<div class = "col-sm-12" style = "margin-top: 2%;" >
						<a href="<?php echo base_url('patients/progress/add/'.$patient_id.'/'.$patient_entry_id['patient_entryid']); ?>"
						style="margin-left: 2%;color: #FFF;font-size:20px;background:#707CC7;border: 1px solid #707cd2;border-radius: 3px;padding:6px 12px;">
						BACK TO PRESCRIPTION</a>
						<a href="<?php echo base_url('patients/progress/print_visit/'.$visit_id.'/'.$patient_entry_id['patient_entryid']).'/'.$patient_id; ?>"
						style="margin-left: 2%;color: #FFF;font-size:20px;background:#707CC7;border: 1px solid #707cd2;border-radius: 3px;padding:6px 12px;">
						Print</a>
						<a href="<?php echo base_url('patients/progress/duplicate_visit/'.$visit_id.'/'.$patient_entry_id['patient_entryid']).'/'.$patient_id; ?>"
						style="margin-left: 2%;color: #FFF;font-size:20px;background:#1b75bc;border: 1px solid #707cd2;border-radius: 3px;padding:6px 12px;">
						Duplicate Follow-Up</a>
					</div>
					<div class = "col-sm-12" >
						<div class="col-sm-6" >
							<h3 style="display: inline-block;font-weight: bold;">Previous Visit Report </h3>
						</div>
						<div class="col-sm-1" >
							<label style="margin-top: 10px;" class="">Date:</label>
						</div>
						<div class="col-sm-4" >
							<input  type="text" style = "font-size: 20px;" name="visit_date" value="<?php echo date("d M, Y", strtotime($visit['visit_date'])) ; ?>" class="form-control" readonly>
						</div>
					</div>
					
					<div class = "col-sm-12 padding" style= 'height: 70px'>
						<div class="col-sm-1 padding"  >
							<label style="margin-top: 10px;" class="">Name:</label>
						</div>
						<div class="col-sm-8 padding" >
							<input  type="text" name="finaltreat_next_visit_date" style = "font-size: 20px;" value ="<?php echo $patientinfo['patient_name']; ?>"  class="form-control" readonly>
						</div>
						<div class="col-sm-1 padding" >
							<label style="margin-top: 10px;" class="">Age:</label>
						</div>
						<div class="col-sm-2 padding" >
						<?php if($patientinfo['patient_dateof_birth']):
							 
						  $today = date("Y-m-d");
						  $diff = date_diff(date_create($patientinfo['patient_dateof_birth']), date_create($today));
  
							?>
							<input  type="number" style = "font-size: 20px;" name="finaltreat_next_visit_date" value ="<?php echo $diff->format('%y'); ?>"  class="form-control" readonly>
							<?php endif;?>
						</div>
					</div>
					
					<div class = "col-sm-12 padding" style= 'height: 70px'>
						<div class="col-sm-2 padding" style=" width: 12%;" >
							<label style="margin-top: 10px;" class="">Mobile No:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 38%;">
							<input  type="number" style = "font-size: 20px;" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_phone']; ?>"  class="form-control" readonly>
						</div>
						<div class="col-sm-2 padding" style=" width: 12%;" >
							<label style="margin-top: 10px;" class="">National ID:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 38%;">
							<input  type="number" style = "font-size: 20px;" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_nid']; ?>"  class="form-control" readonly>
						</div>
					</div>
					
					<div class = "col-sm-12 padding" style= 'height: 70px'>
						<div class="col-sm-2 padding" style=" width: 20%;" >
							<label style="margin-top: 10px;" class="">Previous Center ID:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 25%;">
							<input  type="text" style = "font-size: 20px;" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_idby_center']; ?>"  class="form-control" readonly>
						</div>
						<div class="col-sm-1 padding" style=" width: 10%;"  >
							<label style="margin-top: 10px;" class="">BNDR ID:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 42%;">
							<input  type="text" style = "font-size: 20px;" name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_entryid']; ?>"  class="form-control" readonly>
						</div>
					</div>
					<div class = "col-sm-12 padding" style= 'height: 110px'>
						<div class="col-sm-1 padding "  >
							<label style="margin-top: 10px;" class="">Address:</label>
						</div>
						<div class="col-sm-11" >
							<!--<input  type="text"  name="finaltreat_next_visit_date" value ="<?php echo $patientinfo['patient_address']; ?>"  class="form-control" readonly>-->
							<textarea id="first"  class="" cols="30" rows="3"  style="width:100%;font-size: 20px;" readonly><?php echo $patientinfo['patient_address']; ?></textarea>
						</div>
						
					</div>
					
					<div class = "col-sm-12 padding" style= 'height: 70px'>
						<div class="col-sm-5" >
						<p style="font-size: 20px;"><strong>Gender : </strong> <?php 
						 if ($patientinfo['patient_gender'] === '0'){
							 echo 'Male';
							 
						 }else if ($patientinfo['patient_gender'] === '1'){
							 echo 'Female';
						 }else {
							 echo 'other';
						 }
						  ?></p>
						</div>
						<?php if($patientinfo['patient_marital_status']): ?>
						
						<div class="col-sm-1"  >
							<p>|</p>
						</div>
						
						<div class="col-sm-5"  >
							<p style="font-size: 20px;"><strong>Marital Status : </strong> <?php echo $patientinfo['patient_marital_status']; ?></p>
						</div>
						<?php endif; ?>
					</div>
						
					
					<!-- Basic INfo end-->
					<?php if($complication): ?>
					<div class = "col-sm-12 padding" >
						<div class="col-sm-8" >
							<h4 style="display: inline-block;font-weight: bold;">COMPLICATION / COMORBIDITY </h4>
						</div>
						
					</div>
					<?php endif; ?>
					<div class = "col-sm-12 padding" >
						<table class="table table-bordered table-striped" style = "width: 40%">
							
							<?php foreach($complication as $complications): ?>
							<tr>
								<td><strong style="font-size: 18px;"><?php echo $complications['vcomplication_name']; ?> </strong></td>
								
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
					<?php if($general): ?>
					<?php if($general['height'] || $general['weight'] || $general['sitting_sbp'] || $general['sitting_dbp']): ?>
					<div class = "col-sm-12" id = "finalTreatment">
						<div class="col-sm-8" >
							<h4 style="display: inline-block;font-weight: bold;">GENERAL EXAMINATION </h4>
						</div>
						
					</div>
					<?php 
					
					endif;
					endif;

					?>
					<div class = "col-sm-12 padding " >
						<table class="table table-bordered table-striped" style = "width: 40%">
							<?php if($general): ?>
								<tr>
								<?php if($general['height']): ?>
									<td><strong>Height </strong></td>
									<td style="font-size: 18px;"><?php echo $general['height']; ?> </td>
								<?php endif; ?>
								</tr>
								
								<tr>
								<?php if($general['weight']): ?>
									<td><strong>Weight </strong></td>
									<td style="font-size: 18px;"><?php echo $general['weight']; ?> </td>
								<?php endif; ?>
								</tr>
								
								<tr>
								<?php if($general['sitting_sbp']): ?>
									<td><strong>Sitting SBP </strong></td>
									<td style="font-size: 18px;"><?php echo $general['sitting_sbp']; ?> </td>
								<?php endif; ?>
								</tr>
								
								<tr>
								<?php if($general['sitting_dbp']): ?>
									<td><strong>Sitting DBP </strong></td>
									<td style="font-size: 18px;"><?php echo $general['sitting_dbp']; ?> </td>
								<?php endif; ?>
								</tr>
							<?php endif; ?>
						</table>
						
					</div>
					
					<div style="border-bottom: 3px solid #9F9D9E;margin-top: 15px;" class = "col-sm-12" >
						
						
					</div>
					
					<div style="border-bottom: 3px solid #9F9D9E;" class = "col-sm-12 padding" >
						<div  id ="left" class = "col-sm-4 padding" >
							<?php if ($glucose): ?>
							<h5 style="display: inline-block;font-weight: bold;">Type of glucose intolerance </h5>
							
							<div  class = "col-sm-12 padding p" >
								
								<h5 style="display: inline-block;font-size: 20px;"><?php echo $glucose['dhistory_type_of_glucose']; ?> </h5>
								
							</div>
							
							<?php if ($glucose['dhistory_duration_of_glucose'] && $glucose['dhistory_duration_of_glucose'] !== ' '): ?>
							<div  class = "col-sm-12 p padding" >
								<h5 style="display: inline-block;font-weight: bold;">Duration</h5>
							</div>
							<div  class = "col-sm-12 padding p" id = "laboratoryInvestigation">
								
								<h5 style="display: inline-block;font-size: 20px;"><?php echo $glucose['dhistory_duration_of_glucose']; ?> </h5>
								
							</div>
							<?php endif;?>
							<?php if($patientinfo['patient_gender'] === '1'): ?>
							<?php if ($glucose['dhistory_prev_bad_obstetric_history']): ?>
							<div  class = "col-sm-12 padding p" >
								<h5 style="display: inline-block;font-weight: bold;">Previous Bad Obstetrical History</h5>
							</div>
							<div  class = "col-sm-12 padding p" >
								
								<h5 style="display: inline-block;font-size: 20px;"><?php echo $glucose['dhistory_prev_bad_obstetric_history']; ?> </h5>
								
							</div>
							<?php endif;?>
							<?php if ($glucose['dhistory_prev_history_of_gdm']): ?>
							<div  class = "col-sm-12 padding p" >
								<h5 style="display: inline-block;font-weight: bold;">Previous History of GDM</h5>
							</div>
							<div  class = "col-sm-12 padding p" >
								
								<h5 style="display: inline-block;font-size: 20px;"><?php echo $glucose['dhistory_prev_history_of_gdm']; ?> </h5>
								
							</div>
							<?php endif;?>
							<?php if ($glucose['dhistory_past_medical_history']): ?>
							<div  class = "col-sm-12 padding p" >
								<h5 style="display: inline-block;font-weight: bold;">Past Medical History</h5>
							</div>
							<div  class = "col-sm-12 padding p" >
								
								<!--<h5 style="display: inline-block;font-size: 20px;"><?php echo $glucose['dhistory_past_medical_history']; ?> </h5>-->
								<textarea id="first"  class="" cols="30" rows="2"  style="width:100%;font-size: 20px;" readonly><?php echo $glucose['dhistory_past_medical_history']; ?></textarea>
								
							</div>
							<?php endif;?>
							<?php endif; ?>
							<?php endif;
							
							if ($lab):?>
							<div  class = "col-sm-12 padding p" style= "margin-top: 10px;" >
								<h5 style="display: inline-block;font-weight: bold;">Report</h5>
							</div>
							<div  id = "criteriaIncTwo" >
								
								<div  class = "col-sm-12 lab-inv-item padding p" >
									<table class="table table-bordered table-striped" style = "width: 100%">
									
										<?php 
										if ($lab):
										if($lab['after_meal']): ?>
											<tr>
												<td><strong>After-meal</strong></td>
												<td style = "font-size: 20px;"><?php echo $lab['after_meal']; ?></td>
												
											</tr>
										<?php endif; ?>
										
										<?php if($lab['ags']): ?>
											<tr>
												<td><strong>2Ags/2Abf</strong></td>
												<td style = "font-size: 20px;"><?php echo $lab['ags']; ?></td>
												
											</tr>
										<?php endif; ?>
										
										<?php if($lab['fbg']): ?>
											<tr>
												<td><strong>FBG/Before-meal</strong></td>
												<td style = "font-size: 20px;"><?php echo $lab['fbg']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['s_creatinine']): ?>
											<tr>
												<td><strong>S. Creatinine </strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['s_creatinine']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['2hag']): ?>
											<tr>
												<td><strong>2hAG </strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['2hag']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['sgpt']): ?>
											<tr>
												<td><strong>SGPT </strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['sgpt']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['rbg']): ?>
											<tr>
												<td><strong>RBG </strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['rbg']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['hba1c']): ?>
											<tr>
												<td><strong>HbA1c </strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['hba1c']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['t_chol']): ?>
											<tr>
												<td><strong>T. Chol </strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['t_chol']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['ldl_c']): ?>
											<tr>
												<td><strong>LDL-C</strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['ldl_c']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['hdl_c']): ?>
											<tr>
												<td><strong>HDL-C</strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['hdl_c']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['tg']): ?>
											<tr>
												<td><strong>TG</strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['tg']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['urine_albumin']): ?>
											<tr>
												<td><strong>U. Albumin</strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['urine_albumin']; ?></td>
												
											</tr>
										<?php endif; ?>
										<?php if($lab['urine_acetone']): ?>
											<tr>
												<td><strong>U. Acetone</strong></td>
												<td style = "font-size: 18px;"><?php echo $lab['urine_acetone']; ?></td>
												
											</tr>
										<?php endif; ?>
										<tr>
										<?php if($lab['ecg_type'] === '0'): ?>
											
												<td><strong>ECG</strong></td>
												<td style = "font-size: 18px;"><?php 
												$ecg_array1 = array('[', ']', '"');
															$ecg_array2 = array('', '', '');
															$labecg_array = str_replace($ecg_array1, $ecg_array2, $lab['ecg_abnormals']);
															echo 'Abnormal ('.$labecg_array.')';
												
												?></td>
												<?php elseif($lab['ecg_type'] === '1'):?>
												<td><strong>ECG : </strong></td>
												<td style = "font-size: 18px;"><?php echo "Normal"; ?></td>
												
											
										<?php endif; ?>
										</tr>
										<tr>
										<?php if($lab['usg_type'] === '0'): ?>
											
												<td><strong>USG</strong></td>
												<td style = "font-size: 18px;"><?php echo 'Abnormal ('.$lab['usg_abnormals'].')'; ?></td>
												<?php elseif($lab['usg_type'] === '1'):?>
												<td><strong>USG</strong></td>
												<td style = "font-size: 18px;"><?php echo "Normal"; ?></td>
											
										<?php endif; ?>
										</tr>
											<?php	endif;?>
										
										<?php 
										if ($lab_add ):
										foreach($lab_add as $lab_adds): ?>
											<tr>
												<td><strong><?php echo $lab_adds['labinvs_name']?> </strong></td>
												<td style = "font-size: 18px;"><?php echo  $lab_adds['labinvs_value'].' ';  echo  $lab_adds['labinvs_unit']; ?></td>
												
											</tr>
										<?php endforeach; 
										endif;?>
										
									</table>
									
								</div>
							</div>
							
							<?php endif;?>
							
						</div>
						<div   class = "col-sm-8 padding" id ="right" style="width: 69%;" >
							<div   class = "col-sm-12 padding" style= 'height: 70px' >
								<h3 style="text-align: center;font-weight: bold;">Final Treatment</h3>
							</div>
							
							<div   class = "col-sm-12 padding" style="margin-bottom: 2%;height: 100px;display: flex;align-items: center;">
								<label class="control-label col-sm-4 padding">Date</label>
								<div class="col-sm-8 padding">
									<input type="text" style="height: 90px;font-size: 20px;"  name="finaltreat_date" value="<?php echo $investigation? $investigation['finaltreat_date']: null ; ?>" class="form-control text-center " readonly>
								</div>
							</div>
							<?php if($investigation):?>
							<div   class = "col-sm-12 padding p" style= ''>
								<label class="control-label col-sm-4 padding p">Added Clinical Info</label>
								<div class="col-sm-8 padding p">
									<p  value="" style="width:100%; margin-left: 10%;font-size: 20px;word-break: break-all;" readonly><?php echo $investigation? $investigation['finaltreat_clinical_info']: null ; ?></p>
								</div>
								
							</div>
							
							<div   class = "col-sm-12 padding p" style= 'height: 100px'>
								<label class="control-label col-sm-4 padding p">Dietary Advice (Calorie/Day)</label>
								<div class="col-sm-8 padding p">
									<h5  value="" style="width:100%; margin-left: 10%;height: 90px;font-size: 20px;" readonly><?php echo $investigation? $investigation['finaltreat_dietary_advice']: null ; ?></h5>
								</div>
								
							</div>
							
							<div   class = "col-sm-12 padding p" style= 'height: 100px'>
								<label class="control-label col-sm-4 padding p">Physical Acitvity</label>
								<div class="col-sm-8 padding p">
									<h5 value=""  style="width:100%;margin-left: 10%;height: 100px;font-size: 20px;"> <?php echo $investigation? $investigation['finaltreat_physical_acitvity']: null ; ?></h5>
								</div>
							</div>
							<div   class = "col-sm-12 padding p" style= 'height: 100px'>
								<label class="control-label col-sm-4 padding p">Other Advice</label>
								<div class="col-sm-8 padding p">
									<h5 value=""  style="width:100%;margin-left: 10%;height: 100px;font-size: 20px;"> <?php echo $investigation? $investigation['finaltreat_other_advice']: null ; ?></h5>
								</div>
							</div>
							<div   class = "col-sm-12 padding p" style= 'height: 60px'>
								<label class="control-label col-sm-2 padding p">Diet No</label>
								<div class="col-sm-4 padding p">
									<input type="number" style ="font-size: 20px;" class = "finaltreat_diet_no" value="<?php echo $investigation? $investigation['finaltreat_diet_no']: null ; ?>" class="" readonly />
								</div>
							
								<label class="control-label col-sm-2 padding p">Page No</label>
								<div class="col-sm-4 padding p">
									<input type="number" style ="font-size: 20px;" class = "finaltreat_diet_no" value="<?php echo $investigation? $investigation['finaltreat_page_no']: null ; ?>"  class="" readonly />
								</div>
							</div>
							<?php endif;?>
							
							
							
							<?php if ($oads):?>
							<div class = "col-sm-12 padding input-row-fields-9-cntr" style="display: block;" >
								<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">OADs</h4>
								</div>
								
											<?php foreach($oads as $oad):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);margin-bottom: 10px;"  class = "col-sm-12 padding"  >
									
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-12 padding">
											<label  style = "font-weight: 200;"> OADs: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $oad['oads_name'];?> </label>
										</div>
									</div>
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-12 padding">
											<label style = "font-weight: 200;" > Dose: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $oad['oads_dose'];?> </label>
										</div>
											
									</div>
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding" >
										<?php if ($oad['oads_advice_codition_time'] !== null):?>
										<label style = "font-size: 20px;">খাওয়ার  &nbsp; <?php if($oad['oads_advice_codition_time']){ echo $oad['oads_advice_codition_time'];?> &nbsp;
										<?php echo $oad['oads_advice_codition_time_type']; } ?> <?php echo $oad['oads_advice_codition_apply'];?>  &nbsp;  চলবে  &nbsp;   <?php if($oad['oads_duration']): echo $oad['oads_duration'];?>  &nbsp; 
										<?php echo $oad['oads_duration_type']; endif;?></label>
										<?php endif;?>
										
									</div>
									
								</div>
								<?php endforeach;?>
										
								
								
							</div>
							<?php endif;?>
							<?php if ($insuline): ?>
							<div class = "col-sm-12 padding input-row-fields-10-cntr p" style="display: block;" >
								<div style= ""  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Insulin</h4>
								</div>
								
											<?php foreach($insuline as $insulines):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);margin-bottom: 10px;"  class = "col-sm-12 padding"  >
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-12 padding">
											<label style = "font-weight: 200;"> Insulin: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $insulines['insulin_name'];?> </label>
											
										</div>
									</div>
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-12 padding">
											<label style = "font-weight: 200;"> Dose: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $insulines['insulin_dose'];?> </label>
										</div>
											
									</div>
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										<?php if ($insulines['insulin_advice_codition_time'] !== null):?>
										<label style = "font-size: 20px;">খাওয়ার   &nbsp; <?php echo $insulines['insulin_advice_codition_time'];?> &nbsp;    <?php echo $insulines['insulin_advice_codition_time_type'];?>  &nbsp; 
										<?php echo $insulines['insulin_advice_codition_apply'];?>  &nbsp;    চলবে     &nbsp; <?php if($insulines['insulin_duration']): echo $insulines['insulin_duration'];?>   &nbsp;  
										<?php echo $insulines['insulin_duration_type']; endif;?></label>
										
										<?php elseif ($insulines['insulin_before_sleep'] === '1'):?>
										<label style = "font-size: 20px;">&nbsp;ঘুমানোর &nbsp; আগে &nbsp; চলবে</label>
										<?php elseif ($insulines['insulin_week_days']):?>
										<label style = "font-size: 20px;">&nbsp;সপ্তাহে &nbsp; <?php echo $insulines['insulin_week_days'];?> &nbsp; দিন &nbsp;(<?php echo $insulines['insulin_days_list'];?>) </label>
										<?php endif;?>
										
									
									</div>
								
								</div>
								<?php endforeach; ?>
									
								
							</div>
							<?php endif;?>
							<?php if ($htn): ?>
							<div class = "col-sm-12 padding input-row-fields-cntr p" style="display: block;" >
								<div style= ""  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Anti-HTN</h4>
								</div>
								
											<?php foreach($htn as $htns):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);margin-bottom: 10px;"  class = "col-sm-12 padding p"  >
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-12 padding">
											<label style = "font-weight: 200;"> Anti-HTN: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $htns['anti_htn_name'];?> </label>
										</div>
									</div>
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-12 padding">
											<label style = "font-weight: 200;"> Dose: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $htns['anti_htn_dose'];?> </label>
										</div>
											
									</div>
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding" >
										<?php if ($htns['anti_htn_advice_codition_time'] !== null):?>
										<label style = "font-size: 20px;">খাওয়ার   &nbsp; <?php echo $htns['anti_htn_advice_codition_time'];?> &nbsp;    <?php echo $htns['anti_htn_advice_codition_time_type'];?>  &nbsp; 
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
								<div style= ""  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Anti-lipid</h4>
								</div>
								
											<?php foreach($lipid as $lipids):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);margin-bottom: 10px;"  class = "col-sm-12 padding p"  >
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-12 padding">
											<label > Anti-lipid: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $lipids['anti_lipid_name'];?> </label>
										</div>
									</div>
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-6 padding">
											<label > Dose: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $lipids['anti_lipid_dose'];?> </label>
										</div>
											
									</div>
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										<?php if ($lipids['anti_lipid_advice_codition_time'] !== null):?>
										<label style = "font-size: 20px;">খাওয়ার   &nbsp; <?php echo $lipids['anti_lipid_advice_codition_time'];?> &nbsp;    <?php echo $lipids['anti_lipid_advice_codition_time_type'];?>  &nbsp; 
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
								<div style= ""  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Anti-platelet</h4>
								</div>
								
											<?php foreach($antiplatelet as $antiplatelets):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);margin-bottom: 10px;"  class = "col-sm-12 padding p"  >
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-12 padding">
											<label > Anti-platelet: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $antiplatelets['antiplatelets_name'];?> </label>
										
										</div>
									</div>
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-12 padding">
											<label > Dose: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $antiplatelets['antiplatelets_dose'];?> </label>
										
											</div>
											
									</div>
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding" >
										<?php if ($antiplatelets['antiplatelets_advice_codition_time'] !== null):?>
										<label style = "font-size: 20px;">খাওয়ার   &nbsp; <?php echo $antiplatelets['antiplatelets_advice_codition_time'];?> &nbsp;    <?php echo $antiplatelets['antiplatelets_advice_codition_time_type'];?>  &nbsp; 
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
								<div style= ""  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Anti-obesity</h4>
								</div>
								
											<?php foreach($obesity as $obesitys):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);margin-bottom: 10px;"  class = "col-sm-12 padding p"  >
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-12 padding">
											<label > Anti-obesity: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $obesitys['anti_obesity_name'];?> </label>
										
										</div>
									</div>
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-12 padding">
											<label > Dose: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $obesitys['anti_obesity_dose'];?> </label>
										</div>
											
									</div>
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										
										<?php if ($obesitys['anti_obesity_advice_codition_time'] !== null):?>
										<label style = "font-size: 20px;">খাওয়ার   &nbsp; <?php echo $obesitys['anti_obesity_advice_codition_time'];?> &nbsp;    <?php echo $obesitys['anti_obesity_advice_codition_time_type'];?>  &nbsp; 
										<?php echo $obesitys['anti_obesity_advice_codition_apply'];?>  &nbsp;    চলবে     &nbsp; <?php  if($obesitys['anti_obesity_duration']): echo $obesitys['anti_obesity_duration'];?>   &nbsp;  
										<?php echo $obesitys['anti_obesity_duration_type']; endif;?></label>
										<?php endif;?>
										
									</div>
								
								</div>
								<?php endforeach;?>
									
								
								
							</div>
							<?php endif;?>
							<?php if ($other):?>
							<div class = "col-sm-12 padding input-row-fields-5-cntr" style="display: block;" >
								<div style= ""  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Others</h4>
								</div>
								
										<?php	foreach($other as $others):?>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);margin-bottom: 10px;"  class = "col-sm-12 padding p"  >
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-12 padding">
											<label > Others: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $others['other_name'];?> </label>
										</div>
									</div>
									<div style= "margin-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-12 padding">
											<label > Dose: </label>
											<label style = "font-weight: bold;font-size: 20px;"> <?php echo $others['other_dose'];?> </label>
										</div>
											
									</div>
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										<?php if ($others['other_advice_codition_time'] !== null):?>
										<label style = "font-size: 20px;">খাওয়ার   &nbsp; <?php echo $others['other_advice_codition_time'];?> &nbsp;    <?php echo $others['other_advice_codition_time_type'];?>  &nbsp; 
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
						<div style="border-right: 3px solid #9F9D9E;height: 70px" class = "col-sm-12" >
							
							<div class = "col-sm-3" >
								<h5 style="display: inline-block;font-weight: bold;">Next visit date</h5>
								
							</div>
							
							<div class = "col-sm-9" >
								
								<?php if($investigation): ?>
								
									<h5 style="display: inline-block;font-size: 20px;"><?php echo $investigation['finaltreat_next_visit_date'];?></h5>
									
								<?php endif; ?>
									
								
								
							</div>
						</div>
						<div style="border-right: 3px solid #9F9D9E;height: 70px" class = "col-sm-12" >
							
							<div class = "col-sm-3" >
								<h5 style="display: inline-block;font-weight: bold;">Investigations</h5>
								
							</div>
							
							<div class = "col-sm-9" >
								
								<?php if($investigation): ?>
								
								 <!--	<h5 style="display: inline-block;"><?php echo $investigation['finaltreat_next_investigation'];?></h5>-->
								 <textarea id="first"  class="" cols="30" rows="3"  style="width:100%;font-size: 20px;" readonly><?php echo $investigation['finaltreat_next_investigation']; ?></textarea>
									
								<?php endif; ?>
									
								
								
							</div>
						</div>
						<?php if($investigation): 
						if($investigation['finaltreat_refer_to']): 
						?>
						<div style="border-right: 3px solid #9F9D9E;margin-top: 2%;" class = "col-sm-12" >
							
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
						<h4 style="margin-top: 50px;">Doctor Name: <label style = "font-size: 20px;"> <?php echo $visit['visit_doctor']; ?></label></h4>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
	
	<?php echo form_close(); ?>
	
	
	<script type="text/javascript">
		$(function(){
			$(".qr-gn-scan").click(function(){
					$('#preview').show();
					var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
					scanner.addListener('scan',function(content){
						$('.searchBar').val(content);
						$('#preview').hide();
						scanner.stop();
						//alert(content);
						//window.location.href=content;
					});
					Instascan.Camera.getCameras().then(function (cameras){
					if(cameras.length>0){
						//scanner.start(cameras[0]);
						if(cameras[2]){
							scanner.start(cameras[2]);
						}
				   
						else if(cameras[1]){
							scanner.start(cameras[1]);
						}else{
							alert('No Back camera found!');
						}
					}else{
						console.error('No cameras found.');
						alert('No cameras found.');
					}
					}).catch(function(e){
						console.error(e);
						alert(e);
					});
				
				});
	 
		});
	</script>
	<script type="text/javascript">
	$(document).ready(function () {
    // Handler for .ready() called.
    $('html, body').animate({
        scrollTop: $('#progress').offset().top
    }, 'slow');
});
	</script>
	<script type="text/javascript">
	var left = document.getElementById('left').clientHeight;
	var right = document.getElementById('right').clientHeight;
	if (left > right){
	var el = document.getElementById('left');
		el.setAttribute('style', 'border-right: 3px solid #9F9D9E;width: 30%;padding-left: 0px;');
	}else{
		var el = document.getElementById('right');
		el.setAttribute('style', 'border-left: 3px solid #9F9D9E;width: 30%;padding-left: 0px;width: 66%;');
	}
	</script>

	
	

	
	
	
	
<?php require_once APPPATH.'modules/common/footer.php' ?>