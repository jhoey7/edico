<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public $content, $breadcrumbs;

	// function signin() {
	// 	$arrayReturn = array();
	// 	$returnData = "";
	// 	if(strtolower($_SERVER['REQUEST_METHOD'])!="post") {
	// 		$returnData = "0|Login failed, please refresh page";
	// 	} else {
	// 		$uid = $this->input->post('username');
	// 		$pwd = $this->input->post('password');
	// 		$this->load->model('m_home');
	// 		$result = $this->m_home->signin($uid, $pwd);
	// 		if($result == 0 || $result == 2) {
	// 			$returnData = "0|Username atau Password Anda Salah.<br>Check Kembali Username dan Password Anda.";
	// 		}else if($result == 3) {
	// 			$returnData = "0|Username Anda Sudah Tidak Aktif. Silahkan Hubungi Administrator Anda.";
	// 		} else { 
	// 			$returnData = "1|Login Berhasil.|".base_url();
	// 		}
	// 	}
	// 	$arrayReturn['returnData'] = $returnData;
	// 	echo json_encode($arrayReturn);
	// }

	public function index() {
        if($this->session->userdata('LOGGED')) {
        	$headers = '<link rel="shortcut icon" href="assets/images/logo.png">';
			#Stylesheets
			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/style.default.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-timepicker.min.css" />';

			$footers  = '<script src="'.base_url().'assets/js/jquery-1.10.2.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery-migrate-1.2.1.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery-ui-1.10.3.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/bootstrap.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/modernizr.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery.sparkline.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/toggles.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/retina.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery.cookies.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/bootstrap-timepicker.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/custom.js"></script>';
			$this->load->model("m_menu");
			$menu['menu'] = $this->m_menu->drawMenu();
			$data = array(
				'_title_'		=> 'HOME - IT INVENTORY',
				'_headers_'		=> $headers,
				'_header_'		=> $this->load->view('header','',true),
				'_menus_'		=> $this->load->view('menu',$menu,true),
				'_breadcrumbs_' => $this->load->view('breadcrumbs',$this->breadcrumbs,true),
				'_content_' 	=> (grant()=="")?$this->load->view('error','',true):$this->content,
				'_footers_' 	=> $footers
			);
			if($this->session->userdata('USER_ROLE') == '1') $home = "admin/main";
			else $home = "main";
			$this->parser->parse($home, $data);
        } else {
			// $headers = '<link rel="shortcut icon" href="'.base_url().'assets/landing_page/img/logo.png">';
			// $headers .= '<link rel="stylesheet" href="'.base_url().'assets/landing_page/css/linearicons.css">';
			// $headers .= '<link rel="stylesheet" href="'.base_url().'assets/landing_page/css/font-awesome.min.css">';
			// $headers .= '<link rel="stylesheet" href="'.base_url().'assets/landing_page/css/bootstrap.css">';
			// $headers .= '<link rel="stylesheet" href="'.base_url().'assets/landing_page/css/magnific-popup.css">';
			// $headers .= '<link rel="stylesheet" href="'.base_url().'assets/landing_page/css/nice-select.css">';          
			// $headers .= '<link rel="stylesheet" href="'.base_url().'assets/landing_page/css/animate.min.css">';
			// $headers .= '<link rel="stylesheet" href="'.base_url().'assets/landing_page/css/owl.carousel.css">';
			// $headers .= '<link rel="stylesheet" href="'.base_url().'assets/landing_page/css/main.css">';

			// $footers  = '<script src="'.base_url().'assets/landing_page/js/vendor/jquery-2.2.4.min.js"></script>';
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/vendor/bootstrap.min.js"></script>';
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/easing.min.js"></script>';     
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/hoverIntent.js"></script>';
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/superfish.min.js"></script>'; 
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/jquery.ajaxchimp.min.js"></script>';
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/jquery.magnific-popup.min.js"></script>'; 
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/owl.carousel.min.js"></script>';      
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/jquery.sticky.js"></script>';
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/jquery.nice-select.min.js"></script>';  
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/waypoints.min.js"></script>';
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/jquery.counterup.min.js"></script>';          
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/parallax.min.js"></script>';  
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/mail-script.js"></script>'; 
			// $footers .= '<script src="'.base_url().'assets/landing_page/js/main.js"></script>';
			// $footers .= "<script>var base_url='".base_url()."'; var site_url = '".site_url()."'</script>";
			// if($this->content == "") $this->content = $this->load->view('front/content','',true);
			// $data = array(
			// 	'_title_'		=> '.: INVENT 1 :.',
			// 	'_headers_'		=> $headers,
			// 	'_content_' 	=> $this->content,
			// 	'_footers_' 	=> $footers
			// );
			// $this->parser->parse('front/main', $data);
			$this->load->view('login');
		}
	} 

	function signin($type="") {
	    if(strtolower($_SERVER['REQUEST_METHOD']) == "post" && $type != "ajax") {
	          $this->load->model('m_home');
	          $arrdata['kode_id'] = $this->m_home->get_data('kode_id');
	          $arrdata['jenis_eksportir'] = $this->m_home->get_data('jenis_eksportir');
	          $data['title'] = "LOGIN FORM";
	          $data['header'] = $this->load->view('front/signin',$arrdata,true);
	          $data['footer'] = $this->load->view('front/footer_login','',true);
	          echo json_encode($data);
	    } elseif(strtolower($_SERVER['REQUEST_METHOD']) == "post" && $type == "ajax") {
	          $arrayReturn = array();
	          $returnData = "";
	          $email = $this->input->post('email');
	          $password = $this->input->post('password');
	          $this->load->model('m_home');
	          $result = $this->m_home->signin($email, $password);
	          if($result == 0 || $result == 2) {
	                $returnData = "0|<blockquote class=\"generic-blockquote\" style=\"color: red;\">Username atau Password Anda Salah.<br>Check Kembali Username dan Password Anda.</blockquote>";
	          }else if($result == 3) {
	                $returnData = "0|<blockquote class=\"generic-blockquote\" style=\"color: red;\">Username Anda Sudah Tidak Aktif. Silahkan Hubungi Administrator Anda.</blockquote>";
	          } else { 
	                $returnData = "1|<blockquote class=\"generic-blockquote\" style=\"color: green;\">Login Berhasil. Please wait...</blockquote>|".base_url()."index.php";
	          }
	          $arrayReturn['returnData'] = $returnData;
	          echo json_encode($arrayReturn);
	    }
	} 

	function registration() {
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post") {
			$this->load->model('m_home');
			$return = $this->m_home->registration($_POST);
			if($return == 0) {
				$returnData = "0|<blockquote class=\"generic-blockquote\" style=\"color: red;\">Registrasi gagal, NPWP / Email sudah terdaftar.</blockquote>";
			} else {
				$returnData = "1|<blockquote class=\"generic-blockquote\" style=\"color: green;\">Registrasi berhasil. Silahkan check email Anda.</blockquote>";
			}
			$arrayReturn['returnData'] = $returnData;
			echo json_encode($arrayReturn);
		} else {
			$returnData = "0|<blockquote class=\"generic-blockquote\" style=\"color: red;\">Registrasi gagal, refresh kembali browser Anda.</blockquote>";
			$arrayReturn['returnData'] = $returnData;
			echo json_encode($arrayReturn);
		}
	}

	function signout(){
		$this->session->sess_destroy();
		redirect(base_url());	
	}

	function dashboard() {		
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->breadcrumbs = array("title"=>"Home","icon"=>"home","title_child"=>"Dashboard","url"=>'welcome/dashboard');
		$this->content = $this->load->view('dashboard','',true);
		$this->index();
	}
}