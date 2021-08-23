<section id="top" class="content" style="background-color: #fff;">
    <!-- CONTENT GRID-->
    <div class="container-fluid">

        <!-- MODULE TITLE-->
        <div class="block-header">
            <h1> <i class="material-icons" style="font-size:100%">label</i>Digital Citizenship</h1>
        </div>
        <!--/ MODULE TITLE-->

        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <!-- <div class="row"> -->
            <h5>Choose Filter:</h5>
            <form action="<?php echo base_url(); ?>index.php/Des/digital_citizenship" method="post">
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

        <!-- <div class="card"> -->
            <div class="body">
                <div>
                    <div id="sdcapassword"></div>
                </div>
                <table id="chatInquiryTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name (Last, First Middle)</th>
                            <th>Course</th>
                            <th>Student Number</th>
                            <th>Emails for Account</th>
                            <th>Posible Password</th>
                            <!-- <th>Action</th> -->
                            <!-- <th width="15%">Blackboard Account</th>
                            <th width="15%">Microsoft Office 365</th>
                            <th width="15%">SDCA Gmail Account</th>
                            <th width="15%">Student Portal</th> -->
                        </tr>
                    </thead>
                    <tbody id="adminDigitalTbody">
                        <?php
                        foreach ($this->data['student'] as $student) {
                        $year = '';
                        $date_created = $student['created_at'];
                        $year = Date('Y');
                        // ajax_digital_account(value);
                        $sdca_email = '';
                        $replace_regex = '/\s+/';
                        $sdca_email = preg_replace($replace_regex, '', $student['First_Name']) . preg_replace($replace_regex, '', $student['Last_Name']) . '@sdca.edu.ph';
                        // console.log(sdca_email);
                        echo '<tr>
                            <td>' .
                            $student['Last_Name'] . ', ' . $student['First_Name'] . ' ' . $student['Middle_Name'] .
                            '</td>
                            <td>' .
                            $student['Course'] .
                            '</td>
                            <td>' .
                            $student['Student_Number'] .
                            '</td>
                            <td>' .
                            $sdca_email .
                            '</td>
                            <td>
                            sdca'.+ $year .
                            '</td>' .
                            // html += '<td><label class="switch">' +
                            //     '<input type="checkbox">' +
                            //     '<span class="slider round"></span>' +
                            //     '</label>' +
                            //     '</td>';
                            '</tr>';
                        // $('#adminDigitalTbody').append(html);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <!-- </div> -->
    </div>
    <!--/CONTENT GRID-->
</section>
<script>
    // ajax_digital()
    var new_date = new Date();
    year_today = new_date.getFullYear();
    sdca_pass = 'Password this year : sdca' + year_today;
    $('#sdcapassword').html(sdca_pass);

    function digital_update_status(id, id_acc) {
        switch_id = $('#switch' + id + id_acc);
        switch_value = switch_id.val();
        digital_id = switch_id.data(switch_value);
        if (switch_id.prop("checked")) {
            status = 'done';
        } else {
            status = 'pending';
        }
        $.ajax({
            url: 'updateDigitalCitizenshipAccount',
            dataType: 'json',
            method: 'post',
            data: {
                'digital_id': digital_id,
                'status': status
            },
            success: function(response) {}
        })
    }


    function ajax_digital() {
        $.ajax({
            url: 'getDigitalCitizenship',
            dataType: 'json',
            success: function(response) {
                $.each(response, function(key, value) {
                    year = '';
                    date_created = value['created_at'];
                    year = new Date(date_created).getFullYear();
                    // ajax_digital_account(value);
                    sdca_email = '';
                    sdca_email = remove_space_regex(value['First_Name']) + '.' + remove_space_regex(value['Last_Name']) + '@sdca.edu.ph';
                    console.log(sdca_email);
                    html = '<tr>' +
                        '<td>' +
                        value['Last_Name'] + ', ' + value['First_Name'] + ' ' + value['Middle_Name'] +
                        '</td>' +
                        '<td>' +
                        value['Course'] +
                        '</td>' +
                        '<td>' +
                        value['Student_Number'] +
                        '</td>' +
                        '<td>' +
                        sdca_email +
                        '</td>' +
                        '<td>' +
                        'sdca' + year +
                        '</td>' +
                        // html += '<td><label class="switch">' +
                        //     '<input type="checkbox">' +
                        //     '<span class="slider round"></span>' +
                        //     '</label>' +
                        //     '</td>';
                        '</tr>';
                    $('#adminDigitalTbody').append(html);
                });
            },
        })
    }

    function ajax_digital_account(data) {
        $.ajax({
            url: 'getDigitalCitizenshipAccount',
            dataType: 'json',
            method: 'post',
            data: {
                'digital_id': data['id']
            },
            success: function(response) {
                html = '<tr>';
                html += '<td>' +
                    data['Last_Name'] + ', ' + data['First_Name'] + ' ' + data['Middle_Name'] +
                    '</td>' +
                    '<td>' +
                    data['Student_Number']
                '</td>';
                $.each(response, function(key_acc, value_acc) {
                    checked = '';
                    if (value_acc['status'] == 'done') {
                        checked = 'checked';
                    }
                    html += '<td><label class="switch">' +
                        '<input type="checkbox" ' + checked + ' id="switch' + data['id'] + value_acc['id'] + '" data-' + value_acc['request'] + '="' + value_acc['id'] + '"value="' + value_acc['request'] + '" onclick="digital_update_status(' + data['id'] + ',' + value_acc['id'] + ')">' +
                        '<span class="slider round"></span>' +
                        '</label>' +
                        '</td>';
                });
                html += '</tr>';
                $('#adminDigitalTbody').append(html);
            }
        })
    }

    // alert('Juan Pedro'.replace(/\s/g, ''));
    function remove_space_regex(string) {
        var reg = /\s+/g;
        if (string != null) {
            lowercase = string.toLowerCase();
        }

        replace = lowercase.replace(reg, '');
        // alert(replace);

        return replace;
    }
</script>