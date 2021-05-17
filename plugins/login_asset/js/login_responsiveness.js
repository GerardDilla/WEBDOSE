$(document).ready(function(){
    // setTimout(()=>{
        $('body').scrollTop($('body')[0].scrollHeight - $('body')[0].clientHeight);
    // },1500) 
    console.log(parseInt($('.row.bg-white').height()) + 20)
    if($(window).width()==1024&&$(window).height()==1366){
        $('.first_row').removeClass('col-lg-7');
        // $('.first_row').removeClass('col-lg-6');
        $('.first_row').addClass('col-lg-12');
        $('.second_row').removeClass('col-lg-7');
        // $('.second_row').removeClass('col-lg-6');
        $('.second_row').addClass('col-lg-12');
    }
    else{
        $('.first_row').removeClass('col-lg-12');
        $('.first_row').addClass('col-lg-7');
        // $('.first_row').addClass('col-lg-6');
        $('.second_row').removeClass('col-lg-12');
        // $('.second_row').addClass('col-lg-6');
        $('.second_row').addClass('col-lg-5');
    }
    if($(window).width()==768&&$(window).height()==1024){
        $('.first_row').removeClass('col-md-7');
        // $('.first_row').removeClass('col-md-6');
        $('.first_row').addClass('col-md-12');
        $('.second_row').removeClass('col-md-5');
        // $('.second_row').removeClass('col-md-6');
        $('.second_row').addClass('col-md-12');
    }
    else{
        $('.first_row').removeClass('col-md-12');
        $('.first_row').addClass('col-md-7');
        // $('.first_row').addClass('col-md-6');
        $('.second_row').removeClass('col-md-12');
        $('.second_row').addClass('col-md-5');
        // $('.second_row').addClass('col-md-6');
    }
    // if($(window).height()>$(window).width()){
    //     $('.login-row .form.d-flex').css('margin','1em auto 0 auto')
    //     $('.login-row form.form-validate').css('margin-top','50px')
    //     $('.form-holder .row.bg-white').css('height','auto')
    //     $('.first_row').css('height','100%')
    // }
    // else{
    //     $('.login-row .form.d-flex').css('margin','0 auto 0 auto')
    //     $('.login-row form.form-validate').css('margin-top','0')
    //     $('.first_row').css('height','auto')
    // }
    // if($(window).width()==1024&&$(window).height()==768){
    //     $('.login-page .container').css('height','auto')
        
    // }
    // else{
    //     $('.login-page .container').css('height','100%')
    // }
    // $('.page.login-page').css('height',`${parseInt($('.row.bg-white').height()) + 20}`)
    // if($(window).width()==1366&&$(window).height()==1024){
    //     $('.row.bg-white').css('height',`100vh`)
    //     $('.page.login-page').css('height',`100vh`)
    //     $('.first_row').css('height','100%')
    // }
    // else{
    //     $('.page.login-page').css('height',`${parseInt($('.row.bg-white').height()) + 20}`)
    // }
    // 
    
})


$(window).resize(function(){
    // console.log($(window).width());
    if($(window).width()==1024&&$(window).height()==1366){
        $('.first_row').removeClass('col-lg-7');
        // $('.first_row').removeClass('col-lg-6');
        $('.first_row').addClass('col-lg-12');
        $('.second_row').removeClass('col-lg-7');
        // $('.second_row').removeClass('col-lg-6');
        $('.second_row').addClass('col-lg-12');
    }
    else{
        $('.first_row').removeClass('col-lg-12');
        $('.first_row').addClass('col-lg-7');
        // $('.first_row').addClass('col-lg-6');
        $('.second_row').removeClass('col-lg-12');
        // $('.second_row').addClass('col-lg-6');
        $('.second_row').addClass('col-lg-5');
    }
    if($(window).width()==768&&$(window).height()==1024){
        $('.first_row').removeClass('col-md-7');
        // $('.first_row').removeClass('col-md-6');
        $('.first_row').addClass('col-md-12');
        $('.second_row').removeClass('col-md-5');
        // $('.second_row').removeClass('col-md-6');
        $('.second_row').addClass('col-md-12');
    }
    else{
        $('.first_row').removeClass('col-md-12');
        $('.first_row').addClass('col-md-7');
        // $('.first_row').addClass('col-md-6');
        $('.second_row').removeClass('col-md-12');
        $('.second_row').addClass('col-md-5');
        // $('.second_row').addClass('col-md-6');
    }
    // if($(window).width()==1024&&$(window).height()==768){
    //     $('.login-page .container').css('height','auto')
        
    // }
    // else{
    //     $('.login-page .container').css('height','100%') 
    // }
    // $('.page.login-page').css('height',`${parseInt($('.row.bg-white').height()) + 20}`)
    // if($(window).width()==1366&&$(window).height()==1024){
    //     $('.row.bg-white').css('height',`100vh`)
    //     $('.page.login-page').css('height',`100vh`)
    //     $('.first_row').css('height','100%')
    // }
    // else{
    //     $('.page.login-page').css('height',`${parseInt($('.row.bg-white').height()) + 20}`)
    //     $('.row.bg-white').css('height',`auto`)
    //     $('.page.login-page').css('height',`auto`)
    // }
})