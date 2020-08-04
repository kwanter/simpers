<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Data Pegawai</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_pegawai" action="<?php echo base_url('pegawai/updateData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="nik" name="nik" class="form-control" type="text" value="<?php echo $attr['pegawai']['nik']?>">
                                        <input hidden type="text" name="id_karyawan" id="id_karyawan" value="<?php echo $attr['pegawai']['id_karyawan']?>">
                                        <label for="nik" class="form-label">NIK</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="nipp" name="nipp" class="form-control" type="text" value="<?php echo $attr['pegawai']['nipp']?>">
                                        <label for="nipp" class="form-label">NIPP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="nama_karyawan" name="nama_karyawan" required class="form-control" type="text" value="<?php echo $attr['pegawai']['nama_karyawan']?>">
                                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <b>Jenis Kelamin</b><br><br>
                                    <div class="input-group">
                                        <?php
                                        if($attr['pegawai']['jenis_kelamin'] == 'P'){
                                            ?>
                                            <span>
                                                <input id="lk" type="radio" class="with-gap" checked value="P" name="jk">
                                                <label for="lk" class="form-label">Laki - Laki</label>
                                            </span>
                                            <span>
                                                <input id="pr" type="radio" class="with-gap" value="W" name="jk">
                                                <label for="pr" class="form-label">Perempuan</label>
                                            </span>
                                            <?php
                                        }else{
                                            ?>
                                            <span>
                                                <input id="lk" type="radio" class="with-gap" checked value="P" name="jk">
                                                <label for="lk" class="form-label">Laki - Laki</label>
                                            </span>
                                            <span>
                                                <input id="pr" type="radio" class="with-gap" value="W" name="jk">
                                                <label for="pr" class="form-label">Perempuan</label>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="alamat_ktp" name="alamat_ktp" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['alamat_ktp']?>">
                                        <label for="alamat_ktp" class="form-label">Alamat KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="kode_pos_ktp" name="kode_pos_ktp" class="form-control" type="text" value="<?php echo $attr['pegawai']['kode_pos_ktp']?>">
                                        <label for="kode_pos_ktp" class="form-label">Kode Pos KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="kelurahan_ktp" name="kelurahan_ktp" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['kelurahan_ktp']?>">
                                        <label for="kelurahan_ktp" class="form-label">Kelurahan KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="kecamatan_ktp" name="kecamatan_ktp" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['kecamatan_ktp']?>">
                                        <label for="kecamatan_ktp" class="form-label">Kecamatan KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="kota_ktp" name="kota_ktp" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['kecamatan_ktp']?>">
                                        <label for="kota_ktp" class="form-label">Kota KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="provinsi_ktp" name="provinsi_ktp" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['provinsi_ktp']?>">
                                        <label for="provinsi_ktp" class="form-label">Provinsi KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span>
                                        <input type="checkbox" class="filled-in" id="pilihan_domisili" name="pilihan_domisili" value="0">
                                        <label class="form-label" for="pilihan_domisili">Alamat Domisili Sama Dengan Alamat KTP</label>
                                    </span>
                                </div>
                            </div>
                            <div id="domisili">
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="alamat_domisili" name="alamat_domisili" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['alamat_domisili']?>">
                                            <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="kode_pos_domisili" name="kode_pos_domisili" class="form-control" type="text" value="<?php echo $attr['pegawai']['kode_pos_domisili']?>">
                                            <label for="kode_pos_domisili" class="form-label">Kode Pos Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="kelurahan_domisili" name="kelurahan_domisili" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['kelurahan_domisili']?>">
                                            <label for="kelurahan_domisili" class="form-label">Kelurahan Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="kecamatan_domisili" name="kecamatan_domisili" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['kecamatan_domisili']?>">
                                            <label for="kecamatan_domisili" class="form-label">Kecamatan Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="kota_domisili" name="kota_domisili" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['kota_domisili']?>">
                                            <label for="kota_domisili" class="form-label">Kota Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="provinsi_domisili" name="provinsi_domisili" required="required" class="form-control" type="text" value="<?php echo $attr['pegawai']['provinsi_domisili']?>">
                                            <label for="provinsi_domisili" class="form-label">Provinsi Domisili</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="tmpt_lahir" name="tmpt_lahir" class="form-control" type="text" value="<?php echo $attr['pegawai']['tmpt_lahir']?>">
                                        <label for="tmpt_lahir" class="form-label">Tempat Lahir</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="tgl_lahir" name="tgl_lahir" class="form-control datepicker" type="text" value="<?php echo $attr['pegawai']['tgl_lahir']?>">
                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="suku" name="suku" value="<?php echo $attr['pegawai']['suku']?>">
                                        <label for="suku" class="form-label">Suku</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="no_telp" name="no_telp" class="form-control no_telp" type="text" value="<?php echo $attr['pegawai']['no_telp']?>">
                                        <label for="no_telp" class="form-label">No Telepon</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="no_hp" name="no_hp" class="form-control no_hp" type="text" value="<?php echo $attr['pegawai']['no_hp']?>">
                                        <label for="no_hp" class="form-label">No Handphone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="no_hp2" name="no_hp2" class="form-control no_hp" type="text" value="<?php echo $attr['pegawai']['no_hp_2']?>">
                                        <label for="no_hp2" class="form-label">No Handphone 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="email" class="form-control email" name="email" type="email" value="<?php echo $attr['pegawai']['email']?>">
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b>Agama</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">group_work</i>
                                    </span>
                                    <select required="required" id="agama" name="agama" class="form-control show-tick">
                                        <option value="">-----</option>
                                        <?php
                                        foreach ($attr['agama'] as $agama){
                                            if($agama->subID == $attr['pegawai']['agama']){
                                                ?>
                                                <option selected value="<?php echo $agama->subID?>"><?php echo $agama->value?></option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="<?php echo $agama->subID?>"><?php echo $agama->value?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b>Status Nikah</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">supervised_user_circle</i>
                                    </span>
                                    <select required="required" id="status_nikah" name="status_nikah" class="form-control show-tick">
                                        <option value="">-----</option>
                                        <?php
                                        foreach ($attr['status_nikah'] as $status){
                                            if($status->subID == $attr['pegawai']['status_nikah']){
                                                ?>
                                                <option selected value="<?php echo $status->subID?>"><?php echo $status->value?></option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="<?php echo $status->subID?>"><?php echo $status->value?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <b>Pas Foto</b>
                                <div class="input-group">
                                    <div class="form-line">
                                        <?php
                                            $bulan = (new DateTime($attr['pegawai']['last_upload']))->format('M');
                                            $tahun = (new DateTime($attr['pegawai']['last_upload']))->format('Y');
                                        ?>
                                        <input id="foto" name="foto" class="dropify" type="file" data-show-errors="true" data-default-file="<?php echo base_url('edok/').$attr['pegawai']['id_karyawan'].'/foto/'.$tahun.'/'.$bulan.'/'.$attr['pegawai']['foto']?>">
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
        window.location.replace('<?php echo site_url('master/page/pegawai')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/page/pegawai')?>')
    }

    $(document).ready(function () {
        $("#nik").inputmask("KKT9999999",{ "placeholder": "" });
        $("#nipp").inputmask("9999999",{ "placeholder": "" });
        $("#kode_pos_ktp").inputmask("99999",{ "placeholder": "" });
        $("#kode_pos_domisili").inputmask("99999",{ "placeholder": "" });
        $("#tgl_lahir").inputmask("9999-99-99",{ "placeholder": "1970-02-01" });

        $('.dropify').dropify({
            messages: {
                default : 'Drag atau drop untuk memilih gambar',
                replace : 'Ganti',
                remove  : 'Hapus',
                error   : 'error'
            }
        });
    });

    $(function(){
        $('#pilihan_domisili').click(function() {
            if($(this).is(':checked')){
                $('#domisili').attr("class","hidden");
                $('#pilihan_domisili').val('1');
                $('#alamat_domisili').removeAttr("required");
                $('#kode_pos_domisili').removeAttr("required");
                $('#kelurahan_domisili').removeAttr("required");
                $('#kecamatan_domisili').removeAttr("required");
                $('#kota_domisili').removeAttr("required");
                $('#provinsi_domisili').removeAttr("required");
            }
            else{
                $('#domisili').attr("class","");
                $('#pilihan_domisili').val('');
                $('#alamat_domisili').attr("required","required");
                $('#kode_pos_domisili').attr("required","required");
                $('#kelurahan_domisili').attr("required","required");
                $('#kecamatan_domisili').attr("required","required");
                $('#kota_domisili').attr("required","required");
                $('#provinsi_domisili').attr("required","required");
            }
        });
        var form = $('#form_input_tunjangan');
        form.find('.no_telp').inputmask('9999-9999999', { placeholder: '____-_______' });
        form.find('.no_hp').inputmask('9999-9999-9999', { placeholder: '____-____-____' });
        form.find('.email').inputmask({alias :"email"});

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
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });
</script>