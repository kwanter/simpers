
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Pengisian Data Dokumen Pembayaran</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
						
						
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                Daftar Permohonan Pembayaran
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                             		
									<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Kode</th>
												<th>Nama Pekerjaan</th>
												  <th>Perusahaan</th>
												  <th>Klasifikasi</th>
												  <th>Divisi</th>
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
            url : "<?php echo base_url().'permohonan/ajax_list'; ?>",
            type : 'GET'
        },
		 /*"columnDefs": [
			  { className: "text-right", "targets": [3] },
			  { className: "text-center", "targets": [0,2,4,5,6,7] },
		]*/
		
    });
	
	table = $('#tabledok').DataTable({
		"columnDefs": [
		{ "width": "15px", "targets": 0 },
		{ "width": "60px", "targets": 4 }
		],
		"lengthChange": false,
		"searching": false
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
    //$('#form')[0].reset(); // reset form on modals
    //$('.form-group').removeClass('has-error'); // clear error class
    //$('.help-block').empty(); // clear error string

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
            
            $('#myModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').html('Nama Pekerjaan : Pemeliharaan Gedung Kantor (2018EXP0012)<br />Klasifikasi : Pemeliharaan'); // Set title to Bootstrap modal title
			
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


</script>


 <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
					
					<table id="tabledok" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Dokumen</th>
								<th>No Dokumen</th>
								<th>Tgl Dokumen</th>
								<th width='60px'>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td><input type="text" class="form-control" id="no1"></td>
								<td><input type="text" class="form-control" id="tgl1"></td>
								<td><button id="no1" type="submit" class="btn btn-primary" onclick='delete(this.id)'>Submit</button></td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Berita Acara</td>
								<td>15/BA-DUT2018</td>
								<td>12 jAN 2018</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->