
function getstudentinputs()
{   

    //Gets Values on inputs
    arrayData = {
        studentid: $("#student_id").val(), 
        schoolyear: $("#schoolYear").val(),
        semester: $("#semester").val(),
        addressUrl: $("#inputform").attr('action'),
    };

    console.log('getstudentinputs: Success');
    console.log('Student ID: '+arrayData.studentid);
    console.log('sy: '+arrayData.schoolyear);
    console.log('sem: '+arrayData.semester);
 
    //1st level form checker:
    // Error messages are passed to 'errormessage' for displaying
    if(arrayData.studentid == ''){
        errormessage('Please Input A Student / Reference Number','info');
        return;
    }
    if(!arrayData.schoolyear){
        errormessage('Please Input The School Year','info');
        return;
    }
    if(!arrayData.semester){
        errormessage('Please Input The Semester','info');
        return;
    }
    if(!arrayData.addressUrl){
        errormessage('Error: No URL Found','error','red');
        return;
    }

    //Calls Ajax Process
    console.log('# Get Form Inputs: Success');
    getstudentdata(arrayData);
    return;
     
}
function getstudentdata(arrayData)
{
    //Runs ajax to get student data
    ajax = $.ajax({
        url: arrayData.addressUrl,
        type: 'GET',
        data: {
            semester: arrayData.semester,
            schoolYear: arrayData.schoolyear,
            studentid: arrayData.studentid
        },
        success: function(response){

            arraySession = JSON.parse(response);
            console.log(arraySession);
            if(arraySession === null){

                console.log('getstudentdata: Success');
                errormessage('Error: Failed to get info','warning','red');
                return;
            }
            else if(arraySession.length === 0){

                errormessage('No Result','info');
                return;
            }
            //Calls function for displaying data
            show_studentdata(arraySession);
            
        },
        fail: function(){

            alert('Error: request failed');
            return;
        }
    });

}
function show_studentdata(arraySession){

    if(arraySession.length === 0 || arraySession.length == ''){
        errormessage('Error: No array found','warning','red');
        return;
    }
    //Sets the table to view the result
    showtable = $('#resulttable');
    total_units = 0;
    sc = '';
    $.each(arraySession, function(index, unit){
        if(sc != unit['Sched_Code']){
            total_units = total_units + (parseInt(unit['Course_Lab_Unit']) + parseInt(unit['Course_Lec_Unit']));
        }
        sc = unit['Sched_Code'];
    });

    //Displays data in info
    $('#name_view').val(arraySession[0]['First_Name']+' '+arraySession[0]['Middle_Name'][0]+'. '+arraySession[0]['Last_Name']);
    $('#student_ref').val(arraySession[0]['Reference_Number']);
    $('#unit_view').val('Units: '+total_units);
    $('#program_view').val('Program: '+arraySession[0]['Program']);
    $('#schoolyear_view').val('School Year: '+arraySession[0]['School_Year']);
    $('#tuitionfee_view').val('Admitted SY: '+arraySession[0]['AdmittedSY']);
    $('#totalfee_view').val('Admitted SEM: '+arraySession[0]['AdmittedSEM']);


    //Displays data in table

    //clears the table before append
    showtable.html('');

    $.each(arraySession, function(index, result) 
    {

        //Set custom attribute 'sched-code'
        row = $("<tr/>");
        row.addClass("rowinfo");
        row.attr({'data-scode':result['Sched_Code'], "onClick": "sched_select(this)"});

        row.append($("<td/>").text(result['Sched_Code']));
        row.append($("<td/>").text(result['Course_Code']));
        row.append($("<td/>").text(result['Course_Title']));
        row.append($("<td/>").text(result['Section']));
        row.append($("<td/>").text(result['Course_Lec_Unit']));
        row.append($("<td/>").text(result['Course_Lab_Unit']));
        showtable.append(row);

    });

    //calls the function that scrolls to the div location
    divscroller('resulttable');
    console.log('show_studentdata: Success');

}
function selectsubject(rowobject){
    
    //alert($(rowobject).data('scode'));
    //Puts the schedcode into the form
    schedcode_input = $('#sched-code-id');
    schedcode_view = $('#sched-code-id-view');
    schedcode_input.val($(rowobject).data('scode'));
    schedcode_view.attr("placeholder","Sched Code: "+$(rowobject).data('scode'));

    //For change Subject Module
    coursecode_input = $('#course-code-id');
    coursecode_view = $('#course-code-id-view');
    coursecode_input.val($(rowobject).data('ccode'));
    coursecode_view.attr("placeholder", "Course Code: "+$(rowobject).data('ccode'));
     //For change Subject Module
    coursetitle_input = $('#course-title-id');
    coursetitle_view = $('#course-title-id-view');
    coursetitle_input.val($(rowobject).data('ctitle'));
    coursetitle_view.attr("placeholder", "Course Title: "+$(rowobject).data('ctitle'));
     //For change Subject Module
    lec_input = $('#course-lec-id');
    lec_view = $('#course-lec-id-view');
    lec_input.val($(rowobject).data('clec'));
    lec_view.attr("placeholder", "Course Lecture Unit: "+$(rowobject).data('clec'));
      //For change Subject Module
    lab_input = $('#course-lab-id');
    lab_view = $('#course-lab-id-view');
    lab_input.val($(rowobject).data('clab'));
    lab_view.attr("placeholder", "Course Lab Unit: "+$(rowobject).data('clab'));
    //For change Subject Module
    sched_display_id_input = $('#course_sched_display_id');
    sched_display_id_input.val($(rowobject).data('sched_display_id'));



    $('.modal').modal('hide');
    divscroller('top');
    $.removeData(rowobject);
    console.log('selectsubject: Success');

}
function divscroller(target){

    //Use to scroll to a div's location
    $('html,body').animate({
        scrollTop: $("#"+target).offset().top
    }, 'slow');

}
function errormessage(message = '',icon = '',color = ''){
    
    //alert(message);
    var message_text = $('#message_text');
    var message_icon = $('#message_icon');
    var message_color = 'modal-col-'+color;
    var message_color_id  = $('#message_color_id');
    var message_modal = $('#message_prompt');
    
    message_text.html(message);
    message_icon.html(icon);
    if(color != ''){
        message_color_id.addClass(message_color);
    }
    message_modal.modal('show');

}

function search_input_checker(){

        //Gets Values on inputs
        arrayData = {
            studentid: $("#student_id").val(), 
            schoolyear: $("#schoolYear").val(),
            semester: $("#semester").val(),
            searchType: $("#schedSearchType").val(),
            search_value: $("#schedSearchValue").val(),
            addressUrl: $("#base_url").val(),
        };
    
        console.log('getstudentinputs: Success');
        console.log('Student ID: '+arrayData.studentid);
        console.log('sy: '+arrayData.schoolyear);
        console.log('sem: '+arrayData.semester);
        
        //1st level form checker:
        //Error messages are passed to 'errormessage' for displaying
        if(arrayData.studentid == ''){
            errormessage('Please Input A Student / Reference Number','info');
            return;
        }
        if(!arrayData.schoolyear){
            errormessage('Please Input The School Year','info');
            return;
        }
        if(!arrayData.semester){
            errormessage('Please Input The Semester','info');
            return;
        }
        if(arrayData.addressUrl == ''){
            errormessage('Error: No URL Found','error','red');
            return;
        }
        if(arrayData.addressUrl == null){
            errormessage('Error: No URL Found','error','red');
            return;
        }
        
        $('#subjectchoice_modal').modal('show');
        resultcount = subjectchoices_count(arrayData);
        resultcount.success(function (data) {
            resultcount = data;
            //alert('Result Count: '+resultcount);
            arrayData['perPage'] = '10';
            arrayData['pageNumber'] = 1;
            subjectchoices_perpage(arrayData);
            //alert(arrayData.searchType+':'+arrayData.search_value+':'+resultcount);
            itemsperpage = resultcount / arrayData.perPage;
            //alert('items: '+arrayData.perPage+'+ Result: '+resultcount);
            $('#schedsearchmodalpagination').pagination({
                items: resultcount,
                itemsOnPage: arrayData.perPage,
                cssStyle: 'light-theme',
                onPageClick: function(pageNumber){
                    arrayData['pageNumber'] = pageNumber;
                    subjectchoices_perpage(arrayData);
                }
            });
            
        });

        //errormessage('Shows Choices Modal','info');

}

function subjectchoices_perpage(arrayData)
{
   
    offset = (arrayData.pageNumber - 1) * arrayData.perPage;
    
    ajax = $.ajax({
        url: arrayData.addressUrl+'/get_subjectchoice_search',
        type: 'GET',
        data: {
            semester: arrayData.semester,
            schoolYear: arrayData.schoolyear,
            searchType: arrayData.searchType,
            searchValue: arrayData.search_value,
            studentid: arrayData.studentid,
            offset:offset,
            limit:arrayData.perPage
        },
        success: function(response){

            arraySession = JSON.parse(response);
            if(arraySession === null){
                errormessage('Error: Failed to get info','warning','red');
                return;
            }
            else if(arraySession.length === 0){

                errormessage('No Result','info');
                return;
            }
            //Calls function for displaying data
            createSchedListTable(arraySession,arrayData);
          
        },
        fail: function(){
            errormessage('Error: request failed','warning','red');
            return;
        }
    });

}
function subjectchoices_count(arrayData)
{
    
    return $.ajax({
        url: arrayData.addressUrl+'/get_subjectchoice_search_count',
        type: 'GET',
        data: {
            semester: arrayData.semester,
            schoolYear: arrayData.schoolyear,
            searchType: arrayData.searchType,
            searchValue: arrayData.search_value,
            limit: arrayData.perPage,
            studentid: arrayData.studentid
        },

        success: function(response){

            
            count = response;
            //alert('count'+count+':'+searchValue);
          
        },
        fail: function(){
            errormessage('Error: request failed','warning','red');
            return;
        }
    });

   // alert(count);
    //return ajax;

}
function sched_select(rowobject,select = ''){

    //alert($(rowobject).data('scode'));
    $('#sched_info_modal').modal('show');
    result = sched_info($(rowobject).data('scode'));
    result.success(function (data) {
        result = JSON.parse(data);
        //alert('sc: '+result[0].Sched_Code);

        arraycheck = {
            schedCode: result[0].Sched_Code,
            schedDisplayId: result[0].sched_display_id,
            semester: result[0].Semester,
            schoolyear: result[0].SchoolYear,
            addressUrl: $("#base_url").val(),
            
        };

        enrollees_count = getSchedTotalEnrolled(arraycheck);

        $('#sc_info').html(result[0].Sched_Code);
        $('#lec_info').html(result[0].Course_Lec_Unit);
        $('#lab_info').html(result[0].Course_Lab_Unit);
        $('#unit_info').html(parseInt(result[0].Course_Lec_Unit) + parseInt(result[0].Course_Lab_Unit));

        totalslots = parseInt(result[0].Total_Slot) - parseInt(enrollees_count);
        $('#slot_info').html(totalslots);
        if(totalslots < 0){
            $('#slot_info').html('Exceeding: '+totalslots);
        }
        else if(totalslots == 0){
            $('#slot_info').html('0');
        }
        
        $('#instructor_info').html(result[0].Instructor_Name);
        if(result[0].Instructor_Name == '' || result[0].Instructor_Name == null){
            $('#instructor_info').html('N/A');
        }
        console.log(result);
        $('#sched_info_table').html('');
        $.each(result, function(index, sched) 
        {
            row = $("<tr/>");
            row.append($("<td/>").text(sched['Day']));
            row.append($("<td/>").text(sched['stime']));
            row.append($("<td/>").text(sched['etime']));
            row.append($("<td/>").text(sched['Room']));
            $('#sched_info_table').append(row);

        });
        

        $('#select_subject_id').html('<button/>').addClass('btn btn-success waves-effect').attr({'data-scode':result[0].Sched_Code,'data-ccode':result[0].Course_Code,'data-ctitle':result[0].Course_Title,'data-clec':result[0].Course_Lec_Unit,'data-clab':result[0].Course_Lab_Unit,'data-sched_display_id':result[0].id,"onClick": "selectsubject(this)"}).text('SELECT').show();
        if(select != 1){
            $('#select_subject_id').hide();
        }
       
       
        


    });
}
function sched_info(sc){
    
    addressUrl = $('#base_url').val();
    return $.ajax({
        url: addressUrl+'/get_sched_info',
        type: 'GET',
        data: {
            schedCode: sc,
        },
        success: function(response){

            if(response === null){
                errormessage('Error: Failed to get info','warning','red');
                return;
            }
            else if(response.length === 0){

                errormessage('No Result','info');
                return;
            }
        },
        fail: function(){
            errormessage('Error: request failed','warning','red');
            return;
        }
    });

}
function createSchedListTable(arraySchedList,arrayData)
{
    //set tbody
    tbody = $("<tbody/>");
    rowChecker = "";
    var class_count = 0;

    $.each(arraySchedList, function(index, sched) 
    {
        console.log(sched['Sched_Code']);
        row = $("<tr/>");
        row.addClass("rowpointer");
        row.attr({'data-scode':sched['Sched_Code'], "onClick": "sched_select(this,'1')"});

        if (rowChecker != sched['Sched_Code']) 
        {
            
            //set rowspan
           
            arrayDataRowSpan = {
                data: arraySchedList,
                keyName: 'Sched_Code',
                value: sched['Sched_Code']
            };
            rowSpan = getRowSpan(arrayDataRowSpan);
            
            row.append($("<td/>").attr("rowspan", rowSpan).text(sched['Sched_Code']));
            row.append($("<td/>").attr("rowspan", rowSpan).text(sched['Course_Code']));

            row.append($("<td/>").attr("rowspan", rowSpan).text(sched['Course_Title']));

            row.append($("<td/>").attr("rowspan", rowSpan).text(sched['Section_Name']));
            rowChecker = sched['Sched_Code'];

        }

        tbody.append(row);

        class_count++;
        
    });
    $('#tableSelectSchedule tbody').empty();
    $("#tableSelectSchedule").append(tbody);
}
function getRowSpan(arrayData)
{
    rowSpan = 0;
    $.each(arrayData.data, function(index, value) 
    {
        if (value[arrayData.keyName] == arrayData.value) 
        {
            rowSpan++;
        }
    });

    return rowSpan;
}
function getSchedTotalEnrolled(arrayData)
{
    console.log('get total enrolled');
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_sched_total_enrolled",
        type: 'GET',
        data: {
            schedCode: arrayData.schedCode,
            schedDisplayId: arrayData.schedDisplayId,
            semester: arrayData.semester,
            schoolyear: arrayData.schoolyear
        },
        success: function(response){
            //alert(response);
           
            totalEnrolled = response;
        },
        fail: function(){
            alert('request failed');
        }
    });
    
    return totalEnrolled;
}
function Add_check(){

    sc = $("#sched-code-id").val();
    arrayData = {
        studentid: $("#student_ref").val(), 
        schoolyear: $("#schoolYear").val(),
        semester: $("#semester").val(),
        sc: $("#sched-code-id").val(),
        addressUrl: $("#base_url").val()
    };

    if(arrayData.studentid == ''){
        errormessage('Please Input A Student / Reference Number','info');
        return;
    }
    if(arrayData.sc == null || arrayData.sc == ''){
        errormessage('Please Input A Schedule Code','info');
        return;
    }
    if(!arrayData.schoolyear){
        errormessage('Please Input The School Year','info');
        return;
    }
    if(!arrayData.semester){
        errormessage('Please Input The Semester','info');
        return;
    }
    if(arrayData.addressUrl == ''){
        errormessage('Error: No URL Found','error','red');
        return;
    }
    if(arrayData.addressUrl == null){
        errormessage('Error: No URL Found','error','red');
        return;
    }
    if(arrayData.sc == null || arrayData.sc == ''){
        errormessage('Please Input A Schedule Code','info');
        return;
    }

    //Checks Sched Code if Valid
    sc_val = Validate_sched_code(arrayData);
    if(sc_val == 0 || sc_val === null){
        errormessage('Invalid Schedule Code','info');
        return;
    }

    //Checks Sched Code if Valid
    sc_val = Validate_sched_code(arrayData);
    if(sc_val == 0 || sc_val === null){
        errormessage('Invalid Schedule Code','info');
        return;
    }

    //Gets Enrolled Subjects
    errorcheck = 0;
    sc_val = Validate_sched_code(arrayData);
    if(sc_val == 0 || sc_val === null){
        errormessage('Invalid Schedule Code','info');
        return;
    }
    result = sched_info(arrayData.sc);
    result.success(function (data) {

        data = JSON.parse(data);
        conflicted_data = [];
        count = 0;

        if(data.length == 0){
            errormessage('No Schedule Data Found','info');
            return;
        }
        //--Checks conflicted schedules
        $.each(data, function(index, result2) 
        {   
            arraycheck = {
                sy: $("#schoolYear").val(), 
                sem: $("#semester").val(),
                sn: arrayData.studentid,
                day: result2['Day'],
                start_time: result2['Start_Time'],
                end_time: result2['End_Time'],
                addressUrl: $("#base_url").val()
            };
            arraycheck_totalenrolled = {
                schedCode: result2['Sched_Code'],
                schedDisplayId: result2['sched_display_id'],
                semester: result2['Semester'],
                schoolyear: result2['SchoolYear'],
                addressUrl: $("#base_url").val(),
            };
            //Set variables to be checked
            conflict = Validate_sched_conflict(arraycheck);
            
            if(conflict.length >= 1){
                $.each(conflict, function(index, conflict_row) {
                    console.log('conflicted_data: '+count);
                    conflicted_data[count] = {
                        sc:conflict_row['SC'],
                        cc:conflict_row['Course_Code'],
                        day:conflict_row['Day'],
                        stime:conflict_row['Start_Time'],
                        etime:conflict_row['End_Time'],
                    };
                    count++;
                });
            }
            

            total_enrolled = getSchedTotalEnrolled(arraycheck_totalenrolled);
            available = parseInt(result2['Total_Slot']) - parseInt(total_enrolled);
            
            //result3 = get_enrolled(arrayData);
            
        });
        if(conflicted_data.length >= 1){
            //console.log(conflicted_data);
            msg = '<br>';
            $.each(conflicted_data, function(index, conflict_items) {
                msg += '- '+conflict_items['sc']+':'+conflict_items['cc']+' <br>';
            });
            errormessage('Conflicts with the following: <br>'+msg,'info');
            return;
        }
        if(available <= 0){
            errormessage('The Slot is full for <u>'+arrayData.sc+'</u>','info');
            return;
        }
        Add_Submit(arrayData);
        //$('#form_modal').modal('show');
        $('#final_add_form').submit();
      

    });


 
}
function Validate_sched_code(){

    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/Validate_Sched",
        type: 'GET',
        data: {
            sc: arrayData.sc
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
function Validate_sched_conflict(arrayData){

    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/Validate_Sched_conflict",
        type: 'GET',
        data: {
            sy: arrayData.sy,
            sem: arrayData.sem,
            sn: arrayData.sn,
            day: arrayData.day,
            start_time: arrayData.start_time,
            end_time: arrayData.end_time,
        },
        success: function(response){

            result = JSON.parse(response);
        
        },
        fail: function(){
            alert('request failed');
        }
    });
    return result;
}
function get_subject_list(){

    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/Validate_Sched",
        type: 'GET',
        data: {
            sc: arrayData.sc
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

function Add_Submit(arrayData){

    //alert(arrayData.studentid);
    //alert(arrayData.schoolyear);
    //alert(arrayData.semester);
    $('#form_ref_num').val(arrayData.studentid);
    $('#form_sched_code').val(arrayData.sc);
    $('#form_sy').val(arrayData.schoolyear);
    $('#form_sem').val(arrayData.semester);

}
function test_adding_script(){

    //Will remove later
    alert('Adding.js is Loaded');

}


//FOR DROPING SELECT SUBJECT IN TABLE


function selectenrolledsubjects(rowobject){
    
    //alert($(rowobject).data('scode'));
    //Puts the schedcode into the form

    //Sched Code
    schedcode_input = $('#sched_code_id');
    schedcode_view = $('#sched_code_view');
    schedcode_input.val($(rowobject).data('scode'));
    schedcode_view.attr({"placeholder":"Sched Code: "+$(rowobject).data('scode'),"value": $(rowobject).data('scode')});

   //Course Code
    coursecode_input = $('#course_code_id');
    coursecode_view = $('#course_code_id_view');
    coursecode_input.val($(rowobject).data('course_code'));
    coursecode_view.attr("placeholder", "Course Code: "+$(rowobject).data('course_code'));

    //Course Title
    coursetitle_input = $('#course_title_id');
    coursetitle_view  = $('#course_title_id_view');
    coursetitle_input.val($(rowobject).data('course_title'));
    coursetitle_view.attr("placeholder", "Course Title: "+$(rowobject).data('course_title'));

    //Lecture Unit
    lec_input = $('#lec_id');
    lec_view  = $('#lec_id_view');
    lec_input.val($(rowobject).data('lec'));
    lec_view.attr("placeholder", "Course Lecture Unit: "+$(rowobject).data('lec'));

     //Lab Unit
     lab_input = $('#lab_id');
     lab_view  = $('#lab_id_view');
     lab_input.val($(rowobject).data('lab'));
     lab_view.attr("placeholder", "Course Lab Unit: " +$(rowobject).data('lab'));
 

    divscroller('top');
    console.log('selectenrolledsubjects: Success');

}


///CHECKER OF NO INPUTS IN CHANGE SUBJECT MODULE

function getstudentchangesubjectinputs()
{   

   //Gets Values on inputs
    arrayData = {
        subjecttochange: $("#sched-code-id").val(), 
        subjectenrolled: $("#sched_code_id").val(),
        studentref:      $("#student_ref").val(),
        addressUrl: $("#inputform").attr('action'),
    };

    console.log('getstudentinputs: Success');
    console.log('Subject To Change: '+arrayData.subjecttochange);
    console.log('Subject Enrolled: '+arrayData.subjectenrolled);

    
    //1st level form checker:
    // Error messages are passed to 'errormessage' for displaying
    if(arrayData.studentref == ''){
        errormessage('Please Type a Student Number','info');
        return;  
    }
    if(!arrayData.subjectenrolled){
        errormessage('Please Choose a subject to Change','info');
        return;
    }
    if(!arrayData.subjecttochange){
        errormessage('Please Choose a subject to Enrolled','info');
        return; 
    }
    if(!arrayData.addressUrl){
        errormessage('Error: No URL Found','error','red');
        return;
    }

    $('#confirmation').modal('show'); 
   

    //Calls Ajax Process
    console.log('# Get Form Inputs: Success');
    getstudentchangesubjectinputs(arrayData);
    return; 
     
}

function ChangeSubject(){

    $( "#inputform" ).submit();
}


