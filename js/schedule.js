function checker()
{
    //$( "#edit_pane" ).show();
   //$("#edit_sched_form")[0].reset();
   
   //$("text[id='starttimeEditSched']").val("730");
   //$("#starttimeEditSched").remove();
   //$("select[value=730][id='starttimeEditSched']").prop("selected", true);
   //alert('temp');

   //check array
   array = {
       sem: 'FIRST',
       sy: '2018-2019'
   };
   alert(array.sem);

    
}

function check_connection(url, room)
{
    alert(getRoomSchedList(url, room));
}

function displayRoomSched(roomId, addressUrlSchedList, addressUrlTime)
{
    console.log(addressUrlSchedList);
    console.log(roomId);

    //check if school year and semester is available
    if (!$("#schedsem").val() || !$("#schedsy").val()) 
    {
        
        $("#schedule_error").html('<br><br><hr><strong>Warning: not selecting schoolyear and semester will not display room schedule</strong><hr>');
        return;
    }
    $("#edit_schedule_error").html('');

    arrayData = {
        roomId: roomId,
        urlSched: addressUrlSchedList,
        semester: $("#schedsem").val(),
        schoolYear: $("#schedsy").val()
    };

    


    arraySchedList = getRoomSchedList(arrayData);
    arraySchedList = JSON.parse(arraySchedList);

    arrayDisplayDay = ['M', 'T', 'W', 'H', 'F', 'S', 'A'];
    //remove table
    $("#schedTableOutput").remove();

    createSchedTable(addressUrlTime);

    //remove style of class
    //$('.schedDisplay').removeAttr('style').removeAttr('rowspan');

    //empty table
    //$('.schedDisplay').empty();

    //remove temporary added rows
    //$('.tempRow').remove();

    //array color list
    var color_list = new Array('green', 'blue', 'red' ,'orange', 'violet', 'pink', 'brown', 'blue','green', 'blue',);
    incrColor = 0;

    //array sched start loop
    $.each(arraySchedList, function(index, sched) 
    {
        //split the day
        dayArray = [];
        dayArray = sched['Day'].split(',');
        //checker
        //console.log("sched loop"+sched);
        console.log(sched['Course_Code'] + " shced Start:" + sched['Start_Time'] + " sched End"+sched['End_Time'] + " day:"+sched['Day']);
        console.log(isNaN(sched['End_Time']));
        //set rowspan to 0
        incRowSpan = 0;
        console.log(incRowSpan);
        //console.log("is sched start time not a number: " + isNaN(sched['Start_Time']));
        //console.log("is sched end time not a number: " + isNaN(sched['End_Time']));

        militaryTimeFrom = sched['Start_Time'];
        incRowSpan++;
        while (militaryTimeFrom != sched['End_Time']) 
        {
            console.log(militaryTimeFrom);
            incRowSpan++;
            militaryTimeFrom = customMilitaryTimeAdd(militaryTimeFrom);

            //check if affected by the adding of row
            
            if (($(".tempRow_tr_" + militaryTimeFrom)[0]) && (militaryTimeFrom != sched['End_Time'])) 
            {
                console.log("check increment rowspan .tempRow_tr_" + militaryTimeFrom);
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
                        console.log("remove added "+ "#"+militaryTimeFrom+"_"+day);
                    }
                    console.log("removes "+ "#"+militaryTimeFrom+"_"+day);
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
                $( replace+sched['Start_Time']+"_"+day ).html(sched['Sched_Code']+", "+sched['Course_Code']+", "+sched['Instructor_Name']); 
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
        console.log('check row: '+checker);
        console.log("#tr_"+sched['End_Time']);
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



    //console.log(arrayTime);
    //console.log(arraySchedList[0]['Day']);
    

    //alert(arraySchedList);
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

function createSchedTable(addressUrlTime)
{
    //get time db
    arrayTime = getTime(addressUrlTime);
    arrayTime = JSON.parse(arrayTime);

    arrayDisplayDay = ['M', 'T', 'W', 'H', 'F', 'S', 'A'];

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

function modulusChecker(num1)
{
    console.log(num1%60);
}

function military_time_check()
{
    var d1 = new Date();
    var d2 = new Date();
    var output = new Date();
    

    d1.setHours(7);
    d1.setMinutes(0);
    d2.setHours(0);
    d2.setMinutes(30);
    
    console.log(d1.getHours());
    console.log(d1.getTime());
    console.log(d2.getHours());
    console.log(d2.getMinutes());
    console.log(d2.getTime());

    

    console.log( d1.getTime() + d2.getTime() );

    output.setTime(d1.getTime() + d2.getTime());
    //output *= -1;
    console.log(output.getHours());
    console.log();

    //var addedTime = new Date(output);
    //console.log(addedTime.getHours());
    //console.log(addedTime.getMinutes());

}

function test()
{
    alert('Test');
    //remove style of class
    $('.schedDisplay').removeAttr('style', 'rowspan');

    //empty table
    $('.schedDisplay').empty();
}


function displayRoomSched_temp(roomId, addressUrlSchedList, addressUrlTime)
{
    console.log(addressUrlSchedList);
    console.log(roomId);

    arrayTime = getTime(addressUrlTime);
    arrayTime = JSON.parse(arrayTime);

    arraySchedList = getRoomSchedList(addressUrlSchedList, roomId);
    arraySchedList = JSON.parse(arraySchedList);

    //remove style of class
    $('.schedDisplay').removeAttr('style').removeAttr('rowspan');

    //empty table
    $('.schedDisplay').empty();

    //array color list
    var color_list = new Array('green', 'blue', 'red' ,'orange', 'violet', 'pink', 'brown',);
    incrColor = 0;

    //array sched start loop
    $.each(arraySchedList, function(index, sched) 
    {
        //split the day
        dayArray = [];
        dayArray = sched['Day'].split(',');
        //checker
        //console.log("sched loop"+sched);
        console.log(sched['Course_Code']);
        //set rowspan to 0
        incRowSpan = 0;
        console.log("is sched start time not a number: " + isNaN(sched['Start_Time']));
        console.log("is sched end time not a number: " + isNaN(sched['End_Time']));

        
        //array time start loop
        $.each(arrayTime, function(index, time)
        {

            
            console.log("time loop Time From:"+time['Time_From']+" >= Sched:"+sched['Start_Time']+" AND Time From:"+time['Time_From']+" <= Sched:"+sched['End_Time']);
            
            //console.log("time loop"+time['Time_From']);
            //if ( time['Time_From'] >= sched['Start_Time']  && time['Time_From'] <= sched['End_Time']   )
            if (  sched['Start_Time'] <= time['Time_From'] && time['Time_From'] <= sched['End_Time']   )
            {
                console.log("display sched if pass");
                //array day start loop
                
                $.each(dayArray, function(index, day) 
                {
                    
                    if (day != '') 
                    {
                        //insert color here
                        //$( "#"+time['Time_From']+"_"+day ).addClass( "SchedBorder" );
                        $( "#"+time['Time_From']+"_"+day ).css("background-color", color_list[incrColor]);
                        $( "#"+time['Time_From']+"_"+day ).html(sched['Course_Code']); 
                        console.log("#"+time['Time_From']+"_"+day);
                        console.log(day);

                        //add rowspan
                        //$( "#"+time['Time_From']+"_"+day ).attr('rowspan', incRowSpan);
                    }
                    
                    
                });
                incRowSpan++;
                console.log(incRowSpan);
                
            }
            if((time['Time_From'] >= sched['Start_Time'] ) && (time['Time_From'] >= sched['End_Time']) )
            {
                console.log("return"+time['Time_From'] +">=" +sched['End_Time']);
                //return false;
            }
            
        });

        //set rowpsan
        /*
        $.each(dayArray, function(index, day) 
        {
            
            if (day != '') 
            {
                $( "#"+sched['Start_Time']+"_"+day ).css("background-color", color_list[incrColor]);
                $( "#"+sched['Start_Time']+"_"+day ).html(sched['Course_Code']); 
                //console.log("#"+time['Time_From']+"_"+day);
                //console.log(day);

                //add rowspan
                $( "#"+sched['Start_Time']+"_"+day ).attr('rowspan', incRowSpan);
                $( "#"+sched['Start_Time']+"_"+day ).css({'vertical-align':'middle', "text-align":"center"});
            }
            
            
        });
        */
        //console.log(val['Time_From']);
        
        //console.log(dayArray[0]);
        //console.log(dayArray[1]);
        
        incrColor++;
    });



    //console.log(arrayTime);
    //console.log(arraySchedList[0]['Day']);
    

    //alert(arraySchedList);
}

function getRoomSchedList(arrayData)
{
    //var arrayTime;
    ajax = $.ajax({
        async: false,
        url: arrayData.urlSched,
        type: 'GET',
        data: {
            roomId: arrayData.roomId,
            semester: arrayData.semester,
            schoolYear: arrayData.schoolYear
        },
        success: function(response){
            //alert(response);
            arraySchedList = response;
        }
    });
    
    return arraySchedList;
    //alert(arraySchedList);
    
}

function getTime(addressUrlTime)
{
    //var arrayTime;
    $.ajax({
        async: false,
        url: addressUrlTime,
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

function getSchedCodeList(addressUrlSchedCodeList, addressUrlSchedInfo)
{
    if ($('#section').val()) 
    {
        console.log($('#section').val());    
    }

    if ($('#course').val()) 
    {
        console.log($('#course').val());    
    }
    if ($('#section').val() && $('#course').val()) 
    {
        //hide edit form
        $( "#edit_pane" ).hide();
        console.log('section and course have value'); 
        
        sectionId = $('#section').val();
        courseCode = $('#course').val();

        $.ajax({
            async: false,
            url: addressUrlSchedCodeList,
            type: 'GET',
            data: {section: sectionId, courseCode: courseCode},
            success: function(response){
                //alert(response);
                //console.log(response);
                arraySchedList = response;
            }
        });

        //$("#schedCodeListTable").remove();

        //arraySchedList = JSON.parse(arraySchedList);
        //alert(Array.isArray(arraySchedList));
        if (arraySchedList) 
        {
            createTableCourseCodeSchedule(arraySchedList, addressUrlSchedInfo);

            arraySchedList = JSON.parse(arraySchedList);

            //for viewing the sched code
            $("#schedcode").val("Schedule Code: "+arraySchedList[0]['Sched_Code']);
        }
        else
        {
            //alert('null');
            $("#schedcode").val("Schedule Code:");
        }

        

    }

}

function createTableCourseCodeSchedule(arraySchedList, addressUrlSchedInfo)
{
    arraySchedList = JSON.parse(arraySchedList);

    arrayTableColTitle = ['Sched Code', 'Subject Code', 'Subject Title', 'Section', 'Lec Unit', 'Lab Unit', 'Total Slot', 'Day', 'Time', 'Room', 'Instructor', 'Action'];

    var table = $("<table/>").addClass("table table-bordered").attr("id", "schedCodeListTable").css("width", "100%");
    var row = $("<tr/>").addClass("danger");

    //create thead
    var thead = $("<thead/>");
    $.each(arrayTableColTitle, function(index, value) 
    {
        row.append($("<th/>").addClass("text-center").text(value));
    });

    thead.append(row);
    table.append(thead);

    var tbody = $("<tbody/>");

    rowChecker = 0;
    $.each(arraySchedList, function(index, sched) 
    {
        row = $("<tr/>");
        if (rowChecker == 0) 
        {
            row.append($("<td/>").attr("rowspan", arraySchedList.length).text(sched['Sched_Code']));
            row.append($("<td/>").attr("rowspan", arraySchedList.length).text(sched['Course_Code']));
            row.append($("<td/>").attr("rowspan", arraySchedList.length).text(sched['Course_Title']));
            row.append($("<td/>").attr("rowspan", arraySchedList.length).text(sched['Section_Name']));
            row.append($("<td/>").attr("rowspan", arraySchedList.length).text(sched['Course_Lec_Unit']));
            row.append($("<td/>").attr("rowspan", arraySchedList.length).text(sched['Course_Lab_Unit']));
            row.append($("<td/>").attr("rowspan", arraySchedList.length).text(sched['Total_Slot']));
            rowChecker++;
        }

        row.append($("<td/>").text(sched['Day']));
        row.append($("<td/>").text(sched['Start_Time']+"-"+sched['End_Time']));
        row.append($("<td/>").text(sched['Room']));
        row.append($("<td/>").text(sched['Instructor_Name']));
        //row.append($("<td/>").attr("id","tdToInsertAction_"+sched['sched_display_id']).html($("<input/>").addClass("btn btn-info").attr({"onClick": "showedit(\'"+sched['Course_Title']+"\', "+sched['Sched_Code']+")", "type": "button"}).val("Edit")));
        row.append($("<td/>").attr("id","tdToInsertAction_"+sched['sched_display_id']).html($("<input/>").addClass("btn btn-info").attr({"onClick": "editSchedCodeSchedule("+sched['sched_display_id']+", \'"+addressUrlSchedInfo+"\')", "type": "button"}).val("Edit")));
        

        tbody.append(row);
    });

    table.append(tbody);

    $("#schedCodeListDiv").append(table);

}

function editSchedCodeSchedule(scheduleId, addressUrlSchedInfo, coursename)
{
    //reset error
    $("#edit_schedule_error").html('');
    //Reset form
    $("#edit_sched_form")[0].reset();
    //alert(scheduleId);
    $.ajax({
        async: false,
        url: addressUrlSchedInfo,
        type: 'GET',
        data: {id: scheduleId},
        success: function(response){
            //alert(response);
            //empty div 
            $("#schedInfoHidden").empty();
            //create hidden inputs 
            $("#schedInfoHidden").append($('<input/>').attr({ type: 'hidden', class: 'form-control',  name: 'schedule_id'}).val(scheduleId));
            arraySchedInfo = response;
        }
    });

    arraySchedInfo = JSON.parse(arraySchedInfo);

    $.each(arraySchedInfo, function(index, value) 
    {
        
        $('#starttimeEditSched option[value='+value['Start_Time']+']').attr('selected', 'selected');
        $("#starttimeEditSched").selectpicker('refresh');

        $('#endtimeEditSched option[value='+value['End_Time']+']').attr('selected', 'selected');
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
                console.log(day);
                $("input:checkbox[value='"+day+"'][id='dayEditSched_"+day+"']").prop("checked", true);
                
                console.log('Start: '+day);
            }
        });
        $("#dayEditSched").selectpicker('refresh');

        //Choose and Reset Room Option
        $('#roomEditSched option[value='+value['RoomID']+']').attr('selected', 'selected');
        $("#roomEditSched").selectpicker('refresh');


        $('#instructorEditSched option[value='+value['Instructor_ID']+']').attr('selected', 'selected');
        $("#instructorEditSched").selectpicker('refresh');


        //console.log('Start: '+value['Start_Time']);
        //console.log('End: '+value['End_Time']);
        //console.log('Room: '+value['RoomID']);
        //console.log('Instrutor: '+value['Instructor_ID']);
    });

    //get schedule info
    $( "#name" ).html(coursename);
    $( "#edit_pane" ).show();
    


}




