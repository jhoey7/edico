<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-btns">
	    <a href="#" class="minimize">−</a>
	  </div>
	  <h4 class="panel-title">Laporan Pemasukan Bahan Baku</h4>
	  <p>Cari berdasarkan tanggal untuk mencari data lainnya.</p>
	</div>
	<div class="panel-body">
	  	<form method="post" id="frm_laporan" name="frm_laporan" autocomplete="off">
			<div class="form-group">
				<label class="col-sm-2 control-label">
					<select name="date_type" id="date_type" class="form-control">
						<option value="1">TANGGAL REALISASI</option>
						<option value="2">TANGGAL DAFTAR</option>
					</select>
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
					<select name="no_bc" id="no_bc" class="form-control">
						<option value="1">NOMOR AJU</option>
						<option value="2">NOMOR DAFTAR</option>
						<option value="3">NO. GRN</option>
					</select>
				</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="txt_no_bc" name="txt_no_bc" maxlength="26">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">KODE DOKUMEN</label>
				<div class="col-sm-4">
					<?php echo form_dropdown('kd_dok', $kd_dok, "", 'id="kd_dok" class="form-control"'); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">ASAL BARANG</label>
				<div class="col-sm-4">
					<?php echo form_dropdown('asal_barang', array(""=>"","I"=>"IMPOR","L"=>"LOKAL"), "", 'id="asal_barang" class="form-control"'); ?>
				</div>
			</div>

			<div class="form-group">
			    <div class="btn-group">
				    <a href="javascript:void(0);" class="btn btn-primary" onclick="Laporan('frm_laporan', 'table-laporan','<?php echo site_url('report/proses/pemasukan_bb');?>','laporan');"><i class="fa fa-search"></i>&nbsp;Search</a>
				    <button type="reset" class="btn btn-default"><i class="fa fa-undo"></i>&nbsp;Reset</button>
				    <a href="javascript:void(0);" class="btn btn-danger" onclick="print_report('pemasukan_bb','pdf')"><i class="fa fa-printer"></i>&nbsp;Search</a>
				    <a href="javascript:void(0);" class="btn btn-success" onclick="print_report('pemasukan_bb','xls')"><i class="fa fa-printer"></i>&nbsp;Search</a>
			    </div>
			</div>
			<div class="table-responsive table-laporan"></div>
		</form>
	</div><!-- panel-body -->
</div>
<script type="text/javascript">
	$(function(){
		date('date');
		time('time');
	});
</script>