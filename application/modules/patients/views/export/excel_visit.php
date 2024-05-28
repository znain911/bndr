
								<table class="table" border="1">
									<thead>
										<tr>
											<th>SL.</th>
											<th>ID</th>
											<th>Gender</th>
											<th>Name</th>
											<th>Center</th>
											<th>Phone</th>
											<th>Date Of Birth</th>
											<th>Age</th>
											<th>Register Date</th>
											<th>Visit Date</th>
											<th>Visit Type</th>
											<th>Submitted By</th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
											$sl = 1;
											if( count($items) !== 0):
											foreach($items as $item):
										?>
										<tr>
											<td><?php echo $sl; ?></td>
											<td><?php echo $item['patient_id']; ?></td>
											<td><?php echo $item['patient_gender']; ?></td>
											<td><?php echo $item['patient_name']; ?></td>
											<td><?php echo $item['orgcenter_name']; ?></td>
											<td><?php echo $item['patient_phone']; ?></td>
											<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
											<td><?php echo $item['patient_age']; ?></td>
											<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
											<td><?php echo date("d M, Y", strtotime($item['visit_date'])); ?></td>
											<td><?php echo $item['visit_type']; ?></td>
											<td><?php echo $item['submitted_by']; ?></td>
											
											
										</tr>
										<?php 
											$sl++;
											endforeach; 
											else:
										?>
										<tr><td colspan="13" class="text-center">No new patients today.</td></tr>
										<?php endif; ?>
									</tbody>
								</table>
								
							