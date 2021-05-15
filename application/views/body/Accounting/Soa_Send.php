<!-- <link rel="stylesheet" href="<?php echo base_url('css/iziModal.min.css'); ?>"> -->
<link rel="stylesheet" href="<?php echo base_url('plugins/waitme/waitMe.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('css/iziToast.min.css'); ?>">
<style>
.input-group .bootstrap-select.form-control {
    z-index: inherit;
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
                                    
                                    var current_count = x;
                                    batchSend(x,response.per_page,response.total_page).then().catch(error=>console.log(`Error:page ${x}`));
                                    
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