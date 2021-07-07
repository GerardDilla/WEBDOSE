<style>
  .panel-sdca {
    border-color: #800000;
  }

  .panel-sdca>.panel-heading {
    color: #ffffff;
    background-color: #800000;
    border-color: #800000;
  }

  .panel-sdca>.panel-heading+.panel-collapse .panel-body {
    border-top-color: #ebccd1;
  }

  .panel-sdca>.panel-footer+.panel-collapse .panel-body {
    border-bottom-color: #ebccd1;
  }

  .search_margin {
    margin: 8px 0 18px 0;
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
    <!--/ MODULE TITLE-->

    <div class="card">
      <div class="body">
        <?php
        $render = $this->data['render_data'];
        if ($render['output_select'] != '') {
          foreach ($render['output_select'] as $info) {

            $full_name = $info['full_name'];
            $enrollment_button_link = $info['enrollment_button_link'];
            $reservation_button_link = $info['reservation_button_link'];
            if ($render['student_type'] == 'highered') {
              $first_choice = $info['first_choice'];
              $second_choice = $info['second_choice'];
              $third_choice = $info['third_choice'];
              $major_first = $info['major_first'];
              $major_second = $info['major_second'];
              $major_third = $info['major_third'];
              $major_first_name = $info['major_first_name'];
              $major_second_name = $info['major_second_name'];
              $major_third_name = $info['major_third_name'];
            } else {
              $grade_level = $info['grade_level'];
            }
          } //end of foreach

          $student_type_insert = $render['student_type'];
        } else {
          $full_name = '';
          $enrollment_button_link = '';
          $reservation_button_link = '';
          $first_choice = '';
          $second_choice = '';
          $third_choice = '';
          $grade_level = '';
          $student_type_insert = '';
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
                    <li><a href="#" data-toggle="modal" data-target="#">Inquiries</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#">Reservations</a></li>
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
                <li><a href="<?php echo site_url("DoseAdmin/main"); ?>">HOME</a></li>
                <li><a href="#">BASICED ADMIN</a></li>
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

            <form method="post" action="<?php echo site_url('/admin_page'); ?>">
              <div class="panel panel-sdca">
                <div class="panel-heading">
                  <STRONG> REGISTER DEPOSIT SLIP</STRONG>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon">DEPOSIT SLIP #</span>
                        <input type="number" name="depositslip_no" required="" class="form-control" aria-describedby="basic-addon1" placeholder="Voucher Number">
                      </div>
                      <br>
                    </div>
                    <!--col-->
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon">VALUE</span>
                        <input type="number" name="depositslip_amount" min="0" required="" class="form-control" aria-describedby="basic-addon1" placeholder="#">
                      </div>
                    </div>
                    <!--col-->
                  </div>
                  <!--row-->
                  <div class="row">
                    <div class="col-md-6">
                      <select name="bank_name" class="form-control" placeholder="">
                        <option value="">BANK NAME</option> <?php print $render['bank_list']; ?>
                      </select>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input type="date" name="depositslip_date" class="form-control" placeholder="Date">
                      </div>
                      <!--input grp-->
                    </div>
                    <!--col-lg-6-->

                  </div>
                </div>
                <div class="panel-footer">
                  <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-save"></span> ADD</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--/.HEADING END-->

    <!--SEARCH ENGINE SEARCH ENGINE SEARCH ENGINE SEARCH ENGINESEARCH ENGINE  SEARCH ENGINE SEARCH ENGINE SEARCH ENGINESEARCHSEARCH ENGINESEARCH ENGIN-->

    <!--enD OF SEARCH ENGINE-->
    <section id="pricing-one">
      <div class="container">
        <div class="row text-center pad-row">
          <?php if ($render['alert'] != '') { ?>
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <?php print $render['alert']; ?>
            </div>
          <?php } ?>
          <div class="panel panel-default">


            <div class="panel-heading" id="table">
              <div class="row">

                <form class="" role="search" method="get" action="">
                  <div class="col-md-4">
                    <input type="text" required="" name="search_value" class="form-control" placeholder="Search for..">
                  </div>
                  <div class="col-md-4 search_margin">
                    <select name="student_type" class="form-control" required="" placeholder="">
                      <option value="">Department</option>
                      <!--<option value="highered">HigherEd</option>-->
                      <option value="basiced">BasicEd</option>
                      <option value="seniorhigh">Seniorhigh</option>
                    </select>
                  </div>
                  <div class="col-md-4 search_margin">
                    <select name="search_filter" class="form-control" required="" placeholder="">
                      <option value="">Filter by:</option>
                      <option value="reference_number">Reference No.</option>
                      <option value="student_number">Student No.</option>
                      <option value="last_name">Surname</option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Go Search!</button>
                  </div>

                </form>

              </div>
            </div>
          </div>
          <!--start of table info-->

          <div class="col-md-8">
            <!--    Context Classes  -->
            <div class="panel panel-sdca">



              <div class="panel-heading">
                LIST OF ENROLLEES</div>

              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table">
                    <?php
                    // echo $test;
                    // table list;
                    print $render['output_search'];
                    ?>
                  </table>
                </div>
              </div>
            </div>
            <!--  end  Context Classes  -->
          </div>

          <div class="col-md-4">
            <div class="panel panel-sdca">
              <div class="panel-heading">
                <h4>STUDENT INFORMATION</h4>
              </div>
              <div class="panel-body">

                <div class="row">
                  <div class="col-md-12">

                    <div class="form-group">
                      <fieldset disabled>
                        <label for="exampleInputName2">Name</label><br>
                        <input type="text" required="" class="form-control" id="exampleInputName2" placeholder="Name" value="<?php print $full_name; ?>">
                      </fieldset>
                    </div>
                  </div>
                </div>

                <br>
                <div class="row">
                  <div class="col-md-8 col-md-offset-2">
                    <div class="form-group">
                      <fieldset disabled>
                        <label for="exampleInputEmail2">Reference No.</label><br>
                        <input type="text" class="form-control input-md" id="exampleInputEmail2" placeholder="Reference Number" value="<?php print $render['select_value']; ?>">

                      </fieldset>
                    </div>
                  </div>

                </div>
                <!--row-->
              </div>


              <p></p>




              <p></p>




              <br>



              <p></p>


              <div class="panel-footer">

                <!--Mooooooodaaaallllllll pop up-->

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="<?php print $reservation_button_link; ?>">RESERVATION</button>
                <button type="button" id="enrollmentButton" class="btn btn-primary" data-toggle="modal" data-target="<?php print $enrollment_button_link; ?>">ENROLLMENT</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update">UPDATE</button>

              </div>
            </div>
          </div>

          <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">


              <div class="panel panel-sdca">
                <div class="panel-heading">
                  <STRONG> UPDATE STUDENT INFORMATION</STRONG>
                </div>

                <div class="panel-body">

                  <div class="col-md-4 ">
                    <p>Reference Number: <?php echo $render['select_value']; ?> </p>
                    <p>Student Type: <?php echo $student_type_insert; ?> </p>
                    <form action="" method="post">
                      <label for="exampleInputName3">Exam Status</label>

                      <select name="this_information" class="form-control" placeholder="">
                        <option value="">EXAM RESULT</option>
                        <option value="pass">PASS</option>
                        <option value="fail">FAILED</option>
                      </select>


                      <input type="hidden" value="<?php echo $render['select_value']; ?>" name="reference_no" />
                      <input type="hidden" value="<?php print $student_type_insert; ?>" name="student_type" />

                      <input type="hidden" value="exam" name="other_information" />
                      <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-save"></span> Submit Exam Result</button>
                    </form>
                  </div>

                  <div class="col-md-4">
                    <form method="post" action="">
                      <label for="exampleInputName3">Priority Inquiry</label>
                      <select class="form-control" name="this_information" placeholder="">
                        <option value="">Select</option>
                        <?php print $render['priority_list']; ?>
                      </select>

                      <input type="hidden" value="<?php echo $render['select_value']; ?>" name="reference_no" />
                      <input type="hidden" value="<?php print $student_type_insert; ?>" name="student_type" />

                      <input type="hidden" value="priority" name="other_information" />
                      <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-save"></span> Submit Priority Result</button>
                    </form>
                  </div>

                  <div class="col-md-4" style=" <?php print $render['div_style']; ?> ">
                    <form method="post" action="">
                      <label for="exampleInputName3">Strand Update</label>
                      <?php print $render['track_strand_form']; ?>

                      <div id="seniorhigh_strand"><b></b></div>

                      <input type="hidden" value="<?php echo $render['select_value']; ?>" name="reference_no" />
                      <input type="hidden" value="<?php print $student_type_insert; ?>" name="student_type" />
                      <input type="hidden" value="strand" name="other_information" />
                      <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-save"></span> Submit Strand</button>
                    </form>
                  </div>






                </div>
                <div class="panel-footer">



                </div>

              </div>










            </div>
          </div>





          <!--------Enrollment basic Ed Modal-------->
          <!--------Enrollment basic Ed Modal-------->
          <div class="modal fade bs-example-modal-enrollmentbasiced" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">



              <form id="enrollmentForm" action="<?php echo site_url($render['form_url_enrollment']); ?>" method="post">
                <div class="panel panel-sdca">

                  <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO_SLIM.png"); ?>" width="300" height="250">
                  <div class="panel-heading"><strong>BasicEd Enrollment Section</strong></div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-6 text-left">Reference No: <?php print $render['select_value']; ?></div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 text-left">Full Name: <?php print $full_name; ?></div>
                    </div>


                    <br>
                    <div class="row">
                      <div class="col-md-6 text-left">Grade Level to enroll
                        <select name="program_code" id="gradeSelector" class="form-control" placeholder="" onChange="seniorhigh_track(this.value)">
                          <option value="<?php print $grade_level; ?>"><?php print $grade_level; ?></option>
                          <?php print $render['grade_level_output']; ?>

                        </select>

                        <!-- <input type="hidden" name="shs_check" value="1"  /> -->

                        <div id="seniorhigh_track"><b>Track</b></div>

                        <div id="seniorhigh_stand_assessment"><b>Strand</b></div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6 text-left">School Year
                        <select name="school_year" id="schoolYear" class="form-control" placeholder="">

                          <?php print $render['select_school_year']; ?>

                        </select>
                      </div>
                    </div>
                    <br />
                    <div class="row text-left">
                      <div class="col-md-5">
                      </div>
                    </div>
                    <!--col-->




                  </div>
                  <!--panelbody-->
                  <div class="panel-footer">

                    <div class="checkbox">
                      <!-- Enrollment -->
                      <label>Please review changes before proceeding.</label>
                      <!-- <label><input required type="checkbox" value=""></label> -->
                      <label>
                        <input required type="checkbox" />
                        <!-- <span>Red</span> -->
                      </label>
                    </div>
                    <input type="hidden" value="basiced" name="student_type" />
                    <input type="hidden" name="reference_number" value="<?php print $render['select_value']; ?>" />
                    <input type="hidden" name="client_name" value="<?php print $full_name; ?>" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="enrollmentSubmit" class="btn btn-primary">Submit</button>

                  </div>
                  <!--footer-->
                </div>

            </div>
          </div>
          </form>






          <!--------------------------BasicEd Reservation-------------------------->

          <form action="" method="post">
            <div class="modal fade bs-example-modal-enrollmentbasicedres" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">




                <div class="panel panel-sdca">
                  <div class="panel-heading">
                    <label>Complete Payment Info</label><br>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <fieldset disabled>
                        <label for="exampleInputName2">Name</label><br>
                        <input type="text" required="" class="form-control" id="exampleInputName2" placeholder="Name" value="<?php echo $full_name; ?>">
                      </fieldset>
                      <input type="hidden" value="<?php echo $full_name; ?>" name="full_name" />
                    </div>



                    <div class="form-group">
                      <fieldset disabled>
                        <label for="exampleInputEmail2">Reference No.</label><br>
                        <input type="text" class="form-control input-md" id="exampleInputEmail2" placeholder="Reference Number" value="<?php echo $render['select_value']; ?>">
                      </fieldset>
                      <input type="hidden" value="<?php echo $render['select_value']; ?>" name="reference_no" />
                      <input type="hidden" value="<?php print $student_type_insert; ?>" name="student_type" />
                    </div>





                    <label for="exampleInputName2">Payment</label>
                    <div class="input-group">
                      <input type="number" name="reservation_payment" required="" class="form-control" id="exampleInputName2" aria-describedby="basic-addon1" placeholder="Amount">
                      <span class="input-group-addon" id="basic-addon1">.00</span>
                    </div>

                    <br>



                  </div>
                  <div class="panel-footer">

                    <div class="checkbox">

                      <label>Please review changes before proceeding.</label>
                      <label><input required="" type="checkbox" value=""></label>
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary"></button>
                  </div>
                  <!--footer-->
                </div>

              </div>
            </div>
          </form>
          <!--------Enrollment Higher Ed Modal-------->
          <div class="modal fade bs-example-modal-reservation" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">


              <form action="" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO_SLIM.png"); ?>" width="450" height="250">
                  </div>
                  <div class="modal-body">
                    <div class="panel panel-sdca">
                      <div class="panel-heading">
                        <label>Complete Payment Info</label><br>
                      </div>
                      <div class="panel-body">
                        <div class="form-group">
                          <fieldset disabled>
                            <label for="exampleInputName2">Name</label><br>
                            <input type="text" required="" class="form-control" id="exampleInputName2" placeholder="Name" value="<?php echo $full_name; ?>">
                          </fieldset>
                          <input type="hidden" value="<?php echo $full_name; ?>" name="full_name" />
                        </div>



                        <div class="form-group">
                          <fieldset disabled>
                            <label for="exampleInputEmail2">Reference No.</label><br>
                            <input type="text" class="form-control input-md" id="exampleInputEmail2" placeholder="Reference Number" value="<?php echo $render['select_value']; ?>">
                          </fieldset>
                          <input type="hidden" value="<?php echo $render['select_value']; ?>" name="reference_no" />
                          <input type="hidden" value="<?php print $student_type_insert; ?>" name="student_type" />
                        </div>





                        <label for="exampleInputName2">Payment</label>
                        <div class="input-group">
                          <input type="number" name="reservation_payment" required="" class="form-control" id="exampleInputName2" aria-describedby="basic-addon1" placeholder="Amount">
                          <span class="input-group-addon" id="basic-addon1">.00</span>
                        </div>

                        <br>

                        <label for="exampleInputName3">Inquiry Status</label>
                        <select class="form-control" placeholder="">
                          <option value=""></option>
                          <option>Freshmen</option>
                          <option>Transferee</option>
                          <option>2nd Courser</option>
                        </select>

                      </div>

                    </div>
                  </div>

                  <div class="modal-footer">
                    <div class="checkbox">
                      <label><input required="" type="checkbox" value="">Are you sure?</label>
                    </div>



                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary"></button>
              </form>

              <form action="<?php echo site_url('/other_payments'); ?>" method="post">
                <input type="hidden" value="<?php echo $render['select_value']; ?>" name="reference_number" />
                <input type="hidden" value="<?php echo $full_name; ?>" name="client_name" />
                <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-plus"></span>Use D.slip</button>
              </form>
            </div>







          </div>
        </div>
      </div>
      <!-----------------------------Add on Modal for Deposit Slip-------------------------------->
      <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">


          <div class="panel panel-sdca">
            SUBMIT

          </div>










        </div>
      </div>

      <!---enrollment section section section enrollment enrollment bammmmmm-->
      <div class="modal fade bs-example-modal-enrollment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">


          <form action="<?php echo site_url($render['form_url_enrollment']); ?>" method="post">
            <div class="modal-content">
              <div class="modal-header">
                <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO_SLIM.png"); ?>" width="350" height="150">
              </div>
              <div class="modal-body">
                <div class="panel panel-sdca">
                  <div class="panel-heading">
                    <label>Complete Enrollment Info</label><br>
                  </div>
                  <div class="panel-body">

                    <div class="row">

                      <div class="col-md-3 col-md-offset-5">
                        <div class="form-group">

                          <label for="exampleInputEmail2">Reference No.</label>
                          <label for="exampleInputName2"><?php print $render['select_value']; ?></label>


                        </div>
                      </div>

                      <div class="col-md-4">

                        <div class="form-group">


                          <label for="exampleInputName2"><?php print $full_name; ?></label>



                        </div>
                      </div>
                    </div>
                    <!--row for labels-->





                    <div class="row text-left">
                      <div class="col-md-3 col-md-offset-1">
                        <label>Requirements / Documents </label>

                        <?php
                        foreach ($render['highered_documents'] as $document) {
                          # code...
                          if ($document['Document_Name'] == "") {
                            # code...
                            $doc_name = $document['Old_Code'];
                          } else {
                            $doc_name = $document['Document_Name'];
                          }
                        ?>
                          <div><input type="checkbox" name="document[]" value="<?php echo $document['ID']; ?>"><?php echo $doc_name; ?></div>
                        <?php
                        }
                        ?>
                      </div>
                      <div class="col-md-5 col-md-offset-3">
                        <table border="0">
                          <tr>
                            <td><label> 1st choice: <?php print $first_choice; ?></label> </td>
                            <td>&nbsp; </td>
                            <td>Major in: <?php print $major_first_name; ?></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td><label> 2nd choice: <?php print $second_choice; ?> </label></td>
                            <td>&nbsp; </td>
                            <td>Major in: <?php print $major_second_name; ?></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td><label> 3rd Choice: <?php print $third_choice; ?> </label></td>
                            <td>&nbsp; </td>
                            <td>Major in: <?php print $major_third_name; ?></td>
                          </tr>
                        </table>
                        <!--<label>1st choice: <?php //print $first_choice; 
                                                ?> </label>   -->
                      </div>

                    </div>
                    <!--row text-left-->

                    <!--
                      <div class="row text-left">
                                      <div class="col-md-3 col-md-offset-1">
                                         <input type="checkbox" name="document[]" value="good_moral">Good Moral Certificate
                                      </div>
                                      <div class="col-md-5 col-md-offset-3">
                                          <label>2nd choice: <?php //print $second_choice; 
                                                              ?></label>                                        
                                      </div>
                     </div><

                      <div class="row text-left">
                                       <div class="col-md-3 col-md-offset-1">
                                          <input type="checkbox" name="document[]" value="birth_cert">Birth Certificate
                                       </div>
                                       <div class="col-md-5 col-md-offset-3">
                                          <label>3rd Choice: <?php //print $third_choice; 
                                                              ?></label>                                        
                                      </div>
                      </div>
                      -->


                    <!--
                     <div class="row text-left">                      
                                        <div class="col-md-3 col-md-offset-1">
                                          <input type="checkbox" name="document[]" value="picture">Picture
                                        </div>

                    </div><

                     <div class="row text-left">                      
                                         <div class="col-md-3 col-md-offset-1">
                                           <input type="checkbox" name="document[]" value="hs_diploma">Highschool Diploma
                                         </div>

                     </div>
                        <div class="row text-left">                      
                                         <div class="col-md-4 col-md-offset-1">
                                           <input type="checkbox" name="document[]" value="form_138">Form 138-A (highschool card)
                                         </div>

                     </div>

                   -->









                    <br>
                    <div class="row">
                      <div class="col-md-1">
                        <label>Entrance Exam:</label>
                      </div>


                      <div class="col-md-3">
                        <div class="form-group">

                          <select class="form-control" placeholder="">
                            <option value="">EXAM RESULT</option>
                            <option>PASSED</option>
                            <option>FAILED</option>
                          </select>

                        </div>

                      </div>
                      <div class="col-md-2">
                        <label>Program to be Enrolled:</label>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">

                          <!--
                                    <select name="program_code" class="form-control" placeholder="">
                                     <option value="<?php print $first_choice; ?>"> <?php print $first_choice; ?></option>
                                     <?php print $render['program_list_output']; ?>
                                     
                                     </select>
                                     -->


                          <select name="program_code" class="form-control" id="sel1" onChange="course_major1(this.value, 'major1')">
                            <option value="<?php print $first_choice; ?>"> <?php print $first_choice; ?></option>
                            <?php print $render['program_list_output']; ?>

                          </select>

                          <input type="hidden" name="major_check" value="1" />

                          <div id="major1"><b>Program Major</b>

                            <select name="major1" class="form-control" id="sel1">
                              <option value="<?php print $major_first; ?>"><?php print $major_first_name; ?></option>
                            </select>
                            <!--
                                      <fieldset disabled>
                                      </fieldset>
                                      -->
                          </div>



                        </div>

                      </div>

                    </div>



                    <div class="form-group">
                      <label for="comment">Comment:</label>
                      <textarea class="form-control" rows="3" id="comment"></textarea>
                    </div>



                  </div>
                  <!--panel body-->

                </div>
                <!--panel panel sdca-->
              </div>
              <!--modal body-->

              <div class="panel-footer">
                <div class="row">
                  <div class="col-md-3">

                    <div class="checkbox">
                      <label><input required="" type="checkbox" value="">Are you sure?</label>
                    </div>
                  </div>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                  <input type="submit" class="btn btn-primary"></button>
                </div>
              </div>




              <input type="hidden" name="reference_number" value="<?php print $render['select_value']; ?>" />
              <input type="hidden" name="client_name" value="<?php print $full_name; ?>" />
              <input type="hidden" value="<?php print $student_type_insert; ?>" name="student_type" />
          </form>

        </div>
      </div>
  </div>


</section>

<!--/.PRICING-ONE END-->


<!-- PRINCE LOUIE HERRERA LANG NAG EDIT <section id="pricing-two">
            <div class="container">
           <div class="row text-center pad-row" >
                 <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-danger adjust-border-radius">
                            <div class="panel-heading adjust-border">
                             <h4>BASIC PLAN</h4> 
                            </div>
                            <div class="panel-body">

                               <ul class="plan">      
                                   <li class="price-two"><strong>25</strong> <i class="fa fa-dollar"></i> <small>per month</small></li>                       
                            <li><i class="fa fa-paper-plane-o"></i><strong>1500 </strong> Emails Accounts</li>
                            <li><i class="fa fa-graduation-cap"></i><strong>5000 GB </strong>  Cloud Space</li>
                            <li><i class="fa fa-bomb"></i><strong>230 </strong> Support Queries </li>
                                     <li><i class="fa fa-bookmark-o"></i><strong>1500 </strong> Emails Accounts</li>
                            <li><i class="fa fa-bolt"></i><strong>5000 GB </strong>  Cloud Space</li>
                            <li><i class="fa fa-bars"></i><strong>230 </strong> Support Queries </li>
                           </ul>
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-danger btn-block btn-lg adjust-border-radius">BUY NOW</a>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-primary adjust-border-radius">
                            <div class="panel-heading adjust-border">
                             <h4>MEDIUM PLAN</h4> 
                            </div>
                            <div class="panel-body">

                               <ul class="plan">      
                                   <li class="price-two"><strong>45</strong> <i class="fa fa-dollar"></i><small>per month</small></li>                       
                             <li><i class="fa fa-paper-plane-o"></i><strong>1500 </strong> Emails Accounts</li>
                            <li><i class="fa fa-graduation-cap"></i><strong>5000 GB </strong>  Cloud Space</li>
                            <li><i class="fa fa-bomb"></i><strong>230 </strong> Support Queries </li>
                                     <li><i class="fa fa-bookmark-o"></i><strong>1500 </strong> Emails Accounts</li>
                            <li><i class="fa fa-bolt"></i><strong>5000 GB </strong>  Cloud Space</li>
                            <li><i class="fa fa-bars"></i><strong>230 </strong> Support Queries </li>
                           </ul>
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-primary btn-block btn-lg adjust-border-radius">BUY NOW</a>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-success adjust-border-radius">
                            <div class="panel-heading adjust-border">
                             <h4>ADVANCE PLAN</h4> 
                            </div>
                            <div class="panel-body">

                               <ul class="plan">      
                                   <li class="price-two"><strong>95</strong> <i class="fa fa-dollar"></i><small>per month</small></li>                       
                             <li><i class="fa fa-paper-plane-o"></i><strong>1500 </strong> Emails Accounts</li>
                            <li><i class="fa fa-graduation-cap"></i><strong>5000 GB </strong>  Cloud Space</li>
                            <li><i class="fa fa-bomb"></i><strong>230 </strong> Support Queries </li>
                                     <li><i class="fa fa-bookmark-o"></i><strong>1500 </strong> Emails Accounts</li>
                            <li><i class="fa fa-bolt"></i><strong>5000 GB </strong>  Cloud Space</li>
                            <li><i class="fa fa-bars"></i><strong>230 </strong> Support Queries </li>
                           </ul>
                            </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-success btn-block btn-lg adjust-border-radius">BUY NOW</a>
                            </div>
                        </div>
                    </div>
               </div>
                </div>
         </section>
         -->
<!--/.PRICING-TWO END-->

</section>



<input type="hidden" id="addressUrl" value="<?php print site_url() . '/DoseAdmin/main'; ?>" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/enrollment.js"></script>