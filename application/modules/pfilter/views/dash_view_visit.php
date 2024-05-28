<div>
	<span style="display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;">
	<strong>
	<?php if(empty($conditions['search']['year']) && empty($conditions['search']['month']) && empty($conditions['search']['type'])
			&& empty($conditions['search']['operator']) && empty($conditions['search']['center']) && empty($conditions['search']['from_date']) && empty($conditions['search']['to_date'])
		&& empty($conditions['search']['doctor'])):
		?>
		Today 
		<?php endif;?>
		Total :
	</strong> <span id="totalPatients"><?php echo $totalRec; ?></span>

	</span>
</div>
								<table class="table">
									<thead>
										<tr>
											<th>SL.</th>
											<th>ID</th>
											<th>Gender</th>
											<th>Name</th>
											<th>Center</th>
											<th>Phone</th>
											<!--<th>Date Of Birth</th>-->
											<th>Age</th>
											<th>Register Date</th>
											<th>Visit Date</th>
											<th>Visit Type</th>
											<?php if(!empty($conditions['search']['operator'])):?>
											<th>Operator</th>
											<?php elseif(!empty($conditions['search']['doctor'])):?>
											<th>Doctor</th>
											<?php else:?>
											<th>Type of User</th>
											<?php endif;?>
											
										</tr>
									</thead>
									<tbody>
										<?php 
											$sl = 1;
											if(count($items) !== 0):
											foreach($items as $item):
										?>
										<tr>
											<td><?php echo $sl; ?></td>
											<td><?php echo $item['patient_id']; ?></td>
											<td><?php echo $item['patient_gender']; ?></td>
											<td><?php echo $item['patient_name']; ?></td>
											<td><?php echo $item['orgcenter_name']; ?></td>
											<td><?php echo $item['patient_phone']; ?></td>
											<!--<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>-->
											<td><?php echo $item['patient_age']; ?></td>
											<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
											<td><?php echo date("d M, Y", strtotime($item['visit_admit_date'])); ?></td>
											<td><?php echo $item['visit_type']; ?></td>
											<td><?php  if($item['visit_admited_by_usertype'] === 'Operator' || $item['visit_admited_by_usertype'] === 'Super Operator'){
												if(!empty($conditions['search']['operator'])){
													echo $item['submitted_by']; 
												}else{
													echo 'Operator';  
												}
											}else {
												if(!empty($conditions['search']['doctor'])){
													$doctor = $this->Dashboard_model->get_doctor_name($item['visit_admited_by']);
													echo $doctor['doctor_full_name'];
												}else{
													echo 'Doctor';
												}
											}?></td>
											
											
										</tr>
										<?php 
											$sl++;
											endforeach; 
											else:
										?>
										<tr><td colspan="13" class="text-center">No new patients.</td></tr>
										<?php endif; ?>
									</tbody>
								</table>
								<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>
							