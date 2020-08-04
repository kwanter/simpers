<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<style>
    .dataTable > thead > tr > th[class*="sort"]:after{
        content: "" !important;
    }

    table.dataTable thead>tr>th.sorting_asc, 
    table.dataTable thead>tr>th.sorting_desc, 
    table.dataTable thead>tr>th.sorting, 
    table.dataTable thead>tr>td.sorting_asc, 
    table.dataTable thead>tr>td.sorting_desc, 
    table.dataTable thead>tr>td.sorting { 
        padding-right: inherit; 
    }

    th.sorting_asc::after, th.sorting_desc::after { 
        content:"" !important; 
    }
    td.sorting_asc::after, td.sorting_desc::after { 
        content:"" !important; 
    }
    "this".sorting_asc::after, "this".sorting_desc::after { 
        content:"" !important; 
    }

</style>
<section class="content">
    <div class="container-fluid"></div>
        <!-- Horizontal Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            List Cuti Pegawai
                        </h2>
                    </div>
                    <div class="body">
                        <button class="btn btn-info" onclick="reload_table();"><i class="material-icons">refresh</i> <span>Reload Tabel</span></button>
                        <button class="btn btn-success" onclick="add();"><i class="material-icons">add</i> <span>Pengajuan Cuti</span></button>
                        <br><br>
                        <div class="table-responsive">
                            <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid" >
                                <thead>
                                <tr>
                                    <th><center>No.</th>
                                    <th><center>Nama Pegawai</th>
                                    <th><center>Tgl Mulai Cuti</th>
                                    <th><center>Tgl Selesai Cuti</th>
                                    <th><center>Jenis Cuti</th>
                                    <th><center>Lama Cuti</th>
                                    <th><center>Pegawai Pengganti</th>
                                    <th><center>Pejabat Pengesah</th>
                                    <th><center>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><center>No.</th>
                                    <th><center>Nama Pegawai</th>
                                    <th><center>Tgl Mulai Cuti</th>
                                    <th><center>Tgl Selesai Cuti</th>
                                    <th><center>Jenis Cuti</th>
                                    <th><center>Lama Cuti</th>
                                    <th><center>Pegawai Pengganti</th>
                                    <th><center>Pejabat Pengesah</th>
                                    <th><center>Aksi</th>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-col-blue">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modalLabel">Persetujuan Cuti</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="disetujui"><span class="glyphicon glyphicon-list-alt"></span> Disetujui</label>
                        <span class="input-group-addon">
                            <input name="group1" value="1" class="radio-btn" name="disetujui" type="radio" id="radio_1" />
                            <label for="radio_1">Ya</label>
                            <input name="group1" value="0" class="radio-btn" name="disetujui" type="radio" id="radio_2" checked/>
                            <label for="radio_2">Tidak</label>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="no_surat_cuti"><span class="glyphicon glyphicon-list-alt"></span> No Surat Cuti</label>
                        <input type="hidden" id="id_cuti">
                        <div class="form-line">
                            <input type="text" disabled class="form-control" id="no_surat_cuti" placeholder="Masukkan No Surat Cuti Disini">
                        </div>
                    </div>
                    <button type="submit" id="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
            <div class="modal-footer modal-col-blue">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var table;

    $(document).ready(function(){
        table= $('#tabel').DataTable({
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
            targets : 'no-sort',
            bSort : false,
            order: [], //Initial no order.
            autowidth : true,

            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo site_url('cuti/ajax_list')?>" ,
                "type": "POST",
            },
            language: {
                emptyTable: "Data Belum Di Isi",
                loadingRecords: "Memuat....Harap Menunggu"
            },
        });
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add() {
        window.location.replace('<?php echo site_url('cuti')?>');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('cuti/edit/')?>'+id);
    }

    function print(id) {
        window.open('<?php echo site_url('cuti/formulir_cuti/')?>'+id,'_blank');
        window.focus();
    }

    function tampil() {
        var id = $('#nik').val();
        $('#tabel-hidden').removeAttr('hidden');
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
                    url : "<?php echo site_url('cuti/delete')?>/"+id,
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