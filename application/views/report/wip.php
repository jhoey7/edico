<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-btns">
	    <a href="#" class="minimize">−</a>
	  </div>
	  <h4 class="panel-title">Laporan Posisi Barang Dalam Proses (WIP)</h4>
	  <p>List data yang ditampilkan adalah data yang WIP yang terjadi di bulan berjalan. Cari berdasarkan tanggal untuk mencari data lainnya.</p>
	</div>
	<div class="panel-body">
	  <form class="form-inline" method="post" action="<?php echo site_url('report/wip'); ?>" onSubmit="view_report('frm-laporan'); return false;" id="frm-laporan" name="frm-laporan" autocomplete="off">
	    <div class="form-group">
	      <label class="sr-only" for="tgl-awal">Tanggal Awal</label>
	      <input type="text" class="form-control date" id="tgl-awal" name="tgl_awal" placeholder="Tanggal Awal">
	    </div>
	    <div class="form-group">
	      <label class="sr-only" for="tgl-akhir">Tanggal Akhir</label>
	      <input type="text" class="form-control date" id="tgl-akhir" name="tgl_akhir" placeholder="Tanggal Akhir">
	    </div>
	    <button type="submit" class="btn btn-primary">Search</button>
	    <button type="reset" class="btn btn-default">Reset</button>
	  </form>
	  <div class="table-responsive" style="padding-top: 10px;">
			<table class="table table-bordered mb30 data-table-report" url="<?php echo site_url('report/wip'); ?>" style="font-size: 11px;">
				<thead>
					<tr>
						<th width="2%">#</th>
						<th width="13%">Nomor Transaksi</th>
						<th width="15%">Kode Barang</th>
						<th width="30%">Uraian Barang</th>
						<th width="10%">Satuan</th>
						<th width="10%">Jumlah</th>
						<th width="20%">Keterangan</th>
					</tr>
				</thead>
			</table>
		</div><!-- table-responsive -->
	</div><!-- panel-body -->
</div>