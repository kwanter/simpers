<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Edit Riwayat Pendidikan Formal Karyawan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-edit" data-parsley-validate="" action="<?php echo base_url('pendidikan/updateData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nik">NIK / Nama Karyawan<span class="required"></span>
                        <input hidden id="id_riwayat" name="id_riwayat" value="<?php echo $attr['pendidikan']['id_riwayatpendidikan']?>">
                        <input type="hidden" value="<?php echo $attr['karyawan']['id_karyawan']?>" id="nik" name="nik" class="form-control col-md-5 col-xs-8">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input type="text" value="<?php echo $attr['karyawan']['nama_karyawan']?>" readonly="readonly" class="form-control col-md-5 col-xs-8">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jurusan">Nama Jurusan <span class="required">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input id="jurusan" value="<?php echo $attr['pendidikan']['nama_jurusan'] ?>" name="jurusan" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="peminatan">Peminatan <span class="required">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input id="peminatan" value="<?php echo $attr['pendidikan']['peminatan'] ?>" name="peminatan" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="jenjang" class="control-label col-md-3 col-sm-3 col-xs-12">Jenjang Pendidikan</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select required="required" id="jenjang" name="jenjang" class="form-control">
                            <option value="">-----</option>
                            <?php
                            foreach ($attr['jenjang'] as $jenjang){
                                if($jenjang->id_jenjangpendidikan == $attr['pendidikan']['id_jenjangpendidikan']) {
                                    ?>
                                    <option selected value="<?php echo $jenjang->id_jenjangpendidikan ?>"><?php echo $jenjang->jenjang_pendidikan ?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?php echo $jenjang->id_jenjangpendidikan ?>"><?php echo $jenjang->jenjang_pendidikan ?></option>
                                    <?php
                                }
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
                        <input type="hidden" id="level" name="level" value="<?php echo $attr['pendidikan']['level']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="asal_lp" class="control-label col-md-3 col-sm-3 col-xs-12">Asal Lembaga Pendidikan</label>
                    <div class="col-md-3 col-sm-2 col-xs-12">
                        <input id="asal_lp" value="<?php echo $attr['pendidikan']['asal_lembaga_pendidikan']?>" name="asal_lp" required="required" class="form-control col-md-4 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="asal_kota" class="control-label col-md-3 col-sm-3 col-xs-12">Asal Kota Lembaga Pendidikan</label>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <input id="asal_kota" value="<?php echo $attr['pendidikan']['asal_kota_lp'] ?>" name="asal_kota" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_lulus" class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Kelulusan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="tgl_lulus" value="<?php echo $attr['pendidikan']['tgl_kelulusan'] ?>" name="tgl_lulus" required="required" data-inputmask="'mask': '9999'" class="form-control col-md-4 col-xs-12" type="text">
                        <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nilai" class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Ijasah</label>
                    <div class="col-md-1 col-sm-4 col-xs-12">
                        <input id="nilai" value="<?php echo $attr['pendidikan']['nilai_kelulusan'] ?>" name="nilai" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="skala_nilai" class="control-label col-md-3 col-sm-3 col-xs-12">Skala Nilai</label>
                    <div class="col-md-1 col-sm-4 col-xs-12">
                        <input id="skala_nilai" value="<?php echo $attr['pendidikan']['skala_nilai'] ?>" name="skala_nilai" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-4 col-sm-4 col-xs-6 col-md-offset-3">
                        <button class="btn btn-primary" onclick="cancel();" type="button">Cancel</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>

            <script type="text/javascript">
                function cancel() {
                    window.location.replace('<?php echo site_url('master/page/pendidikan')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/pendidikan')?>')
                }
            </script>
        </div>
    </div>
</div>