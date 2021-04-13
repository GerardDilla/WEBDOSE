<section  id="top" class="content" >
    <div class="container-fluid">
	
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>
                             TITLE HERE<br>
                        </h2>         
                    </div>  
                    <br>   
                    <div class="row">
                        <form method="post" action="<?php echo base_url(); ?>index.php/Admission/">
                            <div class="col-md-3">
                                <?php 
                                    //Search By
                                    $class = array('class' => 'form-control show-tick',);
                                    $options =  array(
                                        ''   => 'Search By:',
                                        ''   => 'Student Number',
                                        ''   => 'Name',
                                    );

                                    echo form_dropdown('Sem', $options, $this->input->post('search'),$class);

                                ?>  
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="" class="form-control InfoEnabled" value="" >
                            </div> 
                            <div class="col-md-3">
                                <button class="btn btn-danger" type="submit" name="search_button" > Search </button>
                            </div> 
                    </div>             
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
                                </tbody>
                            </table>
                        </div>
                      
                         
             </div>

	</div>
</section>



