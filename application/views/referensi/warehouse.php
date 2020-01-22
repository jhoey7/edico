<div class="col-md-12">
	<form id="form_warehouse" name="form_warehouse" action="<?php echo site_url('execute/process/'.$action.'/warehouse/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_post('form_warehouse','divtblwarehouse'); return false;" novalidate="novalidate">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-btns">
					<a href="#" class="panel-close">×</a>
					<a href="#" class="minimize">−</a>
				</div>
				<h4 class="panel-title">Form Warehouse</h4>
				<p>Please provide your warahouse name & description.</p>
			</div>
			<div class="panel-body">

				<div class="form-group">
					<label class="col-sm-2 control-label">Kode Warehouse <span class="asterisk">*</span></label>
					<div class="col-sm-10">
						<input type="text" name="DATA[kode]" id="kode" class="form-control" placeholder="Kode warehouse..." mandatory="yes" value="<?php echo $data['kode']; ?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Nama Warehouse <span class="asterisk">*</span></label>
					<div class="col-sm-10">
						<input type="text" name="DATA[nama]" id="nama" class="form-control" placeholder="Nama warehouse..." mandatory="yes" value="<?php echo $data['nama']; ?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Deskripsi <span class="asterisk">*</span></label>
					<div class="col-sm-10">
						<textarea rows="2" class="form-control" id="uraian" name="DATA[uraian]" placeholder="Descripsi..." mandatory="yes"><?php echo $data['uraian']; ?></textarea>
					</div>
				</div>
			</div><!-- panel-body -->
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-6">
						<button type="submit" class="btn btn-primary" onclick="save_post('form_warehouse','divtblwarehouse'); return false;">Submit</button>
						<button type="reset" class="btn btn-default">Reset</button>
					</div>
				</div>
			</div>
		</div><!-- panel -->
	</form>
</div>