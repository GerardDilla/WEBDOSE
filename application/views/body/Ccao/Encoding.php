


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">system_update_alt</i>Encoding</h1>
		</div>
		<!--/ MODULE TITLE-->

  

   <div class="card">
            <div class="body">
            <?php if($this->session->flashdata('Inquiry')): ?>
			   <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<br>
					<h4><?php echo $this->session->flashdata('Inquiry'); ?></h4>
                </div>
            <?php endif; ?>
                <form id="sign_up" action="<?php echo base_url(); ?>index.php/Ccao/Encoding_Insert"  method="POST">
					<div class="msg">Student Information Form</div>
	               <hr style="border-top: 1px solid red;">
                       <div class="form-group">
                        <input type="radio" name="school" id="HED" value="HED" class="filled-in chk-col-warning radioChoose"  required>
						<label for="HED">Higher Education</label>
						<input type="radio" name="school" id="SHS" value="SHS" class="filled-in chk-col-warning radioChoose"  required>
						<label for="SHS">Senior High School</label>
						<input type="radio" name="school" id="BED" value="BED"  class="filled-in chk-col-warning radioChoose"  required>
                        <label for="BED">Basic Education</label>
                    </div>
					<hr style="border-top: 1px solid red;">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">date_range</i>
                        </span>
                        <div class="form-line">
                            <input type="date" class="form-control" name="date" placeholder="12/12/2012" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">school</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="last_school" placeholder="School:" required>
                        </div>
					</div>
					<hr style="border-top: 1px solid red;">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="fullname"  placeholder="Full Name:" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">confirmation_number</i>
                        </span>
                        <div class="form-line">
                            <input type="number" class="form-control" name="s_number"  placeholder="Contact Number:" required>
                        </div>
					</div>
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="fb"  placeholder="FB Account:" required>
                        </div>
					</div>
					<hr style="border-top: 1px solid red;">
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">perm_contact_calendar</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="guardian_name" placeholder="Guardian`s Name:" required>
                        </div>
					</div>
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">work</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="occupation"  placeholder="Occupation:" required>
                        </div>
					</div>
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">confirmation_number</i>
                        </span>
                        <div class="form-line">
                            <input type="number" class="form-control" name="g_number" placeholder="Contact Number:" required>
                        </div>
					</div>
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">streetview</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="address"  placeholder="Present Address:" required>
                        </div>
					</div>
					<hr style="border-top: 1px solid red;">
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">gps_fixed</i>
                        </span>
                        <select id="course_choices1" class="form-control show-tick" data-live-search="true"  id="ES" class="danger" name="1st" required>
                            <option disabled  selected>Select 1st Choice:</option>
                         </select>
					</div>
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">gps_fixed</i>
                        </span>
                        <select id="course_choices2" class="form-control show-tick" data-live-search="true"  id="ES" class="danger" name="2nd" required>
                            <option disabled  selected>Select 2nd Choice:</option>
                            
                         </select>
					</div>
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">gps_fixed</i>
                        </span>
                    <select id="course_choices3" class="form-control show-tick" data-live-search="true"  id="ES" class="danger" name="3rd" required>
                            <option disabled  selected>Select 3rd Choice:</option>

                    </select>
					</div>

					<hr style="border-top: 1px solid red;">
                 
					  
					<div class="text-center">
                    <button class="btn btn-lg bg-pink waves-warning"  onclick="return confirm('Are you sure you want to insert?')" type="submit">SUBMIT</button>
                   </div>
                  
                </form>
            </div>
        </div>















			
	</div>
	<!--/CONTENT GRID-->

</section>






	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>

	
