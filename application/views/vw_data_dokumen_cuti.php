<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Cetak Dokumen Cuti Karyawan
                        </h2>
                    </div>
                    <div class="body">
                        <form id="form-input" action="#">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="nik"><span>NIK </span></label>
                                    <select id="nik" name="nik" required="required" class="form-control" data-live-search="true">
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
        </div>
        <!-- #END# Horizontal Layout -->
    </div>
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-col-blue">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modalLabel">Update Tanggal Cuti</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="myForm">
                    <div class="form-group">
                        <label for="no_surat_cuti"><span class="glyphicon glyphicon-list-alt"></span> Tanggal Surat Cuti Akan Di Cetak</label>
                        <input type="hidden" id="id_cuti" name="id_cuti">
                        <div class="form-line">
                            <input type="text" class="form-control" name="tgl_dokumen_surat" id="tgl_dokumen_surat" >
                        </div>
                    </div>
                    <button id="submit" type="button" class="btn btn-success">Submit</button>
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

    $(document).on('click', '#submit', function(e) {
        var form = true;

        if($("#tgl_dokumen_surat").val() == "")
            form = false;

        if (form) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('cuti/update_tgl_surat')?>",
                data: $('#myForm').serialize(),
                beforeSend: function() {
                    $("#submit").attr("disabled", true);
                },
                success: function(response) {
                    alert("Sukses Mengupdate Tanggal Surat Cuti");
                    $("#submit").attr("disabled", false);
                    $("#myModal").modal("hide");
                    reload_table();
                },
                error: function() {
                    alert('Error');
                }
            });
        }else{
            alert("No Surat Cuti Harap Di Isi");
            e.preventDefault(); //prevent the default action
        }

        return false;
    });

    $(document).on("click", ".open-AddDialog", function () {
        //var color = $(this).data('color');
        //$('#myModal .modal-content').removeAttr('class').addClass('modal-content modal-col-' + color);
        var id_cuti = $(this).data('id');
        var tgl     = $(this).data('tgl');
        $(".modal-body #id_cuti").val(id_cuti);
        $(".modal-body #tgl_dokumen_surat").val(tgl);
    });

    $('#tgl_dokumen_surat').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
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

     function xprint(id) {
        window.open('<?php echo site_url('cuti/surat_cuti/')?>'+id,'_blank');
        window.focus();
    }

    function tampil() {
        var id = $('#nik').val();
        $('#tabel-hidden').removeAttr('hidden');
        $.fn.dataTable.ext.errMode = 'none';

        table = $('#tabel').on( 'error.dt', function ( e, settings, techNote, message ) {
            console.log( 'An error has been reported by DataTables: ', message );
        }).DataTable({
            processing   : true, //Feature control the processing indicator.
            serverSide   : true, //Feature control DataTables' server-side processing mode.
            order        : [], //Initial no order.
            autowidth    : true,
            paging       : false,
            searching    : false,
            lengthChange : false,
            drawCallback : function( settings ) {
                $('#generate').prop('disabled', false);
            },
            destroy           : true,
            iDisplayLength   : "all",

            // Load data for the table's content from an Ajax source
            ajax: {
                "url"       : "<?php echo base_url('cuti/riwayat_cuti')?>",
                "type"      : "POST",
                "dataType"  : "JSON",
                "data"      : {
                    id : id
                },
                'beforeSend': function () {
                    $('#generate').prop('disabled', true);
                },
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {
                    "targets": "all", //first column / numbering column
                    "orderable" : false
                }
            ]
        });
    }
</script>