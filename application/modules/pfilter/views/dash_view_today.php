<table class="table ">
	<thead>
		<tr>
			<th>SL.</th>
			<th>ID</th>
			<th>Name</th>
			<th class="laptop ">Gender</th>
			<th class="laptop ">Guidebook</th>
			<!--<th>ORG.</th>
			<th>ORG. Center</th>
			<th>Blood Group</th>-->
			<th class="laptop ">Phone</th>
			<th class="laptop ">Age</th>
			<!--<th>Date Of Birth</th>
			<th>Register Date</th>-->
			
			<th>Visits</th>
			<th class="laptop ">Print QR Code</th>
			<th class="mobile ">QR</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = $sl+1;
			if(count($items) !== 0):
			foreach($items as $item):
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td><?php echo $item['patient_entryid']; ?></td>
			<td><?php echo $item['patient_name']; ?></td>
			<td class="laptop "><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
			<td class="laptop "><?php echo $item['patient_guide_book']; ?></td>
			<!--<td><?php echo $item['org_name']; ?></td>
			<td><?php echo $item['orgcenter_name']; ?></td>
			<td><?php echo $item['patient_blood_group']; ?></td>-->
			<td class="laptop "><?php echo $item['patient_phone']; ?></td>
			<td class="laptop "><?php echo $item['patient_age']; ?></td>
			<!--<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
			<?php if($item['patient_form_version'] == 'V1'): ?>
			<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
			<?php else: ?>
			<td>
			<?php echo date("d M, Y", strtotime($item['patient_registration_date'])); ?>
			</td>
			<td><?php 
			if($item['patient_create_date']):
			echo date("d M, Y", strtotime($item['patient_create_date'])); 
			endif; 
			?>
			
			</td>
			<?php endif; ?>-->
			<!--<td class="text-center">
				<a href="<?php echo base_url('patients/edit/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a data-item="<?php echo $item['patient_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
			</td>-->
			<td class="text-center">
				<a href="<?php echo base_url('patients/visit/all/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
			</td>
			<td>
				<h6 class = "qr-print" href="" style="color: #FFF;font-size:14px;background:#1B75BC;padding:4px 6px;display: inline;"><i class="fa fa-print"></i></h6>
				<input type="hidden" id = "entry" value="<?php echo $item['patient_entryid'];?>" name="" />
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
<script >
		$(function(){
			$(".qr-print").click(function(){
			var bndrId =	$(this).next().val();
			 //alert(bndrId);
			 var width = 160;
				var height = 160;
				var divToPrint=document.getElementById('printqr');

				  //var newWin=window.open('','Print-Window');

				  //newWin.document.open();

				  document.write('<html><body class="loadQr" onload="window.print()"></body></html>');
				  $('.loadQr').qrcode({width: width,height: height,text: bndrId});

				  document.close();

				  setTimeout(function(){close();},10);
				  document.location.href = baseUrl+'administrator/dashboard';
			 
			});
		 
		});
	</script>