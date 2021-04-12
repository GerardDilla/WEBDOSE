 <section class="content">
    <div class="container-fluid">
          
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header bg-red">
                            <h2>
                           Foreign Enrolled Student
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
        <form method="post" action="<?php echo base_url(); ?>index.php/Registrar/EnrolledStudentForeignExCell">
                 <input type="hidden" value="<?php echo base_url(); ?>"  id="guidance_url">
               <div class="col-md-6">
                   
                </div>
                <div class="col-md-6">
                    <button class="btn btn-lg btn-success pull-right" id="excell_button" type="submit" name="export" value="Export" ><i class="material-icons">print</i> Export</button>
                    <button type="button" name="search_button" id="search_button" class="btn btn-lg btn-danger pull-right"><i class="material-icons">search</i> Search </button>
                </div>
                     <div class="col-md-6">
                           <div class="form-group">
                           
                      
                               <?php 
                                    //SELECT Nationality
                                    $class = array('class' => 'form-control show-tick',
                                                   'id' => 'school_year',
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
                                    $class = array('class' => 'form-control show-tick',
                                                   'id' => 'semester',
                                                  );
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
                                     $class = array('class' => 'form-control show-tick',
                                                       'id' => 'gender',
                                          );
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
                                                   'id' => 'nationality', 
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
                                    //SELECT LEVEL
                                    $class = array('class'              => 'form-control show-tick',
                                                   'data-live-search'   => 'true',  
                                                   'id' => 'year_level', 
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
                                    <tbody class="showforieng">

                                    </tbody>
                                </table>

                             
                               </div>    

                            <div class="text-center" style="display: none;">  
                         
                        </div>       

                        </div><!-- card -->
                    </div><!-- col-lg-12 -->
                </div><!-- row clearfix -->


                </div><!-- container-fluid-->
             </div><!--content -->


             <script src="<?php echo base_url(); ?>js/guidanceEnrolledStudent.js"></script>



<script>

$(document).ready(function(){

    $('#search_button').click(function(){
            GetData();
     });

    $('#excell_button').click(function(){
            GetDataExcell();
    });
});
  

function GetData()
   {
     
      
       school_year    = $("#school_year").val();
       semester       = $("#semester").val();
       gender         = $("#gender").val();
       nationality    = $("#nationality").val();
       program        = $("#Program").val();
       major          = $("#mjr").val();
       yearlevel      = $("#year_level").val();
       url            = $("#guidance_url").val();
    


      $.ajax({
            method: "POST",
            url: url+"index.php/Registrar/Get_Foreign_ajax",
			data: { 
                    school_year: school_year,
					semester:semester,
					gender:gender,
                    nationality:nationality,
                    program:program,
                    major:major,
                    yearlevel:yearlevel
			},
            success: function(data){				
					result = JSON.parse(data);
                    Display_foreign_result(result)		     
			}
        

        });
   }




function Display_foreign_result(result)
{

	showarea = $('.showforieng');
	showarea.html('');
	$.each(result, function(index, Foreign) 
    {  
			
			table = '';
			table += '<tr style="text-transform: uppercase;">';
			table += '<td>'+(index + 1)+'</td>';	
            table += '<td>'+Foreign['Last_Name']+', '+Foreign['First_Name']+'</td>';	
            table += '<td>'+Foreign['Student_Number']+'</td>';	
            table += '<td>'+Foreign['Course']+'</td>';	
            table += '<td>'+Foreign['Gender']+'</td>';	
            table += '<td>'+Foreign['Address_No']+' '+Foreign['Address_Street']+' '+Foreign['Address_Barangay']+' '+Foreign['Address_City']+'</td>';
          
            if(Foreign['Transferee_Name'] == 'NULL' || Foreign['Transferee_Name'] == 'N/A' || Foreign['Transferee_Name'] == '' || Foreign['Transferee_Name'] == '-' || Foreign['Transferee_Name'] == 'Na' || Foreign['Transferee_Name'] == 'NA')
            {
                table += '<td>NEW</td>';	
            }
            else
            {
                table += '<td>TRANSFEREE</td>';	
            }
            
            table += '<td>'+Foreign['YL']+'</td>';	
            table += '<td>'+Foreign['CP_No']+'</td>';	
            table += '<td>'+Foreign['Secondary_School_Name']+'</td>';	

            if(Foreign['Transferee_Name'] == 'NULL' || Foreign['Transferee_Name'] == 'N/A' || Foreign['Transferee_Name'] == '' || Foreign['Transferee_Name'] == '-' || Foreign['Transferee_Name'] == 'Na' || Foreign['Transferee_Name'] == 'NA')
            {
                table += '<td>'+Foreign['Secondary_School_Name']+'</td>';	   
            }
            else
            {
                table += '<td>'+Foreign['Transferee_Name']+'</td>';	  
            }

            table += '<td>'+Foreign['Course']+''+Foreign['AdmittedSY']+''+Foreign['Program_Majors']+'</td>';	   
            table += '<td>'+Foreign['Birth_Date']+'</td>';	 
            table += '<td>'+Foreign['Nationality']+'</td>';	 
			table += '</tr>';
					 
			showarea.append(table);

	});

		   
   }

 

</script>