<table class="table table-striped">
	<thead>
		<tr>
			<th style="width:5%;">SL.</th>
			<th style="width:25%;">Company</th>
			<th>Brand</th>
			<th style="width: 15%;">Generic</th>
			<th style="width: 15%;">Strength</th>
			<th>Dosages</th>
			<th>DAR</th>
			<th style="width: 4%;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$x = $sl+1;
			foreach($items as $item):
		?>
		<tr>
			<td><?php echo $x; ?></td>
			
			<td><?php echo $item['company_name']; ?></td>
			<td><?php echo $item['brand']; ?></td>
			<td><?php echo $item['generic']; ?></td>
			<td><?php echo $item['strength']; ?></td>
			<td><?php echo $item['dosages']; ?></td>
			<td><?php echo $item['DAR']; ?></td>
			
			<td class="jsgrid">
				<button onclick="window.location.href='<?php echo base_url('setup/drugs/edit/'.$item['id']); ?>'" class="jsgrid-button jsgrid-edit-button" type="button" title="Edit"></button>
				<button data-item="<?php echo $item['id']; ?>" class="remove-btn jsgrid-button jsgrid-delete-button" type="button" title="Delete"></button>
			</td>
		</tr>
		<?php 
			$x++;
			endforeach; 
		?>
	</tbody>
</table>
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>