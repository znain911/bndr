
<?php if ($entry):?>
<h2>Date Entry Count<h2/>
<?php else:?>
<h2>Prescription Upload Count<h2/>
<?php endif;?>
								<table class="table" style = '    background: white;' id="example" data-page-length="10">
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
											<th>Prescription of</th>
											<?php if ($entry):?>
											<th>Submitted By</th>
											<th>Action</th>
											<?php endif;?>
											
											
										</tr>
									</thead>
									<tbody>
										<?php 
											$sl = 1;
											if(count($progresses) !== 0 || count($chs) !== 0):
											if(count($progresses) !== 0 ):
											
											$vdate2 = null;
											
											foreach($progresses as $progress):
											
											if ($entry){
												if($progress['visit_date'] && substr_count( $progress['visit_date'],"-") === 2){
													
													$get_visit = $this->Dashboard_model->get_a_visit($progress['patient_id'],$progress['visit_date']);
														$vdate2 = $progress['visit_date'];
												}elseif($progress['visit_date'] && substr_count( $progress['visit_date'],"/") === 2){
													list($day, $month,$year) = explode('/', $progress['visit_date']);
													$vdate= $year.'-'.$month.'-'.$day;
													$get_visit = $this->Dashboard_model->get_a_visit($progress['patient_id'],$vdate);
													$vdate2 = $vdate;
												}
											}
										?>
										<tr>
											<td><?php echo $sl; ?></td>
											<td><?php echo $progress['patient_entryid']; ?></td>
											<td><?php  echo ($progress['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>';  ?></td>
											<td><?php echo $progress['patient_name']; ?></td>
											<td><?php echo $progress['orgcenter_name']; ?></td>
											<td><?php echo $progress['patient_phone']; ?></td>
											<!--<td><?php echo date("d M, Y", strtotime($progress['patient_dateof_birth'])); ?></td>-->
											<td><?php echo $progress['patient_age']; ?></td>
											<td><?php echo date("d M, Y", strtotime($progress['patient_create_date'])).' '.date("g:i A", strtotime($progress['patient_create_date'])); ?></td>
											<td><?php echo date("d M, Y", strtotime($vdate2)); ?></td>
											<td><?php echo $progress['visit_type']; ?></td>
											<td><?php echo substr($progress['submitted_by'], 0, -9); ?></td>
											<?php if ($entry):?>
											<td><?php echo $progress['insert_by']; ?></td>
											<td>
												<?php if ($get_visit){ if($get_visit['visit_is'] === 'PROGRESS_REPORT'){ ?>
												
													<a href="<?php echo base_url('patients/progress/view/'.$get_visit['visit_id'].'/'.$get_visit['visit_patient_id'].'/'.$get_visit['visit_entryid']); ?>" target="_blank" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
												
												<?php }} ?>
											</td>
											<?php endif;?>
											
											
										</tr>
										<?php 
											$sl++;
											endforeach; 
											endif;
											
											if(count($chs) !== 0 ):
											$vdate2 = null;
											foreach($chs as $ch):
											
											if ($entry){
													if($ch['visit_date'] && substr_count( $ch['visit_date'],"-") === 2){
														$get_visit = $this->Dashboard_model->get_a_visit_ch($ch['patient_id'],$ch['visit_date']);
														$vdate2 = $ch['visit_date'];
													}elseif($ch['visit_date'] && substr_count( $ch['visit_date'],"/") === 2){
														list($day, $month,$year) = explode('/', $ch['visit_date']);
														$vdate= $year.'-'.$month.'-'.$day;
														$get_visit = $this->Dashboard_model->get_a_visit_ch($ch['patient_id'],$vdate);
														$vdate2 = $vdate;
													}
												}
											
											?>
											<tr>
												<td><?php echo $sl; ?></td>
												<td><?php echo $ch['patient_entryid']; ?></td>
												<td><?php  echo ($ch['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>';  ?></td>
												<td><?php echo $ch['patient_name']; ?></td>
												<td><?php echo $ch['orgcenter_name']; ?></td>
												<td><?php echo $ch['patient_phone']; ?></td>
												<!--<td><?php echo date("d M, Y", strtotime($ch['patient_dateof_birth'])); ?></td>-->
												<td><?php echo $ch['patient_age']; ?></td>
												<td><?php echo date("d M, Y", strtotime($ch['patient_create_date'])).' '.date("g:i A", strtotime($ch['patient_create_date'])); ?></td>
												<td><?php echo date("d M, Y", strtotime($vdate2)); ?></td>
												<td><?php echo $ch['visit_type']; ?></td>
												<td><?php echo substr($ch['submitted_by'], 0, -9); ?></td>
												<?php if ($entry):?>
												<td><?php echo $ch['insert_by']; ?></td>
												<td>
													<?php  if ($get_visit){ if($get_visit['visit_is'] === 'CASE_HISTORY'){ ?>
													
														<a href="<?php echo base_url('patients/visit/view/'.$get_visit['visit_id'].'/'.$get_visit['visit_patient_id'].'/'.$get_visit['visit_entryid']); ?>" target="_blank" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
													
													<?php }} ?>
												</td>
												<?php endif;?>
											</tr>
										<?php	
											$sl++;
											endforeach; 
											endif;
											else:
										?>
										<tr><td colspan="13" class="text-center">No Entry Recorded.</td></tr>
										<?php endif; ?>
									</tbody>
								</table>
	<script type="text/javascript">
		 $(function(e) {
            $('#example').DataTable(
                {lengthMenu:[5,10,25,50,100],pageLength:10,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}
                );
        } );
	</script>								
							