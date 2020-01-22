<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-btns">
        <a href="#" class="minimize">−</a>
      </div>
      <h4 class="panel-title">Pemusnahan</h4>
    </div>
    <div class="panel-body">
		<div class="row">
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">Tanggal Surat</h4>
                    <p class="email-summary"><strong><?php echo $header['TGL_SURAT']; ?></strong></p>
                </div>
			</div><!-- col-sm-3 -->
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">Nomor Surat</h4>
                    <p class="email-summary"><strong><?php echo $header['NO_SURAT']; ?></strong></p>
                </div>
			</div><!-- col-sm-3 -->
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">Perihal</h4>
                    <p class="email-summary"><strong><?php echo $header['PERIHAL']; ?></strong></p>
                </div>
			</div><!-- col-sm-3 -->
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">Kantor Tujuan</h4>
                    <p class="email-summary"><strong><?php echo $header['KD_KANTOR_TUJUAN']; ?></strong></p>
                </div>
			</div><!-- col-sm-3 -->
		</div><!-- row -->
      
		<div class="row">
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">Nama Pemohon</h4>
                    <p class="email-summary"><strong><?php echo $header['NM_PEMOHON']; ?></strong></p>
                </div>
			</div><!-- col-sm-3 -->
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">Nomor Identitas</h4>
                    <p class="email-summary"><strong><?php echo $header['ID_PEMOHON']; ?></strong></p>
                </div>
			</div><!-- col-sm-3 -->
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">Telepon</h4>
                    <p class="email-summary"><strong><?php echo $header['TELEPON']; ?></strong></p>
                </div>
			</div><!-- col-sm-3 -->
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">No. Surat Tugas / Kuasa</h4>
                    <p class="email-summary"><strong><?php echo $header['NO_SURAT_TUGAS']; ?></strong></p>
                </div>
			</div><!-- col-sm-5 -->
			<div class="col-sm-3">
				<div class="media-body">
                    <h4 class="text-primary">Email</h4>
                    <p class="email-summary"><strong><?php echo $header['EMAIL']; ?></strong></p>
                </div>
			</div><!-- col-sm-3 -->
		</div>
		<div class="row" style="margin-top: 1%">
			<div class="form-group">
				<div class="col-sm-12">
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-btns">
								<a href="#" class="minimize">−</a>
							</div><!-- panel-btns -->
							<h3 class="panel-title">Detil Barang</h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped mb30">
									<thead>
										<tr>
											<th width="20%">Kode Barang</th>
											<th width="20%">Uraian Barang</th>
											<th width="23%">Jenis Barang</th>
											<th width="12%">Kondisi Barang</th>
											<th width="10%">Jumlah</th>
											<th width="10%">Satuan</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(count($detil) > 0) {
											foreach($detil as $data) {
												echo "<tr>";
												echo "<td>".$data['KD_BARANG']."</td>";
												echo "<td>".$data['NM_BRG']."</td>";
												echo "<td>".$data['JNS_BARANG']."</td>";
												echo "<td>".$data['KONDISI']."</td>";
												echo "<td>".$data['JML_SATUAN']."</td>";
												echo "<td>".$data['KD_SATUAN']."</td>";
											}
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div><!-- panel -->
				</div>
			</div>
		</div>
  	</div>
</div>