<?php require_once APPPATH.'modules/common/header.php' ?>
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Dashboard</h4>
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="index.html">Dashboard</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- ============================================================== -->
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->

	
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default block2">
				<div class="panel-heading text-center put-relative" style="padding: 25px 0px;">
					<ul class="patient-tab-ul">
						
						<li class="active">
							<a href="<?php echo base_url('administrator/dashboard/'); ?>">
								<strong>Prescription</strong>
								Image
							</a>
						</li>
						
						
					
						
					</ul>
				</div>
				
			</div>
		</div>
	</div>
	
	<div class="col-lg-12">
			<strong>Prescription type : </strong> &nbsp;&nbsp;<label class="pres-controler" data-value="1"><input type="radio" name="crnt_is_insulin" value="1" checked />&nbsp; Case History</label> &nbsp;&nbsp; 
			<label class="pres-controler" data-value="0"><input type="radio" name="crnt_is_insulin" value="0"  />&nbsp; Progress</label> &nbsp;&nbsp; 
			<label class="hide-controler" data-value="0"><input type="radio" name="crnt_is_insulin" value="0"  />&nbsp; Hide</label>&nbsp;&nbsp;
			<label class="rp-controler" data-value="0"><input type="radio" name="crnt_is_insulin" value="0"  />&nbsp; Registration Profile</label>&nbsp;&nbsp;
	</div>
	<?php 
	if($items):
	foreach($items as $item):
	$patientId = $item['patient_id'];
	$patient_info = $this->Dashboard_model->patientDetailImage($item['patient_id']);
	$footDoctor = $this->Dashboard_model->footDoctor($item['patient_id']);
	$eyeDoctor = $this->Dashboard_model->eyeDoctor($item['patient_id']);
	$ftDoctor = $this->Dashboard_model->ftDoctor($item['patient_id']);
	?>
	<div class="ch">
		<div class="row">
			<div class="col-sm-12" style = 'background-color: #ddd; border-bottom: 1px solid rgba(120, 130, 140, .13);box-shadow: 0 6px 5px rgb(34 78 33);margin-bottom: 1%;'>
				<h2 style = 'font-weight: bold;margin-left: 3%;display: inline-block;'><?php echo $patient_info['patient_name'];?>  
				<?php if($item['submitted_by']):?>
				<span style="color:#1B75BC">(Submitted By: <?php echo $item['submitted_by'];?>)</span>
				<?php endif;?>
				</h2>
				
				<!--<a href="<?php echo base_url('patients/visit/add/'.$patientId.'/'.$patient_info['patient_entryid']); ?>" target="_blank" style = "margin-top: 0.5%;" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW CASE HISTORY</a>-->
				<button type="button" class="btn btn-success add-case-history" onclick="lockHistory(<?php echo $patientId;?>)">ADD NEW CASE HISTORY</button>
				<button type="button" class="btn btn-info " onclick="transfer(<?php echo $patientId;?>)">Transfer</button>
				<button type="button" style = "    margin-left: 5%;" class="btn btn-danger " onclick="hide(<?php echo $patientId;?>)">Hide</button>
				<button type="button" style = " background: #1b75bc;" class="btn btn-danger " onclick="rp(<?php echo $patientId;?>)">Registration Profile</button>
			
				
			</div>
			<h2 style = 'margin-left: 3%;display: inline-block;'>BNDR Id : <?php echo $patient_info['patient_entryid'];?> 
			<?php if ($item['visit_date']){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Visit Date:</b> <?php 
					if (substr_count( $item['visit_date'],"/") === 2){
						list($day, $month,$year) = explode('/', $item['visit_date']);
						$fnvd= $year.'-'.$month.'-'.$day;
						echo date("d M, Y", strtotime($fnvd)); 
					}else{
						echo date("d M, Y", strtotime($item['visit_date'])); 
					}
					?> </h2>
			<?php }?>
			
			<?php if ($ftDoctor){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Final Treatment Doctor:</b> <?php echo $ftDoctor['doctor_name'];?> </h2>
			<?php }?>
			<?php if ($footDoctor){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Foot Doctor:</b> <?php echo $footDoctor['foot_doctor'];?> </h2>
			<?php }?>
			
			<?php if ($eyeDoctor){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Eye Doctor:</b> <?php echo $eyeDoctor['eye_doctor'];?> </h2>
			<?php }?>
			
			<?php if ($item['orgcenter_name']){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Visit Center:</b> <?php echo $item['orgcenter_name'];?> </h2>
			<?php }?>
			
		</div>
		<div style ="margin-bottom: 1%;margin-top: 1%;">
			<?php $pictures = $this->Dashboard_model->caseHistoryPic($item['patient_id']);
					foreach($pictures as $picture):
			?>
			<a href="<?php echo base_url(); ?>caseHistory/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" target="_blank">
				<img src="<?php echo base_url(); ?>caseHistory/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" width="350" height="225" class="img-thumbnail" />
			</a>
			<?php endforeach;?>
		</div>
	</div>
	<?php endforeach; endif;?>
	<?php 
	if($progressess):
	foreach($progressess as $progressId):
	$allImage = $this->Dashboard_model->progressAllPic($progressId['patient_id']);
	$visitsWiseId = array_values(array_column($allImage, null, 'visit_number'));
	foreach($visitsWiseId as $progress):
	$patientId = $progress['patient_id'];
	$patient_info = $this->Dashboard_model->patientDetailImage($progress['patient_id']);
	?>
	<div class="pr" style = 'display: none'>
		<div class="row">
			<div class="col-sm-12" style = 'background-color: #ddd; border-bottom: 1px solid rgba(120, 130, 140, .13);box-shadow: 0 6px 5px rgb(34 78 33);margin-bottom: 1%;'>
				<h2 style = 'font-weight: bold;margin-left: 3%;display: inline-block;'><?php echo $patient_info['patient_name'];?>  
				<?php if($progress['submitted_by']):?>
				<span style="color:#1B75BC">(Submitted By: <?php echo $progress['submitted_by'];?>)</span>
				<?php endif;?>
				</h2>
				
				<!--<a href="<?php echo base_url('patients/progress/add/'.$patientId.'/'.$patient_info['patient_entryid']); ?>" target="_blank" style = "margin-top: 0.5%;" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW CASE HISTORY</a>-->
				<button type="button" class="btn btn-success add-case-history" onclick="lockProgress(<?php echo $patientId;?>,<?php echo $progress['visit_number']?>)">ADD Progress</button>
				<button type="button" class="btn btn-info " onclick="transferProgress(<?php echo $patientId;?>,<?php echo $progress['visit_number']?>)">Transfer</button>
				<button type="button" style = "    margin-left: 5%;" class="btn btn-danger " onclick="hideProgress(<?php echo $patientId;?>,<?php echo $progress['visit_number']?>)">Hide</button>
				<button type="button" style = "background: #1b75bc;" class="btn btn-danger " onclick="rpProgress(<?php echo $patientId;?>,<?php echo $progress['visit_number']?>)">Registration Profile</button>
			
				
			</div>
			<h2 style = 'margin-left: 3%;display: inline-block;'>BNDR Id : <?php echo $patient_info['patient_entryid'];?> 
			
			<?php if ($progress['visit_date']){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Visit Date:</b> <?php
					if (substr_count( $progress['visit_date'],"/") === 2){
						list($day, $month,$year) = explode('/', $progress['visit_date']);
						$fnvd= $year.'-'.$month.'-'.$day;
						echo date("d M, Y", strtotime($fnvd)); 
					}else{
						echo date("d M, Y", strtotime($progress['visit_date'])); 
					}
					?> </h2>
			<?php }?>
			
			<?php if ($progress['orgcenter_name']){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Visit Center:</b> <?php echo $progress['orgcenter_name'];?> </h2>
			<?php }?>
			<?php if ($progress['doctor_name']){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Doctor name:</b> <?php echo $progress['doctor_name'];?> </h2>
			<?php }?>
		</div>
		<div style ="margin-bottom: 1%;margin-top: 1%;">
			<?php $pictures = $this->Dashboard_model->progressPic($progress['patient_id'],$progress['visit_number']);
				foreach($pictures as $picture):
			?>
			<a href="<?php echo base_url(); ?>progress/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" target="_blank">
				<img src="<?php echo base_url(); ?>progress/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" onclick="image(this)" width="350" height="225" class="img-thumbnail" />
			</a>
			<?php endforeach; ?>
		</div>
		
	
	</div>
	
	
	<?php endforeach; endforeach; endif;?>
	
	<div id="hidepic" style = 'display: none'>
		
	</div>
	
	<div id="rppic" style = 'display: none'>
		
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.pres-controler', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.ch').show();
					$('.pr').hide();
					$('#hidepic').hide();
					$('#rppic').hide();
				}else if(check_val == '0')
				{
					$('.pr').show();
					$('.ch').hide();
					$('#hidepic').hide();
					$('#rppic').hide();
				}
			});
			
			$(document).on('click', '.hide-controler', function(){
				
				$.ajax({
					type: "post",
					url: baseUrl + "administrator/dashboard/hideList",
					data: {},
					dataType:'json',
					success: function (data) {
						
							$('#hidepic').html(data.content);
							//console.log(data.content);
							//alert(data.doctor);
							$('#hidepic').show();
							$('#rppic').hide();
							$('.ch').hide();
							$('.pr').hide();
						
				}
			});
					
			});
			
			$(document).on('click', '.rp-controler', function(){
				$.ajax({
					type: "post",
					url: baseUrl + "administrator/dashboard/rpList",
					data: {},
					dataType:'json',
					success: function (data) {
						
							$('#rppic').html(data.content);
							//console.log(data.content);
							//alert(data.doctor);
							$('#rppic').show();
							$('#hidepic').hide();
							$('.ch').hide();
							$('.pr').hide();
						
				}
			});
				
					
			});
			
			
			
		});
	</script>
	<script type="text/javascript">
		
			function lockHistory(pid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				$.ajax({
					type: "post",
					url: baseUrl + "patients/visit/imageLock",
					data: {pid:pid},
					success: function (data) {
						//var patient =data.status;
						if(data === 'This Patient is locked')
						{
							alert(data);
						}else{
							//alert(data);
							//window.location.href=baseUrl+'patients/visit/add/'+data;
							window.open(baseUrl+'patients/visit/add/'+data);
						}
						
						
					}
				});
			}
			
			function transfer(pid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				
				$.ajax({
					type: "post",
					url: baseUrl + "patients/visit/transfer",
					data: {pid:pid},
					success: function (data) {
						//var patient =data.status;
						//console.log(data);
						if(data === 'success'){
							window.location.reload();
						}else{
							alert('Tranfer Failed');
						}
						
					}
				});
				
			}
			
			function hide(pid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				$.ajax({
					type: "post",
					url: baseUrl + "administrator/dashboard/hide",
					data: {pid:pid},
					success: function (data) {
						//var patient =data.status;
						
						if(data == 1)
						{
							alert('Hide Succesful');
							window.location.reload();
						}else{
							alert('error hiding pictures');
							//window.location.href=baseUrl+'patients/visit/add/'+data;
							
						}
						
						
						
					}
				});
			}
			
			function rp(pid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				$.ajax({
					type: "post",
					url: baseUrl + "administrator/dashboard/rp",
					data: {pid:pid},
					success: function (data) {
						//var patient =data.status;
						
						if(data == 1)
						{
							alert('Picture sent to Registration Profile');
							window.location.reload();
						}else{
							alert('error');
							//window.location.href=baseUrl+'patients/visit/add/'+data;
							
						}
						
						
						
					}
				});
				
			}
			
			function transferProgress(pid,vid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				$.ajax({
					type: "post",
					url: baseUrl + "patients/progress/transferProgress",
					data: {pid:pid , vid:vid},
					success: function (data) {
						//var patient =data.status;
						if(data === 'Success'){
							window.location.reload();
						}else{
							alert('Patient already have a Case History');
						}
						//console.log(data);
						
						
					}
				});
				
				
			}
			function lockProgress(pid,vid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				$.ajax({
					type: "post",
					url: baseUrl + "patients/progress/imageLock",
					data: {pid:pid , vid:vid},
					success: function (data) {
						//var patient =data.status;
						if(data === 'This Patient is locked')
						{
							alert(data);
						}else{
							//alert(data);
							//window.location.href=baseUrl+'patients/visit/add/'+data;
							window.open(baseUrl+'patients/progress/add_super/'+data);
						}
						
						
					}
				});
			}
			
			function hideProgress(pid,vid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				$.ajax({
					type: "post",
					url: baseUrl + "administrator/dashboard/hideProgress",
					data: {pid:pid , vid:vid},
					success: function (data) {
						//var patient =data.status;
						
						if(data == 1)
						{
							alert('Hide Succesful');
							window.location.reload();
						}else{
							alert('error hiding visit');
							//window.location.href=baseUrl+'patients/visit/add/'+data;
							
						}
						
						
						
					}
				});
			}
			
			function rpProgress(pid,vid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				$.ajax({
					type: "post",
					url: baseUrl + "administrator/dashboard/rpProgress",
					data: {pid:pid , vid:vid},
					success: function (data) {
						//var patient =data.status;
						
						if(data == 1)
						{
							alert('Picture sent to Registration Profile');
							window.location.reload();
						}else{
							alert('error');
							//window.location.href=baseUrl+'patients/visit/add/'+data;
							
						}
						
						
						
					}
				});
			}
		
		
	</script>
	
<?php require_once APPPATH.'modules/common/footer.php' ?>