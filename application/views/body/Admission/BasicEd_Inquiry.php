


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
                                        Basic Education Enrollment Summary <br>
                                       
                                     
                                    </h2>
                                </div>
                          
                                <div class="col-md-6">
                                        <div class="row">
                                        <form action="<?php echo base_url(); ?>index.php/Admission/Button_BED" method="post">
                                            <div class="col-md-6">
                                              

                                              	<select tabindex="2" required  class="form-control show-tick" data-live-search="true" name="sy">
                                                        <?php foreach($this->data['get_sy']->result_array() as $row)  {?>
                                                        <?php if($this->input->post('sy')==  $row['SchoolYear']): ?>
                                                            <option selected><?php echo $row['SchoolYear']; ?></option>
                                                        <?php else: ?>
                                                            <option><?php echo $row['SchoolYear']; ?></option>
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
             <div class="col-md-6 ">        
                        <div class="body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                   <tr>
                                        <th  class="text-center" colspan="5">NEW STUDENTS</th>
                                    </tr>
                                    <tr>
                                        <th>LEVEL</th>
                                        <th>INQUIRY</th>
                                        <th>TAKERS</th>
                                        <th>RESERVED</th>
                                        <th>ENROLLED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php 
                                         
                                                foreach($this->data['list'] as $row)  {
                                        ?>
                                        <tr class="text-center"> 
                                          
                                            <td><?php echo $row['Grade_Level']; ?> </td>
                                            <td><?php echo $row['Inquiry']; ?> </td>
                                            <td><?php echo $row['Taker']; ?> </td>
                                            <td><?php echo $row['NewReserve']; ?> </td>
                                            <td><?php echo $row['NEWEnrolled']; ?> </td>


                                        </tr>


                                        <?php }?>
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
                                            $count = 1;
                                                foreach($this->data['list'] as $row)  {
                                        ?>
                                        <tr class="text-center"> 
                                          
                                
                                            <td><?php echo $row['OldReserve']; ?> </td>
                                            <td><?php echo $row['OLDEnrolled']; ?> </td>


                                        </tr>


                                        <?php  $count = $count + 1;}?>
                                  
                                                                 
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

                                   $Total =     $Total +  $row['OLDEnrolled'] + $row['NEWEnrolled']; 
                                 ?>
                              
                                 <tr class="text-center"> 
                                     <td><?php echo $row['OLDReserve'] + $row['NewReserve']; ?></td>
                                     <td><?php echo $row['OLDEnrolled'] + $row['NEWEnrolled']; ?></td>
                                 </tr>

                                   <?php 
                                         
                                         }
             
                                     ?>

                                 <tr class="text-center"> 
                                     <td></td>
                                     <td></td>
                                 </tr>

  
                                </tbody>
                            </table>

                           
                        </div>

             
                            <label>TOTAL SUM OF NEW AND OLD STUDENTS</label>
                            <p class="text-center" style="font-weight: 900;"><?php echo  $Total;  ?> </p>
           

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

	
