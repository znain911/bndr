<?php require_once APPPATH.'modules/common/header.php' ?>
<div id="visitLoader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
<input type="submit" value="Scan QR Code" onclick="myFunction()" data-toggle="modal" data-target=".scan"  id = "" class = ' qr-gn-scan'  style = '    background-color: #3c4451;color: white;    margin-left: 1%;margin-top: 2%'>
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
		<?php 
			$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm', 'style' => 'padding:0 1%;','enctype' => 'multipart/form-data');
			
			echo form_open('', $attr);
		?>
		<?php 
			$patientinfo = $this->Progress_model->get_patientinfo($patient_id);
		?>
		<?php 
		// if($this->session->userdata('user_type') === 'Doctor'):
			// $ipaddress = '';
			// if (isset($_SERVER['HTTP_CLIENT_IP']))
				// $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			// else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				// $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			// else if(isset($_SERVER['HTTP_X_FORWARDED']))
				// $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			// else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				// $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			// else if(isset($_SERVER['HTTP_FORWARDED']))
				// $ipaddress = $_SERVER['HTTP_FORWARDED'];
			// else if(isset($_SERVER['REMOTE_ADDR']))
				// $ipaddress = $_SERVER['REMOTE_ADDR'];
			// else
				// $ipaddress = 'UNKNOWN';
			//echo $ipaddress;
			// $doc_name= $this->session->userdata('full_name') ;
			// $ip = $this->Progress_model->get_ip($doc_name);
			// if($ip['doctor_login_ip'] !== $ipaddress){
				
				// $this->session->sess_destroy();
				// redirect('login/type/user',refresh);
			// }
		// endif;
		
		// $container = $_SERVER['HTTP_USER_AGENT'];
		// echo $container;
		
		//$arp =`arp -a`;
		//$lines = explode("\n", $arp);
		//print_r($lines[1]);
		//$cols = preg_split('/\s+/', trim($lines[3]));
		//print_r($cols);
		
	//$this->session->sess_destroy();?>
	
	<div  style = "position: sticky;top: 0.8%;width: 100%;z-index: 1; margin-top: 2%;" class="navbar-default sidebar color" role="navigation">
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
				<div class="col-sm-4" id ="nst" >
					<ul class="nav" id="side-menu ">
						<input type="hidden" id="chkRdr" name="submitType" />
						<li  class="dhp dhpm"><span style = "cursor: pointer;" class="check-save" data-save-method="save" data-toggle="modal" data-target=".bs-example-modal-sm">Save & Preview</span></li>
						<li  class="dhp dhpm"><span style = "cursor: pointer;" class="check-save" data-save-method="saveexit" data-toggle="modal" data-target=".bs-example-modal-sm">Exit</span></li>
						<li  class="dhp dhpm"><span style = "cursor: pointer;" class="check-save" onclick="window.location.href='<?php echo base_url('administrator/dashboard'); ?>'">Cancel</span></li>

					</ul>
				</div>
				
				
			</div>
			
		</div>
	</div>
	
	
	
	<!-- sample modal content -->
		<?php $payment_config = $this->Progress_model->get_config(); ?>
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
	
	
	
	<div class ="container-fluid visitContainer">
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
						<p style="display: inline-block;margin: 0px;font-weight: bold;"><?php 
						if ($height){
						echo $height['height'];
						}?></P>
					</div>
					
					<div class = "" >
						<h4 style="display: inline-block;margin: 0px;">Weight :- </h4>
						<p style="display: inline-block;margin: 0px;font-weight: bold;"><?php 
						if ($weight){
						echo $weight['weight'];
						}?></P>
					</div>
					
					<div class = "" >
						<h4 style="display: inline-block;margin: 0px;">Blood pressure :- </h4>
						<p style="display: inline-block;margin: 0px;font-weight: bold;"><?php 
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
					<?php if(has_no_case_history($patient_id)): ?>
					<div class = "col-sm-12" style = "margin-top: 2%;" >
					<a href="<?php echo base_url('patients/visit/add/'.$patient_id.'/'.$patient_entry_id); ?>"
					style="margin-left: 2%;color: #FFF;font-size:14px;background:#707CC7;border: 1px solid #707cd2;border-radius: 3px;padding:6px 12px;">
					ADD CASE HISTORY </a>
					
					</div>
					<?php endif; ?>
					<div class = "col-sm-12" >
						<div class="col-sm-8" >
							<h3 style="display: inline-block;font-weight: bold;">Progress Report </h3>
							<?php $doctor_center_name = $this->session->userdata('user_org_center_name');
							$doctor_center_id = $this->session->userdata('user_org_center_id');
							
							
							
							?>
							<input type="hidden" name="visit_center_name" class="form-control src-visit-center" value="<?php echo ($doctor_center_name !== null)? $doctor_center_name : null; ?>" readonly />
							<input type="hidden" name="visit_center_id" id="hiddenVisitCenterId" value="<?php echo ($doctor_center_id !== null)? $doctor_center_id : null; ?>" readonly />
							<input type="hidden" name="registration_center_name" class="form-control src-registration-center" value="<?php echo ($patientinfo['orgcenter_name'])? $patientinfo['orgcenter_name'] : null; ?>" readonly />
							<input type="hidden" name="registration_center_id" id="hiddenRegistrationCenterId" value="<?php echo ($patientinfo['patient_org_centerid'])? $patientinfo['patient_org_centerid'] : null; ?>" readonly />
							<input type="hidden" name="visit_patient" value="<?php echo $patient_id; ?>" readonly />
							<input type="hidden" name="visit_patient_bndr_ID" value="<?php echo $patientinfo['patient_entryid']; ?>" readonly />
							<input type="hidden" name="visit_patient_phone" value="<?php echo $patientinfo['patient_phone']; ?>" readonly />
						</div>
						<div class="col-sm-1" >
							<label style="margin-top: 10px;" class="">Date:<span style="color:#f00">*</span></label>
						</div>
						<div class="col-sm-3" >
							<input  type="text" style = "font-size: 20px;" name="visit_date" value="<?php echo date("d/m/Y"); ?>"  placeholder="DD/MM/YYYY" class="form-control datepicker check-date-is-valid">
						</div>
					</div>
					
					<div class = "col-sm-12 padding" style= 'height: 70px' >
						<div class="col-sm-1 padding"  >
							<label style="margin-top: 10px;" class="">Name:</label>
						</div>
						<div class="col-sm-8 padding" >
							<input  type="text" name="" style = 'height: 50px;font-size: 20px;' value ="<?php echo $patientinfo['patient_name']; ?>"  class="form-control" readonly>
						</div>
						<div class="col-sm-1 padding" >
							<label style="margin-top: 10px;" class="">Age:</label>
						</div>
						<div class="col-sm-2 padding" >
							<?php if($patientinfo['patient_dateof_birth']):
							 
							  $today = date("Y-m-d");
							  $diff = date_diff(date_create($patientinfo['patient_dateof_birth']), date_create($today));
  
							?>
							<input  type="text" name="" style = 'height: 50px;font-size: 20px;' value ="<?php echo $diff->format('%y'); ?>"  class="form-control" readonly>
							<?php else:?>
							<input  type="text" style = 'height: 50px' id="patientAge" name="age" placeholder="Insert age"  class="form-control" >
							<input type="hidden" id="dateOfBirth" name="dateof_birth" placeholder="" class="form-control">
							<?php endif;?>
							
						</div>
					</div>
					
					<div class = "col-sm-12 padding" style= 'height: 70px'>
						<div class="col-sm-2 padding" style=" width: 12%;" >
							<label style="margin-top: 10px;" class="">Mobile No:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 30%;">
							<input  type="number" style = 'height: 50px;font-size: 20px;' name="" value ="<?php echo $patientinfo['patient_phone']; ?>"  class="form-control" readonly>
						</div>
						<div class="col-sm-2 padding" style=" width: 12%;" >
							<label style="margin-top: 10px;" class="">National ID:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 38%;">
						<?php if($patientinfo['patient_nid']):?>
							<input  type="number" style = 'height: 50px;font-size: 20px;' name="" value ="<?php echo $patientinfo['patient_nid']; ?>"  class="form-control" readonly>
						<?php else:?>
							<input  type="number" style = 'height: 50px;font-size: 20px;' name="nid" placeholder="Insert NID number" class="form-control" >
						<?php endif;?>
						</div>
					</div>
					
					<div class = "col-sm-12 padding" style= 'height: 70px'>
						<div class="col-sm-2 padding" style=" width: 20%;" >
							<label style="margin-top: 10px;" class="">Previous Center ID:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 25%;">
							<input  type="text" style = 'height: 50px;font-size: 20px;' name="" value ="<?php echo $patientinfo['patient_idby_center']; ?>"  class="form-control" readonly>
						</div>
						<div class="col-sm-1 padding" style=" width: 10%;"  >
							<label style="margin-top: 10px;" class="">BNDR ID:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 42%;">
							<input  type="text" style = 'height: 50px;font-size: 20px;' name="" value ="<?php echo $patientinfo['patient_entryid']; ?>"  class="form-control" readonly>
						</div>
					</div>
					<div class = "col-sm-12 padding" style= 'height: 70px'>
						<div class="col-sm-1 padding "  >
							<label style="margin-top: 10px;" class="">Address:</label>
						</div>
						<div class="col-sm-10" >
							<?php if($patientinfo['patient_address']):?>
							<input  type="text" style = 'height: 50px' name="" value ="<?php echo $patientinfo['patient_address']; ?>"  class="form-control" readonly>
							<?php else:?>
							<input  type="text" style = 'height: 50px' name="address"  placeholder="Insert address" class="form-control" >
							<?php endif;?>
						</div>
						
					</div>
					<div class = "col-sm-12 padding" style= 'height: 70px'>
						
						<div class="col-sm-3 padding" style=""  >
							<label style="margin-top: 10px;" class="">Guide Book Number:</label>
						</div>
						<div class="col-sm-4 padding" style=" width: 42%;">
							<input  type="text" style = 'height: 50px;font-size: 20px;' name="" value ="<?php echo $patientinfo['patient_guide_book']; ?>"  class="form-control" readonly>
						</div>
					</div>
					<!-- <input type="file" accept=".jpg,.jpeg" style="position:static !important;opacity:1 !important;" name="slip" /> -->
					
					<div class = "col-sm-12 padding" style= 'height: 70px' >
						<?php if ($patientinfo['patient_gender'] === '1' || $patientinfo['patient_gender'] === '2' || $patientinfo['patient_gender'] === '0'):?>
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
						<?php else:?>
						<div class="col-sm-1 padding"  style=" width: 13%;">
							<input type="radio" id="male" name="gender" value="0">
  							<label for="html">Male</label><br>
						</div>
						<div class="col-sm-2 padding"  style=" width: 14%;">
							<input type="radio" id="female" name="gender" value="1">
  							<label for="html">Female</label><br>
						</div>
						
						<div class="col-sm-2 padding"  style=" width: 14%;">
							<input type="radio" id="others" name="gender" value="2">
  							<label for="html">Others</label><br>
						</div>
						<?php endif;?>
						
						<div class="col-sm-1"  >
							<p>|</p>
						</div>
						<?php if ($patientinfo['patient_marital_status'] === 'Married' || $patientinfo['patient_marital_status'] === 'Unmarried' || $patientinfo['patient_marital_status'] === 'Other'):?>
						<div class="col-sm-5"  >
							<p style="font-size: 20px;"><strong>Marital Status : </strong> <?php echo $patientinfo['patient_marital_status']; ?></p>
						</div>
						<?php else:?>
						<div class="col-sm-2 padding"  >
							<input type="radio" id="married" name="marital_info" value="Married">
  							<label class = "ms" for="html">Married</label><br>
						</div>
						
						<div class="col-sm-2 padding"  >
							<input type="radio" id="unmarried" name="marital_info" value="Unmarried">
  							<label class = "ms" for="html">Unmarried</label><br>
						</div>
						
						<div class="col-sm-2 padding" id ="diabetesHistory"  >
							<input type="radio" id="others" name="marital_info" value="Other">
  							<label class = "ms" for="html">Other</label><br>
						</div>
						<?php endif;?>
						
						
					</div>
					
					
					<!-- Basic INfo end-->
					<!--Complication Start-->
					<div class = "col-sm-12" >
						<div class="col-sm-8" >
							<h4 style="display: inline-block;font-weight: bold;">COMPLICATION / COMORBIDITY </h4>
						</div>
						
					</div>
					
					<div class = "col-sm-12 " style= 'height: 30px'>
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_1" value="CAD">
  							<label for="CAD">CAD</label><br>
							<input type="hidden" name="complication_row[]" value="1" />
						</div>
						
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_2" value="Hypertension">
  							<label for="Hypertension">Hypertension</label><br>
							<input type="hidden" name="complication_row[]" value="2" />
						</div>
						
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_3" value="Nephropathy">
  							<label for="Nephropathy">Nephropathy</label><br>
							<input type="hidden" name="complication_row[]" value="3" />
						</div>
						
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_4" value="Skin Disease">
  							<label for="skin">Skin Disease</label><br>
							<input type="hidden" name="complication_row[]" value="4" />
						</div>
						
						
					</div>
					
					<div class = "col-sm-12  " style= 'height: 30px'>
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_5" value="DKA">
  							<label for="DKA">DKA</label><br>
							<input type="hidden" name="complication_row[]" value="5" />
						</div>
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_6" value="Stroke">
  							<label for="Stroke">Stroke</label><br>
							<input type="hidden" name="complication_row[]" value="6" />
						</div>
						
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_7" value="Dyslipidaemia">
  							<label for="Dyslipidaemia">Dyslipidaemia</label><br>
							<input type="hidden" name="complication_row[]" value="7" />
						</div>
						
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_8" value="Retinopathy">
  							<label for="Retinopathy">Retinopathy</label><br>
							<input type="hidden" name="complication_row[]" value="8" />
						</div>
						
						
					</div>
					
					<div class = "col-sm-12 " style= 'height: 30px' >
						<div class="col-sm-6 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_9" value="gastro">
  							<label for="gastro">Gastro Complications</label><br>
							<input type="hidden" name="complication_row[]" value="9" />
						</div>
						
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_10" value="HHS">
  							<label for="HHS">HHS</label><br>
							<input type="hidden" name="complication_row[]" value="10" />
						</div>
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_11" value="PVD">
  							<label for="PVD">PVD</label><br>
							<input type="hidden" name="complication_row[]" value="11" />
						</div>
						
						
						
						
					</div>
					<div class = "col-sm-12 " style= 'height: 30px'>
						<div class="col-sm-6 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_12" value="Foot">
  							<label  for="Foot">Foot Complications</label><br>
							<input type="hidden" name="complication_row[]" value="12" />
						</div>
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_13" value="Neuropathy">
  							<label for="Neuropathy">Neuropathy</label><br>
							<input type="hidden" name="complication_row[]" value="13" />
						</div>
						
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox"  name="complication_14" value="Hypoglycaemia">
  							<label for="Hypoglycaemia">Hypoglycaemia</label><br>
							<input type="hidden" name="complication_row[]" value="14" />
						</div>
						
						
					</div>
					<div class = "col-sm-12 " style= 'height: 30px'>
						<div class="col-sm-3 padding complication-comorbidity-rows" >
							<input type="checkbox" name="complication_15" value="Others">
  							<label for="Others">Others</label><br>
							<input type="hidden" name="complication_row[]" value="15" />
						</div>
					</div>
					<div id="criteriaIncThree" style ="">
					</div>
					
					<div class="col-sm-12 " style= 'height: 100px'>
						<h5 style="font-size: 18px;color: #2f55c7;font-weight: bold;">Insert name to add more complication </h5>
						<div id ="generalExamination" class="" style="width: 400px;">
							<p>Name <input type="text" id="complicationName" style ="height: 60px;font-size: 20px;"/> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 5px 17px; cursor: pointer;font-size: 24px;" class="complication-add">ADD</span></p>
						</div>
					</div>
					<!--Complication End-->
					
					<!--General Examination start-->
					<div  class = "col-sm-12" id = "finalTreatment">
						<div class="col-sm-8" >
							<h4  style="display: inline-block;font-weight: bold;">GENERAL EXAMINATION </h4>
						</div>
						
					</div>
					
					<div class = "col-sm-12  " style= 'height: 70px'>
						<?php $get_single_height = $this->Progress_model->get_single_height($patient_id);
								$hVal = null;
								$hVal2 = null;
								$unit = null;
							//echo $get_single_height['height'];
							if($get_single_height){
							if (strpos($get_single_height['height'], 'cm') !== false) { 
								$hVal = substr($get_single_height['height'], 0, strpos($get_single_height['height'], " "));
							}elseif (strpos($get_single_height['height'], 'ft') !== false && strpos($get_single_height['height'], 'inch') !== false) { 
								$hVal = substr($get_single_height['height'], 0, strpos($get_single_height['height'], " "));
								$hVal2 =  strstr($get_single_height['height'],"ft");
								$unit = 'ft/inch';
								
								//echo filter_var($hVal2, FILTER_SANITIZE_NUMBER_INT);
							}elseif (strpos($get_single_height['height'], 'Inch') !== false) { 
								$hVal = substr($get_single_height['height'], 0, strpos($get_single_height['height'], " "));
								$unit = 'Inch';
								
								//echo filter_var($hVal2, FILTER_SANITIZE_NUMBER_INT);
							}
							}
						?>
						<div class="col-sm-7 padding  general-examination-height p" >
							
								<label class="">Height:</label>
								<?php
								if($get_single_height):
								if (strpos($get_single_height['height'], 'cm') !== false) :?>
								<input  type="text" class="wih" value='<?php echo $hVal;?>' style = "font-size: 20px;" name="gexam_height_value" placeholder="" />
								<?php elseif (strpos($get_single_height['height'], 'ft') !== false && strpos($get_single_height['height'], 'inch') !== false):?>
								<input  type="number" class="wif" value='<?php echo $hVal;?>' style = "font-size: 20px;" name="gexam_height_value_ft" placeholder="ft"/>
								<input  type="number" class="wif" value='<?php echo filter_var($hVal2, FILTER_SANITIZE_NUMBER_INT);?>' style = "font-size: 20px;" name="gexam_height_value_inch" placeholder="inch"/>
								<?php elseif (strpos($get_single_height['height'], 'Inch') !== false):?>
								<input  type="text" class="wih" value='<?php echo $hVal;?>' style = "font-size: 20px;" name="gexam_height_value" placeholder="" />
								<?php else:?>
								<input  type="text" class="wih"  style = "font-size: 20px;" name="gexam_height_value" placeholder="" />
								<?php endif;?>
								
								<?php else:?>
								<input  type="text" class="wih"  style = "font-size: 20px;" name="gexam_height_value" placeholder="" />
								<?php endif;?>
								<select name="gexam_height_unit" style = "font-size: 20px;" class=" sel-gexam-height wifi">
									<option value="cm">cm</option>
									<option value="ft/inch" <?php echo $unit === 'ft/inch' ?  'selected' : null;?> >ft/inch</option>
									<option value="Inch" <?php echo $unit === 'Inch' ?  'selected' : null;?>  >Inch</option>
									
								</select>
								
								
								
						</div>
						<input type="hidden" name="gexam_row[]" value="1" />
						<input type="hidden" name="gexam_row_name_1" value="Height" />
						
						<?php $get_single_weight = $this->Progress_model->get_single_weight($patient_id); 
						
						$wVal = null;
						if($get_single_weight){
							$wVal = substr($get_single_weight['weight'], 0, strpos($get_single_weight['weight'], " "));
							
						}
						
						?>
						
						<div class="col-sm-5 padding " >
							<label class="">Weight:</label>
							<input class="wiw" type="text" value='<?php echo $wVal;?>' style = "font-size: 20px;" class="" name="gexam_weight_value" placeholder="Weight" />
							<label style = "font-size: 20px;">kg</label>
							<input type="hidden" name="gexam_weight_unit" value="kg" />
						</div>
					</div>
					<div class = "col-sm-12  " style= 'height: 70px'>
						
							<label class="">Blood Pressure:</label>
							<input class="wi" type="text" class="" style = "font-size: 20px;" name="gexam_si_sbp_value" placeholder=" SBP" />
							<input class="wi" type="text" class="" style = "font-size: 20px;" name="gexam_si_dbp_value" placeholder=" DBP" />
							<label style = "font-size: 20px;">mmHG</label>
							
							<input type="hidden" name="gexam_si_sbp_unit" value="mm/Hg" />
							<input type="hidden" name="gexam_si_dbp_unit" value="mm/Hg" />
							
						
						
					</div>
					<!--General Examination end-->
					<div style="border-bottom: 3px solid #9F9D9E;margin-top: 15px;" class = "col-sm-12" >
						
						
					</div>
					
					<div style="border-bottom: 3px solid #9F9D9E;" class = "col-sm-12 padding" >
						<div style="" id ="left" class = "col-sm-4 padding" >
							<h5 style="display: inline-block;font-weight: bold;height: 60px;font-size: 20px;">Type of glucose intolerance </h5>
							<div  class = "col-sm-12 padding p" style= 'height: 50px'>
								<div  class = "col-sm-6 padding"  >
									<input type="radio" id="Foot" name="type_of_glucose" value="Type2DM">
	  								<label >Type2DM</label><br>
								</div>
								<div  class = "col-sm-6 padding"  >
									<input type="radio" id="Foot" name="type_of_glucose" value="Type1DM">
	  								<label >Type1DM</label><br>
								</div>
							</div>
							<div  class = "col-sm-12 padding p" style= 'height: 50px'>
								<div  class = "col-sm-6 padding" >
									<input type="radio" id="Foot" name="type_of_glucose" value="IGT">
	  								<label >IGT</label><br>
								</div>
								<div  class = "col-sm-6 padding" >
									<input type="radio" id="Foot" name="type_of_glucose" value="IFG">
	  								<label >IFG</label><br>
								</div>
							</div>
							<div  class = "col-sm-12 padding p" style= 'height: 50px'>
								<div  class = "col-sm-6 padding " >
									<input type="radio" id="Foot" name="type_of_glucose" value="GDM">
	  								<label >GDM</label><br>
								</div>
								<div  class = "col-sm-6 padding" >
									<input type="radio" id="Foot" name="type_of_glucose" value="Others">
	  								<label >Others</label><br>
								</div>
							</div>
							<div  class = "col-sm-12 padding" style= 'height: 50px' >
								<h5 style="display: inline-block;font-weight: bold;">Duration</h5>
							</div>
							<div  class = "col-sm-12 padding" style= 'height: 70px' id = "laboratoryInvestigation">
								<input type="number" class="wid" style= "font-size: 20px;" placeholder = "Amount" name="duration_of_glucose" placeholder="" />
								<select style = "width:45%; height: 45px;" name="duration_time" id="cars">
									<option value="">Select time</option>
									<option value="Month">Month</option>
									<option value="Year">Year</option>
								  </select>
							</div>
							<?php if($patientinfo['patient_gender'] === '1'): ?>
							<div  class = "col-sm-12 padding p"  style= 'height: 50px'>
								<h5 style="display: inline-block;font-weight: bold;">Previous Bad Obstetrical History</h5>
							</div>
							<div  class = "col-sm-12 padding p"  style= 'height: 50px'>
								<div  class = "col-sm-6 padding " >
									<input class="checkbox-prev-bad-obstetric-history-yes" type="radio" name="prev_bad_obstetric_history" value="YES">
	  								<label >YES</label><br>
								</div>
								<div  class = "col-sm-6 padding" >
									<input class="checkbox-prev-bad-obstetric-history-no" type="radio"  name="prev_bad_obstetric_history" value="NO">
	  								<label >NO</label><br>
								</div>
							</div>
							<div  class = "col-sm-12 padding p" style= 'height: 50px'>
								<h5 style="display: inline-block;font-weight: bold;">Previous History of GDM</h5>
							</div>
							<div  class = "col-sm-12 padding p" style= 'height: 50px'>
								<div  class = "col-sm-6 padding " >
									<input class="checkbox-prev-history-of-gdm-yes" type="radio" name="prev_history_of_gdm" value="YES">
	  								<label >YES</label><br>
								</div>
								<div  class = "col-sm-6 padding" >
									<input class="checkbox-prev-history-of-gdm-no" type="radio"  name="prev_history_of_gdm" value="NO">
	  								<label >NO</label><br>
								</div>
							</div>
							<div  class = "col-sm-12 padding p" style= 'height: 50px'>
								<h5 style="display: inline-block;font-weight: bold;">Past Medical History</h5>
							</div>
							<div  class = "col-sm-12 padding p" >
								<textarea name="past_medical_history" class="check-alphanumeric-charactars" cols="30" rows="5" style="width:100%;height: 175px;font-size: 20px;"></textarea>
							</div>
							<?php endif; ?>
							<div  class = "col-sm-12" style= "margin-top: 40px;height: 50px" >
								<h5 style="display: inline-block;font-weight: bold;">Report</h5>
							</div>
							<div  id = "criteriaIncTwo" >
								<div  class = "col-sm-12  padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >2Ags/2Abf</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="ags" placeholder="mmol" />
									</div>
									<input type="hidden" name="ags_unit" value="mmol" />
								</div>
								<div  class = "col-sm-12  padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >After-meal</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="after_meal" placeholder="mmol" />
									</div>
									<input type="hidden" name="after_meal_unit" value="mmol" />
								</div>
								<div  class = "col-sm-12  padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >FBG/Before-meal</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="fbg" placeholder="mmol" />
									</div>
									<input type="hidden" name="fbg_unit" value="mmol" />
								</div>
								
								<div  class = "col-sm-12   padding p" style= "height: 40px" >
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >2hAG</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="2hag" placeholder="mmol" />
									</div>
									<input type="hidden" name="2hag_unit" value="mmol" />
								</div>
								
								<div  class = "col-sm-12   padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >RBG</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="rbg" placeholder="" />
									</div>
									<input type="hidden" name="rbg_unit" value="" />
								</div>
								
								<div  class = "col-sm-12   padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >HbA1c</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="hba1c" placeholder="%" />
									</div>
									<input type="hidden" name="hba1c_unit" value="%" />
								</div>
								
								<div  class = "col-sm-12   padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >T. Chol</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="t_chol" placeholder="mg/dl" />
									</div>
									<input type="hidden" name="t_chol_unit" value="mg/dl" />
								</div>
								
								<div  class = "col-sm-12  padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >LDL-C</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="ldlc" placeholder="mg/dl" />
									</div>
									<input type="hidden" name="ldlc_unit" value="mg/dl" />
								</div>
								
								<div  class = "col-sm-12  padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >HDL-C</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="hdlc" placeholder="mg/dl" />
									</div>
									<input type="hidden" name="hdlc_unit" value="mg/dl" />
								</div>
								
								<div  class = "col-sm-12   padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >TG</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="tg" placeholder="TG" />
									</div>
									
								</div>
								
								<div  class = "col-sm-12   padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >S. Creatinine</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="sc" placeholder="mg/dl" />
									</div>
									<input type="hidden" name="sc_unit" value="mg/dl" />
								</div>
								<div  class = "col-sm-12   padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >SGPT</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="sgpt" placeholder="mg/dl" />
									</div>
									<input type="hidden" name="sgpt_unit" value="units per liter" />
								</div>
								
								
								<div  class = "col-sm-12 padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >U. Albumin</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="ua" placeholder="" />
									</div>
									
								</div>
								
								<div  class = "col-sm-12  padding p" style= "height: 40px">
									<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
										<label >U. Acetone</label>
									</div>
									<div  class = "col-sm-7 padding p" >
										<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class="wir" name="uac" placeholder="" />
									</div>
									<input type="hidden" name="uac_unit" value="+" />
								</div>
								
								<div  class = "col-sm-12   padding p" >
									<div style= "padding-right: 5px;width: 20%;" class = "col-sm-5 padding p" >
										<label >ECG</label>
									</div>
									<div style= "width: 80%;" class = "col-sm-7 padding p" >
										<label class="lab-ecg-type-normal">
										<input class="checkbox-lab-ecg-type-normal" type="checkbox" name="ecg_type" value="1" />
										&nbsp;&nbsp; Normal</label> &nbsp; 
										<label class="lab-ecg-type-abnormal">
										<input class="checkbox-lab-ecg-type-abnormal" type="checkbox" name="ecg_type" value="0" />
										&nbsp; Abnormal</label>
									</div>
								</div>
								
								<div  class = "col-sm-12 padding p" >
									<div class="abnoirmal-type-keywords padding p" style="display:none; margin-top: 10px; margin-bottom: 10px;">
										<label><input type="checkbox" name="abn_keywords[]" value="RBBB" />&nbsp; RBBB </label>&nbsp;&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="abn_keywords[]" value="LBBB" />&nbsp; LBBB </label>&nbsp;&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="abn_keywords[]" value="LVH" />&nbsp; LVH </label>&nbsp;&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="abn_keywords[]" value="MI" />&nbsp; MI</label>&nbsp;&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="abn_keywords[]" value="ISCHEMIA" />&nbsp; ISCHEMIA</label>&nbsp;&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="abn_keywords[]" value="Others" />&nbsp; Others</label>
									</div>
								</div>
								
								<div  class = "col-sm-12  padding p" >
									<div style= "padding-right: 5px;width: 20%;" class = "col-sm-5 padding p" >
										<label >USG</label>
									</div>
									<div style= "width: 80%;" class = "col-sm-7 padding p" >
										<label class="lab-usg-type-normal">
										<input class="checkbox-lab-usg-type-normal" type="checkbox" name="usg_type" value="1" />&nbsp;&nbsp; Normal
										</label> &nbsp; <label class="lab-usg-type-abnormal">
										<input class="checkbox-lab-usg-type-abnormal" type="checkbox" name="usg_type" value="0" />&nbsp; Abnormal</label>
									</div>
								</div>
								
								<div  class = "col-sm-12 padding p" >
									<div class="usg-abnormal-type-keywords" style="display:none">
										<label><input type="text" name="usg_abnormal_value" /></label>
									</div>
								</div>
							</div>
								<div  class = "col-sm-12 padding" >
									<h5 style="display: inline-block;color: #2f55c7;font-weight: bold;">Insert Name and Unit to add more report</h5>
								</div>
								
								<div  >
									<div style="padding-right: 15px;padding-left: 15px;height: 40px" class = "col-sm-12 padding p" >
										<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
											<label >Name</label>
										</div>
										<div  class = "col-sm-7 padding p" >
											<input type="text" class="wir" style= "height: 35px;font-size: 20px;width: 100%;" id="labInvestigationName" name=""  placeholder="" />
										</div>
									</div>
									<div class = "col-sm-12 padding p" style = 'height: 40px'>
										<div style= "padding-right: 5px;" class = "col-sm-5 padding p" >
											<label >Unit</label>
										</div>
										<div  class = "col-sm-7 padding p" >
											<input type="text" class ="wir" style= "height: 35px;font-size: 20px;width: 100%;" id="labInvestigationUnit" name="" placeholder="" />
										</div>
									</div>
									
									<div style="margin-bottom: 50px;" class = "col-sm-12" >
										<span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 2px 8px; cursor: pointer;" class="lab-investigation">ADD</span>
									</div>
								</div>
							
							
							
						</div>
						<div   class = "col-sm-8 padding p" id="right" style="width: 69%;" >
							<div   class = "col-sm-12 padding" style= 'height: 70px' >
								<h3 style="text-align: center;font-weight: bold;">Final Treatment</h3>
							</div>
							<div   class = "col-sm-12 padding" style="margin-bottom: 2%;height: 110px;display: flex;align-items: center;">
								<label class="control-label col-sm-3 padding" style="margin-top: 2%">Date</label>
								<div class="col-sm-9 padding">
									<input type="text" style="height: 100px;font-size: 20px;" name="finaltreat_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" class="form-control text-center datepicker check-date-is-valid">
								</div>
							</div>
							<div   class = "col-sm-12 padding p" style="height: 130px">
								<label class="control-label col-sm-3 padding p">Added Clinical Info</label>
								<div class="col-sm-9 padding p">
									<textarea name="added_clinical_info" class="check-alphanumeric-charactars" cols="30" rows="3" placeholder="Insert Additonal info" style="width:100%;height: 80px;font-size: 20px;"></textarea>
								</div>
							</div>
							<div   class = "col-sm-12 padding p" style="height: 180px">
								<label class="control-label col-sm-3 padding p">Dietary Advice (Calorie/Day)</label>
								<div class="col-sm-9 padding p">
									<textarea name="finaltreat_dietary_advice" class="check-alphanumeric-charactars" cols="30" rows="3" placeholder="Insert Advice Here" style="width:100%;height: 150px;font-size: 20px;"></textarea>
								</div>
							</div>
							<div   class = "col-sm-12 padding p" style="height: 180px">
							
								<label class="control-label col-sm-3 padding p">Physical Acitvity</label>
								<div class="col-sm-9 padding p">
									<textarea name="finaltreat_physical_acitvity" class="check-alphanumeric-charactars" cols="30" rows="3" placeholder="Insert Physical Acitvity" style="width:100%;height: 150px;font-size: 20px;"></textarea>
								</div>
							</div>
							<div   class = "col-sm-12 padding p" style="height: 180px">
							
								<label class="control-label col-sm-3 padding p">Other Advice</label>
								<div class="col-sm-9 padding p">
									<textarea name="finaltreat_other_advice" class="check-alphanumeric-charactars" cols="30" rows="3" placeholder="Insert Additional advice" style="width:100%;height: 150px;font-size: 20px;"></textarea>
								</div>
							</div>
							<div   class = "col-sm-12 padding p" style="height: 130px">
								<label class="control-label col-sm-3 padding p">Diet No</label>
								<div class="col-sm-9 padding p">
									<input type="text" class = "finaltreat_diet_no" name="finaltreat_diet_no" style="width:100%;height: 80px;font-size: 20px;" class="" />
								</div>
							</div>
							<div   class = "col-sm-12 padding p" id= "page_no" style="height: 120px">
								<label class="control-label col-sm-3 padding p">Page No</label>
									<div class="col-sm-9 padding p">
										<input type="text" class = "finaltreat_diet_no" name="finaltreat_page_no" style="width:100%;height: 80px;font-size: 20px;" class="" />
									</div>
							</div>
							<div style= "margin-top: 20px;height: 50px;"  class = "col-sm-12 padding" >
								<div   class = "col-sm-3 padding sel-sympt-9-cntr" data-value="1">
									<button type="button" style = "padding: 12px 12px;" id= "" class="btn btn-success">OADs</button>
								 
								</div>
								<div   class = "col-sm-3 padding sel-sympt-10-cntr"  data-value="1">
									<button type="button"  id= "" style = "padding: 12px 12px;" class="btn btn-success">Insulin</button>
								 
								</div>
								<div   class = "col-sm-3 padding sel-sympt-4-cntr" data-value="1">
									<button type="button" id= "" style = "padding: 12px 12px;" class="btn btn-success">Anti-HTN</button>
								 
								</div>
								<div   class = "col-sm-3 padding sel-sympt-5-cntr" data-value="1">
									<button type="button" id= "" style = "padding: 12px 12px;" class="btn btn-success">Anti-lipid</button>
								 
								</div>
							</div>
							
							<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
								<div   class = "col-sm-3 padding sel-sympt-6-cntr" data-value="1">
									<button type="button" id= "" style = "padding: 12px 12px;" class="btn btn-success">Anti-platelet</button>
								 
								</div>
								<div   class = "col-sm-3 padding sel-sympt-7-cntr" data-value="1">
									<button type="button" id= "" style = "padding: 12px 12px;" class="btn btn-success">Anti-obesity</button>
								 
								</div>
								<div   class = "col-sm-3 padding sel-sympt-8-cntr" data-value="1">
									<button type="button" id= "" style = "padding: 12px 12px;" class="btn btn-success">Others</button>
								 
								</div>
								
							</div>
							<div class = "col-sm-12 padding p input-row-fields-9-cntr" style="display: block;" >
								<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">OADs</h4>
								</div>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding"  >
									
										<div class="col-sm-12" style= "margin-top: 20px;height: 70px;">
											<label class="col-sm-2 padding p"> OADs: </label>
											<input type="text" name="crnt_oads_name_1" style = 'height: 65px;font-size: 20px;' placeholder="Add OADs" class=" load-drugs col-sm-10 padding p" />
										</div>
										<div class="col-sm-12" style = 'height: 70px;'>
											<label class="col-sm-2 padding p"> Dose: </label>
											<input type="text" name="crnt_oads_value_1" value='1+1+1' style = 'height: 65px;font-size: 20px;'  placeholder="ADD Dose" class="col-sm-10 padding p" />
										</div>
											
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-4 padding">
											<div class="inline-sc" style="width: 100%;">
												<span style="display: inline-block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span> 
												<input type="text" name="crnt_oads_condition_time_1" placeholder="" class="" style="float: left;width: 42%;text-align: center;font-size: 20px;margin-top: 0px;">
											</div>
											
										</div>
										<div class="col-sm-4 padding">
											<div class="inline-sc" style="width: 100%;">
												<select name="crnt_oads_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -4px;width: 48%;display: inline-block;font-size: 20px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
												<select name="crnt_oads_condition_apply_1" class="form-control" style="text-align: center;margin-top: -4px;width: 48%;display: inline-block;font-size: 20px;">
													<option value="আগে">আগে</option>
													<option value="মাঝে">মাঝে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4 padding">
											<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>
												<input type="text" name="crnt_oads_duration_1" style="float: left;width: 40%;text-align: center;font-size: 20px;" class="">
												<div class="inline-sc" style="width: 22%;">
													<select name="crnt_oads_duration_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
														<option value="দিন">দিন</option>
														<option value="মাস">মাস</option>
													</select>
												</div>
										</div>
										
										<input type="hidden" name="crnt_oads_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<div style="padding-bottom: 10px" class="col-sm-3">
										<span class="cntr-oads-add-more-htn add-more-bttn" style="cursor:pointer;text-align: center;">
										<i class="mdi mdi-plus"></i>
										More</span>
									</div>
								</div>
								<div class = " padding" id = "crntOads" >
								</div>
								
							</div>
							<div class = "col-sm-12 padding input-row-fields-10-cntr p" style="display: none;" >
								<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Insulin</h4>
								</div>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding"  >
									
										<div class="col-sm-12" style= "margin-top: 20px;height: 70px;">
											<label class="col-sm-2 padding p" > Insulin: </label>
											<input type="text" style = "height: 65px;font-size: 20px;" name="crnt_insulin_name_1" placeholder="Add Insulin" class=" load-drugs-insulin col-sm-10 padding p" />
										</div>
										<div class="col-sm-12" style = "height: 70px;">
											<label class="col-sm-2 padding p"> Dose: </label>
											<input type="text" value="10+10+10" style = "height: 65px;font-size: 20px;" name="crnt_insulin_value_1" placeholder="ADD Dose" class="col-sm-10 padding p" />
										</div>
											
									
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p ins-way" >
										<div class="col-sm-8 padding">
											<div class="inline-sc" style="width: 40%;">
												<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span> 
												<input type="text" name="crnt_insulin_condition_time_1" placeholder="" class="" style="float: left;width: 42%;font-size: 20px;margin-top: -4px;margin-left: 2%;text-align: center;">
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_insulin_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_insulin_condition_apply_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4 padding">
											<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>
											<input type="text" name="crnt_insulin_duration_1" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_insulin_duration_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<input type="hidden" name="crnt_insulin_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										<label class="special-insulin" style ="font-size: 20px" ><input class="special-insulin-value"  type="checkbox" name="before_sleeping_1" value="1" /> &nbsp;ঘুমানোর &nbsp; আগে &nbsp; চলবে</label>
									</div>
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										<label class="special-insulin-week" style ="font-size: 20px" ><input class="special-insulin-value-week"  type="checkbox" name="week_1" value="1" /> &nbsp; সপ্তাহে </label>
										<input type="number"  name="crnt_insulin_week_1" placeholder="" class="" style="width: 20%;font-size: 20px;margin-top: -4px;margin-left: 2%;text-align: center;">
										<span style="display: inline-block;width: 15%;font-size: 20px;">দিন</span>
									</div>
									<div style= "padding-top: 20px;display:none;"  class = "col-sm-12 padding p" >
										
										<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_1_1" value="রবি" /> &nbsp; রবি </label>
										<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_1_2" value="সোম" /> &nbsp; সোম </label>
										<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_1_3" value="মঙ্গল" /> &nbsp; মঙ্গল </label>
										<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_1_4" value="বুধ" /> &nbsp; বুধ</label>
										<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_1_5" value="বৃহস্পতি" /> &nbsp; বৃহস্পতি</label>
										<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_1_6" value="শুক্র" /> &nbsp; শুক্র</label>
										<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_1_7" value="শনি"  /> &nbsp; শনি </label>
										
										<label class="special-insulin-day" style ="font-size: 20px" ><input class="special-insulin-value-day"  type="checkbox" name="jekonodin_1" value="যে কোন দিন" /> &nbsp; যে কোন দিন </label>
										<input type="hidden" name="day_array[]" value="1" />
										<input type="hidden" name="day_array[]" value="2" />
										<input type="hidden" name="day_array[]" value="3" />
										<input type="hidden" name="day_array[]" value="4" />
										<input type="hidden" name="day_array[]" value="5" />
										<input type="hidden" name="day_array[]" value="6" />
										<input type="hidden" name="day_array[]" value="7" />
									</div>
									
									
									<div style="padding-bottom: 10px" class="col-sm-3">
										<span class="cntr-insulin-add-more-htn add-more-bttn" style="cursor:pointer;text-align: center;">
										<i class="mdi mdi-plus"></i>
										More
										</span>
									</div>
								
								</div>
								
								<div class = " padding" id = "crntInsulin" >
								</div>
							</div>
							<div class = "col-sm-12 padding input-row-fields-cntr p" style="display: none;" >
								<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Anti-HTN</h4>
								</div>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p"  >
									
										<div class="col-sm-12" style= "margin-top: 20px;height: 70px;">
											<label class="col-sm-2 padding p"> Anti-HTN: </label>
											<input type="text" style = "height: 65px;font-size: 20px;" name="crnt_anti_htn_name_1" placeholder="Add Anti HTN" class="load-drugs col-sm-10 padding p" />
										</div>
										<div class="col-sm-12" style = "height: 70px;">
											<label class="col-sm-2 padding p" > Dose: </label>
											<input type="text" value="1+1+1" style = "height: 65px;font-size: 20px;" name="crnt_anti_htn_value_1" placeholder="ADD Dose" class="col-sm-10 padding p" />
										</div>
											
									
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-8 padding">
											<div class="inline-sc" style="width: 40%;">
												<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span> 
												<input type="text" name="crnt_anti_htn_condition_time_1" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_anti_htn_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_anti_htn_condition_apply_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4 padding">
											<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>
											<input type="text" name="crnt_anti_htn_duration_1" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_anti_htn_duration_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<input type="hidden" name="crnt_anti_htn_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<div style="padding-bottom: 10px" class="col-sm-3">
										<span class="cntr-htn-add-more-htn add-more-bttn" style="cursor:pointer;text-align: center;">
										<i class="mdi mdi-plus"></i>
										More
										</span>
									</div>
								
								</div>
								
								<div class = " padding" id = "antiHtnFieldsCntr" >
								</div>
							</div>
							
							<div class = "col-sm-12 padding input-row-fields-2-cntr p" style="display: none;" >
								<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Anti-lipid</h4>
								</div>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p"  >
									
										<div class="col-sm-12" style= "margin-top: 20px;height: 70px;">
											<label class="col-sm-2 padding p"> Anti-lipid: </label>
											<input type="text" style = "height: 65px;font-size: 20px;" name="crnt_lipids_name_1" placeholder="Add Anti Lipids" class="load-drugs col-sm-10 padding p" />
										</div>
										<div class="col-sm-12" style = "height: 70px;">
											<label class="col-sm-2 padding p"> Dose: </label>
											<input type="text" value="1+1+1" style = "height: 65px;font-size: 20px;" name="crnt_lipids_value_1" placeholder="ADD Dose" class="col-sm-10 padding p" />
										</div>
											
									
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-8 padding">
											<div class="inline-sc" style="width: 40%;">
												<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span> 
												<input type="text" name="crnt_lipids_condition_time_1" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_lipids_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_lipids_condition_apply_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4 padding">
											<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>
											<input type="text" name="crnt_lipids_duration_1" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_lipids_duration_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<input type="hidden" name="crnt_lipids_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<div style="padding-bottom: 10px" class="col-sm-3">
										<span class="cntr-lipids-add-more-htn add-more-bttn" style="cursor:pointer;text-align: center;">
										<i class="mdi mdi-plus"></i>
										More
										</span>
									</div>
							
								</div>
								
								<div class = " padding" id = "antiLipidsFieldsCntr" >
								</div>
							</div>
							
							<div class = "col-sm-12 padding input-row-fields-3-cntr p" style="display: none;" >
								<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Anti-platelet</h4>
								</div>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p"  >
									
										<div class="col-sm-12" style= "margin-top: 20px;height: 70px;">
											<label class="col-sm-3 padding p"> Anti-platelet: </label>
											<input type="text" style = "height: 65px;font-size: 20px;" name="crnt_aspirine_name_1" placeholder="Add Anti Platelet" class="load-drugs col-sm-9 padding p" />
										</div>
										<div class="col-sm-12 " style = "height: 70px;">
											<label class="col-sm-3 padding p"> Dose: </label>
											<input type="text" value="1+1+1" style = "height: 65px;font-size: 20px;" name="crnt_aspirine_value_1" placeholder="ADD Dose" class="col-sm-9 padding p" />
										</div>
											
									
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding" >
										<div class="col-sm-8 padding p">
											<div class="inline-sc" style="width: 40%;">
												<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span> 
												<input type="text" name="crnt_aspirine_condition_time_1" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_aspirine_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_aspirine_condition_apply_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4 padding">
											<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>
											<input type="text" name="crnt_aspirine_duration_1" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_aspirine_duration_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<input type="hidden" name="crnt_aspirine_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<div style="padding-bottom: 10px" class="col-sm-3">
										<span class="cntr-aspirine-add-more-htn add-more-bttn" style="cursor:pointer;text-align: center;">
										<i class="mdi mdi-plus"></i>
										More
										</span>
									</div>
								
								</div>
								
								<div class = " padding" id = "aspirineFieldsCntr" >
								</div>
							</div>
							
							<div class = "col-sm-12 padding input-row-fields-4-cntr" style="display: none;" >
								<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Anti-obesity</h4>
								</div>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p"  >
									
										<div class="col-sm-12" style= "margin-top: 20px;height: 70px;">
											<label class="col-sm-3 padding p"> Anti-obesity: </label>
											<input type="text" style = "height: 65px;font-size: 20px;" name="crnt_obesity_name_1" placeholder="Add Anti Obesity" class="load-drugs col-sm-9 padding p" />
										</div>
										<div class="col-sm-12 " style = "height: 70px;" >
											<label class="col-sm-3 padding p"> Dose: </label>
											<input type="text" value="1+1+1" style = "height: 65px;font-size: 20px;" name="crnt_obesity_value_1" placeholder="ADD Dose" class="col-sm-9 padding p" />
										</div>
											
									
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-8 padding p">
											<div class="inline-sc" style="width: 40%;">
												<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span> 
												<input type="text" name="crnt_obesity_condition_time_1" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_obesity_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_obesity_condition_apply_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4 padding">
											<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>
											<input type="text" name="crnt_obesity_duration_1" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_obesity_duration_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<input type="hidden" name="crnt_obesity_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									<div style="padding-bottom: 10px" class="col-sm-3">
										<span class="cntr-obesity-add-more-htn add-more-bttn" style="cursor:pointer;text-align: center;">
										<i class="mdi mdi-plus"></i>
										More
										</span>
									</div>
								
								</div>
								
								<div class = " padding" id = "antiObesityFieldsCntr" >
								</div>
							</div>
							
							<div class = "col-sm-12 padding input-row-fields-5-cntr p" style="display: none;" >
								<div style= "margin-top: 20px;"  class = "col-sm-12 padding" >
									<h4 style="text-align: center;font-weight: bold;">Others</h4>
								</div>
								<div style = "box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p"  >
									
										<div class="col-sm-12" style= "margin-top: 20px;height: 70px;">
											<label class="col-sm-2 padding p" > Others: </label>
											<input type="text" style = "height: 65px;font-size: 20px;" name="crnt_other_name_1" placeholder="Add Others" class="load-drugs col-sm-10 padding p" />
										</div>
										<div class="col-sm-12" style = "height: 70px;">
											<label class="col-sm-2 padding p"> Dose: </label>
											<input type="text" value="1+1+1" style = "height: 65px;font-size: 20px;" name="crnt_other_value_1" placeholder="ADD Dose" class="col-sm-10 padding p" />
										</div>
											
									
									
									<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >
										<div class="col-sm-8 padding p">
											<div class="inline-sc" style="width: 40%;">
												<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span> 
												<input type="text" name="crnt_other_condition_time_1" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_other_condition_time_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="মিনিট">মিনিট</option>
													<option value="ঘন্টা">ঘন্টা</option>
												</select>
											</div>
											<div class="inline-sc" style="width: 25%;">
												<select name="crnt_other_condition_apply_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="আগে">আগে</option>
													<option value="পরে">পরে</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4 padding">
											<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>
											<input type="text" name="crnt_other_duration_1" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">
											<div class="inline-sc" style="width: 22%;">
												<select name="crnt_other_duration_type_1" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">
													<option value="দিন">দিন</option>
													<option value="মাস">মাস</option>
												</select>
											</div>
										</div>
										
										<input type="hidden" name="crnt_other_row[]" value="1" />
										<div style="clear:both"></div>
									</div>
									
									<div style="padding-bottom: 10px" class="col-sm-3">
										<span class="cntr-other-add-more-htn add-more-bttn" style="cursor:pointer;text-align: center;">
										<i class="mdi mdi-plus"></i>
										More
										</span>
									</div>
								
								</div>
								
								<div class = " padding" id = "othersFieldsCntr" >
								</div>
							</div>
						</div>
						
						
					</div>
					
					<div  class = "col-sm-12 padding" >
						<div  class = "col-sm-12 padding" >
							<div style="padding-right: 0px;margin-bottom: 10px;" class = "col-sm-12 padding" >
								<div style="margin-top: 10px;"  class = "col-sm-3 padding p" >
									<label >Next Visit Date</label>
								</div>
								<div class = "col-sm-9 p" style = "height: 60px">
									<input style = "width: 75%; margin-top: 2%; height: 50px;font-size: 20px;" type="text" name="finaltreat_next_visit_date" placeholder="Day/Month/Year  Ex: 01/01/2022" class=" "  id = ''>
								</div>
							</div>
							<div class = "col-sm-12 padding" >
								<div style="margin-top: 10px;" id = "NV" class = "col-sm-3 padding p" >
									<label >Next Investigation</label>
								</div>
								<div style="" class = "col-sm-9 padding p" >
									
										<div style="" class="col-sm-10 padding p" style = "height: 180px">
											<textarea id="second" name="" class="src-investigation" cols="30" rows="3" placeholder="Search investigation here" style="width:100%;height: 160px;font-size: 20px;"></textarea>
										</div>
										<div style="padding-right: 0px;" class="col-sm-2">
											<button type="button" style="padding: 12px 12px;font-size: 20px;" id= "add-investigation" class="btn btn-success">ADD</button>
										</div>
										<div style="padding-right: 0px;" class="col-sm-10 padding p" style = "height: 120px">
											<textarea id="first" name="finaltreat_next_investigation" class="" cols="30" rows="3" placeholder="Investigation name" style="width:100%;height: 110px;font-size: 20px;" ></textarea>
										</div>
										<div style="padding-right: 0px;" class="col-sm-2">
											<button type="button" style="padding: 12px 4px;font-size: 20px;" id= "refresh" class="btn btn-danger">Delete</button>
										</div>
										
										
									
								</div>
								<div style="padding-right: 0px;" class = "col-sm-3" >
								</div>
							</div>
						</div>
						<div  class = "col-sm-12 padding" >
							<div class="col-sm-3 padding " >
								<label class="refer-lebel" style ="font-size: 20px;width: 100%;" ><input class="refer-input" style = 'margin-top: 2%;' type="checkbox" name="refer_input" value="1" />&nbsp;&nbsp;Refer To </label>
							</div>
							
						</div>
						<div  class = "col-sm-12 padding refer" style = 'display: none;' >
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_1" value="Endocrinologist">
	  							<label  for="Foot">Endocrinologist</label><br>
								<input type="hidden" name="refer_row[]" value="1" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_2" value="Eye">
	  							<label  for="Foot">Eye</label><br>
								<input type="hidden" name="refer_row[]" value="2" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_3" value="Dental">
	  							<label  for="Foot">Dental</label><br>
								<input type="hidden" name="refer_row[]" value="3" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_4" value="Cardiac_Specialist">
	  							<label  for="Foot">Cardiac Specialist</label><br>
								<input type="hidden" name="refer_row[]" value="4" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_7" value="Skin_Specialist">
	  							<label  for="Foot">Skin Specialist</label><br>
								<input type="hidden" name="refer_row[]" value="7" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_8" value="Surgery_Specialist">
	  							<label  for="Foot">Surgery Specialist</label><br>
								<input type="hidden" name="refer_row[]" value="8" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_9" value="Gynecologist">
	  							<label  for="Foot">Gynecologist</label><br>
								<input type="hidden" name="refer_row[]" value="9" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_10" value="Physiotherapist">
	  							<label  for="Foot">Physiotherapist</label><br>
								<input type="hidden" name="refer_row[]" value="10" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_11" value="Orthopedic">
	  							<label  for="Foot">Orthopedic</label><br>
								<input type="hidden" name="refer_row[]" value="11" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_12" value="Urologist">
	  							<label  for="Foot">Urologist</label><br>
								<input type="hidden" name="refer_row[]" value="12" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_13" value="Gastroenterologist">
	  							<label  for="Foot">Gastroenterologist</label><br>
								<input type="hidden" name="refer_row[]" value="13" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_14" value="General_Medicine">
	  							<label  for="Foot">General Medicine</label><br>
								<input type="hidden" name="refer_row[]" value="14" />
							</div>
							
							
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_16" value="Hematologist">
	  							<label  for="Foot">Hematologist</label><br>
								<input type="hidden" name="refer_row[]" value="16" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_17" value="Vascular_Surgeon">
	  							<label  for="Foot">Vascular Surgeon</label><br>
								<input type="hidden" name="refer_row[]" value="17" />
							</div>
							
							<div class="col-sm-3 padding refer_container" >
								<input type="checkbox"  name="refer_18" value="Foot_Specialist">
	  							<label  for="Foot">Foot Specialist</label><br>
								<input type="hidden" name="refer_row[]" value="18" />
							</div>
							
							<div class="col-sm-4 padding refer_container" >
								<input type="checkbox"  name="refer_5" value="Nephrology_Specialist">
	  							<label  for="Foot">Nephrology Specialist</label><br>
								<input type="hidden" name="refer_row[]" value="5" />
							</div>
							
							<div class="col-sm-4 padding refer_container" >
								<input type="checkbox"  name="refer_6" value="Neurology_Specialist">
	  							<label  for="Foot">Neurology Specialist</label><br>
								<input type="hidden" name="refer_row[]" value="6" />
							</div>
							
							<div class="col-sm-4 padding refer_container" >
								<input type="checkbox"  name="refer_15" value="Respiratory_Specialist">
	  							<label  for="Foot">Respiratory Specialist</label><br>
								<input type="hidden" name="refer_row[]" value="15" />
							</div>
								
								
								
							
						</div>
						
						<div class="col-sm-12 refer-button-container" style= 'height: 100px;display: none'>
							<h5 style="font-size: 18px;color: #2f55c7;font-weight: bold;">Insert name to add more type of doctor </h5>
							<div id ="generalExamination" class="" style="width: 400px;">
								<p>Name <input type="text" id="referName" style ="height: 60px;font-size: 20px;"/> &nbsp;&nbsp; <span style="display: inline-block; background: rgb(204, 204, 204) none repeat scroll 0% 0%; padding: 5px 17px; cursor: pointer;font-size: 24px;" class="refer-add">ADD</span></p>
							</div>
						</div>
						<div  class = "col-sm-12 padding" >
							<h4 style="display: inline-block; margin-top: 0px" class = "col-sm-3 padding">Doctor Name: <?php  ?></h4>
							<input type="text" style= "width: 60%;margin-left: 0.5%;font-weight: bold;font-size: 20px;" class=" col-sm-9 padding" name="finaltreat_doctor_name" value = "<?php echo $this->session->userdata('full_name');?>" readonly />
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
	
	<?php echo form_close(); ?>
	
	<div style = 'display:none; margin-top: 2%;' id = 'imageControlerdoc'>
		<div class="panel panel-default block2">
				<div class="panel-heading text-center put-relative">PATIENT DETAILS 
					
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
		<form mathod="post" id = 'upload_image' enctype = "multipart/form-data">
			
			<div class="container"  style = "    background-color: #7ea2a2;box-shadow: 0 -2px 7px rgb(5 29 103 / 70%);    margin-bottom: 10%;padding-bottom: 2%;">
				<div class="row">
				
					
					<div class="col-lg-6">
						<div class="form-group">
							<label class="control-label col-md-5" style = 'font-size: 24px;' >Date</label>
							<div class="col-md-7">
								<input type="text" name="finaltreat_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" class="form-control text-center datepicker check-date-is-valid">
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<h3 class="col-sm-5" style = 'font-weight: bold;'>Progress Report <span style="color:#f00">*</span></h3>
						<input class="col-sm-7" type="file" accept=".jpg,.jpeg" capture="camera" style="    margin-top: 2%;" name="image1" id= "image_file1" />
					</div>
					
					
					
					
					
					<div class="col-sm-12">
						<div class="col-sm-6">
							<input type="submit" style="padding: 3%;font-weight: bold;" name="upload" id= "upload" value = "Upload"/>
						</div>
					</div>
					
				</div>
			</div>
		</form>
		<div id="uploaded_image">  
		</div> 
	</div>
	
	
	<script >
		$(function(){
			$(".qr-gn").click(function(){
			 //alert('hello');
			 
				var bndrId =  $('#entry').val();
				var width = 160;
				var height = 160;
				var divToPrint=document.getElementById('printqr');

				  //var newWin=window.open('','Print-Window');

				  //newWin.document.open();

				  document.write('<html><body class="loadQr" onload="window.print()"></body></html>');
				  $('.loadQr').qrcode({width: width,height: height,text: bndrId});

				  document.close();

				  setTimeout(function(){close();},10);
				  document.location.href = baseUrl+'administrator/dashboard';
				  //document.location.href = baseUrl+'patients/progress/add/'+<?php echo $patient_id;?>+'/'+bndrId;
			});
		 
		});
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
	$(document).ready(function () {
		// Handler for .ready() called.
		$('html, body').animate({
			scrollTop: $('#progress').offset().top
		}, 'slow');
		
	});
	$("#referName").on("keydown",function(e) {
		var key = e.keyCode;
		console.log("keycode: " + key);
		if ((key == 32))              
		{    
			document.getElementById("referName").value=document.getElementById("referName").value + "_";
			return false;
		}
		else 
		{
			return true;
		}
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
						
						visit_date:{
							required: true,
						},
					},
					messages:{
						
						visit_date:{
							required: "Please enter visit date first",
						},
					},
					submitHandler : function (form) {
						$('#visitLoader').show();
						var formData = new FormData(form);
						// your function if, validate is success
						$.ajax({
							type : "POST",
							url : baseUrl + "patients/progress/create_progress_report",
							//url : baseUrl + "patients/progress/image",
							data : $('#createForm').serialize(),
							//data : new FormData(this),
							//mimeType: "multipart/form-data",
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
									$('#visitLoader').hide('blind', {}, 5000);
									if(data.exit == '1')
									{
										//alert(data.name);
										window.setTimeout(function(){
											window.location.href=baseUrl+'patients/visit/all/<?php echo $patient_id; ?>/<?php echo $patient_entry_id; ?>';
										}, 2000);
									}else if(data.exit == '0'){
										window.setTimeout(function(){
											window.location.href=baseUrl+'patients/progress/view_visit_preview/'+data.visit_id+'/'+data.visit_entryid+'/'+data.visit_patient_id;
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
									$('#visitLoader').hide('blind', {}, 500);
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
			
								
								
								
									
									
									
									
								
			$(document).on('change', '.sel-gexam-height', function(){
				var getValue = $(this).val();
				if(getValue == 'ft/inch')
				{
					var content = '<label class="">Height:</label>'+
									'<input  type="number" class="wif" style = "font-size: 20px;" name="gexam_height_value_ft" placeholder="ft"/>'+
									'<input  type="number" class="wif" style = "font-size: 20px;" name="gexam_height_value_inch" placeholder="inch"/>'+
									'<select name="gexam_height_unit" style = "font-size: 20px;" class=" sel-gexam-height wifi">'+
									'<option value="cm">cm</option>'+
									'<option value="ft/inch" selected>ft/inch</option>'+
									'<option value="Inch">Inch</option>'+
									'</select>';
					$('.general-examination-height').html(content);
				}else if(getValue == 'cm'){
						
					var content = '<label class="">Height:</label>'+
					'<input  type="number" style = "font-size: 20px;" class="wih" name="gexam_height_value" placeholder="" />'+
					'<select name="gexam_height_unit" style = "font-size: 20px;" class=" sel-gexam-height wih">'+
									'<option value="cm" selected>cm</option>'+
									'<option value="ft/inch" >ft/inch</option>'+
									'<option value="Inch">Inch</option>'+
									'</select>';
					$('.general-examination-height').html(content);
				}else if(getValue == 'Inch'){
					var content = '<label class="">Height:</label>'+
					'<input  type="number" class="wih" style = "font-size: 20px;" name="gexam_height_value" placeholder="" />'+
					'<select name="gexam_height_unit" style = "font-size: 20px;" class=" sel-gexam-height wih">'+
									'<option value="cm" >cm</option>'+
									'<option value="ft/inch" >ft/inch</option>'+
									'<option value="Inch" selected>Inch</option>'+
									'</select>';
					$('.general-examination-height').html(content);
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
					var content = '<div class="col-sm-4  complication-comorbidity-rows">' +
										'<input style = "padding-top: 2px" checked type="checkbox" name="complication_'+row+'" value="'+inp_name+'">&nbsp;&nbsp;' +
										'<label >'+inp_name+'</label>' +
										'<input type="hidden" value="'+row+'" name="complication_row[]">' +
										'<span class="rmv-itm mdi mdi-delete com-del"></span>' +
									'</div>';	
					$('#criteriaIncThree').append(content);
					$('#complicationName').val('');
				}else
				{
					return false;
				}
			});
			
			$(document).on('click', '.refer-add', function(){
				var row = $('.refer_container').length + 1;
				var inp_name = $('#referName').val();
				if(inp_name !== '')
				{
					var content = '<div class="col-sm-4  refer_container">' +
										'<input style = "padding-top: 2px" checked type="checkbox" name="refer_'+row+'" value="'+inp_name+'">&nbsp;&nbsp;' +
										'<label >'+inp_name+'</label>' +
										'<input type="hidden" value="'+row+'" name="refer_row[]">' +
										'<span class="rmv-itm mdi mdi-delete com-del"></span>' +
									'</div>';	
					$('.refer').append(content);
					$('#referName').val('');
				}else
				{
					return false;
				}
			});
			
			$(document).on('blur', '#patientAge', function(){
				
				var age = $(this).val();
				
				if(age !== '')
				{
					if(age < 3)
					{
						alert("Minimum 3 years old is allowed!");
						$(this).val('');
						return false;
					}else if(age > 130){
						alert("Maximum 130 years old is allowed!");
						$(this).val('');
						return false;
					}else{
						$.ajax({
							type : "POST",
							url : baseUrl + "patients/get_birth_date",
							data : {age:age},
							dataType : "json",
							success : function (data) {
								if(data.status == "ok")
								{
									$('#dateOfBirth').val(data.content);
									return false;
								}else
								{
									//have end check.
								}
								return false;
							}
						});
					}
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
			//load multiple oads
			$(document).on('click', '.cntr-oads-add-more-htn', function(){
				var content = '<div style= "margin-top: 20px;box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding">' +
									'<div style= "margin-top: 10px;height: 70px;"   class="col-sm-12""><label class="col-sm-2 padding p"> OADs: </label><input type="text" style= "height: 65px;font-size: 20px;" name="crnt_oads_name_'+row+'" placeholder="Add OADs" class=" load-drugs col-sm-10 padding p" /></div>' +
									'<div style= "height: 70px;" class="col-sm-12"><label class="col-sm-2 padding p"> Dose: </label><input type="text" value="1+1+1" style= "height: 65px;font-size: 20px;" name="crnt_oads_value_'+row+'" placeholder="ADD Dose" class="col-sm-10 padding p" /></div>' +
									'<div style= "margin-top: 20px;"  class = "col-sm-12 padding">'+
										'<div  class="col-sm-4 padding">'+
											'<div class="inline-sc" style="width: 100%;">'+
												'<span style="display: inline-block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span>'+
												'<input type="text" name="crnt_oads_condition_time_'+row+'" placeholder="" class="" style="float: left;width: 42%;text-align: center;font-size: 20px;margin-top: 0px;">'+
											'</div>'+
											
										'</div>'+
										'<div  class="col-sm-4 padding">'+
											'<div class="inline-sc" style="width: 100%;">'+
												'<select name="crnt_oads_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;width: 48%;display: inline-block;font-size: 20px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
												'<select name="crnt_oads_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;width: 48%;display: inline-block;">'+
													'<option value="আগে">আগে</option>'+
													'<option value="মাঝে">মাঝে</option>'+
													'<option value="পরে">পরে</option>'+
												'</select>'+
											'</div>'+
										'</div>'+
										'<div class="col-sm-4 padding">'+
											'<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>'+
											'<input type="text" name="crnt_oads_duration_'+row+'" style="float: left;width: 40%;margin-top: 0px;text-align: center;font-size: 20px;" class="">'+
											'<div class="inline-sc" style="width: 22%;">'+
												'<select name="crnt_oads_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="দিন">দিন</option>'+
													'<option value="মাস">মাস</option>'+
												'</select>'+
											'</div>'+
										'</div>'+
										
										'<input type="hidden" name="crnt_oads_row[]" value="'+row+'" />' +
										'<div style="clear:both"></div>' +
									'</div>'+	
									'<div style ="padding-bottom: 10px;" class="col-sm-1"><span class="htn-remove-htn" style="cursor:pointer;    background: #fff none repeat scroll 0 0;"><i class="mdi mdi-delete"></i></span></div>' +
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
			
			//load multiple insulin
			$(document).on('click', '.cntr-insulin-add-more-htn', function(){
				var lebel1 = $('.day-label').length + 1;
				var lebel2 = lebel1 + 1;
				var lebel3 = lebel1 + 2;
				var lebel4 = lebel1 + 3;
				var lebel5 = lebel1 + 4;
				var lebel6 = lebel1 + 5;
				var lebel7 = lebel1 + 6;
				var content = '<div style= "margin-top: 20px;box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p">' +
									'<div style= "margin-top: 10px;height: 70px;"  class="col-sm-12""><label class="col-sm-2 padding p"> Insulin: </label><input type="text" style= "height: 65px;font-size: 20px;"  name="crnt_insulin_name_'+row+'" placeholder="Add insulin" class=" load-drugs-insulin col-sm-10 padding p" /></div>' +
									'<div style= "height: 70px;" class="col-sm-12"><label class="col-sm-2 padding p" > Dose: </label><input type="text" value="10+10+10" style= "height: 65px;font-size: 20px;"  name="crnt_insulin_value_'+row+'" placeholder="ADD Dose" class="col-sm-10 padding p" /></div>' +
									'<div style= "margin-top: 20px;"  class = "col-sm-12 padding">'+
										'<div  class="col-sm-8 padding p">'+
											'<div class="inline-sc" style="width: 40%;">'+
												'<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span>'+
												'<input type="text" name="crnt_insulin_condition_time_'+row+'" placeholder="" class="" style="float: left;width: 42%;font-size: 20px;margin-top: -4px;margin-left: 2%;text-align: center;">'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_insulin_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_insulin_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="আগে">আগে</option>'+
													'<option value="পরে ">পরে </option>'+
													
												'</select>'+
											'</div>'+
										'</div>'+
										'<div class="col-sm-4 padding">'+
											'<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>'+
											'<input type="text" name="crnt_insulin_duration_'+row+'" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">'+
											'<div class="inline-sc" style="width: 22%;">'+
												'<select name="crnt_insulin_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="দিন">দিন</option>'+
													'<option value="মাস">মাস</option>'+
												'</select>'+
											'</div>'+
										'</div>'+
										
										'<input type="hidden" name="crnt_insulin_row[]" value="'+row+'" />' +
										'<div style="clear:both"></div>' +
									'</div>'+
									'<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >'+
										'<label class="special-insulin" style ="font-size: 20px" ><input class="special-insulin-value"  type="checkbox" name="before_sleeping_'+row+'" value="1" /> &nbsp;ঘুমানোর &nbsp; আগে &nbsp; চলবে</label>'+
									'</div>'+
									'<div style= "padding-top: 20px;"  class = "col-sm-12 padding p" >'+
										'<label class="special-insulin-week" style ="font-size: 20px" ><input class="special-insulin-value-week"  type="checkbox" name="week_'+row+'" value="1" /> &nbsp; সপ্তাহে </label>'+
										'<input type="number"  name="crnt_insulin_week_'+row+'" placeholder="" class="" style="width: 20%;font-size: 20px;margin-top: -4px;margin-left: 2%;text-align: center;">'+
										'<span style="display: inline-block;width: 15%;font-size: 20px;">দিন</span>'+
									'</div>'+
									'<div style= "padding-top: 20px;display:none;"  class = "col-sm-12 padding p" >'+
										
										'<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_'+row+'_'+lebel1+'" value="রবি" /> &nbsp; রবি </label>'+
										'<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_'+row+'_'+lebel2+'" value="সোম" /> &nbsp; সোম </label>'+
										'<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_'+row+'_'+lebel3+'" value="মঙ্গল" /> &nbsp; মঙ্গল </label>'+
										'<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_'+row+'_'+lebel4+'" value="বুধ" /> &nbsp; বুধ</label>'+
										'<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_'+row+'_'+lebel5+'" value="বৃহস্পতি" /> &nbsp; বৃহস্পতি</label>'+
										'<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_'+row+'_'+lebel6+'" value="শুক্র" /> &nbsp; শুক্র</label>'+
										'<label class="day-label" style ="font-size: 20px" ><input class=""  type="checkbox" name="day_'+row+'_'+lebel7+'" value="শনি"  /> &nbsp; শনি </label>'+
										
										'<label class="special-insulin-day" style ="font-size: 20px" ><input class="special-insulin-value-day"  type="checkbox" name="jekonodin_'+row+'" value="যে কোন দিন" /> &nbsp; যে কোন দিন </label>'+
										'<input type="hidden" name="day_array[]" value="'+lebel1+'" />'+
										'<input type="hidden" name="day_array[]" value="'+lebel2+'" />'+
										'<input type="hidden" name="day_array[]" value="'+lebel3+'" />'+
										'<input type="hidden" name="day_array[]" value="'+lebel4+'" />'+
										'<input type="hidden" name="day_array[]" value="'+lebel5+'" />'+
										'<input type="hidden" name="day_array[]" value="'+lebel6+'" />'+
										'<input type="hidden" name="day_array[]" value="'+lebel7+'" />'+
									'</div>'+
									'<div style ="padding-bottom: 10px;" class="col-sm-1"><span class="htn-remove-htn" style="cursor:pointer;    background: #fff none repeat scroll 0 0;"><i class="mdi mdi-delete"></i></span></div>' +
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
			
			
		//load multiple anti htn 
			$(document).on('click', '.cntr-htn-add-more-htn', function(){
				var content = '<div style= "margin-top: 20px;box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p">' +
									'<div style= "margin-top: 10px;height: 70px;"  class="col-sm-12""><label class="col-sm-2 padding p" > Anti-HTN: </label><input type="text" style= "height: 65px;font-size: 20px;"  name="crnt_anti_htn_name_'+row+'" placeholder="Add Anti-HTN" class="load-drugs col-sm-10 padding p" /></div>' +
									'<div style= "height: 70px;" class="col-sm-12"><label class="col-sm-2 padding p"> Dose: </label><input type="text" value="1+1+1" style= "height: 65px;font-size: 20px;"  name="crnt_anti_htn_value_'+row+'" placeholder="ADD Dose" class="col-sm-10 padding p" /></div>' +
									'<div style= "margin-top: 20px;"  class = "col-sm-12 padding p">'+
										'<div  class="col-sm-8 padding">'+
											'<div class="inline-sc" style="width: 40%;">'+
											'<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span>'+
											'<input type="text" name="crnt_anti_htn_condition_time_'+row+'" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_anti_htn_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_anti_htn_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="আগে">আগে</option>'+
													'<option value="পরে ">পরে </option>'+
													
												'</select>'+
											'</div>'+
										'</div>'+
										'<div class="col-sm-4 padding">'+
											'<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>'+
											'<input type="text" name="crnt_anti_htn_duration_'+row+'" style="float: left;width: 40%;font-size: 20px;margin-top: -10px;text-align: center;" class="">'+
											'<div class="inline-sc" style="width: 22%;">'+
												'<select name="crnt_anti_htn_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="দিন">দিন</option>'+
													'<option value="মাস">মাস</option>'+
												'</select>'+
											'</div>'+
										'</div>'+
										
										'<input type="hidden" name="crnt_anti_htn_row[]" value="'+row+'" />' +
										'<div style="clear:both"></div>' +
									'</div>'+	
									'<div style ="padding-bottom: 10px;" class="col-sm-1"><span class="htn-remove-htn" style="cursor:pointer;    background: #fff none repeat scroll 0 0;"><i class="mdi mdi-delete"></i></span></div>' +
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
			
		//load multiple anti lipids
			$(document).on('click', '.cntr-lipids-add-more-htn', function(){
				var content = '<div style= "margin-top: 20px;box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p">' +
									'<div style= "margin-top: 10px;height: 70px;"  class="col-sm-12""><label class="col-sm-2 padding p"> Anti-lipid: </label><input type="text" style= "height: 65px;font-size: 20px;" name="crnt_lipids_name_'+row+'" placeholder="Add Anti Lipids" class="load-drugs col-sm-10 padding p" /></div>' +
									'<div style= "height: 70px;" class="col-sm-12"><label class="col-sm-2 padding p" > Dose: </label><input type="text" value="1+1+1" style= "height: 65px;font-size: 20px;" name="crnt_lipids_value_'+row+'" placeholder="ADD Dose" class="col-sm-10 padding p" /></div>' +
									'<div style= "margin-top: 20px;"  class = "col-sm-12 padding p">'+
										'<div  class="col-sm-8 padding">'+
											'<div class="inline-sc" style="width: 40%;">'+
											'<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span>'+
											'<input type="text" name="crnt_lipids_condition_time_'+row+'" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_lipids_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_lipids_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="আগে">আগে</option>'+
													'<option value="পরে ">পরে </option>'+
													
												'</select>'+
											'</div>'+
										'</div>'+
										'<div class="col-sm-4 padding">'+
											'<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>'+
											'<input type="text" name="crnt_lipids_duration_'+row+'" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">'+
											'<div class="inline-sc" style="width: 22%;">'+
												'<select name="crnt_lipids_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="দিন">দিন</option>'+
													'<option value="মাস">মাস</option>'+
												'</select>'+
											'</div>'+
										'</div>'+
										
										'<input type="hidden" name="crnt_lipids_row[]" value="'+row+'" />' +
										'<div style="clear:both"></div>' +
									'</div>'+	
									'<div style ="padding-bottom: 10px;" class="col-sm-1"><span class="htn-remove-htn" style="cursor:pointer;    background: #fff none repeat scroll 0 0;"><i class="mdi mdi-delete"></i></span></div>' +
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
			
		//load multiple platelet
			$(document).on('click', '.cntr-aspirine-add-more-htn', function(){
				var content = '<div style= "margin-top: 20px;box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p">' +
									'<div style= "margin-top: 10px;height: 70px;"  class="col-sm-12""><label class="col-sm-3 padding p"> Anti-platelet: </label><input type="text" style= "height: 65px;font-size: 20px;" name="crnt_aspirine_name_'+row+'" placeholder="Add Anti Platelet" class="load-drugs col-sm-9 padding p" /></div>' +
									'<div style= "height: 70px;" class="col-sm-12 "><label class="col-sm-3 padding p"> Dose: </label><input type="text" value="1+1+1" style= "height: 65px;font-size: 20px;" name="crnt_aspirine_value_'+row+'" placeholder="ADD Dose" class="col-sm-9 padding p" /></div>' +
									'<div style= "margin-top: 20px;"  class = "col-sm-12 padding p">'+
										'<div  class="col-sm-8 padding">'+
											'<div class="inline-sc" style="width: 40%;">'+
											'<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span>'+
											'<input type="text" name="crnt_aspirine_condition_time_'+row+'" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_aspirine_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_aspirine_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="আগে">আগে</option>'+
													'<option value="পরে ">পরে </option>'+
													
												'</select>'+
											'</div>'+
										'</div>'+
										'<div class="col-sm-4 padding">'+
											'<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>'+
											'<input type="text" name="crnt_aspirine_duration_'+row+'" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">'+
											'<div class="inline-sc" style="width: 22%;">'+
												'<select name="crnt_aspirine_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="দিন">দিন</option>'+
													'<option value="মাস">মাস</option>'+
												'</select>'+
											'</div>'+
										'</div>'+
										
										'<input type="hidden" name="crnt_aspirine_row[]" value="'+row+'" />' +
										'<div style="clear:both"></div>' +
									'</div>'+	
									'<div style ="padding-bottom: 10px;" class="col-sm-1"><span class="htn-remove-htn" style="cursor:pointer;    background: #fff none repeat scroll 0 0;"><i class="mdi mdi-delete"></i></span></div>' +
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
			
		//load multiple obesity
			$(document).on('click', '.cntr-obesity-add-more-htn', function(){
				var content = '<div style= "margin-top: 20px;box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p">' +
									'<div style= "margin-top: 10px;height: 70px;"  class="col-sm-12""><label class="col-sm-3 padding p"> Anti-obesity: </label><input type="text" style= "height: 65px;font-size: 20px;" name="crnt_obesity_name_'+row+'" placeholder="Add Anti Obesity" class="load-drugs col-sm-9 padding p" /></div>' +
									'<div style= "height: 70px;" class="col-sm-12"><label class="col-sm-3 padding p"> Dose: </label><input type="text" value="1+1+1" style= "height: 65px;font-size: 20px;" name="crnt_obesity_value_'+row+'" placeholder="ADD Dose" class="col-sm-9 padding p" /></div>' +
									'<div style= "margin-top: 20px;"  class = "col-sm-12 padding p">'+
										'<div  class="col-sm-8 padding p">'+
											'<div class="inline-sc" style="width: 40%;">'+
											'<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span>'+
											'<input type="text" name="crnt_obesity_condition_time_'+row+'" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_obesity_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_obesity_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="আগে">আগে</option>'+
													'<option value="পরে ">পরে </option>'+
													
												'</select>'+
											'</div>'+
										'</div>'+
										'<div class="col-sm-4 padding">'+
											'<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>'+
											'<input type="text" name="crnt_obesity_duration_'+row+'" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">'+
											'<div class="inline-sc" style="width: 22%;">'+
												'<select name="crnt_obesity_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="দিন">দিন</option>'+
													'<option value="মাস">মাস</option>'+
												'</select>'+
											'</div>'+
										'</div>'+
										
										'<input type="hidden" name="crnt_obesity_row[]" value="'+row+'" />' +
										'<div style="clear:both"></div>' +
									'</div>'+	
									'<div style ="padding-bottom: 10px;" class="col-sm-1"><span class="htn-remove-htn" style="cursor:pointer;    background: #fff none repeat scroll 0 0;"><i class="mdi mdi-delete"></i></span></div>' +
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
			
		//load multiple other 
			$(document).on('click', '.cntr-other-add-more-htn', function(){
				var content = '<div style= "margin-top: 20px;box-shadow: 0px 0px 4px rgb(0 0 0 / 70%);"  class = "col-sm-12 padding p">' +
									'<div style= "margin-top: 10px;height: 70px;"  class="col-sm-12""><label class="col-sm-2 padding p" > Others: </label><input type="text" style= "height: 65px;font-size: 20px;" name="crnt_other_name_'+row+'" placeholder="Add Others" class="load-drugs col-sm-10 padding p" /></div>' +
									'<div style= "height: 70px;" class="col-sm-12"><label class="col-sm-2 padding p"> Dose: </label><input type="text" value="1+1+1" style= "height: 65px;font-size: 20px;" name="crnt_other_value_'+row+'" placeholder="ADD Dose" class="col-sm-10 padding p" /></div>' +
									'<div style= "margin-top: 20px;"  class = "col-sm-12 padding p">'+
										'<div  class="col-sm-8 padding p">'+
											'<div class="inline-sc" style="width: 40%;">'+
											'<span style="display: block;width: 55%;float: left;font-size: 20px;">খাওয়ার</span>'+
											'<input type="text" name="crnt_other_condition_time_'+row+'" placeholder="" class="" style="float: left;width: 45%;font-size: 20px;margin-top: -4px;text-align: center;">'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_other_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="মিনিট">মিনিট</option>'+
													'<option value="ঘন্টা">ঘন্টা</option>'+
												'</select>'+
											'</div>'+
											'<div class="inline-sc" style="width: 25%;">'+
												'<select name="crnt_other_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="আগে">আগে</option>'+
													'<option value="পরে ">পরে </option>'+
													
												'</select>'+
											'</div>'+
										'</div>'+
										'<div class="col-sm-4 padding">'+
											'<span style="display: block;width: 32%;float: left;font-size: 20px;">চলবে</span>'+
											'<input type="text" name="crnt_other_duration_'+row+'" style="float: left;width: 40%;font-size: 20px;margin-top: -4px;text-align: center;" class="">'+
											'<div class="inline-sc" style="width: 22%;">'+
												'<select name="crnt_other_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -4px;font-size: 20px;">'+
													'<option value="দিন">দিন</option>'+
													'<option value="মাস">মাস</option>'+
												'</select>'+
											'</div>'+
										'</div>'+
										
										'<input type="hidden" name="crnt_other_row[]" value="'+row+'" />' +
										'<div style="clear:both"></div>' +
									'</div>'+
									'<div style ="padding-bottom: 10px;" class="col-sm-1"><span class="htn-remove-htn" style="cursor:pointer;    background: #fff none repeat scroll 0 0;"><i class="mdi mdi-delete"></i></span></div>' +
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
			//load drug
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
			//load insulin
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
			// oads input field display controller
			$(document).on('click', '.sel-sympt-9-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').show();
					$('.input-row-fields-10-cntr').hide();
					$('.input-row-fields-cntr').hide();
					$('.input-row-fields-2-cntr').hide();
					$('.input-row-fields-4-cntr').hide();
					$('.input-row-fields-3-cntr').hide();
					$('.input-row-fields-5-cntr').hide();
					
					location.href = "#page_no";
				}else if(check_val == '0')
				{
					$('.input-row-fields-9-cntr').hide();
				}
			});
		//insulin input field display controller
			$(document).on('click', '.sel-sympt-10-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').hide();
					$('.input-row-fields-10-cntr').show();
					$('.input-row-fields-cntr').hide();
					$('.input-row-fields-2-cntr').hide();
					$('.input-row-fields-4-cntr').hide();
					$('.input-row-fields-3-cntr').hide();
					$('.input-row-fields-5-cntr').hide();
					
					location.href = "#page_no";
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
			
		//anti htn input field display controller
			$(document).on('click', '.sel-sympt-4-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').hide();
					$('.input-row-fields-10-cntr').hide();
					$('.input-row-fields-cntr').show();
					$('.input-row-fields-2-cntr').hide();
					$('.input-row-fields-4-cntr').hide();
					$('.input-row-fields-3-cntr').hide();
					$('.input-row-fields-5-cntr').hide();
					
					location.href = "#page_no";
				}else if(check_val == '0')
				{
					$('.input-row-fields-cntr').hide();
				}
			});
			
		//anti lipid input field display controller
			$(document).on('click', '.sel-sympt-5-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').hide();
					$('.input-row-fields-10-cntr').hide();
					$('.input-row-fields-cntr').hide();
					$('.input-row-fields-2-cntr').show();
					$('.input-row-fields-4-cntr').hide();
					$('.input-row-fields-3-cntr').hide();
					
					location.href = "#page_no";
				}else if(check_val == '0')
				{
					$('.input-row-fields-2-cntr').hide();
				}
			});
		
		//anti obesity input field display controller
			$(document).on('click', '.sel-sympt-7-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').hide();
					$('.input-row-fields-10-cntr').hide();
					$('.input-row-fields-cntr').hide();
					$('.input-row-fields-2-cntr').hide();
					$('.input-row-fields-4-cntr').show();
					$('.input-row-fields-3-cntr').hide();
					$('.input-row-fields-5-cntr').hide();
					
					location.href = "#page_no";
				}else if(check_val == '0')
				{
					$('.input-row-fields-4-cntr').hide();
				}
			});
			
		//anti platelet input field display controller
			$(document).on('click', '.sel-sympt-6-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').hide();
					$('.input-row-fields-10-cntr').hide();
					$('.input-row-fields-cntr').hide();
					$('.input-row-fields-2-cntr').hide();
					$('.input-row-fields-4-cntr').hide();
					$('.input-row-fields-3-cntr').show();
					$('.input-row-fields-5-cntr').hide();
					
					location.href = "#page_no";
				}else if(check_val == '0')
				{
					$('.input-row-fields-3-cntr').hide();
				}
			});
			
		//anti platelet input field display controller
			$(document).on('click', '.sel-sympt-8-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').hide();
					$('.input-row-fields-10-cntr').hide();
					$('.input-row-fields-cntr').hide();
					$('.input-row-fields-2-cntr').hide();
					$('.input-row-fields-4-cntr').hide();
					$('.input-row-fields-3-cntr').hide();
					$('.input-row-fields-5-cntr').show();
					
					location.href = "#page_no";
				}else if(check_val == '0')
				{
					$('.input-row-fields-5-cntr').hide();
				}
			});
	});
	
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			//load investigation
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
	
		$(document).ready(function(){
			$(document).on('click', '.lab-investigation', function(){
				var row = $('.lab-inv-item').length+1;
				var inp_name = $('#labInvestigationName').val();
				var inp_value = $('#labInvestigationUnit').val();
				
				if(inp_name !== '')
				{
					var content = '<div class = "col-sm-12 lab-inv-item padding p" style= "height: 40px">' +
									'<div style= "padding-right: 5px;width: 30%;" class = "col-sm-5 padding p" >' +
										'<label >'+inp_name+'</label>' +
									'</div>' +
									'<div class="col-sm-7 padding p">' +
										'<input type="text" style= "height: 35px;font-size: 20px;width: 100%;" class= "wir" name="labinv_row_value_'+row+'" placeholder="'+inp_value+'" />' +
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
			
			$(document).on('click', '.rmv-itm', function(){
				$(this).parent().remove();
			});
			
		});
	</script>
	<script type="text/javascript">
	$(document).ready(function(){
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
			$(document).on('click', '.special-insulin', function(){
				if($('input.special-insulin-value').is(":checked"))
				{
					$(this).parent().prev('div').hide();
					$(this).parent().next('div').hide();
				}else{
					$(this).parent().prev('div').show();
					$(this).parent().next('div').show();
				}
			});
			
			$(document).on('click', '.refer-lebel', function(){
				if($('input.refer-input').is(":checked"))
				{
					$('.refer').show();
					$('.refer-button-container').show();
					//$(this).parent().prev('div').hide();
					//$(this).parent().next('div').hide();
				}else{
					//$(this).parent().prev('div').show();
					//$(this).parent().next('div').show();
					$('.refer').hide();
					$('.refer-button-container').hide();
				}
			});
			
			$(document).on('click', '.special-insulin-week', function(){
				if($('input.special-insulin-value-week').is(":checked"))
				{
					$(this).parent().prev('div').hide();
					$(this).parent().next('div').show();
					$(this).parent().prev().prev('div').hide();
				}else{
					$(this).parent().prev('div').show();
					$(this).parent().next('div').hide();
					$(this).parent().prev().prev('div').show();
				}
			});
			$(document).on('click', '.special-insulin-day', function(){
				if($('input.special-insulin-value-day').is(":checked"))
				{
					$(this).prev('label').hide();
					$(this).prev().prev('label').hide();
					$(this).prev().prev().prev('label').hide();
					$(this).prev().prev().prev().prev('label').hide();
					$(this).prev().prev().prev().prev().prev('label').hide();
					$(this).prev().prev().prev().prev().prev().prev('label').hide();
					$(this).prev().prev().prev().prev().prev().prev().prev('label').hide();
					
					$(this).prev('label').children('input').prop('checked',false).trigger('change');
					$(this).prev().prev('label').children('input').prop('checked',false).trigger('change');
					$(this).prev().prev().prev('label').children('input').prop('checked',false).trigger('change');
					$(this).prev().prev().prev().prev('label').children('input').prop('checked',false).trigger('change');
					$(this).prev().prev().prev().prev().prev('label').children('input').prop('checked',false).trigger('change');
					$(this).prev().prev().prev().prev().prev().prev('label').children('input').prop('checked',false).trigger('change');
					$(this).prev().prev().prev().prev().prev().prev().prev('label').children('input').prop('checked',false).trigger('change');
				}else{
					$(this).prev('label').show();
					$(this).prev().prev('label').show();
					$(this).prev().prev().prev('label').show();
					$(this).prev().prev().prev().prev('label').show();
					$(this).prev().prev().prev().prev().prev('label').show();
					$(this).prev().prev().prev().prev().prev().prev('label').show();
					$(this).prev().prev().prev().prev().prev().prev().prev('label').show();
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
	$(document).ready(function(){
		$(document).on('change', '.check-date-is-valid', function(){
					var getValue = $(this).val();
					var splitDate = getValue.split('/');
					if(checkDate(splitDate[0], splitDate[1], splitDate[2]) == 'YES')
					{
						$(this).val('');
					}
				});
		});
	
	</script>
	<script type="text/javascript">
	$('#add-investigation').click(function() {
		if ($('#first').val()!==''){
    $('#first').val($('#first').val() + ','+$('#second').val());
    $('#second').val(null);
		}else {
			$('#first').val($('#second').val());
			
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
	
	
<?php require_once APPPATH.'modules/common/footer.php' ?>