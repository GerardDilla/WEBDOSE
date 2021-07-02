<?php $render = $this->data['render_data'];?>
<style>
  .panel-reg {
  border-color: #74B595;
  background-color: #8AD4AF;
}
.panel-reg > .panel-heading {
  color: #ffffff;
  background-color: #74B595;
  border-color: #74B595;
}
.panel-reg > .panel-heading + .panel-collapse .panel-body {
  border-top-color: #ebccd1;
}
.panel-reg > .panel-footer + .panel-collapse .panel-body {
  border-bottom-color: #ebccd1;
}
input[type=checkbox] {
    left: 0px !important;
    opacity: 1 !important;
    margin: 0px !important;
  }
</style>
<section id="top" class="content" style="background-color: #fff;">
  <!-- CONTENT GRID-->
  <div class="container-fluid">
    <!-- MODULE TITLE-->
    <div class="block-header">
      <h1> <i class="material-icons" style="font-size:100%">label</i>Dose Admin</h1>
    </div>
    <?php
    if (isset($render['output'])) {
      foreach ($render['output'] as $info) {
        $output_sched = $info['output'];
        $section = $info['section_name'];
        $school_year = $info['school_year'];
        $year_level = $info['year_level'];
        $semester = $info['semester'];

        $other_fee = $info['other_fee'];
        $misc_fee = $info['misc_fee'];
        $lab_fee = $info['lab_fee'];
        $total_fee = $info['total_fee'];
        $client_information = $info['client_information'];
      }
      $render['plan'] = '';
    } else {
      $output_sched = '';
      $section = '';
      $school_year = '';
      $year_level = '';
      $semester = '';

      $other_fee = '';
      $misc_fee = '';
      $lab_fee = '';
      $total_fee = '';
    }

    if (isset($render['output_basiced'])) {
      foreach ($render['output_basiced'] as $info) {

        $output_plan_fee = $info['output_plan_fee'];
        $plan_name = $info['plan_name'];
        $output_total_fee = $info['output_total_fee'];
        $client_information = $info['client_information'];
        $SchoolYear = $info['SchoolYear'];
      }
    } else {
      $output_plan_fee = '';
      $plan_name = '';
      $output_total_fee = '';
      $SchoolYear = '';
    }
    ?>
    <!-- <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">St.Dominic College of Asia</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">REPORTS<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" data-toggle="modal" data-target="#basicModal2">Inquiries</a></li>
                <li><a href="#" data-toggle="modal" data-target="#basicModal">Reservations</a></li>
                <li><a href="#"></a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Other Reports</li>
                <li><a href="#">SM Molino</a></li>
                <li><a href="#">SM Bacoor</a></li>
                <li class="divider"></li>
                <li><a href="#">Contents to Ff.</a></li>
              </ul>
            </li>
            <li><a href="<?php echo site_url("admin_page"); ?>">HOME</a></li>
            <li><a href="<?php echo site_url("logout"); ?>">LOG OUT</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">REGISTER AS<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" data-toggle="modal" data-target="#basicModal2">Deposit slip</a></li>
                <li><a href="#" data-toggle="modal" data-target="#basicModal">Voucher</a></li>
                <li><a href="#">Help</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div> -->
    <!--/.NAVBAR END-->
    <!--------------------------------modal voucher-------------------------------------------------->
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="panel panel-sdca">
          <div class="panel-heading">
            <STRONG> REGISTER VOUCHER</STRONG>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-8">
                <div class="input-group">
                  <span class="input-group-addon">VCH#</span>
                  <input type="number" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Voucher Number">
                </div>
                <br>
              </div>
              <!--col-->
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">Use Count</span>
                  <input type="number" required="" class="form-control" aria-describedby="basic-addon1" placeholder="#">
                </div>
              </div>
              <!--col-->
            </div>
            <!--row-->
          </div>
          <div class="panel-footer">
            <button class="btn btn-info"><span class="glyphicon glyphicon-save"></span> ADD</button>
          </div>
        </div>
      </div>
    </div>
    <!--------------------------------modal deposit-------------------------------------------------->
    <div class="modal fade" id="basicModal2" tabindex="-1" role="dialog" aria-labelledby="basicModal2" aria-hidden="true">
      <div class="modal-dialog">
        <div class="panel panel-sdca">
          <div class="panel-heading">
            <STRONG> REGISTER DEPOSIT SLIP</STRONG>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-8">
                <div class="input-group">
                  <span class="input-group-addon">DEPOSIT SLIP #</span>
                  <input type="number" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Voucher Number">
                </div>
                <br>
              </div>
              <!--col-->
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">VALUE</span>
                  <input type="number" min="0" required="" class="form-control" aria-describedby="basic-addon1" placeholder="#">
                </div>
              </div>
              <!--col-->
            </div>
            <!--row-->
            <div class="col-md-10">
              <select class="form-control" placeholder="">
                <option value="">BANK NAME</option>
                <option>EastWest</option>
              </select>
            </div>
          </div>
          <div class="panel-footer">
            <button class="btn btn-info"><span class="glyphicon glyphicon-save"></span> ADD</button>
          </div>
        </div>
      </div>
    </div>
    <!--/.HEADING END-->

    <!--SEARCH ENGINE SEARCH ENGINE SEARCH ENGINE SEARCH ENGINESEARCH ENGINE  SEARCH ENGINE SEARCH ENGINE SEARCH ENGINESEARCHSEARCH ENGINESEARCH ENGIN-->

    <!--enD OF SEARCH ENGINE-->
    <!-------------------------------------------------------------------PAYMENT LARGE PANEL------------------------------------------------------------>
    <section id="pricing-one">
      <div class="container">
        <div class="row text-center pad-row">
          <div class="panel panel-default">
            <div class="panel-heading" id="table">
              <div class="row text-left">
                <div class="col-md-5">
                  <STRONG>
                    PAYMENT, REGISTRATION FORM AND SCHEDULE SECTION
                  </STRONG>
                </div>
              </div>
            </div>
          </div>
          <!--start of table info-->
          <div class="col-md-7">
            <!--    Context Classes  -->
            <div class="panel panel-sdca">
              <div class="panel-heading">
                PAYMENT SECTION
              </div>
              <div class="panel-body">
                <div class="text-left">
                  <div class="row">
                    <div class="col-md-12">
                      <?php print $client_information; ?>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                </div>
                <!--text left-->
                <div class="row">
                  <div class="col-md-3 col-md-offset-8">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="<?php print $render['button_view_regform']; ?>">View Registration Form</button>
                  </div>
                  <!--col-->
                </div>
                <!--row-->
              </div>
              <!--panel body-->
            </div>
            <!--panel panel-->
            <!--  end  Context Classes  -->
          </div>
          <!-------------------------------------------------------------------REGISTRATION FORM VIEW MODAL ------------------------------------------------------------>
          <div class="modal fade bs-example-modal-regform" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="panel panel-reg">
                <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO.png"); ?>" width="320" height="250">
                <div class="panel-heading">
                  <strong>TEMPORARY REGISTRATION FORM</strong>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-3 text-left">
                      <prinz></prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-center">
                      <prinz> Semester: <?php print $semester; ?> </prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-center">
                      <prinz> Academic Year: <?php print $school_year; ?> </prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-right">
                      <prinz>Section: <?php print $section; ?></prinz>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                  <div class="row">
                    <div class="col-xs-3 text-left">
                      <prinz> Name: <?php print $render['client_name']; ?> </prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-center">
                      <prinz> Program: <?php print $render['program_code']; ?> </prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-center">
                      <prinz> Year Level: <?php print $year_level; ?> </prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-right">
                      <prinz> Encoder: <?php print $render['encoder']; ?> </prinz>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                  <div class="row">
                    <div class="col-xs-6 text-left">
                      <prinz></prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-6 text-right">
                      <prinz></prinz>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                </div>
                <!--panel boy-->
                <div class="panel panel-black"></div>
                <!-------------------------------------------------------------------REGISTRATION FORM SCHEDULE SECTION ------------------------------------------------------------>
                <div class="panel-body">
                  <div class="table-responsive">
                    <prinz>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SchedCode</th>
                            <th>Subject</th>
                            <th>Subject Title</th>
                            <th>Lec</th>
                            <th>Lab</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Room</th>
                          </tr>
                        </thead>
                        <?php print $output_sched; ?>
                      </table>
                    </prinz>
                  </div>
                  <!-------------------------------------------------------------------REGISTRATION FORM TUITION FEE SECTION ------------------------------------------------------------>
                  <div class="panel panel-black"></div>
                  <div class="col-xs-6 col-xs-offset-2">
                    <div class="row text-left">
                      Miscellaneous Fees: <?php print $misc_fee; ?>
                    </div>
                    <!--row-->
                    <div class="row text-left">
                      Laboratory Fees: <?php print $lab_fee; ?>
                    </div>
                    <!--row-->
                    <div class="row text-left">
                      Other Fess: <?php print $other_fee; ?>
                    </div>
                    <!--row-->
                    <div class="row text-left">
                      Total Fees: <?php print $total_fee; ?>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                </div>
                <!-------------------------------------------------------------------REGISTRATION FORM FOOTER SECTION ------------------------------------------------------------>
                <div class="panel-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>
                </div>
                <!--panel footer-->
              </div>
              <!--panel panel-->
              <!--  end  Context Classes  -->
            </div>
            <!--modal end cash dialog-->
          </div>
          <!--modal end cash-->
          <div class="modal fade bs-example-modal-regform2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="panel panel-reg">
                <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO.png"); ?>" width="320" height="250">
                <div class="panel-heading">
                  <strong>BASICED REGISTRATION FORM</strong>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-3 text-left">
                      <prinz></prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-center">
                      <prinz> Academic Year: <?php print $SchoolYear; ?></prinz>
                    </div>
                    <!--col-->
                  </div>
                  <div class="row">
                    <div class="col-xs-3 text-left">
                      <prinz> Name: <?php print $render['client_name']; ?> </prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-center">
                      <prinz> Address: </prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-center">
                      <prinz> Grade Level: <?php print $render['program_code']; ?></prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-3 text-right">
                      <prinz> Encoder: <?php print $render['encoder']; ?></prinz>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                  <div class="row">
                    <div class="col-xs-6 text-left">
                      <prinz></prinz>
                    </div>
                    <!--col-->
                    <div class="col-xs-6 text-right">
                      <prinz></prinz>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                </div>
                <!--panel boy-->
                <div class="panel panel-black">
                  <table>
                    <?php print $output_total_fee; ?>
                    <?php print $output_plan_fee; ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-------------------------------------------------------------------PAYMENT SMALL CONTENT SECTION AND MODAL BUTTON------------------------------------------------------------>
          <div class="col-md-5">
            <div class="panel panel-sdca">
              <div class="panel-heading">
                <h4>PAYMENT TYPE</h4>
              </div>
              <div class="panel-body">
                Contents to be followed
              </div>
              <div class="panel-footer">
                <!--Mooooooodaaaallllllll pop up-->
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-cash">CASH</button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default">D slip</button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-cheque">CHEQUE</button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-voucher">VOUCHER</button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-card">CARD</button>
                  </div>
                </div>
              </div>
              <!--footer-->
            </div>
            <!--PANEL PANEL-->
          </div>
          <!--COL-->
          <!-------------------------------------------------------------------CASHPAYMENT MODAL------------------------------------------------------------------>
          <div class="modal fade bs-example-modal-cash" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="panel panel-info">
                <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO.png"); ?>" width="450" height="250">
                <div class="panel-heading">
                  <strong>CASH PAYMENT SECTION</strong>
                </div>
                <form action="" method="post">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon">Php</span>
                          <input type="number" min="5000" step="any" name="payment_cash" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Amount">
                          <input type="hidden" name="plan" value="<?php print $render['plan']; ?>" />
                        </div>
                        <br>
                      </div>
                      <!--col-->
                    </div>
                    <!--row-->
                  </div>
                  <!--panel boy-->
                  <div class="panel-footer">
                    <button type="submit" class="btn btn-success">PAY</button>
                    <div class="checkbox">
                      <label><input required="" type="checkbox" value="">Are you sure?</label>
                    </div>
                  </div>
                  <!--panel footer-->
                </form>
              </div>
              <!--panel panel-->
              <!--  end  Context Classes  -->
            </div>
            <!--modal end cash dialog-->
          </div>
          <!--modal end cash-->
          <!-------------------------------------------------------------------CHEQUE PAYMENT MODAL-------------------------------------------------------------->
          <div class="modal fade bs-example-modal-cheque" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="panel panel-success">
                <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO.png"); ?>" width="450" height="250">
                <div class="panel-heading">
                  <strong>CHEQUE PAYMENT SECTION</strong>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <input type="text" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Cheque Number">
                        <span class="input-group-addon" id="basic-addon1">C#</span>
                      </div>
                      <div class="form-group">
                        <br>
                        <select class="form-control" placeholder="">
                          <option value="">Bank Name</option>
                          <option>EastWest Bank</option>
                          <option>Metro Bank</option>
                          <option>Union Bank</option>
                        </select>
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon">Php</span>
                        <input type="text" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Amount">
                        <span class="input-group-addon" id="basic-addon1">.00</span>
                      </div>
                    </div>
                    <!--col-->
                    <p> note:wala pang date</p>
                  </div>
                  <!--row-->
                </div>
                <!--panel body-->
                <div class="panel-footer">
                  <button type="button" class="btn btn-success">PAY</button>
                </div>
                <!--panel-footer-->
              </div>
              <!--panel panel-->
              <!--  end  Context Classes  -->
            </div>
            <!--modal end  dialog-->
          </div>
          <!--modal end -->
          <!-------------------------------------------------------------------VOUNCER PAYMENT ------------------------------------------------------------------>
          <div class="modal fade bs-example-modal-voucher" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="panel panel-warning">
                <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO.png"); ?>" width="450" height="250">
                <div class="panel-heading">
                  <strong>VOUCHER PAYMENT SECTION</strong>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <select class="form-control" placeholder="">
                          <option value="">Select Voucher</option>
                          <option>00000001</option>
                        </select>
                      </div>
                      <!--input grp-->
                      <div class="input-group">
                        <span class="input-group-addon">Php</span>
                        <input type="number" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Amount">
                        <span class="input-group-addon">.00</span>
                      </div>
                      <br>
                      <div class="form-group">
                        <select class="form-control" placeholder="">
                          <option value="">Fees</option>
                          <option>Tuition</option>
                          <option>Miscellaneous</option>
                          <option>Laboratory Fee</option>
                          <option>Others</option>
                        </select>
                      </div>
                      <!--input grp-->
                      <label><strong>Usable voucher remaining: echo here</strong></label>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                </div>
                <!--panel body-->
                <div class="panel-footer">
                  <button type="button" class="btn btn-success">PAY</button>
                  <div class="btn-group" role="group">
                    <button type="button" data-dismiss="modal" class="btn btn-danger" data-toggle="modal" data-target="#basicModal"><span class="glyphicon glyphicon-plus"></span> VOUCHER</button>
                  </div>
                </div>
                <!--panel-footer-->
              </div>
              <!--panel panel-->
              <!--  end  Context Classes  -->
            </div>
            <!--modal end cash dialog-->
          </div>
          <!--modal end cash-->
          <!--------------------------------modal voucher-------------------->
          <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
              <div class="panel panel-sdca">
                <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO.png"); ?>" width="450" height="250">
                <div class="panel-heading">
                  <STRONG> REGISTER VOUCHER</STRONG>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon">VCH#</span>
                        <input type="number" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Voucher Number">
                      </div>
                      <br>
                    </div>
                    <!--col-->
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon">Use Count</span>
                        <input type="number" required="" class="form-control" aria-describedby="basic-addon1" placeholder="#">
                      </div>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                </div>
                <div class="panel-footer">
                  <button data-dismiss="modal" data-toggle="modal" data-target=".bs-example-modal-voucher" class="btn btn-danger"><span class="glyphicon glyphicon-backward"></span> BACK</button>
                  <button class="btn btn-info"><span class="glyphicon glyphicon-save"></span> ADD</button>
                </div>
              </div>
            </div>
            <!---------------------------------------------------------------------- CARD PAYMENT ------------------------------------------------------------------>
            <div class="modal fade bs-example-modal-card" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="panel panel-danger">
                  <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO.png"); ?>" width="450" height="250">
                  <div class="panel-heading">
                    <strong>CARD PAYMENT SECTION</strong>
                  </div>
                  <div class="panel-body">
                    <form method="post" action="">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-group">
                            </div>
                            <!--input grp-->
                            <input name="card_number" type="number" maxlength="4" required="" class="form-control" placeholder="Last Four Digits ">
                          </div>
                          <div class="form-group">
                            <select name="bank" class="form-control" placeholder="">
                              <option value="">Bank Name</option>
                              <?php print $render['bank_list']; ?>
                            </select>
                          </div>
                          <div class="input-group">
                            <span class="input-group-addon">Php</span>
                            <input name="payment_card" type="text" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Amount">
                            <span class="input-group-addon" id="basic-addon1">.00</span>
                          </div>
                        </div>
                        <!--col-->
                      </div>
                      <!--row-->
                  </div>
                  <!--panel body-->
                  <div class="panel-footer">
                    <button type="submit" class="btn btn-success">PAY</button>
                    </form>
                  </div>
                  <!--panel-footer-->
                </div>
                <!--panel panel-->
                <!--  end  Context Classes  -->
              </div>
              <!--modal end cash dialog-->
            </div>
            <!--modal end cash-->
          </div>
        </div>
      </div>
    </section>
  </div>
</section>