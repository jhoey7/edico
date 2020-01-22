<style type="text/css">
  .select-customize {
    height: 49px !important; 
    font-family: "Arial";
    font-size: 12px !important;
    font-weight: 300 !important;
    line-height: 1.625em !important;
  }
</style>
<section class="info-area" id="about">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <form id="form-signin" name="form-signin" method="post" autocomplete="off" onSubmit="signin('form-signin'); return false;" action="<?php echo site_url('home/signin'); ?>">
          <div class="input-group-icon mt-12">
            <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
            <input type="email" name="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required class="single-input" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$">
          </div>
          <div class="input-group-icon mt-13">
            <div class="icon"><i class="fa fa-unlock" aria-hidden="true"></i></div>
            <input type="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required class="single-input">
          </div>
          <div class="input-group-icon mt-15" style="cursor: pointer;">
              <a href="#" style="color: #F09AB9; cursor: pointer; float: right;">Lupa Passsword ?</a>
          </div>
          <div class="input-group-icon mt-20">
            <button type="submit" class="genric-btn success-border radius mt-10" style="width: 100% !important;">MASUK KE INVENT 1 <span class="lnr lnr-arrow-right"></span></button>
          </div>
          <div class="mt-10 alert-msg" style="text-align: center;"></div>
        </form>
        <form class="form-area" id="form-registration" name="form-registration" method="post" style="display: none;" autocomplete="off" onSubmit="post('form-registration'); return false;" action="<?php echo site_url('home/registration'); ?>">
          <div class="row"> 
            <div class="col-lg-12 form-group">
              <h4 class="mb-10">Data Perusahaan</h4>
              <input name="nama" placeholder="Nama Perusahaan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama Perusahaan'" class="common-input mb-10 form-control" required="" type="text">
            
              <input name="alamat" placeholder="Alamat Perusahaan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Alamat Perusahaan'" class="common-input mb-10 form-control" required="" type="text">

              <div class="input-group mb-10">
                  <select class="common-input mb-10 form-control col-lg-5 select-customize" name="kode_id" required="">
                    <option value=""></option>
                    <?php
                      foreach ($kode_id as $val) {
                        echo '<option value="'.$val['REFF_CODE'].'">'.$val['REFF_DESCRIPTION'].'</option>';
                      }
                    ?>
                  </select>&nbsp;&nbsp;
                  <input name="npwp" placeholder="NPWP Perusahaan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'NPWP Perusahaan'" class="common-input mb-10 form-control col-lg-5" required="" type="text">&nbsp;&nbsp;
                  <input name="telepon" placeholder="Telepon" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Telepon'" class="common-input mb-10 form-control col-lg-5" required="" type="text">
              </div>

              <div class="input-group mb-20">
                <input name="bidang_usaha" placeholder="Bidang Usaha" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Bidang Usaha'" class="common-input mb-10 form-control col-lg-4" required="" type="text">&nbsp;&nbsp;

                <select class="common-input mb-10 form-control col-lg-4 select-customize" name="status_usaha" required="">
                  <option value=""></option>
                  <?php
                    foreach ($jenis_eksportir as $val) {
                      echo '<option value="'.$val['REFF_CODE'].'">'.$val['REFF_DESCRIPTION'].'</option>';
                    }
                  ?>
                </select>&nbsp;&nbsp;

                <select class="common-input mb-10 form-control col-lg-4 select-customize" name="fasilitas_perusahaan" required="">
                  <option value=""></option>
                  <option value="1">Kawasan Berikat</option>
                </select>
              </div>
              <h4 class="mb-10">Data Pemilik</h4>
              <input name="nama_pemilik" placeholder="Nama Pemilik" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama Pemilik'" class="common-input mb-10 form-control" required="" type="text">
            
              <input name="alamat_pemilik" placeholder="Alamat Pemilik" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Alamat Pemilik'" class="common-input mb-10 form-control" required="" type="text">

              <div class="input-group mb-10">
                <input name="telp_pemilik" placeholder="Telepon Pemilik" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Telepon Pemilik'" class="common-input mb-10 form-control col-lg-6 telepon" required="" type="text">&nbsp;&nbsp;

                <input name="email" placeholder="Email Pemilik" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Pemilik'" class="common-input mb-10 form-control col-lg-6" required="" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$">
              </div>

              <input name="jabatan" placeholder="Jabatan Pemilik" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Jabatan Pemilik'" class="common-input form-control mb-10" required="" type="text">

              <button type="submit" class="genric-btn success-border danger radius mt-10" style="width: 100% !important;">DAFTAR <span class="lnr lnr-arrow-right"></span></button>
              <div class="mt-10 alert-msg" style="text-align: center;"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
</section>
<script type="text/javascript">
  function signin(form) {
    $.ajax({
      type: 'POST',
      url: $('[name="'+form+'"]').attr('action')+ '/ajax',
      data: $('[name="'+form+'"]').serialize(),
      dataType: 'json',
      success: function(data) {
        if(typeof(data) != 'undefined') {
          var arrayDataTemp = data.returnData.split("|");
          $('.alert-msg').show();
          $('.alert-msg').html(arrayDataTemp[1]);
          setTimeout(function() {
            $('.alert-msg').hide('slow', function() {
              $('.alert-msg').html(''); 
            });
          }, 2000);

          if(arrayDataTemp[0] == 1) {
            setTimeout(function(){window.location.href=arrayDataTemp[2]}, 1500);
          }
        }
      }
    });
  }

  function post(form) {
    $.ajax({
      type: 'POST',
      url: $('[name="'+form+'"]').attr('action')+ '/ajax',
      data: $('[name="'+form+'"]').serialize(),
      dataType: 'json',
      success: function(data) {
        if(typeof(data) != 'undefined') {
          var arrayDataTemp = data.returnData.split("|");
          $('.alert-msg').show();
          $('.alert-msg').html(arrayDataTemp[1]);
          setTimeout(function() {
            $('.alert-msg').hide('slow', function() {
              $('.alert-msg').html(''); 
            });
            
            if(arrayDataTemp[0] == 1) {
              $('#div-modal').modal('toggle');
            }
          }, 5000);
        }
      }
    });
  }
</script>