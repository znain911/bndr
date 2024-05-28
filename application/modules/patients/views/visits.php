<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-12 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Patients</li>
				<li class="active">Visits</li>
			</ol>
			<ol class="breadcrumb" style = 'margin: 0% 2%;'>
				<input type="submit" value="Scan QR Code" onclick="myFunction()" data-toggle="modal" data-target=".bs-example-modal-sm"  style = '    background-color: #3c4451;color: white;'>
			</ol>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<input type="hidden" id = "entry" value="<?php echo $entryid;?>" name="" />
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
	
	<div class="row Ovisit">
		<div class="col-lg-12">
			<div class="add-href-unit">
				<strong style="margin-top:15px;" class="pull-left">PATIENT VISITS</strong>
				<a href="<?php echo base_url('patients/progress/add/'.$patient_id.'/'.$entryid); ?>" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW PROGRESS REPORT</a>
				<?php if(has_no_case_history($patient_id)): ?>
				<a href="<?php echo base_url('patients/visit/add/'.$patient_id.'/'.$entryid); ?>" class="add-vst-button pull-right" style="margin-right: 10px;"><i class="fa fa-plus-square"></i> ADD NEW CASE HISTORY</a>
				<?php endif; ?>
				<?php if( $this->session->userdata('user_type') === 'Operator'):?>
				<input type="submit" value="Print QR Code" class = "qr-gn pull-right" id="qr-gn" style = '    background-color: #1b75bc;color: white;padding: 6px 10px;margin-right: 1%;'>
				<?php endif;?>
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
								<div class="date-to-date-search">
									<div class="row">
										<!--
										<div class="col-lg-3 text-right">
											<strong class="filter-label">Search By Date</strong>
										</div>
										-->
										<div class="col-lg-9">
											<strong class="inline-date-src to_label">From</strong>
											<input style="width:115px;text-align:center;" type="text" placeholder="yyyy-mm-dd" class="form-control datepicker inline-date-src" onchange="searchFilter()" id="fromDate" /> <strong class="inline-date-src to_label">TO</strong>
											<input style="width:115px;text-align:center;" type="text" placeholder="yyyy-mm-dd" class="form-control datepicker inline-date-src" onchange="searchFilter()" id="toDate" />
											<input type="hidden" id="gTid" value="<?php echo $patient_id; ?>" />
										</div>
									</div>
								</div>
								<div class="search-input-bx">
									<div class="col-lg-3"><strong class="filter-label">Search </strong></div>
									<div class="col-lg-9">
										<input type="text" class="form-control inline-src-right" id="keywords" onkeyup="searchFilter()" placeholder="Search here...." />
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
											<th>Type</th>
											<th>Visit No</th>
											<th>Duration Of DM</th>
											<th>Visit date</th>
											<th>Submitted by</th>
											<th>Log</th>
											<th>Fee Type</th>
											<th>Payment Status</th>
											<th>Action</th>
											<th>Receipt</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sl = 1;
											if(count($items) !== 0):
											foreach($items as $item):
										?>
										<tr>
											<td class="text-center"><?php echo $sl; ?></td>
											<td class="text-center"><?php echo str_replace('_', ' ', $item['visit_is']); ?></td>
											<td class="text-center"><?php echo $item['visit_serial_no']; ?></td>
											<td class="text-center"><?php echo $item['dhistory_duration_of_glucose']; ?></td>
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_date'])); ?></td>
											<td class="text-center"><?php echo get_admitted_by($item['visit_admited_by'], $item['visit_admited_by_usertype'], $item['visit_admited_by_usersyncid']); ?></td>
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_admit_date'])).' '.date("g:i A", strtotime($item['visit_admit_date'])); ?></td>
											<td class="text-center">
												<?php
													echo 'Electronic Follow Up Fee '.'(BDT'.$item['payment_patient_fee_amount'].')';
												?>
											</td>
											<td class="text-center">
												<?php if($item['payment_patient_status'] === '1'): ?>
													<strong style="color:#0A0">Paid</strong>
												<?php else: ?>
													<strong style="color:#F00">Unpaid</strong>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<?php if($item['visit_is'] == 'PROGRESS_REPORT'): ?>
												<a href="<?php echo base_url('patients/progress/edit/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
												<?php else: ?>
												<a href="<?php echo base_url('patients/visit/edit/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
												<?php endif; ?>
												<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
												<a data-item="<?php echo $item['visit_id']; ?>" data-patient="<?php echo $item['visit_patient_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;margin-right:5px;"><i class="fa fa-trash"></i></a>
												<?php endif; ?>
												<?php if($item['visit_is'] == 'PROGRESS_REPORT'): ?>
												<a href="<?php echo base_url('patients/progress/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
												<?php else: ?>
												<a href="<?php echo base_url('patients/visit/view/'.$item['visit_id'].'/'.$item['visit_patient_id'].'/'.$item['visit_entryid']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<?php if($item['visit_is'] == 'PROGRESS_REPORT'): ?>
												<a target="_blank" href="<?php echo base_url('patients/progress/moneyreceipt/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
												<?php else: ?>
												<a target="_blank" href="<?php echo base_url('patients/visit/moneyreceipt/'.$item['visit_id'].'/'.$item['visit_entryid'].'/'.$item['visit_patient_id']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
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
	
	<script >
		$(function(){
			$(".qr-gn").click(function(){
			 //alert('hello');
			 
				var bndrId =  $('#entry').val();
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
				  //document.location.href = baseUrl+'patients/visit/all/'+<?php echo $patient_id;?>+'/'+bndrId;
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
					var pid = $(this).attr('data-patient');
					$.ajax({
						type : "POST",
						url : baseUrl + "patients/visit/delete",
						data : {id:item, pid:pid},
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
			var gtid = $('#gTid').val();
			
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pfilter/get_patient_visits/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&from_date='+from_date+'&to_date='+to_date+'&gtid='+gtid,
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