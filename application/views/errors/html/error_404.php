<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
if( ! isset($CI))
{
    $CI = new CI_Controller();
}
$CI->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=Edge">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Favicon-->
      <link rel="icon" href="<?php echo base_url('assets/images/favicon.ico')?>" type="image/x-icon">
      <title>404 Not Found</title>

      <!-------------------------------------CSS PART----------------------------------->
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

      <!-- Bootstrap Core Css -->
      <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.css');?>" rel="stylesheet">

      <!-- Bootstrap Select Css -->
      <link href="<?php echo base_url('assets/plugins/bootstrap-select/css/bootstrap-select.css');?>" rel="stylesheet" />

      <!-- Waves Effect Css -->
      <link href="<?php echo base_url('assets/plugins/node-waves/waves.css');?>" rel="stylesheet" />

      <!-- Animation Css -->
      <link href="<?php echo base_url('assets/plugins/animate-css/animate.css');?>" rel="stylesheet" />

      <!-- Morris Chart Css-->
      <link href="<?php echo base_url('assets/plugins/morrisjs/morris.css');?>" rel="stylesheet" />

      <!-- JQuery DataTable Css -->
      <link href="<?php echo base_url('assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')?>" rel="stylesheet">

      <!-- Bootstrap Material Datetime Picker Css -->
      <link href="<?php echo base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')?>" rel="stylesheet" />

      <!-- Wait Me Css -->
      <link href="<?php echo base_url('assets/plugins/waitme/waitMe.css')?>" rel="stylesheet" />

      <!-- Bootstrap Tagsinput Css -->
      <link href="<?php echo base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet">

      <!-- Dropify Css -->
      <link href="<?php echo base_url('assets/plugins/dropify/dropify.css')?>" rel="stylesheet">

      <!-- Bootstrap Spinner Css -->
      <link href="<?php echo base_url('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')?>" rel="stylesheet">

      <!-- Bootstrap Select Css -->
      <link href="<?php echo base_url('assets/plugins/bootstrap-select/css/bootstrap-select.css')?>" rel="stylesheet" />

      <!-- noUISlider Css -->
      <link href="<?php echo base_url('assets/plugins/nouislider/nouislider.min.css')?>" rel="stylesheet" />

      <!-- Sweet Alert Css -->
      <link href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css')?>" rel="stylesheet" />

      <!-- Jquery UI Css -->
      <link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css')?>" rel="stylesheet" />

      <!-- Daterangepicker Css -->
      <link href="<?php echo base_url('assets/css/daterangepicker.css')?>" rel="stylesheet" />

      <!---Materialize CSS--->
      <link href="<?php echo base_url('assets/css/materialize.css') ?>" rel="stylesheet">

      <!-- Custom Css -->
      <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">

      <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
      <link href="<?php echo base_url('assets/css/themes/all-themes.css');?>" rel="stylesheet" />

      <style>
          a {
              text-decoration:none;
          }
          a:hover {
              text-decoration:none;
          }
          a:active{
              text-decoration:none;
          }
      </style>

      <!-----------------------------Javascript Part-------------------------------------->
      <!-- Jquery Core Js -->
      <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js');?>"></script>

      <!-- Bootstrap Core Js -->
      <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.js');?>"></script>

      <!-- Select Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/bootstrap-select/js/bootstrap-select.js');?>"></script>

      <!-- Slimscroll Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.js');?>"></script>

      <!-- Waves Effect Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/node-waves/waves.js');?>"></script>

      <!-- Jquery CountTo Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/jquery-countto/jquery.countTo.js');?>"></script>

      <!-- Morris Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/raphael/raphael.min.js');?>"></script>
      <script src="<?php echo base_url('assets/plugins/morrisjs/morris.js');?>"></script>

      <!-- ChartJs -->
      <script src="<?php echo base_url('assets/plugins/chartjs/Chart.bundle.js');?>"></script>

      <!-- Flot Charts Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/flot-charts/jquery.flot.js');?>"></script>
      <script src="<?php echo base_url('assets/plugins/flot-charts/jquery.flot.resize.js');?>"></script>
      <script src="<?php echo base_url('assets/plugins/flot-charts/jquery.flot.pie.js');?>"></script>
      <script src="<?php echo base_url('assets/plugins/flot-charts/jquery.flot.categories.js');?>"></script>
      <script src="<?php echo base_url('assets/plugins/flot-charts/jquery.flot.time.js');?>"></script>

      <!-- Sparkline Chart Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/jquery-sparkline/jquery.sparkline.js');?>"></script>

      <!-- Jquery DataTable Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/jquery.dataTables.js')?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/jszip.min.js')?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js')?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js')?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')?>"></script>
      <script src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js')?>"></script>

      <!-- Input Mask Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js')?>"></script>

      <!-- Dropify Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/dropify/dropify.js')?>"></script>

      <!-- Multi Select Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/multi-select/js/jquery.multi-select.js')?>"></script>

      <!-- Jquery Spinner Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/jquery-spinner/js/jquery.spinner.js')?>"></script>

      <!-- Bootstrap Tags Input Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')?>"></script>

      <!-- noUISlider Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/nouislider/nouislider.js')?>"></script>

      <!-- Autosize Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/autosize/autosize.js')?>"></script>

      <!-- Moment Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/momentjs/moment.js')?>"></script>

      <!-- Jquery Validation Plugin Css -->
      <script src="<?php echo base_url('assets/plugins/jquery-validation/jquery.validate.js')?>"></script>

      <!-- JQuery Steps Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/jquery-steps/jquery.steps.js')?>"></script>

      <!-- Sweet Alert Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js')?>"></script>

      <!-- Bootstrap Material Datetime Picker Plugin Js -->
      <script src="<?php echo base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')?>"></script>

      <!---Jquery Autocomplete---->
      <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery.autocomplete.min.js')?>"></script>

      <!---Jquery UI---->
      <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js')?>"></script>

      <!---Daterangepicker---->
      <script src="<?php echo base_url('assets/js/daterangepicker.js')?>"></script>

      <!-- Custom Js -->
      <script src="<?php echo base_url('assets/js/admin.js');?>"></script>
  </head>

  <body>
      <div class="four-zero-four">
          <div class="four-zero-four-container">
              <div class="error-code">404</div>
              <div class="error-message">This page doesn't exist</div>
              <div class="button-place">
                  <a href="<?php echo base_url();?>" class="btn btn-default btn-lg waves-effect">GO TO HOMEPAGE</a>
              </div>
          </div>
      </div>
  </body>
</html>
