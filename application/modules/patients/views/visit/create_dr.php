<?php require_once APPPATH.'modules/common/header.php' ?>
	<div id="visitLoader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-12 col-md-12 col-xs-12">
		<input type="submit" value="Scan QR Code" onclick="myFunction()" data-toggle="modal" data-target=".scan" id = "" class = ' qr-gn-scan'  style = '    background-color: #3c4451;color: white;    margin-left: 1%;'>
			
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Patients</li>
				<li class="active">Create</li>
			</ol>
			
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<input type="hidden" id = "entry" value="<?php echo $patient_entry_id;?>" name="" />
	
	<div class="modal fade scan" id = "myModal" style="display: none;height: 100%;">
			<div class="modal-dialog modal-sm" style = "margin: 0px;    height: 100%;">
				<div class="modal-content" style = "height: 100%;">
					<div class="modal-header">
						<h4 class="modal-title" id="mySmallModalLabel" style="font-size: 30px;font-weight: bold;text-align: center;">QR Code Scanner</h4> 
					</div>
					<div class="modal-body text-center" style = "padding: 0px;height: 78%;" id ="scanner">
						
					</div>
					<div class="modal-footer" style = "text-align: center;">
						<span class="btn btn-default waves-effect"  data-dismiss="modal">Cancel</span>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
	
	
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row " >
		<?php 
			$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm', 'style' => 'padding:0 5%;');
			echo form_open('', $attr);
		?>
		<?php 
			$patientinfo = $this->Visit_model->get_patientinfo($patient_id);
			
		?>
		
		<div class="col-lg-10 visit-form-col">
			<div id="alert"></div>
			<div class="panel panel-default block2">
				<div class="panel-heading text-center put-relative">PATIENT DETAILS 
					<span class="act-rdr">
						<span class="fa fa-eye" onclick="window.location.href='<?php echo base_url('patients/edit/'.$patient_id.'/'.$patient_entry_id); ?>'"></span>
						<span class="fa fa-pencil" onclick="window.location.href='<?php echo base_url('patients/edit/'.$patient_id.'/'.$patient_entry_id); ?>'"></span>
					</span>
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body patient-details-pnl">
						<div class="media">
							<a class="pull-left" href="#">
								<img class="media-object dp img-circle" src="<?php echo base_url('assets/tools/default_avatar.png'); ?>" style="width: 100px;height:100px;">
							</a>
							<div class="media-body">
								<h4 class="media-heading"><?php echo $patientinfo['patient_name']; ?></h4>
								<p><strong>Gender : </strong> <?php echo ($patientinfo['patient_gender'] === '0')? 'Male' : 'Female'; ?></p>
								<p><strong>BNDR ID : </strong> <?php echo $patientinfo['patient_entryid']; ?></p>
								<p><strong>Patient Guide Book No : </strong> <?php echo $patientinfo['patient_guide_book']; ?></p>
							</div>
							<div class="media-body">
								<p><strong>phone Number : </strong> <?php echo $patientinfo['patient_phone']; ?></p>
								<p><strong>Address : </strong> <?php echo $patientinfo['patient_address']; ?></p>
								<p><strong>Age : </strong> <?php echo $patientinfo['patient_age']; ?></p>
							</div>
							<input type="hidden" name="patient_gender" value="<?php echo $patientinfo['patient_gender']; ?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="visitDetails">
				<div class="panel-heading text-center">VISIT DETAILS</div>
				<input type="hidden" name="visit_patient" value="<?php echo $patient_id; ?>" />
				<input type="hidden" name="visit_patient_bndr_ID" value="<?php echo $patientinfo['patient_entryid']; ?>" />
				<input type="hidden" name="visit_patient_phone" value="<?php echo $patientinfo['patient_phone']; ?>" />
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body"id = 'deactive-enter-visit'>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Registration Date<span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="visit_date" value="<?php echo formated_date($patientinfo['patient_create_date']); ?>" placeholder="DD/MM/YYYY" readonly />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Registration Center <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" name="registration_center_name" class="form-control src-registration-center" value="<?php echo ($patientinfo['orgcenter_name'])? $patientinfo['orgcenter_name'] : null; ?>" readonly />
										<input type="hidden" name="registration_center_id" id="hiddenRegistrationCenterId" value="<?php echo ($patientinfo['patient_org_centerid'])? $patientinfo['patient_org_centerid'] : null; ?>" />
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Visit Date<span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" class="form-control datepicker check-date-is-valid" name="visit_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" />
									</div>
								</div>
								<?php 
									//check user is operator
									$user_type = $this->session->userdata('user_type');
									if($user_type == 'Operator'){
										$operator_center_name = $this->session->userdata('user_org_center_name');
										$operator_center_id = $this->session->userdata('user_org_center_id');
									}elseif($user_type == 'Assistant'){
										$operator_center_name = $this->session->userdata('user_org_center_name');
										$operator_center_id = $this->session->userdata('user_org_center_id');
									}elseif($user_type == 'Doctor'){
										$operator_center_name = $this->session->userdata('user_org_center_name');
										$operator_center_id = $this->session->userdata('user_org_center_id');
									}else{
										$operator_center_name = null;
										$operator_center_id   = null;
									}
								?>
								<div class="form-group">
									<label class="control-label col-md-5">Visit Center <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" name="visit_center_name" class="form-control src-visit-center" value="<?php echo ($operator_center_name !== null)? $operator_center_name : null; ?>" />
										<input type="hidden" name="visit_center_id" id="hiddenVisitCenterId" value="<?php echo ($operator_center_id !== null)? $operator_center_id : null; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="personalHabits">
				<div class="panel-heading text-center">PERSONAL HABITS</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div id="criteriaIncFour">
								<div class="col-md-15 col-sm-3 text-center" style="margin-bottom:15px;">
									<label class="phabit-check"><input type="checkbox" name="phabit_row_name_1" value="Chewing Tobacco"/>&nbsp;&nbsp;Chewing Tobacco</label> &nbsp;&nbsp;
									<input type="hidden" name="phabit_row[]" value="1" />
								</div>
								<div class="col-md-15 col-sm-3 text-center" style="margin-bottom:15px;">
									<label class="phabit-check"><input type="checkbox" name="phabit_row_name_2" value="Smoking"/>&nbsp;&nbsp;Smoking</label> &nbsp;&nbsp;
									<input type="hidden" name="phabit_row[]" value="2" />
								</div>
								<div class="col-md-15 col-sm-3 text-center" style="margin-bottom:15px;">
									<label class="phabit-check"><input type="checkbox" name="phabit_row_name_3" value="Betel Leaf"/>&nbsp;&nbsp;Betel Leaf</label> &nbsp;&nbsp;
									<input type="hidden" name="phabit_row[]" value="3" />
								</div>
								<div class="col-md-15 col-sm-3 text-center" style="margin-bottom:15px;">
									<label class="phabit-check"><input type="checkbox" name="phabit_row_name_4" value="Betel Nut"/>&nbsp;&nbsp;Betel Nut</label> &nbsp;&nbsp;
									<input type="hidden" name="phabit_row[]" value="4" />
								</div>
								<div class="col-md-15 col-sm-3 text-center" style="margin-bottom:15px;">
									<label class="phabit-check"><input type="checkbox" name="phabit_row_name_5" value="Alcohol"/>&nbsp;&nbsp;Alcohol</label> &nbsp;&nbsp;
									<input type="hidden" name="phabit_row[]" value="5" />
								</div>
							</div>
							<div class="col-lg-12">
								<?php if( $this->session->userdata('user_type') === 'Doctor'):?>
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;margin-top: 110px;">
								<?php else:?>
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
								<?php endif;?>
								
									<p class="text-center">Others</p>
									<p>Name <input type="text" id="phabitFieldName" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="phabit-add">ADD</span></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="familyHistory">
				<div class="panel-heading text-center">FAMILY HISTORY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
						<?php if( $this->session->userdata('user_type') === 'Doctor'):?>
							<div class="col-sm-3 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_1" value="Diabetes"/>&nbsp;&nbsp;Diabetes</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="1" />
							</div>
							<div class="col-sm-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_2" value="HTN"/>&nbsp;&nbsp;HTN</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="2" />
							</div>
							<div class="col-sm-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_3" value="CAD"/>&nbsp;&nbsp;CAD</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="3" />
							</div>
							<div class="col-sm-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_4" value="Stroke"/>&nbsp;&nbsp;Stroke</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="4" />
							</div>
							<div class="col-sm-3 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_5" value="Obesity"/>&nbsp;&nbsp;Obesity</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="5" />
							</div>
							<div class="col-sm-3 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_6" value="Dyslipidaemia"/>&nbsp;&nbsp;Dyslipidaemia</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="6" />
							</div>
							<?php else:?>
							<div class="col-md-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_1" value="Diabetes"/>&nbsp;&nbsp;Diabetes</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="1" />
							</div>
							<div class="col-md-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_2" value="HTN"/>&nbsp;&nbsp;HTN</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="2" />
							</div>
							<div class="col-md-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_3" value="CAD"/>&nbsp;&nbsp;CAD</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="3" />
							</div>
							<div class="col-md-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_4" value="Stroke"/>&nbsp;&nbsp;Stroke</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="4" />
							</div>
							<div class="col-md-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_5" value="Obesity"/>&nbsp;&nbsp;Obesity</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="5" />
							</div>
							<div class="col-md-2 text-center family-history-rows" style="margin-bottom:15px;">
								<label class="phabit-check"><input type="checkbox" name="family_history_row_name_6" value="Dyslipidaemia"/>&nbsp;&nbsp;Dyslipidaemia</label> &nbsp;&nbsp;
								<input type="hidden" name="family_history_row[]" value="6" />
							</div>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="diabetesHistory">
				<div class="panel-heading text-center">DIABETES HISTORY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-7">Type of glucose intolerance</label>
									<div class="col-md-5">
										<select name="type_of_glucose" class="form-control">
											<option value="">Select Type</option>
											<?php 
												$type_of_glucoses = array(
																		'Type 2 DM' => 'Type 2 DM',
																		'Type 1 DM' => 'Type 1 DM',
																		'IGT'       => 'IGT',
																		'IFG'       => 'IFG',
																		'GDM'       => 'GDM',
																		'Others'    => 'Others',
																	);
												foreach($type_of_glucoses as $key => $value):
											?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-7">Duration of glucose intolerance</label>
									<div class="col-md-5">
										<select name="duration_of_glucose" class="form-control">
											<option value="">Select Duration</option>
											<?php 
												$duration_of_glucoses = array(
																		'<1 Month'     => '<1 Month',
																		'<1 Year'      => '<1 Year',
																		'1-5 Years'    => '1-5 Years',
																		'>5-10 Years'  => '>5-10 Years',
																		'>10-15 Years' => '>10-15 Years',
																		'>15-20 Years' => '>15-20 Years',
																		'>20 Years'    => '>20 Years',
																	);
												foreach($duration_of_glucoses as $key => $value):
											?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align: left; margin-top: 0px;">Complication / Comorbidity</h3>
							</div>
							<div id="criteriaIncThree">
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_1" value="CAD" />&nbsp;&nbsp;CAD</label>
									<input type="hidden" name="complication_row[]" value="1" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_2" value="Foot Complications" />&nbsp;&nbsp;Foot Complications</label>
									<input type="hidden" name="complication_row[]" value="2" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_3" value="Gastro Complications" />&nbsp;&nbsp;Gastro Complications</label>
									<input type="hidden" name="complication_row[]" value="3" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_4" value="Stroke" />&nbsp;&nbsp;Stroke</label>
									<input type="hidden" name="complication_row[]" value="4" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_5" value="Nephropathy" />&nbsp;&nbsp;Nephropathy</label>
									<input type="hidden" name="complication_row[]" value="5" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_6" value="Hypoglycaemia" />&nbsp;&nbsp;Hypoglycaemia</label>
									<input type="hidden" name="complication_row[]" value="6" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_7" value="PVD" />&nbsp;&nbsp;PVD</label>
									<input type="hidden" name="complication_row[]" value="7" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_8" value="Retinopathy" />&nbsp;&nbsp;Retinopathy</label>
									<input type="hidden" name="complication_row[]" value="8" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_9" value="DKA" />&nbsp;&nbsp;DKA</label>
									<input type="hidden" name="complication_row[]" value="9" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_10" value="Hypertension" />&nbsp;&nbsp;Hypertension</label>
									<input type="hidden" name="complication_row[]" value="10" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_11" value="Neuropathy" />&nbsp;&nbsp;Neuropathy</label>
									<input type="hidden" name="complication_row[]" value="11" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_12" value="HHS" />&nbsp;&nbsp;HHS</label>
									<input type="hidden" name="complication_row[]" value="12" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_13" value="Dyslipidaemia" />&nbsp;&nbsp;Dyslipidaemia</label>
									<input type="hidden" name="complication_row[]" value="13" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_14" value="Skin Disease" />&nbsp;&nbsp;Skin Disease</label>
									<input type="hidden" name="complication_row[]" value="14" />
								</div>
								<div class="col-lg-3 complication-comorbidity-rows">
									<label><input type="checkbox" name="complication_15" value="Others" />&nbsp;&nbsp;Others</label>
									<input type="hidden" name="complication_row[]" value="15" />
								</div>
							</div>
							<div class="col-lg-12 text-right">
								<br />
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p>Name <input type="text" id="complicationName" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="complication-add">ADD</span></p>
								</div>
							</div>
						</div>
						<?php if($patientinfo['patient_gender'] === '1'): ?>
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align: left; margin-top: 0px;">Previous Bad Obstetrical History</h3>
							</div>
							<div class="col-lg-2">
								<label class="prev-bad-obstetric-history-yes"><input class="checkbox-prev-bad-obstetric-history-yes" type="checkbox" name="prev_bad_obstetric_history" value="YES" />&nbsp;&nbsp; YES</label>
							</div>
							<div class="col-lg-2">
								<label class="prev-bad-obstetric-history-no"><input class="checkbox-prev-bad-obstetric-history-no" type="checkbox" name="prev_bad_obstetric_history" value="NO" />&nbsp;&nbsp; NO</label>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align: left; margin-top: 0px;">Previous History of GDM</h3>
							</div>
							<div class="col-lg-2">
								<label class="prev-history-of-gdm-yes"><input class="checkbox-prev-history-of-gdm-yes" type="checkbox" name="prev_history_of_gdm" value="YES" />&nbsp;&nbsp; YES</label>
							</div>
							<div class="col-lg-2">
								<label class="prev-history-of-gdm-no"><input class="checkbox-prev-history-of-gdm-no" type="checkbox" name="prev_history_of_gdm" value="NO" />&nbsp;&nbsp; NO</label>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align: left; margin-top: 0px;">Past Medical History</h3>
							</div>
							<div class="col-lg-8">
								<textarea name="past_medical_history" class="check-alphanumeric-charactars" cols="30" rows="3" style="width:100%"></textarea>
							</div>
						</div>
						<?php endif; ?>
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align: left; margin-top: 0px;">Symptoms at Diagnosis</h3>
							</div>
							<div class="col-lg-2">
								<label class="sel-sympt-diabetes-yes" data-value="1"><input type="checkbox" class="checkbox-sympt-diabetes-yes" name="symptoms_at_diagnosis" value="1" />&nbsp;&nbsp; YES</label>
							</div>
							<div class="col-lg-2">
								<label class="sel-sympt-diabetes-no" data-value="0"><input type="checkbox" class="checkbox-sympt-diabetes-no" name="symptoms_at_diagnosis" value="0" />&nbsp;&nbsp; NO</label>
							</div>
							<div class="col-lg-12" style="margin-top: 10px;">
								<div class="row diabetes-type-keywords" style="display:none">
									<div class="col-lg-2">
										<label><input type="checkbox" name="symptoms_at_diagnosis_types[]" value="Typical" />&nbsp;&nbsp; Typical</label>
									</div>
									<div class="col-lg-2">
										<label><input type="checkbox" name="symptoms_at_diagnosis_types[]" value="Atypical" />&nbsp;&nbsp; Atypical </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align: left; margin-top: 0px;">Other Complaints</h3>
							</div>
							<div class="col-lg-8">
								<textarea name="other_complaints" class="check-alphanumeric-charactars" cols="30" rows="3" style="width:100%"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="generalExamination">
				<div class="panel-heading text-center">GENERAL EXAMINATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div id="criteriaIncOne">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label col-md-5">Height</label>
										<div class="col-md-7 general-examination-height">
											<div class="row">
												<div class="col-md-7">
													<select name="gexam_height_unit" class="form-control sel-gexam-height">
														<option value="">Select Unit</option>
														<option value="ft/inch">ft/inch</option>
														<option value="Inch">Inch</option>
														<option value="cm" selected >cm</option>
													</select>
												</div>
												<div class="col-md-5">
													<input type="text" class="form-control check-with-decimel" name="gexam_height_value" placeholder="Height" />
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label col-md-5">Weight</label>
										<div class="col-md-4">
											<input type="text" name="gexam_weight_unit" value="Kg" class="form-control" readonly />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control check-with-decimel" name="gexam_weight_value" placeholder="Weight" />
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label col-md-5">Hip</label>
										<div class="col-md-4">
											<select name="gexam_hip_unit" class="form-control">
												<option value="">Select Unit</option>
												<option value="Inch">Inch</option>
												<option value="cm">cm</option>
											</select>
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control check-with-decimel" name="gexam_hip_value" placeholder="Hip" />
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label col-md-5">Waist</label>
										<div class="col-md-4">
											<select name="gexam_waist_unit" class="form-control">
												<option value="">Select Unit</option>
												<option value="Inch">Inch</option>
												<option value="cm">cm</option>
											</select>
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control check-with-decimel" name="gexam_waist_value" placeholder="Waist" />
										</div>
									</div>
									<input type="hidden" name="gexam_row[]" value="4" />
									<input type="hidden" name="gexam_row_name_4" value="Waist" />
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label col-md-5">Sitting SBP</label>
										<div class="col-md-4">
											<input type="text" name="gexam_si_sbp_unit" value="mm/Hg" class="form-control" readonly />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control check-with-decimel" name="gexam_si_sbp_value" placeholder="Sitting SBP" />
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label col-md-5">Sitting DBP</label>
										<div class="col-md-4">
											<input type="text" name="gexam_si_dbp_unit" value="mm/Hg" class="form-control" readonly />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control check-with-decimel" name="gexam_si_dbp_value" placeholder="Sitting DBP" />
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label col-md-5">Standing SBP</label>
										<div class="col-md-4">
											<input type="text" name="gexam_st_sbp_unit" value="mm/Hg" class="form-control" readonly />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control check-with-decimel" name="gexam_st_sbp_value" placeholder="Standing SBP" />
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label col-md-5">Standing DBP</label>
										<div class="col-md-4">
											<input type="text" name="gexam_st_dbp_unit" value="mm/Hg" class="form-control" readonly />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control check-with-decimel" name="gexam_st_dbp_value" placeholder="Standing DBP" />
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<h3 style="text-align: right; margin-top: 0px;">Other Physical Examinations</h3>
								</div>
								<div class="col-lg-6">
									<textarea name="other_physical_examinations" class="check-alphanumeric-charactars" cols="30" rows="3" style="width:100%"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="footExamination">
				<div class="panel-heading text-center">FOOT EXAMINATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body" id = 'deactive-enter-foot'>
						<div class="row">
							<div class="col-lg-offset-6 col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Date</label>
									<div class="col-md-7">
										<input type="text" name="footexm_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" class="form-control text-center datepicker check-date-is-valid">
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<h3 style="text-align: center; margin-top: 0px;">PERIPHERAL PLUS</h3>
							</div>
							<div class="col-lg-6" style="margin-bottom:15px;">
								<p><strong>Arteria Dorsalis Pedis</strong></p>
								<p>
									<label class="arteria-dorsalis-predis-present-left"><input class="checkbox-arteria-dorsalis-predis-present-left" type="checkbox" name="arteria_dorsalis_predis_present_left" value="Left"/>&nbsp;&nbsp;Present-Left</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="arteria-dorsalis-predis-present-right"><input class="checkbox-arteria-dorsalis-predis-present-right" type="checkbox" name="arteria_dorsalis_predis_present_right" value="Right" />&nbsp;&nbsp;Present-Right</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="arteria-dorsalis-predis-absent-left"><input class="checkbox-arteria-dorsalis-predis-absent-left" type="checkbox" name="arteria_dorsalis_predis_absent_left" value="Left" />&nbsp;&nbsp;Absent-Left</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="arteria-dorsalis-predis-absent-right"><input class="checkbox-arteria-dorsalis-predis-absent-right" type="checkbox" name="arteria_dorsalis_predis_absent_right" value="Right" />&nbsp;&nbsp;Absent-Right</label>
								</p>
							</div>
							<div class="col-lg-6" style="margin-bottom:15px;">
								<p><strong>Posterior Tribila</strong></p>
								<p>
									<label class="posterior-tribila-present-left"><input class="checkbox-posterior-tribila-present-left" type="checkbox" name="posterior_tribila_present_left" value="Left"/>&nbsp;&nbsp;Present-Left</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="posterior-tribila-present-right"><input class="checkbox-posterior-tribila-present-right" type="checkbox" name="posterior_tribila_present_right" value="Right" />&nbsp;&nbsp;Present-Right</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="posterior-tribila-absent-left"><input class="checkbox-posterior-tribila-absent-left" type="checkbox" name="posterior_tribila_absent_left" value="Left" />&nbsp;&nbsp;Absent-Left</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="posterior-tribila-absent-right"><input class="checkbox-posterior-tribila-absent-right" type="checkbox" name="posterior_tribila_absent_right" value="Right" />&nbsp;&nbsp;Absent-Right</label>
								</p>
							</div>
							
							
							<div class="col-lg-12">
								<br />
								<h3 style="text-align: center; margin-top: 0px;">Sensation</h3>
							</div>
							<div class="col-lg-6" style="margin-bottom:15px;">
								<p><strong>Monofilament</strong></p>
								<p>
									<label class="monofilament-present-left"><input class="checkbox-monofilament-present-left" type="checkbox" name="monofilament_present_left" value="Left"/>&nbsp;&nbsp;Present-Left</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="monofilament-present-right"><input class="checkbox-monofilament-present-right" type="checkbox" name="monofilament_present_right" value="Right" />&nbsp;&nbsp;Present-Right</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="monofilament-absent-left"><input class="checkbox-monofilament-absent-left" type="checkbox" name="monofilament_absent_left" value="Left" />&nbsp;&nbsp;Absent-Left</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="monofilament-absent-right"><input class="checkbox-monofilament-absent-right" type="checkbox" name="monofilament_absent_right" value="Right" />&nbsp;&nbsp;Absent-Right</label>
								</p>
							</div>
							<div class="col-lg-6" style="margin-bottom:15px;">
								<p><strong>Tuning Fork</strong></p>
								<p>
									<label class="tuning-fork-present-left"><input class="checkbox-tuning-fork-present-left" type="checkbox" name="tuning_fork_present_left" value="Left"/>&nbsp;&nbsp;Present-Left</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="tuning-fork-present-right"><input class="checkbox-tuning-fork-present-right" type="checkbox" name="tuning_fork_present_right" value="Right" />&nbsp;&nbsp;Present-Right</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="tuning-fork-absent-left"><input class="checkbox-tuning-fork-absent-left" type="checkbox" name="tuning_fork_absent_left" value="Left" />&nbsp;&nbsp;Absent-Left</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="tuning-fork-absent-right"><input class="checkbox-tuning-fork-absent-right" type="checkbox" name="tuning_fork_absent_right" value="Right" />&nbsp;&nbsp;Absent-Right</label>
								</p>
							</div>
							
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-lg-2" style="text-align:right">Others</label>
									<div class="col-lg-7">
										<textarea name="footexm_other_content" class="check-alphanumeric-charactars" cols="30" rows="3" style="width:100%"></textarea>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-lg-2" style="text-align:right">Name Of Doctor</label>
									<div class="col-lg-3">
										<input type="text" class="form-control src-doctor-name-by-center" name="footexm_doctor_name" data-section="hidden-foot-examination-doctor" placeholder="Type name of doctor" />
										<input type="hidden" id="hidden-foot-examination-doctor" name="footexm_doctor_id" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="dietaryHistory" class="panel panel-default block2">
				<div class="panel-heading text-center">DIETARY HISTORY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body" id = 'deactive-enter-dih'>
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name 
										<select id="prevDiatoryHistroyFieldName" class="custom-input-select"> 
											<option value="" selected="selected">Add Food Item</option>
											<?php
												$foods = $this->Visit_model->get_foods();
												foreach($foods as $food):
											?>
											<option value="<?php echo $food['food_title']; ?>"><?php echo $food['food_title']; ?></option>
											<?php endforeach; ?>
										</select>
									&nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="prev-diatory-history-field-add">ADD</span>
									</p>
								</div>
							</div>
							<div id="criteriaIncSix"></div>
						</div>
					</div>
				</div>
			</div>
			<div id="physicalActivity" class="panel panel-default block2">
				<div class="panel-heading text-center">PHISICAL ACTIVITY HISTORY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body" id = 'deactive-enter-pah'>
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align: center; margin-top: 0px;text-transform:capitalize">Physical Acitvity</h3>
							</div>
							<div class="col-lg-12 text-center">
								<label class="sel-physical-activity" data-value="1"><input type="radio" name="physical_acitvity" value="YES" checked>&nbsp;&nbsp; YES</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label class="sel-physical-activity" data-value="0"><input type="radio" name="physical_acitvity" value="NO">&nbsp;&nbsp; NO</label>
							</div>
						</div>
						<div class="row physical-activities-content">
							<div class="col-lg-12">
								<div class="addmr-frm" style="width:741px !important;">
									<p class="text-center">Type/Select Acitvity</p>
									<p>Activity 
										<select id="prevPhisicalActivityFieldName"> 
											<option value="" selected="selected">Type/Select Acitvity</option>
											<?php
												$activities = $this->Visit_model->get_physical_activities();
												foreach($activities as $activity):
											?>
											<option value="<?php echo $activity['activity_title']; ?>"><?php echo $activity['activity_title']; ?></option>
											<?php endforeach; ?>
										</select>
										Duration <input type="number" id="prevPhisicalActivityFieldUnit" placeholder="Monutes Per Day" />&nbsp;&nbsp;
										Duration <input type="number" id="prevPhisicalActivityFieldUnitPerWeek" placeholder="Day Per Week" />
									&nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="prev-phisical-activity-field-add">ADD</span>
									</p>
								</div>
							</div>
							<div id="criteriaIncEight"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="eyeExamination">
				<div class="panel-heading text-center">EYE EXAMINATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body" id = 'deactive-enter-ee'>
						<div class="row">
							<div class="col-lg-offset-6 col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Date</label>
									<div class="col-md-7">
										<input type="text" name="eyeexam_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" class="form-control text-center datepicker check-date-is-valid">
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-lg-2" style="text-align:right">Right Eye</label>
									<div class="col-lg-7">
										<textarea name="eyeexam_right_eye" class="check-alphanumeric-charactars" cols="30" rows="3" style="width:100%"></textarea>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-lg-2" style="text-align:right">Left Eye</label>
									<div class="col-lg-7">
										<textarea name="eyeexam_left_eye" class="check-alphanumeric-charactars" cols="30" rows="3" style="width:100%"></textarea>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-lg-2" style="text-align:right">Other</label>
									<div class="col-lg-7">
										<textarea name="eyeexam_other" class="check-alphanumeric-charactars" cols="30" rows="3" style="width:100%"></textarea>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-lg-2" style="text-align:right">Treatment</label>
									<div class="col-lg-7">
										<textarea name="eyeexam_treatment" class="check-alphanumeric-charactars" cols="30" rows="3" style="width:100%"></textarea>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-lg-2" style="text-align:right">Name Of Doctor</label>
									<div class="col-lg-3">
										<input type="text" class="form-control src-doctor-name" name="eyeexam_doctor_name" data-section="hidden-eye-examination-doctor" placeholder="Type name of doctor" />
										<input type="hidden" id="hidden-eye-examination-doctor" name="eyeexam_doctor_id" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="laboratoryInvestigation">
				<div class="panel-heading text-center">LABORATORY INVESTIGATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row" id = 'deactive-enter-lab'>
							<div id="criteriaIncTwo">
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">FBG</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="fbg" placeholder="mmol" />
										</div>
									</div>
									
									<input type="hidden" name="fbg_unit" value="mmol" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">S. Creatinine</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="sc" placeholder="mg/dl" />
										</div>
									</div>
									
									<input type="hidden" name="sc_unit" value="mg/dl" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">2hAG</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="2hag" placeholder="mmol" />
										</div>
									</div>
									
									<input type="hidden" name="2hag_unit" value="mmol" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">SGPT</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="sgpt" placeholder="units per liter" />
										</div>
									</div>
									
									<input type="hidden" name="sgpt_unit" value="units per liter" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">Post-meal BG</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="pmb" placeholder="mmol" />
										</div>
									</div>
									
									<input type="hidden" name="pmb_unit" value="mmol" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">Hb</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="hb" placeholder="%" />
										</div>
									</div>
									
									<input type="hidden" name="hb_unit" value="%" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">RBG</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="rbg" placeholder="" />
										</div>
									</div>
									
									<input type="hidden" name="rbg_unit" value="" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">TC</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel-for-tc" name="tc" placeholder="TC" />
										</div>
									</div>
									
									<input type="hidden" name="tc_unit" value="" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">HbA1c</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="hba1c" placeholder="%" />
										</div>
									</div>
									
									<input type="hidden" name="hba1c_unit" value="%" />
								</div>
								<div class="col-lg-6 ">
									<span class="inline-input-for-lab"><span class="label-txt"><strong>DC</strong> – N</span> <input type="text" name="dcn" class="check-with-double-decimel-limit-hundred inline-input-text-for-lab" /> %</span>
									<span class="inline-input-for-lab"><span class="label-txt">Z</span> <input type="text" name="dcz" class="check-with-double-decimel-limit-hundred inline-input-text-for-lab" /> %</span>
									<span class="inline-input-for-lab"><span class="label-txt">M</span> <input type="text" name="dcm" class="check-with-double-decimel-limit-hundred inline-input-text-for-lab" /> %</span>
									<span class="inline-input-for-lab"><span class="label-txt">E</span> <input type="text" name="dce" class="check-with-double-decimel-limit-hundred inline-input-text-for-lab" /> %</span>
									
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">T. Chol</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="t_chol" placeholder="mg/dl" />
										</div>
									</div>
									
									<input type="hidden" name="t_chol_unit" value="mg/dl" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">ESR</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel-max-300" name="esr" placeholder="" />
										</div>
									</div>
									
									
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">LDL-C</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="ldlc" placeholder="mg/dl" />
										</div>
									</div>
									
									<input type="hidden" name="ldlc_unit" value="mg/dl" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">Urine Albumin</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="ua" placeholder="" />
										</div>
									</div>
									
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">HDL-C</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="hdlc" placeholder="mg/dl" />
										</div>
									</div>
									
									<input type="hidden" name="hdlc_unit" value="mg/dl" />
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">Urine micro-Albumin</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="uma" placeholder="" />
										</div>
									</div>
									
									
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">TG</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="tg" placeholder="TG" />
										</div>
									</div>
									
									
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">Urine Acetone</label>
										<div class="col-md-7">
											<input type="text" class="form-control check-with-double-decimel" name="uac" placeholder="+" />
										</div>
									</div>
									
									<input type="hidden" name="uac_unit" value="+" />
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<div class="control-label col-md-5"><strong>ECG : </strong></div>
										<div class="col-md-7" style="padding-top: 7px;">
											<label class="lab-ecg-type-normal"><input class="checkbox-lab-ecg-type-normal" type="checkbox" name="ecg_type" value="1" />&nbsp;&nbsp; Normal</label> &nbsp; <label class="lab-ecg-type-abnormal"><input class="checkbox-lab-ecg-type-abnormal" type="checkbox" name="ecg_type" value="0" />&nbsp; Abnormal</label>
										</div>
										<div class="col-md-offset-5 col-md-7">
											<div class="abnoirmal-type-keywords" style="display:none">
												<label><input type="checkbox" name="abn_keywords[]" value="RBBB" />&nbsp; RBBB </label>&nbsp;&nbsp;&nbsp;&nbsp;
												<label><input type="checkbox" name="abn_keywords[]" value="LBBB" />&nbsp; LBBB </label>&nbsp;&nbsp;&nbsp;&nbsp;
												<label><input type="checkbox" name="abn_keywords[]" value="LVH" />&nbsp; LVH </label>&nbsp;&nbsp;&nbsp;&nbsp;
												<label><input type="checkbox" name="abn_keywords[]" value="MI" />&nbsp; MI</label>&nbsp;&nbsp;&nbsp;&nbsp;
												<label><input type="checkbox" name="abn_keywords[]" value="ISCHEMIA" />&nbsp; ISCHEMIA</label>&nbsp;&nbsp;&nbsp;&nbsp;
												<label><input type="checkbox" name="abn_keywords[]" value="Others" />&nbsp; Others</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<label class="control-label col-md-5">Blood Group</label>
										<div class="col-md-7">
											<select class="form-control" name="bg">
												<option selected="selected" value="">Please Select</option>
												<option value="Unknown">Unknown</option>
												<option value="A+">A+</option>
												<option value="A-">A-</option>
												<option value="B+">B+</option>
												<option value="B-">B-</option>
												<option value="O+">O+</option>
												<option value="O-">O-</option>
												<option value="AB+">AB+</option>
												<option value="AB-">AB-</option>
											</select>
										</div>
									</div>
									
								</div>
								<div class="col-lg-6 ">
									<div class="form-group">
										<div class="control-label col-md-5"><strong>USG : </strong></div>
										<div class="col-md-7" style="padding-top: 7px;">
											<label class="lab-usg-type-normal"><input class="checkbox-lab-usg-type-normal" type="checkbox" name="usg_type" value="1" />&nbsp;&nbsp; Normal</label> &nbsp; <label class="lab-usg-type-abnormal"><input class="checkbox-lab-usg-type-abnormal" type="checkbox" name="usg_type" value="0" />&nbsp; Abnormal</label>
										</div>
										<div class="col-md-offset-5 col-md-7">
											<div class="usg-abnormal-type-keywords" style="display:none">
												<label><input type="text" name="usg_abnormal_value" /></label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="addmr-frm">
									<p class="text-center">Others</p>
									<p>Name <input type="text" id="labInvestigationName" /> &nbsp;&nbsp; Unit <input type="text" id="labInvestigationUnit" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="lab-investigation">ADD</span></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="drugHistory" class="panel panel-default block2">
				<div class="panel-heading text-center">DRUG HISTORY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body" id ='block-enter-dh'>
						<div class="row">
							<div class="col-lg-offset-6 col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Date</label>
									<div class="col-md-7">
										<input type="text" name="drughistory_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" class="form-control text-center datepicker check-date-is-valid">
									</div>
								</div>
							</div>
						</div>
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>OADs : </strong> &nbsp;&nbsp;<label class="sel-sympt-9" data-value="1"><input type="radio" name="prev_is_oads" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-9" data-value="0"><input type="radio" name="prev_is_oads" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-9" style="display:none">
								<div id="prevOads">
									<div class="row-field drug-history-oads">
										<div class="col-lg-3"><input type="text" name="oads_name_1" placeholder="Add OADs" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="oads_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
												<span style="display: block;width: 100%;float: left;">খাওয়ার</span> 
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="oads_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="মাঝে">মাঝে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="oads_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="oads_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										<div class="col-lg-1" style = 'margin-top: 50px'><span class="prev-oads-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="oads_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-sm-12" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 20%;">
												<span style="display: block;width: 100%;float: left;">খাওয়ার</span> 
											</div>
											<input type="text" name="oads_condition_time_1" style="float: left;width: 20%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 20%;">
												<select name="oads_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="oads_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="মাঝে">মাঝে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-sm-10" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="oads_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="oads_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										<div class="col-lg-1" style = 'margin-top: 80px'><span class="prev-oads-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="oads_row[]" value="1" />
										<div style="clear:both"></div>
										
										<?php endif;?>
										
										
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Insulin : </strong> &nbsp;&nbsp;<label class="sel-sympt-10" data-value="1"><input type="radio" name="prev_is_insulin" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-10" data-value="0"><input type="radio" name="prev_is_insulin" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-10" style="display:none">
								<div id="prevInsulin">
									<div class="row-field drug-history-insulin">
										<div class="col-lg-3"><input type="text" name="prev_insulin_name_1" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>
										<div class="col-lg-2"><input type="text" name="prev_insulin_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="prev_insulin_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="prev_insulin_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="prev_insulin_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="prev_insulin_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="prev_insulin_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="prev-insulin-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="prev_insulin_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										
										<div class="col-lg-12" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="prev_insulin_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="prev_insulin_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="prev_insulin_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="prev_insulin_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="prev_insulin_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px'><span class="prev-insulin-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="prev_insulin_row[]" value="1" />
										<div style="clear:both"></div>
										
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-HTN : </strong> &nbsp;&nbsp;<label class="sel-sympt-4" data-value="1"><input type="radio" name="prev_is_anti_htn" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-4" data-value="0"><input type="radio" name="prev_is_anti_htn" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields" style="display:none">
								<div id="antiHtnFields">
									<div class="row-field drug-history-anti-htn">
										<div class="col-lg-3"><input type="text" name="anti_htn_name_1" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="anti_htn_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="anti_htn_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="anti_htn_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="anti_htn_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="anti_htn_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="anti_htn_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="htn-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="anti_htn_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="anti_htn_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="anti_htn_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="anti_htn_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="anti_htn_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="anti_htn_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px'><span class="htn-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="anti_htn_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-lipid : </strong> &nbsp;&nbsp;<label class="sel-sympt-5" data-value="1"><input type="radio" name="prev_is_anti_lipids" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-5" data-value="0"><input type="radio" name="prev_is_anti_lipids" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-2" style="display:none">
								<div id="antiLipidsFields">
									<div class="row-field drug-history-anti-lipid">
										<div class="col-lg-3"><input type="text" name="lipids_name_1" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="lipids_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="lipids_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="lipids_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="lipids_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="lipids_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="lipids_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="lipids-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="lipids_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="lipids_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="lipids_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="lipids_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="lipids_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="lipids_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"style = 'margin-top: 50px' ><span class="lipids-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="lipids_row[]" value="1" />
										<div style="clear:both"></div>
										
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-platelet : </strong> &nbsp;&nbsp;<label class="sel-sympt-6" data-value="1"><input type="radio" name="prev_is_aspirine" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-6" data-value="0"><input type="radio" name="prev_is_aspirine" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-3" style="display:none">
								<div id="aspirineFields">
									<div class="row-field drug-history-anti-platelet">
										<div class="col-lg-3"><input type="text" name="aspirine_name_1" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="aspirine_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="aspirine_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="aspirine_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="aspirine_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="aspirine_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="aspirine_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="aspirine-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="aspirine_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="aspirine_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="aspirine_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="aspirine_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="aspirine_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="aspirine_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px'><span class="aspirine-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="aspirine_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-obesity : </strong> &nbsp;&nbsp;<label class="sel-sympt-7" data-value="1"><input type="radio" name="prev_is_anti_obesity" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-7" data-value="0"><input type="radio" name="prev_is_anti_obesity" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-4" style="display:none">
								<div id="antiObesityFields">
									<div class="row-field drug-history-anti-obisity">
										<div class="col-lg-3"><input type="text" name="obesity_name_1" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="obesity_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="obesity_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="obesity_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="obesity_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="obesity_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="obesity_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="obesity-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="obesity_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="obesity_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="obesity_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="obesity_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="obesity_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="obesity_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px'><span class="obesity-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="obesity_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Others : </strong> &nbsp;&nbsp;<label class="sel-sympt-8" data-value="1"><input type="radio" name="prev_is_others" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-8" data-value="0"><input type="radio" name="prev_is_others" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-5" style="display:none">
								<div id="othersFields">
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="other_name_1" placeholder="Add Others" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="other_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="other_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="other_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="other_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="other_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="other_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="other-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="other_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="other_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="other_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="other_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="other_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="other_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"  style = 'margin-top: 50px'><span class="other-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="other_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row" style="margin-top:30px;">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Final Diagnosis</label>
									<div class="col-md-7">
										<?php 
											$final_diagnosis_array = array(
																		'Type 2 DM',
																		'Type 1 DM',
																		'IGT',
																		'IFG',
																		'GDM',
																		'Others',
																	);
										?>
										<select name="drughistory_fdiagnosis" class="form-control">
											<option value="">Please Select</option>
											<?php foreach($final_diagnosis_array as $key): ?>
											<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Other Associated Diseases</label>
									<div class="col-md-7">
										<textarea name="drughistory_other_associated_diseases" class="check-alphanumeric-charactars" cols="30" rows="3" placeholder="Please enter" style="width:100%"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="finalTreatment" class="panel panel-default block2">
				<div class="panel-heading text-center">FINAL TREATMENT</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body" id = 'block-enter-ft'>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Name Of Doctor</label>
									<div class="col-md-7">
									<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<input type="text" class="form-control src-doctor-name-final-treatment" name="finaltreat_doctor_name" data-section="hidden-final-treatment-doctor" placeholder="Type name of doctor" />
										<?php else:?>
										<input type="text" value = "<?php echo $this->session->userdata('full_name');?>"  class="form-control" name="finaltreat_doctor_name"  placeholder="Type name of doctor" readonly />
										<?php endif;?>
										<input type="hidden" id="hidden-final-treatment-doctor" name="finaltreat_doctor_id" />
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Date</label>
									<div class="col-md-7">
										<input type="text" name="finaltreat_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" class="form-control text-center datepicker check-date-is-valid">
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row" style="margin-top:30px;">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Dietary Advice</label>
									<div class="col-md-7">
										<textarea name="finaltreat_dietary_advice" class="check-alphanumeric-charactars" cols="30" rows="3" placeholder="Please enter" style="width:100%"></textarea>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Physical Acitvity</label>
									<div class="col-md-7">
										<textarea name="finaltreat_physical_acitvity" class="check-alphanumeric-charactars" cols="30" rows="3" placeholder="Please enter" style="width:100%"></textarea>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Diet No</label>
									<div class="col-md-7">
										<input type="text" name="finaltreat_diet_no" class="form-control check-with-single-number" />
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Page No</label>
									<div class="col-md-7">
										<input type="text" name="finaltreat_page_no" class="form-control check-with-single-number" />
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>OADs : </strong> &nbsp;&nbsp;<label class="sel-sympt-9-cntr" data-value="1"><input type="radio" name="crnt_is_oads" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-9-cntr" data-value="0"><input type="radio" name="crnt_is_oads" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-9-cntr" style="display:none">
								<div id="crntOads">
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_oads_name_1" placeholder="Add OADs" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="crnt_oads_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
												<span style="display: block;width: 100%;float: left;">খাওয়ার</span> 
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_oads_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="মাঝে">মাঝে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_oads_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_oads_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										<div class="col-lg-1"><span class="cntr-oads-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_oads_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 20%;">
												<span style="display: block;width: 100%;float: left;">খাওয়ার</span> 
											</div>
											<input type="text" name="crnt_oads_condition_time_1" style="float: left;width: 20%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_oads_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_oads_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="মাঝে">মাঝে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_oads_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_oads_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										<div class="col-lg-1" style = 'margin-top: 50px' ><span class="cntr-oads-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_oads_row[]" value="1" />
										<div style="clear:both"></div>
										
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Insulin : </strong> &nbsp;&nbsp;<label class="sel-sympt-10-cntr" data-value="1"><input type="radio" name="crnt_is_insulin" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-10-cntr" data-value="0"><input type="radio" name="crnt_is_insulin" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-10-cntr" style="display:none">
								<div id="crntInsulin">
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_insulin_name_1" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>
										<div class="col-lg-2"><input type="text" name="crnt_insulin_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_insulin_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_insulin_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_insulin_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_insulin_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_insulin_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="cntr-insulin-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_insulin_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_insulin_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_insulin_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_insulin_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_insulin_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_insulin_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px'><span class="cntr-insulin-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_insulin_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-HTN : </strong> &nbsp;&nbsp;<label class="sel-sympt-4-cntr" data-value="1"><input type="radio" name="crnt_is_anti_htn" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-4-cntr" data-value="0"><input type="radio" name="crnt_is_anti_htn" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-cntr" style="display:none">
								<div id="antiHtnFieldsCntr">
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_anti_htn_name_1" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="crnt_anti_htn_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_anti_htn_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_anti_htn_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_anti_htn_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_anti_htn_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_anti_htn_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="cntr-htn-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_anti_htn_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_anti_htn_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_anti_htn_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_anti_htn_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_anti_htn_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_anti_htn_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"  style = 'margin-top: 50px'><span class="cntr-htn-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_anti_htn_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-lipid : </strong> &nbsp;&nbsp;<label class="sel-sympt-5-cntr" data-value="1"><input type="radio" name="crnt_is_anti_lipids" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-5-cntr" data-value="0"><input type="radio" name="crnt_is_anti_lipids" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-2-cntr" style="display:none">
								<div id="antiLipidsFieldsCntr">
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_lipids_name_1" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="crnt_lipids_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_lipids_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_lipids_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_lipids_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_lipids_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_lipids_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="cntr-lipids-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_lipids_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_lipids_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_lipids_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_lipids_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_lipids_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_lipids_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px'><span class="cntr-lipids-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_lipids_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-platelet : </strong> &nbsp;&nbsp;<label class="sel-sympt-6-cntr" data-value="1"><input type="radio" name="crnt_is_aspirine" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-6-cntr" data-value="0"><input type="radio" name="crnt_is_aspirine" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-3-cntr" style="display:none">
								<div id="aspirineFieldsCntr">
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_aspirine_name_1" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="crnt_aspirine_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_aspirine_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_aspirine_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_aspirine_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_aspirine_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_aspirine_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="cntr-aspirine-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_aspirine_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_aspirine_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_aspirine_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_aspirine_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_aspirine_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_aspirine_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px' ><span class="cntr-aspirine-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_aspirine_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-obesity : </strong> &nbsp;&nbsp;<label class="sel-sympt-7-cntr" data-value="1"><input type="radio" name="crnt_is_anti_obesity" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-7-cntr" data-value="0"><input type="radio" name="crnt_is_anti_obesity" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-4-cntr" style="display:none">
								<div id="antiObesityFieldsCntr">
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_obesity_name_1" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="crnt_obesity_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_obesity_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_obesity_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_obesity_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_obesity_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_obesity_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="cntr-obesity-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_obesity_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_obesity_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_obesity_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_obesity_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_obesity_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_obesity_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px' ><span class="cntr-obesity-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_obesity_row[]" value="1" />
										<div style="clear:both"></div>
										
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Others : </strong> &nbsp;&nbsp;<label class="sel-sympt-8-cntr" data-value="1"><input type="radio" name="crnt_is_others" value="1" />&nbsp; Yes</label> &nbsp;&nbsp; <label class="sel-sympt-8-cntr" data-value="0"><input type="radio" name="crnt_is_others" value="0" checked />&nbsp; No</label>
							</div>
							<div class="input-row-fields-5-cntr" style="display:none">
								<div id="othersFieldsCntr">
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_other_name_1" placeholder="Add Others" class="form-control load-drugs" /></div>
										<div class="col-lg-2"><input type="text" name="crnt_other_value_1" placeholder="Dose" class="form-control" /></div>
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
										<div class="col-lg-3" style="padding-top: 15px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_other_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_other_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_other_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2" style="padding-top: 15px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_other_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_other_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1"><span class="cntr-other-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_other_row[]" value="1" />
										<div style="clear:both"></div>
										<?php else:?>
										<div class="col-lg-12" style="padding-top: 30px;">
											<div class="inline-sc" style="width: 35%;">
											<span style="display: block;width: 50%;float: left;">খাওয়ার</span> 
											<input type="text" name="crnt_other_condition_time_1" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_other_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 20%;">
												<select name="crnt_other_condition_apply_1" class="form-control" style="text-align: center;margin-top: -14px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-lg-10" style="padding-top: 30px;">
											<span style="display: block;width: 30%;float: left;">চলবে</span>
											<input type="text" name="crnt_other_duration_1" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_other_duration_type_1" class="form-control" style="text-align: center;margin-top: -15px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-1" style = 'margin-top: 50px' ><span class="cntr-other-add-more-htn-doc add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i>More</span></div>
										<input type="hidden" name="crnt_other_row[]" value="1" />
										<div style="clear:both"></div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row" style="margin-top:30px;">
							<div class="col-lg-5">
								<div class="form-group">
									<label class="control-label col-md-5">Next Visit Date</label>
									<div class="col-md-5">
										<input type="text" name="finaltreat_next_visit_date" placeholder="DD/MM/YYYY" class="form-control datepicker">
									</div>
								</div>
							</div>
							<div class="col-lg-7">
								<div class="form-group">
									<label class="control-label col-md-3">Next Investigation</label>
									<div class="col-md-9">
										<div class="col-md-9">
										<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
											<textarea id="first" name="finaltreat_next_investigation" class="" cols="30" rows="3" placeholder="Investigation name" style="width:100%" readonly></textarea> 
											<?php else:?>
											<textarea id="first" name="finaltreat_next_investigation" class="" cols="30" rows="3" placeholder="Investigation name" style="width:100%" ></textarea> 
											<?php endif;?>
										</div>
										<div class="col-md-3">
											<button type="button" id= "refresh" class="btn btn-danger">Delete</button>
										</div>
										<div class="col-md-9">
											<textarea id="second" name="" class=" src-investigation" cols="30" rows="1" placeholder="Search investigation here" style="width:100%"></textarea>
										
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $payment_config = $this->Visit_model->get_config(); ?>
		</div>
		
		<div class="col-lg-2" style="padding:0">
			<div class="sticky-sidebar" style="width:225px;">
				<ul id="stickyNavSection">
					<li class="active"><a href="#visitDetails">Visit Details</a></li>
					<li><a href="#personalHabits">Personal Habits</a></li>
					<li><a href="#familyHistory">Family History</a></li>
					<li><a href="#diabetesHistory">Diabetes History</a></li>
					<li><a href="#generalExamination">General Examination</a></li>
					
					<li><a href="#footExamination">Foot Examination</a></li>
					<li><a href="#dietaryHistory">Dietary History</a></li>
					<li><a href="#physicalActivity">Physical Acitvity History</a></li>
					<li><a href="#eyeExamination">Eye Examination</a></li>
					
					<li><a href="#laboratoryInvestigation">Laboratory Investigation</a></li>
					<li><a href="#drugHistory">Drug History</a></li>
					<li><a href="#finalTreatment">Final Treatment</a></li>
				</ul>
				
				<ul class="submit-ul">
					<input type="hidden" id="chkRdr" name="submitType" />
					<li><span class="check-save" data-save-method="save" data-toggle="modal" data-target=".bs-example-modal-sm">Save & Preview</span></li>
					<li><span class="check-save" data-save-method="saveexit" data-toggle="modal" data-target=".bs-example-modal-sm">Save & Exit</span></li>
					<li><span class="check-save" onclick="window.location.href='<?php echo base_url('patients/visit/all/'.$patient_id.'/'.$patient_entry_id); ?>'">Cancel</span></li>
				</ul>
			</div>
		</div>
		
		<!-- sample modal content -->
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="mySmallModalLabel" style="font-size: 15px;">Electronic Follow Up Fee (BDT <?php echo ($payment_config['config_option_two'])? $payment_config['config_option_two'] : 0; ?>)</h4> 
					</div>
					<div class="modal-body text-center">
						<p>
							<input type="hidden" name="fee_amount" value="<?php echo ($payment_config['config_option_two'])? $payment_config['config_option_two'] : 0; ?>" />
							<label><input type="radio" value="1" name="payment" checked />&nbsp;&nbsp;Paid</label> &nbsp;&nbsp;
							<label><input type="radio" value="0" name="payment" />&nbsp;&nbsp;Unpaid</label> &nbsp;&nbsp;
						</p>
					</div>
					<div class="modal-footer">
						<span class="btn btn-default waves-effect" data-dismiss="modal">Cancel</span>
						<button type="submit" class="btn btn-info confirm-payment submit-type" data-save-method="">Confirm</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal -->
		<?php echo form_close(); ?>
	</div>
	</div>
	

	
	
	
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myLargeModalLabel">Medication</h4> </div>
				<div class="modal-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">SL.</th>
								<th class="text-center">Drug</th>
								<th class="text-center">Dosage</th>
								<th class="text-center">Company</th>
								<th class="text-center">Generic</th>
							</tr>
						</thead>
						<tbody id="prevMedicTable">
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	
	<div class="modal fade bs-example-modal-lg-crnt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myLargeModalLabel">Medication</h4> </div>
				<div class="modal-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">SL.</th>
								<th class="text-center">Drug</th>
								<th class="text-center">Dosage</th>
								<th class="text-center">Company</th>
								<th class="text-center">Generic</th>
							</tr>
						</thead>
						<tbody id="crntMedicTable"></tbody>
					</table>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	
	
	<?php 
		$insulins = $this->Visit_model->get_insuline();
		$option_drugs = '<option value="" selected="selected">Type/Select Drug</option>';
		foreach($insulins as $insuline):
		$option_drugs .= '<option value="'.$insuline['insuline_id'].'">'.$insuline['insuline_brand'].'</option>';
		endforeach;
	?>
	<script type="text/javascript">
	<?php if($case_history === 'yes'):?>
				
				//window.location.href=baseUrl+'patients/progress/add/<?php echo $patient_id; ?>/<?php echo $patient_entry_id; ?>';
			<?php endif;?>
	</script>
	
	<script type="text/javascript">
	/*$(function(){
		$("#qr-gn").click(function(){
				$('#preview').show();
				var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
				scanner.addListener('scan',function(content){
					$('.searchBar').val(content);
					$('#preview').hide();
					$('.bs-example-modal-sm').modal('toggle');
					scanner.stop();
					//alert(content);
					//window.location.href=content;
				});
				Instascan.Camera.getCameras().then(function (cameras){
				if(cameras.length>0){
					//scanner.start(cameras[1]);
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
 
	});*/
	
	function onQRCodeScanned(scannedText)
    {
    	var scannedTextMemo = document.getElementById("searchBar");
    	if(scannedTextMemo)
    	{
    	    //var scannerParentElement = document.getElementById("myModal");
    		//scannedTextMemo.value = scannedText;
			$('.searchBar').val(scannedText);
    		$('.scan').modal('hide');
    	}
    	
    }
	
	 //this function will be called when JsQRScanner is ready to use
    function myFunction()
    {
        //create a new scanner passing to it a callback function that will be invoked when
        //the scanner succesfully scan a QR code
        var jbScanner = new JsQRScanner(onQRCodeScanned);
        //var jbScanner = new JsQRScanner(onQRCodeScanned, provideVideo);
        //reduce the size of analyzed image to increase performance on mobile devices
        jbScanner.setSnapImageMaxSize(600);
    	var scannerParentElement = document.getElementById("scanner");
    	if(scannerParentElement)
    	{
    	    //append the jbScanner to an existing DOM element
    		jbScanner.appendTo(scannerParentElement);
    	}        
    }
</script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#upload_image').on('submit', function(e){  
           e.preventDefault();  
		   var pid = <?php echo $patient_id; ?>;
           if($('#image_file1').val() == '')  
           {  
                alert("Please Select a File for Picture 1");  
           }  
           else  
           {  
				$('#visitLoader').show();
                $.ajax({  
                     url: baseUrl + "patients/visit/image/" + pid,   
                     method:"POST",  
                     data:new FormData(this),  
                     contentType: false,  
                     cache: false,  
                     processData:false,  
                     success:function(data)  
                     {  
                          $('#uploaded_image').append(data);  
						  //alert(data); 
						  $('#visitLoader').hide();
                     }  
                });  
           }  
      }); 
		
		});
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
			
			//get districts
			$(document).on('change', '#selectedDivision', function(){
				var division_id = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "register/get_districts",
					data : {division_id:division_id},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#selectedDistrict').html(data.content);
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
			
			//get upazilas
			$(document).on('change', '#selectedDistrict', function(){
				var district_id = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "register/get_upazilas",
					data : {district_id:district_id},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#selectedUpazila').html(data.content);
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.sel-sympt', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.sel-hidden-dropdown').show();
				}else if(check_val == '0')
				{
					$('.sel-hidden-dropdown').hide();
				}else
				{
					$('.sel-hidden-dropdown').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-2', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.sel-hidden-dropdown-2').show();
				}else if(check_val == '0')
				{
					$('.sel-hidden-dropdown-2').show();
				}else
				{
					$('.sel-hidden-dropdown-2').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-4', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-5', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-2').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-2').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-6', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-3').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-3').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-7', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-4').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-4').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-8', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-5').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-5').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-9', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-9').hide();
				}
			});
			$(document).on('click', '.sel-sympt-10', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-10').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-10').hide();
				}
			});
			$(document).on('click', '.sel-sympt-11', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-11').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-11').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-4-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-5-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-2-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-2-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-6-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-3-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-3-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-7-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-4-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-4-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-8-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-5-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-5-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-9-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-9-cntr').hide();
				}
			});
			$(document).on('click', '.sel-sympt-10-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-10-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-10-cntr').hide();
				}
			});
			
			$(document).on('click', '.pres-controler', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('#createForm').hide();
					$('.saveContainer').hide();
					$('#imageControlerdoc').show();
				}else if(check_val == '0')
				{
					$('#createForm').show();
					$('.saveContainer').show();
					$('#imageControlerdoc').hide();
				}
			});
			$(document).on('click', '.sel-sympt-11-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-11-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-11-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-3', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.abnoirmal-type-keywords').hide();
					$('.abnoirmal-type-keywords').find('input:checkbox').prop("checked", false);
				}else if(check_val == '0')
				{
					$('.abnoirmal-type-keywords').show();
				}else
				{
					$('.abnoirmal-type-keywords').hide();
				}
			});
			
			$(document).on('click', '.sel-physical-activity', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '0')
				{
					$('.physical-activities-content').hide();
					$('#criteriaIncEight').html('');
				}else if(check_val == '1')
				{
					$('.physical-activities-content').show();
				}else
				{
					$('.physical-activities-content').hide();
				}
			});
			
			$(document).on('change', '.sel-gexam-height', function(){
				var getValue = $(this).val();
				if(getValue == 'ft/inch')
				{
					var content = '<div class="col-md-5" style="padding: 0;">'+
										'<select name="gexam_height_unit" class="form-control sel-gexam-height">'+
											'<option value="">Select Unit</option>'+
											'<option value="ft/inch" selected="selected">ft/inch</option>'+
											'<option value="Inch">Inch</option>'+
											'<option value="cm">cm</option>'+
										'</select>'+
									'</div>'+
									'<div class="col-md-3" style="padding: 0 7px;">'+
										'<input type="text" class="form-control check-with-decimel" name="gexam_height_value_ft" placeholder="ft" />'+
									'</div>'+
									'<div class="col-md-4" style="padding: 0;">'+
										'<input type="text" class="form-control check-with-decimel" name="gexam_height_value_inch" placeholder="inch" />'+
									'</div>';
					$('.general-examination-height').html(content);
				}else if(getValue == 'cm'){
					var content = '<div class="row">'+
										'<div class="col-md-7">'+
											'<select name="gexam_height_unit" class="form-control sel-gexam-height">'+
												'<option value="">Select Unit</option>'+
												'<option value="ft/inch">ft/inch</option>'+
												'<option value="Inch">Inch</option>'+
												'<option value="cm" selected="selected">cm</option>'+
											'</select>'+
										'</div>'+
										'<div class="col-md-5">'+
											'<input type="text" class="form-control check-with-decimel" name="gexam_height_value" placeholder="Height" />'+
										'</div>'+
									'</div>';
					$('.general-examination-height').html(content);
				}else if(getValue == 'Inch'){
					var content = '<div class="row">'+
										'<div class="col-md-7">'+
											'<select name="gexam_height_unit" class="form-control sel-gexam-height">'+
												'<option value="">Select Unit</option>'+
												'<option value="ft/inch">ft/inch</option>'+
												'<option value="Inch" selected="selected">Inch</option>'+
												'<option value="cm">cm</option>'+
											'</select>'+
										'</div>'+
										'<div class="col-md-5">'+
											'<input type="text" class="form-control check-with-decimel" name="gexam_height_value" placeholder="Height" />'+
										'</div>'+
									'</div>';
					$('.general-examination-height').html(content);
				}else{
					var content = '<div class="row">'+
										'<div class="col-md-7">'+
											'<select name="gexam_height_unit" class="form-control sel-gexam-height">'+
												'<option value="">Select Unit</option>'+
												'<option value="ft/inch">ft/inch</option>'+
												'<option value="Inch">Inch</option>'+
												'<option value="cm">cm</option>'+
											'</select>'+
										'</div>'+
										'<div class="col-md-5">'+
											'<input type="text" class="form-control check-with-decimel" name="gexam_height_value" placeholder="Height" />'+
										'</div>'+
									'</div>';
					$('.general-examination-height').html(content);
				}
			});
			
			$(document).on('click', '.sel-sympt-payment', function(){
				$('.payment-type-keywords').show();
			});
			
			$(document).on('click', '.sel-sympt-management', function(){
				$('#mangmntLifeStyle').change(function(){
					if(this.checked)
						$('.management-type-keywords').show();
					else
						$('.management-type-keywords').hide();

				});
			});
			
			$(document).on('click', '.phabit-check', function(){
				var check_val = $(this).attr('data-row');
				var main_row = $(this).attr('data-main-row');
				if(check_val == '1')
				{
					$('.phabit-amount-'+main_row).show();
				}else if(check_val == '2')
				{
					$('.phabit-amount-'+main_row).show();
				}else if(check_val == '3')
				{
					$('.phabit-amount-'+main_row).hide();
				}
			});
			
			$(document).on('click', '.prev-cooking-oil-check', function(){
				var check_val = $(this).attr('data-row');
				var main_row = $(this).attr('data-main-row');
				if(check_val == '1')
				{
					$('.prev-cooking-oil-amount-'+main_row).show();
				}else if(check_val == '2')
				{
					$('.prev-cooking-oil-amount-'+main_row).hide();
				}
			});
			
			$(document).on('click', '.crnt-cooking-oil-check', function(){
				var check_val = $(this).attr('data-row');
				var main_row = $(this).attr('data-main-row');
				if(check_val == '1')
				{
					$('.crnt-cooking-oil-amount-'+main_row).show();
				}else if(check_val == '2')
				{
					$('.crnt-cooking-oil-amount-'+main_row).hide();
				}
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 7;
			$(document).on('click', '.gexam-field-add-1', function(){
				var inp_name = $('#gexamFieldNameOne').val();
				var inp_value = $('#gexamFieldUnitOne').val();
				
				if(inp_name !== '' && inp_value !== '')
				{
					var content = '<div class="col-lg-4 general-examination put-relative">' +
									'<div class="form-group">' +
										'<label class="control-label col-md-5">'+inp_name+'</label>' +
										'<div class="col-md-3">' +
											'<input type="text" class="form-control" name="gexam_row_value_'+row+'" placeholder="'+inp_value+'" />' +
										'</div>' +
										'<div class="col-md-4">' +
											'<select name="gexam_row_unit_'+row+'" class="form-control">' +
												'<option value="cm">cm</option>' +
												'<option value="kg">kg</option>' +
												'<option value="mmHg">mmHg</option>' +
											'</select>' +
										'</div>' +
									'</div>' +
									'<input type="hidden" name="gexam_row[]" value="'+row+'" />' +
									'<input type="hidden" name="gexam_row_name_'+row+'" value="'+inp_name+'" />' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
								'</div>';
					$('#criteriaIncOne').append(content);
					$('#gexamFieldNameOne').val('');
					$('#gexamFieldUnitOne').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
			$(document).on('click', '.rmv-itm', function(){
				$(this).parent().remove();
			});
			$(document).on('click', '.rmv-itm-diatory-history', function(){
				$(this).parent().parent().remove();
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.lab-investigation', function(){
				var row = $('.lab-inv-item').length+1;
				var inp_name = $('#labInvestigationName').val();
				var inp_value = $('#labInvestigationUnit').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-6 laboratory-investigation lab-inv-item put-relative">' +
									'<div class="form-group">' +
										'<label class="control-label col-md-5">'+inp_name+'</label>' +
										'<div class="col-md-7">' +
											'<input type="text" class="form-control" name="labinv_row_value_'+row+'" placeholder="'+inp_value+'" />' +
										'</div>' +
									'</div>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<input type="hidden" name="labinv_row[]" value="'+row+'" />' +
									'<input type="hidden" name="labinv_row_name_'+row+'" value="'+inp_name+'" />' +
									'<input type="hidden" name="labinv_row_unit_'+row+'" value="'+inp_value+'" />' +
								'</div>';
					$('#criteriaIncTwo').append(content);
					$('#labInvestigationName').val('');
					$('#labInvestigationUnit').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.complication-add', function(){
				var row = $('.complication-comorbidity-rows').length + 1;
				var inp_name = $('#complicationName').val();
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-3 complication-comorbidity-rows put-relative">' +
										'<label><input type="checkbox" name="complication_'+row+'" value="'+inp_name+'">&nbsp;&nbsp;'+inp_name+'</label>' +
										'<input type="hidden" value="'+row+'" name="complication_row[]">' +
										'<span class="rmv-itm mdi mdi-delete"></span>' +
									'</div>';	
					$('#criteriaIncThree').append(content);
					$('#complicationName').val('');
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = $('.complication-comorbidity').length + 1;
			$(document).on('click', '.acute-complication-add', function(){
				var inp_name = $('#acuteComplicationName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4 complication-comorbidity put-relative">' +
										'<label><input type="checkbox" name="acute_complication_'+row+'" value="'+inp_name+'">&nbsp;&nbsp;'+inp_name+'</label>' +
										'<input type="hidden" value="'+row+'" name="acute_complication_row[]">' +
										'<span class="rmv-itm mdi mdi-delete"></span>' +
									'</div>';	
					$('#acuteCriteriaIncThree').append(content);
					$('#acuteComplicationName').val('');
					row++;
				}else
				{
					return false;
				}
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = $('.phabit-check').length + 1;
			$(document).on('click', '.phabit-add', function(){
				var inp_name = $('#phabitFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-md-15 col-sm-3 text-center put-relative" style="margin-bottom:15px;">'+
										'<label class="phabit-check"><input type="checkbox" name="phabit_row_name_'+row+'" value="'+inp_name+'"/>&nbsp;&nbsp;'+inp_name+'</label> &nbsp;&nbsp;'+
										'<input type="hidden" name="phabit_row[]" value="'+row+'" />'+
										'<span class="rmv-itm mdi mdi-delete"></span>' +
									'</div>';	
					$('#criteriaIncFour').append(content);
					$('#phabitFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 5;
			$(document).on('click', '.family-details-add', function(){
				var inp_name = $('#fmdetailsFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4" style="height:100px;margin-bottom:15px;">' +
									'<p><strong>'+inp_name+':</strong></p>' +
									'<p>' +
										'<label><input type="radio" name="fmdetails_'+row+'" value="Yes"/>&nbsp;&nbsp;Yes</label> &nbsp;&nbsp;' +
										'<label><input type="radio" name="fmdetails_'+row+'" value="No" />&nbsp;&nbsp;No</label> &nbsp;&nbsp;' +
										'<label><input type="radio" name="fmdetails_'+row+'" value="Not Known" />&nbsp;&nbsp;Not Known</label>' +
									'</p>' +
									'<input type="hidden" name="fmdetails_row[]" value="'+row+'" />' +
									'<input type="hidden" name="fmdetails_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#criteriaIncFive').append(content);
					$('#fmdetailsFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('keyup', '.prev-diatory-history-daily', function(){
				var inputValue = parseInt($(this).val()) || 0;
				if(inputValue > 10)
				{
					alert("Maximum value 10 is allowed!");
					$(this).val('');
					return false;
				}
			});
			$(document).on('keyup', '.prev-diatory-history-weekly', function(){
				var inputValue = parseInt($(this).val()) || 0;
				if(inputValue > 7)
				{
					alert("Maximum value 7 is allowed!");
					$(this).val('');
					return false;
				}
			});
			
			$(document).on('click', '.prev-diatory-history-field-add', function(){
				var inp_name = $("select#prevDiatoryHistroyFieldName option").filter(":selected").val();
				if(inp_name !== '')
				{
					var row = $('.dietary-hstr').length + 1;
					var content = '<div class="dietary-hstr">' +
									'<label class="control-label col-md-offset-2 col-md-2"><strong>'+row+'.</strong> '+inp_name+'</label>' +
									'<div class="col-md-2">' +
										'<input type="text" class="form-control prev-diatory-history-daily" data-imp-val-row="'+row+'" name="prev_diatory_history_daily_'+row+'" placeholder="Per Day" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control prev-diatory-history-weekly prev-diatory-history-weekly-'+row+'" data-imp-val-row="'+row+'" name="prev_diatory_history_weekly_'+row+'" placeholder="Per Week" />' +
									'</div>' +
									'<div class="col-lg-2 put-relative">'+
										'<span class="rmv-itm-diatory-history mdi mdi-delete" style="right:auto !important;left:-5px !important;top:5px !important"></span>' +
									'</div>'+
									'<div style="clear:both"></div>' +
									'<input type="hidden" name="prev_diatory_history_row[]" value="'+row+'" />' +
									'<input type="hidden" name="prev_diatory_history_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#criteriaIncSix').append(content);
					$(".prev-diatory-history-daily").keydown(function (e) {
						// Allow: backspace, delete, tab, escape, enter and .
						if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
							 // Allow: Ctrl+A, Command+A
							(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
							 // Allow: home, end, left, right, down, up
							(e.keyCode >= 35 && e.keyCode <= 40)) {
								 // let it happen, don't do anything
								 return;
						}
						// Ensure that it is a number and stop the keypress
						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
							e.preventDefault();
						}
					});
					$(".prev-diatory-history-weekly").keydown(function (e) {
						// Allow: backspace, delete, tab, escape, enter and .
						if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
							 // Allow: Ctrl+A, Command+A
							(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
							 // Allow: home, end, left, right, down, up
							(e.keyCode >= 35 && e.keyCode <= 40)) {
								 // let it happen, don't do anything
								 return;
						}
						// Ensure that it is a number and stop the keypress
						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
							e.preventDefault();
						}
					});
					$('#prevDiatoryHistroyFieldName').val('');
				}else
				{
					return false;
				}
			});
			
			$(document).on('keyup', '.prev-diatory-history-daily', function(){
				var row_value = $(this).attr('data-imp-val-row');
				var daily_value = parseInt($(this).val());
				var weekly_value = parseInt(daily_value * 7);
				var monthly_value = weekly_value * 4;
				if(daily_value)
				{
					$('.prev-diatory-history-weekly-'+row_value).val(weekly_value);
					$('.prev-diatory-history-monthly-'+row_value).val(monthly_value);
				}else
				{
					$('.prev-diatory-history-weekly-'+row_value).val('');
					$('.prev-diatory-history-monthly-'+row_value).val('');
				}
			});
			
			$(document).on('keyup', '.prev-diatory-history-weekly', function(){
				var row_value = $(this).attr('data-imp-val-row');
				var weekly_value = parseInt($(this).val());
				var monthly_value = weekly_value * 4;
				if(weekly_value)
				{
					$('.prev-diatory-history-monthly-'+row_value).val(monthly_value);
				}else
				{
					$('.prev-diatory-history-monthly-'+row_value).val('');
				}
			});
			
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('click', '.crnt-diatory-history-field-add', function(){
				var inp_name = $("select#crntDiatoryHistroyFieldName option").filter(":selected").val();
				if(inp_name !== '')
				{
					var content = '<div class="dietary-hstr put-relative">' +
									'<label class="control-label col-md-2"><strong>'+row+'.</strong> '+inp_name+'</label>' +
									'<div class="col-md-2">' +
										'<input type="text" class="form-control crnt-diatory-history-daily" data-imp-val-row="'+row+'" name="crnt_diatory_history_daily_'+row+'" placeholder="Daily" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control crnt-diatory-history-weekly crnt-diatory-history-weekly-'+row+'" data-imp-val-row='+row+' name="crnt_diatory_history_weekly_'+row+'" placeholder="Weekly" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control crnt-diatory-history-monthly-'+row+'" name="crnt_diatory_history_monthly_'+row+'" placeholder="Monthly" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control" name="crnt_diatory_history_calorie_'+row+'" placeholder="Calorie" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control" name="crnt_diatory_history_diet_'+row+'" placeholder="Diet Chart" />' +
									'</div>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<input type="hidden" name="crnt_diatory_history_row[]" value="'+row+'" />' +
									'<input type="hidden" name="crnt_diatory_history_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#crntCriteriaIncOne').append(content);
					$('#crntDiatoryHistroyFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
			
			$(document).on('keyup', '.crnt-diatory-history-daily', function(){
				var row_value = $(this).attr('data-imp-val-row');
				var daily_value = parseInt($(this).val());
				var weekly_value = parseInt(daily_value * 7);
				var monthly_value = weekly_value * 4;
				if(daily_value)
				{
					$('.crnt-diatory-history-weekly-'+row_value).val(weekly_value);
					$('.crnt-diatory-history-monthly-'+row_value).val(monthly_value);
				}else
				{
					$('.crnt-diatory-history-weekly-'+row_value).val('');
					$('.crnt-diatory-history-monthly-'+row_value).val('');
				}
			});
			
			$(document).on('keyup', '.crnt-diatory-history-weekly', function(){
				var row_value = $(this).attr('data-imp-val-row');
				var weekly_value = parseInt($(this).val());
				var monthly_value = weekly_value * 4;
				if(weekly_value)
				{
					$('.crnt-diatory-history-monthly-'+row_value).val(monthly_value);
				}else
				{
					$('.crnt-diatory-history-monthly-'+row_value).val('');
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 8;
			$(document).on('click', '.prev-cooking-oil-add', function(){
				var inp_name = $('#prevCookingOilFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4 put-relative" style="height:100px;margin-bottom:15px;">' +
									'<p><strong>'+inp_name+':</strong></p>' +
									'<p>' +
										'<label class="prev-cooking-oil-check" data-row="1" data-main-row="'+row+'"><input type="radio" name="prev_cookoil_'+row+'" value="Yes"/>&nbsp;&nbsp;Yes</label> &nbsp;&nbsp;' +
										'<label class="prev-cooking-oil-check" data-row="2" data-main-row="'+row+'"><input type="radio" name="prev_cookoil_'+row+'" value="No" />&nbsp;&nbsp;No</label> &nbsp;&nbsp;' +
									'</p>' +
									'<p class="prev-cooking-oil-amount-'+row+'" style="display:none"><input type="text" name="prev_cookoil_amount_'+row+'" placeholder="Leters/Month" class="form-control" /></p>' +
									'<input type="hidden" name="prev_cookoil_row[]" value="'+row+'" />' +
									'<input type="hidden" name="prev_cookoil_row_name_'+row+'" value="'+inp_name+'" />' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
								'</div>';	
					$('#criteriaIncSeven').append(content);
					$('#prevCookingOilFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 8;
			$(document).on('click', '.crnt-cooking-oil-add', function(){
				var inp_name = $('#crntCookingOilFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4 put-relative" style="height:100px;margin-bottom:15px;">' +
									'<p><strong>'+inp_name+':</strong></p>' +
									'<p>' +
										'<label class="crnt-cooking-oil-check" data-row="1" data-main-row="'+row+'"><input type="radio" name="crnt_cookoil_'+row+'" value="Yes"/>&nbsp;&nbsp;Yes</label> &nbsp;&nbsp;' +
										'<label class="crnt-cooking-oil-check" data-row="2" data-main-row="'+row+'"><input type="radio" name="crnt_cookoil_'+row+'" value="No" />&nbsp;&nbsp;No</label> &nbsp;&nbsp;' +
									'</p>' +
									'<p class="crnt-cooking-oil-amount-'+row+'" style="display:none"><input type="text" name="crnt_cookoil_amount_'+row+'" placeholder="Leters/Month" class="form-control" /></p>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<input type="hidden" name="crnt_cookoil_row[]" value="'+row+'" />' +
									'<input type="hidden" name="crnt_cookoil_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#criteriaIncCrntCooking').append(content);
					$('#crntCookingOilFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 4;
			var option_drugs = '<?php echo $option_drugs; ?>';
			$(document).on('click', '.prev-insuline-add', function(){
				var inp_name = $('#prevInsulinFieldName').val();
				if(inp_name !== '')
				{
					var content = '<div class="form-group previous-insuline put-relative">'+
										'<label class="control-label col-md-2"><strong>'+inp_name+'</strong></label>'+
										'<div class="col-md-4">'+
											'<select name="prev_insulin_row_type_'+row+'" class="form-control">'+ option_drugs +'</select>'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Morning" name="prev_insulin_row_value_morning_'+row+'" class="form-control">'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Noon" name="prev_insulin_row_value_noon_'+row+'" class="form-control">'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Night" name="prev_insulin_row_value_night_'+row+'" class="form-control">'+
										'</div>'+
										'<span class="rmv-itm mdi mdi-delete"></span>' +
										'<input type="hidden" name="prev_insulin_row[]" value="'+row+'" />'+
										'<input type="hidden" name="prev_insulin_row_name_'+row+'" value="'+inp_name+'" />'+
									'</div>';	
					$('#prevInsulineContainer').append(content);
					$('#prevInsulinFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 4;
			var option_drugs = '<?php echo $option_drugs; ?>';
			$(document).on('click', '.crnt-insuline-add', function(){
				var inp_name = $('#crntInsulinFieldName').val();
				if(inp_name !== '')
				{
					var content = '<div class="form-group previous-insuline put-relative">'+
										'<label class="control-label col-md-2"><strong>'+inp_name+'</strong></label>'+
										'<div class="col-md-4">'+
											'<select name="crnt_insulin_row_type_'+row+'" class="form-control">'+ option_drugs +'</select>'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Morning" name="crnt_insulin_row_value_morning_'+row+'" class="form-control">'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Noon" name="crnt_insulin_row_value_noon_'+row+'" class="form-control">'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Night" name="crnt_insulin_row_value_night_'+row+'" class="form-control">'+
										'</div>'+
										'<span class="rmv-itm mdi mdi-delete"></span>' +
										'<input type="hidden" name="crnt_insulin_row[]" value="'+row+'" />'+
										'<input type="hidden" name="crnt_insulin_row_name_'+row+'" value="'+inp_name+'" />'+
									'</div>';	
					$('#crntInsulineContainer').append(content);
					$('#crntInsulinFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('keyup', '#prevPhisicalActivityFieldUnit', function(){
				var inp_value = parseInt($(this).val()) || 0;
				if(inp_value > 1440)
				{
					alert("Maximum value 1440 is allowed!");
					$(this).val('');
				}
			});
			$(document).on('keyup', '#prevPhisicalActivityFieldUnitPerWeek', function(){
				var inp_value = parseInt($(this).val()) || 0;
				if(inp_value > 7)
				{
					alert("Maximum value 7 is allowed!");
					$(this).val('');
				}
			});
			$(document).on('click', '.prev-phisical-activity-field-add', function(){
				var inp_name = $("select#prevPhisicalActivityFieldName option").filter(":selected").val();
				var inp_value = $("#prevPhisicalActivityFieldUnit").val();
				var inp_value_per_week = $("#prevPhisicalActivityFieldUnitPerWeek").val();
				if(inp_name !== '' && inp_value !== '')
				{
					var content = '<div class="col-lg-3 put-relative">' +
										'<div style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 105px; padding: 10px;">' +
											'<p><strong>'+inp_name+':</strong></p>' +
											'<p>' +
												'<strong>'+inp_value+' Minutes/Day</strong>' +
												'<input type="hidden" name="prev_phisical_acitivity_value_'+row+'" value="'+inp_value+' Minutes/Day" />' +
											'</p>' +
											'<p>' +
												'<strong>'+inp_value_per_week+' Day/Week</strong>' +
												'<input type="hidden" name="prev_phisical_acitivity_value_per_week_'+row+'" value="'+inp_value_per_week+' Day/Week" />' +
											'</p>' +
											'<span class="rmv-itm mdi mdi-delete"></span>' +
											'<input type="hidden" name="prev_phisical_acitivity_row[]" value="'+row+'" />' +
											'<input type="hidden" name="prev_phisical_acitivity_row_name_'+row+'" value="'+inp_name+'" />' +
										'</div>' +
									'</div>';	
					$('#criteriaIncEight').append(content);
					$('#prevPhisicalActivityFieldName').val('');
					$('#prevPhisicalActivityFieldUnit').val('');
					$("#prevPhisicalActivityFieldUnitPerWeek").val('');
					row++;
				}else
				{
					return false;
				}
			});
			
			$("#prevPhisicalActivityFieldUnit").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					 // Allow: Ctrl+A, Command+A
					(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
					 // Allow: home, end, left, right, down, up
					(e.keyCode >= 35 && e.keyCode <= 40)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('click', '.crnt-phisical-activity-field-add', function(){
				var inp_name = $("select#crntPhisicalActivityFieldName option").filter(":selected").val();
				var inp_value = $("#crntPhisicalActivityFieldUnit").val();
				if(inp_name !== '' && inp_value !== '')
				{
					var content = '<div class="col-lg-3 put-relative">' +
										'<div style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 80px; padding: 10px;">' +
											'<p><strong>'+inp_name+':</strong></p>' +
											'<p>' +
												'<strong>'+inp_value+' min/day</strong>' +
												'<input type="hidden" name="crnt_phisical_acitivity_value_'+row+'" value="'+inp_value+' min/day" />' +
											'</p>' +
											'<span class="rmv-itm mdi mdi-delete"></span>' +
											'<input type="hidden" name="crnt_phisical_acitivity_row[]" value="'+row+'" />' +
											'<input type="hidden" name="crnt_phisical_acitivity_row_name_'+row+'" value="'+inp_name+'" />' +
										'</div>' +
									'</div>';	
					$('#criteriaIncCrntPhisicalAct').append(content);
					$('#crntPhisicalActivityFieldName').val('');
					$('#crntPhisicalActivityFieldUnit').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
			$("#crntPhisicalActivityFieldUnit").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					 // Allow: Ctrl+A, Command+A
					(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
					 // Allow: home, end, left, right, down, up
					(e.keyCode >= 35 && e.keyCode <= 40)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('click', '.prev-medication-field-add', function(){
				var inp_name = $("#prevMedicationFieldName").val();
				var inp_value = $("#prevMedicationFieldUnit").val();
				if(inp_name !== '' && inp_value !== '')
				{	
					$.ajax({
						  type: "GET",
						  url: baseUrl + "patients/visit/drug_info",
						  dataType: "json",
						  data: {
							q: inp_name,
							inp_val: inp_value,
							inp_row: row
						  },
						  beforeSend: function() {
							$('#sponsorLoad').show();
						  },
						  success: function( data ) {
							if(data.status == 'ok')
							{
								$('#criteriaIncNine').append(data.content);
								$('#prevMedicTable').append(data.table_content);
								$('#prevMedicationFieldName').val('');
								$('#prevMedicationFieldUnit').val('');
								$('#sponsorLoad').hide();
								return false;
							}else
							{
								$('#prevMedicationFieldName').val('');
								$('#prevMedicationFieldUnit').val('');
								alert('Please select the right drug name!');
								$('#sponsorLoad').hide();
								return false;
							}
							
						  }
					});
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('click', '.crnt-medication-field-add', function(){
				var inp_name = $("#crntMedicationFieldName").val();
				var inp_value = $("#crntMedicationFieldUnit").val();
				
				if(inp_name !== '' && inp_value !== '')
				{	
					$.ajax({
						  type: "GET",
						  url: baseUrl + "patients/visit/drug_info_currentadvice",
						  dataType: "json",
						  data: {
							q: inp_name,
							inp_val: inp_value,
							inp_row: row
						  },
						  beforeSend: function() {
							$('#sponsorLoad2').show();
						  },
						  success: function( data ) {
							if(data.status == 'ok')
							{
								$('#criteriaIncCrntMedication').append(data.content);
								$('#crntMedicTable').append(data.table_content);
								$('#crntMedicationFieldName').val('');
								$('#crntMedicationFieldUnit').val('');
								$('#sponsorLoad2').hide();
								return false;
							}else
							{
								$('#crntMedicationFieldName').val('');
								$('#crntMedicationFieldUnit').val('');
								alert('Please select the right drug name!');
								$('#sponsorLoad2').hide();
								return false;
							}
							
						  }
					});
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 2;
			$(document).on('click', '.prev-oads-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="oads_name_'+row+'" placeholder="Add OADs" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="oads_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 100%;float: left;">খাওয়ার</span>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="oads_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="মাঝে">মাঝে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="oads_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="oads_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="oads_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#prevOads').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.prev-oads-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="oads_name_'+row+'" placeholder="Add OADs" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="oads_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 20%;">'+
										'<span style="display: block;width: 100%;float: left;">খাওয়ার</span>'+
										'</div>'+
										'<input type="text" name="oads_condition_time_'+row+'" style="float: left;width: 20%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
											'<div class="inline-sc" style="width: 20%;">'+
												'<select name="oads_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
											'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="oads_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="মাঝে">মাঝে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 50px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="oads_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="oads_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="oads_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#prevOads').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.prev-insulin-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="prev_insulin_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>' +
									'<div class="col-lg-2"><input type="text" name="prev_insulin_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="prev_insulin_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="prev_insulin_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="prev_insulin_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="prev_insulin_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="prev_insulin_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="prev_insulin_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#prevInsulin').append(content);
				$('.load-drugs-insulin').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_insulin",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.prev-insulin-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="prev_insulin_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>' +
									'<div class="col-lg-2"><input type="text" name="prev_insulin_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="prev_insulin_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="prev_insulin_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="prev_insulin_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="prev_insulin_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="prev_insulin_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="prev_insulin_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#prevInsulin').append(content);
				$('.load-drugs-insulin').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_insulin",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.htn-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="anti_htn_name_'+row+'" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="anti_htn_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="anti_htn_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="anti_htn_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="anti_htn_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="anti_htn_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="anti_htn_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="anti_htn_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiHtnFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.htn-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="anti_htn_name_'+row+'" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="anti_htn_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="anti_htn_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="anti_htn_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="anti_htn_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="anti_htn_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="anti_htn_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="anti_htn_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiHtnFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.lipids-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="lipids_name_'+row+'" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="lipids_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="lipids_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="lipids_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="lipids_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="lipids_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="lipids_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="lipids_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiLipidsFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.lipids-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="lipids_name_'+row+'" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="lipids_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="lipids_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="lipids_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="lipids_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="lipids_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="lipids_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="lipids_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiLipidsFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.aspirine-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="aspirine_name_'+row+'" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="aspirine_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="aspirine_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="aspirine_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="aspirine_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="aspirine_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="aspirine_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="aspirine_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#aspirineFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.aspirine-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="aspirine_name_'+row+'" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="aspirine_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="aspirine_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="aspirine_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="aspirine_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="aspirine_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="aspirine_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="aspirine_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#aspirineFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cardiac-medication-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="cardiac_medication_name_'+row+'" placeholder="Add Cardiac Medication" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="cardiac_medication_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="cardiac_medication_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#prevCardiacMedication').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.obesity-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="obesity_name_'+row+'" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="obesity_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="obesity_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="obesity_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="obesity_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="obesity_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="obesity_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="obesity_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiObesityFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.obesity-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="obesity_name_'+row+'" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="obesity_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="obesity_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="obesity_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="obesity_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="obesity_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="obesity_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="obesity_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiObesityFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.other-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="other_name_'+row+'" placeholder="Add Others" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="other_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="other_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="other_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="other_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="other_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="other_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="other_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#othersFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.other-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="other_name_'+row+'" placeholder="Add Others" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="other_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="other_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="other_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="other_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="other_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="other_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="other_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#othersFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.htn-remove-htn', function(){
				$(this).parent().parent().remove();
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 2;
			$(document).on('click', '.cntr-oads-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_oads_name_'+row+'" placeholder="Add OADs" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_oads_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 100%;float: left;">খাওয়ার</span>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_oads_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="মাঝে">মাঝে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_oads_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_oads_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_oads_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntOads').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-oads-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_oads_name_'+row+'" placeholder="Add OADs" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_oads_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 20%;">'+
										'<span style="display: block;width: 100%;float: left;">খাওয়ার</span>'+
										'</div>'+
										'<input type="text" name="crnt_oads_condition_time_'+row+'" style="float: left;width: 20%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
											'<div class="inline-sc" style="width: 20%;">'+
												'<select name="crnt_oads_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
											'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_oads_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="মাঝে">মাঝে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_oads_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_oads_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_oads_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntOads').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-exercise-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-6"><input type="text" name="crnt_exercise_value_'+row+'" class="form-control" /></div>' +
									'<div class="col-lg-6"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="crnt_exercise_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntExercise').append(content);
				row++;
			});


			$(document).on('click', '.cntr-insulin-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_insulin_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_insulin_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_insulin_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_insulin_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_insulin_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_insulin_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_insulin_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_insulin_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntInsulin').append(content);
				$('.load-drugs-insulin').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_insulin",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-insulin-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_insulin_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_insulin_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_insulin_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_insulin_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_insulin_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_insulin_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_insulin_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_insulin_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntInsulin').append(content);
				$('.load-drugs-insulin').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_insulin",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});


			$(document).on('click', '.cntr-cardiac-medication-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_cardiac_medication_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_cardiac_medication_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="crnt_cardiac_medication_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntCardiacMedication').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.cntr-htn-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_anti_htn_name_'+row+'" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_anti_htn_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_anti_htn_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_anti_htn_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_anti_htn_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_anti_htn_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_anti_htn_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_anti_htn_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiHtnFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-htn-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_anti_htn_name_'+row+'" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_anti_htn_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_anti_htn_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_anti_htn_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_anti_htn_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_anti_htn_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_anti_htn_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_anti_htn_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiHtnFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-lipids-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_lipids_name_'+row+'" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_lipids_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_lipids_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_lipids_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_lipids_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_lipids_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_lipids_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_lipids_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiLipidsFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-lipids-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_lipids_name_'+row+'" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_lipids_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_lipids_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_lipids_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_lipids_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_lipids_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_lipids_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_lipids_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiLipidsFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-aspirine-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_aspirine_name_'+row+'" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_aspirine_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_aspirine_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_aspirine_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_aspirine_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_aspirine_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_aspirine_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_aspirine_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#aspirineFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-aspirine-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_aspirine_name_'+row+'" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_aspirine_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_aspirine_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_aspirine_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_aspirine_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_aspirine_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_aspirine_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_aspirine_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#aspirineFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-obesity-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_obesity_name_'+row+'" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_obesity_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_obesity_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_obesity_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_obesity_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_obesity_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_obesity_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_obesity_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiObesityFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-obesity-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_obesity_name_'+row+'" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_obesity_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_obesity_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_obesity_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_obesity_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_obesity_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_obesity_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_obesity_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiObesityFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-other-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_other_name_'+row+'" placeholder="Add Others" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_other_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_other_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_other_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_other_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_other_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_other_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_other_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#othersFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-other-add-more-htn-doc', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_other_name_'+row+'" placeholder="Add Others" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_other_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-12" style="padding-top: 30px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_other_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_other_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_other_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-10" style="padding-top: 30px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_other_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_other_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_other_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#othersFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.htn-remove-htn', function(){
				$(this).parent().parent().remove();
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.check-save', function(){
				var method = $(this).attr('data-save-method');
				$('.confirm-payment').attr('data-save-method', method);
			});
			$(document).on('click', '.submit-type', function(){
				var submit_type = $(this).attr('data-save-method');
				if(submit_type == 'save')
				{
					$('#chkRdr').val(1);
				}else if(submit_type == 'saveexit')
				{
					$('#chkRdr').val(0);
				}
				
				$.validator.addMethod(
						"regex",
						function(value, element, regexp) {
							var re = new RegExp(regexp);
							return this.optional(element) || re.test(value);
						},
						"Please check your input."
				);
				
				$("#createForm").validate({
					rules:{
						visit_type:{
							required: true,
						},
						visit_date:{
							required: true,
						},
						registration_center:{
							required: true,
						},
						visit_center:{
							required: true,
						},
						visit_center_name:{
							required: true,
						},
						left_eye:{
							regex: "^[a-zA-Z 0-9'.\\s]{1,40}$",
						},
						right_eye:{
							regex: "^[a-zA-Z 0-9'.\\s]{1,40}$",
						},
						eye_exam_other:{
							regex: "^[a-zA-Z 0-9'.\\s]{1,40}$",
						},
						eye_exam_treatment:{
							regex: "^[a-zA-Z 0-9'.\\s]{1,40}$",
						},
					},
					messages:{
						visit_type:{
							required: null,
						},
						visit_date:{
							required: null,
						},
						registration_center:{
							required: null,
						},
						visit_center:{
							required: null,
						},
						left_eye:{
							regex: 'Only Alphanumerical entries are allowed!',
						},
						right_eye:{
							regex: 'Only Alphanumerical entries are allowed!',
						},
						eye_exam_other:{
							regex: 'Only Alphanumerical entries are allowed!',
						},
						eye_exam_treatment:{
							regex: 'Only Alphanumerical entries are allowed!',
						},
					},
					submitHandler : function () {
						$('#visitLoader').show();
						// your function if, validate is success
						$.ajax({
							type : "POST",
							url : baseUrl + "patients/visit/create",
							data : $('#createForm').serialize(),
							dataType : "json",
							cache: false,
							success : function (data) {
								if(data.status == "ok")
								{
									$('html, body').animate({
										scrollTop: $("body").offset().top
									 }, 1000);
									$('#alert').html(data.success);
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									$('#visitLoader').hide();
									if(data.exit == '1')
									{
										window.setTimeout(function(){
											window.location.href=baseUrl+'patients/visit/all/<?php echo $patient_id; ?>/<?php echo $patient_entry_id; ?>';
										}, 2000);
									}else if(data.exit == '0'){
										window.setTimeout(function(){
											window.location.href=baseUrl+'patients/visit/view/'+data.visit_id+'/'+data.visit_patient_id+'/'+data.visit_entryid;
										}, 2000);
									}
									$('.bs-example-modal-sm').modal('hide');
									document.getElementById('createForm').reset();
									return false;
								}else if(data.status == "error"){
									$('html, body').animate({
										scrollTop: $("body").offset().top
									 }, 1000);
									$('#alert').html(data.error);
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									$('#visitLoader').hide();
									$('.bs-example-modal-sm').modal('hide');
									return false;
								}else
								{
									//have end check.
								}
								return false;
							}
						});
					}
				});
			});
		});
	</script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('.load-drugs').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_drugs",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			$('.load-drugs-insulin').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_insulin",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			//Load visit registration center
			$('.src-registration-center').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_registration_centers",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  select: function (event, ui) {
						$(this).val(ui.item.label); // display the selected text
						$("#hiddenRegistrationCenterId").val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			//load visit center
			$('.src-visit-center').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_visit_centers",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  select: function (event, ui) {
						$(this).val(ui.item.label); // display the selected text
						$("#hiddenVisitCenterId").val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			$(document).on('blur', '.src-visit-center', function(){
				var hiddenVal = $('#hiddenVisitCenterId').val();
				if(hiddenVal == '')
				{
					$(this).val('');
				}
			});
			$(document).on('blur', '.src-doctor-name-by-center', function(){
				var hiddenVal = $('#hidden-foot-examination-doctor').val();
				if(hiddenVal == '')
				{
					$(this).val('');
				}
			});
			$(document).on('blur', '.src-doctor-name', function(){
				var hiddenVal = $('#hidden-eye-examination-doctor').val();
				if(hiddenVal == '')
				{
					$(this).val('');
				}
			});
			$(document).on('blur', '.src-doctor-name-final-treatment', function(){
				var hiddenVal = $('#hidden-final-treatment-doctor').val();
				if(hiddenVal == '')
				{
					$(this).val('');
				}
			});
			
			//Load doctor list
			$('.src-doctor-name').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/load_doctors",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  select: function (event, ui) {
						var hiddenValue = $(this).attr('data-section');
						$(this).val(ui.item.label); // display the selected text
						$('#'+hiddenValue).val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			$('.src-doctor-name-final-treatment').autocomplete({
			  source: function( request, response ) {
				  var centerId = $('#hiddenVisitCenterId').val();
				  if(centerId){
					  $.ajax({
						  type: "GET",
						  url: baseUrl + "patients/visit/load_doctors_with_center_wise",
						  dataType: "json",
						  data: {
							q: request.term,
							centerId:centerId,
						  },
						  success: function( data ) {
							response( data.content);
						  }
					 });
				  }else{
					  alert('Please enter visit center');
					  $('.src-doctor-name-final-treatment:focus').val('');
				  }
			  },
			  select: function (event, ui) {
						var hiddenValue = $(this).attr('data-section');
						$(this).val(ui.item.label); // display the selected text
						$('#'+hiddenValue).val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			$('.src-doctor-name-by-center').autocomplete({
			  source: function( request, response ) {
				  var centerId = $('#hiddenVisitCenterId').val();
				  if(centerId){
					  $.ajax({
						  type: "GET",
						  url: baseUrl + "patients/visit/load_doctors_with_center_wise",
						  dataType: "json",
						  data: {
							q: request.term,
							centerId:centerId,
						  },
						  success: function( data ) {
							response( data.content);
						  }
					 });
				  }else{
					  alert('Please enter visit center');
					  $('.src-doctor-name-by-center:focus').val('');
				  }
			  },
			  select: function (event, ui) {
						var hiddenValue = $(this).attr('data-section');
						$(this).val(ui.item.label); // display the selected text
						$('#'+hiddenValue).val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			// Cache selectors
			var lastId,
				topMenu = $("#stickyNavSection"),
				topMenuHeight = topMenu.outerHeight(),
				// All list items
				menuItems = topMenu.find("a"),
				// Anchors corresponding to menu items
				scrollItems = menuItems.map(function(){
				  var item = $($(this).attr("href"));
				  if (item.length) { return item; }
				});

			// Bind click handler to menu items
			// so we can get a fancy scroll animation
			menuItems.click(function(e){
			  var href = $(this).attr("href"),
				  offsetTop = href === "#" ? 0 : $(href).offset().top+1;
			  $('html, body').stop().animate({ 
				  scrollTop: offsetTop
			  }, 300);
			  e.preventDefault();
			});

			// Bind to scroll
			$(window).scroll(function(){
			   // Get container scroll position
			   var fromTop = $(this).scrollTop();
			   
			   // Get id of current scroll item
			   var cur = scrollItems.map(function(){
				 if ($(this).offset().top < fromTop)
				   return this;
			   });
			   // Get the id of the current element
			   cur = cur[cur.length-1];
			   var id = cur && cur.length ? cur[0].id : "";
			   
			   if (lastId !== id) {
				   lastId = id;
				   // Set/remove active class
				   menuItems
					 .parent().removeClass("active")
					 .end().filter("[href='#"+id+"']").parent().addClass("active");
			   }                   
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var project1 = $('.sticky-sidebar').offset();
			var $window = $(window);
			
			$window.scroll(function() {
				if ( $window.scrollTop() >= project1.top) {
					$(".sticky-sidebar").addClass("sticky-active");
				}else{
					$(".sticky-sidebar").removeClass("sticky-active");
				}
			});			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('keyup', '.src-registration-center', function(){
				$('#hiddenRegistrationCenterId').val('');
			});
			$(document).on('keyup', '.src-visit-center', function(){
				$('#hiddenVisitCenterId').val('');
			});
			$(document).on('keyup', '.src-doctor-name-by-center', function(){
				$('#hidden-foot-examination-doctor').val('');
			});
			$(document).on('keyup', '.src-doctor-name', function(){
				$('#hidden-eye-examination-doctor').val('');
			});
			$(document).on('keyup', '.src-doctor-name-final-treatment', function(){
				$('#hidden-final-treatment-doctor').val('');
			});
			
			$(document).on('keyup', '.check-with-decimel', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,1})?$/)) {
					return true;
				} else {
					var getValue = $(this).val();
					$(this).val(roundOff(getValue));
				}
			});
			
			$(document).on('keyup', '.check-with-double-decimel-for-tc', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,2})?$/)) {
					if(getFieldValue > 60000)
					{
						alert("Maximum value 60000 is allowed!");
						$(this).val(roundOffDoubleDecimel(0));
					}else{
						return true;
					}
				} else {
					var getValue = $(this).val();
					if(getValue > 60000)
					{
						alert("Maximum value 60000 is allowed!");
						$(this).val(roundOffDoubleDecimel(0));
					}else{
						$(this).val(roundOffDoubleDecimel(getValue));
					}
				}
			});
			
			$(document).on('keyup', '.check-with-double-decimel-limit-hundred', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,2})?$/)) {
					if(getFieldValue > 100)
					{
						alert("Maximum value 100 is allowed!");
						$(this).val(0);
					}else{
						return true;
					}
				} else {
					var getValue = $(this).val();
					if(getValue > 100)
					{
						alert("Maximum value 100 is allowed!");
						$(this).val(0);
					}else{
						$(this).val(getValue);
					}
				}
			});
			
			$(document).on('keyup', '.check-with-double-decimel-max-300', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,2})?$/)) {
					if(getFieldValue > 300)
					{
						alert("Maximum value 300 is allowed!");
						$(this).val(0);
					}else{
						return true;
					}
				} else {
					var getValue = $(this).val();
					if(getValue > 300)
					{
						alert("Maximum value 300 is allowed!");
						$(this).val(0);
					}else{
						$(this).val(getValue);
					}
				}
			});
			
			$(document).on('keyup', '.check-with-double-decimel', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,2})?$/)) {
					if(getFieldValue > 500)
					{
						alert("Maximum value 500 is allowed!");
						$(this).val(roundOffDoubleDecimel(0));
					}else{
						return true;
					}
				} else {
					var getValue = $(this).val();
					if(getValue > 500)
					{
						alert("Maximum value 500 is allowed!");
						$(this).val(roundOffDoubleDecimel(0));
					}else{
						$(this).val(roundOffDoubleDecimel(getValue));
					}
				}
			});
			
			$(document).on('keyup', '.check-with-single-number', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,1})?$/)) {
					return true;
				} else {
					var getValue = $(this).val();
					$(this).val(roundOffsingleNumber(getValue));
				}
			});
			
			$(".check-alphanumeric-charactars").keydown(function (e) {
				// Allow: backspace, delete, tab, escape and enter
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 188, 32, 190, 191]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39) || (e.keyCode >= 65 && e.keyCode <= 90)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) || (e.keyCode < 65 || e.keyCode > 90)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
			$(".check-only-alphabetical-charactars").keydown(function (e) {
				// allow: backspace, delete, tab, escape and enter
			 if ($.inarray(e.keycode, [46, 8, 9, 27, 13, 110, 188, 32, 190]) !== -1 ||
					  // allow: ctrl+a
					 (e.keycode == 65 && e.ctrlkey === true) || 
					  // allow: home, end, left, right
					 (e.keycode >= 35 && e.keycode <= 39) || (e.keycode >= 65 && e.keycode <= 90)) {
						  // let it happen, don't do anything
						  return;
				}
				  ensure that it is a number and stop the keypress
				 if ((e.shiftkey || (e.keycode < 65 || e.keycode > 90))) {
					 e.preventdefault();
				}
			 });
			
			$(document).on('keyup', '.check-less-from-sbp-sitting', function(){
				var getSbpSittingValue = roundOff($(this).val());
				var getDbpSittingValue = roundOff($('.sbp-sitting').val());
				if(getDbpSittingValue < 1){
					alert("Please insert Sitting SBP value then try again");
					$(this).val('');
				}else if(getSbpSittingValue > getDbpSittingValue){
					alert("Sitting DBP value can not be higher than sitting SBP value");
					$(this).val('');
				}
			});
			$(document).on('keyup', '.check-less-from-sbp-standing', function(){
				var getSbpStandingValue = roundOff($(this).val());
				var getDbpStandingValue = roundOff($('.sbp-standing').val());
				if(getDbpStandingValue < 1){
					alert("Please insert Standing SBP value then try again");
					$(this).val('');
				}else if(getSbpStandingValue > getDbpStandingValue){
					alert("Standing DBP value can not be higher than Standing SBP value");
					$(this).val('');
				}
			});
			
			$(document).on('change', '.check-date-is-valid', function(){
				var getValue = $(this).val();
				var splitDate = getValue.split('/');
				//alert(checkDate(splitDate[0], splitDate[1], splitDate[2]));
				if(checkDate(splitDate[0], splitDate[1], splitDate[2]) == 'YES')
				{
					$(this).val('');
				}
			});
		});
		
		function roundOff(decimelNumber) { 
            var theNumber = parseFloat(decimelNumber) || 0;
			var singlePlaces = theNumber.toFixed(1); 
			return singlePlaces;
        }
		function roundOffDoubleDecimel(decimelNumber) { 
            var theNumber = parseFloat(decimelNumber) || 0;
			if(theNumber > 500)
			{
				alert("Maximum value 500 is allowed!");
				theNumber = 0;
				return theNumber.toFixed(2);
			}else{
				var singlePlaces = theNumber.toFixed(2); 
				return singlePlaces;
			}
        }
		function roundOffsingleNumber(decimelNumber) { 
            var theNumber = parseFloat(decimelNumber) || 0;
			var singlePlaces = theNumber.toFixed(0); 
			return singlePlaces;
        } 
		function validateCode(string){
			var TCode = string;
			if( /[^a-zA-Z0-9]/.test( TCode ) ) {
			   alert('Input is not alphanumeric');
			   return false;
			}
			return true;     
		 }
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('html, body').animate({scrollTop: 0}, 1000);
		});
		function checkDate(day, month, year)
		{
			var regd = new RegExp("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})\$");

			var date = month + "/" + day + "/" + year;
			var date = new Date(date);
			var today = new Date();

			var vdob = regd.test(date);
			if(date.getDate() != day || (date.getTime()>today.getTime()))
			{
				return "YES";
			}else
			{
				return "NO";
			}
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.sel-sympt-diabetes-yes', function(){
				if($('input.checkbox-sympt-diabetes-yes').is(":checked"))
				{
					$('input.checkbox-sympt-diabetes-no').prop("checked", false);
					$('.diabetes-type-keywords').show();
					$('.diabetes-type-keywords').find('input:checkbox').prop("checked", false);
				}else{
					$('.diabetes-type-keywords').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-diabetes-no', function(){
				if($('input.checkbox-sympt-diabetes-no').is(":checked"))
				{
					$('input.checkbox-sympt-diabetes-yes').prop("checked", false);
					$('.diabetes-type-keywords').hide();
				}else{
					$('.diabetes-type-keywords').hide();
				}
			});
			
			/***Foot Examinations**/
			
			//Arteria Dorsalis Pedis Present
			$(document).on('click', '.arteria-dorsalis-predis-present-left', function(){
				if($('input.checkbox-arteria-dorsalis-predis-present-left').is(":checked"))
				{
					$('input.checkbox-arteria-dorsalis-predis-absent-left').prop("checked", false);
				}
			});
			
			$(document).on('click', '.arteria-dorsalis-predis-present-right', function(){
				if($('input.checkbox-arteria-dorsalis-predis-present-right').is(":checked"))
				{
					$('input.checkbox-arteria-dorsalis-predis-absent-right').prop("checked", false);
				}
			});
			
			//Arteria Dorsalis Pedis Absent
			$(document).on('click', '.arteria-dorsalis-predis-absent-left', function(){
				if($('input.checkbox-arteria-dorsalis-predis-absent-left').is(":checked"))
				{
					$('input.checkbox-arteria-dorsalis-predis-present-left').prop("checked", false);
				}
			});
			
			$(document).on('click', '.arteria-dorsalis-predis-absent-right', function(){
				if($('input.checkbox-arteria-dorsalis-predis-absent-right').is(":checked"))
				{
					$('input.checkbox-arteria-dorsalis-predis-present-right').prop("checked", false);
				}
			});
			
			//Posterior Tribila Present
			$(document).on('click', '.posterior-tribila-present-left', function(){
				if($('input.checkbox-posterior-tribila-present-left').is(":checked"))
				{
					$('input.checkbox-posterior-tribila-absent-left').prop("checked", false);
				}
			});
			
			$(document).on('click', '.posterior-tribila-present-right', function(){
				if($('input.checkbox-posterior-tribila-present-right').is(":checked"))
				{
					$('input.checkbox-posterior-tribila-absent-right').prop("checked", false);
				}
			});
			
			//Posterior Tribila Absent
			$(document).on('click', '.posterior-tribila-absent-left', function(){
				if($('input.checkbox-posterior-tribila-absent-left').is(":checked"))
				{
					$('input.checkbox-posterior-tribila-present-left').prop("checked", false);
				}
			});
			
			$(document).on('click', '.posterior-tribila-absent-right', function(){
				if($('input.checkbox-posterior-tribila-absent-right').is(":checked"))
				{
					$('input.checkbox-posterior-tribila-present-right').prop("checked", false);
				}
			});
			
			
			//Monofilament Present
			$(document).on('click', '.monofilament-present-left', function(){
				if($('input.checkbox-monofilament-present-left').is(":checked"))
				{
					$('input.checkbox-monofilament-absent-left').prop("checked", false);
				}
			});
			
			$(document).on('click', '.monofilament-present-right', function(){
				if($('input.checkbox-monofilament-present-right').is(":checked"))
				{
					$('input.checkbox-monofilament-absent-right').prop("checked", false);
				}
			});
			
			//Monofilament Absent
			$(document).on('click', '.monofilament-absent-left', function(){
				if($('input.checkbox-monofilament-absent-left').is(":checked"))
				{
					$('input.checkbox-monofilament-present-left').prop("checked", false);
				}
			});
			
			$(document).on('click', '.monofilament-absent-right', function(){
				if($('input.checkbox-monofilament-absent-right').is(":checked"))
				{
					$('input.checkbox-monofilament-present-right').prop("checked", false);
				}
			});
			
			//Tuning Fork Present
			$(document).on('click', '.tuning-fork-present-left', function(){
				if($('input.checkbox-tuning-fork-present-left').is(":checked"))
				{
					$('input.checkbox-tuning-fork-absent-left').prop("checked", false);
				}
			});
			
			$(document).on('click', '.tuning-fork-present-right', function(){
				if($('input.checkbox-tuning-fork-present-right').is(":checked"))
				{
					$('input.checkbox-tuning-fork-absent-right').prop("checked", false);
				}
			});
			
			//Tuning Fork Absent
			$(document).on('click', '.tuning-fork-absent-left', function(){
				if($('input.checkbox-tuning-fork-absent-left').is(":checked"))
				{
					$('input.checkbox-tuning-fork-present-left').prop("checked", false);
				}
			});
			
			$(document).on('click', '.tuning-fork-absent-right', function(){
				if($('input.checkbox-tuning-fork-absent-right').is(":checked"))
				{
					$('input.checkbox-tuning-fork-present-right').prop("checked", false);
				}
			});
			
			/********Diabetes History*********/
			
			//Previous Bad Obstetrical History
			$(document).on('click', '.prev-bad-obstetric-history-yes', function(){
				if($('input.checkbox-prev-bad-obstetric-history-yes').is(":checked"))
				{
					$('input.checkbox-prev-bad-obstetric-history-no').prop("checked", false);
				}
			});
			
			$(document).on('click', '.prev-bad-obstetric-history-no', function(){
				if($('input.checkbox-prev-bad-obstetric-history-no').is(":checked"))
				{
					$('input.checkbox-prev-bad-obstetric-history-yes').prop("checked", false);
				}
			});
			
			//Previous History of GDM
			$(document).on('click', '.prev-history-of-gdm-yes', function(){
				if($('input.checkbox-prev-history-of-gdm-yes').is(":checked"))
				{
					$('input.checkbox-prev-history-of-gdm-no').prop("checked", false);
				}
			});
			
			$(document).on('click', '.prev-history-of-gdm-no', function(){
				if($('input.checkbox-prev-history-of-gdm-no').is(":checked"))
				{
					$('input.checkbox-prev-history-of-gdm-yes').prop("checked", false);
				}
			});
			
			//Laboratory Investigation ECG Type
			$(document).on('click', '.lab-ecg-type-abnormal', function(){
				if($('input.checkbox-lab-ecg-type-abnormal').is(":checked"))
				{
					$('input.checkbox-lab-ecg-type-normal').prop("checked", false);
					$('.abnoirmal-type-keywords').show();
					$('.abnoirmal-type-keywords').find('input:checkbox').prop("checked", false);
				}else{
					$('.abnoirmal-type-keywords').hide();
				}
			});
			
			$(document).on('click', '.lab-ecg-type-normal', function(){
				if($('input.checkbox-lab-ecg-type-normal').is(":checked"))
				{
					$('input.checkbox-lab-ecg-type-abnormal').prop("checked", false);
					$('.abnoirmal-type-keywords').hide();
				}else{
					$('.abnoirmal-type-keywords').hide();
				}
			});
			
			//Laboratory Investigation USG Type
			$(document).on('click', '.lab-usg-type-abnormal', function(){
				if($('input.checkbox-lab-usg-type-abnormal').is(":checked"))
				{
					$('input.checkbox-lab-usg-type-normal').prop("checked", false);
					$('.usg-abnormal-type-keywords').show();
				}else{
					$('.usg-abnormal-type-keywords').hide();
				}
			});
			
			$(document).on('click', '.lab-usg-type-normal', function(){
				if($('input.checkbox-lab-usg-type-normal').is(":checked"))
				{
					$('input.checkbox-lab-usg-type-abnormal').prop("checked", false);
					$('.usg-abnormal-type-keywords').hide();
				}else{
					$('.usg-abnormal-type-keywords').hide();
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			//load visit center
			$('.src-investigation').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_investions",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response(data.content);
					// $('.src-investigation').val('');
				  }
				});
			  },
			  select: function (event, ui) {
						// var getValue = $(this).val();
						// if(getValue !== '')
						// {
							// $(this).val(getValue+', '+ui.item.label); // display the selected text
						// }else{
							$(this).val(ui.item.label); // display the selected text
						// }
						// searchFilter();
						//$("#hiddenVisitCenterId").val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
		});
	</script>
	<script type="text/javascript">
	$('#second').change(function() {
		if ($('#first').val()!==''){
    $('#first').val($('#first').val() + ','+$(this).val());
    $('#second').val(null);
		}else {
			$('#first').val($(this).val());
			$('#second').val(null);
		}
});
	</script>
	
	<script type="text/javascript">
	$("#refresh").click(function(){
		var str = $('#first').val();
		var arr = str.split(',');
		arr = arr.splice(0, arr.length - 1);
		var rem = arr.join(',');
		$('#first').val(rem);
	});
	</script>
	
	<script type="text/javascript">
	$('#criteriaIncOne').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#deactive-enter-lab').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#block-enter-ft').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#block-enter-dh').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	<script type="text/javascript">
	$('#deactive-enter-ee').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	<script type="text/javascript">
	$('#deactive-enter-dih').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#deactive-enter-foot').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#deactive-enter-visit').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#deactive-enter-pah').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
<?php require_once APPPATH.'modules/common/footer.php' ?>