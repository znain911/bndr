<table class="table">
	<thead>
		<tr>
			<th style="width: 5%;">SL.</th>
			<th style="width: 30%;">Company Name</th>
			<th style="width: 15%;">Type</th>
			<th style="width: 12%;">Create Date</th>
			<th style="width: 20%;">Created By</th>
			<th style="width: 7%;">Status</th>
			<th style="width: 6%;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sl = $sl + 1;
			foreach($items as $item):
			$types = array('1' => 'Local', '2' => 'International', '' => '');
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td><?php echo $item['company_name']; ?></td>
			<td class="text-center"><?php echo $types[$item['company_type']]; ?></td>
			<td><?php echo date("d M, Y", strtotime($item['company_create_date'])).' '.date("g:i A", strtotime($item['company_create_date'])); ?></td>
			<td class="text-center"><?php echo get_admitted_by($item['company_created_by'], $item['company_created_by_user_type']); ?></td>
			<td class="text-center">
				<?php if($item['company_status'] == 'YES'): ?>
				<span class="label label-success">Available</span>
				<?php else: ?>
				<span class="label label-danger">Unavailable</span>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<a href="<?php echo base_url('setup/company/edit/'.$item['company_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a data-item="<?php echo $item['company_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
			</td>
		</tr>
		<?php 
			$sl++;
			endforeach; 
		?>
	</tbody>
</table>
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>