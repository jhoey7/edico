  <!DOCTYPE html>
  <html lang="zxx" class="no-js">
  <head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Author Meta -->
    <meta name="author" content="codepixer">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>{_title_}</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
    <!-- CSS -->
    {_headers_}
      
    </head>
    <body>

      <header id="header" id="home">
        <div class="container">
          <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
              <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/landing_page/img/logo.png'); ?>" alt="" title="" /></a>
            </div>
            <nav id="nav-menu-container">
              <ul class="nav-menu">
                <li class="menu-active"><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li>
                  <a href="javascript:void(0);" class="genric-btn danger radius small" id="sign-in">Sign In <span class="lnr lnr-user"></span></a>
                </li>
              </ul>
            </nav><!-- #nav-menu-container -->            
          </div>
        </div>
      </header><!-- #header -->

      {_content_}
    
      <!-- start footer Area -->    
      <footer class="footer-area section-gap">
        <div class="container">
          <div class="row">
            <div class="col-lg-3  col-md-6 col-sm-6">
              <div class="single-footer-widget">
                <h4 class="text-white">About Us</h4>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.
                </p>
              </div>
            </div>
            <div class="col-lg-4  col-md-6 col-sm-6">
              <div class="single-footer-widget">
                <h4 class="text-white">Contact Us</h4>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.
                </p>
                <p class="number">
                  012-6532-568-9746 <br>
                  012-6532-569-9748
                </p>
              </div>
            </div>            
            <div class="col-lg-5  col-md-6 col-sm-6">
              <div class="single-footer-widget">
                <h4 class="text-white">Products & Services</h4>
                <p>You can trust us. we only send  offers, not a single spam.</p>
              </div>
            </div>            
          </div>
      </footer> 
      <div class="modal fade" id="div-modal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" style="display: none;">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="ModalHeader"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class='fa fa-times-circle'></i></button>
                  </div>
                  <div class="modal-body table-responsive" id="ModalContent" >

                  </div>
                  <div class="modal-footer" id="ModalFooter">
                    
                  </div>
              </div>
          </div>
      </div>
      <!-- End footer Area -->
      {_footers_}  
    </body>
  </html>