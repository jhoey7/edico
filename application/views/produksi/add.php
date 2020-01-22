<div class="col-md-12">
	<form id="form_<?php echo $tipe; ?>" name="form_<?php echo $tipe; ?>" action="<?php echo site_url('execute/process/'.$action.'/'.$tipe.'/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_post('form_<?php echo $tipe; ?>','divtbl<?php echo $tipe; ?>'); return false;" novalidate="novalidate">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="control-label">No. Bukti <?php echo $title; ?> Gudang <span class="asterisk">*</span></label>
					<input type="text" name="DATA[no_bukti_inout]" id="no_bukti_inout" class="form-control" placeholder="No. Bukti <?php echo $title; ?> Gudang ..." value="<?php echo $data['no_bukti_inout']; ?>" mandatory="yes" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Tgl. <?php echo $title; ?> Gudang <span class="asterisk">*</span></label>
					<input type="text" name="tgl_produksi" id="tgl_produksi" class="form-control date" placeholder="Tgl. <?php echo $title; ?> Gudang ..." mandatory="yes" value="<?php echo $data['tgl_inout']; ?>" />
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Jam </label>
					<div class="bootstrap-timepicker"><input type="text" name="wk_produksi" id="wk_produksi" class="form-control time" placeholder="Jam ..." value="<?php echo $data['wk_inout']; ?>" /></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="control-label">Keterangan </label>
					<textarea class="form-control" id="keterangan" name="DATA[keterangan]"><?php echo $data['keterangan']; ?></textarea>
				</div>
			</div>
		</div>

		<div class="panel-footer">
			<div class="row">
				<div class="col-sm-12" style="text-align: center;">
					<button type="submit" class="btn btn-primary" onclick="save_post('form_<?php echo $tipe; ?>','divtbl<?php echo $tipe; ?>'); return false;">Submit</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
		<input type="hidden" name="no_bukti_inout_hidden" value="<?php echo $data['no_bukti_inout']; ?>" readonly="true"/>
	</form>
</div>
<script>
	$(function(){
		date('date');
		time('time');
	});
</script>