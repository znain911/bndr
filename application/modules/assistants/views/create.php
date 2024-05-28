<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Assistants</li>
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
				<div class="panel-heading text-center">REGISTER DOCTOR ASSISTANT</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
					<?php 
						$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm');
						echo form_open('', $attr);
					?>
					<div class="panel-body">
						<div class="form-group" style="margin-bottom:0">
							<label class="control-label col-md-7"></label>
							<div class="col-md-5" id="alert"></div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Full Name <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="full_name" placeholder="Full Name" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Phone Number <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="phone" placeholder="Phone Number" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Date Of Birth <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="dateof_birth" placeholder="yyyy-mm-dd" class="form-control datepicker">
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
									<option value="<?php echo $org['org_id']; ?>"><?php echo $org['org_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Center <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<select name="center" class="form-control" id="cenTers">
									<option value="" selected="selected">Select Center</option>
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
									<option value="<?php echo $division['division_id']; ?>"><?php echo $division['division_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">District <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<select name="district" class="form-control" id="selectedDistrict">
									<option value="" selected="selected">Select District</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Upazila</label>
							<div class="col-md-4">
								<select name="upazila" class="form-control" id="selectedUpazila">
									<option value="" selected="selected">Select Upazila</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Address</label>
							<div class="col-md-4">
								<textarea name="address" class="form-control" id="" cols="30" rows="5"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Postal Code</label>
							<div class="col-md-4">
								<input type="text" name="postal_code" placeholder="Postal Code" class="form-control">
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
								<input type="text" name="email" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Password <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="password" name="password" placeholder="**********" class="form-control" id="password">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Re-enter Password <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="password" name="password_again" placeholder="**********" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-8 control-label">Status</label>
							<div class="col-md-4 control-label">
								<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Available</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Unavailable</label>
							</div>
						</div>
					</div>
					<div class="panel-footer text-right"> 
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit">Register Doctor Assistant</button> 
						<span onclick="window.location.href='<?php echo base_url('assistants'); ?>'" class="btn btn-danger waves-effect waves-light m-t-10">Cancel</span>
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
					phone:{
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
					password:{
						required: true,
					},
					password_again:{
						required: true,
						equalTo: "#password",
					},
				},
				messages:{
					full_name:{
						required: null,
					},
					phone:{
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
					password:{
						required: null,
					},
					password_again:{
						required: null,
						equalTo: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "assistants/save",
						data : $('#createForm').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('html, body').animate({
									scrollTop: $("body").offset().top
								 }, 1000);
								document.getElementById('createForm').reset();
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
<?php require_once APPPATH.'modules/common/footer.php' ?>