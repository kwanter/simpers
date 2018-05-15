<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Edit Data Pegawai</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-edit" data-parsley-validate="" action="<?php echo base_url('pegawai/updateData')?>" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nik">NIK / NIPP
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input hidden type="text" name="id_karyawan" id="id_karyawan" value="<?php echo $attr['pegawai']['id_karyawan']?>">
                        <input id="nik" name="nik" data-inputmask="'mask': 'KKT9999999'" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $attr['pegawai']['nik']?>" >
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="nipp" name="nipp" data-inputmask="'mask': '999999999'" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $attr['pegawai']['nipp']?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_karyawan">Nama Karyawan <span class="required"></span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="nama_karyawan" value="<?php echo $attr['pegawai']['nama_karyawan']?>" name="nama_karyawan" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Jenis Kelamin
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php
                        if($attr['pegawai']['jenis_kelamin'] == 'P'){
                        ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="flat" checked value="P" name="jk"> Laki - Laki
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="flat" value="W" name="jk"> Perempuan
                                </label>
                            </div>
                        <?php
                        }else{
                        ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="flat" value="P" name="jk"> Laki - Laki
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="flat" checked value="W" name="jk"> Perempuan
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <!-----------------form untuk alamat---------------------->
                <div class="form-group">
                    <label for="alamat_ktp" class="control-label col-md-3 col-sm-3 col-xs-12">Alamat KTP</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="alamat_ktp" value="<?php echo $attr['pegawai']['alamat_ktp']?>" name="alamat_ktp" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                        <input id="kode_pos_ktp" value="<?php echo $attr['pegawai']['kode_pos_ktp']?>" name="kode_pos_ktp" data-inputmask="'mask': '99999'" placeholder="Kode Pos" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-3 col-sm-3 col-xs-10 form-group has-feedback">
                        <input id="kelurahan_ktp" value="<?php echo $attr['pegawai']['kelurahan_ktp']?>" placeholder="Kelurahan KTP" name="kelurahan_ktp" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                        <input id="kecamatan_ktp" value="<?php echo $attr['pegawai']['kecamatan_ktp']?>" placeholder="Kecamatan KTP" name="kecamatan_ktp" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                        <input id="kota_ktp" value="<?php echo $attr['pegawai']['kota_ktp']?>" name="kota_ktp" placeholder="Kota KTP" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                        <input id="provinsi_ktp" value="<?php echo $attr['pegawai']['provinsi_ktp']?>" name="provinsi_ktp" placeholder="Provinsi KTP" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <!----------------------------------->
                <div class="form-group">
                    <label for="pilihan_alamat" class="control-label col-md-3 col-sm-4 col-xs-12">Alamat Domisili <br>Sama Dengan Alamat KTP</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input type="checkbox" class="form-check-input" id="pilihan_domisili" name="pilihan_domisili" value="0">
                    </div>
                </div>
                <!-----------------form untuk alamat domisili---------------------->
                <div id="domisili">
                    <div class="form-group">
                        <label for="alamat_domisili" class="control-label col-md-3 col-sm-3 col-xs-12">Alamat Domisili</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input id="alamat_domisili" value="<?php echo $attr['pegawai']['alamat_domisili']?>" name="alamat_domisili" required="required" class="form-control col-md-7 col-xs-12" type="text">
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                            <input id="kode_pos_domisili" value="<?php echo $attr['pegawai']['kode_pos_domisili']?>" name="kode_pos_domisili" data-inputmask="'mask': '99999'" placeholder="Kode Pos KTP" required="required" class="form-control col-md-7 col-xs-12" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-3 col-sm-3 col-xs-10 form-group has-feedback">
                            <input id="kelurahan_domisili" value="<?php echo $attr['pegawai']['kelurahan_domisili']?>" placeholder="Kelurahan Domisili" name="kelurahan_domisili" required="required" class="form-control col-md-7 col-xs-12" type="text">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                            <input id="kecamatan_domisili" value="<?php echo $attr['pegawai']['kecamatan_domisili']?>" placeholder="Kecamatan Domisili" name="kecamatan_domisili" required="required" class="form-control col-md-7 col-xs-12" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                            <input id="kota_domisili" value="<?php echo $attr['pegawai']['kota_domisili']?>" name="kota_domisili" placeholder="Kota Domisili" required="required" class="form-control col-md-7 col-xs-12" type="text">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                            <input id="provinsi_domisili" value="<?php echo $attr['pegawai']['provinsi_domisili']?>" name="provinsi_domisili" placeholder="Provinsi Domisili" required="required" class="form-control col-md-7 col-xs-12" type="text">
                        </div>
                    </div>
                </div>
                <!----------------------------------->
                <div class="form-group">
                    <label for="tmpt_lahir" class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Lahir</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="tmpt_lahir" name="tmpt_lahir" value="<?php echo $attr['pegawai']['tmpt_lahir']?>" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir" class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Lahir</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="tgl_lahir" value="<?php echo $attr['pegawai']['tgl_lahir']?>" name="tgl_lahir" required="required" data-inputmask="'mask': '9999-99-99'" class="form-control col-md-4 col-xs-12" type="text">
                        <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="no_telp" class="control-label col-md-3 col-sm-3 col-xs-12">No Telepon & No Handphone</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="no_telp" value="<?php echo $attr['pegawai']['no_telp']?>" name="no_telp" required="required" data-inputmask="'mask': '9999-9999999'" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="no_hp" value="<?php echo $attr['pegawai']['no_hp']?>" name="no_hp" required="required" data-inputmask="'mask': '9999-9999-9999'" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="no_hp_2" value="<?php echo $attr['pegawai']['no_hp_2']?>" name="no_hp_2" data-inputmask="'mask': '9999-9999-9999'" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="email" value="<?php echo $attr['pegawai']['email']?>" required="required" class="form-control col-md-7 col-xs-12" name="email" type="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="agama" class="control-label col-md-3 col-sm-3 col-xs-12">Agama</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <select required="required" id="agama" name="agama" class="form-control">
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
                <div class="form-group">
                    <label for="suku" class="control-label col-md-3 col-sm-3 col-xs-12">Suku</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="suku" value="<?php echo $attr['pegawai']['suku']?>" required="required" class="form-control col-md-7 col-xs-12" name="suku" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="status_nikah" class="control-label col-md-3 col-sm-3 col-xs-12">Status Nikah</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <select required="required" id="status_nikah" name="status_nikah" class="form-control">
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
                <div class="form-group">
                    <label for="foto" class="control-label col-md-3 col-sm-3 col-xs-12">Pas Foto</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <input id="foto" class="dropify form-control col-md-7 col-xs-12" data-show-errors="true" data-default-file="<?php echo base_url('pictures/').$attr['pegawai']['foto']?>" name="foto" type="file">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" onclick="cancel();" type="button">Cancel</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>

            <script type="text/javascript">
                function cancel() {
                    window.location.replace('<?php echo site_url('master/page/pegawai')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/pegawai')?>')
                }

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
                });

                $(document).ready(function(){
                    $('.dropify').dropify({
                        messages: {
                            default : 'Drag atau drop untuk memilih gambar',
                            replace : 'Ganti',
                            remove  : 'Hapus',
                            error   : 'error'
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>