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
                                    <label for="data_from">Status</label>
                                    <select name="proof-status" class="form-control show-tick" data-live-search="true" tabindex="-98">
                                        <option value="ALL">ALL</option>
                                        <option value="0">Non Validated</option>
                                        <option value="1">Validated</option>
                                        <option value="-1">Rejected</option>
                                    </select>
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
                                <div class="body table-responsive" id="table-header-freeze">
                                    <table class="table table-bordered" id="proof_of_payment_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Reference Number</th>
                                                <th>Student Number</th>
                                                <th>Student Name</th>
                                                <th>Payment Type</th>
                                                <th>Bank Name</th>
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
<div class="modal fade" id="verifyProofModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel16">Verify Payment Amount</h4>
                <!-- <button type="button" class="close btn btn-sm btn-default" >
                Close
                </button> -->
            </div>
        <div class="modal-body row">
            <input type="hidden" id="req_id" value="">
            <div class="col-md-12">
                <input style="text-align:right;" type="text" id="proofOfPaymentAmount" class="form-control number-format" value="" tabindex="15">
            </div>
            <div class="col-md-12">
                <label class="input-label"></label>
                <input type="text" class="form-control" name="pp_school_year" value="" readonly>
            </div>
            <div class="col-md-12">
                <label class="input-label"></label>
                <input type="text" class="form-control" name="pp_semester" value="" readonly>
            </div>
            <br>
            <div class="col-md-12">
                <h5>Clarify Proof Of Payment Email Template</h5>
            </div>
            <div class="col-md-12">
                <textarea class="form-control" maxlength="300" id="clarify_email_message"></textarea><br>
                <!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> Add Proof Info Table -->
                <!-- <div class="checkbox">
                <input type="checkbox" checked data-toggle="toggle">
                </div> -->
            </div>            
        </div>
        <div class="modal-footer" align="right">
        <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button><button type="button" class="btn btn-danger" onclick="rejectProofofPayment()">Reject</button><button type="button" class="btn btn-warning" onclick="clarifyProofOfPayment()">Clarify</button><button class="btn btn-info" onclick="verifyProofofPayment()">Submit</button>
        </div>
    </div>
</div>
<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>
<script>
    $('#proofOfPaymentAmount').on('focus',function(){
        $('#proofOfPaymentAmount').select();
    })
    async function getProofInfo(req_id){
        return new Promise((resolve,reject)=>{
            $.ajax({
                type: "GET",
                url: base_url + "index.php/Treasury/getProofInfo",
                data: {
                    req_id: req_id
                },
                dataType: 'json',
                success: function(response) {
                    resolve(response)
                },
                error: function(response){
                    console.log(response)
                }
            });
        }).then(data=>{return data});
    }
    async function verifyPayment(req_id,amount){
        const info = await getProofInfo(req_id);
        $('input[name=pp_school_year]').val(info.school_year);
        $('input[name=pp_semester]').val(info.semester);
        $('#req_id').val(req_id)
        $('#proofOfPaymentAmount').val(parseFloat(amount).toFixed(2));
        $('#verifyProofModal').modal('show');
    }
    
    function rejectProofofPayment(){
        // alert('hello')
        // return false;
        iziToast.show({
            zindex:99999,
            theme: 'light',
            icon: 'icon-person',
            title: 'Are you sure you want to reject this?',
        //     message: 'Welcome!',
            position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: '#cc0000',
            overlay:true,
            timeout:false,
            buttons: [
                ['<button>Ok</button>', function (instance,toast,button,e,inputs) {
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
                        url: base_url + "index.php/Treasury/rejectProofOfPayment",
                        data: {
                            req_id: $('#req_id').val()
                        },
                        dataType: 'json',
                        success: function(response) {
                            if(response['msg']=="success"){
                                $('#proof_filter_button').trigger('click');
                                $('#verifyProofModal').modal('hide');
                                iziToast.show({
                                    theme:'light',
                                    title: '<i class="material-icons">task_alt</i> ',
                                    message: "<b>Successfully Rejected!</b>",
                                    position: 'topCenter',
                                });
                            }
                            else{
                                iziToast.warning({
                                    title: 'Error: ',
                                    message: response['msg'],
                                    position: 'topCenter',
                                });
                            }
                            $('body').waitMe('hide');
                        },
                        error: function(response){
                            $('body').waitMe('hide');
                            iziToast.warning({
                                title: 'Error: ',
                                message: response,
                                position: 'topCenter',
                            });
                        }
                    });
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                        onClosing: function(instance, toast, closedBy){
        //                     console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                        }
                    }, toast, 'buttonName');
                }, true]
            ],
            onOpening: function(instance, toast){
                console.info('callback abriu!');
            },
            onClosing: function(instance, toast, closedBy){
                console.info('closedBy: ' + closedBy);
            }
        });
    }
    function clarifyProofOfPayment(){
        // alert('hello')
        // return false;
        iziToast.show({
            zindex:99999,
            theme: 'light',
            icon: 'icon-person',
            title: 'Are you sure you want to clarify this proof of payment?',
        //     message: 'Welcome!',
            position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: '#cc0000',
            overlay:true,
            timeout:false,
            buttons: [
                ['<button>Ok</button>', function (instance,toast,button,e,inputs) {
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
                        url: base_url + "index.php/Treasury/clarifyProofOfPayment",
                        data: {
                            req_id: $('#req_id').val(),
                            message:$('#clarify_email_message').val()
                        },
                        dataType: 'json',
                        success: function(response) {
                            if(response['msg']=="success"){
                                $('#proof_filter_button').trigger('click');
                                $('#verifyProofModal').modal('hide');
                                iziToast.show({
                                    theme:'light',
                                    title: '<i class="material-icons">task_alt</i> ',
                                    message: "<b>Email has been sent to Student!</b>",
                                    position: 'topCenter',
                                });
                            }
                            else{
                                iziToast.warning({
                                    title: 'Error: ',
                                    message: response['msg'],
                                    position: 'topCenter',
                                });
                            }
                            $('body').waitMe('hide');
                        },
                        error: function(response){
                            $('body').waitMe('hide');
                            iziToast.warning({
                                title: 'Error: ',
                                message: response,
                                position: 'topCenter',
                            });
                        }
                    });
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                        onClosing: function(instance, toast, closedBy){
        //                     console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                        }
                    }, toast, 'buttonName');
                }, true]
            ],
            onOpening: function(instance, toast){
                console.info('callback abriu!');
            },
            onClosing: function(instance, toast, closedBy){
                console.info('closedBy: ' + closedBy);
            }
        });
    }
    function verifyProofofPayment(){
        
        iziToast.show({
            zindex:99999,
            theme: 'light',
            icon: 'icon-person',
            title: 'Are you sure you want to verify this proof of payment?',
        //     message: 'Welcome!',
            position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: '#cc0000',
            overlay:true,
            timeout:false,
            buttons: [
                ['<button>Ok</button>', function (instance,toast,button,e,inputs) {
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
                            req_id: $('#req_id').val(),
                            amount_paid:$('#proofOfPaymentAmount').val()
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            $('body').waitMe('hide');
                            console.log(response['error']==""?"":response['error'])
                            if(response['msg']=="success"){
                                $('#proof_filter_button').trigger('click');
                                $('#verifyProofModal').modal('hide');
                                iziToast.show({
                                    theme:'light',
                                    title: '<i class="material-icons">task_alt</i> ',
                                    message: "<b>You successfully verify a payment !</b>",
                                    position: 'topCenter',
                                });
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
                }, true]
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
                        status:$('select[name=proof-status]').val()
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
                                paging: true,
                                searching: true,
                                responsive: true,
                                lengthMenu:[[5,10,25,50,-1],[5,10,25,50,"All"]]
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
            console.log(response)
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
                term = value['file_submitted'].slice(0,2);
                console.log(term)
                const zeroPad = (num, places) => String(num).padStart(places, '0')
                if(term=="DP"||term=="PT"||term=="MT"||term=="FT"||term=="FP"){
                    proof_id = term+''+zeroPad(value['req_id'],6);
                }
                else{
                    proof_id = 'DP'+zeroPad(value['req_id'],6);
                }
                html +=
                    '<tr>' +
                    '<td>' +
                    proof_id +
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
                    value['payment_type'] +
                    '</td>' +
                    '<td>' +
                    value['bank_type'] +
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
                    '<td><a target="_blank" href="<?= base_url('index.php/Treasury/viewProofOfPaymentImage?id='); ?>'+value['req_id']+'">' +
                    '<button class="btn btn-info">View in GDrive</button>' +
                    '</a>';
                    if(value['proof_status']=='1'){
                        
                        html += '<br><br><button class="btn btn-default" disabled="disabled" style="color:green;">Verified <i class="material-icons">verified</i></button>'
                    }
                    else if(value['proof_status']=='-1'){
                        html += '<br><br><button class="btn btn-default" disabled="disabled" style="color:red;">Rejected <i class="material-icons">thumb_down_off_alt</i></button>'
                    }
                    else{
                        html += `<br><br><button type="button" class="btn btn-warning" onclick="verifyPayment('${value['req_id']}',${value['amount_paid']})">Verify</button>`;
                    }
                    
                    html += '</td>' +
                    '</tr>';
                count++;
            });
            return html;
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>


