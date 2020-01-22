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
      <div class="logopanel" style="text-align: center !important;">
          <img src="<?php echo base_url('assets/images/logo.png'); ?>" style="width: 120px; height: 30px;">
      </div><!-- logopanel -->
    
      <div class="leftpanelinner">
        {_menus_}
        <!-- <div class="infosummary">
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
        </div>infosummary -->
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
