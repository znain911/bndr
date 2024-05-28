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
						<li class="">
							<a href="<?php echo base_url('finance/shw/unpaids'); ?>">
								<strong>All</strong>
								Unpaid Payments
							</a>
						</li>
						<li class="active">
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
								<div class="date-to-date-search">
									<div class="row">
										<div class="col-lg-9"></div>
									</div>
								</div>
								
								<div class="search-input-bx" style="width: 60px;">
									<span style="width: 60px;text-transform: uppercase;display: inline-block;background: #1B75BC;color: #FFF;border-radius: 2px;text-align: center;font-size: 12px;padding: 3px 0;margin-top: 5px;cursor:pointer;" onclick="searchFilter()">Search</span>
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
											<th>Today Reg</th>
											<th>Today Follow Up</th>
											<th>Rate</th>
											<th>Total Taka</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$sl = 1;
											if(is_array($items) && count($items) !== 0):
											$total_reg_amount = 0;
											$total_visit_amount = 0;
											$total_payment_amount = 0;
											
											$total_regs_today = 0;
											$total_visits_today = 0;
											
											$config_reg_rate = $this->Finance_model->get_config('reg');
											$config_visit_rate = $this->Finance_model->get_config('visit');
											foreach($items as $item):
											$total_reg_fees_today = $this->Finance_model->get_total_reg_fees_today_by_org($item['org_id']);
											$total_visit_fees_today = $this->Finance_model->get_total_visit_fees_today_by_org($item['org_id']);
											
											$total_regs = $this->Finance_model->get_total_regs_today($item['org_id']);
											$total_visits = $this->Finance_model->get_total_visits_today($item['org_id']);
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
										$total_reg_amount_today = $this->Finance_model->get_total_reg_amount_today();
										$total_visit_amount_today = $this->Finance_model->get_total_visit_amount_today();
										$total_amount_today = $total_reg_amount_today + $total_visit_amount_today;
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
														$total_amount_service_org = (($total_amount_today)/100 * 50);
														echo number_format(floatval($total_amount_service_org), 2, '.', ','); 
													?>
												</td>
											</tr>
											<tr>
												<td>BNDR</td>
												<td>40.00%</td>
												<td>
													<?php 
														$total_amount_bndr = (($total_amount_today)/100 * 40);
														echo number_format(floatval($total_amount_bndr), 2, '.', ','); 
													?>
												</td>
											</tr>
											<tr>
												<td>CGHR</td>
												<td>10.00%</td>
												<td>
													<?php 
														$total_amount_cghr = (($total_amount_today)/100 * 10);
														echo number_format(floatval($total_amount_cghr), 2, '.', ','); 
													?>
												</td>
											</tr>
											<tr>
												<td>TOTAL</td>
												<td>100%</td>
												<td><?php echo number_format(floatval($total_amount_today), 2, '.', ','); ?></td>
											</tr>
										</tbody>
									</table>
									<span class="click-to-download" onclick="window.location.href='<?php echo base_url('finance/download?RPTYPE=TODAY'); ?>'">Download</span>
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
			$('#loader').show();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>financeapi/get_todays_payments/'+page_num,
				data:'page='+page_num+'&keywords='+keywords,
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