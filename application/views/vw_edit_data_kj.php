<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Edit Data Merit</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-edit" data-parsley-validate="" action="<?php echo base_url('kelasjabatan/updateData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_kj">ID KJ
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <select name="id_kj" id="id_kj" class="form-control col-md-7 col-xs-12">
                            <option value="">----</option>
                            <?php
                            foreach ($attr['data'] as $data){
                                ?>
                                <option value="<?php echo $data->id_kelasjabatan?>"><?php echo $data->kode_kelasjabatan?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_kj">Nama Kelas Jabatan
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="nama_kj" disabled name="nama_kj" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="periode" class="control-label col-md-3 col-sm-3 col-xs-12">Periode</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="periode" disabled name="periode" class="form-control col-md-7 col-xs-12" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="merit" class="control-label col-md-3 col-sm-3 col-xs-12">Besaran Merit</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="merit" name="merit" class="form-control col-md-7 col-xs-12" type="number">
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
                    $('#id_kj').on('change',function(){
                        var IDkj = $(this).val();
                        if(IDkj != ""){
                            $.ajax({
                                type:'POST',
                                url:'<?php echo base_url('kelasjabatan/getData')?>',
                                data:'id_kj='+IDkj,
                                success:function(html){
                                    var data = JSON.parse(html);
                                    $('#nama_kj').val(data.nama_kj);
                                    $('#periode').val(data.periode);
                                    $('#merit').val(data.besaran_merit);
                                }
                            });
                        }else{
                            $('#nama_kj').val('');
                            $('#periode').val('');
                            $('#merit').val('');
                        }
                    });
                });

                function cancel() {
                    window.location.replace('<?php echo site_url('master/page/kj')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/kj')?>')
                }
            </script>
        </div>
    </div>
</div>