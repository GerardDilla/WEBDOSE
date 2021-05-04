<style>
    .display_hidden {
        display: none;
    }

    .excel_button_right {
        float: right;
        margin: 0 20px 0 0;
    }

    .like_search_div {
        position: absolute;
        /* top:-100px; */
    }

    .like_search_button {
        position: inherit;
        top: 10px;
    }

    .dataTables_filter,
    .dataTables_info {
        display: none;
    }
</style>
<section id="top" class="content" style="background-color: #fff;">
    <!-- CONTENT GRID-->
    <div class="container-fluid">
        <!-- MODULE TITLE-->
        <div class="block-header" id="base_url_js" data-baseurljs="<?php echo base_url(); ?>">
            <h1>Enrollment Tracker Report</h1>
        </div>
        <!--/ MODULE TITLE-->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <!-- CONTENT START -->
                    <!-- CONTENT TABS -->
                    <ul class="nav nav-tabs tab-col-red" id="enrollment_tracker_tablist" role="enrollment_tracker_tablist">
                        <li class="nav-item active">
                            <a class="enrollment_summary_report-tab nav-link active" data-toggle="tab" href="#enrollment_summary_report" role="tab" aria-controls="enrollment_summary_report" aria-selected="true">
                                <h5>Enrollment Summary Report</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="inquiry_report-tab nav-link" id="inquiry_report-tab" data-toggle="tab" href="#inquiry_report" role="tab" aria-controls="inquiry_report" aria-selected="true">
                                <h5>Inquiry Report</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="adviced_report-tab nav-link" id="adviced_report-tab" data-toggle="tab" href="#adviced_report" role="tab" aria-controls="adviced_report" aria-selected="false">
                                <h5>Advised Report</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="reserved_report-tab nav-link" id="reserved_report-tab" data-toggle="tab" href="#reserved_report" role="tab" aria-controls="reserved_report" aria-selected="false">
                                <h5>Reserved Report</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="enrolled_student_report-tab nav-link" id="enrolled_student_report-tab" data-toggle="tab" href="#enrolled_student_report" role="tab" aria-controls="enrolled_student_report" aria-selected="false">
                                <h5>Enrolled Student Report</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="tally_student_report-tab nav-link" id="tally_student_report-tab" data-toggle="tab" href="#tally_student_report" role="tab" aria-controls="tally_student_report" aria-selected="false">
                                <h5>Tally Student Report</h5>
                            </a>
                        </li>
                    </ul>
                    <!-- /CONTENT TABS -->
                    <div class="tab-content">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <h5>Choose Filter:</h5>
                                <br>
                                <form id="enrollment_tracker_form" action="javascript:void(0);" method="post" data-enrollment="<?php echo base_url(); ?>index.php/Admission/Enrollment_Summary_Report" data-inquiry="<?php echo base_url(); ?>index.php/Admission/Tracker_Inquiry_Report" data-advised="<?php echo base_url(); ?>index.php/Admission/Tracker_Advised_Report" data-reserved="<?php echo base_url(); ?>index.php/Admission/Tracker_Reserved_Report" data-enrolled="<?php echo base_url(); ?>index.php/Admission/Tracker_Enrolled_Report" data-excel="<?php echo base_url(); ?>index.php/Admission/Enrollment_Tracker_Excel">
                                    <!-- <div class="col-md-4" style="border-right:solid #ccc">
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
                                                            </div> -->
                                    <div class="col-md-5" style="border-right:solid #ccc">

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
                                            'id' => 'sy_enrollment_tracker',
                                            'class' => 'form-control show-tick',
                                            'data-live-search' => 'true',
                                            'required' => 'required',
                                        );
                                        echo form_dropdown('sy', $options, $this->input->post('sy'), $js);
                                        ?>


                                        <?php
                                        //Semester DROPDOWN
                                        $class = array(
                                            'class' => 'form-control show-tick',
                                            'id' => 'sem_enrollment_tracker',
                                        );
                                        $options =  array(
                                            '0'        => 'Select Semester',
                                            'FIRST'   => 'FIRST',
                                            'SECOND'  => 'SECOND',
                                            'SUMMER'  => 'SUMMER',
                                        );

                                        echo form_dropdown('sem', $options, $this->input->post('sem'), $class);

                                        ?>



                                        <select tabindex="2" class="form-control show-tick" data-live-search="true" name="course" id="course_enrollment_tracker">
                                            <option disabled selected>Select First Course:</option>
                                            <?php foreach ($this->data['get_course']->result_array() as $row) { ?>
                                                <?php if ($this->input->post('course') ==  $row['Program_Code']) : ?>
                                                    <option selected><?php echo $row['Program_Code']; ?></option>
                                                <?php else : ?>
                                                    <option><?php echo $row['Program_Code']; ?></option>
                                                <?php endif ?>
                                            <?php } ?>
                                        </select>



                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" id="enrollment_summary_filter" name="search_button" class="btn btn-lg btn-danger"> Search </button>
                                    </div>
                                </form>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="tab-content" id="">
                        <!--FIRST TAB-->
                        <div class="tab-pane fade active in" id="enrollment_summary_report" role="tabpanel" aria-labelledby="enrollment_summary_report-tab">
                            <div class="col-md-6 like_search_div">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="search" id="single_search_text_summary">
                                </div>
                                <div class="col-md-4">
                                    <input type="button" class="btn btn-info like_search_button" value="Filter" id="single_search_button_summary">
                                </div>
                                <br>
                            </div>
                            <br><br><br><br><br>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
                                                        Summary Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-success excel_button_right" id="enrollment_summary_excel" type="submit" name="export" value="Export"> Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="enrollment_preloader">
                                                    <div class="preloader pl-size-sm ">
                                                        <div class="spinner-layer pl-red">
                                                            <div class="circle-clipper left">
                                                                <div class="circle"></div>
                                                            </div>
                                                            <div class="circle-clipper right">
                                                                <div class="circle"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    Loading Data ...
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="body table-responsive" style="overflow:auto; max-height:400px" id="table-header-freeze">
                                                        <table class="table table-bordered" id="data_table_summary">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Tracker Status</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Student Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>First Choice</th>
                                                                    <th>Second Choice</th>
                                                                    <th>Third Choice</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Cellphone Number</th>
                                                                    <th>Telephone Number</th>
                                                                    <th>School Last Attended</th>
                                                                    <th>Residence</th>
                                                                    <th>Applied School Year</th>
                                                                    <th>Applied Semester</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="enrollment_summary_report_tbody">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--/FIRST TAB-->
                        <!--SECOND TAB-->
                        <div class="tab-pane fade active" id="inquiry_report" role="tabpanel" aria-labelledby="inquiry_report-tab">
                            <div class="col-md-6 like_search_div">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="search" id="single_search_text_inquiry">
                                </div>
                                <div class="col-md-4">
                                    <input type="button" class="btn btn-info like_search_button" value="Filter" id="single_search_button_inquiry">
                                </div>
                                <br>
                            </div>
                            <br><br><br><br><br>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
                                                        Inquiry Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-success excel_button_right" id="inquiry_excel" type="submit" name="export" value="Export"> Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="inquiry_preloader">
                                                    <div class="preloader pl-size-sm ">
                                                        <div class="spinner-layer pl-red">
                                                            <div class="circle-clipper left">
                                                                <div class="circle"></div>
                                                            </div>
                                                            <div class="circle-clipper right">
                                                                <div class="circle"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    Loading Data ...
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="body table-responsive" style="overflow:auto; max-height:400px" id="table-header-freeze">
                                                        <table class="table table-bordered" id="data_table_inquiry">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Student Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>First Choice</th>
                                                                    <th>Second Choice</th>
                                                                    <th>Third Choice</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Cellphone Number</th>
                                                                    <th>Telephone Number</th>
                                                                    <th>School Last Attended</th>
                                                                    <th>Residence</th>
                                                                    <th>Applied School Year</th>
                                                                    <th>Applied Semester</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="inquiry_report_tbody">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--/SECOND TAB-->
                        <!--THIRD TAB END-->
                        <div class="tab-pane fade" id="adviced_report" role="tabpanel" aria-labelledby="adviced_report-tab">
                            <div class="col-md-6 like_search_div">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="search" id="single_search_text_advising">
                                </div>
                                <div class="col-md-4">
                                    <input type="button" class="btn btn-info like_search_button" value="Filter" id="single_search_button_advising">
                                </div>
                                <br>
                            </div>
                            <br><br><br><br><br>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
                                                        Advsing Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-success excel_button_right" id="advised_excel" type="submit" name="export" value="Export"> Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="advised_preloader">
                                                    <div class="preloader pl-size-sm ">
                                                        <div class="spinner-layer pl-red">
                                                            <div class="circle-clipper left">
                                                                <div class="circle"></div>
                                                            </div>
                                                            <div class="circle-clipper right">
                                                                <div class="circle"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    Loading Data ...
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="body table-responsive" style="overflow:auto; max-height:400px" id="table-header-freeze">
                                                        <table class="table table-bordered" id="data_table_advised">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Student Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>Course</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Cellphone Number</th>
                                                                    <th>Telephone Number</th>
                                                                    <th>School Last Attended</th>
                                                                    <th>Residence</th>
                                                                    <th>Applied School Year</th>
                                                                    <th>Applied Semester</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="advised_report_tbody">

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

                        </div>

                        <!--/THIRD TAB END-->
                        <!--FOURTH TAB END-->
                        <div class="tab-pane fade" id="reserved_report" role="tabpanel" aria-labelledby="reserved_report-tab">
                            <div class="col-md-6 like_search_div">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="search" id="single_search_text_reserved">
                                </div>
                                <div class="col-md-4">
                                    <input type="button" class="btn btn-info like_search_button" value="Filter" id="single_search_button_reserved">
                                </div>
                                <br>
                            </div>
                            <br><br><br><br><br>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
                                                        Reserved Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-success excel_button_right" id="reserved_excel" type="submit" name="export" value="Export"> Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="reserved_preloader">
                                                    <div class="preloader pl-size-sm ">
                                                        <div class="spinner-layer pl-red">
                                                            <div class="circle-clipper left">
                                                                <div class="circle"></div>
                                                            </div>
                                                            <div class="circle-clipper right">
                                                                <div class="circle"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    Loading Data ...
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="body table-responsive" style="overflow:auto; max-height:400px" id="table-header-freeze">
                                                        <table class="table table-bordered" id="data_table_reserved">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Student Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>Course</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Cellphone Number</th>
                                                                    <th>Telephone Number</th>
                                                                    <th>School Last Attended</th>
                                                                    <th>Residence</th>
                                                                    <th>Applied School Year</th>
                                                                    <th>Applied Semester</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="reserved_report_tbody">

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

                        </div>

                        <!--/FOURTH TAB END-->
                        <!--FIFTH TAB END-->
                        <div class="tab-pane fade" id="enrolled_student_report" role="tabpanel" aria-labelledby="enrolled_student_report-tab">
                            <div class="col-md-6 like_search_div">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="search" id="single_search_text_enrolled">
                                </div>
                                <div class="col-md-4">
                                    <input type="button" class="btn btn-info like_search_button" value="Filter" id="single_search_button_enrolled">
                                </div>
                                <br>
                            </div>
                            <br><br><br><br><br>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
                                                        Enrolled Student Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-success excel_button_right" id="enrolled_excel" type="submit" name="export" value="Export"> Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="enrolled_preloader">
                                                    <div class="preloader pl-size-sm ">
                                                        <div class="spinner-layer pl-red">
                                                            <div class="circle-clipper left">
                                                                <div class="circle"></div>
                                                            </div>
                                                            <div class="circle-clipper right">
                                                                <div class="circle"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    Loading Data ...
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="body table-responsive" style="overflow:auto; max-height:400px" id="table-header-freeze">
                                                        <table class="table table-bordered" id="data_table_enrolled">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Student Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>Course</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Cellphone Number</th>
                                                                    <th>Telephone Number</th>
                                                                    <th>School Last Attended</th>
                                                                    <th>Residence</th>
                                                                    <th>Applied School Year</th>
                                                                    <th>Applied Semester</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="enrolled_report_tbody">

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
                        </div>
                        <!--/FIFTH TAB END-->
                        <!--SIXTH TAB END-->
<<<<<<< Updated upstream
                        <div class="tab-pane fade" id="tally_student_report" role="tabpanel" aria-labelledby="tally_student_report-tab">
                            <div class="col-md-6 like_search_div">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="search" id="single_search_text_tally">
                                </div>
                                <div class="col-md-4">
                                    <input type="button" class="btn btn-info like_search_button" value="Filter" id="single_search_button_tally">
=======
                        <div class="tab-pane fade" id="enrolled_student_report" role="tabpanel" aria-labelledby="enrolled_student_report-tab">
                            <div class="col-md-6 like_search_div">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="search" id="single_search_text_enrolled">
                                </div>
                                <div class="col-md-4">
                                    <input type="button" class="btn btn-info like_search_button" value="Filter" id="single_search_button_enrolled">
>>>>>>> Stashed changes
                                </div>
                                <br>
                            </div>
                            <br><br><br><br><br>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
<<<<<<< Updated upstream
                                                        Tally Student Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-success excel_button_right" id="tally_excel" type="submit" name="export" value="Export"> Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="tally_preloader">
=======
                                                        Enrolled Student Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-success excel_button_right" id="enrolled_excel" type="submit" name="export" value="Export"> Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="enrolled_preloader">
>>>>>>> Stashed changes
                                                    <div class="preloader pl-size-sm ">
                                                        <div class="spinner-layer pl-red">
                                                            <div class="circle-clipper left">
                                                                <div class="circle"></div>
                                                            </div>
                                                            <div class="circle-clipper right">
                                                                <div class="circle"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    Loading Data ...
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="body table-responsive" style="overflow:auto; max-height:400px" id="table-header-freeze">
<<<<<<< Updated upstream
                                                        <table class="table table-bordered" id="data_table_tally">
=======
                                                        <table class="table table-bordered" style="width: 1750px;" id="">
>>>>>>> Stashed changes
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

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
                        </div>
                        <!--/SIXTH TAB END-->
                    </div>
                    <!-- /CONTENT START -->
                </div>
            </div>
        </div>
    </div>
    <!--/CONTENT GRID-->
</section>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<script>
    $(document).ready(function() {
        var data_enrollment = $("#enrollment_tracker_form").data("enrollment");
        var data_inquiry = $("#enrollment_tracker_form").data("inquiry");
        var data_advised = $("#enrollment_tracker_form").data("advised");
        var data_reserved = $("#enrollment_tracker_form").data("reserved");
        var data_enrolled = $("#enrollment_tracker_form").data("enrolled");
        var data_excel = $("#enrollment_tracker_form").data("excel");
        var sy = $("#sy_enrollment_tracker").val();
        var sem = $("#sem_enrollment_tracker").val();
        var course = $("#course_enrollment_tracker").val();
        console.log(sy + " " + sem+ " " + course);
        var sy_check, sem_check, course_check;
        var no_id_checer_old = no_id_checker();
        var attr_enrollment, attr_inquiry, attr_advised, attr_reserved, attr_enrolled;
        var check_filter_summary = '';
        var check_filter_inquiry = '';
        var check_filter_advised = '';
        var check_filter_reserved = '';
        var check_filter_enrolled = '';
        // var count_enrollment=0, count_inquiry=0, count_advised=0, count_reserved=0, count_enrolled=0;
        load_new_data();
        $("#enrollment_summary_filter").on('click', function() {
            load_new_data();
            if (sy_check != sy || sem_check != sem || course_check != course || no_id_checer_old != no_id_checker()) {
                sy = sy_check;
                sem = sem_check;
                course = course_check;
                no_id_checer_old = no_id_checker();
                if (sy != 0 || sem != 0 || course != null) {
                    if (no_id_checker() == 'enrollment') {
                        check_filter_summary = 1;
                        get_enrollment_summary(data_enrollment, 'enrollment', sy, sem, course);
                    }
                    if (no_id_checker() == 'inquiry') {
                        check_filter_inquiry = 1;
                        get_enrollment_summary(data_inquiry, 'inquiry', sy, sem, course);
                    }
                    if (no_id_checker() == 'advised') {
                        check_filter_advised = 1;
                        get_enrollment_summary(data_advised, 'advised', sy, sem, course);
                    }
                    if (no_id_checker() == 'reserved') {
                        check_filter_reserved = 1;
                        get_enrollment_summary(data_reserved, 'reserved', sy, sem, course);
                    }
                    if (no_id_checker() == 'enrolled') {
                        check_filter_enrolled = 1;
                        get_enrollment_summary(data_enrolled, 'enrolled', sy, sem, course);
                    }
                } else {
                    console.log('both 0');
                }
            }
        });
        $(".enrollment_summary_report-tab").on('click', function() {
            $('.inquiry_report-tab').attr('id', 'inquiry_report-tab');
            $('.adviced_report-tab').attr('id', 'adviced_report-tab');
            $('.reserved_report-tab').attr('id', 'reserved_report-tab');
            $('.enrolled_student_report-tab').attr('id', 'enrolled_student_report-tab');
            $('.enrollment_summary_report-tab').removeAttr('id');
        });
        $(".inquiry_report-tab").on('click', function() {
            $('.enrollment_summary_report-tab').attr('id', 'enrollment_summary_report-tab');
            $('.adviced_report-tab').attr('id', 'adviced_report-tab');
            $('.reserved_report-tab').attr('id', 'reserved_report-tab');
            $('.enrolled_student_report-tab').attr('id', 'enrolled_student_report-tab');
            $('.inquiry_report-tab').removeAttr('id');
        });
        $(".adviced_report-tab").on('click', function() {
            $('.enrollment_summary_report-tab').attr('id', 'enrollment_summary_report-tab');
            $('.inquiry_report-tab').attr('id', 'inquiry_report-tab');
            $('.reserved_report-tab').attr('id', 'reserved_report-tab');
            $('.enrolled_student_report-tab').attr('id', 'enrolled_student_report-tab');
            $('.adviced_report-tab').removeAttr('id');
        });
        $(".reserved_report-tab").on('click', function() {
            $('.enrollment_summary_report-tab').attr('id', 'enrollment_summary_report-tab');
            $('.inquiry_report-tab').attr('id', 'inquiry_report-tab');
            $('.adviced_report-tab').attr('id', 'adviced_report-tab');
            $('.enrolled_student_report-tab').attr('id', 'enrolled_student_report-tab');
            $('.reserved_report-tab').removeAttr('id');
        });
        $(".enrolled_student_report-tab").on('click', function() {
            $('.enrollment_summary_report-tab').attr('id', 'enrollment_summary_report-tab');
            $('.inquiry_report-tab').attr('id', 'inquiry_report-tab');
            $('.adviced_report-tab').attr('id', 'adviced_report-tab');
            $('.reserved_report-tab').attr('id', 'reserved_report-tab');
            $('.enrolled_student_report-tab').removeAttr('id');
        });

        function load_new_data() {
            attr_enrollment = $(".enrollment_summary_report-tab").attr("id");
            attr_inquiry = $(".inquiry_report-tab").attr("id");
            attr_advised = $(".adviced_report-tab").attr("id");
            attr_reserved = $(".reserved_report-tab").attr("id");
            attr_enrolled = $(".enrolled_student_report-tab").attr("id");
            sy_check = $("#sy_enrollment_tracker").val();
            sem_check = $("#sem_enrollment_tracker").val();
            course_check = $("#course_enrollment_tracker").val();
        }

        function no_id_checker() {
            if (typeof attr_enrollment == typeof undefined || attr_enrollment == false) {
                return 'enrollment';
            } else if (typeof attr_inquiry == typeof undefined || attr_inquiry == false) {
                return 'inquiry';
            } else if (typeof attr_advised == typeof undefined || attr_advised == false) {
                return 'advised';
            } else if (typeof attr_reserved == typeof undefined || attr_reserved == false) {
                return 'reserved';
            } else if (typeof attr_enrolled == typeof undefined || attr_enrolled == false) {
                return 'enrolled';
            } else {
                return 'error';
            }
        }


        function get_enrollment_summary(data_url, no_id, sy, sem, course) {
            if (no_id == 'enrollment') {
                $('#enrollment_preloader').show();
            }
            if (no_id == 'inquiry') {
                $('#inquiry_preloader').show();
            }
            if (no_id == 'advised') {
                $('#advised_preloader').show();
            }
            if (no_id == 'reserved') {
                $('#reserved_preloader').show();
            }
            if (no_id == 'enrolled') {
                $('#enrolled_preloader').show();
            }
            $.ajax({
                method: 'post',
                url: data_url,
                data: {
                    sy: sy,
                    sem: sem,
                    course: course,
                },
                dataType: 'json',
                success: function(data) {

                    if (no_id == 'enrollment') {
                        $data_table_var = $('#data_table_summary');
                        $data_table_var.DataTable().destroy();

                        html = html_enrollment_summary(data);
                        $('#enrollment_summary_report_tbody').html(html);
                    }
                    if (no_id == 'inquiry') {
                        $data_table_var = $('#data_table_inquiry');
                        $data_table_var.DataTable().destroy();

                        html = html_inquiry_summary(data);
                        $('#inquiry_report_tbody').html(html);
                    }
                    if (no_id == 'advised') {
                        $data_table_var = $('#data_table_advised');
                        $data_table_var.DataTable().destroy();

                        html = html_advised_summary(data);
                        $('#advised_report_tbody').html(html);
                    }
                    if (no_id == 'reserved') {
                        $data_table_var = $('#data_table_reserved');
                        $data_table_var.DataTable().destroy();

                        html = html_reserved_summary(data);
                        $('#reserved_report_tbody').html(html);
                    }
                    if (no_id == 'enrolled') {
                        $data_table_var = $('#data_table_enrolled');
                        $data_table_var.DataTable().destroy();

                        html = html_enrolled_summary(data);
                        $('#enrolled_report_tbody').html(html);
                    }
                    // datatable for searching and pagination

                    $data_table_var.DataTable({
                        paging: false,
                        searching: true,
                        responsive: false,
                    });

                },
                error: function() {

                },
                complete: function() {
                    if (no_id == 'enrollment') {
                        $('#enrollment_preloader').hide();
                    }
                    if (no_id == 'inquiry') {
                        $('#inquiry_preloader').hide();
                    }
                    if (no_id == 'advised') {
                        $('#advised_preloader').hide();
                    }
                    if (no_id == 'reserved') {
                        $('#reserved_preloader').hide();
                    }
                    if (no_id == 'enrolled') {
                        $('#enrolled_preloader').hide();
                    }
                }
            });
        }

        function html_enrollment_summary(data) {
            var html = '';
            var i;
            var x = 0;
            for (i = 0; i < data.length; i++) {
                x++;
                html +=
                    '<tr>' +
                    '<td>' + x + '</td>' +
                    '<td>';
                if (data[i].Ref_Num_fec != null && data[i].Ref_Num_si != null && data[i].Ref_Num_ftc != null) {
                    html += '<span style="color:Green">Enrolled</span>';
                } else if (data[i].Ref_Num_ftc != null) {
                    html += '<span style="color:Blue">Payment</span>';
                } else {
                    html += '<span style="color:Red">Advising</span>'
                }
                html +=
                    '</td>' +
                    '<td>' +
                    data[i].Ref_Num_si +
                    '</td>' +
                    '<td>' +
                    data[i].Std_Num_si +
                    '</td>' +
                    '<td>' +
                    data[i].Last_Name +
                    ",<br>" +
                    data[i].First_Name +
                    "<br>" +
                    data[i].Middle_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Gender +
                    '</td>' +
                    '<td>' +
                    data[i].Nationality +
                    '</td>' +
                    '<td>' +
                    data[i].YearLevel +
                    '</td>' +
                    '<td>' +
                    data[i].Course_1st +
                    '</td>' +
                    '<td>' +
                    data[i].Course_2nd +
                    '</td>' +
                    '<td>' +
                    data[i].Course_3rd +
                    '</td>' +
                    '<td>';
                if (data[i].Others_Know_SDCA == 'Come_All') {
                    html += data[i].Others_Know_SDCA + '<br>Referral Name: ' + data[i].Referral_Name;
                } else {
                    html += data[i].Others_Know_SDCA;
                }
                html +=
                    '</td>' +
                    '<td>' +
                    data[i].CP_No +
                    '</td>' +
                    '<td>' +
                    data[i].Tel_No +
                    '</td>' +
                    '<td>' +
                    data[i].SHS_School_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Address_City + ', ' + data[i].Address_Province +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_SchoolYear +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_Semester +
                    '</td>' +
                    '</tr>';
            }
            return html;
        }

        function html_inquiry_summary(data) {
            var html = '';
            var i;
            var x = 0;
            for (i = 0; i < data.length; i++) {
                x++;
                html +=
                    '<tr>' +
                    '<td>' + x + '</td>' +
                    '<td>' +
                    data[i].Ref_Num_si +
                    '</td>' +
                    '<td>' +
                    data[i].Std_Num_si +
                    '</td>' +
                    '<td>' +
                    data[i].Last_Name +
                    ",<br>" +
                    data[i].First_Name +
                    "<br>" +
                    data[i].Middle_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Gender +
                    '</td>' +
                    '<td>' +
                    data[i].Nationality +
                    '</td>' +
                    '<td>' +
                    data[i].YearLevel +
                    '</td>' +
                    '<td>' +
                    data[i].Course_1st +
                    '</td>' +
                    '<td>' +
                    data[i].Course_2nd +
                    '</td>' +
                    '<td>' +
                    data[i].Course_3rd +
                    '</td>' +
                    '<td>';
                if (data[i].Others_Know_SDCA == 'Come_All') {
                    html += data[i].Others_Know_SDCA + '<br>Referral Name: ' + data[i].Referral_Name;
                } else {
                    html += data[i].Others_Know_SDCA;
                }
                html +=
                    '</td>' +
                    '<td>' +
                    data[i].CP_No +
                    '</td>' +
                    '<td>' +
                    data[i].Tel_No +
                    '</td>' +
                    '<td>' +
                    data[i].SHS_School_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Address_City + ', ' + data[i].Address_Province +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_SchoolYear +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_Semester +
                    '</td>' +
                    '</tr>';
            }
            return html;
        }

        function html_advised_summary(data) {
            var html = '';
            var i;
            var x = 0;
            for (i = 0; i < data.length; i++) {
                x++;
                html +=
                    '<tr>' +
                    '<td>' + x + '</td>' +
                    '<td>' +
                    data[i].Ref_Num_ftc +
                    '</td>' +
                    '<td>' +
                    data[i].Std_Num_si +
                    '</td>' +
                    '<td>' +
                    data[i].Last_Name +
                    ",<br>" +
                    data[i].First_Name +
                    "<br>" +
                    data[i].Middle_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Gender +
                    '</td>' +
                    '<td>' +
                    data[i].Nationality +
                    '</td>' +
                    '<td>' +
                    data[i].YearLevel +
                    '</td>' +
                    '<td>' +
                    data[i].Course_ftc +
                    '</td>' +
                    '<td>';
                if (data[i].Others_Know_SDCA == 'Come_All') {
                    html += data[i].Others_Know_SDCA + '<br>Referral Name: ' + data[i].Referral_Name;
                } else {
                    html += data[i].Others_Know_SDCA;
                }
                html +=
                    '</td>' +
                    '<td>' +
                    data[i].CP_No +
                    '</td>' +
                    '<td>' +
                    data[i].Tel_No +
                    '</td>' +
                    '<td>' +
                    data[i].SHS_School_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Address_City + ', ' + data[i].Address_Province +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_SchoolYear +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_Semester +
                    '</td>' +
                    '</tr>';
            }
            return html;
        }

        function html_reserved_summary(data) {
            var html = '';
            var i;
            var x = 0;
            for (i = 0; i < data.length; i++) {
                x++;
                html +=
                    '<tr>' +
                    '<td>' + x + '</td>' +
                    '<td>' +
                    data[i].Ref_No_rf +
                    '</td>' +
                    '<td>' +
                    data[i].Std_Num_si +
                    '</td>' +
                    '<td>' +
                    data[i].Last_Name +
                    ",<br>" +
                    data[i].First_Name +
                    "<br>" +
                    data[i].Middle_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Gender +
                    '</td>' +
                    '<td>' +
                    data[i].Nationality +
                    '</td>' +
                    '<td>' +
                    data[i].YearLevel +
                    '</td>' +
                    '<td>' +
                    data[i].Course_si +
                    '</td>' +
                    '<td>';
                if (data[i].Others_Know_SDCA == 'Come_All') {
                    html += data[i].Others_Know_SDCA + '<br>Referral Name: ' + data[i].Referral_Name;
                } else {
                    html += data[i].Others_Know_SDCA;
                }
                html +=
                    '</td>' +
                    '<td>' +
                    data[i].CP_No +
                    '</td>' +
                    '<td>' +
                    data[i].Tel_No +
                    '</td>' +
                    '<td>' +
                    data[i].SHS_School_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Address_City + ', ' + data[i].Address_Province +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_SchoolYear +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_Semester +
                    '</td>' +
                    '</tr>';
            }
            return html;
        }

        function html_enrolled_summary(data) {
            var html = '';
            var i;
            var x = 0;
            for (i = 0; i < data.length; i++) {
                x++;
                html +=
                    '<tr>' +
                    '<td>' + x + '</td>' +
                    '<td>' +
                    data[i].Reference_Number +
                    '</td>' +
                    '<td>' +
                    data[i].Std_Num_si +
                    '</td>' +
                    '<td>' +
                    data[i].Last_Name +
                    ",<br>" +
                    data[i].First_Name +
                    "<br>" +
                    data[i].Middle_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Gender +
                    '</td>' +
                    '<td>' +
                    data[i].Nationality +
                    '</td>' +
                    '<td>' +
                    data[i].YearLevel +
                    '</td>' +
                    '<td>' +
                    data[i].course +
                    '</td>' +
                    '<td>';
                if (data[i].Others_Know_SDCA == 'Come_All') {
                    html += data[i].Others_Know_SDCA + '<br>Referral Name: ' + data[i].Referral_Name;
                } else {
                    html += data[i].Others_Know_SDCA;
                }
                html +=
                    '</td>' +
                    '<td>' +
                    data[i].CP_No +
                    '</td>' +
                    '<td>' +
                    data[i].Tel_No +
                    '</td>' +
                    '<td>' +
                    data[i].SHS_School_Name +
                    '</td>' +
                    '<td>' +
                    data[i].Address_City + ', ' + data[i].Address_Province +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_SchoolYear +
                    '</td>' +
                    '<td>' +
                    data[i].Applied_Semester +
                    '</td>' +
                    '</tr>';
            }
            return html;
        }

        //For Excel
        $("#enrollment_summary_excel").on('click', function() {
            load_new_data();
            if (sy_check != 0 || sem_check != 0 || course_check != null) {
                window.open(data_excel + '/' + sy_check + '/' + sem_check + '/' + course_check + '/Enrollment_Tracker');
            } else {
                console.log('No data');
            }
        });
        $("#inquiry_excel").on('click', function() {
            load_new_data();
            if (sy_check != 0 || sem_check != 0 || course_check != null) {
                window.open(data_excel + '/' + sy_check + '/' + sem_check + '/' + course_check + '/Inquiry');
            } else {
                console.log('No data');
            }
        });
        $("#advised_excel").on('click', function() {
            load_new_data();
            if (sy_check != 0 || sem_check != 0 || course_check != null) {
                window.open(data_excel + '/' + sy_check + '/' + sem_check + '/' + course_check + '/Advised');
            } else {
                console.log('No data');
            }
        });
        $("#reserved_excel").on('click', function() {
            load_new_data();
            if (sy_check != 0 || sem_check != 0 || course_check != null) {
                window.open(data_excel + '/' + sy_check + '/' + sem_check + '/' + course_check + '/Reserved');
            } else {
                console.log('No data');
            }
        });
        $("#enrolled_excel").on('click', function() {
            load_new_data();
            if (sy_check != 0 || sem_check != 0 || course_check != null) {
                window.open(data_excel + '/' + sy_check + '/' + sem_check + '/' + course_check + '/Enrolled');
            } else {
                console.log('No data');
            }
        });
<<<<<<< Updated upstream

=======
        function error_modal(title, msg) {
            iziToast.show({
                position: 'center',
                color: 'red',
                title: title,
                message: msg
            });
        }
>>>>>>> Stashed changes
        $("#single_search_button_summary").on('click', function() {
            if (check_filter_summary != '') {
                $("#data_table_summary").DataTable().search($("#single_search_text_summary").val()).draw();
            } else {
                error_modal('Search First', 'You must SEACRH first before filtering');
            }
        });

        $("#single_search_button_inquiry").on('click', function() {
            if (check_filter_inquiry != '') {
                $("#data_table_inquiry").DataTable().search($("#single_search_text_inquiry").val()).draw();
            } else {
                error_modal('Search First', 'You must SEACRH first before filtering');
            }
        });

        $("#single_search_button_advising").on('click', function() {
            if (check_filter_advised != '') {
                $("#data_table_advised").DataTable().search($("#single_search_text_advising").val()).draw();
            } else {
                error_modal('Search First', 'You must SEACRH first before filtering');
            }
        });

        $("#single_search_button_reserved").on('click', function() {
            if (check_filter_reserved != '') {
                $("#data_table_reserved").DataTable().search($("#single_search_text_reserved").val()).draw();
            } else {
                error_modal('Search First', 'You must SEACRH first before filtering');
            }
        });

        $("#single_search_button_enrolled").on('click', function() {
            if (check_filter_enrolled != '') {
                $("#data_table_enrolled").DataTable().search($("#single_search_text_enrolled").val()).draw();
            } else {
                error_modal('Search First', 'You must SEACRH first before filtering');
            }
        });

        function datatable($data_table_var) {
            $data_table_var.DataTable({
                paging: false,
                searching: true,
                responsive: false,
            });
        }

        function error_modal(title, msg) {
            iziToast.show({
                position: 'center',
                color: 'red',
                title: title,
                message: msg
            });
        }
    });
</script>