var addressUrl = $("#addressUrl").val();

$( window ).on( "load", function() {
    console.log( "window loaded" );
    //var optionValue = $("#selectedSchoolYear").val();
    //$("#selectSchoolYear").val(optionValue).find("option[value=" + optionValue +"]").attr('selected', true);;
});

$("#selectStudentSubmit").click(function(){
    //console.log("test");
    //alert("test");
    //$("#schedSearchSubmit").prop('disabled', false);
    
    if ($("#studentNumber").val()) 
    {
        //getStudentInfo();
        if (!$.isNumeric($("#studentNumber").val())) 
        {
            alert("Please input correct format for Student Number.");
            return;
        }
        

        $("#selectStudentForm").submit();
    }
    else
    {
        alert("Please input data");
        return;
    }
    

});

function sample()
{
    $("#largeModal").modal('show');
}

$("#reservationListButton").click(function(){
    
    
    $("#unAppliedReservations").modal('show');

});

$("#paymentListButton").click(function(){
    
    
    $("#paymentList").modal('show');

});

$("#enrollmentButton").click(function(){
   
    
    $("#enrollmentModal").modal('show');

});

$("#reservationButton").click(function(){
    
    
    $("#reservationModal").modal('show');

});

$("#reservationInsertButton").click(function(){
    
    
    if ($("#referenceNoRes").val() && $("#semesterRes").val() && $("#schoolYearRes").val() && 
    $("#paymentTypeRes").val() && $("#orNoRes").val() && $("#amountRes").val()) 
    {
        //check OR number for duplication
       
        ajax = $.ajax({
            async: false,
            url: window.addressUrl+"/check_or",
            type: 'GET',
            data: {
                or_no: $("#orNoRes").val()
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
            $("#insertReservation").submit();
        }
    }
    else
    {
        alert("Incomplete details")
    }

});

$("#matriculationInsertButton").click(function(){
    
    
    if ($("#referenceNo").val() && $("#semester").val() && $("#schoolYear").val() && 
    $("#paymentType").val() && $("#orNo").val() && $("#amount").val() && $("#transactionType").val()) 
    {
        //check OR number for duplication
       
        ajax = $.ajax({
            async: false,
            url: window.addressUrl+"/check_or",
            type: 'GET',
            data: {
                or_no: $("#orNo").val()
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
            $("#insertMatriculation").submit();
        }
    }
    else
    {
        alert("Incomplete details")
    }

});

$("#selectBEDStudentSubmit").click(function(){
    //console.log("test");
    //alert("test");
    //$("#schedSearchSubmit").prop('disabled', false);
    
    if ($("#studentNumber").val()) 
    {
        //getStudentInfo();
        if (!$.isNumeric($("#studentNumber").val())) 
        {
            alert("Please input correct format for Student Number.");
            return;
        }
        

        $("#selectStudentForm").submit();
    }
    else
    {
        alert("Please input data");
        return;
    }
    

});

$("#bedReservationInsertButton").click(function(){
    
    
    if ($("#referenceNoRes").val() && $("#schoolYearRes").val() && 
    $("#paymentTypeRes").val() && $("#orNoRes").val() && $("#amountRes").val()) 
    {
        //check OR number for duplication
       
        ajax = $.ajax({
            async: false,
            url: window.addressUrl+"/bed_check_or",
            type: 'GET',
            data: {
                or_no: $("#orNoRes").val()
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
            $("#insertReservation").submit();
        }
    }
    else
    {
        alert("Incomplete details");
        //console.log($("#referenceNoRes").val());
        //console.log($("#schoolYearRes").val());
        //console.log($("#orNoRes").val());
        //console.log($("#amountRes").val());
        
    }

});

$("#bedMatriculationInsertButton").click(function(){
    
    
    if ($("#referenceNo").val() && $("#schoolYear").val() && 
    $("#paymentType").val() && $("#orNo").val() && $("#amount").val() && $("#transactionType").val()) 
    {
        //check OR number for duplication
       
        ajax = $.ajax({
            async: false,
            url: window.addressUrl+"/bed_check_or",
            type: 'GET',
            data: {
                or_no: $("#orNo").val()
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
            $("#insertMatriculation").submit();
            /*
            console.log($("#referenceNo").val());
            console.log($("#gradeLevel").val());
            console.log($("#schoolYear").val());
            console.log($("#paymentType").val());
            console.log($("#orNo").val());
            console.log($("#amount").val());
            console.log($("#transactionType").val());
            */
        }
    }
    else
    {
        alert("Incomplete details")
    }

});

$("#track").change(function(){
    
   console.log($("#track").val());

    ajax = $.ajax({
        async: false,
        url: window.addressUrl+"/get_strand_list",
        type: 'GET',
        data: {
            track: $("#track").val()
        },  

        success: function(response){

            result = JSON.parse(response);
        

        },
        fail: function(){
            alert('Request failed');
        }
    });
    
    if(result.checker == 1)
    {
        $("#strandDiv").html("");
        $("#strandDiv").append($("<select/>").attr({id: 'strandList', class: 'form-control show-tick',  name: 'strand'}));
        $("#strandList").append(new Option("Select Strand", ""));
        $.each(result.output, function( index, strand ) {
            console.log(strand.Strand_Title);
            $('#strandList').append(new Option(strand.Strand_Title, strand.Strand_Code));
        });
       // return;
    }


});

$("#shsReservationInsertButton").click(function(){
    
    
    if ($("#referenceNoRes").val() && $("#schoolYearRes").val() && 
    $("#paymentTypeRes").val() && $("#orNoRes").val() && $("#amountRes").val() && 
    $("#gradeLevelRes").val() && $("#trackRes").val() && $("#strandRes").val()) 
    {
        //check OR number for duplication
       
        ajax = $.ajax({
            async: false,
            url: window.addressUrl+"/bed_check_or",
            type: 'GET',
            data: {
                or_no: $("#orNoRes").val()
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
            
            $("#insertReservation").submit();
        }
    }
    else
    {
        alert("Incomplete details");
       
        
    }

});

$("#shsMatriculationInsertButton").click(function(){
    
    
    if ($("#referenceNo").val() && $("#gradeLevel").val() && $("#schoolYear").val() && 
    $("#paymentType").val() && $("#orNo").val() && $("#amount").val() && $("#transactionType").val() && 
    $("#trackRes").val() && $("#strandRes").val()) 
    {
        //check OR number for duplication
       
        ajax = $.ajax({
            async: false,
            url: window.addressUrl+"/bed_check_or",
            type: 'GET',
            data: {
                or_no: $("#orNo").val()
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
            $("#insertMatriculation").submit();
            
        }
    }
    else
    {
        alert("Incomplete details")
    }

});