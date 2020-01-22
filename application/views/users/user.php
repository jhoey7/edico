<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-btns">
        <a href="#" class="minimize">−</a>
      </div>
      <h4 class="panel-title">Form User</h4>
      <p><code>(*)</code> Mandatory Field.</p>
    </div>
    <div class="panel-body">
    	<form id="form_user" name="form_user" action="<?php echo site_url('execute/process/'.$action.'/user/'.$id); ?>" method="post" autocomplete="off" onSubmit="save_post('form_user','divtbluser'); return false;" novalidate="novalidate">
		<input type="hidden" readonly="true" name="action" id="action" value="<?php echo site_url('users/user'); ?>">
	      <div class="row">
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label class="control-label">Email <code>*</code></label>
	            <input type="text" name="DATA[email]" id="email" class="form-control" mandatory="yes" value="<?php echo $data['email']; ?>" <?php echo $disabled; ?> >
	          </div>
	        </div><!-- col-sm-4 -->
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label class="control-label">Nama <code>*</code></label>
	            <input type="text" name="DATA[nama]" id="nama" class="form-control" mandatory="yes" value="<?php echo $data['nama']; ?>">
	          </div>
	        </div><!-- col-sm-4 -->
	      </div><!-- row -->
	      
	      <div class="row">
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label class="control-label">Telepon</label>
	            <input type="text" name="DATA[telepon]" id="telepon" class="form-control" value="<?php echo $data['telepon']; ?>">
	          </div>
	        </div><!-- col-sm-4 -->
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label class="control-label">Status <code>*</code></label>
	            <?php echo form_dropdown('DATA[STATUS]', $status, $data['status_user'], 'id="status_user" class="form-control" mandatory="yes"'); ?>
	          </div>
	        </div><!-- col-sm-4 -->
	      </div><!-- row -->
	      <div class="row">
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label class="control-label">Role <code>*</code></label>
	            <?php echo form_dropdown('DATA[USER_ROLE]', $kode_role, $data['user_role'], 'id="kode_role" class="form-control" mandatory="yes"'); ?>
	          </div>
	        </div><!-- col-sm-4 -->
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label class="control-label">Alamat</label>
	            <textarea class="form-control" name="DATA[alamat]" id="alamat"><?php echo $data['alamat']; ?></textarea>
	          </div>
	        </div><!-- col-sm-12 -->
		  </div>
	    </div><!-- panel-body -->
	    <div class="panel-footer">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-6">
					<button type="submit" class="btn btn-primary" onclick="save_post('form_user','divtbluser'); return false;">Submit</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
	   </form>
  </div>
</div>