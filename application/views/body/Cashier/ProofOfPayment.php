<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
<style>
    .display_hidden {
        display: none;
    }

    .filter_table tr td {
        /* text-align: end; */
        padding: 5px;
    }

    #proof_filter_button {
        float: right;
    }

    #proof_search_button {
        position: relative;
        top: 5px;
    }

    .dataTables_filter,
    .dataTables_info {
        display: none;
    }

    #filter_top{
        position: relative;
        top: -180px;
    }
    #table_top{
        position: relative;
        top: -100px;
    }

    @media screen and (max-width: 991px) {
        #filter_top{
        position: unset;
        top: 0;
    }
    #table_top{
        position: unset;
        top: 0;
    }
        
    }
</style>
<section id="top" class="content">
    <div class="container-fluid" id="base_url" data-baseurl="<?php echo base_url(); ?>">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h3>
                            Proof of Payments Report
                        </h3>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-8">

                            </div>
                            <div class="col-md-4">
                                <div class="filter_table">
                                    <label for="data_from">From:</label>
                                    <input type="date" id="data_from" class="form-control">
                                    <label for="data_to">To: </label>
                                    <input type="date" id="data_to" class="form-control">

                                </div>
                                <br>
                                <button class="btn btn-lg btn-danger" id="proof_filter_button">Search</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" id="filter_top">
                                <div class="col-md-8" >
                                    <!-- <label for="proof_of_payment_table_search">Search on TABLE</label> -->
                                    <input type="text" class="form-control" id="proof_of_payment_table_search" placeholder="Search on TABLE">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-lg btn-info" id="proof_search_button">Filter</button>
                                </div>
                            </div>
                            <div class="col-md-8">
                            </div>

                        </div>
                        <div class="row">
                            <div class="display_hidden" id="proof_of_payment_preloader">
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
                            <div class="col-md-12" id="table_top">
                                <div class="body table-responsive" style="overflow:auto; max-height:400px" id="table-header-freeze">
                                    <table class="table table-bordered" id="proof_of_payment_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Reference Number</th>
                                                <th>Student Number</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Date Uploaded</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id="proof_of_payment_tbody">

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
</section>
<script>
    $(document).ready(function() {
        check_filter = "";

        function error_modal(title, msg) {
            iziToast.show({
                position: 'center',
                color: 'red',
                title: title,
                message: msg
            });
        }
        $("#proof_search_button").on('click', function() {
            if (check_filter != '') {
                $("#proof_of_payment_table").DataTable().search($("#proof_of_payment_table_search").val()).draw();
            } else {
                error_modal('Search First', 'You must SEACRH first before filtering');
            }
        });

        $('#proof_filter_button').on('click', function() {
            from_date = $('#data_from').val();
            to_date = $('#data_to').val();
            base_url = $('#base_url').data('baseurl');
            $data_table_var = $('#proof_of_payment_table');
            if (!from_date && !to_date) {
                error_modal('Select Date', "You didn't pick any DATEs");
            } else if (!from_date) {
                error_modal('Select Date', "You didn't pick FROM: DATE");
            } else if (!to_date) {
                error_modal('Select Date', "You didn't pick TO: DATE");
            } else {
                $.ajax({
                    type: "POST",
                    url: base_url + "index.php/Cashier/proof_of_payment_ajax",
                    data: {
                        from: from_date,
                        to: to_date,
                    },
                    dataType: 'json',
                    success: function(response) {
                        // alert(response);
                        // console.log(response);
                        if ($.trim(response) != "") {

                            $data_table_var.DataTable().destroy();
                            html = add_to_table_body(response);
                            $('#proof_of_payment_tbody').html(html);
                            check_filter = 1;
                            $data_table_var.DataTable({
                                paging: false,
                                searching: true,
                                responsive: false,
                            });
                        } else {
                            // none
                        }
                    },
                })
            }
        })

        function add_to_table_body(response) {
            html = "";
            count = 1;
            monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            $.each(response, function(key, value) {
                // alert(key + ": " + value['Reference_Number']);
                datetime = new Date(value['requirements_date']);

                date = datetime.getDate().toString();
                month = monthNames[datetime.getMonth()].toString();
                year = datetime.getFullYear().toString();

                html +=
                    '<tr>' +
                    '<td>' +
                    count +
                    '</td>' +
                    '<td>' +
                    value['Reference_Number'] +
                    '</td>' +
                    '<td>';
                if (value['Student_Number'] == 0) {
                    html += 'N/A'
                } else {
                    html += value['Student_Number'];
                }
                html +=
                    '</td>' +
                    '<td>' +
                    value['First_Name'] +
                    '</td>' +
                    '<td>' +
                    value['Middle_Name'] +
                    '</td>' +
                    '<td>' +
                    value['Last_Name'] +
                    '</td>' +
                    '<td>' +
                    month + " " + date + " " + year +
                    '</td>' +
                    '<td><a target="_blank" href="https://drive.google.com/drive/folders/' +
                    value['gdrive_id'] + '">' +
                    '<button class="btn btn-lrg btn-info">View in GDrive</button>' +
                    '</a>' +
                    '</td>' +
                    '</tr>';
                count++;
            });
            return html;
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>