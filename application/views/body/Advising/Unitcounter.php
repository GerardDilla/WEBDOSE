<section class="content" style="background-color: #fff;">
	<div class="container-fluid">
		<div class="block-header">
			<h1>Student with exceeding units</h1>
		</div><!-- Basic Example -->

		<?php if($this->session->flashdata('message')): ?>
		<br>
			<h4 class="col-red">
				<?php echo $this->session->flashdata('message'); ?>
			</h4>
		<br>
		<?php endIf; ?>

		<div class="row">
			<hr>
			<form action='<?php echo base_url(); ?>index.php/Advising/unitcheck_directory' method='post'>
				<div class="col-md-3">
					
					<?php 
						$option2[''] = 'Choose SY';
						foreach($this->data['sy']['array'] as $row){
							$option2[$row['School_Year']] = $row['School_Year'];
						}
					?>
					<?php echo form_dropdown('sy', $option2, $this->data['inputs']['sy']); ?>

				</div>
				<div class="col-md-3">
					<?php 
						$option[''] = 'Choose SEM';
						foreach($this->data['sem']['array'] as $row){
							$option[$row['Semester']] = $row['Semester'];
						}
					?>
					<?php echo form_dropdown('sem', $option, $this->data['inputs']['sem']); ?>
				</div>
				<div class="col-md-3">
					<input style="height:30px" type="number" name="units" value="27" placeholder="Maximum Units">
				</div>
				<div class="col-md-3">
					<button name="filterbutton" value="filterbutton" class="btn btn-info" type="submit">Filter</button>

					<?php if($this->data['list']['count']): ?>
						<button name="printbutton" value="printbutton" class="btn btn-success" type="submit">Export</button>
					<?php endIf; ?>

				</div>
			</form>
			<hr>
			<div class="col-md-12">
				<br>
				<?php if($this->data['list']['count']): ?>
				<h4>Result: <?php echo $this->data['list']['count']; ?></h4>
				<br>
				<?php endIf; ?>
				<br>
				<div class="body table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th></th>
								<th>Student Number</th>
								<th>Name</th>
								<th>Section</th>
								<tH>Status</th>
								<tH>YearLevel</th>
								<th>Units</th>
							</tr>
						</thead>
						<tbody>
						<?php $ref_number = ''; ?>
						<?php $count = 0; ?>
						<?php foreach($this->data['list']['array'] as $row): ?>
						<?php $count++; ?>
								<tr>
									<th scope="row"><?php echo $count; ?></th>
									<th><?php echo $row['Student_Number']; ?></th>
									<td><?php echo $row['First_Name'].' '.$row['Middle_Name'].' '.$row['Last_Name']; ?></td>
									<td><?php echo $row['Section_Name']; ?></td>
									<td><?php echo $row['Status']; ?></td>
									<td><?php echo $row['Year_Level']; ?></td>
									<td><?php echo $row['SUBJECT_UNIT']; ?></td>
								</tr>
						<?php endForeach; ?>
						</tbody>
					</table>
				</div>
				

				
				
			</div>


		</div>
	</div>
</section>




			
			



	


