
function trf_ajax(ref_num = '')
{   
    url = $('#addressUrl').val();
    ajax = $.ajax({
        url: url+'/temporary_regform_ajax',
        type: 'GET',
        data: {
            ref_num: ref_num
        },
        success: function(response){

            result = JSON.parse(response);
            trf_display(result);

        },
        fail: function(){

            alert('Error: request failed');
            return;
        }
    });

}
function trf_display(resultdata)
{   

    //Displays DATA
    //Displays Basic Info
    $('#trf_rn').html(resultdata['get_Advise'][0]['Reference_Number']);
    $('#trf_name').html(resultdata['get_Advise'][0]['First_Name']+' '+resultdata['get_Advise'][0]['Middle_Name'][0]+' '+resultdata['get_Advise'][0]['Last_Name']);
    $('#trf_address').html(
        resultdata['get_Advise'][0]['Address_No']+', '+
        resultdata['get_Advise'][0]['Address_Street']+', '+
        resultdata['get_Advise'][0]['Address_Subdivision']+', '+
        resultdata['get_Advise'][0]['Address_Barangay']+', '+
        resultdata['get_Advise'][0]['Address_City']+', '+
        resultdata['get_Advise'][0]['Address_Province']
    );
    $('#trf_sem').html(resultdata['get_Advise'][0]['Semester']);
    $('#trf_course').html(resultdata['get_Advise'][0]['Course']);
    $('#trf_sy').html(resultdata['get_Advise'][0]['School_Year']);
    $('#trf_yl').html(resultdata['get_Advise'][0]['Year_Level']);
    $('#trf_sec').html(resultdata['get_Advise'][0]['Section']);

    //Displays Payments
    $('#trf_tuition').html(resultdata['get_Advise'][0]['tuition_Fee']);
    $('#trf_misc').html(resultdata['get_miscfees'][0]['Fees_Amount']);
    
    $('#trf_other').html(resultdata['get_otherfees'][0]['Fees_Amount']);
    $('#trf_initial').html(resultdata['get_Advise'][0]['InitialPayment']);
    $('#trf_first').html(resultdata['get_Advise'][0]['First_Pay']);
    $('#trf_second').html(resultdata['get_Advise'][0]['Second_Pay']);
    $('#trf_third').html(resultdata['get_Advise'][0]['Third_Pay']);
    $('#trf_fourth').html(resultdata['get_Advise'][0]['Fourth_Pay']);
    $('#trf_scholar').html(resultdata['get_Advise'][0]['Scholarship']);
    $('#trf_scholar').html(resultdata['get_Advise'][0]['Scholarship']);
    //Lab Fees 
    /*
    labfee = 0;
    $.each(resultdata['get_labfees'], function(index, labresult) 
    {
        labfee = labfee + parseFloat(labresult['Lab_Fee']);  
    }); 
    */
    labfee = parseFloat(resultdata['get_labfees'][0]['Fees_Amount']);
    $('#trf_lab').html(labfee.toFixed(2));

    //Total Fees
    total_fees = parseFloat(resultdata['get_Advise'][0]['tuition_Fee']) + 
    parseFloat(resultdata['get_miscfees'][0]['Fees_Amount']) +
    labfee +
    parseFloat(resultdata['get_otherfees'][0]['Fees_Amount']);

    $('#trf_total_fees').html(total_fees.toFixed(2));

  
    //Displays Sched
    showtable = $('#temporary_regform_subjects');
    //clears the table before append
    showtable.html('');
    sched_checking = '';
    units = 0;
    subjectcount = 0;
    $.each(resultdata['get_Advise'], function(index, result) 
    {
        row = $("<tr/>");
        if(sched_checking != result['Sched_Code']){

            //Set custom attribute 'sched-code'
            units = units + (parseInt(result['Course_Lec_Unit']) + parseInt(result['Course_Lab_Unit']));
            subjectcount++;
            row.append($("<td/>").text(result['Sched_Code']).attr({valign:'top',width:'10%',style:'padding-right: 10px;  padding-top: 1px;'}));
            row.append($("<td/>").text(result['Course_Code']).attr({valign:'top',width:'10%',style:'padding-right: 10px;  padding-top: 1px;'}));
            row.append($("<td/>").text(result['Course_Title']).attr({valign:'top',width:'10%',style:'padding-right: 10px;  padding-top: 1px;'}));
            row.append($("<td/>").text(parseInt(result['Course_Lec_Unit']) + parseInt(result['Course_Lab_Unit'])).attr({valign:'top',width:'10%',style:'padding-right: 10px;  padding-top: 1px;'}));
            row.append($("<td/>").text(result['Day']).attr({valign:'top',width:'10%',style:'padding-right: 10px;  padding-top: 1px;', id:result['Sched_Code']+'_day'}));
            row.append($("<td/>").text(result['START']+' - '+result['END']).attr({valign:'top',width:'10%',style:'padding-right: 10px;  padding-top: 1px;', id:result['Sched_Code']+'_time'}));   
            row.append($("<td/>").text(result['Room']).attr({valign:'top',width:'10%',style:'padding-right: 10px;  padding-top: 1px;', id:result['Sched_Code']+'_room'}));
        
            
        }else{
            $('#'+result['Sched_Code']+'_day').append(' , '+result['Day']);
            $('#'+result['Sched_Code']+'_time').append(' , '+result['START']+' - '+result['END']);
            $('#'+result['Sched_Code']+'_room').append(' , '+result['Room']);
        }
        
        showtable.append(row);
        sched_checking = result['Sched_Code'];

    });

    //Total Units and Subjects
    $('#trf_total_units').html(units);
    $('#trf_total_subject').html(subjectcount);

    $('#regform').modal('show');

}

function print_temporary_regform(ref,sy,sm){

    url = $('#baseurl').val();
    html2canvas(document.querySelector("#trf_print_content")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "temporary_reg_canvas";
        document.getElementById("trf_print_content").appendChild(canvas);

        const dataUrl = document.getElementById('temporary_reg_canvas').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Assessment Form</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        //windowContent += '<body onafterprint="assessment_form_log(&apos;'+ref+'&apos;,&apos;'+sy+'&apos;,&apos;'+sm+')">';
        windowContent += '<img src="' + dataUrl + '">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();   
            assessment_form_log(ref,sy,sm);         
        }, true);
        $('#temporary_reg_canvas').remove();

    });
}

function assessment_form_log(ref,sy,sm){
    //alert();
    url = $('#addressUrl').val();
    ajax = $.ajax({
        url: url+'/print_logs',
        type: 'GET',
        data: {
            ref:ref,
            sy:sy,
            sm:sm
        },
        success: function(response){
            console.log('Printing Logged!');
            return;
        },
        fail: function(){
            console.log('Error: request failed');
            return;
        }
    });
}