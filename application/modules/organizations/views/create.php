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
				<div class="panel-heading text-center">ADD ORGANIZATION</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
					<?php 
						$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm');
						echo form_open('', $attr);
					?>
					<div class="panel-body">
						<div class="form-group" style="margin-bottom:0">
							<label class="control-label col-md-8"></label>
							<div class="col-md-4" id="alert"></div>
						</div>
						<?php 
							$org_id = $this->Organization_model->the_last_org_id();
							$org_code = 'ORG'.str_pad($org_id, 3, '0', STR_PAD_LEFT);
						?>
						<div class="form-group">
							<label class="control-label col-md-8">Organization Code <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="org_code" placeholder="Organization Code" class="form-control" value="<?php echo $org_code; ?>" disabled />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Name <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="name" placeholder="Organization Name" class="form-control">
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
					</div>
					<div class="panel-footer text-right"> 
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit" check-method="submit">Register Organization</button> 
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit" check-method="submit-and-more">Register Organization & Add More</button> 
						<span onclick="window.location.href='<?php echo base_url('organizations'); ?>'" class="btn btn-danger waves-effect waves-light m-t-10">Cancel</span> 
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
					name:{
						required: true,
					},
					division:{
						required: true,
					},
					district:{
						required: true,
					},
				},
				messages:{
					name:{
						required: null,
					},
					division:{
						required: null,
					},
					district:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "organizations/save",
						data : $('#createForm').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById('createForm').reset();
								$('#alert').html(data.success);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#loader').hide();
								$('html, body').animate({
										scrollTop: $("body").offset().top
									 }, 1000);
								return false;
							}else if(data.status == "error"){
								$('#alert').html(data.error);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#loader').hide();
								$('html, body').animate({
										scrollTop: $("body").offset().top
									 }, 1000);
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