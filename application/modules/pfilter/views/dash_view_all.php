<table class="table">
	<thead>
		<tr>
			<th>SL.</th>
			<?php if($this->session->userdata('user_type') !== 'Doctor'):
				if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
			<th>ID</th>
			<?php endif;endif;endif;?>
			<?php if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
			<th>Visits</th>
			<?php endif;?>
			<th class = 'laptop'>Gender</th>
			<th>Name</th>
			<?php if($this->session->userdata('user_type') !== 'Doctor'):
					if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
			<th>ORG. Center</th>
			<?php endif;endif;endif;?>
			<th class = 'laptop'>Phone</th>
			<?php if($this->session->userdata('user_type') !== 'Doctor'):
				if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
			<th>Date Of Birth</th>
			<?php endif;endif;endif;?>
			<th class = 'laptop'>Age</th>
			<?php if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
			<th>First visit Date</th>
			<th>Guidebook</th>
			<?php else:?>
			
			<th>Register Date</th>
			<?php endif;?>
			<?php if($this->session->userdata('user_type') !== 'Doctor'): ?>
			<th>Guidebook</th>
			<th>Submitted By</th>
			
			<th style="width:7%;">Action</th>
			
			<th>Visits</th>
			<th>Receipt</th>
			<?php endif;?>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = 1;
			if(count($items) !== 0):
			foreach($items as $item):
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<?php if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'): ?>
			<td class="text-center">
				<a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:20px;background:#f00;padding:8px 8px;"><i class="fa fa-plus-square"></i></a>
			</td>
			<?php endif;?>
			<?php if($this->session->userdata('user_type') !== 'Doctor'):
				if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
			<td><?php echo $item['patient_entryid']; ?></td>
			<?php endif;endif;endif;?>
			<td class = 'laptop'><?php echo ($item['patient_gender'] == '0')? '<strong>Male</strong>' : '<strong>Female</strong>'; ?></td>
			<td><?php echo $item['patient_name']; ?></td>
			<?php if($this->session->userdata('user_type') !== 'Doctor'): 
				if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
			<td><?php echo $item['orgcenter_name']; ?></td>
			<?php endif;endif;endif;?>
			<td class = 'laptop'><?php echo $item['patient_phone']; ?></td>
			<?php if($this->session->userdata('user_type') !== 'Doctor'): 
				if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
			<td><?php echo date("d M, Y", strtotime($item['patient_dateof_birth'])); ?></td>
			<?php endif;endif;endif;?>
			<td class = 'laptop'><?php echo $item['patient_age']; ?></td>
			<?php if($item['patient_form_version'] == 'V1'): ?>
			<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])).' '.date("g:i A", strtotime($item['patient_create_date'])); ?></td>
			<?php else: ?>
			<!--<td><?php echo date("d M, Y", strtotime($item['patient_create_date'])); ?></td> -->
				<td><?php 
				if($item['patient_create_date']):
				echo date("d M, Y", strtotime($item['patient_create_date'])); 
				endif; 
				?>
				
				</td>
				<td class=" "><?php echo $item['patient_guide_book']; ?></td>
			<?php endif; ?>
			<?php if($this->session->userdata('user_type') !== 'Doctor'): 
					if($this->session->userdata('user_type') !== 'Foot Doctor' ):
											if($this->session->userdata('user_type') !== 'Eye Doctor' ): ?>
			<td class="text-center"><?php echo get_admitted_by($item['patient_admitted_by'], $item['patient_admitted_user_type'], $item['patient_admitted_user_syncid']); ?></td>
			
			<td class="text-center">
				<a href="<?php echo base_url('patients/edit/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;margin-right:5px;"><i class="fa fa-pencil"></i></a>
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a data-item="<?php echo $item['patient_id']; ?>" class="remove-btn" style="cursor: pointer;color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
			</td>
			
			<td class="text-center">
				<?php if($this->session->userdata('user_type') === 'Administrator'): ?>
				<a href="<?php echo base_url('patients/visit/all/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
				<?php else: ?>
				<a href="<?php echo base_url('patients/visit/entry_type/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#f00;padding:3px 6px;"><i class="fa fa-plus-square"></i></a>
				
				<?php endif; ?>
			</td>
			
			<td class="text-center">
				<a target="_blank" href="<?php echo base_url('patients/moneyreceipt/'.$item['patient_id'].'/'.$item['patient_entryid']); ?>" style="color: #FFF;font-size:14px;background:#1B75BC;padding:3px 6px;"><i class="fa fa-print"></i></a>
			</td>
			<?php endif;endif;endif; ?>
		</tr>
		<?php 
			$sl++;
			endforeach; 
			else:
		?>
		<tr><td colspan="13" class="text-center">No new patients.</td></tr>
		<?php endif; ?>
	</tbody>
</table>
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>