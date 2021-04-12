


<section  id="top" class="content" style="background-color: #fff;">

<!-- CONTENT GRID-->
<div class="container-fluid">

    <!-- MODULE TITLE-->
    <div class="block-header">
        <h1> <i class="material-icons" style="font-size:100%">system_update_alt</i>Senior High School  Inquiry Encoding</h1>
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
            <form id="sign_up" action="<?php echo base_url(); ?>index.php/Admission/"  method="POST">
                <div class="msg">Student Information Form</div>
                <hr style="border-top: 1px solid red;">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">nature_people</i>
                    </span>
                    <select tabindex="1" id="course_choices1" class="form-control show-tick" data-live-search="true"  id="ES" class="danger" name="Student" required>
                        <option disabled  selected>Select Type of Student:</option>
                        <option>New Student</option>
                        <option>Transferee</option>
                     </select>
                </div>
               <hr style="border-top: 1px solid red;">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">date_range</i>
                    </span>
                    <div class="form-line">
                        <input tabindex="2" type="date" class="form-control" name="date" placeholder="12/12/2012" required autofocus>
                    </div>
                </div>

                <div class="row">
                     <div class="col-md-6">
                     <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text"  tabindex="3"  class="form-control" name="fullname"  placeholder="Full Name:" required>
                        </div>
                    </div>
                     </div>
                     <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">confirmation_number</i>
                            </span>
                            <div class="form-line">
                               <select tabindex="4"  style="width: 100%;" data-live-search="true"   name="Student" required>
                                    <option disabled  selected>Select Level Applied:</option>
                                    <option>Grade 11</option>
                                    <option>Grade 12</option>
                               </select>
                            </div>
                        </div>
                     </div>
                </div>

                <div class="row">
                      <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person </i>
                            </span>
                            <div class="form-line">
                            <select tabindex="5"   data-live-search="true"  id="ES" class="danger" name="Student" required>
                                            <option disabled  selected>Select Gender:</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                            </div>
                        </div>
                     </div>

                      <div class="col-md-3">
                      </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">confirmation_number</i>
                                </span>
                                <div class="form-line">
                                    <input tabindex="6"  type="number" class="form-control" name="s_number"  placeholder="Contact Number:" required>
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
                                <input  tabindex="6" type="text" class="form-control" placeholder="Date of Birth:">
                            </div>
                        </div>
                     </div>

                        <div class="col-md-6">
                         <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">perm_contact_calendar</i>
                            </span>
                            <div class="form-line">
                                  <input tabindex="7"  type="text" class="form-control date" placeholder="Age:">
                            </div>
                        </div>
                     </div>
               </div>

       
               
               <div class="row">
                   <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">school</i>
                            </span>
                            <div class="form-line">
                                <input tabindex="11"  type="text" class="form-control" name="last_school" placeholder="Last Attended School:" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">perm_contact_calendar</i>
                            </span>
                            <div class="form-line">
                                <input tabindex="13" type="text" class="form-control" name="guardian_name" placeholder="Guardian`s Name:" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">confirmation_number</i>
                            </span>
                            <div class="form-line">
                                <input tabindex="14"  type="number" class="form-control" name="s_number"  placeholder="Contact Number:" required>
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
                                <input tabindex="15"  type="text" class="form-control" name="address"  placeholder="Present Address:" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">confirmation_number</i>
                            </span>
                            <div class="form-line">
                                <input tabindex="16"  type="number" class="form-control" name="s_number"  placeholder="Contact Number:" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <div class="form-line">
                                <input  tabindex="17" type="text" class="form-control" name="fb"  placeholder="Email Address:" required>
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
                                            <option disabled  selected>Select Strand</option>
                                            <?php 
                                         
                                                    foreach($this->data['get_strand'] as $row)  {
                                            ?>  
                                                 <option><?php echo $row->Strand_Code; ?></option>
                                            <?php }?>
                        </select>
                </div>

                     <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">spa</i>
                            </span>
                            <div class="form-line">
                                <input  tabindex="17" type="text" class="form-control" name="fb"  placeholder="Specialization:" required>
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


