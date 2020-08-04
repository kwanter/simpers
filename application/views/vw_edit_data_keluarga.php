<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Input Data Keluarga</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_keluarga" action="<?php echo base_url('keluarga/updateData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK / Nama Karyawan</label>
                                    <input hidden value="<?php echo $attr['keluarga']['id_keluarga']?>" id="id_keluarga" name="id_keluarga">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <input type="text" id="nik" name="nik" required="required" class="form-control" value="<?php echo $attr['karyawan']['nama_karyawan']?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_keluarga" class="form-label">Nama Keluarga</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">keyboard</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="nama_keluarga" name="nama_keluarga" value="<?php echo $attr['keluarga']['nama_keluarga']?>" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <b>Jenis Kelamin</b>
                                    <div class="input-group">
                                        <?php
                                        if($attr['keluarga']['jenis_kelamin'] == 'P'){
                                            ?>
                                            <span>
                                                <input id="lk" type="radio" class="with-gap" checked value="P" name="jk">
                                                <label for="lk" class="form-label">Pria</label>
                                            </span>
                                            <span>
                                                <input id="pr" type="radio" class="with-gap" value="W" name="jk">
                                                <label for="pr" class="form-label">Wanita</label>
                                            </span>
                                            <?php
                                        }else{
                                            ?>
                                            <span>
                                                <input id="lk" type="radio" class="with-gap" value="P" name="jk">
                                                <label for="lk" class="form-label">Pria</label>
                                            </span>
                                            <span>
                                                <input id="pr" type="radio" class="with-gap" checked value="W" name="jk">
                                                <label for="pr" class="form-label">Wanita</label>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hub_keluarga" class="form-label">Hubungan Keluarga</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">face</i>
                                        </span>
                                        <select id="hub_keluarga" name="hub_keluarga" required="required" class="form-control show-tick">
                                            <?php
                                            foreach ($attr['hk'] as $hk){
                                                if($hk->id_hubungankeluarga == $attr['keluarga']['id_hubungankeluarga']) {
                                                    ?>
                                                    <option selected value="<?php echo $hk->id_hubungankeluarga ?>"><?php echo $hk->desc_hubungan ?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="<?php echo $hk->id_hubungankeluarga ?>"><?php echo $hk->desc_hubungan ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tmpt_lahir" class="form-label">Tempat Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">place</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="tmpt_lahir" name="tmpt_lahir" value="<?php echo $attr['keluarga']['tmpt_lahir'] ?>" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="tgl_lahir" name="tgl_lahir" value="<?php echo $attr['keluarga']['tgl_lahir'] ?>" required="required" class="form-control datepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agama" class="form-label">Agama</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">people_outline</i>
                                        </span>
                                        <select required="required" id="agama" name="agama" class="form-control show-tick">
                                            <?php
                                            foreach ($attr['agama'] as $agama){
                                                if($agama->subID == $attr['keluarga']['agama']){
                                                    ?>
                                                    <option selected value="<?php echo $agama->subID ?>"><?php echo $agama->value ?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="<?php echo $agama->subID ?>"><?php echo $agama->value ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="suku" class="form-label">Suku</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">nature_people</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="suku" name="suku" value="<?php echo $attr['keluarga']['suku'] ?>" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">all_inclusive</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="alamat" name="alamat" value="<?php echo $attr['keluarga']['alamat'] ?>" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">all_inclusive</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="kode_pos" name="kode_pos" value="<?php echo $attr['keluarga']['kode_pos'] ?>" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kelurahan" class="form-label">Kelurahan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">all_inclusive</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="kelurahan" placeholder="Kelurahan" value="<?php echo $attr['keluarga']['kelurahan'] ?>" name="kelurahan" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">all_inclusive</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="kecamatan" placeholder="Kecamatan" name="kecamatan" value="<?php echo $attr['keluarga']['kecamatan'] ?>" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kota" class="form-label">Kota</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">all_inclusive</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="kota" name="kota" placeholder="Kota" value="<?php echo $attr['keluarga']['kota'] ?>" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">all_inclusive</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="provinsi" name="provinsi" placeholder="Provinsi" value="<?php echo $attr['keluarga']['provinsi'] ?>" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_hp" class="form-label">No Handphone</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">phone_iphone</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="no_hp" name="no_hp" value="<?php echo $attr['keluarga']['no_hp'] ?>" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">work</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="pekerjaan" name="pekerjaan" value="<?php echo $attr['keluarga']['pekerjaan'] ?>" class="form-control" type="text">
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
        window.location.replace('<?php echo site_url('master/data/keluarga')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/data/keluarga')?>')
    }

    $(document).ready(function () {
        $("#kode_pos").inputmask("99999",{ "placeholder": "" });
        $("#no_hp").inputmask("9999-9999-9999",{ "placeholder": "____-____-____" });
        $("#tgl_lahir").inputmask("9999-99-99",{ "placeholder": "1970-02-01" });
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $(function () {
        var form = $('#form_input_keluarga');
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