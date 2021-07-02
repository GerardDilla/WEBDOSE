<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>DOSE</title>
  <!-- Favicon-->
  <link rel="icon" href="<?php echo base_url(); ?>img/weweb.png" type="">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">




  <link href="<?php echo base_url(); ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Waves Effect Css -->
  <link href="<?php echo base_url(); ?>plugins/node-waves/waves.css" rel="stylesheet" />

  <!-- Animation Css -->
  <link href="<?php echo base_url(); ?>plugins/animate-css/animate.css" rel="stylesheet" />

  <!-- Sweet Alert Css -->
  <link href="<?php echo base_url(); ?>plugins/sweetalert/sweetalert.css" rel="stylesheet" />

  <link rel="stylesheet" href="<?php echo base_url(); ?>css/print.css" media="print" />

  <!-- Custom Css -->
  <link href="<?php echo base_url(); ?>css/style.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">


  <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
  <link href="<?php echo base_url(); ?>css/themes/all-themes.css" rel="stylesheet" />

  <!-- Bootstrap Select Css -->
  <link href="<?php echo base_url(); ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

  <!-- Bootstrap Select Css -->

  <!-- <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>   -->

  <!-- Jquery Core Js -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap Core Js -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.js"></script>
  <!-- Select Plugin Js -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <!-- Waves Effect Plugin Js -->
  <script src="<?php echo base_url(); ?>plugins/node-waves/waves.js"></script>
  <!-- Jquery CountTo Plugin Js -->
  <script src="<?php echo base_url(); ?>plugins/jquery-countto/jquery.countTo.js"></script>

  <!-- ChartJs -->

  <!-- Custom Js -->
  <script src="<?php echo base_url(); ?>js/pages/ui/dialogs.js"></script>
  <script src="<?php echo base_url(); ?>js/admin.js"></script>
  <script src="<?php echo base_url(); ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
  <script src="<?php echo base_url(); ?>js/pages/ui/modals.js"></script>

  <script src="<?php echo base_url(); ?>js/script.js"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script> -->
  <script src="<?php echo base_url(); ?>js/change_section.js"></script>
  <script src="<?php echo base_url(); ?>js/js/clipboard.min.js"></script>

  <script src="<?php echo base_url(); ?>js/AdmissionEditStudentInfo.js"></script>
  <script src="<?php echo base_url(); ?>js/AdmissionEditStudentInfo.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/custom.css">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.2/css/colReorder.bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap.min.css" />
  <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('plugins/simplePagination/css.css'); ?>"> -->

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url('plugins/simplePagination/jquery.simplePagination.js'); ?>"></script>
  <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>plugins/simplePagination/simplePagination.css" />

  <link rel="stylesheet" href="<?php echo base_url('css/toggleableSwitch.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
  <link rel="stylesheet" href="<?php echo base_url('plugins/waitme/waitMe.min.css'); ?>">
</head>
<?php
$render = $this->data['render_data'];
if (isset($output_basiced)) {
  foreach ($output_basiced as $info) {

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

<style>
  .body_top_margin {
    margin-top: 20px;
  }

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

  .panel-reg {
    border-color: #74B595;
    background-color: #8AD4AF;
  }

  .panel-reg>.panel-heading {
    color: #ffffff;
    background-color: #74B595;
    border-color: #74B595;
  }

  .panel-reg>.panel-heading+.panel-collapse .panel-body {
    border-top-color: #ebccd1;
  }

  .panel-reg>.panel-footer+.panel-collapse .panel-body {
    border-bottom-color: #ebccd1;
  }

  .panel-black {
    border-color: #800000;
  }

  .panel-black>.panel-heading {
    color: #ffffff;
    background-color: #000000;
    border-color: #000000;
  }

  .panel-black>.panel-heading+.panel-collapse .panel-body {
    border-top-color: #ebccd1;
  }

  .panel-black>.panel-footer+.panel-collapse .panel-body {
    border-bottom-color: #ebccd1;
  }

  .table-striped>tbody>tr:nth-child(odd)>td,
  .table-striped>tbody>tr:nth-child(odd)>th {
    background-color: #74B595;
  }

  @media print {
    body {
      font-size: 150%;
    }

    #printLink {
      display: none
    }

  }
</style>
<!-------------------------------------------------------------------PAYMENT LARGE PANEL------------------------------------------------------------>
<!-- <section id="top" class="content" style="background-color: #fff;">
  <div class="container-fluid">
    <div class="block-header">
      <h1> <i class="material-icons" style="font-size:100%">label</i>Digital Citizenship</h1>
    </div> -->

<div class="body_top_margin">
  <div class="col-md-7">
    <div class="panel panel-reg">

      <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO_SLIM.png"); ?>" width="220" height="250">



      <div class="panel-heading">
        <strong>BASICED REGISTRATION FORM</strong>

      </div>

      <div class="panel-body">



        <div class="row">
          <div class="col-xs-4 text-left">
            <prinz> Reference Number: <?php print $reference_number; ?></prinz>
          </div>
          <!--col-->

          <div class="col-xs-3 text-left">
            <prinz> Name: <?php print $client_name; ?></prinz>
          </div>
          <!--col-->



          <div class="col-xs-3 text-right">
            <prinz> School Year: <?php print $SchoolYear; ?></prinz>
          </div>
          <!--col-->
        </div>
        <!--row-->

        <div class="row">
          <div class="col-xs-4 text-left">
            <prinz> Address: </prinz>
          </div>
          <!--col-->




          <div class="col-xs-4 text-right">
            <prinz> Encoder: <?php print $encoder; ?></prinz>
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
              <?php print $output_total_fee; ?>
              <?php print $output_plan_fee; ?>


            </table>
          </prinz>
        </div>
      </div>



      <!-------------------------------------------------------------------ACKNOWLEDGEMENT RECIEPT TUITION FEE SECTION ------------------------------------------------------------>

      <div class="panel panel-black"></div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-xs-8">
            <span class="glyphicon glyphicon-info-sign"></span> Thank you for choosing St. Dominic College of Asia. Please get your Official Registration Form at St.Dominic Registrar's Office.
          </div>
          <!--row-->
        </div>
        <!--col-->
      </div>
    </div>

    <button id="printLink" class="btn btn-success"><span class="glyphicon glyphicon-share-alt"></span> USE OFFICIAL REGISTRATION FORM AND RECEPT</button>
    <button id="printLink" class="btn btn-success printLink"><span class="glyphicon glyphicon-print"></span> PRINT</button>
  </div>
  <div class="col-md-5">
    <div class="panel panel-sdca">

      <div class="row">
        <div class="col-xs-6">
          <img class="img-responsive" src="<?php echo base_url("img/DOSE_LOGO_SLIM.png"); ?>" width="220" height="250">
        </div>
        <!--col-->

        <div class="col-xs-4 col-xs-offset-2 text-left">
          <br>
          <br>


        </div>
        <!--col-->
      </div>
      <!--row-->
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-8">
            <strong>ACKNOWLEDGEMENT RECEIPT</strong>
          </div>
          <div class="col-xs-2 col-xs-offset-3">

          </div>
        </div>
        <!--row-->



      </div>

      <div class="panel-body">

        <p>Name: <?php print $client_name; ?></p>
        <p>Payment Type: <?php print $plan_name; ?></p>
        <p>Amount: <?php print $payment_cash; ?></p>
        <p>AR Number: <?php print $acknowledgement_number; ?></p>




      </div>
      <!--panel boy-->

      <div class="col-xs-11 text-right">
        Cashier Signature
      </div>
      <div class="panel panel-black"></div>


      <!-------------------------------------------------------------------REGISTRATION FORM FOOTER SECTION ------------------------------------------------------------>
      <div class="panel-footer   ">
        <div class="row">
          <div class="col-xs-8">
            <span class="glyphicon glyphicon-info-sign"></span> Thank you for choosing St. Dominic College of Asia. Please get your Official receipt at St.Dominic Accounting Office.
          </div>
          <!--row-->
        </div>
        <!--col-->

      </div>
      <!--panel footer-->
    </div>
    <!--panel panel-->

  </div>
  <!--col-->

</div>
<!-- SUBJECT CHOICE -->
<div class="modal fade" id="studentsearch_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 id="largeModalLabel">Search Student</h2>
      </div>
      <div class="modal-body">
        <br><br>
        <div class="row">
          <div class="col-md-12">
            <div id="clipboardcopy" class="alert bg-green alert-dismissible" role="alert" style="display:none">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              Copied to Clipboard
            </div>
          </div>
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-12">
                <select class="form-control show-tick" id="search_education_type">
                  <option value="college">College</option>
                  <option value="basiced">Basic Education / SHS</option>
                </select>
              </div>
              <div class="col-md-12">
                <input id="url" type="hidden" value="<?php echo base_url(); ?>index.php/StudentSearch" />
                <input id="student_searchkey" autofocus class="form-control" placeholder="Search By Student Number / Reference Number / Name..." type="text" />
              </div>
            </div>
          </div>

          <div class="col-md-3" style="padding 50% 0px 50% 0px">
            <button class="btn btn-lg btn-info" id="schedSearchSubmit" tabindex="-1" type="button" onclick="search_student()" autofocus>SEARCH</button>
          </div>

        </div>
        <hr>
        <div class="col-md-12 searchloader" style="padding: 1%; display:none">
          LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
        </div>
        <div class="table panel panel-danger" style="overflow-x:auto; max-height:250px">
          <table class="table table-bordered">
            <thead>
              <tr class="danger">
                <th>Student Number</th>
                <th>Reference Number</th>
                <th>Full Name</th>
              </tr>
            </thead>
            <tbody id="student_search_table">
              <tr>
                <td colspan="10" align="center">No Data</td>
              </tr>
            </tbody>
          </table>
        </div>
        <br>
        <div id="student_search_pagination"></div>
      </div>
    </div>
  </div>
</div>
<!-- /SUBJECT CHOICE -->

<!-- Privacy Policy -->
<div class="modal fade" id="privacy_policy_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 id="largeModalLabel">Privacy Policy</h2>
      </div>
      <div class="modal-body">

        <!-- Set Values here -->
        <input type="hidden" id="privacy_id" value="<?php echo $this->admin_data['userid']; ?>">
        <input type="hidden" id="privacy_system" value="WEBDOSE">
        <input type="hidden" id="privacy_base_url" value="<?php echo base_url(); ?>">

        <div id="PolicyContainer" style="overflow-y: scroll; max-height:300px; padding: 15px 0px 15px 0px; color:#000">
          <p>
            I <u><strong><?php echo $this->admin_data['fullname']; ?></strong></u> of legal age, hereby voluntarily and knowingly authorize St. Dominic College of Asia to collect, process or release my personal and sensitive information that may be used for internal and external school official and legal transactions.
            I agree on the following conditions:
          </p>
          <ol>
            <li>Personal Information will be released unless written notice of revocation is received by the Data Privacy Office of St. Dominic College of Asia.</li>
            <li>Personal information may be released for school official and legal purposes only.</li>
            <li>Sensitive information will be kept confidential unless the school deemed it necessary to release on valid and legal purposes only. </li>
            <li>Updating and modifying of incorrect, inaccurate or incomplete personal information will be done upon submission of letter of request to St. Dominic College of Asia.</li>
            <li>St. Dominic College of Asia and its officials and employees are not held liable for the collection and release of any information that I voluntarily provided.</li>
          </ol>
          <p>
            I have read this form, understood its contents and consent to the collecting, processing and releasing of my personal data. I understand that my consent does not preclude the existence of other criteria for lawful processing of personal data, and does not waive any of my rights under the Data Privacy Act of 2012 and other applicable laws.
          </p>
        </div>
      </div>
      <div class="modal-footer row">
        <div id="policy_options">
          <div class="col-md-12" style="text-align:left; padding: 0px 25px 0px 25px">
            <p>By Clicking '<u>Proceed</u>' You Agree to The Privacy Policy Stated Above.</p>
          </div>
          <div class="col-md-12">
            <a href="<?php echo base_url(); ?>index.php/Admin/logout" class="btn btn-link waves-effect pull-left">BACK</a>
            <button type="button" id="policy_agree" value="" class="btn btn-success pull-right" onclick="policy_agree()"></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Privacy Policy -->
<!-- Privacy Policy Script -->
<script src="<?php echo base_url(); ?>js/privacy_policy.js"></script>
<script>
  $(document).ready(function() {
    $('.printLink').on('click', function() {
      // alert('asdsad');s
      window.print();
      // $('.body_top_margin').print();
    });

  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
</body>
</html>