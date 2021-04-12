


<section  id="top" class="content" >

	<!-- CONTENT GRID-->
	<div class="container-fluid">

 <div class="row clearfix">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                                     <h2>
                                        Search New Students <br>
                                    </h2>
                                   
                         </div>  
                         <br>   
                            <div class="row">
                            <form method="post" action="<?php echo base_url(); ?>index.php/Admission/NewStudentReport">
                            <input type="hidden" value="<?php echo base_url(); ?>"  id="guidance_url">
                               <div class="col-md-3">
                                       <select tabindex="1" required  class="form-control show-tick" data-live-search="true" name="sy"> 
                                           <option value="" selected>Select Admitted School Year</option>  
                                           <?php foreach($this->data['get_sy'] as $row) {?>
                                                <?php if($this->input->post('sy')==  $row['School_Year']): ?>
                                                    <option selected> <?php echo $row['School_Year']; ?></option>
                                                <?php else: ?>
                                                    <option><?php echo $row['School_Year']; ?></option>
                                                <?php endif ?>
                                            <?php }?>
                                        </select>
                                </div>
                                <div class="col-md-3">
                                      <select tabindex="2" required  class="form-control show-tick" data-live-search="true" name="sem"> 
                                          <option value="" selected>Select Admitted Semester</option>    
                                          <?php foreach($this->data['get_sem'] as $row) {?>
                                                <?php if($this->input->post('sem')==  $row['Semester']): ?>
                                                    <option selected> <?php echo $row['Semester']; ?></option>
                                                <?php else: ?>
                                                    <option><?php echo $row['Semester']; ?></option>
                                                <?php endif ?>
                                            <?php }?>        
                                      </select>
                                 </div> 
                                <div class="col-md-3">
                                   <button class="btn btn-danger" type="submit" name="search_button" > Search </button>
                                    <button class="btn btn-success" type="submit"  name="export" value="Export" > Excel </button>
                                </div> 
                             </div>             
                            <br> 
                          </form>    
                         </div>
                     </div>
             </div>


             <div class="card">
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
                                            <th>Transfered School</th>
                                            <th>Curiculum</th>
                                            <th>Birthday</th>
                                            <th>Nationality</th>
                                </thead>
                                <tbody>

                                <?php
                                     $count = 1;
                                     foreach($this->data['GetStudent'] as $row)   {?>


                                       <tr style="text-transform: uppercase;">
                                          <td><?php echo $count;  ?></td>
                                          <td><?php echo $row['Last_Name'];  ?>,&nbsp;&nbsp; <?php echo $row['First_Name']; ?> &nbsp;&nbsp;<?php echo $row['Middle_Name']; ?></td>
                                          <td><?php echo $row['Student_Number'];  ?></td>
                                          <td><?php echo $row['Course'];  ?></td>
                                          <td><?php echo $row['Gender'];  ?></td>
                                          <td><?php echo $row['Address_No']; ?> <?php echo $row['Address_Street']; ?>  <?php echo $row['Address_Barangay']; ?> <?php echo $row['Address_City']; ?></td>
                                         <td>
                                            <?php if($row['Transferee_Name'] == NULL || $row['Transferee_Name'] == 'N/A' || $row['Transferee_Name'] == '' || $row['Transferee_Name'] == '-' || $row['Transferee_Name'] == 'Na' || $row['Transferee_Name'] == 'NA'): ?>
                                                    <?php echo 'New'; ?>
                                                <?php else: ?>
                                                    <?php echo 'Transferee'; ?>
                                                <?php endIf; ?>
                                         </td>
                                          <td><?php echo $row['YearLevel'];  ?></td>
                                          <td><?php echo $row['CP_No'];  ?></td>
                                          <td><?php echo $row['Secondary_School_Name'];  ?></td>
                                          <td><?php echo $row['Transferee_Name'];  ?></td>
                                          <td><?php echo $row['Course']; ?>:<?php echo $row['AdmittedSY']; ?>:<?php echo $row['Program_Majors']; ?></td>
                                          <td><?php echo $row['Birth_Date'];  ?></td>
                                          <td><?php echo $row['Nationality'];  ?></td>
                                       </tr>
                                 

                                     <?php  $count = $count + 1; }?>
       
                                </tbody>
                            </table>
                        </div>
                      
                         
             </div>
                      
                  
 </div>     
        





	</div>
	<!--/CONTENT GRID-->

</section>






	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>

	
