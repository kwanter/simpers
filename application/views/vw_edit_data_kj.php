<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Data Merit</h2>
                    </div>
                    <div class="body">
                        <?php echo $this->session->flashdata('notif');?>
                        <form id="form_input_pegawai" action="<?php echo base_url('kelasjabatan/updateData')?>" method="POST" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>ID Tunjangan</b><br><br>
                                    <div class="input-group">
                                        <select name="id_kj" id="id_kj" class="form-control">
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
                            </div>
                            <div class="col-md-12">
                                <b>Nama Kelas Jabatan</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">keyboard</i>
                                    </span>
                                    <div class="form-line">
                                        <input id="nama_kj" disabled name="nama_kj" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <b>Periode</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">work</i>
                                    </span>
                                    <div class="form-line">
                                        <input id="periode" disabled name="periode" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <b>Besaran Merit</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">attach_money</i>
                                    </span>
                                    <div class="form-line">
                                        <input id="merit" name="merit" class="form-control" type="number">
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