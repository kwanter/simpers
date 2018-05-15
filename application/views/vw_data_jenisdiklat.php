<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2><center>Data Jenis Diklat</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <h3 class="judul">Penambahan Data</h3>
            <div class="ln_solid"></div>
            <form id="form-input" data-parsley-validate="" action="<?php echo base_url('diklat/add_data')?>" method="POST" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_diklat">Jenis Diklat <span class="required">
                        <input type="hidden" value="" id="id_jenisdiklat" name="id_jenisdiklat"/>
                    </label>
                    <input type="text" class="col-md-3 col-sm-4 col-xs-8" name="jenis_diklat" id="jenis_diklat">
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-4 col-sm-4 col-xs-6 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" id="submit" name="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="container">
                    <div class="table-responsive">
                        <table id="tabel" class="table table-striped jambo_table table-bordered" cellspacing="0" width="100%" >
                            <thead>
                            <tr>
                                <th><center>No</th>
                                <th><center>Jenis Diklat</th>
                                <th><center>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th><center>No</th>
                                <th><center>Jenis Diklat</th>
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

<script type="text/javascript">
    var table;

    $(document).ready(function () {
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
            destroy           : true,
            iDisplayLength   : "all",

            // Load data for the table's content from an Ajax source
            ajax: {
                "url"       : "<?php echo base_url('diklat/list_jenisdk')?>",
                "type"      : "POST"
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {
                    "targets": [ 0 ,-1,-2], //first column / numbering column
                    "orderable" : false
                },
                {
                    "targets": [ -1], //first column / numbering column
                    "width" : "10%"
                },
                {
                    "targets": [ 0 ], //first column / numbering column
                    "width" : "5%"
                }
            ]
        });
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    $(function () {
        $('#form-input').on('submit', function(e){
            // ambil semua data yang ada di form dengan serialize()
            $data = $(this).serialize();
            // ambil url yang sudah di rubah pada attribute action
            $url = $(this).attr('action');
            // gunakan ajax untuk mengirim data
            // disini saya manggunakan JSON untuk mendapatkan response nya
            $.ajax({
                'type'      : 'POST',
                'dataType'  : 'JSON',
                'data'      : $data,
                'url'       : $url,
                'beforeSend': function(){
                    // proses sebelum mengirim data
                },
                'success': function(response){
                    // proses saat data berhasil di kirim
                    if(response.error == false){
                        new PNotify({
                            title: 'Success',
                            text: 'Data Berhasil Di Disimpan',
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        $('#id_jenisdiklat').val('');
                        $('#jenis_diklat').val('');
                        $( "h3.judul" ).replaceWith( "<h3 class='judul'>Penambahan Data</h3>" );
                        $('#form-input').attr({"action" : "<?php echo site_url('diklat/add_data')?>" });
                        reload_table();
                    }
                    else{
                        new PNotify({
                            title: 'Oh No!',
                            text: 'Data Gagal Di Hapus',
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    }
                }
            });
            // tahan form agar tidak berpindah halaman
            e.preventDefault();
        });
    });

    $(function () {
        $('#form-input').on('reset', function(e){
            $('#id_jenisdiklat').val('');
            $('#jenis_diklat').val('');
            $( "h3.judul" ).replaceWith( "<h3 class='judul'>Penambahan Data</h3>" );
            $('#form-input').attr({"action" : "<?php echo site_url('diklat/add_data')?>" });
            e.preventDefault();
        });
    });

    function edit(id) {
        $.ajax({
            url      : "<?php echo site_url('diklat/get_data')?>/"+id,
            type     : "POST",
            dataType : "JSON",
            success  : function (data) {
                $('#id_jenisdiklat').val(data.id_jenisdiklat);
                $('#jenis_diklat').val(data.jenis_diklat);
                $( "h3.judul" ).replaceWith( "<h3 class='judul'>Pengeditan Data</h3>" );
                $('#form-input').attr({"action" : "<?php echo site_url('diklat/update_data')?>" });
            },
            error    : function (jqXHR, textStatus, errorThrown) {
                new PNotify({
                    title: 'Oh No!',
                    text: 'Gagal Mengambil Data',
                    type: 'error',
                    styling: 'bootstrap3'
                });
            }
        });
    }

    function del(id) {
        if(confirm('Anda Yakin Ingin Menghapus Data Ini ?')) {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('diklat/delete_data')?>/"+id,
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