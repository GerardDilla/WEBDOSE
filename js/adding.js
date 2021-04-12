
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

    //Displays data in info
    $('#name_view').val(arraySession[0]['First_Name']+' '+arraySession[0]['Middle_Name'][0]+'. '+arraySession[0]['Last_Name']);
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
        row.addClass("rowpointer");
        row.attr({'data-scode':result['Sched_Code'], "onClick": "selectsubject(this)"});

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


function selectenrolledsubjects(rowobject){
    
    //alert($(rowobject).data('scode'));
    //Puts the schedcode into the form

    //Sched Code
    schedcode_input = $('#sched_code_id');
    schedcode_view = $('#sched_code_view');
    schedcode_input.val($(rowobject).data('scode'));
    schedcode_view.attr("placeholder", "Sched Code: "+$(rowobject).data('scode'));

   //Course Code
    coursecode_input = $('#course_code_id');
    coursecode_view = $('#course_code_id_view');
    coursecode_input.val($(rowobject).data('course_codes'));
    coursecode_view.attr("placeholder", "Course Code: "+$(rowobject).data('course_codes'));

    //Course Title
    coursetitle_input = $('#course_title_id');
    coursetitle_view  = $('#course_title_id_view');
    coursetitle_input.val($(rowobject).data('course_titles'));
    coursetitle_view.attr("placeholder", "Course Title: "+$(rowobject).data('course_titles'));

    //Lecture Unit
    lec_input = $('#lec_ids');
    lec_view  = $('#lec_id_views');
    lec_input.val($(rowobject).data('lecs'));
    lec_view.attr("placeholder", "Course Lecture Unit: "+$(rowobject).data('lecs'));

     //Lab Unit
     lab_input = $('#lab_ids');
     lab_view  = $('#lab_id_views');
     lab_input.val($(rowobject).data('labs'));
     lab_view.attr("placeholder", "Course Lab Unit: " +$(rowobject).data('labs'));
 

    divscroller('top');
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
function test_adding_script(){

    //Will remove later
    alert('Adding.js is Loaded');

}
