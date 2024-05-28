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
			<input type="submit" value="Scan QR Code" onclick="myFunction()" data-toggle="modal" data-target=".bs-example-modal-sm"  style = '    background-color: #3c4451;color: white;'>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- ============================================================== -->
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="modal fade bs-example-modal-sm" id = "myModal" style="display: none;height: 100%;">
			<div class="modal-dialog modal-sm" style = "margin: 0px;    height: 100%;">
				<div class="modal-content" style = "height: 100%;">
					<div class="modal-header">
						<h4 class="modal-title" id="mySmallModalLabel" style="font-size: 30px;font-weight: bold;text-align: center;">QR Code Scanner</h4> 
					</div>
					<div class="modal-body text-center" style = "padding: 0px;height: 78%;" id ="scanner">
						
					</div>
					<div class="modal-footer" style = "text-align: center;">
						<span class="btn btn-default waves-effect"  data-dismiss="modal">Cancel</span>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
	<?php if($this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'):?>
	<div class="col-sm-4 p anp " style = "float: none;margin-bottom: 1%;"> 
		<a style = "background: #00c752 none repeat scroll 0 0;border-radius: 30px;color: #fff;display: block;font-weight: 500;padding: 2px 15px;display: flex;
    justify-content: center;align-items: center;" 
		href="<?php echo base_url('patients/create'); ?>"><i class="mdi mdi-plus fa-fw"></i> <span class="hide-menu">Add New Patient</span></a>
	</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default block2">
				<div class="panel-heading text-center put-relative" style="padding: 25px 0px;">
					<ul class="patient-tab-ul">
					<?php if($this->session->userdata('user_type') !== 'Doctor'): 
						if($this->session->userdata('user_type') !== 'Foot Doctor'):
						if($this->session->userdata('user_type') !== 'Eye Doctor'):?>
						<li class="">
							<a href="<?php echo base_url('administrator/dashboard/shw/todays'); ?>">
								<strong>Todays</strong>
								Patients
							</a>
						</li>
						<?php endif;endif;endif; ?>
						<?php if($this->session->userdata('user_type') !== 'Operator') : ?>
						<li class="active">
							<a href="<?php echo base_url('administrator/dashboard/shw/all'); ?>">
								<strong>Total Registered </strong>
								Patients
							</a>
						</li>
						
						
						<?php endif; ?>
						<?php if($this->session->userdata('user_type') !== 'Doctor'): 
							if($this->session->userdata('user_type') !== 'Foot Doctor'):
							if($this->session->userdata('user_type') !== 'Eye Doctor'):?>
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
						<li class="">
							<a href="<?php echo base_url('administrator/dashboard/oprtr_image_today'); ?>">
								<strong>Image Upload</strong>
								Operator
							</a>
						</li>
						<?php endif;endif;endif;endif; ?>
						
					</ul>
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive">
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
								<?php if($this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
								<!--<div class="search-input-bx search" style="width: 480px;">
									<strong class="filter-label fl">Center </strong>
									<div class="Sce ">
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
								</div>-->
								<div class="search-input-bx search" style="width: 60px;">
									<span style="width: 60px;text-transform: uppercase;display: inline-block;background: #1B75BC;color: #FFF;border-radius: 2px;text-align: center;font-size: 12px;padding: 3px 0;margin-top: 5px;cursor:pointer;" onclick="searchFilter()">Search</span>
								</div>
								<div class="col-lg-6" style= 'display: none;' id="year">
									
								</div>
								<div class="search-input-bx" style="width: 175px;display: none;" id="month">
									
								</div>
								<div class="search-input-bx" style= 'display: none;' id="keywords">
									
								</div>
								<?php endif;?>
								<?php if($this->session->userdata('user_type') !== 'Doctor'): 
								if($this->session->userdata('user_type') !== 'Foot Doctor'):
								if($this->session->userdata('user_type') !== 'Eye Doctor'): ?>
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
								<?php endif;endif;endif;?>
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<div id="postList">
								<table class="table">
									<thead>
										<tr>
											<th>SL.</th>
											<?php if($this->session->userdata('user_type') !== 'Doctor' ): 
											if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
											<th>ID</th>
											<?php endif;endif;endif;?>
											<?php if($this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor' || $this->session->userdata('user_type') === 'Eye Doctor' ): 
											?>
											<th>Visits</th>
											<?php endif;?>
											<th class = 'laptop'>Gender</th>
											<th>Name</th>
											<?php if($this->session->userdata('user_type') !== 'Doctor' ): 
											if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ):?>
											<th>ORG. Center</th>
											<?php endif;endif;endif;?>
											<th class = 'laptop'>Phone</th>
											<?php if($this->session->userdata('user_type') !== 'Doctor' ):
													if($this->session->userdata('user_type') !== 'Foot Doctor' ):
													if($this->session->userdata('user_type') !== 'Eye Doctor' ):	?>
											<th>Date Of Birth</th>
											<?php endif;endif;endif;?>
											<th class = 'laptop'>Age</th>
											<?php if($this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): 
												?>
											<th>First Visit Date</th>
											<th>Guidebook</th>
											<?php  else:?>
											
											<th>Register Date</th>
											<?php endif;?>
											<?php if($this->session->userdata('user_type') !== 'Doctor' ): 
												if($this->session->userdata('user_type') !== 'Foot Doctor' ):
												if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
											<th>Guidebook Number</th>
											<th>Submitted By</th>
											
											<th style="width:7%;">Action</th>
											
											<th>Visits</th>
											<th>Receipt</th>
											<?php endif; endif;endif;?>
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
											<?php if($this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor' || $this->session->userdata('user_type') === 'Eye Doctor' ): 
												?>
											<td class="text-center">
												<a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:20px;background:#f00;padding:8px 8px;"><i class="fa fa-plus-square"></i></a>
											</td>
											<?php endif;?>
											<?php if($this->session->userdata('user_type') !== 'Doctor' ): 
											if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ):?>
											<td><?php echo $item['patient_entryid']; ?></td>
											<?php endif;endif;endif;?>
											<td class = 'laptop'><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
											<td><?php echo $item['patient_name']; ?></td>
											<?php if($this->session->userdata('user_type') !== 'Doctor'): 
												if($this->session->userdata('user_type') !== 'Foot Doctor' ):
												if($this->session->userdata('user_type') !== 'Eye Doctor' ):?>
											<td><?php echo $item['orgcenter_name']; ?></td>
											<?php endif;endif;endif;?>
											<td class = 'laptop'><?php echo $item['patient_phone']; ?></td>
											<?php if($this->session->userdata('user_type') !== 'Doctor' ):
													if($this->session->userdata('user_type') !== 'Foot Doctor' ):
													if($this->session->userdata('user_type') !== 'Eye Doctor' ):?>
											<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
											<?php endif;endif;endif;?>
											<td class = 'laptop'><?php echo $item['patient_age']; ?></td>
											<?php if($item['patient_form_version'] == 'V1'): ?>
											<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
											<?php else: ?>
											<td><?php 
											if($item['patient_create_date']):
											echo date("d M, Y", strtotime($item['patient_create_date'])); 
											endif; 
											?>
											
											</td>
											<td class=" "><?php echo $item['patient_guide_book']; ?></td>
											<?php endif; ?>
											<?php if($this->session->userdata('user_type') !== 'Doctor' ):
													if($this->session->userdata('user_type') !== 'Foot Doctor' ):
													if($this->session->userdata('user_type') !== 'Eye Doctor' ):?>
											<td class="text-center"><?php echo get_admitted_by($item['patient_admitted_by'], $item['patient_admitted_user_type'], $item['patient_admitted_user_syncid']); ?></td>
											
											<td class="text-center">
												<a href="<?php echo base_url('patients/edit/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
												<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
												<a data-item="<?php echo $item['patient_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-trash"></i></a>
												<?php endif; ?>
											</td>
											
											<td class="text-center">
												<a href="<?php echo base_url('patients/visit/all/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
											</td>
											
											<td class="text-center">
												<a target="_blank" href="<?php echo base_url('patients/moneyreceipt/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
											</td>
											<?php endif;endif;endif; ?>
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
	/*$(function(){
		$("#qr-gn").click(function(){
				$('#preview').show();
				var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
				scanner.addListener('scan',function(content){
					$('.searchBar').val(content);
					$('#preview').hide();
					$('.bs-example-modal-sm').modal('toggle');
					scanner.stop();
					//alert(content);
					//window.location.href=content;
				});
				Instascan.Camera.getCameras().then(function (cameras){
				if(cameras.length>0){
					//scanner.start(cameras[1]);
					if(cameras[2]){
                        scanner.start(cameras[2]);
                    }
               
                    else if(cameras[1]){
                        scanner.start(cameras[1]);
                    }else{
                        alert('No Back camera found!');
                    }
					
				}else{
					console.error('No cameras found.');
					alert('No cameras found.');
				}
				}).catch(function(e){
					console.error(e);
					alert(e);
				});
			
			});
 
	});*/
	
	function onQRCodeScanned(scannedText)
    {
    	var scannedTextMemo = document.getElementById("searchBar");
    	if(scannedTextMemo)
    	{
    	    //var scannerParentElement = document.getElementById("myModal");
    		//scannedTextMemo.value = scannedText;
			$('.searchBar').val(scannedText);
    		$('.bs-example-modal-sm').modal('hide');
    	}
    	
    }
	
	 //this function will be called when JsQRScanner is ready to use
    function myFunction()
    {
        //create a new scanner passing to it a callback function that will be invoked when
        //the scanner succesfully scan a QR code
        var jbScanner = new JsQRScanner(onQRCodeScanned);
        //var jbScanner = new JsQRScanner(onQRCodeScanned, provideVideo);
        //reduce the size of analyzed image to increase performance on mobile devices
        jbScanner.setSnapImageMaxSize(600);
    	var scannerParentElement = document.getElementById("scanner");
    	if(scannerParentElement)
    	{
    	    //append the jbScanner to an existing DOM element
    		jbScanner.appendTo(scannerParentElement);
    	}        
    }
</script>
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
				url: '<?php echo base_url(); ?>pfilter/get_all_patients/'+page_num,
				data:'page='+page_num+'&from_date='+from_date+'&to_date='+to_date+'&center='+center+'&keywords='+keywords,
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