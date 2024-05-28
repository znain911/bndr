<table class="table" border="1">
	<thead>
		<tr>
			<th>Serial</th>
			<?php if ($this->session->userdata('user_type') === 'Org Admin'): ?>
			<th>Center</th>
			<?php else : ?>
			<th>Organization</th>
			<?php endif; ?>
			<th>Today Reg</th>
			<th>Today Visit</th>
			<th>Rate</th>
			<th>Total Taka</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = 1;
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