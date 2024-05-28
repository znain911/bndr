<table class="table" border="1">
	<thead>
		<tr>
			<th style="text-align:center;background:yellow;">BNDR ID</th>
			<th style="text-align:center;background:yellow;">Patient Guide Book No.</th>
			<th style="text-align:center;background:yellow;">Patient Center ID</th>
			<th style="text-align:center;background:yellow;">Patient Name</th>
			<th style="text-align:center;background:yellow;">Gender</th>
			<th style="text-align:center;background:yellow;">Phone Number</th>
			<th style="text-align:center;background:yellow;">Blood Group</th>
			<th style="text-align:center;background:yellow;">Address</th>
			<th style="text-align:center;background:yellow;">Patient Create Date</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($items) !== 0): ?>
		<?php 
			$gender_array = array('0' => 'Male', '1' => 'Female', '2' => 'Other');
			foreach($items as $item):
		?>
		<tr>
			<td style="text-align:center"><?php echo $item['patient_entryid']; ?></td>
			<td style="text-align:center"><?php echo $item['patient_guide_book']; ?></td>
			<td style="text-align:center"><?php echo $item['patient_idby_center']; ?></td>
			<td style="text-align:center"><?php echo $item['patient_name']; ?></td>
			<td style="text-align:center"><?php echo $gender_array[$item['patient_gender']]; ?></td>
			<td style="text-align:center"><?php echo $item['patient_phone']; ?></td>
			<td style="text-align:center"><?php echo $item['patient_blood_group']; ?></td>
			<td style="text-align:center"><?php echo $item['patient_address']; ?></td>
			<td style="text-align:center"><?php echo $item['patient_create_date']; ?></td>
		</tr>
		<?php 
			endforeach; 
		?>
		<?php else: ?>
		<tr><td colspan="151" style="text-align:center">No Data Found.</td></tr>
		<?php endif; ?>
	</tbody>
</table>