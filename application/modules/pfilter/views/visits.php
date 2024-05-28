<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th>Type</th>
			<th>Visit No</th>
			<th>Duration Of DM</th>
			<th>Visit date</th>
			<th>Submitted by</th>
			<th>Visit Create Date</th>
			<th>Fee Type</th>
			<th>Payment Status</th>
			<th>Action</th>
			<th>Receipt</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = $sl+1;
			if(count($items) !== 0):
			foreach($items as $item):
		?>
		<tr>
			<td class="text-center"><?php echo $sl; ?></td>
			<td class="text-center"><?php echo str_replace('_', ' ', $item['visit_is']); ?></td>
			<td class="text-center"><?php echo $item['visit_serial_no']; ?></td>
			<td class="text-center"><?php echo $item['dhistory_duration_of_glucose']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_date'])); ?></td>
			<td class="text-center"><?php echo $item['visit_admited_by']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_admit_date'])).' '.date("g:i A", strtotime($item['visit_admit_date'])); ?></td>
			<td class="text-center">
				<?php  
					echo 'Electronic Follow Up Fee '.'(BDT'.$item['payment_patient_fee_amount'].')';
				?>
			</td>
			<td class="text-center">
				<?php if($item['payment_patient_status'] === '1'): ?>
					<strong style="color:#0A0">Paid</strong>
				<?php else: ?>
					<strong style="color:#F00">Unpaid</strong>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<?php if($item['visit_is'] == 'PROGRESS_REPORT'): ?>
				<a href="<?php echo base_url('patients/progress/edit/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php else: ?>
				<a href="<?php echo base_url('patients/visit/edit/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php endif; ?>
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a data-item="<?php echo $item['visit_id']; ?>" data-patient="<?php echo $item['visit_patient_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;margin-right:5px;"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
				<?php if($item['visit_is'] == 'PROGRESS_REPORT'): ?>
				<a href="<?php echo base_url('patients/progress/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
				<?php else: ?>
				<a href="<?php echo base_url('patients/visit/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<?php if($item['visit_is'] == 'PROGRESS_REPORT'): ?>
				<a target="_blank" href="<?php echo base_url('patients/progress/moneyreceipt/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
				<?php else: ?>
				<a target="_blank" href="<?php echo base_url('patients/visit/moneyreceipt/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
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