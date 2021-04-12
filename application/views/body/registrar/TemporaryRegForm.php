
	<?php 
	
	foreach($this->data['get_Advise'] as $row) {
		//GET DATA
        $ref_num              = $row->Reference_Number;
		$stu_num              = $row->Student_Number;
		$F_name               = $row->First_Name;
		$M_name               = $row->Middle_Name;
		$L_name               = $row->Last_Name;
		$Section              = $row->Section_Name;
		$AddNo                = $row->Address_No;
		$Addstreet            = $row->Address_Street;
		$AddSubd              = $row->Address_Subdivision;
		$AddBarangay          = $row->Address_Barangay;
		$AddCity              = $row->Address_City;
		$AddProvince          = $row->Address_Province;
		$Course               = $row->Course;
		$Scholar              = $row->Scholarship;
		$YL                   = $row->Year_Level;
		$sy                   = $row->School_Year;
		$sem                  = $row->Semester;
		$major                = $row->Program_Major;
		$lec_unit             = $row->Course_Lec_Unit;
	    $lab_unit             = $row->Course_Lab_Unit;
		$subject              = $row->Sched_Code;
		$Checker_FullPayment  = $row->fullpayment;
		//GET PAYS
		$InitialPayment       = $row->InitialPayment;
		$FirstPay             = $row->First_Pay;
		$SecondPay            = $row->Second_Pay;
		$ThirdPay             = $row->Third_Pay;
		$FourthPay            = $row->Fourth_Pay;
	    // GET TOTAL UNITS 
	    $total_units          = $total_units + $lec_unit;
	    $total_units          = $total_units + $lab_unit;
	     // GET TOTAL  
		$total_subjects       += $subject;  
        }
	?>
   <?php 

   //GET TOTAL CASH PAYMENT
	$Cashpayment = 0;
	foreach ($this->data['get_totalcash']  as $row ){
		 $Cashpayment  = $row->AmountofPayment;
	} 

     // GET TOTAL SUBJECT FROM ENROLLED STUDENT SUBJECT TABLE
	foreach ($this->data['get_TotalCountSubject']  as $row ){
		$Total_Subject = $row->Course_Title;
   } 
     // CHECKER IF NO MAJOR
    if ($major  === 0) {
	   $major = 'N/A';
	 } 

	  //SUM OF UNITS
	  $units = $lec_unit  + $lab_unit;
	
   ?>


<?php
	//GET LAB FEES
	$Lab_Fee = 0;
	foreach ($this->data['get_labfees']  as $row ){
	$Lab_Fee  += $row->Fee;
	} 
	//GET MISC FEES
	foreach ($this->data['get_miscfees']  as $row ){
	$Misc_Fee    = $row->Fees_Amount;
	} 
	///GET OTHER FEES
	foreach ($this->data['get_othefees']  as $row ){
	$OF    = $row->Fees_Amount;
	} 
	/// GET TUITION FEES
	$total_misc = 0;
	$total_other = 0;
	foreach ($this->data['get_tuitionfee']  as $row ){

	$TuitionPerUnit = $row->TuitionPerUnit;
	$Fees_Amount = $row->Fees_Amount;
	$Fees_Type = $row->Fees_Type;
	$Fees_Name = $row->Fees_Name;

	if($Fees_Type == "MISC")
			{
				$total_misc += $Fees_Amount; 
			}
			
	if($Fees_Type == "OTHER")
			{
				$total_other += $Fees_Amount; 
			}
		} 
	$tuition = $TuitionPerUnit * $total_units;
	$tuition = number_format($tuition, 2, '.', '');

	foreach ($this->data['get_totalcash']  as $row ){
		$Cashpayment  = $row->AmountofPayment;
} 
	


	//CHECKER OF FULLPAYMENT OR INSTALLMENT
    if($Checker_FullPayment === '0'){
		$FullPayment = 'INSTALLMENT';

		$tuition = $tuition + ($tuition * .05);
		$Total_Fees = $Lab_Fee  + $Misc_Fee + $OF + $tuition;
	
	}else{
		$FullPayment = 'FULLPAYMENT';
		$Total_Fees = $Lab_Fee  + $Misc_Fee + $OF + $tuition;
	}
?>
	
	
	<section class="content" style="background-color: #fff;">
		<div class="container-fluid" style="padding-top: 20px;">
		
		
	
<div id="printElement"  style="padding-left: 20px;">
		
			    <div class="row">
				    <div class="col-md-12">
					    <img src="<?php echo base_url(); ?>img/SdcaHeader.jpg" width="100%" height="170px" >
					</div>
				
					<div class="col-md-12" >
					    <div class="text-center"><h5><b>OFFICIAL REGISTRATION<b></h5></div>
					</div>


				 <table  class="txt-f" style="font-size: 12px;" width="100%">
				   <tr>
						<td width="40%"><div>STUDENT NO. <span class="small-font"> <?php echo $stu_num; ?></span></div></td>
						<td width="20%"><div>SEMESTER: <span class="small-font"> <?php echo $sem; ?></span></div></td>
						<td  width="20%"><div>SCHOOL YEAR: <span class="small-font"> <?php echo $sy; ?></span></div></td>
						<td  width="20%"><div>SECTION: <span class="small-font"> <?php echo $Section; ?></span></div></td>
				   <tr>
                 
				    <tr>
						<td width="40%"><div>NAME:<span class="small-font"> <?php echo $F_name; ?> <?php echo $M_name; ?>. <?php echo $L_name; ?></span></div></td>
						<td  width="20%"><div>COURSE:<span class="small-font"> <?php echo $Course; ?></span></div></td>
						<td><div>YR. LEVEL: <span class="small-font"> <?php echo $YL; ?></span></div></td>
						<td><div>ENCODER:</div></td>
				    <tr>
				 </table>

              

			   <div class="row" style="font-size: 12px;">
			        <div class="col-md-6">
					       <div>ADDRESS: <span class="small-font">
						                <?php echo $AddNo; ?>, 
						                <?php echo $Addstreet; ?>,
										<?php echo $AddSubd; ?>,
										<?php echo $AddBarangay ; ?>,
										<?php echo $AddCity; ?>,
										<?php echo $AddProvince; ?> 
										</span>
					    </div>
					</div>
					<div class="col-md-6" style="padding-left: 90px;">
					    <div>DATE: <span class="small-font">  <?php echo date("d/m/y") ?> </span></div>
					</div>
			   </div>
  
                  <br>
			
						<table>
							<thead>
								<tr class="success" style="font-size: 13px;">
									<th style="padding-right: 10px;" >Sched Code</th>
									<th style="padding-right: 10px;">Course Code</th>
									<th style="padding-right: 10px;">Course</th>							
									<th style="padding-right: 10px;">Units</th>
									<th style="padding-right: 10px;">Day</th>
									<th style="padding-right: 10px;">Time</th>						
									<th style="padding-right: 10px;">Room</th>
								
						
								</tr>
							</thead>
							 <tbody  style="font-size: 12px;">
								<!-- WITH ENROLLED RESULT -->
						<?php $sched_temp = ''; ?>
	                       <?php foreach($this->data['get_Enrolled'] as $row)  {?>  
								   <?php
								   	 // CHECKER IF NO RESULT IN DAY
								     if ($row->Day  === NULL) {
										$Day = 'TBA';
									  }else{
									    $Day = $row->Day;
									 }  
									 if ($row->Day  === 'H') {
										$Day = 'Th';
									} 
									 // CHECKER IF NO RESULT IN ROOM
								     if ($row->Room  === NULL) {
										$Room = 'TBA';
									  }else{
									    $Room = $row->Room;
									 } 
									 // CHECKER IF NO RESULT IN INSTRUCTOR
									 if ($row->Instructor_Name  === NULL) {
										$Instructor = 'TBA';
									  }else{
									    $Instructor = $row->Instructor_Name;
									 } 
									 // CHECKER IF NO RESULT IN TIME
									 if (($row->Start_Time === NULL) &&($row->End_Time === NULL)) {
										$Time  = 'TBA';
									  }else{
										$St = $row->Start_Time; 
										$Et = $row->End_Time;
							  		    $Time = date("g:i a", strtotime($St)).' - '.date("g:i a", strtotime($Et));
						                }  
							?>
								<?php if($row->Sched_Code != $sched_temp): ?>	
								<tr class="Beld">
									<td valign="top"  width="5%" style="padding-right: 10px; "><?php echo $row->Sched_Code; ?></td>
									<td valign="top" width="10%" style="padding-right: 10px;  padding-top: 1px;"><?php echo $row->Course_Code; ?></td>
									<td valign="top" width="30%" style="padding-right: 10px; padding-top: 1px;"><?php echo $row->Course_Title; ?></td>
									<td valign="top"width="5%" style="padding-right: 10px;  padding-top: 1px;"><?php echo $units; ?></td>	
									<td valign="top" width="5%" style="padding-right: 10px;  padding-top: 1px;"><?php echo $Day; ?></td>			
									<td valign="top" width="15%" style="padding-right: 10px; padding-top: 1px;"><?php echo $Time; ?></td>
									<td valign="top" width="5%" style="padding-right: 10px;  padding-top: 1px;" ><?php echo $Room; ?></td>
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
								<?php $sched_temp = $row->Sched_Code; ?>
							<?php }?>

                           	<!-- WITH ADVISE RESULT -->
						  <?php $sched_temp = ''; ?>
							<?php foreach($this->data['get_Advise'] as $row)  {?>
									<?php
								   	 // CHECKER IF NO RESULT IN DAY
								     if ($row->Day  === NULL) {
										$Day = 'TBA';
									  }else{
									    $Day = $row->Day;
									 } 
									 if ($row->Day  === 'H') {
										$Day = 'TH';
									} 
									  // CHECKER IF NO RESULT IN ROOM
									  if ($row->Room  === NULL) {
										$Room = 'TBA';
									  }else{
									    $Room = $row->Room;
									 }  
									  // CHECKER IF NO RESULT IN INSTRUCTOR
									  if ($row->Instructor_Name  === NULL) {
										$Instructor = 'TBA';
									  }else{
									    $Instructor = $row->Instructor_Name;
									   }  
									   
									    // CHECKER IF NO RESULT IN TIME
									 if (($row->Start_Time === NULL) &&($row->End_Time === NULL)) {
										$Time  = 'TBA';
									  }else{
										$St = $row->Start_Time; 
										$Et = $row->End_Time;
							  		    $Time = date("g:i a", strtotime($St)).' - '.date("g:i a", strtotime($Et));
						                }  
							         ?>
							<?php if($row->Sched_Code != $sched_temp): ?>	
								<tr class="Beld">
									<td valign="top"  width="5%" style="padding-right: 10px; "><?php echo $row->Sched_Code; ?></td>
									<td valign="top" width="5%" style="padding-right: 10px;  padding-top: 1px;"><?php echo $row->Course_Code; ?></td>
									<td valign="top" width="30%" style="padding-right: 10px; padding-top: 1px;"><?php echo $row->Course_Title; ?></td>
									<td valign="top"width="5%" style="padding-right: 10px;  padding-top: 1px;"><?php echo $units; ?></td>	
									<td valign="top" width="5%" style="padding-right: 10px;  padding-top: 1px;"><?php echo $Day; ?></td>			
									<td valign="top" width="15%" style="padding-right: 10px; padding-top: 1px;"><?php echo $Time; ?></td>
									<td valign="top" width="5%" style="padding-right: 10px;  padding-top: 1px;" ><?php echo $Room; ?></td>
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
								<?php $sched_temp = $row->Sched_Code; ?>
							<?php }?>
						   </tbody>
						</table>
					
					<br> <br> <br> <br> <br>

				<!--
				<table style="font-size: 12px; width: 100%;">
					<tr>
					  <td width="25%">  </td>
					  <td width="25%"><div>Tuition:<span class="small-font"> <?php echo $tuition; ?></span></div></td>
					  <td width="25%"><div>Initial Payment:<span class="small-font"> <?php echo $InitialPayment;?></span></div></td>
					  <td width="25%"><div>Total Units:<span class="small-font"> <?php echo $total_units; ?></span></div></td>
					</tr>
					<tr>
					  <td width="25%">  </td>
					  <td width="25%"><div>Miscellaneous Fees:<span class="small-font"> <?php echo $Misc_Fee; ?></span></div></td>
					  <td width="25%"><div>First:<span class="small-font"> <?php echo $FirstPay;?></span></div></td>
					  <td width="25%"><div>Total Subjects:<span class="small-font"> <?php echo $Total_Subject;?></span></div></td>
					</tr>
					<tr>
					   <td width="25%"></td>
					   <td width="25%"><div>Lab Fees:<span class="small-font"> <?php echo $Lab_Fee; ?></span></div></td>
					  <td width="25%"><div>Second:<span class="small-font"> <?php echo $SecondPay;?></span></div></td>
					  <td width="25%"><div>Scholar:<span class="small-font"><?php echo $Scholar; ?> </span></div></td>
					</tr>
					<tr>
					<td width="25%"></td>
					<td width="25%"><div>Other Fees:<span class="small-font"> <?php echo $OF; ?></span></div></td>
					<td width="25%"><div>Third:<span class="small-font"> <?php echo $ThirdPay;?></span></div></td>
					
					</tr>
					<tr>
					<td width="25%"></td>
					<td width="25%"><div>Total Fees:<span class="small-font"> <?php echo $Total_Fees; ?></span></div></td>
					<td width="25%"><div>Fourth:<span class="small-font"> <?php echo $FourthPay;?></span></div></td>
				
					</tr>
				</table>
				-->
	   <br>
	</div>
	</div>	


	<div class="text-center">

		<button class="btn btn-lg btn-danger" onclick="return confirm('Are you sure you want to print?')"  id="printButton">Print</button>
	
	</div>

<br><br><br>







		<br>






		</div>
	</section>
