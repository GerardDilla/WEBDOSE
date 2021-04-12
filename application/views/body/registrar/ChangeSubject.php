


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">assignment_returned</i> Change Subject</h1>
		</div>
		<!--/ MODULE TITLE-->


		<div class="row">

			<div class="col-md-4">
			
			<!-- STUDENT SELECTION -->
			<form action="<?php echo base_url(); ?>index.php/Registrar/Change_Subject" method="post">
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
						<input class="form-control date" value="<?php echo $this->data['data'][0]['Student_Number'] ?>" placeholder="Student Number: <?php echo $stu_num; ?>" id="student_ref" name="student_num" type="text" required>
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

		<?php 
				if($this->data['data'][0]['Major'] == '0'){
					$major = "N/A";
				}else{
					$major = $this->data['data'][0]['Major'];
				}		
		?>

				<!-- INFO DISPLAY -->
				<div class="SBorder">
				    <h4>Student Information</h4>
					    <div class="input-group">
						    <div class="form-line">
							    <input class="form-control date" disabled  type="text" id="name_view" placeholder="Name: <?php echo $this->data['data'][0]['Last_Name']; ?>, <?php echo $this->data['data'][0]['First_Name']; ?> <?php echo $this->data['data'][0]['Middle_Name']; ?> ">
						    </div>
						    <div class="form-line">
							    <input class="form-control date" disabled  type="text" id="program_view" placeholder="Program: <?php echo $this->data['data'][0]['Course']; ?>">
						    </div>
					    	<div class="form-line">
							    <input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Major: <?php echo $major; ?>">
					     	</div>
						    <div class="form-line">
							    <input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Year: <?php echo $this->data['data'][0]['YL']; ?>">
					     	</div>
						    <div class="form-line">
							     <input class="form-control date" disabled  type="text" id="tuitionfee_view" placeholder="Section:<?php echo $this->data['data'][0]['Section_Name']; ?> ">
						   </div>
					
						
					</div>
				</div>
				<!-- /PAYMENT VIEW -->
				<br>

			</div>


    <div class="col-md-8">

			<div class="row">

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
													<th>Sched Code</th>
													<th>Course Code</th>
													<th>Lec Unit</th>
													<th>Lab Unit</th>
													<th>Section</th>
												</tr>
											</thead>
											<tbody>
											<?php  foreach($this->data['data'] as $row){  ?>


											<tr class="rowpointer"     
											    
												data-scode        ="<?php echo $row['Sched_Code']; ?>" 
												data-course_code  ="<?php echo $row['Course_Code']; ?>" 
											    data-course_title ="<?php echo $row['Course_Title']; ?>" 
												data-lec          ="<?php echo $row['Course_Lec_Unit']; ?>"
											    data-lab          ="<?php echo $row['Course_Lab_Unit'];  ?>"

											    onclick="selectsubjectenrolled(this)">


												    <td><?php echo $row['Sched_Code'];?></td>
													<td><?php echo $row['Course_Code']; ?></td>
													<td><?php echo $row['Course_Lec_Unit']; ?></td>
													<td><?php echo $row['Course_Lab_Unit']; ?></td>
													<td><?php echo $row['Section_Name']; ?></td>

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


  <form action="<?php echo base_url(); ?>index.php/Registrar/ChangeSubjectInsertAndUpdate" id="inputform" method="post">

             
                <input  type="hidden"  name="stu_ref" id="student_id" value="<?php echo $this->data['data'][0]['Student_Number']; ?>"> 
				<input   type="hidden" name="sy" id="schoolYear" value="<?php echo $this->data['data'][0]['School_Year']; ?>"> 
				<input  type="hidden"  name="sem" id="semester" value="<?php echo $this->data['data'][0]['Semester']; ?>"> 

				<input  type="hidden"  name="ref_num"      value="<?php echo $this->data['data'][0]['Reference_Number']; ?>"> 
				<input  type="hidden"  name="scheduler"    value="<?php echo $this->data['data'][0]['Scheduler']; ?>"> 
				<input  type="hidden"  name="sdate"        value="<?php echo $this->data['data'][0]['Sdate']; ?>"> 
				<input  type="hidden"  name="status"       value="<?php echo $this->data['data'][0]['Status']; ?>"> 
				<input  type="hidden"  name="program"      value="<?php echo $this->data['data'][0]['Program']; ?>"> 
				<input  type="hidden"  name="major"        value="<?php echo $this->data['data'][0]['Major']; ?>"> 
				<input  type="hidden"  name="year_level"   value="<?php echo $this->data['data'][0]['YL']; ?>"> 
				<input  type="hidden"  name="payment_plan" value="<?php echo $this->data['data'][0]['Payment_Plan']; ?>"> 
				<input  type="hidden"  name="section"      value="<?php echo $this->data['data'][0]['Section']; ?>"> 
                <input  type="hidden"  name="sched_display_id"  id="course_sched_display_id"  > 

				<input type="hidden" id="base_url" name="base_url" value="<?php echo base_url(); ?>index.php/Registrar">

				<div class="col-md-12" >
					<div class="SBorder row">
						<h4>Enrolled Subject to Change</h4><hr>
						<div class="col-md-8 rightline">
							<div class="input-group">
							    <div class="row">
								    <div class="col-md-6">
									    <input class="form-control" disabled  type="text" id="sched_code_view" placeholder="SELECT SUBJECT FROM TABLE" required> 
										<input  type="hidden" name="subject_to_change_sc" id="sched_code_id"> 
									</div>
									<div class="col-md-6">
									    <input class="form-control date" disabled  type="text" id="Course_code_id_view" placeholder=""> 
										<input disabled  type="hidden" id="Course_code_id"> 
									</div>
								</div>
									    <input class="form-control date" disabled  type="text" id="Course_title_id_view" placeholder="">   
										<input disabled  type="hidden" id="Course_title_id">             
							</div>
						</div>
						<div class="col-md-4">
							<div class="input-group">
								<input class="form-control date" disabled  type="text" id="lec_id_view" placeholder=""> 
								<input disabled  type="hidden" id="lec_id">    
								<input class="form-control date" disabled  type="text" id="lab_id_view" placeholder=""> 
								<input disabled  type="hidden" id="lab_id">   
							</div>
						</div>
					</div><!-- SBORDER CLASS -->
				</div> <!-- COL-MD-6 -->

				<div class="col-md-12" >
					<div class="SBorder row">
						<h4>Subject to Enrolled</h4><hr>
						<div class="col-md-8 rightline">
							<div class="input-group">
							    <div class="row">
								    <div class="col-md-6">
									    <input class="form-control date" disabled type="text" id="sched-code-id-view" placeholder="Sched Code:" required	> 
										  <input  type="hidden" name="subject_to_enrolled_sc" id="sched-code-id"> 
									</div>
									<div class="col-md-6">
									    <input class="form-control date" disabled  type="text" id="course-code-id-view" placeholder="Course Code:"> 
										<input  type="hidden" id="course-code-id"> 
									</div>
								</div>
									    <input class="form-control date" disabled  type="text" id="course-title-id-view" placeholder="Course Title:">  
										<input  type="hidden" id="course-title-id">              
							</div>
						</div>
						<div class="col-md-4">
							<div class="input-group">
								<button type="button" data-toggle="modal" data-target="#subjectchoice_modal" class="btn btn-success waves-effect">
										<i class="material-icons">search</i>
										<span>Select Subject</span>
									</button>
								<input class="form-control date" disabled  type="text" id="course-lec-id-view" placeholder="Lec Unit:"> 
								     <input disabled  type="hidden" id="course-lec-id">           
								<input class="form-control date" disabled  type="text" id="course-lab-id-view" placeholder="Lab Unit:"> 
								     <input disabled  type="hidden" id="course-lab-id">           
							</div>
						</div>
					</div><!-- SBORDER CLASS -->
				</div> <!-- COL-MD-6 -->  

			
			</div> <!-- ROW --> 
           <br>
			<div class="row" style="">

				<div class="text-center" >
					<div class="col-md-6">
						<button class="btn btn-lg btn-info " type="button">CLEAR </button>
					</div>

					<div class="col-md-6">
				      	<button class="btn btn-lg btn-danger" id="ChangeButton" onclick="getstudentchangesubjectinputs(this)"  type="button">CHANGE </button>
					</div>
				</div>

			</div>
			<br>

     </form>

			</div>
			</div>

		</div>
	</div>
	<!--/CONTENT GRID-->

</section>



<!-- SUBJECT CHOICE -->
<div class="modal fade" id="subjectchoice_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2 id="largeModalLabel">Add Schedule</h2>
				<p>- Click row to view info and select subject<p>
			</div>
			<div class="modal-body">
				<br><br>
				<div class="row">

					<div class="col-md-9">
						<div class="row">
							<div class="col-md-12">
								<select id="schedSearchType" class="form-control show-tick" data-live-search="true">
									<option disabled selected>
										Select Search Type
									</option>
									<option value="Course_Code">Course Code</option>
									<option value="Sched_Code">Sched Code</option>
									<option value="Course_Title">Course Title</option>
								</select>
							</div>
							<div class="col-md-12">
								<input id="schedSearchValue" class="form-control" placeholder="Search Schedule..." type="text" />
							</div>
						</div>
					</div>

					<div class="col-md-3" style="padding 50% 0px 50% 0px">
						<button class="btn btn-lg btn-info" id="schedSearchSubmit" type="button"  onclick="search_input_checker()">SEARCH</button>
					</div>

				</div>
				<hr>
				<div class="col-md-12 searchloader" style="padding: 1%; display:none">
					LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
				</div>
				<div class="table panel panel-danger" style="overflow-x:auto; max-height:250px">
					<table id="tableSelectSchedule" class="table table-bordered">
						<thead>
							<tr class="danger">
								<th>Sched Code</th>
								<th>Course Code</th>
								<th>Course Title</th>
								<th>Section</th>
								<!--
								<th>Lec Unit</th>
								<th>Lab Unit</th>
								<th>Day</th>
								<th>Time</th>
								<th>Room</th>
								<th>Remaining Slot</th>
								<th>Instructor Name</th>
								<th>Action</th>
								-->
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
				<div id="schedsearchmodalpagination"></div> 					

			</div>
			<div class="modal-footer" id="AddSched_Button_Panel">
				<!-- Will only show if block section. Function: toggleAddAllButton() -->
			</div>
		</div>
	</div>
</div>
<!-- /SUBJECT CHOICE --> 
<!-- SCHED INFO MODAL-->
<div class="modal fade" id="sched_info_modal" tabindex="-1" role="dialog" aria-labelledby="sched_info_modal" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<label>Sched Code: </label> <u id="sc_info"></u>
			<br>
			<label>Lecture Units: </label> <u id="lec_info"></u>
			<br>
			<label>Laboratory Units: </label> <u id="lab_info"></u>
			<br>
			<label>Total Units: </label> <u id="unit_info"></u>
			<br>
			<label>Available Slot: </label> <u id="slot_info"></u>
			<br>
			<label>Instructor: </label> <u id="instructor_info"></u>

			<table class="table table-bordered">
				<thead>
					<tr class="danger">
						<th>Day</th>
						<th>Start</th>
						<th>End</th>
						<th>Room</th>
					</tr>
				</thead>
				<tbody id="sched_info_table">
					<tr>
						<td colspan="10" align="center">No Data</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
				<div id="select_subject_id">
					<!--<button type="button" class="btn btn-success waves-effect" id="select_subject_id">SELECT</button>-->
				</div>
				
		</div>
	</div>
	</div>
</div>
<!-- SCHED INFO MODAL-->

<!-- MESSAGE MODAL-->
<div class="modal fade" id="message_prompt" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
	<div class="modal-content" id="message_color_id">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div style="font-size:50px; text-align:center" id="msg_icon">
				<i class="material-icons" id="message_icon" style="font-size:70px">note_add</i>
			</div>
			<div style="text-align:center">
				<p id="message_text" style="font-size:150%"></p>
			</div>
		</div>
	</div>
	</div>
</div>
<!--/MESSAGE MODAL-->



<!-- CONFIRMATION MODAL-->
<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<div class="col-md-12 searchloader" style="padding: 1%; display:none">
				LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
			</div>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<h5>Please Review Before Proceeding, Do you Confirm these Changes?</h5>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CANCEL</button>
			<button type="button" id="confirm"  onclick="ChangeSubject(this)" class="btn btn-success" >CONFIRM</button>
		</div>
	</div>
	</div>
</div>
<!--/CONFIRMATION MODAL-->


<script type="text/javascript" src="<?php echo base_url(); ?>js/subject_edit.js"></script>
<script src="<?php echo base_url(); ?>js/change_subject.js"></script>


	
  
	


