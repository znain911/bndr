<!DOCTYPE html>
<html>
<head>
<title>Login | Nationwide Electric Registry</title>
<!-- For-Mobile-Apps -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //For-Mobile-Apps -->

<!-- Style.CSS --> <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />

<!-- Web-Fonts -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
<!-- //Web-Fonts -->

<!-- Horizontal-Tabs-JavaScript -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
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

	<!-- Heading -->
	<h1>MULTI LOGIN & SIGNUP FORM</h1>
	<!-- //Headng -->


	<!-- Container -->
	<div class="container">

		<div class="tabs">

			<div class="sap_tabs">

				<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">

					<ul class="resp-tabs-list">
						<li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><h2><span>LOGIN</span></h2></li>
						<li class="resp-tab-item" aria-controls="tab_item-2" role="tab"><span>SIGNUP</span></li>
						<li class="resp-tab-item" aria-controls="tab_item-3" role="tab"><span>RESET PASSWORD</span></li>
						<li class="resp-tab-item" aria-controls="tab_item-4" role="tab"><span>LOGIN OPTIONS</span></li>
						<div class="clear"> </div>
					</ul>

					<div class="resp-tabs-container">
						
						<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
							<!-- Form -->
							<form action="#" method="post">
								<input type="text" Name="Username" placeholder="Username" required="">
								<input type="password" Name="Password" placeholder="Password" required="">
								<ul>
									<li>
										<input type="checkbox" id="brand1" value="">
										<label for="brand1"><span></span>Remember Me</label>
									</li>
								</ul>
								<input type="submit" value="LOGIN">
							</form>
							<!-- //Form -->
						</div>

						<div class="tab-2 resp-tab-content" aria-labelledby="tab_item-2">
							<div class="register">
								<form action="#" method="post">
									<input type="text" Name="First Name" placeholder="First Name" required="">
									<input type="text" Name="Last Name" placeholder="Last Name" required="">
									<input type="text" Name="Email" placeholder="Email" required="">
									<input type="password" Name="Password" placeholder="Password" required="">
									<input type="password" Name="Password" class="lessgap" placeholder="Confirm Password" required="">
									<input type="text" Name="Phone Number" placeholder="Phone Number" required="">
									<div class="send-button">
										<input type="submit" value="REGISTER">
									</div>
								</form>
							</div>
						</div>

						<div class="tab-3 resp-tab-content" aria-labelledby="tab_item-3">
							<div class="reset">
								<form action="#" method="post">
									<input type="text" Name="Email" placeholder="Email" required="">
									<p>(Or)</p>
									<input type="text" Name="Phone Number" placeholder="Phone Number" required="">
									<input type="submit" value="RESET MY PASSWORD">
								</form>
							</div>
						</div>

						<div class="tab-4 resp-tab-content" aria-labelledby="tab_item-4">

							<div class="main">
								<ul class="cbp-ig-grid">
									<li>
										<a href="#">
											<img src="images/facebook.png" class="cbp-ig-icon cbp-ig-icon-facebook" alt="Fashion">
											<h3 class="cbp-ig-title">Facebook</h3>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="images/twitter.png" class="cbp-ig-icon cbp-ig-icon-twitter" alt="Fashion">
											<h3 class="cbp-ig-title">Twitter</h3>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="images/gplus.png" class="cbp-ig-icon cbp-ig-icon-gplus" alt="Fashion">
											<h3 class="cbp-ig-title">Google +</h3>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="images/pinterest.png" class="cbp-ig-icon cbp-ig-icon-pinterest" alt="Fashion">
											<h3 class="cbp-ig-title">Pinterest</h3>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="images/tumblr.png" class="cbp-ig-icon cbp-ig-icon-tumblr" alt="Fashion">
											<h3 class="cbp-ig-title">Tumblr</h3>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="images/linkedin.png" class="cbp-ig-icon cbp-ig-icon-linkedin" alt="Fashion">
											<h3 class="cbp-ig-title">Linkedin</h3>
										</a>
									</li>
								</ul>
							</div>

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
			<p> &copy; 2018 Nationwide Electric Registry.</p>
		</div>
		<!-- //Copyright -->

	</div>
	<!-- //Footer -->



</body>
<!-- //Body -->



</html>