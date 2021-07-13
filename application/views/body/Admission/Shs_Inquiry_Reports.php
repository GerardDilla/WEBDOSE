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
                            <div class="col-md-6">
                                <h2>
                                    Senior High School Enrollment Summary <br>
                                </h2>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <form action="<?php echo base_url(); ?>index.php/Admission/Inquiry_SHS" method="post">
                                        <div class="col-md-6">


                                            <select tabindex="1" required class="form-control show-tick" data-live-search="true" name="sy">
                                                <?php foreach ($this->data['get_sy']->result_array() as $row) { ?>
                                                    <?php if ($this->input->post('sy') ==  $row['SchoolYear']) : ?>
                                                        <option selected><?php echo $row['SchoolYear']; ?></option>
                                                    <?php else : ?>
                                                        <option><?php echo $row['SchoolYear']; ?></option>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </select>

                                            <select tabindex="2" required class="form-control show-tick" data-live-search="true" name="gradlvl">
                                                <?php foreach ($this->data['get_lvl']->result_array() as $row) { ?>
                                                    <?php if ($this->input->post('gradlvl') ==  $row['Grade_LevelCode']) : ?>
                                                        <option value="<?php echo $row['Grade_LevelCode']; ?>" selected><?php echo $row['Grade_Level']; ?></option>
                                                    <?php else : ?>
                                                        <option value="<?php echo $row['Grade_LevelCode']; ?>"><?php echo $row['Grade_Level']; ?></option>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" name="search_button" class="btn btn-lg btn-danger"> Search </button>
                                            <button class="btn btn-lg  btn-success" type="submit" name="export" value="Export"> Excel </button>
                                        </div>
                                    </form>
                                </div>
                                <br>
                                <div class="row">
                                    <!-- <div class="col-md-4"></div> -->
                                    <div class="col-md-8">
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
                                <table class="table table-bordered" style="width: 1750px;" id="data_table_report_admission">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Grade Level</th>
                                            <th>Strand</th>
                                            <th>Search Engine</th>
                                            <th>Contact #</th>
                                            <th>School Last Attended</th>
                                            <th>Residence</th>
                                            <th>DSWD Number</th>
                                            <th></th>
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


                                            if ($row->Strand == NULL) {
                                                $Strand = 'N/A';
                                            } else {
                                                $Strand = $row->Strand;
                                            }
                                        ?>
                                            <tr>

                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $row->Last_Name; ?>, <?php echo $row->First_Name; ?> <?php echo $row->Middle_Name; ?></td>
                                                <td><?php echo $row->Gradelevel; ?></td>
                                                <td><?php echo $Strand; ?></td>
                                                <td><?php echo $OKS; ?></td>
                                                <td><?php echo $row->Mobile_No; ?></td>
                                                <td><?php echo $row->Previous_School_Name1; ?></td>
                                                <td><?php echo $row->City; ?>, <?php echo $row->Province; ?></td>
                                                <td><?php echo $row->dswd_no ? $row->dswd_no : 'N/A'; ?></td>
                                                <!-- <td><a href="<?php echo base_url(); ?>index.php/Admission/SHS_inquiryExport/<?php echo $row->ref_no; ?>" class="btn btn-info btn-sm">Export Application Form</a></td> -->
                                                <td><button type="button" onclick="window.open(`<?php echo base_url(); ?>index.php/Admission/SHS_inquiryExport/<?php echo $row->ref_no; ?>`,'_blank','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=800,height=600')" class="btn btn-info btn-sm">Export Application Form</button></td>

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