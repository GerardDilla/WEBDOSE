$("#selectStudentNumber").click(function(){
    //console.log("test");
    //alert("test");
    //$("#schedSearchSubmit").prop('disabled', false);
    
    if ($("#studentNumber").val()) 
    {
        getStudentInfo();
    }
    else
    {
        alert("Please input data");
    }


});

$("#exportFormButton").click(function(){
    //console.log("test");
    //alert("test");
    //$("#schedSearchSubmit").prop('disabled', false);

    if ( !$("#courseCompleted").val() || !$("#recordRemarks").val() || !$("#recordReferenceNo").val() ||  !$('#transferAdmission').val() ) 
    {
        alert("Please fill up the form");
        return;
       
    }

    //check if student is elementary or juniorhigh
    arrayElem = ['G1', 'G2', 'G3', 'G4', 'G5', 'G6'];
    arrayJuniorSHS = ['G7', 'G8', 'G9', 'G10', 'G11', 'G12'];

    if( $.inArray($("#studentGradeLevel").val(), arrayElem) != -1 )
    {
        //alert("is elementary");
        urlFunction = "elementary_permanent_academic_record";
    }
    else if( $.inArray($("#studentGradeLevel").val(), arrayJuniorSHS) != -1 )
    {
        if(!$("#form137Selector").val())
        {
            alert("Please fill up the form");
            return;
        }

        if($("#form137Selector").val() == "elementary")
        {
            urlFunction = "elementary_permanent_academic_record";
        }
        else
        {
            urlFunction = "juniorhigh_permanent_academic_record";
        }
        //alert("is junior");
        
    }
    else
    {
        alert("error");
        return;
    }

    $('#exportForm').attr('action', $("#addressUrl").val()+"/"+urlFunction);

    $("#exportForm").submit();


});

function getStudentInfo()
{
    //set form disabled to true
    $("#formExport :input").prop('disabled', true);
    $("#formExport :input").val("");

   studentNumber = $("#studentNumber").val();
   if (!studentNumber) 
   {
       alert("Please input Student Number");
       return;
   }

   if (!$.isNumeric(studentNumber)) 
   {
       alert("not numeric");
       return;
   }

    url =  $("#addressUrl").val();
    ajax = $.ajax({
        async: false,
        url: url+"/get_student_info",
        type: 'GET',
        data: {
            studentNumber: studentNumber
        },  

        success: function(response){

            result = JSON.parse(response);
           

        },
        fail: function(){
            alert('Request failed');
        }
    });

    if(result.checker == 0)
    {
        alert(result.message);
        return;
    }
    else
    {
       console.dir(result.output);
    }

    $.each(result.output, function( index, value ) 
    {
        studentName = value.Last_Name+", "+value.First_Name+" "+value.Middle_Name;
        gradeLevel = value.Gradelevel;
      
    });

    $("#studentName").val(studentName.toUpperCase());
    $("#studentGradeLevel").val(gradeLevel);

    $("#hiddenStudentNumber").val(studentNumber);

    //set form disabled to false
    $("#formExport :input").prop('disabled', false);

    //check if student is elementary or juniorhigh
    arrayElem = ['G1', 'G2', 'G3', 'G4', 'G5', 'G6'];
    arrayJuniorSHS = ['G7', 'G8', 'G9', 'G10', 'G11', 'G12'];

    if( $.inArray($("#studentGradeLevel").val(), arrayJuniorSHS) != -1 )
    {
        //alert("is junior");
        $("#formSelector").append($("<select/>").attr({id: 'form137Selector', class: 'form-control',  name: 'form137_selector'}));
        $("#form137Selector").append(new Option("Select Form 137 type", ""));
        $("#form137Selector").append(new Option("Elementary", "elementary"));
        $("#form137Selector").append(new Option("Junior High", "juniorHigh"));
        $("#courseCompleted").attr('placeholder', 'Elementary course completed:');

    }
    else
    {
        $("#courseCompleted").attr('placeholder', 'Kindergarten completed:');
        $("#formSelector").html("");
    }


}

function exportFormExcel()
{
    console.log("enter export");
    if ( !$("#recordRemarks").val() || !$("#recordReferenceNo").val() ||  !$("#recordReleased").val() ) 
    {
        alert("Please fill up the form");
        return;
    }

    //check if student is elementary or juniorhigh
    arrayElem = ['G1', 'G2', 'G3', 'G4', 'G5', 'G6'];
    arrayJuniorSHS = ['G7', 'G8', 'G9', 'G10', 'G11', 'G12'];

    if( $.inArray($("#studentGradeLevel").val(), arrayElem) != -1 )
    {
        //alert("is elementary");
        urlFunction = "elementary_permanent_academic_record";
    }
    else if( $.inArray($("#studentGradeLevel").val(), arrayJuniorSHS) != -1 )
    {
        //alert("is junior");
        urlFunction = "juniorhigh_permanent_academic_record";
    }
    else
    {
        alert("error");
        return;
    }

    url =  $("#addressUrl").val();
    ajax = $.ajax({
        async: false,
        url: url+"/"+urlFunction,
        type: 'GET',
        data: {
            studentNumber: $("#studentNumber").val(),
            recordRemarks: $("#recordRemarks").val(),
            recordReferenceNo: $("#recordReferenceNo").val(),
            recordPrerared: $("#recordPrerared").val(),
            recordApproved: $("#recordApproved").val(),
            recordReleased: $("#recordReleased").val(),
            recordReleased: $("#recordVerified").val(),

        },  

        success: function(response){

            //window.open(url,'_blank' );
           

        },
        fail: function(){
            alert('Request failed');
        }
    });

    

}

$("").click(function(){
    $("#formTransferee").modal("show");
});


$("#shsSelectStudentNumber").click(function(){
    
    
    if ($("#studentNumber").val()) 
    {
        getShsStudentInfo();
    }
    else
    {
        alert("Please input data");
    }


});

function getShsStudentInfo()
{
    //set form disabled to true
    $(".formExport :input").prop('disabled', true);
    $(".formExport :input").val("");
    $(".entranceDataCheckBox").prop('disabled', true);
    $(".entranceDataCheckBox").prop('checked', false);

    $(".graduatedCheckBox").prop('disabled', true);
    $(".graduatedCheckBox").prop('checked', false);

   studentNumber = $("#studentNumber").val();
   if (!studentNumber) 
   {
       alert("Please input Student Number");
       return;
   }

   if (!$.isNumeric(studentNumber)) 
   {
       alert("not numeric");
       return;
   }

    url =  $("#addressUrl").val();
    ajax = $.ajax({
        async: false,
        url: url+"/get_shs_student_info",
        type: 'GET',
        data: {
            studentNumber: studentNumber
        },  

        success: function(response){

            result = JSON.parse(response);
           

        },
        fail: function(){
            alert('Request failed');
        }
    });

    if(result.checker == 0)
    {
        alert(result.message);
        return;
    }
    else
    {
       console.dir(result.output);
    }
    console.log(result.birthDate);

    $.each(result.output, function( index, value ) 
    {
        studentName = value.Last_Name+", "+value.First_Name+" "+value.Middle_Name;
        gradeLevel = value.Gradelevel;
      
    });

    $("#studentName").val(studentName.toUpperCase());
    $("#studentGradeLevel").val(gradeLevel);

    $("#hiddenStudentNumber").val(studentNumber);

    $("#elementarySchoolName").val(result.elementarySchoolName);
    $("#elementaryYear").val(result.elementarySchoolGraduated);
    $("#secondarySchoolName").val(result.secondarySchoolName);
    $("#secondaryYear").val(result.secondarySchoolGraduated);
    $("#birthDate").val(result.birthDate);
    

    //set form disabled to false
    $(".formExport :input").prop('disabled', false);
    $(".entranceDataCheckBox").prop('disabled', false);
    $(".graduatedCheckBox").prop('disabled', false);

    $("#graduationDate").prop('disabled', true);

    $(".dateGraduated").hide();
    
    

}

$(".graduatedCheckBox").click(function(){

    if ($(".graduatedCheckBox").is(":checked")) {
        $(".dateGraduated").show();
        $("#graduationDate").prop('disabled', false);
        $("#graduationDate").val("");
    }
    else {
        $(".dateGraduated").hide();
        $("#graduationDate").prop('disabled', true);
        $("#graduationDate").val("");
    }
    

});

$( document ).ready(function() {
    //hide date graduated on page load
    $(".dateGraduated").hide(); 
    $("#graduationDate").prop('disabled', true);
    $("#graduationDate").val("");

});

$("#exportShsFormButton").click(function(){
    //console.log("test");
    //alert("test");
    //$("#schedSearchSubmit").prop('disabled', false);

    if ( !$("#recordRemarks").val() || !$("#recordReferenceNo").val() || !$("#birthDate").val() || !$("#admissionDate").val()) {
        alert("Please fill up the form");
        return;
       
    }
    if ($(".graduatedCheckBox").is(":checked") ) {
        if (!$("#graduationDate").val()) {
            alert("Please fill up the form");
            return;
        }
        
    }

    

    $('#exportForm').attr('action', $("#addressUrl").val()+"/shs_permanent_academic_record");

    $("#exportForm").submit();


});