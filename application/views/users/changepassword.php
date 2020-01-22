<div class="col-md-12">
	<div class="panel panel-default">
		<form method="post" action="<?php echo site_url('users/execute/passwod'); ?>" autocomplete="off" name="form-password" id="form-password" onSubmit="post_data('form-password'); return false;">
			<div class="panel-heading">
				<div class="panel-btns">
					<a href="#" class="minimize">−</a>
				</div>
				<h4 class="panel-title">Form Change Password</h4>
				<p><code>(*)</code> Mandatory Field.</p>
			</div>
			<div class="panel-body">
				<input type="hidden" name="action" value="change-password" readonly="true">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Password Lama <code>*</code></label>
							<input type="password" name="password_lama" id="password-lama" class="form-control" mandatory="yes" >
						</div>
					</div><!-- col-sm-4 -->
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Password Baru <code>*</code></label>
							<input type="password" name="password_baru" id="password-baru" class="form-control" mandatory="yes" >
						</div>
					</div><!-- col-sm-4 -->
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Ulangi Password Baru <code>*</code></label>
							<input type="password" name="confirm_password" id="confirm_password" class="form-control" mandatory="yes" >
						</div>
					</div><!-- col-sm-4 -->
				</div><!-- row -->
			</div><!-- panel-body -->
			<div class="panel-footer">
				<button class="btn btn-primary btn-save" type="submit">Save</button>
			</div>
		</form>
	</div>
</div>