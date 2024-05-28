<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th>BNDR ID</th>
			<th>Name</th>
			<th class="laptop ">Gender</th>
			<th class="laptop ">Guidebook</th>
			<th class="laptop ">Visit No</th>
			<!--<th>Visit Type</th>-->
			<th class="laptop ">Visit Date</th>
			<th class="laptop ">Phone</th>
			<th class="laptop ">Age</th>
			<!--<th>Visit Center</th>
			<th>Visit Created</th>
			<th>Payment Status</th>-->
			<th class="laptop ">Action</th>
			<th>Visits</th>
			<th class="laptop ">Print QR Code</th>
			<th class="mobile ">QR</th>
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
			<td class="laptop "><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
			<td class="laptop "><?php echo $item['patient_guide_book']; ?></td>
			<td class="text-center laptop"><?php echo 'Visit '.$item['visit_number']; ?></td>
			<!--<td class="text-center"><?php echo $item['visit_type']; ?></td>-->
			<td class="text-center laptop"><?php echo date("d M, Y", strtotime($item['visit_admit_date'])); ?></td>
			<td class="laptop "><?php echo $item['patient_phone']; ?></td>
			<td class="laptop "><?php echo $item['patient_age']; ?></td>
			<!--<td class="text-center"><?php echo $item['orgcenter_name']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_admit_date'])).' '.date("g:i A", strtotime($item['visit_admit_date'])); ?></td>-->
			<!--<td class="text-center">
				<?php //if($item['payment_patient_status'] === '1'): ?>
					<strong style="color:#0A0">Paid</strong>
				<?php// else: ?>
					<strong style="color:#F00">Unpaid</strong>
				<?php //endif; ?>
			</td>-->
			<td class="text-center laptop">
				<a href="<?php echo base_url('patients/visit/edit/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a data-item="<?php echo $item['visit_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;margin-right:5px;"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
				<a href="<?php echo base_url('patients/visit/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
			</td>
			<td><a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a></td>
			<td class="text-center">
				<!--<a target="_blank" href="<?php echo base_url('patients/visit/moneyreceipt/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>-->
				<h6 class = "qr-print" href="" style="color: #FFF;font-size:14px;background:#1B75BC;padding:4px 6px;display: inline;"><i class="fa fa-print"></i></h6>
				<input type="hidden" id = "entry" value="<?php echo $item['patient_entryid'];?>" name="" />
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
				  document.location.href = baseUrl+'administrator/dashboard/shw/ppaids';
			 
			});
		 
		});
	</script>