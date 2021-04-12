
$(document).ready(function(){

    getBalance();

})
function Init_CourseInput(){

    validate = CourseInput_Validate();
    if(validate['status'] == true){

        $('#CourseConfirmForm').submit();
        //alert(validate['submitted']);

    }else{

        alert(validate['message']);

    }


}
function CourseInput_Validate(){

    studentref = $('#student_ref').val();
    program = $('#Program_Manual_Input_dropdown').val();
    major = $('#Major_Manual_Input_dropdown').val();

    result = {
        status:true,
        message:''
    }
    if(studentref == null || studentref == 0){

        result['status'] = false;
        result['message'] = 'Invalid Referencee Number: '+studentref;
        return result;
    }
    if(program == null || program == ''){

        result['status'] = false;
        result['message'] = 'Choose a Program for the Student';
        return result;

    }
    return result;

    

}
function GetCourseInputChoices(){

    $.ajax({
        
        url: $("#addressUrl").val()+"/GetAvailableCourses",
        success: function(response){

            data = JSON.parse(response);
            $('#Program_Manual_Input_dropdown').html('');
            $('#Program_Manual_Input_dropdown').html('<option disabled selected value="0">Select Program</option>');
            $.each(data, function(index, program){

                $('#Program_Manual_Input_dropdown').append('\
                <option value="'+program['Program_Code']+'">'+program['Program_Name']+'</option>\
                ');

            });
            $("#Program_Manual_Input_dropdown").selectpicker('refresh');

        },
        fail: function(){
            alert('Error Connecting to Server');
        }
    });
    //alert('get Choices');

}
function GetMajorInputChoices(Program = ''){

    
    $.ajax({
        
        url: $("#addressUrl").val()+"/GetAvailableMajors",
        type: 'GET',
        data: {
            Program: Program
        },
        success: function(response){

            data = JSON.parse(response);
            if(data.length == 0){

                $('#Major_Manual_Input_dropdown').html('<option value="0">No Major for this Program</option>');
                $("#Major_Manual_Input_dropdown").selectpicker('refresh');

            }else{

                $('#Major_Manual_Input_dropdown').html('');
                $.each(data, function(index, major){
    
                    $('#Major_Manual_Input_dropdown').append('\
                    <option value="'+major['ID']+'">'+major['Program_Major']+'</option>\
                    ');
    
                });
                $("#Major_Manual_Input_dropdown").selectpicker('refresh');
                
            }


        },
        fail: function(){
            alert('Error Connecting to Server');
        }
    });
    //alert(Program);

}


//INITIAL ADD SCHED BUTTON
if (!$("#section").val() || !$("input[name='stud_type']:checked").val() || !$("#referenceNo").val() || !$("#schoolYear").val() || !$("#semester").val()) 
{
    button = $("#add_sched_button");
    button.attr('data-tooltip', 'Fill-in Required Fields First');

    disable_button(button);
  

}

function checker()
{
    //console.log($("input[name='stud_type']:checked").val());
    //$("#tableSelectSchedule tbody tr td").html("");        // Or
    //$("#tableSelectSchedule tbody tr td").html("&nbsp;");  // Add a non-breaking space. (Recommended)
    //$("#tableSelectSchedule tbody tr td").empty();         // This
    //$("#tableSelectSchedule tbody tr").remove();
    //$(".rowSpan_201800219").attr("rowspan", 2);
    //$("#section").prop('disabled', true);
    //$("#studTypeBlock").prop('disabled', true);
    //$("#studTypeOpen").prop('disabled', true);
    arrayData = {
        section: $("#section").val(), 
        addressUrl: $("#addressUrl").val(),
        semester: $("#semester").val(),
        schoolYear: $("#schoolYear").val(), 
    };
    arrayData.start = 5;
    //setOpenSectionPagination(arrayData);
    //getOpenCourseList(arrayData)
    console.log(arrayData);
}

function checkSchedList()
{
    if ($("#section").val() && $("input[name='stud_type']:checked").val() && $("#referenceNo").val() && $("#semester").val() && $("#schoolYear").val()) 
    {
        toggleAddAllButton();
        setCourseSchedList();
    }
    else
    {
        return;
    }
}
function checkinputs(){

    //Check if section and student type is available
    if (!$("#section").val() || !$("input[name='stud_type']:checked").val() || !$("#referenceNo").val() || !$("#schoolYear").val() || !$("#semester").val() || !$("input[name='graduatingchoice']:checked").val()) 
    {
        return;
        
    }else{
        button = $("#add_sched_button");
        enable_button(button);
    }
    
}

function setCourseSchedList()
{
    //Clear table
    $("#tableSelectSchedule tbody").remove();

    //Check if section and student type is available
    if (!$("#section").val() || !$("input[name='stud_type']:checked").val() || !$("#referenceNo").val() || !$("#schoolYear").val() || !$("#semester").val()) 
    {
        return;

    }else{
        button = $("#add_sched_button");
        enable_button(button);
        $("#plan").prop('disabled', false);
    }

    //Gets open or block choice
    studType = $("input[name='stud_type']:checked").val();

    //Gets inputs
    arrayData = {
        section: $("#section").val(), 
        addressUrl: $("#addressUrl").val(),
        semester: $("#semester").val(),
        schoolYear: $("#schoolYear").val(), 
    };
    
    //Gets course list for the block section
    if (studType == "block") 
    {
        toggleAddAllButton();
        arraySchedList = getSectionCourseList(arrayData);
        $("#openSchedPagination").empty();
        $('#largeModal').modal('show');
    }
    else
    {
        //Get all course list
        arraySchedList = getOpenCourseList(arrayData);
        //set pagination
        setOpenSectionPagination(arrayData);
        $('#largeModal').modal('show');
    }

    if(arraySchedList == 0) 
    {
        return;    
    }

    arraySchedList = JSON.parse(arraySchedList);
    //set table display
    $(".searchloader").show();
    createSchedListTable(arraySchedList);

}

function searchOpenSchedList()
{
    //clear table
    $("#tableSelectSchedule tbody").remove();
    //check if section and student type is available
    if (!$("#section").val() || !$("input[name='stud_type']:checked").val() || !$("#referenceNo").val() || !$("#schoolYear").val() || !$("#semester").val()) 
    {
        return;
    }

    //check if the user used search
    if (!$("#schedSearchType").val()) 
    {
        return;
    }
    arrayData = {
        addressUrl: $("#addressUrl").val(),
        semester: $("#semester").val(),
        schoolYear: $("#schoolYear").val(), 
        searchType: $("#schedSearchType").val(),
        searchValue: $("#schedSearchValue").val()
    };
    
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_course_sched_open",
        type: 'GET',
        data: {
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear,
            searchType: arrayData.searchType,
            searchValue: arrayData.searchValue
        },
        success: function(response){
            
            //alert(response);
            arraySchedList = response;
        },
        fail: function(){
            alert('request failed');
        }
    });

    arraySchedList = JSON.parse(arraySchedList);
    //set table display
    
    createSchedListTable(arraySchedList);
    
    resultCount = setOpenSectionPagination(arrayData);

    alert('Returned With '+resultCount+' Results');

}

function createSchedListTable(arraySchedList)
{
    //set tbody
    tbody = $("<tbody/>");
    rowChecker = "";
    var class_count = 0;
    //console.log(arraySchedList);
    $.each(arraySchedList, function(index, sched) 
    {

        row = $("<tr/>");
        if (rowChecker != sched['Sched_Code']) 
        {
            
            //Set rowspan
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
            row.append($("<td/>").attr("rowspan", rowSpan).text(sched['Course_Lec_Unit']));
            row.append($("<td/>").attr("rowspan", rowSpan).text(sched['Course_Lab_Unit']));  
            rowChecker = sched['Sched_Code'];

        }

        row.append($("<td/>").text(sched['Day']));
        row.append($("<td/>").text(sched['Start_Time']+"-"+ sched['End_Time']));
        row.append($("<td/>").text(sched['Room']));
        //get total slot of schedule
        arrayDataCheckEnrolled = {
            schedCode: sched['Sched_Code'],
            schedDisplayId: sched['sched_display_id'],
            semester: $("#semester").val(),
            schoolyear: $("#schoolYear").val(),
            addressUrl: $("#addressUrl").val()
        };
        totalConsumedSlots = parseInt(getSchedTotalEnrolled(arrayDataCheckEnrolled)) + parseInt(getSchedTotalAdvised(arrayDataCheckEnrolled));


        console.log(arrayDataCheckEnrolled['schedCode']+':'+totalConsumedSlots+'!');
        //Prevents Viewing of negative values
        if(parseInt(sched['Total_Slot']) < parseInt(totalConsumedSlots)){

            row.append($("<td/>").text('0'));

        }
        else{

            row.append($("<td/>").text(sched['Total_Slot'] - totalConsumedSlots));

        }
    
        row.append($("<td/>").text(sched['Instructor_Name']));
        
        row.append($("<td/>").html($("<button/>").addClass("btn btn-info subject_inputs").attr({"onClick": "addSched("+sched['sched_display_id']+")", "type": "button", "id": "subject_row_"+class_count}).val(sched['sched_display_id']).text("Add Subject")));
        

        tbody.append(row);

        class_count++;
    });
    $(".searchloader").hide();
    console.log(tbody);
    $("#tableSelectSchedule").append(tbody);
    
}

function setOpenSectionPagination(arrayData)
{
    //console.log(arrayData);
    //set schedule per page
    perPage = 5;
    /*
    if (!arrayData.searchType) 
    {
        arrayData.searchType = 0;
    }
    */
    
    resultCount = getOpenCourseListResultsCount(arrayData);
    totalPage = Math.round(resultCount/perPage);
    console.log(totalPage);
    $("#openSchedPagination").pagination({
        items: resultCount,
        itemsOnPage: perPage,
        onPageClick: function openCourseListPage(pageNumber)
        {
            //alert(pageNumber);
            //clear table
            $("#tableSelectSchedule tbody").remove();
            arrayData = {
                addressUrl: $("#addressUrl").val(),
                semester: $("#semester").val(),
                schoolYear: $("#schoolYear").val(),
                searchType: $("#schedSearchType").val(),
                searchValue: $("#schedSearchValue").val() 
            };
            //compute for start
            arrayData.start = (pageNumber - 1) * 5;

            //console.log(arrayData);

            ajax = $.ajax({

                async: false,
                url: arrayData.addressUrl+"/get_course_sched_open",
                type: 'GET',
                data: {
                    semester: arrayData.semester,
                    schoolYear: arrayData.schoolYear,
                    start: arrayData.start,
                    searchType: arrayData.searchType,
                    searchValue: arrayData.searchValue
                },
                success: function(response){
                    
                    //alert(response);
                    arraySchedList = response;
                },
                fail: function(){
                    alert('request failed');
                }
            });

            arraySchedList = JSON.parse(arraySchedList);
            //set table display
            createSchedListTable(arraySchedList);

        }
        
    });

    return resultCount;
  
    
}



function addSched(schedDisplayId)
{
    //get sched info
    arrayData ={
        schedDisplayId: schedDisplayId,
        addressUrl: $("#addressUrl").val(),
        referenceNo: $("#referenceNo").val(),
        studType: $("input[name='stud_type']:checked").val(),
        unittype: $("input[name='graduatingchoice']:checked").val(),
        section: $("#section").val(),
        semester: $("#semester").val(),
        schoolYear: $("#schoolYear").val(),
        bypassCheck: $("input[id='bypassCheck']:checked").val()
    };

    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/insert_sched_session",
        type: 'GET',
        data: {
            schedDisplayId: arrayData.schedDisplayId,
            referenceNo: arrayData.referenceNo,
            studType: arrayData.studType,
            unittype:arrayData.unittype,
            section: arrayData.section,
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear,
            bypassCheck: arrayData.bypassCheck
        },
        success: function(response){
            //alert(response);
            //console.log(response);
            output = response;
            output = JSON.parse(output);
            
            if(output.success == 0)
            {
                //change later
                //alert(output.message);
                displaymessage(output.message,'red');
                return;
            }
            else if(output.success == 2)
            {
                //clear div
                showBypassLogin(arrayData.schedDisplayId);   
                return;
            }
            //change later
            //alert(output.message);
            displaymessage(output.message,'green','check');
            //display added sched in session
            displaySession();
            $('#collapseOne_19').addClass('in');
            $("#advise_button").removeAttr("disabled");     

        },
        fail: function(){
            alert('request failed');
        }
    });
  
}
function displaymessage(message = '',color = '',icon = 'announcement'){

    $("#errorAdvising").html(message);
    //alert('All possible subjects are added, please review them in the Queued Subjects Tab');

    //Display Error message
    var icon = '<i class="material-icons col-'+color+'" style="font-size:50px">announcement</i>';
    $("#msg_icon").html(icon);
    $("#planName").prop('disabled', true);
    $("#adviseSubmit").prop('disabled', true);
    $("#adviseSubmitConfirm").prop('disabled', true);
    $('#submitModal').modal('show');

}
function showBypassLogin(schedDisplayId)
{
    
    arraySched = getSchedDisplayData(schedDisplayId);

    $("#schedInfo").html('');

    ul = $("<ul>");

    ul.append($("<li>").html("Sched Code: <u>"+arraySched[0]['Sched_Code']+"</u>"));
    ul.append($("<li>").html("Course Code: <u>"+arraySched[0]['Course_Code']+"</u>"));
    ul.append($("<li>").html("Course Title: <u>"+arraySched[0]['Course_Title']+"</u>"));
    ul.append($("<li>").html("Section: <u>"+arraySched[0]['Section_Name']+"</u>"));
    

    $("#schedInfo").append(ul);

    $("#bypassSchedDisplayId").html('');
    $("#bypassSchedDisplayId").append($("<input/>").attr({"id": "bypassSchedDisplayIdValue", "type": "hidden"}).val(schedDisplayId));
    $("#bypass-login").modal("show");
}

function bypassLogin()
{
    arrayData ={
        addressUrl: $("#addressUrl").val(),
        referenceNo: $("#referenceNo").val(),
        bypassUserName: $("#bypassUserName").val(),
        bypassPassword: $("#bypassPassword").val(),
        studType: $("input[name='stud_type']:checked").val(),
        unittype: $("input[name='graduatingchoice']:checked").val(),
        section: $("#section").val(),
        semester: $("#semester").val(),
        schoolYear: $("#schoolYear").val(),
        schedDisplayId: $("#bypassSchedDisplayIdValue").val()
    };
    
    loginCheck = bypassLoginCheck(arrayData);
    if (loginCheck == 0) 
    {
        return;    
    }

    bypassAddSched(arrayData);

    //display added sched in session
    displaySession();
    $('#collapseOne_19').addClass('in');
    $("#advise_button").removeAttr("disabled");
    $("#bypass-login").modal("hide");
    $("#bypassUserName").val("");
    $("#bypassPassword").val("");
    
}

function bypassLoginCheck(arrayData)
{
    console.log('test');
    console.log(arrayData);
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/bypass_module_advising_login",
        type: 'GET',
        data: {
            referenceNo: arrayData.referenceNo,
            userName: arrayData.bypassUserName,
            password: arrayData.bypassPassword,
            schedDisplayId: arrayData.schedDisplayId,
            studType: arrayData.studType,
            section: arrayData.section,
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear
        },
        success: function(response){
            //alert(response);
            //console.log(response);
            output = response;
            output = JSON.parse(output);
            if(output.success == 0)
            {
                //change later
                alert(output.message);
                returnOutput =  0;
            }
            else
            {
                returnOutput = 1;
                alert(output.message);
            }
            
            //displaySession();
            //$('#collapseOne_19').addClass('in');
            //$("#advise_button").removeAttr("disabled");
            //$("#largeModal").modal("hide");
            

        },
        fail: function(){
            alert('request failed');
            returnOutput = 0;
        }
    });
    return returnOutput;
}

function bypassAddSched(arrayData)
{
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/insert_sched_session",
        type: 'GET',
        data: {
            schedDisplayId: arrayData.schedDisplayId,
            referenceNo: arrayData.referenceNo,
            studType: arrayData.studType,
            unittype:arrayData.unittype,
            section: arrayData.section,
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear,
        },
        success: function(response){
            //alert(response);
            //console.log(response);
            output = response;
            output = JSON.parse(output);
            if(output.success == 0)
            {
                //change later
                //alert(output.message);
               
            }
            //change later
            //alert(output.message);
            
            //$("#largeModal").modal("hide");
           

        },
        fail: function(){
            alert('request failed');
           
        }
    });
}

function getSchedDisplayData(schedDisplayId)
{
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_sched_data",
        type: 'POST',
        data: {
            schedDisplayId: schedDisplayId
        },
        success: function(response){
            //alert(response);
            console.log(response);
            output = response;
            output = JSON.parse(output);
            if(output.success == 0)
            {
                //change later
                alert(output.message);
               
            }
            //change later
            //alert(output.message);
            
            //$("#largeModal").modal("hide");
           

        },
        fail: function(){
            alert('request failed');
           
        }
    });
    return output.output;
}

function displaySession()
{
    //clear table
    $("#tableAdvisingSessionList tbody").remove();
    arrayData ={
        addressUrl: $("#addressUrl").val(),
        referenceNo: $("#referenceNo").val()
    };

    arraySession = getSessionData(arrayData);
    arraySession = JSON.parse(arraySession);

    if(arraySession.length == 0)
    {
        $(".sy-sem-sec-choice").prop('disabled', false);
        $(".sy-sem-sec-choice").selectpicker('refresh');

        $("#studTypeBlock").prop('disabled', false);
        $("#studTypeOpen").prop('disabled', false);

        $("#nongraduatingradio").prop('disabled', false);
        $("#graduatingradio").prop('disabled', false);
        $("#pharmaradio").prop('disabled', false);

        $("#total_units").css('color', 'white');
        $("#total_units").html('0');
        $("#total_units").attr("data-units",'0');
        return;
    }

    //Set section selector and student type to disabled
    $(".sy-sem-sec-choice").prop('disabled', true);
    $(".sy-sem-sec-choice").selectpicker('refresh');

    $("#studTypeBlock").prop('disabled', true);
    $("#studTypeOpen").prop('disabled', true);

    $("#nongraduatingradio").prop('disabled', true);
    $("#graduatingradio").prop('disabled', true);
    $("#pharmaradio").prop('disabled', true);

    //Initialize Unit variable
    units = 0;
    

    //Set tbody
    tbody = $("<tbody/>");
    $.each(arraySession, function(index, sched) 
    {
        
        row = $("<tr/>");
        row.append($("<td/>").text(sched['Sched_Code']));
        row.append($("<td/>").text(sched['Course_Code']));
        row.append($("<td/>").text(sched['Course_Title']));
        row.append($("<td/>").text(sched['Section_Name']));
        row.append($("<td/>").text(sched['Course_Lec_Unit']));
        row.append($("<td/>").text(sched['Course_Lab_Unit']));
        //row.append($("<td/>").text(sched['Day']));
        //row.append($("<td/>").text(sched['Start_Time']+"-"+sched['End_Time']));
        //row.append($("<td/>").text(sched['Room']));
        //row.append($("<td/>").text(sched['Instructor_Name']));
        
        row.append($("<td/>").html($("<input/>").addClass("btn btn-danger").attr({"onClick": "removeSched("+sched['session_id']+")", "type": "button"}).val("Remove")));
        
        units = units + parseInt(sched['Course_Lec_Unit']) + parseInt(sched['Course_Lab_Unit']);

        tbody.append(row);
        
    });
    if(units <= 27){
        $("#total_units").css('color', 'yellow');
    }else if(units > 27 && units < 30){
        $("#total_units").css('color', 'violet');
    }else{
        $("#total_units").css('color', 'red');
    }
    $("#total_units").attr("data-units",units);
    $("#total_units").html(units);
    $("#tableAdvisingSessionList").append(tbody);
    displaySchedTable();


}

function getSessionData(arrayData)
{
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_student_advising_session",
        type: 'GET',
        data: {
            referenceNo: arrayData.referenceNo
        },
        success: function(response){
            //alert(response);
            //console.log(response);
            arraySession = response;
            
        },
        fail: function(){
            alert('request failed');
        }
    });
    
    return arraySession;
}

function getmaxunits(currentunits)
{
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/getmaxunits",
        success: function(response){
            units = JSON.parse(response);
        },
        fail: function(){
            alert('request failed');
        }
    });
    return units;
}

function getunit_exception(currentunits)
{
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/unit_excempted/1",
        success: function(response){
            units = JSON.parse(response);
        },
        fail: function(){
            alert('request failed');
        }
    });
    return units;
}

function removeSched(sessionId)
{
    var output = '';
    arrayData ={
        addressUrl: $("#addressUrl").val(),
        sessionId: sessionId
    };
    ajax = $.ajax({
        //async: false,
        url: arrayData.addressUrl+"/remove_advising_session",
        type: 'GET',
        data: {
            sessionId: arrayData.sessionId
        },
        success: function(response){
            //alert(response);
            //console.log(response);
            output = response;
            output = JSON.parse(output);
            if(output.success == 0)
            {
                //change later
                alert(output.message);
                return;
            }
            displaySession();
        },
        fail: function(){
            alert('request failed');
        }
    });
    $('#collapseOne_19').addClass('in');
    $("#advise_button").removeAttr("disabled");
    
}

function getSectionCourseList(arrayData)
{

    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_course_sched_block",
        type: 'GET',
        data: {
            section: arrayData.section,
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear  
        },
        success: function(response){
            //alert(response);
            arraySchedList = response;
        },
        fail: function(){
            alert('request failed');
        }
    });
    return arraySchedList;
   
    //alert(arraySchedList);
    
}

function getOpenCourseList(arrayData)
{
    

    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_course_sched_open",
        type: 'GET',
        data: {
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear
            
        },
        success: function(response){
            
            //alert(response);
            arraySchedList = response;
        },
        fail: function(){
            alert('request failed');
        }
    });
    
    return arraySchedList;
    //alert(arraySchedList);
    
}

function getOpenCourseListResultsCount(arrayData)
{
    //console.log(arrayData);
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_course_sched_open_results_count",
        type: 'GET',
        data: {
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear,
            searchType: arrayData.searchType,
            searchValue: arrayData.searchValue
            
        },
        success: function(response){
            
            //alert(response);
            resultCount = response;
        },
        fail: function(){
            alert('request failed');
        }
    });
    
    return resultCount;
}

function getSchedTotalEnrolled(arrayData)
{
    //console.log('get total enrolled');
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
            console.log(response);
            totalEnrolled = response;
        },
        fail: function(){
            alert('request failed');
        }
    });
    return totalEnrolled;
}
function getSchedTotalAdvised(arrayData)
{
    //console.log('get total enrolled');
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_sched_total_advised",
        type: 'GET',
        data: {
            schedCode: arrayData.schedCode,
            schedDisplayId: arrayData.schedDisplayId,
            semester: arrayData.semester,
            schoolyear: arrayData.schoolyear
        },
        success: function(response){
            //alert(response);
            console.log(response);
            totalAdvised = response;
        },
        fail: function(){
            alert('request failed');
        }
    });
    return totalAdvised;
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

function setPaymentPlan()
{
    arrayData = {
        addressUrl: $("#addressUrl").val(),
        referenceNo: $("#referenceNo").val(),
        plan: $("#plan").val(),
        semester: $("#semester").val(),
        schoolYear: $("#schoolYear").val(),
        section: $("#section").val(),
    };
    console.log(arrayData);
    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/set_payment_plan",
        type: 'GET',
        data: {
            plan: arrayData.plan,
            referenceNo: arrayData.referenceNo,
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear,
            section: arrayData.section
        },
        success: function(response){
            //alert(response);
            //console.log(response);
           
            arrayFees = response;
        },
        fail: function(){
            alert('request failed');
        }
    });

    //Check if fees is set
    arrayFees = JSON.parse(arrayFees);
    //alert(arrayFees['success']);
    if (arrayFees['success'] == 0) 
    {
        console.log('enter error handler');
        var icon = '<i class="material-icons col-red" style="font-size:50px">announcement</i>';
        $("#errorAdvising").empty();
        $("#errorAdvising").append('<li style="font-size:15px;">'+arrayFees['message']+'</li>');
        $("#msg_icon").html(icon);
        $("#planName").prop('disabled', true);
        $("#adviseSubmit").prop('disabled', true);
        $("#adviseSubmitConfirm").prop('disabled', true);
        return 0;
        
    }

        $("#other_fee").val("Other Fee: "+arrayFees['other_fee']);
        $("#misc_fee").val("Misc Fee: "+arrayFees['misc_fee']);
        $("#lab_fee").val("Lab Fee: "+arrayFees['lab_fee']);
        $("#tuition_fee").val("Tuition Fee: "+arrayFees['tuition_fee']);
        $("#total_fee").val("Total Fee: "+arrayFees['total_fee']);
        
    


}
function checkfees(){

}

function adviseStudentCheck()
{

    arrayData = {
        addressUrl: $("#addressUrl").val(),
        curriculum: $("#curriculum").val(),
        Reference_Number: $("#referenceNo").val(),
        referenceNo: $("#referenceNo").val(),
        Student_Number: $("#studentNo").val(),
        SchoolYear: $("#schoolYear").val(),
        Semester: $("#semester").val(),
    };

    $("#errorAdvising").empty();
    //check if the user selected required fields
    
    checker = 0;
    if($('#OutstandingBalance').data('outstanding') > 1){

        Exclusion = BalanceExclusion(arrayData);
        Exclusion.done(function(result){
            if(result == 0){

                var c_msg = '<li style="font-size:15px; color:red">Student must settle remaining balance before advising.</li>';
                $("#errorAdvising").append(c_msg);
                checker =1;

            }
        });

    }
    if(!$("#referenceNo").val())
    {
        var s_msg = '<li style="font-size:15px;">Please select a student first</li>';
        $("#errorAdvising").append(s_msg);
        checker = 1;

    }
    if(!$("#plan").val())
    {
        var p_msg = '<li style="font-size:15px;">Please select a Payment plan first</li>';
        $("#errorAdvising").append(p_msg);
        checker =1;
    }
    if(!$("#curriculum").val())
    {
        var c_msg = '<li style="font-size:15px;">Please select a Curriculum first</li>';
        $("#errorAdvising").append(c_msg);
        checker =1;
    }
    if(!$("#semester").val())
    {
        var c_msg = '<li style="font-size:15px;">Please select a Semester first</li>';
        $("#errorAdvising").append(c_msg);
        checker =1;
    }
    if(!$("#schoolYear").val())
    {
        var c_msg = '<li style="font-size:15px;">Please select a School Year first</li>';
        $("#errorAdvising").append(c_msg);
        checker =1;
    }
    if(!$("input[name='graduatingchoice']:checked").val()){

        var c_msg = '<li style="font-size:15px;">Please select whether the Student is Graduating or Non Graduating</li>';
        $("#errorAdvising").append(c_msg);
        checker =1;

    }

    //check if there is sched session
    arraySession = getSessionData(arrayData);
    arraySession = JSON.parse(arraySession);

    if(arraySession == 0)
    {
        var sh_msg = '<li style="font-size:15px;">Please select a Schedule first</li>';
        $("#errorAdvising").append(sh_msg);
        checker =1;
    }

    //Check if units exceed selected units
    unittypes = getmaxunits();
    excempted = getunit_exception();
    //console.log(excempted);

    if($.inArray( $('#student_program').val(), excempted) == -1){
       
        maxunits = '';
        if($("input[name='graduatingchoice']:checked").val() == 0){
            maxunits = unittypes['nongraduating'];
        }else if($("input[name='graduatingchoice']:checked").val() == 1){
            maxunits = unittypes['graduating'];
        }
        else if($("input[name='graduatingchoice']:checked").val() == 2){
            maxunits = unittypes['pharma'];
        }
        //$("input[name='graduatingchoice']:checked").val() == 1 ? unittypes['graduating'] : unittypes['nongraduating'] ;
        //alert(maxunits);
        units = 0;
        $.each(arraySession, function(index, sched) 
        {
            units = units + parseInt(sched['Course_Lec_Unit']) + parseInt(sched['Course_Lab_Unit']);
        });
        console.log(maxunits+':'+units);
        if(maxunits < units){
    
            var sh_msg = '<li style="font-size:15px;">The student\'s total units exceed the max number of units</li>';
            $("#errorAdvising").append(sh_msg);
            checker = 1;
    
        }

    }


    if(checker == 1)
    {
        var icon = '<i class="material-icons col-red" style="font-size:50px">announcement</i>';
        $("#msg_icon").html(icon);
        $("#planName").prop('disabled', true);
        $("#adviseSubmit").prop('disabled', true);
        $("#adviseSubmitConfirm").prop('disabled', true);
        $('#submitModal').modal('show');
    }
    else
    {

        //Check if fees is available
        feesresult = setPaymentPlan();
        if(feesresult == 0){

            $('#submitModal').modal('show');
            return;
            
        }

        var icon = '<i class="material-icons col-red" style="font-size:50px">check_circle</i>';
        var msg = '<li style="font-size:15px;">Please Enter the Amount Paid Below</li>';
        $("#msg_icon").html(icon);
        $("#errorAdvising").append(msg);
        $("#planName").prop('disabled', false);
        $("#adviseSubmit").prop('disabled', false);
        $("#adviseSubmitConfirm").prop('disabled', false);
        showConfirmation();
    }

    //set input values
    $("#curriculumValue").val($("#curriculum").val());


    arrayCurriculumInfo = getCurriculumInfo(arrayData);
    arrayCurriculumInfo = JSON.parse(arrayCurriculumInfo);

    $("#curriculumName").val(arrayCurriculumInfo[0]['Curriculum_Name']);
    $("#planValue").val($("#plan").val());
    $("#planName").val($("#plan option:selected").text());
    $("#semesterValue").val($("#semester").val());
    $("#schoolYearValue").val($("#schoolYear").val());
    $("#sectionValue").val($("#section").val());


}
function BalanceExclusion(arrayData){

    return ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/GetBalanceExemption",
        type: 'GET',
        data: {
            SchoolYear: arrayData.SchoolYear,
            Semester: arrayData.Semester,
            Reference_Number: arrayData.Reference_Number,
            Student_Number: arrayData.Student_Number
        }
    });

   
}
function getCurriculumInfo(arrayData)
{

    ajax = $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_curriculum_info",
        type: 'GET',
        data: {
            curriculum: $("#curriculum").val()
        },
        success: function(response){
            //alert(response);
           
            arrayInfo = response;
        },
        fail: function(){
            alert('request failed');
        }
    });

    return arrayInfo;
}



function getSchedList(addressUrlSchedList, schedCode)
{
    //var arrayTime;
    ajax = $.ajax({
        async: false,
        url: addressUrlSchedList,
        type: 'GET',
        data: {schedId: schedCode},
        success: function(response){
            //alert(response);
            arraySchedList = response;
        }
    });
    
    return arraySchedList;
    //alert(arraySchedList);

}



function searchSched()
{
    
    var value = $("#searchSched").val();

    $("#tableSelectSchedule tr").each(function(index) {
        if (index != 0) 
        {

            $row = $(this);

            var id = $row.find("td:nth-child(2)").text();

            if (id.indexOf(value) != 0) 
            {
                $(this).hide();
            }
            else 
            {
                $(this).show();
            }
        }
    });
	
}

function searchSchedV2()
{
    var value = $("#searchSched").val().toLowerCase();

    $("#tableSelectSchedule tr").filter(function(index) {
        if (index != 0) 
        {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        }
       
      });
}

function showConfirmation()
{
    $("#confirmation").modal('show');
}
function toggleAddAllButton(){

    if($('#studTypeBlock').is(':checked')){ 
        
        $('#AddSched_Button_Panel').html($("<button/>").addClass("btn btn-success btn-lg").attr({"onClick": "addallsubjects()", "type": "button"}).text("ADD ALL SUBJECTS"));
    }
    else{
        $('#AddSched_Button_Panel').html('');
    }

}
function addallsubjects(){

    var count = 0;
    var adding_message = '';
    $('.subject_inputs').each(function(i, obj){

        console.log($('#total_units').attr('data-units'));

        adding_status = addallSched_no_alert($('#subject_row_'+count).val());
        adding_status.success(function(result){
            result = JSON.parse(result);
            if(result['success'] == 0){
                console.log(result);
                adding_message += '<li style="font-size:15px;">'+result['message']+'</li>';
            }
            
        });
        
        count++;
        
    });
    displaySession(); 
    $('#collapseOne_19').addClass('in');
    $("#errorAdvising").html(adding_message);
    //alert('All possible subjects are added, please review them in the Queued Subjects Tab');

    //Display Error message
    if(adding_message != ''){
        displaymessage(adding_message,'red');
    }
    

    //console.log(adding_message);
    $("#largeModal").modal("hide");
    //display added sched in session
    
}

function addallSched_no_alert(schedDisplayId)
{
    //get sched info
    arrayData ={
        schedDisplayId: schedDisplayId,
        addressUrl: $("#addressUrl").val(),
        referenceNo: $("#referenceNo").val(),
        studType: $("input[name='stud_type']:checked").val(),
        unittype: $("input[name='graduatingchoice']:checked").val(),
        section: $("#section").val(),
        semester: $("#semester").val(),
        schoolYear: $("#schoolYear").val(),
    };

    return $.ajax({
        async: false,
        url: arrayData.addressUrl+"/insert_sched_session",
        type: 'GET',
        data: {
            schedDisplayId: arrayData.schedDisplayId,
            referenceNo: arrayData.referenceNo,
            studType: arrayData.studType,
            section: arrayData.section,
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear,
            unittype: arrayData.unittype
        }
    });


    //display added sched in session
   // displaySession();  
}

function displaySchedTable()
{
    if (!$("#referenceNo").val()) 
    {
        return;
    }

    //Remove table
    $("#schedTableOutput").remove();
    
    arrayData ={
        addressUrl: $("#addressUrl").val(),
        referenceNo: $("#referenceNo").val()
    };
    
    //Create new table
    createSchedTable(arrayData);

    arraySession = getSessionData(arrayData);
    arraySession = JSON.parse(arraySession);

    //array color list
    //var color_list = new Array('green', 'blue', 'red' ,'orange', 'violet', 'pink', 'brown', 'blue','green', 'blue',);
    var color_list = new Array('#81c784', '#90caf9', '#e57373' ,'#ff8a65', '#b94dff', '#f48fb1', '#bcaaa4', '#90caf9','#a5d6a7', '#90caf9',);
    incrColor = 0;

    //array sched start loop
    $.each(arraySession, function(index, sched) 
    {
        //split the day
        dayArray = [];
        dayArray = sched['Day'].split(',');
        //checker
        //console.log("sched loop"+sched);
        //console.log(sched['Course_Code'] + " sched Start:" + sched['Start_Time'] + " sched End"+sched['End_Time'] + " day:"+sched['Day']);
        //console.log(isNaN(sched['End_Time']));
        //set rowspan to 0
        incRowSpan = 0;
        //console.log(incRowSpan);
        //console.log("is sched start time not a number: " + isNaN(sched['Start_Time']));
        //console.log("is sched end time not a number: " + isNaN(sched['End_Time']));

        militaryTimeFrom = sched['Start_Time'];
        incRowSpan++;
        while (militaryTimeFrom != sched['End_Time']) 
        {
            //console.log(militaryTimeFrom);
            incRowSpan++;
            militaryTimeFrom = customMilitaryTimeAdd(militaryTimeFrom);

            //check if affected by the adding of row
            
            if (($(".tempRow_tr_" + militaryTimeFrom)[0]) && (militaryTimeFrom != sched['End_Time'])) 
            {
                //console.log("check increment rowspan .tempRow_tr_" + militaryTimeFrom);
                incRowSpan++;
            }
            

            //remove column cell
            $.each(dayArray, function(index, day) 
            {
                if (day != '') 
                {
                    $("#"+militaryTimeFrom+"_"+day).remove();

                    //delete added row if available
                    if (($(".tempRow_tr_" + militaryTimeFrom)[0]) && (militaryTimeFrom != sched['End_Time'])) 
                    {
                        $(".added_"+militaryTimeFrom+"_"+day).remove();
                        //console.log("remove added "+ "#"+militaryTimeFrom+"_"+day);
                    }
                    //console.log("removes "+ "#"+militaryTimeFrom+"_"+day);
                }
            });
        }
        
        //set rowpsan
        $.each(dayArray, function(index, day) 
        {
            
            if (day != '') 
            {
                var replace = "#";
                //check if added row is available
                if ($(".added_" + sched['Start_Time']+"_"+day)[0]) 
                {
                    replace = ".added_";
                }

                $( replace+sched['Start_Time']+"_"+day ).css("background-color", color_list[incrColor]);
                //set display details of scedule
                $( replace+sched['Start_Time']+"_"+day ).html(sched['Sched_Code']+", "+sched['Course_Code']+", "+sched['Instructor_Name']+", "+sched['Room']); 
                //console.log("#"+time['Time_From']+"_"+day);
                //console.log(day);

                //add rowspan
                $( replace+sched['Start_Time']+"_"+day ).attr('rowspan', incRowSpan);
                $( replace+sched['Start_Time']+"_"+day ).css({'vertical-align':'middle', "text-align":"center"});
                
            }
            
            
        });

        //remove attribute of table col
        $('.schedDisplay'+"#tr_"+sched['End_Time']).removeAttr('id');
        
        //var checker = $("TR").find(".tempRow #tr_"+sched['End_Time']);
        var checker = $(".tempRow_tr_" + sched['End_Time'])[0];
        //console.log('check row: '+checker);
        //console.log("#tr_"+sched['End_Time']);
        if (!checker) 
        {

            //insert another tr
            displayTableRow = "";
            $.each(arrayDisplayDay, function(index, value) 
            {
                displayTableRow += '<td class="added_'+sched['End_Time'] +'_'+value +'" id="'+ sched['End_Time'] +'_'+value+'"  ></td>';
            }); 

            $( "#tr_"+sched['End_Time'] ).after('<tr id="tr_'+sched['End_Time']+'" class="tempRow_tr_' + sched['End_Time'] +'">'+ displayTableRow +' </tr>');
            //console.log(val['Time_From']);

            //insert rowspan
            $("#td_"+sched['End_Time']).attr('rowspan', 2);
        }
        
        
        //console.log(dayArray[0]);
        //console.log(dayArray[1]);
        
        incrColor++;
    });

}

function createSchedTable(arrayData)
{
    //get time db
    arrayTime = getTime(arrayData);
    arrayTime = JSON.parse(arrayTime);

    arrayDisplayDay = ['M', 'T', 'W', 'TH', 'F', 'S', 'A'];

    var table = $("<table/>").addClass("table table-bordered").attr("id", "schedTableOutput");
    var row = $("<tr/>").addClass("danger");

    //create thead
    var thead = $("<thead/>");
    row.append($("<th/>").text("Time"));
    $.each(arrayDisplayDay, function(index, value) 
    {
        row.append($("<th/>").addClass("text-center").text(value));
    });

    thead.append(row);
    table.append(thead);

    arrayDisplayDay = ['M', 'T', 'W', 'H', 'F', 'S', 'A'];

    var tbody = $("<tbody/>");

    $.each(arrayTime, function(index, time) 
    {
        row = $("<tr/>").attr("id", "tr_"+time['Time_From']);
        row.append($("<td/>").attr("id", "td_"+time['Time_From']).text(time['Schedule_Time']));
        $.each(arrayDisplayDay, function(index, day) 
        {
            row.append($("<td/>").attr("id", time['Time_From']+"_"+day).addClass("schedDisplay"));
        });
        tbody.append(row);
    });

    table.append(tbody);

    $("#schedTable").append(table);

}

function getTime(arrayData)
{
    //var arrayTime;
    $.ajax({
        async: false,
        url: arrayData.addressUrl+"/get_time",
        type: 'GET',
        data: {check: 1},
        success: function(response){
            //alert(response);
            arrayTime = response;
        }
    });
   
    return arrayTime;
    //alert(arrayTime);

    /*
    $.each(arrayTime, function(index, val) {
        console.log(val['Time_From']);
    });
    */
    
   
}
function customMilitaryTimeAdd(time)
{
    lengthCheck = time.toString().length;
    //console.log(lengthCheck);
    if (lengthCheck === 3)
    {
        hours = parseInt(time.toString().substr(0, 1), 10);
        minutes = parseInt(time.toString().substr(1, 2), 10);
    }
    else
    {
        hours = parseInt(time.toString().substr(0, 2), 10);
        minutes = parseInt(time.toString().substr(2, 2), 10);
    }
    //console.log(hours);
    //console.log(minutes);
    minutes += 30;
    

    if (minutes === 60) 
    {
        hours++;    
        minutes = "00";

        return hours + minutes;
    }
    else
    {
        return hours + "30";
    }
    //var output = hours + minutes;
    
}
function show_curriculum(){

    student_number = $('#studentNo').val();
    curriculum = $('#curriculum').val();
    url =  $("#addressUrl").val();
    ajax = $.ajax({
        //async: false,
        statusCode: {
            500: function() {
              alert("Cannot get Curriculum");
            }
        },
        url: url+"/curriculum_check",
        type: 'GET',
        data: {
            student_number: student_number,
            curriculum: curriculum
        },  

        success: function(response){

            result = JSON.parse(response);
            if(result.length <= 0){
                alert('No Result');
            }else{
                display_curriculum(result);
            }

        },
        fail: function(){
            alert('Request failed');
        }
    });
   
}
function display_curriculum(arraySession){

    showtable = $('#taken_subjects');
    //Clears the table before append
    showtable.html('');
    $.each(arraySession, function(index, result) 
    {
        row = $("<tr/>");
        row.append($("<td/>").text(result['SYTAKEN']));
        row.append($("<td/>").text(result['SEMTAKEN']));
        row.append($("<td/>").text(result['Course_Code']));
        row.append($("<td/>").text(result['Course_Title']));
        row.append($("<td/>").text(result['Remarks']));
        showtable.append(row);

    });
    $('#curriculum_modal').modal('show');
}
function disable_button(button){

    button.attr("disabled", true);
    button.css( 'cursor', 'not-allowed' );

}
function enable_button(button){

    button.attr("disabled", false);
    button.css( 'cursor', 'pointer' );

}

function getBalance(){

    //OutstandingBalance
    $.ajax({
        
        url: "https://stdominiccollege.edu.ph/SDCALMSv2/index.php/API/BalanceAPI",
        type: 'GET',
        data: {
            Reference_Number: $('#OutstandingBalance').data('token')
        },
        success: function(response){

            data = JSON.parse(response);
            balancedata = data['Output'];
            $('#OutstandingBalance').attr('data-outstanding', balancedata['Outstanding_Balance']);
            $('#OutstandingBalance').val('Outstanding Balance: '+balancedata['Outstanding_Balance']);


        },
        fail: function(){

            alert('Error Connecting to Server');

        }
    });



}
