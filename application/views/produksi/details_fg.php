<div class="col-md-12">
	<form id="form_details" name="form_details" action="<?php echo site_url('execute/process/'.$action.'/produksi_details/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_popup('form_details','divtblproduksidtl'); return false;" novalidate="novalidate">
		<input type="hidden" readonly="true" name="type" id="type" value="<?php echo $tipe; ?>">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Nomor Konversi</label>
						<div class="input-group">
							<input type="hidden" readonly="true" id="id_konversi" name="DATA[id_konversi]" value="<?php echo $data['id_konversi']; ?>" />
							<input type="text" id="nomor_konversi" class="form-control" placeholder="Nomor Konversi ..." disabled="true" value="<?php echo $data['no_konversi']; ?>" />
							<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_konversi/id_konversi|nomor_konversi|kd_satuan|id_barang|kd_brg|jns_brg|uraian_barang/2');"><i class="glyphicon glyphicon-search"></i></span>
						</div>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Kode Satuan <span class="asterisk">*</span></label>
						<input type="text" id="kd_satuan" class="form-control" name="DATA[kd_satuan]" placeholder="Kode Satuan ..." value="<?php echo $data['kd_satuan']; ?>" mandatory="yes" readonly="true"/>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Jumlah Satuan <span class="asterisk">*</span></label>
						<input type="text" id="jml_satuan" class="form-control" name="DATA[jml_satuan]" placeholder="Jumlah Satuan ..." mandatory="yes" onkeyup="this.value = ThausandSeperator('',this.value,<?php echo $this->session->userdata('FORMAT_QTY'); ?>);" value="<?php echo number_format($data['jml_satuan'],$this->session->userdata('FORMAT_QTY')); ?>" />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Kode Barang <span class="asterisk">*</span></label>
						<input type="hidden" readonly="true" id="id_barang" name="DATA[id_barang]" value="<?php echo $data['id_barang']; ?>" />
						<input type="text" id="kd_brg" class="form-control" placeholder="Kode Barang ..." disabled="true" mandatory="yes" value="<?php echo $data['kd_brg']; ?>" />
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Warehouse <span class="asterisk">*</span></label>
						<div class="input-group">
							<input type="hidden" readonly="true" id="id_warehouse" name="DATA[id_gudang]" value="<?php echo $data['id_gudang']; ?>" />
							<input type="text" id="ur_warehouse" class="form-control" placeholder="Warehouse ..." mandatory="yes" disabled="true" value="<?php echo $data['nama_gudang']; ?>" />
							<span class="input-group-addon" style="cursor: pointer;" onclick="getBarangGudang();"><i class="glyphicon glyphicon-search"></i></span>
						</div>
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
						<label class="control-label">Keterangan </label>
						<input type="text" id="keterangan" class="form-control" name="DATA[keterangan]" placeholder="Keterangan ..." value="<?php echo $data['keterangan']; ?>" />
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
			</div>

			<div class="row" style="padding-top: 10px;">
				<div class="form-group">
					<div class="col-sm-12">
						<div class="table-responsive">
							<h5 class="subtitle mb5">Details Bahan Baku</h5>
							<p class="mb10" style="border-bottom: 1px solid #ddd;">
								Tekan <code>Tombol Load Bahan Baku</code> untuk menambahkan kode barang bahan baku dari konversi.
								<a href="javascript:void(0);" title="Load Bahan Baku" class="btn btn-default btn-sm load-bb" style="float:right; margin-top: -13px;"><i class="fa fa-refresh"></i>&nbsp;Load Bahan Baku</a>
							</p>
							<table class="table table-hidaction table-hover tbl-bahanbaku">
								<thead>
									<tr>
										<th width="1%">No</th>
										<th width="25%" style="text-align: left !important;">Kode Barang</th>
										<th width="30%" style="text-align: left !important;">Jenis Barang</th>
										<th width="15%">Jumlah</th>
										<th width="14%" style="text-align: left !important;">Satuan</th>
										<th width="15%">
											<a href="javascript:void(0);" title="Add Bahan Baku" class="btn btn-primary btn-sm add-bb"><i class="fa fa-plus"></i></a>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php if($action == "save") { ?>
									<tr id="tr_detil">
										<td colspan="6" align="center">Data Tidak Ditemukan.</td>
									</tr>
									<?php } else { 
										if (count($bahan_baku) > 0) {
											$no = 1;
											foreach ($bahan_baku as $row) {
									?>
									<tr id="tr_detail<?php echo $no; ?>">
									<td><span class="nop"><?php echo $no; ?></span></td>
									<td><input type="text" id="td_kdbrg<?php echo $no; ?>" class="form-control" value="<?php echo $row['kd_brg']; ?>" readonly/></td>
									<td><input type="text" id="td_jnsbrg<?php echo $no; ?>" class="form-control" value="<?php echo $row['jns_barang']; ?>" readonly/></td>
									<td><input type="text" id="jml_satuan_bb<?php echo $no; ?>" class="form-control jml_satuan_bb" value="<?php echo number_format($row['jml_satuan'], $this->session->userdata('FORMAT_QTY')); ?>" style="text-align: center;" name="DETIL[jml_satuan][]" /></td>
									<td><input type="text" id="td_satuan<?php echo $no; ?>" class="form-control" value="<?php echo $row['kode_satuan']; ?>" readonly/></td>
									<td align="center"><a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="popup_searchtwo('popup/popup_search/mst_barang_konversi|1/id_barang<?php echo $no; ?>|td_kdbrg<?php echo $no; ?>|td_jnsbrg<?php echo $no; ?>|td_satuan<?php echo $no; ?>/2');"><i class="fa fa-search"></i></a>&nbsp;<a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_bb(<?php echo $no; ?>)"><i class="fa fa-times"></i></a><input type="hidden" id="id_barang<?php echo $no; ?>" class="id_brg_bb" name="DETIL[id_barang][]" readonly value="<?php echo $row['id_barang']; ?>" /></td>
									<?php $no++; } } else { ?>
									<tr id="tr_detil">
										<td colspan="6" align="center">Data Tidak Ditemukan.</td>
									</tr>
									<?php } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div><!-- panel-body -->
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

	// $('#chk_gudang_produksi').click(function() {
	// 	if ($(this).is(":checked")) {
	// 		$('#ur_warehouse').removeAttr('mandatory');
	// 		$('#ur_warehouse').removeClass('mandatory');
	// 	} else if($(this).is(":not(:checked)")) {
	// 		$('#ur_warehouse').attr('mandatory','yes');
	// 	}
	// });

	$('.load-bb').click(function() {
		var $id_konversi = $('#id_konversi').val();
		if ($id_konversi == "") {
			notify('Pilih konversi terlebih dahulu ya...','warning');
		} else {
			$.ajax({
				type: 'POST',
				url: site_url + '/produksi/get_bahan_baku',
				data: { id : $id_konversi },
				success: function (data) {
					$(".tbl-bahanbaku tbody").remove();
					$(".tbl-bahanbaku").append(data);
				}
			});
		}
	});

	$('.add-bb').click(function() {
		var $nilai = $(".tbl-bahanbaku tbody tr").size();
		var $random = GetRandomMath();
		var $detil = "";
		detil = "<tr id=\"tr_detail" + $random + "\"><td><span class=\"nop\">" + $nilai + "</span></td><td><input type=\"text\" id=\"td_kdbrg"+$random+"\" class=\"form-control\" readonly/></td><td><input type=\"text\" id=\"td_jnsbrg"+$random+"\" class=\"form-control\" readonly/></td><td><input type=\"text\" id=\"jml_satuan_bb" + $random + "\" class=\"form-control jml_satuan_bb\" name=\"DETIL[jml_satuan][]\" style=\"text-align: center;\" /></td><td><input type=\"text\" id=\"td_satuan"+$random+"\" class=\"form-control\" readonly/></td><td align=\"center\"><a href=\"javascript:void(0);\" class=\"btn btn-success btn-sm\" onclick=\"popup_searchtwo('popup/popup_search/mst_barang_konversi|1/id_barang"+$random+"|td_kdbrg"+$random+"|td_jnsbrg"+$random+"|td_satuan"+$random+"/2');\"><i class=\"fa fa-search\"></i></a>&nbsp;<a href=\"javascript:void(0);\" class=\"btn btn-danger btn-sm\" onclick=\"delete_bb('"+$random+"')\"><i class=\"fa fa-times\"></i></a><input type=\"hidden\" id=\"id_barang" + $random + "\" class=\"id_brg_bb\" name=\"DETIL[id_barang][]\" readonly/></td></tr>";
		if ($nilai == 1) {
			$(".tbl-bahanbaku #tr_detil").remove();
			$(".tbl-bahanbaku tbody:first").append(detil);
			$(".tbl-bahanbaku tbody tr .nop").each(function (index, element) {
				$(this).html(parseFloat(index) + 1);
			});
		} else {
			$(".tbl-bahanbaku tbody:first").append(detil);
			$(".tbl-bahanbaku tbody tr .nop").each(function (index, element) {
				$(this).html(parseFloat(index) + 1);
			});
		}
	});

	function delete_bb(id) {
		$(".tbl-bahanbaku tr[id=tr_detail" + id + "]").remove();
		var nilai = $(".tbl-bahanbaku tbody tr").size();
		if (nilai == 0) {
			var content = '<tr id="tr_detil"><td align="center" style="background:#FFFFFF" colspan="6">Data Tidak Ditemukan</td></tr>';
			$(".tbl-bahanbaku tbody:first").append(content);
		}
		$(".tbl-bahanbaku tbody tr .nop").each(function (index, element) {
			$(this).html(parseFloat(index) + 1);
		});
	}
</script>