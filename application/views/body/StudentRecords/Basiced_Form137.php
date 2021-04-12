
<section  id="top" class="content" style="background-color: #fff;">
	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">assignment_returned</i> Student Record</h1>
		</div>
		<!--/ MODULE TITLE-->

		<div class="row">
			<div class="col-md-4">

			<!-- STUDENT SELECTION -->
				<div class="SBorder vertical_gap">
					<h4>Basic Education</h4><hr>
					<div class="form-line vertical_gap">
						<input id="studentNumber" class="form-control date" value="" placeholder="Student Number:" name="student_num" type="text" required>
					</div>
					<div class="text-center vertical_gap">
						<button  type="submit" id="selectStudentNumber" class="btn btn-lg btn-info">SELECT</button>
					</div>
				</div>
			<!-- /STUDENT SELECTION -->

			<!-- INFO DISPLAY -->
                <div class="SBorder">
                    <div class="input-group">
                        <div class="form-line">
                            <input id="studentName" class="form-control date" disabled  type="text" id="name_view" placeholder="Name:  ">
                        </div>
                        <div class="form-line">
                            <input id="studentGradeLevel" class="form-control date" disabled  type="text" id="program_view" placeholder="Grade level: ">
                        </div>
                    </div>
                </div>
             <!-- INFO DISPLAY -->
				<br>

			</div>

            <form id="exportForm" action ="" method="POST">
			<div id="formExport" class="col-md-8">
				<div class="row">
					<div class="col-md-12" >
						<div class="SBorder row">
                            <div id="formSelector" class="form-line">
                                
                            </div>
                            <div class="form-line">
                                <input id="courseCompleted" name="courseCompleted" class="form-control date" disabled="" type="text">
                            </div>
                            <div class="form-line">
                                <input id="transferAdmission" name="transferAdmission" class="form-control date" disabled="" type="text"  placeholder="Admission:">
                            </div>
                            <div class="form-line">
                                <input id="recordRemarks" name="recordRemarks" class="form-control date" disabled="" type="text"  placeholder="Remarks:">
                            </div>
                            <div class="form-line">
                                <input id="recordReferenceNo" name="recordReferenceNo" class="form-control date" disabled="" type="text"  placeholder="Form 137 Reference No:">
                            </div>
                            <div class="form-line">
                                <input id="recordReleased" name="recordReleased" class="form-control date" disabled="" type="text"  placeholder="Released by:">
                            </div>
                            <div class="text-center vertical_gap">
                                <button type="button" id="exportFormButton" class="btn btn-lg btn-info" disabled="">Export Form 137</button>
                            </div>
						</div>
					</div> 
				</div>
            </div>
            <input id="hiddenStudentNumber" name ="studentNumber" type="hidden" />
            </form>

		</div>
	</div>
	<!--/CONTENT GRID-->
    <input type="hidden" id="addressUrl" value="<?php echo site_url().'/StudentRecords'; ?>"/>
</section>


<!-- TRANSFEREE MODAL-->
<div class="modal fade" id="formTransferee" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">BYPASS PRE-REQUISITES</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="bypasswarning">

				By turning this on you will be able to add subjects with unresolved Pre-Requisites, 
				this will require the <u><strong>Program Chair</strong></u> to sign in before using. <br><br>
				<div id="schedInfo"></div>
				<hr> 

				<h4>Sign-In Program Chair Account</h4>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">person</i>
					</span>
					<div class="form-line">
						<input type="text" id="bypassUserName" class="form-control" name="username" placeholder="Username" required autofocus>
					</div>
				</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">lock</i>
					</span>
					<div class="form-line">
						<input type="password" id="bypassPassword" class="form-control" name="password" placeholder="Password" required>
					</div>
				</div>
				<div>
					<input type="hidden" id="referenceNo" value="<?php echo $student_info['Reference_Number'] ?>" />									
				</div>
				<div id="bypassSchedDisplayId">
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CANCEL</button>
				<button type="submit" id="bypass_login" onclick="bypassLogin()" class="btn btn-success">CONFIRM</button>
			</div>
		</div>
	</div>
</div>
<!-- /TRANSFEREE MODAL-->


<script type="text/javascript" src="<?php echo base_url(); ?>js/studentRecords.js"></script>
<script>
	
</script>

  
	


