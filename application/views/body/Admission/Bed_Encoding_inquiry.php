


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
		<h1> <i class="material-icons" style="font-size:100%">system_update_alt</i>Basic Education Inquiry Encoding</h1>
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

                   <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">date_range</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="1"  type="date"   class="form-control " name="datename" placeholder="12/12/2012" required>
                                </div>
                            </div>
                        </div>
                   </div>

                   <div class="row">
                       <div class="col-md-3">
                           <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">confirmation_number</i>
                                </span>
                                    <div class="form-line">
                                        <select tabindex="2"   data-live-search="true"  id="ES" class="danger" name="Student" required>
                                            <option disabled  selected>Select Level Applied:</option>
                                            <?php 
                                         
                                                    foreach($this->data['get_lvl'] as $row)  {
                                            ?>
                                                 <option><?php echo $row->Grade_Level; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                            </div>
                       </div>
                   </div>


                    <div class="row">
                       <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="3"  type="text" class="form-control" name="fullname"  placeholder="Nickname:" required>
                                </div>
                            </div>
                       </div>
                       <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                       <select tabindex="4"   data-live-search="true"  id="ES" class="danger" name="Student" required>
                                            <option disabled  selected>Select Gender:</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                </div>
                            </div>
                       </div>
                   </div>

                    <div class="row">
                       <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">date_range</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="5"  type="date"   class="form-control " name="datename" placeholder="12/12/2012" required>
                                </div>
                            </div>
                       </div>
                       <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="6"  type="text" class="form-control" name="fullname"  placeholder="Age:" required>
                                </div>
                            </div>
                       </div>
                   </div>
  
                   <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">streetview</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="7"  type="text" class="form-control" name="fullname"  placeholder="Home Address:" required>
                                </div>
                            </div>
                        </div> 
                   </div>

                     <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">confirmation_number</i>
                                </span>
                                <div class="form-line">
                                    <input  tabindex="8 " type="text" class="form-control" name="s_number"  placeholder="Contact Details:" required>
                                </div>
                            </div>
                        </div> 
                   </div>

                     <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">confirmation_number</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="9" type="text" class="form-control" name="s_number"  placeholder="Last School Attended:" required>
                                </div>
                            </div>
                        </div> 
                   </div>

                    <hr style="border-top: 1px solid red;">
                    
                    
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">gps_fixed</i>
                        </span>

                           <select tabindex="10" class="form-control show-tick"  data-live-search="true"  id="ES" class="danger" name="Student" required>
                                            <option disabled  selected>How did you learn about us?</option>
                                            <?php 
                                         
                                                    foreach($this->data['get_Knowabout'] as $row)  {
                                            ?>
                                                 <option><?php echo $row->item; ?></option>
                                            <?php }?>
                        </select>
    
                    </div>
                    
                       <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person_pin_circle</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="11" type="text" class="form-control" name="s_number"  placeholder="Family members enroled:" required>
                                </div>
                         </div>

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person_pin</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="12" type="text" class="form-control" name="s_number"  placeholder="Family members employed:" required>
                                </div>
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

	
