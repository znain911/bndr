<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li>Organization Report</li>
				<li>Centers</li>
				<li>Operators</li>
				<li>Patients</li>
				<li class="active">Visits</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-lg-12 put-relative">
			<div id="loader" class="disable-select"><strong style="color: blue;font-size: 13px;letter-spacing: 5px;text-transform: uppercase;">.....Please wait.....</strong></div>
			<div class="add-href-unit">
				<strong style="margin-top:15px;" class="pull-left">VISITS</strong>
			</div>
			<div class="panel panel-default block2">
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive put-relative">
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
								<div class="search-input-bx" style="width: 175px;">
									<div class="col-lg-6 text-right"><strong class="filter-label">Year </strong></div>
									<div class="col-lg-6">
										<select id="year" class="form-control inline-src-right">
											<option value="" selected="selected">Select</option>
											<option value="">All</option>
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
											<option value="">All</option>
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
											<th>Visit No</th>
											<th>Visit Center</th>
											<th>Visit Date</th>
											<th>Visit Type</th>
											<th>Submitted By</th>
											<th>Payment Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sl = 1;
											if(is_array($items) && count($items) !== 0):
											foreach($items as $item):
										?>
										<tr>
											<td class="text-center"><?php echo $sl; ?></td>
											<td class="text-center"><?php echo $item['visit_number']; ?></td>
											<td class="text-center"><?php echo $item['visit_visit_center']; ?></td>
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_date'])); ?></td>
											<td class="text-center"><?php echo str_replace('_', ' ', $item['visit_is']); ?></td>
											<td class="text-center"><?php echo get_admitted_by($item['visit_admited_by'], $item['visit_admited_by_usertype'], $item['visit_admited_by_usersyncid']); ?></td>
											<td class="text-center">
												<?php if($item['payment_patient_status'] === '1'): ?>
													<strong style="color:#0A0">Paid</strong>
												<?php else: ?>
													<strong style="color:#F00">Unpaid</strong>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<?php if($item['visit_is'] == 'PROGRESS_REPORT'): ?>
												<a href="<?php echo base_url('patients/progress/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
												<?php else: ?>
												<a href="<?php echo base_url('patients/visit/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
												<?php endif; ?>
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
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var from_date = $('#fromDate').val();
			var to_date = $('#toDate').val();
			var center = "<?php echo $center; ?>";
			var patient = "<?php echo $patient; ?>";
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>ajaxapiv1/get_patient_visits/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&from_date='+from_date+'&to_date='+to_date+'&patient='+patient+'&center='+center,
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
		function searchFilter(page_num) {
			$('#loader').show();
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var from_date = $('#fromDate').val();
			var to_date = $('#toDate').val();
			var patient = "<?php echo $patient; ?>";
			var month = $('#month').val();
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>ajaxapiv1/get_patient_visits/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&from_date='+from_date+'&to_date='+to_date+'&year='+year+'&month='+month+'&patient='+patient,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
						$('#loader').show();
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