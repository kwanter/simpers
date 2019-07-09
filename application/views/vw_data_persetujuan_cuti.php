<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content">
    <div class="container-fluid">
        <!-- Horizontal Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Persetujuan Cuti Pegawai
                        </h2>
                    </div>
                    <div class="body">
                        <button class="btn btn-info" onclick="reload_table();"><i class="material-icons">refresh</i> <span>Reload Tabel</span></button>
                        <br><br>
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
        <!-- #END# Horizontal Layout -->
    </div>
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-col-blue">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modalLabel">Persetujuan Cuti</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="myForm">
                    <div class="form-group">
                        <label for="disetujui"><span class="glyphicon glyphicon-list-alt"></span> Disetujui</label>
                        <select required id="disetujui" name="disetujui" class="form-control show-tick">
                            <option value="0" selected>Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_surat_cuti"><span class="glyphicon glyphicon-list-alt"></span> No Surat Cuti</label>
                        <input type="hidden" id="id_cuti" name="id_cuti">
                        <div class="form-line">
                            <input type="text" disabled class="form-control" name="no_surat_cuti" id="no_surat_cuti" placeholder="Masukkan No Surat Cuti Disini">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_dokumen_surat"><span class="glyphicon glyphicon-list-alt"></span> Tanggal Surat Cuti Akan Di Cetak</label>
                        <div class="form-line">
                            <input type="text" disabled class="form-control" name="tgl_dokumen_surat" id="tgl_dokumen_surat">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jabatan" class="form-label">Pejabat Yang Menandatangani</label>
                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">title</i>
                                    </span>
                            <div class="form-line">
                                <select disabled title="Pilih Pejabat Yang Menandatangani" id="pejabat_ttd" name="pejabat_ttd" class="selectpicker form-control show-tick" data-live-search="true"></select>
                            </div>
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
    var request;

    $(document).on('click', '#submit', function(e) {
        var form = true;
        if(!$("#no_surat_cuti").prop('disabled')){
            if($("#no_surat_cuti").val() == "" || $("#tgl_dokumen_surat").val() == "" || !$('#pejabat_ttd').val() ){
                form = false;
            }
        } 

        if (form) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('cuti/persetujuan')?>",
                data: $('#myForm').serialize(),
                beforeSend: function() {
                    $("#submit").attr("disabled", true);
                },
                success: function(response) {
                    alert("Sukses Mengupdate Izin Cuti");
                    $("#submit").attr("disabled", false);
                    $('#disetujui').selectpicker('val','0');
                    refresh_select();
                    DisableAttr();
                    $("#myModal").modal("hide");
                    reload_table();
                },
                error: function() {
                    alert('Error');
                }
            });
        }
        else if($("#no_surat_cuti").val() == "" && ($("#tgl_dokumen_surat").val() != "" || $('#pejabat_ttd').val() )){
            alert("No Surat Cuti Harap Di Isi");
            e.preventDefault(); //prevent the default action
        }
        else if($("#tgl_dokumen_surat").val() == "" && ( $("#no_surat_cuti").val() != "" || $('#pejabat_ttd').val() )){
            alert("Tanggal Dokumen Surat Cuti Harap Di Isi");
            e.preventDefault(); //prevent the default action
        }
        else if(!$('#pejabat_ttd').val() && ($("#no_surat_cuti").val() != "" || $("#tgl_dokumen_surat").val() != "") ) {
            alert("Pejabat TTD Harap Di Isi");
            e.preventDefault(); //prevent the default action
        }
        else{
            alert("Harap Mengisi Ketiga Kolom");
            e.preventDefault(); //prevent the default action
        }
        
        return false;
    });

    $(document).on("click", ".open-AddDialog", function () {
        //var color = $(this).data('color');
        //$('#myModal .modal-content').removeAttr('class').addClass('modal-content modal-col-' + color);
        var url = "<?php echo base_url('cuti/getNamaPejabat')?>";
        $.getJSON(url, function(json){
            $('#pejabat_ttd').html('');
            $.each(json, function(index, row) {
                $('#pejabat_ttd').append('<option value='+row.id_karyawan+'>'+row.nama_karyawan+'</option>');
            });
            refresh_select();
        });
        var id_cuti = $(this).data('id');
        $(".modal-body #id_cuti").val(id_cuti);
        $("#radio_1").prop("checked", false);
        $("#radio_2").prop("checked", true);
    });

    $(document).ready(function(){
        table= $('#tabel').DataTable({
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
            order: [], //Initial no order.
            autowidth : true,

            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo site_url('cuti/ajax_list_persetujuan')?>" ,
                "type": "POST",
            },
        });
    });

    $('#disetujui').on('change', function (e) {
        var optionSelected = $(this).find("option:selected");
        var valueSelected  = optionSelected.val();

        if(valueSelected == "1"){
            EnableAttr();
        }
        else{
            DisableAttr();
        }
        refresh_select();
    });

    function EnableAttr(){
        $("#no_surat_cuti").prop("required",true);
        $("#no_surat_cuti").prop("disabled",false);
        $("#tgl_dokumen_surat").prop("required",true);
        $("#tgl_dokumen_surat").prop("disabled",false);
        $("#pejabat_ttd").prop("required",true);
        $("#pejabat_ttd").prop("disabled",false);
    }

    function DisableAttr(){
        $("#no_surat_cuti").prop("required",false);
        $("#no_surat_cuti").prop("disabled",true);
        $("#no_surat_cuti").val("");
        $("#tgl_dokumen_surat").prop("required",false);
        $("#tgl_dokumen_surat").prop("disabled",true);
        $("#tgl_dokumen_surat").val("");
        $("#pejabat_ttd").prop("required",false);
        $("#pejabat_ttd").prop("disabled",true);
    }

    $('#tgl_dokumen_surat').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function refresh_select(){
        $('.selectpicker').selectpicker('refresh');
        $('.selectpicker').selectpicker('render');
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

    function printx(id) {
        window.open('<?php echo site_url('cuti/surat_cuti/')?>'+id,'_blank');
        window.focus();
    }

    function tampil() {
        var id = $('#nik').val();
        $('#tabel-hidden').removeAttr('hidden');
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
                    url : "<?php echo site_url('cuti/delete')?>/"+id,
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