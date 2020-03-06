
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><i class="fa fa-user fa-fw"></i> Biodata Karyawan</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
						
						<a href="<?php echo base_url()."/karyawan"; ?>" class="btn btn-default" title="Kembali" ><i class="fa fa-mail-reply fa-fw"></i></a>&nbsp;
						<a href="<?php echo base_url()."keluarga/data/".$id; ?>" class="btn btn-primary" ><i class="fa fa-child  fa-fw"></i> Keluarga</a>&nbsp;
						<a href="<?php echo base_url()."pendidikan/data/".$id; ?>" class="btn btn-success" ><i class="fa fa-graduation-cap fa-fw"></i> Pendidikan</a>&nbsp;
						<a href="<?php echo base_url()."pelatihan/data/".$id; ?>" class="btn btn-info" ><i class="fa fa-suitcase fa-fw"></i> Pelatihan</a>&nbsp;
						<a href="<?php echo base_url()."pengalaman/data/".$id; ?>" class="btn btn-warning" ><i class="fa fa-cubes fa-fw"></i> Pengalaman</a>&nbsp;
						<br /><br />
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button class="btn btn-danger" onclick="save()" title='Simpan'><i class="fa fa-save fa-fw"></i></button>&nbsp;
								<a target="_blank" title='Cetak CV' href="<?php echo base_url()."cetak/cv/".$id; ?>" class="btn btn-default" ><i class="fa fa-print fa-fw"></i></a>&nbsp;
								<button class="btn btn-success" onclick="reload()" title='Refresh'><i class="fa fa-rotate-left  fa-fw"></i></button>&nbsp;
								
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
								<form action="#" id="form" class="form-horizontal">
									<input type="hidden" value="<?php echo $id; ?>" name="id"/> 
									
									<div class="row">
										<!-- Left Side  -->
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-md-3">Nama</label>
												<div class="col-md-9">
													<input name="nama" value="<?php //echo $nama; ?>" type="text" class="form-control" id="nama" placeholder="Nama Karyawan">
													<span name="ernama" class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3">NIK</label>
												<div class="col-md-9">
													<input name="nik" type="text" class="form-control" id="nik" placeholder="NIK">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3">Tempat Lahir</label>
												<div class="col-md-9">
													<input name="tempat" type="text" value="<?php //echo $tempat; ?>" class="form-control" id="tempat" placeholder="Tempat Lahir">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3">Tgl Lahir</label>
												<div class="col-md-9">
													
													<input type="text" class="form-control pull-right" id="tgl" readonly="readonly">
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
												<label class="control-label col-md-3">Status</label>
												<div class="col-md-9">
													<select name="status" class="form-control">
														<option value="B" >Belum Kawin</option>
														<option value="K">Kawin</option>
														<option value="J">Janda</option>
														<option value="D">Duda</option>
													</select>
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">Jml Anak</label>
												<div class="col-md-9">
													<select name="anak" class="form-control">
														<option value="0" >0</option>
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
											<div class="form-group ">
												<label class="control-label col-md-3">Unit Kerja</label>
												<div class="col-md-9">
													<input name="uker" type="text" class="form-control" id="uker" placeholder="Unit Kerja">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">Jabatan</label>
												<div class="col-md-9">
													<input name="jabatan" type="text" class="form-control" id="jabatan" placeholder="Jabatan">
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
										<!-- End Left Side  -->
										
										<!-- Right Side  -->
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-md-3">Wilayah</label>
												<div class="col-md-9">
													<select name="wilayah" class="form-control">
														<option value="BPN" >Balikpapan</option>
														<option value="BWG">Banyuwangi</option>
													</select>
													<span class="help-block"></span>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-md-3">No KTP</label>
												<div class="col-md-9">
													<input name="noktp" type="text" class="form-control" id="noktp" placeholder="No KTP" >
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">NPWP</label>
												<div class="col-md-9">
													<input name="npwp" type="text" class="form-control"  placeholder="NPWP">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">No BPJS Kes</label>
												<div class="col-md-9">
													<input name="nobpjs1" type="text" class="form-control"  placeholder="No BPJS Kesehatan">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">No BPJS TK</label>
												<div class="col-md-9">
													<input name="nobpjs2" type="text" class="form-control"  placeholder="No BPJS Tenaga Kerja">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">Telp/HP</label>
												<div class="col-md-9">
													<input name="telp" type="text" class="form-control"  id="telp" placeholder="No Telp/HP">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">Email</label>
												<div class="col-md-9">
													<input name="email" type="text" class="form-control"  id="email" placeholder="Email">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">Jenjang</label>
												<div class="col-md-9">
													<select name="jenjang" class="form-control">
														<?php
														foreach ($lsjenjang as $r) {	
														?>
															<option value="<?php echo $r->id_jenjang; ?>" ><?php echo $r->nama_jenjang; ?></option>
														<?php
														}
														?>
													</select>
													<span class="help-block"></span>
												</div>
											</div>
											
											<div class="form-group ">
												<label class="control-label col-md-3">Jurusan</label>
												<div class="col-md-9">
													<input name="jurusan" type="text" class="form-control" id="jurusan" placeholder="Jurusan">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group ">
												<label class="control-label col-md-3">Tgl Masuk</label>
												<div class="col-md-9">
													<input name="tgl2" type="text" class="form-control"  id="tgl2" placeholder="Tanggal Masuk" readonly="readonly">
													<span class="help-block"></span>
												</div>
											</div>
										</div>
										<!-- End Right Side  -->
									</div>
									<!-- End Row  -->
									
									<div class="row">								
										
										<div class="form-group">
											<label class="control-label col-md-2">Alamat</label>
											<div class="col-md-9">
												<input name="alamat" type="text" class="form-control" id="alamat" placeholder="Alamat">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-2">Kota</label>
											<div class="col-md-4">
												<input name="kota" type="text" class="form-control" id="kota" placeholder="Kota">
												<span class="help-block"></span>
											</div>
										</div>
										
									</div>	
								</form>
								
							
							<hr />
								<div class="form-group">
									<label class="control-label col-md-1">Photo</label>
									<div class="col-md-4">
										<img id="img" src="" width="100px" height="125px"/>
										<input name="file" type="file" class="form-control" id="file">
										
										<span class="help-block"></span>
										<button id="btupload" class="btn btn-sm btn-info" title='Upload Photo'><i class="fa fa-upload fa-fw"></i></button>&nbsp;
										<button id="btremove" class="btn btn-sm btn-default" title='Hapus Photo'><i class="fa fa-remove fa-fw"></i></button>
									</div>
									
								</div>
							
                            </div>
                            <!-- /.panel-body -->
							<br /><br />
							<div class="panel-footer">
                                <button class="btn btn-danger" onclick="save()" title='Simpan'><i class="fa fa-save fa-fw"></i></button>&nbsp;
								<a target="_blank" title='Cetak CV' href="<?php echo base_url()."cetak/cv/".$id; ?>" class="btn btn-default" ><i class="fa fa-print fa-fw"></i></a>&nbsp;
								<button class="btn btn-success" onclick="reload()" title='Refresh'><i class="fa fa-rotate-left  fa-fw"></i></button>
                            </div>
							<!-- /.panel-footer -->
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

$(document).ready(function() {
	//Date picker
	 
	$('#tgl').datepicker({
		format: 'dd M yyyy',
		autoclose: true
	});
	
	$('#tgl2').datepicker({
		format: 'dd M yyyy',
		autoclose: true
    });
	
	 
	$.ajax({
        url : "<?php echo base_url().'karyawan/ajax_edit/'.$id;?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			//$('[name="tgl2"]').val(data[0].tgl_masuk);
			$("#tgl2").datepicker().datepicker("setDate", new Date(data[0].tgl_masuk));
			$('[name="id"]').val(data[0].id_karyawan);
            $('[name="nama"]').val(data[0].nama_karyawan);
			$('[name="wilayah"]').val(data[0].wilayah);
			$('[name="tempat"]').val(data[0].tempat_lahir);
			$('[name="nik"]').val(data[0].nik);
			//$('[name="tgl"]').val(data[0].tgl_lahir);
			$("#tgl").datepicker().datepicker("setDate", new Date(data[0].tgl_lahir));
			$('[name="noktp"]').val(data[0].noktp);
			$('[name="uker"]').val(data[0].uker);
			$('[name="jabatan"]').val(data[0].jabatan);
			$('[name="npwp"]').val(data[0].npwp);
			$('[name="status"]').val(data[0].status);
			$('[name="telp"]').val(data[0].telp);
			$('[name="anak"]').val(data[0].jml_anak);
			$('[name="email"]').val(data[0].email);
			$('[name="agama"]').val(data[0].id_agama);
			$('[name="jenjang"]').val(data[0].id_jenjang);
			$('[name="nama"]').val(data[0].nama_karyawan);
			$('[name="jurusan"]').val(data[0].pend_jurusan);
			$('[name="alamat"]').val(data[0].alamat);
			$('[name="kota"]').val(data[0].kota);
			$('[name="jk"]').val(data[0].jk);
			$('[name="status2"]').val(data[0].stat_pegawai);
			$('[name="nobpjs1"]').val(data[0].nobpjs_kes);
			$('[name="nobpjs2"]').val(data[0].nobpjs_tk);
			//$("#img").attr("src","<?php echo base_url().'edoc/images/'; ?>"+data[0].photo);
			$("#img").attr("src","<?php echo base_url(); ?>"+data[0].photo);
		},
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        },
    });
	
	
	$("#btupload").click(function(){

		var fd = new FormData();
		var fsize = $('#file')[0].files[0].size /1024;
		var files = $('#file')[0].files[0];
		
		if (fsize>200){
			alert ("Maximum Photo File is 200 KB");
			return;
		}
		
		
		fd.append('file',files);

		$.ajax({
			url : "<?php echo base_url().'karyawan/addphoto/'.$id;?>",
			type:'post',
			data:fd,
			dataType: "JSON",
			contentType: false,
			processData: false,
			success:function(response){
				if(response.status){
					$("#img").attr("src",response.url + '?' + (new Date()).getTime() );
				}
				alert(response.info);
				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			},
		});
	});
	
	$("#btremove").click(function(){

		$.ajax({
			url : "<?php echo base_url().'karyawan/delphoto/'.$id;?>",
			type:'get',
			dataType: "JSON",
			success:function(response){
				if(response.status){
					$("#img").attr("src","<?php echo base_url().'edoc/nophoto.jpg'; ?>" );
				}
				alert(response.info);
				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			},
		});
	});
	
});


function reload()
{
	location.reload(true);
}

function save()
{
    var url;
	url = "<?php echo site_url('karyawan/ajax_update2')?>";
    
	var tgl = $("#tgl").datepicker('getDate').getDate();
	var bln = $("#tgl").datepicker('getDate').getMonth()+1;
	var thn = $("#tgl").datepicker('getDate').getFullYear();
	
	var tgl2 = $("#tgl2").datepicker('getDate').getDate();
	var bln2 = $("#tgl2").datepicker('getDate').getMonth()+1;
	var thn2 = $("#tgl2").datepicker('getDate').getFullYear();
	
	formData = new FormData();
	formData.append( 'id', $('input[name=id]').val() );
	formData.append( 'nama', $('input[name=nama]').val() );
	formData.append( 'wilayah', $('select[name=wilayah]').val() );
	formData.append( 'tempat', $('input[name=tempat]').val() );
	formData.append( 'nik', $('input[name=nik]').val() );
	formData.append( 'tgl', thn + '-' + bln + '-' + tgl );		
	formData.append( 'noktp', $('input[name=noktp]').val() );
	formData.append( 'nik', $('input[name=nik]').val() );
	formData.append( 'jk', $('select[name=jk]').val() );
	formData.append( 'npwp', $('input[name=npwp]').val() );
	formData.append( 'uker', $('input[name=uker]').val() );
	formData.append( 'jabatan', $('input[name=jabatan]').val() );
	formData.append( 'telp', $('input[name=telp]').val() );
	formData.append( 'status', $('select[name=status]').val() );
	formData.append( 'status2', $('select[name=status2]').val() );
	formData.append( 'email', $('input[name=email]').val() );
	formData.append( 'anak', $('select[name=anak]').val() );
	formData.append( 'jenjang', $('select[name=jenjang]').val() );
	formData.append( 'agama', $('select[name=agama]').val() );
	formData.append( 'jurusan', $('input[name=jurusan]').val() );
	formData.append( 'alamat', $('input[name=alamat]').val() );
	formData.append( 'kota', $('input[name=kota]').val() );
	formData.append( 'nobpjs1', $('input[name=nobpjs1]').val() );
	formData.append( 'nobpjs2', $('input[name=nobpjs2]').val() );
	formData.append( 'tgl2', thn2 + '-' + bln2 + '-' + tgl2 );
	
    $.ajax({
        url : url,
        type: "POST",
        //data: $('#form').serialize(),
		data: formData,
        dataType: "JSON",
		contentType: false,
		processData: false,
		
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                alert("Data has been saved");
				$('[name="ernama"]').empty();
				$("input").parent().parent().removeClass('has-error');
				
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error update data');
        }
    });
}



</script>

