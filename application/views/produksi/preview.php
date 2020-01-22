<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					DATA HEADER
				</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in" style="height: auto;">
			<div class="panel-body">
				<div class="activity-list">
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>No. Bukti Pengeluaran</strong>
						</span>
						<?php echo $data['no_bukti_inout']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Tgl. Bukti Pengeluaran</strong>
						</span>
						<?php 
							$date = date_create($data['tgl_inout']);
							echo date_format($date,"d F Y")." ".$data['wk_inout'];
						?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Keterangan</strong>
						</span>
						<?php echo $data['keterangan']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Status</strong>
						</span>
						<?php echo $data['status']; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapse-details">
					DATA DETAIL
				</a>
			</h4>
		</div>
		<div id="collapse-details" class="panel-collapse collapse" style="height: 0px;">
			<div class="panel-body">
				<?php echo $detail['content']; ?>
			</div>
		</div>
	</div>
</div>