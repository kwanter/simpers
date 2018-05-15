<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2><center>Data Tunjangan</h2>
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
                            <table id="tabel" class="table table-striped jambo_table table-bordered" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th><center>Nama Tunjangan</th>
                                    <th><center>KJ1</th>
                                    <th><center>KJ2</th>
                                    <th><center>KJ3</th>
                                    <th><center>KJ4</th>
                                    <th><center>KJ5</th>
                                    <th><center>KJ6</th>
                                    <th><center>KJ7</th>
                                    <th><center>KJ8</th>
                                    <th><center>KJ9</th>
                                    <th><center>KJ10</th>
                                    <th><center>KJ11</th>
                                    <th><center>KJ12</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><center>Nama Tunjangan</th>
                                    <th><center>KJ1</th>
                                    <th><center>KJ2</th>
                                    <th><center>KJ3</th>
                                    <th><center>KJ4</th>
                                    <th><center>KJ5</th>
                                    <th><center>KJ6</th>
                                    <th><center>KJ7</th>
                                    <th><center>KJ8</th>
                                    <th><center>KJ9</th>
                                    <th><center>KJ10</th>
                                    <th><center>KJ11</th>
                                    <th><center>KJ12</th>
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
                "url": "<?php echo base_url('tunjangan/ajax_list')?>",
                "type": "POST"
            },
            "iDisplayLength": 50,
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column / numbering column
                    "width" : "15%",
                    "orderable" : false
                },
                {
                    "targets": [ -1,-2,-3,-4,-5,-6,-7,-8,-9,-10,-11,-12], //first column / numbering column
                    "orderable" : false
                }
            ]
        });
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function edit() {
        window.location.replace('<?php echo site_url('tunjangan/edit')?>');
    }

    function add() {
        window.location.replace('<?php echo site_url('tunjangan')?>');
    }
</script>