<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th>BNDR ID</th>
			<th>Name</th>
			<th>Visit No</th>
			<th>Visit Type</th>
			<th>Visit Date</th>
			<th>Submitted By</th>
			<th>Visit Center</th>
			<th>Visit Created</th>
			<!--<th>Payment Status</th>-->
			<th style="width: 8%;">Action</th>
			<th>Receipt</th>
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
			<td class="text-center"><?php echo $item['patient_entryid']; ?></td>
			<td class="text-center"><?php echo $item['patient_name']; ?></td>
			<td class="text-center"><?php echo 'Visit '.$item['visit_number']; ?></td>
			<td class="text-center"><?php echo $item['visit_type']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_admit_date'])); ?></td>
			<td class="text-center"><?php echo get_admitted_by($item['visit_admited_by'], $item['visit_admited_by_usertype'], $item['visit_admited_by_usersyncid']); ?></td>
			<td class="text-center"><?php echo $item['orgcenter_name']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_admit_date'])).' '.date("g:i A", strtotime($item['visit_admit_date'])); ?></td>
			<!--<td class="text-center">
				<?php if($item['payment_patient_status'] === '1'): ?>
					<strong style="color:#0A0">Paid</strong>
				<?php else: ?>
					<strong style="color:#F00">Unpaid</strong>
				<?php endif; ?>
			</td>-->
			<td class="text-center">
				<a href="<?php echo base_url('patients/visit/edit/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a data-item="<?php echo $item['visit_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;margin-right:5px;"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
				<a href="<?php echo base_url('patients/visit/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
			</td>
			<td class="text-center">
				<a target="_blank" href="<?php echo base_url('patients/visit/moneyreceipt/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
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