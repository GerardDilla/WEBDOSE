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
                            </select>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-line vertical_gap">
                            <b class="black">Semester</b>
                            <select name="semester" id="semester" class="form-control show-tick"  data-live-search="true" tabindex="-98">
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

<input type="hidden" id="addressUrl" value="<?php echo site_url().'/StatementOfAccount'; ?>"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/soa.js"></script>