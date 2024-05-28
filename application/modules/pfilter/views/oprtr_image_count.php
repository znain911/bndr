<?php if (isset($conditions['search']['from_date']) && isset($conditions['search']['to_date'])):
		$date = date("d M", strtotime($conditions['search']['from_date']));
		$date2 = date("d M", strtotime($conditions['search']['to_date']));
 ?>
 <div><span style="display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;  font-size: 20px; margin-bottom: 10px;"><strong> From <?php echo $date;?> To <?php echo $date2;?> Count :</strong> <span id="totalPatients"><?php echo $totalRec; ?></span></span></div>
 <?php elseif (isset($conditions['search']['from_date'])):
		$date = date("d M", strtotime($conditions['search']['from_date']));
		
		?>
<div><span style="display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;  font-size: 20px; margin-bottom: 10px;"><strong><?php echo $date;?> Count :</strong> <span id="totalPatients"><?php echo $totalRec; ?></span></span></div>
<?php else :?>
<div><span style="display: inline-block;border: 2px solid #0a0;background: rgba(0,220,0, 0.3);border-radius: 3px;padding: 3px 10px;  font-size: 20px; margin-bottom: 10px;"><strong>Total Count :</strong> <span id="totalPatients"><?php echo $totalRec; ?></span></span></div>
<?php endif;?>							
								<table class="table" id= "upCount2">
									<thead>
										<tr>
											<th>SL.</th>
											<th>Name Of Operator</th>
											<th>Center Name</th>
											<th>Prescription Upload Count</th>
											<th>Data Entry Count</th>
											
											
										</tr>
									</thead>
									<tbody>
										<?php 
											$sl = 1;
											if(count($items) !== 0):
											$operator = null;
											$from_date = null;
											$to_date = null;
											$month = null;
											$year = null;
											if (isset($conditions['search']['operator'])){
												$operator = $conditions['search']['operator'];
											}
											if (isset($conditions['search']['from_date'])){
												$from_date = $conditions['search']['from_date'];
											}
											if (isset($conditions['search']['to_date'])){
												$to_date = $conditions['search']['to_date'];
											}
											if (isset($conditions['search']['month'])){
												$month = $conditions['search']['month'];
											}
											if (isset($conditions['search']['year'])){
												$year = $conditions['search']['year'];
											}
											foreach($items as $item):
											$chCount = $this->Dashboard_model->image_ch_count($item['submitted_by'],$from_date,$to_date,$operator,$month,$year);
											$chEntryCount = $this->Dashboard_model->image_ch_entry_count($item['submitted_by'],$from_date,$to_date,$operator,$month,$year);
											$pCount = $this->Dashboard_model->image_p_count($item['submitted_by'],$from_date,$to_date,$operator,$month,$year);
											$pEntryCount = $this->Dashboard_model->image_p_entry_count($item['submitted_by'],$from_date,$to_date,$operator,$month,$year);
											$filterChCount = array_values(array_column($chCount, null, 'patient_id'));
											$filterChEntryCount = array_values(array_column($chEntryCount, null, 'patient_id'));
											$filterPCount = array_values(array_column($pCount, null, 'time'));
											$filterPEntryCount = array_values(array_column($pEntryCount, null, 'time'));
											$ch = count($filterChCount);
											$chEntry = count($filterChEntryCount);
											$progress = count($filterPCount);
											$pEntry = count($filterPEntryCount);
											
											$totalUpload = $ch + $progress;
											$totalEntry = $chEntry + $pEntry;
										?>
										<tr>
											<td><?php echo $sl; ?></td>
											<td><?php echo substr($item['submitted_by'], 0, -10);  ?></td>
											<td><?php echo $item['orgcenter_name'];  ?></td>
											<td style = 'text-align: center;'><a href="#" onclick="upload('<?php echo substr($item['submitted_by'], 0, -10);?>','<?php echo $item['center_id'];?>')" class="tags1"><?php echo $totalUpload;  ?></a></td>
											<td style = 'text-align: center;'><a href="#" onclick="entry('<?php echo substr($item['submitted_by'], 0, -10);?>','<?php echo $item['center_id'];?>')" class="tags1"><?php echo $totalEntry;  ?></a></td>
											
											
											
										</tr>
										<?php 
											$sl++;
											endforeach; 
											else:
										?>
										<tr><td colspan="13" class="text-center">No new patients found.</td></tr>
										<?php endif; ?>
									</tbody>
								</table>
	<script type="text/javascript">
		 $(function(e) {
            $('#upCount2').DataTable(
                {lengthMenu:[5,10,25,50,100],pageLength:10,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}
                );
        } );
	</script>
