<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2><center>Riwayat Diklat Karyawan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="container">
                <button class="btn btn-success" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
            </div>
            <div class="container">
                <div class="row">
                    <div class="container">
                        <div class="container">
                            <form id="form-input" action="#" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                <div class="form-group">
                                    <br>
                                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="nik">NIK <span class="required"></span>
                                    </label>
                                    <div class="col-md-3 col-sm-4 col-xs-8">
                                        <select id="nik" name="nik" required="required" class="form-control col-md-5 col-xs-8">
                                            <?php
                                            foreach ($attr['karyawan'] as $karyawan){
                                                ?>
                                                <option value="<?php echo $karyawan->id_karyawan ?>"><?php echo $karyawan->nik ?> => <?php echo $karyawan->nama_karyawan ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button id="generate" class="btn btn-info" href="javascript:void(0)" onclick="tampil();return false;"><i class="glyphicon glyphicon-folder-open"></i> Tampilkan</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <div id="tabel-hidden" hidden="hidden">
                                <table id="tabel" class="table table-striped jambo_table table-bordered" cellspacing="0" width="100%" >
                                    <thead>
                                    <tr>
                                        <th><center>Nama Karyawan</th>
                                        <th><center>Jenis Diklat</th>
                                        <th><center>Tanggal Mulai</th>
                                        <th><center>Tanggal Akhir</th>
                                        <th><center>Durasi Diklat</th>
                                        <th><center>Tema Diklat</th>
                                        <th><center>Penyelenggara</th>
                                        <th><center>No Sertifikat</th>
                                        <th><center>Nilai</th>
                                        <th><center>Skala Nilai</th>
                                        <th><center>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th><center>Nama Karyawan</th>
                                        <th><center>Jenis Diklat</th>
                                        <th><center>Tanggal Mulai</th>
                                        <th><center>Tanggal Akhir</th>
                                        <th><center>Durasi Diklat</th>
                                        <th><center>Tema Diklat</th>
                                        <th><center>Penyelenggara</th>
                                        <th><center>No Sertifikat</th>
                                        <th><center>Nilai</th>
                                        <th><center>Skala Nilai</th>
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
</div>

<script type="text/javascript">
    var table;

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add() {
        window.location.replace('<?php echo site_url('diklat')?>');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('diklat/edit/')?>'+id);
    }

    function tampil() {
        var id = $('#nik').val();
        $('#tabel-hidden').removeAttr('hidden');
        $.fn.dataTable.ext.errMode = 'none';

        table = $('#tabel').on( 'error.dt', function ( e, settings, techNote, message ) {
            console.log( 'An error has been reported by DataTables: ', message );
        }).DataTable({
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
            order: [], //Initial no order.
            autowidth : true,
            paging : false,
            searching : false,
            lengthChange : false,
            drawCallback : function( settings ) {
                $('#generate').prop('disabled', false);
            },
            destroy           : true,
            iDisplayLength   : "all",

            // Load data for the table's content from an Ajax source
            ajax: {
                "url"       : "<?php echo base_url('diklat/ajax_list')?>",
                "type"      : "POST",
                "dataType"  : "JSON",
                "data"      : {
                    id : id,
                },
                'beforeSend': function () {
                    $('#generate').prop('disabled', true);
                },
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {
                    "targets": [ 0 ,-1,-2,-3,-4,-5,-6,-7,-8,-9,-10], //first column / numbering column
                    "orderable" : false
                },
            ],
        });
    }

    function del(id) {
        if(confirm('Anda Yakin Ingin Menghapus Data Ini ?')) {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('diklat/delete')?>/"+id,
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