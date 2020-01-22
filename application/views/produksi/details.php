<div class="col-md-12">
	<form id="form_details" name="form_details" action="<?php echo site_url('execute/process/'.$action.'/produksi_details/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_popup('form_details','divtblproduksidtl'); return false;" novalidate="novalidate">
		<input type="hidden" readonly="true" name="type" id="type" value="<?php echo $tipe; ?>">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Kode Barang <span class="asterisk">*</span></label>
					<div class="input-group">
						<input type="hidden" readonly="true" id="id_barang" name="DATA[id_barang]" value="<?php echo $data['id_barang']; ?>" />
						<input type="text" id="kd_brg" class="form-control" placeholder="Kode Barang ..." disabled="true" mandatory="yes" value="<?php echo $data['kd_brg']; ?>" />
						<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_barang/id_barang|kd_brg|uraian_barang|jns_brg/2');"><i class="glyphicon glyphicon-search"></i></span>
					</div>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="form-group">
					<label class="control-label">Kode Satuan <span class="asterisk">*</span></label>
					<div class="input-group">
						<input type="text" id="kd_satuan" name="DATA[kd_satuan]" class="form-control" placeholder="Kode Satuan ..." value="<?php echo $data['kd_satuan']; ?>" mandatory="yes" readonly="true"/>
						<span class="input-group-addon" style="cursor: pointer;" onclick="getSatuanBarang();"><i class="glyphicon glyphicon-search"></i></span>
					</div>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="form-group">
					<label class="control-label">Jumlah Satuan <span class="asterisk">*</span></label>
					<input type="text" id="jml_satuan" name="DATA[jml_satuan]" class="form-control" placeholder="Jumlah Satuan ..." mandatory="yes" onkeyup="this.value = ThausandSeperator('',this.value,<?php echo $this->session->userdata('FORMAT_QTY'); ?>);" value="<?php echo number_format($data['jml_satuan'],$this->session->userdata('FORMAT_QTY')); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Jenis Barang <span class="asterisk">*</span></label>
					<input type="text" id="jns_brg" class="form-control" placeholder="Jenis Barang ..." mandatory="yes" disabled="disabled" value="<?php echo $data['jns_barang']; ?>" />
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Warehouse <span class="asterisk">*</span></label>
					<input type="hidden" readonly="true" id="id_warehouse" name="DATA[id_gudang]" value="<?php echo $data['id_gudang']; ?>" />
					<div class="input-group">
						<input type="text" id="ur_warehouse" class="form-control" placeholder="Warehouse ..." mandatory="yes" disabled="true" value="<?php echo $data['nama_gudang']; ?>" />
						<span class="input-group-addon" style="cursor: pointer;" onclick="getBarangGudang();"><i class="glyphicon glyphicon-search"></i></span>
					</div>
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
					<label class="control-label">Keterangan </label>
					<input type="text" id="keterangan" class="form-control" name="DATA[keterangan]" placeholder="Keterangan ..." value="<?php echo $data['keterangan']; ?>" />
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-5">
					<button type="submit" class="btn btn-primary" onclick="save_popup('form_details','divtblproduksidtl'); return false;">Submit</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	function getBarangGudang() {
		var $id_barang = $('#id_barang').val();
		if ($id_barang != "") {
			popup_searchtwo('popup/popup_search/mst_barang_gudang|'+ $id_barang +'/id_warehouse|ur_warehouse/2');
		} else {
			notify('Pilih barang terlebih dahulu ya...','warning');
		}
	}

	function getSatuanBarang() {
		var $id_barang = $('#id_barang').val();
		if ($id_barang != "") {
			popup_searchtwo('popup/popup_search/mst_satuan_barang|'+ $id_barang +'/kd_satuan/2');
		} else {
			notify('Pilih barang terlebih dahulu ya...','warning');
		}
	}
</script>