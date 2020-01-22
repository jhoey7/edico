<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">DATA HEADER</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in" style="height: auto;">
			<div class="panel-body">
				<div class="activity-list">
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>No. <?php echo strtoupper($tipe); ?></strong>
						</span>
						<?php echo $data['no_inout']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Tgl. <?php echo strtoupper($tipe); ?></strong>
						</span>
						<?php 
							if ($data['tgl_grn']){
								$date = date_create($data['tgl_grn']);
								echo date_format($date,"d F Y")." ".$data['wk_grn'];
							}
						?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Source Dokumen</strong>
						</span>
						<?php echo $data['source_dokumen']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong><?php echo ($tipe == "grn" ? "Partner" : "Customer"); ?></strong>
						</span>
						<?php echo $data['nm_supplier']; ?>
					</div>
					<?php if (in_array($this->session->userdata('FAS_PABEAN'), array(3,4))) { ?>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Kode Valuta</strong>
							</span>
							<?php echo $data['kd_valuta']." - ".$data['uraian_valuta']; ?>
						</div>
					<?php } ?>
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
				<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapsePabean">DATA PABEAN</a>
			</h4>
		</div>
		<div id="collapsePabean" class="panel-collapse collapse" style="height: 0px;">
			<div class="panel-body">
				<div class="activity-list">
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Jenis Dokumen</strong>
						</span>
						BC <?php echo $data['jns_dokumen']; ?>
					</div>
					<?php if($this->session->userdata('SHOW_AJU') == "Y") { ?>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Nomor Aju</strong>
						</span>
						<?php echo $data['nomor_aju']?>
					</div>
					<?php } ?>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Nomor Pendaftaran</strong>
						</span>
						<?php echo $data['no_daftar']; ?>
					</div>
					<div class="media act-media">
						<span class="pull-left" style="width: 200px;">
							<strong>Tanggal Pendaftaran</strong>
						</span>
						<?php
						if ($data['tgl_daftar']){
							$date = date_create($data['tgl_daftar']);
							echo date_format($date,"d F Y");
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapse-details">DATA BARANG</a>
			</h4>
		</div>
		<div id="collapse-details" class="panel-collapse collapse" style="height: 0px;">
			<div class="panel-body">
				<?php echo $details['content']; ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#tblgrnhdr').removeClass("panel-body");
	});
</script>