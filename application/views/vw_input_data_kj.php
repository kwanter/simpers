<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2>Input Data Merit</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php echo $this->session->flashdata('notif');?>
            <form id="form-input" data-parsley-validate="" action="<?php echo base_url('kelasjabatan/addData')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_kelasjabatan">ID Kelas Jabatan <span class="required">
                    </label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <input id="id_kelasjabatan" name="id_kelasjabatan" required="required" data-inputmask="'mask': 'KJ99-99'" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kelas_jabatan">Kelas Jabatan <span class="required"></span>
                    </label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <input id="kelas_jabatan" name="kelas_jabatan" required="required" class="form-control col-md-5 col-xs-8" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="periodik" class="control-label col-md-3 col-sm-3 col-xs-12">Periodik</label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <select id="periodik" name="periodik" required="required" class="form-control col-md-5 col-xs-8" >
                            <?php
                            for($i=0;$i<=15;$i++){
                                ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="merit" class="control-label col-md-3 col-sm-3 col-xs-12">Merit</label>
                    <div class="col-md-2 col-sm-4 col-xs-8">
                        <input id="merit" name="merit" required="required" class="form-control col-md-5 col-xs-8" type="number">
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
                    window.location.replace('<?php echo site_url('master/page/kj')?>')
                }

                function master() {
                    window.location.replace('<?php echo site_url('master/page/kj')?>')
                }
            </script>
        </div>
    </div>
</div>
