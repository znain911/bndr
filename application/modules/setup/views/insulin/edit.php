<?php
	$get_info = $this->Insulin_model->get_info($id);
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
				<li class="active">Insulin</li>
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
				<div class="panel-heading text-center">UPDATE INSULIN</div>
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
							<label class="control-label col-md-8">Brand <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="brand" value="<?php echo $get_info['insuline_brand']; ?>" placeholder="Brand" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Company <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="company" value="<?php echo $get_info['insuline_company']; ?>" placeholder="Company" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Generic <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="generic" value="<?php echo $get_info['insuline_generic']; ?>" placeholder="Generic" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Dosage <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="dosage" placeholder="Dosage" value="<?php echo $get_info['insuline_dosage']; ?>" class="form-control">
							</div>
						</div>
					</div>
					<div class="panel-footer text-right"> 
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit">Update Insulin</button> 
						<span onclick="window.location.href='<?php echo base_url('setup/insulin'); ?>'" class="btn btn-danger waves-effect waves-light m-t-10">Cancel</span>
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
					brand:{
						required: true,
					},
					company:{
						required: true,
					},
					generic:{
						required: true,
					},
					dosage:{
						required: true,
					},
				},
				messages:{
					brand:{
						required: null,
					},
					company:{
						required: null,
					},
					generic:{
						required: null,
					},
					dosage:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "setup/insulin/update",
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
<?php require_once APPPATH.'modules/common/footer.php' ?>