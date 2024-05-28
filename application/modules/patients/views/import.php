<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Patients</li>
				<li class="active">Import</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<?php 
			$attr = array('class' => 'form-horizontal form-material', 'id' => 'createForm', 'style' => 'padding:0 5%;');
			echo form_open('', $attr);
		?>
		<div class="col-lg-12">
			<div id="alert"></div>
			<div class="panel panel-default block2" id="basicInformation">
				<div class="panel-heading text-center">IMPORT FILE</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6"></div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label col-md-5">Organization <span style="color:#f00">*</span></label>
									<div class="col-md-7">
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
									<label class="control-label col-md-5">Center <span style="color:#f00">*</span></label>
									<div class="col-md-7">
										<select name="center" class="form-control" id="cenTers">
											<option value="" selected="selected">Select Center</option>
										</select>
									</div>
								</div>
								<?php 
									$payment_config = $this->Patient_model->get_config();
								?>
								<div class="form-group">
									<div class="col-md-12 text-center">
										<label class="sel-sympt-payment">Registration Fee (BDT <?php echo ($payment_config['config_option'])? $payment_config['config_option'] : 0; ?>)</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
										<div class="payment-type-keywords">
											<div style="height:100px;" class="col-lg-12 text-center">
												<p><strong>Payment Status:</strong></p>
												<p>
													<input type="hidden" name="fee_amount" value="<?php echo ($payment_config['config_option'])? $payment_config['config_option'] : 0; ?>" />
													<label><input type="radio" value="1" name="payment" />&nbsp;&nbsp;Paid</label> &nbsp;&nbsp;
													<label><input type="radio" value="0" name="payment" checked />&nbsp;&nbsp;Unpaid</label> &nbsp;&nbsp;
												</p>
											</div>
										</div>
									</div>
									<input type="hidden" />
								</div>
								<div class="form-group">
									<label class="control-label col-md-5">Upload (Excel File allowed)</label>
									<div class="col-md-7">
										<input type="file" name="import_file" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer text-right"> 
					<button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Import</button> 
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){	
				$("#createForm").validate({
					rules:{
						organization:{
							required: true,
						},
						center:{
							required: true,
						},
					},
					messages:{
						organization:{
							required: null,
						},
						center:{
							required: null,
						},
					},
					submitHandler : function () {
						$('#loader').show();
						var getFrmData = new FormData(document.getElementById('createForm'));
						// your function if, validate is success
						$.ajax({
							type : "POST",
							url : baseUrl + "patients/importstart",
							data : getFrmData,
							dataType : "json",
							cache: false,
							contentType: false,
							processData: false,
							success : function (data) {
								if(data.status == "ok")
								{
									document.getElementById('createForm').reset();
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