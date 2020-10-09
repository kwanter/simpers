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

    .animated {
        animation-duration: 1s;
        animation-fill-mode: backwards;
    }

    .modal {
        text-align: center;
    }

    .modal-dialog {
        text-align: left; /* you'll likely want this */
        max-width: 80%;
        width: auto !important;
        display: inline-block;
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
                            DATA KARYAWAN OUTSOURCING
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a onclick="reload_table();"><i class="material-icons">refresh</i> <span>Reload Tabel</span> </a></li>
                                    <li><a onclick="add();"><i class="material-icons">add</i> <span>Tambah Data</span></a></li>
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
    <div id="theModal" class="modal fade text-center" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3>Data Karyawan Outsourcing</h3>
                </div>
                <div class="modal-body">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Input Data Karyawan Outsourcing</h3> 
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="body">
                                    <form id="form_input_pegawai" action="#" method="POST" enctype="multipart/form-data">
                                        <div class="col-md-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="hidden" name="id_karyawan" id="id_karyawan"/>
                                                    <input id="nik" name="nik" class="form-control" type="text">
                                                    <label for="nik" class="form-label">NIK</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input id="nama_karyawan" name="nama_karyawan" class="form-control" type="text">
                                                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <b>Jenis Kelamin</b><br><br>
                                                <div class="input-group">
                                                    <span>
                                                        <input id="lk" type="radio" class="with-gap" checked value="P" name="jk">
                                                        <label for="lk" class="form-label">Laki - Laki</label>
                                                    </span>
                                                    <span>
                                                        <input id="pr" type="radio" class="with-gap" value="W" name="jk">
                                                        <label for="pr" class="form-label">Perempuan</label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input id="alamat_ktp" name="alamat_ktp" class="form-control" type="text">
                                                    <label for="alamat_ktp" class="form-label">Alamat KTP</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input id="kode_pos_ktp" name="kode_pos_ktp" class="form-control" type="text">
                                                    <label for="kode_pos_ktp" class="form-label">Kode Pos KTP</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input id="kelurahan_ktp" name="kelurahan_ktp" class="form-control" type="text">
                                                    <label for="kelurahan_ktp" class="form-label">Kelurahan KTP</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input id="kecamatan_ktp" name="kecamatan_ktp" class="form-control" type="text">
                                                    <label for="kecamatan_ktp" class="form-label">Kecamatan KTP</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input id="kota_ktp" name="kota_ktp" class="form-control" type="text">
                                                    <label for="kota_ktp" class="form-label">Kota KTP</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input id="provinsi_ktp" name="provinsi_ktp" class="form-control" type="text">
                                                    <label for="provinsi_ktp" class="form-label">Provinsi KTP</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <span>
                                                    <input type="checkbox" class="filled-in" id="pilihan_domisili" name="pilihan_domisili" value="0">
                                                    <label class="form-label" for="pilihan_domisili">Alamat Domisili Sama Dengan Alamat KTP</label>
                                                </span>
                                            </div>
                                        </div>
                                        <div id="domisili">
                                            <div class="col-md-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input id="alamat_domisili" name="alamat_domisili" class="form-control" type="text">
                                                        <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input id="kode_pos_domisili" name="kode_pos_domisili" class="form-control" type="text">
                                                        <label for="kode_pos_domisili" class="form-label">Kode Pos Domisili</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input id="kelurahan_domisili" name="kelurahan_domisili" class="form-control" type="text">
                                                        <label for="kelurahan_domisili" class="form-label">Kelurahan Domisili</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input id="kecamatan_domisili" name="kecamatan_domisili" class="form-control" type="text">
                                                        <label for="kecamatan_domisili" class="form-label">Kecamatan Domisili</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input id="kota_domisili" name="kota_domisili" class="form-control" type="text">
                                                        <label for="kota_domisili" class="form-label">Kota Domisili</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input id="provinsi_domisili" name="provinsi_domisili" class="form-control" type="text">
                                                        <label for="provinsi_domisili" class="form-label">Provinsi Domisili</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input id="tmpt_lahir" required="required" name="tmpt_lahir" class="form-control" type="text">
                                                    <label for="tmpt_lahir" class="form-label">Tempat Lahir</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input id="tgl_lahir" required="required" name="tgl_lahir" class="form-control datepicker" type="text">
                                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input id="no_telp" name="no_telp" class="form-control no_telp" type="text">
                                                    <label for="no_telp" class="form-label">No Telepon</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input id="no_hp" name="no_hp" class="form-control no_hp" type="text">
                                                    <label for="no_hp" class="form-label">No Handphone</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input id="no_hp2" name="no_hp2" class="form-control no_hp" type="text">
                                                    <label for="no_hp2" class="form-label">No Handphone 2</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <b>Agama</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">group_work</i>
                                                </span>
                                                <select required="required" id="agama" name="agama" class="form-control selectpicker show-tick agama">
                                                    <option value="">-----</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <b>Status Nikah</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">supervised_user_circle</i>
                                                </span>
                                                <select required="required" id="status_nikah" name="status_nikah" class="form-control selectpicker show-tick status_nikah">
                                                    <option value="">-----</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input id="jumlah_anak" name="jumlah_anak" class="form-control" type="text">
                                                    <label for="jumlah_anak" class="form-label">Jumlah Anak</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="panel-footer">
                            <button class="btn bg-red waves-effect" onclick="cancel();" type="button"><i class="material-icons">undo</i><span></span></button>
                            <button class="btn bg-blue waves-effect" type="reset"><i class="material-icons">clear</i><span></span></button>
                            <button id="btnSave" type="button" onclick="save();" class="btn bg-orange waves-effect"><i class="material-icons">save</i><span></span></button>
                            <div class="col-xs-10" id="lblstatus"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var table;
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    $('.modal').on('hidden.bs.modal', function () {
        reload_table();
    });

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
                "url": "<?php echo base_url('karyawan/ajax_list')?>",
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

        init_select();

        $(document).on("ajaxComplete", function(e){
            $.AdminBSB.input.activate();
            $.AdminBSB.select.activate();
            $.AdminBSB.search.activate();
            
            $('#theModal').find('.modal-title').text('Input Data Karyawan Outsourcing');

            $('.selectpicker').selectpicker();
            $("#kode_pos_ktp").inputmask("99999",{ "placeholder": "" });
            $("#tgl_lahir").inputmask("9999-99-99",{ "placeholder": "1970-02-01" });

            $('.dropify').dropify({
                messages: {
                    default : 'Drag atau drop untuk memilih gambar',
                    replace : 'Ganti',
                    remove  : 'Hapus',
                    error   : 'error'
                }
            });

            $(function(){
                $('#pilihan_domisili').click(function() {
                    if($(this).is(':checked')){
                        var alamat = $('#alamat_ktp').val();
                        var kode_pos = $('#kode_pos_ktp').val();
                        var kelurahan = $('#kelurahan_ktp').val();
                        var kecamatan = $('#kecamatan_ktp').val();
                        var kota = $('#kota_ktp').val();
                        var provinsi = $('#provinsi_ktp').val();

                        $('#pilihan_domisili').val('1');
                        $('#alamat_domisili').val(alamat);
                        $('#alamat_domisili').parent().addClass("focused");
                        $('#kode_pos_domisili').val(kode_pos);
                        $('#kode_pos_domisili').parent().addClass("focused");
                        $('#kelurahan_domisili').val(kelurahan);
                        $('#kelurahan_domisili').parent().addClass("focused");
                        $('#kecamatan_domisili').val(kecamatan);
                        $('#kecamatan_domisili').parent().addClass("focused");
                        $('#kota_domisili').val(kota);
                        $('#kota_domisili').parent().addClass("focused");
                        $('#provinsi_domisili').val(provinsi);
                        $('#provinsi_domisili').parent().addClass("focused");
                    }else{
                        $('#pilihan_domisili').val('0');
                        $('#alamat_domisili').val('');
                        $('#alamat_domisili').parent().removeClass("focused");
                        $('#kode_pos_domisili').val('');
                        $('#kode_pos_domisili').parent().removeClass("focused");
                        $('#kelurahan_domisili').val('');
                        $('#kelurahan_domisili').parent().removeClass("focused");
                        $('#kecamatan_domisili').val('');
                        $('#kecamatan_domisili').parent().removeClass("focused");
                        $('#kota_domisili').val('');
                        $('#kota_domisili').parent().removeClass("focused");
                        $('#provinsi_domisili').val('');
                        $('#provinsi_domisili').parent().removeClass("focused");
                    }
                });

                var form = $('#form_input_pegawai');
                
                form.find('.no_telp').inputmask('9999-9999999', { placeholder: '____-_______' });
                form.find('.no_hp').inputmask('9999-9999-9999', { placeholder: '____-____-____' });
                form.find('.email').inputmask({alias :"email"});
            });
        });
    });

    function add(){
        save_method = 'add';
        $('#form_input_pegawai')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#btnSave').text('Save');
        $('#theModal').modal('show');
        $('.selectpicker').selectpicker('refresh');
        $('.modal-title').text('Tambah Data Karyawan Outsourcing'); // Set title to Bootstrap modal title
    }

    function batal(){
        $('#form_input_pegawai')[0].reset();
        $('#btnSave').text('Save'); //change button text
        $('#btnSave').attr('class','btn btn-primary'); //set button disable 
        $('#md-form').modal('hide');
    }

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function alamat_ktp(id) {
        $('#form_alamat')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('karyawan/getAlamatLengkap')?>/" + id,
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
            url : "<?php echo site_url('karyawan/getAlamatLengkap')?>/" + id,
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
                    url : "<?php echo site_url('karyawan/delete')?>/"+id,
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

    function init_select(){
        //Unit Select Box
        let dropdown_agama = $('#agama');
        dropdown_agama.empty();
        dropdown_agama.append('<option value="">Pilih Agama</option>');
        dropdown_agama.prop('selectedIndex', 0);
        const url_agama = '<?php echo base_url('karyawan/getPilihanData/agama');?>';

        // Populate dropdown with list
        $.getJSON(url_agama, function (data) {
            $.each(data, function (key, entry) {
                dropdown_agama.append($('<option></option>').attr('value', entry.subID).text(entry.value));
            })
        });

        //Unit Select Box
        let dropdown_status_nikah = $('#status_nikah');
        dropdown_status_nikah.empty();
        dropdown_status_nikah.append('<option value="">Pilih Status Nikah</option>');
        dropdown_status_nikah.prop('selectedIndex', 0);
        const url_status_nikah = '<?php echo base_url('karyawan/getPilihanData/status_nikah');?>';

        // Populate dropdown with list
        $.getJSON(url_status_nikah, function (data) {
            $.each(data, function (key, entry) {
                dropdown_status_nikah.append($('<option></option>').attr('value', entry.subID).text(entry.value));
            })
        });
    }

</script>

<script type="text/javascript">
    var save_method; //for save method string

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function save(){
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        
        $('#btnUpdate').text('Updating...'); //change button text
        $('#btnUpdate').attr('disabled',true); //set button disable 
        
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('karyawan/ajax_add/');?>";
        } else {
            url = "<?php echo site_url('karyawan/ajax_update');?>";
        }
        
        formData = new FormData($('#form_input_pegawai')[0]);
        formData.append( 'save_method', save_method );    
        
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(data){
                //if success close modal and reload ajax table
                if(data.status){
                    reload_table();
                    alert(data.info);
                    $('#form_input_pegawai')[0].reset();
                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                    $('#theModal').modal('hide');
                }
                else{
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                    alert(data.info);
                }
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
                $('#btnUpdate').text('Update'); //change button text
                $('#btnUpdate').attr('disabled',false); //set button enable 
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error adding data');
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
                $('#btnUpdate').text('Update'); //change button text
                $('#btnUpdate').attr('disabled',false); //set button enable 
            }
        });
    }

    function edit(id){
        save_method = 'update';
        $('#form_input_pegawai')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#btnSave').text('Update');
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('karyawan/ajax_edit/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {		
                $('[name="id_karyawan"]').val(id);
                $('[name="nik"]').val(data.nik);
                $('[name="nama_karyawan"]').val(data.nama_karyawan);
                $("input[name=jk][value=" + data.jenis_kelamin + "]").prop('checked', true);
                $('[name="alamat_ktp"]').val(data.alamat_ktp);
                $('[name="kode_pos_ktp"]').val(data.kode_pos_ktp);
                $('[name="kelurahan_ktp"]').val(data.kelurahan_ktp);
                $('[name="kecamatan_ktp"]').val(data.kecamatan_ktp);
                $('[name="kota_ktp"]').val(data.kota_ktp);
                $('[name="provinsi_ktp"]').val(data.provinsi_ktp);
                $('[name="alamat_domisili"]').val(data.alamat_domisili);
                $('[name="kode_pos_domisili"]').val(data.kode_pos_domisili);
                $('[name="kelurahan_domisili"]').val(data.kelurahan_domisili);
                $('[name="kecamatan_domisili"]').val(data.kecamatan_domisili);
                $('[name="kota_domisili"]').val(data.kota_domisili);
                $('[name="provinsi_domisili"]').val(data.provinsi_domisili);
                $('[name="tmpt_lahir"]').val(data.tmpt_lahir);
                $('[name="tgl_lahir"]').val(data.tgl_lahir);
                $('[name="no_telp"]').val(data.no_telp);
                $('[name="no_hp"]').val(data.no_hp);
                $('[name="no_hp2"]').val(data.no_hp_2);
                $('[name="agama"]').val(data.agama).change();
                $('[name="status_nikah"]').val(data.status_nikah).change();
                $('[name="jumlah_anak"]').val(data.jmlh_anak);

                $('.selectpicker').selectpicker('refresh');

                $('#theModal').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data Karyawan OC'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function del(id) {
        swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: 'Anda Tidak Akan Bisa Merecover Kembali Data Yang Sudah Anda Hapus !',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((willDelete) => {
            if (willDelete.value) {
                $.ajax({
                    url : "<?php echo site_url('karyawan/delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        swal.fire('Terhapus','Data Anda Sudah Dihapus','success');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire("Gagal","Data Anda Tidak Jadi Dihapus","error");
                    }
                });
            } else {
                swal.fire("Batal","Data Anda Tidak Jadi Dihapus","warning");
            }
        });
    }

    function cancel() {
        save_method_doc = 'add';
        $('#form_input_pegawai')[0].reset();
        $('#btnSave').text('Save'); //change button text
        $('#btnSave').attr('class','btn btn-primary'); //set button disable 
        $('#theModal').modal('hide');
    }

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

</script>