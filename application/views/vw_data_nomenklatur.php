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
                            Data Nomenklatur
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a onclick="reload_table();"><i class="material-icons">refresh</i> <span>Reload Tabel</span> </a></li>
                                    <li><a onclick="add()"><i class="material-icons">add</i> <span>Tambah Data</span></a></li>
                                    <!---<li><a onclick="edit()"><i class="material-icons">mode_edit</i><span>Ubah Data</span> </a></li>--->
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <button class="btn-primary" onclick="excel();">Excel</button>
                        <button class="btn-info" onclick="pdf();">PDF</button>
                        <div class="table-responsive">
                            <?php
                                for ($i=0;$i<$attr['jumlah'];$i++) {
                                    ?>
                                    <table id="tabel<?php echo $i?>"
                                           class="table table-bordered table-striped table-hover js-basic-example dataTable"
                                           cellspacing="0" width="100%" role="grid">
                                        <caption id="caption<?php echo $i?>"></caption>
                                        <thead>
                                        <tr>
                                            <th>
                                                <center>Jabatan
                                            </th>
                                            <th>
                                                <center>Kelas Jabatan
                                            </th>
                                            <th>
                                                <center>Jumlah
                                            </th>
                                            <th>
                                                <center>Terisi
                                            </th>
                                            <th>
                                                <center>Selisih
                                            </th>
                                            <th>
                                                <center>Aksi
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>
                                                <center>Jabatan
                                            </th>
                                            <th>
                                                <center>Kelas Jabatan
                                            </th>
                                            <th>
                                                <center>Jumlah
                                            </th>
                                            <th>
                                                <center>Terisi
                                            </th>
                                            <th>
                                                <center>Selisih
                                            </th>
                                            <th>
                                                <center>Aksi
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Horizontal Layout -->
    </div>
</section>
<script type="text/javascript">
    var table = [];
    var jumlah = <?php echo $attr['jumlah']?>;
    var uker = <?php echo json_encode($attr['uker']) ?>;

    $(document).ready(function() {
        for (var i=0;i<jumlah;i++){
            table[i] = $('#tabel'+i).DataTable({
                processing: true, //Feature control the processing indicator.
                serverSide: true, //Feature control DataTables' server-side processing mode.
                order: [], //Initial no order.
                autowidth : true,

                // Load data for the table's content from an Ajax source
                ajax: {
                    "url": "<?php echo base_url('nomenklatur/ajax_list/')?>" ,
                    "type": "POST",
                    "data":{uker : uker[i]['uker'] }
                },
                //Set column definition initialisation properties.
                columnDefs: [
                    {
                        "targets": [ -1,-2,-3,-4,-5,-6], //first column / numbering column
                        "orderable" : false
                    }
                ]
            });
        }

        caption(uker);
    });

    function caption(caption) {
        for(var i=0;i<jumlah;i++){
            $('#caption'+i).append('<p style="font-style: oblique;font-weight: bolder">'+caption[i]['uker']+'</p>');
        }
    }

    function excel() {
        window.open('<?php echo site_url('nomenklatur/excel')?>');
    }

    function pdf() {
        window.open('<?php echo site_url('nomenklatur/pdf')?>');
    }

    function reload_table() {
        for (var i=0;i<jumlah;i++){
            table[i].ajax.reload(null,false);
        }
    }

    function add() {
        window.location.replace('<?php echo site_url('nomenklatur')?>');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('nomenklatur/edit/')?>'+id);
    }

    function del(id) {
        swal({
            title: "Apakah Anda Yakin ?",
            text: "Anda Tidak Akan Bisa Merecover Kembali Data Yang Sudah Anda Hapus !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo site_url('nomenklatur/delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        swal("Terhapus !", "Data Anda Sudah Dihapus", "success");
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("Dibatalkan", "Data Anda Tidak Jadi Dihapus", "error");
                    }
                });
            } else {
                swal("Dibatalkan", "Data Anda Tidak Jadi Dihapus", "error");
            }
        });
    }
</script>