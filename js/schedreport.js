
$( document ).ready(function() {
    $( document ).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            searchsched_report();
        }
    });
    $('#searchkey').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            searchsched_report();
        }
    });
});
function searchsched_report(){
    
    //Sets inputs
    arrayData = {
        url:$('#ajaxurl').val(),
        class:$('#ajaxclass').val(),
        searchkey:$('#searchkey').val(),
        program:$('#program').val(),
        sy:$('#schedsy_report').val(),
        sem:$('#schedsem_report').val(),
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
    $('#searchedsem').html(arrayData.sem);
    $('#searchedsy').html(arrayData.sy);

    counter = ajax_getsched_pages(arrayData);
    counter.success(function(pages){
        content = ajax_getsched(arrayData);
        content.success(function(response){
            $('#schedreport_browser').fadeIn('slow');
            $('#sched_report_pagination').pagination({
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
        url: arrayData.url+"index.php/"+arrayData.class+"/ajax_schedreport_search",
        type: 'GET',
        data: {
            searchkey: arrayData.searchkey,
            program: arrayData.program,
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
function export_excel(arrayData){
    //Sets inputs
    arrayData = {
        url:$('#ajaxurl').val(),
        searchkey:$('#searchkey').val(),
        class:$('#ajaxclass').val(),
        program:$('#program').val(),
        sy:$('#schedsy_report').val(),
        sem:$('#schedsem_report').val(),
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

    $.ajax({
        url: arrayData.url+"index.php/"+arrayData.class+"/ajax_SchedReport_Excel",
        type: 'GET',
        dataType:'json',
        data: {
            searchkey: arrayData.searchkey,
            program: arrayData.program,
            sy: arrayData.sy,
            sem: arrayData.sem,
            offset: offset,
            perpage: arrayData.perPage
        },
        success:function(response){
            var $a = $("<a>");
            $a.attr("href",response.file);
            $("body").append($a);
            $a.attr("download","Schedule_Report.xls");
            $a[0].click();
            //$a.remove();
        },
        fail: function(){
            alert('Export failed');
        }

    });
}
function ajax_getsched_pages(arrayData){
   
    return $.ajax({
        url: arrayData.url+"index.php/"+arrayData.class+"/ajax_schedreport_search_pagination",
        type: 'GET',
        data: {
            searchkey: arrayData.searchkey,
            program: arrayData.program,
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
        showtable.append(row);

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
