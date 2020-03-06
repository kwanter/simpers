
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><i class="fa  fa-history fa-fw"></i> History Permohonan</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
						
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                Daftar Permohonan Pembayaran
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                             		
									<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>&nbsp;</th>
												<th>Kode</th>
												<th>Nama Pekerjaan</th>
												  <th>Perusahaan</th>
												  <th>Klasifikasi</th>
												  <th>Divisi</th>
												  
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
            url : "<?php echo base_url().'history/ajax_list'; ?>",
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



function add_workplans()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Data Baru'); // Set Title to Bootstrap modal title
}

function edit_permohonan(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('permohonan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			
            $('[name="id"]').val(data[0].id_permohonan);
            $('[name="nama"]').val(data[0].nama_pekerjaan);
			$('[name="perusahaan"]').val(data[0].nama_rekanan);
			$('[name="klasifikasi"]').val(data[0].id_klasifikasi);
			$('[name="divisi"]').val(data[0].id_divisi);
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('permohonan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('permohonan/ajax_update')?>";
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

function deldata(id)
{
    if(confirm('Yakin ingin menghapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('permohonan/ajax_delete')?>/"+id,
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

function cancel(id)
{
    if(confirm('Membatalkan data berarti menghapus informasi dokumen yang telah dientry.\n Yakin ingin membatalkan data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('isidok/ajax_deldok')?>/"+id,
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
                alert('Membatalkan data gagal');
            }
        });

    }
}

function filldok(id)
{
    if(confirm('Yakin akan Submit data ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('permohonan/ajax_filldok')?>/"+id,
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
                alert('Input data gagal');
            }
        });

    }
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
                            <label class="control-label col-md-3">Nama Pekerjaan</label>
                            <div class="col-md-9">
                                <textarea name='nama' class="form-control" rows="2" placeholder="Nama Pekerjaan"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Perusahaan</label>
                            <div class="col-md-9">
								<input name="perusahaan" type="text" class="form-control" id="anggaran" placeholder="Nama Perusahaan">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Klasifikasi</label>
                            <div class="col-md-9">
                                <select name="klasifikasi" class="form-control">
									<?php
									$list = $this->klasifikasi->getAll();
									foreach ($list as $klasifikasi) {
									?>
										<option value="<?php echo $klasifikasi->id_klasifikasi; ?>"><?php echo $klasifikasi->nama_klasifikasi.' ('.$klasifikasi->kategori.')'; ?></option>
									<?php
									}
									?>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Divisi</label>
                            <div class="col-md-6">
                                <select name="divisi" class="form-control">
									<?php
									$list = $this->divisi->getAll();
									foreach ($list as $divisi) {
									?>
										<option value="<?php echo $divisi->id_divisi; ?>"><?php echo $divisi->nama_divisi; ?></option>
									<?php
									}
									?>
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