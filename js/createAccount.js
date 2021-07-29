$('#saveChanges').on('click',function(e){
    var error_count = 0;
    $('.input-group').removeClass('is-invalid');
    $('#account_creation input.form-control[required]').each(function(){
        if(this.value==""){
            $(`.${this.id}-div`).addClass('is-invalid');
            $(this).focus();
            ++error_count;
        }
    })
    $('#account_creation select.form-control[required]').each(function(){
        if(this.value==""){
            $(`.${this.id}-div`).addClass('is-invalid');
            $(this).focus();
            ++error_count;
        }
    })
    // alert(error_count);
    if(error_count==0){
        $('#account_creation').submit();
    }
})
$('#saveChangesUpdate').on('click',function(){
    var error_count = 0;
    $('.input-group').removeClass('is-invalid');
    $('#update_account input.form-control[required]').each(function(){
        if(this.value==""){
            $(`.${this.id}-div`).addClass('is-invalid');
            $(this).focus();
            ++error_count;
        }
    })
    $('#update_account select.form-control[required]').each(function(){
        if(this.value==""){
            $(`.${this.id}-div`).addClass('is-invalid');
            $(this).focus();
            ++error_count;
        }
    })
    // alert(error_count);
    if(error_count==0){
        $('#update_account').submit();
    }
})
// $('#update_account').on('submit',function(e){
//     // e.preventDefault();
//     // console.log(e);
//     // return false;
    
// })