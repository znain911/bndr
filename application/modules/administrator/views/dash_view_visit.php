<?php require_once APPPATH.'modules/common/header.php' ?>
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Dashboard</h4>
		</div>
		
		<!-- /.col-lg-12 -->
	</div>
	<!-- ============================================================== -->
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<a href="<?php echo base_url('patients/export/csv'); ?>" class="add-vst-button pull-right" style="margin-right:15px;"><i class="fa fa-plus-square"></i> EXPORT CSV</a>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default block2">
				<div class="panel-heading text-center put-relative" style="padding: 25px 0px;">
					<ul class="patient-tab-ul">
						
						
						
						<li class="active">
							<a href="<?php echo base_url('administrator/dashboard'); ?>">
								<strong>Visit Report</strong>
							</a>
						</li>
						
						<li class="">
							<a href="<?php echo base_url('administrator/dashboard/doc_image_today'); ?>">
								<strong>Image Upload</strong>
								Doctor
							</a>
						</li>
						
						<li class="">
							<a href="<?php  echo base_url('administrator/dashboard/oprtr_image_today'); ?>">
								<strong>Image Upload</strong>
								Operator
							</a>
						</li>
					</ul>
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive">
							
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
								<div class="search-input-bx" style="width: 200px;">
									<div class="col-lg-5 text-right"><strong class="filter-label">Center </strong></div>
									<div class="col-lg-7">
										<select id="center" class="form-control inline-src-right">
											<option value="" selected="selected">Select Center</option>
											<?php 
												$centers = $this->Dashboard_model->get_center_list_visit();
												foreach($centers as $center):
											?>
											<option value="<?php echo $center['orgcenter_id']; ?>"><?php echo $center['orgcenter_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="search-input-bx" style="width: 150px;">
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
								
								<div class="search-input-bx" style="width: 150px;">
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
								<div class="search-input-bx" style="width: 250px;">
									<div class="col-lg-5 text-right"><strong class="filter-label">Operators </strong></div>
									<div class="col-lg-7">
										<select id="operator" class="form-control inline-src-right">
											<option value="" selected="selected">Select Operator</option>
											<?php 
												
												$so = $this->Dashboard_model->get_sp();
												$operators = $this->Dashboard_model->get_operators();
												
												foreach($so as $super):?>
												<option value="<?php echo $super['operator_id']; ?>"><?php echo $super['operator_full_name']; ?></option>
											<?php	
											endforeach;
											foreach($operators as $operator):
											?>
											<option value="<?php echo $operator['operator_id']; ?>"><?php echo $operator['operator_full_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								
								<div class="search-input-bx" style="width: 250px;">
									<div class="col-lg-5 text-right"><strong class="filter-label">Doctors </strong></div>
									<div class="col-lg-7">
										<select id="doctor" class="form-control inline-src-right">
											<option value="" selected="selected">Select Doctor</option>
											<?php 
												
												$doctors = $this->Dashboard_model->get_doctors();
												
											foreach($doctors as $doctor):
											?>
											<option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctor_full_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="search-input-bx" style="width: 250px;    float: left;">
									<div class="col-lg-5 text-right"><strong class="filter-label">Visit Type</strong></div>
									<div class="col-lg-7">
										<select id="type" class="form-control inline-src-right">
											<option value="" selected="selected">Select type</option>
											<option value="">ALL</option>
											<option value="PROGRESS_REPORT" >Follow up</option>
											<option value="CASE_HISTORY" >Case History</option>
											
										</select>
									</div>
								</div>
								<!--<div class="search-input-bx">
									<div class="col-lg-3"><strong class="filter-label">Search </strong></div>
									<div class="col-lg-9">
										<input type="text" class="form-control inline-src-right" name= "keywords" id="keywords" placeholder="Search ID/Name/Phone" <?php echo (isset($src_input))? 'value="'.$src_input.'"' : null; ?> />
									</div>
								</div>-->
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<div id="postList">
							<div><span style="display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;"><strong>Today total :</strong> <span id="totalPatients"><?php echo $items_count; ?></span></span></div>
								<table class="table">
									<thead>
										<tr>
											<th>SL.</th>
											<th>ID</th>
											<th>Gender</th>
											<th>Name</th>
											<th>Center</th>
											<th>Phone</th>
											<!--<th>Date Of Birth</th>-->
											<th>Age</th>
											<th>Register Date</th>
											<th>Visit Date</th>
											<th>Visit Type</th>
											<th>Type of User</th>
											
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
											<td><?php echo $item['patient_id']; ?></td>
											<td><?php echo $item['patient_gender']; ?></td>
											<td><?php echo $item['patient_name']; ?></td>
											<td><?php echo $item['orgcenter_name']; ?></td>
											<td><?php echo $item['patient_phone']; ?></td>
											<!--<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>-->
											<td><?php echo $item['patient_age']; ?></td>
											<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
											<td><?php echo date("d M, Y", strtotime($item['visit_admit_date'])); ?></td>
											<td><?php echo $item['visit_type']; ?></td>
											<td><?php 
											if($item['visit_admited_by_usertype'] === 'Operator' || $item['visit_admited_by_usertype'] === 'Super Operator'){
											//echo $item['submitted_by']; 
											echo 'Operator'; 
											}else {
												//$doctor = $this->Dashboard_model->get_doctor_name($item['visit_admited_by']);
												//echo $doctor['doctor_full_name'];
												echo 'Doctor';
											}?></td>
											
											
										</tr>
										<?php 
											$sl++;
											endforeach; 
											else:
										?>
										<tr><td colspan="13" class="text-center">No new patients today.</td></tr>
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
		$("#doctor").change(function(){
		  //alert("The text has been changed.");
		  $("#operator").val(null);
		});
		
		$("#operator").change(function(){
		  $("#doctor").val(null);
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
			var operator = $('#operator').val();
			var doctor = $('#doctor').val();
			var type = $('#type').val();
			
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pfilter/get_all_visit/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&from_date='+from_date+'&to_date='+to_date+'&center='+center+'&year='+year+'&month='+month+'&operator='+operator+'&doctor='+doctor+'&type='+type,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
						//alert(data.doctor);
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