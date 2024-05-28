<?php require_once APPPATH.'modules/common/report-header.php' ?>

	<div class="row bg-title">
		<!-- <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Reports</li>
			</ol>
		</div> -->
		<!-- /.col-lg-12 -->
	</div>
	
	<!-- ============================================================== -->
	<!-- Demo table -->
	<!-- ============================================================== -->
	<div class="row">
		<div class="col-lg-12">

			<div class="filter-form-report">
				<form action="<?php echo base_url('reportapp/expexcelwithcenter'); ?>" method="POST">
					<div class="form-group row">
						<label class="col-lg-8 text-right">Select Organization</label>
						<div class="col-lg-4">
							<select name="organization" class="form-control" id="selectedOrganization">
								<option value="" selected="selected">Select Organization</option>
								<?php 
									$orgs = $this->Organization_model->get_all_items();
									foreach($orgs as $org):
								?>
								<option value="<?php echo $org['org_id']; ?>"><?php echo $org['org_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-8 text-right">Select Center</label>
						<div class="col-lg-4">
							<select name="center" class="form-control" id="cenTers">
								<option value="" selected="selected">Select Center</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-8"></label>
						<div class="col-lg-4 text-right">
							<button type="submit" class="fcbtn btn btn-info btn-outline btn-1b"><i class="fa fa-plus-square"></i> EXPORT TO EXCEL</button>


						</div>
					</div>
				</form>
			</div>



			<div class="add-href-unit">
				<!-- <strong style="margin-bottom: 10px; text-transform: uppercase; font-size: 17px; margin-top: 0px;" class="pull-left">Reports</strong> -->
				<!-- <a href="<?php echo base_url('reportapp/expexcelnew'); ?>" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> EXPORT TO EXCEL</a> -->
			</div>
			
		</div>
	</div>
	<script type="text/javascript">
		/*function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var from_date = $('#fromDate').val();
			var to_date = $('#toDate').val();
			
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pfilter/get_reports/'+page_num,
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
		}*/
	</script>
	<script>
		
	$(document).ready(function () {
		$(".csshovername a").hover(function () {
			$('.mahmud-panel-textwrap .text-tite').toggleClass("opacityshow");
		});
		 
		$(".mains").click(function () {
			$(".subm").toggleClass("show");
			$(this).toggleClass('mainsup');
		});
	}); 
 
	$(document).ready(function(){
		$(".menu-opener-inner").removeClass("active");
		$(".clkevnt").removeClass("albodyoverlay");
		var widthmenu = $(window).width();
		if ( widthmenu < 740) {
			 $(".menu").css({width: widthmenu +'px','right': '-'+widthmenu+'px' });
		}else{
			$(".menu").css({ width: '302px','right': '-302px' });
		}	
	});



	$(window).resize(function() {
		$(".menu-opener-inner").removeClass("active");
		$(".clkevnt").css({ display: 'none' });	
		var widthmenu = $(window).width();
		if ( widthmenu < 740) {
			 $(".menu").css({width: widthmenu +'px','right': '-'+widthmenu+'px' });
		}else{
			$(".menu").css({ width: '302px','right': '-302px' });
		}	
	
	});

	var count = 0;
	$(".menu-opener").click(function() {
		count++;
		//even odd click detect 
		var isEven = function(someNumber) {
			return (someNumber % 2 === 0) ? true : false;
		};
		// on odd clicks do this
		if (isEven(count) === false) {
		   $(".menu-opener-inner").addClass("active");
		   $(".clkevnt").addClass("albodyoverlay");
		   $(".menu").animate({ 'right': '0px' }, { queue:false, duration: 700, easing: 'swing' });
		}
		// on even clicks do this
		else if (isEven(count) === true) {
		   $(".menu-opener-inner").removeClass("active");
		   $(".clkevnt").removeClass("albodyoverlay");
		   mw =  $(".menu").width();
		   $(".menu").animate({ 'right': '-'+mw+'px' }, { queue:false, duration: 600, easing: 'swing' });
		}
	});



	$('.subm').hide();
		$(".mains").click(function () {
		$(".subm").slideToggle();
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
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>