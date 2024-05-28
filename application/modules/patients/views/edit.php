<?php
	$get_info = $this->Patient_model->get_info($id);
	if($get_info != true)
	{
		redirect('not-found');
	}
?>
<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Patients</li>
				<li class="active">Edit</li>
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
		<input type="hidden" name="id" value="<?php echo $get_info['patient_id']; ?>" />
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
										<input type="text" class="form-control check-alphabetic-charactars" name="full_name" value="<?php echo $get_info['patient_name']; ?>" placeholder="Full Name" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Mobile No <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<input type="text" class="form-control check-numeric-charactars" name="phone" value="<?php echo $get_info['patient_phone']; ?>" placeholder="Mobile Number (Maximum Digit : 11)" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Email Address</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="email" value="<?php echo $get_info['patient_email']; ?>" placeholder="Email Address" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Previous Center ID</label>
									<div class="col-md-7">
										<input type="text" name="patient_idby_center" value="<?php echo $get_info['patient_idby_center']; ?>" placeholder="Previous Center ID" class="form-control">
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
								<div class="form-group">
									<label class="control-label col-md-5">Organization <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="organization" class="form-control" id="selectedOrganization">
											<option value="" selected="selected">Select Organization</option>
											<?php 
												$orgs = $this->Patient_model->get_all_organizations();
												foreach($orgs as $org):
											?>
											<option value="<?php echo $org['org_id']; ?>" <?php echo ($get_info['patient_org_id'] && $get_info['patient_org_id'] == $org['org_id'])? 'selected' : null; ?>><?php echo $org['org_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Center <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="center" class="form-control" id="cenTers">
											<option value="" selected="selected">Select Center</option>
											<?php if($get_info['patient_org_id']): ?>
												<?php 
													$centers = $this->Patient_model->get_all_centers($get_info['patient_org_id']);
													foreach($centers as $center):
												?>
												<option value="<?php echo $center['orgcenter_id']; ?>" <?php echo ($get_info['patient_org_centerid'] && $get_info['patient_org_centerid'] == $center['orgcenter_id'])? 'selected' : null; ?>><?php echo $center['orgcenter_name']; ?></option>
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
										<input type="text" name="registration_date" value="<?php echo formated_date($get_info['patient_registration_date']); ?>" placeholder="DD/MM/YYYY" class="form-control datepicker check-date-is-valid" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Date Of Birth</label>
									<div class="col-md-7">
										<input type="text" id="dateOfBirth" name="dateof_birth" value="<?php echo formated_date($get_info['patient_dateof_birth']); ?>" placeholder="DD/MM/YYYY" class="form-control datepicker">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Age</label>
									<div class="col-md-7">
										<input type="text" id="patientAge" name="age" value="<?php echo $get_info['patient_age']; ?>" placeholder="e.g. 25" class="form-control check-numeric-charactars">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">National ID</label>
									<div class="col-md-7">
										<input type="text" name="nid" value="<?php echo $get_info['patient_nid']; ?>" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Gender <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="gender" class="form-control">
											<option value="0" <?php echo ($get_info['patient_gender'] === '0')? 'selected' : null; ?>>Male</option>
											<option value="1" <?php echo ($get_info['patient_gender'] === '1')? 'selected' : null; ?>>Female</option>
											<option value="2" <?php echo ($get_info['patient_gender'] === '2')? 'selected' : null; ?>>Other</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Patient Guide Book No</label>
									<div class="col-md-7">
										<input type="text" name="guide_book" value="<?php echo $get_info['patient_guide_book']; ?>" class="form-control">
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
									<label class="control-label col-md-5">Division <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="division" class="form-control" id="selectedDivision">
											<option value="" selected="selected">Select Division</option>
											<?php 
												$divisions = $this->Organization_model->get_all_divisions();
												foreach($divisions as $division):
											?>
											<option value="<?php echo $division['division_id']; ?>" <?php echo ($get_info['patient_division_id'] == $division['division_id'])? 'selected' : null; ?>><?php echo $division['division_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">District <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<?php 
											$districts = $this->Organization_model->get_all_districts($get_info['patient_division_id']);
										?>
										<select name="district" class="form-control" id="selectedDistrict">
											<option value="" selected="selected">Select District</option>
											<?php foreach($districts as $district): ?>
											<option value="<?php echo $district['district_id']; ?>" <?php echo ($get_info['patient_district_id'] == $district['district_id'])? 'selected' : null; ?>><?php echo $district['district_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Upazila</label>
									<div class="col-md-7">
										<?php 
											$upazilas = $this->Organization_model->get_all_upazilas($get_info['patient_district_id']);
										?>
										<select name="upazila" class="form-control" id="selectedUpazila">
											<option value="" selected="selected">Select Upazila</option>
											<?php foreach($upazilas as $upazila): ?>
											<option value="<?php echo $upazila['upazila_id']; ?>" <?php echo ($get_info['patient_upazila_id'] == $upazila['upazila_id'])? 'selected' : null; ?>><?php echo $upazila['upazila_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Address</label>
									<div class="col-md-7">
										<textarea name="address" class="form-control" id="" cols="30" rows="3"><?php echo $get_info['patient_address']; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Postal Code</label>
									<div class="col-md-7">
										<input type="text" name="postal_code" value="<?php echo $get_info['patient_postal_code']; ?>" placeholder="Postal Code" class="form-control">
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
												$expnds = $this->Patient_model->get_monthly_expenditures();
												foreach($expnds as $expnd):
											?>
											<option value="<?php echo $expnd['expenditure_title']; ?>" <?php echo ($get_info['profinfo_mothly_income'] == $expnd['expenditure_title'])? 'selected' : null; ?>><?php echo $expnd['expenditure_title']; ?></option>
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
												$prffs = $this->Patient_model->get_professions();
												foreach($prffs as $prff):
											?>
											<option value="<?php echo $prff['profession_title']; ?>" <?php echo ($get_info['profinfo_profession'] == $prff['profession_title'])? 'selected' : null; ?>><?php echo $prff['profession_title']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Education</label>
									<div class="col-md-7">
										<select name="education" class="form-control">
											<option value="">Select Education</option>
											<?php
												$educats = $this->Patient_model->get_educations();
												foreach($educats as $educat):
											?>
											<option value="<?php echo $educat['education_title']; ?>" <?php echo ($get_info['profinfo_education'] == $educat['education_title'])? 'selected' : null; ?>><?php echo $educat['education_title']; ?></option>
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
		<div class="col-lg-2">
			<div class="sticky-sidebar" style="width:225px;">
				<ul id="stickyNavSection">
					<li class="active"><a href="#basicInformation">Basic Information</a></li>
					<li><a href="#locationAddress">Address</a></li>
					<li><a href="#professionalInformation">Professional Information</a></li>
				</ul>
				
				<ul class="submit-ul">
					<input type="hidden" id="chkRdr" name="submitType" />
					<li><span class="check-save" data-save-method="save" data-toggle="modal" data-target=".bs-example-modal-sm">Update</span></li>
					<li><span class="check-save" data-save-method="saveexit" data-toggle="modal" data-target=".bs-example-modal-sm">Update & Exit</span></li>
					<li><span class="check-save" onclick="window.location.href='<?php echo base_url('patients'); ?>'">Cancel</span></li>
				</ul>
				
				<div class="visit-add-bt">
					<a class="add-vst-button pull-right" href="<?php echo base_url('patients/visit/add/'.$get_info['patient_id'].'/'.$get_info['patient_entryid']); ?>"><i class="fa fa-plus-square"></i> ADD NEW VISIT</a>
				</div>
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
							<input type="hidden" name="fee_amount" value="<?php echo $get_info['patient_regfee_amount']; ?>" />
							<label><input type="radio" value="1" name="payment" <?php echo ($get_info['patient_payment_status'] == '1')? 'checked' : null; ?> />&nbsp;&nbsp;Paid</label> &nbsp;&nbsp;
							<label><input type="radio" value="0" name="payment" <?php echo ($get_info['patient_payment_status'] == '0')? 'checked' : null; ?> />&nbsp;&nbsp;Unpaid</label> &nbsp;&nbsp;
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
		<!-- /.modal -->
		<?php echo form_close(); ?>
	</div>
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
						division:{
							required: true,
						},
						district:{
							required: true,
						},
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
						division:{
							required: null,
						},
						district:{
							required: null,
						},
					},
					submitHandler : function () {
						$('#loader').show();
						// your function if, validate is success
						$.ajax({
							type : "POST",
							url : baseUrl + "patients/update",
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
									$('#loader').hide();
									if(data.exit == '1')
									{
										window.location.href=baseUrl+'patients';
									}
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