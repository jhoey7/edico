<div class="panel panel-default">
	<div class="panel-heading">
	  <div class="panel-btns">
	    <a href="#" class="minimize">&minus;</a>
	  </div><!-- panel-btns -->
	  <h3 class="panel-title">Form Stockopname</h3>
	  <!-- <p>Menampilkan seluruh data stockopname yang terdapat di Inventory Data Stockopname.</p> -->
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-sm-2 control-label"><strong>TANGGAL STOCKOPNAME</strong></label>
			<div class="col-sm-2">
				<?php echo $data['tgl_stock'] ?>
			</div>
		</div>
		<div class="table-responsive">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">DETAIL BARANG STOCKOPNAME</h3>
				</div>
				<div class="panel-body">
					<?php echo $tabel['content']; ?>
				</div>
			</div>
		</div><!-- table-responsive -->
	</div>
</div>