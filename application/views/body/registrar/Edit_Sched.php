<section class="content">
<h2>Manage Schedule: <br><?php echo $this->data['sem'].','; ?> <?php echo $this->data['sy']; ?></h2>
<br><br>
<div class="row">
<h2><?php echo $this->session->flashdata('editmessage'); ?></h2>


<div class="shadow" style="display:none; background-color:#fff; padding:10px" id="edit_pane">
	<form method="post" id="edit_sched_form" action="<?php echo site_url().'/Registrar/update_schedule'; ?>">
		
		<h3 id="name"></h3>

		<div id="schedcode_hidden_input" style="text-align:left; text-transform:uppercase">
		<!---container for schedcode hidden input produced by jquery-->
		</div>

		<div id="schedInfoHidden">
		<!---container for schedId hidden input produced by jquery-->
		</div>

		<div id="edit_schedule_error" style="text-align:left;">
		</div>

		<hr>
			<!-- Start Time-->
			<select id="starttimeEditSched" name="starttime" class="form-control show-tick selectpicker shadow" data-live-search="true" >
				<option selected disabled>Select Start Time</option>
				<?php foreach($this->data['time'] as $row){?>
					<option value="<?php echo $row['Time_From'];?>"><?php echo $row['Schedule_Time']; ?></option>
				<?php }?>
				<!-- CHOICES ARE PUT HERE VIA JQUERY: GERARD-->

			</select> <!-- End Time -->
			<select id="endtimeEditSched" name="endtime" class="form-control show-tick selectpicker shadow" data-live-search="true">
				<option selected disabled>Select End Time</option>
				<?php foreach($this->data['time'] as $row){?>
					<option value="<?php echo $row['Time_To'];?>"><?php echo $row['Schedule_Time']; ?></option>
				<?php }?>
				<!-- CHOICES ARE PUT HERE VIA JQUERY: GERARD-->
			</select><br>
			
			<br>
			<div class="text-center">
				<!-- Day -->
				<div class="form-group">
					<input type="checkbox" name="day[]" id="dayEditSched_M" class="chk-col-red" value="M">
					<label for="dayEditSched_M">M</label>

					<input type="checkbox" name="day[]" id="dayEditSched_T" class="chk-col-red" value="T">
					<label for="dayEditSched_T" class="m-l-20">T</label>
					
					<input type="checkbox" name="day[]" id="dayEditSched_W" class="chk-col-red" value="W">
					<label for="dayEditSched_W" class="m-l-20">W</label>
					
					<input type="checkbox" name="day[]" id="dayEditSched_TH" class="chk-col-red" value="H">
					<label for="dayEditSched_TH" class="m-l-20">TH</label>
					
					<input type="checkbox" name="day[]" id="dayEditSched_F" class="chk-col-red" value="F">
					<label for="dayEditSched_F" class="m-l-20">F</label>
					
					<input type="checkbox" name="day[]" id="dayEditSched_S" class="chk-col-red" value="S">
					<label for="dayEditSched_S" class="m-l-20">S</label>
					
					<input type="checkbox" name="day[]" id="dayEditSched_SU" class="chk-col-red" value="Sun">
					<label for="dayEditSched_SU" class="m-l-20">A</label>
				</div>
			</div>
			<!-- Room --> 
			<select id="roomEditSched" name="room" class="form-control show-tick selectpicker shadow" data-live-search="true"  onchange="displayRoomSched(this.value, '<?php echo site_url().'/Registrar/get_room_sched'; ?>', '<?php echo site_url().'/Registrar/get_time'; ?>')">
				<option selected disabled>Select a Room</option>
					<?php  foreach($this->data['Room'] as $row){ ?>   
						<option value="<?php echo $row['ID'];?>"> <?php echo $row['Room']; ?> </option>
					<?php }  ?>
				<!-- CHOICES ARE PUT HERE VIA JQUERY: GERARD-->

			</select> <!-- Instructor -->
			<select id="instructorEditSched" name="instructor" class="form-control show-tick selectpicker shadow" data-live-search="true" id="instructor" name="instructor">
				<option selected disabled>Select Instructor</option>
				<option value="0">To Be Announced</option>

				<?php foreach($this->data['instructor'] as $row){?>
					<option value="<?php echo $row['ID'];?>"> <?php echo $row['Instructor_Name']; ?> </option>
				<?php }?>
				<!-- CHOICES ARE PUT HERE VIA JQUERY: GERARD-->

			</select>
			<br><br><br>
			<button type="submit" name="removebutton" onClick="if(!confirm('Are you sure you want to delete?')){return false;}" class="btn btn-danger btn-lg pull-left">Remove</button>

			<button type="button" onclick="EditFormValidate('<?php echo site_url().'/Registrar/edit_schedule_form_validation'; ?>')" class="btn btn-success btn-lg pull-right">Update Schedule</button>
			<br>			
			<!-- Modal Confirmation-->
			<div class="modal fade" id="editConfirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Schedule</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Are you sure you want to Update current schedule?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
					<button type="submit" id="savesubject" name="savesubject" class="btn btn-success">SAVE CHANGES</button>		
				</div>
				</div>
			</div>
			</div>
	</form>
	<br><br>
</div>

<br>
<hr>
<br>

<form action="<?php echo base_url(); ?>index.php/Registrar/Sched_search" method="post">
	<div class="col-sm-10" style="padding:0px">
	<!--Schedcode, Sem and SY Input-->
	<input class="form-control" name="specified_sched" placeholder="Search By: Sched Code, Course Code, Course Title or Section...">
	<select id="schedsem" name="schedsem" class="form-control show-tick" required data-live-search="true">
				<option selected disabled>SELECT SEMESTER</option>
				<option value="FIRST">FIRST</option>
				<option value="SECOND">SECOND</option>
				<option value="SUMMER">SUMMER</option>
	</select>
	<select id="schedsy" name="schedsy" class="form-control show-tick" required data-live-search="true">
				<option selected disabled>SELECT SCHOOLYEAR</option>
				<option value="2017-2018">2017-2018</option>
				<option value="2018-2019">2018-2019</option>
				<option value="2019-2020">2019-2020</option>
	</select>
	</div>
	<div class="col-sm-2" style="padding:0px">
	<button type="submit" class="btn btn-info" style="width:100%; height:100px">Filter</button>
	</div>
	<!-- /Sem and SY Input -->
</form>
</div>
<div id="schedCodeListDiv" class="table panel panel-danger" style="overflow-x:auto; max-height:300px">
	<table style="width:100%" class="display" id="schedCodeListTable">
		<thead>
		<tr style="width:100%">
			<th>Sched Code</th>
			<th>Subject Code</th>
			<th>Subject Title</th>
			<th>Section</th>
			<th>Lec Unit</th>
			<th>Lab Unit</th>
			<th>Total Slot</th>
			<th>Available Slot</th>
			<th>Day</th>
			<th>Time</th>
			<th>Room</th>
			<th>Instructor</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
			foreach($this->data['checksched'] as $row)
			{ 
		?>
			<tr>

				<td ><?php echo $row['Sched_Code'];?></td>
				<td ><?php echo $row['Course_Code'];?></td>
				<td ><?php echo $row['Course_Title'];?></td>
				<td ><?php echo $row['Section_Name'];?></td>
				<td ><?php echo $row['Course_Lec_Unit'];?></td>
				<td ><?php echo $row['Course_Lab_Unit'];?></td>
				<td ><?php echo $row['Total_Slot']; ?></td>
				<td ><?php echo $this->data['Sched_slot'][$row['sched_display_id']];?></td>
				<td><?php echo $row['Day']; ?> </td>
				<td><?php echo $row['Start_Time']."-".$row['End_Time']; ?> </td>
				<td><?php echo $row['Room']; ?> </td>
				<td><?php echo $row['Instructor_Name']; ?> </td>
				<!-- <td><button type="button" class="btn btn-info" onclick="showedit('<?php echo $row['Course_Title'];?>','<?php echo $row['Sched_Code'];?>')">Edit</button></td> -->
				<td><button type="button" id="<?php echo $row['sched_display_id'];?>" class="btn btn-info" onclick="editSchedCodeSchedule('<?php echo $row['sched_display_id'];?>','<?php echo site_url().'/Registrar/get_schedule_info'; ?>','<?php echo addslashes($row['Course_Title']); ?>')">Edit</button>
			</tr>
		<?php 
			} 
		?>
		</tbody>
	</table>
	
</div>
<?php echo $this->pagination->create_links(); ?>

</section> 

<!-- VIEW/UPDATE SCHEDULE MODAL -->
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
$('body').addClass('ls-closed');
</script>
<script>
$( document ).ready(function() {
    $('#schedsy option[value=<?php echo $this->data['sy']; ?>]').attr('selected', 'selected');
	$("#schedsy").selectpicker('refresh');

	$('#schedsem, option[value=<?php echo $this->data['sem']; ?>]').attr('selected', 'selected');
	$("#schedsem").selectpicker('refresh');
});

</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/schedule.js"></script>

