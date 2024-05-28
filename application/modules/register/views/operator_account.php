<!DOCTYPE html>
<html>
<head>
<title>Registration | Nationwide Electronic Registry</title>
<!-- For-Mobile-Apps -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //For-Mobile-Apps -->

<!-- Style.CSS --> <link rel="stylesheet" href="<?php echo base_url('assets/register/'); ?>css/style.css" type="text/css" media="all" />
<!-- Date picker plugins css -->
    <link href="<?php echo base_url('assets/'); ?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<!-- Web-Fonts -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
<!-- //Web-Fonts -->

<!-- Horizontal-Tabs-JavaScript -->
<script src="<?php echo base_url('assets/'); ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('assets/login/'); ?>js/jquery.validate.js"></script>
<script src="<?php echo base_url('assets/register/'); ?>js/easyResponsiveTabs.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#horizontalTab').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion           
			width: 'auto', //auto or any width like 600px
			fit: true, // 100% fit in a container
		});
	});
</script>
<!-- Horizontal-Tabs-JavaScript -->
<script type="text/javascript">
	var baseUrl = "<?php echo base_url(); ?>";
</script>
</head>
<!-- Head -->



<!-- Body -->
<body>
	<!-- Container -->
	<div class="nationwide-logo"><img src="<?php echo base_url('assets/register/tools/logo.png'); ?>" alt="Badas Logo" /> <span class="logo-label">Nationwide Electronic Registry</span></div>
	<div class="container">
		<div class="tabs">

			<div class="sap_tabs">

				<div style="display: block; width: 100%; margin: 0px;">

					<h2 class="registration-title">Data Entry Operator</h2>

					<div class="resp-tabs-container">
						<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
						<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
							<!-- Form -->
							<?php 
								$attr = array('class' => 'user-reg', 'id' => 'operatorRegistry');
								echo form_open('', $attr);
							?>
								<div id="alert"></div>
								<input type="text" name="full_name" placeholder="Full Name">
								<input type="text" name="phone" placeholder="Phone Number">
								<input type="text" name="dateof_birth" class="datepicker" placeholder="Date Of Birth">
								<div class="select_option">
									<select name="organization" class="form-control" id="selectedOrganization">
										<option value="" selected="selected">Select Organization</option>
										<?php 
											$organizations = $this->Register_model->get_all_organizations();
											foreach($organizations as $org):
										?>
										<option value="<?php echo $org['org_id']; ?>"><?php echo $org['org_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="select_option">
									<select name="center" class="form-control" id="cenTers">
										<option value="" selected="selected">Select Center</option>
									</select>
								</div>
								<div class="legend-devider"><span>Location Information</span></div>
								<div class="select_option">
									<select name="division" class="form-control" id="selectedDivision">
										<option value="" selected="selected">Select Division</option>
										<?php 
											$divisions = $this->Register_model->get_all_divisions();
											foreach($divisions as $division):
										?>
										<option value="<?php echo $division['division_id']; ?>"><?php echo $division['division_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="select_option">
									<select name="district" class="form-control" id="selectedDistrict">
										<option value="" selected="selected">Select District</option>
									</select>
								</div>
								<div class="select_option">
									<select name="upazila" class="form-control" id="selectedUpazila">
										<option value="" selected="selected">Select Upazila</option>
									</select>
								</div>
								<textarea name="address" id="" cols="30" rows="3" placeholder="Address"></textarea>
								<input type="text" name="postal_code" placeholder="Postal Code">
								<div class="legend-devider"><span>Login Information</span></div>
								<input type="text" name="email" placeholder="Email">
								<input type="password" name="password" placeholder="Password" id="password">
								<input type="password" name="password_again" placeholder="Re-enter Password">
								
								<input type="submit" value="CREATE ACCOUNT" style="margin-top:35px;">
								<div class="new-acc">
									<span>Already have an account? <a href="<?php echo base_url('login/type/user'); ?>"><strong>Back to login</strong></a></span>
								</div>
							<?php echo form_close(); ?>
							<!-- //Form -->
						</div>
					</div>

				</div>

			</div>

		</div>

	</div>
	<!-- //Container -->



	<!-- Footer -->
	<div class="footer">

		<!-- Copyright -->
		<div class="copyright">
			<p> &copy; 2018 Nationwide Electronic Registry.</p>
		</div>
		<!-- //Copyright -->

	</div>
	<!-- //Footer -->
	<script src="<?php echo base_url('assets/'); ?>bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.datepicker').datepicker({
				autoclose: true,
				todayHighlight: true,
				format: 'yyyy-mm-dd',
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#operatorRegistry").validate({
				rules:{
					full_name:{
						required: true,
					},
					phone:{
						required: true,
					},
					dateof_birth:{
						required: true,
					},
					organization:{
						required: true,
					},
					center:{
						required: true,
					},
					division:{
						required: true,
					},
					district:{
						required: true,
					},
					upazila:{
						required: true,
					},
					email:{
						required: true,
						email: true,
					},
					password:{
						required: true,
					},
					password_again:{
						required: true,
						equalTo: "#password",
					},
				},
				messages:{
					full_name:{
						required: null,
					},
					phone:{
						required: null,
					},
					dateof_birth:{
						required: null,
					},
					organization:{
						required: null,
					},
					center:{
						required: null,
					},
					division:{
						required: null,
					},
					district:{
						required: null,
					},
					upazila:{
						required: null,
					},
					email:{
						required: null,
						email: null,
					},
					password:{
						required: null,
					},
					password_again:{
						required: null,
						equalTo: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "register/create_operator_account",
						data : $('#operatorRegistry').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('html, body').animate({
									scrollTop: $("body").offset().top
								 }, 1000);
								document.getElementById('operatorRegistry').reset();
								$('#alert').html(data.success);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#loader').hide();
								return false;
							}else if(data.status == "error"){
								$('html, body').animate({
									scrollTop: $("body").offset().top
								 }, 1000);
								$('#alert').html(data.error);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#loader').hide();
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
</body>
<!-- //Body -->



</html>