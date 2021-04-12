<section class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">sync</i> Shift Program </h1>
		</div>
		<!--/ MODULE TITLE-->


		<div class="row">

			<?php if($this->session->flashdata('shift_message') || $this->session->flashdata('message')): ?>
				<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
					<?php echo $this->session->flashdata('shift_message'); ?>
					<?php echo $this->session->flashdata('message'); ?>
				</div>
			<?php endIf; ?>


			<div class="col-md-4">

				<!-- STUDENT SELECTION -->
				<div class="SBorder vertical_gap">
				<form action="" method="post">	
					<h4>Higher Education</h4><hr>
					<div class="form-line vertical_gap">
						<input class="form-control date" placeholder="Enter Student Number..." name="id" type="text" value="<?php echo $sn = !empty($this->data['Data'][0]['Student_Number']) ? $this->data['Data'][0]['Student_Number']:$this->input->post('id'); ?>">
					</div>


					<div class="text-center vertical_gap">
						<button class="btn btn-lg btn-info" id="select_student" name="submit" value="1">SELECT</button>
					</div>
				</form>
				</div>
				<!-- /STUDENT SELECTION -->

				<!-- INFO DISPLAY -->
				<div class="SBorder">
					<div class="input-group">
						
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="name_view" placeholder="Name: <?php echo $this->data['Data'][0]['First_Name']; ?> <?php echo $this->data['Sdata'][0]['Middle_Name']; ?> <?php echo $this->data['Sdata'][0]['Last_Name']; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="program_view" placeholder="Program: <?php echo $this->data['Data'][0]['Course']; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" placeholder="Curriculum: <?php echo $this->data['Data'][0]['Curriculum_Name']; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Schoolyear: <?php echo $this->data['Data'][0]['School_Year']; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="tuitionfee_view" placeholder="Admitted Schoolyear: <?php echo $this->data['Data'][0]['AdmittedSY']; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="totalfee_view" placeholder="Admitted Semester: <?php echo $this->data['Data'][0]['AdmittedSEM']; ?>">
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
					<div class="col-md-12">
						<div class="SBorder row" style="min-height:262px; margin:5px 0 5px 0px">
							<h4>Program To Shift</h4><hr>
							<div class="col-md-8 rightline">
							<form id="shift_form" action="<?php echo base_url(); ?>index.php/Registrar/Shift_Student" method="post">
								<!-- SELECT PROGRAM -->
								<input type="hidden" name="Reference_Number" value="<?php echo $this->data['Data'][0]['Reference_Number']; ?>">
								<!-- GETS SY AND SEM THROUGH JS-->
								<input type="hidden" name="Semester" id="submit_sm" value="">
								<input type="hidden" name="Schoolyear" id="submit_sy" value="">

								<?php 
								if($this->data['Programs']){
									$option[''] = 'SELECT PROGRAM';
									foreach($this->data['Programs'] as $row){
										$option[$row['Program_Code']] = strtoupper($row['Program_Code'].' : '.$row['Program_Name']);
									}
									$attribute = 'onchange="set_choices(this.value)" id="program" class="form-control show-tick" data-live-search="true"';
									echo form_dropdown('program', $option,'',$attribute);
								}
								?>
								<!-- SELECT MAJOR -->
								<hr>
								<select id="major" class="form-control show-tick" data-live-search="true" name="major">
									<option disabled selected>
										SELECT PROGRAM MAJOR
									</option>
								</select> 
								<hr>
								<select id="curriculum" class="form-control show-tick" data-live-search="true" name="curriculum">
									<option disabled selected>
										SELECT CURRICULUM
									</option>
								</select> 
								<hr>
								<div class="form-line">
									<label>PROGRAM: <u id="program_name"></u></label>
								</div>
								<hr>
							</form>
							</div>
							<div class="col-md-4">
								<!-- SHIFT BUTTONS -->
								<div class="text-center vertical_gap2">
									<button onclick="clear_selection()" class="btn btn-lg btn-default widthfull">
										<i class="material-icons">loop</i> Clear Selected
									</button>
								</div>
								<br>
								<div class="text-center vertical_gap2">
									<button class="btn btn-lg btn-info widthfull"  style="font-size:15px" data-toggle="modal" data-target="#confirmation">
										SHIFT <i class="material-icons">play_arrow</i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- /FORM -->

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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h5>Please Review Before Proceeding, Do you Confirm these Changes?</h5>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default waves-effect" data-dismiss="modal">CANCEL</button>
				<button type="button" id="confirm" name="saveshift" class="btn btn-success" onclick="submit_form()">CONFIRM</button>
			</div>
		</div>
		</div>
	</div>
<!--/CONFIRMATION MODAL-->

<!-- Small Size -->
<div class="modal fade" id="Message" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="smallModalLabel"></h4>
			</div>
			<div class="modal-body" style="text-align:center">
				<h4><?php echo $this->session->flashdata('message'); ?></h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div>
</div>

<!-- Small Size -->
<div class="modal fade" id="Success" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="smallModalLabel"></h4>
			</div>
			<div class="modal-body" style="text-align:center">
				<h4><?php echo $this->session->flashdata('shift_message'); ?></h4>
			</div>
			<div class="modal-footer">
				<form action="" method="post">
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
					<button type="submit" class="btn btn-link waves-effect">PROCEED</button>
				</form>
			</div>
		</div>
	</div>
</div>

	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>

<script>
function set_choices(val){

	//Gets and Displays Majors
	majors = get_majors(val);
	display_result(majors);

	//Gets and Displays Program Name
	prog_info = get_program_info(val);
	$('#program_name').html(result[0]['Program_Name']);
	
	//Gets and Displays Curriculum
	curriculum = get_curriculum(val);
	display_curriculum(curriculum);


}
function get_majors(val){

	url = '<?php echo base_url(); ?>index.php/Registrar/get_program_majors_ajax';

	ajax = $.ajax({
		async: false,
		url: url,
		type: 'GET',
		data: {Program_Code:val},
		success: function(response){
			
			result = JSON.parse(response);
			//display_result(result);
			

		},
		fail: function(){

			alert('Error: request failed');
			return;
		}
	});
	return result;
	//get_program_info(val);

}
function get_program_info(val){

	url = '<?php echo base_url(); ?>index.php/Registrar/get_program_info';

	ajax = $.ajax({
		async: false,
		url: url,
		type: 'GET',
		data: {Program_Code:val},
		success: function(response){
			
			result = JSON.parse(response);
			

		},
		fail: function(){

			alert('Error: request failed');
			return;
		}
	});
	return result;
}
function get_curriculum(val){

	url = '<?php echo base_url(); ?>index.php/Registrar/get_curriculum';

	ajax = $.ajax({
		async: false,
		url: url,
		type: 'GET',
		data: {Program_Code:val},
		success: function(response){
			
			result = JSON.parse(response);
			

		},
		fail: function(){

			alert('Error: request failed');
			return;
		}
	});
	return result;
}
function display_result(result){

	$('#major').html('');
	if(result.length != 0){

		$.each(result, function(index, row){
			$('#major').append('<option value="'+row['ID']+'">'+row['Program_Major']+'</option>');
		});

	}else{
		$('#major').html('<option value="">N/A</option>');
	}
	$("#major").selectpicker('refresh');

}
function display_curriculum(result){

$('#curriculum').html('');
if(result.length != 0){

	$.each(result, function(index, row){
		$('#curriculum').append('<option value="'+row['Curriculum_ID']+'">'+row['Curriculum_Name']+'</option>');
	});

}else{
	$('#curriculum').html('<option value="">N/A</option>');
}
$("#curriculum").selectpicker('refresh');

}
function clear_selection(){
	
	$("#select_student").trigger( "click" );
}
function submit_form(){

	$('#submit_sy').val($('#schoolYear').val());
	$('#submit_sm').val($('#semester').val());
	$('#shift_form').submit();

}
</script>
	


