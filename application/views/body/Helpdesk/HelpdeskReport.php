<section  id="top" class="content" >
    <div class="container-fluid">
	
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h1>
                             Helpdesk Report <i class="material-icons">person</i><br>
                        </h1>         
                    </div>  
                    <div class="row container">
                        <form method="post" action="<?php echo base_url(); ?>index.php/Admission/">
                            <div class="col-md-12">
                                <div class="row container">
                                    <!--
                                    <div class="col-md-3 card" style="margin-left:10px">
                                        <h5>TO</h5>
                                        <div class="input-group date">
                                            <input type="date" class="form-control" placeholder="Date start...">
                                            <span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                            </span>
                                        </div>
                                    </div>
                                    -->
                                    <div class="col-md-3"><br>
                                        <button class="btn btn-primary filterModal" type="button"> FILTERS </button>
                                        <span class="exportResults"></span>
                                        <button class="btn btn-default loading" style="border:0px" type="button"> LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></button>
                                    </div> 
                                    <div class="col-md-12 row"><br>
                                        <div class="col-md-2">
                                            <label>ACTIVE FILTERS:</label>
                                        </div>
                                        <div class="col-md-12 row ActiveFilters">


                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </form>
                    </div> 
                    <br>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="table panel panel-danger" style="overflow-x:auto; overflow-y: auto;  padding:25px 20px 20px 20px">
                <table class="table table-striped table-bordered" id="ReportTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Inquirer Name</th>
                            <th>Inquirer Email</th>
                            <th>Contact Number</th>
                            <th>Student Number</th>
                            <th>Student Level</th>
                            <th>Student Department</th>
                            <th>Student Strand</th>
                            <th>Student Program</th>
                            <th>Inquiry</th>
                            <th>Resolved</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>

                <table id="example" class="display" width="100%"></table>
            </div>         
        </div>

	</div>
</section>


<!-- Modal Confirmation-->
<div class="modal fade" id="herpdeskFilterModal" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="datefilter_form" method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">REPORT FILTERS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 filter-input">
                        <h4>Search by Specific key</h4>
                        <div class="form-line">
                            <input class="form-control" placeholder="Search..." id="searchkey" type="text">
                        </div>
                        <hr>
                    </div>
                    <div class="col-xs-12">
                        <h4>Search by Date range</h4>
                        <div class="form-line">
                            <span>From</span>
                            <input class="form-control date" id="datefrom" name="datefrom" type="date">
                        </div>
                    </div> 
                    <div class="col-xs-12"><br>
                        <div class="form-line">
                            <span>To</span>
                            <input class="form-control date" id="dateto" name="dateto" type="date">
                        </div>
                    </div> 
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                <button type="submit" id="addFilter" name="savesubject" class="btn btn-primary">ADD FILTER</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal Confirmation-->
<div class="modal fade" id="helpdeskInquiryInfo" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="datefilter_form" method="post">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h5 style="color:black" class="modal-title">NAME: <span id="inquirerName"></span></h5>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h5 style="color:black" class="modal-title">EMAIL: <span id="inquirerEmail"></span></h5>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h5 style="color:black" class="modal-title">CONTACT: <span id="inquirerContact"></span></h5>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h5 style="color:black" class="modal-title">STUDENT / REFERENCE NUMBER: <span id="inquirerStudentID"></span></h5>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h5 style="color:black" class="modal-title">EDUCATION: <span id="inquirerEducation"></span></h5>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h5 style="color:black" class="modal-title">STRAND: <span id="inquirerStrand"></span></h5>
                        <hr> 
                    </div>
                    <div class="col-md-12">
                        <h5 style="color:black" class="modal-title">PROGRAM: <span id="inquirerProgram"></span></h5>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h5 style="color:black" class="modal-title">DATE: <span id="inquirerDate"></span></h5>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h5 style="color:black" class="modal-title">INQUIRY: <br><br><span id="inquirerInquiry"></span></h5>
                        <hr>
                    </div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
var baseurl = '<?php echo base_url(); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/helpdesk_report.js"></script>





