<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Input Master Data Hari Libur</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_pendidikan" action="<?php echo base_url('cuti/addDataLibur')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="form-label">Tanggal Libur Awal</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">calendar_today</i>
                                        </span>
                                        <input type="text" class="form-control" name="tgl_libur_awal" id="tgl_libur_awal">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="form-label">Tanggal Libur Akhir</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">calendar_today</i>
                                        </span>
                                        <input type="text" class="form-control" name="tgl_libur_akhir" id="tgl_libur_akhir">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="form-label">Deskripsi Hari Libur</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">assignment</i>
                                        </span>
                                        <input type="text" class="form-control" name="deskripsi_libur" id="deskripsi_libur">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button class="btn bg-red waves-effect" onclick="cancel();" type="button"><i class="material-icons">undo</i><span>Cancel</span></button>
                            <button class="btn bg-blue waves-effect" type="reset"><i class="material-icons">clear</i><span>Reset</span></button>
                            <button type="submit" class="btn bg-orange waves-effect"><i class="material-icons">save</i><span>Simpan</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tgl_libur_awal').bootstrapMaterialDatePicker().on('change', function(e, date){
            $('#tgl_libur_akhir').val("");
            $('#tgl_libur_akhir').bootstrapMaterialDatePicker('setDate', date);
        });
    });

    function cancel() {
        window.location.replace('<?php echo site_url('master/page/libur')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/page/libur')?>')
    }

    $('#tgl_libur_awal').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $('#tgl_libur_akhir').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });
</script>
