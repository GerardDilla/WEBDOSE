


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">system_update_alt</i>Reports</h1>
		</div>
		<!--/ MODULE TITLE-->

  

   <div class="card">
            <div class="body">
                <form id="sign_up" action="<?php echo base_url(); ?>index.php/Ccao/Check_Inquiry_Button"  method="POST">
                   <div class="row">
                       <div class="col-md-6">


                            <?php 

                               $array = array(
                               
                                'HED'   =>   'Higher Education',
                                'SHS'   =>   'Senior High School',
                                'BED'   =>   'Basic Education',
                              );

                            ?>
                            <?php echo form_dropdown('school', $array,'','id = dropChoose'); ?>

                     </div>
                       <div class="col-md-6">
                            <select   class="form-control show-tick" data-live-search="true"  id="SCourse" class="danger" name="School_year" required>
                                       <option disabled  selected>Select Course</option>
                                       <option></option>
                            </select>
                       </div>
                       <div class="text-center">
                           <button type="submit" name="submit" class="btn btn-danger">Search</button>
                           <button  name="export" class="btn btn-success">Export</button>
                       </div>
                   </div>
                </form>
                <br><br>
                  <div class="row">
                       <div class="col-md-12">
                       <div class="table panel panel-danger" style="overflow-x:auto; overflow-y: auto; height: 500px;">
                          <table class="table table-bordered"  style="width: 3000px;">
                            <thead>
                                <tr class="danger">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Fb Account</th>
                                    <th>School</th>
                                    <th>Guardian Name</th>
                                    <th>Occupation</th>
                                    <th>Contact Number</th>
                                    <th>Present Address</th>
                                    <th>1st Choice</th>
                                    <th>2nd Choice</th>
                                    <th>3rd Choice</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>

                              <?php
                                     $count = 1;
                                     foreach($this->data['get_inquiry']->result() as $row) 
                                      {
                                          


                                        if($row->g_name ===  NULL){
                                            $Guardian_Name = 'N/A';
                                           }else{
                                            $Guardian_Name = $row->g_name;
                                           }  

                                           if($row->g_occupation ===  NULL){
                                            $Occupation = 'N/A';
                                           }else{
                                            $Occupation = $row->g_occupation;
                                           }  

                                           if($row->g_number ===  NULL){
                                            $Guardian_Number = 'N/A';
                                           }else{
                                            $Guardian_Number = $row->g_number;
                                           }  

                                           if($row->address ===  NULL){
                                            $Address = 'N/A';
                                           }else{
                                            $Address = $row->address;
                                           }  
                                           
                                
                                        ?>

                                     
                                       <tr>
                                          <td><?php echo $count;  ?></td>
                                          <td><?php echo $row->name; ?></td>
                                          <td><?php echo $row->s_contact; ?></td>
                                          <td><?php echo $row->fb_user; ?></td>
                                          <td><?php echo $row->last_school; ?></td>
                                          <td><?php echo $Guardian_Name; ?></td>
                                          <td><?php echo $Occupation; ?></td>
                                          <td><?php echo $Guardian_Number; ?></td>
                                          <td><?php echo $Address; ?></td>
                                          <td><?php echo $row->first_choice; ?></td>
                                          <td><?php echo $row->second_choice; ?></td>
                                          <td><?php echo $row->third_choice; ?></td>
                                          <td><?php echo $row->date; ?></td>
                                       
                                    
                                       </tr>
                                 

                                     <?php  $count = $count + 1; }?>
                          
                            </tbody>
                          </table>
                         </div>   
                       </div>
                   </div>
            </div>
        </div>















			
	</div>
	<!--/CONTENT GRID-->

</section>




	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>

	


