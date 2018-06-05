<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Edit Riwayat Diklat Karyawan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-input" data-parsley-validate="" action="<?php echo base_url('diklat/updateData')?>" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nik">NIK / Nama Karyawan<span class="required"></span>
                    <input type="hidden" value="<?php echo $attr['diklat']['id_diklatkaryawan']?>" id="id_diklat" name="id_diklat">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input readonly id="nik" name="nik" value="<?php echo $attr['karyawan']['nama_karyawan']?>" required="required" class="form-control col-md-5 col-xs-8"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_diklat">Jenis Diklat <span class="required">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <select id="jenis_diklat" name="jenis_diklat" required="required" class="form-control col-md-5 col-xs-8">
                            <option value="">---</option>
                            <?php
                            foreach ($attr['jenis_diklat'] as $jenis_diklat){
                                if($jenis_diklat->id_jenisdiklat == $attr['diklat']['jenis_diklat']) {
                                    ?>
                                    <option selected
                                            value="<?php echo $jenis_diklat->id_jenisdiklat ?>"><?php echo $jenis_diklat->jenis_diklat ?></option>
                                    <?php
                                }
                                else {
                                    ?>
                                    <option value="<?php echo $jenis_diklat->id_jenisdiklat ?>"><?php echo $jenis_diklat->jenis_diklat ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_diklat">Tanggal Diklat <span class="required">
                    </label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input id="tgl_diklat" name="tgl_diklat" value="<?php echo $attr['diklat']['tgl_mulaidiklat']?> s/d <?php echo $attr['diklat']['tgl_akhirdiklat']?>" required="required" class="form-control col-md-5 col-xs-8" type="text">
                        <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tema_diklat" class="control-label col-md-3 col-sm-3 col-xs-12">Tema Diklat</label>
                    <div class="col-md-4 col-sm-2 col-xs-12">
                        <input id="tema_diklat" name="tema_diklat" value="<?php echo $attr['diklat']['tema_diklat'] ?>" required="required" class="form-control col-md-4 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lokasi" class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="lokasi" name="lokasi" value="<?php echo $attr['diklat']['lokasi'] ?>" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="penyelenggara" class="control-label col-md-3 col-sm-3 col-xs-12">Penyelenggara</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="penyelenggara" name="penyelenggara" value="<?php echo $attr['diklat']['penyelenggara'] ?>" required="required" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_lulus" class="control-label col-md-3 col-sm-3 col-xs-12">No Sertifikat</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input id="no_sertifikat" name="no_sertifikat" value="<?php echo $attr['diklat']['no_sertifikat'] ?>" required="required" class="form-control col-md-4 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nilai" class="control-label col-md-3 col-sm-3 col-xs-12">Nilai</label>
                    <div class="col-md-1 col-sm-4 col-xs-12">
                        <input id="nilai" name="nilai" value="<?php echo $attr['diklat']['nilai'] ?>" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="skala_nilai" class="control-label col-md-3 col-sm-3 col-xs-12">Skala Nilai</label>
                    <div class="col-md-1 col-sm-4 col-xs-12">
                        <input id="skala_nilai" name="skala_nilai" value="<?php echo $attr['diklat']['skala_nilai'] ?>" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="sertifikat" class="control-label col-md-3 col-sm-3 col-xs-12">Sertifikat</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <input id="sertifikat" data-show-errors="true" class="dropify form-control col-md-7 col-xs-12" data-default-file="<?php echo base_url('sertifikat/').$attr['diklat']['sertifikat']?>" name="sertifikat" type="file">
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
                    window.location.replace('<?php echo site_url('master/page/diklat')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/diklat')?>')
                }

                $(document).ready(function(){
                    $('.dropify').dropify({
                        messages: {
                            default : 'Drag atau drop untuk memilih sertifikat',
                            replace : 'Ganti',
                            remove  : 'Hapus',
                            error   : 'error'
                        }
                    });
                });

                $('#tgl_diklat').daterangepicker({
                    "showDropdowns": true,
                    "locale": {
                        "format": "YYYY-MM-DD",
                        "separator": " s/d ",
                        "applyLabel": "Ok",
                        "cancelLabel": "Batal",
                        "fromLabel": "Dari",
                        "toLabel": "Ke",
                        "customRangeLabel": "Custom",
                        "weekLabel": "W",
                        "daysOfWeek": [
                            "Min",
                            "Sen",
                            "Sel",
                            "Rab",
                            "Kam",
                            "Jum",
                            "Sab"
                        ],
                        "monthNames": [
                            "Januari",
                            "Februari",
                            "Maret",
                            "April",
                            "Mei",
                            "Juni",
                            "Juli",
                            "Agustus",
                            "September",
                            "Oktober",
                            "November",
                            "Desember"
                        ],
                        "firstDay": 1
                    }
                },function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            </script>
        </div>
    </div>
</div>