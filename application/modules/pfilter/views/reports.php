<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th>Serial No</th>
			<th>Visit Type</th>
			<th>Visit date</th>
			<th>Admitted by</th>
			<th>Visit Create Date</th>
			<th>Fee Type</th>
			<th>Payment Status</th>
			<th>Action</th>
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
			<td class="text-center"><?php echo $item['visit_serial_no']; ?></td>
			<td class="text-center"><?php echo $item['visit_type']; ?></td>
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
				<a href="<?php echo base_url('patients/visit/edit/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a data-item="<?php echo $item['visit_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;margin-right:5px;"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
				<a href="<?php echo base_url('patients/visit/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
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