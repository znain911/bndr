<?php require_once APPPATH.'modules/common/header.php' ?>
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Dashboard</h4>
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="index.html">Dashboard</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- ============================================================== -->
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default block2">
				<div class="panel-heading text-center put-relative" style="padding: 25px 0px;">
					<ul class="patient-tab-ul">
						<li class="">
							<a href="<?php echo base_url('finance/shw/all'); ?>">
								<strong>All</strong>
								Payments
							</a>
						</li>
						<li class="">
							<a href="<?php echo base_url('finance/shw/paids'); ?>">
								<strong>All</strong>
								Paid Payments
							</a>
						</li>
						<li class="active">
							<a href="<?php echo base_url('finance/shw/unpaids'); ?>">
								<strong>All</strong>
								Unpaid Payments
							</a>
						</li>
						<li class="">
							<a href="<?php echo base_url('finance/shw/todays'); ?>">
								<strong>Todays</strong>
								Payments
							</a>
						</li>
					</ul>
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div id="loader" class="disable-select bndr-table-loader"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
					<div class="panel-body">
						<div class="table-responsive">
							<div class="top-search-filter-section">
								<?php 
									$attr = array('class' => 'form-horizontal form-material', 'id' => 'filterByDate');
									echo form_open('', $attr);
								?>
								<div class="search-input-bx" style="width: 60px;">
									<span style="width: 60px;text-transform: uppercase;display: inline-block;background: #1B75BC;color: #FFF;border-radius: 2px;text-align: center;font-size: 12px;padding: 3px 0;margin-top: 5px;cursor:pointer;" onclick="searchFilter()">Search</span>
								</div>
								<div class="search-input-bx" style="width: 220px;">
									<div class="col-lg-6"><strong class="filter-label">Year </strong></div>
									<div class="col-lg-6">
										<select id="year" class="form-control inline-src-right">
											<?php 
												$starting_year = 2018;
												for($x=$starting_year; $x < $starting_year + 10; $x++):
											?>
											<option value="<?php echo $x; ?>" <?php echo (date("Y") == $x)? 'selected' : null; ?>><?php echo $x; ?></option>
											<?php endfor; ?>
										</select>
									</div>
								</div>
								<div class="search-input-bx" style="width: 220px;">
									<div class="col-lg-6 text-right"><strong class="filter-label">Month </strong></div>
									<div class="col-lg-6">
										<select id="month" class="form-control inline-src-right">
											<option value="All" selected="selected">All</option>
											<?php 
												$months = array(
															'01' => 'January',
															'02' => 'February',
															'03' => 'March',
															'04' => 'April',
															'05' => 'May',
															'06' => 'June',
															'07' => 'July',
															'08' => 'August',
															'09' => 'September',
															'10' => 'October',
															'11' => 'November',
															'12' => 'December',
														);
												foreach($months as $key => $month):
											?>
												<option value="<?php echo $key; ?>"><?php echo $month; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								
								<div class="search-input-bx">
									<div class="col-lg-3"><strong class="filter-label">Search </strong></div>
									<div class="col-lg-9">
										<?php if($this->session->userdata('user_type') === 'Org Admin') : ?> 
										<input type="text" class="form-control inline-src-right src-organization" id="keywords" placeholder="Search by center name" />
									<?php else : ?>
										<input type="text" class="form-control inline-src-right src-organization" id="keywords" placeholder="Search here..." />
									<?php endif; ?>
									</div>
								</div>
								
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<div id="postList">
								<table class="table">
									<thead>
										<tr>
											<th>Serial</th>
											<th>Organization</th>
											<th><p style="margin: 0;">JAN</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">FEB</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">MAR</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">APR</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">MAY</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">JUN</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">JUL</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">AUG</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">SEP</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">OCT</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">NOV</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th><p style="margin: 0;">DEC</p><span>Reg</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Follow Up</span></th>
											<th>Total Reg</th>
											<th>Total Follow Up</th>
											<th>Rate</th>
											<th>Total Taka</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$sl = 1;
											if(is_array($items) && count($items) !== 0):
											
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
											$config_reg_rate = $this->Finance_model->get_config('reg');
											$config_visit_rate = $this->Finance_model->get_config('visit');
											foreach($items as $item):
											// January
											$jan_date = date("Y").'-01-';
											$jan_payment = get_month_wise_fees($jan_date, $item['org_id'], 'UNPAID');

											// February
											$feb_date = date("Y").'-02-';
											$feb_payment = get_month_wise_fees($feb_date, $item['org_id'], 'UNPAID');

											// March
											$mar_date = date("Y").'-03-';
											$mar_payment = get_month_wise_fees($mar_date, $item['org_id'], 'UNPAID');

											// April
											$apr_date = date("Y").'-04-';
											$apr_payment = get_month_wise_fees($apr_date, $item['org_id'], 'UNPAID');

											//May
											$may_date = date("Y").'-05-';
											$may_payment = get_month_wise_fees($may_date, $item['org_id'], 'UNPAID');

											//June
											$jun_date = date("Y").'-06-';
											$jun_payment = get_month_wise_fees($jun_date, $item['org_id'], 'UNPAID');

											//July
											$jul_date = date("Y").'-07-';
											$jul_payment = get_month_wise_fees($jul_date, $item['org_id'], 'UNPAID');

											//August
											$aug_date = date("Y").'-08-';
											$aug_payment = get_month_wise_fees($aug_date, $item['org_id'], 'UNPAID');

											//September
											$sep_date = date("Y").'-09-';
											$sep_payment = get_month_wise_fees($sep_date, $item['org_id'], 'UNPAID');

											//October
											$oct_date = date("Y").'-10-';
											$oct_payment = get_month_wise_fees($oct_date, $item['org_id'], 'UNPAID');

											//November
											$nov_date = date("Y").'-11-';
											$nov_payment = get_month_wise_fees($nov_date, $item['org_id'], 'UNPAID');

											//December
											$dec_date = date("Y").'-12-';
											$dec_payment = get_month_wise_fees($dec_date, $item['org_id'], 'UNPAID');
											
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
										$allocation_total_reg_amount = $this->Finance_model->get_total_reg_amount('UNPAID');
										$allocation_total_visit_amount = $this->Finance_model->get_total_visit_amount('UNPAID');
										$allocation_total_amount = $allocation_total_reg_amount + $allocation_total_visit_amount;
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
									<span class="click-to-download" onclick="window.location.href='<?php echo base_url('finance/download?RPTYPE=UNPAID'); ?>'">Download</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var year = $('#year').val();
			var month = $('#month').val();
			$('#loader').show();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>financeapi/get_all_unpaids/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&month='+month+'&year='+year,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
						$('#loader').hide();
						$('html, body').animate({
							scrollTop: $("body").offset().top
						 }, 1000);
					}else
					{
						return false;
					}
				}
			});
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			//load visit center
			$('.src-organization').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "finance/get_org_by_keywords",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  select: function (event, ui) {
						$(this).val(ui.item.label); // display the selected text
						searchFilter();
						//$("#hiddenVisitCenterId").val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>