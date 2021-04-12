 <section class="content">
    <div class="container-fluid">
          
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header bg-red">
                            <h2>
                           Enrolled Student
                            </h2>
                        </div>
             <div class="body">
                   
                <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                             <label class="text-red" for="HED">HIGHER EDUCATION </label>
                        </div>
                    </div>
                </div>

        <div class="row">
             <form method="post" action="<?php echo base_url(); ?>index.php/Registrar/EnrolledStudentREPORT">
                 <input type="hidden" value="<?php echo base_url(); ?>"  id="guidance_url">
               <div class="col-md-6">
                   
                </div>
                <div class="col-md-6">
                    <button class="btn btn-lg btn-success pull-right" type="submit" name="export" value="Export" ><i class="material-icons">print</i> Export</button>
                    <button type="submit" name="search_button" class="btn btn-lg btn-danger pull-right"><i class="material-icons">search</i> Search </button>
                </div>
                     <div class="col-md-6">
                           <div class="form-group">
                           
                      
                               <?php 
                                    //SELECT Nationality
                                    $class = array('class' => 'form-control show-tick',
                                                   'data-live-search'   => 'true',  
                                             );
                                    $options =  array('' => 'Select SchoolYear:');
                                    foreach($this->data['Get_YEAR']->result_array()  as $row) {

                                        $options[$row['School_Year']] = $row['School_Year'];
                                        }
                                    echo form_dropdown('School_year', $options, $this->input->post('School_year'),$class);
                                 ?>    

    
                       
                                <br>
                            
                                <?php 
                                    //Semester DROPDOWN
                                    $class = array('class' => 'form-control show-tick',);
                                    $options =  array(
                                    ''        => 'Select Semester',
                                    'FIRST'   => 'FIRST',
                                    'SECOND'  => 'SECOND',
                                    'SUMMER'  => 'SUMMER',
                                    );

                                     echo form_dropdown('Sem', $options, $this->input->post('Sem'),$class);

                                 ?>  
                                                            
                                     <br>

                                 <?php 
                                    //GENDER DROPDOWN
                                     $class = array('class' => 'form-control show-tick',);
                                     $options =  array(
                                     ''        => 'Select Gender',
                                    'FEMALE'  => 'FEMALE',
                                    'MALE'    => 'MALE',
                                     );

                                    echo form_dropdown('Gender', $options, $this->input->post('Gender'),$class);

                                  ?>  

                                          <br>
                                
                                <?php 
                                    //SELECT Nationality
                                    $class = array('class' => 'form-control show-tick',
                                                   'data-live-search'   => 'true',  
                                             );
                                    $options =  array('' => 'Select Nationality:');
                                    foreach($this->data['Get_Nationality']->result_array()  as $row) {

                                        $options[$row['Nationality']] = $row['Nationality'];
                                        }
                                    echo form_dropdown('National', $options, $this->input->post('National'),$class);
                                 ?>                
                                 
                            </div>
                     </div>

                      <div class="col-md-6">
                           <div class="form-group">

                             <?php 
                                    //SELECT Nationality
                                    $class = array('class'              => 'form-control show-tick',
                                                   'id'                 => 'Program',   
                                                   'data-live-search'   => 'true',  
                                                );
                                    $options =  array('' => 'Select Program:');
                                    foreach($this->data['Get_Course']->result_array()  as $row) {

                                        $options[$row['Program_Code']] = $row['Program_Code'];
                                        }
                                    echo form_dropdown('Program', $options, $this->input->post('Program'),$class);
                                 ?>                
                            
                                   
                                 <br>

                                 
                                 <?php 
                                      
									$class = array('class' => 'form-control show-tick',
										            'id'   => 'mjr',);
                                    $options =  array('' => 'Select Major');
                          
                                    echo form_dropdown('mjr', $options, $this->input->post('mjr'),$class);
								?>    
                                 <input type="hidden" value="<?php echo $this->input->post('mjr'); ?>"  id="major">
                                 <br>
                                 
                             <?php 
                                    //SELECT Nationality
                                    $class = array('class'              => 'form-control show-tick',
                                                   'data-live-search'   => 'true',  
                                                );
                                    $options =  array('' => 'Select Year Level');
                                    foreach($this->data['Get_YearLevel']->result_array()  as $row) {

                                        $options[$row['Year_Level']] = $row['Year_Level'];
                                        }
                                    echo form_dropdown('YL', $options, $this->input->post('YL'),$class);
                                 ?>                
                        

                            <br>
                                    
                              
                              
                    </form>                
                                             
                            </div>
                            </div>   
                    </div>
                        
                           
                 
                 <br><br><br>

                          <div class="table panel panel-danger" style="overflow-x:auto; overflow-y: auto; height: 500px;">
                                <table class="table table-bordered" style="width: 2500px;">
                            
                                    <thead>
                                        <tr class="danger">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Student Number</th>
                                            <th>Course</th>
                                            <th>Gender</th>
                                            <th>Address</th>
                                            <th>Applied Status</th>
                                            <th>Year</th>
                                            <th>Contact Number</th>
                                            <th>High School</th>
                                            <th>Last School Attended</th>
                                            <th>Curiculum</th>
                                            <th>Birthday</th>
                                            <th>Nationality</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                     $count = 1;
                                     foreach($this->data['GetStudent']->result() as $row) 

                                        
                                      {?>
                                       <tr style="text-transform: uppercase;">
                                          <td><?php echo $count;  ?></td>
                                          <td><?php echo $row->Last_Name;  ?>,&nbsp;&nbsp; <?php echo $row->First_Name; ?> &nbsp;&nbsp;<?php echo $row->Middle_Name; ?></td>
                                          <td><?php echo $row->Student_Number;  ?></td>
                                          <td><?php echo $row->Course;  ?></td>
                                          <td><?php echo $row->Gender;  ?></td>
                                          <td><?php echo $row->Address_No; ?> <?php echo $row->Address_Street; ?>  <?php echo $row->Address_Barangay; ?> <?php echo $row->Address_City; ?></td>
                                          <td>

                                               <?php if($row->Transferee_Name == NULL || $row->Transferee_Name == 'N/A' || $row->Transferee_Name == '' || $row->Transferee_Name == '-' || $row->Transferee_Name == 'Na' || $row->Transferee_Name == 'NA'): ?>
                                                    <?php echo 'New'; ?>
                                                <?php else: ?>
                                                    <?php echo 'Transferee'; ?>
                                                <?php endIf; ?>
                                          
                                          </td>
                                          <td><?php echo $row->YL;  ?></td>
                                          <td><?php echo $row->CP_No;  ?></td>
                                          <td><?php echo $row->Secondary_School_Name;  ?></td>
                                          <td>

                                                <?php if($row->Transferee_Name == NULL || $$row->Transferee_Name == 'N/A' || $row->Transferee_Name == '' || $row->Transferee_Name == '-' || $row->Transferee_Name == 'Na' || $row->Transferee_Name == 'NA'): ?>
                                                        <?php echo $row->Secondary_School_Name; ?>
                                                    <?php else: ?>
                                                        <?php echo $row->Transferee_Name; ?>
                                                <?php endIf; ?>
                        
                                          
                                          </td>
                                          <td><?php echo $row->Course; ?>:<?php echo $row->AdmittedSY; ?>:<?php echo $row->Program_Majors; ?></td>
                                          <td><?php echo $row->Birth_Date;  ?></td>
                                          <td><?php echo $row->Nationality;  ?></td>
                                       </tr>
                                 

                                     <?php  $count = $count + 1; }?>
                                    </tbody>
                                </table>

                             
                               </div>    

                            <div class="text-center" style="display: none;">  
                          <?php
	                       echo  $this->pagination->create_links();
	                       ?>
                        </div>       

                        </div><!-- card -->
                    </div><!-- col-lg-12 -->
                </div><!-- row clearfix -->


                </div><!-- container-fluid-->
             </div><!--content -->


             <script src="<?php echo base_url(); ?>js/guidanceEnrolledStudent.js"></script>



