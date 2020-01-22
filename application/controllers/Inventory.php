<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
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
				'_title_'		=> 'INVENTORY - IT INVENTORY',
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

	function barang($act="",$id="") {
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		if (in_array($act, array("add","edit"))) {
			$this->proccess("barang",$act);
		} elseif($act=="preview") {
			$this->load->model('m_table','model');
			$arrdata = $this->model->detail_barang(($this->input->post('id') ? $this->input->post('id') : $id));
			$data = $this->load->view('inventory/detil-barang', $arrdata, true);
	        if ($this->input->post("ajax")) {
	            echo $arrdata;
	        } else {
	            echo $data;
	        }
		} elseif ($act == "upload") {
			echo $this->load->view('inventory/upload_barang','',true);
		} else {
			$this->breadcrumbs = array("title"=>"Inventory","icon"=>"suitcase","title_child"=>"Barang","url"=>'inventory/barang');
			$this->load->model('m_table','model');
			$arrdata = $this->model->barang($act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function stockopname($act="", $id="", $ajax="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit"))) {
			$this->proccess("stockopname",$act);
		} elseif($act=="preview") {
			$this->load->model('m_table','model');
			$arrdata = $this->model->detail_stockopname(($this->input->post('id') ? $this->input->post('id') : $id), $ajax);
			$data = $this->load->view('inventory/detil-stockopname', $arrdata, true);
	        if ($this->input->post("ajax") || $ajax == "ajax") {
	            echo $arrdata;
	        } else {
	            echo $data;
	        }
		} elseif ($act == "upload") {
			echo $this->load->view('inventory/upload_stockopname','',true);
		} elseif ($act == "add_details") {
			$arrdata['action'] = 'save';
			$arrdata['tgl_stock'] = $id;
			echo $this->load->view('inventory/form-stockopname',$arrdata,true);
		} elseif ($act == "edit_details") {
			if ($this->input->post("tb_chktblstockopnamedtl")) {
				list($id) = $this->input->post("tb_chktblstockopnamedtl");
				echo json_encode(array("status"=>"success","id"=>$id));
			} else {
				$this->load->model('m_execute','model');
				$arrdata['action'] = 'update';
				$arrdata['tgl_stock'] = $id;
				$arrdata['id'] = $this->input->post("id");
				$arrdata['data'] = $this->model->get_data('stockopname_dtl', $this->input->post('id'));
				echo $this->load->view('inventory/form-stockopname',$arrdata,true);
			}
		} else {
			$this->breadcrumbs = array("title"=>"Inventory","icon"=>"suitcase","title_child"=>"Stockopname","url"=>'inventory/stockopname');
			$this->load->model('m_table','model');
			$arrdata = $this->model->stockopname($act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function konversi($act="", $id="", $ajax="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit","preview","bb","details"))) {
			if ($act == "add") {
				$arrdata['action'] = 'save';
				echo $this->load->view('inventory/konversi', $arrdata, true);
			} elseif ($act == "edit") {
				$this->load->model('m_execute','model');
				if ($this->input->post("tb_chktblkonversi")) {
					list($id) = $this->input->post("tb_chktblkonversi");
					$arrdata = $this->model->check_status('konversi','D',$id);
					if ($arrdata == true) {
						echo json_encode(array("status"=>"success","id"=>$id));
					} else {
						echo json_encode(array("status"=>"failed","message"=>"Data sudah terealisasi."));
					}
				} else {
					$arrdata['action'] = 'update';
					$arrdata['id'] = $this->input->post('id');
					$arrdata['data'] = $this->model->get_data('konversi', ($this->input->post('id') ? $this->input->post('id') : $id));
					echo $this->load->view('inventory/konversi', $arrdata, true);
				}
			} elseif ($act == "preview") {
				$this->load->model('m_execute','model');
				$this->load->model('m_table','table');
				$action = "update";
				$arrdata['id'] = $this->input->post('id');
				$arrdata['data'] = $this->model->get_data('konversi', ($this->input->post('id') ? $this->input->post('id') : $id));
				$arrdata['bahan_baku'] = $this->table->konversi_bb("bb", ($this->input->post('id') ? $this->input->post('id') : $id));
				$this->breadcrumbs = array("title"=>"Inventory","icon"=>"suitcase","title_child"=>"Konversi","url_2"=>'inventory/konversi','title_child_2'=>"Preview");
				$this->content = $this->load->view('inventory/preview_konversi', $arrdata, true);
				$this->index();
			} elseif ($act == "bb") {
				if ($id == "add") {
					$arrdata['action'] = 'save';
					$arrdata['id'] = $ajax;
					echo $this->load->view('inventory/konversi_bb', $arrdata, true);
				} elseif ($id == "edit") {
					$this->load->model('m_execute','model');
					if ($this->input->post("tb_chktblkonversidtl")) {
						list($id) = $this->input->post("tb_chktblkonversidtl");
						$arrdata = $this->model->check_status('konversi_bb','D',$id);
						if ($arrdata == true) {
							echo json_encode(array("status"=>"success","id"=>$id));
						} else {
							echo json_encode(array("status"=>"failed","message"=>"Data sudah terealisasi."));
						}
					} else {
						$arrdata['id'] = $this->input->post('id');
						$arrdata['action'] = "update";
						$arrdata['data'] = $this->model->get_data('konversi_dtl', $this->input->post('id'));
						echo $this->load->view('inventory/konversi_bb',$arrdata,true);
					}
				} else {
					$this->load->model('m_table','model');
					$arrdata = $this->model->konversi_bb($act, ($this->input->post('id') ? $this->input->post('id') : $id), $ajax);
					if ($this->input->post("ajax") || $ajax == "post") {
						echo $arrdata;
					}
				}
			} elseif ($act == "details") {
				$this->load->model('m_table','table');
				$arrdata = $this->table->konversi_bb("bb", ($this->input->post('id') ? $this->input->post('id') : $id), "details");
				$data = $this->load->view('inventory/detil-konversi', $arrdata, true);
		        if ($this->input->post("ajax")) {
		            echo $arrdata;
		        } else {
		            echo $data;
		        }
			} 
		} else {
			$this->breadcrumbs = array("title"=>"Inventory","icon"=>"suitcase","title_child"=>"Konversi","url"=>'inventory/konversi');
			$this->load->model('m_table','model');
			$arrdata = $this->model->konversi($act);
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
		$this->load->model('m_execute','model');
		if($act == "add") {
			if($type == "barang") {
				$arrdata['jns_barang'] = $this->model->get_data('combo_jns_brg');
				$arrdata['warehouse'] = $this->model->get_data('combo_warehouse');
			}
			$arrdata['action'] = "save";
			$this->breadcrumbs = array("title"=>"Inventory","icon"=>"suitcase","title_child"=>ucwords($type),"url_2"=>'inventory/'.$type,'title_child_2'=>ucwords($act));
			$this->content = $this->load->view('inventory/'.$type, $arrdata, true);
			$this->index();
		} elseif($act == "edit") {
			if ($this->input->post("tb_chktblbarang") && $type == "barang") {
				list($id) = $this->input->post("tb_chktblbarang");
				$arrdata = $this->model->check_status('barang_inout','id_brg',$id);
				if ($arrdata == true) {
					echo json_encode(array("status"=>"failed","message"=>"Kode Barang sudah ada di mutasi."));
				} else {
					echo json_encode(array("status"=>"success","id"=>$id));
				}
			} else {
				$arrdata['action'] = "update";
				$arrdata['id'] = $this->input->post('id');
				$arrdata['data'] = $this->model->get_data($type, $this->input->post('id'));
				$arrdata['disabled'] = "disabled=\"true\"";

				if($type == "barang") {
					$arrdata['jns_barang'] = $this->model->get_data('combo_jns_brg');
					$arrdata['warehouse'] = $this->model->get_data('combo_warehouse');
					if ($this->input->post('id')) {
						$arrdata['barang_gudang'] = $this->model->get_data('barang_gudang', $this->input->post('id'));	
					}
				} elseif($type == "stockopname") {
					$this->load->model('m_table','table');
					$arrdata['tabel'] = $this->table->detail_stockopname($this->input->post('id'), 'edit');
				}
				$this->breadcrumbs = array("title"=>"Inventory","icon"=>"suitcase","title_child"=>ucwords($type),"url_2"=>'inventory/'.$type,'title_child_2'=>ucwords($act));
				$this->content = $this->load->view('inventory/'.$type, $arrdata, true);
				$this->index();
			}
		}
	}

	public function inout() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		if(strtolower($_SERVER['REQUEST_METHOD'])=="post"){
			echo $this->model->get_data('inout');
		}else{
			$arrdata['jenis_barang'] = $this->model->get_data('combo_jns_brg');
			$this->breadcrumbs = array("title"=>"Inventory","icon"=>"suitcase","title_child"=>"Tracking In/Out Barang","url"=>'inventory/inout');		
			$this->content = $this->load->view('inventory/inout', $arrdata, true);
			$this->index();		
		}
	}
}