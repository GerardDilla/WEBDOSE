<section class="content" style="background-color: #fff;">
	<div class="container-fluid">
		<div class="block-header">
			<h1></h1>
		</div><!-- Basic Example -->
		<div class="row">

			<form action="<?php echo base_url(); ?>index.php/Registrar/Check_Ched_Button" method="post">

				<input type="hidden" value="<?php echo base_url(); ?>" id="guidance_url">

				<!-- <div class="col-md-6">

				</div>

				<div class="col-md-6">

				</div>

				<br><br> <br> -->

				<div class="col-md-12">
					<div class="text-center">
						<h3>Enrollment List</h3>
						<h5> Semester: <span id="sems" style="font-weight: 100;"></span> School Year:<span id="sys" style="font-weight: 100;"></span></h5>
					</div>
					<br><br><br>
				</div>

				<div class="col-md-6">
					<h5>School:<span style="font-weight: 100;"> ST. DOMINIC COLLEGE OF ASIA</span></h5>
					<h5>ADDRESS:<span style="font-weight: 100;"> Emilio Aguinaldo Highway, Talaba, Bacoor </span></h5>

					<!-- <label>Certified True And Correct:</label>
					<select class="form-control show-tick" data-live-search="true" id="ES" class="danger" name="user">
						<?php foreach ($this->data['get_user']->result_array() as $row) { ?>
							<?php if ($this->input->post('user') ==  $row['User_FullName']) : ?>
								<option selected><?php echo $row['User_FullName']; ?></option>
							<?php else : ?>
								<option><?php echo $row['User_FullName']; ?></option>
							<?php endif ?>
						<?php } ?>
					</select> -->

				</div>

				<div class="col-md-6">
					<?php
					//SchoolYear Select
					$datestring = "%Y";
					$time = time();
					$year_now = mdate($datestring, $time);
					$options = array(

						'0' => 'Select School Year',
						($year_now - 1) . "-" . $year_now => ($year_now - 1) . "-" . $year_now,
						$year_now . "-" . ($year_now + 1) => $year_now . "-" . ($year_now + 1),
						($year_now + 1) . "-" . ($year_now + 2) => ($year_now + 1) . "-" . ($year_now + 2)

					);
					$js = array(
						'id' => 'ES',
						'class' => 'form-control show-tick',
						'data-live-search' => 'true',
						'required' => 'required',
					);
					echo form_dropdown('sy', $options, $this->input->post('sy'), $js);
					?>

					<?php

					//SCHOOL YEAR DROPDOWN
					$class = array('class' => 'form-control show-tick',);

					$options =  array(
						''        => 'Select Semester',
						'FIRST'   => 'FIRST',
						'SECOND'  => 'SECOND',
						'SUMMER'  => 'SUMMER',
					);

					echo form_dropdown('sem', $options, $this->input->post('sem'), $class);

					?>


					<?php
					//SELECT LEVEL
					$class = array(
						'class' => 'form-control show-tick',
						'id'   => 'Program',
						'data-live-search'   => 'true',
					);
					$options =  array('' => 'Select Course');
					foreach ($this->data['Get_Course']->result_array() as $row) {

						$options[$row['Program_Code']] = $row['Program_Code'];
					}
					echo form_dropdown('course', $options, $this->input->post('course'), $class);
					?>


					<br>

					<?php
					//SELECT LEVEL
					$class = array(
						'class' => 'form-control show-tick',
						'id'   => 'mjr',
					);
					$options =  array('0' => 'Select Major');

					echo form_dropdown('mjr', $options, $this->input->post('mjr'), $class);
					?>
					<input type="hidden" value="<?php echo $this->input->post('mjr'); ?>" id="major">


					<br>

					<?php
					//SELECT LEVEL
					$class = array('class' => 'form-control show-tick',);
					$options =  array('' => 'Select Year Level');
					foreach ($this->data['get_ylvl']->result_array() as $row) {

						$options[$row['Year_Level']] = $row['Year_Level'];
					}
					echo form_dropdown('year_lvl', $options, $this->input->post('year_lvl'), $class);
					?>

					<br><br>
				</div>

				<div class="col-md-12">
					<br><br>
					<div class="text-center">
						<button type="submit" name="search_button" value="search_button" class="btn btn-lg btn-danger">Search</button>
						<?php if ($this->session->userdata('submit')) : ?>
							<button class="btn btn-lg btn-success" type="submit" name="export" value="Export">Generate</button>
						<?php endif; ?>
			</form>
		</div>
		<br><br>
	</div>




	<div class="col-md-12">
		<div class="table panel panel-danger" style="overflow-x:auto; height: 500px;">
			<table class="table table-bordered" style="width: 2000px;">
				<thead>
					<tr class="danger">
						<th class="text-center">#</th>
						<th class="text-center">Student Number</th>
						<th class="text-center">Surname</th>
						<th class="text-center">First Name</th>
						<th class="text-center">Middle Name</th>
						<th class="text-center">Sufix</th>
						<th class="text-center">Gender</th>
						<th class="text-center">Nationality</th>
						<th class="text-center">Year Level</th>
						<th class="text-center">Program</th>
						<th class="text-center">Major</th>



						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Units</th>

					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
						$student_number = "";
						$checker = "";
						$count = 1;
						foreach ($this->data['get_students']->result_array() as $row) {


							if ($student_number === $row['Student_Number']) {
								# code...
								$checker = 'true';
						?>
								<input type="hidden" name="course_title" value="">
								<td class="text-center"><?php echo $row['Course_Code']; ?></td>
								<td class="text-center"> <?php echo $row['Course_Lab_Unit'] + $row['Course_Lec_Unit']; ?> </td>
							<?php
							} else {
								$checker = 'false';
								$student_number = $row['Student_Number'];
							?>
					</tr>
					<tr>
						<td class="text-center">
							<?php echo $count;
								$count++; ?>
						</td>
						<td class="text-center">
							<?php echo $row['Student_Number'] ;  ?>
						</td>
						<td class="text-center" style="text-transform: uppercase;">
							<?php echo $row['Last_Name'] ;  ?>
						</td>
						<td class="text-center" style="text-transform: uppercase;">
							<?php echo $row['First_Name'] ?>
						</td>
						<td class="text-center" style="text-transform: uppercase;">
							<?php echo $row['Middle_Name'] ?>
						</td>
						<td class="text-center"></td>
						
						
						<?php
								//start check if male of female
								if (($row['Gender'] === 'MALE') || ($row['Gender'] === 'Male')) {
									# code...

						?>
							<td class="text-center">M</td>
						<?php
								} else {


						?>
							<td class="text-center">F</td>
						<?php
								}
								//end check if male of female
						?>

						
						<td class="text-center"><?php echo $row['Nationality']; ?></td>
						<td class="text-center"><?php echo $row['YearLevel']; ?></td>
						<td class="text-center"><?php echo $row['Program']; ?></td>
						<td class="text-center"><?php echo $row['Program_Major']; ?></td>
						<td class="text-center"><?php echo $row['Course_Code']; ?></td>
						<td class="text-center"> <?php echo $row['Course_Lab_Unit'] + $row['Course_Lec_Unit']; ?> </td>
						<?php

							}

						?>

						<?php

						} //end foreach
						?>
					</tr>

				</tbody>
			</table>
		</div>
	</div>

	</div>
	</div>
</section>

<script src="<?php echo base_url(); ?>js/guidanceEnrolledStudent.js"></script>