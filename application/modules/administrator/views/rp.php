

<?php 
	if($items):
	foreach($items as $item):
	$patientId = $item['patient_id'];
	$patient_info = $this->Dashboard_model->patientDetailImage($item['patient_id']);
	
	$ftDoctor = $this->Dashboard_model->ftDoctorrp($item['patient_id']);
	?>
	
	<div class="chHide" style ="margin-top: 2%">
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
				<?php }

				if ($item['orgcenter_name']){?>
				<h2 style = 'margin-left: 3%;display: inline-block;'><b>Visit Center:</b> <?php echo $item['orgcenter_name'];?> </h2>
				<?php }?>
				
			</div>
			<div style ="margin-bottom: 1%;margin-top: 1%;">
				<?php $pictures = $this->Dashboard_model->picRp($item['patient_id']);
						foreach($pictures as $picture):
				?>
				<a href="<?php echo base_url(); ?><?php if($picture['visit_type'] === 'Case History'){echo 'caseHistory';}else{ echo 'progress';}?>/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" target="_blank">
					<img src="<?php echo base_url(); ?><?php if($picture['visit_type'] === 'Case History'){echo 'caseHistory';}else{ echo 'progress';}?>/<?php echo $patientId;?>/<?php echo $picture['image_name']?>" width="350" height="225" class="img-thumbnail" />
				</a>
				<?php endforeach;?>
			</div>
		</div>
		
		<?php endforeach; endif;
		
	?>
		
	
		
		
		
		<script type="text/javascript">
	
	</script>