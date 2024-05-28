<?php
	$row_info = $this->Administrator_model->get_info($id);
	if($row_info != true)
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
						echo form_open_multipart('', $attr);
					?>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<div class="panel-body">
						<div class="form-group" style="margin-bottom:0">
							<label class="control-label col-md-8"></label>
							<div class="col-md-4" id="alert"></div>
						</div>
						<div class="form-group">
							<label class="col-md-8 control-label">Full Name <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="full_name" value="<?php echo $row_info['owner_name']; ?>" placeholder="Enter Full Name" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-8 control-label">Email <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="email" value="<?php echo $row_info['owner_email']; ?>" placeholder="Enter Email" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-8 control-label">Phone Number <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="phone" value="<?php echo $row_info['owner_phone']; ?>" placeholder="Enter Phone Number" class="form-control">
							</div>
						</div>
						<?php if($this->session->userdata('user_type') == 'Administrator'): ?>
						<div class="form-group">
							<label class="col-md-8 control-label">Role</label>
							<div class="col-md-4">
								<select name="role_id" class="form-control">
									<option value="">Select Role</option>
									<?php 
										$get_roles = $this->Administrator_model->get_roles();
										foreach($get_roles as $role):
									?>
										<option value="<?php echo $role['role_id']; ?>" <?php echo ($row_info['owner_role_id'] == $role['role_id'])? 'selected' : null; ?>><?php echo $role['role_title']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<?php endif; ?>
						<div class="form-group">
							<label class="col-md-8 control-label">Recent Photo</label>
							<div class="col-md-4">
								<?php if($row_info['owner_photo']): ?>
								<div class="old-photo">
									<img src="<?php echo attachment_url('administrators/'.$row_info['owner_photo']); ?>" alt="Photo" />
								</div>
								<?php endif; ?>
								<input type="file" name="recent_photo">
							</div>
						</div>
						<?php if($this->session->userdata('user_type') == 'Administrator'): ?>
						<div class="form-group">
							<div class="col-md-offset-8 col-md-4 text-center">
								<div class="frm-legend"><span class="legend-label">Permission</span></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-8 control-label"></label>
							<div class="col-md-4">
								<?php 
									$get_manages = $this->Administrator_model->get_admin_manages();
									foreach($get_manages as $manage):
									$get_permissionby_adminid = $this->Administrator_model->get_permissions_byid($row_info['owner_id'], $manage['manage_id']);
								?>
								<label><input type="checkbox" name="permission[]" value="<?php echo $manage['manage_id']; ?>" <?php echo ($get_permissionby_adminid['permission_permission_id'] === $manage['manage_id'])? 'checked' : null; ?> /> &nbsp;&nbsp;<?php echo $manage['manage_title']; ?> </label><br />
								<?php endforeach; ?>
							</div>
						</div>
						<?php endif; ?>
						
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
					email:{
						required: true,
						email: true,
					},
					phone:{
						required: true,
						number: true,
					},
				},
				messages:{
					full_name:{
						required: null,
					},
					email:{
						required: null,
						email: null,
					},
					phone:{
						required: null,
						number: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					var getFrmData = new FormData(document.getElementById('createForm'));
					$.ajax({
						type : "POST",
						url : baseUrl + "setup/administrator/update",
						data : getFrmData,
						dataType : "json",
						cache: false,
						contentType: false,
						processData: false,
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
						url : baseUrl + "administrator/dashboard/change_password",
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