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
<div class="modal fade" tabindex="-1" role="dialog" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Nomenklatur Yang Terisi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
      </div>
      <div class="modal-body">
            <table id="tabel_detail" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid">
                <thead>
                <tr>
                    <th>
                        <center>NIK/NIPP
                    </th>
                    <th>
                        <center>Nama Karyawan
                    </th>
                    <th>
                        <center>Tmpt Lahir
                    </th>
                    <th>
                        <center>Tgl Lahir
                    </th>
                    <th>
                        <center>Umur
                    </th>
                    <th>
                        <center>Jenis Kelamin
                    </th>
                </tr>
                </thead>
                <tbody>
                </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
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

    function detail(id){
        $("#modal").modal('show');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('nomenklatur/edit/')?>'+id);
    }

    function del(id) {
        swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: 'Anda Tidak Akan Bisa Merecover Kembali Data Yang Sudah Anda Hapus !',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((willDelete) => {
            if (willDelete.value) {
                $.ajax({
                    url : "<?php echo site_url('nomenklatur/delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        swal.fire('Terhapus','Data Anda Sudah Dihapus','success');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire("Gagal","Data Anda Tidak Jadi Dihapus","error");
                    }
                });
            } else {
                swal.fire("Batal","Data Anda Tidak Jadi Dihapus","warning");
            }
        });

    }
</script>