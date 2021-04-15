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
                                    Basic Education Inquiry Reports <br>
                                </h2>
                            </div>
                            <form action="<?php echo base_url(); ?>index.php/Admission/Inquiry_BED" method="post">
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

                                <div class="col-md-4">
                                    <div class="row">


                                        <div class="col-md-6">
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
                                            //SELECT LEVEL
                                            $class = array(
                                                'class' => 'form-control show-tick',
                                                'id'   => 'Program',
                                                'data-live-search'   => 'true',
                                            );
                                            $options =  array('' => 'Select Grade level');
                                            foreach ($this->data['get_lvl'] as $row) {
                                                $options[$row->Grade_LevelCode] = $row->Grade_Level;
                                            }
                                            echo form_dropdown('getlvl', $options, $this->input->post('getlvl'), $class);
                                            ?>

                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-danger" type="submit" name="search_button" value="search_button"> Search </button>
                                            <button class="btn btn-success" type="submit" name="export" value="Export"> Excel </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><br>
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
                                    <th>Name</th>
                                    <th>Grade Level</th>
                                    <th>Search Engine</th>
                                    <th>Contact #</th>
                                    <th>School Last Attended</th>
                                    <th>Residence</th>
                                    <th>DSWD Number</th>
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
                                    <tr>

                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $row->Last_Name; ?>, <?php echo $row->First_Name; ?> <?php echo $row->Middle_Name; ?></td>
                                        <td><?php echo $row->Gradelevel; ?></td>
                                        <td><?php echo $OKS; ?></td>
                                        <td><?php echo $row->Mobile_No; ?></td>
                                        <td><?php echo $row->Previous_School_Name1; ?></td>
                                        <td><?php echo $row->City; ?>, <?php echo $row->Province; ?></td>
                                        <td><?php echo $row->dswd_no ? $row->dswd_no : 'N/A'; ?></td>



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