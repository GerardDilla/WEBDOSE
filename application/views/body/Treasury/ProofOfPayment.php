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

    #filter_top {
        position: relative;
        top: -180px;
    }

    #table_top {
        position: relative;
        top: -100px;
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
                                    <label for="data_from">Format</label>
                                    <select name="date-format" class="form-control show-tick" data-live-search="true" tabindex="-98">
                                        <option value="Daily">Daily</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Monthly">Monthly</option>
                                    </select>
                                    <label class="daily" for="date_from">From:</label>
                                    <input type="date" id="date_from" class="form-control daily date-format" required>
                                    <label class="daily" for="data_to">To: </label>
                                    <input type="date" id="date_to" class="form-control daily date-format" required>
                                    <label class="monthly" for="date_from" style="display:none;">Month:</label>
                                    <input type="month" id="monthly" class="form-control monthly date-format" style="display:none;">
                                    <label class="weekly" for="data_to" style="display:none;">Week: </label>
                                    <input type="week" id="weekly" class="form-control weekly date-format" style="display:none;">
                                </div>
                                <br>
                                <button class="btn btn-lg btn-danger" id="proof_filter_button">Search</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" id="filter_top">
                                <div class="col-md-8">
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
                                                <th>Student Name</th>
                                                <th>Account Number</th>
                                                <th>Account Holder Name</th>
                                                <th>Receipt No.</th>
                                                <th>Amount</th>
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
<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>
<script>
    function verifyProofofPayment(req_id){
        iziToast.show({
            theme: 'light',
            icon: 'icon-person',
            title: 'Are you sure you want to verify this proof of payment?',
        //     message: 'Welcome!',
            position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: '#cc0000',
            overlay:true,
            timeout:false,
            buttons: [
                ['<button>Ok</button>', function (instance, toast) {
                    $('body').waitMe({
                        effect: 'win8',
                        text: 'Please wait...',
                        bg: 'rgba(255,255,255,0.7)',
                        color: '#cc0000',
                        maxSize: '',
                        waitTime: -1,
                        textPos: 'vertical',
                        fontSize: '',
                        source: '',
                        onClose: function() {

                        }
                    });
                    $.ajax({
                        type: "GET",
                        url: base_url + "index.php/Treasury/verifyProofofPayment",
                        data: {
                            req_id: req_id,
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('body').waitMe('hide');
                            console.log(response['error']==""?"":response['error'])
                            if(response['msg']=="success"){
                                $('#proof_filter_button').trigger('click');
                            }
                            else{
                                iziToast.warning({
                                    title: 'Error: ',
                                    message: response['msg'],
                                    position: 'topCenter',
                                });
                            }
                        },error:function(response){
                            $('body').waitMe('hide');
                            iziToast.warning({
                                title: 'Error: ',
                                message: response,
                                position: 'topCenter',
                            });
                        }
                    })
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                        onClosing: function(instance, toast, closedBy){
        //                     console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                        }
                    }, toast, 'buttonName');
                }, true], // true to focus
                ['<button>Close</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                        onClosing: function(instance, toast, closedBy){
        //                     console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                        }
                    }, toast, 'buttonName');
                }]
            ],
            onOpening: function(instance, toast){
                console.info('callback abriu!');
            },
            onClosing: function(instance, toast, closedBy){
                console.info('closedBy: ' + closedBy);
            }
        });
    }
    $(document).ready(function() {
        check_filter = "";

        function getDateOfWeek(w, y) {
            var d = (1 + (w - 1) * 7);
            var new_date = '' + new Date(y, 0, d);
            var split_var = new_date.split(" ");
            if (split_var[0] == "Sun") {
                var day = 0;
            } else if (split_var[0] == "Mon") {
                var day = 1;
            } else if (split_var[0] == "Tue") {
                var day = 2;
            } else if (split_var[0] == "Wed") {
                var day = 3;
            } else if (split_var[0] == "Thu") {
                var day = 4;
            } else if (split_var[0] == "Fri") {
                var day = 5;
            } else if (split_var[0] == "Sat") {
                var day = 6;
            }
            return new Date(y, 0, d - day);
        }
        
        function error_modal(title, msg) {
            iziToast.show({
                position: 'center',
                color: 'red',
                title: title,
                message: msg
            });
        }
        $('#monthly').on('change', function() {
            console.log(this.value)
        });
        $('#weekly').on('change', function() {
            date_val = this.value;
            var w = date_val.split('-');
            var y = w[1].split('W');
            var start_date = moment(new Date(Date.parse(getDateOfWeek(parseInt(y[1]) + 1, w[0])))).format('YYYY-MM-DD');
            var end_date = moment(new Date(Date.parse(getDateOfWeek(parseInt(y[1]) + 1, w[0])) + (86400000 * 6))).format('YYYY-MM-DD');
            $('#data_from').val(start_date);
            $('#data_to').val(end_date);
        })
        $('select[name=date-format]').on('change', function() {
            $('.weekly').hide();
            $('.daily').hide();
            $('.monthly').hide();
            $('.weekly').attr('required', false);
            $('.daily').attr('required', false);
            $('.monthly').attr('required', false);
            $('.date-format').val('');
            if (this.value == "Weekly") {
                $('.weekly').show();
                $('.weekly').attr('required', true);
            } else if (this.value == "Monthly") {
                $('.monthly').show();
                $('.monthly').attr('required', true);
            } else {
                $('.daily').show();
                $('.daily').attr('required', true);
            }
        })
        $("#proof_search_button").on('click', function() {
            if (check_filter != '') {
                $("#proof_of_payment_table").DataTable().search($("#proof_of_payment_table_search").val()).draw();
            } else {
                error_modal('Search First', 'You must SEACRH first before filtering');
            }
        });

        $('#proof_filter_button').on('click', function() {
            var from_date = $('#date_from').val();
            var to_date = $('#date_to').val();
            base_url = $('#base_url').data('baseurl');
            $data_table_var = $('#proof_of_payment_table');
            var empty_count = 0;
            $('.date-format[required]').each(function() {
                if (this.value == "") {
                    ++empty_count;
                }
            })
            if (empty_count > 0) {
                error_modal('Select Date', `You didn't pick TO: DATE ${empty_count}`);
            } else if (empty_count == 0) {
                if ($('select[name=date-format]').val() == "Monthly") {
                    from_date = $('#monthly').val();
                    to_date = '';
                }
                
                $.ajax({
                    type: "POST",
                    url: base_url + "index.php/Treasury/proof_of_payment_ajax",
                    data: {
                        from: from_date,
                        to: to_date,
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response)
                        // alert(response);
                        $data_table_var.DataTable().destroy();
                        $('#proof_of_payment_tbody').empty();
                        if ($.trim(response) != "") {


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
        $('.verify-proof-payment').on('click',function(){
            console.log('hesss')
        })
        function add_to_table_body(response) {
            html = "";
            count = 1;
            monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            $.each(response, function(key, value) {
                // console.log(value['proof_status']=='1'?'':'<button class="btn btn-info">Validate</button>');
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
                    value['First_Name'] + ' ' + value['Middle_Name'] + ' ' + value['Last_Name'] +
                    '</td>' +
                    '<td>' +
                    value['acc_num'] +
                    '</td>' +
                    '<td>' +
                    value['acc_holder_name'] +
                    '</td>' +
                    '<td>' +
                    value['payment_reference_no'] +
                    '</td>' +
                    '<td>' +
                    value['amount_paid'] +
                    '</td>' +
                    '<td>' +
                    month + " " + date + " " + year +
                    '</td>' +
                    '<td><a target="_blank" href="https://drive.google.com/drive/u/0/folders/' +
                    value['gdrive_folder_id'] + '">' +
                    '<button class="btn btn-info">View in GDrive</button>' +
                    '</a>';
                    if(value['proof_status']=='1'){
                        
                        html += '<br><button class="btn btn-default" disabled="disabled" style="color:green;">Verified <i class="material-icons">verified</i></button>'
                    }
                    else{
                        html += `<br><button type="button" class="btn btn-warning" onclick="verifyProofofPayment('${value['req_id']}')">Verify</button>`;
                    }
                    
                    html += '</td>' +
                    '</tr>';
                count++;
            });
            return html;
        }
    });
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script> -->


