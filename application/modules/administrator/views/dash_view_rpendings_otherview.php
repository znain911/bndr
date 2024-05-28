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
						<li class="active">
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
						<li>
							<a href="<?php echo base_url('administrator/dashboard/shw/ppendings'); ?>">
								<strong>Visit Payment</strong>
								Pendings
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('administrator/dashboard/shw/ppaids'); ?>">
								<strong>Visit Payment</strong>
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
											<th>Gender</th>
											<th>Visit Center</th>
											<th>Patient Phone</th>
											<th>Patient DOB</th>
											<th>Patient Age</th>
											<th>Reg. Date</th>
											<th>Payment Status</th>
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
											<td><?php echo $item['patient_entryid']; ?></td>
											<td><?php echo $item['patient_name']; ?></td>
											<td><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
											<td><?php echo $item['orgcenter_name']; ?></td>
											<td><?php echo $item['patient_phone']; ?></td>
											<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
											<td><?php echo $item['patient_age']; ?></td>
											<?php if($item['patient_form_version'] == 'V1'): ?>
											<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
											<?php else: ?>
											<td><?php echo date("d M, Y", strtotime($item['patient_registration_date'])); ?></td>
											<?php endif; ?>
											<td class="text-center">
												<?php if($item['patient_payment_status'] === '1'): ?>
													<strong style="color:#0A0">Paid</strong>
												<?php else: ?>
													<strong style="color:#F00">Unpaid</strong>
												<?php endif; ?>
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
					$.ajax({
						type : "POST",
						url : baseUrl + "patients/delete",
						data : {id:item},
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
				url: '<?php echo base_url(); ?>pfilter/get_payment_rpendins/'+page_num,
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