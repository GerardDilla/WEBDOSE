<link href="<?php echo base_url(); ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">


<?php
foreach($this->data['get_totalunits'] as $row){
	$lec_unit             = $row['Course_Lec_Unit'];
	$lab_unit             = $row['Course_Lab_Unit'];
	$total_units          =  $total_units  + $lab_unit + $lec_unit;
}
	
// GET TOTAL SUBJECT FROM ENROLLED STUDENT SUBJECT TABLE
$countsubject = 0;
foreach ($this->data['get_TotalCountSubject']  as $row ){
$countsubject++;
} 
    
$tuition = number_format($this->data['get_data'][0]['tuition_Fee'], 2, '.', '');	
$Misc_Fee           = $this->data['get_miscfees'][0]['Fees_Amount'];
$OF                 = $this->data['get_othefees'][0]['Fees_Amount'];
$Lab_Fees           = $this->data['get_labfees'][0]['Fees_Amount'];
$FullpaymentChecker = $this->data['get_data'][0]['fullpayment'];


//TOTAL FEES
$Total_Fees = $Lab_Fees  + $Misc_Fee + $OF + $tuition;


//NUMBER 2 DECIMAL FORMAT
 $Total_Fees = number_format($Total_Fees, 2, '.', '');
 $Lab_Fees   = number_format($Lab_Fees, 2, '.', '');


?>

<div id="printElement">
<section style="padding-left: 30px;">
	<div class="container-fluid">
   
			<div class="row">
				<div class="col-md-12">
					<img src="<?php echo base_url(); ?>img/SdcaHeader.jpg" width="100%" height="auto" >
				</div>
				
				<div class="col-md-12" >
				    <br><br>
					<div style="text-align: center;"><h4><b>OFFICIAL REGISTRATION<b></h4></div>
					<br>
				</div>

				    <table style="width: 100%;">
				        <tr>
					     	<td><div><span style="font-weight: 700;">STUDENT NO: </span> <?php echo $this->data['get_data'][0]['Student_Number']; ?></div></td>
						    <td><div><span style="font-weight: 700;">SEMESTER:</span>   <?php echo $this->data['get_data'][0]['Semester']; ?></div></td>
						    <td><div><span style="font-weight: 700;">SCHOOL YEAR:</span>   <?php echo $this->data['get_data'][0]['School_Year']; ?></div></td>
						    <td><div><span style="font-weight: 700;">SECTION:</span> <?php echo $this->data['get_data'][0]['ENROLLED_SECTION']; ?> </div></td>
				        <tr>

				        <tr>
							<td><div><span style="font-weight: 700;">NAME:</span> <?php echo strtoupper($this->data['get_data'][0]['Last_Name']); ?>, <?php echo strtoupper($this->data['get_data'][0]['First_Name']); ?> <?php echo strtoupper($this->data['get_data'][0]['Middle_Name']); ?></div></td>
							<td ><div><span style="font-weight: 700;">COURSE:</span> <?php echo $this->data['get_data'][0]['Course']; ?></div></td>
							<td><div><span style="font-weight: 700;">YR. LEVEL:</span> <?php echo $this->data['get_data'][0]['YL']; ?></div></td>
							<td><div><span style="font-weight: 700;">ENCODER:</span></div></td>
				        <tr>
				  
					</table>
					<table style="width: 100%;">
					    <tr>
						<td width="82%">
						   <div><span style="font-weight: 700;">ADDRESS:</span>
								<span style="font-weight: normal;">
									<?php echo strtoupper($this->data['get_data'][0]['Address_No']); ?>
									<?php echo strtoupper($this->data['get_data'][0]['Address_Street']); ?>
									<?php echo strtoupper($this->data['get_data'][0]['Address_Subdivision']); ?>
									<?php echo strtoupper($this->data['get_data'][0]['Address_Barangay']); ?>
									<?php echo strtoupper($this->data['get_data'][0]['Address_City']); ?>
									<?php echo strtoupper($this->data['get_data'][0]['Address_Province']); ?>
								</span>
							</div>
						</td>
						<td width="18%">
						  <div><span style="font-weight: 700;">DATE:</span> <span>  <?php echo date("d/m/y") ?> </span></div>
						</td>
						<tr>
					</table>
  
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
							<?php foreach($this->data['get_data'] as $row)  {?>
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
					<br> 


					<table class="pull-right" style="width: 80%; text-align:left">
						<tr>
							<td><strong>Tuition:</strong></td>
							<td id="trf_tuition"><?php echo $tuition; ?></td>
							<td><strong>Initial Payment:</strong></td>
							<td id="trf_initial"><?php echo $this->data['get_data'][0]['InitialPayment'];?></td>
							<td><strong>Total Units:</strong></td>
							<td id="trf_total_units"><?php echo $total_units; ?></td>
						</tr>
						<tr>
							<td><strong>Misc Fees:</strong></td>
							<td id="trf_misc"><?php echo $Misc_Fee; ?></td>
							<td><strong>First:</strong></td>
							<td id="trf_first"><?php echo $this->data['get_data'][0]['First_Pay'];?></td>
							<td><strong>Total Subjects:</strong></td>
							<td id="trf_total_subject"><?php echo $countsubject;?></td>
						</tr>
						<tr>
							<td><strong>Lab Fees:</strong></td>
							<td id="trf_lab"><?php echo $Lab_Fees; ?></td>
							<td><strong>Second:</strong></td>
							<td id="trf_second"><?php echo $this->data['get_data'][0]['Second_Pay'];?></td>
							<td><strong>Scholar:</strong></td>
							<td id="trf_scholar"><?php echo $this->data['get_data'][0]['Scholarship'];?></td>
						</tr>
						<tr>
							<td><strong>Other Fees:</strong></td>
							<td id="trf_other"><?php echo $OF; ?></td>
							<td><strong>Third:</strong></td>
							<td id="trf_third"><?php echo $this->data['get_data'][0]['Third_Pay'];?></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Total Fees:</strong></td>
							<td id="trf_total_fees"><?php echo $Total_Fees; ?></td>
							<td><strong>Fourth:</strong></td>
							<td id="trf_fourth"><?php echo $this->data['get_data'][0]['Fourth_Pay'];?></td>
							<td></td>
							<td></td>
						</tr>
			</table>
	
		</div>         
	     <br><br><br>
		
	
</div>	
</section>
</div>	


<div class="row" style="text-align: center;">
		    <div class="col-md-12">
			    <button class="btn btn-lg btn-success" id="printButton" onclick="printDiv('printElement')">Print</button>
				<a class="btn btn-lg btn-danger" href="<?php echo base_url(); ?>index.php/Registrar/Forms"  id="CancelButton" >Cancel</a>
			</div>
		 </div>

		<input type="hidden" value="<?php echo $this->data['get_data'][0]['Semester']; ?>" id="sm">
		<input type="hidden" value="<?php echo $this->data['get_data'][0]['School_Year']; ?>" id="sy">
		<input type="hidden" value="<?php echo $this->data['get_data'][0]['Student_Number']; ?>" id="sn">
		<input type="hidden" value="<?php echo $this->data['get_data'][0]['Reference_Number']; ?>" id="rf">
		<input type="hidden" value="<?php echo base_url(); ?>" id="addressUrl">




	<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>js/subject_edit.js"></script>



	<script>


 
	function printDiv(divId) 
	{
		$( "#printButton" ).hide();
		$( "#CancelButton" ).hide();
		window.onafterprint = function(e){
			$(window).off('mousemove', window.onafterprint);
			$( "#printButton" ).show();
			$( "#CancelButton" ).show();
			PrintRegformLogs();
        };
        window.print();
	   //	Window.close();
    }
	
   
   function PrintRegformLogs()
   {
		Semester          = $("#sm").val()
		SchoolYear        = $("#sy").val()
		Student_Number    = $("#sn").val()
		Reference_Number  = $("#rf").val()
		url               = $("#addressUrl").val()
		
		$.ajax({
			method: "POST",
				url: url+"index.php/Registrar/print_logs_ajax",
				    data: { 
						Semester: Semester,
						SchoolYear: SchoolYear,
						Student_Number:Student_Number,
						Reference_Number:Reference_Number
				    },
		});
	  
   }
	
	
	</script>