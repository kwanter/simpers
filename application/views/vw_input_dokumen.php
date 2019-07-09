<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Input Data Dokumen Karyawan</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_dokumen" action="<?php echo base_url('dokumen/addData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK / Nama Karyawan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <select id="nik" name="nik" required="required" class="form-control show-tick">
                                            <option>----Pilih Karyawan----</option>
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
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keluarga" class="form-label">Anggota Keluarga</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <select id="keluarga" name="keluarga" class="form-control" >
                                            <option>Pilih Anggota Keluarga</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_dok" class="form-label">Jenis Dokumen</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <select id="jenis_dok" name="jenis_dok" required="required" class="form-control">
                                            <?php
                                            foreach ($attr['jenis_dok'] as $dok){
                                                ?>
                                                <option value="<?php echo $dok->jenis_kartu?>"><?php echo $dok->deskripsi_kartu?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_dok" class="form-label">No Dokumen</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">keyboard</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="no_dok" name="no_dok" class="form-control" type="text">
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
                                            <input id="tanggal" name="tanggal" class="form-control datepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b>File Dokumen</b>
                                <div class="input-group">
                                    <div class="form-line">
                                        <input id="dokumen" name="dokumen" class="dropify" type="file">
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
        var baseURL= "<?php echo base_url();?>";
        $('.dropify').dropify({
            messages: {
                default : 'Drag atau drop untuk memilih gambar',
                replace : 'Ganti',
                remove  : 'Hapus',
                error   : 'error'
            }
        });

        $('#nik').change(function(){
            var keluarga = $(this).val();
            // AJAX request
            $.ajax({
                url: baseURL+'dokumen/getDataKeluarga',
                method: 'post',
                data: {id_karyawan: keluarga},
                dataType: 'json',
                success: function(response){
                    // Remove options 
                    $('#keluarga').find('option').not(':first').remove();
                    // Add options
                    $.each(response,function(index,data){
                        $('#keluarga').append('<option value="'+data['id_keluarga']+'">'+data['nama_keluarga']+'</option>');
                    });
                    $('#keluarga').selectpicker('refresh');
                }
            });
        });
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