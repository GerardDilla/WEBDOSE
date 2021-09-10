


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
                        <h2 class="red"> Higher Education Student Information</h2> 
                        </div>
                        
                        <form  action="<?php echo base_url(); ?>index.php/Admission/Student_Info"  method="POST">
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
                                        <i class="material-icons">perm_identity</i> Other Information
                                    </a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#messages_with_icon_title" data-toggle="tab" aria-expanded="false">
                                        <i class="material-icons">school</i> Educational Background
                                    </a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#settings_with_icon_title" data-toggle="tab" aria-expanded="true">
                                        <i class="material-icons">flash_on</i> Emergency Contacts
                                    </a>
                                </li>
                            </ul>
                 
                  
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="home_with_icon_title">
                                    <div class="row">
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                    <b class="red">Reference Number:</b>
                                                    <input type="text"   class="form-control" disabled value="<?php echo $this->data['get_info'][0]['Reference_Number']; ?>">
                                                    <input type="hidden"  name="ref_num" value="<?php echo $this->data['get_info'][0]['Reference_Number']; ?>">
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                    <b class="red">Student Number:</b>
                                                    <input type="text" class="form-control" disabled value="<?php echo $this->data['get_info'][0]['Student_Number']; ?>">
                                                    <input type="hidden" name="stu_num"   value="<?php echo $this->data['get_info'][0]['Student_Number']; ?>">
                                                </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-4">
                                                 <div class="form-line">
                                                   <b class="red">First Name:</b>
                                                    <input type="text" class="form-control InfoEnabled" id="first_name" name="first_name" value="<?php echo $this->data['get_info'][0]['First_Name']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                   <b class="red">Middle Name:</b>
                                                    <input type="text" class="form-control InfoEnabled"  name="middle_name" value="<?php echo $this->data['get_info'][0]['Middle_Name']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                    <b class="red">Last Name:</b>
                                                    <input type="text" class="form-control InfoEnabled" name="last_name"  value="<?php echo $this->data['get_info'][0]['Last_Name']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-line">
                                                  <b class="red">Address No:</b>
                                                     <input type="text" class="form-control InfoEnabled" name="address_no" value="<?php echo $this->data['get_info'][0]['Address_No']; ?>" disabled>

                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                    <b class="red">Address Street: </b>
                                                     <input type="text"  name="address_st" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Address_Street']; ?>" disabled>
                                                    
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                 <b class="red"> Subdivision: </b>
                                                     <input type="text" class="form-control InfoEnabled" name="subdivision" value="<?php echo $this->data['get_info'][0]['Address_Subdivision']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                     <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Barangay:  </b>
                                                     <input type="text" name="barangay" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Address_Barangay']; ?>" disabled>
                                                </div>
                                            </div> 
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Province: </b>
                                                     <input type="text" name="province" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Address_Province']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">City: </b>
                                                     <input type="text" name="city" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Address_City']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                     <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-line">
                                                <p>
                                                <b class="red">Birthdate: </b>
                                                 </p>
                                                <input id="date" type="date" class="form-control InfoEnabled" name="b-date"  value="<?php echo $this->data['get_info'][0]['Birth_Date']; ?>" disabled>
                                                 
                                                </div>

                                         
                                            </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Phone Number: </b>
                                                     <input type="number" name="phone_num" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Tel_No']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Nationality: </b>
                                                     <input type="text"  name="nationality" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Nationality']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                     <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-line">
                                                <b class="red">Mobile Number: </b>
                                                     <input type="number" name="mobile_num" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['CP_No']; ?>" disabled>
                                                </div>
                                            </div>
                                        <div class="col-md-3">
                                                <div class="form-line">
                                                <b class="red">Age:  </b>
                                                     <input type="text" name="Age"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Age']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-3">
                                                <div class="form-line">
                                                <b class="red">Birth Place: </b>
                                                     <input type="text" name="b_place" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Birth_Place']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-3">
                                                <div class="form-line">
                                                <b class="red">Zip Code: </b>
                                                     <input type="text"  name="zip_code" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Address_Zip']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Parent Status: </b>
                                                     <input type="text" name="parent_Status" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Parents_Status']; ?>" disabled>
                                                </div>
                                            </div>
                                  <div class="col-md-4">
                                           <p>
                                                    <b class="red">Gender: </b>
                                            </p>
                                                    <select class="InfoEnabled" name="gender">  
                                                        <option  selected><?php echo $this->data['get_info'][0]['Gender']; ?></option>    
                                                        <option>FEMALE</option>    
                                                        <option>MALE</option>   
                                                    </select>

                                     </div>
                                  
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Email Address:  </b>
                                                     <input type="text" name="email_add" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Email']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                     <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Father`s Name:</b>
                                                     <input type="text"  name="father_name" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Name']; ?>" disabled>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Father`s Occupation:</b>
                                                     <input type="text" name="father_occupation"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Occupation']; ?>" disabled>
                    
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Father`s Contact:  </b>
                                                     <input type="text" name="father_contact" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Contact']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-line">
                                                <b class="red">Father`s Address: </b>
                                                     <input type="text" name="father_add" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Address']; ?>" disabled>
                                                </div>
                                            </div>
                                    
                                    </div>  

                                    <div class="row">

                                      <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Father`s Email Address: </b>
                                                     <input type="text" name="father_email" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Email']; ?>" disabled>
                                                </div>
                                        </div>

                                            <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Father`s Income: </b>
                                                     <input type="text" name="father_inc" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Income']; ?>" disabled>
                                                </div>
                                            </div>

                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Father`s Education: </b>
                                                     <input type="text" name="father_ed" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Father_Education']; ?>" disabled>
                                                </div>
                                        </div>
                                       
                                    </div>  

                                      <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Mother`s Name:  </b>
                                                     <input type="text"  name="mother_name" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Name']; ?>" disabled>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Mother`s Occupation: </b>
                                                     <input type="text" name="mother_occupation" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Occupation']; ?>" disabled>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Mother`s Contact:  </b>
                                                     <input type="text" name="mother_contact" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Contact']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>  

                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-line">
                                                <b class="red"> Mother`s Address: </b>
                                                     <input type="text" name="mother_address" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Address']; ?>" disabled/>
                                                </div>
                                            </div>

                                    </div>  

                                    <div class="row">

                                    <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Mother`s Email Address: </b>
                                                     <input type="text" name="mother_email" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Email']; ?>" disabled/>
                                                </div>
                                        </div>
                                            <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Mother`s Income: </b>
                                                     <input type="text" name="mother_inc" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Income']; ?>" disabled/>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Mother`s Education: </b>
                                                     <input type="text" name="mother_ed" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Mother_Education']; ?>" disabled/>
                                                </div>
                                        </div>
                                       
                                    </div>  

                                </div>
                                <div role="tabpanel"   class="tab-pane fade" id="profile_with_icon_title">
                                    <b class="red">Preferred Course/s in SDCA</b>

                                     <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">First Choice: </b>
                                                     <input type="text" name="first_choice" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Course_1st']; ?>" disabled/>
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Second Choice:  </b>
                                                     <input type="text" name="second_choice" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Course_2nd']; ?>" disabled/>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form-line">
                                                <b class="red">Third Choice: </b>
                                                     <input type="text"  name="third_choice" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Course_3rd']; ?>" disabled/>
                                                </div>
                                        </div>
                                       
                                    </div>  


                                      <div class="col-md-6">
                                            <p>
                                                <b class="red">How did you know about SDCA?</b>
                                            </p>
                                            <select class="InfoEnabled" name="OTKSDCA" disabled>  
                                            <option  selected><?php echo $this->data['get_info'][0]['Others_Know_SDCA']; ?></option>    
                                            <?php foreach($this->data['get_knowabout'] as $row): ?>
                                               <option><?php echo $row->item;   ?></option>    
                                            <?php endforeach ?>
                                           </select>
                                           <?php if($this->data['get_info'][0]['Others_Know_SDCA'] == 'Come_All'){?>
                                           <p>
                                                <b class="red">Referral Name</b>
                                            </p>
                                            <input type="text" name="referral_name" id="referral_name" value="<?php echo $this->data['get_info'][0]['Referral_Name'] ?>" class="form-control InfoEnabled" disabled>
                                            <?php } ?>
                                        </div>

                                         <div class="col-md-6">
                                            <p>
                                                <b class="red">Do you have a relative or friend who`s in SDCA?</b>
                                            </p>
                                            <select class="InfoEnabled" name="Relative" disabled>  
                                                 <option  selected><?php echo $this->data['get_info'][0]['Others_Relative_Stats']; ?></option>    
                                                 <option>EMPLOYEE</option>    
                                                 <option>CURRENTLY ENROLLED</option>
                                                 <option>NONE</option>   
                                           </select>
                                            
                                        </div>
                                       
                                  

                                     <div class="row">
                                         <div class="col-md-12">
                                            <p>
                                                <b class="red">if yes, to either, please fill in your relative`s name:</b>
                                            </p>

                                            <div class="row">
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
                                            </div>

                                            <div class="row">
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
                                                
                                        
                                        </div>
                                
                                    </div>  
                                  
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages_with_icon_title">  

                                <div class="row">
                                <p>
                                  <b class="red">SENIOR HIGHSCHOOL</b>
                                </p>
                                 <div class="col-md-6"> 
                                        <div class="form-line">
                                           <b class="red">Name of School: </b>
                                          <input type="text" name="shs_name" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['SHS_School_Name']; ?>" disabled>
                                       </div> 
                                       <div class="form-line">
                                           <b class="red">Adrress:</b>
                                          <input type="text" name="shs_address" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['SHS_School_Address']; ?>" disabled>
                                       </div> 
                                 </div>

                                   <div class="col-md-6">
                                      <div class="form-line">
                                           <b class="red">Year Graduated: </b>
                                          <input type="text" name="shs_grad" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['SHS_School_Grad']; ?>" disabled>
                                       </div> 
                                   <div class="form-line">
                                       <p>
                                           <b class="red">Select Track:</b>
                                       </p>
                                       <select class="InfoEnabled" name="shs_track">
                                           <option> </option>
                                      </select>
                                    </div> 

                                 </div>



                                </div>
                                    
                                    <div class="row">
                                             <div class="col-md-6">
                                                <b class="red">Secondary/Highschool/</b>
                                                        <div class="form-line">
                                                        <b class="red">Name of School: </b>
                                                            <input type="text" name="secondary_school" class="form-contro InfoEnabled" value="<?php echo $this->data['get_info'][0]['Secondary_School_Name']; ?>">
                                                        </div>
                                                </div>
                                               
                                                <div class="col-md-6">
                                                   <b class="red">Elementary/Grade School</b>

                                                        <div class="form-line">
                                                        <b class="red">Name of School: </b>
                                                            <input type="text" name="elementary_school" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Grade_School_Name']; ?>">
                                                        </div>
                                                </div>
                                     </div>

                                      <div class="row">
                                               <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Address:</b>
                                                            <input type="text" name="secondary_address" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Secondary_School_Address']; ?>">
                                                        </div>
                                                
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Address:</b>
                                                            <input type="text" name="gradeschool_address" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Grade_School_Address']; ?>">
                                                        </div>
                                                
                                                </div>
                                     </div>


                                      <div class="row">
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Year Graduated: </b>
                                                            <input type="text" name="secondary_grad"  class="form-control InfoEnabled"  value="<?php echo $this->data['get_info'][0]['Secondary_School_Grad']; ?>">
                                                            <input type="hidden" value="">
                                                        </div>
                                                
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Year Graduated: </b>
                                                            <input type="text" name="elem_grad" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Grade_School_Grad']; ?>">
                                                        </div>
                                                
                                                </div>
                                     </div>
                                     <div class="row">
                                               <div class="col-md-12">   
                                                  <div class="text-center"> 
                                                     <b class="red">Transferee/2nd Course</b>
                                                  </div>
                                                </div>
                                        
                                     </div>
                                 
                                     <div class="row">
                                   
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Name of School:  </b>
                                                            <input type="text"  name="transfere_nameschool" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Transferee_Name']; ?>">
                                                        </div>
                                                
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Last year Attended:</b>
                                                            <input type="text" name="transfere_lastattend"  class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Transferee_Attend']; ?>">
                                                        </div>
                                                
                                                </div>
                                     </div>

                                     <div class="row">
                                   
                                            <div class="col-md-6">
                                                    <div class="form-line">
                                                    <b class="red">Address: </b>
                                                        <input type="text" name="transfere_schooladdress" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Transferee_Address']; ?>">
                                                    </div>
                                            
                                            </div>
                                            <div class="col-md-6">
                                                    <div class="form-line">
                                                    <b class="red">Course:</b>
                                                        <input type="text"  name="transfere_course" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Transferee_Course']; ?>">
                                                    </div>
                                            
                                            </div>
                                    </div>
                      
                                   
                                </div>
                                <div role="tabpanel"  class="tab-pane fade"  id="settings_with_icon_title">
                                <div class="row">
                                         <div class="col-md-12">
                                            <p>
                                                <b class="red">PERSON TO NOTIFY INCASE OF EMERGENCY:</b>
                                            </p>

                                            <div class="row">
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Guardian`s Name: </b>
                                                            <input type="text" name="guardian_name" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Name']; ?>">
                                                        </div>
                                                
                                                </div>

                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Guardian`s Contact: </b>
                                                            <input type="text" name="guardian_contact" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Contact']; ?>">
                                                        </div>
                                                
                                                </div>
                                            </div>

                                             <div class="row">
                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Guardian`s Address: </b>
                                                            <input type="text" name="guardian_address" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Address']; ?>">
                                                        </div>
                                                
                                                </div>

                                                <div class="col-md-6">
                                                        <div class="form-line">
                                                        <b class="red">Guardian`s Relationship:  </b>
                                                            <input type="text" name="guardian_relationship" class="form-control InfoEnabled" value="<?php echo $this->data['get_info'][0]['Guardian_Relationship']; ?>">
                                                        </div>
                                                
                                                </div>
                                            </div>
                                           
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                             <?php  }  ?>
                 
                </div>
            </div>
	<!--/CONTENT GRID-->

</section>







	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>

	
