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
                            Sisa Cuti Tahunan Karyawan
                        </h2>
                    </div>
                    <div class="body">
                        <button onclick="reload_table();" class="button btn-primary">Reload</button>
                        <br></br>
                        <div id="tabel-hidden">
                            <div class="table-responsive">
                                <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid" >
                                    <thead>
                                    <tr>
                                        <th><center>No.</th>
                                        <th><center>Nama Pegawai</th>
                                        <th><center>Sisa Cuti Tahunan</th>
                                        <th><center>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th><center>No.</th>
                                        <th><center>Nama Pegawai</th>
                                        <th><center>Sisa Cuti Tahunan</th>
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
                <h4 class="modal-title" id="modalLabel">Sisa Cuti</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="myForm">
                    <div class="form-group">
                        <label for="no_surat_cuti"><span class="glyphicon glyphicon-list-alt"></span> Sisa Cuti</label>
                        <input type="hidden" id="id_karyawan" name="id_karyawan">
                        <div class="form-line">
                            <input type="text" class="form-control" name="sisa_cuti" id="sisa_cuti">
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

        if (form) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('cuti/update_sisa_cuti')?>",
                data: $('#myForm').serialize(),
                success: function(response) {
                    alert("Sukses Mengupdate Sisa Cuti");
                    $("#myModal").modal("hide");
                    reload_table();
                },
                error: function() {
                    alert('Error');
                }
            });
        }else{
            alert("Sisa Cuti Harap Di Isi");
            e.preventDefault(); //prevent the default action
        }

        return false;
    });

    $(document).on("click", ".open-AddDialog", function () {
        var id_karyawan = $(this).data('id');
        var sisa_cuti   = $(this).data('cuti');
        $(".modal-body #id_karyawan").val(id_karyawan);
        $(".modal-body #sisa_cuti").val(sisa_cuti);
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    $(document).ready(function() {
        table = $('#tabel').DataTable({
            processing   : true, //Feature control the processing indicator.
            serverSide   : true, //Feature control DataTables' server-side processing mode.
            order        : [], //Initial no order.
            autowidth    : true,
            paging       : true,
            searching    : true,
            responsive   : true,

            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo base_url('cuti/rekap_cuti')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {
                    "targets"   : "all", //first column / numbering column
                    "orderable" : false,
                }
            ]
        });
    });
</script>