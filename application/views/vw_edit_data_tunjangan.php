<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Edit Data Tunjangan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-edit" data-parsley-validate="" action="<?php echo base_url('tunjangan/updateData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tunjangan">ID Tunjangan
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <select name="id_tunjangan" id="id_tunjangan" class="form-control col-md-7 col-xs-12">
                            <option value="">----</option>
                            <?php
                            foreach ($attr['data'] as $data){
                                ?>
                                <option value="<?php echo $data->id_tunjangan?>"><?php echo $data->kode_tunjangan?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_tunjangan">Nama Tunjangan
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="nama_tunjangan" disabled name="nama_tunjangan" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="kelas_jabatan" class="control-label col-md-3 col-sm-3 col-xs-12">Kelas Jabatan</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="kelas_jabatan" disabled name="kelas_jabatan" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="besaran_tunjangan" class="control-label col-md-3 col-sm-3 col-xs-12">Besaran Tunjangan</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="besaran_tunjangan" name="besaran_tunjangan" class="form-control col-md-7 col-xs-12" type="number">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" onclick="cancel();" type="button">Cancel</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>

            <script type="text/javascript">
                $(document).ready(function(){
                    $('#id_tunjangan').on('change',function(){
                        var IDtunjangan = $(this).val();
                        if(IDtunjangan != ""){
                            $.ajax({
                                type:'POST',
                                url:'<?php echo base_url('tunjangan/getData')?>',
                                data:'id_tunjangan='+IDtunjangan,
                                success:function(html){
                                    var data = JSON.parse(html);
                                    $('#nama_tunjangan').val(data.nama_tunjangan);
                                    $('#kelas_jabatan').val(data.kelas_jabatan);
                                    $('#besaran_tunjangan').val(data.besaran_tunjangan);
                                }
                            });
                        }else{
                            $('#nama_tunjangan').val('');
                            $('#kelas_jabatan').val('');
                            $('#besaran_tunjangan').val('');
                        }
                    });
                });

                function cancel() {
                    window.location.replace('<?php echo site_url('master/page/tunjangan')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/tunjangan')?>')
                }
            </script>
        </div>
    </div>
</div>