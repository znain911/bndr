<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Export</li>
				<li class="active">Excel</li>
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
				<strong style="margin-top:15px;margin-bottom:25px;" class="pull-center">EXPORT EXCEL</strong>
			</div>
			<div class="panel panel-default block2">
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive put-relative">
							<div class="top-search-filter-section" style="width: 400px; margin: 30px auto;">
								<?php 
									$attr = array('class' => 'form-horizontal form-material', 'id' => 'filterByDate');
									echo form_open('patients/exportexcel', $attr);
								?>
								<div class="date-to-date-search">
									<div class="row">
										<!--
										<div class="col-lg-3 text-right">
											<strong class="filter-label">Search By Date</strong>
										</div>
										-->
										<div class="col-lg-9">
											<strong class="inline-date-src to_label">From</strong>
											<input style="width:115px;text-align:center;" type="text" placeholder="yyyy-mm-dd" class="form-control datepicker inline-date-src" id="fromDate" name="from_date" /> <strong class="inline-date-src to_label">TO</strong>
											<input style="width:115px;text-align:center;" type="text" placeholder="yyyy-mm-dd" class="form-control datepicker inline-date-src" id="toDate" name="to_date" />
											<?php if(isset($_GET['type']) && $_GET['type'] == 'IMPORTED'): ?>
											<input type="hidden" name="is_registered" value="NO" />
											<?php else: ?>
											<input type="hidden" name="is_registered" value="YES" />
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div style="clear:both"></div>
							</div>
						</div>
					</div>
					<div class="panel-footer text-right"> 
						<button class="btn btn-info waves-effect waves-light m-t-10" type="submit">Export</button> 
						<span onclick="window.location.href='<?php echo base_url('patients'); ?>'" class="btn btn-danger waves-effect waves-light m-t-10">Cancel</span>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php' ?>