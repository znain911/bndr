<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="index.html">Dashboard</a></li>
				<li class="active">Reports</li>
				<li class="active">Center Wise Doctors</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>

	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-md-12 put-relative">
			<div id="loader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
			<div class="filter-form-report">
				<?php  
					$attr = array('id' => 'filterForm', 'class' => 'filter-form-report form-material');
					echo form_open('', $attr);
				?>
					<div class="form-group row">
						<label class="col-lg-8 text-right">Select Organization</label>
						<div class="col-lg-4">
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
					<div class="form-group row">
						<label class="col-lg-8 text-right">Select Center</label>
						<div class="col-lg-4">
							<select name="center" class="form-control" id="cenTers">
								<option value="" selected="selected">Select Center</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-8"></label>
						<div class="col-lg-4 text-right">
							<button type="submit" class="fcbtn btn btn-success btn-outline btn-1b">Get Reports</button>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		
		<div class="col-md-12" id="showContent"></div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#filterForm").validate({
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
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "reports/get_centerwise_doctors",
						data : $('#filterForm').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById('filterForm').reset();
								$('#showContent').html(data.content);
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
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>