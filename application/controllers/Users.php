<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
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
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/treeview.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/laporan.css">';
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
			$footers .= '<script src="'.base_url().'assets/js/jquery.gritter.min.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/treeview.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/alerts.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/newtable.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/custom.js"></script>';

			$footers .= '<script type="text/javascript">jQuery(document).ready(function(){jQuery("#treeView").treeTable();});</script>';
			$footers .= '<script type="text/javascript">jQuery(document).ready(function(){';
			$footers .= 'jQuery(".akses_w").attr(\'checked\',true);';
			$footers .= 'menucheckAll(\'fuser\')';
			$footers .= '});</script>';
			if ($this->content=="") {
				redirect(base_url(),'refresh');
			}
			$this->load->model("m_menu");
			$menu['menu'] = $this->m_menu->drawMenu();
			$data = array(
				'_title_'		=> 'USERS - IT INVENTORY',
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
		}else{
			$this->session->sess_destroy();
			redirect(base_url('index.php'),'refresh');
		}
	}

	function user($act="", $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		if(in_array($act, array("add","edit"))) {
			$this->proccess("user",$act);
		} else {
			$this->breadcrumbs = array("title"=>"Users","icon"=>"users","title_child"=>"User","url"=>'users/user');
			$this->load->model('m_table','model');
			$arrdata = $this->model->user($act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function role($act="", $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		if(in_array($act, array("add","edit"))) {
			$this->proccess("role",$act);
		} else {
			$this->breadcrumbs = array("title"=>"Users","icon"=>"users","title_child"=>"Role","url"=>'users/role');
			$this->load->model('m_table','model');
			$arrdata = $this->model->role($act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function proccess($type, $act) {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		$this->load->model('m_execute','model');
		if($act == "add") {
			$action = "save";
		} elseif($act == "edit") {
			$action = "update";
			$arrdata['disabled'] = 'disabled="true"';
			$arrdata['id'] = $this->input->post('id');
			$arrdata['data'] = $this->model->get_data($type,$this->input->post('id'));
		}

		if($type == "user") {
			$arrdata['kode_role'] = $this->model->get_data('combo_role');
			$arrdata['status'] = array(""=>"","1"=>"Active","0"=>"Non Active");
		} elseif($type == "role") {
			$arrdata['menu'] = $this->model->menu_management($this->input->post('id'));
		}
		$arrdata['action'] = $action;
		$this->breadcrumbs = array("title"=>"Users","icon"=>"users","title_child"=>ucwords($type),"url_2"=>'users/'.$type,'title_child_2'=>ucwords($act));
		$this->content = $this->load->view('users/'.$type,$arrdata,true);
		$this->index();
	}

	function logapps() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->breadcrumbs = array("title"=>"Inventory","icon"=>"suitcase","title_child"=>"Log Apps","url"=>'inventory/logapps');
		$this->load->model('m_table','model');
		$arrdata = $this->model->logapps();
		$data = $this->content = $this->load->view('view-table', $arrdata, true);
		if ($this->input->post("ajax")) {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}
}