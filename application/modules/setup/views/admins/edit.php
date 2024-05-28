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
				<li class="active">Organizations</li>
				<li class="active">Create</li>
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
				<div class="panel-heading text-center">UPDATE ADMINISTRATOR</div>
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
						<div class="form-group">
							<label class="col-md-8 control-label">Role</label>
							<div class="col-md-4">
								<select name="role_id" class="form-control" onchange="getRoleType(this.value)">
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
						<div id="selectOrg">
							<?php 
								if($row_info['owner_role_id'] == '4'):
									$orgs = $this->Administrator_model->get_all_orgs();
									$org_content = '';
									foreach($orgs as $org):
										if($org['org_id'] == $row_info['owner_org_id']){
											$selected = 'selected';
										}else{
											$selected = null;
										}
										$org_content .= '<option value="'.$org['org_id'].'" '.$selected.'>'.$org['org_name'].'</option>';
									endforeach;
									$content = '<div class="form-group">
													<label class="col-md-8 control-label">Organization <span style="color:#f00">*</span></label>
													<div class="col-md-4">
														<select name="org_id" class="form-control">
															<option value="">Select Organization</option>
															'.$org_content.'
														</select>
													</div>
												</div>';
									echo $content;
								endif; 
							?>
						</div>
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
						
						<div class="form-group">
							<label class="col-md-8 control-label">Status</label>
							<div class="col-md-4 control-label">
								<label><input type="radio" name="status" value="1" <?php echo ($row_info['owner_activate'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Available</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['owner_activate'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Unavailable</label>
							</div>
						</div>
						
					</div>
					<div class="panel-footer text-right"> 
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit">Update Administrator</button> 
						<span onclick="window.location.href='<?php echo base_url('setup/administrator'); ?>'" class="btn btn-danger waves-effect waves-light m-t-10">Cancel</span>
					</div>
					<?php echo form_close(); ?>
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
					password:{
						required: true,
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
					password:{
						required: null,
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
		function getRoleType(val){
			if(val == '4')
			{
				$.ajax({
					type : "POST",
					url : baseUrl + "setup/administrator/getorg",
					data : {role:val},
					dataType : "json",
					cache: false,
					contentType: false,
					processData: false,
					success : function (data) {
						if(data.status == "ok")
						{
							$('#selectOrg').html(data.content);
							return false;
						}else
						{
							//have end check.
						}
						return false;
					}
				});
			}else{
				$('#selectOrg').html('');
				return false;
			}
		}
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>