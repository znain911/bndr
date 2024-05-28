<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th>Visit No</th>
			<th>Visit Center</th>
			<th>Visit Date</th>
			<th>Visit Type</th>
			<th>Submitted By</th>
			<th>Payment Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sl = 1;
			if(count($items) !== 0):
			foreach($items as $item):
		?>
		<tr>
			<td class="text-center"><?php echo $sl; ?></td>
			<td class="text-center"><?php echo $item['visit_number']; ?></td>
			<td class="text-center"><?php echo $item['visit_visit_center']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_date'])); ?></td>
			<td class="text-center"><?php echo str_replace('_', ' ', $item['visit_is']); ?></td>
			<td class="text-center"><?php echo get_admitted_by($item['visit_admited_by'], $item['visit_admited_by_usertype'], $item['visit_admited_by_usersyncid']); ?></td>
			<td class="text-center">
				<?php if($item['payment_patient_status'] === '1'): ?>
					<strong style="color:#0A0">Paid</strong>
				<?php else: ?>
					<strong style="color:#F00">Unpaid</strong>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<?php if($item['visit_is'] == 'PROGRESS_REPORT'): ?>
				<a href="<?php echo base_url('patients/progress/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
				<?php else: ?>
				<a href="<?php echo base_url('patients/visit/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
				<?php endif; ?>
			</td>
		</tr>
		<?php 
			$sl++;
			endforeach;
			else:
		?>
		<tr><td colspan="13" class="text-center">No Data Found.</td></tr>
		<?php endif; ?>
	</tbody>
</table>
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>