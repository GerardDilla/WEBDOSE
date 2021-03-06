<style>
    .display_hidden {
        display: none;
    }

    .excel_button_right {
        float: right;
        margin: 0 20px 0 0;
    }
</style>
<section id="top" class="content" style="background-color: #fff;">
    <!-- CONTENT GRID-->
    <div class="container-fluid">
        <!-- MODULE TITLE-->
        <div class="block-header">
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
                    </ul>
                    <!-- /CONTENT TABS -->
                    <div class="tab-content">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <h5>Choose Filter:</h5>
                                <br>
                                <form id="enrollment_tracker_form" action="javascript:void(0);" method="post" 
                                data-enrollment="<?php echo base_url(); ?>index.php/Admission/Enrollment_Summary_Report" 
                                data-inquiry="<?php echo base_url(); ?>index.php/Admission/Tracker_Inquiry_Report" 
                                data-advised="<?php echo base_url(); ?>index.php/Admission/Tracker_Advised_Report" 
                                data-reserved="<?php echo base_url(); ?>index.php/Admission/Tracker_Reserved_Report" 
                                data-enrolled="<?php echo base_url(); ?>index.php/Admission/Tracker_Enrolled_Report"
                                data-excel="<?php echo base_url(); ?>index.php/Admission/Enrollment_Tracker_Excel">
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
                                            <option disabled selected>Select Course:</option>
                                            <?php foreach ($this->data['get_course']->result_array() as $row) { ?>
                                                <?php if ($this->input->post('course') ==  $row['Program_Code']) : ?>
                                                    <option selected><?php echo $row['Program_Code']; ?></option>
                                                <?php else : ?>
                                                    <option><?php echo $row['Program_Code']; ?></option>
                                                <?php endif ?>
                                            <?php } ?>
                                        </select>



                                    </div>
                                    <div class="col-md-4">
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
                                                        <table class="table table-bordered" style="width: 1750px;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Tracker Status</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>First Choice</th>
                                                                    <th>Second Choice</th>
                                                                    <th>Third Choice</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Contact #</th>
                                                                    <!-- <th>School Last Attended</th> -->
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
                                                        <table class="table table-bordered" style="width: 1750px;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>First Choice</th>
                                                                    <th>Second Choice</th>
                                                                    <th>Third Choice</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Contact #</th>
                                                                    <!-- <th>School Last Attended</th> -->
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
                                                        <table class="table table-bordered" style="width: 1750px;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>Course</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Contact #</th>
                                                                    <!-- <th>School Last Attended</th> -->
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
                                                        <table class="table table-bordered" style="width: 1750px;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>Course</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Contact #</th>
                                                                    <!-- <th>School Last Attended</th> -->
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
                                                        <table class="table table-bordered" style="width: 1750px;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Number</th>
                                                                    <th>Name</th>
                                                                    <th>Gender</th>
                                                                    <th>Nationality</th>
                                                                    <th>YearLevel</th>
                                                                    <th>Course</th>
                                                                    <th>Search Engine</th>
                                                                    <th>Contact #</th>
                                                                    <!-- <th>School Last Attended</th> -->
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
                    </div>
                    <!-- /CONTENT START -->
                </div>
            </div>
        </div>
    </div>
    <!--/CONTENT GRID-->
</section>
<script>
    $(function() {
        var data_enrollment = $("#enrollment_tracker_form").data("enrollment");
        var data_inquiry = $("#enrollment_tracker_form").data("inquiry");
        var data_advised = $("#enrollment_tracker_form").data("advised");
        var data_reserved = $("#enrollment_tracker_form").data("reserved");
        var data_enrolled = $("#enrollment_tracker_form").data("enrolled");
        var data_excel = $("#enrollment_tracker_form").data("excel");
        var sy = $("#sy_enrollment_tracker").val();
        var sem = $("#sem_enrollment_tracker").val();
        var course = $("#course_enrollment_tracker").val();
        var sy_check, sem_check, course_check;
        var no_id_checer_old = no_id_checker();
        var attr_enrollment, attr_inquiry, attr_advised, attr_reserved, attr_enrolled;
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
                    // if(count_enrollment == 0){
                    if (no_id_checker() == 'enrollment') {
                        get_enrollment_summary(data_enrollment, 'enrollment', sy, sem, course);
                    }
                    // }else if(count_inquiry == 0){
                    if (no_id_checker() == 'inquiry') {
                        get_enrollment_summary(data_inquiry, 'inquiry', sy, sem, course);
                    }
                    // }else if(count_advised == 0){
                    if (no_id_checker() == 'advised') {
                        get_enrollment_summary(data_advised, 'advised', sy, sem, course);
                    }
                    // }else if(count_reserved == 0){
                    if (no_id_checker() == 'reserved') {
                        get_enrollment_summary(data_reserved, 'reserved', sy, sem, course);
                    }
                    // }else if(count_enrolled == 0){
                    if (no_id_checker() == 'enrolled') {
                        get_enrollment_summary(data_enrolled, 'enrolled', sy, sem, course);
                    }
                    // }else{
                    // console.log('nooooo');
                    // }
                } else {
                    console.log('both 0');
                }
            }
            // if(sy_check != sy){
            //     sy = sy_check;
            //     // count_enrollment = 0;count_inquiry = 0;count_advised = 0;count_reserved = 0;count_enrolled = 0;
            // }
            // if(sem_check != sem){
            //     sem = sem_check;
            //     // count_enrollment = 0;count_inquiry = 0;count_advised = 0;count_reserved = 0;count_enrolled = 0;
            // }
            // if(course_check != course){
            //     course = course_check;
            //     // count_enrollment = 0;count_inquiry = 0;count_advised = 0;count_reserved = 0;count_enrolled = 0;
            // }

            // if(sy != 0 || sem != 0 || course != null){
            //     if(count_enrollment == 0){
            //         if(no_id_checker() == 'enrollment'){
            //             console.log('load once Enrollment');
            //         }
            //     }else if(count_inquiry == 0){
            //         if(no_id_checker() == 'inquiry'){
            //             console.log('load once inquiry');
            //         }
            //     }else if(count_advised == 0){
            //         if(no_id_checker() == 'advised'){
            //             console.log('load once advised');
            //         }
            //     }else if(count_reserved == 0){
            //         if(no_id_checker() == 'reserved'){
            //             console.log('load once reserved');
            //         }
            //     }else if(count_enrolled == 0){
            //         if(no_id_checker() == 'enrolled'){
            //             console.log('load once enrolled');
            //         }
            //     }else{
            //         console.log('nooooo');
            //     }
            // }else{
            //     console.log('both 0');
            // }
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
                // count_enrollment = 1;
                // count_inquiry = 0;
                // count_advised = 0;
                // count_reserved = 0;
                // count_enrolled = 0;
                return 'enrollment';
            } else if (typeof attr_inquiry == typeof undefined || attr_inquiry == false) {
                // count_enrollment = 0;
                // count_inquiry = 1;
                // count_advised = 0;
                // count_reserved = 0;
                // count_enrolled = 0;
                return 'inquiry';
            } else if (typeof attr_advised == typeof undefined || attr_advised == false) {
                // count_enrollment = 0;
                // count_inquiry = 0;
                // count_advised = 1;
                // count_reserved = 0;
                // count_enrolled = 0;
                return 'advised';
            } else if (typeof attr_reserved == typeof undefined || attr_reserved == false) {
                // count_enrollment = 0;
                // count_inquiry = 0;
                // count_advised = 0;
                // count_reserved = 1;
                // count_enrolled = 0;
                return 'reserved';
            } else if (typeof attr_enrolled == typeof undefined || attr_enrolled == false) {
                // count_enrollment = 0;
                // count_inquiry = 0;
                // count_advised = 0;
                // count_reserved = 0;
                // count_enrolled = 1;
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
                        html = html_enrollment_summary(data);
                        $('#enrollment_summary_report_tbody').html(html);
                    }
                    if (no_id == 'inquiry') {
                        html = html_inquiry_summary(data);
                        $('#inquiry_report_tbody').html(html);
                    }
                    if (no_id == 'advised') {
                        html = html_advised_summary(data);
                        $('#advised_report_tbody').html(html);
                    }
                    if (no_id == 'reserved') {
                        html = html_reserved_summary(data);
                        $('#reserved_report_tbody').html(html);
                    }
                    if (no_id == 'enrolled') {
                        html = html_enrolled_summary(data);
                        $('#enrolled_report_tbody').html(html);
                    }

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
                    '<td>';
                html += data[i].Ref_Num_si;
                        if (data[i].Std_Num_si != null && data[i].Std_Num_si != 0) {
                            html += "<br>Std_No.: " + data[i].Std_Num_si;
                        }
                html +=
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
                    '<td>';
                        if (data[i].Tel_No != null && data[i].CP_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No +
                                '<br>' +
                                'Cellphone: ' + data[i].CP_No;
                        } else if (data[i].Tel_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No;
                        } else if (data[i].CP_No != null) {
                            html +=
                                'Cellphone: ' + data[i].CP_No;
                        }
                html +=
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
                    '<td>';
                        if (data[i].Tel_No != null && data[i].CP_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No +
                                '<br>' +
                                'Cellphone: ' + data[i].CP_No;
                        } else if (data[i].Tel_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No;
                        } else if (data[i].CP_No != null) {
                            html +=
                                'Cellphone: ' + data[i].CP_No;
                        }
                html +=
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
                    '<td>';
                        if (data[i].Tel_No != null && data[i].CP_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No +
                                '<br>' +
                                'Cellphone: ' + data[i].CP_No;
                        } else if (data[i].Tel_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No;
                        } else if (data[i].CP_No != null) {
                            html +=
                                'Cellphone: ' + data[i].CP_No;
                        }
                html +=
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
                    '<td>';
                        if (data[i].Tel_No != null && data[i].CP_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No +
                                '<br>' +
                                'Cellphone: ' + data[i].CP_No;
                        } else if (data[i].Tel_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No;
                        } else if (data[i].CP_No != null) {
                            html +=
                                'Cellphone: ' + data[i].CP_No;
                        }
                html +=
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
                    '<td>';
                        if (data[i].Tel_No != null && data[i].CP_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No +
                                '<br>' +
                                'Cellphone: ' + data[i].CP_No;
                        } else if (data[i].Tel_No != null) {
                            html +=
                                'Telephone: ' + data[i].Tel_No;
                        } else if (data[i].CP_No != null) {
                            html +=
                                'Cellphone: ' + data[i].CP_No;
                        }
                html +=
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
            if(sy_check != 0 || sem_check != 0 || course_check != null){
                window.open(data_excel+'/'+sy_check+'/'+sem_check+'/'+course_check+'/Enrollment_Tracker');
            }else{
                console.log('No data');
            }
        });
        $("#inquiry_excel").on('click', function() {
            load_new_data();
            if(sy_check != 0 || sem_check != 0 || course_check != null){
                window.open(data_excel+'/'+sy_check+'/'+sem_check+'/'+course_check+'/Inquiry');
            }else{
                console.log('No data');
            }
        });
        $("#advised_excel").on('click', function() {
            load_new_data();
            if(sy_check != 0 || sem_check != 0 || course_check != null){
                window.open(data_excel+'/'+sy_check+'/'+sem_check+'/'+course_check+'/Advised');
            }else{
                console.log('No data');
            }
        });
        $("#reserved_excel").on('click', function() {
            load_new_data();
            if(sy_check != 0 || sem_check != 0 || course_check != null){
                window.open(data_excel+'/'+sy_check+'/'+sem_check+'/'+course_check+'/Reserved');
            }else{
                console.log('No data');
            }
        });
        $("#enrolled_excel").on('click', function() {
            load_new_data();
            if(sy_check != 0 || sem_check != 0 || course_check != null){
                window.open(data_excel+'/'+sy_check+'/'+sem_check+'/'+course_check+'/Enrolled');
            }else{
                console.log('No data');
            }
        });
    });
</script>