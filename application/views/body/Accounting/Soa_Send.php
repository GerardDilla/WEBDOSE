<link rel="stylesheet" href="<?php echo base_url('css/iziModal.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('plugins/waitme/waitMe.min.css'); ?>">
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
            <form id="sendForm" action ="" method="POST">
            <div class="col-md-6">
                <!-- ACADEMIC TERM -->
				<div class="SBorder vertical_gap">
                    <h4>Academic Term</h4><hr>
                    <div class="input-group">
                        <div class="form-line vertical_gap">
                            
                            <b class="black">School Year</b>
                            <select name="schoolYear" id="schoolYear" class="form-control show-tick"  data-live-search="true" tabindex="-98">
                                <option value="<?php echo $this->data['array_adivsing_term']['School_Year']; ?>" selected> <?php echo $this->data['array_adivsing_term']['School_Year'];  ?></option>
                                <option value="2019-2020">2020-2019</option>
                                <option value="2020-2021">2020-2021</option>
                            </select>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-line vertical_gap">
                            <b class="black">Semester</b>
                            <select name="semester" id="semester" class="form-control show-tick"  data-live-search="true" tabindex="-98">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="<?php echo $this->data['array_adivsing_term']['Semester']; ?>" selected> <?php echo $this->data['array_adivsing_term']['Semester'];  ?></option>
                            </select>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-line vertical_gap">
                            <b class="black">Term</b>
                            <select name="term" id="term" class="form-control show-tick"  data-live-search="true" tabindex="-98">
                                <option value="<?php echo $this->data['array_adivsing_term']['Term']; ?>" selected> <?php echo $this->data['array_adivsing_term']['Term'];  ?></option>
                            </select>
                        </div>
                    </div>
				</div>
                <!-- /ACADEMIC TERM -->
            </div>
            <div class="col-md-6">
                <!-- DUE DATE/ PROGRAM -->
				<div class="SBorder vertical_gap">
                    <h4>Due Date and Program</h4><hr>
                    <div class="input-group">
                        <div class="form-line vertical_gap">
                            <b class="black">Due Date</b>
                            <input type="date" id="dueDate" name="dueDate" class="form-control show-tick" />
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-line vertical_gap">
                            <b class="black">Program</b>
                            <select name="programCode" id="programCode" class="form-control show-tick"  data-live-search="true" tabindex="-98">
                                <option value="" disabled selected> Select a Program</option>
                                <?php foreach ($this->data['array_program_code_list'] as $key => $program) { ?>
                                    <option value="<?php echo $program['Program_Code']; ?>"> <?php echo $program['Program_Code']; ?> </option>
                                <?php } ?>
                                
                            </select>
                        </div>
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
            </form>
        </div>
    </div>

        

</section>
<div id="modal" data-izimodal-group="" data-izimodal-loop="" style="display:none;" data-izimodal-title="">
</div>
<script src="<?php echo base_url('plugins/waitme/waitMe.min.js');?>"></script>
<script src="<?php echo base_url('js/iziModal.min.js'); ?>"></script>
<input type="hidden" id="addressUrl" value="<?php echo site_url().'/StatementOfAccount'; ?>"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/soa.js"></script>
<script>
$("#sendButton").click(function(){
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
            storagedata.changeVal('data',response);
            console.log(response);
            for(var x=1;x<=response.total_page;++x){
                console.log(`page ${x}`);
            }
            $('body').waitMe('hide');
            $('#modal').iziModal('open');
            $('#modal').iziModal('setTitle',"Sending...      <span align='right'>10%</span>")
        },
        error: function(response) {
            // reject(response);
        }
    });
});
</script>