<?php require_once APPPATH.'modules/common/header.php' ?>
	<div id="visitLoader" class="disable-select"><img src="<?php echo base_url('assets/login/tools/loader.gif'); ?>" alt="Proccessing....." /></div>
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-12 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Patients</li>
				<li class="active">Progress</li>
				<li class="active">Create</li>
			</ol>
			<input type="submit" value="Scan QR Code" onclick="myFunction()" data-toggle="modal" data-target=".scan"  class = 'laptop qr-gn-scan'  style = '    background-color: #3c4451;color: white;'>
			<input type="submit" value="Print QR Code" class = "qr-gn laptop"  style = '    background-color: #1b75bc;color: white;padding: 1px 10px;'>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<input type="hidden" id = "entry" value="<?php echo $patient_entry_id;?>" name="" />
	<?php 
			$patientinfo = $this->Visit_model->get_patientinfo($patient_id);
		?>
		
		<?php 
									//check user is operator
									$user_type = $this->session->userdata('user_type');
									if($user_type == 'Operator'){
										$operator_center_name = $this->session->userdata('user_org_center_name');
										$operator_center_id = $this->session->userdata('user_org_center_id');
									}elseif($user_type == 'Assistant'){
										$operator_center_name = $this->session->userdata('user_org_center_name');
										$operator_center_id = $this->session->userdata('user_org_center_id');
									}elseif($user_type == 'Doctor'){
										$operator_center_name = $this->session->userdata('user_org_center_name');
										$operator_center_id = $this->session->userdata('user_org_center_id');
									}else{
										$operator_center_name = null;
										$operator_center_id   = null;
									}
								?>
	<div class="modal fade scan" id = "myModal" style="display: none;height: 100%;">
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
	<div style = '' id = ''>
			<div class="panel panel-default block2 laptop">
		
				<div class="panel-heading text-center put-relative">PATIENT DETAILS 
					
				</div>
				
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body patient-details-pnl">
						<div class="media">
							<a class="pull-left" href="#">
								<img class="media-object dp img-circle" src="<?php echo base_url('assets/tools/default_avatar.png'); ?>" style="width: 100px;height:100px;">
							</a>
							<div class="media-body">
								<h4 class="media-heading"><?php echo $patientinfo['patient_name']; ?></h4>
								<p><strong>Gender : </strong> <?php echo ($patientinfo['patient_gender'] === '0')? 'Male' : 'Female'; ?></p>
								<p><strong>BNDR ID : </strong> <?php echo $patientinfo['patient_entryid']; ?></p>
								<p><strong>Patient Guide Book No : </strong> <?php echo $patientinfo['patient_guide_book']; ?></p>
							</div>
							<div class="media-body">
								<p><strong>phone Number : </strong> <?php echo $patientinfo['patient_phone']; ?></p>
								<p><strong>Address : </strong> <?php echo $patientinfo['patient_address']; ?></p>
								<p><strong>Age : </strong> <?php echo $patientinfo['patient_age']; ?></p>
							</div>
							<input type="hidden" name="patient_gender" value="<?php echo $patientinfo['patient_gender']; ?>" />
						</div>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default block2 mobile" style = "    margin-top: 10%;">
				<input type="submit" value="Scan QR Code" onclick="myFunction()" data-toggle="modal" data-target=".scan"  class="qr-gn-scan" style = '    background-color: #3c4451;color: white;'>
				<input type="submit" value="Print QR Code" class = "qr-gn"  style = '    background-color: #1b75bc;color: white;padding: 1px 10px;'>
				<div class="panel-heading text-center put-relative">PATIENT DETAILS 
					
				</div>
				<div class="panel-wrapper collapse in put-relative" aria-expanded="true">
					<div class="panel-body patient-details-pnl">
						<div class="media">
							<a class="pull-left" href="#">
								<img class="media-object dp img-circle" src="<?php echo base_url('assets/tools/default_avatar.png'); ?>" style="width: 100px;height:100px;">
							</a>
							<div class="media-body">
								<h4 class="media-heading"><?php echo $patientinfo['patient_name']; ?></h4>
								<p><strong>Gender : </strong> <?php echo ($patientinfo['patient_gender'] === '0')? 'Male' : 'Female'; ?></p>
								<p><strong>BNDR ID : </strong> <?php echo $patientinfo['patient_entryid']; ?></p>
								<p><strong>Patient Guide Book No : </strong> <?php echo $patientinfo['patient_guide_book']; ?></p>
							</div>
							<div class="media-body">
								<p><strong>phone Number : </strong> <?php echo $patientinfo['patient_phone']; ?></p>
								<p><strong>Address : </strong> <?php echo $patientinfo['patient_address']; ?></p>
								<p><strong>Age : </strong> <?php echo $patientinfo['patient_age']; ?></p>
							</div>
							<input type="hidden" name="patient_gender" value="<?php echo $patientinfo['patient_gender']; ?>" />
						</div>
					</div>
				</div>
			</div>
		<form method="post" id = 'upload_image' enctype = "multipart/form-data">
			
			<div class="container"  style = "    background-color: #7ea2a2;box-shadow: 0 -2px 7px rgb(5 29 103 / 70%);    margin-bottom: 10%;padding-bottom: 2%;">
				<div class="row">
					
					
					
					<div class="col-lg-6">
						<div class="form-group">
							<h4 class="control-label col-md-5" style = 'font-weight: bold;'>Visit Date</h4>
							<div class="col-md-7">
								<input type="text" name="finaltreat_date" value="<?php echo date("d/m/Y"); ?>" placeholder="DD/MM/YYYY" class="form-control text-center datepicker check-date-is-valid">
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<h3 class="col-sm-12" style = 'font-weight: bold;'>Personal Info,Family History & Glucose Intolerance <span style="color:#f00">*</span></h3>
					</div>
					<div class="col-sm-12">
						<input class="col-sm-12" type="file" accept=".jpg,.jpeg" capture="camera"  name="image1" id= "image_file1" />
					</div>
					
					<div class="col-sm-12" style="    margin-top: 2%;">
						<h3 class="col-sm-12" style = 'font-weight: bold;' >Complication/Comorbidity Complaints & Physical Examination</h3>
					</div>
					<div class="col-sm-12">
						<input class="col-sm-12" type="file" accept=".jpg,.jpeg" capture="camera"   name="image2" id= "image_file2" />
					</div>
					
					<div class="col-sm-12" style="    margin-top: 2%;">
						<h3 class="col-sm-12" style = "font-weight: bold;" >Foot Examination</h3>
					</div>
					<div class="col-sm-12">
						<input class="col-sm-12" type="file" accept=".jpg,.jpeg" capture="camera"   name="image3" id= "image_file3" />
					</div>
					<div class="col-sm-12" >
						<div class="form-group">
							<h4 class="control-label col-md-5" style="font-weight: bold" >Foot Examination Doctor </h4>
							<div class="col-md-7">
								<input type="text" class="form-control doctor-name-foot" name="foot_doctor_name" data-section="hidden-final-treatment-doctor" placeholder="Type name of doctor" />
								
									
							</div>
						</div>
					</div>
					
					<div class="col-sm-12" style="    margin-top: 2%;">
						<h3 class="col-sm-12" style = 'font-weight: bold;' >Diet & Physical Activity</h3>
					</div>
					<div class="col-sm-12">
						<input class="col-sm-12" type="file" accept=".jpg,.jpeg" capture="camera"  name="image4" id= "image_file4" />
					</div>
					
					<div class="col-sm-12" style="    margin-top: 2%;" >
						<h3 class="col-sm-12" style = 'font-weight: bold;' >Eye Examination</h3>
					</div>
					<div class="col-sm-12"> 
						<input class="col-sm-12" type="file" accept=".jpg,.jpeg" capture="camera"  name="image5" id= "image_file5" />
					</div>
					<div class="col-sm-12" >
						<div class="form-group">
							<h4 class="control-label col-md-5" style="font-weight: bold">Eye Examination Doctor</h4>
							<div class="col-md-7">
								<input type="text" class="form-control doctor-name-eye" name="eye_doctor_name" data-section="hidden-final-treatment-doctor" placeholder="Type name of doctor" />
								
									
							</div>
						</div>
					</div>
					
					<div class="col-sm-12" style="    margin-top: 2%;">
						<h3 class="col-sm-12" style = 'font-weight: bold;' >Laboratory Investigation</h3>
					</div>
					<div class="col-sm-12">
						<input class="col-sm-12" type="file" accept=".jpg,.jpeg" capture="camera"   name="image6" id= "image_file6" />
					</div>
					
					<div class="col-sm-12" style="    margin-top: 2%;">
						<h3 class="col-sm-12" style = 'font-weight: bold;' >Drug History</h3>
					</div>
					<div class="col-sm-12">
						<input class="col-sm-12" type="file" accept=".jpg,.jpeg" capture="camera"   name="image7" id= "image_file7" />
					</div>
					
					<div class="col-sm-12" style="    margin-top: 2%;">
						<h3 class="col-sm-12" style = 'font-weight: bold;' >Final Treatment</h3>
					</div>
					<div class="col-sm-12">
						<input class="col-sm-12" type="file" accept=".jpg,.jpeg" capture="camera"  name="image8" id= "image_file8" />
					</div>
					<div class="col-sm-12" >
						<div class="form-group">
							<h4 class="control-label col-md-5" style="font-weight: bold">Final Treatment Doctor</h4>
							<div class="col-md-7">
								<input type="text" class="form-control src-doctor-name-final-treatment" name="finaltreat_doctor_name" data-section="hidden-final-treatment-doctor" placeholder="Type name of doctor" />
								
									<input type="hidden" name="visit_center_id" id="hiddenVisitCenterId" value="<?php echo ($operator_center_id !== null)? $operator_center_id : null; ?>" />
							</div>
						</div>
					</div>
					
					<div class="col-sm-12">
						<div class="col-sm-6">
							<input type="submit" style="padding: 3%;font-weight: bold;margin-top: 2%;" name="upload" id= "upload" value = "Submit"/>
						</div>
					</div>
					
				</div>
			</div>
		</form>
		<div id="uploaded_image">  
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
				  //document.location.href = baseUrl+'patients/visit/image_visit/'+<?php echo $patient_id;?>+'/'+bndrId;
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
    		$('.scan').modal('hide');
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
		$('#upload_image').on('submit', function(e){  
           e.preventDefault();  
		   var pid = <?php echo $patient_id; ?>;
		   
		   
		   if($('#image_file1').val() == '')  
		   {  
				alert("Please Select a File for Picture 1");  
		   }  
		   else  
		   {  
				$('#visitLoader').show();
				$.ajax({  
					 url: baseUrl + "patients/visit/image/" + pid,   
					 method:"POST",  
					 data:new FormData(this),  
					 contentType: false,  
					 cache: false,  
					 processData:false,  
					 success:function(data)  
					 {  
					 $('#visitLoader').hide();
						  $('#uploaded_image').append(data);  
						  //alert(data); 
						  //$('#image_file1').hide();
					 }  
				});  
		   }
		   
      }); 
		
		});
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
			
			//get districts
			$(document).on('change', '#selectedDivision', function(){
				var division_id = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "register/get_districts",
					data : {division_id:division_id},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#selectedDistrict').html(data.content);
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
			
			//get upazilas
			$(document).on('change', '#selectedDistrict', function(){
				var district_id = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "register/get_upazilas",
					data : {district_id:district_id},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#selectedUpazila').html(data.content);
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
		$(document).ready(function(){
			$(document).on('click', '.sel-sympt', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.sel-hidden-dropdown').show();
				}else if(check_val == '0')
				{
					$('.sel-hidden-dropdown').hide();
				}else
				{
					$('.sel-hidden-dropdown').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-2', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.sel-hidden-dropdown-2').show();
				}else if(check_val == '0')
				{
					$('.sel-hidden-dropdown-2').show();
				}else
				{
					$('.sel-hidden-dropdown-2').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-4', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-5', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-2').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-2').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-6', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-3').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-3').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-7', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-4').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-4').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-8', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-5').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-5').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-9', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-9').hide();
				}
			});
			$(document).on('click', '.sel-sympt-10', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-10').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-10').hide();
				}
			});
			$(document).on('click', '.sel-sympt-11', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-11').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-11').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-4-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-5-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-2-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-2-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-6-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-3-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-3-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-7-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-4-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-4-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-8-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-5-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-5-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-9-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-9-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-9-cntr').hide();
				}
			});
			$(document).on('click', '.sel-sympt-10-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-10-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-10-cntr').hide();
				}
			});
			$(document).on('click', '.sel-sympt-11-cntr', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.input-row-fields-11-cntr').show();
				}else if(check_val == '0')
				{
					$('.input-row-fields-11-cntr').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-3', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '1')
				{
					$('.abnoirmal-type-keywords').hide();
					$('.abnoirmal-type-keywords').find('input:checkbox').prop("checked", false);
				}else if(check_val == '0')
				{
					$('.abnoirmal-type-keywords').show();
				}else
				{
					$('.abnoirmal-type-keywords').hide();
				}
			});
			
			$(document).on('click', '.sel-physical-activity', function(){
				var check_val = $(this).attr('data-value');
				if(check_val == '0')
				{
					$('.physical-activities-content').hide();
					$('#criteriaIncEight').html('');
				}else if(check_val == '1')
				{
					$('.physical-activities-content').show();
				}else
				{
					$('.physical-activities-content').hide();
				}
			});
			
			$(document).on('change', '.sel-gexam-height', function(){
				var getValue = $(this).val();
				if(getValue == 'ft/inch')
				{
					var content = '<div class="col-md-5" style="padding: 0;">'+
										'<select name="gexam_height_unit" class="form-control sel-gexam-height">'+
											'<option value="">Select Unit</option>'+
											'<option value="ft/inch" selected="selected">ft/inch</option>'+
											'<option value="Inch">Inch</option>'+
											'<option value="cm">cm</option>'+
										'</select>'+
									'</div>'+
									'<div class="col-md-3" style="padding: 0 7px;">'+
										'<input type="text" class="form-control check-with-decimel" name="gexam_height_value_ft" placeholder="ft" />'+
									'</div>'+
									'<div class="col-md-4" style="padding: 0;">'+
										'<input type="text" class="form-control check-with-decimel" name="gexam_height_value_inch" placeholder="inch" />'+
									'</div>';
					$('.general-examination-height').html(content);
				}else if(getValue == 'cm'){
					var content = '<div class="row">'+
										'<div class="col-md-7">'+
											'<select name="gexam_height_unit" class="form-control sel-gexam-height">'+
												'<option value="">Select Unit</option>'+
												'<option value="ft/inch">ft/inch</option>'+
												'<option value="Inch">Inch</option>'+
												'<option value="cm" selected="selected">cm</option>'+
											'</select>'+
										'</div>'+
										'<div class="col-md-5">'+
											'<input type="text" class="form-control check-with-decimel" name="gexam_height_value" placeholder="Height" />'+
										'</div>'+
									'</div>';
					$('.general-examination-height').html(content);
				}else if(getValue == 'Inch'){
					var content = '<div class="row">'+
										'<div class="col-md-7">'+
											'<select name="gexam_height_unit" class="form-control sel-gexam-height">'+
												'<option value="">Select Unit</option>'+
												'<option value="ft/inch">ft/inch</option>'+
												'<option value="Inch" selected="selected">Inch</option>'+
												'<option value="cm">cm</option>'+
											'</select>'+
										'</div>'+
										'<div class="col-md-5">'+
											'<input type="text" class="form-control check-with-decimel" name="gexam_height_value" placeholder="Height" />'+
										'</div>'+
									'</div>';
					$('.general-examination-height').html(content);
				}else{
					var content = '<div class="row">'+
										'<div class="col-md-7">'+
											'<select name="gexam_height_unit" class="form-control sel-gexam-height">'+
												'<option value="">Select Unit</option>'+
												'<option value="ft/inch">ft/inch</option>'+
												'<option value="Inch">Inch</option>'+
												'<option value="cm">cm</option>'+
											'</select>'+
										'</div>'+
										'<div class="col-md-5">'+
											'<input type="text" class="form-control check-with-decimel" name="gexam_height_value" placeholder="Height" />'+
										'</div>'+
									'</div>';
					$('.general-examination-height').html(content);
				}
			});
			
			$(document).on('click', '.sel-sympt-payment', function(){
				$('.payment-type-keywords').show();
			});
			
			$(document).on('click', '.sel-sympt-management', function(){
				$('#mangmntLifeStyle').change(function(){
					if(this.checked)
						$('.management-type-keywords').show();
					else
						$('.management-type-keywords').hide();

				});
			});
			
			$(document).on('click', '.phabit-check', function(){
				var check_val = $(this).attr('data-row');
				var main_row = $(this).attr('data-main-row');
				if(check_val == '1')
				{
					$('.phabit-amount-'+main_row).show();
				}else if(check_val == '2')
				{
					$('.phabit-amount-'+main_row).show();
				}else if(check_val == '3')
				{
					$('.phabit-amount-'+main_row).hide();
				}
			});
			
			$(document).on('click', '.prev-cooking-oil-check', function(){
				var check_val = $(this).attr('data-row');
				var main_row = $(this).attr('data-main-row');
				if(check_val == '1')
				{
					$('.prev-cooking-oil-amount-'+main_row).show();
				}else if(check_val == '2')
				{
					$('.prev-cooking-oil-amount-'+main_row).hide();
				}
			});
			
			$(document).on('click', '.crnt-cooking-oil-check', function(){
				var check_val = $(this).attr('data-row');
				var main_row = $(this).attr('data-main-row');
				if(check_val == '1')
				{
					$('.crnt-cooking-oil-amount-'+main_row).show();
				}else if(check_val == '2')
				{
					$('.crnt-cooking-oil-amount-'+main_row).hide();
				}
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 7;
			$(document).on('click', '.gexam-field-add-1', function(){
				var inp_name = $('#gexamFieldNameOne').val();
				var inp_value = $('#gexamFieldUnitOne').val();
				
				if(inp_name !== '' && inp_value !== '')
				{
					var content = '<div class="col-lg-4 general-examination put-relative">' +
									'<div class="form-group">' +
										'<label class="control-label col-md-5">'+inp_name+'</label>' +
										'<div class="col-md-3">' +
											'<input type="text" class="form-control" name="gexam_row_value_'+row+'" placeholder="'+inp_value+'" />' +
										'</div>' +
										'<div class="col-md-4">' +
											'<select name="gexam_row_unit_'+row+'" class="form-control">' +
												'<option value="cm">cm</option>' +
												'<option value="kg">kg</option>' +
												'<option value="mmHg">mmHg</option>' +
											'</select>' +
										'</div>' +
									'</div>' +
									'<input type="hidden" name="gexam_row[]" value="'+row+'" />' +
									'<input type="hidden" name="gexam_row_name_'+row+'" value="'+inp_name+'" />' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
								'</div>';
					$('#criteriaIncOne').append(content);
					$('#gexamFieldNameOne').val('');
					$('#gexamFieldUnitOne').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
			$(document).on('click', '.rmv-itm', function(){
				$(this).parent().remove();
			});
			$(document).on('click', '.rmv-itm-diatory-history', function(){
				$(this).parent().parent().remove();
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.lab-investigation', function(){
				var row = $('.lab-inv-item').length+1;
				var inp_name = $('#labInvestigationName').val();
				var inp_value = $('#labInvestigationUnit').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-6 laboratory-investigation lab-inv-item put-relative">' +
									'<div class="form-group">' +
										'<label class="control-label col-md-5">'+inp_name+'</label>' +
										'<div class="col-md-7">' +
											'<input type="text" class="form-control" name="labinv_row_value_'+row+'" placeholder="'+inp_value+'" />' +
										'</div>' +
									'</div>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<input type="hidden" name="labinv_row[]" value="'+row+'" />' +
									'<input type="hidden" name="labinv_row_name_'+row+'" value="'+inp_name+'" />' +
									'<input type="hidden" name="labinv_row_unit_'+row+'" value="'+inp_value+'" />' +
								'</div>';
					$('#criteriaIncTwo').append(content);
					$('#labInvestigationName').val('');
					$('#labInvestigationUnit').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.complication-add', function(){
				var row = $('.complication-comorbidity-rows').length + 1;
				var inp_name = $('#complicationName').val();
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-3 complication-comorbidity-rows put-relative">' +
										'<label><input type="checkbox" name="complication_'+row+'" value="'+inp_name+'">&nbsp;&nbsp;'+inp_name+'</label>' +
										'<input type="hidden" value="'+row+'" name="complication_row[]">' +
										'<span class="rmv-itm mdi mdi-delete"></span>' +
									'</div>';	
					$('#criteriaIncThree').append(content);
					$('#complicationName').val('');
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = $('.complication-comorbidity').length + 1;
			$(document).on('click', '.acute-complication-add', function(){
				var inp_name = $('#acuteComplicationName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4 complication-comorbidity put-relative">' +
										'<label><input type="checkbox" name="acute_complication_'+row+'" value="'+inp_name+'">&nbsp;&nbsp;'+inp_name+'</label>' +
										'<input type="hidden" value="'+row+'" name="acute_complication_row[]">' +
										'<span class="rmv-itm mdi mdi-delete"></span>' +
									'</div>';	
					$('#acuteCriteriaIncThree').append(content);
					$('#acuteComplicationName').val('');
					row++;
				}else
				{
					return false;
				}
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = $('.phabit-check').length + 1;
			$(document).on('click', '.phabit-add', function(){
				var inp_name = $('#phabitFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-md-15 col-sm-3 text-center put-relative" style="margin-bottom:15px;">'+
										'<label class="phabit-check"><input type="checkbox" name="phabit_row_name_'+row+'" value="'+inp_name+'"/>&nbsp;&nbsp;'+inp_name+'</label> &nbsp;&nbsp;'+
										'<input type="hidden" name="phabit_row[]" value="'+row+'" />'+
										'<span class="rmv-itm mdi mdi-delete"></span>' +
									'</div>';	
					$('#criteriaIncFour').append(content);
					$('#phabitFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 5;
			$(document).on('click', '.family-details-add', function(){
				var inp_name = $('#fmdetailsFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4" style="height:100px;margin-bottom:15px;">' +
									'<p><strong>'+inp_name+':</strong></p>' +
									'<p>' +
										'<label><input type="radio" name="fmdetails_'+row+'" value="Yes"/>&nbsp;&nbsp;Yes</label> &nbsp;&nbsp;' +
										'<label><input type="radio" name="fmdetails_'+row+'" value="No" />&nbsp;&nbsp;No</label> &nbsp;&nbsp;' +
										'<label><input type="radio" name="fmdetails_'+row+'" value="Not Known" />&nbsp;&nbsp;Not Known</label>' +
									'</p>' +
									'<input type="hidden" name="fmdetails_row[]" value="'+row+'" />' +
									'<input type="hidden" name="fmdetails_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#criteriaIncFive').append(content);
					$('#fmdetailsFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('keyup', '.prev-diatory-history-daily', function(){
				var inputValue = parseInt($(this).val()) || 0;
				if(inputValue > 10)
				{
					alert("Maximum value 10 is allowed!");
					$(this).val('');
					return false;
				}
			});
			$(document).on('keyup', '.prev-diatory-history-weekly', function(){
				var inputValue = parseInt($(this).val()) || 0;
				if(inputValue > 7)
				{
					alert("Maximum value 7 is allowed!");
					$(this).val('');
					return false;
				}
			});
			
			$(document).on('click', '.prev-diatory-history-field-add', function(){
				var inp_name = $("select#prevDiatoryHistroyFieldName option").filter(":selected").val();
				if(inp_name !== '')
				{
					var row = $('.dietary-hstr').length + 1;
					var content = '<div class="dietary-hstr">' +
									'<label class="control-label col-md-offset-2 col-md-2"><strong>'+row+'.</strong> '+inp_name+'</label>' +
									'<div class="col-md-2">' +
										'<input type="text" class="form-control prev-diatory-history-daily" data-imp-val-row="'+row+'" name="prev_diatory_history_daily_'+row+'" placeholder="Per Day" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control prev-diatory-history-weekly prev-diatory-history-weekly-'+row+'" data-imp-val-row="'+row+'" name="prev_diatory_history_weekly_'+row+'" placeholder="Per Week" />' +
									'</div>' +
									'<div class="col-lg-2 put-relative">'+
										'<span class="rmv-itm-diatory-history mdi mdi-delete" style="right:auto !important;left:-5px !important;top:5px !important"></span>' +
									'</div>'+
									'<div style="clear:both"></div>' +
									'<input type="hidden" name="prev_diatory_history_row[]" value="'+row+'" />' +
									'<input type="hidden" name="prev_diatory_history_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#criteriaIncSix').append(content);
					$(".prev-diatory-history-daily").keydown(function (e) {
						// Allow: backspace, delete, tab, escape, enter and .
						if ($.inArray(e.keyCode, [46, 8, 9, 27, 110, 190]) !== -1 ||
							 // Allow: Ctrl+A, Command+A
							(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
							 // Allow: home, end, left, right, down, up
							(e.keyCode >= 35 && e.keyCode <= 40)) {
								 // let it happen, don't do anything
								 return;
						}
						// Ensure that it is a number and stop the keypress
						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
							e.preventDefault();
						}
					});
					$(".prev-diatory-history-weekly").keydown(function (e) {
						// Allow: backspace, delete, tab, escape, enter and .
						if ($.inArray(e.keyCode, [46, 8, 9, 27, 110, 190]) !== -1 ||
							 // Allow: Ctrl+A, Command+A
							(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
							 // Allow: home, end, left, right, down, up
							(e.keyCode >= 35 && e.keyCode <= 40)) {
								 // let it happen, don't do anything
								 return;
						}
						// Ensure that it is a number and stop the keypress
						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
							e.preventDefault();
						}
					});
					$('#prevDiatoryHistroyFieldName').val('');
				}else
				{
					return false;
				}
			});
			
			$(document).on('keyup', '.prev-diatory-history-daily', function(){
				var row_value = $(this).attr('data-imp-val-row');
				var daily_value = parseInt($(this).val());
				var weekly_value = parseInt(daily_value * 7);
				var monthly_value = weekly_value * 4;
				if(daily_value)
				{
					$('.prev-diatory-history-weekly-'+row_value).val(weekly_value);
					$('.prev-diatory-history-monthly-'+row_value).val(monthly_value);
				}else
				{
					$('.prev-diatory-history-weekly-'+row_value).val('');
					$('.prev-diatory-history-monthly-'+row_value).val('');
				}
			});
			
			$(document).on('keyup', '.prev-diatory-history-weekly', function(){
				var row_value = $(this).attr('data-imp-val-row');
				var weekly_value = parseInt($(this).val());
				var monthly_value = weekly_value * 4;
				if(weekly_value)
				{
					$('.prev-diatory-history-monthly-'+row_value).val(monthly_value);
				}else
				{
					$('.prev-diatory-history-monthly-'+row_value).val('');
				}
			});
			
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('click', '.crnt-diatory-history-field-add', function(){
				var inp_name = $("select#crntDiatoryHistroyFieldName option").filter(":selected").val();
				if(inp_name !== '')
				{
					var content = '<div class="dietary-hstr put-relative">' +
									'<label class="control-label col-md-2"><strong>'+row+'.</strong> '+inp_name+'</label>' +
									'<div class="col-md-2">' +
										'<input type="text" class="form-control crnt-diatory-history-daily" data-imp-val-row="'+row+'" name="crnt_diatory_history_daily_'+row+'" placeholder="Daily" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control crnt-diatory-history-weekly crnt-diatory-history-weekly-'+row+'" data-imp-val-row='+row+' name="crnt_diatory_history_weekly_'+row+'" placeholder="Weekly" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control crnt-diatory-history-monthly-'+row+'" name="crnt_diatory_history_monthly_'+row+'" placeholder="Monthly" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control" name="crnt_diatory_history_calorie_'+row+'" placeholder="Calorie" />' +
									'</div>' +
									'<div class="col-lg-2">' +
										'<input type="text" class="form-control" name="crnt_diatory_history_diet_'+row+'" placeholder="Diet Chart" />' +
									'</div>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<input type="hidden" name="crnt_diatory_history_row[]" value="'+row+'" />' +
									'<input type="hidden" name="crnt_diatory_history_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#crntCriteriaIncOne').append(content);
					$('#crntDiatoryHistroyFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
			
			$(document).on('keyup', '.crnt-diatory-history-daily', function(){
				var row_value = $(this).attr('data-imp-val-row');
				var daily_value = parseInt($(this).val());
				var weekly_value = parseInt(daily_value * 7);
				var monthly_value = weekly_value * 4;
				if(daily_value)
				{
					$('.crnt-diatory-history-weekly-'+row_value).val(weekly_value);
					$('.crnt-diatory-history-monthly-'+row_value).val(monthly_value);
				}else
				{
					$('.crnt-diatory-history-weekly-'+row_value).val('');
					$('.crnt-diatory-history-monthly-'+row_value).val('');
				}
			});
			
			$(document).on('keyup', '.crnt-diatory-history-weekly', function(){
				var row_value = $(this).attr('data-imp-val-row');
				var weekly_value = parseInt($(this).val());
				var monthly_value = weekly_value * 4;
				if(weekly_value)
				{
					$('.crnt-diatory-history-monthly-'+row_value).val(monthly_value);
				}else
				{
					$('.crnt-diatory-history-monthly-'+row_value).val('');
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 8;
			$(document).on('click', '.prev-cooking-oil-add', function(){
				var inp_name = $('#prevCookingOilFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4 put-relative" style="height:100px;margin-bottom:15px;">' +
									'<p><strong>'+inp_name+':</strong></p>' +
									'<p>' +
										'<label class="prev-cooking-oil-check" data-row="1" data-main-row="'+row+'"><input type="radio" name="prev_cookoil_'+row+'" value="Yes"/>&nbsp;&nbsp;Yes</label> &nbsp;&nbsp;' +
										'<label class="prev-cooking-oil-check" data-row="2" data-main-row="'+row+'"><input type="radio" name="prev_cookoil_'+row+'" value="No" />&nbsp;&nbsp;No</label> &nbsp;&nbsp;' +
									'</p>' +
									'<p class="prev-cooking-oil-amount-'+row+'" style="display:none"><input type="text" name="prev_cookoil_amount_'+row+'" placeholder="Leters/Month" class="form-control" /></p>' +
									'<input type="hidden" name="prev_cookoil_row[]" value="'+row+'" />' +
									'<input type="hidden" name="prev_cookoil_row_name_'+row+'" value="'+inp_name+'" />' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
								'</div>';	
					$('#criteriaIncSeven').append(content);
					$('#prevCookingOilFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 8;
			$(document).on('click', '.crnt-cooking-oil-add', function(){
				var inp_name = $('#crntCookingOilFieldName').val();
				
				if(inp_name !== '')
				{
					var content = '<div class="col-lg-4 put-relative" style="height:100px;margin-bottom:15px;">' +
									'<p><strong>'+inp_name+':</strong></p>' +
									'<p>' +
										'<label class="crnt-cooking-oil-check" data-row="1" data-main-row="'+row+'"><input type="radio" name="crnt_cookoil_'+row+'" value="Yes"/>&nbsp;&nbsp;Yes</label> &nbsp;&nbsp;' +
										'<label class="crnt-cooking-oil-check" data-row="2" data-main-row="'+row+'"><input type="radio" name="crnt_cookoil_'+row+'" value="No" />&nbsp;&nbsp;No</label> &nbsp;&nbsp;' +
									'</p>' +
									'<p class="crnt-cooking-oil-amount-'+row+'" style="display:none"><input type="text" name="crnt_cookoil_amount_'+row+'" placeholder="Leters/Month" class="form-control" /></p>' +
									'<span class="rmv-itm mdi mdi-delete"></span>' +
									'<input type="hidden" name="crnt_cookoil_row[]" value="'+row+'" />' +
									'<input type="hidden" name="crnt_cookoil_row_name_'+row+'" value="'+inp_name+'" />' +
								'</div>';	
					$('#criteriaIncCrntCooking').append(content);
					$('#crntCookingOilFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 4;
			var option_drugs = '<?php echo $option_drugs; ?>';
			$(document).on('click', '.prev-insuline-add', function(){
				var inp_name = $('#prevInsulinFieldName').val();
				if(inp_name !== '')
				{
					var content = '<div class="form-group previous-insuline put-relative">'+
										'<label class="control-label col-md-2"><strong>'+inp_name+'</strong></label>'+
										'<div class="col-md-4">'+
											'<select name="prev_insulin_row_type_'+row+'" class="form-control">'+ option_drugs +'</select>'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Morning" name="prev_insulin_row_value_morning_'+row+'" class="form-control">'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Noon" name="prev_insulin_row_value_noon_'+row+'" class="form-control">'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Night" name="prev_insulin_row_value_night_'+row+'" class="form-control">'+
										'</div>'+
										'<span class="rmv-itm mdi mdi-delete"></span>' +
										'<input type="hidden" name="prev_insulin_row[]" value="'+row+'" />'+
										'<input type="hidden" name="prev_insulin_row_name_'+row+'" value="'+inp_name+'" />'+
									'</div>';	
					$('#prevInsulineContainer').append(content);
					$('#prevInsulinFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 4;
			var option_drugs = '<?php echo $option_drugs; ?>';
			$(document).on('click', '.crnt-insuline-add', function(){
				var inp_name = $('#crntInsulinFieldName').val();
				if(inp_name !== '')
				{
					var content = '<div class="form-group previous-insuline put-relative">'+
										'<label class="control-label col-md-2"><strong>'+inp_name+'</strong></label>'+
										'<div class="col-md-4">'+
											'<select name="crnt_insulin_row_type_'+row+'" class="form-control">'+ option_drugs +'</select>'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Morning" name="crnt_insulin_row_value_morning_'+row+'" class="form-control">'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Noon" name="crnt_insulin_row_value_noon_'+row+'" class="form-control">'+
										'</div>'+
										'<div class="col-lg-2">'+
											'<input type="text" placeholder="Night" name="crnt_insulin_row_value_night_'+row+'" class="form-control">'+
										'</div>'+
										'<span class="rmv-itm mdi mdi-delete"></span>' +
										'<input type="hidden" name="crnt_insulin_row[]" value="'+row+'" />'+
										'<input type="hidden" name="crnt_insulin_row_name_'+row+'" value="'+inp_name+'" />'+
									'</div>';	
					$('#crntInsulineContainer').append(content);
					$('#crntInsulinFieldName').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('keyup', '#prevPhisicalActivityFieldUnit', function(){
				var inp_value = parseInt($(this).val()) || 0;
				if(inp_value > 1440)
				{
					alert("Maximum value 1440 is allowed!");
					$(this).val('');
				}
			});
			$(document).on('keyup', '#prevPhisicalActivityFieldUnitPerWeek', function(){
				var inp_value = parseInt($(this).val()) || 0;
				if(inp_value > 7)
				{
					alert("Maximum value 7 is allowed!");
					$(this).val('');
				}
			});
			$(document).on('click', '.prev-phisical-activity-field-add', function(){
				var inp_name = $("select#prevPhisicalActivityFieldName option").filter(":selected").val();
				var inp_value = $("#prevPhisicalActivityFieldUnit").val();
				var inp_value_per_week = $("#prevPhisicalActivityFieldUnitPerWeek").val();
				if(inp_name !== '' && inp_value !== '')
				{
					var content = '<div class="col-lg-3 put-relative">' +
										'<div style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 105px; padding: 10px;">' +
											'<p><strong>'+inp_name+':</strong></p>' +
											'<p>' +
												'<strong>'+inp_value+' Minutes/Day</strong>' +
												'<input type="hidden" name="prev_phisical_acitivity_value_'+row+'" value="'+inp_value+' Minutes/Day" />' +
											'</p>' +
											'<p>' +
												'<strong>'+inp_value_per_week+' Day/Week</strong>' +
												'<input type="hidden" name="prev_phisical_acitivity_value_per_week_'+row+'" value="'+inp_value_per_week+' Day/Week" />' +
											'</p>' +
											'<span class="rmv-itm mdi mdi-delete"></span>' +
											'<input type="hidden" name="prev_phisical_acitivity_row[]" value="'+row+'" />' +
											'<input type="hidden" name="prev_phisical_acitivity_row_name_'+row+'" value="'+inp_name+'" />' +
										'</div>' +
									'</div>';	
					$('#criteriaIncEight').append(content);
					$('#prevPhisicalActivityFieldName').val('');
					$('#prevPhisicalActivityFieldUnit').val('');
					$("#prevPhisicalActivityFieldUnitPerWeek").val('');
					row++;
				}else
				{
					return false;
				}
			});
			
			$("#prevPhisicalActivityFieldUnit").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27,  110, 190]) !== -1 ||
					 // Allow: Ctrl+A, Command+A
					(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
					 // Allow: home, end, left, right, down, up
					(e.keyCode >= 35 && e.keyCode <= 40)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('click', '.crnt-phisical-activity-field-add', function(){
				var inp_name = $("select#crntPhisicalActivityFieldName option").filter(":selected").val();
				var inp_value = $("#crntPhisicalActivityFieldUnit").val();
				if(inp_name !== '' && inp_value !== '')
				{
					var content = '<div class="col-lg-3 put-relative">' +
										'<div style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 80px; padding: 10px;">' +
											'<p><strong>'+inp_name+':</strong></p>' +
											'<p>' +
												'<strong>'+inp_value+' min/day</strong>' +
												'<input type="hidden" name="crnt_phisical_acitivity_value_'+row+'" value="'+inp_value+' min/day" />' +
											'</p>' +
											'<span class="rmv-itm mdi mdi-delete"></span>' +
											'<input type="hidden" name="crnt_phisical_acitivity_row[]" value="'+row+'" />' +
											'<input type="hidden" name="crnt_phisical_acitivity_row_name_'+row+'" value="'+inp_name+'" />' +
										'</div>' +
									'</div>';	
					$('#criteriaIncCrntPhisicalAct').append(content);
					$('#crntPhisicalActivityFieldName').val('');
					$('#crntPhisicalActivityFieldUnit').val('');
					row++;
				}else
				{
					return false;
				}
			});
			
			$("#crntPhisicalActivityFieldUnit").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 110, 190]) !== -1 ||
					 // Allow: Ctrl+A, Command+A
					(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
					 // Allow: home, end, left, right, down, up
					(e.keyCode >= 35 && e.keyCode <= 40)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('click', '.prev-medication-field-add', function(){
				var inp_name = $("#prevMedicationFieldName").val();
				var inp_value = $("#prevMedicationFieldUnit").val();
				if(inp_name !== '' && inp_value !== '')
				{	
					$.ajax({
						  type: "GET",
						  url: baseUrl + "patients/visit/drug_info",
						  dataType: "json",
						  data: {
							q: inp_name,
							inp_val: inp_value,
							inp_row: row
						  },
						  beforeSend: function() {
							$('#sponsorLoad').show();
						  },
						  success: function( data ) {
							if(data.status == 'ok')
							{
								$('#criteriaIncNine').append(data.content);
								$('#prevMedicTable').append(data.table_content);
								$('#prevMedicationFieldName').val('');
								$('#prevMedicationFieldUnit').val('');
								$('#sponsorLoad').hide();
								return false;
							}else
							{
								$('#prevMedicationFieldName').val('');
								$('#prevMedicationFieldUnit').val('');
								alert('Please select the right drug name!');
								$('#sponsorLoad').hide();
								return false;
							}
							
						  }
					});
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 1;
			$(document).on('click', '.crnt-medication-field-add', function(){
				var inp_name = $("#crntMedicationFieldName").val();
				var inp_value = $("#crntMedicationFieldUnit").val();
				
				if(inp_name !== '' && inp_value !== '')
				{	
					$.ajax({
						  type: "GET",
						  url: baseUrl + "patients/visit/drug_info_currentadvice",
						  dataType: "json",
						  data: {
							q: inp_name,
							inp_val: inp_value,
							inp_row: row
						  },
						  beforeSend: function() {
							$('#sponsorLoad2').show();
						  },
						  success: function( data ) {
							if(data.status == 'ok')
							{
								$('#criteriaIncCrntMedication').append(data.content);
								$('#crntMedicTable').append(data.table_content);
								$('#crntMedicationFieldName').val('');
								$('#crntMedicationFieldUnit').val('');
								$('#sponsorLoad2').hide();
								return false;
							}else
							{
								$('#crntMedicationFieldName').val('');
								$('#crntMedicationFieldUnit').val('');
								alert('Please select the right drug name!');
								$('#sponsorLoad2').hide();
								return false;
							}
							
						  }
					});
					row++;
				}else
				{
					return false;
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 2;
			$(document).on('click', '.prev-oads-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="oads_name_'+row+'" placeholder="Add OADs" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="oads_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="oads_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#prevOads').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.prev-insulin-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="prev_insulin_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>' +
									'<div class="col-lg-3"><input type="text" name="prev_insulin_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="prev_insulin_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#prevInsulin').append(content);
				$('.load-drugs-insulin').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_insulin",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.htn-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="anti_htn_name_'+row+'" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="anti_htn_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="anti_htn_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiHtnFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.lipids-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="lipids_name_'+row+'" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="lipids_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="lipids_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiLipidsFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.aspirine-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="aspirine_name_'+row+'" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="aspirine_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="aspirine_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#aspirineFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cardiac-medication-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="cardiac_medication_name_'+row+'" placeholder="Add Cardiac Medication" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="cardiac_medication_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="cardiac_medication_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#prevCardiacMedication').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.obesity-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="obesity_name_'+row+'" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="obesity_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="obesity_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiObesityFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.other-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="other_name_'+row+'" placeholder="Add Others" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="other_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="other_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#othersFields').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.htn-remove-htn', function(){
				$(this).parent().parent().remove();
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var row = 2;
			$(document).on('click', '.cntr-oads-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_oads_name_'+row+'" placeholder="Add OADs" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_oads_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 100%;float: left;">খাওয়ার</span>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_oads_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="মাঝে">মাঝে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_oads_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_oads_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_oads_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntOads').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-exercise-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-6"><input type="text" name="crnt_exercise_value_'+row+'" class="form-control" /></div>' +
									'<div class="col-lg-6"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="crnt_exercise_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntExercise').append(content);
				row++;
			});


			$(document).on('click', '.cntr-insulin-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_insulin_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs-insulin" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_insulin_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_insulin_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_insulin_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_insulin_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_insulin_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_insulin_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_insulin_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntInsulin').append(content);
				$('.load-drugs-insulin').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_insulin",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});


			$(document).on('click', '.cntr-cardiac-medication-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_cardiac_medication_name_'+row+'" placeholder="Add Insulin" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-3"><input type="text" name="crnt_cardiac_medication_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-2"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i> Remove</span></div>' +
									'<input type="hidden" name="crnt_cardiac_medication_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#crntCardiacMedication').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			$(document).on('click', '.cntr-htn-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_anti_htn_name_'+row+'" placeholder="Add Anti HTN" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_anti_htn_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_anti_htn_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_anti_htn_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_anti_htn_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_anti_htn_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_anti_htn_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_anti_htn_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiHtnFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-lipids-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_lipids_name_'+row+'" placeholder="Add Anti Lipids" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_lipids_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_lipids_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_lipids_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_lipids_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_lipids_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_lipids_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_lipids_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiLipidsFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-aspirine-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_aspirine_name_'+row+'" placeholder="Add Antiplatelets" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_aspirine_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_aspirine_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_aspirine_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_aspirine_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_aspirine_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_aspirine_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_aspirine_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#aspirineFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-obesity-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_obesity_name_'+row+'" placeholder="Add Anti-obesity" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_obesity_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_obesity_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_obesity_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_obesity_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_obesity_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_obesity_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_obesity_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#antiObesityFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.cntr-other-add-more-htn', function(){
				var content = '<div class="row-field">' +
									'<div class="col-lg-3"><input type="text" name="crnt_other_name_'+row+'" placeholder="Add Others" class="form-control load-drugs" /></div>' +
									'<div class="col-lg-2"><input type="text" name="crnt_other_value_'+row+'" placeholder="Dose" class="form-control" /></div>' +
									'<div class="col-lg-3" style="padding-top: 15px;">'+
										'<div class="inline-sc" style="width: 35%;">'+
										'<span style="display: block;width: 50%;float: left;">খাওয়ার</span>'+
										'<input type="text" name="crnt_other_condition_time_'+row+'" placeholder="" class="form-control" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;"></div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_other_condition_time_type_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="মিনিট">মিনিট</option>'+
												'<option value="ঘন্টা">ঘন্টা</option>'+
											'</select>'+
										'</div>'+
										'<div class="inline-sc" style="width: 20%;">'+
											'<select name="crnt_other_condition_apply_'+row+'" class="form-control" style="text-align: center;margin-top: -14px;">'+
												'<option value="আগে">আগে</option>'+
												'<option value="পরে">পরে</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-2" style="padding-top: 15px;">'+
										'<span style="display: block;width: 30%;float: left;">চলবে</span>'+
										'<input type="text" name="crnt_other_duration_'+row+'" style="float: left;width: 45%;height: 30px;margin-top: -10px;text-align: center;" class="form-control">'+
										'<div class="inline-sc" style="width: 22%;">'+
											'<select name="crnt_other_duration_type_'+row+'" class="form-control" style="text-align: center;margin-top: -15px;">'+
												'<option value="দিন">দিন</option>'+
												'<option value="মাস">মাস</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-1"><span class="htn-remove-htn" style="cursor:pointer"><i class="mdi mdi-delete"></i></span></div>' +
									'<input type="hidden" name="crnt_other_row[]" value="'+row+'" />' +
									'<div style="clear:both"></div>' +
								'</div>';	
				$('#othersFieldsCntr').append(content);
				$('.load-drugs').autocomplete({
				  source: function( request, response ) {
					$.ajax({
					  type: "GET",
					  url: baseUrl + "patients/visit/get_drugs",
					  dataType: "json",
					  data: {
						q: request.term
					  },
					  success: function( data ) {
						response( data.content);
					  }
					});
				  },
				  minLength: 1,
				  open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				  },
				  close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				  }
				});
				row++;
			});
			
			$(document).on('click', '.htn-remove-htn', function(){
				$(this).parent().parent().remove();
			});
			
		});
	</script>
	
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('.load-drugs').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_drugs",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			$('.load-drugs-insulin').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_insulin",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			//Load visit registration center
			$('.src-registration-center').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_registration_centers",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  select: function (event, ui) {
						$(this).val(ui.item.label); // display the selected text
						$("#hiddenRegistrationCenterId").val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			//load visit center
			$('.src-visit-center').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_visit_centers",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  select: function (event, ui) {
						$(this).val(ui.item.label); // display the selected text
						$("#hiddenVisitCenterId").val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			$(document).on('blur', '.src-visit-center', function(){
				var hiddenVal = $('#hiddenVisitCenterId').val();
				if(hiddenVal == '')
				{
					$(this).val('');
				}
			});
			$(document).on('blur', '.src-doctor-name-by-center', function(){
				var hiddenVal = $('#hidden-foot-examination-doctor').val();
				if(hiddenVal == '')
				{
					$(this).val('');
				}
			});
			$(document).on('blur', '.src-doctor-name', function(){
				var hiddenVal = $('#hidden-eye-examination-doctor').val();
				if(hiddenVal == '')
				{
					$(this).val('');
				}
			});
			$(document).on('blur', '.src-doctor-name-final-treatment', function(){
				var hiddenVal = $('#hidden-final-treatment-doctor').val();
				if(hiddenVal == '')
				{
					$(this).val('');
				}
			});
			
			//Load doctor list
			$('.src-doctor-name').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/load_doctors",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  select: function (event, ui) {
						var hiddenValue = $(this).attr('data-section');
						$(this).val(ui.item.label); // display the selected text
						$('#'+hiddenValue).val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			$('.src-doctor-name-final-treatment').autocomplete({
			  source: function( request, response ) {
				  var centerId = $('#hiddenVisitCenterId').val();
				  if(centerId){
					  $.ajax({
						  type: "GET",
						  url: baseUrl + "patients/visit/load_doctors_with_center_wise",
						  dataType: "json",
						  data: {
							q: request.term,
							centerId:centerId,
						  },
						  success: function( data ) {
							response( data.content);
						  }
					 });
				  }else{
					  alert('Please enter visit center');
					  $('.src-doctor-name-final-treatment:focus').val('');
				  }
			  },
			  select: function (event, ui) {
						var hiddenValue = $(this).attr('data-section');
						$(this).val(ui.item.label); // display the selected text
						$('#'+hiddenValue).val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
			
			$('.src-doctor-name-by-center').autocomplete({
			  source: function( request, response ) {
				  var centerId = $('#hiddenVisitCenterId').val();
				  if(centerId){
					  $.ajax({
						  type: "GET",
						  url: baseUrl + "patients/visit/load_doctors_with_center_wise",
						  dataType: "json",
						  data: {
							q: request.term,
							centerId:centerId,
						  },
						  success: function( data ) {
							response( data.content);
						  }
					 });
				  }else{
					  alert('Please enter visit center');
					  $('.src-doctor-name-by-center:focus').val('');
				  }
			  },
			  select: function (event, ui) {
						var hiddenValue = $(this).attr('data-section');
						$(this).val(ui.item.label); // display the selected text
						$('#'+hiddenValue).val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			// Cache selectors
			var lastId,
				topMenu = $("#stickyNavSection"),
				topMenuHeight = topMenu.outerHeight(),
				// All list items
				menuItems = topMenu.find("a"),
				// Anchors corresponding to menu items
				scrollItems = menuItems.map(function(){
				  var item = $($(this).attr("href"));
				  if (item.length) { return item; }
				});

			// Bind click handler to menu items
			// so we can get a fancy scroll animation
			menuItems.click(function(e){
			  var href = $(this).attr("href"),
				  offsetTop = href === "#" ? 0 : $(href).offset().top+1;
			  $('html, body').stop().animate({ 
				  scrollTop: offsetTop
			  }, 300);
			  e.preventDefault();
			});

			// Bind to scroll
			$(window).scroll(function(){
			   // Get container scroll position
			   var fromTop = $(this).scrollTop();
			   
			   // Get id of current scroll item
			   var cur = scrollItems.map(function(){
				 if ($(this).offset().top < fromTop)
				   return this;
			   });
			   // Get the id of the current element
			   cur = cur[cur.length-1];
			   var id = cur && cur.length ? cur[0].id : "";
			   
			   if (lastId !== id) {
				   lastId = id;
				   // Set/remove active class
				   menuItems
					 .parent().removeClass("active")
					 .end().filter("[href='#"+id+"']").parent().addClass("active");
			   }                   
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			var project1 = $('.sticky-sidebar').offset();
			var $window = $(window);
			
			$window.scroll(function() {
				if ( $window.scrollTop() >= project1.top) {
					$(".sticky-sidebar").addClass("sticky-active");
				}else{
					$(".sticky-sidebar").removeClass("sticky-active");
				}
			});			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('keyup', '.src-registration-center', function(){
				$('#hiddenRegistrationCenterId').val('');
			});
			$(document).on('keyup', '.src-visit-center', function(){
				$('#hiddenVisitCenterId').val('');
			});
			$(document).on('keyup', '.src-doctor-name-by-center', function(){
				$('#hidden-foot-examination-doctor').val('');
			});
			$(document).on('keyup', '.src-doctor-name', function(){
				$('#hidden-eye-examination-doctor').val('');
			});
			$(document).on('keyup', '.src-doctor-name-final-treatment', function(){
				$('#hidden-final-treatment-doctor').val('');
			});
			
			$(document).on('keyup', '.check-with-decimel', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,1})?$/)) {
					return true;
				} else {
					var getValue = $(this).val();
					$(this).val(roundOff(getValue));
				}
			});
			
			$(document).on('keyup', '.check-with-double-decimel', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,2})?$/)) {
					if(getFieldValue > 500)
					{
						alert("Maximum value 500 is allowed!");
						$(this).val(roundOffDoubleDecimel(0));
					}else{
						return true;
					}
				} else {
					var getValue = $(this).val();
					if(getValue > 500)
					{
						alert("Maximum value 500 is allowed!");
						$(this).val(roundOffDoubleDecimel(0));
					}else{
						$(this).val(roundOffDoubleDecimel(getValue));
					}
				}
			});
			
			$(document).on('keyup', '.check-with-single-number', function(){
				var getFieldValue = $(this).val();
				if (getFieldValue.match(/^(\d+)?([.]?\d{0,1})?$/)) {
					return true;
				} else {
					var getValue = $(this).val();
					$(this).val(roundOffsingleNumber(getValue));
				}
			});
			
			$(".check-alphanumeric-charactars").keydown(function (e) {
				// Allow: backspace, delete, tab, escape and enter
				if ($.inArray(e.keyCode, [46, 8, 9, 27,  110, 188, 32, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39) || (e.keyCode >= 65 && e.keyCode <= 90)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) || (e.keyCode < 65 || e.keyCode > 90)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
			$(".check-only-alphabetical-charactars").keydown(function (e) {
				// Allow: backspace, delete, tab, escape and enter
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 110, 188, 32, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39) || (e.keyCode >= 65 && e.keyCode <= 90)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 65 || e.keyCode > 90))) {
					e.preventDefault();
				}
			});
			
			$(document).on('keyup', '.check-less-from-sbp-sitting', function(){
				var getSbpSittingValue = roundOff($(this).val());
				var getDbpSittingValue = roundOff($('.sbp-sitting').val());
				if(getDbpSittingValue < 1){
					alert("Please insert Sitting SBP value then try again");
					$(this).val('');
				}else if(getSbpSittingValue > getDbpSittingValue){
					alert("Sitting DBP value can not be higher than sitting SBP value");
					$(this).val('');
				}
			});
			$(document).on('keyup', '.check-less-from-sbp-standing', function(){
				var getSbpStandingValue = roundOff($(this).val());
				var getDbpStandingValue = roundOff($('.sbp-standing').val());
				if(getDbpStandingValue < 1){
					alert("Please insert Standing SBP value then try again");
					$(this).val('');
				}else if(getSbpStandingValue > getDbpStandingValue){
					alert("Standing DBP value can not be higher than Standing SBP value");
					$(this).val('');
				}
			});
			
			$(document).on('change', '.check-date-is-valid', function(){
				var getValue = $(this).val();
				var splitDate = getValue.split('/');
				//alert(checkDate(splitDate[0], splitDate[1], splitDate[2]));
				if(checkDate(splitDate[0], splitDate[1], splitDate[2]) == 'YES')
				{
					$(this).val('');
				}
			});
		});
		
		function roundOff(decimelNumber) { 
            var theNumber = parseFloat(decimelNumber) || 0;
			var singlePlaces = theNumber.toFixed(1); 
			return singlePlaces;
        }
		function roundOffDoubleDecimel(decimelNumber) { 
            var theNumber = parseFloat(decimelNumber) || 0;
			if(theNumber > 500)
			{
				alert("Maximum value 500 is allowed!");
				theNumber = 0;
				return theNumber.toFixed(2);
			}else{
				var singlePlaces = theNumber.toFixed(2); 
				return singlePlaces;
			}
        }
		function roundOffsingleNumber(decimelNumber) { 
            var theNumber = parseFloat(decimelNumber) || 0;
			var singlePlaces = theNumber.toFixed(0); 
			return singlePlaces;
        } 
		function validateCode(string){
			var TCode = string;
			if( /[^a-zA-Z0-9]/.test( TCode ) ) {
			   alert('Input is not alphanumeric');
			   return false;
			}
			return true;     
		 }
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('html, body').animate({scrollTop: 0}, 1000);
		});
		function checkDate(day, month, year)
		{
			var regd = new RegExp("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})\$");

			var date = month + "/" + day + "/" + year;
			var date = new Date(date);
			var today = new Date();

			var vdob = regd.test(date);
			if(date.getDate() != day || (date.getTime()>today.getTime()))
			{
				return "YES";
			}else
			{
				return "NO";
			}
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.sel-sympt-diabetes-yes', function(){
				if($('input.checkbox-sympt-diabetes-yes').is(":checked"))
				{
					$('input.checkbox-sympt-diabetes-no').prop("checked", false);
					$('.diabetes-type-keywords').show();
					$('.diabetes-type-keywords').find('input:checkbox').prop("checked", false);
				}else{
					$('.diabetes-type-keywords').hide();
				}
			});
			
			$(document).on('click', '.sel-sympt-diabetes-no', function(){
				if($('input.checkbox-sympt-diabetes-no').is(":checked"))
				{
					$('input.checkbox-sympt-diabetes-yes').prop("checked", false);
					$('.diabetes-type-keywords').hide();
				}else{
					$('.diabetes-type-keywords').hide();
				}
			});
			
			/***Foot Examinations**/
			
			//Arteria Dorsalis Pedis Present
			$(document).on('click', '.arteria-dorsalis-predis-present-left', function(){
				if($('input.checkbox-arteria-dorsalis-predis-present-left').is(":checked"))
				{
					$('input.checkbox-arteria-dorsalis-predis-present-right').prop("checked", false);
				}
			});
			
			$(document).on('click', '.arteria-dorsalis-predis-present-right', function(){
				if($('input.checkbox-arteria-dorsalis-predis-present-right').is(":checked"))
				{
					$('input.checkbox-arteria-dorsalis-predis-present-left').prop("checked", false);
				}
			});
			
			//Arteria Dorsalis Pedis Absent
			$(document).on('click', '.arteria-dorsalis-predis-absent-left', function(){
				if($('input.checkbox-arteria-dorsalis-predis-absent-left').is(":checked"))
				{
					$('input.checkbox-arteria-dorsalis-predis-absent-right').prop("checked", false);
				}
			});
			
			$(document).on('click', '.arteria-dorsalis-predis-absent-right', function(){
				if($('input.checkbox-arteria-dorsalis-predis-absent-right').is(":checked"))
				{
					$('input.checkbox-arteria-dorsalis-predis-absent-left').prop("checked", false);
				}
			});
			
			//Posterior Tribila Present
			$(document).on('click', '.posterior-tribila-present-left', function(){
				if($('input.checkbox-posterior-tribila-present-left').is(":checked"))
				{
					$('input.checkbox-posterior-tribila-present-right').prop("checked", false);
				}
			});
			
			$(document).on('click', '.posterior-tribila-present-right', function(){
				if($('input.checkbox-posterior-tribila-present-right').is(":checked"))
				{
					$('input.checkbox-posterior-tribila-present-left').prop("checked", false);
				}
			});
			
			//Posterior Tribila Absent
			$(document).on('click', '.posterior-tribila-absent-left', function(){
				if($('input.checkbox-posterior-tribila-absent-left').is(":checked"))
				{
					$('input.checkbox-posterior-tribila-absent-right').prop("checked", false);
				}
			});
			
			$(document).on('click', '.posterior-tribila-absent-right', function(){
				if($('input.checkbox-posterior-tribila-absent-right').is(":checked"))
				{
					$('input.checkbox-posterior-tribila-absent-left').prop("checked", false);
				}
			});
			
			
			//Monofilament Present
			$(document).on('click', '.monofilament-present-left', function(){
				if($('input.checkbox-monofilament-present-left').is(":checked"))
				{
					$('input.checkbox-monofilament-present-right').prop("checked", false);
				}
			});
			
			$(document).on('click', '.monofilament-present-right', function(){
				if($('input.checkbox-monofilament-present-right').is(":checked"))
				{
					$('input.checkbox-monofilament-present-left').prop("checked", false);
				}
			});
			
			//Monofilament Absent
			$(document).on('click', '.monofilament-absent-left', function(){
				if($('input.checkbox-monofilament-absent-left').is(":checked"))
				{
					$('input.checkbox-monofilament-absent-right').prop("checked", false);
				}
			});
			
			$(document).on('click', '.monofilament-absent-right', function(){
				if($('input.checkbox-monofilament-absent-right').is(":checked"))
				{
					$('input.checkbox-monofilament-absent-left').prop("checked", false);
				}
			});
			
			//Tuning Fork Present
			$(document).on('click', '.tuning-fork-present-left', function(){
				if($('input.checkbox-tuning-fork-present-left').is(":checked"))
				{
					$('input.checkbox-tuning-fork-present-right').prop("checked", false);
				}
			});
			
			$(document).on('click', '.tuning-fork-present-right', function(){
				if($('input.checkbox-tuning-fork-present-right').is(":checked"))
				{
					$('input.checkbox-tuning-fork-present-left').prop("checked", false);
				}
			});
			
			//Tuning Fork Absent
			$(document).on('click', '.tuning-fork-absent-left', function(){
				if($('input.checkbox-tuning-fork-absent-left').is(":checked"))
				{
					$('input.checkbox-tuning-fork-absent-right').prop("checked", false);
				}
			});
			
			$(document).on('click', '.tuning-fork-absent-right', function(){
				if($('input.checkbox-tuning-fork-absent-right').is(":checked"))
				{
					$('input.checkbox-tuning-fork-absent-left').prop("checked", false);
				}
			});
			
			/********Diabetes History*********/
			
			//Previous Bad Obstetrical History
			$(document).on('click', '.prev-bad-obstetric-history-yes', function(){
				if($('input.checkbox-prev-bad-obstetric-history-yes').is(":checked"))
				{
					$('input.checkbox-prev-bad-obstetric-history-no').prop("checked", false);
				}
			});
			
			$(document).on('click', '.prev-bad-obstetric-history-no', function(){
				if($('input.checkbox-prev-bad-obstetric-history-no').is(":checked"))
				{
					$('input.checkbox-prev-bad-obstetric-history-yes').prop("checked", false);
				}
			});
			
			//Previous History of GDM
			$(document).on('click', '.prev-history-of-gdm-yes', function(){
				if($('input.checkbox-prev-history-of-gdm-yes').is(":checked"))
				{
					$('input.checkbox-prev-history-of-gdm-no').prop("checked", false);
				}
			});
			
			$(document).on('click', '.prev-history-of-gdm-no', function(){
				if($('input.checkbox-prev-history-of-gdm-no').is(":checked"))
				{
					$('input.checkbox-prev-history-of-gdm-yes').prop("checked", false);
				}
			});
			
			//Laboratory Investigation ECG Type
			$(document).on('click', '.lab-ecg-type-abnormal', function(){
				if($('input.checkbox-lab-ecg-type-abnormal').is(":checked"))
				{
					$('input.checkbox-lab-ecg-type-normal').prop("checked", false);
					$('.abnoirmal-type-keywords').show();
					$('.abnoirmal-type-keywords').find('input:checkbox').prop("checked", false);
				}else{
					$('.abnoirmal-type-keywords').hide();
				}
			});
			
			$(document).on('click', '.lab-ecg-type-normal', function(){
				if($('input.checkbox-lab-ecg-type-normal').is(":checked"))
				{
					$('input.checkbox-lab-ecg-type-abnormal').prop("checked", false);
					$('.abnoirmal-type-keywords').hide();
				}else{
					$('.abnoirmal-type-keywords').hide();
				}
			});
			
			//Laboratory Investigation USG Type
			$(document).on('click', '.lab-usg-type-abnormal', function(){
				if($('input.checkbox-lab-usg-type-abnormal').is(":checked"))
				{
					$('input.checkbox-lab-usg-type-normal').prop("checked", false);
					$('.usg-abnormal-type-keywords').show();
				}else{
					$('.usg-abnormal-type-keywords').hide();
				}
			});
			
			$(document).on('click', '.lab-usg-type-normal', function(){
				if($('input.checkbox-lab-usg-type-normal').is(":checked"))
				{
					$('input.checkbox-lab-usg-type-abnormal').prop("checked", false);
					$('.usg-abnormal-type-keywords').hide();
				}else{
					$('.usg-abnormal-type-keywords').hide();
				}
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			//load visit center
			$('.src-investigation').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "patients/visit/get_investions",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response(data.content);
					// $('.src-investigation').val('');
				  }
				});
			  },
			  select: function (event, ui) {
						// var getValue = $(this).val();
						// if(getValue !== '')
						// {
							// $(this).val(getValue+', '+ui.item.label); // display the selected text
						// }else{
							$(this).val(ui.item.label); // display the selected text
						// }
						// searchFilter();
						//$("#hiddenVisitCenterId").val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
		});
	</script>
	<script type="text/javascript">
	$('#second').change(function() {
		if ($('#first').val()!==''){
    $('#first').val($('#first').val() + ','+$(this).val());
    $('#second').val(null);
		}else {
			$('#first').val($(this).val());
			$('#second').val(null);
		}
});
	</script>
	
	<script type="text/javascript">
	$("#refresh").click(function(){
		var str = $('#first').val();
		var arr = str.split(',');
		arr = arr.splice(0, arr.length - 1);
		var rem = arr.join(',');
		$('#first').val(rem);
	});
	</script>
	
	<script type="text/javascript">
	$('#criteriaIncOne').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#deactive-enter-lab').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#block-enter-ft').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	<script type="text/javascript">
	$('#deactive-enter-visit').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	</script>
	
	
<?php require_once APPPATH.'modules/common/footer.php' ?>