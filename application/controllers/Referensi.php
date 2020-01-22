<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi extends CI_Controller {
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
			if ($this->content=="") {
				redirect(base_url(),'refresh');
			}
			$this->load->model("m_menu");
			$menu['menu'] = $this->m_menu->drawMenu();
			$data = array(
				'_title_'		=> 'REFERENSI - IT INVENTORY',
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

	function supplier($act="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit"))) {
			$this->proccess("supplier",$act);
		} else {
			$this->breadcrumbs = array("title"=>"Referensi","icon"=>"gear","title_child"=>"Supplier","url"=>'referensi/supplier');
			$this->load->model('m_table','model');
			$arrdata = $this->model->supplier($act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function satuan() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->breadcrumbs = array("title"=>"Referensi","icon"=>"gear","title_child"=>"Satuan","url"=>'referensi/satuan');
		$this->load->model('m_table','model');
		$arrdata = $this->model->satuan();
		$data = $this->content = $this->load->view('view-table', $arrdata, true);
        if ($this->input->post("ajax")) {
            echo $arrdata;
        } else {
            $this->content = $data;
            $this->index();
        }
	}

	function negara() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->breadcrumbs = array("title"=>"Referensi","icon"=>"gear","title_child"=>"Negara","url"=>'referensi/negara');
		$this->load->model('m_table','model');
		$arrdata = $this->model->negara();
		$data = $this->content = $this->load->view('view-table', $arrdata, true);
        if ($this->input->post("ajax")) {
            echo $arrdata;
        } else {
            $this->content = $data;
            $this->index();
        }
	}

	function warehouse($act="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit"))) {
			$this->proccess("warehouse",$act);
		} else {
			$this->breadcrumbs = array("title"=>"Referensi","icon"=>"gear","title_child"=>"Warehouse","url"=>'referensi/warehouse');
			$this->load->model('m_table','model');
			$arrdata = $this->model->warehouse($act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function proccess($type, $act="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if($act == "add") {
			$action = "save";
		} elseif($act == "edit") {
			$action = "update";

			$this->load->model('m_execute','model');
			$arrdata['id'] = $this->input->post('id');
			$arrdata['data'] = $this->model->get_data($type, $this->input->post('id'));
		}

		$arrdata['action'] = $action;
		$this->breadcrumbs = array("title"=>"Referensi","icon"=>"gear","title_child"=>ucwords($type),"url_2"=>'referensi/'.$type,'title_child_2'=>ucwords($act));
		$this->content = $this->load->view('referensi/'.$type, $arrdata, true);
		$this->index();
	}
}