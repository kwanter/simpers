<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<style>
    .th1{
        width: 15% !important;
    }
    .th2{
        width: 20% !important;
    }
</style>

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
                            DATA KARYAWAN
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a onclick="reload_table();"><i class="material-icons">refresh</i> <span>Reload Tabel</span> </a></li>
                                    <li><a onclick="add()"><i class="material-icons">add</i> <span>Tambah Data</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid" >
                                <thead>
                                <tr>
                                    <th><center>NIK</th>
                                    <th><center>Nama Karyawan</th>
                                    <th><center>Tmpt Lahir</th>
                                    <th><center>Tgl Lahir</th>
                                    <th><center>J.K.</th>
                                    <th><center>Agama</th>
                                    <th><center>Status Nikah</th>
                                    <th><center>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><center>NIK</th>
                                    <th><center>Nama Karyawan</th>
                                    <th><center>Tmpt Lahir</th>
                                    <th><center>Tgl Lahir</th>
                                    <th><center>J.K.</th>
                                    <th><center>Agama</th>
                                    <th><center>Status Nikah</th>
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
<script type="text/javascript">
    var table;

    $(document).ready(function() {
        table = $('#tabel').DataTable({
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
            order: [], //Initial no order.
            autowidth : true,
            responsive: true,
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
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    customize: function (doc) {
                        doc.defaultStyle.fontSize = 9;
                    },
                    className: "btn-sm",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
                },
            ],

            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo base_url('pegawai/ajax_list')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {
                    "targets"   : [ 0,-1,-2,-3,-4,-5,-6,-7], //first column / numbering column
                    "orderable" : false,
                }
            ]
        });
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add() {
        window.location.replace('<?php echo site_url('pegawai')?>');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('pegawai/edit/')?>'+id);
    }

    function alamat_ktp(id) {
        $('#form_alamat')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('pegawai/getAlamatLengkap')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="alamat"]').val(data.alamat_ktp);
                $('[name="kelurahan"]').val(data.kelurahan_ktp);
                $('[name="kecamatan"]').val(data.kecamatan_ktp);
                $('[name="kota"]').val(data.kota_ktp);
                $('[name="provinsi"]').val(data.provinsi_ktp);
                $('[name="kode_pos"]').val(data.kode_pos_ktp);
                $('#modal_alamat').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Alamat KTP Lengkap'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Mengambil Data Dari Ajax');
            }
        });
    }

    function alamat_domisili(id) {
        $('#form_alamat')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('pegawai/getAlamatLengkap')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="alamat"]').val(data.alamat_domisili);
                $('[name="kelurahan"]').val(data.kelurahan_domisili);
                $('[name="kecamatan"]').val(data.kecamatan_domisili);
                $('[name="kota"]').val(data.kota_domisili);
                $('[name="provinsi"]').val(data.provinsi_domisili);
                $('[name="kode_pos"]').val(data.kode_pos_domisili);
                $('#modal_alamat').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Alamat Domisili Lengkap'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Mengambil Data Dari Ajax');
            }
        });
    }

    function cetak_cv(id) {
        window.open('<?php echo base_url('pegawai/cetak_cv/')?>' + id,'_blank');
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
                    url : "<?php echo site_url('pegawai/delete')?>/"+id,
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