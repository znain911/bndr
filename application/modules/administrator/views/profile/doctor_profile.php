<?php
	$get_info = $this->Doctor_model->get_info($id);
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
				<li class="active">Profile</li>
				<li class="active">Edit</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default block2">
				<div class="panel-heading text-center">EDIT ACCOUNT</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
					<?php 
						$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm');
						echo form_open('', $attr);
					?>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<div class="panel-body">
						<div class="form-group" style="margin-bottom:0">
							<label class="control-label col-md-8"></label>
							<div class="col-md-4" id="alert"></div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Full Name <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="full_name" placeholder="Full Name" value="<?php echo $get_info['doctor_full_name']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Phone Number <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="phone" placeholder="Phone Number" value="<?php echo $get_info['doctor_phone']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">BMDC No <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="bmdc_no" placeholder="BMDC No" value="<?php echo $get_info['doctor_bmdc_no']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Date Of Birth <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="dateof_birth" placeholder="yyyy-mm-dd" value="<?php echo $get_info['doctor_dateof_birth']; ?>" class="form-control datepicker">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Organization <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<select name="organization" class="form-control" id="selectedOrganization">
									<option value="" selected="selected">Select Organization</option>
									<?php 
										$orgs = $this->Organization_model->get_all_items();
										foreach($orgs as $org):
									?>
									<option value="<?php echo $org['org_id']; ?>" <?php echo ($get_info['doctor_org_id'] == $org['org_id'])? 'selected' : null; ?>><?php echo $org['org_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Center <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<select name="center" class="form-control" id="cenTers">
									<option value="" selected="selected">Select Center</option>
									<?php 
										$centers = $this->Organization_model->get_all_centers($get_info['doctor_org_id']);
										foreach($centers as $center):
									?>
									<option value="<?php echo $center['orgcenter_id']; ?>" <?php echo ($get_info['doctor_org_centerid'] == $center['orgcenter_id'])? 'selected' : null; ?>><?php echo $center['orgcenter_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-6"></label>
							<div class="col-md-6">
								<div class="frm-legend"><span class="legend-label">Location Information</span></div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Division <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<select name="division" class="form-control" id="selectedDivision">
									<option value="" selected="selected">Select Division</option>
									<?php 
										$divisions = $this->Organization_model->get_all_divisions();
										foreach($divisions as $division):
									?>
									<option value="<?php echo $division['division_id']; ?>" <?php echo ($get_info['doctor_division_id'] == $division['division_id'])? 'selected' : null; ?>><?php echo $division['division_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">District <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<select name="district" class="form-control" id="selectedDistrict">
									<option value="" selected="selected">Select District</option>
									<?php 
										$districts = $this->Organization_model->get_all_districts($get_info['doctor_division_id']);
										foreach($districts as $district):
									?>
									<option value="<?php echo $district['district_id']; ?>" <?php echo ($get_info['doctor_district_id'] == $district['district_id'])? 'selected' : null; ?>><?php echo $district['district_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Upazila</label>
							<div class="col-md-4">
								<select name="upazila" class="form-control" id="selectedUpazila">
									<option value="" selected="selected">Select Upazila</option>
									<?php 
										$upazilas = $this->Organization_model->get_all_upazilas($get_info['doctor_district_id']);
										foreach($upazilas as $upazila):
									?>
									<option value="<?php echo $upazila['upazila_id']; ?>" <?php echo ($get_info['doctor_upazila_id'] == $upazila['upazila_id'])? 'selected' : null; ?>><?php echo $upazila['upazila_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Address</label>
							<div class="col-md-4">
								<textarea name="address" class="form-control" id="" cols="30" rows="5"><?php echo $get_info['doctor_address']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Postal Code</label>
							<div class="col-md-4">
								<input type="text" name="postal_code" placeholder="Postal Code" value="<?php echo $get_info['doctor_postal_code']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-6"></label>
							<div class="col-md-6">
								<div class="frm-legend"><span class="legend-label">Login Information</span></div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Email Address <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="email" class="form-control" value="<?php echo $get_info['doctor_email']; ?>" />
							</div>
						</div>
					</div>
					<div class="panel-footer text-right"> 
						<input type="hidden" name="status" value="1" />
						<span data-id="<?php echo $this->session->userdata('active_user'); ?>" class="btn btn-danger waves-effect waves-light m-t-10 row-action-change-password" data-target="#modal-without-animation" data-toggle="modal">Change Password</span>
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit">Update Account</button>  
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	
	</div>
	<div class="modal password-change-mdl" id="modal-without-animation">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Change Password</h4>
				</div>
				<div class="modal-body">
					<?php 
						$attr = array('id' => 'upPassrf');
						echo form_open('#', $attr);
					?>
						<div id="UpPloader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
						<input type="hidden" id="adminCheck" name="admin" />
						<div class="form-group">
							<label for="Password">Password</label>
							<input type="password" class="form-control" name="password" id="Password" placeholder="6 - 15 Characters">
						</div>
						<div class="form-group">
							<label for="RePassword">Re-Password</label>
							<input type="password" class="form-control" name="repass" placeholder="6 - 15 Characters">
						</div>
						<button type="submit" class="btn btn-primary waves-effect waves-light w-md">Update Password</button>
					</form>
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn btn-default width-100" data-dismiss="modal">Close</a>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#createForm").validate({
				rules:{
					full_name:{
						required: true,
					},
					phone:{
						required: true,
					},
					bmdc_no:{
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
					email:{
						required: true,
						email: true,
					},
				},
				messages:{
					full_name:{
						required: null,
					},
					phone:{
						required: null,
					},
					bmdc_no:{
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
					email:{
						required: null,
						email: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "doctors/update",
						data : $('#createForm').serialize(),
						dataType : "json",
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.row-action-change-password', function(){
				var get_admin = $(this).attr('data-id');
				$('#adminCheck').val(get_admin);
			})
			
			$("#upPassrf").validate({
				rules:{
					password:{
						required: true,
						minlength: 5,
					},
					repass:{
						required: true,
						minlength: 5,
						equalTo: "#Password",
					},
				},
				submitHandler : function () {
					$('#UpPloader').show();
					var getFrmData = new FormData(document.getElementById('upPassrf'));
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "doctors/change_password",
						data : getFrmData,
						dataType : "json",
						cache: false,
						contentType: false,
						processData: false,
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("upPassrf").reset();
								$('#UpPloader').hide();
								$('#modal-without-animation').modal('hide');
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
<?php require_once APPPATH.'modules/common/footer.php' ?>