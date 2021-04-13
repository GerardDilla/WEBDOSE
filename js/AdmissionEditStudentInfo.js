


function disable() {
        $(".InfoEnabled").prop('disabled', false);
        $(".InfoEnabled").css("color", "black");
        $(".UpdateButton").css("display","block");
        $(".EditButton").css("display","none");
        $(".datepicker2").css("display","none");
        $(".datepicker").css("display","block");
        $(".DisabledEditButton").css("display","block");
}

function enabled() {
        $(".DisabledEditButton").css("display","none");
        $(".InfoEnabled").prop('disabled', true);
        $(".InfoEnabled").css("color", "#808080");
        $(".EditButton").css("display","block");
        $(".UpdateButton").css("display","none");
        $(".datepicker2").css("display","block");
        $(".datepicker").css("display","none");
}