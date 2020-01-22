<div class="panel-group" id="accordion">
	<?php if($tipe_dokumen == "0") { ?>
	<div class="panel panel-default" style="overflow: visible ;">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					DATA PABEAN
				</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in" style="height: auto;">
			<div class="panel-body">
				<form id="form_realisasi_<?php echo $tipe; ?>" name="form_realisasi_<?php echo $tipe; ?>" action="<?php echo site_url('execute/process/'.$action.'/'.$tipe.'/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_popup('form_realisasi_<?php echo $tipe; ?>','divtbl<?php echo $tipe; ?>hdr'); return false;" novalidate="novalidate">
					<div class="row">
						<?php if($this->session->userdata('SHOW_AJU') == "Y") { ?>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">No. Aju <span class="asterisk">*</span></label>
								<input type="text" name="DATA[nomor_aju]" id="nomor_aju" class="form-control" placeholder="No Aju ..." mandatory="yes" maxlength="26" />
							</div>
						</div>
						<?php } ?>

						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">No. Pendaftaran <span class="asterisk">*</span></label>
								<input type="text" name="DATA[no_daftar]" id="no_daftar" class="form-control" placeholder="No. Pendaftaran ..." mandatory="yes" maxlength="8" />
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Tgl. Pendaftaran <span class="asterisk">*</span></label>
								<input type="text" name="DATA[tgl_daftar]" id="tgl_daftar" class="form-control date" placeholder="Tanggal Pendaftaran ..." mandatory="yes" />
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Tgl. Realisasi </label>
								<input type="text" name="tgl_realisasi" id="tgl_realisasi" class="form-control date" placeholder="Tgl Realsasi ..." />
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Waktu Realisasi </label>
								<div class="bootstrap-timepicker"><input type="text" name="wk_realisasi" id="wk_realisasi" class="form-control time" placeholder="Waktu Realisasi ..." /></div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Jenis Doukumen <span class="asterisk">*</span></label>
								<?php echo form_dropdown('DATA[jns_dokumen]', $combo_dokumen, "", 'id="jns_dokumen" class="form-control" mandatory="yes"'); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12" style="text-align: center; padding-top: 3px;">
							<button type="submit" class="btn btn-primary" onclick="save_popup('form_realisasi_<?php echo $tipe; ?>','divtbl<?php echo $tipe; ?>hdr'); return false;">Submit</button>
							<button type="reset" class="btn btn-default">Reset</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapse-details">
					DATA HEADER
				</a>
			</h4>
		</div>
		<div id="collapse-details" class="panel-collapse collapse" style="height: 0px;">
			<div class="panel-body">
				<div class="activity-list">
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>No. <?php echo strtoupper($tipe); ?></strong>
						</span>
						<?php echo $data['no_inout']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Tgl. <?php echo strtoupper($tipe); ?></strong>
						</span>
						<?php 
							if ($data['tgl_grn']) {
								$date = date_create($data['tgl_grn']);
								echo date_format($date,"d F Y")." ".$data['wk_grn'];
							}
						?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Source Dokumen</strong>
						</span>
						<?php echo $data['source_dokumen']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Partner</strong>
						</span>
						<?php echo $data['nm_supplier']; ?>
					</div>
					<?php if (in_array($this->session->userdata('FAS_PABEAN'), array(3,4))) { ?>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Kode Valuta</strong>
							</span>
							<?php echo $data['kd_valuta']." - ".$data['uraian_valuta']; ?>
						</div>
					<?php } ?>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Status</strong>
						</span>
						<?php echo $data['status']; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php } else { ?>
	<div class="panel panel-default" style="overflow: visible ;">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					DATA <?php echo strtoupper($tipe); ?>
				</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in" style="height: auto;">
			<div class="panel-body">
				<form id="form_realisasi_<?php echo $tipe; ?>" name="form_realisasi_<?php echo $tipe; ?>" action="<?php echo site_url('execute/process/'.$action.'/'.$tipe.'/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_popup('form_realisasi_<?php echo $tipe; ?>','divtbl<?php echo $tipe; ?>hdr'); return false;" novalidate="novalidate">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">No. <?php echo strtoupper($tipe); ?> <span class="asterisk">*</span></label>
								<input type="text" name="DATA[no_inout]" id="no_inout" class="form-control" placeholder="No <?php echo strtoupper($tipe); ?> ..." mandatory="yes" />
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Tgl. <?php echo strtoupper($tipe); ?> <span class="asterisk">*</span></label>
								<input type="text" name="tgl_grn" id="tgl_grn" class="form-control date" placeholder="Tgl <?php echo strtoupper($tipe); ?> ..." mandatory="yes" />
							</div>
						</div>

						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label">Waktu <?php echo strtoupper($tipe); ?> <span class="asterisk">*</span></label>
								<div class="bootstrap-timepicker"><input type="text" name="wk_grn" id="wk_grn" class="form-control time" placeholder="Waktu GRN ..." /></div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Tgl. Realisasi </label>
								<input type="text" name="tgl_realisasi" id="tgl_realisasi" class="form-control date" placeholder="Tgl Realsasi ..." />
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Waktu Realisasi </label>
								<div class="bootstrap-timepicker"><input type="text" name="wk_realisasi" id="wk_realisasi" class="form-control time" placeholder="Waktu Realisasi ..." /></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12" style="text-align: center; padding-top: 3px;">
							<button type="submit" class="btn btn-primary" onclick="save_popup('form_realisasi_<?php echo $tipe; ?>','divtbl<?php echo $tipe; ?>hdr'); return false;">Submit</button>
							<button type="reset" class="btn btn-default">Reset</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapse-details">
					DATA PABEAN
				</a>
			</h4>
		</div>
		<div id="collapse-details" class="panel-collapse collapse" style="height: 0px;">
			<div class="panel-body">
				<div class="activity-list">
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Jenis Dokumen</strong>
						</span>
						<?php echo "BC ".$data['jns_dokumen']; ?>
					</div>
					<?php if($this->session->userdata('SHOW_AJU') == "Y") { ?>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Nomor Aju</strong>
						</span>
						<?php echo $data['nomor_aju']; ?>
					</div>
					<?php } ?>

					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Nomor Daftar</strong>
						</span>
						<?php echo $data['no_daftar']; ?>
					</div>
					
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Tanggal Daftar</strong>
						</span>
						<?php 
							if ($data['tgl_daftar']) {
								$date = date_create($data['tgl_daftar']);
								echo date_format($date,"d F Y");
							}
						?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Source Dokumen</strong>
						</span>
						<?php echo $data['source_dokumen']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Partner</strong>
						</span>
						<?php echo $data['nm_supplier']; ?>
					</div>
					<?php if (in_array($this->session->userdata('FAS_PABEAN'), array(3,4))) { ?>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Kode Valuta</strong>
							</span>
							<?php echo $data['kd_valuta']." - ".$data['uraian_valuta']; ?>
						</div>
					<?php } ?>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Status</strong>
						</span>
						<?php echo $data['status']; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapsePabean">
					DATA BARANG
				</a>
			</h4>
		</div>
		<div id="collapsePabean" class="panel-collapse collapse" style="height: 0px;">
			<div class="panel-body">
				<?php echo $details['content']; ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		date('date');
		time('time');
	});
</script>