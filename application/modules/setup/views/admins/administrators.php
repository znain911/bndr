<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Setup</li>
				<li class="active">Administrators</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-lg-12">
			<div class="add-href-unit">
				<strong style="margin-top:15px;" class="pull-left">ADMINISTRATORS</strong>
				<a href="<?php echo base_url('setup/administrator/create'); ?>" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW ADMINISTRATOR</a>
			</div>
			<div class="panel panel-default block2" style="padding:15px">
				<div class="table-responsive put-relative">
					<table id="dataTable" class="table">
						<thead>
							<tr>
								<th class="text-center">SL.</th>
								<th class="text-center">Name</th>
								<th class="text-center">Phone</th>
								<th class="text-center">Photo</th>
								<th class="text-center">Email</th>
								<th class="text-center">Role</th>
								<th class="text-center">Created Date</th>
								<th class="text-center">Status</th>
								<th class="text-center">Action</th>
								<th>Change Password</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$x = 1;
								$items = $this->Administrator_model->get_all_items();
								foreach($items as $item):
							?>
							<tr>
								<td class="text-center"><?php echo $x; ?></td>
								<td><?php echo $item['owner_name']; ?></td>
								<td><?php echo $item['owner_phone']; ?></td>
								<td class="text-center">
									<?php 
										if($item['owner_photo']):
									?>
									<img src="<?php echo attachment_url('administrators/'.$item['owner_photo']); ?>" height="40" width="50"/>
									<?php else: ?>
									<img src="<?php echo base_url('assets/tools/default_avatar.png'); ?>" height="40" width="50"/>
									<?php endif; ?>
								</td>
								<td class="text-center"><?php echo $item['owner_email']; ?></td>
								<td class="text-center"><?php echo $item['role_title']; ?></td>
								<td class="text-center">
									<?php
										$time = strtotime($item['owner_create_date']);
										$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
										echo $myFormatForView;
									?>
								</td>
								<td class="admin-status text-center">
									<?php if($item['owner_activate'] !== '1'): ?>
									<i class="fa fa-lock"></i>
									<?php else : ?>
									<i class="fa fa-check"></i>
									<?php endif; ?> 
								</td>
								<td class="jsgrid">
									<button onclick="window.location.href='<?php echo base_url('setup/administrator/edit/'.$item['owner_id']); ?>'" class="jsgrid-button jsgrid-edit-button" type="button" title="Edit"></button>
									<button data-item="<?php echo $item['owner_id']; ?>" class="remove-btn jsgrid-button jsgrid-delete-button" type="button" title="Delete"></button>
								</td>
								<td class="text-center">
									<a data-id="<?php echo $item['owner_id']; ?>" class="btn btn-block change-password row-action-change-password" data-target="#modal-without-animation" data-toggle="modal">Change Password</a>
								</td>
							</tr>
							<?php 
								$x++;
								endforeach; 
							?>
						</tbody>
					</table>
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
						<div id="UpPloader"><img src="<?php echo base_url('assets/tools/loader.gif'); ?>" alt="" /></div>
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
			$(document).on('click', '.remove-btn', function(){
				if(confirm('Are you sure to delete?', true))
				{
					var item = $(this).attr('data-item');
					$.ajax({
						type : "POST",
						url : baseUrl + "setup/administrator/delete",
						data : {id:item},
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
					$(this).parent().parent().remove();
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