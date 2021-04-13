
$(document).ready(function(){

    Hed_Fetch_New_Students();
    Hed_Fetch_Old_Students();
    Hed_Fetch_Withdraw_Students();
    Hed_Fetch_Reserved_Students();
    BED_Fetch_New_Students();
    BED_FETCH_OLD_STUDENTS();
    SHS_Fetch_New_Students();
    SHS_FETCH_OLD_STUDENTS();
    BED_FETCH_INQUIRY_STUDENTS();
    SHS_FETCH_INQUIRY_STUDENTS();
    HED_FETCH_INQUIRY();
    BED_FETCH_RESERVED_STUDENTS();
    SHS_FETCH_RESERVED_STUDENTS();
    OTHER_PROGRAMS();
    ShsStudents();
    
     
    var Dashboard_url = $("#base_url").val(); 


        $.ajax({
            url:Dashboard_url+"index.php/Executive/get_senior",
            success:function(data){
                result = JSON.parse(data);
                BarSHS(result);
            
            }

        });

        $.ajax({
            url:Dashboard_url+"index.php/Executive/get_basiced",
            success:function(data){
                result = JSON.parse(data);
                BarBED(result);
            
            }

        });


        $.ajax({
            url:Dashboard_url+"index.php/Executive/get_highered",
            success:function(data){
                result = JSON.parse(data);
                BarHigherEd(result);
            
            }

        });

        
});
 

///OTHER PROGRAMS
function OTHER_PROGRAMS(){
    var Dashboard_url = $("#base_url").val(); 

    $.ajax({
        url:Dashboard_url+"index.php/Executive/get_other_programs",
        success:function(data){
            result = JSON.parse(data);
            OTHERPROGRAMS(result);
        
        }

    });
}

///HED INQUIRY
function HED_FETCH_INQUIRY(){
    var Dashboard_url = $("#base_url").val(); 

    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_highered_inquiry",
        success:function(data){
                TotalInquiryHIGHERED = JSON.parse(data);
             $('.TotalInquiryHIGHERED').html(TotalInquiryHIGHERED[0]['REF']);
             InquiryBED();
             InquiryTotalAll();
        }
    
    });

}

///SHS FETCH RESERVE
function SHS_FETCH_RESERVED_STUDENTS(){

var Dashboard_url = $("#base_url").val(); 
$.ajax({
    url:Dashboard_url+"index.php/Dashboard/fecth_shs_reserved",
    success:function(data){
        TotalReservedSHS = JSON.parse(data);
        $('.TotalReservedSHS').html(TotalReservedSHS[0]['REF']); 
        ReservationStudents(TotalReservedSHS);
        ReservationTotalAll();
    }

});

}

///SHS FECTH  INQUIRY
function SHS_FETCH_INQUIRY_STUDENTS(){

    var Dashboard_url = $("#base_url").val(); 

    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_shs_inquiry",
        success:function(data){
                TotalInquirySHS = JSON.parse(data);
             $('.TotalInquirySHS').html(TotalInquirySHS[0]['REF']);
        }
    
    });
    
  
}

///BED  FETCH RESERVED
function BED_FETCH_RESERVED_STUDENTS(){
 var Dashboard_url = $("#base_url").val(); 
$.ajax({
    url:Dashboard_url+"index.php/Dashboard/fecth_bed_reserved",
    success:function(data){
            TotalReservedBED = JSON.parse(data);
         $('.TotalReservedBED').html(TotalReservedBED[0]['REF']); 
    }

});
}

///BED FECTH  INQUIRY
function BED_FETCH_INQUIRY_STUDENTS(){

    var Dashboard_url = $("#base_url").val(); 

    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_bed_inquiry",
        success:function(data){
                TotalInquiryBED = JSON.parse(data);
             $('.TotalInquiryBED').html(TotalInquiryBED[0]['REF']);
        
        }

    });
  
}


///SHS FETCH OLD STUDENTS
function SHS_FETCH_OLD_STUDENTS(){

    var Dashboard_url = $("#base_url").val(); 
    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_oldshs_student",
        success:function(data){
                TotalOLDSHSStudents = JSON.parse(data);
             $('.TotalOLDSHSStudents').html(TotalOLDSHSStudents[0]['REF']);

            
              StudentsTotalALL();
              GetPieTotalStudents();   
              
        }

    });
}


//BELL-BELL
function Fetch_Enrollment_Tracker(){

    var Dashboard_url = $("#base_url").val(); 
   
  
        $.ajax({
            url:Dashboard_url+"index.php/Dashboard/Tracker_Inquiry",
                success:function(data){
                    console.log(data);
                    EnrollmentTrackerData = JSON.parse(data);
                    // die(EnrollmentTrackerData);
                //  $('.TotalNewSHSStudents').html(EnrollmentTrackerData[0]['REF']);
                    EnrollmentTrackerPie(EnrollmentTrackerData);
            }
        });

}

//SHS FETCH NEW STUDENTS
function SHS_Fetch_New_Students(){

    var Dashboard_url = $("#base_url").val(); 
   
  
        $.ajax({
            url:Dashboard_url+"index.php/Dashboard/fecth_newshs_student",
                 success:function(data){
                    TotalNewSHSStudents = JSON.parse(data);
                 $('.TotalNewSHSStudents').html(TotalNewSHSStudents[0]['REF']);
                  TotalNewStutends();
                  newstudents();
            }
        });

}


// BED FETCH NEW STUDENTS
function BED_Fetch_New_Students(){

    var Dashboard_url = $("#base_url").val(); 
    
    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_newbed_student",
             success:function(data){
                TotalNewBedStudents = JSON.parse(data);
             $('.TotalNewBedStudents').html(TotalNewBedStudents[0]['REF']);
             
        }
    });

}

function BED_FETCH_OLD_STUDENTS(){
    
    var Dashboard_url = $("#base_url").val(); 
   
  

    
        $.ajax({
            url:Dashboard_url+"index.php/Dashboard/fecth_bedold_student",
                 success:function(data){
                    TotalOLDBedStudents = JSON.parse(data);
                 $('.TotalOLDBedStudents').html(TotalOLDBedStudents[0]['REF']);
                 BedStudents();     
            }
        });

}

// HED FETCH NEW STUDENTS
function Hed_Fetch_New_Students(){

    var Dashboard_url = $("#base_url").val(); 
    
    // FOR HIGHER EDUCATION
     $.ajax({
         url:Dashboard_url+"index.php/Dashboard/fecth_new",
              success:function(data){
             NewStudents = JSON.parse(data);
             $('.NewStudents').html(NewStudents[0]['REF']);
         
         }
     });

}

// HED FETCH OLD STUDENTS
function Hed_Fetch_Old_Students(){

    var Dashboard_url = $("#base_url").val(); 
    
    // FOR HIGHER EDUCATION

    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_old",
             success:function(data){
             OldStudents = JSON.parse(data);
            $('.OldStudents').html(OldStudents[0]['REF']);
            $('.TotalEnrolledStudents').html(parseInt(OldStudents[0]['REF']) + parseInt(NewStudents[0]['REF']) );
          
        }
    });

}

// HED FETCH WITHDRAW STUDENTS
function Hed_Fetch_Withdraw_Students(){

    var Dashboard_url = $("#base_url").val(); 
    
    // FOR HIGHER EDUCATION

    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_withdraw",
             success:function(data){
                StudentWithdraw = JSON.parse(data);
            $('.StudentWithdraw').html(StudentWithdraw[0]['REF']);
            
    
           
        }
    });

}

// HED FETCH Reserved STUDENTS
function Hed_Fetch_Reserved_Students(){

    var Dashboard_url = $("#base_url").val(); 
    
    // FOR HIGHER EDUCATION

    ///HIGHER ED
    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_reserved",
             success:function(data){
                StudentReserved = JSON.parse(data);
            $('.StudentReserved').html(StudentReserved[0]['REF']);
            ReservationStudents();   
            ReservationTotalAll();
        }
    });

}





//TOTAL SHS STUDENTS
function ShsStudents(){
    $('.TotalSHSStudents').html(parseInt(TotalOLDSHSStudents[0]['REF']) + parseInt(TotalNewSHSStudents[0]['REF']) );
}
//TOTAL BED STUDETNS
function BedStudents(){
    $('.TotalBEDStudents').html(parseInt(TotalOLDBedStudents[0]['REF']) + parseInt(TotalNewBedStudents[0]['REF']) );
}
//TOTAL STUDENTS
function StudentsTotalALL(){

    $('.TotalAllStudents').html(parseInt(TotalOLDSHSStudents[0]['REF']) + parseInt(TotalNewSHSStudents[0]['REF']) + parseInt(TotalOLDBedStudents[0]['REF']) + parseInt(TotalNewBedStudents[0]['REF']) + parseInt(OldStudents[0]['REF']) + parseInt(NewStudents[0]['REF']) );

}
//TOTAL NEW STUDENTS
function TotalNewStutends(){
    $('.TotalNEWStudents').html(parseInt(TotalNewBedStudents[0]['REF']) + parseInt(NewStudents[0]['REF']) + parseInt(TotalNewSHSStudents[0]['REF']) );
}

//TOTAL RESERVATIONS
function ReservationTotalAll(){

    $('.TotalAllReserveStudents').html(parseInt(StudentReserved[0]['REF']) + parseInt(TotalReservedBED[0]['REF']) + parseInt(TotalReservedSHS[0]['REF']) ); 

}

//TOTAL INQUIRY
function InquiryTotalAll(){

    $('.TotalAllInquiryStudents').html(parseInt(TotalInquiryBED[0]['REF']) + parseInt(TotalInquirySHS[0]['REF']) + parseInt(TotalInquiryHIGHERED[0]['REF'])); 

}
//MAIN PIE 
function GetPieTotalStudents(){

    //Pie Chart
    var BasicEd = parseInt(TotalOLDBedStudents[0]['REF']) + parseInt(TotalNewBedStudents[0]['REF']);
    var HigherEd = parseInt(OldStudents[0]['REF']) + parseInt(NewStudents[0]['REF']);
    var Shs = parseInt(TotalOLDSHSStudents[0]['REF']) + parseInt(TotalNewSHSStudents[0]['REF']);
   
    let ctx = document.getElementById('myChart').getContext('2d');
    let labels = ['SENIOR HIGHSCHOOL','HIGHER EDUCATION', 'BASIC EDUCATION'];
    let colorHex = ['#E91E63', '#2196F3', '#4CAF50'];
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: [Shs,HigherEd,BasicEd],
                backgroundColor: colorHex,
            
               
            }]
        },
        options: {
            responsive: true,
            legend: {
                    position: 'left',
            },
             animation: {
                animateScale: true,
                animateRotate: true
             },
             plugins: {
                labels: [
                    {
                      render: 'value',
                      position: 'outside',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#000',
                    },
                    {
                      render: 'percentage',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#fff',
                     
                    }
                  ]
                },

          }
        
    });

}

//PIE OF NEW STUDENTS
function newstudents(){

    var BasicEd =   parseInt(TotalNewBedStudents[0]['REF']);
    var HigherEd = parseInt(NewStudents[0]['REF']);
    var Shs =    parseInt(TotalNewSHSStudents[0]['REF']);
   
    let ctx = document.getElementById('myCharts5').getContext('2d');
    let labels = ['SHS','HIGHERED', 'BASICED'];
    let colorHex = ['#E91E63', '#2196F3', '#4CAF50'];
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: [Shs,HigherEd,BasicEd],
                backgroundColor: colorHex,
               
                
            }]
            
        },
        options: {
            responsive: true,
            legend: {
                    position: 'left',
            },
         animation: {
                animateScale: true,
                animateRotate: true
             },
             plugins: {
                labels: [
                    {
                      render: 'value',
                      position: 'outside',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#000',
                    },
                    {
                      render: 'percentage',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#fff',
                     
                    }
                  ]
                },
           

          }
        
    });
}
//PIE FOR RESERVATION
function ReservationStudents(TotalReservedSHS){

   var Shs  = TotalReservedSHS[0]['REF'];
    var BasicEd = TotalReservedBED[0]['REF'];
    var HigherEd = StudentReserved[0]['REF'];
    let ctx = document.getElementById('myCharts3').getContext('2d');
    let labels = ['SHS','HIGHERED', 'BASICED'];
    let colorHex = ['#E91E63', '#2196F3', '#4CAF50'];
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: [Shs,HigherEd,BasicEd],
                backgroundColor: colorHex,
         
            }]
        },
        options: {
            responsive: true,
            legend: {
                    position: 'left',
            },
        animation: {
                animateScale: true,
                animateRotate: true
             },
             plugins: {
                labels: [
                    {
                      render: 'value',
                      position: 'outside',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#000',
                    },
                    {
                      render: 'percentage',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#fff',
                     
                    }
                  ]
                },
           

          }
        
    });
}

//PIE FOR INQUIRY

function InquiryBED(){
    
    let BasicEd = parseInt(TotalInquiryBED[0]['REF']);
    let Shs = parseInt(TotalInquirySHS[0]['REF']);
    let HIGHERED = parseInt(TotalInquiryHIGHERED[0]['REF']);
    let ctx = document.getElementById('myCharts2').getContext('2d');
    let labels = ['SHS','HIGHERED', 'BASICED'];
    let colorHex = ['#E91E63', '#2196F3', '#4CAF50'];
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: [Shs,HIGHERED,BasicEd],
                backgroundColor: colorHex,
                 
            }]
        },
        options: {
            responsive: true,
            legend: {
                    position: 'left',
            },
        animation: {
                animateScale: true,
                animateRotate: true
             },
             plugins: {
                labels: [
                    {
                      render: 'value',
                      position: 'outside',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#000',
                    },
                    {
                      render: 'percentage',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#fff',
                     
                    }
                  ]
                },
           

          }
        
    });
}

//BELL-BELL
//PIE FOR Enrollment Tracker
function EnrollmentTrackerPie(){
    // var Shs  = TotalReservedSHS[0]['REF'];
    
    
    // var BasicEd = TotalReservedBED[0]['REF'];
    // var HigherEd = StudentReserved[0]['REF'];
    let ctx = document.getElementById('myCharts_tracker').getContext('2d');
    let labels = ['SHS','HIGHERED', 'BASICED'];
    let colorHex = ['#E91E63', '#2196F3', '#4CAF50'];
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: [Shs,HigherEd,BasicEd],
                backgroundColor: colorHex,
         
            }]
        },
        options: {
            responsive: true,
            legend: {
                    position: 'left',
            },
        animation: {
                animateScale: true,
                animateRotate: true
             },
             plugins: {
                labels: [
                    {
                      render: 'value',
                      position: 'outside',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#000',
                    },
                    {
                      render: 'percentage',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#fff',
                     
                    }
                  ]
                },
           

          }
        
    });
}

//PIE FOR OTHERPROGRAMS
function OTHERPROGRAMS(result){

    let ctx = document.getElementById('myCharts4').getContext('2d');

    var count   = 0;
    var labels  = [];
    var Enrolled = [];

    $.each(result, function(index, list) 
    {
         labels[count]   = list['Program_Code'];
         Enrolled[count] = list['Enrolled'];
        count++;
    }); 
 
    let colorHex = ['#E91E63', '#2196F3', '#4CAF50','#FFA500'];
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels:labels,
            datasets: [{
                data: Enrolled,
                backgroundColor: colorHex,
                 
            }]
        },
        options: {
            responsive: true,
            legend: {
                    position: 'left',
            },
        animation: {
                animateScale: true,
                animateRotate: true
             },
             plugins: {
                labels: [
                    {
                      render: 'value',
                      position: 'outside',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#000',
                    },
                    {
                      render: 'percentage',
                      fontSize: 14,
                      fontStyle: 'bold',
                      fontColor: '#fff',
                     
                    }
                  ]
                },
           

          }
        
    });
}
//BAR CHART OF BASIC ED
function BarBED(result){
    
    var count   = 0;
    var labels  = [];
    var Inquiry = [];
    var Reserve = [];
    var New = [];
    var Enrolled = [];

    $.each(result, function(index, list) 
    {
         labels[count]   = list['Grade_Level'];
         Inquiry[count]  = list['Inquiry'];
         Reserve[count]  = list['Reserve'];
         New[count]      = list['NewStudent'];
         Enrolled[count] = list['Enrolled'];
        count++;
    });
   


let ctx = $("#myCharts6");
let data = {
    labels : labels,
    datasets : [
       
       
        {
            label : "Inquiry",
            data  : Inquiry,
            backgroundColor : [
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
            ],
            borderColor : [
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
            ],
            borderWidth : 1
        },
        {
            label : "Reserved",
            data : Reserve,
            backgroundColor : [
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
            ],
            borderColor : [
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
            ],
            borderWidth : 1
        },
        {
            label :"New Students",
            data  :New,
            backgroundColor : [
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
            ],
            borderColor : [
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
            ],
            borderWidth : 1
        },
        {
            label : "Enrolled",
            data : Enrolled,
            backgroundColor : [
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
            ],
            borderColor : [
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
            ],
            borderWidth : 1
        }
    ]
};

var options = {
    title : {
        display : true,
        position : "top",
        text : "",
        fontSize : 18,
        fontColor : "#111"
    },
    legend : {
        display : true,
        position : "top",
            
    },
    scales : {
        yAxes : [{
            ticks : {
                min : 0
            }
        }]
    },
    plugins: {
        labels: {
        render: 'value'
                }
    },
};

var chart = new Chart( ctx, {
    type : "bar",
    data : data,
    options : options
});
}



//BAR CHART OF SHS
function BarSHS(result){
    
    var count   = 0;
    var labels  = [];
    var Inquiry = [];
    var Reserve = [];
    var New = [];
    var Enrolled = [];

    $.each(result, function(index, list) 
    {
         labels[count]        = list['Strand_Code'];
         Inquiry[count]       = list['Inquiry'];
         Reserve[count]       = list['Reserve'];
         New[count]           = list['NewStudent'];
         Enrolled[count]      = list['Enrolled'];
        count++;
    });

 

let ctx = $("#myCharts7");
let data = {
    labels : labels,
    datasets : [
       
       
        {
            label : "Inquiry",
            data  : Inquiry,
            backgroundColor : [
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",

            ],
            borderColor : [
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
            ],
            borderWidth : 1
        },
        {
            label : "Reserved",
            data : Reserve,
            backgroundColor : [
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                
            ],
            borderColor : [
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                
            ],
            borderWidth : 1
        },
        {
            label :"New Students",
            data  :New,
            backgroundColor : [
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
            ],
            borderColor : [
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
            ],
            borderWidth : 1
        },
        {
            label : "Enrolled",
            data : Enrolled,
            backgroundColor : [
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
            ],
            borderColor : [
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
            ],
            borderWidth : 1
        }
    ]
};

var options = {
    title : {
        display : true,
        position : "top",
        text : "",
        fontSize : 18,
        fontColor : "#111"
    },
    legend : {
        display : true,
        position : "top",
            
    },
    scales : {
        yAxes : [{
            ticks : {
                min : 0
            }
        }]
    },
    plugins: {
        labels: {
        render: 'value'
                }
    },
};

var chart = new Chart( ctx, {
    type : "bar",
    data : data,
    options : options
});
}


//BAR CHART OF HigherEd
function BarHigherEd(result){
    
    var count   = 0;
    var labels  = [];
    var Inquiry = [];
    var Reserve = [];
    var New = [];
    var Enrolled = [];

    $.each(result, function(index, list) 
    {
         labels[count]        = list['Program_Code'];
         Inquiry[count]       = list['Inquiry'];
         Reserve[count]       = list['Reserve'];
         New[count]           = list['NewStudent'];
         Enrolled[count]      = list['Enrolled'];
        count++;
    });

 

let ctx = $("#myCharts8");
let data = {
    labels : labels,
    datasets : [
       
       
        {
            label : "Inquiry",
            data  : Inquiry,
            backgroundColor : [
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",

            ],
            borderColor : [
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
                "#E91E63",
            ],
            borderWidth : 1
        },
        {
            label : "Reserved",
            data : Reserve,
            backgroundColor : [
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                
            ],
            borderColor : [
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                '#2196F3',
                
            ],
            borderWidth : 1
        },
        {
            label :"New Students",
            data  :New,
            backgroundColor : [
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
            ],
            borderColor : [
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
                '#4CAF50',
            ],
            borderWidth : 1
        },
        {
            label : "Enrolled",
            data : Enrolled,
            backgroundColor : [
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
            ],
            borderColor : [
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
                '#FFA500',
            ],
            borderWidth : 1
        }
    ]
};

var options = {
    title : {
        display : true,
        position : "",
        text : "",
        fontSize : 18,
        fontColor : "#111"
    },
    legend : {
        display : true,
        position : "top",
            
    },
    scales : {
        yAxes : [{
            ticks : {
                min : 0
            }
        }]
    },
    plugins: {
        labels: {
        render: 'value'
                }
    },
};

var chart = new Chart( ctx, {
    type : "bar",
    data : data,
    options : options
});
}


//HED FOR SUMMER
function Summer_HED(){
    
    var Dashboard_url = $("#base_url").val(); 
    //FOR SUMMER HED //////////////////////////////////////////////////////////////////////////////

       //ADVISED HED

       $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_advised",
             success:function(data){
                StudentAdviced = JSON.parse(data);
            $('.TotalAdvisedStudents').html(StudentReserved[0]['REF']);

           
        }
    });


    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_summer_New",
             success:function(data){
                SummerStudentsNew = JSON.parse(data);
            $('.SummerNewStudents').html(SummerStudentsNew[0]['REF']);

           
        }
    });

    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_summer",
             success:function(data){
                SummerStudents = JSON.parse(data);
             $('.SummerOldStudents').html(SummerStudents[0]['REF']);
             $('.TotalSummerOldtudents').html(parseInt(SummerStudents[0]['REF']) - parseInt(SummerStudentsNew[0]['REF']) );
            
        }
    });


    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_summer_withdraw",
             success:function(data){
                TotalSummerWithdraw = JSON.parse(data);
             $('.TotalSummerWithdraw').html(TotalSummerWithdraw[0]['REF']);
        }
    });

    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_summer_reserved",
             success:function(data){
                TotalSummerReserved = JSON.parse(data);
             $('.TotalSummerReserved').html(TotalSummerReserved[0]['REF']); 
        }
    });



    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_summer_advised",
             success:function(data){
                TotalSummerAdvised= JSON.parse(data);
             $('.TotalSummerAdvised').html(TotalSummerAdvised[0]['REF']);
        }
    });

    $.ajax({
        url:Dashboard_url+"index.php/Dashboard/fecth_summer_advised",
             success:function(data){
                TotalSummerAdvised= JSON.parse(data);
             $('.TotalSummerAdvised').html(TotalSummerAdvised[0]['REF']);
        }
    });

   //FOR SUMMER HED //////////////////////////////////////////////////////////////////////////////
}

(function(){function f(){this.renderToDataset=this.renderToDataset.bind(this)}if("undefined"===typeof Chart)console.error("Can not find Chart object.");else{"function"!=typeof Object.assign&&(Object.assign=function(a,c){if(null==a)throw new TypeError("Cannot convert undefined or null to object");for(var b=Object(a),e=1;e<arguments.length;e++){var d=arguments[e];if(null!=d)for(var g in d)Object.prototype.hasOwnProperty.call(d,g)&&(b[g]=d[g])}return b});var k={};["pie","doughnut","polarArea","bar"].forEach(function(a){k[a]=
!0});f.prototype.setup=function(a,c){this.chart=a;this.ctx=a.ctx;this.args={};this.barTotal={};var b=a.config.options;this.options=Object.assign({position:"default",precision:0,fontSize:b.defaultFontSize,fontColor:b.defaultFontColor,fontStyle:b.defaultFontStyle,fontFamily:b.defaultFontFamily,shadowOffsetX:3,shadowOffsetY:3,shadowColor:"rgba(0,0,0,0.3)",shadowBlur:6,images:[],outsidePadding:2,textMargin:2,overlap:!0},c);"bar"===a.config.type&&(this.options.position="default",this.options.arc=!1,this.options.overlap=
!0)};f.prototype.render=function(){this.labelBounds=[];this.chart.data.datasets.forEach(this.renderToDataset)};f.prototype.renderToDataset=function(a,c){this.totalPercentage=0;this.total=null;var b=this.args[c];b.meta.data.forEach(function(c,d){this.renderToElement(a,b,c,d)}.bind(this))};f.prototype.renderToElement=function(a,c,b,e){if(this.shouldRenderToElement(c.meta,b)&&(this.percentage=null,c=this.getLabel(a,b,e))){var d=this.ctx;d.save();d.font=Chart.helpers.fontString(this.options.fontSize,
this.options.fontStyle,this.options.fontFamily);var g=this.getRenderInfo(b,c);this.drawable(b,c,g)&&(d.beginPath(),d.fillStyle=this.getFontColor(a,b,e),this.renderLabel(c,g));d.restore()}};f.prototype.renderLabel=function(a,c){return this.options.arc?this.renderArcLabel(a,c):this.renderBaseLabel(a,c)};f.prototype.renderBaseLabel=function(a,c){var b=this.ctx;if("object"===typeof a)b.drawImage(a,c.x-a.width/2,c.y-a.height/2,a.width,a.height);else{b.save();b.textBaseline="top";b.textAlign="center";this.options.textShadow&&
(b.shadowOffsetX=this.options.shadowOffsetX,b.shadowOffsetY=this.options.shadowOffsetY,b.shadowColor=this.options.shadowColor,b.shadowBlur=this.options.shadowBlur);for(var e=a.split("\n"),d=0;d<e.length;d++)b.fillText(e[d],c.x,c.y-this.options.fontSize/2*e.length+this.options.fontSize*d);b.restore()}};f.prototype.renderArcLabel=function(a,c){var b=this.ctx,e=c.radius,d=c.view;b.save();b.translate(d.x,d.y);if("string"===typeof a){b.rotate(c.startAngle);b.textBaseline="middle";b.textAlign="left";d=
a.split("\n");var g=0,l=[],f=0;"border"===this.options.position&&(f=(d.length-1)*this.options.fontSize/2);for(var h=0;h<d.length;++h){var m=b.measureText(d[h]);m.width>g&&(g=m.width);l.push(m.width)}for(h=0;h<d.length;++h){var n=d[h],k=(d.length-1-h)*-this.options.fontSize+f;b.save();b.rotate((g-l[h])/2/e);for(var p=0;p<n.length;p++){var q=n.charAt(p);m=b.measureText(q);b.save();b.translate(0,-1*e);b.fillText(q,0,k);b.restore();b.rotate(m.width/e)}b.restore()}}else b.rotate((d.startAngle+Math.PI/
2+c.endAngle)/2),b.translate(0,-1*e),this.renderLabel(a,{x:0,y:0});b.restore()};f.prototype.shouldRenderToElement=function(a,c){return!a.hidden&&!c.hidden&&(this.options.showZero||"polarArea"===this.chart.config.type?0!==c._view.outerRadius:0!==c._view.circumference)};f.prototype.getLabel=function(a,c,b){if("function"===typeof this.options.render)a=this.options.render({label:this.chart.config.data.labels[b],value:a.data[b],percentage:this.getPercentage(a,c,b),dataset:a,index:b});else switch(this.options.render){case "value":a=
a.data[b];break;case "label":a=this.chart.config.data.labels[b];break;case "image":a=this.options.images[b]?this.loadImage(this.options.images[b]):"";break;default:a=this.getPercentage(a,c,b)+"%"}"object"===typeof a?a=this.loadImage(a):null!==a&&void 0!==a&&(a=a.toString());return a};f.prototype.getFontColor=function(a,c,b){var e=this.options.fontColor;"function"===typeof e?e=e({label:this.chart.config.data.labels[b],value:a.data[b],percentage:this.getPercentage(a,c,b),backgroundColor:a.backgroundColor[b],
dataset:a,index:b}):"string"!==typeof e&&(e=e[b]||this.chart.config.options.defaultFontColor);return e};f.prototype.getPercentage=function(a,c,b){if(null!==this.percentage)return this.percentage;if("polarArea"===this.chart.config.type){if(null===this.total)for(c=this.total=0;c<a.data.length;++c)this.total+=a.data[c];a=a.data[b]/this.total*100}else if("bar"===this.chart.config.type){if(void 0===this.barTotal[b])for(c=this.barTotal[b]=0;c<this.chart.data.datasets.length;++c)this.barTotal[b]+=this.chart.data.datasets[c].data[b];
a=a.data[b]/this.barTotal[b]*100}else a=c._view.circumference/this.chart.config.options.circumference*100;a=parseFloat(a.toFixed(this.options.precision));this.options.showActualPercentages||("bar"===this.chart.config.type&&(this.totalPercentage=this.barTotalPercentage[b]||0),this.totalPercentage+=a,100<this.totalPercentage&&(a-=this.totalPercentage-100,a=parseFloat(a.toFixed(this.options.precision))),"bar"===this.chart.config.type&&(this.barTotalPercentage[b]=this.totalPercentage));return this.percentage=
a};f.prototype.getRenderInfo=function(a,c){return"bar"===this.chart.config.type?this.getBarRenderInfo(a,c):this.options.arc?this.getArcRenderInfo(a,c):this.getBaseRenderInfo(a,c)};f.prototype.getBaseRenderInfo=function(a,c){if("outside"===this.options.position||"border"===this.options.position){var b,e=a._view,d=e.startAngle+(e.endAngle-e.startAngle)/2,g=e.outerRadius/2;"border"===this.options.position?b=(e.outerRadius-g)/2+g:"outside"===this.options.position&&(b=e.outerRadius-g+g+this.options.textMargin);
b={x:e.x+Math.cos(d)*b,y:e.y+Math.sin(d)*b};"outside"===this.options.position&&(d=this.options.textMargin+this.measureLabel(c).width/2,b.x+=b.x<e.x?-d:d);return b}return a.tooltipPosition()};f.prototype.getArcRenderInfo=function(a,c){var b=a._view;var e="outside"===this.options.position?b.outerRadius+this.options.fontSize+this.options.textMargin:"border"===this.options.position?(b.outerRadius/2+b.outerRadius)/2:(b.innerRadius+b.outerRadius)/2;var d=b.startAngle,g=b.endAngle,l=g-d;d+=Math.PI/2;g+=
Math.PI/2;var f=this.measureLabel(c);d+=(g-(f.width/e+d))/2;return{radius:e,startAngle:d,endAngle:g,totalAngle:l,view:b}};f.prototype.getBarRenderInfo=function(a,c){var b=a.tooltipPosition();b.y-=this.measureLabel(c).height/2+this.options.textMargin;return b};f.prototype.drawable=function(a,c,b){if(this.options.overlap)return!0;if(this.options.arc)return b.endAngle-b.startAngle<=b.totalAngle;var e=this.measureLabel(c);c=b.x-e.width/2;var d=b.x+e.width/2,g=b.y-e.height/2;b=b.y+e.height/2;return"outside"===
this.options.renderInfo?this.outsideInRange(c,d,g,b):a.inRange(c,g)&&a.inRange(c,b)&&a.inRange(d,g)&&a.inRange(d,b)};f.prototype.outsideInRange=function(a,c,b,e){for(var d=this.labelBounds,g=0;g<d.length;++g){for(var f=d[g],k=[[a,b],[a,e],[c,b],[c,e]],h=0;h<k.length;++h){var m=k[h][0],n=k[h][1];if(m>=f.left&&m<=f.right&&n>=f.top&&n<=f.bottom)return!1}k=[[f.left,f.top],[f.left,f.bottom],[f.right,f.top],[f.right,f.bottom]];for(h=0;h<k.length;++h)if(m=k[h][0],n=k[h][1],m>=a&&m<=c&&n>=b&&n<=e)return!1}d.push({left:a,
right:c,top:b,bottom:e});return!0};f.prototype.measureLabel=function(a){if("object"===typeof a)return{width:a.width,height:a.height};var c=0;a=a.split("\n");for(var b=0;b<a.length;++b){var e=this.ctx.measureText(a[b]);e.width>c&&(c=e.width)}return{width:c,height:this.options.fontSize*a.length}};f.prototype.loadImage=function(a){var c=new Image;c.src=a.src;c.width=a.width;c.height=a.height;return c};Chart.plugins.register({id:"labels",beforeDatasetsUpdate:function(a,c){if(k[a.config.type]){Array.isArray(c)||
(c=[c]);var b=c.length;a._labels&&b===a._labels.length||(a._labels=c.map(function(){return new f}));for(var e=!1,d=0,g=0;g<b;++g){var l=a._labels[g];l.setup(a,c[g]);"outside"===l.options.position&&(e=!0,l=1.5*l.options.fontSize+l.options.outsidePadding,l>d&&(d=l))}e&&(a.chartArea.top+=d,a.chartArea.bottom-=d)}},afterDatasetUpdate:function(a,c,b){k[a.config.type]&&a._labels.forEach(function(a){a.args[c.index]=c})},beforeDraw:function(a){k[a.config.type]&&a._labels.forEach(function(a){a.barTotalPercentage=
{}})},afterDatasetsDraw:function(a){k[a.config.type]&&a._labels.forEach(function(a){a.render()})}})}})();
