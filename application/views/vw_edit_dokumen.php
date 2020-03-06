<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Data Dokumen Karyawan</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_dok" action="<?php echo base_url('dokumen/updateData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK / Nama Karyawan</label>
                                    <input type="hidden" id="id_kartu_karyawan" name="id_kartu_karyawan" value="<?php echo $attr['dok']->id_kartu_karyawan?>"/>
                                    <input hidden type="text" name="id_karyawan" id="id_karyawan" value="<?php echo $attr['dok']->id_karyawan?>">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <input value="<?php echo $attr['karyawan']['nama_karyawan']?>" readonly id="nik" name="nik" required="required" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kj" class="form-label">Jenis Dokumen</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <select id="jenis_dok" name="jenis_dok" required="required" class="form-control">
                                            <?php
                                            foreach ($attr['jenis_dok'] as $dok){
                                                if($dok->jenis_dok == $attr['dok']->kartu_singkat) {
                                                    ?>
                                                    <option selected value="<?php echo $dok->jenis_kartu ?>"><?php echo $dok->deskripsi_kartu ?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="<?php echo $dok->jenis_kartu ?>"><?php echo $dok->deskripsi_kartu ?></option>
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
                                    <label for="no_surat" class="form-label">No Dokumen</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">keyboard</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="no_dok" value="<?php echo $attr['dok']->kartu_no?>" name="no_dok" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal" class="form-label">Masa Berakhir Dokumen</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="tanggal" value="<?php echo $attr['dok']->kartu_tgl_akhir?>" name="tanggal" class="form-control datepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <b>File Dokumen</b>
                                <div class="input-group">
                                    <div class="form-line">
                                        <?php
                                            $bulan = (new DateTime($attr['dok']->kartu_tgl_akhir))->format('M');
                                            $tahun = (new DateTime($attr['dok']->kartu_tgl_akhir))->format('Y');
                                        ?>
                                        <input id="dokumen" name="dokumen" class="dropify" type="file" data-show-errors="true" data-default-file="<?php echo base_url('edok/').$attr['dok']->id_karyawan."/dok/".$tahun.'/'.$bulan.'/'.$attr['dok']->file?>">
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
    $(document).ready(function () {
        $('.dropify').dropify({
            messages: {
                default : 'Drag atau drop untuk memilih gambar',
                replace : 'Ganti',
                remove  : 'Hapus',
                error   : 'error'
            }
        });
        $('#jenis_dok').trigger('change');
    });

    function cancel() {
        window.location.replace('<?php echo site_url('master/data/dokumen')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/data/dokumen')?>')
    }

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });
</script>