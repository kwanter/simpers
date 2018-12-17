<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Riwayat Jabatan Karyawan</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_jabatan" action="<?php echo base_url('jabatan/updateData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK / Nama Karyawan</label>
                                    <input type="hidden" id="id_riwayat" name="id_riwayat" value="<?php echo $attr['jabatan']->id_riwayatjabatan?>"/>
                                    <input hidden type="text" name="id_karyawan" id="id_karyawan" value="<?php echo $attr['jabatan']->id_karyawan?>">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <input value="<?php echo $attr['karyawan']['nama_karyawan']?>" readonly id="nik" name="nik" required="required" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_surat" class="form-label">No Surat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">keyboard</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="no_surat" value="<?php echo $attr['jabatan']->no_surat?>" name="no_surat" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal" class="form-label">Tanggal Berlaku Surat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="tanggal" value="<?php echo $attr['jabatan']->tgl_berlaku?>" name="tanggal" required="required" class="form-control datepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="masa_selesai" class="form-label">Masa Selesai Jabatan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="masa_selesai" value="<?php echo $attr['jabatan']->tgl_selesai?>" name="masa_selesai" class="form-control datepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jabatan" class="form-label">Nama Jabatan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">title</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="hidden" id="id_nomen" name="id_nomen" value="<?php echo $attr['jabatan']->id_nomenklatur?>" /><input type="hidden" id="tampung" value="">
                                            <input id="jabatan" value="<?php echo $attr['jabatan']->nama_jabatan?>" name="jabatan" required="required" class="form-control" type="text">
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
                                                            event.preventDefault();
                                                            $('#jabatan').val(ui.item.label); // display the selected text
                                                            $('#tampung').val(ui.item.label); // display the selected text
                                                            $('#job_title').val(ui.item.job_title); // display the selected text
                                                            $('#kj').val(ui.item.kelas_jabatan).change();
                                                            $('#id_nomen').val(ui.item.id); // save selected id to input
                                                            $('#unit_kerja').val(ui.item.uker); // save selected id to input
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
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="job_title" class="form-label">Job Title</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">title</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="job_title" value="<?php echo $attr['jabatan']->job_title?>" name="job_title" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span>
                                        <input type="checkbox" class="filled-in" id="pilihan" name="pilihan" value="0">
                                        <label class="form-label" for="pilihan">Jabatan Existing Sama Dengan Nama Jabatan</label>
                                    </span>
                                </div>
                            </div>
                            <div id="jabatan_exist">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="jabatan_existing" class="form-label">Jabatan Existing</label>
                                        <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">title</i>
                                        </span>
                                            <div class="form-line">
                                                <input id="jabatan_existing" value="<?php echo $attr['jabatan']->tugas_jabatan?>" name="jabatan_existing" required="required" class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_kerja" class="form-label">Unit Kerja</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">work</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="unit_kerja" value="<?php echo $attr['jabatan']->unit_kerja?>" name="unit_kerja" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status_karyawan" class="form-label">Status Karyawan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">developer_mode</i>
                                        </span>
                                        <select id="status_karyawan" name="status_karyawan" required="required" class="form-control">
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
                                                <option value="CK">Calon Karyawan</option>
                                                <option value="K">Karyawan</option>
                                                <option selected value="P">Perbantuan</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kj" class="form-label">Kelas Jabatan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <select id="kj" name="kj" required="required" class="form-control">
                                            <?php
                                            foreach ($attr['kj'] as $kj){
                                                if($kj->kelas_jabatan == $attr['jabatan']->kelas_jabatan) {
                                                    ?>
                                                    <option selected value="<?php echo $kj->kelas_jabatan ?>"><?php echo $kj->nama_kelasjabatan ?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="<?php echo $kj->kelas_jabatan ?>"><?php echo $kj->nama_kelasjabatan ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="periode" class="form-label">Periode</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <select id="periode" name="periode" required="required" class="form-control">
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
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status Surat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <select id="status" name="status" required="required" class="form-control">
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
                            </div>
                            <div class="col-md-12">
                                <b>File SK</b>
                                <div class="input-group">
                                    <div class="form-line">
                                        <?php
                                            $bulan = (new DateTime($attr['jabatan']->tgl_berlaku))->format('M');
                                            $tahun = (new DateTime($attr['jabatan']->tgl_berlaku))->format('Y');
                                        ?>
                                        <input id="sk" name="sk" class="dropify" type="file" data-show-errors="true" data-default-file="<?php echo base_url('edok/').$attr['jabatan']->id_karyawan."/sk/".$tahun.'/'.$bulan.'/'.$attr['jabatan']->sk?>">
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
    });

    function cancel() {
        window.location.replace('<?php echo site_url('master/data/jabatan')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/data/jabatan')?>')
    }

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $(function(){
        $('#pilihan').click(function() {
            var jabatan = $('#tampung').val();
            if(jabatan == '' || jabatan == null){
                if($(this).is(':checked')){
                    var jabatan_x = $('#jabatan').val();
                    $('#jabatan_existing').val(jabatan_x);
                }
                else{
                    $('#jabatan_existing').val("");
                }
            }
            else{
                if($(this).is(':checked')){
                    $('#jabatan_existing').val(jabatan);
                }
                else{
                    $('#jabatan_existing').val("");
                }
            }
        });

        $('#jabatan').keydown(function(){
            setTimeout(function() {
                var tampung = $('#jabatan').val();
                $('#tampung').val(tampung);
            }, 50);
        });
    });

</script>