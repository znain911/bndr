<?php require_once APPPATH.'modules/common/header.php' ?>



								<table id = "compile" class="table" style = "margin-top: 5%">
									<thead>
										<tr>
											<th>SL.</th>
											<th>Name</th>
											<th>BNDR ID</th>
											<th>Guide Book</th>
											<th>Form Version</th>
											<th>Action</th>
											
											
										</tr>
									</thead>
									<tbody>
									
										<?php 
											$sl = 1;
											if(count($chlist) !== 0):
											foreach($chlist as $ch):
										?>
										<tr>
											<td><?php echo $sl; ?></td>
											<td><?php echo $ch['patient_name']; ?></td>
											<td><?php echo $ch['patient_entryid']; ?></td>
											<td><?php echo $ch['patient_guide_book']; ?></td>
											<td><?php echo $ch['patient_form_version']; ?></td>
											<td><button type="button" onclick="compile('<?php echo $ch['patient_id'];?>')" class="btn btn-primary btn-sm">Compile</button>
												
											</td>
										</tr>
										<?php 
										$sl++;
											endforeach;
											
											endif;
											
										?>
									</tbody>
								</table>
<script type="text/javascript">
		 $(function(e) {
            $('#compile').DataTable(
                {lengthMenu:[5,10,25,50,100],pageLength:10,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}
                );
        } );
	</script>	
	
	<script type='text/javascript'>

function compile(pid)
{
	$.ajax({
		type: 'POST',
		url: baseUrl + "register/complie",
		data:'pid='+pid,
		dataType:'json',
		beforeSend: function () {
			
		},
		success: function (data) {
			if(data.status == 'ok')
			{
				//$('#postList').html(data.content);
				console.log(data.content);
				console.log(data.content2);
				alert('Compilation done');
				window.location.reload();
				//$('.upImage').show();
				//$('.upImage').html(data.content);
				//window.scrollBy(0, 1000);
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
			
			$(window).on('load', function(){
				$(".waves-effect").removeClass("active");
			})
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php' ?>