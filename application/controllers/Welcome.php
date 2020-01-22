<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public $content;

	public function index()
	{
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
		}else{
			$this->load->view('login');
		}
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
