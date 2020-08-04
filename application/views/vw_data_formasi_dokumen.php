<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    table, th, td {
        border: 1px solid black !important;
        font-size : 10 !important;
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

</style>
<section class="content">
    <div class="container-fluid">
        <!-- Horizontal Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Formasi Dokumen Karyawan
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <ul class="dropdown-menu pull-right">
                                    <li><a onclick="reload_table();"><i class="material-icons">refresh</i> <span>Reload Tabel</span> </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <button class="btn-primary" onclick="excel();">Excel</button>
                        <button class="btn-info" onclick="pdf();">PDF</button>
                        <div class="table-responsive">
                            <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid">
                                <thead>
                                <tr>
                                    <th align="center" rowspan="2"><center>Nama Karyawan</th>
                                    <th align="center" rowspan="2"><center>Kartu Keluarga</th>
                                    <th align="center" rowspan="2"><center>KTP</th>
                                    <th align="center" rowspan="2"><center>Akta Lahir</th>
                                    <th align="center" colspan="6"><center>Akta Lahir Keluarga</th>
                                    <th align="center" rowspan="2"><center>Akta Nikah</th>
                                    <th align="center" rowspan="2"><center>NPWP</th>
                                    <th align="center" rowspan="2"><center>Paspor</th>
                                    <th align="center" rowspan="2"><center>SIM</th>
                                    <th align="center" colspan="6"><center>Ijazah</th>
                                    <th align="center" colspan="2"><center>BPJS</th>
                                    <th align="center" rowspan="2"><center>Buku Tabungan</th>
                                </tr>
                                <tr>
                                    <th align="center"><center>Istri</th>
                                    <th align="center"><center>Anak Ke-1</th>
                                    <th align="center"><center>Anak Ke-2</th>
                                    <th align="center"><center>Anak Ke-3</th>
                                    <th align="center"><center>Anak Ke-4</th>
                                    <th align="center"><center>Anak Ke-5</th>
                                    <th align="center"><center>SD</th>
                                    <th align="center"><center>SMP</th>
                                    <th align="center"><center>SMA</th>
                                    <th align="center"><center>D3</th>
                                    <th align="center"><center>S1</th>
                                    <th align="center"><center>S2</th>
                                    <th align="center"><center>Kesehatan</th>
                                    <th align="center"><center>Ketenagakerjaan</th>
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
    $(document).ready(function() {
        table= $('#tabel').DataTable({
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
            order: [], //Initial no order.
            autowidth : true,

            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo base_url('dokumen/ajax_list_formasi')?>" ,
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