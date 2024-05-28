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
	<!--<video id="preview" style =" width:380px;height: 300px;margin:0px auto;display:none;"></video>-->
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
	<?php if( $this->session->userdata('user_type') === 'Operator'):?>
	<div class="mobile">
		<div  class = 'printContainer row mobile' style = " display: flex;justify-content: center;margin-top: 9%;">
			<input type="submit" value="Print QR Code" class = "qr-gn"  style = '    background-color: #1b75bc;color: white;padding: 8px 10px;'>
		</div>
	</div>
	<?php endif;?>
	<div class="row mobile" style = '<?php if($this->session->userdata('user_type') === 'Operator'){echo 'margin-top: 2%';}?>' >
	<?php if($this->session->userdata('user_type') === 'Doctor'):?>
		<?php if(has_no_case_history($patient_id)): ?>
		<div class="col-md-3" style='    display: flex;justify-content: center;    padding: 0px;'>
			
			<a href="<?php echo base_url('patients/visit/all/'.$patient_id.'/'.$entryid); ?>" class="add-vst-button pull-right" ><i class="fa fa-plus-square"></i> Prescription Entry</a>
			
		</div>
		<?php else: ?>
		<div class="col-md-2" style='    display: flex;justify-content: center;padding: 0px;'>
			
				
			<a href="<?php echo base_url('patients/progress/add/'.$patient_id.'/'.$entryid); ?>" style="" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> Prescription Entry</a>
		</div>
		<?php endif; ?>
		<?php elseif($this->session->userdata('user_type') === 'Foot Doctor' || $this->session->userdata('user_type') === 'Eye Doctor'):?>
		<div class="col-md-2" style='    display: flex;justify-content: center;padding: 0px;'>
			
				
			<a href="<?php echo base_url('patients/progress/add/'.$patient_id.'/'.$entryid); ?>" style="" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> Prescription Entry</a>
		</div>
	<?php else:?>
		<div class="col-md-2" style='    display: flex;justify-content: center;padding: 0px;'>
			
				
			<a href="<?php echo base_url('patients/visit/all/'.$patient_id.'/'.$entryid); ?>" style="" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> Data Entry</a>
		</div>
		<?php endif;?>
		<?php if(has_no_case_history($patient_id)): ?>
		<div class="col-md-3" style='    display: flex;justify-content: center;    padding: 0px;'>
			
			<a href="<?php echo base_url('patients/visit/image_visit/'.$patient_id.'/'.$entryid); ?>" class="add-vst-button pull-right" ><i class="fa fa-plus-square"></i> CASE HISTORY IMAGE</a>
			
		</div>
		<?php endif; ?>
		
		<div class="col-md-3" style='    display: flex;justify-content: center;    padding: 0px;'>
			<a href="<?php echo base_url('patients/progress/image_progress/'.$patient_id.'/'.$entryid); ?>" style="margin-right: 10px;" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> PROGRESS REPORT IMAGE</a>
			
		</div>
		
	</div>
	
	<div class="row laptop" style = '' >
	<?php if($this->session->userdata('user_type') === 'Doctor'):?>
		<?php if(has_no_case_history($patient_id)): ?>
		<div class="col-md-3" style='    display: flex;justify-content: center;    padding: 0px;'>
			
			<a href="<?php echo base_url('patients/visit/all/'.$patient_id.'/'.$entryid); ?>" class="add-vst-button pull-right" ><i class="fa fa-plus-square"></i> Prescription Entry</a>
			
		</div>
		
		<?php else: ?>
		<div class="col-md-2" style='    display: flex;justify-content: center;padding: 0px;'>
			
				
			<a href="<?php echo base_url('patients/progress/add/'.$patient_id.'/'.$entryid); ?>" style="" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> Prescription Entry</a>
		</div>
		
		<?php endif; ?>
		<?php elseif($this->session->userdata('user_type') === 'Foot Doctor' || $this->session->userdata('user_type') === 'Eye Doctor'):?>
		<div class="col-md-2" style='    display: flex;justify-content: center;padding: 0px;'>
			
				
			<a href="<?php echo base_url('patients/progress/add/'.$patient_id.'/'.$entryid); ?>" style="" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> Prescription Entry</a>
		</div>
	<?php else:?>
		<div class="col-md-2" style='    display: flex;justify-content: center;padding: 0px;'>
			
				
			<a href="<?php echo base_url('patients/visit/all/'.$patient_id.'/'.$entryid); ?>" style="" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> Data Entry</a>
		</div>
		
		<div class="col-md-2" style='    display: flex;justify-content: center;padding: 0px;'>
			
				
			<input type="submit" value="Print QR Code" class = "qr-gn"  style = '    background-color: #1b75bc;color: white;padding: 8px 15px;'>
		</div>
		<?php endif;?>
		<?php 
			$caseHistory = [];
			
			if($all_images){
			foreach($all_images as $key => $value) {
				
				if($value['visit_type'] === 'Case History' ) {
					array_push($caseHistory, [$key => $value]);
				}
				
			}
			}
			$totalCH = count($caseHistory);
		//print_r($all_images);
		 if(has_no_case_history($patient_id)): 
		if($totalCH < 8): ?>
		<div class="col-md-3" style='    display: flex;justify-content: center;    padding: 0px;'>
			
			<a href="<?php echo base_url('patients/visit/image_visit/'.$patient_id.'/'.$entryid); ?>" class="add-vst-button pull-right" ><i class="fa fa-plus-square"></i> CASE HISTORY IMAGE</a>
			
		</div>
		<?php endif;endif; ?>
		
		<div class="col-md-3" style='    display: flex;justify-content: center;    padding: 0px;'>
			<a href="<?php echo base_url('patients/progress/image_progress/'.$patient_id.'/'.$entryid); ?>" style="margin-right: 10px;" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> PROGRESS REPORT IMAGE</a>
			
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="add-href-unit">
				<strong style="margin-top:15px;" class="pull-left">PATIENT VISITS (image)</strong>
				
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
								
								
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<div id="postList">
								<table class="table">
									<thead>
										<tr>
											<th>SL.</th>
											<th>Type</th>
											
											<th>Visit date</th>
											<th>Visit Doctor</th>
											<th>Center Name</th>
											
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sl = 1;
											if(count($images) !== 0):
											if($foot): ?>
											<tr>
												<td class="text-center"><?php echo $sl; ?></td>
												<td class="text-center"><?php echo $foot['visit_type']; ?></td>
												<td class="text-center"><?php
												if (substr_count( $foot['visit_date'],"/") === 2){
													list($day, $month,$year) = explode('/', $foot['visit_date']);
													$fnvd= $year.'-'.$month.'-'.$day;
													echo date("d M, Y", strtotime($fnvd)); 
												}else{
													echo date("d M, Y", strtotime($foot['visit_date'])); 
												} ?>
												
												</td>
												<td class="text-center"><?php 
														echo $foot['foot_doctor'].'(Foot Doctor)';
													?>
												
												</td>
												<td class="text-center"><?php echo $foot['orgcenter_name']; ?></td>
												
												<td class="text-center">
													
														<a href="<?php echo base_url('caseHistory/'.$foot['patient_id'].'/'.$foot['image_name']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
													
												</td>
												
											</tr>
										<?php 	
										$sl++;
										endif;
												if($eye):
										?>
											<tr>
												<td class="text-center"><?php echo $sl; ?></td>
												<td class="text-center"><?php echo $eye['visit_type']; ?></td>
												<td class="text-center"><?php 
												if (substr_count( $eye['visit_date'],"/") === 2){
													list($day, $month,$year) = explode('/', $eye['visit_date']);
													$fnvd= $year.'-'.$month.'-'.$day;
													echo date("d M, Y", strtotime($fnvd)); 
												}else{
													echo date("d M, Y", strtotime($eye['visit_date'])); 
												}
												?></td>
												<td class="text-center"><?php 
														echo $eye['eye_doctor'].'(Eye Doctor)';
													?>
												
												</td>
												<td class="text-center"><?php echo $eye['orgcenter_name']; ?></td>
												
												<td class="text-center">
													
														<a href="<?php echo base_url('caseHistory/'.$eye['patient_id'].'/'.$eye['image_name']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
													
												</td>
												
											</tr>
										<?php $sl++;
										endif;
										foreach($images as $image):
										?>
										<tr>
											<td class="text-center"><?php echo $sl; ?></td>
											<td class="text-center"><?php echo $image['visit_type']; ?></td>
											<td class="text-center"><?php 
											if (substr_count( $image['visit_date'],"/") === 2){
													list($day, $month,$year) = explode('/', $image['visit_date']);
													$fnvd= $year.'-'.$month.'-'.$day;
													echo date("d M, Y", strtotime($fnvd)); 
												}else{
													echo date("d M, Y", strtotime($image['visit_date'])); 
												}

											?></td>
											<td class="text-center"><?php 
												if($image['eye_doctor']){
													echo $image['eye_doctor'].'(Eye Doctor)';
												}elseif($image['foot_doctor']){
													echo $image['foot_doctor'].'(Foot Doctor)';
												}else{
													echo $image['doctor_name']; 
												}
												
												?>
											
											</td>
											<td class="text-center"><?php echo $image['orgcenter_name']; ?></td>
											
											<td class="text-center">
												<?php if($image['visit_type'] === 'Progress'):?>
													<a href="<?php echo base_url('patients/progress/p_image/'.$image['patient_id'].'/'.$entryid.'/'.$image['visit_number']); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
												<?php else:?>
													<a href="<?php echo base_url('patients/visit/ch_image/'.$image['patient_id'].'/'.$entryid); ?>" style="color: #FFF;font-size:14px;background:#0a0;padding:3px 6px;"><i class="fa fa-eye"></i></a>
												<?php endif;?>
											</td>
											
										</tr>
										<?php 
											$sl++;
											endforeach;
											else:
										?>
										<tr><td colspan="13" class="text-center">No Image Found.</td></tr>
										<?php endif; ?>
									</tbody>
								</table>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="add-href-unit">
				<strong style="margin-top:15px;" class="pull-left">PATIENT VISITS (DATA ENTRY)</strong>
				
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
								
								
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<div id="postList">
								<table class="table">
									<thead>
										<tr>
											<th>SL.</th>
											<th>Type</th>
											
											<th>Visit date</th>
											<th>Visit Doctor</th>
											<th>Center Name</th>
											
											<th>Action</th>
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
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['visit_admit_date'])); ?></td>
											<td class="text-center"><?php echo $item['visit_doctor']; ?></td>
											<td class="text-center"><?php echo $item['orgcenter_name']; ?></td>
											
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
				  //document.location.href = baseUrl+'patients/visit/entry_type/'+<?php echo $patient_id;?>+'/'+bndrId;
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