<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2><center>Data Nomenklatur</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="container">
                <button class="btn btn-info" onclick="reload_table();"><i class="glyphicon glyphicon-repeat"></i> Reload Tabel </button>
                <button class="btn btn-success" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
            </div>
            <div class="container">
                <div class="row">
                    <div class="container">
                        <div class="table-responsive">
                            <table id="tabel" class="table table-striped jambo_table table-bordered" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th><center>Jabatan</th>
                                    <th><center>Job Title</th>
                                    <th><center>Unit Kerja</th>
                                    <th><center>Grup</th>
                                    <th><center>Jumlah</th>
                                    <th><center>Terisi</th>
                                    <th><center>Selisih</th>
                                    <th><center>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><center>Jabatan</th>
                                    <th><center>Job Title</th>
                                    <th><center>Unit Kerja</th>
                                    <th><center>Grup</th>
                                    <th><center>Jumlah</th>
                                    <th><center>Terisi</th>
                                    <th><center>Selisih</th>
                                    <th><center>Aksi</th>
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
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
            order: [], //Initial no order.
            autowidth : true,
            dom: "Blfrtip",
            buttons: [
                {
                    extend: "excel",
                    className: "btn-sm",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
                },
                {
                    extend: "pdfHtml5",
                    orientation: 'landscape',
                    pageSize: 'A4',
                    className: "btn-sm",
                    title : "Nomenklatur",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
                },
            ],

            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo base_url('nomenklatur/ajax_list')?>",
                "type": "POST",
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {
                    "targets": [ -1,-2,-3,-4,-5,-6,-7,-8], //first column / numbering column
                    "orderable" : false
                },
                {
                    "targets": [-2,-3,-4,-5], //first column / numbering column
                    "width" : "5%"
                },
                {
                    "targets": [-1], //first column / numbering column
                    "width" : "9%"
                }
            ],

        });
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add() {
        window.location.replace('<?php echo site_url('nomenklatur')?>');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('nomenklatur/edit/')?>'+id);
    }

    function del(id) {
        if(confirm('Anda Yakin Ingin Menghapus Data Ini ?')) {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('nomenklatur/delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    new PNotify({
                        title: 'Success',
                        text: 'Data Berhasil Di Hapus',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    new PNotify({
                        title: 'Oh No!',
                        text: 'Data Gagal Di Hapus',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }
            });

        }
    }
</script>