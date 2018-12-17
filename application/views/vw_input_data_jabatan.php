<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Input Riwayat Jabatan Karyawan</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_pendidikan" action="<?php echo base_url('jabatan/addData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK / Nama Karyawan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">perm_identity</i>
                                        </span>
                                        <select id="nik" name="nik" required="required" class="form-control show-tick">
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
                                    <label for="no_surat" class="form-label">No Surat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">keyboard</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="no_surat" name="no_surat" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal" class="form-label">Tanggal Berlaku Surat</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="tanggal" name="tanggal" required="required" class="form-control datepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="masa_selesai" class="form-label">Masa Selesai Jabatan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="masa_selesai" name="masa_selesai" class="form-control datepicker" type="text">
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
                                            <input type="hidden" id="id_nomen" name="id_nomen" value="" /><input type="hidden" id="tampung" value="">
                                            <input id="jabatan" value="" name="jabatan" required="required" class="form-control" type="text">
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
                                            <input id="job_title" name="job_title" required="required" class="form-control" type="text">
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
                                                <input id="jabatan_existing" name="jabatan_existing" required="required" class="form-control" type="text">
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
                                            <input id="unit_kerja" name="unit_kerja" required="required" class="form-control" type="text">
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
                                            <option value="CK">Calon Karyawan</option>
                                            <option value="K">Karyawan</option>
                                            <option value="P">Perbantuan</option>
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
                                                ?>
                                                <option value="<?php echo $kj->kelas_jabatan?>"><?php echo $kj->nama_kelasjabatan?></option>
                                                <?php
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
                                                ?>
                                                <option value="<?php echo $periode->periodik?>"><?php echo $periode->periodik?></option>
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
                                        <input id="sk" name="sk" class="dropify" type="file">
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