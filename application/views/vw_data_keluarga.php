<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="right_col" role="main">
    <div class="x_panel">
        <div class="x_title">
            <h2><center>Data Keluarga</h2>
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
                                        <th><center>Nama Keluarga</th>
                                        <th><center>Hubungan Keluarga</th>
                                        <th><center>Tempat Lahir</th>
                                        <th><center>Tanggal Lahir</th>
                                        <th><center>Jenis Kelamin</th>
                                        <th><center>Suku</th>
                                        <th><center>Agama</th>
                                        <th><center>Alamat</th>
                                        <th><center>No Handphone</th>
                                        <th><center>Pekerjaan</th>
                                        <th><center>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th><center>Nama Keluarga</th>
                                        <th><center>Hubungan Keluarga</th>
                                        <th><center>Tempat Lahir</th>
                                        <th><center>Tanggal Lahir</th>
                                        <th><center>Jenis Kelamin</th>
                                        <th><center>Suku</th>
                                        <th><center>Agama</th>
                                        <th><center>Alamat</th>
                                        <th><center>No Handphone</th>
                                        <th><center>Pekerjaan</th>
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
    
    function reload_table() {
        table.ajax.reload(null,false);
    }
    
    function add() {
        window.location.replace('<?php echo site_url('keluarga')?>');
    }

    function edit(id) {
        window.location.replace('<?php echo site_url('keluarga/edit/')?>'+id);
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
                "url": "<?php echo base_url('keluarga/ajax_list')?>",
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
                    "targets": [ 0 ,1,2,3,4,5,6,7,8,9,10], //first column / numbering column
                    "orderable" : false
                },
            ],
        });
    }

    function del(id) {
        if(confirm('Anda Yakin Ingin Menghapus Data Ini ?')) {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('keluarga/delete')?>/"+id,
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

    function alamat(id) {
        $('#form_alamat')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('keluarga/getAlamatLengkap')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="alamat"]').val(data.alamat);
                $('[name="kelurahan"]').val(data.kelurahan);
                $('[name="kecamatan"]').val(data.kecamatan);
                $('[name="kota"]').val(data.kota);
                $('[name="provinsi"]').val(data.provinsi);
                $('[name="kode_pos"]').val(data.kode_pos);
                $('#modal_alamat').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Alamat Lengkap'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Mengambil Data Dari Ajax');
            }
        });
    }
</script>