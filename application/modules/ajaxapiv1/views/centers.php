<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th style="text-align:left !important;">Center Name</th>
			<th style="text-align:left !important;">Organization</th>
			<th>Total Patients</th>
			<th>Total Visits</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sl = $sl + 1;
			$patient_params = array('search' => array(
				'from_date' => $from_date,
				'to_date'   => $to_date,
				'month'     => $month,
				'year'      => $year,
			));
			$visit_params = array('search' => array(
				'from_date' => $from_date,
				'to_date'   => $to_date,
				'month'     => $month,
				'year'      => $year,
			));
			foreach($items as $item):
		?>
		<tr>
			<td class="text-center"><?php echo $sl; ?></td>
			<td><?php echo $item['orgcenter_name']; ?></td>
			<td><?php echo $item['org_name']; ?></td>
			<td class="text-center"><?php echo total_patients_of_the_center($patient_params, $item['orgcenter_id']); ?></td>
			<td class="text-center"><?php echo total_visits_of_the_center($visit_params, $item['orgcenter_id']); ?></td>
			<td class="text-center">
				<a href="<?php echo base_url('orgreports/operators?CENTER='.$item['orgcenter_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;">View Operators</a>
			</td>
		</tr>
		<?php 
			$sl++;
			endforeach; 
		?>
	</tbody>
</table>
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>