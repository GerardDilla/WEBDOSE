


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			
		</div>
		<!--/ MODULE TITLE-->

   

<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                        <h2> Basic Education Student Information</h2> 
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->

                            <?php if($this->session->flashdata('noref')): ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                        
                                                <br>
                                                <h4><?php echo $this->session->flashdata('noref'); ?></h4>
                                            </div>
                                    <?php endif; ?>
                                    <?php if($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                        
                                                <br>
                                                <h4><?php echo $this->session->flashdata('success'); ?></h4>
                                            </div>
                                    <?php endif; ?>
                     <form id="sign_up" action="<?php echo base_url(); ?>index.php/Admission/Student_Info_BED"  method="POST">
                            <div class="row">
                         
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <b class="red">Please Type Reference/Student Number:</b>
                                            <div class="form-line">
                                                <input type="number" name="sturef_number" class="form-control date" value="<?php echo $this->input->post('sturef_number'); ?>">
                                            </div>
                                            <span class="input-group-addon">
                                                <i class="material-icons">send</i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-danger btn-lg" name="search" type="submit">SEARCH</button>
                                    </div>
                                    <?php  
                                     $sturef =$this->input->post('sturef_number');
                                     if(isset($sturef)){
                                     ?>

                                    <div class="col-md-5">
                                       <div class="pull-right">
                                        <button name="edit"  type="button" onclick="disable()" class="btn btn-success btn-lg EditButton">EDIT</button>
                                        <br>
                                        <button name="enabledEdit"  type="button" onclick="enabled()" class="btn btn-success btn-lg DisabledEditButton">DISABLE EDIT</button>
                                      
                                        <br>
                                        <button name="update" onclick="return confirm('Are you sure you want to update?')" class="btn btn-info btn-lg UpdateButton" type="submit">UPDATE</button>
                                      
                                      </div>
                                    </div>
                            </div>

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#home_with_icon_title" data-toggle="tab" aria-expanded="false">
                                        <i class="material-icons">face</i> Personal Information
                                    </a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#profile_with_icon_title" data-toggle="tab" aria-expanded="false">
                                        <i class="material-icons">perm_identity</i> Parents Information
                                    </a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#messages_with_icon_title" data-toggle="tab" aria-expanded="false">
                                        <i class="material-icons">school</i> Academic Background
                                    </a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#other_with_icon_title" data-toggle="tab" aria-expanded="false">
                                        <i class="material-icons">announcement</i> Other Information
                                    </a>
                                </li>
                            </ul>
                 

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="home_with_icon_title">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">Reference Number:</b>
                                            </p>
                                                <div class="form-line">
                                                    <input type="text"class="form-control"   value="<?php echo $this->data['get_info'][0]['Reference_Number']; ?>" disabled>
                                                    <input type="hidden" name="ref_num" value="<?php echo $this->data['get_info'][0]['Reference_Number']; ?>">
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                             <p>
                                                <b class="red">Student Number:</b>
                                            </p>
                                                <div class="form-line">
                                                    <input type="text"   class="form-control"  value="<?php echo $this->data['get_info'][0]['Student_number']; ?>" disabled>
                                                    <input type="hidden" name="stu_num" value="<?php echo $this->data['get_info'][0]['Reference_Number']; ?>">
                                                </div>
                                        </div>

                                         <div class="col-md-4">
                                             <p>
                                                <b class="red">LRN:</b>
                                            </p>
                                                <div class="form-line">
                                                    <input type="text" name="lrn"  class="form-control InfoEnabled"  value="<?php echo $this->data['get_info'][0]['LRN']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                            <p>
                                                <b >Student`s Information</b>
                                            </p>

                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">First Name:</b>
                                            </p>
                                              <div class="form-line">
                                                    <input type="text" class="form-control InfoEnabled" name="first_name" value="<?php echo $this->data['get_info'][0]['First_Name']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">Middle Name:</b>
                                            </p>
                                                <div class="form-line">
                                                    <input type="text" class="form-control InfoEnabled"  name="middle_name" value="<?php echo $this->data['get_info'][0]['Middle_Name']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                           <p>
                                                <b class="red">Last Name:</b>
                                            </p>
                                                <div class="form-line">
                                                    <input type="text" class="form-control InfoEnabled" name="last_name"  value="<?php echo $this->data['get_info'][0]['Last_Name']; ?> " disabled>
                                                </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                          
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">Nickname:</b>
                                            </p>
                                                 <div class="form-line">
                                                    <input type="text" class="form-control InfoEnabled" name="nickname" value="<?php echo $this->data['get_info'][0]['Nick_Name']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">Grade Level:</b>
                                            </p>
                                                <div class="form-line">
                                                    <input type="text" class="form-control InfoEnabled"  name="Grade_lvl" value="<?php echo $this->data['get_info'][0]['Gradelevel']; ?>" disabled>
                                                </div>
                                        </div>
                                       
                                    </div>  


                                    <div class="row">
                                            <div class="col-md-4">
                         
                                                <div class="form-line">
                                                <p>
                                                <b class="red">Birth Day:</b>
                                            </p>
                                                <input id="date" type="date" class="form-control InfoEnabled" name="b-date"  value="<?php echo $this->data['get_info'][0]['Birth_Date']; ?>" disabled>

                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">Age:</b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text"  name="age" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Age']; ?> " disabled>
                                                    
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                           <p>
                                                <b class="red">Gender:</b>
                                            </p>
                                               <select   name="gender" class="form-control InfoEnabled"  >
                                               <option selected><?php echo $this->data['get_info'][0]['Gender']; ?></option>
                                               <option>MALE</option>
                                               <option>FEMALE</option>
                                               </select>
                                        </div>
                                    </div>  

                                     <div class="row">
                                            <div class="col-md-4">
                                            <p>
                                                <b class="red">Birth Place:</b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="b-place" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Birth_Place']; ?>" disabled>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                           <p>
                                                <b class="red">Religion:</b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="religion" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Religion']; ?>" disabled>
                                                </div>
                                        </div>
                                        
                                    </div>  

                                     <div class="row">
                                            <div class="col-md-4">
                                            <p>
                                                <b class="red">Citizenship:</b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="nationality" class="form-control InfoEnabled"  value="<?php echo $this->data['get_info'][0]['Nationality']; ?>" disabled>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                           <p>
                                                <b class="red">Alien Number: </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="number" name="alien_num" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Alien']; ?>" disabled>
                                                </div>
                                        </div>
                                       
                                    </div>  

                                     <div class="row">

                                            <p>
                                                <b>Contact`s Information</b>
                                            </p>

                                            <div class="col-md-4">
                                            <p>
                                                <b class="red">Mobile Number: </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="number" name="mobile_num" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mobile_No']; ?>" disabled>
                                                </div>
                                            </div>
                                        <div class="col-md-4">

                                            <p>
                                                <b class="red">Phone Number: </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="number" name="phone_num"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Phone_No']; ?>" disabled>
                                                </div>
                                        </div>
                                
                                    </div>  

                                    <div class="row">

                                            <p>
                                                <b >Address</b>
                                            </p>
                                            <div class="col-md-4">

                                             <p>
                                                <b class="red">House No: </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="house_no" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Address_No']; ?>" disabled>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">Street:</b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text"  name="street" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Address_Street']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">Subdivision:</b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="subdivision" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Subdivision']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                     <div class="row">
                                            <div class="col-md-4">
                                            <p>
                                                <b class="red">Barangay: </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text"  name="barangay"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Barangay']; ?>" disabled>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">City/Munucipality:  </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="city_muni"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['City']; ?>" disabled>
                    
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p>
                                                <b class="red">Zip:  </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="zip" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Zip_Code']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                            <div class="col-md-4">
                                            <p>
                                                <b class="red">Province:  </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="province" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Province']; ?>" disabled>
                                                </div>
                                            </div>
                                    </div>  
                                </div>
                                <div role="tabpanel"   class="tab-pane fade" id="profile_with_icon_title">
                                    <b>Family Information</b>

                                     <div class="row">
                                            <div class="col-md-4">
                                            <b class="red">Parent Status:</b>
                                                <select name="parent_status" >
                                                    <option selected><?php echo $this->data['get_info'][0]['Parent_Status']; ?></option>  
                                                </select>
                                            </div>
    
                                    </div>  

                                   <b>Father`s Information</b>
                                    <div class="row">
                                         <div class="col-md-6">
                                         <b class="red">Father`s Name:</b>
                                               <div class="form-line">
                                                     <input type="text" name="fathers_name"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Name']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-4">
                                                <div class="form-line">
                                                <p>
                                                <b class="red" >Status</b>
                                                </p>
                                                    <select  name="father_status" >  
                                                        <option selected><?php echo $this->data['get_info'][0]['Father_Status']; ?></option>  
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  

                                     <div class="row">
                                         <div class="col-md-6">
                                           <p>
                                                <b class="red">Birthdate: </b>
                                            </p>
                                               <div class="form-line">
                                                     <input type="date"  id="date" name="father_bday" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Birthdate']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-4">
                                            <p>
                                                <b class="red">Age: </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text"  name="father_Age" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Age']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                         <div class="col-md-6">
                                           <p>
                                                <b class="red">Employer: </b>
                                            </p>
                                               <div class="form-line">
                                                     <input type="text" name="father_employer"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Employer']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-6">
                                                <div class="form-line">
                                                <p>
                                                <b class="red">Average Income:</b>
                                                </p>
                                                    <select class="InfoEnabled" name="father_avg_income" disabled>  
                                                        <option selected><?php echo $this->data['get_info'][0]['Father_Income']; ?></option>  
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  

                                 <div class="row">
                                         <div class="col-md-6">
                                            <p>
                                                <b class="red">Position: </b>
                                            </p>
                                               <div class="form-line">
                                                     <input type="text" name="father_position" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Position']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-6">
                                                <div class="form-line">
                                                <p>
                                                <b class="red">Highest Level of Education:</b>
                                                </p>
                                                    <select required  class="InfoEnabled"  name="father_lvl_education" >  
                                                      <option selected><?php echo $this->data['get_info'][0]['Father_Education']; ?></option>  
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  


                                <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Address:</b>
                                                     <input type="text" name="father_address" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Address']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">City:</b>
                                                     <input type="text" name="father_city" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_City']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Province: </b>
                                                     <input type="text" name="father_province" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Municipality']; ?>" disabled>
                                                </div>
                                        </div>

                                         
                                    </div>  

                                     <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Country: </b>
                                                     <input type="text" name="father_country"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Country']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Zip: </b>
                                                   <input type="text" name="father_zip"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Zipcode']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Telephone:</b>
                                                     <input type="text" name="father_Telephone"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Phoneno']; ?>" disabled>
                                                </div>
                                        </div>

                                         
                                    </div>  


                                       <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Email: </b>
                                                     <input type="text" name="father_email" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Email']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Mobile No: </b>
                                                     <input type="text" name="father_mobile" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Mobileno']; ?>" disabled>
                                                </div>
                                        </div>
                                        
                                    </div>  



                         <b>Mother`s Information</b>
                                    <div class="row">
                                         <div class="col-md-6">
                                         <b class="red">Mother`s Name:</b>
                                               <div class="form-line">
                                               <input type="text" name="mother_name" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Name']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-4">
                                                <div class="form-line">
                                                <p>
                                                <b class="red">Status</b>
                                                </p>
                                                    <select  name="mother_status">  
                                                        <option selected><?php echo $this->data['get_info'][0]['Mother_Status']; ?></option>  
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  

                                     <div class="row">
                                         <div class="col-md-6">
                                           <p>
                                                <b class="red">Birthdate: </b>
                                            </p>
                                               <div class="form-line">
                                                  <input type="date" id="date" name="mother_bday" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Birthdate']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-4">
                                            <p>
                                                <b class="red">Age: </b>
                                            </p>
                                                <div class="form-line">
                                                     <input type="text" name="mother_age" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Age']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                         <div class="col-md-6">
                                           <p>
                                                <b class="red">Employer: </b>
                                            </p>
                                               <div class="form-line">
                                                  <input type="text" name="mother_employer" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Employer']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-6">
                                                <div class="form-line">
                                                <p>
                                                <b class="red">Average Income:</b>
                                                </p>
                                                    <select  name="mother_avg_income">  
                                                        <option selected><?php echo $this->data['get_info'][0]['Mother_Income']; ?></option>  
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  

                                 <div class="row">
                                         <div class="col-md-6">
                                            <p>
                                                <b class="red">Position: </b>
                                            </p>
                                               <div class="form-line">
                                                 <input type="text" name="mother_employer" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Position']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-6">
                                                <div class="form-line">
                                                <p>
                                                <b class="red">Highest Level of Education:</b>
                                                </p>
                                                    <select  name="mother_lvl_education">  
                                                    <option selected><?php echo $this->data['get_info'][0]['Mother_Education']; ?></option> 
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  


                                <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Address:</b>
                                               <input type="text" name="mother_adrress" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Address']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">City:</b>
                                                 <input type="text" name="mother_city" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_City']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Province: </b>
                                                  <input type="text" name="mother_province" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Municipality']; ?>" disabled>
                                                </div>
                                        </div>

                                         
                                    </div>  

                                     <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Country: </b>
                                                   <input type="text" name="mother_country" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Country']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Zip: </b>
                                               <input type="text" name="mother_zip" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Zipcode']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Telephone:</b>
                                               <input type="text" name="mother_telephone" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Phoneno']; ?>" disabled>
                                                </div>
                                        </div>

                                         
                                    </div>  


                                       <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Email: </b>
                                                    <input type="text" name="mother_email" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Email']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Mobile No: </b>
                                                    <input type="text" name="mother_mobile" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Mobileno']; ?>" disabled>
                                                </div>
                                        </div>
                                        
                                    </div>  


                                     <b>Guardian`s Information</b>
                                    <div class="row">
                                         <div class="col-md-6">
                                         <b class="red">Guardian`s Name:</b>
                                               <div class="form-line">
                                                   <input type="text" name="guardian_name" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Name']; ?>" disabled>
                                                </div>
                                        </div>

                                         <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Status</b>
                                                    <select name="guardian_status">  
                                                        <option selected><?php echo $this->data['get_info'][0]['Guardian_Status']; ?></option>  
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  

                                     <div class="row">
                                         <div class="col-md-6">
                                           <p>
                                                <b class="red">Birthdate: </b>
                                            </p>
                                               <div class="form-line">
                                                   <input type="text" name="guardian_bday" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Birthdate']; ?>" disabled> 
                                                </div>
                                        </div>

                                         <div class="col-md-4">
                                            <p>
                                                <b class="red">Age: </b>
                                            </p>
                                                <div class="form-line">
                                                   <input type="text" name="guardian_age" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Age']; ?>" disabled> 
                                                </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                         <div class="col-md-6">
                                           <p>
                                                <b class="red">Employer: </b>
                                            </p>
                                               <div class="form-line">
                                                    <input type="text" name="guardian_employer" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Employer']; ?>" disabled> 
                                                </div>
                                        </div>

                                         <div class="col-md-6">
                                                <div class="form-line">
                                                <b class="red">Average Income:</b>
                                                    <select name="guardian_avg_income">  
                                                        <option selected><?php echo $this->data['get_info'][0]['Guardian_Income']; ?></option>  
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  

                                 <div class="row">
                                         <div class="col-md-6">
                                            <p>
                                                <b class="red">Position: </b>
                                            </p>
                                               <div class="form-line">
                                                    <input type="text" name="guardian_position" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Position']; ?>" disabled> 
                                                </div>
                                        </div>

                                         <div class="col-md-6">
                                                <div class="form-line">
                                                <b class="red">Highest Level of Education:</b>
                                                    <select  name="guardian_lvl_education">  
                                                        <option selected><?php echo $this->data['get_info'][0]['Guardian_Education']; ?></option>  
                                                    </select>
                                                </div>
                                        </div>
                                    </div>  


                                <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Address:</b>
                                                   <input type="text" name="guardian_address" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Address']; ?>" disabled> 
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">City:</b>
                                               <input type="text" name="guardian_city" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_City']; ?>" disabled> 
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Province: </b>
                                               <input type="text" name="guardian_province" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Municipality']; ?>" disabled> 
                                                </div>
                                        </div>

                                         
                                    </div>  

                                     <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Country: </b>
                                                    <input type="text" name="guardian_country" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Country']; ?>" disabled> 
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Zip: </b>
                                               <input type="text" name="guardian_zip" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Zipcode']; ?>" disabled> 
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Telephone:</b>
                                                   <input type="text" name="guardian_telephone" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Phoneno']; ?>" disabled> 
                                                </div>
                                        </div>

                                         
                                    </div>  


                                       <div class="row">
                                         <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Email: </b>
                                               <input type="text" name="guardian_email" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Email']; ?>" disabled> 
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                               <div class="form-line">
                                               <b class="red">Mobile No: </b>
                                               <input type="text" name="guardian_mobile" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Mobileno']; ?>" disabled> 
                                                </div>
                                        </div>
                                        
                                    </div>  


                                     
                                   
                                  
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages_with_icon_title">
                                <b>Academic Background</b>
                                    <div class="row">
                                             <div class="col-md-3">
                                                <b class="red">Name of School:</b>
                                                        <div class="form-line">
                                                           <input type="text" name="name_of_school1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Name1']; ?>" disabled> 
                                                        </div>
                                                </div>
                                               
                                                <div class="col-md-3">
                                                   <b class="red">Level:</b>
                                                        <div class="form-line">
                                                        <input type="text" name="level1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Level1']; ?>" disabled> 
                                                            <input type="hidden"  value="">
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <b class="red">Years Attended:</b>
                                                        <div class="form-line">
                                                        <input type="text" name="year_attended1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Years1']; ?>" disabled> 
                                                            <input type="hidden"  value="">
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <b class="red">Awards/Recognition</b>
                                                        <div class="form-line">
                                                        <input type="text" name="awards1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Awards1']; ?>" disabled> 
                                                            <input type="hidden"  value="">
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="form-line">
                                                        <input type="text" name="name_of_school2" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Name2']; ?>" disabled> 
                                                        </div>
                                                </div>
                                               
                                                <div class="col-md-3">
                                                        <div class="form-line">
                                                            <input type="text" name="level2" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Level2']; ?>" disabled> 
                                                          
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="form-line">
                                                            <input type="text" name="year_attended2" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Years2']; ?>" disabled> 
                                                          
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="form-line">
                                                            <input type="text" name="awards2"class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Awards2']; ?>" disabled> 
                                                         
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="form-line">
                                                        <input type="text" name="name_of_school3" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Name3']; ?>" disabled> 
                                                        </div>
                                                </div>
                                               
                                                <div class="col-md-3">
                                                        <div class="form-line">
                                                            <input type="text" name="level3" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Level3']; ?>" disabled> 
                                                          
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="form-line">
                                                            <input type="text" name="year_attended3" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Years3']; ?>" disabled> 
                                                          
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="form-line">
                                                            <input type="text" name="awards3"class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Previous_School_Awards3']; ?>" disabled> 
                                                         
                                                        </div>
                                                </div>
                                     </div>

                                      <div class="row">
                                      <p>
                                      <b>Subject/s Liked Best</b>
                                      </p>
                                               <div class="col-md-6">
                                             
                                                 <div class="form-line">
                                                        <b class="red">1</b>
                                                        <input type="text" name="subject_best1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Best_Subject1']; ?>" disabled> 
                                                        </div>
                                                
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">2</b>
                                                        <input type="text" name="subject_best2" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Best_Subject2']; ?>" disabled> 
                                                        </div>
                                                
                                                </div>


                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">3</b>
                                                        <input type="text" name="subject_best3" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Best_Subject3']; ?>" disabled> 
                                                            
                                                        </div>
                                                
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">4</b>
                                                        <input type="text" name="subject_best4" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Best_Subject4']; ?>" disabled> 
                                                        </div>
                                                </div>
                                     </div>

                                    <div class="row">
                                      <p>
                                      <b>Subject/s Liked Least</b>
                                      </p>
                                               <div class="col-md-6">
                                             
                                                 <div class="form-line">
                                                        <b class="red">1</b>
                                                        <input type="text" name="least_best1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Least_Subject1']; ?>" disabled> 
                                                        </div>
                                                
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">2</b>
                                                        <input type="text" name="least_best2" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Least_Subject2']; ?>" disabled> 
                                                        </div>
                                                
                                                </div>


                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">3</b>
                                                        <input type="text" name="least_best3" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Least_Subject3']; ?>" disabled> 
                                                        </div>
                                                
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">4</b>
                                                        <input type="text" name="least_best4" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Least_Subject4']; ?>" disabled> 
                                                        </div>
                                                </div>
                                     </div>

                                     <div class="row">
                                     <p>
                                      <b>Extra-Curricular Activities</b>
                                      </p>
                                            <div class="col-md-4">
                                            <b class="red">Organization/Clubs:</b>
                                                    <div class="form-line">
                                                    <input type="text" name="name_of_org1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Organization_Name1']; ?>" disabled> 
                                                    </div>
                                            
                                            </div>
                                            
                                            <div class="col-md-4">
                                            <b class="red">Position:</b>
                                                    <div class="form-line">
                                                    <input type="text" name="postion1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Organization_Position1']; ?>" disabled> 
                                                    </div>
                                            
                                            </div>
                                            <div class="col-md-4">
                                            <b class="red">Year:</b>
                                                    <div class="form-line">
                                                    <input type="text" name="year1" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Organization_Year1']; ?>" disabled> 
                                                    </div>
                                            
                                            </div>

                                             <div class="col-md-4">
                                                    <div class="form-line">
                                                    <input type="text" name="name_of_org2" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Organization_Name2']; ?>" disabled> 
                                                    </div>
                                            
                                            </div>
                                            
                                            <div class="col-md-4">
                                                    <div class="form-line">
                                                    <input type="text" name="postion2" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Organization_Position2']; ?>" disabled> 
                                                    </div>
                                            
                                            </div>
                                            <div class="col-md-4">
                                                    <div class="form-line">
                                                    <input type="text" name="year2" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Organization_Year2']; ?>" disabled> 
                                                    </div>
                                            
                                            </div>
                                    </div>

                                </div>
                        
                                <div role="tabpanel" class="tab-pane fade" id="other_with_icon_title">
                                        <b>Other Information</b>
                                       <div class="row">
                                        <div class="col-md-6">
                                            <p>
                                                <b class="red">How did you know about SDCA?</b>
                                            </p>
                                            <select name="otk" >  
                                            <option  selected><?php echo $this->data['get_info'][0]['Others_Know_SDCA']; ?></option>    
                                            <?php foreach($this->data['get_knowabout'] as $row): ?>
                                               <option><?php echo $row->item;   ?></option>    
                                            <?php endforeach ?>
                                           </select>
                                            
                                        </div>

                                         <div class="col-md-6">
                                            <p>
                                                <b class="red">Do you have a relative or friend who`s in SDCA?</b>
                                            </p>
                                            <select  name="Relatives">  
                                                 <option  selected><?php echo $this->data['get_info'][0]['Others_Relative_Stats']; ?></option>    
                                                 <option>EMPLOYEE</option>    
                                                 <option>CURRENTLY ENROLLED</option>
                                                 <option>NONE</option>   
                                           </select>
                                            
                                        </div>
                                       
                                     

                               
                                         <div class="col-md-12">
                                            <p>
                                                <b class="red">if yes, to either, please fill in your relative`s name:</b>
                                            </p>

                                          </div>
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Name: </b>
                                                            <input type="text" name="Relative_name" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Others_Relative_Name']; ?>" disabled/>
                                                        </div>
                                                
                                                </div>

                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Course/Department:</b>
                                                            <input type="text" name="relative_department" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Others_Relative_Department']; ?>" disabled/>
                                                        </div>
                                                
                                                </div>
                                            

                                            
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Relationship:</b>
                                                            <input type="text"  name="relative_relationship" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Others_Relative_Relationship']; ?>" disabled/>
                                                        </div>
                                                
                                                </div>

                                                  <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Contact Number: </b>
                                                            <input type="text"  name="relative_contact" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Others_Relative_Contact']; ?>" disabled/>   
                                                        </div>
                                                
                                                </div>
                                         </div> 

                               
                               <?php  }  ?> 
                           
                        </div>
                     
                    </div>
                
                    </form>
                   
                </div>
            </div>
	<!--/CONTENT GRID-->

</section>


    




	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>

	
