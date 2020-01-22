<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-btns">
	    <a href="#" class="minimize">−</a>
	  </div>
	  <h4 class="panel-title">Laporan <?php echo $title; ?></h4>
	  <p>Cari berdasarkan tanggal untuk mencari data lainnya.</p>
	</div>
	<div class="panel-body">
	  	<form method="post" id="frm_laporan" name="frm_laporan" autocomplete="off">
			<div class="form-group">
				<div class="form-group">
					<label class="col-sm-3 control-label">TANGGAL BUKTI <?php echo ($tipe=="pemasukan_hp" ? "PEMASUKAN" : "PENGELUARAN") ?></label>
					<div class="col-sm-2">
						<input type="text" class="form-control date" id="tgl-awal" name="tgl_awal" placeholder="Tgl. Awal">
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control date" id="tgl-akhir" name="tgl_akhir" placeholder="Tgl. Akhir">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">
						<select name="no_bc" id="no_bc" class="form-control">
							<option value="1">NO. BUKTI <?php echo ($tipe=="pemasukan_hp" ? "PEMASUKAN" : "PENGELUARAN") ?></option>
							<option value="2">KODE BARANG</option>
						</select>
					</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="txt_no_bc" name="txt_no_bc" maxlength="26">
					</div>
				</div>

				<div class="form-group">
				    <div class="btn-group">
					    <a href="javascript:void(0);" class="btn btn-primary" onclick="Laporan('frm_laporan', 'table-laporan','<?php echo site_url('report/proses/'.$tipe);?>','laporan');"><i class="fa fa-search"></i>&nbsp;Search</a>
					    <button type="reset" class="btn btn-default"><i class="fa fa-undo"></i>&nbsp;Reset</button>
					    <div class="btn-group">
					        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
					            Action <span class="caret"></span>
					        </button>
					        <ul class="dropdown-menu" role="menu">
					            <li><a href="javascript:void(0);" onClick="print_report('<?php echo $tipe;?>','pdf')">Export to PDF</a></li>
					            <li><a href="javascript:void(0);" onClick="print_report('<?php echo $tipe;?>','xls')">Export to XLS</a></li>
					        </ul>
					    </div>
				    </div>
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