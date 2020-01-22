<div class="visible-xs hidden-sm hidden-md hidden-lg">   
  <div class="media userlogged">
      <img alt="" src="<?php echo base_url('assets/images/photos/loggeduser.png'); ?>" class="media-object">
      <div class="media-body">
          <h4><?php echo $this->session->userdata('NAMA'); ?></h4>
          <span>"Life is so..."</span>
      </div>
  </div>

  <h5 class="sidebartitle actitle">Account</h5>
  <ul class="nav nav-pills nav-stacked nav-bracket mb30">
    <li><a href="profile.html"><i class="fa fa-user"></i> <span>Profile</span></a></li>
    <li><a href="#"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
    <li><a href="#"><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
    <li><a href="signout.html"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
  </ul>
</div>

<h5 class="sidebartitle">Navigation</h5>
<ul class="nav nav-pills nav-stacked nav-bracket">
  <?php echo $menu; ?>
</ul>