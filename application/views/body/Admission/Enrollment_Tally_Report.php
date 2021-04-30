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
                            <a class="tally_student_report-tab nav-link" id="tally_student_report-tab" data-toggle="tab" href="#tally_student_report" role="tab" aria-controls="tally_student_report" aria-selected="false">
                                <h5>Tally Program Report</h5>
                            </a>
                        </li>
                    </ul>
                    <!-- /CONTENT TABS -->

                    <div class="tab-content" id="">

                        <!--FIRST TAB END-->
                        <div class="tab-pane fade active in" id="tally_student_report" role="tabpanel" aria-labelledby="tally_student_report-tab">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-8">

                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <div class="filter_table">
                                                <label for="date_from">From:</label>
                                                <input type="date" id="date_from" class="form-control">
                                                <label for="date_to">To: </label>
                                                <input type="date" id="date_to" class="form-control">

                                            </div>
                                            <br>
                                            <button class="btn btn-lg btn-danger" id="Search_button">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix card_position">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2>
                                                        Tally Program Report <br>
                                                    </h2>
                                                </div>
                                                <button class="btn btn-lg  btn-success excel_button_right" id="tally_excel" type="submit" name="export" value="Export"> Export </button>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="display_hidden" id="tally_preloader">
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
                                                                    <th>Count</th>
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
        $('#Search_button').on('click', function() {
            date_from = $('#date_from').val();
            console.log(!date_from)
            date_to = $('#date_to').val();

            if (!date_from && !date_to) {
                izi_toast('Oops!', 'You pick DATEs first.', 'red');
            } else if (!date_from) {
                izi_toast('Oops!', 'Please pick FROM DATE.', 'red');
            } else if (!date_to) {
                izi_toast('Oops!', 'Please pick TO DATE.', 'red');
            } else {
                $.ajax({
                    method: 'POST',
                    url: 'Count_Tally',
                    data: {
                        from: date_from,
                        to: date_to,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        html = '';
                        $.each(response, function(key, value) {
                            // alert(key + ": " + value);
                            html += '<tr>' +
                                '<td>' + key + '</td>' +
                                '<td>' + value + '</td>' +
                                '</tr>';
                        });

                        $('#data_table_tally_tbody').html(html);
                    }

                })
            }
        })
    });
</script>