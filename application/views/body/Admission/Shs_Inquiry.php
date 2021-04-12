


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">system_update_alt</i></h1>
		</div>
		<!--/ MODULE TITLE-->

   

 <div class="row clearfix">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row">
                               <div class="col-md-6">
                                    <h2>
                                    Senior High School Enrollment Summary <br>
                                    </h2>
                                </div>
                          
                                <div class="col-md-6">
                                        <div class="row">
                                        <form action="<?php echo base_url(); ?>index.php/Admission/Button_Shs" method="post">
                                            <div class="col-md-6">
                                              

                                              	<select tabindex="1" required  class="form-control show-tick" data-live-search="true" name="sy">
                                                        <?php foreach($this->data['get_sy']->result_array() as $row)  {?>
                                                        <?php if($this->input->post('sy')==  $row['SchoolYear']): ?>
                                                            <option selected><?php echo $row['SchoolYear']; ?></option>
                                                        <?php else: ?>
                                                            <option><?php echo $row['SchoolYear']; ?></option>
                                                        <?php endif ?>
                                                        <?php }?>
                                                </select>

                                                	<select tabindex="2" required  class="form-control show-tick" data-live-search="true" name="gradlvl">
                                                        <?php foreach($this->data['get_lvl']->result_array() as $row)  {?>
                                                            <?php if($this->input->post('gradlvl')==  $row['Grade_LevelCode']): ?>
                                                                <option  value="<?php echo $row['Grade_LevelCode']; ?>" selected><?php echo $row['Grade_Level']; ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo $row['Grade_LevelCode']; ?>"><?php echo $row['Grade_Level']; ?></option>
                                                            <?php endif ?>
                                                        <?php }?>
                                                </select>
                                             
                                            </div> 
                                            <div class="col-md-6">
                                                <button class="btn btn-danger" type="submit" name="search_button" value="search_button"> Search </button>
                                                <button class="btn btn-success" type="submit" name="export" value="Export" > Excel </button>
                                            </div> 
                                            </form>
                                        </div> 
                           
                                </div>
                            </div>
                        </div>
         
        <div class="row">
             <div class="col-md-6">        
                        <div class="body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                  
                                   <tr>
                                        <th  class="text-center" colspan="5">NEW STUDENTS</th>
                                    </tr>
                                    <tr>
                                        <th>Track</th>
                                        <th>INQUIRY</th>
                                        <th>TAKERS</th>
                                        <th>RESERVED</th>
                                        <th>ENROLLED</th>
                                    </tr>
                                </thead>
                                <tbody>

                              <?php 
                                        
                                    foreach($this->data['list'] as $row)  {

                                ///TOTAL OF NEW ENROLLED     
                                 $TotalNewEnrolled   =   $row['NEWEnrolled'];
                                 $SumOfNewEnrolled = $SumOfNewEnrolled + $TotalNewEnrolled;


                                 ?>
                                 <tr class="text-center"> 
                                   
                                     <td><?php echo $row['Strand_Code']; ?> </td>
                                     <td><?php echo $row['Inquiry']; ?></td>
                                     <td><?php echo $row['Taker']; ?> </td>
                                     <td><?php echo $row['NewReserve']; ?> </td>
                                     <td><?php echo $row['NEWEnrolled']; ?> </td>
                              
                            
                                 </tr>


                                 <?php }?>

                                     <tr class="text-center"> 
                                   
                                   <td>TOTAL </td>
                                   <td></td>
                                   <td> </td>
                                   <td> </td>
                                   <td><?php echo $SumOfNewEnrolled; ?></td>
                                     </tr>
                                       
                                </tbody>
                            </table>
                        </div>
                     </div>




                      <div class="col-md-3">        
                        <div class="body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                               
                                   <tr>
                                        <th  class="text-center" colspan="5">CONTINUING STUDENTS</th>
                                    </tr>
                                    <tr>
                                        <th>RESERVED</th>
                                        <th>ENROLLED</th>
                                    </tr>
                                </thead>
                                <tbody>

                                 <?php 
                                         
                                         foreach($this->data['list'] as $row)  {

                                 $TotalOldEnrolled   =   $row['OLDEnrolled'];
                                 $SumOfOLDEnrolled = $SumOfOLDEnrolled + $TotalOldEnrolled;

                                 ?>
                                 <tr class="text-center"> 
                                   
                  
                                     <td><?php echo $row['OLDReserve']; ?> </td>
                                     <td><?php echo $row['OLDEnrolled']; ?> </td>
                              
                            
                                 </tr>


                                 <?php }?>

                                   <tr class="text-center"> 

                                        <td> </td>
                                        <td><?php echo   $SumOfOLDEnrolled;  ?> </td>

                                   </tr>
                       
                                </tbody>
                            </table>

                           
                        </div>

             

                     </div>


                          <div class="col-md-3">        
                        <div class="body table-responsive">
                            <table class="table table-bordered">
                                <thead>   
                                     <tr  clas="text-center">
                                        <th colspan="2">TOTAL</th>
                                    </tr> 
                                    <tr>
                                        <th>RESERVED</th>
                                        <th>ENROLLED</th>
                                    </tr>
                                </thead>
                                <tbody>

                               <?php    
                                         foreach($this->data['list'] as $row)  {
                                             
                                 ?>
                              
                                 <tr class="text-center"> 
                                     <td><?php echo $row['OLDReserve'] + $row['NewReserve']; ?></td>
                                     <td><?php echo $row['OLDEnrolled'] + $row['NEWEnrolled']; ?></td>
                                 </tr>

                                   <?php 
                                         
                                         }
             
                                     ?>

                                 <tr class="text-center"> 
                                     <td><?php echo $row['OLDReserve'] + $row['NewReserve']; ?></td>
                                     <td><?php echo $row['OLDEnrolled'] + $row['NEWEnrolled']; ?></td>
                                 </tr>

  
                                </tbody>
                            </table>

                           
                        </div>

             
                            <label>TOTAL SUM OF NEW AND OLD STUDENTS</label>
                            <p class="text-center"><?php echo   $SumOfOLDEnrolled+ $SumOfNewEnrolled;  ?> </p>
           

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

	
