var addressUrl = $("#addressUrl").val();
var selectedRoles = [];
var toRemoveRoles = [];

$('#accessTable').multiSelect({
    selectableHeader: "<h3 class='col-gray'>Available Roles</h3>",
    selectionHeader: "<h3 class='col-gray'>Current Roles</h3>",
    afterSelect: function(values){
        //alert("Select value: "+values);
        
        //window.selectedRoles.push(values[0]);
        addRole(values[0]);
        console.log("selected roles");
        console.log(window.selectedRoles);
        console.log("to remove roles");
        console.log(window.toRemoveRoles);
        
        checkRoleChanges();
    },
    afterDeselect: function(values){
        //alert("Deselect value: "+values);
        removeRole(values[0]);
        console.log("selected roles");
        console.log(window.selectedRoles);
        console.log("to remove roles");
        console.log(window.toRemoveRoles);
        checkRoleChanges();
    }
});

function removeRole(value)
{
    var index = window.selectedRoles.indexOf(value);
    console.log("value: "+value);
    console.log("index: "+index);
    if (index > -1) {
        window.selectedRoles.splice(index, 1);
    }
    else{
        window.toRemoveRoles.push(value);
    }
    return;
}

function addRole(value)
{
    var index = window.toRemoveRoles.indexOf(value);
    console.log("value: "+value);
    console.log("index: "+index);
    if (index > -1) {
        console.log("enter splice to remove role");
        window.toRemoveRoles.splice(index, 1);
    }
    else{
        window.selectedRoles.push(value);
    }
    return;
}

function checkRoleChanges()
{
    console.log('check role');
    if ((window.selectedRoles.length > 0) || (window.toRemoveRoles.length > 0)) {
        $('#buttonRoleSubmit').prop('disabled', false);
        //remove notification
        $('#actionNotification').html("");
    }
    else {
        $('#buttonRoleSubmit').prop('disabled', true);
    }
    return;
}

function submitRoleChange()
{
    
    console.log("Submit Roles");

    ajax = $.ajax({
        async: false,
        url: window.addressUrl+"/update_user_roles",
        type: 'POST',
        data: {
            addRoles: window.selectedRoles,
            removeRoles: window.toRemoveRoles,
            userId: $('#userId').val()
        },  
        success: function(response){
            console.log(response);
            result = response;
            result = JSON.parse(result);
            

        },
        fail: function(){
            alert('request failed');
        }
    });

    if (result.checker == 1) {
        console.log('checker is 1');
        //alert(result.message);
        $('#actionNotification').html(result.message);
        $('#buttonRoleSubmit').prop('disabled', true);

        //clear Arrays
        window.selectedRoles = [];
        window.toRemoveRoles = [];
    }
    else{
        $('#actionNotificationError').html(result.message);
    }

    
    
}

//$('#accessTable').multiSelect('addOption', { value: 'test', text: 'test', index: 0, nested: 'optgroup_label' });
//$('#accessTable').multiSelect('addOption', { value: 'test2', text: 'test2', index: 2, nested: 'optgroup_label' });

//selected
//$('#accessTable').multiSelect('select', ['test', 'test2']);

function searchUser()
{
   
    arrayData = {
        perPage:10,
        pageNumber:1,
    };
    page = getInfoPages(arrayData);
    console.log(page.length);
    getInfo(arrayData);
    $('#userSearchPagination').pagination({
        items: page,
        itemsOnPage: arrayData.perPage,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber){
            arrayData['pageNumber'] = pageNumber;
            getInfo(arrayData);
        }
    });

}
function getInfoPages(arrayData)
{

    arrayData['searchkey'] = $('#userSearchKey').val();
    arrayData['searchType'] = $('#searchBy').val();
    console.log(arrayData['searchkey']);
    console.log('@get_info_pages');
    arrayData['url'] = window.addressUrl;
    ajax = $.ajax({
        async: false,
        url: arrayData.url+"/search_user_page",
        type: 'GET',
        data: {
            key: arrayData.searchkey,
            searchType: arrayData.searchType
        },  
        success: function(response){

            result = response;

        },
        fail: function(){
            alert('request failed');
        }
    });
    return result;

}
function getInfo(arrayData)
{


    arrayData['searchkey'] = $('#userSearchKey').val();
    arrayData['searchType'] = $('#searchBy').val();
    arrayData['url'] = window.addressUrl;
    console.log('@get_info: '+arrayData['searchkey']);

    offset = (arrayData.pageNumber - 1) * arrayData.perPage;

    ajax = $.ajax({
        async: false,
        url: arrayData.url+"/search_user",
        type: 'GET',
        data: {
            key: arrayData.searchkey,
            searchType: arrayData.searchType,
            limit: arrayData.perPage,
            offset: offset,
        },  
        success: function(response){

            result = response;
            result = JSON.parse(result);
            displayUserInfoResult(result);
        },
        fail: function(){
            alert('request failed');
        }
    });
    return result;

}
function displayUserInfoResult(arraySession)
{


    showtable = $('#userSearchTable');
    //Clears the table before append
    showtable.html('');
    console.log(arraySession);
    if(arraySession.length == 0){
        row = $("<tr/>");
        row.append($("<td/>").text('NO RESULTS: Try a difference search term')).css('text-align','center');
        showtable.append(row);
    }
    $.each(arraySession, function(index, result) 
    {
        var status = "";
        if (result['tabValid'] == 1) {
            status = "Active";
        }
        else {
            status = "Inactive";
        }
        row = $("<tr/>");
        
        row.append($("<td/>").text(result['UserName']));
        row.append($("<td/>").text(result['User_FullName']));
        row.append($("<td/>").text(result['User_Position']));
        row.append($("<td/>").text(result['User_Department']));
        row.append($("<td/>").text(status));
        row.append($("<td/>").html('<a href="'+window.addressUrl+'/index/'+result['User_ID']+'" class="btn btn-info">Select</a>'));
        showtable.append(row);

    });
        
}


