<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-btns">
	    <a href="#" class="minimize">−</a>
	  </div>
	  <h4 class="panel-title">Laporan Pengeluaran Barang Perdokumen Pabean</h4>
	  <p>Cari berdasarkan tanggal untuk mencari data lainnya.</p>
	</div>
	<div class="panel-body">
	  	<form method="post" id="frm_laporan" name="frm_laporan" autocomplete="off">
		    <div class="row row-pad-5">
				<div class="col-lg-1">
					<input type="text" class="form-control date" id="tgl-awal" name="tgl_awal" placeholder="Tgl. Awal">
				</div>
				<div class="col-lg-1">
					<input type="text" class="form-control date" id="tgl-akhir" name="tgl_akhir" placeholder="Tgl. Akhir">
				</div>
				<div class="col-lg-2">
					<input type="text" class="form-control" id="nomor_aju" name="nomor_aju" placeholder="Nomor Aju">
				</div>
				<div class="col-lg-2">
					<?php echo form_dropdown('kd_dok', $kd_dok, "", 'id="kd_dok" class="form-control"'); ?>
				</div>
				<div class="col-lg-2">
					<div class="ckbox checkbox ckbox-success">
						<input type="checkbox" id="all" name="all">
						<label for="all" style="padding-left: 3px;">By Document ?</label>
					</div>
				</div>
			</div>
		    <div class="btn-group">
			    <a href="javascript:void(0);" class="btn btn-primary" onclick="Laporan('frm_laporan', 'table-laporan','<?php echo site_url('report/proses/pengeluaran');?>','laporan');"><i class="fa fa-search"></i>&nbsp;Search</a>
			    <button type="reset" class="btn btn-default"><i class="fa fa-undo"></i>&nbsp;Reset</button>
			    <div class="btn-group">
			        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
			            Action <span class="caret"></span>
			        </button>
			        <ul class="dropdown-menu" role="menu">
			            <li><a href="javascript:void(0);" onClick="print_report('pengeluaran','pdf')">Export to PDF</a></li>
			            <li><a href="javascript:void(0);" onClick="print_report('pemasukan','xls')">Export to XLS</a></li>
			        </ul>
			    </div>
		    </div>
			<div class="table-responsive" style="padding-top: 10px;"><div class="table-responsive table-laporan"></div></div><!-- table-responsive -->
		</form>
	</div><!-- panel-body -->
</div>
<script type="text/javascript">
	$(function(){
		date('date');
		time('time');
	});
</script>