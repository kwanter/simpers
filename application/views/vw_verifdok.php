
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Daftar Dokumen Verifikasi</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
						
						<a href="<?php echo base_url().'verifikasi'; ?>" class="btn btn-success" ><i class="fa fa-backward"></i> Kembali</a><br /><br />
							<table style="font-weight:bold;" border="0" width="100%">
								<tr valign="top">
									<td width='150px'>Nama Pekerjaan</td>
									<td align='center' width='20px'> : </td>
									<td><?php echo $nama." - [".$kode."]"; ?><br />&nbsp;</td>
								</tr>
								<tr valign="top">
									<td width='150px'>Nama Perusahaan</td>
									<td align='center'> : </td>
									<td><?php echo $rekanan; ?><br />&nbsp;</td>
								</tr>
								<tr valign="top">
									<td width='150px'>Klasifikasi / Divisi</td>
									<td align='center'> : </td>
									<td><?php echo $klasifikasi." / ".$divisi; ?><br />&nbsp;</td>
								</tr>
								<tr valign="top">
									<td width='150px'>&nbsp;</td>
									<td align='center'>&nbsp;</td>
									<td align='right'>
										
										<a target='_blank' href="<?php echo base_url().'cetak/listdok/'.$id; ?>" class='btn btn-sm btn-default'>Print</a>
										<?php if($numstat==3){ ?>
										<a onclick='reject(this.id)' class='btn btn-danger btn-sm' title='Tolak Permohonan' id="<?php echo $id; ?>">Tolak</a>
										<a onclick='submitverif(this.id)' class='btn btn-primary btn-sm' title='Submit Verifikasi' id="<?php echo $id; ?>">Submit</a>
										
										<?php }?>
									</td>
								</tr>
							</table>
								<br />
						<div class="panel panel-info">
							
                            <div class="panel-heading">
                                Daftar Dokumen Yang Diverifikasi
                            </div>
                            <!-- /.panel-heading -->
							
                            <div class="panel-body">
								
                                <div class="dataTable_wrapper">
                             		
									<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>&nbsp;</th>
												<th>Nama Dokumen</th>
												<th>Nomor</th>
												<th>Tgl</th>
												<th>Ada</th>
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
            url : "<?php echo base_url().'isidok/ajax_list2/'.$id; ?>",
            type : 'GET'
        },
		
		"columnDefs": [
			{ "width": "10px", "targets": 0},
			{ "width": "10px", "targets": 1},
			{ "width": "500px", "targets": 2 },
			{ "width": "80px", "targets": 4 },
			{ "width": "35px", "targets": 5 }
		  ]
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
	
	 //datepicker
	$('.datepicker').datepicker({
		autoclose: true,
		format: "yyyy-mm-dd",
		todayHighlight: true,
		orientation: "top auto",
		todayBtn: true,
		todayHighlight: true,  
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


function edit_dok(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('isidok/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			
            $('[name="id"]').val(data[0].id_permohonan_dok);
			$('[name="nama"]').val(data[0].nama_dokumen);
            $('[name="nodok"]').val(data[0].nodok);
			//$('[name="tgl"]').val(data[0].tgldok);
			$('[name="tgl"]').datepicker('update',data[0].tgldok);
			
			
            
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
        url = "<?php echo site_url('isidok/ajax_add')?>";
    } else {
        url = "<?php echo site_url('isidok/ajax_update')?>";
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

function filldok(id)
{
    if(confirm('Yakin ingin input dokumen ?'))
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

function submitverif(id)
{
    if(confirm('Yakin submit hasil verfikasi ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('permohonan/ajax_submitverif')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                //$('#modal_form').modal('hide');
                //reload_table();
				if(data.status)
					window.location = "<?php echo base_url().'verifikasi';?>";
				alert(data.info);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Submit verifikasi gagal');
            }
        });

    }
}
 
function resetdok(id)
{
    if(confirm('Yakin ingin reset informasi dokumen ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('isidok/ajax_resetdok')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                //$('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Menghapus data gagal');
            }
        });

    }
}

function edit_ya(id)
{
	// ajax delete data to database
	$.ajax({
		url : "<?php echo site_url('isidok/ajax_edit_ya')?>/"+id,
		type: "POST",
		dataType: "JSON",
		success: function(data)
		{
			//if success reload ajax table
			//$('#modal_form').modal('hide');
			reload_table();
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Gagal Mengupdate');
		}
	});   
}

function edit_tdk(id)
{
	// ajax delete data to database
	$.ajax({
		url : "<?php echo site_url('isidok/ajax_edit_tdk')?>/"+id,
		type: "POST",
		dataType: "JSON",
		success: function(data)
		{
			//if success reload ajax table
			//$('#modal_form').modal('hide');
			reload_table();
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Gagal Mengupdate');
		}
	});   
}
function reject(id)
{
    if(confirm('Yakin akan menolak permohonan ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('permohonan/ajax_reject')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                //$('#modal_form').modal('hide');
                //reload_table();
				if(data.status)
					window.location = "<?php echo base_url().'verifikasi';?>";
					alert(data.info);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Submit verifikasi gagal');
            }
        });

    }
}
</script>

<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>

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
                            <label class="control-label col-md-3">Nama Dokumen</label>
                            <div class="col-md-9">
                                <input name="nama" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nomor Dokumen</label>
                            <div class="col-md-9">
                                <textarea name='nodok' class="form-control" rows="2" placeholder="Nomor Dokumen"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Tgl Dokumen</label>
                            <div class="col-md-9">
								<input name="tgl" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" readonly="readonly">
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