<?php require_once APPPATH.'modules/common/header.php' ?>
	<div id="visitLoader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Patients</li>
				<li class="active">Create</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<?php 
			$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm', 'style' => 'padding:0 5%;');
			echo form_open('', $attr);
		?>
		<?php 
			$patientinfo = $this->Visit_model->get_patientinfo($patient_id);
		?>
		<div class="col-lg-10 visit-form-col">
			<input type="hidden" name="id" value="<?php echo $visit_id; ?>" />
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
							<?php 
								$gender_array = array('0' => 'Male', '1' => 'Female', '2' => 'Other');
							?>
							<div class="media-body">
								<h4 class="media-heading"><?php echo $patientinfo['patient_name']; ?></h4>
								<p><strong>Gender : </strong> <?php echo ($patientinfo['patient_gender'])? $gender_array[$patientinfo['patient_gender']] : null; ?></p>
								<p><strong>BNDR ID : </strong> <?php echo $patientinfo['patient_entryid']; ?></p>
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
			<?php 
				/***************************/
				/*****Visit information****/
				/***************************/
				
				$visit_info                      = $this->Visit_model->visit_information($visit_id, $patient_id);
				$visit_laboratory_ecg            = $this->Visit_model->visit_laboratory_ecg($visit_id, $patient_id);
				$visit_complications             = $this->Visit_model->visit_complications($visit_id, $patient_id);
				$visit_personal_habits           = $this->Visit_model->visit_personal_habits($visit_id, $patient_id);
				$visit_family_history            = $this->Visit_model->visit_family_history($visit_id, $patient_id);
			
			?>
			
			<div id="alert"></div>
			<div class="panel panel-default block2" id="visitDetails">
				<div class="panel-heading text-center">VISIT DETAILS</div>
				<input type="hidden" name="visit_patient" value="<?php echo $patient_id; ?>" />
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
							<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Duration Of DM <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<?php 
											$visit_types = array('Less than 1 month',
																'Less than 1 Year',
																'1 to 5 Years',
																'5 to 10 Years',
																'10 to 15 Years',
																'15 to 20 Years',
																'Above 20 Years',
															);
										?>
										<select name="visit_type" class="form-control">
											<?php 
												foreach($visit_types as $type):
											?>
											<option value="<?php echo $type; ?>" <?php echo ($visit_info['visit_type'] == $type)? 'selected' : null; ?>><?php echo $type; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Registration Centre<span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" name="registration_center" id="regCenter" class="form-control form-control-line" value="<?php echo $visit_info['visit_registration_center']; ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Doctor</label>
									<div class="col-md-7">
										<input type="text" name="to_doctor" value="<?php echo $visit_info['visit_doctor']; ?>" class="form-control form-control-line" id="toDoctor" />
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Visit Date<span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" class="form-control datepicker" name="visit_date" placeholder="yyyy-mm-dd" value="<?php echo $visit_info['visit_date']; ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Visit Centre<span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="visit_center" id="visitCenter" placeholder="Visit Centre" value="<?php echo $visit_info['visit_visit_center']; ?>" />
									</div>
								</div>
							</div>
							</div>
							<?php 
								if($patientinfo['patient_gender'] === '1'):
								$visit_menstruals   = $this->Visit_model->menstrual_information($visit_id, $patient_id);
								$obstetric_history  = $this->Visit_model->obstetric_history($visit_id, $patient_id);
							?>
							<div class="row">
							<div class="col-lg-6">
								<h4 style="font-weight: bold; font-size: 15px; border-bottom: 1px solid rgb(204, 204, 204); text-align: center; padding-bottom: 6px;">Menstrual Cycle</h4>
								<div class="form-group">
									<label class="control-label col-md-5" style="padding-top: 12px;">Regular</label>
									<div class="col-md-2">
										<label><input type="radio" name="mentrual_regular" value="Yes" <?php echo (isset($visit_menstruals['menstrlc_regular']) && $visit_menstruals['menstrlc_regular'] == 'Yes')? 'checked' : null; ?> /> Yes</label>
									</div>
									<div class="col-md-2">
										<label><input type="radio" name="mentrual_regular" value="No" <?php echo (isset($visit_menstruals['menstrlc_regular']) && $visit_menstruals['menstrlc_regular'] == 'No')? 'checked' : null; ?> /> No</label>
									</div>
									<div class="col-md-3">
										<label><input type="radio" name="mentrual_regular" value="Unknown" <?php echo (isset($visit_menstruals['menstrlc_regular']) && $visit_menstruals['menstrlc_regular'] == 'Unknown')? 'checked' : null; ?> /> Unknown</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5" style="padding-top: 12px;">Irregular</label>
									<div class="col-md-2">
										<label><input type="radio" name="mentrual_menopause" value="Yes" <?php echo (isset($visit_menstruals['menstrlc_irregular']) && $visit_menstruals['menstrlc_irregular'] == 'Yes')? 'checked' : null; ?> /> Yes</label>
									</div>
									<div class="col-md-2">
										<label><input type="radio" name="mentrual_menopause" value="No" <?php echo (isset($visit_menstruals['menstrlc_irregular']) && $visit_menstruals['menstrlc_irregular'] == 'No')? 'checked' : null; ?> /> No</label>
									</div>
									<div class="col-md-3">
										<label><input type="radio" name="mentrual_menopause" value="Unknown" <?php echo (isset($visit_menstruals['menstrlc_irregular']) && $visit_menstruals['menstrlc_irregular'] == 'Unknown')? 'checked' : null; ?> /> Unknown</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5" style="padding-top: 12px;">Menopause</label>
									<div class="col-md-2">
										<label><input type="radio" name="mentrual_menopause" value="Yes" <?php echo (isset($visit_menstruals['menstrlc_menopause']) && $visit_menstruals['menstrlc_menopause'] == 'Yes')? 'checked' : null; ?> /> Yes</label>
									</div>
									<div class="col-md-2">
										<label><input type="radio" name="mentrual_menopause" value="No" <?php echo (isset($visit_menstruals['menstrlc_menopause']) && $visit_menstruals['menstrlc_menopause'] == 'No')? 'checked' : null; ?> /> No</label>
									</div>
									<div class="col-md-3">
										<label><input type="radio" name="mentrual_menopause" value="Unknown" <?php echo (isset($visit_menstruals['menstrlc_menopause']) && $visit_menstruals['menstrlc_menopause'] == 'Unknown')? 'checked' : null; ?> /> Unknown</label>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<h4 style="font-weight: bold; font-size: 15px; border-bottom: 1px solid rgb(204, 204, 204); text-align: center; padding-bottom: 6px;">Obstetric History</h4>
								<div class="form-group">
									<label class="control-label col-md-5">No of children</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="obstetric_no_of_children" value="<?php echo $obstetric_history['obstetric_children']; ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">No of large baby</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="obstetric_no_of_largebaby" value="<?php echo $obstetric_history['obstetric_large_baby']; ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">If infertility, duration(yr)</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="obstetric_fertility_duration" value="<?php echo $obstetric_history['obstetric_infertility_duration']; ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Age of last child</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="obstetric_last_child_age" value="<?php echo $obstetric_history['obstetric_last_child_age']; ?>" />
									</div>
								</div>
							</div>
							</div>
							<?php endif; ?>
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
									<label class="control-label col-md-5"></label>
									<div class="col-md-7">
										<strong>Symptomatic?: </strong> &nbsp;&nbsp;<label class="sel-sympt" data-value="1"><input type="radio" name="is_sympt" value="1" <?php echo ($visit_info['visit_has_symptomatic'] == '1')? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt" data-value="0"><input type="radio" name="is_sympt" value="0" <?php echo ($visit_info['visit_has_symptomatic'] == '0')? 'checked' : null; ?> /> No</label>
									</div>
								</div>
								<div class="sel-hidden-dropdown form-group" style="display:<?php echo ($visit_info['visit_has_symptomatic'] == 1)? 'block' : 'none'; ?>">
									<label class="control-label col-md-5">Select Type</label>
									<div class="col-md-7">
										<?php 
											$symptomatics = array(
																'Typical',
																'Atypical',
																'Asymptomatic',
																'Complication',
															);
										?>
										<select name="sympt_type" class="form-control">
											<option value="" selected="selected">Select Type</option>
											<?php 
												foreach($symptomatics as $type):
											?>
											<option value="<?php echo $type; ?>" <?php echo ($visit_info['visit_symptomatic_type'] == $type)? 'selected' : null; ?>><?php echo $type; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Patient Guide Book No</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="guidebook_no" placeholder="Patient Guide Book No" value="<?php echo $visit_info['visit_guidebook_no']; ?>" />
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5"></label>
									<div class="col-md-7">
										<label class="sel-sympt-2" data-value="1"><input type="radio" name="patient_type" value="Old Patient" <?php echo ($visit_info['visit_patient_type'] == 'Old Patient')? 'checked' : null; ?> /> Old Patient</label> &nbsp;&nbsp; <label class="sel-sympt-2" data-value="0"><input type="radio" name="patient_type" value="New Patient" <?php echo ($visit_info['visit_patient_type'] == 'New Patient')? 'checked' : null; ?> /> New Patient</label>
									</div>
								</div>
								<div class="sel-hidden-dropdown-2 form-group" style="display:<?php echo ($visit_info['visit_diabetes_duration'])? 'block' : 'none'; ?>">
									<label class="control-label col-md-5">Diabetes Duration</label>
									<div class="col-md-7">
										<select name="diabetes_duration" class="form-control">
											<option value="" selected="selected">Diabetes Duration</option>
											<?php 
												$durations = array('1 to 5 years', '6 to 10 years', '11 to 15 years', '16 to 20 years', 'More than 20 years');
												foreach($durations as $duration):
											?>
											<option value="<?php echo $duration; ?>" <?php echo ($visit_info['visit_diabetes_duration'] == $duration)? 'selected' : null; ?>><?php echo $duration; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Type Of Diabetes</label>
									<div class="col-md-7">
										<?php 
											$dtypes = array('Type 1','Type 2','Gestational Diabetes','Others');
										?>
										<select name="types_of_diabetes" class="form-control">
											<?php 
												foreach($dtypes as $dtype): 
											?>
											<option value="<?php echo $dtype; ?>" <?php echo ($visit_info['visit_types_of_diabetes'] == $dtype)? 'selected' : null; ?>><?php echo $dtype; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<?php 
				$visit_general_examinations      = $this->Visit_model->visit_general_examinations($visit_id, $patient_id);
				
				$get_array = array();
				foreach($visit_general_examinations as $key => $new_array)
				{
					$get_array[$new_array['generalexam_name']] = array($new_array['generalexam_value'], $new_array['generalexam_unit']);
				}
				
				$gexams = array(
							'Height' => array('cm','kg','mmHg'),
							'Weight' => array('cm','kg','mmHg'),
							'Waist' => array('cm','kg','mmHg'),
							'Hip' => array('cm','kg','mmHg'),
							'SBP' => array('cm','kg','mmHg'),
							'DBP' => array('cm','kg','mmHg'),
						  );
				
				$array_1 = array();
					foreach($gexams as $key => $value)
					{
						$array_1[] = $key;
					}
				$array_2 = array();
					foreach($get_array as $key => $value)
					{
						$array_2[] = $key;
					}
				
				$check_result = array_diff($array_2, $array_1);
				$final_result = array_merge($array_1, $check_result);
				
				$create_array = array();
				foreach($final_result as $key)
				{
					$create_array[$key] = array('cm','kg','mmHg');
				}
			?>
			<input type="hidden" id="generalExaminationTotal" value="<?php echo count($create_array)+1; ?>" />
			<div class="panel panel-default block2" id="generalExamination">
				<div class="panel-heading text-center">GENERAL EXAMINATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm">
									<p class="text-center">Add more criteria</p>
									<p>Name <input type="text" id="gexamFieldNameOne" /> &nbsp;&nbsp; Unit <input type="text" id="gexamFieldUnitOne" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="addbttn gexam-field-add-1">ADD</span></p>
								</div>
							</div>
							<div id="criteriaIncOne">
								<?php 
									$itmx = 1;
									foreach($create_array as $key => $units):
								?>
								<div class="col-lg-4">
									<div class="form-group">
										<label class="control-label col-md-5"><?php echo $key; ?></label>
										<div class="col-md-3">
											<input type="text" class="form-control" name="gexam_row_value_<?php echo $itmx; ?>" placeholder="<?php echo $key; ?>" value="<?php echo (isset($get_array[$key][0]))? $get_array[$key][0] : null; ?>" />
										</div>
										<div class="col-md-4">
											<select name="gexam_row_unit_<?php echo $itmx; ?>" class="form-control">
												<?php foreach($units as $unit): ?>
												<option value="<?php echo $unit; ?>" <?php echo (isset($get_array[$key][1]) && $get_array[$key][1] == $unit)? 'selected' : null; ?>><?php echo $unit; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<input type="hidden" name="gexam_row[]" value="<?php echo $itmx; ?>" />
									<input type="hidden" name="gexam_row_name_<?php echo $itmx; ?>" value="<?php echo $key; ?>" />
									<?php if($itmx > 6): ?>
									<span class="rmv-itm mdi mdi-delete"></span>
									<?php endif; ?>
								</div>
								<?php 
									$itmx++;
									endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<?php 
				$visit_laboratory_investigations = $this->Visit_model->visit_laboratory_investigations($visit_id, $patient_id);
				$visit_laboratory_ecg = $this->Visit_model->visit_laboratory_ecg($visit_id, $patient_id);
				$lab_array = array();
				foreach($visit_laboratory_investigations as $key => $new_array)
				{
					$lab_array[$new_array['labinvs_name']] = array($new_array['labinvs_value']);
				}
				
				$lab_investigations = array(
											'HbA1c'         => '%',
											'FPG'           => '',
											'2hAG'          => 'mmol',
											'Post Meal'     => 'mmol',
											'Urine Acetone' => '+',
											'Urine Albumin' => '',
											'S.Creatinine'  => 'mg/dl',
											'SGPT'          => 'units per liter',
											'HB'            => '%',
											'T.Chol'        => 'mg/dl',
											'LDL-C'         => 'mg/dl',
											'HDL-C'         => 'mg/dl',
											'Triglycerides' => 'mg/dl',
											'ESR'           => '',
											'Urine Albumin/Microalbumin' => '',
										  );
				
				$array_1 = array();
					foreach($lab_investigations as $key => $value)
					{
						$array_1[] = $key;
					}
				$array_2 = array();
					foreach($lab_array as $key => $value)
					{
						$array_2[] = $key;
					}
				
				$check_result = array_diff($array_2, $array_1);
				$final_result = array_merge($array_1, $check_result);
				
				$create_array = array();
				foreach($final_result as $key)
				{
					if(isset($lab_investigations[$key]))
					{
						$create_array[$key] = $lab_investigations[$key];
					}else
					{
						$create_array[$key] = null;
					}
				}
			?>
			<input type="hidden" id="labInvestigationTotal" value="<?php echo count($create_array)+1; ?>" />
			<div class="panel panel-default block2" id="laboratoryInvestigation">
				<div class="panel-heading text-center">LABORATORY INVESTIGATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm">
									<p class="text-center">Add more criteria</p>
									<p>Name <input type="text" id="labInvestigationName" /> &nbsp;&nbsp; Unit <input type="text" id="labInvestigationUnit" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="lab-investigation">ADD</span></p>
								</div>
							</div>
							
							<?php 
								$ecg_array1 = array('[', ']', '"');
								$ecg_array2 = array('', '', '');
								$labecg_array = str_replace($ecg_array1, $ecg_array2, $visit_laboratory_ecg['ecg_abnormals']);
								$labecg_array = explode(',', $labecg_array);
							?>
							<div id="criteriaIncTwo">
								<?php 
									$xlab = 1;
									foreach($create_array as $key => $value):
										
									if($xlab == 10):
								?>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="control-label col-md-2"></label>
											<div class="col-md-7">
												<strong>ECG : </strong> &nbsp;&nbsp;<label class="sel-sympt-3" data-value="1"><input type="radio" name="ecg_type" value="1" <?php echo ($visit_laboratory_ecg['ecg_type'] === '1')? 'checked' : null; ?> /> Normal</label> &nbsp;&nbsp; <label class="sel-sympt-3" data-value="0"><input type="radio" name="ecg_type" value="0" <?php echo ($visit_laboratory_ecg['ecg_type'] === '0')? 'checked' : null; ?> /> Abnormal</label>
												<div class="abnoirmal-type-keywords" style="display:<?php echo ($visit_laboratory_ecg['ecg_type'] === '0')? 'block' : 'none'; ?>">
													<label><input type="checkbox" name="abn_keywords[]" value="RBBB" <?php echo (in_array('RBBB', $labecg_array))? 'checked' : null; ?> />&nbsp;&nbsp; RBBB </label>&nbsp;&nbsp;&nbsp;&nbsp;
													<label><input type="checkbox" name="abn_keywords[]" value="LBBB" <?php echo (in_array('LBBB', $labecg_array))? 'checked' : null; ?> />&nbsp;&nbsp; LBBB </label>&nbsp;&nbsp;&nbsp;&nbsp;
													<label><input type="checkbox" name="abn_keywords[]" value="LVH" <?php echo (in_array('LVH', $labecg_array))? 'checked' : null; ?> />&nbsp;&nbsp; LVH </label>&nbsp;&nbsp;&nbsp;&nbsp;
													<label><input type="checkbox" name="abn_keywords[]" value="MI" <?php echo (in_array('MI', $labecg_array))? 'checked' : null; ?> />&nbsp;&nbsp; MI</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<label><input type="checkbox" name="abn_keywords[]" value="ISCHEMIA" <?php echo (in_array('ISCHEMIA', $labecg_array))? 'checked' : null; ?> />&nbsp;&nbsp; ISCHEMIA</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<label><input type="checkbox" name="abn_keywords[]" value="Others" <?php echo (in_array('Others', $labecg_array))? 'checked' : null; ?> />&nbsp;&nbsp; Others</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php endif; ?>
								<div class="col-lg-4">
									<div class="form-group">
										<label class="control-label col-md-5"><?php echo $key; ?></label>
										<div class="col-md-7">
											<input type="text" class="form-control" name="labinv_row_value_<?php echo $xlab; ?>" placeholder="<?php echo $value; ?>" value="<?php echo (isset($lab_array[$key][0]))?  $lab_array[$key][0] : null; ?>" />
										</div>
									</div>
									<?php if($xlab > 15): ?>
									<span class="rmv-itm mdi mdi-delete"></span>
									<?php endif; ?>
									<input type="hidden" name="labinv_row[]" value="<?php echo $xlab; ?>" />
									<input type="hidden" name="labinv_row_name_<?php echo $xlab; ?>" value="<?php echo $key; ?>" />
								</div>
								<?php	
									$xlab++;
									endforeach;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<?php 
				$visit_acute_complications = $this->Visit_model->visit_acute_complications($visit_id, $patient_id); 
				$acute_complication_arrays = array(
											'Hypogycemia',
											'DKA',
											'HHS',
										);
				$array1 = array();
				foreach($visit_acute_complications as $key => $new_array)
				{
					$array1[] = $new_array['vcomplication_name'];
				}
				
				$array2 = array();
				foreach($acute_complication_arrays as $key)
				{
					$array2[] = $key;
				}
				
				$get_diff = array_diff($array1, $array2);
				$create_array = array_merge($acute_complication_arrays, $get_diff);
			?>
			<input type="hidden" id="acuteComplicationTotal" value="<?php echo count($create_array)+1; ?>" />
			<div class="panel panel-default block2" id="complicationComorbidity">
				<div class="panel-heading text-center">COMPLICATION / COMORBIDITY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align:center">Acute Complications</h3>
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name <input type="text" id="acuteComplicationName" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="acute-complication-add">ADD</span></p>
								</div>
							</div>
							<div id="acuteCriteriaIncThree">
								<?php 
									$data_x = 1;
									$acute_com_array = array();
									foreach($visit_acute_complications as $complication):
										$acute_com_array[] = $complication['vcomplication_name'];
									endforeach;
									
									foreach($create_array as $data): 
								?>
								
								<div class="col-lg-4">
									<label><input type="checkbox" name="acute_complication_<?php echo $data_x; ?>" value="<?php echo $data; ?>" <?php echo (in_array($data, $acute_com_array))? 'checked' : null; ?>/>&nbsp;&nbsp;<?php echo $data; ?></label>
									<input type="hidden" name="acute_complication_row[]" value="<?php echo $data_x; ?>" />
									<?php if($data_x > 3): ?>
									<span class="rmv-itm mdi mdi-delete"></span>
									<?php endif; ?>
								</div>
								<?php 
								$data_x++;
								endforeach; 
								?>
							</div>
						</div>
			
			
			
			
			<?php 
				$visit_complications = $this->Visit_model->visit_complications($visit_id, $patient_id); 
				$complication_arrays = array(
											'Neuropathy',
											'Nephropathy',
											'Retinopathy',
											'Cerebrovascular',
											'PVD',
											'CAD',
											'HTN',
											'Dyslipidaemia',
											'Gastro Complications',
											'Foot Complications',
										);
				$array1 = array();
				foreach($visit_complications as $key => $new_array)
				{
					$array1[] = $new_array['vcomplication_name'];
				}
				
				$array2 = array();
				foreach($complication_arrays as $key)
				{
					$array2[] = $key;
				}
				
				$get_diff = array_diff($array1, $array2);
				$create_array = array_merge($complication_arrays, $get_diff);
			?>
			<input type="hidden" id="complicationTotal" value="<?php echo count($create_array)+1; ?>" />
						<div class="row">
							<div class="col-lg-12">
								<h3 style="text-align: center; margin-top: 50px;">Chronic Complications</h3>
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name <input type="text" id="complicationName" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="complication-add">ADD</span></p>
								</div>
							</div>
							<div id="criteriaIncThree">
								<?php 
									$data_x = 1;
									$com_array = array();
									foreach($visit_complications as $complication):
										$com_array[] = $complication['vcomplication_name'];
									endforeach;
									
									foreach($create_array as $data): 
								?>
								
								<div class="col-lg-4">
									<label><input type="checkbox" name="complication_<?php echo $data_x; ?>" value="<?php echo $data; ?>" <?php echo (in_array($data, $com_array))? 'checked' : null; ?>/>&nbsp;&nbsp;<?php echo $data; ?></label>
									<input type="hidden" name="complication_row[]" value="<?php echo $data_x; ?>" />
									<?php if($data_x > 10): ?>
									<span class="rmv-itm mdi mdi-delete"></span>
									<?php endif; ?>
								</div>
								<?php 
								$data_x++;
								endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<?php 
				$visit_personal_habits = $this->Visit_model->visit_personal_habits($visit_id, $patient_id);
				
				$habits_array = array();
				foreach($visit_personal_habits as $key => $new_array)
				{
					$habits_array[$new_array['phabit_name']] = array($new_array['phabit_adiction_type'], $new_array['phabit_amount'], $new_array['phabit_time_unit']);
				}
				
				$personal_habits = array(
										'Cigarette/Bidi'                 => array('day','Week','Month'),
										'Jorda/Tobacco Leaf/Powder'      => array('day','Week','Month'),
										'Betal Leaf/Betal Nut (Shupari)' => array('day','Week','Month'),
										'Alcohol'                        => array('day','Week','Month'),
									);
				$array1 = array();
				foreach($habits_array as $key => $new_array)
				{
					$array1[] = $key;
				}
				
				$array2 = array();
				foreach($personal_habits as $key => $new_array)
				{
					$array2[] = $key;
				}
				
				$check_diff = array_diff($array1, $array2);
				$add_values = array();
				foreach($check_diff as $key)
				{
					$add_values[$key] = array('day','Week','Month');
				}
				
				$create_array = array_merge($personal_habits, $add_values);
			?>
			<input type="hidden" id="personalHabitsTotal" value="<?php echo count($create_array)+1; ?>" />
			<div class="panel panel-default block2" id="personalHabits">
				<div class="panel-heading text-center">PERSONAL HABITS</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name <input type="text" id="phabitFieldName" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="phabit-add">ADD</span></p>
								</div>
							</div>
							
							<div id="criteriaIncFour">
								<?php 
									$phabitx = 1;
									foreach($create_array as $key => $value_array):
								?>
								<div class="col-lg-4" style="height:100px;margin-bottom:15px;">
									<p><strong><?php echo $key; ?>:</strong></p>
									<p>
										<label class="phabit-check" data-row="1" data-main-row="<?php echo $phabitx; ?>"><input type="radio" name="phabit_<?php echo $phabitx; ?>" value="Regular" <?php echo (isset($habits_array[$key][0]) && $habits_array[$key][0] == 'Regular')? 'checked' : null; ?> />&nbsp;&nbsp;Regular</label> &nbsp;&nbsp;
										<label class="phabit-check" data-row="2" data-main-row="<?php echo $phabitx; ?>"><input type="radio" name="phabit_<?php echo $phabitx; ?>" value="Occasional" <?php echo (isset($habits_array[$key][0]) && $habits_array[$key][0] == 'Occasional')? 'checked' : null; ?> />&nbsp;&nbsp;Occasional</label> &nbsp;&nbsp;
										<label class="phabit-check" data-row="3" data-main-row="<?php echo $phabitx; ?>"><input type="radio" name="phabit_<?php echo $phabitx; ?>" value="Never" <?php echo (isset($habits_array[$key][0]) && $habits_array[$key][0] == 'Never')? 'checked' : null; ?> />&nbsp;&nbsp;Never</label>
									</p>
									<div class="row phabit-amount-<?php echo $phabitx; ?>" style="display:<?php echo (isset($habits_array[$key][0]) && $habits_array[$key][0] !== 'Never')? 'block' : 'none'; ?>">
										<div class="col-lg-8">
											<input placeholder="Amount" type="text" name="phabit_amount_<?php echo $phabitx; ?>" value="<?php echo (isset($habits_array[$key][1]))? $habits_array[$key][1] : null; ?>" class="form-control" />
										</div>
										<div class="col-lg-4">
											<select name="phabit_time_<?php echo $phabitx; ?>" class="form-control">
												<?php foreach($value_array as $time): ?>
												<option value="<?php echo $time; ?>" <?php echo (isset($habits_array[$key][2]) && $habits_array[$key][2] == $time)? 'selected' : null; ?>><?php echo $time; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<?php if($phabitx > 4): ?>
									<span class="rmv-itm mdi mdi-delete"></span>
									<?php endif; ?>
									<input type="hidden" name="phabit_row[]" value="<?php echo $phabitx; ?>" />
									<input type="hidden" name="phabit_row_name_<?php echo $phabitx; ?>" value="<?php echo $key; ?>" />
								</div>
								<?php 
									$phabitx++;
									endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php 
				$visit_family_history = $this->Visit_model->visit_family_history($visit_id, $patient_id);
				
				$family_array = array();
				foreach($visit_family_history as $key => $new_array)
				{
					$family_array[$new_array['fmhistory_label']] = array($new_array['fmhistory_diabetes'], $new_array['fmhistory_htn'], $new_array['fmhistory_ihd'], $new_array['fmhistory_stroke'], $new_array['fmhistory_amupation']);
				}
			?>
			<div class="panel panel-default block2" id="familyHistory">
				<div class="panel-heading text-center">FAMILY HISTORY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<!--
							<div class="col-lg-12">
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name <input type="text" id="fmdetailsFieldName" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="family-details-add">ADD</span></p>
								</div>
							</div>
							-->
							<?php 
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
										<th>Diabetes</th>
										<th>HTN</th>
										<th>IHD/MI</th>
										<th>Stroke</th>
										<th>Amupation</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$fmhistory = 1;
										foreach($family_history as $key):
									?>
									<tr>
										<td><?php echo $key; ?></td>
										<td style="padding: 0px;">
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<th class="text-center" style="width: 30%;"><label><input type="radio" name="diabetes_radio_<?php echo $fmhistory; ?>" value="1" <?php echo (isset($family_array[$key][0]) && $family_array[$key][0] == '1')? 'checked' : null; ?> /><br />Yes</label></th>
													<th class="text-center" style="width: 23%;"><label><input type="radio" name="diabetes_radio_<?php echo $fmhistory; ?>" value="2" <?php echo (isset($family_array[$key][0]) && $family_array[$key][0] == '2')? 'checked' : null; ?> /><br />No</label></th>
													<th class="text-center"><label><input type="radio" name="diabetes_radio_<?php echo $fmhistory; ?>" value="3" <?php echo (isset($family_array[$key][0]) && $family_array[$key][0] == '3')? 'checked' : null; ?> /><br />Unknown</label></th>
												</tr>
											</table>
										</td>
										<td style="padding: 0px;">
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<th class="text-center" style="width: 30%;"><label><input type="radio" name="htn_radio_<?php echo $fmhistory; ?>" value="1" <?php echo (isset($family_array[$key][1]) && $family_array[$key][1] == '1')? 'checked' : null; ?> /><br />Yes</label></th>
													<th class="text-center" style="width: 23%;"><label><input type="radio" name="htn_radio_<?php echo $fmhistory; ?>" value="2" <?php echo (isset($family_array[$key][1]) && $family_array[$key][1] == '2')? 'checked' : null; ?> /><br />No</label></th>
													<th class="text-center"><label><input type="radio" name="htn_radio_<?php echo $fmhistory; ?>" value="3" <?php echo (isset($family_array[$key][1]) && $family_array[$key][1] == '3')? 'checked' : null; ?> /><br />Unknown</label></th>
												</tr>
											</table>
										</td>
										<td style="padding: 0px;">
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<th class="text-center" style="width: 30%;"><label><input type="radio" name="mi_radio_<?php echo $fmhistory; ?>" value="1" <?php echo (isset($family_array[$key][2]) && $family_array[$key][2] == '1')? 'checked' : null; ?> /><br />Yes</label></th>
													<th class="text-center" style="width: 23%;"><label><input type="radio" name="mi_radio_<?php echo $fmhistory; ?>" value="2" <?php echo (isset($family_array[$key][2]) && $family_array[$key][2] == '2')? 'checked' : null; ?> /><br />No</label></th>
													<th class="text-center"><label><input type="radio" name="mi_radio_<?php echo $fmhistory; ?>" value="3" <?php echo (isset($family_array[$key][2]) && $family_array[$key][2] == '3')? 'checked' : null; ?> /><br />Unknown</label></th>
												</tr>
											</table>
										</td>
										<td style="padding: 0px;">
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<th class="text-center" style="width: 30%;"><label><input type="radio" name="stroke_radio_<?php echo $fmhistory; ?>" value="1" <?php echo (isset($family_array[$key][3]) && $family_array[$key][3] == '1')? 'checked' : null; ?> /><br />Yes</label></th>
													<th class="text-center" style="width: 23%;"><label><input type="radio" name="stroke_radio_<?php echo $fmhistory; ?>" value="2" <?php echo (isset($family_array[$key][3]) && $family_array[$key][3] == '2')? 'checked' : null; ?> /><br />No</label></th>
													<th class="text-center"><label><input type="radio" name="stroke_radio_<?php echo $fmhistory; ?>" value="3" <?php echo (isset($family_array[$key][3]) && $family_array[$key][3] == '3')? 'checked' : null; ?> /><br />Unknown</label></th>
												</tr>
											</table>
										</td>
										<td style="padding: 0px;">
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<th class="text-center" style="width: 30%;"><label><input type="radio" name="amupation_radio_<?php echo $fmhistory; ?>" value="1" <?php echo (isset($family_array[$key][4]) && $family_array[$key][4] == '1')? 'checked' : null; ?> /><br />Yes</label></th>
													<th class="text-center" style="width: 23%;"><label><input type="radio" name="amupation_radio_<?php echo $fmhistory; ?>" value="2" <?php echo (isset($family_array[$key][4]) && $family_array[$key][4] == '2')? 'checked' : null; ?> /><br />No</label></th>
													<th class="text-center"><label><input type="radio" name="amupation_radio_<?php echo $fmhistory; ?>" value="3" <?php echo (isset($family_array[$key][4]) && $family_array[$key][4] == '3')? 'checked' : null; ?> /><br />Unknown</label></th>
												</tr>
											</table>
										</td>
										<input type="hidden" name="fmdetails_row_label_<?php echo $fmhistory; ?>" value="<?php echo $key; ?>" />
										<input type="hidden" name="fmdetails_row[]" value="<?php echo $fmhistory; ?>" />
									</tr>
									<?php 
										$fmhistory++;
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
			  /***********           Visit Previous Advice        *************/
			  /************************************************/
			  
			  $prev_diatory_history = $this->Visit_model->prev_diatory_history($visit_id, $patient_id);
			  
			  
			  /************************************************/
			  /***********         End  Visit Query        *************/
			  /************************************************/
			
			?>
			
			
			<div id="previousAdvice">
			<h2 class="text-left">PREVIOUS ADVICE</h2>
			
			<?php 
				
				$prev_dietary_array = array();
				foreach($prev_diatory_history as $key => $new_array)
				{
					$prev_dietary_array[$new_array['diehist_name']] = array($new_array['diehist_daily'], $new_array['diehist_weekly'], $new_array['diehist_monthly'], $new_array['diehist_calore'], $new_array['diehist_diet_chart']);
				}
			?>
			<input type="hidden" id="preDietaryTotal" value="<?php echo count($prev_dietary_array)+1; ?>" />
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">DIETARY HISTORY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name 
										<select id="prevDiatoryHistroyFieldName"> 
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
							<div id="criteriaIncSix">
								<?php 
									$prev_dietary_row = 1;
									foreach($prev_dietary_array as $key => $new_array):
								?>
								<div class="dietary-hstr put-relative">
									<label class="control-label col-md-2"><strong><?php echo $prev_dietary_row; ?>.</strong> <?php echo $key; ?></label>
									<div class="col-md-2">
										<input type="text" value="<?php echo (isset($new_array[0]))? $new_array[0] : null; ?>" placeholder="Daily" name="prev_diatory_history_daily_<?php echo $prev_dietary_row; ?>" data-imp-val-row="<?php echo $prev_dietary_row; ?>" class="form-control prev-diatory-history-daily" />
									</div>
									<div class="col-lg-2">
										<input type="text" value="<?php echo (isset($new_array[1]))? $new_array[1] : null; ?>" placeholder="Weekly" name="prev_diatory_history_weekly_<?php echo $prev_dietary_row; ?>" data-imp-val-row="<?php echo $prev_dietary_row; ?>" class="form-control prev-diatory-history-weekly prev-diatory-history-weekly-<?php echo $prev_dietary_row; ?>" />
									</div>
									<div class="col-lg-2">
										<input type="text" value="<?php echo (isset($new_array[2]))? $new_array[2] : null; ?>" placeholder="Monthly" name="prev_diatory_history_monthly_<?php echo $prev_dietary_row; ?>" class="form-control prev-diatory-history-monthly-<?php echo $prev_dietary_row; ?>" />
									</div>
									<div class="col-lg-2">
										<input type="text" value="<?php echo (isset($new_array[3]))? $new_array[3] : null; ?>" placeholder="Calorie" name="prev_diatory_history_calorie_<?php echo $prev_dietary_row; ?>" class="form-control" />
									</div>
									<div class="col-lg-2">
										<input type="text" value="<?php echo (isset($new_array[4]))? $new_array[4] : null; ?>" placeholder="Diet Chart" name="prev_diatory_history_diet_<?php echo $prev_dietary_row; ?>" class="form-control" />
									</div>
									<span class="rmv-itm mdi mdi-delete"></span>
									<div style="clear:both"></div>
									<input type="hidden" value="<?php echo $prev_dietary_row; ?>" name="prev_diatory_history_row[]" />
									<input type="hidden" value="<?php echo $key; ?>" name="prev_diatory_history_row_name_<?php echo $prev_dietary_row; ?>" />
								</div>
								<?php 
									$prev_dietary_row++;
									endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<?php 
				$prev_cooking_oils = $this->Visit_model->prev_cooking_oil($visit_id, $patient_id);
				
				$prev_oil_array = array();
				foreach($prev_cooking_oils as $key => $new_array)
				{
					$prev_oil_array[$new_array['cooking_oil_name']] = array($new_array['cooking_oil_has_used'], $new_array['cooking_oil_litr_permonth']);
				}
				
				$prev_cooking_oils = array(
										'Soyebean oil',
										'Mustard oil',
										'Palm oil',
										'Olive oil',
										'Rice bran oil',
										'Coconut oil', 
										'Sunflower oil'
									);
				$array1 = array();
				foreach($prev_oil_array as $key => $new_array)
				{
					$array1[] = $key;
				}
				
				$get_diff = array_diff($array1, $prev_cooking_oils);
				$create_array = array_merge($prev_cooking_oils, $get_diff);
			?>
			<input type="hidden" id="preCookingOilTotal" value="<?php echo count($create_array)+1; ?>" />
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">TYPE OF COOKING OIL</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name <input type="text" id="prevCookingOilFieldName" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="prev-cooking-oil-add">ADD</span></p>
								</div>
							</div>
							<div id="criteriaIncSeven">
								<?php 
									$prev_oil_row = 1;
									foreach($create_array as $key):
								?>
								<div class="col-lg-4" style="height:100px;margin-bottom:15px;">
									<p><strong><?php echo $key; ?>:</strong></p>
									<p>
										<label class="prev-cooking-oil-check" data-row="1" data-main-row="<?php echo $prev_oil_row; ?>"><input type="radio" name="prev_cookoil_<?php echo $prev_oil_row; ?>" value="Yes" <?php echo (isset($prev_oil_array[$key][0]) && $prev_oil_array[$key][0] == 'Yes')? 'checked' : null; ?> />&nbsp;&nbsp;Yes</label> &nbsp;&nbsp;
										<label class="prev-cooking-oil-check" data-row="2" data-main-row="<?php echo $prev_oil_row; ?>"><input type="radio" name="prev_cookoil_<?php echo $prev_oil_row; ?>" value="No" <?php echo (isset($prev_oil_array[$key][0]) && $prev_oil_array[$key][0] == 'No')? 'checked' : null; ?> />&nbsp;&nbsp;No</label> &nbsp;&nbsp;
									</p>
									<p class="prev-cooking-oil-amount-<?php echo $prev_oil_row; ?>" style="display:<?php echo (isset($prev_oil_array[$key][0]) && $prev_oil_array[$key][0] == 'Yes')? 'block' : 'none'; ?>">
										<input placeholder="liters/Month" type="text" name="prev_cookoil_amount_<?php echo $prev_oil_row; ?>" class="form-control" value="<?php echo (isset($prev_oil_array[$key][1]))? $prev_oil_array[$key][1] : null; ?>" />
									</p>
									<input type="hidden" name="prev_cookoil_row[]" value="<?php echo $prev_oil_row; ?>" />
									<input type="hidden" name="prev_cookoil_row_name_<?php echo $prev_oil_row; ?>" value="<?php echo $key; ?>" />
									<?php if($prev_oil_row > 7): ?>
									<span class="rmv-itm mdi mdi-delete"></span>
									<?php endif; ?>
								</div>
								<?php 
									$prev_oil_row++;
									endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<?php 
				$prev_phisical_activities = $this->Visit_model->prev_phisical_activities($visit_id, $patient_id);
				
				$prev_phisical_array = array();
				foreach($prev_phisical_activities as $key => $new_array)
				{
					$prev_phisical_array[$new_array['physical_act_type']] = $new_array['physical_act_duration_a_day'];
				}
			?>
			<input type="hidden" id="prePhisicalActivityTotal" value="<?php echo count($prev_phisical_array)+1; ?>" />
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">PHISICAL ACTIVITY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm">
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
										Duration <input type="number" id="prevPhisicalActivityFieldUnit" placeholder="min/day" />
									&nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="prev-phisical-activity-field-add">ADD</span>
									</p>
								</div>
							</div>
							<div id="criteriaIncEight">
								<?php 
									$prv_phsical = 1;
									foreach($prev_phisical_array as $key => $value):
								?>
								<div class="col-lg-3 put-relative">
									<div style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 80px; padding: 10px;">
										<p><strong><?php echo $key; ?>:</strong></p>
										<p>
											<strong><?php echo $value; ?></strong>
											<input type="hidden" value="<?php echo $value; ?>" name="prev_phisical_acitivity_value_<?php echo $prv_phsical; ?>">
										</p>
										<span class="rmv-itm mdi mdi-delete"></span>
										<input type="hidden" value="<?php echo $prv_phsical; ?>" name="prev_phisical_acitivity_row[]">
										<input type="hidden" value="<?php echo $key; ?>" name="prev_phisical_acitivity_row_name_<?php echo $prv_phsical; ?>">
									</div>
								</div>
								<?php 
									$prv_phsical++;
									endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">MEDICATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						
						<?php 
							$prev_medication_oads = $this->Visit_model->prev_medication_oads($visit_id, $patient_id);
							
							$prev_oads_array = array();
							foreach($prev_medication_oads as $key => $new_array)
							{
								$prev_oads_array[$new_array['oads_name']] = $new_array['oads_dose'];
							}
						?>
						<input type="hidden" id="preMedicationOadsTotal" value="<?php echo count($prev_oads_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>OADs : </strong> &nbsp;&nbsp;<label class="sel-sympt-9" data-value="1"><input type="radio" name="prev_is_oads" value="1" <?php echo (count($prev_oads_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-9" data-value="0"><input type="radio" name="prev_is_oads" value="0" <?php echo (count($prev_oads_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-9" style="display:<?php echo (count($prev_oads_array) !== 0)? 'block' : 'none'; ?>">
								<div id="prevOads">
									<?php 
										$prev_oads = 1;
										if(count($prev_oads_array) !== 0):
										foreach($prev_oads_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="oads_name_<?php echo $prev_oads; ?>" value="<?php echo $key; ?>" placeholder="Add OADs" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="oads_value_<?php echo $prev_oads; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($prev_oads == 1): ?>
										<div class="col-lg-2"><span class="prev-oads-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="oads_row[]" value="<?php echo $prev_oads; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$prev_oads++;
										endforeach; 
										else:
									?>
									<div class="input-row-fields-9" style="display:none">
										<div id="prevOads">
											<div class="row-field">
												<div class="col-lg-3"><input type="text" name="oads_name_1" placeholder="Add OADs" class="form-control load-drugs" /></div>
												<div class="col-lg-3"><input type="text" name="oads_value_1" placeholder="Dose" class="form-control" /></div>
												<div class="col-lg-2"><span class="prev-oads-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
												<input type="hidden" name="oads_row[]" value="1" />
												<div style="clear:both"></div>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$prev_medication_insulins = $this->Visit_model->prev_medication_insulins($visit_id, $patient_id);
							
							$prev_insulins_array = array();
							foreach($prev_medication_insulins as $key => $new_array)
							{
								$prev_insulins_array[$new_array['insulin_name']] = $new_array['insulin_dose'];
							}
						?>
						<input type="hidden" id="preMedicationInsulinTotal" value="<?php echo count($prev_insulins_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Insulin : </strong> &nbsp;&nbsp;<label class="sel-sympt-10" data-value="1"><input type="radio" name="prev_is_insulin" value="1" <?php echo (count($prev_insulins_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-10" data-value="0"><input type="radio" name="prev_is_insulin" value="0" <?php echo (count($prev_insulins_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-10" style="display:<?php echo (count($prev_insulins_array) !== 0)? 'block' : 'none'; ?>">
								<div id="prevInsulin">
									<?php 
										$prev_insulin = 1;
										if(count($prev_insulins_array) !== 0):
										foreach($prev_insulins_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="prev_insulin_name_<?php echo $prev_insulin; ?>" value="<?php echo $key; ?>" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>
										<div class="col-lg-3"><input type="text" name="prev_insulin_value_<?php echo $prev_insulin; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($prev_insulin == 1): ?>
										<div class="col-lg-2"><span class="prev-insulin-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="prev_insulin_row[]" value="<?php echo $prev_insulin; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$prev_insulin++;
										endforeach;
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="prev_insulin_name_1" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>
										<div class="col-lg-3"><input type="text" name="prev_insulin_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="prev-insulin-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="prev_insulin_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$prev_medication_antihtns = $this->Visit_model->prev_medication_antihtns($visit_id, $patient_id);
							
							$prev_antihtns_array = array();
							foreach($prev_medication_antihtns as $key => $new_array)
							{
								$prev_antihtns_array[$new_array['anti_htn_name']] = $new_array['anti_htn_dose'];
							}
						?>
						<input type="hidden" id="preMedicationAntihtnTotal" value="<?php echo count($prev_antihtns_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti HTN : </strong> &nbsp;&nbsp;<label class="sel-sympt-4" data-value="1"><input type="radio" name="prev_is_anti_htn" value="1" <?php echo (count($prev_antihtns_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-4" data-value="0"><input type="radio" name="prev_is_anti_htn" value="0" <?php echo (count($prev_antihtns_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields" style="display:<?php echo (count($prev_antihtns_array) !== 0)? 'block' : 'none'; ?>">
								<div id="antiHtnFields">
									<?php 
										$prev_antihtn = 1;
										if(count($prev_antihtns_array) !== 0):
										foreach($prev_antihtns_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="anti_htn_name_<?php echo $prev_antihtn; ?>" value="<?php echo $key; ?>" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="anti_htn_value_<?php echo $prev_antihtn; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($prev_antihtn == 1): ?>
										<div class="col-lg-2"><span class="htn-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="anti_htn_row[]" value="<?php echo $prev_antihtn; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$prev_antihtn++;
										endforeach;
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="anti_htn_name_1" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="anti_htn_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="htn-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="anti_htn_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$prev_medication_antilipids = $this->Visit_model->prev_medication_antilipids($visit_id, $patient_id);
							
							$prev_antilipids_array = array();
							foreach($prev_medication_antilipids as $key => $new_array)
							{
								$prev_antilipids_array[$new_array['anti_lipid_name']] = $new_array['anti_lipid_dose'];
							}
						?>
						<input type="hidden" id="preMedicationAntilipidsTotal" value="<?php echo count($prev_antilipids_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti lipids : </strong> &nbsp;&nbsp;<label class="sel-sympt-5" data-value="1"><input type="radio" name="prev_is_anti_lipids" value="1" <?php echo (count($prev_antilipids_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-5" data-value="0"><input type="radio" name="prev_is_anti_lipids" value="0" <?php echo (count($prev_antilipids_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-2" style="display:<?php echo (count($prev_antilipids_array) !== 0)? 'block' : 'none'; ?>">
								<div id="antiLipidsFields">
									<?php 
										$prev_antilipids = 1;
										if(count($prev_antilipids_array) !== 0):
										foreach($prev_antilipids_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="lipids_name_<?php echo $prev_antilipids; ?>" value="<?php echo $key; ?>" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="lipids_value_<?php echo $prev_antilipids; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($prev_antilipids == 1): ?>
										<div class="col-lg-2"><span class="lipids-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="lipids_row[]" value="<?php echo $prev_antilipids; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$prev_antilipids++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="lipids_name_1" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="lipids_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="lipids-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="lipids_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$prev_medication_antiplatelets = $this->Visit_model->prev_medication_antiplatelets($visit_id, $patient_id);
							
							$prev_antiplatelets_array = array();
							foreach($prev_medication_antiplatelets as $key => $new_array)
							{
								$prev_antiplatelets_array[$new_array['antiplatelets_name']] = $new_array['antiplatelets_dose'];
							}
						?>
						<input type="hidden" id="preMedicationAntilipletsTotal" value="<?php echo count($prev_antiplatelets_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Antiplatelets : </strong> &nbsp;&nbsp;<label class="sel-sympt-6" data-value="1"><input type="radio" name="prev_is_aspirine" value="1" <?php echo (count($prev_antiplatelets_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-6" data-value="0"><input type="radio" name="prev_is_aspirine" value="0" <?php echo (count($prev_antiplatelets_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-3" style="display:<?php echo (count($prev_antiplatelets_array) !== 0)? 'block' : 'none'; ?>">
								<div id="aspirineFields">
									<?php 
										$prev_antiplatelets = 1;
										if(count($prev_antiplatelets_array) !== 0):
										foreach($prev_antiplatelets_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="aspirine_name_<?php echo $prev_antiplatelets; ?>" value="<?php echo $key; ?>" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="aspirine_value_<?php echo $prev_antiplatelets; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($prev_antiplatelets == 1): ?>
										<div class="col-lg-2"><span class="aspirine-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="aspirine_row[]" value="<?php echo $prev_antiplatelets; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$prev_antiplatelets++;
										endforeach;
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="aspirine_name_1" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="aspirine_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="aspirine-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="aspirine_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$prev_medication_cardiacmedications = $this->Visit_model->prev_medication_cardiacmedications($visit_id, $patient_id);
							
							$prev_cardiacmedications_array = array();
							foreach($prev_medication_cardiacmedications as $key => $new_array)
							{
								$prev_cardiacmedications_array[$new_array['cardiac_medication_name']] = $new_array['cardiac_medication_dose'];
							}
						?>
						<input type="hidden" id="preMedicationCardiacTotal" value="<?php echo count($prev_cardiacmedications_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Cardiac Medication : </strong> &nbsp;&nbsp;<label class="sel-sympt-11" data-value="1"><input type="radio" name="prev_is_cardiac_medication" value="1" <?php echo (count($prev_cardiacmedications_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-11" data-value="0"><input type="radio" name="prev_is_cardiac_medication" value="0" <?php echo (count($prev_cardiacmedications_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-11" style="display:<?php echo (count($prev_cardiacmedications_array) !== 0)? 'block' : 'none'; ?>">
								<div id="prevCardiacMedication">
									<?php 
										$prev_cardiacmedication = 1;
										if(count($prev_cardiacmedications_array) !== 0):
										foreach($prev_cardiacmedications_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="cardiac_medication_name_<?php echo $prev_cardiacmedication; ?>" value="<?php echo $key; ?>" placeholder="Add Cardiac Medication" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="cardiac_medication_value_<?php echo $prev_cardiacmedication; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($prev_cardiacmedication == 1): ?>
										<div class="col-lg-2"><span class="cardiac-medication-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="cardiac_medication_row[]" value="<?php echo $prev_cardiacmedication; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$prev_cardiacmedication++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="cardiac_medication_name_1" placeholder="Add Cardiac Medication" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="cardiac_medication_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cardiac-medication-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="cardiac_medication_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$prev_medication_antiobesities = $this->Visit_model->prev_medication_antiobesities($visit_id, $patient_id);
							
							$prev_antiobesities_array = array();
							foreach($prev_medication_antiobesities as $key => $new_array)
							{
								$prev_antiobesities_array[$new_array['anti_obesity_name']] = $new_array['anti_obesity_dose'];
							}
						?>
						<input type="hidden" id="preMedicationAntiobisityTotal" value="<?php echo count($prev_antiobesities_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-obesity : </strong> &nbsp;&nbsp;<label class="sel-sympt-7" data-value="1"><input type="radio" name="prev_is_anti_obesity" value="1" <?php echo (count($prev_antiobesities_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-7" data-value="0"><input type="radio" name="prev_is_anti_obesity" value="0" <?php echo (count($prev_antiobesities_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-4" style="display:<?php echo (count($prev_antiobesities_array) !== 0)? 'block' : 'none'; ?>">
								<div id="antiObesityFields">
									<?php 
										$prev_antiobesity = 1;
										if(count($prev_antiobesities_array) !== 0):
										foreach($prev_antiobesities_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="obesity_name_<?php echo $prev_antiobesity; ?>" value="<?php echo $key; ?>" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="obesity_value_<?php echo $prev_antiobesity; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($prev_antiobesity == 1): ?>
										<div class="col-lg-2"><span class="obesity-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="obesity_row[]" value="<?php echo $prev_antiobesity; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$prev_antiobesity++;
										endforeach;
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="obesity_name_1" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="obesity_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="obesity-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="obesity_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$prev_medication_others = $this->Visit_model->prev_medication_others($visit_id, $patient_id);
							
							$prev_others_array = array();
							foreach($prev_medication_others as $key => $new_array)
							{
								$prev_others_array[$new_array['other_name']] = $new_array['other_dose'];
							}
						?>
						<input type="hidden" id="preMedicationOthersTotal" value="<?php echo count($prev_others_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Others : </strong> &nbsp;&nbsp;<label class="sel-sympt-8" data-value="1"><input type="radio" name="prev_is_others" value="1" <?php echo (count($prev_others_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-8" data-value="0"><input type="radio" name="prev_is_others" value="0" <?php echo (count($prev_others_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-5" style="display:<?php echo (count($prev_others_array) !== 0)? 'block' : 'none'; ?>">
								<div id="othersFields">
									<?php 
										$prev_others = 1;
										if(count($prev_others_array) !== 0):
										foreach($prev_others_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="other_name_<?php echo $prev_others; ?>" value="<?php echo $key; ?>" placeholder="Add Others" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="other_value_<?php echo $prev_others; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($prev_others == 1): ?>
										<div class="col-lg-2"><span class="other-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="other_row[]" value="<?php echo $prev_others; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$prev_others++;
										endforeach;
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="other_name_1" placeholder="Add Others" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="other_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="other-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="other_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			
			<?php 
		  
			  /************************************************/
			  /***********           Visit Current Advice        *************/
			  /************************************************/
			  
			  $crnt_diatory_history = $this->Visit_model->crnt_diatory_history($visit_id, $patient_id);
			  
			  /************************************************/
			  /***********         End  Visit Query        *************/
			  /************************************************/
			
			?>
			
			<div id="currentAdvice">
			<h2 class="text-left">CURRENT ADVICE</h2>
			
			<?php 
				
				$crnt_dietary_array = array();
				foreach($crnt_diatory_history as $key => $new_array)
				{
					$crnt_dietary_array[$new_array['diehist_name']] = array($new_array['diehist_daily'], $new_array['diehist_weekly'], $new_array['diehist_monthly'], $new_array['diehist_calore'], $new_array['diehist_diet_chart']);
				}
				
			?>
			<input type="hidden" id="crntDietaryTotal" value="<?php echo count($crnt_dietary_array)+1; ?>" />
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">DIETARY HISTORY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name 
										<select id="crntDiatoryHistroyFieldName"> 
											<option value="" selected="selected">Add Food Item</option>
											<?php
												$foods = $this->Visit_model->get_foods();
												foreach($foods as $food):
											?>
											<option value="<?php echo $food['food_title']; ?>"><?php echo $food['food_title']; ?></option>
											<?php endforeach; ?>
										</select>
									&nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="crnt-diatory-history-field-add">ADD</span>
									</p>
								</div>
							</div>
							<div id="crntCriteriaIncOne">
								<?php 
									$crnt_dietary_row = 1;
									foreach($crnt_dietary_array as $key => $new_array):
								?>
								<div class="dietary-hstr put-relative">
									<label class="control-label col-md-2"><strong><?php echo $crnt_dietary_row; ?>.</strong> <?php echo $key; ?></label>
									<div class="col-md-2">
										<input type="text" value="<?php echo (isset($new_array[0]))? $new_array[0] : null; ?>" placeholder="Daily" name="crnt_diatory_history_daily_<?php echo $crnt_dietary_row; ?>" data-imp-val-row="<?php echo $crnt_dietary_row; ?>" class="form-control crnt-diatory-history-daily">
									</div>
									<div class="col-lg-2">
										<input type="text" value="<?php echo (isset($new_array[1]))? $new_array[1] : null; ?>" placeholder="Weekly" name="crnt_diatory_history_weekly_<?php echo $crnt_dietary_row; ?>" data-imp-val-row="<?php echo $crnt_dietary_row; ?>" class="form-control crnt-diatory-history-weekly crnt-diatory-history-weekly-<?php echo $crnt_dietary_row; ?>">
									</div>
									<div class="col-lg-2">
										<input type="text" value="<?php echo (isset($new_array[2]))? $new_array[2] : null; ?>" placeholder="Monthly" name="crnt_diatory_history_monthly_<?php echo $crnt_dietary_row; ?>" class="form-control crnt-diatory-history-monthly-<?php echo $crnt_dietary_row; ?>">
									</div>
									<div class="col-lg-2">
										<input type="text" value="<?php echo (isset($new_array[3]))? $new_array[3] : null; ?>" placeholder="Calorie" name="crnt_diatory_history_calorie_<?php echo $crnt_dietary_row; ?>" class="form-control">
									</div>
									<div class="col-lg-2">
										<input type="text" value="<?php echo (isset($new_array[4]))? $new_array[4] : null; ?>" placeholder="Diet Chart" name="crnt_diatory_history_diet_<?php echo $crnt_dietary_row; ?>" class="form-control">
									</div>
									<span class="rmv-itm mdi mdi-delete"></span>
									<input type="hidden" value="<?php echo $crnt_dietary_row; ?>" name="crnt_diatory_history_row[]">
									<input type="hidden" value="<?php echo $key; ?>" name="crnt_diatory_history_row_name_<?php echo $crnt_dietary_row; ?>">
								</div>
								<?php 
									$crnt_dietary_row++;
									endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php 
				$crnt_cooking_oils = $this->Visit_model->crnt_cooking_oil($visit_id, $patient_id);
				
				$crnt_oil_array = array();
				foreach($crnt_cooking_oils as $key => $new_array)
				{
					$crnt_oil_array[$new_array['cooking_oil_name']] = array($new_array['cooking_oil_has_used'], $new_array['cooking_oil_litr_permonth']);
				}
				$crnt_cooking_oils = array(
											'Soyebean oil',
											'Mustard oil',
											'Palm oil',
											'Olive oil',
											'Rice bran oil',
											'Coconut oil', 
											'Sunflower oil'
										);
				$array1 = array();
				foreach($crnt_oil_array as $key => $new_array)
				{
					$array1[] = $key;
				}
				
				$get_diff = array_diff($array1, $crnt_cooking_oils);
				$create_array = array_merge($crnt_cooking_oils, $get_diff);
			?>
			<input type="hidden" id="crntCookingOilTotal" value="<?php echo count($create_array)+1; ?>" />
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">TYPE OF COOKING OIL</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm" style="padding: 7px 30px;width: 350px;">
									<p class="text-center">Add more criteria</p>
									<p>Name <input type="text" id="crntCookingOilFieldName" /> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="crnt-cooking-oil-add">ADD</span></p>
								</div>
							</div>
							<div id="criteriaIncCrntCooking">
								<?php 
									$crnt_oil_row = 1;
									foreach($create_array as $key):
								?>
								<div class="col-lg-4" style="height:100px;margin-bottom:15px;">
									<p><strong><?php echo $key; ?>:</strong></p>
									<p>
										<label class="crnt-cooking-oil-check" data-row="1" data-main-row="<?php echo $crnt_oil_row; ?>"><input type="radio" name="crnt_cookoil_<?php echo $crnt_oil_row; ?>" value="Yes" <?php echo (isset($crnt_oil_array[$key][0]) && $crnt_oil_array[$key][0] == 'Yes')? 'checked' : null; ?> />&nbsp;&nbsp;Yes</label> &nbsp;&nbsp;
										<label class="crnt-cooking-oil-check" data-row="2" data-main-row="<?php echo $crnt_oil_row; ?>"><input type="radio" name="crnt_cookoil_<?php echo $crnt_oil_row; ?>" value="No" <?php echo (isset($crnt_oil_array[$key][0]) && $crnt_oil_array[$key][0] == 'No')? 'checked' : null; ?> />&nbsp;&nbsp;No</label> &nbsp;&nbsp;
									</p>
									<p class="crnt-cooking-oil-amount-<?php echo $crnt_oil_row; ?>" style="display:<?php echo (isset($crnt_oil_array[$key][0]) && $crnt_oil_array[$key][0] == 'Yes')? 'block' : 'none'; ?>"><input type="text" name="crnt_cookoil_amount_<?php echo $crnt_oil_row; ?>" value="<?php echo (isset($crnt_oil_array[$key][1]))? $crnt_oil_array[$key][1] : null; ?>" placeholder="Liters/Month" class="form-control" /></p>
									<input type="hidden" name="crnt_cookoil_row[]" value="<?php echo $crnt_oil_row; ?>" />
									<input type="hidden" name="crnt_cookoil_row_name_<?php echo $crnt_oil_row; ?>" value="<?php echo $key; ?>" />
									<?php if($crnt_oil_row > 7): ?>
									<span class="rmv-itm mdi mdi-delete"></span>
									<?php endif; ?>
								</div>
								<?php 
									$crnt_oil_row++;
									endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php 
				$crnt_phisical_activities = $this->Visit_model->crnt_phisical_activities($visit_id, $patient_id);
				
				$crnt_phisical_array = array();
				foreach($crnt_phisical_activities as $key => $new_array)
				{
					$crnt_phisical_array[$new_array['physical_act_type']] = $new_array['physical_act_duration_a_day'];
				}
			?>
			<input type="hidden" id="crntPhisicalActivityTotal" value="<?php echo count($crnt_phisical_array)+1; ?>" />
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">PHISICAL ACTIVITY</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="addmr-frm">
									<p class="text-center">Type/Select Acitvity</p>
									<p>Activity 
										<select id="crntPhisicalActivityFieldName"> 
											<option value="" selected="selected">Type/Select Acitvity</option>
											<?php
												$activities = $this->Visit_model->get_physical_activities();
												foreach($activities as $activity):
											?>
											<option value="<?php echo $activity['activity_title']; ?>"><?php echo $activity['activity_title']; ?></option>
											<?php endforeach; ?>
										</select>
										Duration <input type="number" id="crntPhisicalActivityFieldUnit" placeholder="min/day" />
									&nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="crnt-phisical-activity-field-add">ADD</span>
									</p>
								</div>
							</div>
							<div id="criteriaIncCrntPhisicalAct">
								<?php 
									$crnt_phsical = 1;
									foreach($crnt_phisical_array as $key => $value):
								?>
								<div class="col-lg-3 put-relative">
									<div style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 80px; padding: 10px;">
										<p><strong><?php echo $key; ?>:</strong></p>
										<p>
											<strong><?php echo $value; ?></strong>
											<input type="hidden" value="<?php echo $value; ?>" name="crnt_phisical_acitivity_value_<?php echo $crnt_phsical; ?>">
										</p>
										<span class="rmv-itm mdi mdi-delete"></span>
										<input type="hidden" value="<?php echo $crnt_phsical; ?>" name="crnt_phisical_acitivity_row[]">
										<input type="hidden" value="<?php echo $key; ?>" name="crnt_phisical_acitivity_row_name_<?php echo $crnt_phsical; ?>">
									</div>
								</div>
								<?php 
									$crnt_phsical++;
									endforeach; 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php 
				$managements = $this->Visit_model->get_visit_managements($visit_id, $patient_id);
				$visit_exercise = $this->Visit_model->get_visit_exercise($visit_id, $patient_id, $managements['management_id']);
			?>
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">Management</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-md-2"></label>
									<div class="col-md-7">
										<label class="sel-sympt-management"><input type="checkbox" id="mangmntLifeStyle" name="life_style" value="1" <?php echo (isset($managements['management_has_lifestyle']) && $managements['management_has_lifestyle'] == '1')? 'checked' : null; ?> /> Life Style</label> &nbsp;&nbsp; <label><input type="checkbox" name="mangemnt_medication" value="1" <?php echo (isset($managements['management_has_medication']) && $managements['management_has_medication'] == '1')? 'checked' : null; ?> /> Medication</label>
										<div class="management-type-keywords" style="display:<?php echo (isset($managements['management_has_lifestyle']) && $managements['management_has_lifestyle'] == '1')? 'block' : 'none'; ?>">
											<div class="form-group">
												<label class="control-label col-md-5">Diet; Total calorie/Day</label>
												<div class="col-md-7">
													<input type="text" placeholder="Total calorie/Day" name="total_calorie_perday" value="<?php echo (isset($managements['management_calorie_perday']))? $managements['management_calorie_perday'] : null; ?>" class="form-control" />
												</div>
											</div>
											<div class="form-group">
												<input type="hidden" id="exerCiseTotal" value="<?php echo count($visit_exercise)+1; ?>" />
												<label class="control-label col-md-5">Exercise</label>
												<div class="col-md-7">
													<div id="crntExercise">
														<?php 
															$exercise_row = 1;
															if(count($visit_exercise) !== 0):
															foreach($visit_exercise as $exercise):
														?>
														<div class="row-field">
															<div class="col-lg-6"><input type="text" name="crnt_exercise_value_<?php echo $exercise_row; ?>" value="<?php echo $exercise['exercise_method']; ?>" class="form-control" /></div>
															<?php if($exercise_row == 1): ?>
															<div class="col-lg-6"><span class="cntr-exercise-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
															<?php else: ?>
															<div class="col-lg-6"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
															<?php endif; ?>
															<input type="hidden" name="crnt_exercise_row[]" value="<?php echo $exercise_row; ?>" />
															<div style="clear:both"></div>
														</div>
														<?php 
															$exercise_row++;
															endforeach; 
															else:
														?>
														<div class="row-field">
															<div class="col-lg-6"><input type="text" name="crnt_exercise_value_1" class="form-control" /></div>
															<div class="col-lg-6"><span class="cntr-exercise-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
															<input type="hidden" name="crnt_exercise_row[]" value="1" />
															<div style="clear:both"></div>
														</div>
														<?php endif; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">MEDICATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						
						<?php 
							$crnt_medication_oads = $this->Visit_model->crnt_medication_oads($visit_id, $patient_id);
							
							$crnt_oads_array = array();
							foreach($crnt_medication_oads as $key => $new_array)
							{
								$crnt_oads_array[$new_array['oads_name']] = $new_array['oads_dose'];
							}
						?>
						<input type="hidden" id="crntMedicationOadsTotal" value="<?php echo count($crnt_oads_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>OADs : </strong> &nbsp;&nbsp;<label class="sel-sympt-9-cntr" data-value="1"><input type="radio" name="crnt_is_oads" value="1" <?php echo (count($crnt_oads_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-9-cntr" data-value="0"><input type="radio" name="crnt_is_oads" value="0" <?php echo (count($crnt_oads_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-9-cntr" style="display:<?php echo (count($crnt_oads_array) !== 0)? 'block' : 'none'; ?>">
								<div id="crntOads">
									<?php 
										$crnt_oads = 1;
										if(count($crnt_oads_array) !== 0):
										foreach($crnt_oads_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_oads_name_<?php echo $crnt_oads; ?>" value="<?php echo $key; ?>" placeholder="Add OADs" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_oads_value_<?php echo $crnt_oads; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($crnt_oads == 1): ?>
										<div class="col-lg-2"><span class="cntr-oads-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="crnt_oads_row[]" value="<?php echo $crnt_oads; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$crnt_oads++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_oads_name_1" placeholder="Add OADs" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_oads_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cntr-oads-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="crnt_oads_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$crnt_medication_insulins = $this->Visit_model->crnt_medication_insulins($visit_id, $patient_id);
							
							$crnt_insulins_array = array();
							foreach($crnt_medication_insulins as $key => $new_array)
							{
								$crnt_insulins_array[$new_array['insulin_name']] = $new_array['insulin_dose'];
							}
						?>
						<input type="hidden" id="crntMedicationInsulinTotal" value="<?php echo count($crnt_insulins_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Insulin : </strong> &nbsp;&nbsp;<label class="sel-sympt-10-cntr" data-value="1"><input type="radio" name="crnt_is_insulin" value="1" <?php echo (count($crnt_insulins_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-10-cntr" data-value="0"><input type="radio" name="crnt_is_insulin" value="0" <?php echo (count($crnt_insulins_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-10-cntr" style="display:<?php echo (count($crnt_insulins_array) !== 0)? 'block' : 'none'; ?>">
								<div id="crntInsulin">
									<?php 
										$crnt_insulin = 1;
										if(count($crnt_insulins_array) !== 0):
										foreach($crnt_insulins_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_insulin_name_<?php echo $crnt_insulin; ?>" value="<?php echo $key; ?>" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_insulin_value_<?php echo $crnt_insulin; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($crnt_insulin == 1): ?>
										<div class="col-lg-2"><span class="cntr-insulin-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="crnt_insulin_row[]" value="<?php echo $crnt_insulin; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$crnt_insulin++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_insulin_name_1" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_insulin_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cntr-insulin-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="crnt_insulin_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$crnt_medication_antihtns = $this->Visit_model->crnt_medication_antihtns($visit_id, $patient_id);
							
							$crnt_antihtns_array = array();
							foreach($crnt_medication_antihtns as $key => $new_array)
							{
								$crnt_antihtns_array[$new_array['anti_htn_name']] = $new_array['anti_htn_dose'];
							}
						?>
						<input type="hidden" id="crntMedicationAntihtnTotal" value="<?php echo count($crnt_antihtns_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti HTN : </strong> &nbsp;&nbsp;<label class="sel-sympt-4-cntr" data-value="1"><input type="radio" name="crnt_is_anti_htn" value="1" <?php echo (count($crnt_antihtns_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-4-cntr" data-value="0"><input type="radio" name="crnt_is_anti_htn" value="0" <?php echo (count($crnt_antihtns_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-cntr" style="display:<?php echo (count($crnt_antihtns_array) !== 0)? 'block' : 'none'; ?>">
								<div id="antiHtnFieldsCntr">
									<?php 
										$crnt_antihtn = 1;
										if(count($crnt_antihtns_array) !== 0):
										foreach($crnt_antihtns_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_anti_htn_name_<?php echo $crnt_antihtn; ?>" value="<?php echo $key; ?>" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_anti_htn_value_<?php echo $crnt_antihtn; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($crnt_antihtn == 1): ?>
										<div class="col-lg-2"><span class="cntr-htn-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="crnt_anti_htn_row[]" value="<?php echo $crnt_antihtn; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$crnt_antihtn++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_anti_htn_name_1" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_anti_htn_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cntr-htn-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="crnt_anti_htn_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$crnt_medication_antilipids = $this->Visit_model->crnt_medication_antilipids($visit_id, $patient_id);
							
							$crnt_antilipids_array = array();
							foreach($crnt_medication_antilipids as $key => $new_array)
							{
								$crnt_antilipids_array[$new_array['anti_lipid_name']] = $new_array['anti_lipid_dose'];
							}
						?>
						<input type="hidden" id="crntMedicationAntiLipidsTotal" value="<?php echo count($crnt_antilipids_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti lipids : </strong> &nbsp;&nbsp;<label class="sel-sympt-5-cntr" data-value="1"><input type="radio" name="crnt_is_anti_lipids" value="1" <?php echo (count($crnt_antilipids_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-5-cntr" data-value="0"><input type="radio" name="crnt_is_anti_lipids" value="0" <?php echo (count($crnt_antilipids_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-2-cntr" style="display:<?php echo (count($crnt_antilipids_array) !== 0)? 'block' : 'none'; ?>">
								<div id="antiLipidsFieldsCntr">
									<?php 
										$crnt_antilipids = 1;
										if(count($crnt_antilipids_array) !== 0):
										foreach($crnt_antilipids_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_lipids_name_<?php echo $crnt_antilipids; ?>" value="<?php echo $key; ?>" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_lipids_value_<?php echo $crnt_antilipids; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($crnt_antilipids == 1): ?>
										<div class="col-lg-2"><span class="cntr-lipids-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="crnt_lipids_row[]" value="<?php echo $crnt_antilipids; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$crnt_antilipids++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_lipids_name_1" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_lipids_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cntr-lipids-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="crnt_lipids_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$crnt_medication_antiplatelets = $this->Visit_model->crnt_medication_antiplatelets($visit_id, $patient_id);
							
							$crnt_antiplatelets_array = array();
							foreach($crnt_medication_antiplatelets as $key => $new_array)
							{
								$crnt_antiplatelets_array[$new_array['antiplatelets_name']] = $new_array['antiplatelets_dose'];
							}
						?>
						<input type="hidden" id="crntMedicationAntiplateletsTotal" value="<?php echo count($crnt_antiplatelets_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Antiplatelets : </strong> &nbsp;&nbsp;<label class="sel-sympt-6-cntr" data-value="1"><input type="radio" name="crnt_is_aspirine" value="1" <?php echo (count($crnt_antiplatelets_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-6-cntr" data-value="0"><input type="radio" name="crnt_is_aspirine" value="0" <?php echo (count($crnt_antiplatelets_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-3-cntr" style="display:<?php echo (count($crnt_antiplatelets_array) !== 0)? 'block' : 'none'; ?>">
								<div id="aspirineFieldsCntr">
									<?php 
										$crnt_antiplatelets = 1;
										if(count($crnt_antiplatelets_array) !== 0):
										foreach($crnt_antiplatelets_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_aspirine_name_<?php echo $crnt_antiplatelets; ?>" value="<?php echo $key; ?>" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_aspirine_value_<?php echo $crnt_antiplatelets; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($crnt_antiplatelets == 1): ?>
										<div class="col-lg-2"><span class="cntr-aspirine-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="crnt_aspirine_row[]" value="<?php echo $crnt_antiplatelets; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$crnt_antiplatelets++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_aspirine_name_1" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_aspirine_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cntr-aspirine-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="crnt_aspirine_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$crnt_medication_cardiacmedications = $this->Visit_model->crnt_medication_cardiacmedications($visit_id, $patient_id);
							
							$crnt_cardiacmedications_array = array();
							foreach($crnt_medication_cardiacmedications as $key => $new_array)
							{
								$crnt_cardiacmedications_array[$new_array['cardiac_medication_name']] = $new_array['cardiac_medication_dose'];
							}
						?>
						<input type="hidden" id="crntMedicationCardiacTotal" value="<?php echo count($crnt_cardiacmedications_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Cardiac Medication : </strong> &nbsp;&nbsp;<label class="sel-sympt-11-cntr" data-value="1"><input type="radio" name="crnt_is_cardiac_medication" value="1" <?php echo (count($crnt_cardiacmedications_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-11-cntr" data-value="0"><input type="radio" name="crnt_is_cardiac_medication" value="0" <?php echo (count($crnt_cardiacmedications_array) !== 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-11-cntr" style="display:<?php echo (count($crnt_cardiacmedications_array) !== 0)? 'block' : 'none'; ?>">
								<div id="crntCardiacMedication">
									<?php 
										$crnt_cardiacmedications = 1;
										if(count($crnt_cardiacmedications_array) !== 0):
										foreach($crnt_cardiacmedications_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_cardiac_medication_name_<?php echo $crnt_cardiacmedications; ?>" value="<?php echo $key; ?>" placeholder="Add Cardiac Medication" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_cardiac_medication_value_<?php echo $crnt_cardiacmedications; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($crnt_cardiacmedications == 1): ?>
										<div class="col-lg-2"><span class="cntr-cardiac-medication-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="crnt_cardiac_medication_row[]" value="<?php echo $crnt_cardiacmedications; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$crnt_cardiacmedications++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_cardiac_medication_name_1" placeholder="Add Cardiac Medication" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_cardiac_medication_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cntr-cardiac-medication-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="crnt_cardiac_medication_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$crnt_medication_antiobesities = $this->Visit_model->crnt_medication_antiobesities($visit_id, $patient_id);
							
							$crnt_antiobesities_array = array();
							foreach($crnt_medication_antiobesities as $key => $new_array)
							{
								$crnt_antiobesities_array[$new_array['anti_obesity_name']] = $new_array['anti_obesity_dose'];
							}
						?>
						<input type="hidden" id="crntMedicationAntiobisityTotal" value="<?php echo count($crnt_antiobesities_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Anti-obesity : </strong> &nbsp;&nbsp;<label class="sel-sympt-7-cntr" data-value="1"><input type="radio" name="crnt_is_anti_obesity" value="1" <?php echo (count($crnt_antiobesities_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-7-cntr" data-value="0"><input type="radio" name="crnt_is_anti_obesity" value="0" <?php echo (count($crnt_antiobesities_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-4-cntr" style="display:<?php echo (count($crnt_antiobesities_array) !== 0)? 'block' : 'none'; ?>">
								<div id="antiObesityFieldsCntr">
									<?php 
										$crnt_antiobesities = 1;
										if(count($crnt_antiobesities_array) !== 0):
										foreach($crnt_antiobesities_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_obesity_name_<?php echo $crnt_antiobesities; ?>" value="<?php echo $key; ?>" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_obesity_value_<?php echo $crnt_antiobesities; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($crnt_antiobesities == 1): ?>
										<div class="col-lg-2"><span class="cntr-obesity-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="crnt_obesity_row[]" value="<?php echo $crnt_antiobesities; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$crnt_antiobesities++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_obesity_name_1" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_obesity_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cntr-obesity-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="crnt_obesity_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<br />
						
						<?php 
							$crnt_medication_others = $this->Visit_model->crnt_medication_others($visit_id, $patient_id);
							
							$crnt_others_array = array();
							foreach($crnt_medication_others as $key => $new_array)
							{
								$crnt_others_array[$new_array['other_name']] = $new_array['other_dose'];
							}
						?>
						<input type="hidden" id="crntMedicationOthersTotal" value="<?php echo count($crnt_others_array)+1; ?>" />
						<div class="row other-medication-box">
							<div class="col-lg-12">
								<strong>Others : </strong> &nbsp;&nbsp;<label class="sel-sympt-8-cntr" data-value="1"><input type="radio" name="crnt_is_others" value="1" <?php echo (count($crnt_others_array) !== 0)? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-8-cntr" data-value="0"><input type="radio" name="crnt_is_others" value="0" <?php echo (count($crnt_others_array) == 0)? 'checked' : null; ?> /> No</label>
							</div>
							<div class="input-row-fields-5-cntr" style="display:<?php echo (count($crnt_others_array) !== 0)? 'block' : 'none'; ?>">
								<div id="othersFieldsCntr">
									<?php 
										$crnt_others = 1;
										if(count($crnt_others_array) !== 0):
										foreach($crnt_others_array as $key => $value):
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_other_name_<?php echo $crnt_others; ?>" value="<?php echo $key; ?>" placeholder="Add Others" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_other_value_<?php echo $crnt_others; ?>" value="<?php echo $value; ?>" placeholder="Dose" class="form-control" /></div>
										<?php if($crnt_others == 1): ?>
										<div class="col-lg-2"><span class="cntr-other-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<?php else: ?>
										<div class="col-lg-2"><span style="cursor:pointer" class="htn-remove-htn"><i class="mdi mdi-delete"></i> Remove</span></div>
										<?php endif; ?>
										<input type="hidden" name="crnt_other_row[]" value="<?php echo $crnt_others; ?>" />
										<div style="clear:both"></div>
									</div>
									<?php 
										$crnt_others++;
										endforeach; 
										else:
									?>
									<div class="row-field">
										<div class="col-lg-3"><input type="text" name="crnt_other_name_1" placeholder="Add Others" class="form-control load-drugs" /></div>
										<div class="col-lg-3"><input type="text" name="crnt_other_value_1" placeholder="Dose" class="form-control" /></div>
										<div class="col-lg-2"><span class="cntr-other-add-more-htn add-more-bttn" style="cursor:pointer"><i class="mdi mdi-plus"></i> Add More</span></div>
										<input type="hidden" name="crnt_other_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php 
				$visit_diagonosis = $this->Visit_model->visit_diagonosis($visit_id, $patient_id);
			?>
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">Diagonosis</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label col-md-2"></label>
									<div class="col-md-7">
										<strong>Diabetes : </strong> &nbsp;&nbsp;<label class="sel-sympt-diabetes" data-value="1"><input type="radio" name="diabetes_type" value="1" <?php echo (isset($visit_diagonosis['diagonosis_has_diabetes']) && $visit_diagonosis['diagonosis_has_diabetes'] == '1')? 'checked' : null; ?> /> Yes</label> &nbsp;&nbsp; <label class="sel-sympt-diabetes" data-value="0"><input type="radio" name="diabetes_type" value="0" <?php echo (isset($visit_diagonosis['diagonosis_has_diabetes']) && $visit_diagonosis['diagonosis_has_diabetes'] == '0')? 'checked' : null; ?> /> No</label>
										
										<?php 
											$diabetes_array1 = array('[', ']', '"', '\/');
											$diabetes_array2 = array('', '', '', '');
											$diabetes_array = str_replace($diabetes_array1, $diabetes_array2, $visit_diagonosis['diagonosis_diabetes_types']);
											$diabetes_array = explode(',', $diabetes_array);
										?>
										<div class="diabetes-type-keywords" style="display:<?php echo (isset($visit_diagonosis['diagonosis_has_diabetes']) && $visit_diagonosis['diagonosis_has_diabetes'] == '1')? 'block' : 'none'; ?>">
											<label><input type="checkbox" name="diabetes_keywords[]" value="Type 1 DM" <?php echo (in_array('Type 1 DM', $diabetes_array))? 'checked' : null; ?> />&nbsp;&nbsp; Type 1 DM </label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label><input type="checkbox" name="diabetes_keywords[]" value="Type 2 DM" <?php echo (in_array('Type 2 DM', $diabetes_array))? 'checked' : null; ?> />&nbsp;&nbsp; Type 2 DM </label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label><input type="checkbox" name="diabetes_keywords[]" value="IGT/IFG" <?php echo (in_array('IGTIFG', $diabetes_array))? 'checked' : null; ?> />&nbsp;&nbsp; IGT/IFG </label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label><input type="checkbox" name="diabetes_keywords[]" value="GDM" <?php echo (in_array('GDM', $diabetes_array))? 'checked' : null; ?> />&nbsp;&nbsp; GDM</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<?php 
				$payment_config = $this->Visit_model->get_config();
				$visit_payments = $this->Visit_model->get_visit_payments($visit_id, $patient_id);
			?>
			<div class="panel panel-default block2" id="paymentInformation">
				<div class="panel-heading text-center">Payment</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<div class="col-md-12 text-center">
										<label class="sel-sympt-payment">Electronic Follow Up Fee (BDT <?php echo ($payment_config['config_option_two'])? $payment_config['config_option_two'] : 0; ?>)</label>
										<div class="payment-type-keywords">
											<div style="height:100px;margin-bottom:15px;" class="col-lg-12 text-center">
												<p><strong>Payment Status:</strong></p>
												<p>
													<input type="hidden" name="fee_amount" value="<?php echo $visit_payments['payment_patient_fee_amount']; ?>" />
													<label><input type="radio" value="1" name="payment" <?php echo ($visit_payments['payment_patient_status'] == '1')? 'checked' : null; ?> />&nbsp;&nbsp;Paid</label> &nbsp;&nbsp;
													<label><input type="radio" value="0" name="payment" <?php echo ($visit_payments['payment_patient_status'] == '0')? 'checked' : null; ?> />&nbsp;&nbsp;Unpaid</label> &nbsp;&nbsp;
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2" style="padding:0">
			<div class="sticky-sidebar" style="width:225px;">
				<ul id="stickyNavSection">
					<li class="active"><a href="#visitDetails">Visit Details</a></li>
					<li><a href="#diabetesHistory">Diabetes History</a></li>
					<li><a href="#generalExamination">General Examination</a></li>
					<li><a href="#laboratoryInvestigation">Laboratory Investigation</a></li>
					<li><a href="#complicationComorbidity">Complication / Comorbidity</a></li>
					<li><a href="#personalHabits">Personal Habits</a></li>
					<li><a href="#familyHistory">Family History</a></li>
					<li><a href="#previousAdvice">Previous Advice</a></li>
					<li><a href="#currentAdvice">Current Advice</a></li>
					<li><a href="#paymentInformation">Payment</a></li>
				</ul>
				
				<ul class="submit-ul">
					<input type="hidden" id="chkRdr" name="submitType" />
					<li><button type="submit" class="check-save submit-type" data-save-method="save">Save</button></li>
					<li><button type="submit" class="check-save submit-type" data-save-method="saveexit">Save & Exit</button></li>
					<li><span class="check-save" onclick="window.location.href='<?php echo base_url('patients/visit/all/'.$patient_id.'/'.$patient_entry_id); ?>'">Cancel</span></li>
				</ul>
			</div>
		</div>
		<?php echo form_close(); ?>
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
			
			$(document).on('click', '.sel-sympt-diabetes', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '0')
				{
					$('.diabetes-type-keywords').hide();
					$('.diabetes-type-keywords').find('input:checkbox').prop("checked", false);
				}else if(check_val == '1')
				{
					$('.diabetes-type-keywords').show();
				}else
				{
					$('.diabetes-type-keywords').hide();
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
			var row = $('#generalExaminationTotal').val();
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = $('#labInvestigationTotal').val();
			$(document).on('click', '.lab-investigation', function(){
				var inp_name = $('#labInvestigationName').val();
				var inp_value = $('#labInvestigationUnit').val();
				
				if(inp_name !== '' && inp_value !== '')
				{
					var content = '<div class="col-lg-4 laboratory-investigation put-relative">' +
									'<div class="form-group">' +
										'<label class="control-label col-md-5">'+inp_name+'</label>' +
										'<div class="col-md-7">' +
											'<input type="text" class="form-control" name="labinv_row_value_'+row+'" placeholder="'+inp_value+'" />' +
										'</div>' +
									'</div>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<input type="hidden" name="labinv_row[]" value="'+row+'" />' +
									'<input type="hidden" name="labinv_row_name_'+row+'" value="'+inp_name+'" />' +
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
			var row = $('#complicationTotal').val();
			$(document).on('click', '.complication-add', function(){
				var inp_name = $('#complicationName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4 complication-comorbidity put-relative">' +
										'<label><input type="checkbox" name="complication_'+row+'" value="'+inp_name+'">&nbsp;&nbsp;'+inp_name+'</label>' +
										'<input type="hidden" value="'+row+'" name="complication_row[]">' +
										'<span class="rmv-itm mdi mdi-delete"></span>' +
									'</div>';	
					$('#criteriaIncThree').append(content);
					$('#complicationName').val('');
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
			var row = $('#acuteComplicationTotal').val();
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
			var row = $('#personalHabitsTotal').val();
			$(document).on('click', '.phabit-add', function(){
				var inp_name = $('#phabitFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4 personal-habits put-relative" style="height:100px;margin-bottom:15px;">' +
									'<p><strong>'+inp_name+':</strong></p>' +
									'<p>' +
										'<label class="phabit-check" data-row="1" data-main-row="'+row+'"><input type="radio" name="phabit_'+row+'" value="Regular"/>&nbsp;&nbsp;Regular</label> &nbsp;&nbsp;' +
										'<label class="phabit-check" data-row="2" data-main-row="'+row+'"><input type="radio" name="phabit_'+row+'" value="Occasional" />&nbsp;&nbsp;Occasional</label> &nbsp;&nbsp;' +
										'<label class="phabit-check" data-row="3" data-main-row="'+row+'"><input type="radio" name="phabit_'+row+'" value="Never" />&nbsp;&nbsp;Never</label>' +
									'</p>' +
									'<div class="row phabit-amount-'+row+'" style="display:none">' +
										'<div class="col-lg-8">' +
											'<input placeholder="Amount" type="text" name="phabit_amount_'+row+'" class="form-control" />' +
										'</div>' +
										'<div class="col-lg-4">' +
											'<select name="phabit_time_'+row+'" class="form-control">' +
												'<option value="day">Day</option>' +
												'<option value="Week">Week</option>' +
												'<option value="Month">Month</option>' +
											'</select>' +
										'</div>' +
									'</div>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<input type="hidden" name="phabit_row[]" value="'+row+'" />' +
									'<input type="hidden" name="phabit_row_name_'+row+'" value="'+inp_name+'" />' +
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
			var row = $('#preDietaryTotal').val();
			$(document).on('click', '.prev-diatory-history-field-add', function(){
				var inp_name = $("select#prevDiatoryHistroyFieldName option").filter(":selected").val();
				if(inp_name !== '')
				{
					var content = '<div class="dietary-hstr put-relative">' +
									'<label class="control-label col-md-2"><strong>'+row+'.</strong> '+inp_name+'</label>' +
									'<div class="col-md-2">' +
										'<input type="text" class="form-control prev-diatory-history-daily" data-imp-val-row="'+row+'" name="prev_diatory_history_daily_'+row+'" placeholder="Daily" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control prev-diatory-history-weekly prev-diatory-history-weekly-'+row+'" data-imp-val-row="'+row+'" name="prev_diatory_history_weekly_'+row+'" placeholder="Weekly" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control prev-diatory-history-monthly-'+row+'" name="prev_diatory_history_monthly_'+row+'" placeholder="Monthly" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control" name="prev_diatory_history_calorie_'+row+'" placeholder="Calorie" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control" name="prev_diatory_history_diet_'+row+'" placeholder="Diet Chart" />' +
									'</div>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<div style="clear:both"></div>' +
									'<input type="hidden" name="prev_diatory_history_row[]" value="'+row+'" />' +
									'<input type="hidden" name="prev_diatory_history_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#criteriaIncSix').append(content);
					$('#prevDiatoryHistroyFieldName').val('');
					row++;
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
			var row = $('#crntDietaryTotal').val();
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
			var row = $('#preCookingOilTotal').val();
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
			var row = $('#crntCookingOilTotal').val();
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
			var row = $('#prePhisicalActivityTotal').val();
			$(document).on('click', '.prev-phisical-activity-field-add', function(){
				var inp_name = $("select#prevPhisicalActivityFieldName option").filter(":selected").val();
				var inp_value = $("#prevPhisicalActivityFieldUnit").val();
				if(inp_name !== '' && inp_value !== '')
				{
					var content = '<div class="col-lg-3 put-relative">' +
										'<div style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 80px; padding: 10px;">' +
											'<p><strong>'+inp_name+':</strong></p>' +
											'<p>' +
												'<strong>'+inp_value+' min/day</strong>' +
												'<input type="hidden" name="prev_phisical_acitivity_value_'+row+'" value="'+inp_value+' min/day" />' +
											'</p>' +
											'<span class="rmv-itm mdi mdi-delete"></span>' +
											'<input type="hidden" name="prev_phisical_acitivity_row[]" value="'+row+'" />' +
											'<input type="hidden" name="prev_phisical_acitivity_row_name_'+row+'" value="'+inp_name+'" />' +
										'</div>' +
									'</div>';	
					$('#criteriaIncEight').append(content);
					$('#prevPhisicalActivityFieldName').val('');
					$('#prevPhisicalActivityFieldUnit').val('');
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
			var row = $('#crntPhisicalActivityTotal').val();
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
			if($('#preMedicationOadsTotal').val() !== '1')
			{
				var row = $('#preMedicationOadsTotal').val();
			}else
			{
				var row = 2;
			}
			$(document).on('click', '.prev-oads-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="oads_name_'+row+'" placeholder="Add OADs" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="oads_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#preMedicationInsulinTotal').val() !== '1')
			{
				var row = $('#preMedicationInsulinTotal').val();
			}else
			{
				var row = 2;
			}
			$(document).on('click', '.prev-insulin-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="prev_insulin_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>' +
									'<div class="col-lg-3"><input type="text" name="prev_insulin_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#preMedicationAntihtnTotal').val() !== '1')
			{
				var row = $('#preMedicationAntihtnTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.htn-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="anti_htn_name_'+row+'" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="anti_htn_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#preMedicationAntilipidsTotal').val() !== '1')
			{
				var row = $('#preMedicationAntilipidsTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.lipids-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="lipids_name_'+row+'" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="lipids_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#preMedicationAntilipletsTotal').val() !== '1')
			{
				var row = $('#preMedicationAntilipletsTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.aspirine-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="aspirine_name_'+row+'" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="aspirine_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">	
		$(document).ready(function(){
			if($('#preMedicationCardiacTotal').val() !== '1')
			{
				var row = $('#preMedicationCardiacTotal').val();
			}else
			{
				var row = 2;
			}
			
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#preMedicationAntiobisityTotal').val() !== '1')
			{
				var row = $('#preMedicationAntiobisityTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.obesity-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="obesity_name_'+row+'" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="obesity_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#preMedicationOthersTotal').val() !== '1')
			{
				var row = $('#preMedicationOthersTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.other-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="other_name_'+row+'" placeholder="Add Others" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="other_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
			if($('#crntMedicationOadsTotal').val() !== '1')
			{
				var row = $('#crntMedicationOadsTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.cntr-oads-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_oads_name_'+row+'" placeholder="Add OADs" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_oads_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#exerCiseTotal').val() !== '1')
			{
				var row = $('#exerCiseTotal').val();
			}else
			{
				var row = 2;
			}
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#crntMedicationInsulinTotal').val() !== '1')
			{
				var row = $('#crntMedicationInsulinTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.cntr-insulin-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_insulin_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_insulin_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#crntMedicationCardiacTotal').val() !== '1')
			{
				var row = $('#crntMedicationCardiacTotal').val();
			}else
			{
				var row = 2;
			}
			
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#crntMedicationAntihtnTotal').val() !== '1')
			{
				var row = $('#crntMedicationAntihtnTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.cntr-htn-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_anti_htn_name_'+row+'" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_anti_htn_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#crntMedicationAntiLipidsTotal').val() !== '1')
			{
				var row = $('#crntMedicationAntiLipidsTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.cntr-lipids-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_lipids_name_'+row+'" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_lipids_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#crntMedicationAntiplateletsTotal').val() !== '1')
			{
				var row = $('#crntMedicationAntiplateletsTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.cntr-aspirine-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_aspirine_name_'+row+'" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_aspirine_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#crntMedicationAntiobisityTotal').val() !== '1')
			{
				var row = $('#crntMedicationAntiobisityTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.cntr-obesity-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_obesity_name_'+row+'" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_obesity_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#crntMedicationOthersTotal').val() !== '1')
			{
				var row = $('#crntMedicationOthersTotal').val();
			}else
			{
				var row = 2;
			}
			
			$(document).on('click', '.cntr-other-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_other_name_'+row+'" placeholder="Add Others" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_other_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
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
			$(document).on('click', '.submit-type', function(){
				var submit_type = $(this).attr('data-save-method');
				if(submit_type == 'save')
				{
					$('#chkRdr').val(1);
				}else if(submit_type == 'saveexit')
				{
					$('#chkRdr').val(0);
				}
				
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
					},
					submitHandler : function () {
						$('#visitLoader').show();
						// your function if, validate is success
						$.ajax({
							type : "POST",
							url : baseUrl + "patients/visit/update",
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
										window.location.href=baseUrl+'patients/visit/all/<?php echo $patient_id; ?>/<?php echo $patient_entry_id; ?>';
									}
									return false;
								}else if(data.status == "error"){
									$('html, body').animate({
										scrollTop: $("body").offset().top
									 }, 1000);
									$('#alert').html(data.error);
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									$('#visitLoader').hide();
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
			$('#regCenter').autocomplete({
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
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			//load visit center
			$('#visitCenter').autocomplete({
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
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			//Load doctor list
			$('#toDoctor').autocomplete({
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
<?php require_once APPPATH.'modules/common/footer.php' ?>