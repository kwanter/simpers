<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- footer content -->
<footer>
    <div class="pull-right">
        Copyright &copy; Sub Divisi SI - PT KALTIM KARIANGAU TERMINAL - <?php echo date('Y');?>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->

<script type="text/javascript">
    $('#tgl_lahir').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#tgl_lulus').datetimepicker({
        format: 'YYYY'
    });
    $('#tanggal').datetimepicker({
        format: 'YYYY-MM-DD'
    });
</script>
<!-- Custom Theme Scripts -->
<script src="<?php echo base_url('assets/js/custom.js')?>"></script>

      </div>
    </div>
  </body>
</html>
