<table class="table">
	<thead>
		<tr>
			<th>Serial</th>
			<?php if ($this->session->userdata('user_type') === 'Org Admin'): ?>
			<th>Center</th>
			<?php else : ?>
			<th>Organization</th>
			<?php endif; ?>
			<th><p style="margin: 0;">JAN</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">FEB</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">MAR</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">APR</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">MAY</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">JUN</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">JUL</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">AUG</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">SEP</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">OCT</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">NOV</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th><p style="margin: 0;">DEC</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Visit</span></th>
			<th>Total Reg</th>
			<th>Total Visit</th>
			<th>Rate</th>
			<th>Total Taka</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = $sl+1;
			$jan_total_reg   = 0;
			$jan_total_visit = 0;
			$jan_total_regs   = 0;
			$jan_total_visits = 0;
			
			$feb_total_reg   = 0;
			$feb_total_visit = 0;
			$feb_total_regs   = 0;
			$feb_total_visits = 0;
			
			$mar_total_reg   = 0;
			$mar_total_visit = 0;
			$mar_total_regs   = 0;
			$mar_total_visits = 0;
			
			$apr_total_reg   = 0;
			$apr_total_visit = 0;
			$apr_total_regs   = 0;
			$apr_total_visits = 0;
			
			$may_total_reg   = 0;
			$may_total_visit = 0;
			$may_total_regs   = 0;
			$may_total_visits = 0;
			
			$jun_total_reg   = 0;
			$jun_total_visit = 0;
			$jun_total_regs   = 0;
			$jun_total_visits = 0;
			
			$jul_total_reg   = 0;
			$jul_total_visit = 0;
			$jul_total_regs   = 0;
			$jul_total_visits = 0;
			
			$aug_total_reg   = 0;
			$aug_total_visit = 0;
			$aug_total_regs   = 0;
			$aug_total_visits = 0;
			
			$sep_total_reg   = 0;
			$sep_total_visit = 0;
			$sep_total_regs   = 0;
			$sep_total_visits = 0;
			
			$oct_total_reg   = 0;
			$oct_total_visit = 0;
			$oct_total_regs   = 0;
			$oct_total_visits = 0;
			
			$nov_total_reg   = 0;
			$nov_total_visit = 0;
			$nov_total_regs   = 0;
			$nov_total_visits = 0;
			
			$dec_total_reg   = 0;
			$dec_total_visit = 0;
			$dec_total_regs   = 0;
			$dec_total_visits = 0;
			
			$total_regs_count   = 0;
			$total_visits_count = 0;
			
			$total_reg_amounts   = 0;
			$total_visit_amounts = 0;
			$total_takas         = 0;
			$config_reg_rate = $this->Financeapi_model->get_config('reg');
			$config_visit_rate = $this->Financeapi_model->get_config('visit');
			if(is_array($items) && count($items) !== 0):
			
			
			foreach($items as $item):
			if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
				// January
			$jan_date = $year.'-01-';
			$jan_payment = get_month_wise_fees($jan_date, $item['org_id'],'PAID',$keywords);
			
			// February
			$feb_date = $year.'-02-';
			$feb_payment = get_month_wise_fees($feb_date, $item['org_id'],'PAID',$keywords);
			
			// March
			$mar_date = $year.'-03-';
			$mar_payment = get_month_wise_fees($mar_date, $item['org_id'],'PAID',$keywords);
			
			// April
			$apr_date = $year.'-04-';
			$apr_payment = get_month_wise_fees($apr_date, $item['org_id'],'PAID',$keywords);
			
			//May
			$may_date = $year.'-05-';
			$may_payment = get_month_wise_fees($may_date, $item['org_id'],'PAID',$keywords);
			
			//June
			$jun_date = $year.'-06-';
			$jun_payment = get_month_wise_fees($jun_date, $item['org_id'],'PAID',$keywords);
			
			//July
			$jul_date = $year.'-07-';
			$jul_payment = get_month_wise_fees($jul_date, $item['org_id'],'PAID',$keywords);
			
			//August
			$aug_date = $year.'-08-';
			$aug_payment = get_month_wise_fees($aug_date, $item['org_id'],'PAID',$keywords);
			
			//September
			$sep_date = $year.'-09-';
			$sep_payment = get_month_wise_fees($sep_date, $item['org_id'],'PAID',$keywords);
			
			//October
			$oct_date = $year.'-10-';
			$oct_payment = get_month_wise_fees($oct_date, $item['org_id'],'PAID',$keywords);
			
			//November
			$nov_date = $year.'-11-';
			$nov_payment = get_month_wise_fees($nov_date, $item['org_id'],'PAID',$keywords);
			
			//December
			$dec_date = $year.'-12-';
			$dec_payment = get_month_wise_fees($dec_date, $item['org_id'],'PAID',$keywords);
			}else{
			// January
			$jan_date = $year.'-01-';
			$jan_payment = get_month_wise_fees($jan_date, $item['org_id'], 'PAID');

			// February
			$feb_date = $year.'-02-';
			$feb_payment = get_month_wise_fees($feb_date, $item['org_id'], 'PAID');

			// March
			$mar_date = $year.'-03-';
			$mar_payment = get_month_wise_fees($mar_date, $item['org_id'], 'PAID');

			// April
			$apr_date = $year.'-04-';
			$apr_payment = get_month_wise_fees($apr_date, $item['org_id'], 'PAID');

			//May
			$may_date = $year.'-05-';
			$may_payment = get_month_wise_fees($may_date, $item['org_id'], 'PAID');

			//June
			$jun_date = $year.'-06-';
			$jun_payment = get_month_wise_fees($jun_date, $item['org_id'], 'PAID');

			//July
			$jul_date = $year.'-07-';
			$jul_payment = get_month_wise_fees($jul_date, $item['org_id'], 'PAID');

			//August
			$aug_date = $year.'-08-';
			$aug_payment = get_month_wise_fees($aug_date, $item['org_id'], 'PAID');

			//September
			$sep_date = $year.'-09-';
			$sep_payment = get_month_wise_fees($sep_date, $item['org_id'], 'PAID');

			//October
			$oct_date = $year.'-10-';
			$oct_payment = get_month_wise_fees($oct_date, $item['org_id'], 'PAID');

			//November
			$nov_date = $year.'-11-';
			$nov_payment = get_month_wise_fees($nov_date, $item['org_id'], 'PAID');

			//December
			$dec_date = $year.'-12-';
			$dec_payment = get_month_wise_fees($dec_date, $item['org_id'], 'PAID');
			}
			
			$total_reg_amount   =  array(
										$jan_payment['total_reg_fee'],
										$feb_payment['total_reg_fee'],
										$mar_payment['total_reg_fee'],
										$apr_payment['total_reg_fee'],
										$may_payment['total_reg_fee'],
										$jun_payment['total_reg_fee'],
										$jul_payment['total_reg_fee'],
										$aug_payment['total_reg_fee'],
										$sep_payment['total_reg_fee'],
										$oct_payment['total_reg_fee'],
										$nov_payment['total_reg_fee'],
										$dec_payment['total_reg_fee'],
									);
			$total_regs_all   =  array(
										$jan_payment['total_regs'],
										$feb_payment['total_regs'],
										$mar_payment['total_regs'],
										$apr_payment['total_regs'],
										$may_payment['total_regs'],
										$jun_payment['total_regs'],
										$jul_payment['total_regs'],
										$aug_payment['total_regs'],
										$sep_payment['total_regs'],
										$oct_payment['total_regs'],
										$nov_payment['total_regs'],
										$dec_payment['total_regs'],
									);
			$total_visit_amount = array(
										$jan_payment['total_visit_fee'],
										$feb_payment['total_visit_fee'],
										$mar_payment['total_visit_fee'],
										$apr_payment['total_visit_fee'],
										$may_payment['total_visit_fee'],
										$jun_payment['total_visit_fee'],
										$jul_payment['total_visit_fee'],
										$aug_payment['total_visit_fee'],
										$sep_payment['total_visit_fee'],
										$oct_payment['total_visit_fee'],
										$nov_payment['total_visit_fee'],
										$dec_payment['total_visit_fee'],
									);
			$total_visits_all = array(
										$jan_payment['total_visits'],
										$feb_payment['total_visits'],
										$mar_payment['total_visits'],
										$apr_payment['total_visits'],
										$may_payment['total_visits'],
										$jun_payment['total_visits'],
										$jul_payment['total_visits'],
										$aug_payment['total_visits'],
										$sep_payment['total_visits'],
										$oct_payment['total_visits'],
										$nov_payment['total_visits'],
										$dec_payment['total_visits'],
									);
			$total_taka = array_sum($total_reg_amount) + array_sum($total_visit_amount);

			$jan_total_reg   += $jan_payment['total_reg_fee'];
			$jan_total_visit += $jan_payment['total_visit_fee'];
			$jan_total_regs   += $jan_payment['total_regs'];
			$jan_total_visits += $jan_payment['total_visits'];
			
			$feb_total_reg   += $feb_payment['total_reg_fee'];
			$feb_total_visit += $feb_payment['total_visit_fee'];
			$feb_total_regs   += $feb_payment['total_regs'];
			$feb_total_visits += $feb_payment['total_visits'];
			
			$mar_total_reg   += $mar_payment['total_reg_fee'];
			$mar_total_visit += $mar_payment['total_visit_fee'];
			$mar_total_regs   += $mar_payment['total_regs'];
			$mar_total_visits += $mar_payment['total_visits'];
			
			$apr_total_reg   += $apr_payment['total_reg_fee'];
			$apr_total_visit += $apr_payment['total_visit_fee'];
			$apr_total_regs   += $apr_payment['total_regs'];
			$apr_total_visits += $apr_payment['total_visits'];
			
			$may_total_reg   += $may_payment['total_reg_fee'];
			$may_total_visit += $may_payment['total_visit_fee'];
			$may_total_regs   += $may_payment['total_regs'];
			$may_total_visits += $may_payment['total_visits'];
			
			$jun_total_reg   += $jun_payment['total_reg_fee'];
			$jun_total_visit += $jun_payment['total_visit_fee'];
			$jun_total_regs   += $jun_payment['total_regs'];
			$jun_total_visits += $jun_payment['total_visits'];
			
			$jul_total_reg   += $jul_payment['total_reg_fee'];
			$jul_total_visit += $jul_payment['total_visit_fee'];
			$jul_total_regs   += $jul_payment['total_regs'];
			$jul_total_visits += $jul_payment['total_visits'];
			
			$aug_total_reg   += $aug_payment['total_reg_fee'];
			$aug_total_visit += $aug_payment['total_visit_fee'];
			$aug_total_regs   += $aug_payment['total_regs'];
			$aug_total_visits += $aug_payment['total_visits'];
			
			$sep_total_reg   += $sep_payment['total_reg_fee'];
			$sep_total_visit += $sep_payment['total_visit_fee'];
			$sep_total_regs   += $sep_payment['total_regs'];
			$sep_total_visits += $sep_payment['total_visits'];
			
			$oct_total_reg   += $oct_payment['total_reg_fee'];
			$oct_total_visit += $oct_payment['total_visit_fee'];
			$oct_total_regs   += $oct_payment['total_regs'];
			$oct_total_visits += $oct_payment['total_visits'];
			
			$nov_total_reg   += $nov_payment['total_reg_fee'];
			$nov_total_visit += $nov_payment['total_visit_fee'];
			$nov_total_regs   += $nov_payment['total_regs'];
			$nov_total_visits += $nov_payment['total_visits'];
			
			$dec_total_reg   += $dec_payment['total_reg_fee'];
			$dec_total_visit += $dec_payment['total_visit_fee'];
			$dec_total_regs   += $dec_payment['total_regs'];
			$dec_total_visits += $dec_payment['total_visits'];
			
			$total_reg_amounts   += array_sum($total_reg_amount);
			$total_visit_amounts += array_sum($total_visit_amount);
			$total_takas         += $total_taka;
			
			$total_regs_count   += array_sum($total_regs_all);
			$total_visits_count += array_sum($total_visits_all);
			
			$rate_visit = $config_visit_rate['config_option_two'];
			$rate_reg = $config_reg_rate['config_option'];
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td><?php echo $item['org_name']; ?></td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $jan_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $jan_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $feb_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $feb_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $mar_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $mar_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $apr_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $apr_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $may_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $may_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $jun_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $jun_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $jul_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $jul_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $aug_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $aug_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $sep_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $sep_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $oct_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $oct_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $nov_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $nov_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $dec_payment['total_regs']; ?></td>
						<td class="text-center"><?php echo $dec_payment['total_visits']; ?></td>
					</tr>
				</table>
			</td>
			<td class="text-center"><?php echo array_sum($total_regs_all); ?></td>
			<td class="text-center"><?php echo array_sum($total_visits_all); ?></td>
			<td class="text-center"><?php echo '(R-'.$rate_reg.') | '.'(V-'.$rate_visit.')'; ?></td>
			<td class="text-center"><?php echo $total_taka; ?></td>
		</tr>
		<?php 
			$sl++;
			endforeach; 
		?>
		<tr>
			<td class="text-right" colspan="2"><strong>Total</strong></td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $jan_total_regs; ?></td>
						<td class="text-center"><?php echo $jan_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $feb_total_regs; ?></td>
						<td class="text-center"><?php echo $feb_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $mar_total_regs; ?></td>
						<td class="text-center"><?php echo $mar_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $apr_total_regs; ?></td>
						<td class="text-center"><?php echo $apr_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $may_total_regs; ?></td>
						<td class="text-center"><?php echo $may_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $jun_total_regs; ?></td>
						<td class="text-center"><?php echo $jun_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $jul_total_regs; ?></td>
						<td class="text-center"><?php echo $jul_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $aug_total_regs; ?></td>
						<td class="text-center"><?php echo $aug_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $sep_total_regs; ?></td>
						<td class="text-center"><?php echo $sep_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $oct_total_regs; ?></td>
						<td class="text-center"><?php echo $oct_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $nov_total_regs; ?></td>
						<td class="text-center"><?php echo $nov_total_visits; ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table style="width:100%">
					<tr>
						<td class="text-center"><?php echo $dec_total_regs; ?></td>
						<td class="text-center"><?php echo $dec_total_visits; ?></td>
					</tr>
				</table>
			</td>
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
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>

<br />
<br />
<div class="share-calcuation-panel">
	<?php
		$the_year = $year.'-';
		if(isset($keywords) && $this->session->userdata('user_type') === 'Org Admin') {
			$allocation_total_amount = get_year_wise_total_amount($the_year, $keywords,'PAID','Org Admin');
		}else{
		$allocation_total_amount = get_year_wise_total_amount($the_year, $keywords, 'PAID');
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
	<span class="click-to-download" onclick="window.location.href='<?php echo base_url('financeapi/download?RPTYPE=PAID&keywords='.$keywords.'&year='.$year.'&month='.$month); ?>'">Download</span>
</div>