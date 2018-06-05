<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Input Riwayat Jabatan Karyawan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-input" data-parsley-validate="" action="<?php echo base_url('jabatan/addData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nik">NIK / Nama Karyawan<span class="required"></span>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_surat">No Surat <span class="required">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input id="no_surat" name="no_surat" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tanggal" class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Berlaku Surat</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="tanggal" name="tanggal" required="required" data-inputmask="'mask': '9999-99-99'" class="form-control col-md-4 col-xs-12" type="text">
                        <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">Nama Jabatan <span class="required">
                    <input type="hidden" id="id_nomen" name="id_nomen" value="" /><input type="hidden" id="tampung">
                    </label>
                    <div class="col-md-5 col-sm-4 col-xs-8">
                        <input id="jabatan" name="jabatan" required="required" class="form-control col-md-5 col-xs-8" type="text">
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
                        <input id="job_title" name="job_title" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="job_title" class="control-label col-md-3 col-sm-3 col-xs-12">Unit Kerja</label>
                    <div class="col-md-5 col-sm-3 col-xs-12">
                        <input id="unit_kerja" name="unit_kerja" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="status_karyawan" class="control-label col-md-3 col-sm-3 col-xs-12">Status Karyawan</label>
                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <select id="status_karyawan" name="status_karyawan" required="required" class="form-control col-md-5 col-xs-8">
                            <option value="CK">Calon Karyawan</option>
                            <option value="K">Karyawan</option>
                            <option value="P">Perbantuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="kj" class="control-label col-md-3 col-sm-3 col-xs-12">Kelas Jabatan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <select id="kj" name="kj" required="required" class="form-control col-md-4 col-xs-12">
                            <?php
                            foreach ($attr['kj'] as $kj){
                                ?>
                                <option value="<?php echo $kj->nama_kelasjabatan?>"><?php echo $kj->nama_kelasjabatan?></option>
                                <?php
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
                                ?>
                                <option value="<?php echo $periode->periodik?>"><?php echo $periode->periodik?></option>
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