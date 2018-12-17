<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Input Riwayat Pendidikan Formal Karyawan</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_pendidikan" action="<?php echo base_url('pendidikan/addData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK / Nama Karyawan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <select id="nik" name="nik" required="required" class="form-control show-tick">
                                            <?php
                                            foreach ($attr['karyawan'] as $karyawan){
                                                ?>
                                                <option value="<?php echo $karyawan->id_karyawan ?>"><?php echo $karyawan->nik ?> => <?php echo $karyawan->nama_karyawan ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jurusan" class="form-label">Nama Jurusan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">keyboard</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="jurusan" name="jurusan" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="peminatan" class="form-label">Peminatan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">polymer</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="peminatan" name="peminatan" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenjang" class="form-label">Jenjang Pendidikan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">school</i>
                                        </span>
                                        <select required="required" id="jenjang" name="jenjang" class="form-control">
                                            <?php
                                            foreach ($attr['jenjang'] as $jenjang){
                                                ?>
                                                <option value="<?php echo $jenjang->id_jenjangpendidikan?>"><?php echo $jenjang->jenjang_pendidikan?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("#jenjang").change(function(){
                                                    var nilai = $("#jenjang option:selected").val();
                                                    $.ajax({
                                                        type    : "POST",
                                                        url     : "<?php echo base_url('pendidikan/getLevel')?>",
                                                        data    : { id : nilai},
                                                        success : function(data)
                                                        {
                                                            var result = data.replace(/\s/g, '');
                                                            $('#level').val(result);
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                        <input type="hidden" id="level" name="level"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="asal_lp" class="form-label">Asal Lembaga Pendidikan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">school</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="asal_lp" name="asal_lp" required class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="asal_kota" class="form-label">Asal Kota Lembaga Pendidikan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">place</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="asal_kota" name="asal_kota" required class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_lulus" class="form-label">Tahun Kelulusan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="tgl_lulus" name="tgl_lulus" required class="form-control datepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nilai" class="form-label">Nilai Ijazah / IPK</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="nilai" name="nilai" required class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="skala_nilai" class="form-label">Skala Nilai</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="skala_nilai" name="skala_nilai" required class="form-control" type="text">
                                        </div>
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
        window.location.replace('<?php echo site_url('master/data/pendidikan')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/data/pendidikan')?>')
    }

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $(function () {
        var form = $('#form_input_pendidikan');
        form.validate({
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-label').append(error);
            }
        });
    });
</script>
