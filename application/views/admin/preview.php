<div class="panel-group" id="accordion">
	<form method="post" action="<?php echo site_url('execute/process/save/company/'.$id); ?>" autocomplete="off" name="form-process" id="form-process" onSubmit="save_post('form-process','divtblcompany'); return false;">
		<input type="hidden" readonly="true" name="action" value="<?php echo site_url('admin/company/new'); ?>" />
		<div style="padding-bottom: 5px; width: 100%; text-align: left;">
			<button class="btn btn-danger btn-sm" type="submit"><i class="glyphicon glyphicon-check"></i>&nbsp;APPROVE</button>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">
						Data Perusahaan
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
				<div class="panel-body">
					<div class="activity-list">
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Nama Perusahaan</strong>
							</span>
							<?php echo $company['NAMA']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Alamat Perusahaan</strong>
							</span>
							<?php echo $company['ALAMAT']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Telepon Perusahaan</strong>
							</span>
							<?php echo $company['TELEPON']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>NPWP</strong>
							</span>
							<?php echo $company['NPWP']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Bidang Usaha</strong>
							</span>
							<?php echo $company['BIDANG_USAHA']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Status Perusahaan</strong>
							</span>
							<?php echo $company['STATUS_USAHA']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Fasilitas Kepabeanan</strong>
							</span>
							<?php echo $company['FASILITAS_PERUSAHAAN']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo">
						Data Pemilik
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" style="height: 0px;">
				<div class="panel-body">
					<div class="activity-list">
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Nama Pemilik</strong>
							</span>
							<?php echo $company['NAMA_PEMILIK']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Alamat Pemilik</strong>
							</span>
							<?php echo $company['ALAMAT_PEMILIK']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Telepon Pemilik</strong>
							</span>
							<?php echo $company['TELP_PEMILIK']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Email</strong>
							</span>
							<?php echo $company['EMAIL']; ?>
						</div>
						<div class="media act-media">
							<span class="pull-left" style="width: 200px;">
								<strong>Jabatan</strong>
							</span>
							<?php echo $company['JABATAN']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>