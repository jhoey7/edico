<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends CI_Controller {
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
				'_title_'		=> 'PRODUKSI - IT INVENTORY',
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

	function rm($act="", $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit","preview","realisasi","details"))) {
			$this->proccess("rm", $act, $id);
		} else {
			$this->breadcrumbs = array("title"=>"Produksi","icon"=>"building-o","title_child"=>"Raw Material","url"=>'produksi/rm');
			$this->load->model('m_table','model');
			$arrdata = $this->model->produksi_hdr("rm",$act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function scrap($act="", $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit","preview","realisasi","details"))) {
			$this->proccess("scrap", $act, $id);
		} else {
			$this->breadcrumbs = array("title"=>"Produksi","icon"=>"building-o","title_child"=>"Scrap","url"=>'produksi/scrap');
			$this->load->model('m_table','model');
			$arrdata = $this->model->produksi_hdr("scrap",$act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function half($act="", $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit","preview","realisasi","details"))) {
			$this->proccess("half", $act, $id);
		} else {
			$this->breadcrumbs = array("title"=>"Produksi","icon"=>"building-o","title_child"=>"Half Finished","url"=>'produksi/half');
			$this->load->model('m_table','model');
			$arrdata = $this->model->produksi_hdr("half",$act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function fg($act="", $id="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if(in_array($act, array("add","edit","preview","realisasi","details"))) {
			$this->proccess("fg", $act, $id);
		} else {
			$this->breadcrumbs = array("title"=>"Produksi","icon"=>"building-o","title_child"=>"Finish Goods","url"=>'produksi/fg');
			$this->load->model('m_table','model');
			$arrdata = $this->model->produksi_hdr("fg",$act);
			$data = $this->content = $this->load->view('view-table', $arrdata, true);
	        if ($this->input->post("ajax") || $act=="post") {
	            echo $arrdata;
	        } else {
	            $this->content = $data;
	            $this->index();
	        }
	    }
	}

	function details($type, $act, $id, $ajax="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if (in_array($act, array("add","edit"))) {
			$this->proccess_detail($type, $act, $id, $ajax);
		} else {
			$this->load->model('m_table','model');
			$arrdata = $this->model->produksi_dtl($type, $act, $id);
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
		$arrdata['tipe'] = $type;
		($type == "rm") ? $arrdata['title'] = "Pengeluaran" : $arrdata['title'] = "Penerimaan";
		if ($type == "rm") $title_child = "Raw Material";
		elseif ($type == "scrap") $title_child = "Scrap";
		elseif ($type == "half") $title_child = "Half Finished";
		elseif ($type == "fg") $title_child = "Finished Goods";
		if ($act == "add") {
			$arrdata['title'] = $title_child;
			$arrdata['action'] = "save";
			echo $this->load->view('produksi/add',$arrdata,true);
		} elseif($act == "edit") {
			$this->load->model('m_execute','model');
			if ($this->input->post("tb_chktbl".$type)) {
				list($id) = $this->input->post("tb_chktbl".$type);
				$arrdata = $this->model->check_status('produksi_hdr','D',$id);
				if ($arrdata == true) {
					echo json_encode(array("status"=>"success","id"=>$id));
				} else {
					echo json_encode(array("status"=>"failed","message"=>"Data sudah terealisasi."));
				}
			} else {
				$arrdata['title'] = $title_child;
				$arrdata['id'] = $this->input->post('id');
				$arrdata['action'] = "update";
				$arrdata['data'] = $this->model->get_data('header_produksi', $this->input->post('id'));
				echo $this->load->view('produksi/add',$arrdata,true);
			}
		} elseif ($act == "details") {
			$this->load->model('m_execute','model');
			$this->load->model('m_table','table');
			$arrdata['detail'] = $this->table->produksi_dtl($type, ($this->input->post('id') ? $this->input->post('id') : $id), "realisasi");
			echo $this->load->view('produksi/preview_detail',$arrdata,true);
		} elseif ($act == "preview") {
			$this->load->model('m_execute','model');
			$this->load->model('m_table','table');
			$arrdata['data'] = $this->model->get_data('header_produksi', ($this->input->post('id') ? $this->input->post('id') : $id));
			$arrdata['detail'] = $this->table->produksi_dtl($type, ($this->input->post('id') ? $this->input->post('id') : $id), $arrdata['data']['status']);
			$this->breadcrumbs = array("title"=>"Produksi","icon"=>"building-o","title_child"=>$title_child,"url_2"=>'produksi/'.$type,'title_child_2'=>ucwords($act));
			$this->content = $this->load->view('produksi/preview',$arrdata,true);
			$this->index();
		}
	}

	function proccess_detail($type, $act, $id="", $ajax="") {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		if ($act == "edit") {
			$this->load->model('m_execute','model');
			if ($this->input->post("tb_chktblproduksidtl")) {
				list($id) = $this->input->post("tb_chktblproduksidtl");
				$arrdata = $this->model->check_status('produksi_dtl','00',$id);
				if ($arrdata == true) {
					echo json_encode(array("status"=>"success","id"=>$id));
				} else {
					echo json_encode(array("status"=>"failed","message"=>"Data sudah terealisasi."));
				}
			} else {
				$arrdata['action'] = 'update';
				$arrdata['data'] = $this->model->get_data('details_produksi', $this->input->post('id'));
				$arrdata['id'] = $this->input->post('id');
				$arrdata['tipe'] = $type;

				if ($type == "fg") {
					$arrdata['bahan_baku'] = $this->model->get_data('produksi_bb', $this->input->post('id'));
				}

				if ($type == "fg") echo $this->load->view('produksi/details_fg',$arrdata,true);
				else echo $this->load->view('produksi/details',$arrdata,true);
			}
		} elseif ($act == "add") {
			$arrdata['action'] = 'save';
			$arrdata['id'] = $id;
			$arrdata['tipe'] = $type;

			if ($type == "fg") echo $this->load->view('produksi/details_fg',$arrdata,true);
			else echo $this->load->view('produksi/details',$arrdata,true);
		}
	}

	function get_bahan_baku() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		$arrdata = $this->model->get_data('konversi_bb', $this->input->post('id'));
		
		$html = "";
		if (count($arrdata) > 0) {
			$no = 1;
			$html .= '<tbody>';
			foreach ($arrdata as $row) {
				$html .= '<tr id="tr_detail'.$no.'">';
				$html .= '<td><span class="nop">'.$no.'</span></td>';
				$html .= '<td><input type="text" id="td_kdbrg'.$no.'" class="form-control" value="'.$row['kd_brg'].'" readonly/></td>';
				$html .= '<td><input type="text" id="td_jnsbrg'.$no.'" class="form-control" value="'.$row['jns_barang'].'" readonly/></td>';
				$html .= '<td><input type="text" id="jml_satuan_bb'.$no.'" class="form-control jml_satuan_bb" value="'.$row['jml_satuan'].'" style="text-align: center;" name="DETIL[jml_satuan][]" /></td>';
				$html .= '<td><input type="text" id="td_satuan'.$no.'" class="form-control" value="'.$row['kd_satuan'].'" readonly/></td>';
				$html .= '<td align="center"><a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="popup_searchtwo(\'popup/popup_search/mst_barang_konversi|1/id_barang'.$no.'|td_kdbrg'.$no.'|td_jnsbrg'.$no.'|td_satuan'.$no.'/2\');"><i class="fa fa-search"></i></a>&nbsp;<a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_bb('.$no.')"><i class="fa fa-times"></i></a><input type="hidden" id="id_barang'.$no.'" class="id_brg_bb" name="DETIL[id_barang][]" readonly value="'.$row['id_barang'].'" /></td>';
				$html .= '</tr>';
				$no++;
			}
			$html .= '</tbody>';
		} else {
			$html .= '<tbody><tr id="tr_detil"><td colspan="6" align="center">Data Tidak Ditemukan.</td></tr></tbody>';
		}
		echo $html;
	}
}