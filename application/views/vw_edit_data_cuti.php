<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Pengubahan Data Pengajuan Cuti Pegawai</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_pendidikan" action="<?php echo base_url('cuti/updateData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK / Nama Pegawai</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <input type="hidden" value="<?php echo $attr['data']->id_datacuti?>" name="id_datacuti" id="id_datacuti">
                                        <select readonly title="Pegawai Yang Ingin Cuti" id="nik" name="nik" required="required" class="form-control selectpicker show-tick" data-dropup-auto="false" data-size="5" data-live-search="true">
                                            <?php
                                            foreach ($attr['karyawan'] as $karyawan){
                                                if($attr['data']->id_karyawan == $karyawan->id_karyawan){
                                            ?>
                                                    <option selected value="<?php echo $karyawan->id_karyawan ?>"><?php echo $karyawan->nik ?> => <?php echo $karyawan->nama_karyawan ?></option>
                                            <?php
                                                } else{
                                                ?>
                                                    <option value="<?php echo $karyawan->id_karyawan ?>"><?php echo $karyawan->nik ?> => <?php echo $karyawan->nama_karyawan ?></option>
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
                                    <label for="nik" class="form-label">Divisi</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <input disabled type="text" class="form-control" name="divisi_cuti" id="divisi_cuti">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="form-label">Jabatan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <input disabled type="text" class="form-control" name="jabatan_cuti" id="jabatan_cuti">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_diklat" class="form-label">NIK / Nama Pegawai Pengganti</label>
                                     <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <select title="Pegawai Pengganti" id="nik_pengganti" name="nik_pengganti" required="required" class="form-control selectpicker show-tick" data-dropup-auto="false" data-size="5" data-live-search="true">
                                            <?php
                                            foreach ($attr['karyawan'] as $karyawan){
                                                if($attr['data']->id_karyawan_pengganti == $karyawan->id_karyawan){
                                            ?>
                                                    <option selected value="<?php echo $karyawan->id_karyawan ?>"><?php echo $karyawan->nik ?> => <?php echo $karyawan->nama_karyawan ?></option>
                                            <?php
                                                } else{
                                                ?>
                                                    <option value="<?php echo $karyawan->id_karyawan ?>"><?php echo $karyawan->nik ?> => <?php echo $karyawan->nama_karyawan ?></option>
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
                                    <label for="nik" class="form-label">Divisi Pegawai Pengganti</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                       <input disabled type="text" class="form-control" name="divisi_pengganti" id="divisi_pengganti">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="form-label">Jabatan Pegawai Pengganti</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <input disabled type="text" class="form-control" name="jabatan_pengganti" id="jabatan_pengganti">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_cuti" class="form-label">Jenis Cuti</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <select disabled title="Pilih Jenis Cuti" id="jenis_cuti" name="jenis_cuti_hidden" class="form-control">
                                            <?php
                                            foreach ($attr['jeniscuti'] as $jenis_cuti){
                                                if($attr['data']->jenis_cuti == $jenis_cuti->id_jeniscuti){
                                            ?>
                                                    <option selected value="<?php echo $jenis_cuti->id_jeniscuti?>"><?php echo $jenis_cuti->nama_cuti?></option>
                                                    <input type="hidden" name="jenis_cuti" value="<?php echo $jenis_cuti->id_jeniscuti?>" id="jenis_cuti_hidden"/>
                                            <?php        
                                                } else {
                                                ?>
                                                    <option value="<?php echo $jenis_cuti->id_jeniscuti?>"><?php echo $jenis_cuti->nama_cuti?></option>
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
                                    <label for="tgl_diklat" class="form-label">Sisa Cuti Tahunan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="sisa_cuti" readonly name="sisa_cuti" class="form-control" value="<?php echo $attr['cuti']?>" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kota_cuti" class="form-label">Kota Tempat Cuti</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">title</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="sisa_cuti" required="required" name="kota_cuti" value="<?php echo $attr['data']->kota_cuti?>" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_diklat" class="form-label">Alasan Pengajuan Cuti</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">title</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="alasan_pengajuan" value="<?php echo $attr['data']->alasan_pengajuan?>" name="alasan_pengajuan" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_diklat" class="form-label">Tanggal Pengajuan Awal Cuti</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input value="<?php echo $attr['data']->tgl_mulai_cuti;?>" id="tgl_cuti_awal" name="tgl_cuti_awal" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_diklat" class="form-label">Tanggal Pengajuan Akhir Cuti</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input value="<?php echo $attr['data']->tgl_selesai_cuti;?>" id="tgl_cuti_akhir" name="tgl_cuti_akhir" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_diklat" class="form-label">Tanggal Kembali Cuti</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input value="<?php echo $attr['data']->tgl_kembali;?>" id="tgl_cuti_kembali" name="tgl_cuti_kembali" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_diklat" class="form-label">Tanggal Formulir Di Cetak</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input value="<?php echo $attr['data']->tgl_dokumen_formulir;?>" id="tgl_dokumen_formulir" name="tgl_dokumen_formulir" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jabatan" class="form-label">Pejabat Yang Menyetujui</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">title</i>
                                        </span>
                                        <div class="form-line">
                                            <select title="Pilih Pejabat Yang Menyetujui" id="pejabat_setuju" name="pejabat_setuju" required="required" class="form-control selectpicker show-tick" data-dropup-auto="false" data-size="4">
                                                <?php
                                                foreach ($attr['pejabat'] as $pejabat){
                                                    if($attr['data']->pejabat_setuju == $pejabat->id_karyawan){
                                                ?>
                                                        <option selected value="<?php echo $pejabat->id_karyawan ?>"> <?php echo $pejabat->nama_karyawan ?></option>
                                                <?php        
                                                    } else {
                                                    ?>
                                                        <option value="<?php echo $pejabat->id_karyawan ?>"> <?php echo $pejabat->nama_karyawan ?></option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jabatan" class="form-label">Pejabat Yang Berwenang</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">title</i>
                                        </span>
                                        <div class="form-line">
                                            <select title="Pilih Pejabat Yang Berwenang" id="pejabat_wewenang" name="pejabat_wewenang" required="required" class="selectpicker form-control show-tick" data-dropup-auto="false" data-size="4">
                                                <?php
                                                foreach ($attr['pejabat'] as $pejabat){
                                                    if($attr['data']->pejabat_wewenang == $pejabat->id_karyawan){ 
                                                ?>
                                                        <option selected value="<?php echo $pejabat->id_karyawan ?>"> <?php echo $pejabat->nama_karyawan ?></option>
                                                <?php        
                                                    } else {
                                                    ?>
                                                        <option value="<?php echo $pejabat->id_karyawan ?>"> <?php echo $pejabat->nama_karyawan ?></option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            </select>
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
    $(document).ready(function(){
            $('#nik').on('change',function(){
            var data = $(this).val();
            if(data){
                $.ajax({
                    type:'POST',
                    url: '<?php echo base_url("pegawai/getDataKaryawanCuti") ?>',
                    dataType: "json",
                    data:'data='+data,
                    success:function(result){
                        if(result.status == 'ok'){
                            $('#divisi_cuti').val(result.result.unit_kerja);
                            $('#jabatan_cuti').val(result.result.jabatan_terakhir); 
                            $('#sisa_cuti').val(result.result.sisa_cuti_tahunan);
                        } else{
                            $('#divisi_cuti').html('');
                            $('#jabatan_cuti').html('');
                            $('#sisa_cuti').html(''); 
                        }
                    }
                }); 
            }else{
                $('#divisi_cuti').html('');
                $('#jabatan_cuti').html(''); 
                $('#sisa_cuti').html('');
            }
        });

        $('#nik_pengganti').on('change',function(){
            var data = $(this).val();
            if(data){
                $.ajax({
                    type:'POST',
                    url: '<?php echo base_url("pegawai/getDataKaryawanCuti") ?>',
                    dataType: "json",
                    data:'data='+data,
                    success:function(result){
                        if(result.status == 'ok'){
                            $('#divisi_pengganti').val(result.result.unit_kerja);
                            $('#jabatan_pengganti').val(result.result.jabatan_terakhir); 
                        } else{
                            $('#divisi_pengganti').html('');
                            $('#jabatan_pengganti').html(''); 
                        }
                    }
                }); 
            }else{
                $('#divisi_pengganti').html('');
                $('#jabatan_pengganti').html(''); 
            }
        });
        $('.selectpicker').selectpicker('refresh')
    });

    function cancel() {
        window.location.replace('<?php echo site_url('master/cuti/cuti')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/cuti/cuti')?>')
    }

    $('#tgl_cuti_awal').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $('#tgl_cuti_akhir').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $('#tgl_cuti_kembali').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $('#tgl_dokumen_formulir').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });
</script>
