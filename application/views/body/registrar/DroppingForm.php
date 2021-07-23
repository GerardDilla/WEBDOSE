<?php 
	foreach($this->data['Student_Info'] as $row){
        //GET DATA
		$stu_num              = $row->Student_Number;
		$F_name               = $row->First_Name;
		$M_name               = $row->Middle_Name;
		$L_name               = $row->Last_Name;
		$Course               = $row->Course;
		$sem                  = $row->Semester;
		$sy                   = $row->School_Year;
		  // CHECKER IF NO MAJOR
		  if ($major  == 0) {
		    	$major = 'N/A';
		  }else{
	     	$major             = $row->Program_Major;
	      } 
		$AdmittedSy           = $row->AdmittedSY;
		$AdmittedSem          = $row->AdmittedSEM;
		$YL2                  = $row->YL;
		$section_n            = $row->Section_Name;
	}
	
	?>


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">assignment_returned</i> Drop Subject </h1>
		</div>
		<!--/ MODULE TITLE-->


		<div class="row">

		  <?php if($this->session->flashdata('NoSched')): ?>
			   <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<br>
					<h4><?php echo $this->session->flashdata('NoSched'); ?></h4>
                </div>
          <?php endif; ?>

			<div class="col-md-4">
			
			<!-- STUDENT SELECTION -->
			<form action="<?php echo base_url(); ?>index.php/Registrar/drop_choice" method="post">
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
					<!--
					<select  class="form-control show-tick" data-live-search="true"  id="ES" class="danger" name="Semester" >             
                            <?php foreach($this->data['getsem'] as $row)  {?>
                            <option><?php echo $row['semester']; ?></option>
                            <?php }?>
                    </select>
					<select  class="form-control show-tick" data-live-search="true"  id="ES" class="danger" name="School_year" required>             
                            <?php foreach($this->data['getsy'] as $row)  {?>
                            <option><?php echo $row['schoolyear']; ?></option>
                            <?php }?>
                    </select>
					-->

					<?php
					//SchoolYear Select
						$datestring = "%Y";
						$time = time();
						$year_now = mdate($datestring, $time);
						$options = array(
							
							'0'=> 'Select School Year',
							($year_now - 6)."-".($year_now - 5) => ($year_now - 6)."-".($year_now - 5),
							($year_now - 5)."-".($year_now - 4) => ($year_now - 5)."-".($year_now - 4),
							($year_now - 4)."-".($year_now - 3) => ($year_now - 4)."-".($year_now - 3),
							($year_now - 3)."-".($year_now - 2) => ($year_now - 3)."-".($year_now - 2),
							($year_now - 2)."-".($year_now - 1) => ($year_now - 2)."-".($year_now - 1),
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

					<div class="text-center vertical_gap">
						<button  type="submit" class="btn btn-lg btn-info">SELECT</button>
					</div>
				</div>
			</form>
			<!-- /STUDENT SELECTION -->

				<!-- INFO DISPLAY -->
				<div class="SBorder">
					<div class="input-group">
						
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="name_view" placeholder="Name: <?php echo $F_name; ?> <?php echo $M_name; ?> <?php echo $L_name; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="program_view" placeholder="Program: <?php echo $Course; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Major: <?php echo $major; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Year: <?php echo $YL2; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="tuitionfee_view" placeholder="Admitted Schoolyear: <?php echo $AdmittedSy; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="totalfee_view" placeholder="Admitted Semester: <?php echo $AdmittedSem; ?>">
							<input type="hidden" name="name" value="">
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
							<h4>Dropped Enrolled Subject</h4><hr>

							

							
					<form action="<?php echo base_url(); ?>index.php/Registrar/DropSubject" method="post">
					    <input type="hidden"  name="sn" value="<?php echo $stu_num; ?>">
						<input type="hidden"  name="sy" value="<?php echo $sy; ?>">
						<input type="hidden"  name="sem" value="<?php echo $sem; ?>">
						

							<div class="col-md-8 rightline">
							   <div class="input-group">
								 <div class="form-line">	
							       <input class="form-control date" disabled  type="text" id="sched_code_view" name="sched_code" value="" placeholder="Select Subject from table" require>
							       <input type="hidden" id="sched_code_id" name="sched_code" value="">
						         </div>
								 <div class="form-line">	
								   <div class="row">
								       <div class="col-md-6">
							              <input class="form-control date" disabled  type="text" id="Course_code_id_view" placeholder="">
							              <input type="hidden" id="Course_code_id">
										</div>
										<div class="col-md-6">
							              <input class="form-control date" disabled  type="text" id="Course_title_id_view" placeholder="">
							              <input type="hidden" id="Course_title_id" >
										</div>
									</div>
						         </div>	
								 <div class="form-line">	
								   <div class="row">
								      <div class="col-md-6">
									     <input class="form-control date" disabled  type="text" id="lec_id_view" placeholder="">
							             <input type="hidden" id="lec_id" name="name" value="">
									  </div>
									  <div class="col-md-6">
									     <input class="form-control date" disabled  type="text" id="lab_id_view" placeholder="">
							             <input type="hidden" id="lab_id" name="name" value="">
									  </div>
									</div>
						         </div>	
								</div>
							</div>
							<div class="col-md-4">
								<!-- SHIFT BUTTONS -->
								<div class="text-center vertical_gap2">
									<button class="btn btn-info btn-lg  widthfull">
										<i class="material-icons">loop</i> Clear Selected
									</button>
								</div>
								<div class="text-center vertical_gap2">
									<br>
								<div class="text-center">
										<div class="form-group">
											<input class="with-gap studType" id="studTypeBlock" name="refund" value="refund" type="radio" required> <label for="studTypeBlock">Refund</label> 
											<input class="with-gap studType" id="studTypeOpen"  name="refund" value="norefund" type="radio" required ><label class="m-l-20" for="studTypeOpen">No Refund</label>
										</div>
				                 	</div>
							          
									<button class="btn btn-lg btn-danger widthfull"  style="font-size:15px" onclick="return confirm('Please Review Before Proceeding, Do you Confirm these Changes?')">
										Drop <i class="material-icons">assignment_returned</i>
									</button>
								
								

								
									</form>
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
											<i class="material-icons">arrow_drop_down</i> SUBJECTS 
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
											<tbody>
											<?php  foreach($this->data['Student_Info'] as $row){  ?>

												<tr class="rowpointer" 
												
											                	data-scode         ="<?php echo $row->ESID; ?>" 
												                data-course_code   ="<?php echo $row->Course_Code; ?>" 
															    data-course_title  ="<?php echo $row->Course_Title; ?>" 
																data-lec          ="<?php echo $row->Course_Lec_Unit; ?>"
															    data-lab          ="<?php echo $row->Course_Lab_Unit; ?>"

																	 onclick="selectsubjectenrolled(this)">

												    <td><?php echo $row->Sched_Code; ?></td>
													<td><?php echo $row->Course_Code; ?></td>
													<td><?php echo $row->Course_Title; ?></td>
													<td><?php echo $row->Section_Name; ?></td>
													<td><?php echo $row->Course_Lec_Unit; ?></td>
													<td><?php echo $row->Course_Lab_Unit; ?></td>
													

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

				</div>
			</div>

		</div>
	</div>
	<!--/CONTENT GRID-->

</section>


<!-- CONFIRMATION MODAL-->
<form action="" method="post">	
	<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h5>Please Review Before Proceeding, Do you Confirm these Changes?</h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CANCEL</button>
				<button type="submit" id="confirm" name="saveshift" class="btn btn-success" >CONFIRM</button>
			</div>
		</div>
		</div>
	</div>
</form>
<!--/CONFIRMATION MODAL-->

	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script src="<?php echo base_url(); ?>js/change_subject.js"></script>


	


