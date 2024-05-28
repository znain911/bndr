<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th style="text-align:left !important;">BNDR ID</th>
			<th style="text-align:left !important;">Name</th>
			<th>Visits</th>
			<th>Gender</th>
			<th>Phone</th>
			<th>Date Of Birth</th>
			<th>Age</th>
			<th>Payment Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sl = $sl+1;
			foreach($items as $item):
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td><?php echo $item['patient_entryid']; ?></td>
			<td><?php echo $item['patient_name']; ?></td>
			<td class="text-center"><?php echo total_visits_of_the_patients($center, $item['patient_id']); ?></td>
			<td class="text-center"><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
			<td class="text-center"><?php echo $item['patient_phone']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
			<td class="text-center"><?php echo $item['patient_age']; ?></td>
			<td class="text-center">
				<?php if($item['patient_payment_status'] === '1'): ?>
					<strong style="color:#0A0">Paid</strong>
				<?php else: ?>
					<strong style="color:#F00">Unpaid</strong>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<a href="<?php echo base_url('orgreports/visits?PATIENT='.$item['patient_id'].'&BNDRID='.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;">View Visits</a>
			</td>
		</tr>
		<?php 
			$sl++;
			endforeach; 
		?>
	</tbody>
</table>
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>