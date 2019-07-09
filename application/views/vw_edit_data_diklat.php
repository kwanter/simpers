<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Riwayat Diklat Karyawan</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_pendidikan" action="<?php echo base_url('diklat/updateData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK / Nama Karyawan</label>
                                    <input type="hidden" value="<?php echo $attr['diklat']['id_diklatkaryawan']?>" id="id_diklat" name="id_diklat">
                                    <input type="hidden" value="<?php echo $attr['diklat']['id_karyawan']?>" id="id_karyawan" name="id_karyawan">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <input readonly id="nik" name="nik" value="<?php echo $attr['karyawan']['nama_karyawan']?>" required="required" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_diklat" class="form-label">Jenis Diklat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">keyboard</i>
                                        </span>
                                        <select id="jenis_diklat" name="jenis_diklat" required="required" class="form-control">
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
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_diklat" class="form-label">Tanggal Diklat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="tgl_diklat" value="<?php echo $attr['diklat']['tgl_mulaidiklat']?> s/d <?php echo $attr['diklat']['tgl_akhirdiklat']?>" name="tgl_diklat" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tema_diklat" class="form-label">Tema Diklat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">school</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="tema_diklat" value="<?php echo $attr['diklat']['tema_diklat'] ?>" name="tema_diklat" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lokasi" class="form-label">Lokasi Diklat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">place</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="lokasi" value="<?php echo $attr['diklat']['lokasi'] ?>" name="lokasi" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="penyelenggara" class="form-label">Penyelenggara</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="penyelenggara" value="<?php echo $attr['diklat']['penyelenggara'] ?>" name="penyelenggara" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_sertifikat" class="form-label">No Sertifikat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="no_sertifikat" value="<?php echo $attr['diklat']['no_sertifikat'] ?>" name="no_sertifikat" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nilai" class="form-label">Nilai</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="nilai" value="<?php echo $attr['diklat']['nilai'] ?>" name="nilai" class="form-control" type="text">
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
                                            <input id="skala_nilai" value="<?php echo $attr['diklat']['skala_nilai'] ?>" name="skala_nilai" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sertifikat" class="form-label">Sertifikat</label>
                                    <div class="input-group">
                                        <div class="form-line">
                                            <?php
                                            $bulan = (new DateTime($attr['diklat']['tgl_akhirdiklat']))->format('M');
                                            $tahun = (new DateTime($attr['diklat']['tgl_akhirdiklat']))->format('Y');
                                            ?>
                                            <input id="sertifikat" data-show-errors="true" class="dropify form-control" data-default-file="<?php echo base_url('edok/').$attr['diklat']['id_karyawan']."/cert/".$tahun.'/'.$bulan.'/'.$attr['diklat']['sertifikat']?>" name="sertifikat" type="file">
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
        window.location.replace('<?php echo site_url('master/data/diklat')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/data/diklat')?>')
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