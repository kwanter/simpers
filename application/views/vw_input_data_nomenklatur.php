<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Input Data Nomenklatur</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_nomenklatur" action="<?php echo base_url('nomenklatur/addData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kode_jabatan">Kode Jabatan</label>
                                    <div class="form-line">
                                        <input id="kode_jabatan" name="kode_jabatan" required="required" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama_jabatan">Nama Jabatan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">keyboard</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="nama_jabatan" name="nama_jabatan" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="job_title">Job Title</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">work</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="job_title" name="job_title" required="required" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="uker">Unit Kerja</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">group_work</i>
                                        </span>
                                        <select id="uker" name="uker" required="required" class="form-control">
                                            <?php
                                            foreach ($attr['uker'] as $uker){
                                                ?>
                                                <option value="<?php echo $uker['id_uker'] ?>"><?php echo $uker['nama_uker'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="grup">Grup</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">group</i>
                                        </span>
                                        <select id="grup" name="grup" required="required" class="form-control">
                                            <option value="---">---</option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="atasan">Atasan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">supervisor_account</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" required="required" name="atasan" id="atasan" class="form-control"/>
                                            <input type="hidden" name="parent" id="parent"/>
                                            <script type="text/javascript">
                                                var id;
                                                $(document).ready(function () {
                                                    console.log( "document loaded" );
                                                    $("#uker").change(function() {
                                                        id = $(this).val();
                                                        $('#atasan').val('');
                                                        $('#parent').val('');
                                                    }).trigger("change");
                                                });

                                                $(function() {
                                                    $("#atasan").autocomplete({
                                                        source: function(request, response) {
                                                            $.ajax({
                                                                url      : "<?php echo base_url('nomenklatur/getAtasan/')?>" + id,
                                                                type     : "post",
                                                                dataType : "json",
                                                                data     : {
                                                                    search: request.term
                                                                },
                                                                success: function(data) {
                                                                    response(data);
                                                                },
                                                                error: function(jqXHR, textStatus, errorThrown){
                                                                    alert("Tidak Ditemukan");
                                                                },
                                                            });
                                                        },
                                                        select: function(event, ui) {
                                                            $('#atasan').val(ui.item.label); // display the selected text
                                                            $('#parent').val(ui.item.parent);
                                                            return false;
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
                                    <label for="jumlah">Formasi Nomen</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <div class="form-line">
                                            <input id="jumlah" name="jumlah" required="required" class="form-control" type="number">
                                        </div>
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
                                                if($kj->kelas_jabatan == $attr['nomenklatur']->id_kelasjabatan) {
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
        window.location.replace('<?php echo site_url('master/page/nomenklatur')?>')
    }

    function master() {
        window.location.replace('<?php echo site_url('master/page/nomenklatur')?>')
    }

    var form = $('#form_input_nomenklatur');
    form.validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
            $(element).parents('.input-group').append(error);
        }
    });
</script>