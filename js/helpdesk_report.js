

$(document).ajaxStart(function() {
    $(".loading").show();
});
$(document).ajaxStop(function() {
    $(".loading").hide();
});

$(document).ready(function(){

    $('.filterModal').click(function(){

        showFiltersModal();

    });

    $('#addFilter').click(function(e){
        e.preventDefault();
        AddFilters();
    });

    $('.ActiveFilters').on('click','.removeFilter',function(){

        RemoveFilter(this);

    });


});

function showFiltersModal(toggle = 1){

    if(toggle == 1){
        $('#herpdeskFilterModal').modal('show');
    }else{
        $('#herpdeskFilterModal').modal('hide');
    }
    

}

function AddFilters(){


    if(DateRangeValidation() == false){
        return;
    }

    outputs = filterInputs();
    $.each(outputs,function(filter,value){
        
        //Limit date range filter to 1 
        if(filter == 'Date Range'){
            $('.ActiveFilters').find("[data-type='Date Range']").remove();
        }

        //TEMPORARY: Limit search key filter to 1 
        if(filter == 'Search Key'){
            //$('.ActiveFilters').find("[data-type='Search Key']").remove();
        }

        //Removes filters with same value
        $('.ActiveFilters').find("[data-value='"+value+"']").remove();
       
        //Appends newly added filter
        if(value != ''){
            $('.ActiveFilters').append(filterOutput(filter,value));
        }
        

    });
    showFiltersModal(0);
    FilterTable();

}

function RemoveFilter(filter){

    $(filter).parent().parent().remove();
    FilterTable();

}

function FilterTable(){

    filters = getFilters();
    helpdeskdata = getHelpdeskData(filters);
    helpdeskdata.done(function(result){

        result = JSON.parse(result);
        console.log(result);
        //DisplayTable(data);
        table = $('#ReportTable').DataTable();
        table.destroy();
        table = $('#ReportTable').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "scrollY":        false,
            "scrollX":        "100vh",
            "scrollCollapse": true,
            //"fixedColumns":   true,
            "searching": false,
            "data": result['data'],
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 11, 'asc' ]],
            "columns": [
                { "data": "InquirerName" },
                { "data": "InquirerName" },
                { "data": "InquirerEmail" },
                { "data": "ContactNumber" },
                { "data": "StudentNumber" },
                { "data": "TopicCategory" },
                { "data": "School_Name" },
                { "data": "StudentStrand" },
                { "data": "Program_Code" },
                { "data": "Inquiry" },
                { "data": "Resolved" },
                { "data": "DateSubmitted" }
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-name', data.InquirerName);
                $(row).attr('data-email', data.InquirerEmail);
                $(row).attr('data-contact', data.ContactNumber);
                $(row).attr('data-studentnumber', data.StudentNumber);
                $(row).attr('data-education', data.TopicCategory);
                $(row).attr('data-department', data.School_Name);
                $(row).attr('data-strand', data.StudentStrand);
                $(row).attr('data-program', data.Program_Code);
                $(row).attr('data-datesubmit', data.DateSubmitted);
                $(row).attr('data-resolved', data.Resolved);
                $(row).attr('data-inquiry', data.Inquiry);
                
            },
            dom: 'Bfrtip',
            buttons: {
                buttons: [
                    { extend: 'excel', Text: 'EXPORT', title:'Helpdesk Report', className: 'btn-danger exportButton' },
                    { extend: 'print', Text: 'PRINT',  title:'Helpdesk Report', className: 'btn-danger exportButton'}
                ],
                dom: {
                    button: {
                        className: 'btn'
                    }
                }
            },
            rowCallback: function (row, data) {
                $(row).addClass('rowpointer');
            }

            
        });
        table.columns( [4,6,7,8,9] ).visible( false );
        table.on( 'buttons-processing', function ( e, indicator ) {
            if (indicator) {
                table.columns( [4,6,7,8,9] ).visible( true );
            }
            else {
                table.columns( [4,6,7,8,9] ).visible( false );
            }
        } );
        
        table.buttons().container().appendTo( '.exportResults' );
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        
        $('.dataTable').on('click', 'tr', function() {

          showRowInformation($(this));

        });

    });

}

function getFilters(){

    filters = {
        searchkey:[],
        datefrom:[]
    }
    $('.Filter').each(function(index){
        console.log($(this).data('type')+' - '+$(this).data('value'));
        if($(this).data('type') == 'Search Key'){
            filters['searchkey'].push($(this).data('value'));
        }
        else if($(this).data('type') == 'Date Range'){
            filters['datefrom'] = filters['datefrom'].concat($(this).data('range').split(','));
        }
        
    });
    console.log(filters);
    return filters;
    
}

function filterInputs(){

    inputs = {
        'Search Key':$('#searchkey').val(),
        'Date Range':$('#datefrom').val() == '' || $('#dateto').val() == '' ? '' : [$('#datefrom').val(),$('#dateto').val()],
        'Strand':'',
        'Program':'',
        'Education':'',
        'Concern':''
    }
    output = {};
    $.each(inputs,function(index,row){

        if(index == 'Date Range'){
            value = row[0]+' - '+row[1];
        }else{
            value = row;
        }
        if(row == ''){

            output[index] = '';

        }else{

            output[index] = value;
            
        }
    });
    return output;

}

function DateRangeValidation(){

    from = $('#datefrom').val() != '' ? $('#datefrom').val() : 0;
    to = $('#dateto').val() != '' ? $('#dateto').val() : 0;
    
    if(from != 0 || to != 0){
       
        if(from.toString() >= to.toString()){
            alert('Please input a proper date range');
            return false;
        }

    }
    return true;
}

function getHelpdeskData(filters = {}){

    return ajax = $.ajax({
        async: false,
        url: baseurl+"index.php/Executive/getHelpdeskInquiries",
        type: 'GET',
        data: filters,
        fail: function(){
            alert('request failed');
        }
    });

}

function DisplayTable(tabledata = {}){

    $('#ReportTable tbody').html();
    $.each(tabledata,function(index,row){
        index = index + 1;
        output = '\
            <tr>\
                <td>'+index+'</td>\
                <td>'+row['InquirerName']+'</td>\
                <td>'+row['InquirerEmail']+'</td>\
                <td>'+row['StudentNumber']+'</td>\
                <td>'+row['TopicCategory']+'</td>\
                <td>'+row['School_Name']+'</td>\
                <td>'+row['StudentStrand']+'</td>\
                <td>'+row['Program_Code']+'</td>\
                <td>'+row['Inquiry']+'</td>\
                <td>'+row['DateSubmitted']+'</td>\
            </tr>\
        ';
        $('#ReportTable tbody').append(output);
    });
    

}

function filterOutput(type = '', value = '',dates = {}){
    
    return '\
        <div class="col-md-4 Filter" data-type="'+type+'" data-value="'+value+'" data-range="'+value.split(" - ")+'">\
            <div class="alert bg-green alert-dismissible" style="padding: 10px;" role="alert">\
                <button type="button" style="right: 0px;" class="close removeFilter" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>\
                <p style="max-width:270px overflow:hidden"><b>'+type+': </b><span> '+value+'</span></p>\
            </div>\
        </div>\
    ';

}

function showRowInformation(row){

    $('#inquirerName').html(row.data('name'));
    $('#inquirerEmail').html(row.data('email'));
    $('#inquirerContact').html(row.data('contact'));
    $('#inquirerStudentID').html(row.data('studentnumber'));
    $('#inquirerEducation').html(row.data('education'));
    $('#inquirerStrand').html(row.data('strand'));
    $('#inquirerProgram').html(row.data('program'));
    $('#inquirerDate').html(row.data('datesubmit'));
    $('#inquirerInquiry').html(row.data('inquiry'));

    $('#helpdeskInquiryInfo').modal('show');

}
