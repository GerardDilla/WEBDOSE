


<form action="<?php echo base_url(); ?>index.php/ProgramChair/select_student" method="post">
     
	<section class="content" style="background-color: #fff;">
		<div class="container-fluid">
			<div class="block-header">
	
				<h3>Managed Regform</h3>
				<?php if($this->data['student_schedule']): ?>
				<a href="<?php echo site_url('ProgramChair/view_student_sched') ?>" class="btn btn-primary waves-effect" type="button">
				<i class="material-icons">autorenew</i> 
				<span>CLEAR</span> 
				
				<a href="<?php echo site_url('ProgramChair/schedule_preview/').$this->student->get_reference_number().'/'.$this->data['student_schedule'][0]['Semester'].'/'.$this->data['student_schedule'][0]['School_Year']; ?>" class="btn btn-success waves-effect" type="button">
				<i class="material-icons">pageview</i>
				 <span>PREVIEW</span></a>
				<?php endif; ?>

			</div>
	      <?php if($this->session->flashdata('message_error')): ?>
			   <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<br>
					<h4><?php echo $this->session->flashdata('message_error'); ?></h4>
                </div>
          <?php endif; ?>
		 
			<div class="row">
				<div class="col-md-3">
					<div class="SBorder">


					<?php 
                             //Semester DROPDOWN
                             $class = array('class' => 'form-control show-tick',);
                             $options =  array(
							'SECOND'  => 'SECOND',
                            'FIRST'   => 'FIRST',
                            'SUMMER'  => 'SUMMER',
                         );

                             echo form_dropdown('semester', $options, $this->input->post('semester'),$class);

                     ?>  


						<br>
						<br>
						<select tabindex="2" required  class="form-control show-tick" data-live-search="true" name="school_year">
							
							<?php foreach($this->data['school_year']->result_array() as $row)  {?>
							<?php if($this->input->post('sy')==  $row['schoolyear']): ?>
								 <option  selected ><?php echo $row['schoolyear']; ?></option>
							<?php else: ?>
								 <option><?php echo $row['schoolyear']; ?></option>
							<?php endif ?>
							<?php }?>
					  </select>
						<br>
						<br>
						<b>Student/Reference Number:</b>
						<div class="input-group">
							<span class="input-group-addon"><i class="material-icons">date_range</i></span>
							<div class="form-line">
								<input tabindex="3"  required class="form-control date" type="number" name="ref_stud_number" value="<?php if(class_exists('Student')) {echo $this->student->get_student_number();} ?>">
							</div>
						</div><b>Student Name</b>
						<div class="input-group">
							<span class="input-group-addon"><i class="material-icons">account_circle</i></span>
							<div class="form-line">
								<input class="form-control date"  type="text" disabled value="<?php if(class_exists('Student')) {echo $this->student->get_full_name();} ?> ">
							</div>
						</div>
						<div class="text-center">
							<button  class="btn btn-danger" name="Search-Button">Search</button>
						</div>
					</div>
			
					<div class="SBorder" style="margin-top: 50px;">
						<b>Section</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['student_schedule'][0]['Section']; ?> ">
						</div><b>Program</b>
						<div class="form-line">
							<input class="form-control date" type="text"  disabled value="<?php echo $this->data['student_schedule'][0]['Course']; ?>">
						</div><b>Major</b>	
						<div class="form-line">
								  <?php 	
								  //PROGRAM CHECKER						  
										if($this->data['student_schedule'][0]['Program_Major'] === 0){
												$major = 'N/A';
										}
								  ?> 
							<input class="form-control date" type="text"  disabled value="<?php echo $this->data['student_schedule'][0]['Program_Major'];?>">
						</div>
						<?php
							$total_units = 0; 
							foreach ($this->data['student_schedule'] as $sched) {
								# code...
								$total_units = $total_units + $sched['Course_Lab_Unit'] + $sched['Course_Lec_Unit'];
							}
						?>
						<b>Total Units</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $total_units; ?>">
						</div>
						<b>Total Subjects</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value=" <?php echo count($this->data['student_schedule']); ?>">
						</div>
					</div>

					

				
					
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="table panel panel-danger" style="overflow-x:auto; height: 370px;" >
							<table class="table table-bordered" style="width:1200px;">
								<thead >
									<tr class="danger">
										<th style="position: sticky; top: 0;">Sched Code</th>
										<th style="position: sticky; top: 0;">Course Code</th>
										<th style="position: sticky; top: 0;">Course</th>
										<th style="position: sticky; top: 0;">Units</th>
										<th style="position: sticky; top: 0;">Time</th>
										<th style="position: sticky; top: 0;">Day</th>
										<th style="position: sticky; top: 0;">Room</th>	
									</tr>
								</thead>
								<tbody>
								<!-- WITH ADVISE RESULT -->
								<?php $sched_temp = ''; ?>
									<?php foreach($this->data['student_schedule'] as $row)  {?>
										<?php
										// CHECKER IF NO RESULT IN DAY
										if ($row['Day']  === NULL) {
											$Day = 'TBA';
										}else{
											$Day = $row['Day'];
										}
										if ($row['Day']  === 'H') {
											$Day = 'TH';
										} 
										// CHECKER IF NO RESULT IN ROOM
										if ($row['Room'] === NULL) {
											$Room = 'TBA';
										}else{
											$Room = $row['Room'];
										}  
										// CHECKER IF NO RESULT IN INSTRUCTOR
										if ($row['Instructor_Name'] === NULL) {
											$Instructor = 'TBA';
										}else{
											$Instructor = $row['Instructor_Name'];
										}  
										if (($row['START'] === NULL) &&($row['END']  === NULL)) {
											$Time  = 'TBA';
										}else{
											$St = $row['START']; 
											$Et = $row['END'];

											$Time = $St.'-'.$Et;
										}  
										
										?>

									<?php if($row['Sched_Code'] != $sched_temp): ?>	
									<tr>
										<td><?php echo $row['Sched_Code']; ?></td>
										<td><?php echo $row['Course_Code']; ?></td>
										<td><?php echo $row['Course_Title']; ?></td>
										<td><?php echo $row['Course_Lec_Unit'] + $row['Course_Lab_Unit']; ?> </td>
										<td><?php echo $Time; ?></td>
										<td><?php echo $Day; ?></td>
										<td><?php echo $Room;?></td>
									</tr>
									<?php else: ?>
										<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td><?php echo $Time; ?></td>
										<td><?php echo $Day; ?> </td>
										<td><?php echo $Room;?> </td>
										</tr> 
									<?php endIf; ?> 
									<?php $sched_temp = $row['Sched_Code']; ?>
								<?php }?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="row card SBorder">
						<div class="header">
						<b>Remaining Balance</b><br>
						</div>
						<div class="body">
						<?php foreach ($this->data['remaining_balance'] as $key => $balance) { ?>				
							<div class="SBorder col-md-2">
								
								
									<b>Semester </b>
									<div class="form-line">
										<input class="form-control date" type="text" disabled  value="<?php echo $balance['semester']; ?>">
									</div>
									<b>School Year </b>
									<div class="form-line">
										<input class="form-control date" type="text" disabled  value="<?php echo $balance['schoolyear']; ?>">
									</div>
									<b>Balance</b>
									<div class="form-line">
										<input class="form-control date" type="text" disabled  value="<?php echo $balance['BALANCE']; ?>">
									</div>
								
								
							</div>
							<?php } ?>
							

							
						</div>
					</div>
				</div>

				



				
			</div>
		</div>
		</form>
	</section>

