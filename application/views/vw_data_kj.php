<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2><center>Data Merit</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="container">
                <button class="btn btn-info" onclick="reload_table();"><i class="glyphicon glyphicon-repeat"></i> Reload Tabel </button>
                <!---<button class="btn btn-success" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>--->
                <button class="btn btn-warning" onclick="edit()"><i class="glyphicon glyphicon-pencil"></i> Ubah Data</button>
            </div>
            <div class="container">
                <div class="row">
                    <div class="container">
                        <div class="table-responsive">
                            <table id="tabel" class="table jambo_table table-striped table-bordered" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th><center>KJ</th>
                                    <th><center>Periodik 0</th>
                                    <th><center>Periodik 1</th>
                                    <th><center>Periodik 2</th>
                                    <th><center>Periodik 3</th>
                                    <th><center>Periodik 4</th>
                                    <th><center>Periodik 5</th>
                                    <th><center>Periodik 6</th>
                                    <th><center>Periodik 7</th>
                                    <th><center>Periodik 8</th>
                                    <th><center>Periodik 9</th>
                                    <th><center>Periodik 10</th>
                                    <th><center>Periodik 11</th>
                                    <th><center>Periodik 12</th>
                                    <th><center>Periodik 13</th>
                                    <th><center>Periodik 14</th>
                                    <th><center>Periodik 15</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><center>KJ</th>
                                    <th><center>Periodik 0</th>
                                    <th><center>Periodik 1</th>
                                    <th><center>Periodik 2</th>
                                    <th><center>Periodik 3</th>
                                    <th><center>Periodik 4</th>
                                    <th><center>Periodik 5</th>
                                    <th><center>Periodik 6</th>
                                    <th><center>Periodik 7</th>
                                    <th><center>Periodik 8</th>
                                    <th><center>Periodik 9</th>
                                    <th><center>Periodik 10</th>
                                    <th><center>Periodik 11</th>
                                    <th><center>Periodik 12</th>
                                    <th><center>Periodik 13</th>
                                    <th><center>Periodik 14</th>
                                    <th><center>Periodik 15</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var table;

    $(document).ready(function() {
        table = $('#tabel').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url('kelasjabatan/ajax_list')?>",
                "type": "POST"
            },
            "iDisplayLength": 50,
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column / numbering column
                    "width" : "5%"
                },
                {
                    "targets": [ 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16], //first column / numbering column
                    "orderable" : false
                }
            ]
        });
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add() {
        window.location.replace('<?php echo site_url('kelasjabatan')?>');
    }

    function edit() {
        window.location.replace('<?php echo site_url('kelasjabatan/edit')?>');
    }
</script>