<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></script>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url('css/iziToast.min.css'); ?>">

<section class="content">

	<!-- CONTENT GRID-->
	<div class="container-fluid" style="min-height:600px">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> Bypass Manager </h1>
		</div>
		<!--/ MODULE TITLE-->

		<div class="row">

			<div class="col-md-2" style="padding-right:0px">

				<!-- STUDENT SELECTION -->
				<div class="SBorder vertical_gap" style="background-color:#fff">

					<h4>Search Filter</h4>
					<hr>

					<div class="form-line vertical_gap">

						<input placeholder="Search by Name / Username..." id="searchkey" type="text" style="padding:5px 5px">

					</div>
					<br>
					<select class="form-control show-tick" data-live-search="true" id="department" class="danger" name="Semester" required>
						<option value=''>Department</option>
						<?php foreach ($this->Departments as $dept) : ?>
							<option><?php echo $dept['dept']; ?></option>
						<?php endforeach; ?>
					</select>
					<br><br>
					<div class="text-center">
						<br>
						<button class="btn btn-info" id="filter"> Search </button>
						<br><br>
					</div>

				</div>

			</div>

			<div class="col-md-10" style="padding-left:0px">

				<!-- DISPLAYS SUBJECT OF CHOSEN STUDENT -->
				<div class="col-md-12">
					<div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
						<div class="panel" style="background-color:#cc0000; color:#fff">
							<div class="panel-heading" role="tab" id="headingOne_19">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" href="#collapseOne_19" aria-expanded="true" aria-controls="collapseOne_19">
										User List
									</a>
								</h4>
							</div>
							<div id="collapseOne_19" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_19">
								<div class="panel-body" style="background-color:#fff; overflow:auto; max-height:700px">
									<table class="table table-bordered" id="user_table">
										<thead>
											<tr class="danger" style="font-size:14px">
												<th>ID</th>
												<th>Username</th>
												<th>Full Name</th>
												<th>Department</th>
												<th>Bypass Permission</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
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
	<!--/CONTENT GRID-->

</section>


<div class="modal fade" id="updateBypass" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Bypass Permissions: <span style="color:#666" id="selected_user"></span></h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="userid_update" value="">
				<div class="row" id="permission-choices">

				</div>
			</div>
			<div class="modal-footer">
				<button id="update_permission" class="btn btn-success">UPDATE</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bypassmanager.js"></script>