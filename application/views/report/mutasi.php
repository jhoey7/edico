<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-btns">
			<a href="#" class="minimize">−</a>
		</div>
		<h4 class="panel-title">Laporan Mutasi</h4>
		<p>Pencarian Laporan Mutasi Berdasarkan Tangal Realisasi.</p>
	</div>
	<div class="panel-body">
		<form method="post" action="<?php echo site_url('report/proses/mutasi'); ?>" onSubmit="mutasi('frm_laporan'); return false;" id="frm_laporan" name="frm_laporan" autocomplete="off">
			<div class="form-group">
				<label class="col-sm-2 control-label">JENIS BARANG</label>
				<div class="col-sm-4">
					<?php echo form_dropdown('jns_brg', $jns_barang, "", 'id="jns_brg" class="form-control" mandatory="yes"'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">PERIODE</label>
				<div class="col-sm-2">
					<input type="text" class="form-control date" id="tgl-awal" name="tgl_awal" placeholder="Tgl. Awal">
				</div>
				<div class="col-sm-2">
					<input type="text" class="form-control date" id="tgl-akhir" name="tgl_akhir" placeholder="Tgl. Akhir">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">KODE BARANG</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="kd_barang" name="kd_barang" placeholder="Kode Barang">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-1">
					<div class="ckbox checkbox ckbox-default">
						<input type="checkbox" id="all" name="all">
						<label for="all" style="margin-top: 7px !important;">Show All</label>
					</div>
				</div>
			</div>

			<div class="form-group">
			    <div class="btn-group">
				    <a href="javascript:void(0);" class="btn btn-primary" onclick="Laporan('frm_laporan', 'table-laporan','<?php echo site_url('report/proses/mutasi');?>','laporan');"><i class="fa fa-search"></i>&nbsp;Search</a>
				    <button type="reset" class="btn btn-default"><i class="fa fa-undo"></i>&nbsp;Reset</button>
				    <div class="btn-group">
				        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
				            Action <span class="caret"></span>
				        </button>
				        <ul class="dropdown-menu" role="menu">
				            <li><a href="javascript:void(0);" onClick="print_report('mutasi','pdf')">Export to PDF</a></li>
				            <li><a href="javascript:void(0);" onClick="print_report('mutasi','xls')">Export to XLS</a></li>
				        </ul>
				    </div>
			    </div>
			</div>
			<!-- <button type="submit" class="btn btn-info btn-search">Search</button>
			<button type="reset" class="btn btn-default">Reset</button> -->
			<div class="table-laporan"></div>
		</form>
	</div><!-- panel-body -->
</div>
<script>
	$(function(){
		date('date');
	});
</script>