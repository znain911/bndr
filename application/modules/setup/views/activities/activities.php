<?php require_once APPPATH.'modules/common/header.php' ?>

	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="#">Dashboard</a></li>
				<li class="active">Setup</li>
				<li class="active">Physical Activities</li>
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
				<strong style="margin-top:15px;" class="pull-left">PHYSICAL ACTIVITIES</strong>
				<a href="<?php echo base_url('setup/physical/create'); ?>" class="add-vst-button pull-right"><i class="fa fa-plus-square"></i> ADD NEW PHYSICAL ACTIVITY</a>
			</div>
			<div class="panel panel-default block2" style="padding:15px">
				<div class="table-responsive put-relative">
					<table id="dataTable" class="table">
						<thead>
							<tr>
								<th>SL.</th>
								<th>Activity Name</th>
								<th>Create Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$x = 1;
								$items = $this->Physical_model->get_all_items();
								foreach($items as $item):
							?>
							<tr>
								<td><?php echo $x; ?></td>
								<td><?php echo $item['activity_title']; ?></td>
								<td><?php echo date("d M, Y", strtotime($item['activity_create_date'])).' '.date("g:i A", strtotime($item['activity_create_date'])); ?></td>
								<td class="jsgrid">
									<button onclick="window.location.href='<?php echo base_url('setup/physical/edit/'.$item['activity_id']); ?>'" class="jsgrid-button jsgrid-edit-button" type="button" title="Edit"></button>
									<button data-item="<?php echo $item['activity_id']; ?>" class="remove-btn jsgrid-button jsgrid-delete-button" type="button" title="Delete"></button>
								</td>
							</tr>
							<?php 
								$x++;
								endforeach; 
							?>
						</tbody>
					</table>
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
						url : baseUrl + "setup/physical/delete",
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
<?php require_once APPPATH.'modules/common/footer.php' ?>