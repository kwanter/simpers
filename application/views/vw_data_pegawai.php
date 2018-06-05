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
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2><center>Data Karyawan</h2>
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
                                    <th width="2%"><center>ID</th>
                                    <th width="3%"><center>NIK</th>
                                    <th width="12%"><center>Nama Karyawan</th>
                                    <th width="15%"><center>Tmpt Lahir</th>
                                    <th width="13%"><center>Tgl Lahir</th>
                                    <th width="5%"><center>J.K.</th>
                                    <th width="5%"><center>Agama</th>
                                    <th width="10%"><center>No Telp</th>
                                    <th width="10%"><center>No HP</th>
                                    <th width="10%"><center>Email</th>
                                    <th width="5%"><center>Status Nikah</th>
                                    <th width="10%"><center>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><center>ID</th>
                                    <th><center>NIK</th>
                                    <th><center>Nama Karyawan</th>
                                    <th><center>Tmpt Lahir</th>
                                    <th><center>Tgl Lahir</th>
                                    <th><center>J.K.</th>
                                    <th><center>Agama</th>
                                    <th><center>No Telp</th>
                                    <th><center>No HP</th>
                                    <th><center>Email</th>
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
    </div>
</div>

<div class="modal fade" id="modal_alamat" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Alamat Lengkap</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_alamat" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9">
                                <input disabled name="alamat" id="alamat" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kelurahan</label>
                            <div class="col-md-9">
                                <input disabled name="kelurahan" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kecamatan</label>
                            <div class="col-md-9">
                                <input disabled name="kecamatan" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kota</label>
                            <div class="col-md-9">
                                <input disabled name="kota" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Provinsi</label>
                            <div class="col-md-9">
                                <input disabled name="provinsi" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Pos</label>
                            <div class="col-md-9">
                                <input disabled name="kode_pos" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                        columns: [1,2,3,4,5,6,7,8,9,10,11]
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
                        columns: [1,2,3,4,5,6,7,8,9,10,11]
                    }
                },
            ],

            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo base_url('pegawai/ajax_list')?>",
                "type": "POST",
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {
                    "targets"   : [ 0 ], //first column / numbering column
                    "orderable" : false
                },
                {
                    "targets"   : [ -10 ], //first column / numbering column
                    "orderable" : false
                },
                {
                    "targets"   : [ -1 ], //first column / numbering column
                    "orderable" : false
                },
                {
                    "targets"   : [ -2,-3,-4,-5,-6,-7,-8,-9,-11], //first column / numbering column
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
        if(confirm('Anda Yakin Ingin Menghapus Data Ini ?')) {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('pegawai/delete')?>/"+id,
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