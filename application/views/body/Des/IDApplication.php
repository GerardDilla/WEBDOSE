<style>
    .checked_form {
        background-color: rgba(193, 255, 193, 1) !important;
    }

    .checked_form:hover {
        background-color: rgba(137, 251, 137, 1) !important;
    }
</style>
<section id="top" class="content admin_id-selection" style="background-color: #fff;">
    <!-- CONTENT GRID-->
    <div class="container-fluid">

        <!-- MODULE TITLE-->
        <div class="block-header">
            <h1> <i class="material-icons" style="font-size:100%">label</i>ID Application</h1>
        </div>
        <!--/ MODULE TITLE-->
        <?php
        $id_msg = "     Hi, This is ____ from the Digital Education Solutions unit of the ICT Department.
    We are glad to inform you that we have successfully printed your ID, you may now claim it at DES Office located at the Computer Laboratory 2, 5th Floor, GD 1 Should you have any concerns, please don't hesitate to email us.

";
        ?>
        <div>
            <textarea id="id_msg" class="form-control id_msg" rows="3" placeholder="<?php echo $id_msg ?>"></textarea>
        </div>
        <div class="card">
            <div class="body">
                <div class="card-body table-responsive">
                    <table id="idApplicationTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Name (Last, First Middle)</th>
                                <th>Reference Number</th>
                                <th>Student Number</th>
                                <th>Course</th>
                                <th>Address</th>
                                <th>Guardian Name</th>
                                <th>Guardian Contact</th>
                                <!-- <th>Guardian Email</th> -->
                                <th>Email</th>
                                <th width="5%">To Gdrive</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="adminIdTbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/CONTENT GRID-->
</section>
<script src="<?php echo base_url('plugins/waitme/waitMe.js'); ?>"></script>
<script>
    ajax_id();

    function id_update_status(id) {
        switch_id = $('#switch' + id);
        tr_switch_id = $('#tr-switch' + id);
        student_name = switch_id.data('student_name_' + id);
        // console.log(switch_id);
        // console.log(switch_id.prop("checked"));
        // switch_id.removeClass('checked');
        // switch_value = switch_id.val();
        // account_id = switch_id.data(switch_value);
        q_title = '';
        q_msg = '';
        if (switch_id.prop("checked")) {
            q_msg = '<b style="font-size:20px;color:black;">Are you sure this student is done?</b><br>' +
                '<span style="font-size:15px;color:black">' +
                '<span style="color:red"><b>NOTE</b></span>' +
                ': This action will send an <span style="color:red"><b>EMAIL</b></span> to the student.<br><br>' +
                'Student (Last, First Middle) : ' +
                '<span style="font-size:15px;color:black"><b><u>' +
                student_name +
                '</u></b></span>' +
                '</span><br><br>';
        } else {
            q_msg = '<b style="font-size:20px;color:black;">Are you sure you want to uncheck this user?</b><br>';
            q_msg += '<span style="font-size:15px;color:black">' +
                '<span style="color:red;">NOTE</span>: This will not unsent the sent email for this user.' +
                '</span><br><br>';
            q_msg += '<span style="font-size:15px;color:black">' +
                'Student (Last, First Middle) : ' +
                '<span style="font-size:15px;color:black"><b><u>' +
                student_name +
                '</u></b></span>' +
                // 'This action will send an <span style="color:red"><b>EMAIL</b></span> that his/her ID is done.'+
                '</span><br><br>';
        }


        iziToast.question({
            timeout: false,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: q_title,
            message: q_msg,
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function(instance, toast) {
                    if (switch_id.prop("checked")) {
                        status = 'done';
                        tr_switch_id.addClass('checked_form');
                        switch_id.prop('checked', true);
                    } else {
                        status = 'pending';
                        tr_switch_id.removeClass('checked_form');
                        switch_id.prop('checked', false);
                    }
                    $('.admin_id-selection').waitMe({
                        effect: 'bounce',
                        text: 'Email is Sending Please Wait..',
                        bg: 'rgba(255, 255, 255, 0.7)',
                        color: '#000',
                        maxSize: '',
                        waitTime: '-1',
                        textPos: 'horizontal',
                        fontSize: '',
                        source: '',
                        onClose: function() {}
                    });
                    $.ajax({
                        url: 'updateIdApplication',
                        dataType: 'json',
                        method: 'post',
                        // async: false,
                        data: {
                            'id_application': id,
                            'status': status,
                            'custom_msg': $('#id_msg').val()
                        },
                        success: function(response) {
                            // alert(response);

                        },
                        complete: function() {
                            // alert('Done');
                            $('.admin_id-selection').waitMe('hide');
                        }
                    })

                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');

                }, true],
                ['<button>NO</button>', function(instance, toast) {
                    if (switch_id.prop("checked")) {
                        switch_id.prop('checked', false);
                    } else {
                        switch_id.prop('checked', true);
                    }
                    // switch_id.prop('checked', false);

                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');

                    return;
                }],
            ],
            onClosing: function(instance, toast, closedBy) {
                console.info('Closing | closedBy: ' + closedBy);
            },
            onClosed: function(instance, toast, closedBy) {
                console.info('Closed | closedBy: ' + closedBy);
            }
        });
    }

    function ajax_id() {
        $.ajax({
            url: 'getIdApplication',
            dataType: 'json',
            success: function(response) {
                $.each(response, function(key, value) {
                    student_name = value['Last_Name'] + ', ' + value['First_Name'] + ' ' + value['Middle_Name'];
                    if(value['Address_Country'] != ''){
                        country = '';
                    }else{
                        country = value['Address_Country'];
                    }
                    $address = value['Address_No'] + ' ' + value['Address_Street'] + ' ' + value['Address_Subdivision'] + ', ' + value['Address_Barangay'] + ' ' + value['Address_City'] + ' ' + value['Address_Province'] + ' ' + country + ', ' + value['Address_Zip'] 
                    checked = '';
                    class_check = '';
                    if (value['status'] == 'done') {
                        checked = 'checked';
                        class_check = ' class="checked_form"';
                    }
                    html = '<tr ' + class_check + 'id="tr-switch' + value['id'] + '">';
                    html += '<td>' +
                        value['status'].toUpperCase() +
                        '</td>';
                    html += '<td>' +
                        student_name +
                        '</td>' +
                        '<td>' +
                        value['Student_Number'] +
                        '</td>' +
                        '<td>' +
                        value['Course'] +
                        '</td>' +
                        '<td>' +
                        'Address' +
                        // value['Student_Number'] +
                        '</td>' +
                        '<td>' +
                        value['Guardian_Name'] +
                        '</td>' +
                        '<td>' +
                        value['Guardian_Contact'] +
                        '</td>' +
                        '<td>' +
                            value['Email'] +
                        '</td>'+
                        '<td>' +
                        '<a href="https://drive.google.com/drive/folders/' + value['gdrive_folder_id'] + '" target="_blank">' +
                        '<button class="btn action_button">Link</button>' +
                        '</a>' +
                        '</td>';
                    html += '<td>' +
                        '<button class="btn action_button-error" onclick="ajax_id_error(' + value['id'] + ')">Error</button>' +
                        '</td>';
                    html += '<td><label class="switch">' +
                        '<input type="checkbox" ' + checked + ' data-student_name_' + value['id'] + '="' + student_name + '" id="switch' + value['id'] + '" onclick="id_update_status(' + value['id'] + ')">' +
                        '<span class="slider round"></span>' +
                        '</label>' +
                        '</td>';
                    html += '</tr>';
                    $('#adminIdTbody').append(html);
                });
                // $('#idApplicationTable').DataTable({
                //     "paging": false,
                //     "ordering": false,
                //     "info": false
                // });
            }
        })
    }

    function ajax_id_error(id) {
        $.ajax({
            url: 'idApplicationError',
            dataType: 'json',
            method: 'post',
            data: {
                'id_application': id,
            },
            success: function(response) {}
        })
    }
</script>