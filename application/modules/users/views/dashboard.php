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
				<div class="panel-heading text-center">PATIENTS
					<div class="panel-action"><a data-perform="panel-collapse" href="javascript:void(0)"><i class="ti-minus"></i></a> <a data-perform="panel-dismiss" href="javascript:void(0)"><i class="ti-close"></i></a></div>
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>SL.</th>
										<th>ID</th>
										<th>Gender</th>
										<th>Name</th>
										<th>ORG.</th>
										<th>ORG. Center</th>
										<th>Blood Group</th>
										<th>Phone</th>
										<th>Date Of Birth</th>
										<th>Age</th>
										<th>Register Date</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$sl = 1;
										$items = $this->Dashboard_model->get_all_items();
										if(count($items) !== 0):
										foreach($items as $item):
									?>
									<tr>
										<td><?php echo $sl; ?></td>
										<td><?php echo $item['patient_entryid']; ?></td>
										<td><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
										<td><?php echo $item['patient_first_name'].' '.$item['patient_last_name']; ?></td>
										<td><?php echo $item['org_name']; ?></td>
										<td><?php echo $item['orgcenter_name']; ?></td>
										<td><?php echo $item['patient_blood_group']; ?></td>
										<td><?php echo $item['patient_phone']; ?></td>
										<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
										<td><?php echo get_age($item['patient_dateof_birth']); ?></td>
										<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
										<td>
											<?php if($item['patient_status'] == '1'): ?>
											<span class="label label-success">Approved</span>
											<?php else: ?>
											<span class="label label-danger">Pending</span>
											<?php endif; ?>
										</td>
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php' ?>