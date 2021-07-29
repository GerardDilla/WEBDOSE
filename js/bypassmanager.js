$(document).ready(function () {

    $('#filter').click(function () {
        getUsers();
    });

    $('#update_permission').click(function () {
        update_permission();
    });

    $("#permission_update").on("submit", function (event) {
        event.preventDefault();
        data = $(this).serialize();
        update_permission(data);

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
                    <td><button onclick="permission($(this).data(\'userid\'))" data-userid="' + data['User_ID'] + '" data-username="' + data['UserName'] + '" class="btn btn-info btn-sm">Update Permission</button></td>\
                    </tr>\
                ');
            });
            if (!$.fn.DataTable.isDataTable('#user_table')) {
                $('#user_table').DataTable({
                    responsive: true
                });
            }

            console.log(response);

        },
    });
}

function permission(userid) {

    // console.log($(obj).data('userid'));
    // console.log($(obj).data('username'));
    $.each($('.permission_choice'), function (index, checkbox) {
        $(checkbox).prop('checked', false);
    });
    $.ajax({
        url: "./BypassAPI/info",
        type: "GET",
        data: {
            UserID: userid,
        },
        success: function (response) {

            response = JSON.parse(response);
            $('#userid_update').val(userid);
            $('#selected_user').html(userid);
            $.each(response, function (index, school) {
                if (school['School_ID'] != null) {
                    console.log(school['School_Code'] + '_test');
                    $('#' + school['School_Code'] + '_tik').prop('checked', true);
                    $('#' + school['School_Code'] + '_tik').attr('checked');
                }
            });
            $('#updateBypass').modal('show');
            // console.log(response);

        },
    });
}

function update_permission(formdata) {

    console.log(data);
    $.ajax({
        url: "./BypassAPI/update",
        type: "POST",
        data: {
            formdata
        },
        success: function (response) {

            // response = JSON.parse(response);
            iziModal('Permission Updated');
            permission($('#userid_update').val());
            getUsers();

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
