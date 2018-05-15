<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Input Data Nomenklatur</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-input" data-parsley-validate="" action="<?php echo base_url('nomenklatur/addData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_jabatan">Kode Jabatan <span class="required">
                    </label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <input id="kode_jabatan" name="kode_jabatan" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_jabatan">Nama Jabatan <span class="required"></span>
                    </label>
                    <div class="col-md-5 col-sm-4 col-xs-8">
                        <input id="nama_jabatan" name="nama_jabatan" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="job_title" class="control-label col-md-3 col-sm-3 col-xs-12">Job Title</label>
                    <div class="col-md-5 col-sm-4 col-xs-8">
                        <input id="job_title" name="job_title" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="jumlah" class="control-label col-md-3 col-sm-3 col-xs-12">Formasi Nomen</label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <input id="jumlah" name="jumlah" required="required" class="form-control col-md-5 col-xs-8" type="number">
                    </div>
                </div>
                <div class="form-group">
                    <label for="grup" class="control-label col-md-3 col-sm-3 col-xs-12">Grup</label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <select id="grup" name="grup" required="required" class="form-control col-md-5 col-xs-8">
                            <option value="---">---</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="uker" class="control-label col-md-3 col-sm-3 col-xs-12">Unit Kerja</label>
                    <div class="col-md-4 col-sm-4 col-xs-8">
                        <select id="uker" name="uker" required="required" class="form-control col-md-5 col-xs-8">
                            <option value="">---</option>
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
                <div class="form-group">
                    <label for="atasan" class="control-label col-md-3 col-sm-3 col-xs-12">Atasan</label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <input type="text" required="required" name="atasan" id="atasan" class="form-control col-md-5 col-xs-8"/>
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
                    window.location.replace('<?php echo site_url('master/page/nomenklatur')?>')
                }
                function master() {
                    window.location.replace('<?php echo site_url('master/page/nomenklatur')?>')
                }
            </script>
        </div>
    </div>
</div>