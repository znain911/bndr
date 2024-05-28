<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel=stylesheet>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/2.4.85/css/materialdesignicons.min.css" />
    <!-- Bootstrap Core CSS -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/bower_components/jsgrid/dist/jsgrid.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/bower_components/jsgrid/dist/jsgrid-theme.min.css" />
    <link href="<?php echo base_url('assets/'); ?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/'); ?>plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Date picker plugins css -->
    <link href="<?php echo base_url('assets/'); ?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
	<!-- Menu CSS -->
    <link href="<?php echo base_url('assets/'); ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?php echo base_url('assets/'); ?>css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/'); ?>css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- jQuery -->

    <!-- ---------------------------- Report Menu -------------------------- -->
  	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>menu/stylem.css"> 

    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url('assets/login/'); ?>js/jquery.validate.js"></script>
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
	<style type="text/css">
		.navbar-header {
		    width: 100%;
		    background: #fff !important;
		    border: 0;
		}
	</style>
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
							<img style="width: 65px; height: 25px;" src="<?php echo base_url('assets/'); ?>tools/logo.png" alt="Logo" class="dark-logo" />
							<!--This is light logo icon--><!-- <img src="<?php echo base_url('assets/'); ?>plugins/images/admin-logo-dark.png" alt="home" class="light-logo" /> -->
							<!-- <img style="width: 207px; height: 37px;" src="<?php echo base_url('assets/'); ?>bndrnew.png" alt="Logo" class="dark-logo" /> -->
						</b>
						<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
						<span class="hidden-xs">
							<strong style="color: #0F70B7; font-size: 17px;">Nationwide Electronic Registry</strong>
						</span>
						<?php else: ?>
						<span class="hidden-xs org-center-logo-name">
							<span class="org-logo-name" style="color: #2171b5"><?php echo $this->session->userdata('user_org_name'); ?></span>
							<span class="org-center-name-logo" style="color: #00BB1A"><?php echo $this->session->userdata('user_org_center_name'); ?></span>
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
						<div class="message-ic" style="color: #00BB1A"><span class="fa fa-bell fa-fw" style="color: #00BB1A"></span></div>
					</li>
					<li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)"> 
							<?php if($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('admin_photo') !== null): ?>
							<!-- <img src="<?php echo attachment_url('administrators/').$this->session->userdata('admin_photo'); ?>" alt="user" width="36" class="img-circle" /> -->
							<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" width="36" class="img-circle img-thumbnail" />
							<?php elseif($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('admin_photo') !== null): ?>
							<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" width="36" class="img-circle" />
							<?php else: ?>
							<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" width="36" class="img-circle" />
							<?php endif; ?>
							<!-- <b class="hidden-xs"><?php echo $this->session->userdata('full_name'); ?></b> -->
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
							<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
							<li><a href="<?php echo base_url('administrator/dashboard/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
							<?php else: ?>
							<li><a href="<?php echo base_url('users/dashboard/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
							<?php endif; ?>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <li>
						<div class="message-ic" style="color: #2171b5"><!-- <span class="fa fa-bell fa-fw" style="color: #2171b5"></span> --> &nbsp</div>
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
                    <?php require_once APPPATH.'modules/common/report-menu.php' ?>
                </ul>
				
				<?php if($this->session->userdata('user_type') !== 'Administrator'): ?>
				<div class="search-bar-input">
					<?php 
						$attr = array('class' => 'search-form', 'method' => 'get');
						echo form_open('patients', $attr); 
					?>
					<input placeholder="Search : Patient name, id, Guide Book Number, Phone, NID, Doctor" type="text" class="form-control" name="src" value="<?php echo (isset($_GET['src']) && $_GET['src'] !== null)? $_GET['src'] : null; ?>" />
					<input type="hidden" name="rdr_to" value="patients" />
					<input type="hidden" name="pactive" value="true" />
					<button type="submit">Search</button>
					<?php echo form_close(); ?>
				</div>
				
				<div class="get-it-right"> 
					<a href="<?php echo base_url('patients/create'); ?>"><i class="mdi mdi-plus fa-fw"></i> <span class="hide-menu">Add New Patient</span></a>
				</div>
				<?php endif; ?>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
		
		<!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->



<div class="menianim"> 
    <nav class="menu-opener"> 
        <div class="menu-opener-inner"></div>
    </nav>    
                
    <nav class="menu">                    
        <div style="clear:both; height:20px;"></div> 
        <div class="dw-user-box" style="color: #fff; padding-left: 20px;">
                                    <div class="u-img">
										<?php if($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('admin_photo') !== null): ?>
										<!-- <img src="<?php echo attachment_url('administrators/').$this->session->userdata('admin_photo'); ?>" alt="user" /> -->
										<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" width="66" class="img-circle img-thumbnail" />
										<?php elseif($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('admin_photo') !== null): ?>
										<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" width="66" class="img-circle img-thumbnail" />
										<?php else: ?>
										<img src="<?php echo base_url('assets/'); ?>plugins/images/users/varun.jpg" alt="user" width="66" class="img-circle img-thumbnail" />
										<?php endif; ?>
									</div>
                                    <div class="u-text" style="color: #fff">
                                        <h4 style="color: #fff"><?php echo $this->session->userdata('full_name'); ?></h4>
                                        <!-- <p class="text-muted" style="font-size:12px;color:#fff">Last Login : <?php echo date("d M, Y", strtotime($this->session->userdata('last_login_time'))).' '.date("g:i A", strtotime($this->session->userdata('last_login_time'))); ?></p>
                                        <p class="text-muted" style="font-size:12px;color:#fff">Login From : <?php echo $this->session->userdata('last_login_ip'); ?></p> -->
                                        <?php if($this->session->userdata('user_type') === 'Administrator'): ?>
										
										<h5 style="color: #fff">Nationwide Electronic Registry</h5>
										<?php else: ?>
										<h5 style="color: #fff"><?php echo $this->session->userdata('user_org_name'); ?></h5>
										<p class="text-muted" style="font-size:12px;color:#fff"><?php echo $this->session->userdata('user_org_center_name'); ?></p>

						<?php endif; ?>
									</div>
                                </div>
        <ul class="menu-inner">
            <li><a href="javascript:void(0)" class="menu-link active"><i class="fa fa-tachometer" aria-hidden="true"></i> DASHBOARD</a></li> 
            <li><a href="javascript:void(0)" class="menu-link"><i class="fa fa-user" aria-hidden="true"></i> ADD USER</a></li>                   
            <li><a href="javascript:void(0)" class="menu-link"><i class="fa fa-server" aria-hidden="true"></i> USER LIST</a></li> 
            <li><a href="javascript:void(0)" class="menu-link"><i class="fa fa-list-alt" aria-hidden="true"></i> REPORT</a></li>                    
            <li><a href="javascript:void(0)" class="menu-link"><i class="fa fa-credit-card" aria-hidden="true"></i> PAYMENTS</a></li>                    
            <li><a href="javascript:void(0)" class="menu-link"><i class="fa fa-envelope" aria-hidden="true"></i> Contact Us</a></li>
			<li><a href="javascript:void(0)" class="menu-link"><i class="fa fa-users" aria-hidden="true"></i> PROFILE</a></li>
			<li><a href="javascript:void(0)" class="menu-link"><i class="fa fa-key" aria-hidden="true"></i> CHANGE PASSWORD</a></li>
			<li><a href="javascript:void(0)" class="menu-link"><i class="fa fa-question-circle" aria-hidden="true"></i> FAQ</a></li>
			   

			<?php if($this->session->userdata('user_type') === 'Administrator'): ?>							
				<li><a href="<?php echo base_url('administrator/dashboard/logout'); ?>" class="menu-link"><i class="fa fa-sign-out" aria-hidden="true"></i> LOGOUT</a></li>
			<?php else: ?>	
				<li><a href="<?php echo base_url('users/dashboard/logout'); ?>" class="menu-link"><i class="fa fa-sign-out" aria-hidden="true"></i> LOGOUT</a></li>
			<?php endif; ?>
        </ul>  
    </nav>
</div>  








        <div id="page-wrapper">
            <div class="container-fluid">