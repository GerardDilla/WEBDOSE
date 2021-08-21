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
        
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <!-- <div class="row"> -->
            <h5>Choose Filter:</h5>
            <form action="<?php echo base_url(); ?>index.php/Des/id_application" method="post">
                <div class="col-md-8">
                    <table>
                        <tr>
                            <td>
                                <label for="inquiry_from">From: </label>
                                <?php if (!empty($this->input->post('inquiry_from'))) : ?>
                                    <input type="date" id="inquiry_from" class="form-control" name="inquiry_from" data-date-format="yyyy-mm-dd" value="<?php echo $this->input->post('inquiry_from'); ?>">
                                <?php else : ?>
                                    <input type="date" id="inquiry_from" class="form-control" name="inquiry_from" data-date-format="yyyy-mm-dd">
                                <?php endif ?>
                            </td>
                            <td>
                                <!-- <button>Clear</button> -->
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="inquiry_to">To: </label>
                                <?php if (!empty($this->input->post('inquiry_to'))) : ?>
                                    <input type="date" id="inquiry_to" class="form-control" name="inquiry_to" data-date-format="yyyy-mm-dd" value="<?php echo $this->input->post('inquiry_to'); ?>">
                                <?php else : ?>
                                    <input type="date" id="inquiry_to" class="form-control" name="inquiry_to" data-date-format="yyyy-mm-dd">
                                <?php endif ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inquiry_to">Reference / Student No.: </label>
                                <?php if (!empty($this->input->post('identity_no'))) : ?>
                                    <input type="text" id="identity_no" class="form-control" name="identity_no" value="<?php echo $this->input->post('identity_no'); ?>">
                                <?php else : ?>
                                    <input type="text" id="identity_no" class="form-control" name="identity_no">
                                <?php endif ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <hr>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-4">
                    <br>
                    <button type="submit" name="search_button" value="search_button" class="btn btn-lg btn-danger"> Search </button>
                    <br><br>
                    <button class="btn btn-lg  btn-success" type="submit" name="export" value="export"> Excel </button>
                </div>
            </form>
            <!-- </div> -->
        </div>
        
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
                            <?php

                            foreach ($this->data['student'] as $student) {
                                // echo $student;
                                $student_name = $student['Last_Name'] + ', ' + $student['First_Name'] + ' ' + $student['Middle_Name'];
                                if ($student['Address_Country'] != '') {
                                    $country = '';
                                } else {
                                    $country = $student['Address_Country'];
                                }
                                $address = $student['Address_No'] + ' ' + $student['Address_Street'] + ' ' + $student['Address_Subdivision'] + ', ' + $student['Address_Barangay'] + ' ' + $student['Address_City'] + ' ' + $student['Address_Province'] + ' ' + $country + ', ' + $student['Address_Zip'];
                                $checked = '';
                                $class_check = '';
                                if ($student['status'] == 'done') {
                                    $checked = 'checked';
                                    $class_check = ' class="checked_form"';
                                }
                                echo '<tr ' . $class_check . 'id="tr-switch' . $student['id'] . '">
                                <td>' .
                                    strtoupper($student['status']) .
                                    '</td>
                                    <td>' .
                                    $student_name .
                                    '</td>
                                    <td>' .
                                    $student['Reference_Number'] .
                                    '</td>
                                    <td>' .
                                    $student['Student_Number'] .
                                    '</td>
                                    <td>' .
                                    $student['Course'] .
                                    '</td>
                                    <td>' .
                                    $address .
                                    '</td>
                                    <td>' .
                                    $student['Guardian_Name'] .
                                    '</td>
                                    <td>' .
                                    $student['Guardian_Contact'] .
                                    '</td>
                                    <td>' .
                                    $student['Email'] .
                                    '</td>
                                    <td>
                                    <a href="https://drive.google.com/drive/folders/' . $student['gdrive_folder_id'] . '" target="_blank">
                                    <button class="btn action_button">Link</button>
                                    </a>
                                    </td>
                                    <td>
                                <button class="btn action_button-error" onclick="ajax_id_error(' . $student['id'] . ')">Error</button>
                                    </td>
                                    <td><label class="switch">
                                <input type="checkbox" ' . $checked . ' data-student_name_' . $student['id'] . '="' . $student_name . '" id="switch' . $student['id'] . '" onclick="id_update_status(' . $student['id'] . ')">
                                    <span class="slider round"></span>
                                    </label>
                                    </td>
                                    </tr>';
                            }


                            ?>
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
    // ajax_id();

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

    function ajax_search() {
        $.ajax({
            url: 'getIdApplication',
            type: 'POST',
            data: {
                from: asdsa,
                to: asdsa,
                refno: asdasa,
            },
            dataType: 'json',
            success: function(response) {
                $('#adminIdTbody').empty();
                $html = table_data(response);
                $('#adminIdTbody').append(html);
            }
        })
    }

    function ajax_id() {
        $.ajax({
            url: 'getIdApplication',
            dataType: 'json',
            success: function(response) {
                $('#adminIdTbody').empty();
                $html = table_data(response);
                $('#adminIdTbody').append(html);
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

    function table_data(response) {
        $.each(response, function(key, value) {
            student_name = value['Last_Name'] + ', ' + value['First_Name'] + ' ' + value['Middle_Name'];
            if (value['Address_Country'] != '') {
                country = '';
            } else {
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
                value['Reference_Number'] +
                '</td>' +
                '<td>' +
                value['Student_Number'] +
                '</td>' +
                '<td>' +
                value['Course'] +
                '</td>' +
                '<td>' +
                $address +
                '</td>' +
                '<td>' +
                value['Guardian_Name'] +
                '</td>' +
                '<td>' +
                value['Guardian_Contact'] +
                '</td>' +
                '<td>' +
                value['Email'] +
                '</td>' +
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
            return html;
        });
    }
</script>