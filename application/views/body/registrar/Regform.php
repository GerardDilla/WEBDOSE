
  <?php 



foreach($this->data['get_totalunits'] as $row){
$lec_unit             = $row['Course_Lec_Unit'];
$lab_unit             = $row['Course_Lab_Unit'];
$total_units          =  $total_units  + $lab_unit + $lec_unit;
}

// GET TOTAL SUBJECT FROM ENROLLED STUDENT SUBJECT TABLE
$countsubjects = 0;
foreach ($this->data['get_TotalCountSubject']  as $row ){
$countsubjects++;
} 
    
$tuition = number_format($this->data['get_data'][0]['tuition_Fee'], 2, '.', '');	
$Misc_Fee           = $this->data['get_miscfees'][0]['Fees_Amount'];
$OF                 = $this->data['get_othefees'][0]['Fees_Amount'];
$Lab_Fees           = $this->data['get_labfees'][0]['Fees_Amount'];
$FullpaymentChecker = $this->data['get_data'][0]['fullpayment'];


//TOTAL FEES
$Total_Fees = $Lab_Fees  + $Misc_Fee + $OF + $tuition;

//CHECKING INSTALLMENT OR FULLPAYMENT
$Total_Fees = number_format($Total_Fees, 2, '.', '');
 $Lab_Fees   = number_format($Lab_Fees, 2, '.', '');


?>


<form action="<?php echo base_url(); ?>index.php/Registrar/Choose_Form" method="post">
     
	<section class="content" style="background-color: #fff;">
		<div class="container-fluid">
			<div class="block-header">
	
	<h3>Managed Regform</h3>
				<a href="" class="btn btn-primary waves-effect" type="button">
				<i class="material-icons">autorenew</i> 
				<span>CLEAR</span> </a>
				
				<button class="btn btn-success waves-effect" type="submit" name="Print_View">
				<i class="material-icons">print</i>
				 <span>PRINT PREVIEW</span></button>
			</div>
	      <?php if($this->session->flashdata('NoFees')): ?>
			   <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<br>
					<h4><?php echo $this->session->flashdata('NoFees'); ?></h4>
                </div>
          <?php endif; ?>
		  <?php if($this->session->flashdata('noref')): ?>
			   <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<br>
					<h4><?php echo $this->session->flashdata('noref'); ?></h4>
                </div>
          <?php endif; ?>
		  <?php if($this->session->flashdata('NoSS')): ?>
			   <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<br>
					<h4><?php echo $this->session->flashdata('NoSS'); ?></h4>
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

                             echo form_dropdown('sem', $options, $this->input->post('sem'),$class);

                     ?>  


						<br>
						<br>
						<select tabindex="2" required  class="form-control show-tick" data-live-search="true" name="sy">
							
							<?php foreach($this->data['get_sy']->result_array() as $row)  {?>
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
								<input tabindex="3"  required class="form-control date" type="number" name="refnum" value="<?php echo $this->data['get_data'][0]['Student_Number']; ?>">
							</div>
						</div><b>Student Name</b>
						<div class="input-group">
							<span class="input-group-addon"><i class="material-icons">account_circle</i></span>
							<div class="form-line">
								<input class="form-control date"  type="text" disabled value="<?php echo $this->data['get_data'][0]['Last_Name']; ?>, <?php echo $this->data['get_data'][0]['First_Name']; ?> <?php echo $this->data['get_data'][0]['Middle_Name']; ?> ">
							</div>
						</div>
						<div class="text-center">
							<button  class="btn btn-danger" name="Search-Button">Search</button>
						</div>
					</div>
			
					<div class="SBorder" style="margin-top: 50px;">
						<b>Section</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['get_data'][0]['ENROLLED_SECTION']; ?> ">
						</div><b>Program</b>
						<div class="form-line">
							<input class="form-control date" type="text"  disabled value="<?php echo $this->data['get_data'][0]['Course']; ?>">
						</div><b>Major</b>	
						<div class="form-line">
								  <?php 	
								  //PROGRAM CHECKER						  
										if($this->data['get_data'][0]['Program_Major'] === 0){
												$major = 'N/A';
										}
								  ?> 
							<input class="form-control date" type="text"  disabled value="<?php echo $this->data['get_data'][0]['Program_Major'];?>">
						</div>
					</div>

					<div class="SBorder" style="margin-top: 50px;">
						<b>No. of Print Regform</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['countPrint']->num_rows(); ?> ">
						</div>
					</div>

				
					
				</div>
				<div class="col-md-9">
					<div class="table panel panel-danger" style="overflow-x:auto; height: 350px;" >
						<table class="table table-bordered" style="width:1200px;">
							<thead>
								<tr class="danger">
									<th>Sched Code</th>
									<th>Course Code</th>
									<th>Course</th>
									<th>Units</th>
									<th>Time</th>
									<th>Day</th>
									<th>Room</th>	
								</tr>
							</thead>
							<tbody>
                           	<!-- WITH ADVISE RESULT -->
							   <?php $sched_temp = ''; ?>
							 	<?php foreach($this->data['get_data'] as $row)  {?>
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



				<div class="col-md-3">
					<div class="SBorder">
						<b>Tuition</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled  value="<?php echo $tuition; ?>">
							<b>Miscellaneous Fees</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $Misc_Fee; ?>">
						</div>
						</div><b>Lab Fees</b>
						<div class="form-line">
						
							<input class="form-control date" type="text" disabled  value="<?php echo $Lab_Fees;?>">
						</div><b>Other Fees</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled  value="<?php echo $OF; ?>">
						</div>
						<b>Total Fees</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $Total_Fees; ?>">
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="SBorder">
						<b>Initial Payment</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled  value="<?php echo $this->data['get_data'][0]['InitialPayment'];?>">
						</div>
						<b>First</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['get_data'][0]['First_Pay'];?>">
						</div><b>Second</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['get_data'][0]['Second_Pay'];?>">
						</div><b>Third</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['get_data'][0]['Third_Pay'];?>">
						</div>
						<b>Fourth</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['get_data'][0]['Fourth_Pay'];?>">
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="SBorder">
						<b>Total Cash Payment</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['get_totalcash'][0]['AmountofPayment']; ; ?>">
						</div><b>Total Units</b>
						<div class="form-line">
							
							<input class="form-control date" type="text" disabled value="<?php echo $total_units; ?>">
						</div>
						<b>Total Subjects</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value=" <?php echo $countsubjects; ?>">
						</div>
						<b>Scholar</b>
						<div class="form-line">
							<input class="form-control date" type="text" disabled value="<?php echo $this->data['get_data'][0]['Scholarship'];?>">
						</div>
						
					</div>
				</div>
			</div>
		</div>
		</form>
	</section>

