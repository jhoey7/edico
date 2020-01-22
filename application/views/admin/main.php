<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <script>
    var base_url = '<?php echo base_url(); ?>';
    var site_url = '<?php echo site_url(); ?>';
  </script>
  <title>{_title_}</title>
  {_headers_}
</head>
<body class="stickyheader">
  <!-- Preloader -->
  <div id="preloader">
      <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
  </div>
  <section>
    <div class="leftpanel sticky-leftpanel">
      <div class="logopanel">
          <h1><span>[</span> INVENTORY <span>]</span></h1>
      </div><!-- logopanel -->
    
      <div class="leftpanelinner">
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
          <li><a href="index.html"><i class="fa fa-home"></i> <span>Home</span></a></li>
          <li class="nav-parent"><a href="#"><i class="fa fa-edit"></i> <span>Company</span></a>
            <ul class="children">
              <li><a href="<?php echo site_url('admin/company/new'); ?>"><i class="fa fa-caret-right"></i> New</a></li>
              <li><a href="<?php echo site_url('admin/company/approve'); ?>"><i class="fa fa-caret-right"></i> Approve</a></li>
              <!-- <li><a href="form-validation.html"><i class="fa fa-caret-right"></i> Reject</a></li> -->
            </ul>
          </li>
        </ul>
        <div class="infosummary">
          <h5 class="sidebartitle">Dok. Pabean Summary</h5>    
          <ul>
            <li>
              <div class="datainfo">
                  <span class="text-muted">Pemasukan</span>
                  <h4>630, 201</h4>
              </div>
              <div id="sidebar-chart" class="chart"></div>   
            </li>
            <li>
              <div class="datainfo">
                  <span class="text-muted">Pengeluaran</span>
                  <h4>1, 332, 801</h4>
              </div>
              <div id="sidebar-chart2" class="chart"></div>   
            </li>
          </ul>
        </div><!-- infosummary -->
      </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->
  
  <div class="mainpanel">
    {_header_}
    <div class="pageheader">
      {_breadcrumbs_}
    </div>
    
    <div class="contentpanel">
      <div class="row">
        {_content_}
      </div>
    </div><!-- contentpanel -->
    
  </div><!-- mainpanel -->
  
</section>
<!-- Modal -->
<div class="modal fade" id="div-modal" tabindex="-1" role="dialog" aria-labelledby="div-title" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="div-title"></h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->
{_footers_}
</body>
</html>
