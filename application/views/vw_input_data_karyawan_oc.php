<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
   .modal {
        text-align: center;
    }

    .modal-dialog {
        text-align: left; /* you'll likely want this */
        max-width: 80%;
        width: auto !important;
        display: inline-block;
    }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">X</button>
    <h3>Data Karyawan Outsourcing</h3>
</div>
<div class="modal-body">
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Input Data Karyawan Outsourcing</h3> 
        </div>
        <div class="panel-body">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="body">
                        <form id="form_input_pegawai" action="#" method="POST" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="nik" name="nik" class="form-control" type="text">
                                        <label for="nik" class="form-label">NIK</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="nama_karyawan" name="nama_karyawan" class="form-control" type="text">
                                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <b>Jenis Kelamin</b><br><br>
                                    <div class="input-group">
                                        <span>
                                            <input id="lk" type="radio" class="with-gap" checked value="P" name="jk">
                                            <label for="lk" class="form-label">Laki - Laki</label>
                                        </span>
                                        <span>
                                            <input id="pr" type="radio" class="with-gap" value="W" name="jk">
                                            <label for="pr" class="form-label">Perempuan</label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="alamat_ktp" name="alamat_ktp" class="form-control" type="text">
                                        <label for="alamat_ktp" class="form-label">Alamat KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="kode_pos_ktp" name="kode_pos_ktp" class="form-control" type="text">
                                        <label for="kode_pos_ktp" class="form-label">Kode Pos KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="kelurahan_ktp" name="kelurahan_ktp" class="form-control" type="text">
                                        <label for="kelurahan_ktp" class="form-label">Kelurahan KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="kecamatan_ktp" name="kecamatan_ktp" class="form-control" type="text">
                                        <label for="kecamatan_ktp" class="form-label">Kecamatan KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="kota_ktp" name="kota_ktp" class="form-control" type="text">
                                        <label for="kota_ktp" class="form-label">Kota KTP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="provinsi_ktp" name="provinsi_ktp" class="form-control" type="text">
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
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="alamat_domisili" name="alamat_domisili" class="form-control" type="text">
                                            <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="kode_pos_domisili" name="kode_pos_domisili" class="form-control" type="text">
                                            <label for="kode_pos_domisili" class="form-label">Kode Pos Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="kelurahan_domisili" name="kelurahan_domisili" class="form-control" type="text">
                                            <label for="kelurahan_domisili" class="form-label">Kelurahan Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="kecamatan_domisili" name="kecamatan_domisili" class="form-control" type="text">
                                            <label for="kecamatan_domisili" class="form-label">Kecamatan Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="kota_domisili" name="kota_domisili" class="form-control" type="text">
                                            <label for="kota_domisili" class="form-label">Kota Domisili</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input id="provinsi_domisili" name="provinsi_domisili" class="form-control" type="text">
                                            <label for="provinsi_domisili" class="form-label">Provinsi Domisili</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="tmpt_lahir" required="required" name="tmpt_lahir" class="form-control" type="text">
                                        <label for="tmpt_lahir" class="form-label">Tempat Lahir</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="tgl_lahir" required="required" name="tgl_lahir" class="form-control datepicker" type="text">
                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="email" class="form-control email" name="email" type="email">
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="no_telp" name="no_telp" class="form-control no_telp" type="text">
                                        <label for="no_telp" class="form-label">No Telepon</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="no_hp" name="no_hp" class="form-control no_hp" type="text">
                                        <label for="no_hp" class="form-label">No Handphone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="no_hp2" name="no_hp2" class="form-control no_hp" type="text">
                                        <label for="no_hp2" class="form-label">No Handphone 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <b>Agama</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">group_work</i>
                                    </span>
                                    <select required="required" id="agama" name="agama" class="form-control selectpicker show-tick agama">
                                        <option value="">-----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <b>Status Nikah</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">supervised_user_circle</i>
                                    </span>
                                    <select required="required" id="status_nikah" name="status_nikah" class="form-control selectpicker show-tick status_nikah">
                                        <option value="">-----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="jumlah_anak" name="jumlah_anak" class="form-control" type="text">
                                        <label for="jumlah_anak" class="form-label">Jumlah Anak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <b>Pas Foto</b>
                                <div class="input-group">
                                    <div class="form-line">
                                        <input id="foto" name="foto" class="dropify" type="file">
                                    </div>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="panel-footer">
            <button class="btn bg-red waves-effect" onclick="cancel();" type="button"><i class="material-icons">undo</i><span></span></button>
            <button class="btn bg-blue waves-effect" type="reset"><i class="material-icons">clear</i><span></span></button>
            <button id="btnSave" type="button" onclick="save();" class="btn bg-orange waves-effect"><i class="material-icons">save</i><span></span></button>
            <div class="col-xs-10" id="lblstatus"></div>
        </div>
    </div>
</div>