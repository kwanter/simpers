
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><i class="fa fa-suitcase fa-fw"></i> Riwayat Pelatihan Karyawan</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								Informasi Identitas Karyawan
							</div>
							<div class="panel-body">
								<?php
									foreach ($info as $k) {	
										$nama = $k->nama_karyawan;
										$nik = $k->nik;
										$uker = $k->nama_uker." (".$k->lokasi.")";
										$jabatan = $k->jabatan;
										$status2 = $k->status2;
										$status = $k->status."/".$k->jml_anak;
										
									}
								?>
								<div class="col-lg-4">
									<dl>									
										<dt>Nama Karyawan :</dt>
										<dd><?php echo $nama; ?></dd>
										<dt>NIK :</dt>
										<dd><?php echo $nik; ?></dd>
									</dl>
								</div>
								<div class="col-lg-4">
									<dl>									
										<dt>Unit Kerja :</dt>
										<dd><?php echo $uker; ?></dd>
										<dt>Jabatan :</dt>
										<dd><?php echo $jabatan; ?></dd>
									</dl>
								</div>
								<div class="col-lg-4">
									<dl>									
										<dt>Status Pernikahan :</dt>
										<dd><?php echo $status; ?></dd>
										<dt>Status Pegawai :</dt>
										<dd><?php echo $status2; ?></dd>
									</dl>
								</div>
							</div>
							<!-- /.panel-body -->
						</div>
					</div>
				</div>
				
                <div class="row">
                    <div class="col-lg-12">
						<a href="<?php echo base_url().'/karyawan/biodata/'.$id; ?>" class="btn btn-default"  title="Kembali"><i class="fa fa-mail-reply fa-fw"></i></a>&nbsp;
						<button class="btn btn-danger" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Tambah</button><br /><br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Daftar Riwayat Pelatihan Karyawan
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                             		
									<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Tema</th>
												<th>Penyelenggara</th>
												<th>Kota</th>
												<th>Tahun</th>
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
		<!-- bootstrap datepicker -->
		<script src="<?php echo base_url(); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
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
		
	table = $('#table').DataTable({
        
		"ajax": {
            url : "<?php echo base_url().'pelatihan/ajax_list/'.$id; ?>",
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
        url : "<?php echo site_url('pelatihan/ajax_edit/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {		
            $('[name="id"]').val(data[0].id_rwpelatihan);
			$('[name="tema"]').val(data[0].tema_pelatihan);
			$('[name="penyelenggara"]').val(data[0].penyelenggara);
			$('[name="kota"]').val(data[0].kota);
			$('[name="tahun"]').val(data[0].tahun);
						
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
            url : "<?php echo site_url('pelatihan/ajax_delete')?>/"+id,
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
        url = "<?php echo site_url('pelatihan/ajax_add/'.$id);?>";
    } else {
        url = "<?php echo site_url('pelatihan/ajax_update/'.$id);?>";
    }
	
	formData = new FormData();
	formData.append( 'id', $('input[name=id]').val() );
	formData.append( 'tema', $('textarea[name=tema]').val() );
	formData.append( 'penyelenggara', $('input[name=penyelenggara]').val() );
	formData.append( 'kota', $('input[name=kota]').val() );
	formData.append( 'tahun', $('input[name=tahun]').val() );
	
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        dataType: "JSON",
		contentType: false,
		processData: false,
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
                            <label class="control-label col-md-3">Tema</label>
                            <div class="col-md-9">
								<textarea name='tema' id='tema' class="form-control" rows="2" placeholder="Tema Pelatihan"></textarea>
                                <span class="help-block"></span>								
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Penyelenggara</label>
                            <div class="col-md-9">
								<input name="penyelenggara" type="text" class="form-control" id="penyelenggara" placeholder="Penyelenggara">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Kota</label>
                            <div class="col-md-9">
								<input name="kota" type="text" class="form-control" id="kota" placeholder="Kota">
                                <span  class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Tahun</label>
                            <div class="col-md-9">
								<input name="tahun" type="text" class="form-control" id="tahun" placeholder="Tahun">
                                <span  class="help-block"></span>
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