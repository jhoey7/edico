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
					<label class="col-sm-2 control-label">PERIODE</label>
					<div class="col-sm-2">
						<input type="text" class="form-control date" id="tgl-awal" name="tgl_awal" placeholder="Tgl. Awal">
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control date" id="tgl-akhir" name="tgl_akhir" placeholder="Tgl. Akhir">
					</div>
				</div>

				<div class="form-group">
				    <div class="btn-group">
					    <a href="javascript:void(0);" class="btn btn-primary" onclick="Laporan('frm_laporan', 'table-laporan','<?php echo site_url('report/proses/penyelesaian_waste');?>','laporan');"><i class="fa fa-search"></i>&nbsp;Search</a>
					    <button type="reset" class="btn btn-default"><i class="fa fa-undo"></i>&nbsp;Reset</button>
					    <div class="btn-group">
					        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
					            Action <span class="caret"></span>
					        </button>
					        <ul class="dropdown-menu" role="menu">
					            <li><a href="javascript:void(0);" onClick="print_report('penyelesaian_waste','pdf')">Export to PDF</a></li>
					            <li><a href="javascript:void(0);" onClick="print_report('penyelesaian_waste','xls')">Export to XLS</a></li>
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