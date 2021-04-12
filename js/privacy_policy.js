/*
$('#policy_agree').fadeOut();
$('#PolicyContainer').on("scroll", function() {
	var scrollHeight = $(document).height();
  var scrollPosition = $(window).height() + $(window).scrollTop();
  console.log('height:'+scrollHeight+' - position:'+scrollPosition);
  //console.log('position:'+scrollPosition);
  console.log('fadein:'+(scrollHeight - scrollPosition) / scrollHeight);
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {

      $('#policy_agree').fadeIn();
    }
    if(scrollPosition == 657){
        
        $('#policy_agree').fadeIn();
    }
});
*/

function get_privacy_inputs(){

    array = {
        id: $('#privacy_id').val(),
        sys: $('#privacy_system').val(),
        url: $('#privacy_base_url').val(),
    }
    return array;

}
//Automatically shows privacy policy when not agreed yet
function policy_agree_check(){

    inputs = get_privacy_inputs();
    ajax = $.ajax({
        async: false,
        url: inputs.url+"index.php/PolicyHandler/CheckAgreement",
        type: 'GET',
        data: {
            id: inputs.id,
            sys: inputs.sys,
        },  
        success: function(response){

            if(response >= 1){
                console.log('Already Agreed');
            }else{
                agree_button_timer();
                $('#privacy_policy_modal').modal({keyboard:false,backdrop:'static'});
                view_privacy_policy('show');
            }

        },
        fail: function(){
            alert('request failed');
        }
    });

}
function policy_agree(){


    inputs = get_privacy_inputs();
    ajax = $.ajax({
        async: false,
        url: inputs.url+"index.php/PolicyHandler/PrivacyPolicy",
        type: 'GET',
        data: {
            id: inputs.id,
            sys: inputs.sys,
        },  
        success: function(response){

            blur(0);
            $('#privacy_policy_modal').modal('hide');

        },
        fail: function(){
            alert('request failed');
        }
    });

}
function view_privacy_policy(show = ''){
    if(show == 'show'){
        $('#policy_options').fadeIn();
    }else{
        $('#policy_options').fadeOut();
    }
    $('#privacy_policy_modal').modal({keyboard:true,backdrop:'true'});
}
function blur(toggle = ''){

    var filterVal = 'blur(0px)';
    if(toggle == 1){
        var filterVal = 'blur(5px)';
    }
    //Change objects for blurring
    $('.navbar')
    .css('filter',filterVal)
    .css('webkitFilter',filterVal)
    .css('mozFilter',filterVal)
    .css('oFilter',filterVal)
    .css('msFilter',filterVal);


    $('#leftsidebar')
    .css('filter',filterVal)
    .css('webkitFilter',filterVal)
    .css('mozFilter',filterVal)
    .css('oFilter',filterVal)
    .css('msFilter',filterVal);


    $('.body-container')
    .css('filter',filterVal)
    .css('webkitFilter',filterVal)
    .css('mozFilter',filterVal)
    .css('oFilter',filterVal)
    .css('msFilter',filterVal);
}
function agree_button_timer(){

    count = 5;
    $('#policy_agree').prop('disabled', true);
    blur(1);
    var x = setInterval(function() {

        $("#policy_agree").html('BUTTON WILL BE AVAILABLE IN: '+count);
        count--;
        //console.log(count);
        if(count == 0){
            $("#policy_agree").html('PROCEED');
            $('#policy_agree').prop('disabled', false);
            clearInterval(x);
        }
    }, 1000);

}