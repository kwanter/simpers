<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Input Data Tunjangan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-input" data-parsley-validate="" action="<?php echo base_url('tunjangan/addData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tunjangan">ID Tunjangan <span class="required">
                    </label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <input id="id_tunjangan" name="id_tunjangan" required="required" data-inputmask="'mask': 'TJAAA-KJ99'" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_tunjangan">Nama Tunjangan <span class="required"></span>
                    </label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <input id="nama_tunjangan" name="nama_tunjangan" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kelas_jabatan">Kelas Jabatan <span class="required"></span>
                    </label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <select id="kelas_jabatan" name="kelas_jabatan" required="required" class="form-control col-md-5 col-xs-8">
                            <?php
                            foreach ($attr['kj'] as $kj){
                            ?>
                            <option value="<?php echo $kj->kelas_jabatan ?>"><?php echo $kj->kelas_jabatan ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tunjangan" class="control-label col-md-3 col-sm-3 col-xs-12">Besaran Tunjangan</label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <input id="tunjangan" name="tunjangan" required="required" class="form-control col-md-5 col-xs-8" type="number">
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
                    window.location.replace('<?php echo site_url('master/page/tunjangan')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/tunjangan')?>')
                }
            </script>
        </div>
    </div>
</div>