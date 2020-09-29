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
                                    <li><a href="<?php echo site_url('karyawan')?>" data-toggle="modal" data-target="#theModal"><i class="material-icons">add</i> <span>Tambah Data</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable" cellspacing="0" width="100%" role="grid" >
                                <thead>
                                <tr>
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
            <div class="modal-content"></div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var table;

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

        $("#nik").inputmask("KKT9999999",{ "placeholder": "" });
        $("#nipp").inputmask("9999999",{ "placeholder": "" });
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
                $('#alamat_domisili').val("required");
                $('#kode_pos_domisili').val("required");
                $('#kelurahan_domisili').val("required");
                $('#kecamatan_domisili').val("required");
                $('#kota_domisili').val("required");
                $('#provinsi_domisili').removeAttr("required");
            }else{
                $('#pilihan_domisili').val('0');
                $('#alamat_domisili').val(alamat);
                $('#kode_pos_domisili').val(kode_pos);
                $('#kelurahan_domisili').val(kelurahan);
                $('#kecamatan_domisili').val(kecamatan);
                $('#kota_domisili').val(kota);
                $('#provinsi_domisili').val(provinsi);
            }
        });

        var form = $('#form_input_pegawai');
        
        form.find('.no_telp').inputmask('9999-9999999', { placeholder: '____-_______' });
        form.find('.no_hp').inputmask('9999-9999-9999', { placeholder: '____-____-____' });
        form.find('.email').inputmask({alias :"email"});

        form.validate({
            rules: {
                'jk': {
                    required: true
                },
                'agama' :{
                    required: true
                },
                'status_nikah' : {
                    required: true
                }
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
                $(element).parents('.input-group').append(error);
            }
        });
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add() {
        $('#content').load("<?php echo site_url('karyawan')?>");
        //window.location.replace('<?php echo site_url('karyawan')?>');
    }

    function edit(id) {
        $('#content').load("<?php echo site_url('karyawan/edit')?>");
        //window.location.replace('<?php echo site_url('karyawan/edit/')?>'+id);
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

    function cetak_cv(id) {
        window.open('<?php echo base_url('karyawan/cetak_cv/')?>' + id,'_blank');
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
</script>

<script type="text/javascript">
    var table;
    var save_method; //for save method string

    $('#frmadd').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function add(){
        save_method = 'add';
        $('#frmadd')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#mdadd').modal('show'); // show bootstrap modal
        $('.modal-title').text('New Jenis Document Data'); // Set Title to Bootstrap modal title
	}

    function save(){
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        
        $('#btnUpdate').text('Updating...'); //change button text
        $('#btnUpdate').attr('disabled',true); //set button disable 
        
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('document/ajax_add/');?>";
        } else {
            url = "<?php echo site_url('document/ajax_update');?>";
        }
        formData = new FormData();        
        formData.append( 'id', $('input[name=id]').val() );
        formData.append( 'jenis_doc', $('input[name=jenis_doc]').val() );
        
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
                    $('#mdadd').modal('hide');
                    $('#mdedit').modal('hide');
                    reload_table();
                    $('input[name=jenis_doc]').val('');
                }
                else{
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
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
        $('#frmadd')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('document/ajax_edit/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {		
                $('[name="id"]').val(data.idm_document);
                $('[name="jenis_doc"]').val(data.jenis_doc);
                $('#mdadd').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Jenis Document Data'); // Set title to Bootstrap modal title
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
                    url : "<?php echo site_url('document/delete')?>/"+id,
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
        //window.location.replace('<?php echo site_url('master/page/karyawan_oc')?>')
    }

    function master() {
        //window.location.replace('<?php echo site_url('master/page/karyawan_oc')?>')
    }

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });
</script>