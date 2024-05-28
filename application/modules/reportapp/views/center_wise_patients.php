<?php 
	$org_info = $this->Report_model->get_org_info($org_id);
	$centers = $this->Report_model->get_centers($org_id);
?>
<div class="panel">
	<div class="panel-heading text-center">
		<span style="font-size: 23px; color: rgb(0, 187, 0);">Reports (Center Wise Patients)</span> <br />
		<span style="font-weight:normal"><strong>Organization : </strong> <?php echo $org_info['org_name']; ?></span>
	</div>
	<div class="table-responsive">
		<table class="table table-hover manage-u-table">
			<thead>
				<tr>
					<th class="text-center">SL.</th>
					<th class="text-left">Center</th>
					<th class="text-center">Total Patients</th>
					<th class="text-center">Total New Patients</th>
					<th class="text-center">Total Old Patients</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$x = 1;
					foreach($centers as $center):
					$total_patients = $this->Report_model->total_center_patients($center['orgcenter_id']);
					$total_new_patients = $this->Report_model->total_patients($center['orgcenter_id'], 'New Patient');
					$total_old_patients = $this->Report_model->total_patients($center['orgcenter_id'], 'Old Patient');
				?>
				<tr>
					<td class="text-center"><?php echo $x; ?></td>
					<td class="text-left"><?php echo $center['orgcenter_name']; ?></td>
					<td class="text-center"><?php echo $total_patients; ?></td>
					<td class="text-center"><?php echo $total_new_patients; ?></td>
					<td class="text-center"><?php echo $total_old_patients; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>