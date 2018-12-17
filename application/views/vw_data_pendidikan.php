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
                            Riwayat Pendidikan
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <!---<li><a onclick="reload_table();"><i class="material-icons">refresh</i> <span>Reload Tabel</span> </a></li>--->
                                    <li><a onclick="add()"><i class="material-icons">add</i> <span>Tambah Data</span></a></li>
                                    <!---<li><a onclick="edit()"><i class="material-icons">mode_edit</i><span>Ubah Data</span> </a></li>--->
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form id="form-input" action="#">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="nik"><span>NIK </span></label>
                                    <select id="nik" name="nik" required="required" class="form-control">
                                        <?php
                                        foreach ($attr['karyawan'] as $karyawan){
                                            ?>
                                            <option value="<?php echo $karyawan->id_karyawan ?>"><?php echo $karyawan->nik ?> => <?php echo $karyawan->nama_karyawan ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button class="btn bg-cyan" id="generate" href="javascript:void(0)" onclick="tampil();return false;"><i class="material-icons">view_list</i><span>Tampilkan</span></button>
                        </form>
                        <div id="tabel-hidden" hidden="hidden">
                            <div class="table-responsive">
                                <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid" >
                                    <thead>
                                    <tr>
                                        <th><center>Nama Karyawan</th>
                                        <th><center>Jenjang Pendidikan</th>
                                        <th><center>Nama Jurusan</th>
                                        <th><center>Peminatan</th>
                                        <th><center>Asal Lembaga Pendidikan</th>
                                        <th><center>Asal Kota</th>
                                        <th><center>Tahun Kelulusan</th>
                                        <th><center>Nilai Kelulusan</th>
                                        <th><center>Skala Nilai</th>
                                        <th><center>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th><center>Nama Karyawan</th>
                                        <th><center>Jenjang Pendidikan</th>
                                        <th><center>Nama Jurusan</th>
                                        <th><center>Peminatan</th>
                                        <th><center>Asal Lembaga Pendidikan</th>
                                        <th><center>Asal Kota</th>
                                        <th><center>Tahun Kelulusan</th>
                                        <th><center>Nilai Kelulusan</th>
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
        <!-- #END# Horizontal Layout -->
    </div>
</section>

<script type="text/javascript">
    var table;

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add() {
        window.location.replace('<?php echo site_url('pendidikan')?>');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('pendidikan/edit/')?>'+id);
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
                "url": "<?php echo base_url('pendidikan/ajax_list')?>",
                "type": "POST",
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
                    "targets": [ 0 ,-1,-2,-3,-4,-5,-6,-7,-8,-9], //first column / numbering column
                    "orderable" : false
                },
                {
                    "targets": [ -1,-2,-4 ], //first column / numbering column
                    "width" : "10%"
                },
            ],
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
                    url : "<?php echo site_url('pendidikan/delete')?>/"+id,
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