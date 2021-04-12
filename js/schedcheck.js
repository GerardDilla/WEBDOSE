function searchsched(){
    
    //Sets inputs
    arrayData = {
        url:$('#ajaxurl').val(),
        searchkey:$('#searchkey').val(),
        sy:$('#schedsy_edit').val(),
        sem:$('#schedsem_edit').val(),
        pageNumber: 1,
        //Pagination
        perPage:10
    };
    //Checks inputs
    if(!arrayData.sy){
        alert('Please Select a School Year');
        return;
    }
    if(!arrayData.sem){
        alert('Please Select a Semester');
        return;
    }
    counter = ajax_getsched_pages(arrayData);
    counter.success(function(pages){
        content = ajax_getsched(arrayData);
        content.success(function(response){
            
            $('#sched_edit_pagination').pagination({
                items: pages,
                itemsOnPage: arrayData.perPage,
                cssStyle: 'light-theme',
                onPageClick: function(pageNumber){
                    arrayData['pageNumber'] = pageNumber;
                    ajax_getsched(arrayData);
                }
            });
        });
    });

    //alert(arrayData.searchkey+':'+''+arrayData.sy+':'+arrayData.sem);
}
function ajax_getsched(arrayData){

    offset = (arrayData.pageNumber - 1) * arrayData.perPage;
    return $.ajax({
        //async: false,
        url: arrayData.url+"index.php/Registrar/ajax_getsched_search",
        type: 'GET',
        data: {
            searchkey: arrayData.searchkey,
            sy: arrayData.sy,
            sem: arrayData.sem,
            offset: offset,
            perpage: arrayData.perPage
        },
        success:function(response){
            result = response;
            result = JSON.parse(result);
            display_sched_table(result.sched,result.total_enrolled);
        }
    });
}

function ajax_getsched_pages(arrayData){
   
    return $.ajax({
        url: arrayData.url+"index.php/Registrar/ajax_getsched_search_pagination",
        type: 'GET',
        data: {
            searchkey: arrayData.searchkey,
            sy: arrayData.sy,
            sem: arrayData.sem
        }
    });

}

function display_sched_table(arrayData,total_enrolled){

    showtable = $('#sched_edit_table');
    //Clears the table before append
    showtable.html('');
    $.each(arrayData, function(index, result) 
    {
        ex = '';
        total_slot = parseInt(result['Total_Slot']) - parseInt(total_enrolled[result['Sched_Code']]);
        if(total_slot < 0){
            ex = 'Exceeding:';
            total_slot = parseInt(total_enrolled[result['Sched_Code']]) - parseInt(result['Total_Slot']);
            console.log(total_slot);
        }
        row = $("<tr/>");
        row.append($("<td/>").text(result['Sched_Code']));
        row.append($("<td/>").text(result['Course_Code']));
        row.append($("<td/>").text(result['Course_Title']));
        row.append($("<td/>").text(result['Section_Name']));
        row.append($("<td/>").text(result['Course_Lec_Unit']));
        row.append($("<td/>").text(result['Course_Lab_Unit']));
        row.append($("<td/>").text(result['Total_Slot']));
        row.append($("<td/>").text(ex+''+total_slot));
        row.append($("<td/>").text(result['Day']));
        row.append($("<td/>").text(convert_time(result['Start_Time'])+' - '+convert_time(result['End_Time'])));
        row.append($("<td/>").text(result['Room']));
        row.append($("<td/>").text(result['Instructor_Name']));
        row.append('<button type="button" value="'+result['sched_display_id']+'" class="btn btn-info" onclick="editsched(this.value)">Edit</button>');
        showtable.append(row);

    });

}
function editsched(schedcode = ''){

    //Get url
    addressUrlSchedInfo = $('#addressUrlSchedInfo').val();
    enrolled_count = 0;
    //reset error
    $("#edit_schedule_error").html('');
    //Reset form
    $("#edit_sched_form")[0].reset();
    //alert(schedcode);
    $.ajax({
        url: addressUrlSchedInfo,
        type: 'GET',
        data: {id: schedcode},
        success: function(response){
            //alert(response);
            //Empty div 
            $("#schedInfoHidden").empty();
            //Create hidden inputs 
            $("#schedInfoHidden").append($('<input/>').attr({ type: 'hidden', class: 'form-control',  name: 'schedule_id', id: 'schedule_id'}).val(schedcode));
            arraySchedInfo = response;
            arraySchedInfo = JSON.parse(arraySchedInfo);

            //Gets total enrolled
            totalenrolled = ajax_get_totalenrolled(arraySchedInfo);
            totalenrolled.success(function(enrollcount){

              totaladvised = ajax_get_totaladvised(arraySchedInfo);
              totaladvised.success(function(advisedcount){

                arraySchedInfo[0]['Total_enrolled'] = enrollcount == '' ? 0 : enrollcount;
                arraySchedInfo[0]['Total_advised'] = advisedcount == '' ? 0 : advisedcount;

                console.log(arraySchedInfo);
                display_editor(arraySchedInfo);

              });


            });

        }
    });
    
}
function display_editor(arraySchedInfo){

    $.each(arraySchedInfo, function(index, value) 
    {
        $("#coursename").html(value['Course_Title']);

        //$('#starttimeEditSched option[value='+value['Start_Time']+']').attr('selected', 'selected');
        $("#starttimeEditSched").val(value['Start_Time']);
        $("#starttimeEditSched").selectpicker('refresh');

        //$('#endtimeEditSched option[value='+value['End_Time']+']').attr('selected', 'selected');
        $("#endtimeEditSched").val(value['End_Time']);
        $("#endtimeEditSched").selectpicker('refresh');



        //append hidden inputs
        $("#schedInfoHidden").append($('<input/>').attr({ type: 'hidden', class: 'form-control',  name: 'section'}).val(value['Section_ID']));
        $("#schedInfoHidden").append($('<input/>').attr({ type: 'hidden', class: 'form-control',  name: 'course'}).val(value['Course_Code']));
        $("#schedInfoHidden").append($('<input/>').attr({ type: 'hidden', class: 'form-control',  name: 'schedsem'}).val(value['Semester']));
        $("#schedInfoHidden").append($('<input/>').attr({ type: 'hidden', class: 'form-control',  name: 'schedsy'}).val(value['SchoolYear']));

        //split day into array
        dayArray = [];
        dayArray = value['Day'].split(',');

        $.each(dayArray, function(index, day) 
        {
            
            if (day != '') 
            {
                $("input:checkbox[value='"+day+"'][id='dayEditSched_"+day+"']").prop("checked", true);
            }
        });
        $("#dayEditSched").selectpicker('refresh');

        //Choose and Reset Room Option
        //$('#roomEditSched option[value='+value['RoomID']+']').attr('selected', 'selected');
        $("#roomEditSched").val(value['RoomID']);
        $("#roomEditSched").selectpicker('refresh');

        //Display Total Enrolled
        $("#editview_total_slots").html(value['Total_Slot']);

        //Display Total Enrolled
        $("#editview_total_enrollees").html(value['Total_enrolled']);

        //Display Total Advised
        $("#editview_total_advised").html(value['Total_advised']);

        //Display Total available slots
        available_slot = parseInt(value['Total_Slot']) - (parseInt(value['Total_enrolled']) + parseInt(value['Total_advised']));
        $("#editview_total_available").html(available_slot > 0 ? available_slot : 0);

        //Display exceeding enrollments
        exceeding_enroll = (parseInt(value['Total_enrolled']) + parseInt(value['Total_advised'])) - parseInt(value['Total_Slot']);
        $("#editview_total_exceeding").html(exceeding_enroll < 0 ? 0 : exceeding_enroll);

        $("#editslot").val(value['Total_Slot']);
        console.log(value['Total_Slot']+':Slots');

        console.log('Instructor_ID'+value['Instructor_ID']);
        //$('#instructorEditSched option[value="'+value['Instructor_ID']+'"]').attr('selected', 'selected');
        $("#instructorEditSched").val(value['Instructor_ID']);
        $("#instructorEditSched").selectpicker('refresh');

        console.log('Section ID:'+value['Section_ID']);
        $("#sectionEditSched").val(value['Section_ID']);
        $("#sectionEditSched").selectpicker('refresh');

    });
    $('#editsched_modal').modal('show');
}
function EditFormValidate(php_url){

    var frm = $('#edit_sched_form');
    var msgarray;
    $.ajax({
        type: frm.attr('method'),
        url: php_url,
        data: frm.serialize(),
        success: function (data) {
        
          if(data == ''){
            $("#edit_schedule_error").html('');
            $("#editConfirmation").modal('show');
          }
          else{
            $("#edit_schedule_error").html('<br><br><hr><strong>'+data+'</strong><hr>');
            $("#editConfirmation").modal('hide');
          }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
            //$("#feedback_msg").html(data);
        },
    });

}
function Schedule_update(php_url){
    
    var frm = $('#edit_sched_form');
    console.log(frm.serialize());
    $.ajax({
        type: frm.attr('method'),
        url: php_url,
        data: frm.serialize(),
        success: function (data) {

            searchsched();
            msg = '<div class="alert bg-green alert-dismissible" role="alert">';
            msg += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
            msg += data;
            msg += ' </div>';
            $('#editConfirmation').modal('hide');
            $("#edit_schedule_error").html(msg);
        
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
            //$("#feedback_msg").html(data);
        },
    });
    
}
function remove_sched(url = ''){

    input = $('#schedule_id').val();
    $.ajax({
        type: 'GET',
        url: url+'/Registrar/ajax_remove_sched',
        data: {schedule_id:input},
        success: function (data) {

            searchsched();
            msg = '<div class="alert bg-green alert-dismissible" role="alert">';
            msg += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
            msg += data;
            msg += ' </div>';
            $('#RemoveConfirmation').modal('hide');
            $('#editsched_modal').modal('hide');
            $("#sched_removal_message").html(msg);
        
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
            //$("#feedback_msg").html(data);
        },
    });
}
function ajax_get_totalenrolled(arrayData){
   
    base_url = $('#ajaxurl').val();
    return $.ajax({
        url: base_url+"index.php/Registrar/get_sched_total_enrolled",
        type: 'GET',
        data: {
            schedCode: arrayData[0]['Sched_Code'],
            schedDisplayId: arrayData[0]['Sched_Display_ID'],
            semester: arrayData[0]['Semester'],
            schoolyear: arrayData[0]['SchoolYear']
        }
    });

}
function ajax_get_totaladvised(arrayData){
   
    base_url = $('#ajaxurl').val();
    return $.ajax({
        url: base_url+"index.php/Registrar/get_sched_total_advised",
        type: 'GET',
        data: {
            schedCode: arrayData[0]['Sched_Code'],
            schedDisplayId: arrayData[0]['Sched_Display_ID'],
            semester: arrayData[0]['Semester'],
            schoolyear: arrayData[0]['SchoolYear']
        }
    });

}
function convert_time(time){

    if(time == '700'){return '7:00AM';}
    if(time == '730'){return '7:30AM';}
    if(time == '800'){return '8:00AM';}
    if(time == '830'){return '8:30AM';}
    if(time == '900'){return '9:00AM';}
    if(time == '930'){return '9:30AM';}
    if(time == '1000'){return '10:00AM';}
    if(time == '1030'){return '10:30AM';}
    if(time == '1100'){return '11:00AM';}
    if(time == '1130'){return '11:30AM';}
    if(time == '1200'){return '12:00PM';}
    if(time == '1230'){return '12:30PM';}
    if(time == '1300'){return '1:00PM';}
    if(time == '1330'){return '1:30PM';}
    if(time == '1400'){return '2:00PM';}
    if(time == '1430'){return '2:30PM';}
    if(time == '1500'){return '3:00PM';}
    if(time == '1530'){return '3:30PM';}
    if(time == '1600'){return '4:00PM';}
    if(time == '1630'){return '4:30PM';}
    if(time == '1700'){return '5:00PM';}
    if(time == '1730'){return '5:30PM';}
    if(time == '1800'){return '6:00PM';}
    if(time == '1830'){return '6:30PM';}
    if(time == '1900'){return '7:00PM';}
    if(time == '1930'){return '7:30PM';}
    if(time == '2000'){return '8:00PM';}
    if(time == '2030'){return '8:30PM';}
    if(time == '2100'){return '9:00PM';}

}
function confirm_modal_exit(){
    $('#editConfirmation').modal('hide');
}
function remove_modal_exit(){
    $('#RemoveConfirmation').modal('hide');
}
/*
function search_student(){
   
    arrayData = {
        perPage:10,
        pageNumber:1,
    };
    page = get_info_pages(arrayData);
    console.log(page.length);
    get_info(arrayData);
    $('#student_search_pagination').pagination({
        items: page,
        itemsOnPage: arrayData.perPage,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber){
            arrayData['pageNumber'] = pageNumber;
            get_info(arrayData);
        }
    });

}
function get_info_pages(arrayData){

    arrayData['searchkey'] = $('#searchkey').val();
    console.log('@get_info_pages');
    arrayData['url'] = $('#url').val();
    ajax = $.ajax({
        async: false,
        url: arrayData.url+"/search_student_page",
        type: 'GET',
        data: {
            key: arrayData.searchkey
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
function get_info(arrayData){


    arrayData['searchkey'] = $('#searchkey').val();
    arrayData['url'] = $('#url').val();
    console.log('@get_info: '+arrayData['searchkey']);

    offset = (arrayData.pageNumber - 1) * arrayData.perPage;

    ajax = $.ajax({
        async: false,
        url: arrayData.url+"/search_student",
        type: 'GET',
        data: {
            key: arrayData.searchkey,
            limit: arrayData.perPage,
            offset: offset,
        },  
        success: function(response){

            result = response;
            result = JSON.parse(result);
            display_student_info_result(result);
        },
        fail: function(){
            alert('request failed');
        }
    });
    return result;

}
function display_student_info_result(arraySession){

        showtable = $('#student_search_table');
        //Clears the table before append
        showtable.html('');
        $.each(arraySession, function(index, result) 
        {
            row = $("<tr/>");
            row.append($("<td/>").text(result['Student_Number']));
            row.append($("<td/>").text(result['Reference_Number']));
            row.append($("<td/>").text(result['First_Name']+" "+result['Middle_Name']+" "+result['Last_Name']));
            showtable.append(row);
    
        });
        
}
*/
