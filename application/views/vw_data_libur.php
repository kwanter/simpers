<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    table, th, td {
        border: 1px solid black !important;
        font-size : 14 !important;
    }

    th , td{    
        height : 5px !important;
        vertical-align: center !important;
    }

    table.dataTable thead .sorting, 
    table.dataTable thead .sorting_asc, 
    table.dataTable thead .sorting_desc,
    table.dataTable thead .sorting_disabled {
        background : none !important;
    }

    .sorting_disabled {
        background-image : none !important;
    }

    .th1{
        width: 5% !important;
    }

    .th2{
        width: 10% !important;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <!-- Horizontal Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Master Data Hari Libur
                        </h2>
                        
                    </div>
                    <div class="body">
                        <button class="btn-primary" onclick="excel();"><i class="material-icons">event_note</i></button>
                        <button class="btn-info" onclick="pdf();"><i class="material-icons">speaker_notes</i></button>
                        <button class="btn-warning" onclick="reload_table();"><i class="material-icons">refresh</i></button>
                        <button class="btn-info" onclick="add();"><i class="material-icons">add</i></button>
                        <div class="table-responsive">
                            <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid">
                                <thead>
                                <tr>
                                    <th class="th1" align="center" ><center>No.</th>
                                    <th align="center" ><center>Tanggal Libur</th>
                                    <th align="center" ><center>Deskripsi Hari Libur</th>
                                    <th class="th2" align="center" ><center>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
            order: [], //Initial no order.
            autowidth : true,

            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo base_url('cuti/ajax_list_libur')?>" ,
                "type": "POST",
            },
            //Set column definition initialisation properties.
            columnDefs: [
                {
                    "targets": '_all', //first column / numbering column
                    "orderable" : false,
                    "order"    : [[1, 'asc']]
                }
            ]
        });
    });

    function excel() {
        window.open('<?php echo site_url('cuti/excel_libur')?>');
    }

    function pdf() {
        window.open('<?php echo site_url('cuti/pdf_libur')?>');
    }

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add() {
        window.location.replace('<?php echo site_url('cuti/libur_add')?>');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('cuti/libur_edit/')?>'+id);
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
                    url : "<?php echo site_url('cuti/deleteLibur')?>/"+id,
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