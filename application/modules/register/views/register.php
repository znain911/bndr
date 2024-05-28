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

<!-- Web-Fonts -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
<!-- //Web-Fonts -->

<!-- Horizontal-Tabs-JavaScript -->
<script src="<?php echo base_url('assets/register/'); ?>js/jquery-1.11.1.min.js"></script>
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

					<div class="resp-tabs-container">
						
						<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
							<!-- Form -->
							<?php 
								$attr = array('id' => 'applyRegister');
								echo form_open(base_url('register/account/type'), $attr);
							?>
								<div class="select_option">
									<select name="type" class="form-control">
										<option value="" selected="selected">SELECT ACCOUNT TYPE</option>
										<option value="1">DATA ENTRY OPERATOR</option>
										<option value="2">DOCTOR</option>
										<option value="3">DOCTOR ASSISTANT</option>
									</select>
								</div>
								<input type="submit" value="REGISTER" style="margin-top:35px;">
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


	<script type="text/javascript">
		$.validator.setDefaults({
			submitHandler: function() {
				window.location=document.getElementById('applyRegister').attr('action');
			}
		});

		$().ready(function() {
			// validate signup form on keyup and submit
			$("#applyRegister").validate({
				rules: {
					type: {
						required: true,
					},
				},
				messages: {
					type: {
						required: null,
					},
				}
			});
			
		});
	</script>
</body>
<!-- //Body -->



</html>