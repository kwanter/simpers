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
                        <h2 class="judul">
                            Data Jenis Diklat
                        </h2>
                    </div>
                    <div class="body">
                        <form id="form-input" action="<?php echo base_url('diklat/add_data')?>" method="POST" class="form-horizontal form-label-left">
                            <div class="col-md-12">
                                <label for="jenis_diklat">Jenis Diklat</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="hidden" value="" id="id_jenisdiklat" name="id_jenisdiklat"/>
                                        <input type="text" class="form-control" name="jenis_diklat" id="jenis_diklat">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button class="btn bg-blue waves-effect" type="reset"><i class="material-icons">clear</i><span>Reset</span></button>
                            <button type="submit" class="btn bg-orange waves-effect"><i class="material-icons">save</i><span>Simpan</span></button>
                        </form>
                        <div class="table-responsive">
                            <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid" >
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
        <!-- #END# Horizontal Layout -->
    </div>
</section>

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
                        swal("Sukses !", "Data Berhasil Disimpan", "success");
                        $('#id_jenisdiklat').val('');
                        $('#jenis_diklat').val('');
                        $( "h2.judul" ).replaceWith( "<h2 class='judul'>Penambahan Data</h2>" );
                        $('#form-input').attr({"action" : "<?php echo site_url('diklat/add_data')?>" });
                        reload_table();
                    }
                    else{
                        swal("Gagal !", "Data Gagal Disimpan", "error");
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
            $( "h2.judul" ).replaceWith( "<h2 class='judul'>Penambahan Data</h2>" );
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
                $( "h2.judul" ).replaceWith( "<h2 class='judul'>Pengeditan Data</h2>" );
                $('#form-input').attr({"action" : "<?php echo site_url('diklat/update_data')?>" });
            },
            error    : function (jqXHR, textStatus, errorThrown) {
                swal("Gagal !", "Data Gagal Diambil", "error");
            }
        });
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
                    url : "<?php echo site_url('diklat/delete_data')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        swal("Sukses !", "Data Sukses Di Hapus", "success");
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("Gagal !", "Data Gagal Di Hapus", "error");
                    }
                });
            } else {
                swal("Dibatalkan", "Data Anda Tidak Jadi Dihapus", "error");
            }
        });
    }
</script>