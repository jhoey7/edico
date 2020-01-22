<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-btns">
				<a href="#" class="minimize">−</a>
			</div>
			<h4 class="panel-title">Form Setting</h4>
		</div>
		<div class="panel-body">
			<form id="form_setting" name="form_setting" action="<?php echo site_url('execute/process/save/setting'); ?>" method="post" autocomplete="off" onSubmit="save_post('form_setting',''); return false;" novalidate="novalidate">
				<div class="row">
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Quantity Format</label>
							<div class="rdio rdio-danger">
								<input type="radio" name="DATA[format_qty]" value="0" id="format_qty" <?php if($data['format_qty']=="0"){ echo "checked";}?> checked />
								<label for="format_qty" style="padding-left:10px;"><code>999,999</code></label>
							</div>

							<div class="rdio rdio-danger">
								<input type="radio" name="DATA[format_qty]" value="2" id="format_qty2" <?php if($data['format_qty']=="2"){ echo "checked";}?> />
								<label for="format_qty2" style="padding-left:10px;"><code>999,999.99</code></label>
							</div>

							<div class="rdio rdio-danger">
								<input type="radio" name="DATA[format_qty]" value="4" id="format_qty4" <?php if($data['format_qty']=="4"){ echo "checked";}?> />
								<label for="format_qty4" style="padding-left:10px;"><code>999,999.9999</code></label>
							</div>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Currency Format</label>
							<div class="rdio rdio-primary">
								<input type="radio" name="DATA[format_currency]" value="0" id="format_currency" <?php if($data['format_currency']=="0"){ echo "checked";}?> checked />
								<label for="format_currency" style="padding-left:10px;"><code>999,999</code></label>
							</div>

							<div class="rdio rdio-primary">
								<input type="radio" name="DATA[format_currency]" value="2" id="format_currency2" <?php if($data['format_currency']=="2"){ echo "checked";}?> />
								<label for="format_currency2" style="padding-left:10px;"><code>999,999.99</code></label>
							</div>

							<div class="rdio rdio-primary">
								<input type="radio" name="DATA[format_currency]" value="4" id="format_currency4" <?php if($data['format_currency']=="4"){ echo "checked";}?> />
								<label for="format_currency4" style="padding-left:10px;"><code>999,999.9999</code></label>
							</div>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Realisasi By ?</label>
							<div class="rdio rdio-success">
								<input type="radio" name="DATA[tipe_dokumen]" value="0" id="tipe_dokumen" <?php if($data['tipe_dokumen']=="0"){ echo "checked";}?> checked />
								<label for="tipe_dokumen" style="padding-left:10px;">TPB Ceisa</label>
							</div>

							<div class="rdio rdio-success">
								<input type="radio" name="DATA[tipe_dokumen]" value="1" id="tipe_dokumen2" <?php if($data['tipe_dokumen']=="1"){ echo "checked";}?> />
								<label for="tipe_dokumen2" style="padding-left:10px;">Dokumen Internal</label>
							</div>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Show Nomor Aju ?</label>
							<div class="rdio rdio-success">
								<input type="radio" name="DATA[show_aju]" value="Y" id="show_aju" <?php if($data['show_aju']=="Y"){ echo "checked";}?> checked />
								<label for="show_aju" style="padding-left:10px;">Yes</label>
							</div>

							<div class="rdio rdio-success">
								<input type="radio" name="DATA[show_aju]" value="N" id="show_aju2" <?php if($data['show_aju']=="N"){ echo "checked";}?> />
								<label for="show_aju2" style="padding-left:10px;">No</label>
							</div>
						</div>
					</div>
				</div>
			</div><!-- panel-body -->

			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-5 col-sm-offset-5">
						<button type="submit" class="btn btn-primary" onclick="save_post('form_setting',''); return false;">Submit</button>
						<button type="reset" class="btn btn-default">Reset</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>