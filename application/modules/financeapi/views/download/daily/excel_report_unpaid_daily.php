<table class="table" border="1">
	<?php $days = cal_days_in_month(CAL_GREGORIAN,$month,$year); ?>
	<thead>
		<tr>
			<th>Serial</th>
			<?php if ($this->session->userdata('user_type') === 'Org Admin'): ?>
			<th>Center/Organization</th>
			<?php else : ?>
			<th>Organization</th>
			<?php endif; ?>
			<?php for($d=1; $d<$days+1; $d++): ?>
				<?php if($d < 10): ?>
					<th><p style="margin: 0;"><?php echo '0'.$d.' '.date("M", strtotime(date("Y-m-d", strtotime($year.'-'.$month.'-'.$d)))); ?></p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
				<?php else: ?>
					<th><p style="margin: 0;"><?php echo $d.' '.date("M", strtotime(date("Y-m-d", strtotime($year.'-'.$month.'-'.$d)))); ?></p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
				<?php endif; ?>
			<?php endfor; ?>
			<th>Total Reg</th>
			<th>Total Visit</th>
			<th>Rate</th>
			<th>Total Taka</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = 1;
			$total_regs_count   = 0;
			$total_visits_count = 0;
			
			$total_reg_amounts   = 0;
			$total_visit_amounts = 0;
			$total_takas         = 0;
			
			$days_total_regs = array();
			$days_total_visits = array();
			
			$config_reg_rate = $this->Financeapi_model->get_config('reg');
			$config_visit_rate = $this->Financeapi_model->get_config('visit');
			if(is_array($items) && count($items) !== 0):
			
			foreach($items as $item):
			
			$rate_visit = $config_visit_rate['config_option_two'];
			$rate_reg = $config_reg_rate['config_option'];
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td><?php echo $item['org_name']; ?></td>
			<?php
				$set_total_reg_fee   = 0;
				$set_total_visit_fee = 0;
				$set_total_regs      = 0;
				$set_total_visits    = 0;
				$set_total_amount    = 0;
				for($d=1; $d<$days+1; $d++): 
				
				// Day wise payment details
				if($d < 10){
					$the_date             = $year.'-'.$month.'-0'.$d;
				}else{
					$the_date             = $year.'-'.$month.'-'.$d;
				}
				if(isset($keywords) && $this->session->userdata('user_type') === 'Org Admin') {
					 $payment_details      = get_month_wise_fees($the_date, $item['org_id'],'UNPAID',$keywords);
				 }else{
				$payment_details      = get_month_wise_fees($the_date, $item['org_id'], 'UNPAID');
				 }
				$set_total_reg_fee   += $payment_details['total_reg_fee'];
				$set_total_visit_fee += $payment_details['total_visit_fee'];
				$set_total_regs      += $payment_details['total_regs'];
				$set_total_visits    += $payment_details['total_visits'];
				$set_total_amount    += $payment_details['total_amount'];
				
				$days_total_regs[$d][] = $payment_details['total_regs'];
				$days_total_visits[$d][] = $payment_details['total_visits'];
			?>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $payment_details['total_regs']; ?></td>
						<td class="text-center"><?php echo $payment_details['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<?php endfor; ?>
			<td class="text-center"><?php echo $set_total_regs; ?></td>
			<td class="text-center"><?php echo $set_total_visits; ?></td>
			<td class="text-center"><?php echo '(R-'.$rate_reg.') | '.'(V-'.$rate_visit.')'; ?></td>
			<td class="text-center"><?php echo $set_total_amount; ?></td>
			
			<?php 
				$total_regs_count   += $set_total_regs;
				$total_visits_count += $set_total_visits;
				$total_takas         += $set_total_amount;
			?>
		</tr>
		<?php 
			$sl++;
			endforeach; 
		?>
		<tr>
			<td class="text-right" colspan="2"><strong>Total</strong></td>
			<?php 
				for($d=1; $d<$days+1; $d++): 
				$day_wise_total_reg   = array_sum($days_total_regs[$d]); 
				$day_wise_total_visit = array_sum($days_total_visits[$d]);
			?>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $day_wise_total_reg; ?></td>
						<td class="text-center"><?php echo $day_wise_total_visit; ?></td>
					</tr>
				</table>
			</td>
			<?php endfor; ?>
			<td class="text-center"><?php echo $total_regs_count; ?></td>
			<td class="text-center"><?php echo $total_visits_count; ?></td>
			<td></td>
			<td class="text-center"><?php echo $total_takas; ?></td>
		</tr>
		<?php else: ?>
		<tr><td colspan="18" class="text-center">No new patients.</td></tr>
		<?php endif; ?>
	</tbody>
</table>