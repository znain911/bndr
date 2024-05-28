<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel=stylesheet>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/2.4.85/css/materialdesignicons.min.css" />
    <!-- Bootstrap Core CSS -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/bower_components/jsgrid/dist/jsgrid.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/bower_components/jsgrid/dist/jsgrid-theme.min.css" />
    <link href="<?php echo base_url('assets/'); ?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/'); ?>plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>bootstrap/dist/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>bootstrap/dist/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Date picker plugins css -->
    <link href="<?php echo base_url('assets/'); ?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
	<!-- Menu CSS -->
    <link href="<?php echo base_url('assets/'); ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?php echo base_url('assets/'); ?>css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/'); ?>css/36.css" rel="stylesheet">
	
    <!-- color CSS -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- jQuery -->
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url('assets/login/'); ?>js/jquery.validate.js"></script>
	<!--<script src="<?php echo base_url('assets/'); ?>plugins/bower_components/jquery/dist/instascan.min.js"></script>-->
	<script src="<?php echo base_url('assets/'); ?>plugins/bower_components/jquery/dist/jquery.qrcode.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/bower_components/jquery/dist/jsqrscanner.nocache.js"></script>
	<script type="text/javascript">
		var baseUrl = "<?php echo base_url(); ?>";
	</script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-129395078-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-129395078-1');
	</script>
	
</head>

<body>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="<?php echo base_url('administrator/dashboard'); ?>">
                        <b>
							<img style="width: 65px; height: 25px;" src="<?php echo base_url('assets/'); ?>tools/logo.png" alt="Logo" class="dark-logo" /><!--This is light logo icon--><img src="<?php echo base_url('assets/'); ?>plugins/images/admin-logo-dark.png" alt="home" class="light-logo" />
						</b>
						<?php if($this->session->userdata('user_type') === 'Administrator' || $this->session->userdata('user_type') === 'Org Admin'): ?>
						<span class="hidden-xs">
							<strong>Nationwide Electronic Registry</strong>
						</span>
						<?php else: ?>
						<span class="hidden-xs org-center-logo-name">
							<span class="org-logo-name"><?php echo $this->session->userdata('user_org_name'); ?></span>
							<span class="org-center-name-logo"><?php echo $this->session->userdata('user_org_center_name'); ?></span>
						</span>
						<?php endif; ?>
					</a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
						<div class="message-ic"><span class="fa fa-envelope fa-fw"></span></div>
					</li>
					<li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)"> 
							<?php if($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('admin_photo') !== null): ?>
							<img src="<?php echo attachment_url('administrators/').$this->session->userdata('admin_photo'); ?>" alt="user" width="36" class="img-circle" />
							<?php elseif($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('admin_photo') !== null): ?>
							<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" width="36" class="img-circle" />
							<?php else: ?>
							<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" width="36" class="img-circle" />
							<?php endif; ?>
							<b class="hidden-xs"><?php echo $this->session->userdata('full_name'); ?></b>
							<span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
							<li>
                                <div class="dw-user-box">
                                    <div class="u-img">
										<?php if($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('admin_photo') !== null): ?>
										<img src="<?php echo attachment_url('administrators/').$this->session->userdata('admin_photo'); ?>" alt="user" />
										<?php elseif($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('admin_photo') !== null): ?>
										<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" />
										<?php else: ?>
										<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" />
										<?php endif; ?>
									</div>
                                    <div class="u-text">
                                        <h4><?php echo $this->session->userdata('full_name'); ?></h4>
                                        <p class="text-muted" style="font-size:12px;color:#333">Last Login : <?php echo date("d M, Y", strtotime($this->session->userdata('last_login_time'))).' '.date("g:i A", strtotime($this->session->userdata('last_login_time'))); ?></p>
                                        <p class="text-muted" style="font-size:12px;color:#333">Login From : <?php echo $this->session->userdata('last_login_ip'); ?></p>
									</div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo base_url('administrator/dashboard/profile'); ?>"><i class="ti-settings"></i> Account Setting</a></li>
                            <li role="separator" class="divider"></li>
							<?php if($this->session->userdata('user_type') === 'Administrator' || $this->session->userdata('user_type') === 'Org Admin'): ?>
							<li><a href="<?php echo base_url('administrator/dashboard/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
							<?php else: ?>
							<li><a href="<?php echo base_url('users/dashboard/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
							<?php endif; ?>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav put-relative">
                <div class="sidebar-head">
					<h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigation</span></h3> 
				 </div>
                <ul class="nav" id="side-menu">
                    <?php require_once APPPATH.'modules/common/menu.php' ?>
                </ul>
				
				<?php
					if($this->session->userdata('user_type') === 'Operator' || $this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'|| $this->session->userdata('user_type') === 'Super Operator' ):
				//if($this->session->userdata('user_type') !== 'Administrator' ): ?>
				<div class="search-bar-input laptop" style = '<?php if($this->session->userdata('user_type') === 'Org Admin'){echo 'margin-top: 6%;';}?>'>
					<?php 
						$attr = array('class' => 'search-form', 'method' => 'get');
						echo form_open('patients', $attr); 
					?>
					<input placeholder="Search : Patient name, id, Guide Book Number, Phone, NID, Doctor" type="text" id = "searchBar" class="form-control searchBar" name="src" value="<?php echo (isset($_GET['src']) && $_GET['src'] !== null)? $_GET['src'] : null; ?>" />
					<input type="hidden" name="rdr_to" value="patients" />
					<input type="hidden" name="pactive" value="true" />
					<button type="submit">Search</button>
					<?php echo form_close(); ?>
				</div>
				
				<div class="search-bar-input mobiles">
					<?php 
						$attr = array('class' => 'search-form', 'method' => 'get');
						echo form_open('patients', $attr); 
					?>
					<input placeholder="Search Here" type="text" class="form-control searchBar" id = "searchBar" name="src" value="<?php echo (isset($_GET['src']) && $_GET['src'] !== null)? $_GET['src'] : null; ?>" />
					<input type="hidden" name="rdr_to" value="patients" />
					<input type="hidden" name="pactive" value="true" />
					<button type="submit" style = ''><span class="mdi mdi-account-search"></span></button>
					<?php echo form_close(); ?>
				</div>
				<?php 
				if($this->session->userdata('user_type') !== 'Doctor'  ): 
				if($this->session->userdata('user_type') !== 'Foot Doctor'  ): 
				if($this->session->userdata('user_type') !== 'Eye Doctor'  ): 
				if($this->session->userdata('user_type') !== 'Super Operator'  ): 
				?>
				<div class="get-it-right"> 
					<a href="<?php echo base_url('patients/create'); ?>"><i class="mdi mdi-plus fa-fw"></i> <span class="hide-menu">Add New Patient</span></a>
				</div>
				
				
				<?php endif;endif;endif;endif;endif; ?>
            </div>
        </div>
		<?php if($this->session->userdata('user_type') === 'Org Admin'){?>
		<div class="search-bar-input laptop" style = 'margin-top: 7.5%;'>
			<?php 
				$attr = array('class' => 'search-form', 'method' => 'get');
				echo form_open('patients', $attr); 
			?>
			<input placeholder="Search : Patient name, id, Guide Book Number, Phone, NID, Doctor" type="text" id = "searchBar" class="form-control searchBar"  name="src" value="<?php echo (isset($_GET['src']) && $_GET['src'] !== null)? $_GET['src'] : null; ?>" />
			<input type="hidden" name="rdr_to" value="patients" />
			<input type="hidden" name="pactive" value="true" />
			<button type="submit">Search</button>
			<?php echo form_close(); ?>
		</div>
		<?php }?>
		
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
		
		<!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">