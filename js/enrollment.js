var addressUrl = $("#addressUrl").val();
var baseurl_link = $("#baseurl_link").data('baseurl');


$("#jsTest").click(function() {
    alert("Handler for .click() called.");
});


$("#enrollmentSubmit").click(function() {
    if (!$("#schoolYear").val() || !$("#gradeSelector").val()) {
        alert("Please select School Year and Grade Level.");
        return;
    }
    schoolYear = $("#schoolYear").val();
    gradeLevel = $("#gradeSelector").val();

    if (($("#gradeSelector").val() == "G11") || ($("#gradeSelector").val() == "G12")) {
        shsTrack = $("#shsTrack").val();
        shsStrand = $("#shsStrand").val();
        checkSeniorHighFee(schoolYear, gradeLevel, shsTrack, shsStrand);
    } else {
        checkBasicedFee(schoolYear, gradeLevel);
    }


});

function checkBasicedFee(schoolYear, gradeLevel) {
    ajax = $.ajax({
        async: false,
        url: baseurl_link + "index.php/DoseAdmin/ajax_basiced_fees_checker",
        type: 'GET',
        data: {
            schoolYear: schoolYear,
            gradeLevel: gradeLevel
        },

        success: function(response) {
            // console.log(response);
            result = JSON.parse(response);
        },
        fail: function() {
            alert('Request failed');
        }
    });

    if (result.checker == 0) {
        $("#errorHandling").modal("show");
        alert(result.message);
        $("#errorMessage").html(result.message);
        return;
    } else {
        $("#enrollmentForm").submit();
    }
}

function checkSeniorHighFee(schoolYear, gradeLevel, shsTrack, shsStrand) {
    ajax = $.ajax({
        async: false,
        url: baseurl_link + "index.php/DoseAdmin/ajax_shs_fees_checker",
        type: 'GET',
        data: {
            schoolYear: schoolYear,
            gradeLevel: gradeLevel,
            shsTrack: shsTrack,
            shsStrand: shsStrand
        },

        success: function(response) {
            console.log(response);
            result = JSON.parse(response);


        },
        fail: function() {
            alert('Request failed');
        }
    });

    if (result.checker == 0) {
        $("#errorHandling").modal("show");
        alert(result.message);
        $("#errorMessage").html(result.message);
        return;
    } else {
        $("#enrollmentForm").submit();
    }

}