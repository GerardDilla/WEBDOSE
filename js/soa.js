$("#sendButton").click(function(){
    var programCode = $("#programCode").val();
    var schoolYear = $("#schoolYear").val();
    var semester = $("#semester").val();
    var term = $("#term").val();
    if ( !$("#programCode").val() || !$("#schoolYear").val() || !$("#semester").val() || !$("#term").val() || !$("#dueDate").val() ) 
    {
        alert("Please fill up the form");
        console.log(`logs ${programCode}, ${schoolYear}, ${semester}, ${term}`);
        return;
    }
    console.log(`logs ${$("#schoolYear").val()}`);

    $('#sendForm').attr('action', $("#addressUrl").val()+"/send_email");

    $("#sendForm").submit();
});