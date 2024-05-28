<div class="col-lg-12" style ="margin-top: 1%">
			<strong>Hide type : </strong> &nbsp;&nbsp;<label class="hidepres-controler" data-value="1"><input type="radio" name="hide" value="1" checked />&nbsp; Case History</label> &nbsp;&nbsp; 
			<label class="hidepres-controler" data-value="0"><input type="radio" name="hide" value="0"  />&nbsp; Progress</label> &nbsp;&nbsp; 
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
	
	<div class="chHide">
		<div class="row ">
				<div class="col-sm-12" style = 'background-color: #ddd; border-bottom: 1px solid rgba(120, 130, 140, .13);box-shadow: 0 6px 5px rgb(34 78 33);margin-bottom: 1%;'>
					<h2 style = 'font-weight: bold;margin-left: 3%;display: inline-block;'><?php echo $patient_info['patient_name'];?>  
					<?php if($item['submitted_by']):?>
					<span style="color:#1B75BC">(Submitted By: <?php echo $item['submitted_by'];?>)</span>
					<?php endif;?>
					</h2>
					
					<!--<a href="<?php echo base_url('patients/visit/add/'.$patientId.'/'.$patient_info['patient_entryid']); ?>" target="_blank" style = "margin-top: 0.5%;" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW CASE HISTORY</a>-->
					<button type="button" style = "    margin-left: 5%; display: none" class="btn btn-danger " onclick="hide(<?php echo $patientId;?>)">Hide</button>
					
				
					
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
				<?php $pictures = $this->Dashboard_model->caseHistoryPichide($item['patient_id']);
						foreach($pictures as $picture):
				?>
				<a href="<?php echo base_url(); ?>caseHistory/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" target="_blank">
					<img src="<?php echo base_url(); ?>caseHistory/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" width="350" height="225" class="img-thumbnail" />
				</a>
				<?php endforeach;?>
			</div>
		</div>
		
		<?php endforeach; endif;
		
		if($hideprogressess):
	foreach($hideprogressess as $progressId):
	$allImage = $this->Dashboard_model->progressAllPichide($progressId['patient_id']);
	$visitsWiseId = array_values(array_column($allImage, null, 'visit_number'));
	foreach($visitsWiseId as $progress):
	$patientId = $progress['patient_id'];
	$patient_info = $this->Dashboard_model->patientDetailImage($progress['patient_id']);
	//print_r($allImage);
	?>
		
		<div class="prHide" style = 'display: none'>
		<div class="row">
			<div class="col-sm-12" style = 'background-color: #ddd; border-bottom: 1px solid rgba(120, 130, 140, .13);box-shadow: 0 6px 5px rgb(34 78 33);margin-bottom: 1%;'>
				<h2 style = 'font-weight: bold;margin-left: 3%;display: inline-block;'><?php echo $patient_info['patient_name'];?>  
				<?php if($progress['submitted_by']):?>
				<span style="color:#1B75BC">(Submitted By: <?php echo $progress['submitted_by'];?>)</span>
				<?php endif;?>
				</h2>
				
				<!--<a href="<?php echo base_url('patients/progress/add/'.$patientId.'/'.$patient_info['patient_entryid']); ?>" target="_blank" style = "margin-top: 0.5%;" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW CASE HISTORY</a>-->
				
			<button type="button" style = "    margin-left: 5%; display: none" class="btn btn-danger " onclick="hideProgress(<?php echo $patientId;?>,<?php echo $progress['visit_number']?>)">Hide</button>
				
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
			<?php $pictures = $this->Dashboard_model->progressPichide($progress['patient_id'],$progress['visit_number']);
			//print_r($progress['patient_id']);
				foreach($pictures as $picture):
			?>
			<a href="<?php echo base_url(); ?>progress/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" target="_blank">
				<img src="<?php echo base_url(); ?>progress/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" onclick="image(this)" width="350" height="225" class="img-thumbnail" />
			</a>
			<?php endforeach; ?>
		</div>
		
	
	</div>
	
	
	<?php endforeach; endforeach; endif;?>
		
		
		
		<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.hidepres-controler', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.chHide').show();
					$('.prHide').hide();
				}else if(check_val == '0')
				{
					$('.prHide').show();
					$('.chHide').hide();
				}
			});

			
		});
	</script>