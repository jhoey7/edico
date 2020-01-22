<div class="col-md-12">
	<form id="form_<?php echo $tipe; ?>" name="form_<?php echo $tipe; ?>" action="<?php echo site_url('execute/process/'.$action.'/'.$tipe.'/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_post('form_<?php echo $tipe; ?>','divtbl<?php echo $tipe; ?>'); return false;" novalidate="novalidate">
		<?php if($action == "update") {
			if($tipe_dokumen == "0") {
				echo '<input type="hidden" readonly="true" name="no_inout_hidden" value="'.$data['no_inout'].'" />';
			} else {
				echo '<input type="hidden" readonly="true" name="no_aju_hidden" value="'.$data['nomor_aju'].'" />';
				echo '<input type="hidden" readonly="true" name="jns_dokumen" value="'.$data['jns_dokumen'].'" />';
			}
		} ?>
		<div class="panel-body">
			<?php if($tipe_dokumen == "0") { ?>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">No. <?php echo strtoupper($tipe); ?> <span class="asterisk">*</span></label>
						<input type="text" name="DATA[no_inout]" id="no_inout" class="form-control" placeholder="No <?php echo strtoupper($tipe); ?>..." mandatory="yes" value="<?php echo $data['no_inout']; ?>">
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Source Doukumen <span class="asterisk">*</span></label>
						<input type="text" name="DATA[source_dokumen]" id="source_dokumen" class="form-control" mandatory="yes" placeholder="<?php echo $placeholder; ?>" value="<?php echo $data['source_dokumen']; ?>">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Tgl. <?php echo strtoupper($tipe); ?> <span class="asterisk">*</span></label>
						<input type="text" name="tgl_grn" id="tgl_grn" class="form-control date" placeholder="Tgl <?php echo strtoupper($tipe); ?>..." mandatory="yes" value="<?php echo $data['tgl_grn']; ?>" <?php echo $disabled; ?>>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Waktu <?php echo strtoupper($tipe); ?> </label>
						<div class="bootstrap-timepicker"><input type="text" name="wk_grn" id="wk_grn" class="form-control time" placeholder="Waktu <?php echo strtoupper($tipe); ?>..." value="<?php echo $data['wk_grn']; ?>" <?php echo $disabled; ?>></div>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label"><?php echo $title; ?> <span class="asterisk">*</span></label>
						<?php echo form_dropdown('DATA[partner_id]', $combo_partner, $data['partner_id'], 'id="partner_id" '.$disabled.' class="form-control" mandatory="yes"'); ?>
					</div>
				</div>
			</div>

			<?php if (in_array($this->session->userdata('FAS_PABEAN'), array(3,4))) { ?>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Kode Valuta <span class="asterisk">*</span></label>
						<input type="hidden" readonly="true" name="DATA[kd_valuta]" value="<?php echo $data['kd_valuta']; ?>" id="kd_valuta" />
						<div class="input-group">
							<input type="text" id="ur_valuta" class="form-control" placeholder="Kode Valuta ..." mandatory="yes" value="<?php echo $data['uraian_valuta']; ?>" disabled="true" />
							<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_valuta/kd_valuta|ur_valuta/2');"><i class="glyphicon glyphicon-search"></i></span>
						</div>
					</div>
				</div>
			</div>
			<?php } } else { ?>
			<div class="row">
				<?php if ($this->session->userdata('SHOW_AJU') == "Y") { ?>
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">No. Aju <span class="asterisk">*</span></label>
						<input type="text" name="DATA[nomor_aju]" id="nomor_aju" class="form-control" placeholder="No Aju ..." mandatory="yes" value="<?php echo $data['nomor_aju']; ?>" maxlength="26">
					</div>
				</div>
				<?php } ?>

				<div class="col-sm-<?php echo ($this->session->userdata('SHOW_AJU') == "Y") ? "6" : "12" ?>">
					<div class="form-group">
						<label class="control-label">Source Doukumen <span class="asterisk">*</span></label>
						<input type="text" name="DATA[source_dokumen]" id="source_dokumen" class="form-control" mandatory="yes" placeholder="<?php echo $placeholder; ?>" value="<?php echo $data['source_dokumen']; ?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Nomor Daftar <span class="asterisk">*</span></label>
						<input type="text" name="DATA[no_daftar]" id="no_daftar" class="form-control" placeholder="Nomor Daftar ..." mandatory="yes" value="<?php echo $data['no_daftar']; ?>" maxlength="8" />
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Tanggal Daftar <span class="asterisk">*</span></label>
						<input type="text" name="DATA[tgl_daftar]" id="tgl_daftar" class="form-control date" placeholder="Tanggal Daftar ..." mandatory="yes" value="<?php echo $data['tgl_daftar']; ?>" />
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label"><?php echo $title; ?> <span class="asterisk">*</span></label>
						<?php echo form_dropdown('DATA[partner_id]', $combo_partner, $data['partner_id'], 'id="partner_id" '.$disabled.' class="form-control" mandatory="yes"'); ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jenis Doukumen <span class="asterisk">*</span></label>
						<?php echo form_dropdown('DATA[jns_dokumen]', $combo_dokumen, $data['jns_dokumen'], 'id="jns_dokumen" class="form-control" mandatory="yes"'); ?>
					</div>
				</div>

				<?php if (in_array($this->session->userdata('FAS_PABEAN'), array(3,4))) { ?>
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Kode Valuta <span class="asterisk">*</span></label>
							<input type="hidden" readonly="true" name="DATA[kd_valuta]" value="<?php echo $data['kd_valuta']; ?>" id="kd_valuta" />
							<div class="input-group">
								<input type="text" id="ur_valuta" class="form-control" placeholder="Kode Valuta ..." mandatory="yes" value="<?php echo $data['uraian_valuta']; ?>" disabled="true" />
								<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_valuta/kd_valuta|ur_valuta/2');"><i class="glyphicon glyphicon-search"></i></span>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div><!-- panel-body -->
		<div class="panel-footer">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-5">
					<button type="submit" class="btn btn-primary" onclick="save_post('form_<?php echo $tipe; ?>','divtbl<?php echo $tipe; ?>'); return false;">Submit</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$(function(){
		date('date');
		time('time');
	});
</script>