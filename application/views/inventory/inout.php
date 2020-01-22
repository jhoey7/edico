<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-btns">
	    <a href="#" class="minimize">&minus;</a>
	  </div><!-- panel-btns -->
	  <h3 class="panel-title">Penelusuran Keluar Masuk Barang</h3>
	  <p>Silahkan Cari Berdasarkan Periode Tanggal, Kode Barang & Jenis Barang.</p>
	</div>
	<div class="panel-body">
		<form id="frm_laporan" name="frm_laporan" action="<?php echo site_url('inventory/inout'); ?>" method="post" autocomplete="off" onSubmit="mutasi('frm_laporan'); return false;" novalidate="novalidate">
			<div class="form-group">
				<label class="col-sm-2 control-label">
					Periode
				</label>
				<div class="col-sm-2">
					<input type="text" class="form-control date" id="tgl-awal" name="tgl_awal" placeholder="Tgl. Awal">
				</div>
				<div class="col-sm-2">
					<input type="text" class="form-control date" id="tgl-akhir" name="tgl_akhir" placeholder="Tgl. Akhir">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">
					Kode Barang
				</label>
				<div class="col-sm-4">
					<div class="input-group">
						<input type="text" class="form-control" id="kode_barang" name="kode_barang" disabled="true">
						<input type="hidden" class="form-control" id="id_barang" name="id_barang" readonly="true">
						<span class="input-group-addon" style="cursor: pointer;" onclick="popup_searchtwo('popup/popup_search/mst_barang_inout/id_barang|kode_barang|jenis_barang/2');"><i class="glyphicon glyphicon-search"></i></span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Jenis Barang</label>
				<div class="col-sm-2">
					<?php echo form_dropdown('jenis_barang', $jenis_barang, '', 'id="jenis_barang"  class="form-control"'); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">
					&nbsp;
				</label>
			    <div class="col-sm-10">
				    <a href="javascript:void(0);" class="btn btn-primary btn-search" onclick="mutasi('frm_laporan'); return false;">
				    	<i class="fa fa-search"></i>&nbsp;Search
				    </a>
				    <button type="reset" class="btn btn-default"><i class="fa fa-undo"></i>&nbsp;Reset</button>
			    </div>
			</div>
			<div class="table-responsive table-laporan"></div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		date('date');
		time('time');
	});

	function updateinout(form) {
		swal({
			title: 'Confirm',
			text: 'Perhatian: Proses berikut akan merubah jumlah stock akhir barang sejumlah Total saldo dibawah. Anda yakin Akan memproses data ini?',
			type: 'info',
			showCancelButton: true,
			closeOnConfirm: true,
			showLoaderOnConfirm: true,
		}, function (r) {	
			if (r) {
				$.ajax({
					type: 'POST',
					dataType: "json",
					url: site_url + '/execute/process/update/inout',
					data: $('[name="' + form + '"]').serialize(),
					beforeSend: function () { Loading(true) },
					complete: function () { Loading(false) },
					success: function (result) {
						var format = JSON.stringify(result);
						var data = JSON.parse(format);

						if (Object.keys(data).length > 0) {
							if (data.status == "success") {
								setTimeout(function () { location.href = data._url; }, 1500);
								notify(data.message, 'success');
								return false;
							} else {
								Loading(false)
								notify(data.message, 'error');
							}
						}
					}
				}).responseJSON;
			} else {
				return false;
			}
		});
	}
</script>