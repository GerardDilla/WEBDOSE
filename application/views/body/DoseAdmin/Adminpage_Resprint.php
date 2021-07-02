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

  <!-- <script src="<?php echo base_url(); ?>js/script.js"></script> -->
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

<body class="body_top_margin">
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
          <div class="col-xs-6">
            <strong>ACKNOWLEDGEMENT RECEIPT</strong>
          </div>
          <div class="col-xs-2 col-xs-offset-3">
          </div>
        </div>
        <!--row-->
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-xs-12">
            <table>
              <?php 
              // echo 'asdsadsa';
              print ucwords($print_page); ?>
              <tr>
                <td>AR Number:</td>
                <td><?php print $acknowledgement_number; ?></td>
              </tr>
            </table>
          </div>
          <!--col-->
        </div>
        <!--row-->
      </div>
      <!--panel boy-->
      <div class="col-xs-11 text-right">
        Cashier Signature
      </div>
      <div class="panel panel-black"></div>
      <!-------------------------------------------------------------------REGISTRATION FORM TUITION FEE SECTION ------------------------------------------------------------>
      <!-------------------------------------------------------------------REGISTRATION FORM FOOTER SECTION ------------------------------------------------------------>
      <div class="panel-footer">
        <div class="row">
          <div class="col-xs-12">
            <span class="glyphicon glyphicon-info-sign"></span> Thank you for choosing St. Dominic College of Asia. Please get your official receipt at St. Dominic accounting office. This reservation is only valid for 5 working days.
          </div>
          <!--row-->
        </div>
        <!--col-->
      </div>
      <!--panel footer-->
    </div>
    <!--panel panel-->
    <button id="printLink" class="btn btn-success">PRINT</button>
  </div>
</body>
<script src="<?php echo base_url(); ?>js/privacy_policy.js"></script>
<script>
  $(document).ready(function() {
    $('#printLink').on('click', function() {
      // alert('asdsad');s
      window.print();
      // $('.body_top_margin').print();
    });

  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

</html>