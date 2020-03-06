
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Master Karyawan</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
						
						<button class="btn btn-danger" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
						<a href="<?php echo base_url()."cetak/xlskaryawan" ?>" class="btn btn-success" title='Export Ke Excel'><i class="fa fa-file-excel-o fa-fw"></i></a>
						<a target="_blank" href="<?php echo base_url()."cetak/pdfkaryawan" ?>" class="btn btn-warning" title='Export Ke PDF'><i class="fa fa-file-pdf-o fa-fw"></i></a><br /><br />
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Daftar Karyawan
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                             		
									<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Wilayah</th>
												<th>Nama<br />Karyawan</th>
												<th>JK</th>
												<th>Status/<br />Jml Anak</th>
												<th>Agama</th>
												<th>Unit<br />Kerja</th>
												<th>Jabatan</th>
												<th>Status<br />Pegawai</th>
												<th width='60px'>Action</th>
											</tr>
										</thead>
										<tbody>
										</tbody>

										
									</table>
                                </div>
                                <!-- /.table-responsive -->
                                
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    
					</div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo base_url(); ?>assets/js/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url(); ?>assets/js/startmin.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
				/*
		  $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
			*/
        </script>

    </body>
</html>


<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {
		

    //datatables
	
	table = $('#table').DataTable({
        
		"ajax": {
            url : "<?php echo base_url().'karyawan/ajax_list'; ?>",
            type : 'GET'
        },
		 /*"columnDefs": [
			  { className: "text-right", "targets": [3] },
			  { className: "text-center", "targets": [0,2,4,5,6,7] },
		]*/
		
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function add()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Data Baru'); // Set Title to Bootstrap modal title
}

function edit(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('karyawan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			
            $('[name="id"]').val(data[0].id_karyawan);
            $('[name="wilayah"]').val(data[0].wilayah);
			$('[name="nama"]').val(data[0].nama_karyawan);
			$('[name="jk"]').val(data[0].jk);
			$('[name="status"]').val(data[0].status);
			$('[name="anak"]').val(data[0].jml_anak);
			$('[name="uker"]').val(data[0].uker);
			$('[name="jabatan"]').val(data[0].jabatan);
			$('[name="status2"]').val(data[0].stat_pegawai);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title
			

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function deldata(id)
{
    if(confirm('Yakin ingin menghapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('karyawan/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Menghapus data gagal');
            }
        });

    }
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('karyawan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('karyawan/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}


</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">New Data</h3>
            </div>
            <div class="modal-body form ">
			
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        
						<div class="form-group">
                            <label class="control-label col-md-3">Wilayah</label>
                            <div class="col-md-9">
                                <select name="wilayah" class="form-control">
									<option value="BPN" selected>Balikpapan</option>
									<option value="BWG">Banyuwangi</option>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Nama Karyawan</label>
                            <div class="col-md-9">
								<input name="nama" type="text" class="form-control" id="nama" placeholder="Nama Karyawan">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Jenis Kelamin</label>
							<div class="col-md-9">
								<select name="jk" class="form-control">
									<option value="L" selected>Laki-laki</option>
									<option value="P">Perempuan</option>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
                            <label class="control-label col-md-3">St. Pernikahan</label>
                            <div class="col-md-9">
                                <select name="status" class="form-control">
									<option value="B" selected>Belum Kawin</option>
									<option value="K">Kawin</option>
									<option value="J">Janda</option>
									<option value="D">Duda</option>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Jml Anak</label>
                            <div class="col-md-9">
                                <select name="anak" class="form-control">
									<option value="0" selected>0</option>
									<option value="1" >1</option>
									<option value="2" >2</option>
									<option value="3" >3</option>
									<option value="4" >4</option>
									<option value="5" >5</option>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group ">
							<label class="control-label col-md-3">Agama</label>
							<div class="col-md-9">
								<select name="agama" class="form-control">
								<?php
								foreach ($lsagama as $r) {	
								?>
									<option value="<?php echo $r->id_agama; ?>" ><?php echo $r->nama_agama; ?></option>
								<?php
								}
								?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Unit Kerja</label>
                            <div class="col-md-9">
								<input name="uker" type="text" class="form-control" id="uker" placeholder="Unit Kerja">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						
						<div class="form-group">
                            <label class="control-label col-md-3">Jabatan</label>
                            <div class="col-md-9">
								<input name="jabatan" type="text" class="form-control" id="anggaran" placeholder="Jabatan">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">St. Pegawai</label>
                            <div class="col-md-9">
                                <select name="status2" class="form-control">
									<option value="T" selected>Karyawan Tetap (T)</option>
									<option value="O" >Tenaga Outsourcing (O)</option>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
				
				
            </div>
			
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->