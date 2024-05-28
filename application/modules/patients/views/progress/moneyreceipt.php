<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Print Money Receipt</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<style type="text/css">
		.text-danger strong {
    		color: #9f181c;
		}
		.receipt-main {
			background: #ffffff none repeat scroll 0 0;
			margin-top: 50px;
			margin-bottom: 50px;
			padding: 40px 30px !important;
			position: relative;
			box-shadow: 0 1px 21px #acacac;
			color: #333333;
			font-family: open sans;
		}
		.receipt-main p {
			color: #333333;
			font-family: open sans;
			line-height: 1.42857;
		}
		.receipt-footer h1 {
			font-size: 15px;
			font-weight: 400 !important;
			margin: 0 !important;
		}
		.receipt-main thead {
			background: #414143 none repeat scroll 0 0;
		}
		.receipt-main thead th {
			color:#fff;
		}
		.receipt-right h5 {
			font-size: 16px;
			font-weight: bold;
			margin: 0 0 7px 0;
		}
		.receipt-right p {
			font-size: 12px;
			margin: 0px;
		}
		.receipt-right p i {
			text-align: center;
			width: 18px;
		}
		.receipt-main td {
			padding: 9px 20px !important;
		}
		.receipt-main th {
			padding: 13px 20px !important;
		}
		.receipt-main td {
			font-size: 13px;
			font-weight: initial !important;
		}
		.receipt-main td p:last-child {
			margin: 0;
			padding: 0;
		}	
		.receipt-main td h2 {
			font-size: 20px;
			font-weight: 900;
			margin: 0;
			text-transform: uppercase;
		}
		.receipt-header-mid .receipt-left h1 {
			font-weight: 100;
			margin: 34px 0 0;
			text-align: right;
			text-transform: uppercase;
		}
		.receipt-header-mid {
			margin: 24px 0;
			overflow: hidden;
		}
		
		#container {
			background-color: #dcdcdc;
		}
		.receipt-header img {
		  display: inline-block;
		}
		.tp-header > p {
			font-size: 16px;
			line-height: 15px;
			color: #121014;
		}
		.rcpt-text {
			font-size: 24px !important;
		}
		.prnt-body p {
			font-size: 17px;
		}
		
		@media print {
			.paid{color:#0A0 !important;font-weight:bold !important;}
			.unpaid{color:#F00 !important;font-weight:bold !important;}
		}

	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
				<div class="row">
					<div class="receipt-header">
						<div class="col-xs-3 col-sm-3 col-md-3 text-left">
							<div class="receipt-left">
								<img class="img-responsive" alt="BNDR" src="<?php echo base_url('assets/tools/logo.png'); ?>" style="width: 100%;">
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 text-center tp-header">
							<p>Diabetic Association of Bangladesh</p>
							<p>Nationwide Electronic Registry</p>
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 text-right">
							<div class="receipt-right">
								<img class="img-responsive" alt="BADAS" src="<?php echo base_url('assets/tools/badas.png'); ?>" style="width: 71px; border-radius: 43px;">
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="receipt-header receipt-header-mid">
						<div class="col-xs-12 col-sm-12 col-md-12 text-center prnt-body">
							<p class="rcpt-text"><strong>Money Receipt</strong></p>
							<p><strong><?php echo $receipt['visit_visit_center']; ?></strong></p>
						</div>
					</div>
				</div>
				
				<div>
					<table class="table table-bordered">
						<tbody>
							<tr>
								<td class="col-md-9"><strong>Patient Name</strong></td>
								<td class="col-md-3"><?php echo $receipt['patient_name']; ?></td>
							</tr>
							<tr>
								<td class="col-md-9"><strong>Patient ID</strong></td>
								<td class="col-md-3"><?php echo $receipt['patient_entryid']; ?></td>
							</tr>
							<tr>
								<td class="col-md-9"><strong>Type Of Payment</strong></td>
								<td class="col-md-3">Electronic Follow-up Fee</td>
							</tr>
							<tr>
								<td class="text-right">
									<p>
										<strong>Payment Amount: </strong>
									</p>
								</td>
								<td>
									<p>
										<strong><i class="fa fa-inr"></i> <?php echo $receipt['payment_patient_fee_amount']; ?>/-</strong>
									</p>
								</td>
							</tr>
							<tr>
							   
								<td class="text-right"><h2><strong>Total: </strong></h2></td>
								<td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i> <?php echo $receipt['payment_patient_fee_amount']; ?>/-</strong></h2></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="row">
					<div class="receipt-header receipt-header-mid receipt-footer">
						<div class="col-xs-8 col-sm-8 col-md-8 text-left">
							<div class="receipt-right">
								<p><b>Date :</b> <?php echo date('d M, Y', strtotime(date('Y-m-d'))); ?></p>
								<p><b>Payment Status :</b> 
									<?php if($receipt['payment_patient_status'] == '1'): ?>
									<strong class="paid" style="color:#0A0">Paid</strong>
									<?php else: ?>
									<strong class="unpaid" style="color:#F00">Unpaid</strong>
									<?php endif; ?>
								</p>
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4">
							<div class="receipt-left">
								<h1>Signature</h1>
							</div>
						</div>
					</div>
				</div>
				
			</div>    
		</div>
	</div>
	<script>
		window.print();
	</script>
</body>
</html>