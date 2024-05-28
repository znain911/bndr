<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li>Organization Report</li>
				<li>Centers</li>
				<li class="active">Operators</li>
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
				<strong style="margin-top:15px;" class="pull-left">OPERATORS</strong>
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
											<th style="text-align:left !important;">Operator Name</th>
											<th style="text-align:left !important;">Center</th>
											<th>Total Patients</th>
											<th>Total Visits</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(is_array($items) && count($items) !== 0): ?>
										<?php
											$sl = 1;
											$patient_params = array('search' => array(
												'from_date' => null,
												'to_date'   => null,
												'month'     => null,
												'year'      => null,
											));
											$visit_params = array('search' => array(
												'from_date' => null,
												'to_date'   => null,
												'month'     => null,
												'year'      => null,
											));
											foreach($items as $item):
										?>
										<tr>
											<td class="text-center"><?php echo $sl; ?></td>
											<td><?php echo $item['operator_full_name']; ?></td>
											<td><?php echo $item['orgcenter_name']; ?></td>
											<td class="text-center"><?php echo total_patients_of_the_operator($patient_params, $item['operator_org_centerid'], $item['operator_id']); ?></td>
											<td class="text-center"><?php echo total_visits_of_the_operator($visit_params, $item['operator_org_centerid'], $item['operator_id']); ?></td>
											<td class="text-center">
												<a href="<?php echo base_url('orgreports/patients?CENTER='.$item['operator_org_centerid'].'&OPERATOR='.$item['operator_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;">View Patients</a>
											</td>
										</tr>
										<?php 
											$sl++;
											endforeach; 
										?>
										<?php else: ?>
										<tr>
											<td colspan="6" class="text-center">NO DATA FOUND</td>
										</tr>
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
			$('#loader').show();
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var from_date = $('#fromDate').val();
			var to_date = $('#toDate').val();
			var month = $('#month').val();
			var year = $('#year').val();
			var center = "<?php echo $center; ?>";
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>ajaxapiv1/get_all_operators/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&from_date='+from_date+'&to_date='+to_date+'&center='+center+'&year='+year+'&month='+month,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
						$('#loader').hide();
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