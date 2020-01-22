<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					DATA BARANG JADI
				</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in" style="height: auto;">
			<div class="panel-body">
				<div class="activity-list">
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Nomor Konversi</strong>
						</span>
						<?php echo $data['no_konversi']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Kode Barang Jadi</strong>
						</span>
						<?php  echo $data['kd_brg']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Jenis Barang</strong>
						</span>
						<?php echo $data['jns_barang']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Uraian Barang Jadi</strong>
						</span>
						<?php echo $data['nm_brg']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Keterangan</strong>
						</span>
						<?php echo $data['keterangan']; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapse-details">
					DATA BHAN BAKU
				</a>
			</h4>
		</div>
		<div id="collapse-details" class="panel-collapse collapse" style="height: 0px;">
			<div class="panel-body">
				<?php echo $bahan_baku['content']; ?>
			</div>
		</div>
	</div>
</div>