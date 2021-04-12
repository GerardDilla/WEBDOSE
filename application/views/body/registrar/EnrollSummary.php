
<section class="content" style="background-color: #fff;">
		<div class="container-fluid">
			<div class="block-header">
		     	<h3>Enrollment Summary</h3>
			</div>
	<form action="<?php echo base_url(); ?>index.php/Registrar/Summary" method="post">
			<div class="row">
		        <div class="col-md-6">
				       <div class="SBorder">
						   <b>Enrolled Status</b>
					           <select class="form-control show-tick">
                                     <option>Select all Enrolled and Reservation:</option>
                                     <option>Enrolled</option>
                                     <option>Reservation</option>
						       </select>
						</div>
				</div>
				<div class="col-md-6">
			     	<div class="row">
		                <div class="col-md-6">
					     	<div class="SBorder">
							  <?php 
                                    //Semester DROPDOWN
                                    $class = array('class' => 'form-control show-tick',);
                                    $options =  array(
                                    ''        => 'Select Semester',
                                    'FIRST'   => 'FIRST',
                                    'SECOND'  => 'SECOND',
                                    'SUMMER'  => 'SUMMER',
                                    );

                                     echo form_dropdown('sem', $options, $this->input->post('sem'),$class);

                             ?>  
								  <br>

								  <?php 
                                    //SELECT Nationality
                                    $class = array('class' => 'form-control show-tick',
                                                   'data-live-search'   => 'true',  
                                             );
                                    $options =  array('' => 'Select SchoolYear:');
                                    foreach($this->data['get_sy']->result_array()  as $row) {

                                        $options[$row['School_Year']] = $row['School_Year'];
                                        }
                                    echo form_dropdown('sy', $options, $this->input->post('sy'),$class);
                                 ?>  

							<?php
								//SchoolYear Select
								//	$datestring = "%Y";
								//	$time = time();
								//	$year_now = mdate($datestring, $time);
								//	$options = array(
										
									//	'0'=> 'Select School Year',
									//	($year_now - 1)."-".$year_now => ($year_now - 1)."-".$year_now,
									//	$year_now."-".($year_now + 1) => $year_now."-".($year_now + 1),
									//	($year_now + 1)."-".($year_now + 2) => ($year_now + 1)."-".($year_now + 2)
										
								//	);
								//	$js = array(
									//	'id' => 'ES',
									//	'class' => 'form-control show-tick',
									//	'data-live-search' => 'true',
									//	'required' => 'required',
								//	);
								//	echo form_dropdown('sy', $options,$this->input->post('sy'), $js);
								?>
                           
								  <br>
						     </div>
						</div>
				    <div class="col-md-6">
				     	<div class="row">
		                   <div class="col-md-6">
							   <button class="btn-danger"  type="submit" name="submit" style=" width: 100%; height: 90px;">Search</button>
						   </div>
					

					   
						   <div class="col-md-6">
						        <button class="btn-success"  type="submit" name="export" value="Export"  style=" width: 100%; height: 90px;">Export</button>
						   </div>
		            	</div>

					</form>
				    </div>
				 </div>
	       </div>	 
	   </div>

				 <br>

				 <div class="body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="danger">
                                        <th>#</th>
                                        <th>Course</th>
                                        <th>NEW</th>
										<th>OLD</th>
										<th>WITHDRAW</th>
										<th>TOTAL</th>
										<th>ENLISTED</th>
										<th>FIRST</th>
										<th>SECOND</th>
										<th>THIRD</th>
										<th>FOURTH</th>
										<th>FIFTH</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
									
									   <?php 
									   $count = 1;
									    foreach($this->data['list'] as $row)  {
										 
										if ($row['program']  === NULL) {
												$Major = 'N/A';
										}else{
												$Major = $row['program'];		
										} 

										 
											$New         = $row['new'];
											$Old         = $row['old']; 
											$FirstY      = $row['1st']; 
											$SecondY     = $row['2nd']; 
											$ThirdY      = $row['3rd']; 
											$FourthY     = $row['4th']; 
											$FiftY       = $row['5th']; 
											$Withdraw    = $row['withdraw']; 
											$Enlisted    = $row['Enlisted']; 


									     $Difference = 0; 
										 $Difference = $row['old'] - $row['new'];
										 
                                         /// Sum = NEw  + Old 
										$SumOfOldAndNew  = $New + $Difference;

										/// Sum of New
										 $SumOfNew = $SumOfNew + $New;

										 /// Sum of Old
										 $SumOfOld = $SumOfOld + $Difference;

										 /// Sum of Withdraw
										 $SumOfWithdraw = $SumOfWithdraw + $Withdraw;

										 /// Total Sum 
										 $TotalSumOfOldAndNew =  $SumOfNew  + $SumOfOld;

										 /// Total First Year
										 $TotalFirstY = $TotalFirstY + $FirstY;

										  /// Total Second Year
										  $TotalSecondY = $TotalSecondY + $SecondY;

										  /// Total 3rd Year
										  $TotalThirdY = $TotalThirdY + $ThirdY;

										  /// Total 4th Year
										  $TotalFourthY = $TotalFourthY + $FourthY;

										  /// Total 5th Year
										  $TotalFifthY  = $TotalFifthY  + $FiftY;

                                          /// Total Enlisted
										  $TotalEnlisted = $TotalEnlisted  + $Enlisted;
										
										?>  
									
                                        <th scope="row"><?php echo $count;  ?></th>
										<td><?php echo $Major; ?></td>
										<td class="text-center"><?php echo $row['new']; ?></td>
										<td class="text-center"><?php echo $Difference; ?></td>
										<td class="text-center"><?php echo $row['withdraw']; ?></td>
										<td class="text-center danger"><?php echo $SumOfOldAndNew; ?></td>
										<td class="text-center"><?php echo $row['Enlisted']; ?></td>
										<td class="text-center"><?php echo $row['1st']; ?></td>
										<td class="text-center"><?php echo $row['2nd']; ?></td>
										<td class="text-center"><?php echo $row['3rd']; ?></td>
										<td class="text-center"><?php echo $row['4th']; ?></td>
										<td class="text-center"><?php echo $row['5th']; ?></td>
                                        
                                    </tr>
									<?php  $count = $count + 1;}?>
								   <tr style="background-color: #f2dede;">
									  <th colspan="2">TOTAL</th>
									  <th class="text-center"><?php echo $SumOfNew; ?></th>
									  <th class="text-center"><?php echo $SumOfOld; ?></th>
									  <th class="text-center"><?php echo $SumOfWithdraw; ?></th>
									  <th class="text-center"><?php echo $TotalSumOfOldAndNew; ?></th>
									  <td class="text-center"><?php echo $TotalEnlisted; ?></td>
									  <th class="text-center"><?php echo $TotalFirstY; ?></th>
									  <th class="text-center"><?php echo $TotalSecondY; ?></th>
									  <th class="text-center"><?php echo $TotalThirdY; ?></th>
									  <th class="text-center"><?php echo $TotalFourthY; ?></th>
									  <th class="text-center"><?php echo $TotalFifthY; ?></th>
									</tr>
                                </tbody>
                            </table>
                        </div>
			  
			
	       
			
		
	</div>
</section>

