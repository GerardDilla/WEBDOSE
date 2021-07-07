<script>
    function course_major1(str, name) {
        if (str == "") {
            document.getElementById("major1").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("major1").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/ajax_input?course='; ?>" + str + "&master=" + name, true);
            xmlhttp.send();
            // BELL-BELL 2.17.21
            document.getElementById("highered_1st_choice_program_code").value = str;
            //
        }
    }

    function course_major2(str, name) {
        console.log(str.name);
        if (str == "") {
            document.getElementById("major2").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("major2").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/ajax_input?course='; ?>" + str + "&master=" + name, true);
            xmlhttp.send();
            // BELL-BELL 2.17.21
            document.getElementById("highered_2nd_choice_program_code").value = str;
            //
        }
    }

    function course_major3(str, name) {
        if (str == "") {
            document.getElementById("major3").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("major3").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/ajax_input?course='; ?>" + str + "&master=" + name, true);
            xmlhttp.send();
            // BELL-BELL 2.17.21
            document.getElementById("highered_3rd_choice_program_code").value = str;
            //
        }
    }


    function set_major(str, name) {
        if (str == "") {
            document.getElementById("sample").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("sample").innerHTML = xmlhttp.responseText;
                }
            }

            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/save_major?major_id='; ?>" + str + "&major_num=" + name, true);
            xmlhttp.send();
        }
    }


    function seniorhigh_stand(str) {
        if (str == "") {
            document.getElementById("seniorhigh_strand").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("seniorhigh_strand").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/seniorhigh_strand?track='; ?>" + str, true);
            xmlhttp.send();
        }
    }


    function seniorhigh_stand_assessment(str) {
        if (str == "") {
            document.getElementById("seniorhigh_stand_assessment").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("seniorhigh_stand_assessment").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/seniorhigh_strand?track='; ?>" + str, true);
            xmlhttp.send();
        }
    }


    function seniorhigh_track(str) {
        if (str == "") {
            document.getElementById("seniorhigh_track").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("seniorhigh_track").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/ajax_seniorhigh_track?grade_level='; ?>" + str, true);
            xmlhttp.send();
        }
    } // end seniorhigh_track

    function set_strand(str) {
        if (str == "") {
            document.getElementById("strand_set").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("strand_set").innerHTML = xmlhttp.responseText;
                }
            }

            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/save_strand?strand_code='; ?>" + str, true);
            xmlhttp.send();
        }
    }


    function address(val1, val2, option_only = 0) {
        if (val1 == "") {
            document.getElementById(val1).innerHTML = "";
            return;
        } else {

            if (val1 == "Address_Province") {
                document.getElementById("Address_City").innerHTML = "Barangay";
            }

            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById(val1).innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/address?type='; ?>" + val1 + "&value=" + val2 + "&option_only=" + option_only, true);
            xmlhttp.send();
        }
    }

    function foreign_form(val) {
        if ((val == "") || (val == "FILIPINO")) {
            document.getElementById("foreign_form").innerHTML = "";
            return;
        } else {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("foreign_form").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo site_url() . '/DoseAdmin/foreign_form?type='; ?>" + val, true);
            xmlhttp.send();
        }
    }

    /////////////////////////////////////////////////
    function checker() {
        // xmlhttp = new XMLHttpRequest();
        // if (window.XMLHttpRequest) {
        //         // code for IE7+, Firefox, Chrome, Opera, Safari
        //         xmlhttp = new XMLHttpRequest();
        //     } else {
        //         // code for IE6, IE5
        //         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        //     }

    }

    $('#enrollmentButton').click(function() {
        //alert('enrollment button click');
        console.log('enrollment button click');
        if (($('#gradeSelector').val() == 'G11') || ($('#gradeSelector').val() == 'G12')) {
            console.log('enter g11 or g12 condition');
            seniorhigh_track($('#gradeSelector').val());
        }
    });
</script>