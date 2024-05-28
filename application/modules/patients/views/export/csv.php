<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Export</li>
				<li class="active">Csv</li>
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
				<strong style="margin-top:15px;margin-bottom:25px;" class="pull-center">EXPORT CSV</strong>
			</div>
			<div class="panel panel-default block2">
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive put-relative">
							<div class="top-search-filter-section" >
								<?php 
									$attr = array('class' => 'form-horizontal form-material', 'id' => 'filterByDate');
									echo form_open('patients/exportcsv', $attr);
								?>
								<div class="date-to-date-search" style="width:355px">
									<div class="row">
										<div style="width:100%;padding: 0 15px;">
											<strong class="inline-date-src to_label">From</strong>
											<input style="width:115px;text-align:center;" type="date" placeholder="yyyy-mm-dd" class="form-control  inline-date-src" id="fromDate" name="from_date" /> <strong class="inline-date-src to_label">TO</strong>
											<input style="width:115px;text-align:center;" type="date" placeholder="yyyy-mm-dd" class="form-control  inline-date-src" id="toDate" name="to_date" />
											<?php if(isset($_GET['type']) && $_GET['type'] == 'IMPORTED'): ?>
											<input type="hidden" name="is_registered" value="NO" />
											<?php else: ?>
											<input type="hidden" name="is_registered" value="YES" />
											<?php endif; ?>
										</div>
									</div>
								</div>
											<?php if( $this->session->userdata('user_type') === 'Org Admin'): ?>
											
											
											
											<div class="search-input-bx" style="width: 175px;margin-right: 200px;">
												<div class="col-lg-6 text-right"><strong class="filter-label">Year </strong></div>
												<div class="col-lg-6">
													<select name="year" id="year" class="form-control inline-src-right">
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
													<select name="month" id="month" class="form-control inline-src-right">
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
											
											<div class="search-input-bx" style="width: 200px;">
												<div class="col-lg-5 text-right"><strong class="filter-label">Center </strong></div>
												<div class="col-lg-7">
													<select name="center" id="center" class="form-control inline-src-right">
														<option value="" selected="selected">Select Center</option>
														<?php 
															$centers = $this->Patient_model->get_center_list_visit();
															foreach($centers as $center):
														?>
														<option value="<?php echo $center['orgcenter_name']; ?>"><?php echo $center['orgcenter_name']; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											
											<div class="search-input-bx" style="width: 250px;">
												<div class="col-lg-5 text-right"><strong class="filter-label">Operators </strong></div>
												<div class="col-lg-7">
													<select name= 'operator' id="operator" class="form-control inline-src-right">
														<option value="" selected="selected">Select Operator</option>
														<?php 
															$so = $this->Patient_model->get_sp();
															$operators = $this->Patient_model->get_operators();
															foreach($so as $super):?>
															<option value="<?php echo $super['operator_full_name']; ?>"><?php echo $super['operator_full_name']; ?></option>
														<?php	
														endforeach;
														foreach($operators as $operator):
														?>
														<option value="<?php echo $operator['operator_full_name']; ?>"><?php echo $operator['operator_full_name']; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<?php endif; ?>
										
								
								<div style="clear:both"></div>
							</div>
						</div>
					</div>
					<div class="panel-footer text-right"> 
						<a class="btn btn-info waves-effect waves-light m-t-10" data-save-method="save" data-toggle="modal" data-target=".bs-example-modal-sm" type="submit">Export</a> 
						<span onclick="window.location.href='<?php echo base_url('patients'); ?>'" class="btn btn-danger waves-effect waves-light m-t-10">Cancel</span>
					</div>
					
					<div class="modal fade bs-example-modal-sm" id= "myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
						<div class="modal-dialog modal-sm" style = "    width: 40%;">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="mySmallModalLabel" style="font-size: 15px;">Export Type </h4> 
								</div>
								<div class="modal-body text-center">
									<label class="hide-controler" data-value="0"><input type="radio" name="csv_type" value="3" checked />&nbsp; Data and Count</label>&nbsp;&nbsp;
									<label class="pres-controler" data-value="1"><input type="radio" name="csv_type" value="1"  />&nbsp; Only Count</label> &nbsp;&nbsp; 
									<label class="pres-controler" data-value="0"><input type="radio" name="csv_type" value="2"  />&nbsp; Data</label> &nbsp;&nbsp; 
									
								</div>
								<div class="modal-footer">
									<span class="btn btn-default waves-effect" data-dismiss="modal">Cancel</span>
									<button type="submit" class="btn btn-info confirm-payment submit-type" data-save-method="" >Confirm</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function(){
			
			$(document).on('click', '.submit-type', function(){
				$('#myModal').modal('toggle');
			});
			
			});
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>