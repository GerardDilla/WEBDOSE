<link href="<?php echo base_url(); ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<style>
.watermark {
    position: absolute;
    opacity: 0.25;
    font-size: 3em;
    width: 100%;
    text-align: center;
    z-index: 1000;
}
</style>
<div id="printElement">
<section style="padding-left: 30px;">
	<div class="container-fluid">
   
			<div class="row">
				<div class="col-md-12">
					<img src="<?php echo base_url(); ?>img/SdcaHeader.jpg" width="100%" height="auto" >
				</div>
				
				<div class="col-md-12" >
				    <br><br>
					<div style="text-align: center;"><h4><b>UNOFFICIAL REGISTRATION<b></h4></div>
					<br>
				</div>

				    <table style="width: 100%;">
				        <tr>
					     	<td><div><span style="font-weight: 700;">STUDENT NO: </span> <?php echo $this->data['student_schedule'][0]['Student_Number']; ?></div></td>
						    <td><div><span style="font-weight: 700;">SEMESTER:</span>   <?php echo $this->data['student_schedule'][0]['Semester']; ?></div></td>
						    <td><div><span style="font-weight: 700;">SCHOOL YEAR:</span>   <?php echo $this->data['student_schedule'][0]['School_Year']; ?></div></td>
						    <td><div><span style="font-weight: 700;">SECTION:</span> <?php echo $this->data['student_schedule'][0]['Section']; ?> </div></td>
				        <tr>

				        <tr>
							<td><div><span style="font-weight: 700;">NAME:</span> <?php echo strtoupper($this->student->get_full_name()); ?></div></td>
							<td ><div><span style="font-weight: 700;">COURSE:</span> <?php echo $this->data['student_schedule'][0]['Course']; ?></div></td>
							<td><div><span style="font-weight: 700;">YR. LEVEL:</span> <?php echo $this->data['student_schedule'][0]['YL']; ?></div></td>
							<td><div><span style="font-weight: 700;">DATE:</span> <span>  <?php echo date("d/m/y") ?> </span></div></td>
				        <tr>
                        
                    </table>
					<table style="width: 100%;">
					    <tr>
						<td width="82%">
						   <div><span style="font-weight: 700;">ADDRESS:</span>
								<span style="font-weight: normal;">
									<?php echo strtoupper($this->student->get_address()); ?>
									
								</span>
							</div>
						</td>
						<td width="18%">
						  <div></div>
						</td>
						<tr>
					</table>
                    <div class="watermark">THIS IS NOT AN OFFICIAL REGISTRATION FORM</div>
			   <br> 				
					<table style="width: 100%; text-align: left; ">
						<thead>
							<tr>
								<th width="10%">Sched Code</th>
								<th width="10%">Course Code</th>
								<th width="40%">Course</th>							
								<th  width="5%">Units</th>
								<th width="5%">Day</th>
								<th width="15%">Time</th>						
								<th width="10%">Room</th>
							</tr>
						</thead>
					<tbody>
							
				
						  <?php $sched_temp = ''; ?>
							<?php foreach($this->data['student_schedule'] as $row)  {?>
									<?php
								   	 // CHECKER IF NO RESULT IN DAY
								    if ($row['Day']   === NULL) {
										$Day = 'TBA';
									}else{
									    $Day = $row['Day'];
									} 
									if ($row['Day']  === 'H') {
										$Day = 'TH';
									} 
									  // CHECKER IF NO RESULT IN ROOM
									if ($row['Room']  === NULL) {
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
									   
									 // CHECKER IF NO RESULT IN TIME
								    if (($row['START'] === NULL) &&($row['END'] === NULL)) {
											$Time  = 'TBA';
									}else{
										$St = $row['START']; 
										$Et = $row['END'];
										$Time = $St.'-'.$Et;
									}  
                            ?>
                            
							<?php if($row['Sched_Code'] != $sched_temp): ?>	
								<tr >
									<td valign="top"><?php echo $row['Sched_Code'];  ?></td>
									<td valign="top"><?php echo $row['Course_Code']; ?></td>
									<td valign="top"><?php echo  $row['Course_Title']; ?></td>
									<td valign="top"><?php  echo $row['Course_Lec_Unit'] + $row['Course_Lab_Unit']; ?></td>	
									<td valign="top"><?php echo $Day; ?></td>			
									<td valign="top"><?php echo $Time; ?></td>
									<td valign="top"><?php echo $Room; ?></td>
								</tr>
								<?php else: ?>
									<tr class="Beld">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><?php echo $Day; ?> </td>
									<td><?php echo $Time; ?></td>
									<td><?php echo $Room;?> </td>
									</tr> 
								<?php endIf; ?> 
								<?php $sched_temp = $row['Sched_Code']; ?>
                            <?php }?>
                            
						
						</tbody>
					</table>
					<br>
					<h3>Remaining Balance</h3>
					<table>
						<thead>
							<tr>
								<th width="10%">Semester</th>
								<th width="10%">School Year</th>
								<th width="40%">Balance</th>							
							</tr>
						</thead>
						<tbody>
						<?php foreach ($this->data['remaining_balance'] as $key => $balance) { ?>
							<tr>
								<td><?php echo $balance['semester']; ?></td>
								<td><?php echo $balance['schoolyear']; ?></td>
								<td><?php echo $balance['BALANCE']; ?></td>
							</tr>
						<?php } ?>
						</tbody>				
					</table>
					
					
	
		</div>         
        <br><br>
         <div class="watermark">THIS IS NOT AN OFFICIAL REGISTRATION FORM</div>
         <br><br>
         <br><br>
	
</div>	
</section>
</div>	

<div class="row" style="text-align: center;">
    <div class="col-md-12">
        <a class="btn btn-lg btn-danger" href="<?php echo site_url('ProgramChair/view_student_sched/').$this->student->get_reference_number().'/'.$this->data['student_schedule'][0]['Semester'].'/'.$this->data['student_schedule'][0]['School_Year']; ?>"  id="CancelButton" >Cancel</a>
    </div>
</div>

		<input type="hidden" value="<?php echo $this->data['student_schedule'][0]['Semester']; ?>" id="sm">
		<input type="hidden" value="<?php echo $this->data['student_schedule'][0]['School_Year']; ?>" id="sy">
		<input type="hidden" value="<?php echo $this->data['student_schedule'][0]['Student_Number']; ?>" id="sn">
		<input type="hidden" value="<?php echo $this->data['student_schedule'][0]['Reference_Number']; ?>" id="rf">
		<input type="hidden" value="<?php echo base_url(); ?>" id="addressUrl">




	<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>js/subject_edit.js"></script>


