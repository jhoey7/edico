<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-btns">
	    <a href="#" class="minimize">&minus;</a>
	  </div><!-- panel-btns -->
	  <h3 class="panel-title">Data Pemusnahan Barang</h3>
	  <p>Menampilkan seluruh data pemusnahan barang yang terdapat di Pemusnahan.</p>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover mb30 data-table" width="100%" url="<?php echo site_url('pemusnahan/daftar'); ?>" style="font-size: 12px;" url-add="<?php echo site_url('pemusnahan/daftar/add'); ?>">
				<thead>
					<tr>
						<th width="2%">#</th>
						<th width="10%">No. Surat</th>
						<th width="10%">Tgl. SUrat</th>
						<th width="15%">Kantor Tujuan</th>
						<th width="14%">Perihal</th>
						<th width="12%">Nama Pemohon</th>
						<th width="12%">ID Pemohon</th>
						<th width="12%">No. SUrat Tugas</th>
						<th width="13%" class="action">&nbsp;</th>
					</tr>
				</thead>
			</table>
		</div><!-- table-responsive -->
	</div>
</div>