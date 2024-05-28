<?php require_once APPPATH.'modules/common/header.php' ?>
<?php //require_once APPPATH.'modules/barcode/vendor/autoload.php';?>

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
	
	<div  class = 'printContainer' style = " display: flex;justify-content: center;margin-bottom: 10px;">
		<div id="qrcode" style = '    margin-right: 2%;'></div>
		<input type="submit" value="Print QR Code" id="qr-gn" style = 'display: none;'>
	</div>
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<?php 
			$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm', 'style' => 'padding:0 5%;');
			echo form_open('', $attr);
		?>
		

		
		<div class="col-lg-10">
			<div id="alert"></div>
			<div class="panel panel-default block2" id="basicInformation">
				<div class="panel-heading text-center">BASIC INFORMATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Full Name <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" class="form-control check-alphabetic-charactars" name="full_name" placeholder="Full Name" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Mobile No <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" class="form-control check-numeric-charactars" name="phone" placeholder="Mobile Number (Maximum Digit : 11)" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Email Address</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="email" placeholder="Email Address" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Previous Center ID <?php if( $this->session->userdata('user_org_center_id') === '14'):?><span style="color:#f00">*</span><?php endif;?></label>
									<div class="col-md-7">
										<input type="text" name="patient_center_id" placeholder="Previous Center ID" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Marital Status <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="marital_staus" class="form-control">
											<option value="Married" selected="selected">Married</option>
											<option value="Unmarried">Unmarried</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								<?php 
									//check user is operator
									$user_type = $this->session->userdata('user_type');
									if($user_type == 'Operator')
									{
										$active_user_org = $this->session->userdata('user_org_id');
									}elseif($user_type == 'Assistant'){
										$active_user_org = $this->session->userdata('user_org_id');
									}elseif($user_type == 'Doctor'){
										$active_user_org = $this->session->userdata('user_org_id');
									}elseif($user_type == 'Org Admin'){
										$active_user_org = $this->session->userdata('user_org_id');
									}else{
										$active_user_org = null;
									}
								?>
								<div class="form-group">
									<label class="control-label col-md-5">Organization <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="organization" class="form-control" id="selectedOrganization">
											<option value="" selected="selected">Select Organization</option>
											<?php 
												$orgs = $this->Patient_model->get_all_organizations();
												foreach($orgs as $org):
											?>
											<option value="<?php echo $org['org_id']; ?>" <?php echo ($active_user_org == $org['org_id'])? 'selected' : null; ?>><?php echo $org['org_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Center <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="center" class="form-control" id="cenTers">
											<option value="" selected="selected">Select Center</option>
											<?php if($active_user_org !== null): ?>
												<?php 
													$centers = $this->Patient_model->get_all_centers($active_user_org);
													$org_center_id = $this->session->userdata('user_org_center_id');
													foreach($centers as $center):
												?>
												<option value="<?php echo $center['orgcenter_id']; ?>" <?php echo ($org_center_id == $center['orgcenter_id'])? 'selected' : null; ?>><?php echo $center['orgcenter_name']; ?></option>
												<?php endforeach; ?>
											<?php endif; ?>
											
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Date</label>
									<div class="col-md-7">
										<input type="text" name="registration_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" class="form-control datepicker check-date-is-valid" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Date Of Birth</label>
									<?php if($this->session->userdata('user_type') === 'Doctor'):?>
									<div class="col-md-7">
										<input type="text" id="dateOfBirth" name="dateof_birth" placeholder="Day/Month/Year Ex: 01/01/2022" class="form-control">
									</div>
									<?php else :?>
									<div class="col-md-7">
										<input type="text" id="dateOfBirth" name="dateof_birth" placeholder="DD/MM/YYYY" class="form-control datepicker">
									</div>
									<?php endif;?>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Age</label>
									<div class="col-md-7">
										<input type="text" id="patientAge" name="age" placeholder="e.g. 25" class="form-control check-numeric-charactars">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">National ID</label>
									<div class="col-md-7">
										<input type="text" name="nid" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Gender <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="gender" class="form-control">
											<option value="0" selected="selected">Male</option>
											<option value="1">Female</option>
											<option value="2">Other</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Patient Guide Book No</label>
									<div class="col-md-7">
										<input type="text" name="guide_book" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default block2" id="locationAddress">
				<div class="panel-heading text-center">ADDRESS</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Division 
									<?php if($this->session->userdata('user_type') !== 'Doctor'):?>
										<span style="color:#f00">*</span>
									<?php endif;?>
									</label>
									<div class="col-md-7">
										<select name="division" class="form-control" id="selectedDivision">
											<option value="" selected="selected">Select Division</option>
											<?php 
												$divisions = $this->Organization_model->get_all_divisions();
												foreach($divisions as $division):
											?>
											<option value="<?php echo $division['division_id']; ?>"><?php echo $division['division_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">District 
									<?php if($this->session->userdata('user_type') !== 'Doctor'):?>
										<span style="color:#f00">*</span>
									<?php endif;?>
									</label>
									<div class="col-md-7">
										<select name="district" class="form-control" id="selectedDistrict">
											<option value="" selected="selected">Select District</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Upazila</label>
									<div class="col-md-7">
										<select name="upazila" class="form-control" id="selectedUpazila">
											<option value="" selected="selected">Select Upazila</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Address</label>
									<div class="col-md-7">
										<textarea name="address" class="form-control" id="" cols="30" rows="3"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Postal Code</label>
									<div class="col-md-7">
										<input type="text" name="postal_code" placeholder="Postal Code" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default block2" id="professionalInformation">
				<div class="panel-heading text-center">PROFESSIONAL INFORMATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Monthly Expenditure</label>
									<div class="col-md-7">
										<select name="income" class="form-control">
											<option value="">Select Monthly Expenditure</option>
											<?php 
												//$expnds = array('below 10,000', '10,000 - 20,000', '20,000 - 30, 000', '30, 000 - 40,000', '40,000 - 50,000', '50,000 & Above');
												$expnds = $this->Patient_model->get_monthly_expenditures();
												foreach($expnds as $expnd):
											?>
											<option value="<?php echo $expnd['expenditure_title']; ?>"><?php echo $expnd['expenditure_title']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Profession</label>
									<div class="col-md-7">
										<select name="profession" class="form-control">
											<option value="">Select Profession</option>
											<?php 
												//$prffs = array('Employed', 'Unemployed', 'Home Maker', 'Student', 'Retired');
												$prffs = $this->Patient_model->get_professions();
												foreach($prffs as $prff):
											?>
											<option value="<?php echo $prff['profession_title']; ?>"><?php echo $prff['profession_title']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6 " >
								<div class="form-group">
									<label class="control-label col-md-5">Education</label>
									<div class="col-md-7">
										<select name="education" class="form-control">
											<option value="">Select Education</option>
											<?php 
												//$educats = array('No formal education', '1-5 years', '5-10 years', '10-12 years', '12-16 years', 'More than 16 years');
												$educats = $this->Patient_model->get_educations();
												foreach($educats as $educat):
											?>
											<option value="<?php echo $educat['education_title']; ?>"><?php echo $educat['education_title']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $payment_config = $this->Patient_model->get_config(); ?>
		</div>
		<div class="col-lg-2 dsp laptop">
			<div class="sticky-sidebar" style="width:225px;">
				<ul id="stickyNavSection">
					<li class="active"><a href="#basicInformation">Basic Information</a></li>
					<li><a href="#locationAddress">Address</a></li>
					<li><a href="#professionalInformation">Professional Information</a></li>
				</ul>
				
				<ul class="submit-ul">
					<input type="hidden" id="chkRdr" name="submitType" />
					<li><span class="check-save" data-save-method="save" data-toggle="modal" data-target=".bs-example-modal-sm">Save</span></li>
					<li><span class="check-save" data-save-method="saveexit" data-toggle="modal" data-target=".bs-example-modal-sm">Save & Exit</span></li>
					<li><span class="check-save" onclick="window.location.href='<?php echo base_url('patients'); ?>'">Cancel</span></li>
				</ul>
				
				<div class="visit-add-bt" id="visitAddBt"></div>
			</div>
		</div>
		<!-- sample modal content -->
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="mySmallModalLabel" style="font-size: 15px;">Registration Fee (BDT <?php echo ($payment_config['config_option'])? $payment_config['config_option'] : 0; ?>)</h4> 
					</div>
					<div class="modal-body text-center">
						<p>
							<input type="hidden" name="fee_amount" value="<?php echo ($payment_config['config_option'])? $payment_config['config_option'] : 0; ?>" />
							<label><input type="radio" value="1" name="payment" checked />&nbsp;&nbsp;Paid</label> &nbsp;&nbsp;
							<label><input type="radio" value="0" name="payment" />&nbsp;&nbsp;Unpaid</label> &nbsp;&nbsp;
						</p>
					</div>
					<div class="modal-footer">
						<span class="btn btn-default waves-effect" data-dismiss="modal">Cancel</span>
						<button type="submit" class="btn btn-info confirm-payment submit-type" data-save-method="">Confirm</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="col-lg-2 mobile " >
			<div class="sticky-sidebar" style="width:225px;position: static;">
				
				
				<ul class="submit-ul">
					<input type="hidden" id="chkRdr" name="submitType" />
					<li><span class="check-save" data-save-method="save" data-toggle="modal" data-target=".bs-example-modal-sm">Save</span></li>
					<li><span class="check-save" data-save-method="saveexit" data-toggle="modal" data-target=".bs-example-modal-sm">Save & Exit</span></li>
					<li><span class="check-save" onclick="window.location.href='<?php echo base_url('patients'); ?>'">Cancel</span></li>
				</ul>
				
				<div class="visit-add-bt" id="visitAddBt"></div>
			</div>
		</div>
		<!-- /.modal -->
		<?php echo form_close(); ?>
	</div>
	
	<script >
		$(function(){
			$("#qr-gn").click(function(){
			 //alert('hello');
			 
				 var bndrId =  $('#entry').val();
				 var width = 160;
				 var height = 160;
			  var divToPrint=document.getElementById('printqr');
			  
			  $.ajax({
					type : "POST",
					url : baseUrl + "register/qr_code",
					data : {id: bndrId},
					dataType : "json",
					success : function (data) {
						//alert(data.id);
						
						}
					});

			  //var newWin=window.open('','Print-Window');

			  //newWin.document.open();

			  document.write('<html><body class="loadQr" onload="window.print()"></body></html>');
			  $('.loadQr').qrcode({width: width,height: height,text: bndrId});
			  
				
			  document.close();

			  setTimeout(function(){close();},10);
			  document.location.href = baseUrl+'administrator/dashboard';
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
				
				$("#createForm").validate({
					rules:{
						first_name:{
							required: true,
						},
						registration_date:{
							required: true,
						},
						last_name:{
							required: true,
						},
						phone:{
							required: true,
							number: true,
							maxlength: 13,
						},
						emg_phone:{
							number: true,
						},
						organization:{
							required: true,
						},
						marital_staus:{
							required: true,
						},
						nid:{
							number: true,
						},
						
						<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
						division:{
							required: true,
						},
						district:{
							required: true,
						},
						<?php endif;
						 if( $this->session->userdata('user_org_center_id') === '14'):?>
						 patient_center_id:{
							required: true,
						},
						<?php endif;?>
					},
					messages:{
						first_name:{
							required: null,
						},
						registration_date:{
							required: null,
						},
						last_name:{
							required: null,
						},
						phone:{
							required: null,
							number: null,
							maxlength:null,
						},
						emg_phone:{
							number: null,
						},
						organization:{
							required: null,
						},
						marital_staus:{
							required: null,
						},
						nid:{
							number: null,
						},
						
						<?php if( $this->session->userdata('user_type') !== 'Doctor'):?>
						division:{
							required: null,
						},
						district:{
							required: null,
						},
						<?php endif;
						if( $this->session->userdata('user_org_center_id') === '14'):?>
						patient_center_id:{
							required: 'This field is required',
						},
						<?php endif;?>
					},
					submitHandler : function () {
						$('#loader').show();
						// your function if, validate is success
						$.ajax({
							type : "POST",
							url : baseUrl + "patients/save",
							data : $('#createForm').serialize(),
							dataType : "json",
							cache: false,
							success : function (data) {
								if(data.status == "ok")
								{
									$('html, body').animate({
										scrollTop: $("body").offset().top
									 }, 1000);
									document.getElementById('createForm').reset();
									$('#alert').html(data.success);
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									redirect_t_p = '';
									$('#loader').hide();
									$('.qrcodeConatiner').show();
									$('#qr-gn').show();
									$("#qrcode").html("");
									var width = 50;
									var height = 50;
									<?php if( $this->session->userdata('user_type') === 'Doctor'):?>
									window.location.href=baseUrl+'patients/progress/add/'+data.patient_id+'/'+data.entry_ID;
									<?php else:?>
									if(data.exit == '1')
									{
										window.location.href=baseUrl+'patients';
									}else
									{
										$('#visitAddBt').html(data.addvisit);
										$('#qrcode').qrcode({width: width,height: height,text: data.entry_ID});
										$('.printContainer').append(data.inputEntry);
										//$('.barcode').html(data.barcode);
									}
									<?php endif;?>
									$('.bs-example-modal-sm').modal('hide');
									return false;
								}else if(data.status == "error"){
									$('html, body').animate({
										scrollTop: $("body").offset().top
									 }, 1000);
									$('#alert').html(data.error);
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									$('#loader').hide();
									redirect_t_p = '';
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
			
			//Get Age
			$(document).on('change', '#dateOfBirth', function(){
				
				var date_digit = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "patients/get_age",
					data : {date_digit:date_digit},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							if(data.content < 3)
							{
								alert("Minimum 3 years old is allowed!");
								$('#dateOfBirth').val('');
								$('#patientAge').val('');
								return false;
							}else if(data.content > 130){
								alert("Maximum 130 years old is allowed!");
								$('#dateOfBirth').val('');
								$('#patientAge').val('');
								return false;
							}else{
								$('#patientAge').val(data.content);
							}
							return false;
						}else
						{
							//have end check.
						}
						return false;
					}
				});
				
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
			$(".check-alphanumeric-charactars").keydown(function (e) {
				// Allow: backspace, delete, tab, escape and enter
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 188, 32, 190]) !== -1 ||
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
			
			$(".check-numeric-charactars").keydown(function (e) {
				// Allow: backspace, delete, tab, escape and enter
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 188, 32, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
			$(".check-alphabetic-charactars").keydown(function (e) {
				// Allow: backspace, delete, tab, escape and enter
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 188, 32, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39) || (e.keyCode >= 65 && e.keyCode <= 90)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 65 || e.keyCode > 90))) {
					e.preventDefault();
				}
			});
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>