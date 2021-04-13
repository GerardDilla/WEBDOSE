<section class="content" style="background-color: #fff;">
	<div class="container-fluid">
		<div class="block-header">
			<h1>
				Schedule Report 
				<span class="searchloader" style="padding: 1%; display:none">
					<img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
				</span>

			</h1>
		</div>

			<form method="post" action="<?php echo base_url(); ?>index.php/<?php echo $this->router->fetch_class(); ?>/SchedReport">
				<div class="row"> 
						<div class="col-sm-10" style="padding:0px">
						<!--Ajax base url-->
						<input type="hidden" id="ajaxurl" value="<?php echo base_url(); ?>">
						<input type="hidden" id="ajaxclass" value="<?php echo $this->router->fetch_class(); ?>">
						<!--Schedcode, Sem and SY Input-->
						<?php
						$options_programs[''] = 'All Programs';
						foreach($this->data['programs'] as $prog_row){
							$options_programs[$prog_row['Program_Code']] = $prog_row['Program_Code'];
						}
						
						$attributes = 'id="program" tabindex="1" required class="form-control show-tick" data-live-search="true"';

						echo form_dropdown('program', $options_programs,'', $attributes);

						?>
						<select  id="schedsem_report" tabindex="1" required class="form-control show-tick" data-live-search="true" name="sem">
								<option disabled selected> Select Semester</option>
								<option>FIRST</option>	
								<option>SECOND</option>
								<option>SUMMER</option>
						</select>
							<br>
						<select  id="schedsy_report" tabindex="1" required class="form-control show-tick" data-live-search="true" name="sy">
								<option disabled selected> Select School Year</option>
								<option>2017-2018</option>	
								<option>2018-2019</option>	
								<option>2019-2020</option>
								<option>2020-2021</option>
						</select>
						<div id="schedreport_browser" style="padding:10px; display:none">
							<table>
								<thead>
									<tr style="width:100%">
									<th style="padding:15px">School Year: <u id="searchedsy"></u></th>
									<th style="padding:15px">Semester: <u id="searchedsem"></u></th>
									<th class="form-line" style="padding:15px 0px 15px 15px;">
										<input type="text" class="form-control"  id="searchkey" placeholder="Search...">
									</th>
									<th>
										<button type="button" class="btn btn-md btn-info" onclick="searchsched_report()"><i class="material-icons">search</i></button>
									</th>
									</tr>
								</thead>
							</table>
							<span style="padding:15px" id="sched_report_pagination"></span>
						</div>
						
				</div>
				<div class="col-sm-2" style="padding:0px">
						<!--
						<form method="post" action="<?php echo base_url(); ?>index.php/<?php echo $this->router->fetch_class(); ?>/SchedReport_Excel">
							<button style="height:50px; width:100%" class="btn btn-lg btn-danger pull-right" type="submit" name="export" value="Export" ><i class="material-icons">print</i> Export</button>
						</form>
						-->
						<button type="button" style="height:50px; width:100%" class="btn btn-lg btn-danger pull-right" onclick="export_excel()"><i class="material-icons">print</i> Export</button>
						<button type="button" class="btn btn-info" onclick="searchsched_report()" name="sched_filter" value="1" style="width: 100%; height:50px">Filter</button>
				</div>
					<!-- /Sem and SY Input -->
					<br>
					<div class="table panel panel-danger" style="overflow-x:auto;  max-height:500px; padding:20px;">
						<table style="width: 1400px; overflow-y:auto;" class="display">
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
								<?php /*foreach($this->data['Sched_report']  as $row)  {?>

								<?php 

									if ($row['Instructor_Name']  === NULL) {
										$Instructor = 'TBA';
									}else{
										$Instructor = $row['Instructor_Name'];
									}  
									if (($row['START'] === NULL) &&($row['END'] === NULL)) {
									$Time  = 'TBA';
									}else{
										$St = $this->data['TimeConverted'][$row['sched_display_id']]['start']; 
										$Et = $this->data['TimeConverted'][$row['sched_display_id']]['end'];

										$Time = $St.'-'.$Et;
									}  
								
								?>
								<tr>
									<?php $total_slot = ($row['Total_Slot']) - ($this->data['Sched_report_slot'][$count]); ?>
									<?php 
									if(($row['Total_Slot']) < ($this->data['Sched_report_slot'][$count])){
										$totalexceed = ($this->data['Sched_report_slot'][$count]) - ($row['Total_Slot']);
										$total_slot = '<b style="color:red">Exceeded: <b>'.$totalexceed;

									}
									?>
									<td><?php echo $row['Sched_Code']; ?></td>
									<td><?php echo $row['Course_Code']; ?></td>
									<td><?php echo $row['Course_Title']; ?></td>
									<td><?php echo $row['Section_Name']; ?></td>
									<td><?php echo $row['Course_Lec_Unit']; ?></td>
									<td><?php echo $row['Course_Lab_Unit']; ?></td>
									<td><?php echo $total_slot; ?></td>
									<td><?php echo $row['Day']; ?></td>
									<td><?php echo $Time; ?></td>
									<td><?php echo $row['Room']; ?></td>
									<td><?php echo $Instructor; ?></td>
								</tr>
								<?php $count++; ?>
								<?php }*/?>
							</tbody>
						</table>
					</div>
			    </div>
			</form>

			<script>
			$(document).ready(function(){
				$("#myInput").on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$("#myTable tr").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				});
			});
			</script>
		

	</div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>js/schedreport.js"></script>


 