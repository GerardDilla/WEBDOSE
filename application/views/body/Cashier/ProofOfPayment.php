<style>
    .display_hidden {
        display: none;
    }

    .filter_table tr td {
        text-align: end;
        padding: 5px;
    }

    .filter_table {
        margin-left: 0 auto;
        float: right;
    }
</style>
<section id="top" class="content">
    <div class="container-fluid" id="base_url" data-baseurl="<?php echo base_url(); ?>">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header" style="background-color: #F44336;">
                        <h1 style="color:white">
                            Proof of Payments Report
                        </h1>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-11">
                                <table class="filter_table">
                                    <tr>
                                        <td style="border-right:solid #ccc"><label for="data_from">From:</label></td>
                                        <td><input type="date" id="data_from" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td style="border-right:solid #ccc"><label for="data_to">To: </label></td>
                                        <td style="border-right:solid #ccc"><input type="date" id="data_to" class="form-control"></td>
                                        <td><button class="btn btn-lg btn-danger" id="proof_filter_button">Filter</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <br>
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
                            <div class="col-md-12">
                                <div class="body table-responsive" style="overflow:auto; max-height:400px" id="table-header-freeze">
                                    <table class="table table-bordered" style="width: 1750px;" id="proof_of_payment_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Action</th>
                                                <th>Reference Number</th>
                                                <th>Date Uploaded</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>

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
    $('#proof_filter_button').on('click', function() {
        from_date = $('#data_from').val();
        to_date = $('#data_to').val();
        base_url = $('#base_url').data('baseurl');
        if (!from_date && !to_date) {
            alert("You didn't pick any DATEs");
        } else if (!from_date) {
            alert("You didn't pick FROM: DATE");
        } else if (!to_date) {
            alert("You didn't pick TO: DATE");
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
                        $data_table_var = $('#proof_of_payment_table');
                        $data_table_var.DataTable().destroy();
                        html = add_to_table_body(response);
                        $('#proof_of_payment_tbody').html(html);

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
                '<td><a target="_blank" href="https://drive.google.com/drive/folders/' + value['gdrive_id'] + '">' +
                '<button class="btn btn-lrg btn-info">View in GDrive</button>' +
                '</a>' +
                '</td>' +
                '<td>' +
                value['Reference_Number'] +
                '</td>' +
                '<td>' +
                month + " " + date + " " + year +
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
                '</tr>';
            count++;
        });
        return html;
    }
</script>