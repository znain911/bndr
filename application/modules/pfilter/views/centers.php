<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th>Name</th>
			<th>ORG.</th>
			<th style="width: 8%;">Center Code</th>
			<th style="width: 15%;">Location</th>
			<th style="width: 12%;">Register Date</th>
			<th>Status</th>
			<th style="width: 6%;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sl = 1;
			foreach($items as $item):
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td><?php echo $item['orgcenter_name']; ?></td>
			<td><?php echo $item['org_name']; ?></td>
			<td><?php echo $item['orgcenter_code']; ?></td>
			<td><?php echo $item['upazila_name'].', '.$item['district_name'].', '.$item['division_name']; ?></td>
			<td><?php echo date("d M, Y", strtotime($item['orgcenter_create_date'])).' '.date("g:i A", strtotime($item['orgcenter_create_date'])); ?></td>
			<td>
				<?php if($item['orgcenter_status'] == '1'): ?>
				<span class="label label-success">Approved</span>
				<?php else: ?>
				<span class="label label-danger">Pending</span>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<a href="<?php echo base_url('centers/edit/'.$item['orgcenter_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a data-item="<?php echo $item['orgcenter_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-trash"></i></a>
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