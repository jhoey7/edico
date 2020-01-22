<div class="col-md-12">
	<form id="form_<?php echo $tipe; ?>_dtl" name="form_<?php echo $tipe; ?>_dtl" action="<?php echo site_url('execute/process/'.$action.'/'.$tipe.'_details/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_popup('form_<?php echo $tipe; ?>_dtl','divtbl<?php echo $tipe; ?>dtl'); return false;" novalidate="novalidate">
		<input type="hidden" readonly="true" name="DATA[id_barang]" id="id_barang" value="<?php echo $data['id_barang']; ?>">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Kode Barang <span class="asterisk">*</span></label>
						<div class="input-group">
							<input type="text" id="kd_brg" class="form-control" placeholder="Kode Barang ..." value="<?php echo $data['kd_brg']; ?>" disabled="true" />
							<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_barang/id_barang|kd_brg|uraian_barang|jns_brg/2');"><i class="glyphicon glyphicon-search"></i></span>
						</div>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Kode Satuan <span class="asterisk">*</span></label>
						<div class="input-group">
							<input type="text" name="DATA[kd_satuan]" id="kd_satuan" class="form-control" placeholder="Kode Satuan ..." value="<?php echo $data['kd_satuan']; ?>" mandatory="yes" readonly="true"/>
							<span class="input-group-addon" style="cursor: pointer;" onclick="getSatuanBarang();"><i class="glyphicon glyphicon-search"></i></span>
						</div>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Jumlah Satuan <span class="asterisk">*</span></label>
						<input type="text" name="DATA[jml_satuan]" id="jml_satuan" class="form-control" placeholder="Jumlah Satuan ..." value="<?php echo $data['jml_satuan']; ?>" mandatory="yes" onkeyup="this.value = ThausandSeperator('',this.value,<?php echo $this->session->userdata('FORMAT_QTY'); ?>);" />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jenis Barang <span class="asterisk">*</span></label>
						<input type="text" id="jns_brg" class="form-control" placeholder="Jenis Barang ..." mandatory="yes" value="<?php echo $data['jenis_barang']; ?>" disabled="disabled" />
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Unit Price <span class="asterisk">*</span></label>
						<input type="text" name="DATA[unit_price]" id="unit_price" class="form-control" placeholder="Unit Price ..." value="<?php echo $data['unit_price']; ?>" mandatory="yes" onkeyup="this.value = ThausandSeperator('',this.value,<?php echo $this->session->userdata('FORMAT_CURRENCY'); ?>);" />
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Price <span class="asterisk">*</span></label>
						<input type="text" name="DATA[price]" id="price" class="form-control" placeholder="Price ..." value="<?php echo $data['price']; ?>" mandatory="yes" onkeyup="this.value = ThausandSeperator('',this.value,<?php echo $this->session->userdata('FORMAT_CURRENCY'); ?>);" />
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Uraian Barang <span class="asterisk">*</span></label>
						<input type="text" id="uraian_barang" class="form-control" placeholder="Uraian Barang ..." mandatory="yes" value="<?php echo $data['nm_brg']; ?>" disabled="disabled" />
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Warehouse <span class="asterisk">*</span></label>
						<input type="hidden" readonly="true" name="DATA[id_warehouse]" value="<?php echo $data['id_warehouse']; ?>" id="id_warehouse" />
						<div class="input-group">
							<input type="text" id="ur_warehouse" class="form-control" placeholder="Warehouse ..." mandatory="yes" value="<?php echo $data['warehouse_name']; ?>" disabled="true" />
							<span class="input-group-addon" style="cursor: pointer;" onclick="getBarangGudang();"><i class="glyphicon glyphicon-search"></i></span>
						</div>
					</div>
				</div>
			</div>
			<?php if (in_array($this->session->userdata('FAS_PABEAN'), array(3,4))) { ?>
				<div class="row">
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Seri Barang <span class="asterisk">*</span></label>
							<input type="text" id="seri_barang" name="DATA[seri_barang]" class="form-control" placeholder="Seri Barang ..." mandatory="yes" value="<?php echo $data['seri_barang']; ?>" style="text-align: center;" />
						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Negara <?php echo $tipe == "grn" ? "Asal" : "Tujuan" ?> Barang <span class="asterisk">*</span></label>
							<input type="hidden" readonly="true" name="DATA[kd_negara_asal]" value="<?php echo $data['kd_negara_asal']; ?>" id="kd_negara_asal" />
							<div class="input-group">
								<input type="text" id="ur_negara_asal" class="form-control" placeholder="Negara Asal ..." mandatory="yes" value="<?php echo $data['ur_negara_asal']; ?>" disabled="true" />
								<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_negara/kd_negara_asal|ur_negara_asal/2');"><i class="glyphicon glyphicon-search"></i></span>
							</div>
						</div>
					</div>
					
					<div class="col-sm-3" style="padding-top: 3em;">
						<div class="ckbox ckbox-default">
							<input type="checkbox" id="chk_asal_barang" name="chk_asal_barang" <?php echo ($data['asal_barang'] == "I" || $data['asal_barang'] == "") ? 'checked="true"' : ""; ?> />
							<label for="chk_asal_barang" style="padding-left: 7px !important;">Barang Impor ?</label>
						</div>
					</div>
				</div>
			<?php } ?>
		</div><!-- panel-body -->
		<div class="panel-footer">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-5">
					<button type="submit" class="btn btn-primary" onclick="save_popup('form_<?php echo $tipe; ?>_dtl','divtbl<?php echo $tipe; ?>dtl'); return false;">Submit</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	function getBarangGudang() {
		var $id_barang = $('#id_barang').val();
		console.log($id_barang);
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