<?php require_once APPPATH.'modules/common/header.php' ?>
	
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
								<strong>Case History</strong>
								Image
							</a>
						</li>
						
						
					
						
					</ul>
				</div>
				
			</div>
		</div>
	</div>
	
	
	<?php 
	if($item):
	
	$patientId = $item['patient_id'];
	$patient_info = $this->Progress_model->patientDetailImage($item['patient_id']);
	$ftDoctor = $this->Progress_model->ftDoctor($item['patient_id'] , $vid);
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
			
			
				
			</div>
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
			
			
			<?php if ($item['orgcenter_name']){?>
			<h2 style = 'margin-left: 3%;display: inline-block;'><b>Visit Center:</b> <?php echo $item['orgcenter_name'];?> </h2>
			<?php }?>
			
		</div>
		<div style ="margin-bottom: 1%;margin-top: 1%;">
			<?php $pictures = $this->Progress_model->progressPic($item['patient_id'], $vid);
					foreach($pictures as $picture):
			?>
			<a href="<?php echo base_url(); ?>progress/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" target="_blank">
				<img src="<?php echo base_url(); ?>progress/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" width="350" height="225" class="img-thumbnail" />
			</a>
			<?php endforeach;?>
		</div>
	</div>
	<?php  endif;?>


	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.pres-controler', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.ch').show();
					$('.pr').hide();
				}else if(check_val == '0')
				{
					$('.pr').show();
					$('.ch').hide();
				}
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
			function lockProgress(pid){
				//var pid = $(this).prev('.patient-id').val();
				//alert(pid);
				$.ajax({
					type: "post",
					url: baseUrl + "patients/progress/imageLock",
					data: {pid:pid},
					success: function (data) {
						//var patient =data.status;
						if(data === 'This Patient is locked')
						{
							alert(data);
						}else{
							//alert(data);
							//window.location.href=baseUrl+'patients/visit/add/'+data;
							window.open(baseUrl+'patients/progress/add/'+data);
						}
						
						
					}
				});
			}
		
	</script>
	
<?php require_once APPPATH.'modules/common/footer.php' ?>