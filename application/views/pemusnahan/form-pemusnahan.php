<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-btns">
        <a href="#" class="minimize">−</a>
      </div>
      <h4 class="panel-title">Form Pemusnahan</h4>
      <p><code>(*)</code> Mandatory Field.</p>
    </div>
    <div class="panel-body">
    	<form method="post" action="<?php echo site_url('pemusnahan/execute/pemusnahan'); ?>" autocomplete="off" name="form-pemusnahan" id="form-pemusnahan" onSubmit="post_data('form-pemusnahan'); return false;">
			<input type="hidden" name="action" value="<?php echo $action; ?>" readonly="true">
			<input type="hidden" name="id" value="<?php echo $data['id']; ?>" readonly="true">
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
						<label class="control-label">Tanggal Surat <code>*</code></label>
						<input type="text" name="data[tgl_surat]" id="tgl_surat" class="form-control date" mandatory="yes" value="<?php echo $data['tgl_surat']; ?>" <?php echo $disabled; ?>>
					</div>
				</div><!-- col-sm-4 -->
				<div class="col-sm-5">
					<div class="form-group">
						<label class="control-label">Nomor Surat <code>*</code></label>
						<input type="text" name="data[no_surat]" id="no_surat" class="form-control" mandatory="yes" value="<?php echo $data['no_surat']; ?>">
					</div>
				</div><!-- col-sm-4 -->
				<div class="col-sm-5">
					<div class="form-group">
						<label class="control-label">Perihal <code>*</code></label>
						<input type="text" name="data[perihal]" id="perihal" class="form-control" mandatory="yes" value="<?php echo $data['perihal']; ?>">
					</div>
				</div><!-- col-sm-4 -->
			</div><!-- row -->
	      
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
						<label class="control-label">Kantor Tujuan <code>*</code></label>
						<input type="text" name="data[kd_kantor_tujuan]" id="kd_kantor_tujuan" class="form-control" mandatory="yes" value="<?php echo $data['kd_kantor_tujuan']; ?>">
					</div>
				</div><!-- col-sm-4 -->
				<div class="col-sm-5">
					<div class="form-group">
						<label class="control-label">Nama Pemohon <code>*</code></label>
						<input type="text" name="data[nm_pemohon]" id="nm_pemohon" class="form-control" mandatory="yes" value="<?php echo $data['nm_pemohon']; ?>">
					</div>
				</div><!-- col-sm-4 -->
				<div class="col-sm-5">
					<div class="form-group">
						<label class="control-label">Nomor Identitas <code>*</code></label>
						<input type="text" name="data[id_pemohon]" id="id_pemohon" class="form-control" mandatory="yes" value="<?php echo $data['id_pemohon']; ?>">
					</div>
				</div><!-- col-sm-4 -->
			</div><!-- row -->
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
						<label class="control-label">Telepon <code>*</code></label>
						<input type="text" name="data[telepon]" id="telepon" class="form-control" mandatory="yes" value="<?php echo $data['telepon']; ?>">
					</div>
				</div><!-- col-sm-2 -->
				<div class="col-sm-5">
					<div class="form-group">
						<label class="control-label">No. Surat Tugas / Kuasa <code>*</code></label>
						<input type="text" name="data[no_surat_tugas]" id="no_surat_tugas" class="form-control" mandatory="yes" value="<?php echo $data['no_surat_tugas']; ?>">
					</div>
				</div><!-- col-sm-5 -->
				<div class="col-sm-5">
					<div class="form-group">
						<label class="control-label">Email <code>*</code></label>
						<input type="text" name="data[email]" id="email" class="form-control" mandatory="yes" value="<?php echo $data['email']; ?>">
					</div>
				</div><!-- col-sm-5 -->
			</div>
			<div class="row" style="margin-top: 1%">
				<div class="form-group">
					<div class="col-sm-12">
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="panel-btns">
									<a href="#" class="minimize">−</a>
								</div><!-- panel-btns -->
								<h3 class="panel-title">Detil Barang</h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped mb30" id="tbl-barang-pemusnahan">
										<thead>
											<tr>
												<th width="20%">Kode Barang</th>
												<th width="20%">Uraian Barang</th>
												<th width="23%">Jenis Barang</th>
												<th width="12%">Kondisi Barang</th>
												<th width="10%">Jumlah</th>
												<th width="10%">Satuan</th>
												<th width="5%">Action</th>
											</tr>
										</thead>
										<tbody>
											<tr id="tr_1">
												<td><input type="text" name="DETIL[KD_BARANG][]" id="KODE_BARANG_1" class="form-control" onfocus="Autocomp(this.id)" url="<?php echo site_url('autocomplete/barang'); ?>" urai="UR_BRG_1;JNS_BRG_1;KD_SATUAN_1;UR_JNS_1;" mandatory="yes"></td>
												<td><input type="text" id="UR_BRG_1" class="form-control" disabled="true"></td>
												<td><input type="text" id="UR_JNS_1" class="form-control" disabled="true"><input type="hidden" name="DETIL[JNS_BARANG][]" id="JNS_BRG_1" class="form-control"></span></td>
												<td><input type="text" name="DETIL[KONDISI][]" id="KONDISI_BARANG_1" class="form-control"mandatory="yes"></td>
												<td><input type="text" name="DETIL[JML_SATUAN][]" id="JML_BARANG_1" class="form-control" mandatory="yes"></td>
												<td><input type="text" name="DETIL[KD_SATUAN][]" id="KD_SATUAN_1" class="form-control" readonly="true"></td>
												<td><a href="javascript:void(0);" class="btn btn-info btn-add-pemusnahan"><i class="fa fa-plus"></i></a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div><!-- panel -->
					</div>
				</div>
			</div>
		    <div class="panel-footer">
		      <button class="btn btn-primary btn-save" type="submit">Save</button>
		    </div>
	   	</form>
  	</div>
</div>