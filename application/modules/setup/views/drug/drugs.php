<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Setup</li>
				<li class="active">Drugs</li>
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
				<strong style="margin-top:15px;" class="pull-left">DRUGS</strong>
				<a href="<?php echo base_url('setup/drugs/create'); ?>" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW DRUG</a>
			</div>
			<div class="panel panel-default block2" style="padding:15px">
				<div class="table-responsive put-relative">
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
						<div class="search-input-bx">
							<div class="col-lg-3"><strong class="filter-label">Search </strong></div>
							<div class="col-lg-9">
								<input type="text" class="form-control inline-src-right" id="keywords" onkeyup="searchFilter()" placeholder="Search here...." <?php echo (isset($src_input))? 'value="'.$src_input.'"' : null; ?> />
							</div>
						</div>
						<?php echo form_close(); ?>
						<div style="clear:both"></div>
					</div>
					<div id="postList">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width:5%;">SL.</th>
									<th style="width:25%;">Company</th>
									<th>Brand</th>
									<th style="width: 15%;">Generic</th>
									<th style="width: 15%;">Strength</th>
									<th>Dosages</th>
									<th>DAR</th>
									<th style="width: 4%;">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$x = 1;
									foreach($items as $item):
								?>
								<tr>
									<td><?php echo $x; ?></td>
									
									<td><?php echo $item['company_name']; ?></td>
									<td><?php echo $item['brand']; ?></td>
									<td><?php echo $item['generic']; ?></td>
									<td><?php echo $item['strength']; ?></td>
									<td><?php echo $item['dosages']; ?></td>
									<td><?php echo $item['DAR']; ?></td>
									
									<td class="jsgrid">
										<button onclick="window.location.href='<?php echo base_url('setup/drugs/edit/'.$item['id']); ?>'" class="jsgrid-button jsgrid-edit-button" type="button" title="Edit"></button>
										<button data-item="<?php echo $item['id']; ?>" class="remove-btn jsgrid-button jsgrid-delete-button" type="button" title="Delete"></button>
									</td>
								</tr>
								<?php 
									$x++;
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.remove-btn', function(){
				if(confirm('Are you sure to delete?', true))
				{
					var item = $(this).attr('data-item');
					$.ajax({
						type : "POST",
						url : baseUrl + "setup/drugs/delete",
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
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pfilter/get_all_drugs/'+page_num,
				data:'page='+page_num+'&keywords='+keywords,
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