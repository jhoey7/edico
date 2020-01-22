<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-btns">
        <a href="#" class="minimize">−</a>
      </div>
      <h4 class="panel-title">Form Role</h4>
      <p><code>(*)</code> Mandatory Field.</p>
    </div>
	<form id="form_role" name="form_role" action="<?php echo site_url('execute/process/'.$action.'/role/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_post('form_role','divtblrole'); return false;" novalidate="novalidate">
		<input type="hidden" readonly="true" name="action" id="action" value="<?php echo site_url('users/role'); ?>">
    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label class="control-label">Role Name <code>*</code></label>
						<input type="text" name="uraian" id="uraian" class="form-control" mandatory="yes" value="<?php echo $data['uraian']; ?>" <?php echo $disabled; ?>>
					</div>
				</div><!-- col-sm-4 -->
			</div><!-- row -->
			<div class="row mb15">
				<div class="col-sm-12 mb15">
					<div class="form-group">
						<label class="control-label">Grant Menu</label>
						<?php  echo $menu; ?>
					</div>
				</div>
			</div>
		</div><!-- panel-body -->
		<div class="panel-footer">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-6">
					<button type="submit" class="btn btn-primary" onclick="save_post('form_role','divtblrole'); return false;">Submit</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
	</form>
  </div>
</div>