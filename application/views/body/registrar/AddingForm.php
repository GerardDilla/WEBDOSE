<section class="content" style="background-color: #fff;" id="top">

	<!-- CONTENT GRID-->
	<div class="container-fluid" id="capture">
		 
		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">note_add</i> Add Subject </h1>

			<?php if($this->session->flashdata('message')): ?>
			<div class="alert bg-<?php echo $this->session->flashdata('color'); ?> alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<?php echo $this->session->flashdata('message'); ?>
			</div>
			<?php endIf; ?>

		</div>
		<!--/ MODULE TITLE-->

		<!-- CONTENT-->
		<div class="row">

			<div class="col-md-4">

				<!-- STUDENT SELECTION -->
				<div class="SBorder vertical_gap">
					<h4>Higher Education</h4><hr>
					<form action="<?php echo base_url(); ?>index.php/Registrar/getstudentinfo" method="GET" id="inputform">
						<div class="form-line vertical_gap">

							<input class="form-control date" name="id" id="student_id" placeholder="Student / Reference Number " type="number" value="<?php echo $this->data['Sdata'][0]['Student_Number']; ?>">
							<input name="id2" id="student_ref" placeholder="Student / Reference Number " type="hidden" value="<?php echo $this->data['Sdata'][0]['Reference_Number']; ?>">

						</div> 
						<!--
						<select class="vertical_gap widthfull" name="schoolyear" id="schoolYear" class="form-control show-tick" data-live-search="true">
							<option disabled selected value="">
								Select School Year
							</option>
							<option selected="selected" value="2018-2019">2018-2019</option>
							<option value="2019-2020">2019-2020</option>
						</select>
						-->

						<?php
						//SchoolYear Select
							$datestring = "%Y";
							$time = time();
							$year_now = mdate($datestring, $time);
							$options = array(
								
								'0'=> 'Select School Year',
								($year_now - 3)."-".($year_now - 2) => ($year_now - 3)."-".($year_now - 2),
								($year_now - 2)."-".($year_now - 1) => ($year_now - 2)."-".($year_now - 1),
								($year_now - 1)."-".$year_now => ($year_now - 1)."-".$year_now,
								$year_now."-".($year_now + 1) => $year_now."-".($year_now + 1),
								($year_now + 1)."-".($year_now + 2) => ($year_now + 1)."-".($year_now + 2)
								
							);
							$js = array(
								'id' => 'schoolYear',
								'class' => 'form-control show-tick',
								'data-live-search' => 'true',
							);
							echo form_dropdown('schoolyear', $options, $this->data['Legend'][0]['School_Year'], $js);
						?>

						<?php
						//SchoolYear Select
							$options = array(
								'FIRST' => 'FIRST',
								'SECOND' => 'SECOND',
								'SUMMER' => 'SUMMER',
							);
							$js = array(
								'id' => 'semester',
								'class' => 'form-control show-tick',
								'data-live-search' => 'true',
							);
							echo form_dropdown('semester', $options, $this->data['Legend'][0]['Semester'], $js);
						?>
						<!--
						<select class="vertical_gap widthfull" name="semester" id="semester" class="form-control show-tick" data-live-search="true">
							<option disabled selected value="">
								Select Semester
							</option>
							<option value="FIRST">FIRST</option>
							<option selected="selected" value="SECOND">SECOND</option>
							<option value="SUMMER">SUMMER</option>
						</select>
						-->


						<div class="text-center vertical_gap">
							<button class="btn btn-lg btn-info" type="button" onclick="getstudentinputs()">SELECT</button>
						</div>
					</form>
				</div>
				<!-- /STUDENT SELECTION -->

				<!-- INFO DISPLAY -->
				<div class="SBorder">
					<div class="input-group">
						
						<div class="form-line">
							<input class="form-control" disabled  type="text" id="name_view" 
							placeholder="Name: <?php echo $this->data['Sdata'][0]['First_Name']; ?> <?php echo $this->data['Sdata'][0]['Middle_Name']; ?> <?php echo $this->data['Sdata'][0]['Last_Name']; ?> 
							">
						</div>
						<div class="form-line">
							<input class="form-control" disabled  type="text" id="unit_view" placeholder="Units: <?php echo $this->data['Student_units']; ?>">
						</div>
						<div class="form-line">
							<input class="form-control" disabled  type="text" id="program_view" placeholder="Program: <?php echo $this->data['Sdata'][0]['Program']; ?>">
						</div>
						<div class="form-line">
							<input class="form-control" disabled  type="text" id="schoolyear_view" placeholder="Schoolyear: <?php echo $this->data['Sdata'][0]['School_Year']; ?>">
						</div>
						<div class="form-line">
							<input class="form-control" disabled  type="text" id="tuitionfee_view" placeholder="Admitted Schoolyear: <?php echo $this->data['Sdata'][0]['AdmittedSY']; ?>">
						</div>
						<div class="form-line">
							<input class="form-control" disabled  type="text" id="totalfee_view" placeholder="Admitted Semester: <?php echo $this->data['Sdata'][0]['AdmittedSEM']; ?>">
						</div>
						
					</div>
				</div>
				<!-- /PAYMENT VIEW -->
				<br>

			</div>

			<div class="col-md-8">

				<div class="row">

					<!-- FORM -->
					<!-- Change form depending on need  -->
					<div class="col-md-12">
						<div class="SBorder row" style="min-height:262px; margin:5px 0 5px 0px">
							<h4>Subject to Add</h4><hr>
							<div class="col-md-8 rightline">

								<!-- selected schedcode will go here -->
								<input class="form-control" type="text"  name="sched_code" id="sched-code-id" value="" placeholder="Enter Schedule Code">
								<input type="hidden" id="base_url" name="base_url" value="<?php echo base_url(); ?>index.php/Registrar">
								<button type="button" data-toggle="modal" data-target="#subjectchoice_modal" class="btn btn-default waves-effect">
                                    <i class="material-icons">search</i>
                                    <span>Search Schedule</span>
                                </button>

							</div>
							<div class="col-md-4">
								<!-- SHIFT BUTTONS -->
								<div class="text-center vertical_gap2">
									<button class="btn btn-lg btn-default widthfull">
										<i class="material-icons">loop</i> Clear Selected
									</button>
								</div>
								<br>
								<div class="text-center vertical_gap2">
									<button class="btn btn-lg btn-info widthfull"  style="font-size:15px" data-toggle="modal" data-target="#confirmation">
										ADD <i class="material-icons">note_add</i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- /FORM -->

					<!-- DISPLAYS SUBJECT OF CHOSEN STUDENT -->
					<div class="col-md-12" >
						<div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
							<div class="panel" style="background-color:#cc0000; color:#fff">
								<div class="panel-heading" role="tab" id="headingOne_19">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" href="#collapseOne_19" aria-expanded="true" aria-controls="collapseOne_19">
											<i class="material-icons">arrow_drop_down</i> SUBJECTS (Click row to view info)
										</a>
									</h4>
								</div>
								<div id="collapseOne_19" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_19" >
									<div class="panel-body" style="background-color:#fff; overflow:auto; max-height:300px">
										<table class="table table-bordered">
											<thead>
												<tr class="danger" style="font-size:14px">
													<th>Sched Code</th>
													<th>Course Code</th>
													<th>Course Title</th>
													<th>Section</th>
													<th>Lec Unit</th>
													<th>Lab Unit</th>
												</tr>
											</thead>
											<tbody id="resulttable">
											<?php if($this->data['Sdata']): ?>
												<?php foreach($this->data['Sdata'] as $row): ?>
													<tr class="rowinfo" data-scode="<?php echo $row['Sched_Code']; ?>" onclick="sched_select(this)">
														<td><?php echo $row['Sched_Code']; ?></td>
														<td><?php echo $row['Course_Code']; ?></td>
														<td><?php echo $row['Course_Title']; ?></td>
														<td><?php echo $row['Section']; ?></td>
														<td><?php echo $row['Course_Lec_Unit']; ?></td>
														<td><?php echo $row['Course_Lab_Unit']; ?></td>
													</tr>	
												<?php endForeach; ?>
											<?php endIf; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- DISPLAYS SUBJECT OF CHOSEN STUDENT -->

				</div>
			</div>

		</div>

	</div>
	<!--/CONTENT GRID-->

</section>



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
			<button type="button" id="confirm" name="saveshift" onclick="Add_check()" class="btn btn-success" >CONFIRM</button>
		</div>
	</div>
	</div>
</div>
<!--/CONFIRMATION MODAL-->

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
						<button class="btn btn-lg btn-info" id="schedSearchSubmit" type="button" onclick="search_input_checker()">SEARCH</button>
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

<!-- FORM MODAL-->
<!-- Hidden inputs for submit-->
<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
	<div class="modal-content" id="message_color_id">
		<div class="modal-header">
		<h3>Submit Form</h3>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<!-- INPUTS ARE PLACED HERE THROUGH JAVASCRIPT-->
			<form action="<?php echo base_url(); ?>index.php/Registrar/Add_Subject" id="final_add_form" method="post">
			<label>Ref Number</label>
				<input type="text" name="form_ref_num" id="form_ref_num" value="">
			<label>Sched Code</label>
				<input type="text" name="form_sched_code" id="form_sched_code" value="">
			<label>SY</label>
				<input type="text" name="form_sy" id="form_sy" value="">
			<label>SEM</label>
				<input type="text" name="form_sem" id="form_sem" value="">
			</form>
			<!-- /INPUTS ARE PLACED HERE THROUGH JAVASCRIPT-->
		</div>
	</div>
	</div>
</div>
<!-- /Hidden inputs for submit-->
<!--/FORM MODAL-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/subject_edit.js"></script>
<script>
$( document ).ready(function() {
	$('#schedsem option[value=<?php echo $this->data['semester']; ?>]').attr('selected', 'selected');
	$("#schedsem").selectpicker('refresh');
	
	$('#schedsy option[value=<?php echo $this->data['sy']; ?>]').attr('selected', 'selected');
	$("#schedsy").selectpicker('refresh');
});
</script>
	


