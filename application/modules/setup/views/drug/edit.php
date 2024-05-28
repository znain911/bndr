<?php
	$get_info = $this->Drugs_model->get_info($id);
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
				<li class="active">Drugs</li>
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
				<div class="panel-heading text-center">UPDATE DRUG</div>
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
							<label class="control-label col-md-8">Company <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<select name="company_id" class="form-control">
									<option value="">Select Company</option>
									<?php 
										$companies = $this->Drugs_model->get_companies();
										foreach($companies as $company):
									?>
									<option value="<?php echo $company['company_id']; ?>" <?php echo ($get_info['company'] == $company['company_id'])? 'selected': null; ?>><?php echo $company['company_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-8">Brand <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="brand" placeholder="Enter Brand" class="form-control" value="<?php echo $get_info['brand']; ?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-8">Generic <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="generic" placeholder="Enter Generic" class="form-control" value="<?php echo $get_info['generic']; ?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-8">Strength <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="strength" placeholder="Enter Strength" class="form-control" value="<?php echo $get_info['strength']; ?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-8">Dosages <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="dosages" placeholder="Enter Dosages" class="form-control" value="<?php echo $get_info['dosages']; ?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-8">DAR</label>
							<div class="col-md-4">
								<input type="text" name="dar" placeholder="Enter DAR" class="form-control" value="<?php echo $get_info['DAR']; ?>" />
							</div>
						</div>
					</div>
					<div class="panel-footer text-right"> 
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit">Update Drug</button> 
						<span onclick="window.location.href='<?php echo base_url('setup/drugs'); ?>'" class="btn btn-danger waves-effect waves-light m-t-10">Cancel</span>
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
					title:{
						required: true,
					},
				},
				messages:{
					title:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "setup/drugs/update",
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