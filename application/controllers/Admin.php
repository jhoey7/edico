<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public $content, $breadcrumbs;

	public function index()
	{
		if($this->session->userdata('LOGGED')) {
			$headers = '<link rel="shortcut icon" href="'.base_url().'assets/images/logo.png">';
			#Stylesheets
			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/style.default.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-timepicker.min.css" />';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/sweetalert/sweetalert.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/alerts.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/newtable.css">';
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
			$footers .= '<script src="'.base_url().'assets/js/newtable.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/jquery.gritter.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/custom.js"></script>';
			$data = array(
				'_title_'		=> 'ADMIN PAGE - IT INVENTORY',
				'_headers_'		=> $headers,
				'_header_'		=> $this->load->view('header','',true),
				'_breadcrumbs_' => $this->load->view('breadcrumbs',$this->breadcrumbs,true),
				'_content_' 	=> $this->content,
				'_footers_' 	=> $footers
			);
			if($this->session->userdata('USER_ROLE') == '1') $home = "admin/main";
			else $home = "main";
			$this->parser->parse($home, $data);
		}else{
			redirect(base_url('index.php'),'refresh');
		}
	}

	function company($type, $ajax="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->breadcrumbs = array("title"=>"Company","icon"=>"edit","title_child"=>"New","url"=>'admin/company/'.$type);
		$this->load->model('m_admin','model');
		$arrdata = $this->model->daftar($type, $ajax);
		$data = $this->content = $this->load->view('view-table', $arrdata, true);
        if ($this->input->post("ajax") || $ajax == "post") {
            echo $arrdata;
        } else {
            $this->content = $data;
            $this->index();
        }
	}

	function preview() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = $this->input->post('id');
		$this->breadcrumbs = array("title"=>"Company","icon"=>"edit","title_child"=>"Detiail Company","url"=>'admin/company/'.$type);
		$this->load->model('m_admin','model');
		$data['id']		 = $id;
		$data['company'] = $this->model->get_data($id);
        $this->content = $this->load->view('admin/preview',$data,true);
        $this->index();
	}

	function test() {
		$DATA['id'] = '1';
		$DATA['nama'] = "joni''";
		echo $this->db->insert('joni',$DATA);
	}
}