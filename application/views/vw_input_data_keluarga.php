<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Input Data Keluarga Karyawan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-input" data-parsley-validate="" action="<?php echo base_url('keluarga/addData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nik">NIK / Nama Karyawan <span class="required"></span>
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <select id="nik" name="nik" required="required" class="form-control col-md-5 col-xs-8">
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
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_keluarga">Nama Keluarga <span class="required">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input id="nama_keluarga" name="nama_keluarga" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hub_keluarga">Hubungan Keluarga <span class="required"></span>
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <select id="hub_keluarga" name="hub_keluarga" required="required" class="form-control col-md-5 col-xs-8">
                            <?php
                            foreach ($attr['hk'] as $hk){
                                ?>
                                <option value="<?php echo $hk->id_hubungankeluarga ?>"><?php echo $hk->desc_hubungan ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Jenis Kelamin
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
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
                    </div>
                </div>
                <div class="form-group">
                    <label for="tmpt_lahir" class="control-label col-md-3 col-sm-3 col-xs-12">Tempat & Tanggal Lahir</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="tmpt_lahir" name="tmpt_lahir" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="tgl_lahir" name="tgl_lahir" required="required" data-inputmask="'mask': '9999-99-99'" class="form-control col-md-4 col-xs-12" type="text">
                        <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="agama" class="control-label col-md-3 col-sm-3 col-xs-12">Agama</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select required="required" id="agama" name="agama" class="form-control">
                            <option value="">-----</option>
                            <?php
                            foreach ($attr['agama'] as $agama){
                                ?>
                                <option value="<?php echo $agama->subID?>"><?php echo $agama->value?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="suku" class="control-label col-md-3 col-sm-3 col-xs-12">Suku</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="suku" name="suku" required="required" class="form-control col-md-4 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat" class="control-label col-md-3 col-sm-3 col-xs-12">Alamat</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="alamat" name="alamat" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                        <input id="kode_pos" name="kode_pos" data-inputmask="'mask': '99999'" placeholder="Kode Pos" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-3 col-sm-3 col-xs-10 form-group has-feedback">
                        <input id="kelurahan" placeholder="Kelurahan" name="kelurahan" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                        <input id="kecamatan" placeholder="Kecamatan" name="kecamatan" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                        <input id="kota" name="kota" placeholder="Kota" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                        <input id="provinsi" name="provinsi" placeholder="Provinsi" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="no_hp" class="control-label col-md-3 col-sm-3 col-xs-12">No Handphone</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="no_hp" name="no_hp" required="required" data-inputmask="'mask': '9999-9999-9999'" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="pekerjaan" class="control-label col-md-3 col-sm-3 col-xs-12">Pekerjaan</label>
                    <div class="col-md-3 col-sm-2 col-xs-12">
                        <input id="pekerjaan" name="pekerjaan" required="required" class="form-control col-md-7 col-xs-12" type="text">
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
                    window.location.replace('<?php echo site_url('master/page/keluarga')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/keluarga')?>')
                }
            </script>
        </div>
    </div>
</div>