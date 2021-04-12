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
                                    <label class="text-red" for="HED">Basic Education </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <form method="post" action="<?php echo base_url(); ?>index.php/Registrar/EnrolledStudentBEDREPORT">
                                <input type="hidden" value="<?php echo base_url(); ?>" id="guidance_url">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-lg btn-success pull-right" type="submit" name="export" value="Export"><i class="material-icons">print</i> Export</button>
                                    <button type="submit" name="search_button" class="btn btn-lg btn-danger pull-right"><i class="material-icons">search</i> Search </button>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php

                                        //SCHOOL YEAR DROPDOWN
                                        $class = array('class' => 'form-control show-tick',);
                                        $datestring = "%Y";
                                        $time = time();
                                        $year_now = mdate($datestring, $time);
                                        $options = array(
                                                        
                                            '0'=> 'Select School Year',
                                            ($year_now - 2)."-".($year_now - 1) => ($year_now - 2)."-".($year_now - 1),
                                            ($year_now - 1)."-".$year_now => ($year_now - 1)."-".$year_now,
                                            $year_now."-".($year_now + 1) => $year_now."-".($year_now + 1),
                                            // ($year_now + 1)."-".($year_now + 2) => ($year_now + 1)."-".($year_now + 2)
                                            
                                        );




                                        echo form_dropdown('School_year', $options, $this->input->post('School_year'), $class);

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
                                        echo form_dropdown('Gender', $options, $this->input->post('Gender'), $class);
                                        ?>

                                        <br>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <?php
                                        //SELECT LEVEL
                                        $class = array('class' => 'form-control show-tick',);
                                        $options =  array('' => 'Select Grade Level');
                                        foreach ($this->data['Get_Levels'] as $row) {

                                            $options[$row['Grade_LevelCode']] = $row['Grade_Level'];
                                        }
                                        echo form_dropdown('GLVL', $options, $this->input->post('GLVL'), $class);
                                        ?>

                                        <br>
                            </form>

                        </div>
                    </div>
                </div>

                <p class="pull-right" style="font-weight: 900; font-size: large;">Total Number of Students Enrolled Search:<span class="red"> <?php echo $this->data['GetStudent']->num_rows(); ?> </span> </p>
                <br> <br>
            </div><!-- card -->
        </div><!-- col-lg-12 -->

        <div class="table panel panel-danger" style="overflow-x:auto; overflow-y: auto; height: 500px;">
            <table class="table table-bordered" style="width: 2500px;">

                <thead>
                    <tr class="danger">
                        <th>#</th>
                        <th>Name</th>
                        <th>Student Number</th>
                        <th>Grade Level</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Birthday</th>
                        <th>Nationality</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($this->data['GetStudent']->result_array() as $row) :
                    ?>
                        <tr style="text-transform: uppercase;">
                            <td><?php echo  $count;  ?></td>
                            <td><?php echo  $row['Last_Name']; ?>,&nbsp;&nbsp;<?php echo  $row['First_Name']; ?>&nbsp;&nbsp;<?php echo $row['Middle_Name']; ?></td>
                            <td><?php echo  $row['Student_number']; ?></td>
                            <td><?php echo  $row['Gradelevel']; ?></td>
                            <td><?php echo  $row['Gender']; ?></td>
                            <td><?php echo $row['Address_No']; ?> ,<?php echo $row['Address_Street']; ?> , <?php echo $row['Subdivision']; ?>, <?php echo $row['Barangay']; ?>, <?php echo $row['City']; ?>, <?php echo $row['Province']; ?></td>
                            <td><?php echo  $row['Mobile_No']; ?></td>
                            <td><?php echo  $row['Birth_Date']; ?></td>
                            <td><?php echo  $row['Nationality']; ?></td>
                        <?php $count = $count + 1;
                    endforeach; ?>

                </tbody>
            </table>


        </div>
    </div><!-- row clearfix -->


    </div><!-- container-fluid-->
    </div>
    <!--content -->