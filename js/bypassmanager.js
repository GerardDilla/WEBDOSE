$(document).ready(function () {

    $('#filter').click(function () {
        getUsers();
    });

    $('#update_permission').click(function () {
        update_permission();
    });

    $('#permission-choice').on('click', '.checklabel', function (obj) {
        alert('test');
        $inputid = $(obj).data('inputid');
        if ($('#' + $inputid).is(':checked')) {
            alert('checked');
            $('#permission-choices #' + $inputid).attr('checked', '');
        } else {
            alert('not checked');
            $('#permission-choices #' + $inputid).removeAttr('checked');
        }

    });


});

function getUsers() {

    $.ajax({
        url: "./BypassAPI/list",
        type: "GET",
        data: {
            Searchkey: $('#searchkey').val(),
            Department: $('#department').val(),
        },
        success: function (response) {

            response = JSON.parse(response);
            if (response.length == 0) {
                iziModal('No Results');
                return;
            }
            tablecontent = $('#user_table tbody');
            tablecontent.html('');
            $.each(response, function (index, data) {

                tablecontent.append('\
                    <tr>\
                    <td>'+ data['User_ID'] + '</td>\
                    <td>'+ data['UserName'] + '</td>\
                    <td>'+ data['User_FullName'] + '</td>\
                    <td>'+ data['User_Department'] + '</td>\
                    <td>'+ (data['bypass_access'] != null ? data['bypass_access'] : 'None') + '</td>\
                    <td><button onclick="permission(this)" data-userid="' + data['User_ID'] + '" data-username="' + data['UserName'] + '" class="btn btn-info btn-sm">Update Permission</button></td>\
                    </tr>\
                ');
            });
            console.log(response);

        },
    });
}

function permission(obj) {

    // console.log($(obj).data('userid'));
    // console.log($(obj).data('username'));
    $.ajax({
        url: "./BypassAPI/info",
        type: "GET",
        data: {
            UserID: $(obj).data('userid'),
        },
        success: function (response) {

            response = JSON.parse(response);
            $('#permission-choices').html('');
            $('#userid_update').val($(obj).data('userid'));
            $('#selected_user').html($(obj).data('username'));
            $.each(response, function (index, school) {
                checked = school['School_ID'] == null ? '' : 'checked';
                $('#permission-choices').append('\
                    <div class="col-md-3">\
                        <input type="checkbox" id="'+ school['School_Code'] + '_tik" data-label="' + school['School_Code'] + '" class="filled-in permission_choice" ' + checked + '>\
                        <label class="checklabel" data-inputid="'+ school['School_Code'] + '_tik" for="' + school['School_Code'] + '_tik">' + school['School_Code'] + '</label>\
                    </div>\
                ');
            });
            $('#updateBypass').modal('show');
            // console.log(response);

        },
    });
}

function update_permission() {

    inputs = {};
    $.each($('.permission_choice'), function (index, obj) {
        console.log($(obj).attr('checked') != undefined ? 1 : 0);
        inputs[$(obj).data('label')] = $(obj).attr('checked') != undefined ? 1 : 0;
    });
    console.log(inputs);
    $.ajax({
        url: "./BypassAPI/update",
        type: "POST",
        data: {
            inputs: inputs,
            userid: $('#userid_update').val()
        },
        success: function (response) {

            response = JSON.parse(response);
            iziModal('Permission Updated');

        },
    });


}
function iziModal(msg, position = "topCenter") {
    iziToast.show({
        position: position,
        color: 'blue',
        message: msg
    });
}
