<?php
/*foreach ($list as $r) {	
	
	$id = $r->id_karyawan;
	$nama = $r->nama_karyawan;
	$tempat = $r->tempat_lahir;
	$nik = $r->nik;
	$tgl = $r->tgl_lahir;
	$noktp = $r->noktp;
	$jabatan = $r->jabatan;
	$npwp = $r->npwp;
	$status = $r->status;
	$telp = $r->telp;
	$jmlanak = $r->jml_anak;
	$email = $r->email;
	$jurusan= $r->pend_jurusan;
	$tglmasuk = $r->tgl_masuk;
	$alamat = $r->alamat;
	$kota = $r->kota;
	$photo = $r->photo;
}*/
?>
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
						
						<a href="<?php echo base_url()."/karyawan"; ?>" class="btn btn-default" ><i class="fa fa-mail-reply fa-fw"></i> Kembali</a>&nbsp;
						<a href="<?php echo base_url()."/karyawan/keluarga/".$id; ?>" class="btn btn-primary" ><i class="fa fa-child  fa-fw"></i> Keluarga</a>&nbsp;
						<a href="<?php echo base_url()."/karyawan/pendidikan/".$id; ?>" class="btn btn-success" ><i class="fa fa-graduation-cap fa-fw"></i> Pendidikan</a>&nbsp;
						<a href="<?php echo base_url()."/karyawan/pelatihan/".$id; ?>" class="btn btn-info" ><i class="fa fa-suitcase fa-fw"></i> Pelatihan</a>&nbsp;
						<br /><br />
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button class="btn btn-danger" onclick="save()" title='Simpan'><i class="fa fa-save fa-fw"></i></button>&nbsp;
								<button class="btn btn-warning" onclick="add()" title='Refresh'><i class="fa fa-rotate-left  fa-fw"></i></button>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
								<form action="#" id="form" class="form-horizontal">
									<input type="hidden" value="<?php echo $id; ?>" name="id"/> 
									
									<div class="row">
										<div class="col-lg-6">
											oke
										</div>
										<div class="col-lg-6">
											eko
										</div>
									</div>
									
									<div class="form-body">
										
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Nama</label>
											<div class="col-md-9">
												<input name="nama" value="<?php //echo $nama; ?>" type="text" class="form-control" id="nama" placeholder="Nama Karyawan">
												<span class="help-block"></span>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Wilayah</label>
											<div class="col-md-9">
												<select name="wilayah" class="form-control">
													<option value="BPN" selected>Balikpapan</option>
													<option value="BWG">Banyuwangi</option>
												</select>
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Tmp Lahir</label>
											<div class="col-md-9">
												<input name="tempat" type="text" value="<?php //echo $tempat; ?>" class="form-control" id="tempat" placeholder="Tempat Lahir">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">NIK</label>
											<div class="col-md-9">
												<input name="nik" type="text" class="form-control" id="nik" value="<?php //echo $nik; ?>" placeholder="NIK">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Tgl Lahir</label>
											<div class="col-md-9">
												<input name="tgl" type="text" class="form-control" value="<?php //echo $tgl; ?>" id="tgl" placeholder="Tanggal Lahir">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">NO KTP</label>
											<div class="col-md-9">
												<input name="noktp" type="text" class="form-control" value="<?php //echo $noktp; ?>" id="noktp" placeholder="No KTP" >
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Jabatan</label>
											<div class="col-md-9">
												<input name="jabatan" type="text" class="form-control" value="<?php //echo $jabatan; ?>" id="jabatan" placeholder="Jabatan">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">NPWP</label>
											<div class="col-md-9">
												<input name="npwp" type="text" class="form-control" value="<?php //echo $npwp; ?>" id="npwp" placeholder="NPWP">
												<span class="help-block"></span>
											</div>
										</div>
																				
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Status</label>
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
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Telp/HP</label>
											<div class="col-md-9">
												<input name="telp" type="text" class="form-control" value="<?php //echo $telp; ?>" id="telp" placeholder="No Telp/HP">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
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
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Email</label>
											<div class="col-md-9">
												<input name="email" type="text" class="form-control" value="<?php //echo $email;?>" id="telp" placeholder="Email">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Agama</label>
											<div class="col-md-9">
												<select name="agama" class="form-control">
													<option value="I" selected>Islam</option>
													<option value="K">Katolik</option>
												</select>
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Jenjang</label>
											<div class="col-md-9">
												<select name="jenjang" class="form-control">
													<option value="S1" selected>Strata 1</option>
													<option value="D3">Diploma 3</option>
												</select>
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Tgl Masuk</label>
											<div class="col-md-9">
												<input name="tgl2" type="text" class="form-control"  id="tgl2" placeholder="Tanggal Masuk">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Jurusan</label>
											<div class="col-md-9">
												<input name="jurusan" type="text" class="form-control" value="<?php //echo $jurusan; ?>" id="jurusan" placeholder="Jurusan">
												<span class="help-block"></span>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="control-label col-md-3">Jns Kelamin</label>
											<div class="col-md-9">
												<select name="jk" class="form-control">
													<option value="L" selected>Laki-laki</option>
													<option value="P">Perempuan</option>
												</select>
												<span class="help-block"></span>
											</div>
										</div>
										<div class="form-group">
											&nbsp;
										</div>
										<div class="form-group">
											<label class="control-label col-md-2">Alamat</label>
											<div class="col-md-9">
												<input name="alamat" type="text" class="form-control" value="<?php //echo $alamat; ?>" id="alamat" placeholder="Alamat">
												<span class="help-block"></span>
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-2">Kota</label>
											<div class="col-md-4">
												<input name="kota" type="text" class="form-control" value="<?php //echo $kota; ?>" id="kota" placeholder="Kota">
												<span class="help-block"></span>
											</div>
										</div>
										
								</form>
								
							</div>
							<hr />
								<div class="form-group">
									<label class="control-label col-md-1">Photo</label>
									<div class="col-md-4">
										<img src="<?php //echo base_url()."assets/".$photo; ?>" width="100px" height="125px"/>
										<input name="kota" type="file" class="form-control" id="kota" placeholder="Kota">
										
										<span class="help-block"></span>
										<button class="btn btn-sm btn-info" onclick="add()" title='Upload Photo'><i class="fa fa-upload fa-fw"></i></button>&nbsp;
										<button class="btn btn-sm btn-default" onclick="add()" title='Hapus Photo'><i class="fa fa-remove fa-fw"></i></button>
									</div>
									
								</div>
							
                            </div>
                            <!-- /.panel-body -->
							<br /><br />
							<div class="panel-footer">
                                <button class="btn btn-danger" onclick="save()" title='Simpan'><i class="fa fa-save fa-fw"></i></button>&nbsp;
								<button class="btn btn-warning" onclick="add()" title='Refresh'><i class="fa fa-rotate-left  fa-fw"></i></button>
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
	
	$.ajax({
        url : "<?php echo base_url().'karyawan/ajax_edit/'.$id;?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			$('[name="tgl2"]').val(data[0].tgl_masuk);
			$('[name="id"]').val(data[0].id_karyawan);
            $('[name="nama"]').val(data[0].nama_karyawan);
			$('[name="wilayah"]').val(data[0].wilayah);
			$('[name="tempat"]').val(data[0].tempat_lahir);
			$('[name="nik"]').val(data[0].nik);
			$('[name="tgl"]').val(data[0].tgl_lahir);
			$('[name="noktp"]').val(data[0].noktp);
			$('[name="jabatan"]').val(data[0].jabatan);
			$('[name="npwp"]').val(data[0].npwp);
			$('[name="status"]').val(data[0].status);
			$('[name="telp"]').val(data[0].telp);
			$('[name="anak"]').val(data[0].jml_anak);
			$('[name="email"]').val(data[0].email);
			//$('[name="agama"]').val(data[0].id_agama);
			$('[name="nama"]').val(data[0].nama_karyawan);
			$('[name="jurusan"]').val(data[0].pend_jurusan);
			$('[name="alamat"]').val(data[0].alamat);
			$('[name="kota"]').val(data[0].kota);
			
			$('[name="jk"]').val(data[0].jk);
		},
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        },
    });
	

});


function save()
{
    var url;
	url = "<?php echo site_url('karyawan/ajax_update')?>";
    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                alert("Data has been saved");

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

