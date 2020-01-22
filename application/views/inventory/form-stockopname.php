<div class="col-md-12">
	<form id="form_stockopname" name="form_stockopname" action="<?php echo site_url('execute/process/'.$action.'/stockopname/'.$tgl_stock."~".$id); ?>" method="post" autocomplete="off" onSubmit="save_popup('form_stockopname','divtblstockopnamedtl'); return false;" novalidate="novalidate">
        <div class="row">
            <div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Kode Barang<span class="asterisk">*</span></label>
                    <?php if ($action == "save") { ?>
					<div class="input-group">
						<input type="hidden" readonly="true" id="id_barang" name="DATA[id_barang]" value="<?php echo $data['id_barang']; ?>" />
						<input type="text" id="kd_brg" class="form-control" placeholder="Kode Barang Bahan Baku ..." disabled="true" mandatory="yes" value="<?php echo $data['kd_brg']; ?>" />
						<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_barang|1/id_barang|kd_brg|uraian_barang|jns_brg/2');"><i class="glyphicon glyphicon-search"></i></span>
					</div>
                    <?php } else { ?>
                    <input type="text" id="kd_brg" class="form-control" placeholder="Kode Barang Bahan Baku ..." disabled="true" mandatory="yes" value="<?php echo $data['kd_brg']; ?>" />
                    <?php } ?>
				</div>
			</div>

            <div class="col-sm-6">
                <div class="form-group">
					<label class="control-label">Jenis Barang <span class="asterisk">*</span></label>
					<input type="text" id="jns_brg" class="form-control" placeholder="Jenis Barang ..." mandatory="yes" disabled="disabled" value="<?php echo $data['jenis_barang']; ?>" />
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
					<input type="text" name="DATA[jml_stockopname]" id="jml_stockopname" class="form-control" placeholder="Jumlah Satuan ..." value="<?php echo $data['jml_stockopname']; ?>" mandatory="yes" onkeyup="this.value = ThausandSeperator('',this.value,<?php echo $this->session->userdata('FORMAT_QTY'); ?>);" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Warehouse <span class="asterisk">*</span></label>
                    <input type="hidden" readonly="true" name="DATA[id_gudang]" value="<?php echo $data['id_gudang']; ?>" id="id_gudang" />
                    <?php if ($action == "save") { ?>
                    <div class="input-group">
                        <input type="text" id="ur_warehouse" class="form-control" placeholder="Warehouse ..." mandatory="yes" value="<?php echo $data['warehouse_name']; ?>" disabled="true" />
                        <span class="input-group-addon" style="cursor: pointer;" onclick="getBarangGudang();"><i class="glyphicon glyphicon-search"></i></span>
                    </div>
                    <?php } else { ?>
                    <input type="text" id="ur_warehouse" class="form-control" placeholder="Warehouse ..." mandatory="yes" value="<?php echo $data['warehouse_name']; ?>" disabled="true" />
                    <?php } ?>
                </div>
            </div>
        </div>

		<div class="panel-footer">
			<div class="row">
				<div class="col-sm-12" style="text-align: center;">
					<button type="submit" class="btn btn-primary" onclick="save_popup('form_stockopname','divtblstockopnamedtl'); return false;">Submit</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
        <input type="hidden" readonly="true" name="id_barang_hidden" value="<?php echo $data['id_barang']; ?>" />
	</form>
</div>
<script type="text/javascript">
    function getBarangGudang() {
        var $id_barang = $('#id_barang').val();
        console.log($id_barang);
        if ($id_barang != "") {
            popup_searchtwo('popup/popup_search/mst_barang_gudang|'+ $id_barang +'/id_gudang|ur_warehouse/2');
        } else {
            notify('Pilih barang terlebih dahulu ya...','warning');
        }
    }
</script>