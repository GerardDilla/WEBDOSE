<section class="content" style="background-color: #fff;">
	<div class="container-fluid">
		<div class="block-header">
			<h1>Advising</h1>
		</div><!-- Basic Example -->

		<?php if($this->session->flashdata('advising_error') || $this->session->flashdata('advising_success')): ?>
		<br>
			<h3 class="col-red">
				<?php echo $this->session->flashdata('advising_error'); ?>
			</h3>
			<h3 class="col-green">
				<?php echo $this->session->flashdata('advising_success'); ?>
			</h3>
		<br>
		<?php endIf; ?>

		<div class="row">

			<!-- Student/ Reference Number search -->
			<div class="col-md-10">
				<hr>
				<form action="<?php echo site_url()."/Advising/get_student_information"; ?>" method="post">
						<div class="input-group">
							<span class="input-group-addon"><i class="material-icons">person</i></span>
							<div >
								<!--
								<h3 class="danger"><?php echo validation_errors(); ?></h3>
								<h3 class="danger" style="color:#cc0000"><?php echo $this->data['error']; ?> </h3>
								-->
								<?php if(validation_errors()): ?>
									<div class="alert bg-orange alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4><?php echo validation_errors(); ?></h4>
									</div>
								<?php endIf; ?>

								<?php if($this->data['error']): ?>
									<div class="alert bg-orange alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4><?php echo $this->data['error']; ?></h4>
									</div>
								<?php endIf; ?>

							</div>
							<div class="form-line">
								<input class="form-control date" placeholder="STUDENT NUMBER / REFERENCE NUMBER" name="id" type="text">
							</div>
							<div >
								<button type="submit" class="btn btn-default">
									<i class="material-icons" style="font-size:100%">person</i>
									Check Student
								</button>

								<!-- Advise Student -->		
								<button type="button" class="btn btn-success" onclick="adviseStudentCheck()">
								<i class="material-icons" style="font-size:100%">note_add</i>
								ADVISE STUDENT
								</button>
								<!-- Advise Student -->

								<!-- Print Temporary Registration Form: data-toggle="modal" data-target="#regform" -->		
								<?php if(!empty($this->data['AdvisedCheck'])): ?>
									<button type="button" class="btn btn-success" onclick="trf_ajax('<?php echo $this->data['student_info'][0]['Reference_Number']; ?>')">
										<i class="material-icons" style="font-size:100%">local_printshop</i>
										ASSESSMENT FORM:  <?php echo $this->data['AdvisedCheck'][0]['School_Year'].', '.$this->data['AdvisedCheck'][0]['Semester']; ?>
										<img width="20" class="searchloader" src="<?php echo base_url(); ?>img/ajax-loader.gif" />
									</button>
								<?php endIf; ?>
								<!-- Print Temporary Registration Form -->

								<?php if ($this->data['advising_session'] != NULL): ?>
								<?php foreach($this->data['advising_session'] as $row){
									$sem = $row['Semester'];
									$sy = $row['School_Year'];
									$refnum = $row['Reference_Number'];
								} 
								?>
								<!-- Advise Student 
								<a href="<?php echo base_url(); ?>index.php/Advising/temporary_regform/<?php echo $refnum; ?>/<?php echo $sy; ?>/<?php echo $sem; ?>" class="btn btn-info" >Print Temporary RegForm</a>
								 Advise Student -->
								<?php endIf; ?>



							</div>
						</div>
				</form>
				<hr>
			</div>
			<!-- /Student/ Reference Numeber search -->
			
			<div class="col-md-3">

				<!-- insert form here later -->
				<div class="SBorder">

					<?php
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
							'id' => 'schoolYear',
							'class' => 'form-control show-tick sy-sem-sec-choice',
							'data-live-search' => 'true',
							'onchange' => 'setCourseSchedList()'	
						);
						if($this->data['advising_session_set']['disable'])
						{
							$js['disabled'] = 'disabled';
						}

						echo form_dropdown('school_year', $options, $this->data['advising_session_set']['school_year']?:$this->data['legend'][0]['School_Year'], $js);
					?>

					<br>
					<br>

					<?php
						$options = array(
							'0'=> 'Select Semester',
							'FIRST' => 'FIRST',
							'SECOND' => 'SECOND',
							'SUMMER' => 'SUMMER'
						);
						
						$js = array(
							'id' => 'semester',
							'class' => 'form-control show-tick sy-sem-sec-choice',
							'data-live-search' => 'true',
						);
						if($this->data['advising_session_set']['disable'])
						{
							$js['disabled'] = 'disabled';
						}
						echo form_dropdown('semester', $options, $this->data['advising_session_set']['semester']?:$this->data['legend'][0]['Semester'], $js);

					?>
					
					<br>
					<br>

					<?php if($this->data['student_curriculum']): ?>
							<div class="row" style="margin:0px; width:100%">
								<div class="col-sm-10" style="padding:0px">
									<select id="curriculum" class="form-control show-tick" data-live-search="true" name="curriculum">
										<?php foreach ($this->data['curriculum_list'] as $key => $curriculum):
											//list of curriculum with the given program
										?>
											<?php 
											$select = '';
											if($this->data['student_curriculum'][0]['Curriculum_ID'] == $curriculum['Curriculum_ID']){
												$select = 'selected';
											}
											else{
												$select = '';
											}
											?>
											<option value="<?php echo $curriculum['Curriculum_ID'] ?>" <?php echo $select; ?>><?php echo $curriculum['Curriculum_Name'] ?></option>
										<?php endForeach; ?>
									</select>
								</div>
								<div class="col-sm-2 rowpointer" style="padding:0px" data-toggle="tooltip" title="VIEW SUBJECTS TAKEN / STATUS">
									<button type="button" class="btn btn-info " style="padding:0; width:35px; height:34px;" onclick="show_curriculum()">
										<i class="material-icons" style="font-size: 27px;">search</i>
									</button>
								</div>
							</div>
					<?php else: ?>
							<select id="curriculum" class="form-control show-tick" data-live-search="true" name="curriculum">
								<option disabled selected>
									Select Curicullum
								</option>
								<?php foreach ($this->data['curriculum_list'] as $key => $curriculum): ?>
										<option value="<?php echo $curriculum['Curriculum_ID'] ?>"><?php echo $curriculum['Curriculum_Name'] ?></option>
								<?php endForeach; ?>
							</select> 
					<?php endIf; ?>

					<br>

					<select id="section" class="form-control show-tick sy-sem-sec-choice" data-live-search="true" name="section" onchange="checkinputs()" <?php echo $this->data['advising_session_set']['disable']; ?> >
						<option disabled selected>
							Select Section
						</option>
						<?php foreach ($this->data['section_list'] as $key => $section): ?>
								<option value="<?php echo $section['Section_ID']; ?>" <?php if($this->data['advising_session_set']['section'] == $section['Section_ID']): ?>selected <?php endIf; ?>> <?php echo $section['Section_Name']; ?></option>
						<?php endForeach; ?>
					</select>
					
					<br>
					<br>
					  
								
                    <!-- BY PASS STUDENT 
					<div class="text-center">
					     <div class="demo-checkbox">
                                <input type="checkbox" id="basic_checkbox_1">
                                <label for="basic_checkbox_1"><span class="green">Bypass Student</span></label>
                            </div>
					</div>
					-->

					<div class="text-center">
					
						<div class="form-group">

							<input class="with-gap" id="nongraduatingradio" name="graduatingchoice" value="0" type="radio" onclick="checkinputs()" <?php echo $this->data['advising_session_set']['disable']; ?> <?php echo $this->data['advising_session_set']['nongraduating']; ?>> 
							<label class="m-l-20" for="nongraduatingradio">Non Graduating (33 Units)</label>

							<input class="with-gap" id="graduatingradio" name="graduatingchoice" value="1" type="radio" onclick="checkinputs()" <?php echo $this->data['advising_session_set']['disable']; ?> <?php echo $this->data['advising_session_set']['graduating']; ?>> 
							<label for="graduatingradio">Graduating (30 Units)</label> 

							<?php if($this->data['student_info'][0]['Course'] == 'BSP'): ?>
								<input class="with-gap" id="pharmaradio" name="graduatingchoice" value="2" type="radio" onclick="checkinputs()" <?php echo $this->data['advising_session_set']['disable']; ?> <?php echo $this->data['advising_session_set']['pharma']; ?>> 
								<label for="pharmaradio">Pharmacy (34 Units)</label>
							<?php endIf; ?>

							
						</div>
					</div>
 
					<div class="text-center">
						<div class="form-group">
							<input class="with-gap studType" id="studTypeBlock" name="stud_type" value="block" type="radio" onclick="checkinputs()" <?php echo $this->data['advising_session_set']['disable']; ?> <?php echo $this->data['advising_session_set']['block']; ?>> <label for="studTypeBlock">Block</label> 
							<input class="with-gap studType" id="studTypeOpen" name="stud_type" value="open" type="radio" onclick="checkinputs()" <?php echo $this->data['advising_session_set']['disable']; ?> <?php echo $this->data['advising_session_set']['open']; ?>> <label class="m-l-20" for="studTypeOpen">Open</label>
						</div>
					</div>

					<!-- insert hidden value here -->
					<input type="hidden" id="addressUrl" value="<?php echo site_url().'/Advising'; ?>"/>
					<input type="hidden" id="baseurl" value="<?php echo base_url(); ?>"/>
					
				</div>
				
				<br>

				<!-- Add Schedule Modal -->			
				<div class="text-center">
					<button class="btn btn-lg btn-danger" id="add_sched_button"  onclick="checkSchedList()">
					Add Schedule 
					<img width="20" class="searchloader" src="<?php echo base_url(); ?>img/ajax-loader.gif" />
					</button>
					<!--<button class="btn btn-danger" onclick="displaySched(201720071, '<?php echo site_url().'/Advising/get_sched_list'; ?>', '<?php echo site_url().'/Advising/get_time'; ?>')" data-target="#largeModal">checker</button> -->
				</div>
				<br>
				<!-- /Add Schedule Modal -->
 
				<!-- PAYMENT SELECTION -->
				<select id="plan" class="form-control show-tick" data-live-search="true" name="plan" onchange="setPaymentPlan()"  >
					<option disabled selected>
						Select Payment Plan
					</option>
					<option value="full">Full</option>
					<option value="installment">Installment</option>
				</select>
				<br>
				<!-- /PAYMENT SELECTION -->

				<!-- PAYMENT VIEW -->
				<input type="hidden" name="reference_no" value="<?php echo $student_info['Reference_Number'] ?>" />
				<!-- insert view fees -->
				<div class="SBorder">
					<div class="input-group">
						
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="other_fee" value="<?php echo "Other Fee: ".$this->data['fees']['other_fee']; ?>">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="misc_fee" value="<?php echo "Misc Fee: ".$this->data['fees']['misc_fee']; ?>">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="lab_fee" value="<?php echo "Lab Fee: ".$this->data['fees']['lab_fee']; ?>">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="tuition_fee" value="<?php echo "Tuition: ".$this->data['fees']['tuition_fee']; ?>">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="total_fee" value="<?php echo "Total Fee: ".$this->data['fees']['total_fee']; ?>">
						</div>
						
					</div>
				</div>
				<!-- /PAYMENT VIEW -->
				<br>

			</div>

			<div class="col-md-9">

				<div class="row">
					<div class="col-md-6">

						<?php foreach ($this->data['student_info'] as $key => $student_info): ?>
							<!-- student basic information note: temporary change the design if necessary -->
							<div class="SBorder">
								<div class="input-group">
									<h4 style="display:inline-block">
										<span class="label label-primary">
											<?php 
												if(!empty($this->data['AdvisedCheck'])){
													echo 'Last Advised: <u>'.$this->data['AdvisedCheck'][0]['School_Year'].', '.$this->data['AdvisedCheck'][0]['Semester'].'</u>';
												}
												else{
													echo 'Not Advised';
												}
											?>
										</span>
									</h4>
									<div class="form-line">
										<input class="form-control date capitalizetext" disabled placeholder="First Name" type="text" value="<?php echo $student_info['First_Name'].' '.$student_info['Middle_Name'].' '.$student_info['Last_Name']; ?>">
									</div>
									<div class="form-line">
										<input class="form-control date capitalizetext" disabled type="text" id="OutstandingBalance" data-token="<?php echo $this->data['encrypt_referencenumber']; ?>" data-outstanding="" value="Outstanding Balance: ">
									</div>
									<input type="hidden" id="referenceNo" value="<?php echo $student_info['Reference_Number'] ?>" />
									<input type="hidden" id="studentNo" value="<?php echo $student_info['Student_Number'] ?>" />
								</div>
							</div>
							<br>
							<!-- end of student basic information note: temporary change the design if necessary -->
						
						<?php endForeach; ?>

					</div>

					<div class="col-md-6">

						<?php foreach ($this->data['student_info'] as $key => $student_info): ?>

							<?php
								//check if the student is new
							if ( ($student_info['Student_Number'] === 0) || ($student_info['Course'] === "N/A") ):
							?>

									<div class="SBorder">
										<div class="input-group">
											<div class="form-line">
												<label>First Choice</label>
											</div>
											<div class="form-line">
												<input class="form-control date" disabled placeholder="Programs" type="text" value="<?php echo $student_info['Course_1st']; ?>">
											</div>
											<div class="form-line">
												<input class="form-control date" disabled placeholder="Major" type="text" value="<?php echo $student_info['1st_major']; ?>">
											</div>
										</div>
									</div>
									<br>
									<div class="SBorder">
										<div class="input-group">
											<div class="form-line">
												<label>Second Choice</label>
											</div>
											<div class="form-line">
												<input class="form-control date" disabled placeholder="Programs" type="text" value="<?php echo $student_info['Course_2nd']; ?>">
											</div>
											<div class="form-line">
												<input class="form-control date" disabled placeholder="Major" type="text" value="<?php echo $student_info['2nd_major']; ?>">
											</div>
										</div>
									</div>
									<br>
									<div class="SBorder">
										<div class="input-group">
											<div class="form-line">
												<label>Third Choice</label>
											</div>
											<div class="form-line">
												<input class="form-control date" disabled placeholder="Programs" type="text" value="<?php echo $student_info['Course_3rd']; ?>">
											</div>
											<div class="form-line">
												<input class="form-control date" disabled placeholder="Major" type="text" value="<?php echo $student_info['3rd_major']; ?>">
											</div>
										</div>
									</div>
									<br>

							<?php else: ?>

									<div class="SBorder">
										<div class="input-group"style="margin-bottom: 10px;">
											<div class="form-line">
												<input class="form-control date" readonly="true" id="student_program" placeholder="Programs" type="text" value="<?php echo $student_info['Course']; ?>">
											</div>
											<div class="form-line">
												<input class="form-control date" disabled placeholder="Major" type="text" value="<?php echo $student_info['Program_Major']; ?>">
											</div>
										</div>
									</div>

							<?php endIf; ?>
							
						<?php endForeach; ?>

						
						<?php if(!$this->data['student_info']): ?>
		
								<div class="SBorder">
									<div class="input-group">
									
										<div class="form-line">
											<input class="form-control date" disabled placeholder="Programs" type="text" value="">
										</div>
										<div class="form-line">
											<input class="form-control date" disabled placeholder="Major" type="text" value="">
										</div>
									</div>
								</div>
								<br>
							
						<?php endIf; ?>
					
					</div>

					<div class="col-md-12">
						<!-- USED ACCORDION FOR THE ADDED SUBJECTS DESIGN: GERARD-->
						<div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
							<div class="panel" style="background-color:#cc0000; color:#fff">
								<div class="panel-heading" role="tab" id="headingOne_19">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" href="#collapseOne_19" aria-expanded="true" aria-controls="collapseOne_19">
											<i class="material-icons">arrow_drop_down</i> VIEW QUEUED SUBJECTS  
											<img class="searchloader" style="display:none" src="<?php echo base_url(); ?>img/ajax-loader.gif" />
											<span class="pull-right">TOTAL UNITS: <u id="total_units" data-units="0">0</u>
											</span>
										</a>
									</h4>
								</div>
								<div id="collapseOne_19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_19">
									<div class="panel-body" style="background-color:#fff; overflow:auto; max-height:300px">
										<table id="tableAdvisingSessionList" class="table table-bordered">
											<thead>
												<tr class="danger" style="font-size:14px">
													<th>Sched Code</th>
													<th>Course Code</th>
													<th>Course Title</th>
													<th>Section</th>
													<th>Lec Unit</th>
													<th>Lab Unit</th>

													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach ($this->data['advising_session'] as $key => $sched) 
													{
														# code...
														

												?>
														<tr>
															<td><?php echo $sched['Sched_Code']; ?></td>
															<td><?php echo $sched['Course_Code']; ?></td>
															<td><?php echo $sched['Course_Title']; ?></td>
															<td><?php echo $sched['Section_Name']; ?></td>
															<td><?php echo $sched['Course_Lec_Unit']; ?></td>
															<td><?php echo $sched['Course_Lab_Unit']; ?></td>

															<td><button  class="btn btn-danger" onclick="removeSched(<?php echo $sched['session_id']; ?>)" > Remove </button> </td>
														</tr>


												<?php
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div id="schedTable" class="table panel panel-danger" style="overflow-x:auto; max-height:500px">
							<table id="schedTableOutput" class="table table-bordered">
								<thead>
									<tr class="danger">
										<th>Time</th>
										<th class="text-center">M</th>
										<th class="text-center">T</th>
										<th class="text-center">W</th>
										<th class="text-center">TH</th>
										<th class="text-center">F</th>
										<th class="text-center">S</th>
										<th class="text-center">A</th>
									</tr>
								</thead>
								<tbody>
									
									<?php
										foreach ($this->data['time'] as $time) 
										{
											# code...
											
											
											
										
									?>
										<tr>
											<td><?php echo $time['Schedule_Time']; ?></td>
											<?php 
											$array_day = array('M', 'T', 'W', 'H', 'F', 'SA', 'SU');
											foreach ($array_day as $value) 
											{
												# code...
											
											?>
												<td id="<?php echo $time['Time_From']; ?>_<?php echo $value; ?>"></td>
											<?php 
											}
											?>

										</tr>	
									<?php
											
										}
									?>
							
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>


<!-- Large Size -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" style="width:100%" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h2 id="largeModalLabel">Add Schedule</h2>
						</div>
						<div class="modal-body">

							<br> <br>
							<div class="row">
								<!--
								<div class="col-md-6">
											<input id="searchSched" onkeyup="searchSchedV2()" class="form-control" placeholder="Search Schedule..." type="text" />
									<br>
									</div>
									-->
								<div class="col-md-2">
									<select id="schedSearchType" class="form-control show-tick" data-live-search="true">
										<option disabled selected>
											Select Search Type
										</option>
										<option value="Course_Code">Course Code</option>
										<option value="Sched_Code">Sched Code</option>
										<option value="Course_Title">Course Title</option>

									</select>
								
								</div>
								<div class="col-md-2">
									<input id="schedSearchValue" class="form-control" placeholder="Search Schedule..." type="text" style="margin-top: 0px;" />
								</div>
								<div class="col-md-2">
									<button class="btn btn-lg btn-info" id="schedSearchSubmit" type="button" onclick="searchOpenSchedList()" disabled style="height: 34px;">SEARCH</button>
								</div>
								<div class="col-md-2 searchloader" style="padding: 1%; display:none">
									LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
								</div>
								<div class="col-md-2 pull-right">
									<h6 class="card-inside-title">Bypass Pre-Requisite <br>(Requires Program Chair Login)</h6>
									<div class="demo-switch">
										<div class="switch">
											<label>OFF<input type="checkbox" name="bypass_check" id="bypassCheck" value="1"><span class="lever"></span>ON</label>
										</div>
									</div>
									<br>
								</div>
							</div>

							<div class="table panel panel-danger" style="overflow-x:auto; max-height:500px">
								<table id="tableSelectSchedule" class="table table-bordered">
									<thead>
										<tr class="danger">
											<th>Sched Code</th>
											<th>Course Code</th>
											<th>Course Title</th>
											<th>Section</th>
											<th>Lec Unit</th>
											<th>Lab Unit</th>
											<th>Day</th>
											<th>Time</th>
											<th>Room</th>

											<th>Remaining Slot</th>
											<th>Instructor Name</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
										<td colspan="10" align="center">No Data</td>
										</tr>
									</tbody>
								</table>
							</div>
							<br>
							<div id="openSchedPagination"> </div>

						</div>
						<div class="modal-footer" id="AddSched_Button_Panel">
								<!-- Will only show if block section. Function: toggleAddAllButton() -->
						</div>
				</div>
		</div>
</div>

<form action="<?php echo site_url().'/Advising/advise_student'; ?>" method="post">	

	<!-- Small Size -->
	<div class="modal fade" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content" style="padding:10px">
						<div class="modal-header">
								<h4 class="modal-title" id="smallModalLabel">Advise Student</h4>
						</div>
						<div class="modal-body" >
							<input type="hidden" name="reference_no" value="<?php echo $student_info['Reference_Number'] ?>" />
							<div style="font-size:50px; text-align:center" id="msg_icon">
								<i class="material-icons col-red" style="font-size:50px;">announcement</i>
							</div>
							<ul class="row danger" id="errorAdvising">
							
							</ul>
							<div class="row">
								<div class="col-md-12">
									<input id="curriculumName"  class="form-control" placeholder="Curriculum" type="hidden" disabled/>
									<input type="hidden" id="curriculumValue" name="curriculum" value="" />
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<input id="planName"  class="form-control" placeholder="Plan" type="hidden" disabled/>
									<input type="hidden" id="planValue" name="plan" value="" />
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<input type="hidden" id="semesterValue" name="semester" value="" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" id="schoolYearValue" name="school_year" value="" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" id="sectionValue" name="section" value="" />
								</div>
							</div>

							<br><br>		
							<div class="row">
								<div class="col-md-12">
									<!--<input id="planName"  required class="form-control" placeholder="Payment Amount" name="payment" type="number"  />-->
									<input required placeholder="Payment Amount" name="payment" type="hidden" value="0" />
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
							<!--<button type="button" class="btn btn-success waves-effect" id="adviseSubmit" data-target="#confirmation" onclick="showConfirmation()" class="btn btn-link waves-effect" >Proceed</button>-->
						</div>
				</div>
		</div>
	</div>

	<!-- Modal Confirmation-->
	<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Schedule</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Are you sure you want to Advise the student?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success waves-effect" data-dismiss="modal">CLOSE</button>
					<button type="submit" id="adviseSubmitConfirm" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();" name="savesubject" class="btn btn-success">SAVE CHANGES</button>
				</div>
			</div>
		</div>
	</div>

</form>

<!-- Curriculum Modal-->
<div class="modal fade" id="curriculum_modal" tabindex="-1" role="dialog" aria-labelledby="curriculum" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Taken Subjects</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
					<div style="overflow:auto; max-height:300px">
						<table class="table table-bordered">
							<thead>
								<tr class="danger">
									<th>School Year</th>
									<th>Semester</th>
									<th>Course Code</th>
									<th>Course Title</th>
									<th>Remarks</th>
								</tr>
							</thead>
							<tbody id="taken_subjects">
								<tr>
									<td colspan="10" align="center">No Data</td>
								</tr>
							</tbody>
						</table>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success waves-effect" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div>
</div>

<!-- Temporary RegForm Modal -->
<div class="modal fade" id="regform" tabindex="-1" role="dialog" aria-labelledby="regform" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body row regform_adjust_mobile" id="trf_print_content">
				<!--Regform Header-->
				<div class="col-lg-12" style="text-align:center">
				<img src="<?php echo base_url(); ?>/img/SdcaHeader.jpg" width="80%" height="auto">
				</div>
				<!--/Regform Header-->
				<div class="col-lg-12" style="text-align:center; color:#000">
					<strong>ASSESSMENT FORM</strong>
					<hr>
					<table style="width:100%">
						<tbody>
							<tr class="success" style="font-size: 12px; text-align:left">
								<td width="40%" style="padding:0px 10px 0px 0px" valign="top">
									<strong>REFERENCE NUMBER:</strong> <span id="trf_rn">STUDENT NUMBER</span> <br>
									<strong>NAME:</strong> <span id="trf_name" class="capitalizetext">NAME</span> <br>
									<strong>ADDRESS:</strong> <span id="trf_address">ADDRESS</span> <br>
								</td>
								<td width="20%" style="padding:0px 10px 0px 0px" valign="top">
									<strong>SEMESTER:</strong> <span id="trf_sem">SEMESTER</span> <br>
									<strong>COURSE:</strong> <span id="trf_course">COURSE</span> <br>
								</td>
								<td width="20%" style="padding:0px 10px 0px 0px" valign="top">
									<strong>SCHOOL YEAR:</strong> <span id="trf_sy">SCHOOL YEAR</span> <br>
									<strong>YEAR LEVEL:</strong> <span id="trf_yl">YEAR LEVEL</span> <br>
								</td>							
								<td width="20%" style="padding:0px 10px 0px 0px" valign="top">
									<strong>SECTION:</strong> <span id="trf_sec">SECTION</span> <br>
									<strong>DATE:</strong> <span id="trf_date"><?php echo date('m-d-Y'); ?></span> <br>
								</td>
							</tr>
						</tbody>
					</table>
					<hr>
					<table>
						<thead>
							<tr class="success" style="font-size: 13px;">
								<th style="padding-right: 10px;">Sched Code</th>
								<th style="padding-right: 10px;">Course Code</th>
								<th style="padding-right: 10px;">Course</th>							
								<th style="padding-right: 10px;">Units</th>
								<th style="padding-right: 10px;">Day</th>
								<th style="padding-right: 10px;">Time</th>						
								<th style="padding-right: 10px;">Room</th>
							</tr>
						</thead>
						<tbody id="temporary_regform_subjects" style="font-size: 12px; text-align:left">
							<!-- WITH ENROLLED RESULT -->
																	
							<tr class="Beld">
								<td valign="top" width="10%" style="padding-right: 10px; ">201830493</td>
								<td valign="top" width="10%" style="padding-right: 10px;  padding-top: 1px;">EU321</td>
								<td valign="top" width="25%" style="padding-right: 10px; padding-top: 1px;">Community Leadership</td>
								<td valign="top" width="5%" style="padding-right: 10px;  padding-top: 1px;">1</td>	
								<td valign="top" width="5%" style="padding-right: 10px;  padding-top: 1px;">T</td>			
								<td valign="top" width="15%" style="padding-right: 10px; padding-top: 1px;">12:00PM-1:00PM</td>
								<td valign="top" width="10%" style="padding-right: 10px;  padding-top: 1px;">COMP LAB 2</td>
							</tr>
						</tbody>
					</table>
					<hr>
					<table class="pull-right" style="font-size: 13px; width: 80%; text-align:left">
						<tr>
							<td><strong>Tuition:</strong></td>
							<td class="feesbox" id="trf_tuition">T0000000</td>

							<td><strong>Initial Payment:</strong></td>
							<td class="feesbox" id="trf_initial">T0000000</td>
							
							<td><strong>Total Units:</strong></td>
							<td class="feesbox" id="trf_total_units">T0000000</td>
						</tr>
						<tr>
							<td><strong>Misc Fees:</strong></td>
							<td class="feesbox" id="trf_misc">T0000000</td>

							<td><strong>First:</strong></td>
							<td class="feesbox" id="trf_first">T0000000</td>
							
							<td><strong>Total Subjects:</strong></td>
							<td class="feesbox" id="trf_total_subject">T0000000</td>
						</tr>
						<tr>
							<td><strong>Lab Fees:</strong></td>
							<td class="feesbox" id="trf_lab">T0000000</td>

							<td><strong>Second:</strong></td>
							<td class="feesbox" id="trf_second">T0000000</td>
							
							<td><strong>Scholar:</strong></td>
							<td class="feesbox" id="trf_scholar">T0000000</td>
						</tr>
						<tr>
							<td><strong>Other Fees:</strong></td>
							<td class="feesbox" id="trf_other">T0000000</td>

							<td><strong>Third:</strong></td>
							<td class="feesbox" id="trf_third">T0000000</td>
							
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Total Fees:</strong></td>
							<td class="feesbox" id="trf_total_fees">T0000000</td>

							<td><strong>Fourth:</strong></td>
							<td class="feesbox" id="trf_fourth">T0000000</td>
							
							<td></td>
							<td></td>
						</tr>
					</table>
					<br>
					<label>
					<h6><u>NOTE: THIS IS NOT A PROOF OF OFFICIAL ENROLLMENT</u></h6>
					</label>
				</div>
			</div>
			<div class="modal-footer">
			<div id="print_display"></div>
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
				<button type="button" onclick="print_temporary_regform('<?php echo $student_info['Reference_Number'] ?>','<?php echo $this->data['AdvisedCheck'][0]['School_Year']; ?>','<?php echo $this->data['AdvisedCheck'][0]['Semester'];?>')" class="btn btn-success">PRINT</button>
			</div>
		</div>
	</div>
</div>

<!-- BYPASS MODAL-->
<div class="modal fade" id="bypass-login" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">BYPASS PRE-REQUISITES</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="bypasswarning">

				By turning this on you will be able to add subjects with unresolved Pre-Requisites, 
				this will require the <u><strong>Program Chair</strong></u> to sign in before using. <br><br>
				<div id="schedInfo"></div>
				<hr> 

				<h4>Sign-In Program Chair Account</h4>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">person</i>
					</span>
					<div class="form-line">
						<input type="text" id="bypassUserName" class="form-control" name="username" placeholder="Username" required autofocus>
					</div>
				</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">lock</i>
					</span>
					<div class="form-line">
						<input type="password" id="bypassPassword" class="form-control" name="password" placeholder="Password" required>
					</div>
				</div>
				<div>
					<input type="hidden" id="referenceNo" value="<?php echo $student_info['Reference_Number'] ?>" />									
				</div>
				<div id="bypassSchedDisplayId">
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CANCEL</button>
				<button type="submit" id="bypass_login" onclick="bypassLogin()" class="btn btn-success">CONFIRM</button>
			</div>
		</div>
	</div>
</div>
<!-- /BYPASS MODAL-->

<?php if($student_info['Course'] === "N/A" || $student_info['AdmittedSY'] === "N/A" || $student_info['AdmittedSEM'] === "N/A"): ?>

<!-- COURSE BYPASS MODAL-->
<div class="modal fade" id="courseInputModal" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="color:#000">
				<h4 class="modal-title" id="exampleModalLabel">COURSE CONFIRMATION</h4>
				<br>
				<br>
				The student you're about to advise has not taken the entrance examination yet therefore not assigned to a course.
				<br>
				To proceed, you must assign a course for the student.
				<br>
				<br>
				Student's Prefered Courses: 
				
				<ul>
					<li>
						<b>Course:</b> <?php echo $student_info['Course_1st']; ?>
						<br>
						<b>Major</b>: <?php echo $student_info['1st_major']; ?>
					</li>
					<li>
						<b>Course:</b> <?php echo $student_info['Course_2nd']; ?>
						<br>
						<b>Major:</b> <?php echo $student_info['2nd_major']; ?>
					</li>
					<li>
						<b>Course:</b> <?php echo $student_info['Course_3rd']; ?>
						<br>
						<b>Major:</b> <?php echo $student_info['3rd_major']; ?>
					</li>
				</ul>
				
				<hr> 

				<h4>Choose Course</h4>
				<form id="CourseConfirmForm" action="<?php echo base_url(); ?>index.php/Advising/UpdateStudentCourse_Advising" method="POST">

					<input type="hidden" name="student_ref" id="student_ref" value="<?php echo $this->data['student_info'][0]['Reference_Number']; ?>">
					<br>
					<select name="Program_Manual_Input" class="form-control show-tick" id="Program_Manual_Input_dropdown" data-live-search='true' style="width:100%">
						
					</select>
					<br>
					<select name="Major_Manual_Input" class="form-control show-tick" id="Major_Manual_Input_dropdown" data-live-search='true'>
						<option value="0">Select Major</option>
					</select>


				</form>

			</div>
			<div class="modal-footer">
				<a type="button" class="btn btn-default waves-effect" href="<?php echo base_url(); ?>index.php/Advising">CANCEL</a>
				<button type="submit" id="CourseConfirmForm_submit" class="btn btn-success">CONFIRM</button>
			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		$('#courseInputModal').modal('show');

		GetCourseInputChoices();

		$('#Program_Manual_Input_dropdown').change(function(){
			GetMajorInputChoices($(this).val());
		});

		$('#CourseConfirmForm_submit').click(function(){
			Init_CourseInput();
		});

	});
</script>

<?php endIf; ?>
<!-- /COURSE BYPASS MODAL-->

	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/html2canvas.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/temporary_regform.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bypass_subject.js"></script>



<script>
	$("#schedSearchType").change(function(){
		console.log("test");
		$("#schedSearchSubmit").prop('disabled', false);
	});

	$( window ).load(function() {
		// Run code
		//displaySchedTable();
		displaySession();
	});
</script>

	


