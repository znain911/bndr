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
							<a href="<?php echo base_url('administrator/dashboard/shw/todays'); ?>">
								<strong>Todays</strong>
								Patients
							</a>
						</li>
						<?php if($this->session->userdata('user_type') !== 'Operator'): ?>
						<li class="">
							<a href="<?php echo base_url('administrator/dashboard/shw/all'); ?>">
								<strong>Total Registered</strong>
								Patients
							</a>
						</li>
						<?php endif; ?>
						<!--<li class="">
							<a href="<?php echo base_url('administrator/dashboard/shw/rppendings'); ?>">
								<strong>Registration Payment</strong>
								Pendings
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('administrator/dashboard/shw/rppaids'); ?>">
								<strong>Registration Payment</strong>
								Completed
							</a>
						</li>
						<li class="active">
							<a href="<?php echo base_url('administrator/dashboard/shw/ppendings'); ?>">
								<strong>Visit Payment</strong>
								Pendings
							</a>
						</li>-->
						<li>
							<a href="<?php echo base_url('administrator/dashboard/shw/ppaids'); ?>">
								<strong>Total Visit</strong>
								Completed
							</a>
						</li>
					</ul>
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive put-relative">
							<div><span style="display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;"><strong>Total :</strong> <span id="totalPatients"><?php echo $total_items; ?></span></span></div>
							<div class="top-search-filter-section">
								<?php 
									$attr = array('class' => 'form-horizontal form-material', 'id' => 'filterByDate');
									echo form_open('', $attr);
								?>
								<div class="date-to-date-search" style="width:355px">
									<div class="row">
										<div style="width:100%;padding: 0 15px;">
											<strong class="inline-date-src to_label">From</strong>
											<input style="width:115px;text-align:center;" type="text" placeholder="yyyy-mm-dd" class="form-control datepicker inline-date-src" id="fromDate" /> <strong class="inline-date-src to_label">TO</strong>
											<input style="width:115px;text-align:center;" type="text" placeholder="yyyy-mm-dd" class="form-control datepicker inline-date-src" id="toDate" />
										</div>
									</div>
								</div>
								<div class="search-input-bx" style="width: 60px;">
									<span style="width: 60px;text-transform: uppercase;display: inline-block;background: #1B75BC;color: #FFF;border-radius: 2px;text-align: center;font-size: 12px;padding: 3px 0;margin-top: 5px;cursor:pointer;" onclick="searchFilter()">Search</span>
								</div>
								<div class="search-input-bx" style="width: 335px;">
									<div class="col-lg-5 text-right"><strong class="filter-label">Center </strong></div>
									<div class="col-lg-7">
										<select id="center" class="form-control inline-src-right">
											<option value="" selected="selected">Select Center</option>
											<?php 
												$centers = $this->Dashboard_model->get_center_list();
												foreach($centers as $center):
											?>
											<option value="<?php echo $center['orgcenter_id']; ?>"><?php echo $center['orgcenter_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="search-input-bx" style="width: 175px;">
									<div class="col-lg-6 text-right"><strong class="filter-label">Year </strong></div>
									<div class="col-lg-6">
										<select id="year" class="form-control inline-src-right">
											<option value="" selected="selected">Select</option>
											<?php 
												$starting_year = 2018;
												for($x=$starting_year; $x < $starting_year + 10; $x++):
											?>
											<option value="<?php echo $x; ?>"><?php echo $x; ?></option>
											<?php endfor; ?>
										</select>
									</div>
								</div>
								<div class="search-input-bx" style="width: 175px;">
									<div class="col-lg-6 text-right"><strong class="filter-label">Month </strong></div>
									<div class="col-lg-6">
										<select id="month" class="form-control inline-src-right">
											<option value="" selected="selected">Select</option>
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
										<input type="text" class="form-control inline-src-right" id="keywords" placeholder="Search here...." <?php echo (isset($src_input))? 'value="'.$src_input.'"' : null; ?> />
									</div>
								</div>
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<div id="postList">
								<table class="table">
									<thead>
										<tr>
											<th>SL.</th>
											<th>BNDR ID</th>
											<th>Name</th>
											<th>Visit No</th>
											<th>Visit Type</th>
											<th>Visit Date</th>
											<th>Visit Center</th>
											<th>Visit Created</th>
											<th>Payment Status</th>
											<th>Action</th>
											<th>Receipt</th>
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
											<td class="text-center"><?php echo 'Visit '.$item['visit_number']; ?></td>
											<td class="text-center"><?php echo $item['visit_type']; ?></td>
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_date'])); ?></td>
											<td class="text-center"><?php echo $item['orgcenter_name']; ?></td>
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_admit_date'])).' '.date("g:i A", strtotime($item['visit_admit_date'])); ?></td>
											<td class="text-center">
												<?php if($item['payment_patient_status'] === '1'): ?>
													<strong style="color:#0A0">Paid</strong>
												<?php else: ?>
													<strong style="color:#F00">Unpaid</strong>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<a href="<?php echo base_url('patients/visit/edit/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
												<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
												<a data-item="<?php echo $item['visit_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;margin-right:5px;"><i class="fa fa-trash"></i></a>
												<?php endif; ?>
												<a href="<?php echo base_url('patients/visit/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
											</td>
											<td class="text-center">
												<a target="_blank" href="<?php echo base_url('patients/visit/moneyreceipt/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.remove-btn', function(){
				if(confirm('Are you sure to delete?', true))
				{
					var item = $(this).attr('data-item');
					var pid = $(this).attr('data-patient');
					$.ajax({
						type : "POST",
						url : baseUrl + "patients/visit/delete",
						data : {id:item, pid:pid},
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
					$(this).parent().parent().remove();
				}
			});
		});
	</script>
	<script type="text/javascript">
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var from_date = $('#fromDate').val();
			var to_date = $('#toDate').val();
			var center = $('#center').val();
			var month = $('#month').val();
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pfilter/get_payment_pendins/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&from_date='+from_date+'&to_date='+to_date+'&center='+center+'&year='+year+'&month='+month,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
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
			$(document).on('click', '#fromDate', function(){
				$("#month").val('');
				$("#year").val('');
			});
			$(document).on('click', '#toDate', function(){
				$("#month").val('');
				$("#year").val('');
			});
			$(document).on('change', '#month', function(){
				$("#fromDate").val('');
				$("#toDate").val('');
			});
			$(document).on('change', '#year', function(){
				$("#fromDate").val('');
				$("#toDate").val('');
			});
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>