<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th>BNDR ID</th>
			<th>Name</th>
			<th>Gender</th>
			<th>Visit Center</th>
			<th>Patient Phone</th>
			<th>Patient DOB</th>
			<th>Patient Age</th>
			<th>Reg. Date</th>
			<th>Submitted By</th>
			<th>Payment Status</th>
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
			<td><?php echo $item['patient_entryid']; ?></td>
			<td><?php echo $item['patient_name']; ?></td>
			<td><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
			<td><?php echo $item['orgcenter_name']; ?></td>
			<td><?php echo $item['patient_phone']; ?></td>
			<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
			<td><?php echo $item['patient_age']; ?></td>
			<?php if($item['patient_form_version'] == 'V1'): ?>
			<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
			<?php else: ?>
			<td><?php echo date("d M, Y", strtotime($item['patient_registration_date'])); ?></td>
			<?php endif; ?>
			<td class="text-center"><?php echo get_admitted_by($item['patient_admitted_by'], $item['patient_admitted_user_type'], $item['patient_admitted_user_syncid']); ?></td>
			<td class="text-center">
				<?php if($item['patient_payment_status'] === '1'): ?>
					<strong style="color:#0A0">Paid</strong>
				<?php else: ?>
					<strong style="color:#F00">Unpaid</strong>
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
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>