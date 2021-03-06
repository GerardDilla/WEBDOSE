


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
                               <div class="col-md-4">
                                    <h2>
                                    Higher Education Inquiry Reports <br>
                                    </h2>
                                </div>
                          
                                <div class="col-md-8">
                                        <div class="row">
                                        <h5>Choose Filter:</h5>
                                        <form action="<?php echo base_url(); ?>index.php/Admission/Inquiry_HED" method="post">
                                            <div class="col-md-4" style="border-right:solid #ccc">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <label>From: </label>
                                                        </td>
                                                        <td>
                                                            <input type="date" name="inquiry_from" data-date-format="yyyy-mm-dd">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                           <hr>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        <label>To: </label>
                                                        </td>
                                                        <td>
                                                            <input type="date" name="inquiry_to" data-date-format="yyyy-mm-dd"> 
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-4" style="border-right:solid #ccc">
                                              
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
                                                        echo form_dropdown('sy', $options, $this->input->post('sy'), $js);
                                                    ?>

                                          
                                                <?php 
                                                    //Semester DROPDOWN
                                                    $class = array('class' => 'form-control show-tick',);
                                                    $options =  array(
                                                    '0'        => 'Select Semester',
                                                    'FIRST'   => 'FIRST',
                                                    'SECOND'  => 'SECOND',
                                                    'SUMMER'  => 'SUMMER',
                                                    );

                                                    echo form_dropdown('sem', $options, $this->input->post('sem'),$class);

                                                ?>  
                                                        
                                                

                                            	<select tabindex="2" class="form-control show-tick" data-live-search="true" name="course">
                                                          <option  disabled selected>Select Course:</option>
                                                        <?php foreach($this->data['get_course']->result_array() as $row)  {?>
                                                        <?php if($this->input->post('course')==  $row['Program_Code']): ?>
                                                            <option  selected><?php echo $row['Program_Code']; ?></option>
                                                        <?php else: ?>
                                                            <option><?php echo $row['Program_Code']; ?></option>
                                                        <?php endif ?>
                                                        <?php }?>
                                                </select>
                   
                                                     
                                             
                                            </div> 
                                            <div class="col-md-4">
                                                <button type="submit" name="search_button" class="btn btn-lg btn-danger"> Search </button>
                                                <br><br>
                                                <button class="btn btn-lg  btn-success" type="submit" name="export" value="Export" > Excel </button>
                                            </div> 
                                            </form>
                                        </div> 
                           
                                </div>
                            </div>
                        </div>
         
        <div class="row">
             <div class="col-md-12">        
                        <div class="body table-responsive" style="overflow:auto; max-height:400px">
                            <table class="table table-bordered" style="width: 1600px;">
                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>Reference_Number</th>
                                        <th>Name</th>
                                        <th>Program</th>
                                        <th>Search Engine</th>
                                        <th>Contact #</th>
                                        <th>School Last Attended</th>
                                        <th>Residence</th>
                                        <th>Status </th>
                                        <th>Remarks </th>
                                        <th>Applied School Year</th>
                                        <th>Applied Semester</th>
                                        <th>DSWD Number</th>
                                        <th>Date Inquired</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $count = 1; ?>
                                <?php 
                                         
                                         foreach($this->data['get_inquiry'] as $row)  {

                                            if($row->Others_Know_SDCA == NULL){
                                                $OKS = 'N/A';
                                            }else{
                                                $OKS = $row->Others_Know_SDCA;
                                            }
                                 ?>
                                 <tr style="text-transform: uppercase;"> 
                                   
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row->ref_no; ?></td>
                                    <td><?php echo $row->Last_Name; ?>, <?php echo $row->First_Name; ?> <?php echo $row->Middle_Name; ?></td>
                                    <td>
                                        <?php if($row->EXM_RF == NULL): ?>
                                            <?php echo $row->Course_1st; ?>
                                        <?php else: ?>
                                            <?php echo $row->Course; ?>
                                        <?php endIf; ?>
                                    </td>
                                    <td><?php echo $OKS; ?></td>
                                    <td><?php echo $row->CP_No; ?></td>

                                    <?php if($row->Transferee_Name == NULL || $row->Transferee_Name == 'N/A' || $row->Transferee_Name == '' || $row->Transferee_Name == '-'): ?>
                                        <?php if($row->SHS_School_Name == NULL || $row->SHS_School_Name == 'N/A' || $row->SHS_School_Name == '' || $row->SHS_School_Name == '-'): ?>
                                            <td><?php echo $row->Secondary_School_Name; ?></td>
                                        <?php else: ?>
                                            <td><?php echo $row->SHS_School_Name; ?></td>
                                        <?php endIf; ?>
                                    <?php else: ?>
                                         <td><?php echo $row->Transferee_Name; ?></td>
                                    <?php endIf; ?>
                              
                                    <td><?php echo $row->Address_City; ?>,   <?php echo $row->Address_Province; ?></td>
                                    <td>
                                        <?php if($row->Transferee_Name == NULL || $row->Transferee_Name == 'N/A' || $row->Transferee_Name == '' || $row->Transferee_Name == '-'): ?>
                                            <?php echo 'New'; ?>
                                        <?php else: ?>
                                            <?php echo 'Transferee'; ?>
                                        <?php endIf; ?>
                                    </td>
                                    <td>
                                        <?php if($row->EXM_RF == NULL): ?>
                                            <?php echo 'Follow Up'; ?>
                                        <?php else: ?>
                                            <?php echo 'With Exam'; ?>
                                        <?php endIf; ?>
                                    </td>
                                    <td><?php echo $row->Applied_SchoolYear; ?></td>
                                    <td><?php echo $row->Applied_Semester; ?></td>
                                    <td><?php echo $row->dswd_no ? $row->dswd_no : 'N/A'; ?></td>
                                    <td><?php echo $row->DateInquired; ?></td>

                                    <!-- Download as pdf button -->
                                    <td>
                                          <button class="btn btn-sm btn-info inquiry_export"  data-referenceno="<?php echo $row->ref_no; ?>" >Download Inquiry Info</button>  
                                    </td>
                                    <!--<td><?php echo $row->Rmk; ?></td>-->
                                   
                                 </tr>

                                 <?php $count++; ?>
                                 <?php }?>

                               
                                       
                                </tbody>
                            </table>
                        </div>
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

<script>


$(document).ready(function(){

    $('td .inquiry_export').click(function(){
        //alert($(this).data('referenceno'));
        refnum = $(this).data('referenceno');
        //alert(refnum);
        window.open("<?php echo base_url(); ?>index.php/Admission/HED_Student_Info_full/"+refnum);
        /*
        $.ajax({
            method: "POST",
            url: "<?php echo base_url(); ?>index.php/Admission/HED_Student_Info_full",
			data: { refnum: refnum},
            success: function(data){				
					result = JSON.parse(data);
                    console.log();
                    	     
			}
        

        });
        */
    });

});



</script>

	
