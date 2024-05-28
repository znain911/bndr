<?php require_once APPPATH.'modules/common/header.php' ?>
<?php 
		// if($this->session->userdata('user_type') === 'Doctor'):
		
				// $ipaddress = $_SERVER['REMOTE_ADDR'];
			// //echo $ipaddress;
			// $doc_name= $this->session->userdata('full_name') ;
			// $ip = $this->Patient_model->get_ip($doc_name);
			// if($ip['doctor_login_ip'] !== $ipaddress){
				
				// $this->session->sess_destroy();
				// redirect('login/type/user',refresh);
			// }
		//endif;
	//$this->session->sess_destroy();?>
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-6 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-3 col-sm-12 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Patients</li>
			</ol>
			<ol class="breadcrumb" style = 'margin: 0% 2%;'>
				<input type="submit" value="Scan QR Code" onclick="myFunction()" data-toggle="modal" data-target=".bs-example-modal-sm"  style = '    background-color: #3c4451;color: white;'>
			</ol>
			
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
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row laptop">
		<div class="col-lg-12">
			<div class="add-href-unit">
				<strong style="margin-top:15px;" class="pull-left">PATIENTS</strong>
				<?php if ($this->session->userdata('user_type') !== 'Org Admin'  ):?>
				<?php if ($this->session->userdata('user_type') !== 'Doctor' ):
				if ($this->session->userdata('user_type') !== 'Foot Doctor' ):
				if ($this->session->userdata('user_type') !== 'Eye Doctor' ):?>
				<a href="<?php echo base_url('patients/create'); ?>" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW PATIENT</a>
				
				<a href="<?php echo base_url('patients/import'); ?>" class="add-vst-button pull-right" style="margin-right:15px;"><i class="fa fa-plus-square"></i> IMPORT EXCEL</a>
				<a href="<?php echo base_url('patients/export/excel'); ?>" class="add-vst-button pull-right" style="margin-right:15px;"><i class="fa fa-plus-square"></i> EXPORT EXCEL</a>
				<a href="<?php echo base_url('patients/export/csv'); ?>" class="add-vst-button pull-right" style="margin-right:15px;"><i class="fa fa-plus-square"></i> EXPORT CSV</a>
				<?php endif;endif;?>
				<?php endif;endif;?>
			</div>
			<div class="panel panel-default block2">
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body">
						<div class="table-responsive put-relative">
							<div><span style="display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;"><strong>Total :</strong> <span id="totalPatients"><?php echo $total_items; ?></span></span></div>
							<div class="top-search-filter-section">
								<?php 
									$attr = array('class' => 'form-horizontal form-material', 'id' => 'filterByDate');
									echo form_open('', $attr);
								?>
								<?php if($this->session->userdata('user_type') !== 'Doctor'):
										if($this->session->userdata('user_type') !== 'Foot Doctor'):	
											if($this->session->userdata('user_type') !== 'Eye Doctor'):?>
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
								<?php if ($this->session->userdata('user_type') === 'Administrator' ):?>
								<div class="search-input-bx" style="width: 335px;">
									<div class="col-lg-5 text-right"><strong class="filter-label">Center </strong></div>
									<div class="col-lg-7">
										<select id="center" class="form-control inline-src-right">
											<option value="" selected="selected">Select Center</option>
											<?php 
												$centers = $this->Patient_model->get_center_list();
												foreach($centers as $center):
											?>
											<option value="<?php echo $center['orgcenter_id']; ?>"><?php echo $center['orgcenter_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<?php endif;?>
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
								<?php if ($this->session->userdata('user_type') === 'Administrator' ):?>
								<div class="search-input-bx">
									<div class="col-lg-3"><strong class="filter-label">Search </strong></div>
									<div class="col-lg-9">
										<input type="text" class="form-control inline-src-right" id="keywords" placeholder="Search ID/Name/Phone" <?php echo (isset($src_input))? 'value="'.$src_input.'"' : null; ?> />
									</div>
								</div>
								<?php endif;endif;endif;endif;?>
								<?php echo form_close(); ?>
								<div style="clear:both"></div>
							</div>
							<div id="postList">
								<table class="table">
									<thead>
										<tr>
											<th>SL.</th>
											<?php if($this->session->userdata('user_type') !== 'Doctor'):
											if($this->session->userdata('user_type') !== 'Foot Doctor'):
											if($this->session->userdata('user_type') !== 'Eye Doctor'): ?>
											<th>ID</th>
											<?php endif; endif;endif;?>
											<?php if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
											<th>Visits</th>
											<?php endif;?>
											<th>Gender</th>
											<th>Name</th>
											<th>ORG. Center</th>
											<th>Phone</th>
											<?php //if($this->session->userdata('user_type') !== 'Doctor'):
											//if($this->session->userdata('user_type') !== 'Foot Doctor'):
											//if($this->session->userdata('user_type') !== 'Eye Doctor'): ?>
											<!--<th>Date Of Birth</th>-->
											<?php // endif;endif;endif;?>
											<th>Age</th>
											<?php if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
											<th>First visit Date</th>
											<?php else:?>
											
											<th>Register Date</th>
											<?php endif;?>
											<?php if($this->session->userdata('user_type') !== 'Doctor'): 
											if($this->session->userdata('user_type') !== 'Foot Doctor'):
											if($this->session->userdata('user_type') !== 'Eye Doctor'):?>
											<th>Submitted By</th>
											
											<th style="width:7%;">Action</th>
											
											<th>Visits</th>
											<!--<th>Receipt</th>-->
											<?php endif;endif;endif;?>
										</tr>
									</thead>
									<tbody>
										<?php
											$sl = 1;
											foreach($items as $item):
										?>
										<tr>
											<td><?php echo $sl; ?></td>
											<?php if($this->session->userdata('user_type') === 'Doctor'||$this->session->userdata('user_type') === 'Foot Doctor'||$this->session->userdata('user_type') === 'Eye Doctor'): ?>
											<td class="text-center">
												<!--<a href="<?php echo base_url('patients/progress/add/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>-->
												<a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
											</td>
											<?php endif;?>
											<?php if($this->session->userdata('user_type') !== 'Doctor'): 
											if($this->session->userdata('user_type') !== 'Foot Doctor'):
											if($this->session->userdata('user_type') !== 'Eye Doctor'):?>
											<td><?php echo $item['patient_entryid']; ?></td>
											<?php endif;endif;endif;?>
											<td><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
											<td><?php echo $item['patient_name']; ?></td>
											<td><?php echo $item['orgcenter_name']; ?></td>
											<td><?php echo $item['patient_phone']; ?></td>
											<?php //if($this->session->userdata('user_type') !== 'Doctor'):
												//if($this->session->userdata('user_type') !== 'Foot Doctor'):
												//if($this->session->userdata('user_type') !== 'Eye Doctor'):	?>
											<!--<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
											<td><?php echo $item['patient_dateof_birth']; ?></td>-->
											<?php //endif;endif;endif;?>
											<td><?php echo $item['patient_age']; ?></td>
											<?php if($item['patient_form_version'] == 'V1'): ?>
											<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
											<?php else: ?>
											<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])); ?></td>
											<?php endif; ?>
											<?php if($this->session->userdata('user_type') !== 'Doctor'): 
													if($this->session->userdata('user_type') !== 'Foot Doctor'):
													if($this->session->userdata('user_type') !== 'Eye Doctor'):?>
											<td class="text-center"><?php echo get_admitted_by($item['patient_admitted_by'], $item['patient_admitted_user_type'], $item['patient_admitted_user_syncid']); ?></td>
											
											<td class="text-center">
												<a href="<?php echo base_url('patients/edit/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
												<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
												<a data-item="<?php echo $item['patient_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-trash"></i></a>
												<?php endif;?>
											</td>
											
											<td class="text-center">
												<!--<a href="<?php echo base_url('patients/visit/all/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>-->
												<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
												<a href="<?php echo base_url('patients/visit/all/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
												<?php else: ?>
												<a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
												
												<?php endif;  ?>
												
											</td>
											
											<!--<td class="text-center">
												<a target="_blank" href="<?php echo base_url('patients/moneyreceipt/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
											</td>-->
											<?php endif;endif;endif; ?>
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
	
	<div class="row mobile">
		<div class="col-lg-12">
			<div class="add-href-unit">
				<strong style="margin-top:15px;" class="pull-left">PATIENTS</strong>
			</div>
			<?php if ($this->session->userdata('user_type') !== 'Administrator' ):?>
			<div id="postList">
				<table class="table" style = "table-layout:fixed;">
					<thead>
						<tr>
							<th style = 'width: 5%'>SL.</th>
							<?php if ($this->session->userdata('user_type') === 'Operator' ):?>
							<th style = 'width: 30%;word-wrap:break-word;'>BNDR ID</th>
							<?php endif;?>
							
							<?php if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
							<th style = 'width: 15%;word-wrap:break-word;'>Visits</th>
							<?php endif;?>
							<th style = 'width: 43%;word-wrap:break-word;'>Name</th>
							<?php if ($this->session->userdata('user_type') === 'Operator' ):?>
							<th style = 'width: 12%;word-wrap:break-word;'>Visits</th>
							<th style="width:12%;">Action</th>
							<?php endif;?>
							<?php if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
							<th>First visit Date</th>
							<?php endif;?>
						</tr>
					</thead>
					<tbody>
						<?php
							$sl = 1;
							foreach($items as $item):
						?>
						<tr>
							<td><?php echo $sl; ?></td>
							<?php if ($this->session->userdata('user_type') === 'Operator' ):?>
							<td style = 'word-wrap:break-word;'><?php echo $item['patient_entryid']; ?></td>
							<?php endif;?>
							<?php if($this->session->userdata('user_type') === 'Doctor'||$this->session->userdata('user_type') === 'Foot Doctor'||$this->session->userdata('user_type') === 'Eye Doctor'): ?>
							<td class="text-center">
								<!--<a href="<?php echo base_url('patients/progress/add/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>-->
								<a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
							</td>
							<?php endif;?>
							<td style = 'word-wrap:break-word;'><?php echo $item['patient_name']; ?></td>
							<?php if ($this->session->userdata('user_type') === 'Operator' ):?>
							<td><a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a></td>
							<td><a href="<?php echo base_url('patients/edit/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a></td>
							<?php  endif;?>
							<?php if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
										
							<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])); ?></td>
							<?php  endif;?>
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
				data:'page='+page_num+'&keywords='+keywords+'&from_date='+from_date+'&to_date='+to_date+'&center='+center+'&year='+year+'&month='+month,
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