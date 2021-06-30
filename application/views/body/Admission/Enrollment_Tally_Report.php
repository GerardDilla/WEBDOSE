<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
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

    .display_hidden {
        display: none;
    }

    .filter_table tr td {
        /* text-align: end; */
        padding: 5px;
    }


    #Search_button {
        position: relative;
        top: 5px;
    }

    .dataTables_filter,
    .dataTables_info {
        display: none;
    }

    #filter_top {
        position: relative;
        top: -180px;
    }

    #table_top {
        position: relative;
        top: -50px;
    }

    .card_position {
        position: relative;
        top: 15px;
    }

    @media screen and (max-width: 991px) {
        #filter_top {
            position: unset;
            top: 0;
        }

        #table_top {
            position: unset;
            top: 0;
        }

        #Search_button {
            float: left;
        }

    }
</style>
<section id="top" class="content" style="background-color: #fff;">
    <!-- CONTENT GRID-->
    <div class="container-fluid">
        <!-- MODULE TITLE-->
        <div class="block-header" id="base_url_js" data-baseurljs="<?php echo base_url(); ?>">
            <h1>Tally Report</h1>
        </div>
        <!--/ MODULE TITLE-->
        <div class="row clearfix" class='table_posiiton'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <!-- CONTENT START -->
                    <!-- CONTENT TABS -->
                    <ul class="nav nav-tabs tab-col-red" id="enrollment_tracker_tablist" role="enrollment_tracker_tablist">
                        <!-- <li class="nav-item active">
                            <a class="enrollment_summary_report-tab nav-link active" data-toggle="tab" href="#enrollment_summary_report" role="tab" aria-controls="enrollment_summary_report" aria-selected="true">
                                <h5>Enrollment Summary Report</h5>
                            </a>
                        </li> -->
                        <li class="nav-item active">
                            <a class="tally_program_report-tab nav-link" id="tally_program_report-tab" data-toggle="tab" href="#tally_program_report" role="tab" aria-controls="tally_program_report" aria-selected="false">
                                <h5>Tally Program Report</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="tally_city_report-tab nav-link" id="tally_city_report-tab" data-toggle="tab" href="#tally_city_report" role="tab" aria-controls="tally_city_report" aria-selected="false">
                                <h5>Tally City Report</h5>
                            </a>
                        </li>
                    </ul>
                    <!-- /CONTENT TABS -->

                    <div class="tab-content" id="">
                        <!--FIRST TAB-->
                        <div class="tab-pane fade active in" id="tally_program_report" role="tabpanel" aria-labelledby="tally_program_report-tab">
                            <div class="row clearfix card_position">
                                <div class="tab-content">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <h5>Choose Filter:</h5>
                                            <br>
                                            <div class="col-md-5" style="border-right:solid #ccc">
                                                <?php
                                                //SchoolYear Select
                                                $datestring = "%Y";
                                                $time = time();
                                                $year_now = mdate($datestring, $time);
                                                $options = array(

                                                    '0' => 'Select School Year',
                                                    ($year_now - 2) . "-" . ($year_now - 1) => ($year_now - 2) . "-" . ($year_now - 1),
                                                    ($year_now - 1) . "-" . $year_now => ($year_now - 1) . "-" . $year_now,
                                                    $year_now . "-" . ($year_now + 1) => $year_now . "-" . ($year_now + 1),
                                                    ($year_now + 1) . "-" . ($year_now + 2) => ($year_now + 1) . "-" . ($year_now + 2)

                                                );
                                                $js = array(
                                                    'id' => 'sy_program_tally',
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
                                                    'id' => 'sem_program_tally',
                                                );
                                                $options =  array(
                                                    '0'        => 'Select Semester',
                                                    'FIRST'   => 'FIRST',
                                                    'SECOND'  => 'SECOND',
                                                    'SUMMER'  => 'SUMMER',
                                                );
                                                echo form_dropdown('sem', $options, $this->input->post('sem'), $class);
                                                ?>
                                                <!-- <select tabindex="2" class="form-control show-tick" data-live-search="true" name="course" id="course_program_tally">
                                                    <option disabled selected>Select Course:</option>
                                                    <?php foreach ($this->data['get_course']->result_array() as $row) { ?>
                                                        <?php if ($this->input->post('course') ==  $row['Program_Code']) : ?>
                                                            <option selected><?php echo $row['Program_Code']; ?></option>
                                                        <?php else : ?>
                                                            <option><?php echo $row['Program_Code']; ?></option>
                                                        <?php endif ?>
                                                    <?php } ?>
                                                </select> -->
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" id="program_tally_filter" name="search_button" class="btn btn-lg btn-danger"> Search </button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
                                                        Tally Program Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-primary excel_button_right" id="tally_program_export" type="submit" name="export" value="Export"> Word Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="tally_program_preloader">
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
                                                        <table class="table table-bordered" id="data_table_tally">
                                                            <thead>
                                                                <tr>
                                                                    <th>Course</th>
                                                                    <th>Inquired</th>
                                                                    <th>Advised</th>
                                                                    <th>Reserved</th>
                                                                    <th>Enrolled</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="data_table_tally_tbody">
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
                        <!--/FIRST TAB END-->
                        <!--SECOND TAB-->
                        <div class="tab-pane fade" id="tally_city_report" role="tabpanel" aria-labelledby="tally_city_report-tab">
                            <div class="row clearfix card_position">
                                <div class="tab-content">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <h5>Choose Filter:</h5>
                                            <br>
                                            <div class="col-md-5" style="border-right:solid #ccc">
                                                <?php
                                                //SchoolYear Select
                                                $datestring = "%Y";
                                                $time = time();
                                                $year_now = mdate($datestring, $time);
                                                $options = array(

                                                    '0' => 'Select School Year',
                                                    ($year_now - 2) . "-" . ($year_now - 1) => ($year_now - 2) . "-" . ($year_now - 1),
                                                    ($year_now - 1) . "-" . $year_now => ($year_now - 1) . "-" . $year_now,
                                                    $year_now . "-" . ($year_now + 1) => $year_now . "-" . ($year_now + 1),
                                                    ($year_now + 1) . "-" . ($year_now + 2) => ($year_now + 1) . "-" . ($year_now + 2)

                                                );
                                                $js = array(
                                                    'id' => 'sy_city_tally',
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
                                                    'id' => 'sem_city_tally',
                                                );
                                                $options =  array(
                                                    '0'        => 'Select Semester',
                                                    'FIRST'   => 'FIRST',
                                                    'SECOND'  => 'SECOND',
                                                    'SUMMER'  => 'SUMMER',
                                                );
                                                echo form_dropdown('sem', $options, $this->input->post('sem'), $class);
                                                ?>
                                                <!-- <select tabindex="2" class="form-control show-tick" data-live-search="true" name="province" id="province_tally">
                                                    <option disabled selected>Select Province:</option>
                                                    <?php foreach ($this->data['get_province']->result_array() as $row) { ?>
                                                        <option value="<?php echo $row['provCode']; ?>"><?php echo $row['provDesc']; ?></option>
                                                    <?php } ?>
                                                </select> -->
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" id="tally_city_filter" name="search_button" class="btn btn-lg btn-danger"> Search </button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
                                                        Tally City Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-primary excel_button_right" id="tally_city_export" type="submit" name="export" value="Export"> Word Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="tally_city_preloader">
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
                                                        <table class="table table-bordered" id="data_table_tally_city">
                                                            <thead>
                                                                <tr>
                                                                    <th>City</th>
                                                                    <th>Inquiry</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="data_table_tally_city_tbody">
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
                        <!--/SECOND TAB END-->
                    </div>

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
    base_url = $('#privacy_base_url').val();
    program_tally_search = 0;
    city_tally_search = 0;
    // console.log(base_url);
    $(document).ready(function() {
        function izi_toast(title, msg, color) {
            iziToast.show({
                position: 'topCenter',
                color: color,
                title: title,
                message: msg
            });
        }
        // Search_button

        $('#program_tally_filter').on('click', function() {
            // alert($('#sy_program_tally').val())
            academic_year = $('#sy_program_tally').val()
            // alert($('#sem_enrollment_tracker').val())
            semester = $('#sem_program_tally').val()
            // alert($('#course_program_tally').val())
            // program = $('#course_program_tally').val()
            // console.log(academic_year + " " + semester+ " " + program);
            if (!academic_year || academic_year == 0) {
                izi_toast('Oops!', 'You DID NOT pick Academic Year.', 'red');
            } else {
                city_tally_search = 1;
                $('#tally_program_preloader').show();
                $('#data_table_tally_tbody').empty();
                $.ajax({
                    method: 'POST',
                    url: 'Count_Program_Tally',
                    data: {
                        sy: academic_year,
                        sem: semester,
                        // course: program,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        html = '';
                        inquiry = 0;
                        advised = 0;
                        reserved = 0;
                        enrolled = 0;
                        $.each(response, function(key, value) {
                            // alert(key + ": " + value);

                            // if (program != null) {
                            //     if (key == program) {
                            //         html += '<tr>' +
                            //             '<td>' + key + '</td>' +
                            //             '<td>' + value[0][0] + '</td>' +
                            //             '<td>' + value[0][1] + '</td>' +
                            //             '<td>' + value[0][1] + '</td>' +
                            //             '</tr>';
                            //     }
                            // } else {
                            html += '<tr>' +
                                '<td>' + key + '</td>' +
                                '<td>' + value[0][0] + '</td>' +
                                '<td>' + value[0][1] + '</td>' +
                                '<td>' + value[0][2] + '</td>' +
                                '<td>' + value[0][3] + '</td>' +
                                '</tr>';
                            // }
                            inquiry += value[0][0];
                            advised += value[0][1];
                            reserved += value[0][2];
                            enrolled += value[0][3];
                        });
                        html += '<tr>' +
                                '<td><b>Total</b></td>' +
                                '<td>' + inquiry + '</td>' +
                                '<td>' + advised + '</td>' +
                                '<td>' + reserved + '</td>' +
                                '<td>' + enrolled + '</td>' +
                                '</tr>';

                        $('#data_table_tally_tbody').html(html);
                    },
                    complete: function() {
                        $('#tally_program_preloader').hide();
                    }

                })
            }
        })

        $('#tally_city_filter').on('click', function() {
            academic_year = $('#sy_city_tally').val() // 0
            semester = $('#sem_city_tally').val() // 0
            if (!academic_year || academic_year == 0) {
                izi_toast('Oops!', 'You DID NOT pick Academic Year.', 'red');
            } else {
                city_tally_search = 1;
                $('#tally_city_preloader').show();
                $('#data_table_tally_city_tbody').empty();
                $.ajax({
                    method: 'POST',
                    url: 'Count_City_Tally',
                    data: {
                        sy: academic_year,
                        sem: semester,
                        // prov_code: province_code,
                        // prov_desc: province_desc,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        html = '';
                        $.each(response, function(key, value) {
                            // alert(key + ": " + value);
                            // console.log(key +' , '+province_desc);
                            // if (key == province_desc) {
                            html += '<tr>' +
                                // '<td>' + key + '</td>' +
                                '<td>' + value['Address_City'] + '</td>' +
                                '<td>' + value['count_student'] + '</td>' +
                                // '<td>' + value[0][1] + '</td>' +
                                '</tr>';
                            // }
                        });
                        // console.log(html);
                        $('#data_table_tally_city_tbody').html(html);
                    },
                    complete: function() {
                        $('#tally_city_preloader').hide();
                    }
                })
            }
        })

        $('#tally_program_export').on('click', function() {
            academic_year = $('#sy_program_tally').val()
            semester = $('#sem_program_tally').val()
            if (city_tally_search != 0) {
                if (academic_year || academic_year != 0) {
                    window.open('Program_Word_Export/' + academic_year + '/' + semester, '_blank');
                } else {
                    izi_toast('Oops!', 'You DID NOT pick Academic Year.', 'red');
                }
            } else {
                izi_toast('Oops!', 'Must Search first.', 'red');
            }
        })
        $('#tally_city_export').on('click', function() {
            academic_year = $('#sy_city_tally').val()
            semester = $('#sem_city_tally').val()
            if (city_tally_search != 0) {
                if (academic_year || academic_year != 0) {
                    window.open('City_Word_Export/' + academic_year + '/' + semester, '_blank');
                } else {
                    izi_toast('Oops!', 'You DID NOT pick Academic Year.', 'red');
                }
            } else {
                izi_toast('Oops!', 'Must Search first.', 'red');
            }
        })

    });
</script>