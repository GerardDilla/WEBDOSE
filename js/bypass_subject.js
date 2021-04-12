//Check bypass button activity
/*
$(document).ready(function(){
    $('#bypass-subject').click(function(){
        if($(this).prop("checked") == true){
            $('#bypass-subject').prop('checked', false );
            $('#bypass-login').modal('show');
        }
    });
});

function bypass_continue(){
    //Sample Ajax, Change whats needed
    ajax = $.ajax({
        async: false,
        //url: inputs.url,
        type: 'GET',
        data: {
            user: 'Sample user name',
            pass: 'Sample pass',
        },  
        success: function(response){
            $('#bypass-login').modal('hide');
            $( "#bypass-subject" ).prop( "checked", true );
        },
        fail: function(){
            alert('request failed');
        }
    });

}
*/
