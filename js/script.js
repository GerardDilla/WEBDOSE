function search_student(){
    arrayData = {
        perPage:10,
        pageNumber:1,
    };
    page = get_info_pages(arrayData);
    console.log(`page number:${page}`)
    console.log(page.length);

    get_info(arrayData);
    $('#student_search_pagination').pagination({
        items: parseInt(page),
        itemsOnPage: arrayData.perPage,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber){
            arrayData['pageNumber'] = pageNumber;
            get_info(arrayData);
        }
    });
}
function get_info_pages(arrayData){

    arrayData['searchkey'] = $('#student_searchkey').val();
    // console.log(arrayData['searchkey']);
    console.log('@get_info_pages');
    var educ_type = $('#search_education_type').val();
    arrayData['url'] = $('#url').val();
    ajax = $.ajax({
        async: false,
        url: arrayData.url+"/search_student_page",
        type: 'GET',
        data: {
            key: arrayData.searchkey,
            educ_type:educ_type
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


    arrayData['searchkey'] = $('#student_searchkey').val();
    arrayData['url'] = $('#url').val();
    console.log('@get_info: '+arrayData['searchkey']);

    offset = (arrayData.pageNumber - 1) * arrayData.perPage;
    var educ_type = $('#search_education_type').val();
    ajax = $.ajax({
        async: false,
        url: arrayData.url+"/search_student",
        type: 'GET',
        data: {
            key: arrayData.searchkey,
            limit: arrayData.perPage,
            offset: offset,
            educ_type:educ_type
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
    console.log(arraySession);
    if(arraySession.length == 0){
        row = $("<tr/>");
        row.append($("<td/>").text('NO RESULTS: Try a difference search term')).css('text-align','center');
        showtable.append(row);
    }
    $.each(arraySession, function(index, result) 
    {
        row = $("<tr/>");
        row.append($("<td/>").append('\
        <button class="btn btn-info btn-sm copybtn" data-clipboard-text="'+result['Student_Number']+'">\
        <i class="material-icons">content_copy</i>\
        </button> '+
        result['Student_Number']
        ));

        row.append($("<td/>").append('\
        <button class="btn btn-info btn-sm copybtn" data-clipboard-text="'+result['Reference_Number']+'">\
        <i class="material-icons">content_copy</i>\
        </button> '+
        result['Reference_Number']
        ));
        
        //row.append($("<td/>").text(result['Reference_Number']));
        row.append($("<td/>").text(result['First_Name']+" "+result['Middle_Name']+" "+result['Last_Name']));

        row.append($("<td/>").append('\
        <button class="btn btn-info btn-sm copybtn" data-clipboard-text="http://stdominiccollege.edu.ph/EnrollmentTracker/?rn='+result['Reference_Number']+'">\
        <i class="material-icons">content_copy</i>\
        </button>'
        ));

        showtable.append(row);

    });
        
}
function searchstudent_modal(modal_command){
    modal = $('#studentsearch_modal');
    if(modal_command == 1){
        modal.modal('show');
       
        $('#studentsearch_modal').on('shown.bs.modal', function() {
            $('#student_searchkey').focus();
        });
        $('#studentsearch_modal').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                search_student();
            }
        });
    }else{
        modal.modal('hide');
    }

}

$( document ).ready(function() {
    //new ClipboardJS('.copybtn');
    var clipboard = new ClipboardJS('.copybtn',{ container: studentsearch_modal });

    clipboard.on('success', function(e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        $("#clipboardcopy").fadeIn();
        setInterval(function(){ 

            $("#clipboardcopy").fadeOut();
        
        }, 1500);
        //e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
});
