<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Data Tunjangan</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_tunjangan" action="<?php echo base_url('tunjangan/updateData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <b>ID Tunjangan</b>
                                        <input id="id_tunjangan" name="id_tunjangan" required class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <b>Nama Tunjangan</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">keyboard</i>
                                    </span>
                                    <div class="form-line">
                                        <input id="nama_tunjangan" required name="nama_tunjangan" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <b>Kelas Jabatan</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">work</i>
                                    </span>
                                    <select id="kelas_jabatan" name="kelas_jabatan" required class="form-control">
                                        <?php
                                        foreach ($attr['kj'] as $kj){
                                            ?>
                                            <option value="<?php echo $kj->kelas_jabatan ?>"><?php echo $kj->kelas_jabatan ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <b>Besaran Tunjangan</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">attach_money</i>
                                    </span>
                                    <div class="form-line">
                                        <input id="besaran_tunjangan" name="besaran_tunjangan" class="form-control" type="number">
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
    function cancel() {
        window.location.replace('<?php echo site_url('master/page/tunjangan')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/page/tunjangan')?>')
    }

    $(document).ready(function () {
        $("#id_tunjangan").inputmask("TJAAA-KJ99",{ "placeholder": "" });
    });

    var form = $('#form_input_pegawai');
    form.validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
            $(element).parents('.input-group').append(error);
        }
    });
</script>