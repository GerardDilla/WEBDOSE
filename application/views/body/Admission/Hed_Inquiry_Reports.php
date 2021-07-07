<style>
    .dataTables_filter,
    .dataTables_info {
        display: none;
    }

    #datatbable_search_button {
        position: relative;
        top: 33px;
    }
</style>
<section id="top" class="content" style="background-color: #fff;">

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
                                                        <label for="inquiry_from">From: </label>
                                                        <?php if (!empty($this->input->post('inquiry_from'))) : ?>
                                                            <input type="date" id="inquiry_from" class="form-control" name="inquiry_from" data-date-format="yyyy-mm-dd" value="<?php echo $this->input->post('inquiry_from'); ?>">
                                                        <?php else : ?>
                                                            <input type="date" id="inquiry_from" class="form-control" name="inquiry_from" data-date-format="yyyy-mm-dd">
                                                        <?php endif ?>
                                                    </td>
                                                    <td>
                                                        <!-- <button>Clear</button> -->
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <label for="inquiry_to">To: </label>
                                                        <?php if (!empty($this->input->post('inquiry_from'))) : ?>
                                                            <input type="date" id="inquiry_to" class="form-control" name="inquiry_to" data-date-format="yyyy-mm-dd" value="<?php echo $this->input->post('inquiry_to'); ?>">
                                                        <?php else : ?>
                                                            <input type="date" id="inquiry_to" class="form-control" name="inquiry_to" data-date-format="yyyy-mm-dd">
                                                        <?php endif ?>
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="single_search">Reference no. / Student No.</label>
                                                        <?php if (!empty($this->input->post('single_search'))) : ?>
                                                            <input type="text" name="single_search" class="form-control" id="single_search" value="<?php echo $this->input->post('single_search');?>">
                                                        <?php else : ?>
                                                            <input type="text" name="single_search" class="form-control" id="single_search">
                                                        <?php endif ?>
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

                                                '0' => 'Select School Year',
                                                ($year_now - 1) . "-" . $year_now => ($year_now - 1) . "-" . $year_now,
                                                $year_now . "-" . ($year_now + 1) => $year_now . "-" . ($year_now + 1),
                                                ($year_now + 1) . "-" . ($year_now + 2) => ($year_now + 1) . "-" . ($year_now + 2)

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

                                            echo form_dropdown('sem', $options, $this->input->post('sem'), $class);

                                            ?>


                                            <label for="course">Course Enrolled :</label>
                                            <select tabindex="2" class="form-control show-tick" data-live-search="true" name="course">
                                                <option value="0" selected>Select Course:</option>
                                                <?php foreach ($this->data['get_course']->result_array() as $row) { ?>
                                                    <?php if ($this->input->post('course') ==  $row['Program_Code']) : ?>
                                                        <option selected><?php echo $row['Program_Code']; ?></option>
                                                    <?php else : ?>
                                                        <option><?php echo $row['Program_Code']; ?></option>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </select>

                                            <label for="1st_coice">First Choice :</label>
                                            <select class="form-control show-tick" data-live-search="true" name="1st_choice">
                                                <option value="0" selected>Select Course:</option>
                                                <?php foreach ($this->data['get_course']->result_array() as $row) { ?>
                                                    <?php if ($this->input->post('1st_choice') ==  $row['Program_Code']) : ?>
                                                        <option selected><?php echo $row['Program_Code']; ?></option>
                                                    <?php else : ?>
                                                        <option><?php echo $row['Program_Code']; ?></option>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" name="search_button" class="btn btn-lg btn-danger"> Search </button>
                                            <br><br>
                                            <button class="btn btn-lg  btn-success" type="submit" name="export" value="Export"> Excel </button>
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <label for="datatbable_search">Search on Table</label>
                                        <input type="text" id="datatbable_search" class="form-control" placeholder="Search">
                                    </div>
                                    <div class="col-md-4">
                                        <button id="datatbable_search_button" class="btn btn-info">Table Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="body table-responsive" style="overflow:auto; max-height:400px">
                                <table class="table table-bordered" style="width: 1600px;" id="data_table_report_admission">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Applied</th>
                                            <th>Reference_Number</th>
                                            <th>Name</th>
                                            <th>Program</th>
                                            <th>Search Engine</th>
                                            <th>Contact #</th>
                                            <th>Email</th>
                                            <th>School Last Attended</th>
                                            <th>Residence</th>
                                            <th>Status </th>
                                            <th>Remarks </th>
                                            <th>Applied School Year</th>
                                            <th>Applied Semester</th>
                                            <th>DSWD Number</th>
                                            <th>Date Inquired</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        <?php

                                        foreach ($this->data['get_inquiry'] as $row) {

                                            if ($row->Others_Know_SDCA == NULL) {
                                                $OKS = 'N/A';
                                            } else {
                                                $OKS = $row->Others_Know_SDCA;
                                            }
                                        ?>
                                            <tr style="text-transform: uppercase;">

                                                <td><?php echo $count; ?></td>
                                                <td>
                                                    <?php echo !empty($row->interview_status) ? 'Onestop' : ''
                                                    ?>
                                                </td>
                                                <td><?php echo $row->ref_no; ?></td>
                                                <td><?php echo $row->Last_Name; ?>, <?php echo $row->First_Name; ?> <?php echo $row->Middle_Name; ?></td>
                                                <td>
                                                    <?php if ($row->EXM_RF == NULL) : ?>
                                                        <?php echo $row->Course_1st; ?>
                                                    <?php else : ?>
                                                        <?php echo $row->Course; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $OKS; ?></td>
                                                <td><?php echo $row->CP_No; ?></td>
                                                <td><?php echo $row->Email; ?></td>

                                                <?php if ($row->Transferee_Name == NULL || $row->Transferee_Name == 'N/A' || $row->Transferee_Name == '' || $row->Transferee_Name == '-') : ?>
                                                    <?php if ($row->SHS_School_Name == NULL || $row->SHS_School_Name == 'N/A' || $row->SHS_School_Name == '' || $row->SHS_School_Name == '-') : ?>
                                                        <td><?php echo $row->Secondary_School_Name; ?></td>
                                                    <?php else : ?>
                                                        <td><?php echo $row->SHS_School_Name; ?></td>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <td><?php echo $row->Transferee_Name; ?></td>
                                                <?php endif; ?>

                                                <td><?php echo $row->Address_City; ?>, <?php echo $row->Address_Province; ?></td>
                                                <td>
                                                    <?php if ($row->Transferee_Name == NULL || $row->Transferee_Name == 'N/A' || $row->Transferee_Name == '' || $row->Transferee_Name == '-') : ?>
                                                        <?php echo 'New'; ?>
                                                    <?php else : ?>
                                                        <?php echo 'Transferee'; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($row->EXM_RF == NULL) : ?>
                                                        <?php echo 'Follow Up'; ?>
                                                    <?php else : ?>
                                                        <?php echo 'With Exam'; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $row->Applied_SchoolYear; ?></td>
                                                <td><?php echo $row->Applied_Semester; ?></td>
                                                <td><?php echo $row->dswd_no ? $row->dswd_no : 'N/A'; ?></td>
                                                <td><?php echo $row->DateInquired; ?></td>
                                                <!--<td><?php echo $row->Rmk; ?></td>-->

                                            </tr>

                                            <?php $count++; ?>
                                        <?php } ?>



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
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>
<script>
    $('#data_table_report_admission').DataTable().destroy();
    var table = $('#data_table_report_admission').DataTable({
        paging: false,
        // searching: true,
        responsive: false,
    });
    $('#datatbable_search_button').on('keyup click', function() {
        table.search($('#datatbable_search').val()).draw();
    });
</script>