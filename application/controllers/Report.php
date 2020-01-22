<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public $content, $breadcrumbs;

	public function index()
	{
		if ($this->session->userdata('LOGGED')) {
			$headers = '<link rel="shortcut icon" href="'.base_url().'assets/images/logo.png">';
			#Stylesheets
			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/style.default.css">';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-timepicker.min.css" />';
  			$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/alerts.css">';
			$headers .= '<script src="'.base_url().'assets/js/jquery-1.10.2.min.js"></script>';

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
			$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
			$footers .= '<script src="'.base_url().'assets/js/alerts.js"></script>';
			if ($this->content=="") {
				redirect(base_url(),'refresh');
			}
			$this->load->model("m_menu");
			$menu['menu'] = $this->m_menu->drawMenu();
			$data = array(
				'_title_'		=> 'REPORT - IT INVENTORY',
				'_headers_'		=> $headers,
				'_header_'		=> $this->load->view('header','',true),
				'_menus_'		=> $this->load->view('menu',$menu,true),
				'_breadcrumbs_' => (grant()=="")?"":$this->load->view('breadcrumbs',$this->breadcrumbs,true),
				'_content_' 	=> (grant()=="")?$this->load->view('errors/html/error_forbidden','',true):$this->content,
				'_footers_' 	=> $footers
			);
			$this->parser->parse('main', $data);
		} else {
			$this->session->sess_destroy();
			redirect(base_url(),'refresh');
		}
	}

	function pemasukan() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Pemasukan","url"=>'report/pemasukan');
		$arrdata['kd_dok'] = $this->model->get_data('reff_dokumen','IN');
		$this->content = $this->load->view('report/pemasukan',$arrdata,true);
		$this->index();
	}

	function pengeluaran() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Pengeluaran","url"=>'report/pengeluaran');
		$arrdata['kd_dok'] = $this->model->get_data('reff_dokumen','OUT');
		$this->content = $this->load->view('report/pengeluaran',$arrdata,true);
		$this->index();
	}

	function pemasukan_bb() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Pemasukan Bahan Baku","url"=>'report/pemasukan-bahan-baku');
		$arrdata['kd_dok'] = $this->model->get_data('reff_dokumen','IN');
		$this->content = $this->load->view('report/pemasukan_bb',$arrdata,true);
		$this->index();
	}

	function pemakaian_bb() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		$arrdata['tipe'] = 'pemakaian_bb';
		$arrdata['title'] = 'Pemakaian Bahan Baku';
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Pemakaian Bahan Baku","url"=>'report/pemakaian_bb');
		$this->content = $this->load->view('report/pemakaian_bb',$arrdata,true);
		$this->index();
	}

	function pemakaian_subkon() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		$arrdata['tipe'] = 'pemakaian_subkon';
		$arrdata['title'] = 'Pemakaian Barang Dalam Proses Subkontrak';
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Pemakaian Subkontrak","url"=>'report/pemakaian_subkon');
		$this->content = $this->load->view('report/pemakaian_bb',$arrdata,true);
		$this->index();
	}

	function pemasukan_hp() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		$arrdata['tipe'] = 'pemasukan_hp';
		$arrdata['title'] = 'Pemasukan Hasil Produksi';
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Pemasukan Hasil Produksi","url"=>'report/pemasukan_hp');
		$this->content = $this->load->view('report/pemakaian_bb',$arrdata,true);
		$this->index();
	}

	function pengeluaran_hp() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model('m_execute','model');
		$arrdata['kd_dok'] = $this->model->get_data('reff_dokumen','OUT');
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Pengeluaran Hasil Produksi","url"=>'report/pengeluaran_hp');
		$this->content = $this->load->view('report/pengeluran_hp',$arrdata,true);
		$this->index();
	}

	function mutasi() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Laporan Mutasi","url"=>'report/mutasi');
		$this->load->model('m_execute','model');
		$arrdata['jns_barang'] = $this->model->get_data('combo_jns_brg','');
		$this->content = $this->load->view('report/mutasi',$arrdata,true);
		$this->index();
	}

	function penyelesaian_waste() {
		if(!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$arrdata['title'] = 'Penyelesaian Waste / Scrap';
		$this->breadcrumbs = array("title"=>"Laporan","icon"=>"laptop","title_child"=>"Laporan Penyelesaian Waste/Scrap","url"=>'report/penyelesaian_waste');
		$this->content = $this->load->view('report/penyelesaian_waste',$arrdata,true);
		$this->index();
	}

	function proses($tipe="",$jenis_paper="") {
		if(!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		ini_set('memory_limit','-1');
		set_time_limit(0);
		error_reporting(E_ERROR);
		$this->load->model("m_report","model");
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post") {
			$tgl_awal 		= $this->input->post("tgl_awal");
			$tgl_akhir 		= $this->input->post("tgl_akhir");
			$no_aju 		= $this->input->post("txt_no_bc");
			$kd_dok 		= $this->input->post("kd_dok");
			$all 			= $this->input->post("all");
			$asal_barang 	= $this->input->post("asal_barang");
			$jns_brg 		= $this->input->post("jns_brg");
			$date_type		= $this->input->post('date_type');
			$no_bc			= $this->input->post('no_bc');
		}
		
		if(in_array($tipe, array("pemasukan","pengeluaran","mutasi","pemasukan_bb","pemakaian_bb","pemakaian_subkon","pemasukan_hp","pengeluaran_hp","mutasi","penyelesaian_waste"))) {		
			if ($tipe == 'pemasukan') {
				$tittle="Laporan Pemasukan Barang Per Dokumen Pabean";
			} elseif ($tipe == "pemasukan_bb") {
				$title = "Laporan Pemasukan Bahan Baku";
			} elseif ($tipe == "pemakaian_bb") {
				$title = "Laporan Pemakaian Bahan Baku";
			} elseif ($tipe == "pemakaian_subkon") {
				$title = "Laporan Pemakaian Barang Dalam Proses Subkontrak";
			} elseif ($tipe == "pemasukan_hp") {
				$title = "Laporan Pemasukan Hasil Produksi";
			} elseif ($tipe == "pengeluaran_hp") {
				$title = "Laporan Pengeluaran Hasil Produksi";
			} elseif ($tipe == "mutasi") {
				$title = "Laporan Mutasi Barang";
			} elseif ($tipe == "penyelesaian_waste") {
				$title = "Laporan Penyelesaian Waste / Scrap";
			}

			if(in_array($tipe, array("pemasukan","pengeluaran","pemasukan_bb","pemakaian_bb","pemakaian_subkon","pemasukan_hp","pengeluaran_hp","mutasi","penyelesaian_waste"))) $showpage = true;
			
			$query = $this->model->daftar($tipe, $tgl_awal, $tgl_akhir, $no_aju, $kd_dok, $all, $asal_barang, $jns_brg, $date_type, $no_bc);
			if ($query) {

				if ($all && $tipe == "mutasi") {
					$resArray = $this->db->query($query)->result_array();
					foreach ($resArray as $value) {
                        $valIn = $ValIn.$value["id_barang"].",";
                        $inArray[] = $value["id_barang"];
					}
					$inData = substr($valIn,0,strlen($ValIn)-1);
                    if (!$inData) $inData="''";

                    $query .= " UNION SELECT kd_brg, jns_brg, nm_brg, kd_satuan_terkecil, id as id_barang
                              FROM tm_barang 
                              WHERE kode_trader = ".$this->db->escape($this->session->userdata('KODE_TRADER'))." 
                              AND jns_brg = ".$this->db->escape($jns_brg);

                    if($indata!=''){
                        $query .= " AND id NOT IN(".$indata.") ";    
                    }
				}

				if($showpage) {
					$this->baris = 100;
					
					$table_count = $this->db->query("SELECT COUNT(1) AS JML FROM ($query) AS TBL");
					if($table_count){
						$table_count = $table_count->row();
						$total_record = $table_count = $table_count->JML;
					}else{
						$total_record = 0;
					}
					$table_count = ceil($table_count / $this->baris);
					$hal = $this->input->post('hal');
					if($jenis_paper) $hal = $this->input->post('halaman');
					if($hal < 1) $hal = 1;
					if($hal > $table_count) $hal = $table_count;
					if($hal<=1){
						$dari = 0;
						$sampai = $this->baris;
					}else{
						$dari = ($hal - 1) * $this->baris;
						$sampai = $this->baris;
					}

					$query .= " LIMIT $dari, $sampai";
					
					$datast = ($hal - 1);
					if($datast<1) $datast = 1;
					else $datast = $datast * $this->baris + 1;
					$dataen = $datast + $this->baris - 1;
					if($total_record < $dataen) $dataen = $total_record;
					if($total_record==0) $datast = 0;
					
					if($hal<=1)
						$no = 1;			
					else
						$no = ($hal - 1) * $this->baris + 1;
					
					if(!$jenis_paper) {
						$out .='<footer><tr class="head">
									<th colspan="17">
									<input type="hidden" class="tb_text" id="tb_view" value="'.$this->baris.'" readonly/> 
									<span style="float:left; padding-top: 10px;">&nbsp;'.$this->baris.' RECORDS PER PAGE. SHOWING '.$datast.' - '.$dataen.' OF '.number_format($total_record).' RECORDS.</span>';
						
						if($total_record > $this->baris){ 
							$actions = site_url()."/report/proses/".$tipe;
							$prev = $hal-1;
							$next = $hal+1;
							$firsExec = "lap_pagging('".$actions."', 'table-laporan', '1', 'frm_laporan');";
							$prevExec = "lap_pagging('".$actions."', 'table-laporan', '".$prev."', 'frm_laporan');";
							$nextExec = "lap_pagging('".$actions."', 'table-laporan', '".$next."', 'frm_laporan');";
							$lastExec = "lap_pagging('".$actions."', 'table-laporan', '".$total_record."', 'frm_laporan');";
							$forgo = "lap_pagging('".$actions."', 'table-laporan', document.getElementById('tb_halfrm_laporan').value, 'frm_laporan');";
							$out .="<span style=\"float: right\">";
							if ($hal != "1"){
								$out .="<a href=\"javascript:void(0)\" onclick=\"".$firsExec."\" title=\"First\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-fast-backward\"></i></a>&nbsp;";
								$out .="<a href=\"javascript:void(0)\" onclick=\"".$prevExec."\" title=\"Prev\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-step-backward\"></i></a>&nbsp;";
							}else{
								$out .="<button disabled=\"true\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-fast-backward\"></i></button>&nbsp;";
								$out .="<button disabled=\"true\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-step-backward\"></i></button>&nbsp;";
							}
							
							$out .="Page <input type=\"text\" class=\"tb_text\" name=\"tb_halfrm_laporan\" id=\"tb_halfrm_laporan\" title=\"Masukkan nomor halaman yang diinginkan kemudian tekan Go\" value=\"".$hal."\" ".$disabled." style=\"width:30px;text-align:right;height:30px; text-align: center;\"/>"; 
							
							$out .="&nbsp;<input type=\"button\" class=\"btn btn-sm btn-primary\" OnClick=\"".$forgo."\" value=\"Go\">";
							$out .=" Of ".$table_count;
							
							if ($hal != ($table_count)){
								$out .=" <a href=\"javascript:void(0)\" onclick=\"".$nextExec."\" title=\"Next\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-step-forward\"></i></a>&nbsp;";
								$out .="<a href=\"javascript:void(0)\" onclick=\"".$lastExec."\" title=\"Last\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-fast-forward\"></i></a>&nbsp;";	
							}else{
								$out .=" <button disabled=\"true\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-step-forward\"></i></button>&nbsp;";
								$out .="<button disabled=\"true\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-fast-forward\"></i></button>&nbsp;";
							}
							$out .="</span>";
						}else{
							$out .="<input type=\"hidden\" class=\"tb_text\" id=\"tb_halfrm_laporan\" value=\"".$hal."\" ".$disabled."  ondblclick=\"".$nextExec."\" style=\"width:30px;text-align:right;\"/>"; 	
						}
							
						$out .='</th></tr></footer>';
					}
				} else {
					$no = 1;	
				}
				$rs = $this->db->query($query);	
				$resultRow = $rs->result_array();
			}
			if ($tipe == "mutasi") {
				$stockopname = $this->model->getTglStockView("", $tgl_akhir);
			}
			$data = array(
				"resultData" 	=> $resultRow,
				"PAGING_TOP"	=> $out,
				"PAGING_BOT"	=> $out,
				"no"			=> $no,
				"halaman"		=> $hal,
				"tittle"		=> $title,
				"tipe"			=> $tipe,
				"jenis_paper"	=> $jenis_paper,
				"tgl_awal"		=> $tgl_awal,
				"tgl_akhir"		=> $tgl_akhir,
				"stockopname"	=> $stockopname
			);
			if(in_array($jenis_paper, array("pdf","xls"))) {
				error_reporting(E_ALL);
				ini_set("display_errors", 1);
				ini_set('memory_limit','-1');
				set_time_limit(0); 
				$html = $this->load->view('report/view', $data, true); 
				if($jenis_paper=="pdf"){
					$stylesheet = file_get_contents('assets/css/laporan.css');
					$mpdf = new \Mpdf\Mpdf(array("mode"=>"utf-8","format"=>"A4-L","margin_top"=>25, "default_font_size"=>10,"margin_right"=>7, "margin_left"=>7, "margin_bottom"=>5));
					$mpdf->ignore_invalid_utf8 = true; 
					$mpdf->SetProtection(array('print'));
					$mpdf->SetAuthor("invent2lite");
					$mpdf->SetCreator("invent2lite");
					$mpdf->list_indent_first_level = 0; 
					$mpdf->SetDisplayMode('fullpage');
            		$mpdf->SetTitle($title);
					$mpdf->AliasNbPages('[pagetotal]');
					$mpdf->SetHTMLHeader('<div align="justify">'.$this->session->userdata('NAMA_TRADER').'<br />'.$title.'<br />
						Periode '.date_format(date_create($tgl_awal), 'd-m-Y').' s/d '.date_format(date_create($tgl_akhir), 'd-m-Y').'<br />
						</div><div align="right" style="padding-top: -20px;">Halaman {PAGENO} dari [pagetotal]</div>','0',true);
					$mpdf->WriteHTML($stylesheet,1);
					$mpdf->WriteHTML($html);
					$mpdf->Output();
				}elseif($jenis_paper=="xls"){
					$this->cetakexcell($title,$html);	
				}else{
					$this->index();
					return;	
				}
			} else {
				$this->load->view('report/view', $data);
			}
		}
	}

	function cetakexcell($filename = "", $contents = "") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $html = '<style> td{mso-number-format:"\@";}</style>';
        $html .= $contents;
        $filename = str_replace(" ", "_", $filename) . ".xls";
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);
        header("Content-Transfer-Encoding: binary");
        echo $html;
    }
}