<li> <a href="<?php echo base_url('administrator/dashboard'); ?>" class="waves-effect <?php echo (($this->uri->segment(1) == 'administrator' && $this->uri->segment(2) == 'dashboard') || $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor')? 'active' : null; ?>"><i class="mdi mdi-av-timer fa-fw laptop" data-icon="v"></i> <span class="hide-menu"> Dashboard </a></li>
<?php if($this->session->userdata('user_type') === 'Administrator' || $this->session->userdata('user_type') === 'Org Admin') :?>
<li> <a href="http://27.147.158.170:8081/bndr_dash/administrator/dashboard/graph" target="_blank" class="waves-effect <?php echo menu_item_activate('graph'); ?>"><i class="fa fa-area-chart fa-lg" data-icon="v"></i> <span class="hide-menu">Summary</a></li>
<?php endif; ?>
<?php 
	$check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 1);
?>
<?php if($this->session->userdata('user_type') === 'Administrator' && $check_permission == true): ?>
<li> 
	<a href="javascript:void(0)" class="waves-effect <?php echo menu_item_activate('organizations'); ?>"><i class="mdi mdi-hospital fa-fw"></i> <span class="hide-menu">Organizations<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li><a href="<?php echo base_url('organizations'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Views Organizations</span></a></li>
		<li><a href="<?php echo base_url('organizations/create'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">New Organization Registration</span></a></li>
	</ul>
</li>
<?php endif; ?>

<?php 
	$check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 2);
?>
<?php if($this->session->userdata('user_type') === 'Administrator' && $check_permission == true): ?>
<li> 
	<a href="javascript:void(0)" class="waves-effect <?php echo menu_item_activate('centers'); ?>"><i class="mdi mdi-hospital fa-fw"></i> <span class="hide-menu">Centers<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li><a href="<?php echo base_url('centers'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Views Centers</span></a></li>
		<li><a href="<?php echo base_url('centers/create'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">New Center Registration</span></a></li>
	</ul>
</li>
<?php endif; ?>
<?php 
	$check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 3);
?>
<?php if($this->session->userdata('user_type') === 'Administrator'  && $check_permission == true): ?>
<li> 
	<a href="javascript:void(0)" class="waves-effect <?php echo menu_item_activate('patients'); ?>"><i class="mdi mdi-treasure-chest fa-fw"></i> <span class="hide-menu">Patients<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li><a href="<?php echo base_url('patients'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Views All Patients</span></a></li>
		<li><a href="<?php echo base_url('patients/imported'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Views Imported Patients</span></a></li>
		<li><a href="<?php echo base_url('patients/create'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">New Patient Registration</span></a></li>
	</ul>
</li>
<?php endif; ?>

<?php if($this->session->userdata('user_type') === 'Org Admin' ): ?>
<li> 
	<a href="javascript:void(0)" class="waves-effect <?php echo menu_item_activate('patients'); ?>"><i class="mdi mdi-treasure-chest fa-fw"></i> <span class="hide-menu">Patients<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li><a href="<?php echo base_url('patients'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Views All Patients</span></a></li>
	</ul>
</li>
<?php endif; ?>
<?php 
	$check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 4);
?>
<?php if($this->session->userdata('user_type') === 'Org Admin' ): ?>
<li> 
	<a style="line-height: 30px;" href="javascript:void(0)" class="waves-effect <?php echo menu_item_activate('doctors'); ?>"><i style="font-weight:500;font-size:18px;" class="icon-people fa-fw"></i> <span class="hide-menu">Doctors<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li><a href="<?php echo base_url('doctors'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">View Doctors</span></a></li>
	</ul>
</li>
<?php endif; ?>

<?php if($this->session->userdata('user_type') === 'Administrator' && $check_permission == true): ?>
<li> 
	<a style="line-height: 30px;" href="javascript:void(0)" class="waves-effect <?php echo menu_item_activate('doctors'); ?>"><i style="font-weight:500;font-size:18px;" class="icon-people fa-fw"></i> <span class="hide-menu">Doctors<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li><a href="<?php echo base_url('doctors'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">View Doctors</span></a></li>
		<li><a href="<?php echo base_url('doctors/create'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">New Doctor Registration</span></a></li>
	</ul>
</li>
<?php endif; ?>

<?php 
	$check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 5);
?>
<?php if($this->session->userdata('user_type') === 'Administrator' && $check_permission == true): ?>

<li> 
	<a href="javascript:void(0)" class="waves-effect <?php echo menu_item_activate('reports'); ?>"><i class="mdi mdi-clipboard fa-fw"></i> <span class="hide-menu">Reports<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li><a href="<?php echo base_url('reports/cntrpatients'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Center Wise Patients</span></a></li>
		<li><a href="<?php echo base_url('reports/cntrdoctors'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Center Wise Doctors</span></a></li>
		<li><a href="<?php echo base_url('reports/visits'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Center Wise Visits</span></a></li>
		<li><a href="<?php echo base_url('reports/all'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Reports</span></a></li>
	</ul>
</li>

<?php endif; ?>

<?php 
	$check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 6);
?>
<?php if($this->session->userdata('user_type') === 'Administrator' && $check_permission == true): ?>
<li> 
	<a style="line-height: 30px;" href="javascript:void(0)" class="waves-effect <?php echo ($this->uri->segment(1) == 'assistants' || $this->uri->segment(1) == 'operators')? 'active' : null; ?>"><i style="font-weight:500;font-size:18px;" class="icon-people fa-fw"></i> <span class="hide-menu">Other Users<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li>
			<a href="<?php echo base_url('assistants'); ?>">
				<i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Doctor Assistants</span>
			</a>
			<ul class="nav nav-third-level">
				<li><a href="<?php echo base_url('assistants'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">View Assistants</span></a></li>
				<li><a href="<?php echo base_url('assistants/create'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">New Assistant Registration</span></a></li>
			</ul>
		</li>
		<li>
			<a href="<?php echo base_url('operators'); ?>">
				<i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Data Entry Operators</span>
			</a>
			<ul class="nav nav-third-level">
				<li><a href="<?php echo base_url('operators'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">View Operators</span></a></li>
				<li><a href="<?php echo base_url('operators/create'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">New Operator Registration</span></a></li>
			</ul>
		</li>
	</ul>
</li>
<?php endif; ?>

<?php if($this->session->userdata('user_type') === 'Org Admin' ): ?>
<li> 
	<a style="line-height: 30px;" href="javascript:void(0)" class="waves-effect <?php echo ($this->uri->segment(1) == 'assistants' || $this->uri->segment(1) == 'operators')? 'active' : null; ?>"><i style="font-weight:500;font-size:18px;" class="icon-people fa-fw"></i> <span class="hide-menu">Other Users<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		
		<li>
			<a href="<?php echo base_url('operators'); ?>">
				<i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Data Entry Operators</span>
			</a>
			<ul class="nav nav-third-level">
				<li><a href="<?php echo base_url('operators'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">View Operators</span></a></li>
				<li><a href="<?php echo base_url('operators/create'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">New Operator Registration</span></a></li>
			</ul>
		</li>
	</ul>
</li>

<?php endif; ?>

<?php 
	$check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 7);
?>
<?php if($this->session->userdata('user_type') === 'Administrator' && $check_permission == true): ?>
<li> 
	<a href="javascript:void(0)" class="waves-effect <?php echo menu_item_activate('setup'); ?>"><i class="mdi mdi-cogs fa-fw"></i> <span class="hide-menu">Setup<span class="fa arrow"></span></span></a>
	<ul class="nav nav-second-level">
		<li><a href="<?php echo base_url('setup/roles'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Roles</span></a></li>
		<li><a href="<?php echo base_url('setup/administrator'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Administrators</span></a></li>
		
		<li><a href="<?php echo base_url('setup/division'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Division</span></a></li>
		<li><a href="<?php echo base_url('setup/district'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage District</span></a></li>
		<li><a href="<?php echo base_url('setup/upazila'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Upazila</span></a></li>
		<li><a href="<?php echo base_url('setup/expenditure'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Monthly Expenditure</span></a></li>
		<li><a href="<?php echo base_url('setup/education'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Education</span></a></li>
		<li><a href="<?php echo base_url('setup/profession'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Profession</span></a></li>
		
		<li><a href="<?php echo base_url('setup/insulin'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Insulin</span></a></li>
		<li><a href="<?php echo base_url('setup/company'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Drugs Companies</span></a></li>
		<li><a href="<?php echo base_url('setup/drugs'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Drugs</span></a></li>
		<li><a href="<?php echo base_url('setup/foods'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Food Items</span></a></li>
		<li><a href="<?php echo base_url('setup/physical'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Manage Physical Activities</span></a></li>
		<li><a href="<?php echo base_url('setup/config'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Configuration</span></a></li>
		<li><a href="<?php echo base_url('setup/centers'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Local App Centers</span></a></li>
	</ul>
</li>


<li>
	<a href="<?php echo base_url('administrator/dashboard/compile'); ?>" class = 'compilation'>
				<i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Compilation</span>
			</a>
</li>
<?php endif; ?>
<?php 
	$check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 8);
?>
<?php if($this->session->userdata('user_type') === 'Administrator' && $check_permission == true): ?>
<!--<li><a href="<?php echo base_url('finance'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Finance</span></a></li>-->
<?php endif; ?>

<?php if($this->session->userdata('user_type') === 'Org Admin'): ?>
<!--<li><a href="<?php echo base_url('finance'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Finance</span></a></li>-->
<?php endif; ?>

<?php if($this->session->userdata('user_type') === 'Administrator' && $this->session->userdata('role') == '4'): ?>
<li><a href="<?php echo base_url('orgreports'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Organization Report</span></a></li>
<?php endif; ?>

<?php if($this->session->userdata('user_type') === 'Administrator' && $check_permission == true): ?>
<!--<li><a href="<?php echo base_url('reportapp/patienthistory'); ?>"><i class="mdi mdi-bulletin-board fa-fw"></i><span class="hide-menu">Download Report</span></a></li>-->
<?php endif; ?>