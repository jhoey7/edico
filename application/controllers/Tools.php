<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {
	public $content, $breadcrumbs;

	public function index()
	{
		if ($this->session->userdata('LOGGED')) {
			$headers = '<link rel="shortcut icon" href="'.base_url().'assets/images/logo.png">';
			#Stylesheets
			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/style.default.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-timepicker.min.css" />';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/sweetalert/sweetalert.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/alerts.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/jquery.gritter.css">';
			$headers .= '<script src="'.base_url().'assets/js/jquery-1.10.2.min.js"></script>';
			
			$footers = '<script src="'.base_url().'assets/js/jquery-migrate-1.2.1.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery-ui-1.10.3.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/bootstrap.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/modernizr.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery.sparkline.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/toggles.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/retina.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/sweetalert/sweetalert.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery.cookies.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/bootstrap-timepicker.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/alerts.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery.gritter.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/custom.js"></script>';
			if ($this->content=="") {
				redirect(base_url(),'refresh');
			}
			$this->load->model("m_menu");
			$menu['menu'] = $this->m_menu->drawMenu();
			$data = array(
				'_title_'		=> 'TOOLS - IT INVENTORY',
				'_headers_'		=> $headers,
				'_header_'		=> $this->load->view('header','',true),
				'_menus_'		=> $this->load->view('menu',$menu,true),
				'_breadcrumbs_' => (grant()=="")?"":$this->load->view('breadcrumbs',$this->breadcrumbs,true),
				'_content_' 	=> (grant()=="")?$this->load->view('errors/html/error_forbidden','',true):$this->content,
				'_footers_' 	=> $footers
			);
			if($this->session->userdata('USER_ROLE') == '1') $home = "admin/main";
			else $home = "main";
			$this->parser->parse($home, $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url('index.php'),'refresh');
		}
	}

	public function setting() {
		$this->load->model("m_execute","model");
		$arrdata['data'] = $this->model->get_data('setting');
		$this->content = $this->load->view('tools/setting',$arrdata,true);
		$this->breadcrumbs = array("title"=>"Tools","icon"=>"wrench","title_child"=>"Advance Setting","url"=>'tools/setting');
		$this->index();
	}
}