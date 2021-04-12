
<section  id="top" class="content" style="background-color: #fff;">
	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">assignment_returned</i> Senior High School Student Record</h1>
		</div>
		<!--/ MODULE TITLE-->

		<div class="row">
			<div class="col-md-4">

                <!-- STUDENT SELECTION -->
				<div class="SBorder vertical_gap">
                    <h4>Senior High School</h4><hr>
                    <div class="input-group">
                        <div class="form-line vertical_gap">
                            <input id="studentNumber" class="form-control" value="" placeholder="Student Number:" name="student_num" type="text" required>
                        </div>
                        <div class="text-center vertical_gap">
                            <button  type="submit" id="shsSelectStudentNumber" class="btn btn-lg btn-info">SELECT</button>
                        </div>
                    </div>
				</div>
                <!-- /STUDENT SELECTION -->
                <br>
                <!-- INFO DISPLAY -->
                <div class="SBorder">
                    <div class="input-group">
                        <div class="form-line">
                            <input id="studentName" class="form-control" disabled  type="text" id="name_view" placeholder="Name:  ">
                        </div>
                        <div class="form-line">
                            <input id="studentGradeLevel" class="form-control" disabled  type="text" id="program_view" placeholder="Grade level: ">
                        </div>
                    </div>
                </div>
                <!-- INFO DISPLAY -->
                <br>
            <form id="exportForm" action ="" method="POST">
                <!-- INFO DISPLAY -->
                <div class="SBorder formExport">
                    <h4>Record</h4><hr>
                    <div class="input-group">
                        <div class="form-line">
                            <input id="recordRemarks" name="recordRemarks" class="form-control" disabled="" type="text"  placeholder="Remarks:">
                        </div>
                        <div class="form-line">
                            <input id="recordReferenceNo" name="recordReferenceNo" class="form-control" disabled="" type="text"  placeholder="Form 137 Reference No:">
                        </div>
                        
                    </div>
                    <div class="input-group">
                        <div class="form-line">
                            <input type="checkbox" id="checkbox_grad" class="graduatedCheckBox" name = "isGraduated" value="1" disabled="" >
                            <label for="checkbox_grad">is the student SHS graduate?</label>
                        </div>
                        <div class="form-line dateGraduated">
                            <b class="black">Date Graduated</b>
                            <input type="date" id="graduationDate" name="graduationDate" class="form-control" disabled="">
                        </div>
                    </div>
                </div>
                <!-- INFO DISPLAY -->
                

			</div>

            
			<div class="col-md-8">
				
                <div class="SBorder">
                <h4>Student Information</h4><hr>
                    <h5 class="card-inside-title">Entrance Data</h5>
                    <div class="input-group">

                    
                            <input type="checkbox" id="checkbox_1" class="entranceDataCheckBox"  name = "entranceData[]" value="PSA BIRTH CERTIFICATE" disabled="" >
                            <label for="checkbox_1">PSA BIRTH CERTIFICATE</label>

                            <input type="checkbox" id="checkbox_2" class="entranceDataCheckBox" name = "entranceData[]" value="FORM 137-A" disabled="" >
                            <label for="checkbox_2">FORM 137-A</label>
                            
                            <input type="checkbox" id="checkbox_3" class="entranceDataCheckBox" name = "entranceData[]" value="FORM 138" disabled="" >
                            <label for="checkbox_3">FORM 138</label>

                            <input type="checkbox" id="checkbox_4" class="entranceDataCheckBox"  name = "entranceData[]" value="GMC" disabled="" >
                            <label for="checkbox_4">GMC</label>

                            <input type="checkbox" id="checkbox_5" class="entranceDataCheckBox"  name = "entranceData[]" value="PICTURE" disabled="" >
                            <label for="checkbox_5">PICTURE</label>
                        
                    </div>
                    <br>
                    <div class="input-group formExport">
                        
                        <div class="form-line">
                            <b class="black">Birth Date</b>
                            <input type="date" id="birthDate" name="birthDate" class="form-control" disabled="">
                        </div>
                        
                    </div>
                    <div class="input-group formExport">
                        
                        
                        <div class="form-line">
                            <b class="black">Admission Date</b>
                            <input type="date" id="admissionDate" name="admissionDate" class="form-control" disabled="">
                        </div>

                    </div>
                    
                </div>

                <br>

                <div class="SBorder formExport">
                <h4>Elementary School Info</h4><hr>
                    <div class="input-group">
                        <div class="form-line">
                            <input id="elementarySchoolName" name="elementarySchoolName" class="form-control" disabled="" type="text" placeholder="School Name:">
                        </div>
                        <div class="form-line">
                            <input id="elementaryGeneralAvergae" name="elementaryGeneralAvergae" class="form-control" disabled="" type="text"  placeholder="General Average:">
                        </div>
                        <div class="form-line">
                            <input id="elementaryYear" name="elementaryYear" class="form-control" disabled="" type="text"  placeholder="Year:">
                        </div>
                    </div>
                </div>

                <br>

                <div class="SBorder formExport">
                <h4>Secondary School Info</h4><hr>
                    <div class="input-group">
                        <div class="form-line">
                            <input id="secondarySchoolName" name="secondarySchoolName" class="form-control" disabled="" type="text" placeholder="School Name:">
                        </div>
                        <div class="form-line">
                            <input id="secondaryGeneralAvergae" name="secondaryGeneralAvergae" class="form-control" disabled="" type="text"  placeholder="General Average:">
                        </div>
                        <div class="form-line">
                            <input id="secondaryYear" name="secondaryYear" class="form-control" disabled="" type="text"  placeholder="Year:">
                        </div>
                    </div>
                </div>

                <br>

                <div class="SBorder formExport">
                    <div class="text-center vertical_gap">
                        <button type="button" id="exportShsFormButton" class="btn btn-lg btn-info" disabled="">Export Form 137</button>
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





<script type="text/javascript" src="<?php echo base_url(); ?>js/studentRecords.js"></script>

  
	


