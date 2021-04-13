function print_chart(){


    html2canvas(document.querySelector("#printMe")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard";
        document.getElementById("printMe").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Enrollment Summary Report</p>';
        windowContent += '<div style="margin-top: 170px;"></div>';
        windowContent += '<img src="' + dataUrl + '">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard').remove();
 
    });
}


function print_chart1(){


    html2canvas(document.querySelector("#printMe1")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard1";
        document.getElementById("printMe1").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard1').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Inquiry Summary Report</p>';
        windowContent += '<div style="margin-top: 150px;"></div>';
        windowContent += '<div style="margin-left: 160px;">';
        windowContent += '<img src="' + dataUrl + '" height="350" width="500">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</div>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard1').remove();
 
    });
}


function print_chart2(){


    html2canvas(document.querySelector("#printMe2")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard2";
        document.getElementById("printMe2").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard2').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Reservation Summary Report</p>';
        windowContent += '<div style="margin-top: 150px;"></div>';
        windowContent += '<div style="margin-left: 160px;">';
        windowContent += '<img src="' + dataUrl + '" height="350" width="500">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</div>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard2').remove();
 
    });
}


function print_chart3(){


    html2canvas(document.querySelector("#printMe3")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard3";
        document.getElementById("printMe3").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard3').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Enrollment Summary Other Programs Report </p>';
        windowContent += '<div style="margin-top: 150px;"></div>';
        windowContent += '<div style="margin-left: 160px;">';
        windowContent += '<img src="' + dataUrl + '" height="350" width="500">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</div>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard3').remove();
 
    });
}



function print_chart4(){


    html2canvas(document.querySelector("#printMe4")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard4";
        document.getElementById("printMe4").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard4').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Enrollment Summary (New Students) Report </p>';
        windowContent += '<div style="margin-top: 150px;"></div>';
        windowContent += '<div style="margin-left: 160px;">';
        windowContent += '<img src="' + dataUrl + '" height="350" width="500">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</div>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard4').remove();
 
    });
}


function print_chart5(){


    html2canvas(document.querySelector("#printMe5")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard5";
        document.getElementById("printMe5").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard5').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Basic Education Bar Chart Report </p>';
        windowContent += '<div style="margin-top: 150px;"></div>';
        windowContent += '<img src="' + dataUrl + '">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard5').remove();
 
    });
}

function print_chart6(){


    html2canvas(document.querySelector("#printMe6")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard6";
        document.getElementById("printMe6").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard6').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Senior HighSchool Bar Chart Report </p>';
        windowContent += '<div style="margin-top: 150px;"></div>';
        windowContent += '<img src="' + dataUrl + '">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard6').remove();
 
    });
}


function print_chart7(){


    html2canvas(document.querySelector("#printMe7")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard7";
        document.getElementById("printMe7").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard7').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Higher Education Bar Chart Report </p>';
        windowContent += '<div style="margin-top: 150px;"></div>';
        windowContent += '<img src="' + dataUrl + '">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard7').remove();
 
    });
}

function print_chart_tracker(){


    html2canvas(document.querySelector("#printMe_tracker")).then(canvas => {
        //document.body.appendChild(canvas);
        canvas.id = "printDashboard_Tracker";
        document.getElementById("printMe_tracker").appendChild(canvas);

        const dataUrl = document.getElementById('printDashboard_Tracker').toDataURL(); 

        let windowContent = '<!DOCTYPE html>';
        windowContent += '<html>';
        windowContent += '<head>';
        windowContent += '<title>Print Chart</title>';
        windowContent += '</head>';
        windowContent += '<body>';
        windowContent += '<p style="text-align:center; font-weight: 900; font-size: 24px;">Enrollment Tracker Summary Report </p>';
        windowContent += '<div style="margin-top: 150px;"></div>';
        windowContent += '<div style="margin-left: 160px;">';
        windowContent += '<img src="' + dataUrl + '" height="350" width="500">';
        windowContent += '<script src="'+url+'js/temporary_regform.js"></script>';
        windowContent += '</div>';
        windowContent += '</body>';
        windowContent += '</html>';
        
        const printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
        printWin.document.open();
        printWin.document.write(windowContent); 
        
        printWin.document.addEventListener('load', function() {
            printWin.focus();
            printWin.print();
            printWin.document.close();
            printWin.close();         
        }, true);
        $('#printDashboard_Tracker').remove();
 
    });
}


