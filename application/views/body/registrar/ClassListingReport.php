
<section class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> Class Listing Report </h1>
		</div>
		<!--/ MODULE TITLE-->

<?php 

foreach($this->data['ClassList'] as $row)  {

$sc      = $row->Sched_Code;	
$sy      = $row->SchoolYear;
$sem     = $row->Semester;
$section = $row->Section_Name;
$cc      = $row->Course_Code;
$yl      = $row->Year_Level;
$st      = $row->Startime;
$et      = $row->Endtime;
$day     = $row->Day;
$ct      = $row->Course_Title;
$room    = $row->Room;
$lec     = $row->Course_Lec_Unit;
$lab     = $row->Course_Lab_Unit;
$Ins     = $row->Instructor_Name;
}
	
$totalUnits = $lec + $lab;
?> 

		<div class="row">

			<div class="col-md-4">
			
				<!-- STUDENT SELECTION -->
		<form action="<?php echo base_url(); ?>index.php/<?php echo $this->router->fetch_class(); ?>/Class_List_Report" method="post">
				<div class="SBorder vertical_gap">
					<h4>Higher Education</h4><hr>
					<div class="form-line vertical_gap">
					
						<input  placeholder="Sched Code: <?php echo $sc; ?>"  value="<?php echo $sc; ?>" name="sched_code" type="text">
						
					</div>
					<select  class="form-control show-tick" data-live-search="true"  id="ES" class="danger" name="Semester" required>             
                            <option disabled>Semester: <?php echo $sem ; ?></option>
                    </select>
					<select  class="form-control show-tick" data-live-search="true"  id="ES" class="danger" name="School_year" required>             
                            <option disabled>School Year: <?php echo $sy; ?> </option>
                    </select>
				
					<div class="text-center">
					<br>
					  <button  name="submit" type="submit" class="btn btn-danger"> Search </button>
					  <button   type="submit" name="export" value="Export"   class="btn btn-success"> Export </button>
					  </form>
					</div>
				</div>

				<div class="SBorder">
					<div class="input-group">
						
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="name_view" placeholder="Section:  <?php echo $section; ?> ">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="program_view" placeholder="Course Code: <?php echo $cc; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="form-line">
							<input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="<?php echo $ct; ?>">
							<input type="hidden" name="name" value="">
						</div>
						<div class="row">
						   <div class="col-md-6">
						      <div class="form-line">
							     <input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Year: <?php echo $yl; ?>">
							     <input type="hidden" name="name" value="">
						    </div>
						   </div>
						   <div class="col-md-6">
						      <div class="form-line">
							     <input class="form-control date" disabled  type="text" id="schoolyear_view" placeholder="Units: <?php echo $totalUnits; ?>">
							     <input type="hidden" name="name" value="">
						    </div>
						   </div>
						</div>
					</div>
				</div>

				<div class="SBorder">
					<div class="input-group">
					   
					   <div class="row">
					       <div class="col-md-6">
						        <div class="form-line">
									<input class="form-control date" disabled  type="text" id="name_view" placeholder="Day: <?php echo $day; ?>">
									<input type="hidden" name="name" value="">
								</div>
						   </div>
						   <div class="col-md-6">
						      <div class="form-line">
									<input class="form-control date" disabled  type="text" id="name_view" placeholder="Room: <?php echo $room; ?>">
									<input type="hidden" name="name" value="">
								</div>
						   </div>
					   </div>
							
								<div class="form-line">
									<input class="form-control date" disabled  type="text" id="name_view" placeholder="Time: <?php echo $st; ?>-<?php echo $et; ?>">
									<input type="hidden" name="name" value="">
								</div>
						
							
								
						
					      <div class="form-line">
									<input class="form-control date" disabled  type="text" id="name_view" placeholder="Instructor: <?php echo $Ins; ?>">
									<input type="hidden" name="name" value="">
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-8">

					<!-- DISPLAYS SUBJECT OF CHOSEN STUDENT -->
					<div class="col-md-12" >
						<div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
							<div class="panel" style="background-color:#cc0000; color:#fff">
								<div class="panel-heading" role="tab" id="headingOne_19">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" href="#collapseOne_19" aria-expanded="true" aria-controls="collapseOne_19">
										Enrolled Student
										</a>
									</h4>
								</div>
								<div id="collapseOne_19" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_19" >
									<div class="panel-body" style="background-color:#fff; overflow:auto; max-height:700px">
										<table class="table table-bordered">
											<thead>
												<tr class="danger" style="font-size:14px">
													<th>No.</th>
													<th>Student Number</th>
													<th>Full Name</th>
													<th>Year Level</th>
													<th>Program</th>
												</tr>
											</thead>
											<tbody>
											<?php $count = 1; ?>
										    	<?php foreach($this->data['ClassList'] as $row)  {?> 
											      <tr style="text-transform: uppercase;">
												  <td><?php echo $count; ?></td>
												  <td><?php echo $row->Student_Number; ?></td>
												  <td><?php echo $row->Last_Name; ?>,   <?php echo $row->First_Name; ?> , <?php echo $row->Middle_Name; ?> </td>
												  <td><?php echo $row->Year_Level; ?></td>
												  <td><?php echo $row->Program; ?></td>

										     	  </tr> 
												 <?php $count++; ?>
										     	<?php }?>			
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
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>

	


