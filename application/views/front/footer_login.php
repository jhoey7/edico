<div class="col-lg-12">
  <div class="input-group-icon" style="text-align: center !important;" id="text-account">
    Belum memiliki akun? Daftar sekarang, yuk!
  </div>
  <div class="input-group-icon">
    <a href="javascript:void(0);" class="genric-btn primary radius mt-10" id="btn-footer" style="width: 100% !important;">DAFTAR</a>
  </div>
</div>
<script type="text/javascript">
	$('#btn-footer').on('click', function() {
        if($("#form-signin").is(":visible") == true) {
        	$("#form-registration").show();
        	$("#form-signin").hide();
        	$("#text-account").html('Kamu sudah memiliki akun?');
        	$("#btn-footer").html('MASUK KE INVENT 1');
        } else {
        	$("#form-registration").hide();
        	$("#form-signin").show();
        	$("#text-account").html('Belum memiliki akun? Daftar sekarang, yuk!');
        	$("#btn-footer").html('DAFTAR');
        }
    });
</script>