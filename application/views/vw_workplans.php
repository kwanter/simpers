 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        RENCANA KERJA
        <small>Rencana Kegiatan Investasi dan Eksploitasi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Entry Data</li>
        <li class="active">Rencana Kerja</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		
  
	
	<!-- DAFTAR -->
		<div class="box box-info">
			 <div class="box">
            <div class="box-header">
			  <button class="btn btn-danger" onclick="add_workplans()"><i class="glyphicon glyphicon-plus"></i> New</button>
			  <button class="btn btn-info" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
			  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				
            
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Pekerjaan</th>
							  <th>Kode Rekening</th>
							  <th>Pagu</th>
							  <th>Tahun</th>
							  <th>Uker</th>
							  <th>Kategori</th>
							  <th>Pembiayaan</th>
							  <th width='60px'>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>

					
				</table>
			</div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable();
  })
</script>

<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {
	
	$.ajax({
		
        url: "<?php echo base_url().'json/list_anggaran'; ?>" ,
        dataType: "JSON",
		 type: "GET",
        success: function (data) {
			
			
			$( "#anggaran" ).autocomplete({
					
			  minLength: 2,
			  appendTo: "#modal_form",
			  source: data,
			  focus: function( event, ui ) {
			  	$("#idanggaran").val("");
				$("#rekening").val("");
				$( "#anggaran" ).val( ui.item.label );
				
				return false;
			  },
			  select: function( event, ui ) {
					$( "#anggaran" ).val( ui.item.label );
					$( "#idanggaran" ).val( ui.item.id );
					$( "#rekening" ).val( ui.item.kode );
					return false;
				  }
				})
			.autocomplete( "instance" )._renderItem = function( ul, item ) {
				
			  return $( "<li>" )
				//.append( "<div><b>" + item.value + "</b><br />" + item.label + "</div>" )
				.append( "<div>" + item.label + "</div>" )
				.appendTo( ul );
			};
			
			
		}
    });
		

    //datatables
	table = $('#table').DataTable({
        "ajax": {
            url : "<?php echo base_url().'workplans/ajax_list'; ?>",
            type : 'GET'
        },
		 "columnDefs": [
			  { className: "text-right", "targets": [3] },
			  { className: "text-center", "targets": [0,2,4,5,6,7] },
		]
		
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
    $('.modal-title').text('New Data'); // Set Title to Bootstrap modal title
}

function edit_workplans(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('workplans/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			
            $('[name="id"]').val(data[0].id_workplans);
            $('[name="nama"]').val(data[0].nama_pekerjaan);
			$('[name="kategori"]').val(data[0].kategori);
			$('[name="tahun"]').val(data[0].tahun);
			$('[name="uker"]').val(data[0].id_uker);
			$('[name="rekening"]').val(data[0].kode_rekening);
			$('[name="pagu"]').val(data[0].pagu);
			$('[name="pembiayaan"]').val(data[0].pembiayaan);
			$('[name="anggaran"]').val(data[0].uraian + " (" + data[0].kode_rekening + ")" );
			$('[name="idanggaran"]').val(data[0].id_anggaran);
			
            
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
        url = "<?php echo site_url('workplans/ajax_add')?>";
    } else {
        url = "<?php echo site_url('workplans/ajax_update')?>";
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
            url : "<?php echo site_url('workplans/ajax_delete')?>/"+id,
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
                            <label class="control-label col-md-3">Kategori</label>
                            <div class="col-md-4">
                                <select name="kategori" class="form-control">
									<option value="INV">Investasi</option>
									<option value="EXP">Eksploitasi</option>
								</select>
                                <span class="help-block"></span>
                            </div>
							<label class="control-label col-md-2">Tahun</label>
							<div class="col-md-2">
								<input name="tahun" type="text" value="<?php echo date('Y'); ?>" class="form-control" id="tahun" readonly="readonly">
								<span class="help-block"></span>
							</div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Unit Kerja</label>
                            <div class="col-md-6">
                                <select name="uker" class="form-control">
									<option value="6">Operasi</option>
									<option value="7">Teknik</option>
									<option value="4">Keuangan</option>
									<option value="5">SDM, UMUM, SI</option>
								</select>
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Mata Anggaran</label>
                            <div class="col-md-9">
								<input name="anggaran" type="text" class="form-control" id="anggaran">
								<input type="hidden" value="" name="idanggaran" id="idanggaran"/> 
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Kode Rekening</label>
                            <div class="col-md-4">
								<input name="rekening" type="text" class="form-control" id="rekening" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Pagu Anggaran</label>
                            <div class="col-md-4">
                                <input name="pagu" type="text" class="form-control" placeholder="Pagu Anggaran">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Pembiayaan</label>
                            <div class="col-md-4">
                                <select name="pembiayaan" class="form-control">
									<option value="S">Singe Years</option>
									<option value="M">Multi Years</option>
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