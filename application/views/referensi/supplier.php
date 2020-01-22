<div class="col-md-12">
	<form id="form_supplier" name="form_supplier" action="<?php echo site_url('execute/process/'.$action.'/supplier/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_post('form_supplier','divtblsupplier'); return false;" novalidate="novalidate">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-btns">
					<a href="#" class="panel-close">×</a>
					<a href="#" class="minimize">−</a>
				</div>
				<h4 class="panel-title">Form Supplier</h4>
				<p>Please provide your supplier name, address, country.</p>
			</div>
			<div class="panel-body">

				<div class="form-group">
					<label class="col-sm-2 control-label">Nama Supplier <span class="asterisk">*</span></label>
					<div class="col-sm-10">
						<input type="text" name="DATA[nm_supplier]" id="nm_supplier" class="form-control" placeholder="Nama supplier..." mandatory="yes" value="<?php echo $data['nm_supplier']; ?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Alamat Supplier <span class="asterisk">*</span></label>
					<div class="col-sm-10">
						<textarea rows="2" class="form-control" id="almt_supplier" name="DATA[almt_supplier]" placeholder="Alamat supplier..." mandatory="yes"><?php echo $data['almt_supplier']; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Negara Supplier <span class="asterisk">*</span></label>
					<div class="col-sm-1">
						<input type="text" name="DATA[kd_negara]" id="kd_negara" class="form-control" placeholder="Kode..." mandatory="yes" readonly="true" value="<?php echo $data['kd_negara']; ?>">
					</div>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="negara_supplier" id="negara_supplier" class="form-control" placeholder="Uraian..." mandatory="yes" value="<?php echo $data['uraian_negara']; ?>" readonly>
							<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_negara/kd_negara|negara_supplier/2');"><i class="glyphicon glyphicon-search"></i></span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">NPWP Supplier <span class="asterisk">*</span></label>
					<div class="col-sm-10">
						<input type="text" name="DATA[npwp_supplier]" id="npwp_supplier" class="form-control" placeholder="NPWP supplier..." mandatory="yes" value="<?php echo $data['npwp_supplier']; ?>">
					</div>
				</div>
			</div><!-- panel-body -->
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-6">
						<button type="submit" class="btn btn-primary" onclick="save_post('form_supplier','divtblsupplier'); return false;">Submit</button>
						<button type="reset" class="btn btn-default">Reset</button>
					</div>
				</div>
			</div>
		</div><!-- panel -->
	</form>
</div>