<table class="table">
	<thead>
		<tr>
			<th>Serial</th>
			<th>Organization</th>
			<th>Today Reg</th>
			<th>Today Visit</th>
			<th>Rate</th>
			<th>Total Taka</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = $sl+1;
			$total_reg_amount = 0;
			$total_visit_amount = 0;
			$total_payment_amount = 0;
			
			$total_regs_today = 0;
			$total_visits_today = 0;
			
			$config_reg_rate = $this->Financeapi_model->get_config('reg');
			$config_visit_rate = $this->Financeapi_model->get_config('visit');
			if(is_array($items) && count($items) !== 0):
			
			foreach($items as $item):
			if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
				$total_reg_fees_today = $this->Financeapi_model->get_total_reg_fees_today_by_org($item['org_id'],$keywords);
				$total_visit_fees_today = $this->Financeapi_model->get_total_visit_fees_today_by_org($item['org_id'],$keywords);
				$total_regs = $this->Financeapi_model->get_total_regs_today($item['org_id'], $keywords);
				$total_visits = $this->Financeapi_model->get_total_visits_today($item['org_id'], $keywords);
			}else{
			$total_reg_fees_today = $this->Financeapi_model->get_total_reg_fees_today_by_org($item['org_id']);
			$total_visit_fees_today = $this->Financeapi_model->get_total_visit_fees_today_by_org($item['org_id']);
			$total_regs = $this->Financeapi_model->get_total_regs_today($item['org_id']);
			$total_visits = $this->Financeapi_model->get_total_visits_today($item['org_id']);
			}
			
			$total_regs_today += $total_regs;
			$total_visits_today += $total_visits;
			
			$rate_visit = $config_visit_rate['config_option_two'];
			$rate_reg = $config_reg_rate['config_option'];
			$total_amount = $total_reg_fees_today + $total_visit_fees_today;
			
			$total_reg_amount += $total_reg_fees_today;
			$total_visit_amount += $total_visit_fees_today;
			$total_payment_amount += $total_amount;
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td><?php echo $item['org_name']; ?></td>
			<td class="text-center"><?php echo $total_regs; ?></td>
			<td class="text-center"><?php echo $total_visits; ?></td>
			<td class="text-center"><?php echo '(R-'.$rate_reg.') | '.'(V-'.$rate_visit.')'; ?></td>
			<td class="text-center"><?php echo $total_amount; ?></td>
		</tr>
		<?php 
			$sl++;
			endforeach;
		?>
		<tr>
			<td class="text-right" colspan="2"><strong>Total</strong></td>
			<td class="text-center"><?php echo $total_regs_today; ?></td>
			<td class="text-center"><?php echo $total_visits_today; ?></td>
			<td></td>
			<td class="text-center"><?php echo $total_payment_amount; ?></td>
		</tr>
		<?php else: ?>
		<tr><td colspan="6" class="text-center">No payments data.</td></tr>
		<?php endif; ?>
	</tbody>
</table>
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>

<br />
<br />
<div class="share-calcuation-panel">
	<?php
		$the_year = date("Y-m-d");
		if(isset($keywords) && $this->session->userdata('user_type') === 'Org Admin') {
			$allocation_total_amount = get_year_wise_total_amount($the_year, $keywords,null,'Org Admin');
		}else{
		$allocation_total_amount = get_year_wise_total_amount($the_year, $keywords);
		}
	?>

	<table border="0" style="width: 360px;">
		<thead>
			<tr>
				<td><strong>Allocation</strong></td>
				<td><strong>Share</strong></td>
				<td><strong>Amount</strong></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Service Organization</td>
				<td>50.00%</td>
				<td>
					<?php 
						$total_amount_service_org = (($allocation_total_amount)/100 * 50);
						echo number_format(floatval($total_amount_service_org), 2, '.', ','); 
					?>
				</td>
			</tr>
			<tr>
				<td>BNDR</td>
				<td>40.00%</td>
				<td>
					<?php 
						$total_amount_bndr = (($allocation_total_amount)/100 * 40);
						echo number_format(floatval($total_amount_bndr), 2, '.', ','); 
					?>
				</td>
			</tr>
			<tr>
				<td>CGHR</td>
				<td>10.00%</td>
				<td>
					<?php 
						$total_amount_cghr = (($allocation_total_amount)/100 * 10);
						echo number_format(floatval($total_amount_cghr), 2, '.', ','); 
					?>
				</td>
			</tr>
			<tr>
				<td>TOTAL</td>
				<td>100%</td>
				<td><?php echo number_format(floatval($allocation_total_amount), 2, '.', ','); ?></td>
			</tr>
		</tbody>
	</table>
	<span class="click-to-download" onclick="window.location.href='<?php echo base_url('financeapi/download?RPTYPE=TODAY&keywords='.$keywords); ?>'">Download</span>
</div>