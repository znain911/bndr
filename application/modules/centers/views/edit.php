<?php
	$get_info = $this->Center_model->get_info($id);
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
				<li class="active">Centers</li>
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
				<div class="panel-heading text-center">EDIT CENTER</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
					<?php 
						$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm');
						echo form_open('', $attr);
					?>
					<input type="hidden" name="id" value="<?php echo $get_info['orgcenter_id']; ?>" />
					<div class="panel-body">
						<div class="form-group" style="margin-bottom:0">
							<label class="control-label col-md-8"></label>
							<div class="col-md-4" id="alert"></div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Center Code <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="orgcenter_code" placeholder="Center Code" value="<?php echo $get_info['orgcenter_code']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Organization <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<select name="org" class="form-control">
									<option value="" selected="selected">Select Organization</option>
									<?php 
										$orgs = $this->Organization_model->get_all_items();
										foreach($orgs as $org):
									?>
									<option value="<?php echo $org['org_id']; ?>" <?php echo ($get_info['orgcenter_org_id'] == $org['org_id'])? 'selected' : null; ?>><?php echo $org['org_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Center Name <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="name" placeholder="Center Name" value="<?php echo $get_info['orgcenter_name']; ?>" class="form-control">
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
									<option value="<?php echo $division['division_id']; ?>" <?php echo ($get_info['orgcenter_division_id'] == $division['division_id'])? 'selected' : null; ?>><?php echo $division['division_name']; ?></option>
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
										$districts = $this->Organization_model->get_all_districts($get_info['orgcenter_division_id']);
										foreach($districts as $district):
									?>
									<option value="<?php echo $district['district_id']; ?>" <?php echo ($get_info['orgcenter_district_id'] == $district['district_id'])? 'selected' : null; ?>><?php echo $district['district_name']; ?></option>
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
										$upazilas = $this->Organization_model->get_all_upazilas($get_info['orgcenter_district_id']);
										foreach($upazilas as $upazila):
									?>
									<option value="<?php echo $upazila['upazila_id']; ?>" <?php echo ($get_info['orgcenter_upazila_id'] == $upazila['upazila_id'])? 'selected' : null; ?>><?php echo $upazila['upazila_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="panel-footer text-right"> 
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit">Update Center</button> 
						<span onclick="window.location.href='<?php echo base_url('centers'); ?>'" class="btn btn-danger waves-effect waves-light m-t-10">Cancel</span>
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
					org:{
						required: true,
					},
					orgcenter_code:{
						required: true,
					},
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
					org:{
						required: null,
					},
					orgcenter_code:{
						required: null,
					},
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
						url : baseUrl + "centers/update",
						data : $('#createForm').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('#alert').html(data.success);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#loader').hide();
								return false;
							}else if(data.status == "error"){
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