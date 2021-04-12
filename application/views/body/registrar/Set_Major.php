
<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">assignment_returned</i> Set Major</h1>
		</div>
		<!--/ MODULE TITLE-->


		<div class="row">
			<div class="col-md-4">
			<!-- STUDENT SELECTION -->
			<form action="<?php echo base_url(); ?>index.php/Registrar/SetMajor" method="post">
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
						<input class="form-control date" value="<?php echo $this->input->post('student_num'); ?>" placeholder="Student Number:" name="student_num" type="text" required>
					</div>

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
							<input class="form-control date" disabled  type="text" id="name_view" placeholder="Name: <?php echo $this->data['data'][0]['Last_Name'] ?>, <?php echo $this->data['data'][0]['First_Name'] ?>  <?php echo $this->data['data'][0]['Middle_Name'] ?> ">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="program_view" placeholder="Program:  <?php echo $this->data['data'][0]['Course'] ?>">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="schoolyear_view" 
								   placeholder="Major:  <?php 
								                        if($this->data['data'][0]['Major'] == 0){
								                              echo  "N/A";
								                             }else{
															  echo	$this->data['data'][0]['Program_Major'];
															 }
		                                                 ?> ">
						</div>
					</div>
				</div>
				<!-- /PAYMENT VIEW -->
				<br>

			</div>


			<div class="col-md-8">
				<div class="row">
				<form action="<?php echo base_url(); ?>index.php/Registrar/UpdateMajor" method="post">

					<input type="hidden" value="<?php echo $this->data['data'][0]['Student_Number'] ?>" name="stu_num">
					<input type="hidden" value="<?php echo $this->data['data'][0]['Reference_Number'] ?>" name="ref_num">	

					<div class="col-md-12" >
						<div class="SBorder row">
							<h4>Select Major</h4><hr>
							<div class="col-md-10 rightline">
							   <div class="input-group">
								 <div class="form-line">
									<?php 
										//SELECT Nationality
										$class = array('class'           => 'form-control show-tick',
													'data-live-search'   => 'true',  
													);
										$options =  array('' => 'Select Major',
									                      '0'=> 'Set No Major');
										 foreach($this->data['Major'] as $row) {
											$options[$row['ID']] = $row['Program_Major'];
											}
										echo form_dropdown('Major', $options, $this->input->post('Major'),$class);
									?>                     
						         </div>
							   </div>
							    <div class="form-line" style="text-align: center;">
							        <button class="btn btn-danger text-center" id="submit" type="submit" onclick="return confirm('Please Review Before Proceeding, Do you Confirm these Changes?')" name="search_button"> Change </button>
						        </div>
                            </div> 
						</div>
					
					</div> 

					</form>   
				</div>
			</div>

		</div>
	</div>
	<!--/CONTENT GRID-->

</section>



	<script src="<?php echo base_url(); ?>js/change_section.js"></script>
  
	


