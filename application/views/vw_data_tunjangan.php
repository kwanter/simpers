<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <!--
        <div class="block-header">
            <h2>DATA KARYAWAN</h2>
        </div>
        --->
        <!-- Horizontal Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Data Tunjangan
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a onclick="reload_table();"><i class="material-icons">refresh</i> <span>Reload Tabel</span> </a></li>
                                    <!---<li><a onclick="add()"><i class="material-icons">add</i> <span>Tambah Data</span></a></li>--->
                                    <li><a onclick="edit()"><i class="material-icons">mode_edit</i><span>Ubah Data</span> </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid" >
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
        <!-- #END# Horizontal Layout -->
    </div>
</section>
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