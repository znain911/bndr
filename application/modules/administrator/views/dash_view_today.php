<?php require_once APPPATH.'modules/common/header.php' ?>
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Dashboard</h4>
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<!--<ol class="breadcrumb">
				<li><a href="index.html">Dashboard</a></li>
				<li class="active">Dashboard</li>
			</ol>-->
			<?php if($this->session->userdata('user_type') !== 'Administrator'  ): ?>
			<input type="submit" value="Scan QR Code" onclick="myFunction()" data-toggle="modal" data-target=".bs-example-modal-sm"  style = '    background-color: #3c4451;color: white;'>
			<?php else:?>
			<ol class="breadcrumb">
				<li><a href="index.html">Dashboard</a></li>
				<li class="active">Dashboard</li>
			</ol>
			<?php endif;?>
		</div>
		<!-- /.col-lg-12 -->
	</div>
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
	<!-- ============================================================== -->
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	
	
	<div class="row laptop">
		<div class="col-lg-12">
			<div class="panel panel-default block2">
				<div class="panel-heading text-center put-relative" style="padding: 25px 0px;">
					<ul class="patient-tab-ul">
						<li class="active">
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
						
						<li class="">
							<a href="<?php echo base_url('administrator/dashboard/oprtr_image_today'); ?>">
								<strong>Image Upload</strong>
								Operator
							</a>
						</li>
						<?php endif;endif; ?>
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
								<div class="date-to-date-search">
									<div class="row">
										<div class="col-lg-9"></div>
									</div>
								</div>
								<div class="search-input-bx" style="width: 60px;">
									<span style="width: 60px;text-transform: uppercase;display: inline-block;background: #1B75BC;color: #FFF;border-radius: 2px;text-align: center;font-size: 12px;padding: 3px 0;margin-top: 5px;cursor:pointer;" onclick="searchFilter()">Search</span>
								</div>
								<!--<div class="search-input-bx" style="width: 335px;">
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
								</div>-->
								<div class="search-input-bx">
									<div class="col-lg-3"><strong class="filter-label">Search </strong></div>
									<div class="col-lg-9">
										<input type="text" class="form-control inline-src-right" id="keywords" placeholder="Search here...." />
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
											<th>ID</th>
											<th>Name</th>
											<th>Gender</th>
											<th>Guidebook</th>
											<!--<th>ORG. Center</th>-->
											<th>Phone</th>
											<!--<th>Date Of Birth</th>-->
											<th>Age</th>
											<!--<th>Register Date</th>
											<th>Submitted By</th>-->
											<th style="width:5%;">Action</th>
											<th>Visits</th>
											<th>Print QR Code</th>
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
											<!--<td><?php echo $item['orgcenter_name']; ?></td>-->
											<td><?php echo $item['patient_guide_book']; ?></td>
											<td><?php echo $item['patient_phone']; ?></td>
											<!--<td><?php echo $item['patient_dateof_birth']; ?></td>-->
											<td><?php echo $item['patient_age']; ?></td>
											<!--<?php if($item['patient_form_version'] == 'V1'): ?>
											<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
											<?php else: ?>
											<!--<td>
											<?php echo date("d M, Y", strtotime($item['patient_registration_date'])); ?>
											</td>
											<td><?php 
											if($item['patient_create_date']):
											echo date("d M, Y", strtotime($item['patient_create_date'])); 
											endif; 
											?>
											
											</td>
											<?php endif; ?>
											<td class="text-center"><?php echo get_admitted_by($item['patient_admitted_by'], $item['patient_admitted_user_type'], $item['patient_admitted_user_syncid']); ?></td>-->
											<td class="text-center">
												<a href="<?php echo base_url('patients/edit/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
												<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
												<a data-item="<?php echo $item['patient_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-trash"></i></a>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<!--<a href="<?php echo base_url('patients/visit/all/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>-->
												<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
												<a href="<?php echo base_url('patients/visit/all/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
												<?php else: ?>
												<a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
												
												<?php endif; ?>
											</td>
											<td class="text-center">
												<!--<a target="_blank" href="<?php echo base_url('patients/moneyreceipt/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>-->
												<h6 class = "qr-print" href="" style="color: #FFF;font-size:14px;background:#1B75BC;padding:4px 6px;display: inline;"><i class="fa fa-print"></i></h6>
												<input type="hidden" id = "entry" value="<?php echo $item['patient_entryid'];?>" name="" />
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
	
	<?php if ($this->session->userdata('user_type') === 'Operator'):?>
	<div class="row mobile">
		<div class="col-lg-12">
			<div class="panel panel-default block2">
				<div class="panel-heading text-center put-relative" style="padding: 25px 0px;">
					<ul class="patient-tab-ul">
						<li class="active">
							<a href="<?php echo base_url('administrator/dashboard/shw/todays'); ?>">
								<strong>Todays</strong>
								Patients
							</a>
						</li>
					
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
						<div class="table-responsive">
							<div><span style="display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;"><strong>Total :</strong> <span id="totalPatients"><?php echo $total_items; ?></span></span></div>
							<div class="top-search-filter-section">
								<?php 
									$attr = array('class' => 'form-horizontal form-material', 'id' => 'filterByDate');
									echo form_open('', $attr);
								?>
								<div class="date-to-date-search">
									<div class="row">
										<div class="col-lg-9"></div>
									</div>
								</div>
								<div class="search-input-bx" style="width: 60px;">
									<span style="width: 60px;text-transform: uppercase;display: inline-block;background: #1B75BC;color: #FFF;border-radius: 2px;text-align: center;font-size: 12px;padding: 3px 0;margin-top: 5px;cursor:pointer;" onclick="searchFilter()">Search</span>
								</div>
								
								
									<div class="col-lg-3"><strong class="filter-label">Search </strong></div>
									<div class="col-lg-9">
										<input type="text" class="form-control inline-src-right" id="keywords" placeholder="Search here...." />
									</div>
								
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<?php if ($this->session->userdata('user_type') === 'Operator'):?>
								<div id="postList1">
									<table class="table" style = "table-layout:fixed;">
										<thead>
											<tr>
												<th style = 'width: 5%'>SL.</th>
												<th style = 'width: 30%;word-wrap:break-word;'>ID</th>
												<th style = 'width: 43%;word-wrap:break-word;'>Name</th>
												<th style = 'width: 12%;word-wrap:break-word;'>Visits</th>
												<th style="width:12%;">QR</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$sl = 1;
												foreach($items as $item):
											?>
											<tr>
												<td><?php echo $sl; ?></td>
												<td style = 'word-wrap:break-word;'><?php echo $item['patient_entryid']; ?></td>
												<td style = 'word-wrap:break-word;'><?php echo $item['patient_name']; ?></td>
												<td><a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a></td>
												<td>
												<!--<a href="<?php echo base_url('patients/edit/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>-->
												<h6 class = "qr-print" href="" style="color: #FFF;font-size:14px;background:#1B75BC;padding:4px 6px;display: inline;"><i class="fa fa-print"></i></h6>
												<input type="hidden" id = "entry" value="<?php echo $item['patient_entryid'];?>" name="" />
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
								<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif;?>
	
	<script >
		$(function(){
			$(".qr-print").click(function(){
			var bndrId =	$(this).next().val();
			 //alert(bndrId);
			 var width = 160;
				var height = 160;
				var divToPrint=document.getElementById('printqr');

				$.ajax({
					type : "POST",
					url : baseUrl + "register/qr_code",
					data : {id: bndrId},
					dataType : "json",
					success : function (data) {
						//alert(data.id);
						
						}
					});
					
				  //var newWin=window.open('','Print-Window');

				  //newWin.document.open();

				  document.write('<html><body class="loadQr" onload="window.print()"></body></html>');
				  $('.loadQr').qrcode({width: width,height: height,text: bndrId});

				  document.close();

				  setTimeout(function(){close();},10);
				  document.location.href = baseUrl+'administrator/dashboard';
			 
			});
		 
		});
	</script>
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
			//var center = $('#center').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pfilter/get_todays_patients/'+page_num,
				data:'page='+page_num+'&keywords='+keywords,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
						$('#postList1').html(data.content);
					}else
					{
						return false;
					}
				}
			});
		}
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>