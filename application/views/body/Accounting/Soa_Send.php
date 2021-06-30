<!-- <link rel="stylesheet" href="<?php echo base_url('css/iziModal.min.css'); ?>"> -->
<link rel="stylesheet" href="<?php echo base_url('plugins/waitme/waitMe.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('css/iziToast.min.css'); ?>">
<style>
.input-group .bootstrap-select.form-control {
    z-index: inherit;
}
.email-status{
    transform:translate(50%,50%);
    bottom:50%;
    right:50%;
    position:absolute;
}
#emailLogs{
    overflow-y: auto;
    max-height:50vh;
}
#soaEmailLogs .modal-body{
    overflow-y: auto;
    max-height:60vh;
}
</style>
<section  id="top" class="content" style="background-color: #fff;">
    <!-- CONTENT GRID-->
    <div class="container-fluid">

        <!-- MODULE TITLE-->
        <div class="block-header">
            <h1> <i class="material-icons" style="font-size:100%">assignment_returned</i> Higher Education SOA</h1>
            <?php if($this->session->flashdata('message_error') || $this->session->flashdata('message_success')): ?>
            <br>
                <h3 class="col-red">
                    <?php echo $this->session->flashdata('message_error'); ?>
                </h3>
                <h3 class="col-green">
                    <?php echo $this->session->flashdata('message_success'); ?>
                </h3>
            <br>
            <?php endIf; ?>
        </div>
        <!--/ MODULE TITLE-->

        <div class="row">
            <!-- <form id="sendForm" action ="" method="POST"> -->
            <div class="col-md-6">
                <!-- ACADEMIC TERM -->
				<div class="SBorder vertical_gap">
                    <h4>Academic Term</h4><hr>
                    <div class="input-group">
                        <div class="form-line vertical_gap">
                            <b class="black">School Year</b>
                            <select name="schoolYear" id="schoolYear" class="form-control show-tick"  data-live-search="true">
                                <option value="<?php echo $this->data['array_adivsing_term']['School_Year']; ?>" selected> <?php echo $this->data['array_adivsing_term']['School_Year'];  ?></option>
                                <option value="2019-2020">2020-2019</option>
                                <option value="2020-2021">2020-2021</option>0
                            </select>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-line vertical_gap">
                            <b class="black">Semester</b>
                            <select name="semester" id="semester" class="form-control show-tick"  data-live-search="true" tabindex="-98" style="z-index:99">
                                <!-- <option value="1">1</option>
                                <option value="2">2</option> -->
                                <option value="<?php echo $this->data['array_adivsing_term']['Semester']; ?>" selected> <?php echo $this->data['array_adivsing_term']['Semester'];  ?></option>
                                <option value="2">2</option> -->
                            </select>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <!-- <br> -->
                        <!-- <div class="form-line vertical_gap">
                            <b class="black">Term</b>
                            <select name="term" id="term" class="form-control show-tick"  data-live-search="true" tabindex="-98">
                                <option value="<?php echo $this->data['array_adivsing_term']['Term']; ?>" selected> <?php echo $this->data['array_adivsing_term']['Term'];  ?></option>
                            </select>
                        </div> -->
                    </div>
				</div>
                <!-- /ACADEMIC TERM -->
            </div>
            <div class="col-md-6">
                <!-- DUE DATE/ PROGRAM -->
				<div class="SBorder vertical_gap">
                    <h4>Due Date and Program</h4><hr>
                    <div class="input-group">
                    <!-- <br>
                        <br>
                        <br> -->
                        <!-- <div class="form-line vertical_gap">
                            <b class="black">Due Date</b>
                            <input type="date" id="dueDate" name="dueDate" class="form-control show-tick" />
                        </div> -->
                       
                        <div class="form-line vertical_gap">
                            <b class="black">Program</b>
                            <select name="programCode" id="programCode" class="form-control show-tick"  data-live-search="true" tabindex="-98">
                                <option value="" disabled selected> Select a Program</option>
                                <?php foreach ($this->data['array_program_code_list'] as $key => $program) { if($program['Program_Code']!='N/A'){ ?>
                                    <option value="<?php echo $program['Program_Code']; ?>"> <?php echo $program['Program_Code']; ?> </option>
                                <?php }} ?>
                                
                            </select>
                        </div>
                        <!-- <br> -->
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="form-line vertical_gap">
                            <button type="button" id="sendButton" class="btn btn-block btn-lg btn-primary waves-effect" >Send Batch Email</button>
                        </div>
                       
                    </div>
				</div>
                <!-- /DUE DATE/ PROGRAM -->
            </div>
            <!-- </form> -->
        </div>
    </div>

        

</section>
<div class="modal fade" id="soaEmailLogs" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel16">SOA Email Logs</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="modal-body">
            <!-- <div class="col-md-12" id="emailLogs">

            </div> -->
            <table class="table" id="emailLogs">
                <thead>
                    <th width="80%">Full Name</th>
                    <th>Status</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Hi</span>
            </button>
             -->
             <button type="button" class="btn btn-light-secondary" id="closeLogs">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="button" class="btn btn-warning" id="resend_email">
                <i class="material-icons">autorenew</i>
                Resend Email
            </button>
        </div>
    </div>
  </div>
</div>
<!-- <div id="modal" data-izimodal-group="" data-izimodal-loop="" style="display:none;" data-izimodal-title="">
</div> -->
<script src="<?php echo base_url('plugins/waitme/waitMe.min.js');?>"></script>
<!-- <script src="<?php echo base_url('js/iziModal.min.js'); ?>"></script> -->
<script src="<?php echo base_url('js/iziToast.min.js'); ?>"></script>
<input type="hidden" id="addressUrl" value="<?php echo site_url().'/StatementOfAccount'; ?>"/>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/soa.js"></script> -->
<script>
var percentage = 0;
var page_count = 0;
var sample_data = [
{status: "error", reference_no: "26455", full_name: "JOSETTE CORPUZ CLERIGO"},
{status: "error", reference_no: "26617", full_name: "JEAN CARLA CERES AGNAS"},
{status: "error", reference_no: "26734", full_name: "ROSECHAN LOJA LAGRAZON"},
{status: "error", reference_no: "26773", full_name: "JOSEPH ANTHONY ATEGA KOTICO"},
{status: "error", reference_no: "26732", full_name: "JUSTIN KOTICO YASAY"},
{status: "error", reference_no: "26200", full_name: "SHENDRICK RAGUB GABEST"},
{status: "error", reference_no: "26789", full_name: "DENEB MAKEV EBRO PAHILA"},
{status: "error", reference_no: "26357", full_name: "MARICAR CASTRO RIVERA"},
{status: "error", reference_no: "26904", full_name: "KEN LORENCE REMOROZA BAGUS"},
{status: "error", reference_no: "26274", full_name: "CHARIZE ANN ARCA BAUTISTA"},
{status: "error", reference_no: "26180", full_name: "MARVYN SALARZON CRUZ"},
{status: "error", reference_no: "26269", full_name: "TRISHAN AGAD HERNANDEZ"},
{status: "error", reference_no: "26157", full_name: "CHERRIE MAY DIRECTO JAMILLA"},
{status: "error", reference_no: "26158", full_name: "DINA FLOR TAGALOG LASCUNA"},
{status: "error", reference_no: "26359", full_name: "MONNA CABIGAYAN OCHARON"}];
var htmlsample = "";
// var result_value = sample_data.filter((item)=>{return item.status == "error"});
// $('#emailLogs tbody').empty();
// result_value.forEach((item)=>{
//     htmlsample += `<tr><td>${item.full_name}</td><td style="position:relative;"><i ${item.status=='error'?'style="color:red;"':'style="color:green;"'} class="material-icons email-status">${item.status=='error'?'dangerous':'check_circle'}</i></td></tr>`;
// })
// $('#emailLogs tbody').append(htmlsample);
// console.log(sample_data.filter((item)=>{return item.status == "error"}));
$('#resend_email').on('click',function(){
    
})
$('#closeLogs').on('click',function(){
    
    iziToast.show({
        theme: 'light',
        title: 'Hey',
        message: 'Are you sure?',
        position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'maroon',
        overlay:true,
        buttons: [
    //         ['<button>Ok</button>', function (instance, toast) {
    // //             alert("Hello world!");
    //             $('#soaEmailLogs').modal('hide');
    //         }, true],
            ['<button>Ok</button>', function (instance, toast) {
                instance.hide({
                    transitionOut: 'fadeOutUp',
                    onClosing: function(instance, toast, closedBy){
    //                     console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                        $('#soaEmailLogs').modal('hide');
                    }
                }, toast, 'buttonName');
            }]
        ],
        onOpening: function(instance, toast){
            console.info('callback abriu!');
        },
        onClosing: function(instance, toast, closedBy){
            console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
        }
    });
})
// $('#soaEmailLogs').modal('show');

async function getEmailLogs(){
    return new Promise((resolve,reject)=>{
        $.ajax({
            url: "<?php echo base_url();?>index.php/StatementOfAccount/getEmailLogs",
            method: 'get',
            dataType:'json',
            success: function(response) {
                resolve(response)
            },
            error:function(response){
                reject(response)
            }
        })
    })
}
function getPercentage(page,total_page){
    
    var percentage_per_page = (1/parseInt(total_page)*100);
    // setTimeout(function(){
        
        // console.log(`Percentage: ${parseInt(percentage_per_page*page)}`);
        // $('.waitMe_text').text(`Please wait... ${parseInt(percentage_per_page*page)}%`);
        // console.log(`page:${page},total_page:${total_page}`)
        // console.log(`page:${page_count}`)
            
        // },page*500)
        ++page_count;
        if(page_count==total_page){
            $('.waitMe_text').text(`Please wait... 100%`);
            setTimeout(() => {
                $('body').waitMe('hide')
                iziToast.show({
                    title: 'Batch Email Finished!',
                    position: 'topRight',
                    iconColor: 'red',
                    // message: 'You forgot important data',
                });
                $('#sendButton').prop('disabled',false);
                getEmailLogs().then(result=>{
                    var html = "";
                    $('#getEmailLogs').empty();
                    var result_value = sample_data.filter((item)=>{return item.status == "error"});
                    $('#emailLogs tbody').empty();
                    result_value.forEach((item)=>{
                        html += `<tr><td>${item.full_name}</td><td style="position:relative;"><i ${item.status=='error'?'style="color:red;"':'style="color:green;"'} class="material-icons email-status">${item.status=='error'?'dangerous':'check_circle'}</i></td></tr>`;
                    })
                    $('#emailLogs tbody').append(html);
                    $('#soaEmailLogs').modal('show');
                    console.log(result.logs.filter((item)=>{return item.status == "error"}));
                }).catch(error=>console.log(error));
            }, 2000);
            
        }
        else{
            $('.waitMe_text').text(`Please wait... ${parseInt(percentage_per_page*page_count)}%`);
        }
}
async function batchSend(page,per_page,total_page){
    return new Promise((resolve,reject)=>{
        $.ajax({
            url: "<?php echo base_url();?>index.php/StatementOfAccount/batchSend",
            method: 'get',
            dataType:'json',
            // async:false,
            data:{
                page:page,
                per_page:per_page,
                programCode:$('#programCode').val(),
                semester:$('#semester').val(),
                schoolYear:$('#schoolYear').val(),
                due_date:$('#dueDate').val(),
            },
            success: function(response) {
                getPercentage(page,total_page);
                resolve(response)
            },
            error:function(response){
                getPercentage(page,total_page);
                reject(response)
            }
        })
    })
}
async function retrySend(reference_no){
    return new Promise((resolve,reject)=>{
        $.ajax({
            url: "<?php echo base_url();?>index.php/StatementOfAccount/retrySend",
            method: 'post',
            dataType:'json',
            data:{
                reference_no:reference_no,
                programCode:$('#programCode').val(),
                semester:$('#semester').val(),
                schoolYear:$('#schoolYear').val(),
                due_date:$('#dueDate').val()
            },
            success: function(response) {
                resolve(response)
            },
            error:function(response){
                reject(response)
            }
        })
    })
}
$("#sendButton").click(function(e){
    console.log(e)
    e.preventDefault();
    console.log(e)
    var validate_count = 0;
    $('select.form-control').each(function(){
        if(this.value==""){
            ++validate_count;
        }
    })
    if(validate_count==0){
        $('#sendButton').prop('disabled',true);
        this.percentage = 0;
        page_count = 0;
        $.ajax({
            url: "<?php echo base_url();?>index.php/StatementOfAccount/getEmailData",
            method: 'get',
            dataType:'json',
            data:{
                programCode:$('#programCode').val(),
                semester:$('#semester').val(),
                schoolYear:$('#schoolYear').val()
            },
            success: function(response) {
                // storagedata.changeVal('data',response);
                console.log(response);
                if(response.total==0){
                    iziToast.error({
                        title: 'Msg:',
                        message:' No Entries!',
                        position: 'topRight',
                        // iconColor: 'red',
                        // message: 'You forgot important data',
                    });
                    $('#sendButton').prop('disabled',false);
                }
                else{
                    iziToast.show({
                        theme: 'light',
                        icon: 'icon-person',
                        title: 'NOTE:',
                        message: 'This can take more than 10 minutes to process!!',
                        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                        progressBarColor: '#cc0000',
                        progressBar: true,
                        timeout:10000,
                        overlay:true,
                        buttons: [
                            ['<button>Ok</button>', function (instance, toast) {
                                $('body').waitMe({
                                        effect : 'stretch',
                                        text : 'Please wait...',
                                        bg : 'rgba(255,255,255,0.7)',
                                        color : '#000',
                                        maxSize : '',
                                        waitTime : -1,
                                        textPos : 'vertical',
                                        fontSize : '',
                                        source : '',
                                        onClose : function() {}
                                });
                                instance.hide({
                                    transitionOut: 'fadeOutUp',
                                    onClosing: function(instance, toast, closedBy){
                                        console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                                    }
                                }, toast, 'buttonName');
                                
                                for(var x=1;x<=response.total_page;++x){
                                    // function useBreak(){
                                    //     break;
                                    // }
                                    var current_count = x;
                                    batchSend(x,response.per_page,response.total_page).then().catch(error=>{
                                        console.log(`Error:page ${x}`)
                                        iziToast.error({
                                            title: 'Msg:',
                                            message:" Error sending batch email!",
                                            position: 'topRight',
                                            // iconColor: 'red',
                                            // message: 'You forgot important data',
                                        });
                                        // break;
                                        return;
                                    });
                                    
                                }
                            }, true], // true to focus
                            ['<button>Close</button>', function (instance, toast) {
                                instance.hide({
                                    transitionOut: 'fadeOutUp',
                                    onClosing: function(instance, toast, closedBy){
                                        console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                                        $('#sendButton').prop('disabled',false);
                                    }
                                }, toast, 'buttonName');
                            }]
                        ],
                        onOpening: function(instance, toast){
                            console.info('callback abriu!');
                        },
                        onClosing: function(instance, toast, closedBy){
                            console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
                            $('#sendButton').prop('disabled',false);
                        }
                    });
                }
                
                
                // $('#modal').iziModal('open');
                // $('#modal').iziModal('setTitle',"Sending...      <span align='right'>10%</span>")
            },
            error: function(response) {
                // reject(response);
                console.log('response')
                $('#sendButton').prop('disabled',false);
            }
        });
    }
    else{
        iziToast.error({
            title: 'Error:',
            message:'You must fill up all the fields!',
            position: 'topRight',
            iconColor: 'red',
            // message: 'You forgot important data',
        });
    }
});
</script>