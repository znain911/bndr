<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<th>Visits</th>
			<th>BNDR ID</th>
			<th class = 'laptop'>Gender</th>
			<th>Name</th>
			<th class = 'laptop'>Phone</th>
			<th class = 'laptop'>Age</th>
			<th>Most Recent Visit Date</th>
			<th>Guidebook</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = 1;
			if(count($items) !== 0):
			foreach($items as $item):
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td class="text-center">
				<a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:20px;background:#f00;padding:8px 8px;"><i class="fa fa-plus-square"></i></a>
			</td>
			<td><?php echo $item['patient_entryid']; ?></td>
			<td class = 'laptop'><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
			<td><?php echo $item['patient_name']; ?></td>
			<td class = 'laptop'><?php echo $item['patient_phone']; ?></td>
			<td class = 'laptop'><?php echo $item['patient_age']; ?></td>
			<td><?php 
			$visit_date = $this->Dashboard_model->get_latest_visit_date($item['patient_id']);
			if($visit_date):
			if($visit_date['visit_admit_date']):
			echo date("d M, Y", strtotime($visit_date['visit_admit_date'])); 
			endif; 
			endif; 
			?>
			
			</td>
			<td class=" "><?php echo $item['patient_guide_book']; ?></td>
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