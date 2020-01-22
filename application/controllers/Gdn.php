<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gdn extends CI_Controller {
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
				'_title_'		=> 'GDN - IT INVENTORY',
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

	function daftar($act="", $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit","preview","realisasi"))) {
			$this->proccess("gdn", $act, $id);
		} else {
			$this->breadcrumbs = array("title"=>"Good Delivery Note","icon"=>"sign-in","title_child"=>"Daftar","url"=>'gdn/daftar');
			$this->load->model('m_table','model');
			$arrdata = $this->model->tpb_hdr("gdn",$act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function details($act, $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if (in_array($act, array("add","edit"))) {
			$this->proccess('details', $act, $id);
		} else {
			$this->load->model('m_table','model');
			$arrdata = $this->model->details("gdn", $act, $id);
	        if ($this->input->post("ajax") || $id=="post") {
	            echo $arrdata;
	        }
	    }
	}

	function proccess($type, $act, $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		if ($act == "add") {
			$arrdata['action'] = "save";
			if ($type == "details") {
				$arrdata['tipe'] = "gdn";
				$arrdata['id'] = $id;
				echo $this->load->view('tpb/details',$arrdata,true);
			} else {
				$arrdata['placeholder'] = "Exp. No. Sales Orders / No. Delivery Orders";
				$arrdata['title'] = "Customer";
				$arrdata['tipe'] = $type;
				$arrdata['combo_partner'] = $this->model->get_data('combo_partner');
				$arrdata['combo_dokumen'] = $this->model->get_data("reff_dokumen","OUT");
				echo $this->load->view('tpb/add',$arrdata,true);
			}
		} elseif ($act == "edit") {
			$arrdata['action'] = "update";
			$arrdata['id'] = $this->input->post('id');

			if ($type == "details") {
				if ($this->input->post("tb_chktblgdndtl")) {
					list($id) = $this->input->post("tb_chktblgdndtl");
					$arrdata = $this->model->check_status('tpb_dtl','00',$id);
					if ($arrdata == true) {
						echo json_encode(array("status"=>"success","id"=>$id));
					} else {
						echo json_encode(array("status"=>"failed","message"=>"Data sudah terealisasi."));
					}
				} else {
					$arrdata['tipe'] = "gdn";
					$arrdata['data'] = $this->model->get_data("details", $this->input->post('id'));
					echo $this->load->view('tpb/details',$arrdata,true);
				}
			} else {
				if ($this->input->post("tb_chktblgdnhdr")) {
					list($id) = $this->input->post("tb_chktblgdnhdr");
					$arrdata = $this->model->check_status('tpb_hdr','D',$id);
					if ($arrdata == true) {
						echo json_encode(array("status"=>"success","id"=>$id));
					} else {
						echo json_encode(array("status"=>"failed","message"=>"Data sudah terealisasi."));
					}
				} else {
					$arrdata['placeholder'] = "Exp. No. Sales Orders / No. Delivery Orders";
					$arrdata['title'] = "Customer";
					$arrdata['tipe'] = $type;
					$arrdata['data'] = $this->model->get_data("header", $this->input->post('id'));
					$arrdata['combo_partner'] = $this->model->get_data('combo_partner');
					$arrdata['combo_dokumen'] = $this->model->get_data("reff_dokumen","OUT");
					echo $this->load->view('tpb/add',$arrdata,true);
				}
			}
		} elseif ($act == "preview") {
			$this->load->model('m_table', 'table');
			$arrdata['action'] = "preview";
			$arrdata['tipe'] = $type;
			$arrdata['id'] = ($this->input->post('id') ? $this->input->post('id') : $id);
			$arrdata['data'] = $this->model->get_data("header", ($this->input->post('id') ? $this->input->post('id') : $id));
			$arrdata['details'] = $this->table->details($type, ($this->input->post('id') ? $this->input->post('id') : $id), $arrdata['data']['status']);
			$this->breadcrumbs = array("title"=>"Good Delivery Note","icon"=>"sign-out","title_child"=>"Daftar","url_2"=>'gdn/daftar/'.$type,'title_child_2'=>ucwords($act));
			$this->content = $this->load->view('tpb/preview',$arrdata,true);
			$this->index();
		} elseif ($act == "realisasi") {
			if ($this->input->post("tb_chktblgdnhdr")) {
				list($id) = $this->input->post("tb_chktblgdnhdr");
				$arrdata = $this->model->check_status('tpb_hdr','D',$id);
				if ($arrdata == true) {
					echo json_encode(array("status"=>"success","id"=>$id));
				} else {
					echo json_encode(array("status"=>"failed","message"=>"Data sudah terealisasi."));
				}
			} else {
				$this->load->model('m_table', 'table');
				$arrdata['action'] = "realisasi";
				$arrdata['id'] = $this->input->post('id');
				$arrdata['tipe'] = 'gdn';
				$arrdata['combo_dokumen'] = $this->model->get_data("reff_dokumen","OUT");
				$arrdata['data'] = $this->model->get_data("header", $this->input->post('id'));
				$arrdata['details'] = $this->table->details($type,$this->input->post('id'),"realisasi");
				$arrdata['tipe_dokumen'] = $this->session->userdata('TIPE_DOKUMEN');
				echo $this->load->view('tpb/realisasi',$arrdata,true);
			}
		}
	}
}