function selectsubjectenrolled(rowobject){
    
    //alert($(rowobject).data('scode'));
    //Puts the schedcode into the form

    //Sched Code
    schedcode_input = $('#sched_code_id');
    schedcode_view = $('#sched_code_view');
    schedcode_input.val($(rowobject).data('scode'));
    schedcode_view.attr("placeholder", "Sched Code: "+$(rowobject).data('scode'));

   //Course Code
    coursecode_input = $('#Course_code_id');
    coursecode_view = $('#Course_code_id_view');
    coursecode_input.val($(rowobject).data('course_code'));
    coursecode_view.attr("placeholder", "Course Code: "+$(rowobject).data('course_code'));

    //Course Title
    coursetitle_input = $('#Course_title_id');
    coursetitle_view  = $('#Course_title_id_view');
    coursetitle_input.val($(rowobject).data('course_title'));
    coursetitle_view.attr("placeholder", "Course Title: "+$(rowobject).data('course_title'));

    //Lecture Unit
    lec_input = $('#lec_id');
    lec_view  = $('#lec_id_view');
    lec_input.val($(rowobject).data('lec'));
    lec_view.attr("placeholder", "Course Lecture Unit: "+$(rowobject).data('lec'));

     //Lab Unit
     lab_input = $('#lab_id');
     lab_view  = $('#lab_id_view');
     lab_input.val($(rowobject).data('lab'));
     lab_view.attr("placeholder", "Course Lab Unit: " +$(rowobject).data('lab'));


   
 

    divscroller('top');
    console.log('selectsubject: Success');

}