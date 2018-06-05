<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Edit Riwayat Jabatan Karyawan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-input" data-parsley-validate="" action="<?php echo base_url('jabatan/updateData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nik">NIK / Nama Karyawan<span class="required"></span>
                    <input type="hidden" id="id_riwayat" name="id_riwayat" value="<?php echo $attr['jabatan']->id_riwayatjabatan?>"/>
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input value="<?php echo $attr['karyawan']['nama_karyawan']?>" readonly id="nik" name="nik" required="required" class="form-control col-md-5 col-xs-8">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_surat">No Surat <span class="required">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input id="no_surat" name="no_surat" value="<?php echo $attr['jabatan']->no_surat?>" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tanggal" class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Berlaku Surat</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="tanggal" name="tanggal" value="<?php echo $attr['jabatan']->tgl_berlaku?>" required="required" data-inputmask="'mask': '9999-99-99'" class="form-control col-md-4 col-xs-12" type="text">
                        <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">Nama Jabatan <span class="required">
                    <input type="hidden" id="id_nomen" name="id_nomen" value="<?php echo $attr['jabatan']->id_nomenklatur?>" /><input type="hidden" id="tampung">
                    </label>
                    <div class="col-md-5 col-sm-4 col-xs-8">
                        <input id="jabatan" name="jabatan" value="<?php echo $attr['jabatan']->nama_jabatan?>" required="required" class="form-control col-md-5 col-xs-8" type="text">
                        <script type="text/javascript">
                            $(function() {
                                $("#jabatan").autocomplete({
                                    source: function(request, response) {
                                        $.ajax({
                                            url: "<?php echo base_url('jabatan/getJabatan')?>",
                                            type : "post",
                                            dataType: "json",
                                            data: {
                                                search: request.term
                                            },
                                            success: function(data) {
                                                response(data);
                                            }
                                        });
                                    },
                                    select: function(event, ui) {
                                        $('#jabatan').val(ui.item.label); // display the selected text
                                        $('#tampung').val(ui.item.label); // display the selected text
                                        $('#job_title').val(ui.item.job_title); // display the selected text
                                        $('#id_nomen').val(ui.item.id); // save selected id to input
                                        $('#unit_kerja').val(ui.item.uker); // save selected id to input
                                        return false;
                                    }
                                });

                                $('#jabatan').blur(function()
                                {
                                    if( !$(this).val() || $(this).val() != $('#tampung').val()) {
                                        $('#id_nomen').val('');
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="form-group">
                    <label for="job_title" class="control-label col-md-3 col-sm-3 col-xs-12">Job Title</label>
                    <div class="col-md-5 col-sm-3 col-xs-12">
                        <input id="job_title" name="job_title" value="<?php echo $attr['jabatan']->job_title?>" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="job_title" class="control-label col-md-3 col-sm-3 col-xs-12">Unit Kerja</label>
                    <div class="col-md-5 col-sm-3 col-xs-12">
                        <input id="unit_kerja" value="<?php echo $attr['jabatan']->unit_kerja?>" name="unit_kerja" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="status_karyawan" class="control-label col-md-3 col-sm-3 col-xs-12">Status Karyawan</label>
                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <select id="status_karyawan" name="status_karyawan" required="required" class="form-control col-md-5 col-xs-8">
                            <?php
                            if($attr['jabatan']->status_karyawan == 'CK'){
                                ?>
                                <option selected value="CK">Calon Karyawan</option>
                                <option value="K">Karyawan</option>
                                <option value="P">Perbantuan</option>
                                <?php
                            }elseif ($attr['jabatan']->status_karyawan == 'K'){
                                ?>
                                <option value="CK">Calon Karyawan</option>
                                <option selected value="K">Karyawan</option>
                                <option value="P">Perbantuan</option>
                                <?php
                            }else{
                                ?>
                                <option svalue="CK">Calon Karyawan</option>
                                <option value="K">Karyawan</option>
                                <option selected value="P">Perbantuan</option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="kj" class="control-label col-md-3 col-sm-3 col-xs-12">Kelas Jabatan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <select id="kj" name="kj" required="required" class="form-control col-md-4 col-xs-12">
                            <?php
                            foreach ($attr['kj'] as $kj){
                                if($kj->nama_kelasjabatan == $attr['jabatan']->kelas_jabatan) {
                                    ?>
                                    <option selected value="<?php echo $kj->nama_kelasjabatan ?>"><?php echo $kj->nama_kelasjabatan ?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?php echo $kj->nama_kelasjabatan ?>"><?php echo $kj->nama_kelasjabatan ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="periode" class="control-label col-md-3 col-sm-3 col-xs-12">Periode</label>
                    <div class="col-md-1 col-sm-4 col-xs-12">
                        <select id="periode" name="periode" required="required" class="form-control col-md-7 col-xs-12">
                            <?php
                            foreach ($attr['periode'] as $periode){
                                if($attr['jabatan']->periode == $periode->periodik) {
                                    ?>
                                    <option selected value="<?php echo $periode->periodik ?>"><?php echo $periode->periodik ?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?php echo $periode->periodik ?>"><?php echo $periode->periodik ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">Status Surat</label>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <select id="status" name="status" required="required" class="form-control col-md-7 col-xs-12">
                            <?php
                            if($attr['jabatan']->status == 'aktif'){
                                ?>
                                <option selected value="aktif">Berlaku</option>
                                <option value="non-aktif">Tidak Berlaku</option>
                                <?php
                            }else{
                                ?>
                                <option value="aktif">Berlaku</option>
                                <option selected value="non-aktif">Tidak Berlaku</option>
                                <?php
                            }
                            ?>
                        </select>
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
                    window.location.replace('<?php echo site_url('master/page/jabatan')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/jabatan')?>')
                }
            </script>
        </div>
    </div>
</div>