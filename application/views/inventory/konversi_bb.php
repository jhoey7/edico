<div class="col-md-12">
	<form id="form_konversi_bb" name="form_konversi_bb" action="<?php echo site_url('execute/process/'.$action.'/konversi_bb/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_popup('form_konversi_bb','divtblkonversidtl'); return false;" novalidate="novalidate">
        <div class="row">
            <div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Kode Barang Bahan Baku <span class="asterisk">*</span></label>
					<div class="input-group">
						<input type="hidden" readonly="true" id="id_barang" name="DATA[id_barang]" value="<?php echo $data['id_barang']; ?>" />
						<input type="text" id="kd_brg" class="form-control" placeholder="Kode Barang Bahan Baku ..." disabled="true" mandatory="yes" value="<?php echo $data['kd_brg']; ?>" />
						<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_barang|1/id_barang|kd_brg|uraian_barang|jns_brg/2');"><i class="glyphicon glyphicon-search"></i></span>
					</div>
				</div>
			</div>

            <div class="col-sm-6">
                <div class="form-group">
					<label class="control-label">Jenis Barang <span class="asterisk">*</span></label>
					<input type="text" id="jns_brg" class="form-control" placeholder="Jenis Barang ..." mandatory="yes" disabled="disabled" value="<?php echo $data['jns_barang']; ?>" />
				</div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Uraian Barang <span class="asterisk">*</span></label>
					<input type="text" id="uraian_barang" class="form-control" placeholder="Uraian Barang ..." mandatory="yes" disabled="disabled" value="<?php echo $data['nm_brg']; ?>" />
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Jumlah Barang <span class="asterisk">*</span></label>
					<input type="text" name="DATA[jml_satuan]" id="jml_satuan" class="form-control" placeholder="Jumlah Satuan ..." value="<?php echo $data['jml_satuan']; ?>" mandatory="yes" onkeyup="this.value = ThausandSeperator('',this.value,<?php echo $this->session->userdata('FORMAT_QTY'); ?>);" />
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
					<button type="submit" class="btn btn-primary" onclick="save_popup('form_konversi_bb','divtblkonversidtl'); return false;">Submit</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
        <input type="hidden" readonly="true" name="id_barang_hidden" value="<?php echo $data['id_barang']; ?>" />
	</form>
</div>