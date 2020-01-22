<div class="col-md-12">
	<form id="form_barang" name="form_barang" action="<?php echo site_url('execute/process/'.$action.'/barang/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_post('form_barang','divtblbarang'); return false;" novalidate="novalidate">
		<input type="hidden" readonly="true" name="action" id="action" value="<?php echo site_url('inventory/barang'); ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-btns">
					<a href="#" class="panel-close">×</a>
					<a href="#" class="minimize">−</a>
				</div>
				<h4 class="panel-title">Form Barang</h4>
				<p>Please provide your supplier name, address, country.</p>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Kode HS</label>
							<input type="text" name="DATA[kd_hs]" id="kd_hs" class="form-control" placeholder="Kode HS..." value="<?php echo $data['kd_hs']; ?>">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Kode Barang <span class="asterisk">*</span></label>
							<input type="text" name="DATA[kd_brg]" id="kd_brg" class="form-control" placeholder="Kode barang..." mandatory="yes" value="<?php echo $data['kd_brg']; ?>" <?php echo $disabled; ?>>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Jenis Barang <span class="asterisk">*</span></label>
							<?php echo form_dropdown('DATA[jns_brg]', $jns_barang, $data['jns_brg'], 'id="jns_brg" '.$disabled.' class="form-control" mandatory="yes"'); ?>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Uraian Barang <span class="asterisk">*</span></label>
							<input type="text" name="DATA[nm_brg]" id="nm_brg" class="form-control" placeholder="Uraian barang..." mandatory="yes" value="<?php echo $data['nm_brg']; ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Satuan Terbesar <span class="asterisk">*</span></label>
							<input type="hidden" readonly="true" name="DATA[kd_satuan]" value="<?php echo $data['kd_satuan']; ?>" id="kd_satuan" />
							<div class="input-group">
								<input type="text" id="ur_kd_satuan" class="form-control" placeholder="Satuan Terbesar ..." mandatory="yes" value="<?php echo $data['ur_kd_satuan']; ?>" disabled="true" />
								<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_satuan/kd_satuan|ur_kd_satuan/2');"><i class="glyphicon glyphicon-search"></i></span>
							</div>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Satuan Terkecil</label>
							<input type="hidden" readonly="true" name="DATA[kd_satuan_terkecil]" value="<?php echo $data['kd_satuan_terkecil']; ?>" id="kd_satuan_terkecil" />
							<div class="input-group">
								<input type="text" id="ur_kd_satuan_terkecil" class="form-control" placeholder="Satuan Terkecil ..." value="<?php echo $data['ur_kd_satuan_terkecil']; ?>" disabled="true" />
								<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_satuan/kd_satuan_terkecil|ur_kd_satuan_terkecil/2');"><i class="glyphicon glyphicon-search"></i></span>
							</div>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Nilai Konversi </label>
							<input type="text" name="DATA[nilai_konversi]" id="nilai_konversi" class="form-control" placeholder="Nilai Konversi..." value="<?php echo $data['nilai_konversi']; ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-striped mb30 tbl-warehouse">
									<thead>
										<tr>
											<th width="90%">Warehouse</th>
											<th width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($action == "save") {
										?>
											<tr class="tr_first">
												<td><?php echo form_dropdown('WAREHOUSE[ID_GUDANG][]', $warehouse, $data['jns_brg'], 'id="wh-1" class="form-control" mandatory="yes"'); ?></td>
												<td><a href="javascript:void(0);" class="btn btn-success btn-sm add-warehouse"><i class="fa fa-plus"></i></a></td>
											</tr>
										<?php } elseif ($action == "update") {
											$no = 1;
											foreach ($barang_gudang as $val) { 
												if ($no == 1) {
													$class = "class=\"tr_first\"";
													$id = "id=\"wh-1\"";
													$class_btn = "class=\"btn btn-success btn-sm add-warehouse\"";
													$onclick = "";
												} else {
													$class = "class=\"".$no."\"";
													$id = "id=\"".$no."\"";
													$class_btn = "class=\"btn btn-danger btn-sm\"";
													$onclick = "onclick=\"delete_row('".$no."')\"";
												}
										?>
												<tr <?php echo $class; ?>>
													<td><?php echo form_dropdown('WAREHOUSE[ID_GUDANG][]', $warehouse, $val['id_gudang'], '"'.$id.' class="form-control" mandatory="yes"'); ?></td>
													<td><a href="javascript:void(0);" <?php echo $class_btn; ?> <?php echo $onclick; ?>><i class="fa fa-plus"></i></a><input type="hidden" readonly name="id_<?php echo $val['id_gudang']; ?>" value="<?php echo $val['id'];?>" /></td>
												</tr>
										<?php
												$no++;
											}
										} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div><!-- panel-body -->
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-6">
						<button type="submit" class="btn btn-primary" onclick="save_post('form_barang','divtblbarang'); return false;">Submit</button>
						<button type="reset" class="btn btn-default">Reset</button>
					</div>
				</div>
			</div>
		</div><!-- panel -->
	</form>
</div>