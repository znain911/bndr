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
						<?php if($this->session->userdata('user_type') !== 'Doctor'): ?>
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
						<li class="">
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
						<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
						<li class="">
							<a href="<?php echo base_url('administrator/dashboard/doc_image_today'); ?>">
								<strong>Image Upload</strong>
								Doctor
							</a>
						</li>
						
						<li class="active">
							<a href="<?php echo base_url('administrator/dashboard/oprtr_image_today'); ?>">
								<strong>Image Upload</strong>
								Operator
							</a>
						</li>
						<?php endif;endif; ?>
					</ul>
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body"  style = "padding: 10px;">
						<div class="table-responsive">
							<div class="col-lg-12" style="margin: 1% 0%">
								<div class="col-md-9 ">
									
								</div>
								<div class="col-md-3 ">
									<strong class="filter-label" style = 'color: white;background-color: #1b75bc;display: flex;justify-content: center; padding: 3%;border: 2px solid #fffdfd;border-radius: 25px;'>
										<a style = 'color: #ffffff; font-size: 16px;' href="<?php echo base_url('administrator/dashboard/oprtr_image_today'); ?>">Today Upload by Operators</a>
									</strong>
								</div>
								
								
								
							</div>
							
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
											<option value="" selected="selected">Select a Center first</option>
											
										</select>
									</div>
								</div>
								
								<div class="search-input-bx" style="width: 230px;">
									<div class="col-lg-6 text-right"><strong class="filter-label">Center </strong></div>
									<div class="col-lg-6">
										<select name="center" class="form-control inline-src-right" id="cenTers">
											<option  value="" selected="selected">Select Center</option>
										
										
										</select>
									</div>
								</div>
								
								<div class="search-input-bx" style="width: 310px;">
									<div class="col-lg-6 text-right"><strong class="filter-label">Organization </strong></div>
									<div class="col-lg-6">
										<select  class="form-control inline-src-right" id="selectedOrganization">
											<option value="" selected="selected">Select Organization</option>
												<?php 
													$orgs = $this->Dashboard_model->get_all_organizations();
													foreach($orgs as $org):
												?>
											<option style = 'background: white; color: black;' value="<?php echo $org['org_id']; ?>" ><?php echo $org['org_name']; ?></option>
												<?php endforeach; ?>
										</select>
									</div>
								</div>
								
								
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							
							<div id="postList">
							<div style = "margin-bottom: 0.5%;"><span style="font-size: 20px;display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;"><strong>Total Count :</strong> <span id="totalPatients"><?php echo $items_count; ?></span></span></div>
								<table id = "example" class="table">
									<thead>
										<tr>
											<th>SL.</th>
											<th>Name Of Operator</th>
											<th>Center Name</th>
											<th>Prescription Upload Count</th>
											<th>Data Entry Count</th>
											
											
										</tr>
									</thead>
									<tbody>
										<?php 
											$sl = 1;
											if(count($items) !== 0):
											foreach($items as $item):
											$chCount = $this->Dashboard_model->image_ch_count($item['submitted_by']);
											$chEntryCount = $this->Dashboard_model->image_ch_entry_count($item['submitted_by']);
											$pCount = $this->Dashboard_model->image_p_count($item['submitted_by']);
											$pEntryCount = $this->Dashboard_model->image_p_entry_count($item['submitted_by']);
											$filterChCount = array_values(array_column($chCount, null, 'patient_id'));
											$filterChEntryCount = array_values(array_column($chEntryCount, null, 'patient_id'));
											$filterPCount = array_values(array_column($pCount, null, 'time'));
											$filterPEntryCount = array_values(array_column($pEntryCount, null, 'time'));
											$ch = count($filterChCount);
											$chEntry = count($filterChEntryCount);
											$progress = count($filterPCount);
											$pEntry = count($filterPEntryCount);
											
											$totalUpload = $ch + $progress;
											$totalEntry = $chEntry + $pEntry;
										?>
										<tr>
											<td><?php echo $sl; ?></td>
											<td><?php echo substr($item['submitted_by'], 0, -10);  ?></td>
											<td><?php echo $item['orgcenter_name'];  ?></td>
											<td style = 'text-align: center;'><a href="#" onclick="upload('<?php echo substr($item['submitted_by'], 0, -9);?>','<?php echo $item['center_id'];?>')" class="tags1"><?php echo $totalUpload;  ?></a></td>
											<td style = 'text-align: center;'><a href="#" onclick="entry('<?php echo substr($item['submitted_by'], 0, -9);?>','<?php echo $item['center_id'];?>')" class="tags1"><?php echo $totalEntry;  ?></a></td>
											
											
											
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
								
							</div>
						</div>
					</div>
				</div>
				
				
				
				
			</div>
			<div class = 'upImage' style = 'display: hide; margin-top: 2%'>
				
				</div>
		</div>
	</div>
	<script type="text/javascript">
	
	
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var from_date = $('#fromDate').val();
			var to_date = $('#toDate').val();
			var month = $('#month').val();
			var year = $('#year').val();
			var operator = $('#operator').val();
			var cenTers = $('#cenTers').val();
			var organization = $('#selectedOrganization').val();
			//alert(from_date);
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pfilter/oprtr_image/'+page_num,
				data:'page='+page_num+'&from_date='+from_date+'&to_date='+to_date+'&year='+year+'&month='+month+'&operator='+operator+'&centers='+cenTers+'&org='+organization,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
						$('.upImage').hide();
						//alert(data.doctor);
					}else
					{
						return false;
					}
				}
			});
		}
	</script>
	<script type='text/javascript'>

function upload(oprtr,center)
{
	var from_date = $('#fromDate').val();
	var to_date = $('#toDate').val();
	var month = $('#month').val();
	var year = $('#year').val();
    //alert(operator);
	$.ajax({
		type: 'POST',
		url: '<?php echo base_url(); ?>pfilter/image_patient_list_upload_operator/',
		data:'oprtr='+oprtr+'&center='+center+'&from_date='+from_date+'&to_date='+to_date+'&year='+year+'&month='+month,
		dataType:'json',
		beforeSend: function () {
			
		},
		success: function (data) {
			if(data.status == 'ok')
			{
				//$('#postList').html(data.content);
				//alert(data.content);
				$('.upImage').show();
				$('.upImage').html(data.content);
				window.scrollBy(0, 1000);
			}else
			{
				return false;
			}
		}
	});
}

function entry(oprtr,center)
{
	var from_date = $('#fromDate').val();
	var to_date = $('#toDate').val();
	var month = $('#month').val();
	var year = $('#year').val();
    //alert(center);
	$.ajax({
		type: 'POST',
		url: '<?php echo base_url(); ?>pfilter/image_patient_list_entry_oprtr/',
		data:'oprtr='+oprtr+'&center='+center+'&from_date='+from_date+'&to_date='+to_date+'&year='+year+'&month='+month,
		dataType:'json',
		beforeSend: function () {
			
		},
		success: function (data) {
			if(data.status == 'ok')
			{
				//$('#postList').html(data.content);
				//alert(data.content);
				$('.upImage').show();
				$('.upImage').html(data.content);
				//window.scrollBy(0, 1000);
				
				$([document.documentElement, document.body]).animate({
				scrollTop: $(".upImage").offset().top
				}, 2000);
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
			//get centers
			$(document).on('change', '#selectedOrganization', function(){
				var org = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "register/get_centers",
					data : {org_id:org},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#cenTers').html(data.content);
							$('#loader').hide();
							return false;
						}else
						{
							//have end check.
						}
						return false;
					}
				});
			});
			
			$(document).on('change', '#cenTers', function(){
				var center = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "register/get_operators",
					data : {center_id:center},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#operator').html(data.content);
							$('#loader').hide();
							return false;
						}else
						{
							//have end check.
						}
						return false;
					}
				});
			});
			
			
			});
			
</script>

<script type="text/javascript">
		$(function(e) {
            $('#example').DataTable(
                {lengthMenu:[5,10,25,50,100],pageLength:10,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}
                );
        } );
	</script>	

<?php require_once APPPATH.'modules/common/footer.php' ?>