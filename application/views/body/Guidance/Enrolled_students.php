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
             <form method="post" action="<?php echo base_url(); ?>index.php/Guidance/EnrolledStudentREPORT">
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
					//SchoolYear Select
						$datestring = "%Y";
						$time = time();
						$year_now = mdate($datestring, $time);
						$options = array(
							
							'0'=> 'Select School Year',
							($year_now - 1)."-".$year_now => ($year_now - 1)."-".$year_now,
							$year_now."-".($year_now + 1) => $year_now."-".($year_now + 1),
							($year_now + 1)."-".($year_now + 2) => ($year_now + 1)."-".($year_now + 2)
							
						);
						$js = array(
							'id' => 'ES',
							'class' => 'form-control show-tick',
							'data-live-search' => 'true',
							'required' => 'required',
						);
						echo form_dropdown('School_year', $options, $this->data['Legend'][0]['School_Year'], $js);
					?>
                           

                     <br>
                            
                        <?php 
                                //SELECT SEMESTER
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
                                ''       => 'Select Gender',
                                'FEMALE' => 'FEMALE',
                                'MALE'   => 'MALE',
                                );
                                echo form_dropdown('Gender', $options, $this->input->post('Gender'),$class);
                        ?>                   
                            <br>
                                     
                        <?php 
                                //SELECT Nationality
                                $class = array('class'           => 'form-control show-tick',
                                                 'id'                 => 'provinces',   
                                                'data-live-search'   => 'true',  
                                                 );
                                $options =  array('' => 'Select Province:');
                                foreach($this->data['Getprovince']->result_array()  as $row) {
                                $options[$row['provDesc']] = $row['provDesc'];
                                 }
                                echo form_dropdown('province', $options, $this->input->post('province'),$class);
                        ?>            
                            <br>

                        <?php 
                                $class = array('class' => 'form-control show-tick',
                                             'id'   => 'municipalitys',
                                             'data-live-search'   => 'true',  
                                            );
                                $options =  array('' => 'Select Municipality');
                                echo form_dropdown('municipality', $options, $this->input->post('municipality'),$class);
                        ?>    
                                   <input type="hidden" value="<?php echo $this->input->post('municipality'); ?>"  id="municip">
                            <br>

                            <?php 
                                $class = array('class' => 'form-control show-tick',
                                             'id'   => 'barangays',
                                             'data-live-search'   => 'true',  
                                            );
                                $options =  array('' => 'Select Barangay');
                                echo form_dropdown('barangay', $options, $this->input->post('barangay'),$class);
                        ?>    
                                   <input type="hidden" value="<?php echo $this->input->post('barangay'); ?>"  id="barang">
                            <br>
                                   
                                
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
                                    $options =  array('0' => 'Select Major');
                          
                                    echo form_dropdown('mjr', $options, $this->input->post('mjr'),$class);
								?>    
                                 <input type="hidden" value="<?php echo $this->input->post('mjr'); ?>"  id="major">
                                 <br>
                              
                                 <?php 
                                    //SELECT YEAR LEVEl
                                    $class = array('class' => 'form-control show-tick',
                                                    'data-live-search'   => 'true',);
                                    $options =  array('' => 'Select Year Level:');
                                    foreach($this->data['Get_YearLevel']->result_array()  as $row) {

                                    $options[$row['Year_Level']] = $row['Year_Level'];
                                    }
                                    echo form_dropdown('YearLevel', $options, $this->input->post('YearLevel'),$class);
                                ?>    


                            <br>

                            <?php 
                                    //SELECT SCHOOL YEAR
                                    $class = array('class' => 'form-control show-tick',
                                                    'data-live-search'   => 'true',);
                                    $options =  array('' => 'Select Nationality:');
                                    foreach($this->data['Get_Nationality']->result_array()  as $row) {

                                    $options[$row['Nationality']] = $row['Nationality'];
                                    }
                                    echo form_dropdown('National', $options, $this->input->post('National'),$class);
                            ?>    
                              
                    </form>                
                                             
                            </div>
                            </div>   
                    </div>
                        
                           
                 
                 <br><br><br>

                        <div class="table panel panel-danger" style="overflow-x:auto; overflow-y: auto; height: 500px;">
                                <table class="table table-bordered" style="width: 3500px;">
                            
                                    <thead>
                                        <tr class="danger">
                                            <th>SEQ</th>
                                            <th>NAME</th>
                                            <th>STUDENT NUMBER</th>
                                            <th>SEX</th>
                                            <th>BIRTHDATE</th>
                                            <th>COMPLETE PROGRAM NAME</th>
                                            <th>YEAR LEVEL</th>
                                            <th>FATHER`S NAME</th>
                                            <th>MOTHER`S MAIDEN NAME</th>
                                            <th>DSWD HOUSEHOLD NO.</th>
                                            <th>HOUSEHOLD PER CAPITA INCOME</th>
                                            <th>STREET & BARANGAY</th>
                                            <th>TOWN/CITY/MUN</th>
                                            <th>PROVINCE</th>
                                            <th>ZIPCODE</th>
                                            <th>TOTAL ASSESSMENT</th>
                                            <th>DISABILITY</th>

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
                                          <td><?php echo $row->Gender;  ?></td>
                                          <td><?php echo $row->Birth_Date;  ?></td>
                                          <td><?php echo $row->courseTitle;  ?></td>
                                          <td><?php echo $row->YL;  ?></td>
                                          <td><?php echo $row->Father_Name;  ?></td>
                                          <td><?php echo $row->Mother_Name;  ?></td>
                                          <td>N/A</td>
                                          <td>N/A</td>
                                          <td><?php echo $row->Address_Street; ?>  <?php echo $row->Address_Barangay; ?> </td>
                                          <td><?php echo $row->Address_City; ?></td>
                                          <td><?php echo $row->Address_Province; ?></td>
                                          <td><?php echo $row->Address_Zip; ?></td>
                                          <td>N/A</td>
                                          <td>N/A</td>
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
