<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Dashboard</h4>
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Setup</li>
				<li class="active">Configuration</li>
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
				<div class="panel-heading text-center">CONFIGURATION
					<div class="panel-action"><a data-perform="panel-collapse" href="javascript:void(0)"><i class="ti-minus"></i></a> <a data-perform="panel-dismiss" href="javascript:void(0)"><i class="ti-close"></i></a></div>
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
					<?php 
						$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm');
						echo form_open('', $attr);
					?>
					<?php 
						$get_config = $this->Setup_model->get_config();
					?>
					<div class="panel-body">
						<div class="form-group" style="margin-bottom:0">
							<label class="control-label col-md-8"></label>
							<div class="col-md-4" id="alert"></div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Visit Registration Fee <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="reg_fee" value="<?php echo $get_config['config_option']; ?>" placeholder="Visit Registration Fee" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-8">Electronic Follow Up Fee <span style="color:#f00">*</span></label>
							<div class="col-md-4">
								<input type="text" name="followup_fee" value="<?php echo $get_config['config_option_two']; ?>" placeholder="Electronic Follow Up Fee" class="form-control">
							</div>
						</div>
					</div>
					<div class="panel-footer text-right"> <button class="btn btn-info waves-effect waves-light m-t-10" type="submit">Update Configuration</button> </div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#createForm").validate({
				rules:{
					reg_fee:{
						required: true,
					},
				},
				messages:{
					reg_fee:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "setup/update_config",
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