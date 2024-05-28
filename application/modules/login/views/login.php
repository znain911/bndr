<!DOCTYPE html>
<html>
<head>
<title>Login | Nationwide Electronic Registry</title>
<!-- For-Mobile-Apps -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //For-Mobile-Apps -->

<!-- Style.CSS --> <link rel="stylesheet" href="<?php echo base_url('assets/login/'); ?>css/styles.css" type="text/css" media="all" />

<!-- Web-Fonts -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
<!-- //Web-Fonts -->

<!-- Horizontal-Tabs-JavaScript -->
<script src="<?php echo base_url('assets/login/'); ?>js/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url('assets/login/'); ?>js/jquery.validate.js"></script>
<script src="<?php echo base_url('assets/login/'); ?>js/easyResponsiveTabs.js" type="text/javascript"></script>
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
	<span style="margin-top: -5px;display: inline-block;position: absolute;right: 10px;top: 12px;color: #999;font-size: 14px;">Version 2</span>
	<!-- Container -->
	<div class="nationwide-logo"><img src="<?php echo base_url('assets/login/tools/logo.png'); ?>" alt="Badas Logo" /> <span class="logo-label">Nationwide Electronic Registry</span></div>
	<div class="container">
		<div class="tabs">

			<div class="sap_tabs">

				<div style="display: block; width: 100%; margin: 0px;">

					<ul class="resp-tabs-list">
						<li class="resp-tab-item resp-tab-active" aria-controls="tab_item-1" role="tab"><h2><a href="<?php echo base_url('login'); ?>"><span>ADMINISTRATOR</span></a></h2></li>
						<li class="resp-tab-item"><a href="<?php echo base_url('login/type/user'); ?>"><span>USER</span></a></li>
						<div class="clear"> </div>
					</ul>

					<div class="resp-tabs-container">
						<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
						<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
							<!-- Form -->
							<?php 
								$attr = array('id' => 'adminLogin');
								echo form_open('', $attr);
							?>
								<div id="alert"></div>
								<input type="text" name="email_or_phone" placeholder="Email Or Phone Number">
								<input type="password" name="password" placeholder="Password">
								<ul>
									<li>
										<input type="checkbox" id="brand1" value="1">
										<label for="brand1"><span></span>Remember Me</label>
									</li>
								</ul>
								<input type="submit" value="LOGIN">
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
			<p> &copy; <?php echo date('Y');?> Nationwide Electronic Registry.</p>
		</div>
		<!-- //Copyright -->

	</div>
	<!-- //Footer -->


	<script type="text/javascript">
		$(document).ready(function(){
			$("#adminLogin").validate({
				rules:{
					email_or_phone:{
						required: true,
					},
					password:{
						required: true,
					},
					role_type:{
						required: true,
					},
				},
				messages:{
					email_or_phone:{
						required: null,
					},
					password:{
						required: null,
					},
					role_type:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "login/credentials",
						data : $('#adminLogin').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								window.location.href=baseUrl+'administrator/dashboard';
								return false;
							}else if(data.status == "warning"){
								$('#alert').html(data.warning);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#loader').hide();
								return false;
							}else if(data.status == "error"){
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
</body>
<!-- //Body -->



</html>