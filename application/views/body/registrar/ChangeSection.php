


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">assignment_returned</i> Change Section</h1>
		</div>
		<!--/ MODULE TITLE-->


		<div class="row">

			<div class="col-md-4">
			
			<!-- STUDENT SELECTION -->
			<form action="<?php echo base_url(); ?>index.php/Registrar/ChangeSection" method="post">
				<div class="SBorder vertical_gap">
					<h4>Higher Education</h4><hr>

					  <?php if($this->session->flashdata('nosn')): ?>
								<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
										<br>
										<h4><?php echo $this->session->flashdata('nosn'); ?></h4>
									</div>
						 <?php endif; ?>

					<div class="form-line vertical_gap">
						<input class="form-control date" value="<?php echo $this->input->post('student_num') ?>" placeholder="Student Number: <?php echo $stu_num; ?>" name="student_num" type="text" required>
					</div>
					<?php
					//SchoolYear Select
						$options = array(
							'FIRST' => 'FIRST',
							'SECOND' => 'SECOND',
							'SUMMER' => 'SUMMER',
						);
						$js = array(
							'id' => 'ES',
							'class' => 'form-control show-tick',
							'data-live-search' => 'true',
							'required' => 'required',
						);
						echo form_dropdown('Semester', $options, $this->data['Legend'][0]['Semester'], $js);
					?>

					<?php
					//SchoolYear Select
						$datestring = "%Y";
						$time = time();
						$year_now = mdate($datestring, $time);
						$options = array(
							
							'0'=> 'Select School Year',
							($year_now - 1)."-".$year_now => ($year_now - 1)."-".$year_now,
							$year_now."-".($year_now + 1) => $year_now."-".($year_now + 1),
							($year_now + 1)."-".($year_now + 2) => ($year_now + 1)."-".($year_now + 2)
							
						);
						$js = array(
							'id' => 'ES',
							'class' => 'form-control show-tick',
							'data-live-search' => 'true',
							'required' => 'required',
						);
						echo form_dropdown('School_year', $options, $this->data['Legend'][0]['School_Year'], $js);
					?>


					<div class="text-center vertical_gap">
						<button  type="submit" class="btn btn-lg btn-info">SELECT</button>
					</div>
				</div>
			</form>
			<!-- /STUDENT SELECTION -->


		<?php foreach($this->data['data'] as $row)  {
			 

			$ref_num      = $row->Reference_Number;
			$stu_num      = $row->Student_Number;
			$Lname        = $row->Last_Name;
			$Fname        = $row->First_Name;
			$Mname        = $row->Middle_Name;
			$Course       = $row->Course;
			$YL2          = $row->YL;
			$section_n    = $row->Section_Name;
		    $Lec          =	$row->Course_Lec_Unit;
			$Lab          = $row->Course_Lab_Unit;
			$sy           = $row->School_Year;
			$sem          = $row->Semester;
			$major2       = $row->Program_Major;

			$scheduler    = $row->Scheduler;
			$sdate        = $row->Sdate;
			$status       = $row->Status;
			$paymentplan  = $row->Payment_Plan;


			 // CHECKER IF NO MAJOR
			 if ($major  == 0) {
					$major = 'N/A';
				}else{
					$major   = $row->Program_Major;
				} 
				
				$total_units          =  $total_units  + $Lab + $Lec;
        }?>
				<!-- INFO DISPLAY -->
				<div class="SBorder">
					<div class="input-group">
						
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="name_view" placeholder="Name: <?php echo $Lname; ?>, <?php echo $Mname; ?> <?php echo $Fname; ?>">
							
						</div>

				
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="program_view" placeholder="Program: <?php echo $Course; ?>">
							
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Major: <?php echo $major; ?>">
							
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Year: <?php echo $YL2; ?>">
							
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="tuitionfee_view" placeholder="Section: <?php echo $section_n; ?>">
							
						</div>
					
						
					</div>
				</div>
				<!-- /PAYMENT VIEW -->
				<br>

			</div>


			<div class="col-md-8">

				<div class="row">
				<form action="<?php echo base_url(); ?>index.php/Registrar/InsertAndUpdate" method="post">
					<!-- FORM -->
					<!-- Change form depending on need  -->
					<div class="col-md-12" >
						<div class="SBorder row">
							<h4>Section to Changed</h4><hr>

							
						<input type="hidden"  name="ref" value="<?php echo $ref_num; ?>">
					    <input type="hidden"  name="sn" value="<?php echo $stu_num; ?>">
						<input type="hidden"  id="sem" name="sem" value="<?php echo $sem; ?>">
						<input type="hidden"  id="sy" name="sy" value="<?php echo $sy; ?>">
						<input type="hidden"  name="major" value="<?php echo $major2; ?>">
						<input type="hidden"  id="course" name="course" value="<?php echo $Course; ?>">
						<input type="hidden"  name="payment_plan" value="<?php echo $paymentplan; ?>">
						<input type="hidden"  name="scheduler" value="<?php echo $scheduler; ?>">
						<input type="hidden"  name="sdate" value="<?php echo $sdate; ?>">
						<input type="hidden"  name="status" value="<?php echo $status; ?>">
						<input type="hidden"  id="url" value="<?php echo base_url(); ?>">


				

							<div class="col-md-8 rightline">
							   <div class="input-group">
								 <div class="form-line">
                                
								<select   onchange="getsched()" data-live-search="true"  id="sections" class="danger" name="section" required>             
								       <option>SELECT SECTION</option>
										<?php foreach($this->data['section'] as $row)  {?>
										<option><?php echo $row->Section_Name; ?> </option>
										<?php }?>
								</select>

						         </div>
								</div>
							</div>
							<div class="col-md-4 text-center">
                                <button class="btn btn-danger" id="submit" type="submit" onclick="return confirm('Please Review Before Proceeding, Do you Confirm these Changes?')" name="search_button"> Change </button>
                                <button class="btn btn-info" type="submit" name="export" value="Export" > Clear </button>
                            </div> 
							
						</div>
					
					</div> 
					<!-- /FORM -->

					<div class="col-md-12">
					    <div class="SBorder">
				             <div class="input-group">
                                 <div class="col-md-6">
									<div class="form-line">
										<input class="form-control date" disabled  type="text" id="Total_Units" placeholder="Total Units: <?php echo $total_units; ?>">
									</div>
								 </div>
								 <div class="col-md-6">
									<div class="form-line">
										<input class="form-control date" disabled  type="text" id="Total_Subjects" placeholder="Total Subjects: <?php echo  $this->data['get_TotalCountSubject']->num_rows();?>">
									</div>
								 </div>
										
					        </div>
				         </div>
					</div>
  
					<!-- DISPLAYS SUBJECT OF CHOSEN STUDENT -->
					<div class="col-md-12" >
						<div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
							<div class="panel" style="background-color:#cc0000; color:#fff">
								<div class="panel-heading" role="tab" id="headingOne_19">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" href="#collapseOne_19" aria-expanded="true" aria-controls="collapseOne_19">
											<i class="material-icons">arrow_drop_down</i> SUBJECTS 
										</a>
									</h4>
								</div>
								<div id="collapseOne_19" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_19" >
									<div class="panel-body" style="background-color:#fff; overflow:auto; max-height:300px">
										<table  id="adada"  class="table table-bordered">
											<thead>
												<tr class="danger" style="font-size:14px">
												     <th></th>
													<th>Sched Code</th>
													<th>Course Code</th>
													<th>Lec Unit</th>
													<th>Lab Unit</th>
													<th>Section</th>
												</tr>
											</thead>
											<tbody id="schedtable">

                                               <div id="IDasa"></div> 
											   <div id="IDSection"></div> 
											   <div id="IDSchoolYear"></div> 
											   <div id="IDYearLevel"></div> 
											   <div id="IDSemester"></div> 

									
                                                   

											<?php  foreach($this->data['data'] as $row){  ?>
												<tr>
												    <td><input type="checkbox" checked name="schedData[]" value="<?php echo $row->Sched_Code; ?>"></td>
												    <td><?php echo $row->Sched_Code; ?></td>
													<td><?php echo $row->Course_Code; ?></td>
													<td><?php echo $row->Course_Lec_Unit; ?></td>
													<td><?php echo $row->Course_Lab_Unit; ?></td>
													<td><?php echo $row->Section_Name; ?></td>

										        </tr>
											<?php } ?>
											

											</tbody>

											
										</table>

									</div>

                                 
								</div>
							</div>
						</div>
					</div>
					<!-- DISPLAYS SUBJECT OF CHOSEN STUDENT -->
					</form>   
				</div>
			</div>

		</div>
	</div>
	<!--/CONTENT GRID-->

</section>



	<script src="<?php echo base_url(); ?>js/change_section.js"></script>
  
	


