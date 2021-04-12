
<section class="content">
	<form  method="post" id="schedform" action="<?php echo site_url()."/Registrar/savesubject"; ?>">
	<div class="container-fluid">
		<div class="block-header">
			<h1>Manage Schedule</h1>
		</div><!-- Basic Example -->
		<?php if($this->session->flashdata('msg')): ?>
				<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
		<?php endIf; ?>
		   <div class="row" style="background-color: #fff; padding: 30px 0px 30px 0px;">
			 	<?php if($this->session->flashdata('sched_msg')): ?>
					<div class="alert bg-green alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<?php echo $this->session->flashdata('sched_msg'); ?>
					</div>
				<?php endIf; ?>
		    <div class="col-md-3">
				 <div class="SBorder">
				 <!-- Sem and SY Input-->
					<?php 

						$option[''] = 'SELECT SCHOOLYEAR';
						$option['2017-2018'] = '2017-2018';
						$option['2018-2019'] = '2018-2019';
						$option['2019-2020'] = '2019-2020';
						$option['2020-2021'] = '2020-2021';
						
						$attribute = 'id="schedsy" class="form-control show-tick"  data-live-search="true"';
						echo form_dropdown('schedsy', $option,$this->data['legend'][0]['School_Year'],$attribute);

					?>
					<?php 

						$option2[''] = 'SELECT SEMESTER';
						$option2['FIRST'] = 'FIRST';
						$option2['SECOND'] = 'SECOND';
						$option2['SUMMER'] = 'SUMMER';

						$attribute2 = 'id="schedsem" class="form-control show-tick"  data-live-search="true"';
						echo form_dropdown('schedsem', $option2,$this->data['legend'][0]['Semester'],$attribute2);

					?>
				<!-- /Sem and SY Input -->
				<!-- In case needed to connect to legend again: Gerard 
				 <?php foreach($this->data['legend'] as $row){?>
					<h4>Semester:<span class="Beld"> <input type="hidden" name="semester" value="<?php echo $row['Semester']; ?>"> <?php echo $row['Semester']; ?> </span></h4>
					<h4>School Year:<span class="Beld"> <input type="hidden" name="schoolyear" value="<?php echo $row['School_Year']; ?>"> <?php echo $row['School_Year']; ?> </span></h4>
                 <?php }?>
				-->
				</div>
				<br>
			  <div class="text-center">
					<button type="button" class="btn-lg btn btn-success" data-toggle="modal" data-target="#viewsched_modal"> 
						Check Schedule
						<span class="searchloader" style="padding: 1%; display:none">
							<img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
						</span>
					</button>
					<!--
					<hr>
					<button type="button" class="btn-lg btn btn-success" onclick="open_edit_window('<?php echo base_url(); ?>index.php/Registrar/Sched_Management', '<?php echo $this->data['sy']; ?>', '<?php echo $this->data['semester']; ?>')"> Check Schedule </button>
					-->
				</div>
				<br>
				<div class="SBorder">
					<div class="input-group">
						

						<!-- Sched Code  -->
						<div class="form-line">
							<input class="form-control" disabled name= "schedcode" id="schedcode"  placeholder="Schedule Code" type="text" value="<?php echo "Schedule Code: ".$this->data['sched_code']; ?>">
							
						</div>

						<!-- Program Selector -->
							<select id="program" name="program" onchange="programsection(this.value,'<?php echo site_url()."/Registrar/Get_program"; ?>')" class="form-control show-tick"  data-live-search="true">
						               <option selected disabled>Select a Program Please</option>
						            <?php  foreach($this->data['programs'] as $row){?>
                                        <option value="<?php echo $row['Program_ID'];?>" <?php if($this->session->flashdata('program') == $row['Program_ID']): ?>selected <?php endIf; ?>> <?php echo $row['Program_Code']; ?> </option>
                                    <?php } ?>
                        	</select> 
                        	<hr>
                           
						<!-- Program Sections -->
						   <select id="section" name="section" class="form-control show-tick" onchange="getSchedCodeList('<?php echo site_url().'/Registrar/get_sched_code_info'; ?>', '<?php echo site_url().'/Registrar/get_schedule_info'; ?>')" data-live-search="true">
						        <option selected disabled>Select a Section Please</option>
								<?php
									
									# code...
									foreach ($this->data['section_list'] as $value) 
									{
										# code...								
								?>
										<option value="<?php echo $value['Section_ID']; ?>" <?php if($value['Section_ID'] === $this->data['section_id']){ ?> selected <?php } ?>> <?php echo $value['Section_Name']; ?> </option>
								<?php
									}
								?>
                           </select>
                        <hr>
						<hr> 
						
						<!--  Course Code -->
						<select id="course" name="course" onchange="subject(this.value,'<?php echo site_url().'/Registrar/Get_CourseTitle'; ?>'); getSchedCodeList('<?php echo site_url().'/Registrar/get_sched_code_info'; ?>', '<?php echo site_url().'/Registrar/get_schedule_info'; ?>');" class="form-control show-tick"  data-live-search="true">
								<option selected disabled>Subject Code</option>
								<?php foreach($this->data['subject'] as $row){?>
									<option value="<?php echo $row['Course_Code'];?>" <?php if($this->session->flashdata('course') == $row['Course_Code']): ?>selected <?php endIf; ?>> <?php echo $row['Course_Code'] ?>  </option>
								<?php }?>
						</select>

						<!-- Course Title -->
						<div class="form-line">
							
							<h5 id = "coursetitle" name = "coursetitle"></h5>
							<br>
							<h3>Units</h3>
							<h5 style="color:green;">Lecture: <span class="nobr" id="courselecunit"></span></h5>
							
							<h5 style="color:red;">Lab: <span class="nobr" id="courselabunit"></span></h5>
							
							<br>
						</div>
					
							
						<!-- Total Student -->
						<div class="form-line">
							<input class="form-control" name= "totalslot" id="totalslot"  placeholder="Total Students" type="number" value="<?php if($this->session->flashdata('totalslot')){echo $this->session->flashdata('totalslot'); } else{echo '40';} ?>">
						</div>
		                
					</div>
				</div><br>

				<div class="text-center">
			      <button type="button" class="btn-lg btn btn-success"  data-toggle="modal" data-target="#AddSched"> Add Schedule </button>
			      <button type="reset" class="btn-lg btn btn-warning" onClick="window.location.reload()"> Reset </button>
				</div>
			   </div>
			   <div class="col-md-9">
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
								<tr id = "tr_<?php echo $time['Time_From']; ?>">
									<td id = "td_<?php echo $time['Time_From']; ?>"><?php echo $time['Schedule_Time']; ?></td>
									<?php 
									$array_day = array('M', 'T', 'W', 'H', 'F', 'S', 'A');
									foreach ($array_day as $value) 
									{
										# code...
									
									?>
										<td class ="schedDisplay" id="<?php echo $time['Time_From']; ?>_<?php echo $value; ?>"></td>
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


  <div class="modal fade" id="AddSched" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Add Schedule</h4>

							<div id="schedule_error">
							</div>
                        </div>
                        <div class="modal-body">
						   <div class="SBorder">


						    <!-- Start Time-->
						    <select id="starttime" name="starttime" class="form-control show-tick"  data-live-search="true">
						   				<option selected disabled>Select Start Time</option>
						   			<?php foreach($this->data['time'] as $row){?>
                                        <option value="<?php echo $row['Time_From'];?>"><?php echo $row['Schedule_Time']; ?></option>
                                    <?php }?>
                             </select>

					
							<!-- End Time -->
						      <select id="endtime" name="endtime" class="form-control show-tick"  data-live-search="true">
						               <option selected disabled>Select End Time</option>
                                    <?php foreach($this->data['time'] as $row){?>
                                        <option value="<?php echo $row['Time_To'];?>"><?php echo $row['Schedule_Time']; ?></option>
                                    <?php }?>
							 </select>
							 <br><br>
							 <div class="text-center">

							<!-- Day -->	
							 <div class="form-group">

							 		<input type="checkbox" name="day[]" id="monday" class="chk-col-red" value="M">
							 		<label for="monday" class="m-l-20">M</label>
									
									<input type="checkbox" name="day[]" id="tuesday" class="chk-col-red" value="T">
									<label for="tuesday" class="m-l-20">T</label>
									
									<input type="checkbox" name="day[]" id="wedenesday" class="chk-col-red" value="W">
									<label for="wedenesday" class="m-l-20">W</label>
									
									<input type="checkbox" name="day[]" id="thursday" class="chk-col-red" value="H">
									<label for="thursday" class="m-l-20">TH</label>
									
									<input type="checkbox" name="day[]" id="friday" class="chk-col-red" value="F">
									<label for="friday" class="m-l-20">F</label>
									
									<input type="checkbox" name="day[]" id="saturday" class="chk-col-red" value="S">
									<label for="saturday" class="m-l-20">S</label>
									
									<input type="checkbox" name="day[]" id="sunday" class="chk-col-red" value="Sun">
									<label for="sunday" class="m-l-20">A</label>
									
                                    
                                </div>
				            	</div>
							</div><br>
							
							<!-- Room --> 	
							<select name="room" id="room" class="form-control show-tick"  data-live-search="true" onchange ="displayRoomSched(this.value, '<?php echo site_url().'/Registrar/get_room_sched'; ?>', '<?php echo site_url().'/Registrar/get_time'; ?>')">
						               <option selected disabled>Select a Room</option>
						            <?php  foreach($this->data['Room'] as $row){ ?>   
                                        <option value="<?php echo $row['ID'];?>"> <?php echo $row['Room']; ?> </option>
                                    <?php }  ?>
                            </select>
					
							<!-- Instructor -->
							<select name="instructor" id="instructor" class="form-control show-tick"  data-live-search="true">
									<option selected disabled>Select Instructor</option>
									<option value="0">To Be Announced</option>
									<?php foreach($this->data['instructor'] as $row){?>
									<option value="<?php echo $row['ID'];?>"> <?php echo $row['Instructor_Name']; ?> </option>
									<?php }?>
							</select>
							
                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="FormValidate('<?php echo site_url(); ?>/Registrar/ScheduleFormValidation')" class="btn btn-link waves-effect" >
							  Save
							</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
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
			        Are you sure you want to save current schedule?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
			        <button type="submit" id="savesubject" name="savesubject" class="btn btn-success">SAVE CHANGES</button>
			      </div>
			    </div>
			  </div>
			</div>
    </form>



<!-- VIEW/UPDATE SCHEDULE MODAL -->
<div class="modal fade" id="viewsched_modal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document" style="width:80vw">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title" id="largeModalLabel">CHECK / UPDATE SCHEDULE
				
				<span class="searchloader" style="padding: 1%; display:none">
					: LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
				</span>
				
				</h1> 				

				<input type="hidden" id="ajaxurl" value="<?php echo base_url(); ?>">
			</div>
			<div class="modal-body">
				<br>
				<div class="row">
						<div id="sched_removal_message" style="text-align:left;"></div>
						<hr>
						<div class="col-sm-4" style="border:none; padding-top:0px">
							<input class="form-control" id="searchkey" name="specified_sched" placeholder="Sched Code, Course Code, Course Title or Section...">
						</div>
						<div class="col-sm-3">
							<?php 
								$option2[''] = 'SELECT SEMESTER';
								$option2['FIRST'] = 'FIRST';
								$option2['SECOND'] = 'SECOND';
								$option2['SUMMER'] = 'SUMMER';

								$attribute2 = 'id="schedsem_edit" class="form-control show-tick"  data-live-search="true"';
								echo form_dropdown('schedsem', $option2,$this->data['legend'][0]['Semester'],$attribute2);
							?>
						</div>
						<div class="col-sm-3">
							<?php 
								$option[''] = 'SELECT SCHOOLYEAR';
								$option['2017-2018'] = '2017-2018';
								$option['2018-2019'] = '2018-2019';
								$option['2019-2020'] = '2019-2020';
								$option['2020-2021'] = '2020-2021';
								$attribute = 'id="schedsy_edit" class="form-control show-tick"  data-live-search="true"';
								echo form_dropdown('schedsy', $option,$this->data['legend'][0]['School_Year'],$attribute);
							?>
						</div>
						<div class="col-sm-2">
							<button type="submit" onclick="searchsched()" class="btn btn-info">Filter</button>
						</div>
				</div>

				<hr>

				<div id="schedCodeListDiv" class="table panel panel-danger" style="overflow-x:auto; max-height:300px">
					<table style="width:100%" class="display" id="schedCodeListTable">
						<thead>
						<tr style="width:100%">
							<th >Sched Code</th>
							<th >Subject Code</th>
							<th >Subject Title</th>
							<th >Section</th>
							<th >Lec Unit</th>
							<th >Lab Unit</th>
							<th >Total Slot</th>
							<th >Remaining Slot</th>
							<th >Day</th>
							<th >Time</th>
							<th >Room</th>
							<th>Instructor </th>
						</tr>
						</thead>
						<tbody id="sched_edit_table">

						</tbody>
					</table>
				</div>
				<hr>
				<div id="sched_edit_pagination"></div> 
			</div>
			<div class="modal-footer" style="padding:0px 40px 40px 40px">

			</div>
		</div>
	</div>
</div>
<!-- VIEW/UPDATE SCHEDULE MODAL -->


<!-- Edit Modal-->
<div class="modal fade" id="editsched_modal" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Schedule
				
				<span class="searchloader" style="padding: 1%; display:none">
					: LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
				</span>
				
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4 id="coursename"></h4>
				<!-- Edit form -->
				<form method="post" id="edit_sched_form" action="">
					<input type="hidden" id="addressUrlSchedInfo" value="<?php echo site_url().'/Registrar/get_schedule_info'; ?>">
					<div id="schedcode_hidden_input" style="text-align:left; text-transform:uppercase">
					<!---container for schedcode hidden input produced by jquery-->
					</div>

					<div id="schedInfoHidden">
					<!---container for schedId hidden input produced by jquery-->
					</div>

					<div id="edit_schedule_error" style="text-align:left;">
					</div>

					<hr>

					<div class="row">
						<div class="col-md-6">
							<!-- Start Time-->
							<label for="starttimeEditSched">START TIME</label>
							<select id="starttimeEditSched" name="starttime" class="form-control show-tick selectpicker" data-live-search="true" >
								<option selected disabled>Select Start Time</option>
								<?php foreach($this->data['time'] as $row){?>
									<option value="<?php echo $row['Time_From'];?>"><?php echo $row['Schedule_Time']; ?></option>
								<?php }?>
								<!-- CHOICES ARE PUT HERE VIA JQUERY: GERARD-->
							</select> 
						</div>
						<div class="col-md-6">
							<!-- End Time -->
							<label for="endtimeEditSched">END TIME</label>
							<select id="endtimeEditSched" name="endtime" class="form-control show-tick selectpicker" data-live-search="true">
								<option selected disabled>Select End Time</option>
								<?php foreach($this->data['time'] as $row){?>
									<option value="<?php echo $row['Time_To'];?>"><?php echo $row['Schedule_Time']; ?></option>
								<?php }?>
								<!-- CHOICES ARE PUT HERE VIA JQUERY: GERARD-->
							</select>
						</div>
					</div>


					<hr>
					<label for="roomEditSched">DAY</label>
					<div class="text-center">
						<!-- Day -->
						<div class="form-group">

							<input type="checkbox" name="day[]" id="dayEditSched_M" class="chk-col-red" value="M">
							<label for="dayEditSched_M">M</label>
							
							<input type="checkbox" name="day[]" id="dayEditSched_T" class="chk-col-red" value="T">
							<label for="dayEditSched_T" class="m-l-20">T</label>
							
							<input type="checkbox" name="day[]" id="dayEditSched_W" class="chk-col-red" value="W">
							<label for="dayEditSched_W" class="m-l-20">W</label>

							<input type="checkbox" name="day[]" id="dayEditSched_H" class="chk-col-red" value="H">
							<label for="dayEditSched_H" class="m-l-20">TH</label>
							
							<input type="checkbox" name="day[]" id="dayEditSched_F" class="chk-col-red" value="F">
							<label for="dayEditSched_F" class="m-l-20">F</label>
							
							<input type="checkbox" name="day[]" id="dayEditSched_S" class="chk-col-red" value="S">
							<label for="dayEditSched_S" class="m-l-20">S</label>
							
							<input type="checkbox" name="day[]" id="dayEditSched_Sun" class="chk-col-red" value="Sun">
							<label for="dayEditSched_Sun" class="m-l-20">SUN</label>
							
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6">
							<!-- Room --> 
							<label for="roomEditSched">ROOM</label>
							<select id="roomEditSched" name="room" class="form-control show-tick selectpicker" data-live-search="true"  onchange="displayRoomSched(this.value, '<?php echo site_url().'/Registrar/get_room_sched'; ?>', '<?php echo site_url().'/Registrar/get_time'; ?>')">
								<option selected disabled>Select a Room</option>
									<?php  foreach($this->data['Room'] as $row){ ?>   
										<option value="<?php echo $row['ID'];?>"> <?php echo $row['Room']; ?> </option>
									<?php }  ?>
								<!-- CHOICES ARE PUT HERE VIA JQUERY: GERARD-->
							</select> 
						</div>
						<div class="col-md-2">
							<label for="editslot">SLOTS</label>
							<input type="number" class="form-control" id="editslot" name="edit_total_slot" placeholder="SLOTS">
						</div>
						<div class="col-md-4">
							<label>Slots: <u><span id="editview_total_slots"></span></u></label><br>
							<label>Total Enrollees: <u><span id="editview_total_enrollees"></u></span></label>
							<label>Total Advised: <u><span id="editview_total_advised"></u></span></label>
							<label>Available: <u><span id="editview_total_available"></u></span></label><br>
							<label>Exceeding: <u><span id="editview_total_exceeding"></u></span></label><br>

						</div>
					</div>

					<hr>

					<!-- Instructor -->
					<label for="instructorEditSched">INSTRUCTOR</label>
					<select id="instructorEditSched" name="instructor" class="form-control show-tick selectpicker" data-live-search="true">
						<option selected disabled>Select Instructor</option>
							<option id="e_instructor_0" value="0">To Be Announced</option>
							<?php foreach($this->data['instructor'] as $row){?>
							<option id="e_instructor_<?php echo $row['ID'];?>" value="<?php echo $row['ID'];?>"> <?php echo $row['Instructor_Name']; ?> </option>
							<?php }?>
						<!-- CHOICES ARE PUT HERE VIA JQUERY: GERARD-->
					</select>

					<hr>

					<!-- Section -->
					<label for="sectionEditSched">SECTION</label>
					<select id="sectionEditSched" name="section" class="form-control selectpicker" data-live-search="true">
					<option selected disabled value="0">Select Section</option>	
					<?php foreach($this->data['section'] as $sectionrow){?>
							<option id="e_section_<?php echo $sectionrow['Section_ID'];?>" value="<?php echo $sectionrow['Section_ID'];?>"> <?php echo $sectionrow['Section_Name']; ?> </option>
					<?php }?>
					</select>
					<hr>


					<!-- Modal Confirmation-->
					<div class="modal fade" id="editConfirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
					<div class="modal-dialog modal-sm" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="confirm_modal_exit()" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							Are You Sure You Want to Update The Current Schedule?
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-link waves-effect" onclick="confirm_modal_exit()">Back</button>
							<button type="button" id="savesubject" name="savesubject" class="btn btn-success" onclick="Schedule_update('<?php echo site_url().'/Registrar/ajax_update_schedule'; ?>')">Proceed</button>
						</div>
						</div>
					</div>
					</div>
					<!--/ Modal Confirmation-->

					<!-- Modal Confirmation: Remove-->
					<div class="modal fade" id="RemoveConfirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
					<div class="modal-dialog modal-sm" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" onclick="remove_modal_exit()" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								Are You Sure You Want to Remove This Schedule Instance?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link waves-effect" onclick="remove_modal_exit()">Back</button>
								<button type="button" id="savesubject" name="savesubject" class="btn btn-success" onclick="remove_sched('<?php echo site_url(); ?>')">Proceed</button>
							</div>
						</div>
					</div>
					</div>
					<!--/ Modal Confirmation: Remove-->

				</form>
				<!-- /Edit form -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
				<button class="btn btn-danger btn-lg pull-left" data-toggle="modal" data-target="#RemoveConfirmation">REMOVE</button>
				<button type="submit" id="savesubject" onclick="EditFormValidate('<?php echo site_url().'/Registrar/edit_schedule_form_validation'; ?>')" name="savesubject" class="btn btn-success">SAVE CHANGES</button>
			</div>
		</div>
	</div>
</div>
<!-- /Edit Modal-->
</section>

<script>
$( '#program' ).load(function() {
  // Run code
  section = $('#program').val();
  if (section) 
  {
	  console.log(section);
  }
});
</script>
<script>
function open_edit_window(url,sy,sem){
	window.open(url+'/'+sem+'/'+sy, 'SCHEDULE MANAGEMENT', 'window settings');
}
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/schedule.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/schedcheck.js"></script>
