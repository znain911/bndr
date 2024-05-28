<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Setup</li>
				<li class="active">Company</li>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-lg-12">
			<div class="add-href-unit">
				<strong style="margin-top:15px;" class="pull-left">COMPANIES</strong>
				<a href="<?php echo base_url('setup/company/create'); ?>" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW COMPANY</a>
			</div>
			<div class="panel panel-default block2" style="padding:15px">
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive put-relative">
							<div class="top-search-filter-section">
								<?php 
									$attr = array('class' => 'form-horizontal form-material', 'id' => 'filterByDate');
									echo form_open('', $attr);
								?>
								<div class="date-to-date-search">
									<div class="row">
										<div class="col-lg-9">
											<strong class="inline-date-src to_label">From</strong>
											<input style="width:115px;text-align:center;" type="text" placeholder="yyyy-mm-dd" onchange="searchFilter()" class="form-control datepicker inline-date-src" id="fromDate" /> <strong class="inline-date-src to_label">TO</strong>
											<input style="width:115px;text-align:center;" type="text" placeholder="yyyy-mm-dd" onchange="searchFilter()" class="form-control datepicker inline-date-src" id="toDate" />
										</div>
									</div>
								</div>
								<div class="search-input-bx">
									<div class="col-lg-3"><strong class="filter-label">Search </strong></div>
									<div class="col-lg-9">
										<input type="text" class="form-control inline-src-right" id="keywords" onkeyup="searchFilter()" placeholder="Search here...." <?php echo (isset($src_input))? 'value="'.$src_input.'"' : null; ?> />
									</div>
								</div>
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<div id="postList">
								<table class="table">
									<thead>
										<tr>
											<th style="width: 5%;">SL.</th>
											<th style="width: 30%;">Company Name</th>
											<th style="width: 15%;">Type</th>
											<th style="width: 12%;">Create Date</th>
											<th style="width: 20%;">Created By</th>
											<th style="width: 7%;">Status</th>
											<th style="width: 6%;">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sl = 1;
											foreach($items as $item):
											$types = array('1' => 'Local', '2' => 'International', '' => '');
										?>
										<tr>
											<td><?php echo $sl; ?></td>
											<td><?php echo $item['company_name']; ?></td>
											<td class="text-center"><?php echo $types[$item['company_type']]; ?></td>
											<td><?php echo date("d M, Y", strtotime($item['company_create_date'])).' '.date("g:i A", strtotime($item['company_create_date'])); ?></td>
											<td class="text-center"><?php echo get_admitted_by($item['company_created_by'], $item['company_created_by_user_type']); ?></td>
											<td class="text-center">
												<?php if($item['company_status'] == 'YES'): ?>
												<span class="label label-success">Available</span>
												<?php else: ?>
												<span class="label label-danger">Unavailable</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<a href="<?php echo base_url('setup/company/edit/'.$item['company_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
												<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
												<a data-item="<?php echo $item['company_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-trash"></i></a>
												<?php endif; ?>
											</td>
										</tr>
										<?php 
											$sl++;
											endforeach; 
										?>
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
						url : baseUrl + "setup/company/delete",
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
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pfilter/get_all_companies/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&from_date='+from_date+'&to_date='+to_date,
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
<?php require_once APPPATH.'modules/common/footer.php' ?>