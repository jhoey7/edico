<div class="visible-xs hidden-sm hidden-md hidden-lg">   
  <div class="media userlogged">
      <img alt="" src="<?php echo base_url('assets/images/logged_user.png'); ?>" class="media-object">
      <div class="media-body">
          <h4><?php echo $this->session->userdata('NAMA'); ?></h4>
          <span>"Life is so..."</span>
      </div>
  </div>

  <h5 class="sidebartitle actitle">Account</h5>
  <ul class="nav nav-pills nav-stacked nav-bracket mb30">
    <li><a href="<?php echo site_url('users/user/profile'); ?>"><i class="fa fa-user"></i> Profile</a></li>
    <li><a href="<?php echo site_url('users/user/changepassword'); ?>"><i class="fa fa-key"></i> Change Password</a></li>
    <li><a href="<?php echo site_url('home/signout'); ?>"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
  </ul>
</div>

<h5 class="sidebartitle">Navigation</h5>
<ul class="nav nav-pills nav-stacked nav-bracket">
  <?php echo $menu; ?>
</ul>