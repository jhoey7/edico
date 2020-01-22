<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_execute extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	function process($type, $act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$error = 0;
		$KODE_TRADER = $this->session->userdata('KODE_TRADER');
		$TIPE_DOKUMEN = $this->session->userdata("TIPE_DOKUMEN");
		$FAS_PERUSAHAAN = $this->session->userdata("FAS_PABEAN");

		if ($type=="save") {
			if ($act=="supplier") {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id!="") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					$query = "SELECT KD_SUPPLIER FROM reff_supplier 
							  WHERE NPWP_SUPPLIER  = ".$this->db->escape(trim($DATA['npwp_supplier']))."
							  AND KODE_TRADER = ".$this->session->userdata('KODE_TRADER');
					$result = $this->db->query($query);
					if($result->num_rows() > 0){
						$error += 1;
						$message = "Data gagal diproses, sudah terdapat data.";
					}else{
						$DATA['KODE_TRADER'] = $this->session->userdata('KODE_TRADER');

						$result = $this->db->insert('reff_supplier', $DATA);
						$func->main->get_log("add","supplier");
						if(!$result){
							$error += 1;
							$message = "Data gagal diproses";
						}
					}
				}
				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('referensi/supplier'));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "company") {
				$action = $this->input->post('action');
				if($action == "") $action = site_url()."/admin/company/new/post";
				if($id=="")  list($id) = $this->input->post("tb_chktblcompany");

				$id = $this->azdgcrypt->decrypt($id);
				$this->db->set("STATUS","1",FALSE);
				$this->db->where(array(
					"KODE_TRADER"	=> $id
				));
				$this->db->update("tm_perusahaan");
				$select = $this->db->select('email, nama_pemilik as nama, alamat_pemilik as alamat, telp_pemilik as telepon')->where('kode_trader', $id)->get('tm_perusahaan');
				if($select->num_rows()) {
					$arrdata = array_merge($select->row_array(),array("password"=>password_hash('123abc', PASSWORD_BCRYPT),"user_role"=>"2","kode_trader"=>$id));
					$insert = $this->db->insert('tm_user', $arrdata);
					if(!$insert) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>$action);
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "user") {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				} 
				if($id!=""){
					$error += 1;
					$message = "Data gagal diproses";
				}else{
					$query = "SELECT EMAIL FROM tm_user 
							  WHERE EMAIL  = ".$this->db->escape(trim($DATA['email']));
					$result = $this->db->query($query);
					if($result->num_rows() > 0){
						$error += 1;
						$message = "Data gagal diproses, Email sudah digunakan.";
					}else{
						$DATA['KODE_TRADER'] = $this->session->userdata('KODE_TRADER');
						$DATA['PASSWORD'] = password_hash('123abc', PASSWORD_BCRYPT);
						$result = $this->db->insert('tm_user', $DATA);
						if(!$result){
							$error += 1;
							$message = "Data gagal diproses.";
						}
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>$this->input->post('action'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "role") {
				$query = "SELECT uraian FROM tm_role WHERE uraian = '".$this->input->post("uraian")."'";
				$Exec = $this->db->query($query);
				if($Exec->num_rows() > 0) {
					$error += 1;
					$message = "Data gagal diproses, Role sudah digunakan.";
				} else {
					$role['uraian'] = $this->input->post("uraian");
					if($this->db->insert('tm_role', $role)) {
						$role_id = $this->db->insert_id();
						foreach($this->input->post('checkmenu') as $index=>$val){
							$AKSES = $this->input->post('akses_'.$val);
							$GROP_MENU["GRANT_TYPE"] 	= strtoupper($AKSES[0]);
							$GROP_MENU["MENU_ID"] 		= $val;
							$GROP_MENU["ROLE_ID"] 		= $role_id;
							$this->db->insert("tm_role_menu", $GROP_MENU);
						}
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>$this->input->post('action'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "warehouse") {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$query = "SELECT nama FROM tm_warehouse WHERE kode = ".$this->db->escape($DATA['kode']);
				$Exec = $this->db->query($query);
				if($Exec->num_rows() > 0) {
					$error += 1;
					$message = "Data gagal diproses, Kode warehouse sudah digunakan.";
				} else {
					$DATA['KODE_TRADER'] = $this->session->userdata('KODE_TRADER');
					$DATA['CREATED_BY'] = $this->session->userdata('ID');
					$result = $this->db->insert('tm_warehouse', $DATA);
					$func->main->get_log("add","warehouse");
					if (!$result) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('referensi/warehouse'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "barang") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if ($b == "") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id!="") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					$arrdetil = $this->input->post('WAREHOUSE');
					$arrkeys = array_keys($arrdetil);
					$countdtl = count($arrdetil[$arrkeys[0]]);
					$arr_check = array();
					for ($i = 0;$i < $countdtl; $i++) {
						for ($j = 0;$j < count($arrkeys); $j++) {
							$arr_check[] = $arrdetil[$arrkeys[$j]][$i];
						}
					} 
					if($func->main->ducplicate_array($arr_check) == true) {
						$error += 1;
						$message = "Terdapat Duplicat Gudang.";
					} else {
						$DATA['KODE_TRADER'] = $KODE_TRADER;
						$query = "SELECT ID FROM tm_barang 
								  WHERE KODE_TRADER = ".$KODE_TRADER." 
								  AND KD_BRG = ".$this->db->escape($DATA['kd_brg'])." 
								  AND JNS_BRG = ".$this->db->escape($DATA['jns_brg']);
						$result = $this->db->query($query);
						if ($result->num_rows() > 0) {
							$ID = $result->row()->ID;

							$arr_gudang_barang = $this->check_gudang_barang($ID);
							foreach ($arr_check as $val) {
								if ($arr_gudang_barang[$val]['ID'] == $val) {
									$msg .= $arr_gudang_barang[$val]['NAMA']."<br>";
								} else {
									++$x;
									$WAREHOUSE[$x]['ID_BARANG'] = $ID;
									$WAREHOUSE[$x]['ID_GUDANG'] = $val;
								}
							}

							if ($msg) {
								$error += 1;
								$message = "Terdapat gudang yang sudah ada di database, yaitu : <br>".$msg;
							} else {
								$result = $this->db->insert_batch("tm_barang_gudang",$WAREHOUSE);
								$func->main->get_log("add","inventory barang");
								if (!$result) {
									$error += 1;
									$message = "Data gagal diproses.";
								}
							}
						} else {
							if ($DATA['kd_satuan_terkecil'] == "") $DATA['kd_satuan_terkecil'] = $DATA['kd_satuan'];
							if ($DATA['nilai_konversi'] == "") $DATA['nilai_konversi'] = 1;

							$this->db->insert('tm_barang', $DATA);
							$ID = $this->db->insert_id();
							foreach ($arr_check as $val) {
								++$x;
								$WAREHOUSE[$x]['ID_BARANG'] = $ID;
								$WAREHOUSE[$x]['ID_GUDANG'] = $val;
							}
							$result = $this->db->insert_batch("tm_barang_gudang",$WAREHOUSE);
							$func->main->get_log("add","inventory barang");
							if (!$result) {
								$error += 1;
								$message = "Data gagal diproses.";
							}
						}
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>$this->input->post('action'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "grn" || $act == "gdn") {
				foreach($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id != "") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					if ($act == "grn") $DATA['JNS_INOUT'] = "IN";
					else $DATA['JNS_INOUT'] = "OUT";

					$DATA['KODE_TRADER'] = $KODE_TRADER;
					$DATA['CREATED_BY'] = $this->session->userdata('ID');

					$query = "SELECT no_inout FROM tpb_hdr WHERE KODE_TRADER = ".$KODE_TRADER;
					if ($TIPE_DOKUMEN == "1") {
						$query .= " AND jns_dokumen = ".$this->db->escape($DATA['jns_dokumen'])." AND nomor_aju = ".$this->db->escape($DATA['nomor_aju']);
					} else {
						$query .= " AND no_inout = ".$this->db->escape($DATA['no_inout']);
						$DATA['tgl_inout'] = trim($this->input->post('tgl_grn'))." ".trim($this->input->post('wk_grn'));
					}
					$result = $this->db->query($query);
					if ($result->num_rows() > 0) {
						$error += 1;
						$message = "No. ".strtoupper($act)." sudah ada.";
						if ($TIPE_DOKUMEN == "1") $message = "Nomor Aju sudah ada.";
					} else {
						$return = $this->db->insert('tpb_hdr', $DATA);
						$id_grn = $this->db->insert_id();
						if (!$return) {
							$error += 1;
							$message = "Data gagal diproses.";
						}
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url($act.'/daftar/preview/'.$this->azdgcrypt->crypt($id_grn)));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "grn_details" || $act == "gdn_details") {
				foreach($this->input->post('DATA') as $a => $b) {
					if ($b == "") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$DATA['id_hdr'] = $this->azdgcrypt->decrypt($id);
				$DATA['jml_satuan'] = currency($DATA['jml_satuan']);
				$DATA['unit_price'] = currency($DATA['unit_price']);
				$DATA['price'] = currency($DATA['price']);
				$DATA['created_by'] = $this->session->userdata('ID');

				if (in_array($this->session->userdata('FAS_PABEAN'), array(3,4))) {
					if ($this->input->post('chk_asal_barang') == "") {
						$DATA['asal_barang'] = "L";
					}
				}

				if (!$id) {
					$error += 1;
					$message = "Data gagal diproses.";
				} elseif ($DATA['id_barang'] == "") {
					$error += 1;
					$message = "Data gagal diproses.";
				} else {
					$result = $this->db->insert('tpb_dtl', $DATA);
					if (!$result) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url(str_replace('_details','',$act).'/details/'.$id.'/post'));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif (in_array($act, array("rm","scrap","half","fg"))) {
				foreach ($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id != "") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					$sql = "SELECT no_bukti_inout FROM tr_produksi_hdr 
							WHERE kode_trader = ".$KODE_TRADER." 
							AND no_bukti_inout = ".$this->db->escape($DATA["no_bukti_inout"]);
					$result = $this->db->query($sql);		
					if ($result->num_rows() > 0) {
						$error += 1;
						$message = "Nomor Bukti Pengeluaran sudah digunakan!";	
					} else {
						$DATA['tgl_bukti_inout'] = $this->input->post('tgl_produksi')." ".$this->input->post('wk_produksi');
						$DATA['jenis_produksi'] = strtoupper($act);
						$DATA['created_by'] = $this->session->userdata('ID');
						$DATA['kode_trader'] = $KODE_TRADER;
						$result = $this->db->insert('tr_produksi_hdr', $DATA);
						$ID = $this->db->insert_id();
						if (!$result) {
							$error += 1;
							$message = "Data gagal diproses.";
						}
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('produksi/'.$act.'/preview/'.$this->azdgcrypt->crypt($ID)));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "produksi_details") {
				$jenis_produksi = $this->input->post('type');
				foreach($this->input->post('DATA') as $a => $b) {
					if ($b == "") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$DATA['id_hdr'] = $this->azdgcrypt->decrypt($id);
				$DATA['jml_satuan'] = currency($DATA['jml_satuan']);

				if (!$id) {
					$error += 1;
					$message = "Data gagal diproses.";
				} elseif ($DATA['id_barang'] == "") {
					$error += 1;
					$message = "Data gagal diproses.";
				} elseif ($DATA['jml_satuan'] < 1) {
					$error += 1;
					$message = "Jumlah satuan tidak boleh 0 (nol).";
				} else {
					if ($jenis_produksi == "fg") {
						$arrdetil = $this->input->post('DETIL');
						if (count($arrdetil) == 0) {
							$error += 1;
							$message = "Proses Data Gagal<br/>Masukan dahulu data detil penggunaan bahan baku.";
						} else {
							$arrkeys = array_keys($arrdetil);
							$countdtl = count($arrdetil[$arrkeys[0]]);
							$arr_check = array();
							for ($i = 0;$i < $countdtl; $i++) {
								for ($j = 0;$j < count($arrkeys); $j++) {
									$detail[$i][$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
									if ($arrkeys[$j] == "jml_satuan") {
										$detail[$i][$arrkeys[$j]] = currency($arrdetil[$arrkeys[$j]][$i]);
									}
								}
								$arr_check[] = $detail[$i]["id_barang"];
							}
							if ($func->main->ducplicate_array($arr_check) == true) {
								$error += 1;
								$message = "Terdapat Duplicat Kode Barang Bahan Baku.";
							} else {
								if ($this->db->insert('tr_produksi_dtl', $DATA)) {
									$ID = $this->db->insert_id();
									for ($x = 0;$x < count($detail); $x++) {
										$detail[$x]['id_hdr'] = $this->azdgcrypt->decrypt($id);
										$detail[$x]['id_dtl'] = $ID;
									}
									$result = $this->db->insert_batch("tr_produksi_bb",$detail);
								} else {
									$error += 1;
									$message = "Data gagal diproses";
								}
					
								if (!$result) {
									$error += 1;
									$message = "Data gagal diproses.";
								}
							}
						}
					} else {
						$result = $this->db->insert('tr_produksi_dtl', $DATA);
					
						if (!$result) {
							$error += 1;
							$message = "Data gagal diproses.";
						}
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('produksi/details/'.$jenis_produksi.'/'.$id.'/post'));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "konversi") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id!="") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					$DATA['KODE_TRADER'] = $KODE_TRADER;
					$DATA['CREATED_BY'] = $this->session->userdata('ID');

					$query = "SELECT no_konversi FROM tm_konversi_hp WHERE KODE_TRADER = ".$KODE_TRADER." AND id_barang = ".$this->db->escape($DATA['id_barang']);
					$result = $this->db->query($query);
					if ($result->num_rows() > 0) {
						$error += 1;
						$message = "Kode Barang sudah ada.";
					} else {
						$return = $this->db->insert('tm_konversi_hp', $DATA);
						$id_grn = $this->db->insert_id();
						if (!$return) {
							$error += 1;
							$message = "Data gagal diproses.";
						}
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('inventory/konversi/preview/'.$this->azdgcrypt->crypt($id_grn)));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "konversi_bb") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id == "") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					$query = "SELECT id_barang FROM tm_konversi_bb WHERE id_hdr = ".$this->azdgcrypt->decrypt($id)." AND id_barang = ".$DATA['id_barang'];
					$result = $this->db->query($query);
					if ($result->num_rows() > 0) {
						$error += 1;
						$message = "Kode Barang Bahan Baku sudah ada.";
					} else {
						$DATA['jml_satuan'] = currency($DATA['jml_satuan']);
						$DATA['id_hdr'] = $this->azdgcrypt->decrypt($id);
						$return = $this->db->insert('tm_konversi_bb', $DATA);
						if (!$return) {
							$error += 1;
							$message = "Data gagal diproses.";
						}
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('inventory/konversi/bb/'.$id."/post"));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "setting") {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id!="") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					$this->db->where(array('KODE_TRADER'=>$KODE_TRADER));
					$this->db->update('tm_perusahaan',$DATA);

					$datses['FORMAT_CURRENCY'] = $DATA['format_currency'];
					$datses['FORMAT_QTY'] = $DATA['format_qty'];
					$datses['TIPE_DOKUMEN'] = $DATA['tipe_dokumen'];
					$datses['SHOW_AJU'] = $DATA['show_aju'];
					$this->session->set_userdata($datses);
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('tools/setting'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "stockopname") {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				} 

				$arrid = explode("~", $id);
				$tgl_stock = $this->azdgcrypt->decrypt($arrid[0]);

				$query = "SELECT id FROM tm_stockopname 
						  WHERE id_barang  = ".$this->db->escape(trim($DATA['id_barang']))." 
						  AND id_gudang = ".$this->db->escape(trim($DATA['id_gudang']))." 
						  AND kode_trader = ".$this->db->escape($KODE_TRADER)." 
						  AND DATE_FORMAT(tgl_stock, '%Y%m%d%H%i') = ".$this->db->escape($tgl_stock);
				$result = $this->db->query($query);
				if($result->num_rows() > 0){
					$error += 1;
					$message = "Data gagal diproses, Kode Barang dengan Kode Gudang Sudah Tersedia.";
				}else{
					$DATA['tgl_stock'] = date_format(date_create($tgl_stock), "Y-m-d H:i:s");
					$DATA['kode_trader'] = $KODE_TRADER;
					$DATA['jml_stockopname'] = currency($DATA['jml_stockopname']);

					$result = $this->db->insert('tm_stockopname', $DATA);
					if(!$result){
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('inventory/stockopname/preview/'.$arrid[0].'/ajax'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			}
		} elseif ($type == "update") {
			if($act=="supplier"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$this->db->where(array(
					"KD_SUPPLIER" => $this->azdgcrypt->decrypt($id)
				));
				$result = $this->db->update('reff_supplier', $DATA);
				$func->main->get_log("update","supplier");
				if(!$result){
					$error += 1;
					$message = "Data gagal diproses";
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('referensi/supplier'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "user") {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$this->db->where(array("ID"=>$this->azdgcrypt->decrypt($id)));
				$result = $this->db->update('tm_user', $DATA);
				if(!$result){
					$error += 1;
					$message = "Data gagal diproses";
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>$this->input->post('action'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "role") {
				if($this->db->delete('tm_role_menu',array("ROLE_ID"=>$this->azdgcrypt->decrypt($id)))) {
					foreach($this->input->post('checkmenu') as $index=>$val){
						$AKSES = $this->input->post('akses_'.$val);
						$GROP_MENU["GRANT_TYPE"] 	= strtoupper($AKSES[0]);
						$GROP_MENU["MENU_ID"] 		= $val;
						$GROP_MENU["ROLE_ID"] 		= $this->azdgcrypt->decrypt($id);
						$this->db->insert("tm_role_menu", $GROP_MENU);
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>$this->input->post('action'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "warehouse") {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$this->db->where(array("ID"=>$this->azdgcrypt->decrypt($id)));
				$result = $this->db->update('tm_warehouse', $DATA);
				$func->main->get_log("update","warehouse");
				if(!$result){
					$error += 1;
					$message = "Data gagal diproses";
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('referensi/warehouse'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "barang") {
				$arrdetil = $this->input->post('WAREHOUSE');
				foreach ($this->input->post('DATA') as $a => $b) {
					if ($b == "") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$arrkeys = array_keys($arrdetil);
				$countdtl = count($arrdetil[$arrkeys[0]]);
				$arr_check = array();
				for ($i = 0;$i < $countdtl; $i++) {
					for ($j = 0;$j < count($arrkeys); $j++) {
						$arr_check[] = $arrdetil[$arrkeys[$j]][$i];
					}
				}
				if($func->main->ducplicate_array($arr_check) == true) {
					$error += 1;
					$message = "Terdapat Duplicat Gudang.";
				} else {
					foreach ($arr_check as $val) {
						++$x;
						$WAREHOUSE[$x]['ID_BARANG'] = $this->azdgcrypt->decrypt($id);
						$WAREHOUSE[$x]['ID_GUDANG'] = $val;
					}

					if ($DATA['kd_satuan_terkecil'] == "") $DATA['kd_satuan_terkecil'] = $DATA['kd_satuan'];
					if ($DATA['nilai_konversi'] == "") $DATA['nilai_konversi'] = 1;
					
					$this->db->where(array("ID"=>$this->azdgcrypt->decrypt($id)));
					$this->db->update('tm_barang', $DATA);
					$this->db->where(array("ID_BARANG"=>$this->azdgcrypt->decrypt($id)));
					$this->db->delete('tm_barang_gudang');
					$result = $this->db->insert_batch("tm_barang_gudang",$WAREHOUSE);
					if (!$result) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>$this->input->post('action'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "grn" || $act =="gdn") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				
				$DATA['UPDATED_BY'] = $this->session->userdata('ID');
				$DATA['UPDATED_TIME'] = date('Y-m-d H:i:s');
				
				if ((trim($this->input->post('no_inout_hidden')) == $DATA['no_inout']) && $TIPE_DOKUMEN == "0") {
					$this->db->where(array(
						"ID"=>$this->azdgcrypt->decrypt($id),
						"STATUS"=>"D"
					));
					$result = $this->db->update('tpb_hdr', $DATA);
					if (!$result) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				} elseif ((trim($this->input->post('no_aju_hidden')) == $DATA['nomor_aju'] && trim($this->input->post('jns_dokumen')) == $DATA['jns_dokumen']) && $TIPE_DOKUMEN == "1") {
					$this->db->where(array(
						"ID"=>$this->azdgcrypt->decrypt($id),
						"STATUS"=>"D"
					));
					$result = $this->db->update('tpb_hdr', $DATA);
					if (!$result) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				} else {
					$query = "SELECT no_inout FROM tpb_hdr WHERE KODE_TRADER = ".$KODE_TRADER;
					if ($TIPE_DOKUMEN == "1") {
						$query .= " AND jns_dokumen = ".$this->db->escape($DATA['jns_dokumen'])." AND nomor_aju = ".$this->db->escape($DATA['nomor_aju']);
					} else {
						$query .= " AND no_inout = ".$this->db->escape($DATA['no_inout']);
						$DATA['tgl_inout'] = trim($this->input->post('tgl_grn'))." ".trim($this->input->post('wk_grn'));
					}
					$result = $this->db->query($query);
					if ($result->num_rows() > 0) {
						$error += 1;
						$message = "No. ".strtoupper($act)." sudah ada.";
						if ($TIPE_DOKUMEN == "1") $message = "Nomor Aju sudah ada.";
					} else {
						$this->db->where(array(
							"ID"=>$this->azdgcrypt->decrypt($id),
							"STATUS"=>"D"
						));
						$result = $this->db->update('tpb_hdr', $DATA);
						if (!$result) {
							$error += 1;
							$message = "Data gagal diproses.";
						}
					}
				}

				
				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url($act.'/daftar/preview/'.$id));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "grn_details" || $act =="gdn_details") {
				$arrid = explode("~", $this->azdgcrypt->decrypt($id));
				foreach($this->input->post('DATA') as $a => $b) {
					if ($b == "") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$DATA['jml_satuan'] = currency($DATA['jml_satuan']);
				$DATA['unit_price'] = currency($DATA['unit_price']);
				$DATA['price'] = currency($DATA['price']);
				$DATA['updated_by'] = $this->session->userdata('ID');
				$DATA['updated_time'] = date('Y-m-d H:i:s');

				if (in_array($this->session->userdata('FAS_PABEAN'), array(3,4))) {
					if ($this->input->post('chk_asal_barang') == "") {
						$DATA['asal_barang'] = "L";
					}
				}

				$this->db->where(array('ID'=>$arrid[0],"STATUS"=>"00"));
				$result = $this->db->update('tpb_dtl', $DATA);
				if (!$result) {
					$error += 1;
					$message = "Data gagal diproses.";
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url(str_replace('_details','',$act).'/details/'.$this->azdgcrypt->crypt($arrid[1]).'/post'));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif (in_array($act, array("rm","scrap","half","fg"))) {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				if (trim($this->input->post('no_bukti_inout_hidden')) != $DATA['no_bukti_inout']) {
					$sql = "SELECT no_bukti_inout FROM tr_produksi_hdr 
							WHERE kode_trader = ".$KODE_TRADER." 
							AND no_bukti_inout = ".$this->db->escape($DATA["no_bukti_inout"]);
					$result = $this->db->query($sql);		
					if ($result->num_rows() > 0) {
						$error += 1;
						$message = "Nomor Bukti Pengeluaran sudah digunakan!";	
					}
				} else {
					$DATA['tgl_bukti_inout'] = $this->input->post('tgl_produksi')." ".$this->input->post('wk_produksi');
					$DATA['updated_by'] = $this->session->userdata('ID');
					$DATA['updated_time'] = date('Y-m-d H:i:s');
					$this->db->where(array('id'=>$this->azdgcrypt->decrypt($id)));
					$result = $this->db->update('tr_produksi_hdr', $DATA);
					if (!$result) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('produksi/'.$act.'/preview/'.$id));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "produksi_details") {
				$jenis_produksi = $this->input->post('type');
				$arrid = explode("~", $this->azdgcrypt->decrypt($id));
				foreach($this->input->post('DATA') as $a => $b) {
					if ($b == "") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$DATA['jml_satuan'] = currency($DATA['jml_satuan']);

				if ($DATA['id_barang'] == "") {
					$error += 1;
					$message = "Data gagal diproses.";
				} elseif ($DATA['jml_satuan'] < 1) {
					$error += 1;
					$message = "Jumlah satuan tidak boleh 0 (nol).";
				} else {
					if ($jenis_produksi == "fg") {
						$arrdetil = $this->input->post('DETIL');
						if (count($arrdetil) < 0) {
							$error += 1;
							$message = "Proses Data Gagal<br/>Masukan dahulu data detil penggunaan bahan baku.";
						} else {
							$arrkeys = array_keys($arrdetil);
							$countdtl = count($arrdetil[$arrkeys[0]]);
							$arr_check = array();
							for ($i = 0;$i < $countdtl; $i++) {
								for ($j = 0;$j < count($arrkeys); $j++) {
									$detail[$i][$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
									if ($arrkeys[$j] == "jml_satuan") {
										$detail[$i][$arrkeys[$j]] = currency($arrdetil[$arrkeys[$j]][$i]);
									}
								}
								$arr_check[] = $detail[$i]["id_barang"];
							}
							if ($func->main->ducplicate_array($arr_check) == true) {
								$error += 1;
								$message = "Terdapat Duplicat Kode Barang Bahan Baku.";
							} else {
								for ($x = 0;$x < count($detail); $x++) {
									$detail[$x]['id_hdr'] = $arrid[1];
									$detail[$x]['id_dtl'] = $arrid[0];
								}
							}
						}
					}

					$this->db->where(array('ID'=>$arrid[0],"STATUS"=>"00"));
					$result = $this->db->update('tr_produksi_dtl', $DATA);
					if ($jenis_produksi == "fg") {
						$this->db->where(array('id_dtl'=>$arrid[0],'id_hdr'=>$arrid[1]));
						$this->db->delete('tr_produksi_bb');
						$result = $this->db->insert_batch("tr_produksi_bb",$detail);
					}
				}

				if (!$result) {
					$error += 1;
					$message = "Data gagal diproses.";
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('produksi/details/'.$jenis_produksi.'/'.$this->azdgcrypt->crypt($arrid[1]).'/post'));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "konversi") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id == "") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					$DATA['UPDATED_BY'] = $this->session->userdata('ID');
					$DATA['UPDATED_TIME'] = date('Y-m-d H:i:s');

					if ($DATA['no_konversi'] == $this->input->post('no_konversi_hidden')) {
						$this->db->where(array("id"=>$this->azdgcrypt->decrypt($id)));
						$return = $this->db->update('tm_konversi_hp',$DATA);
					} else {
						$query = "SELECT no_konversi FROM tm_konversi_hp WHERE KODE_TRADER = ".$KODE_TRADER." AND no_konversi = ".$this->db->escape($DATA['no_konversi']);
						$result = $this->db->query($query);
						if ($result->num_rows() > 0) {
							$error += 1;
							$message = "Nomor Konversi sudah ada.";
						} else {
							$this->db->where(array("id"=>$this->azdgcrypt->decrypt($id)));
							$return = $this->db->update('tm_konversi_hp',$DATA);
						}
					}
					
					if (!$return) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('inventory/konversi/preview/'.$id));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "konversi_bb") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				if ($id == "") {
					$error += 1;
					$message = "Data gagal diproses";
				} else {
					$arrid = explode("~", $this->azdgcrypt->decrypt($id));
					$DATA['jml_satuan'] = currency($DATA['jml_satuan']);

					if ($DATA['id_barang'] == $this->input->post('id_barang_hidden')) {
						$this->db->where(array("id"=>$arrid[0],"id_hdr"=>$arrid[1]));
						$return = $this->db->update('tm_konversi_bb', $DATA);
					} else {
						$query = "SELECT id_barang FROM tm_konversi_bb WHERE id_hdr = ".$arrid[1]." AND id_barang = ".$DATA['id_barang'];
						$result = $this->db->query($query);
						if ($result->num_rows() > 0) {
							$error += 1;
							$message = "Kode Barang Bahan Baku sudah ada.";
						} else {
							$this->db->where(array("id"=>$arrid[0],"id_hdr"=>$arrid[1]));
							$return = $this->db->update('tm_konversi_bb', $DATA);
						}
					}
					if (!$return) {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('inventory/konversi/bb/'.$this->azdgcrypt->crypt($arrid[1])."/post"));
				} else {
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "inout") {
				# code...
			} elseif ($act == "stockopname") {
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				} 

				$arrid = explode("~", $id);
				$tgl_stock = $this->azdgcrypt->decrypt($arrid[0]);
				$id = $this->azdgcrypt->decrypt($arrid[1]);

				$this->db->where(array('id'=>$id));
				$result = $this->db->update('tm_stockopname', array('jml_stockopname'=>currency($DATA['jml_stockopname'])));
				if(!$result){
					$error += 1;
					$message = "Data gagal diproses.";
				}

				if($error == 0){
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('inventory/stockopname/preview/'.$arrid[0].'/ajax'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			}
		} elseif ($type == "delete") { 
			$error = "Data gagal diproses.";
			if ($act == "supplier") {
				$action = site_url()."/referensi/supplier/post";
				$message = "Data berhasil diproses.";

				foreach($this->input->post('tb_chktblsupplier') as $chkitem) { 
					if ($this->check_status("partner","id",$chkitem) == true) {
						$error = "Data tidak dapat dihapus. <br/>Supplier sudah ada di mutasi.";
					} else {
						$result = $this->db->delete('reff_supplier', array('KD_SUPPLIER' => $this->azdgcrypt->decrypt($chkitem)));
					}
				}
			} elseif ($act == "user") {
				$action = site_url()."/users/user/post";
				$message = "Data berhasil diproses.";

				foreach($this->input->post('tb_chktbluser') as $chkitem) { 
					$result = $this->db->delete('tm_user', array('ID' => $this->azdgcrypt->decrypt($chkitem)));
				}
			} elseif ($act == "role") {
				$action = site_url()."/users/role/post";
				$message = "Data berhasil diproses.";

				foreach($this->input->post('tb_chktblrole') as $chkitem) { 
					$this->db->delete('tm_role', array('KODE_ROLE' => $this->azdgcrypt->decrypt($chkitem)));
					$result = $this->db->delete('tm_role_menu', array('ROLE_ID' => $this->azdgcrypt->decrypt($chkitem)));
				}
			} elseif ($act == "warehouse") {
				$action = site_url("/referensi/warehouse/post");
				$message = "Data berhasil diproses.";

				foreach($this->input->post('tb_chktblwarehouse') as $chkitem) { 
					if ($this->check_status("barang_inout","id_gudang",$chkitem) == true) {
						$error = "Data tidak dapat dihapus. <br/>Kode Barang sudah ada di mutasi.";
					} else {
						$result = $this->db->delete('tm_warehouse', array('ID' => $this->azdgcrypt->decrypt($chkitem)));
					}
				}
			} elseif ($act == "barang") {
				$action = site_url()."/inventory/barang/post";
				$message = "Data berhasil diproses.";

				foreach($this->input->post('tb_chktblbarang') as $chkitem) { 
					if ($this->check_status("barang_inout","id_brg",$chkitem) == true) {
						$error = "Data tidak dapat dihapus. <br/>Kode Barang sudah ada di mutasi.";
					} else {
						$this->db->delete('tm_barang_gudang', array('ID_BARANG' => $this->azdgcrypt->decrypt($chkitem)));
						$result = $this->db->delete('tm_barang', array('ID' => $this->azdgcrypt->decrypt($chkitem)));
					}
				}
			} elseif ($act == "grn" || $act == "gdn") {
				$x = 0; $y = 0;
				foreach ($this->input->post('tb_chktbl'.$act.'hdr') as $chkitem) {
					$this->db->delete('tpb_hdr', array('ID' => $this->azdgcrypt->decrypt($chkitem),"STATUS"=>"D"));
					if ($this->db->affected_rows()) {
						$x++;
					} else {
						$y++;
					}
				}
				if ($x == 0) {
					$result = false;
					$error = $y." Data sudah teralisasi.";
				} else {
					$action = site_url($act."/daftar/post");
					$message = $x." Data berhasil diproses & ".$y." data sudah teralisasi.";
					$result = true;
				}
			} elseif ($act == "grn_details" || $act == "gdn_details") {
				$div = str_replace("_details","",$act);
				foreach ($this->input->post('tb_chktbl'.$div.'dtl') as $chkitem) {
					$arrid = explode("~", $this->azdgcrypt->decrypt($chkitem));
					$ID_HDR = $arrid[1];
					$result = $this->db->delete('tpb_dtl', array('ID' => $arrid[0],"STATUS"=>"00"));
				}
				$action = site_url($div."/details/".$this->azdgcrypt->crypt($ID_HDR)."/post");
				$message = "Data berhasil diproses.";
			} elseif (in_array($act, array("rm","scrap","half","fg"))) {
				foreach ($this->input->post('tb_chktbl'.$act) as $chkitem) {
					$result = $this->db->delete('tr_produksi_hdr', array('ID' => $this->azdgcrypt->decrypt($chkitem),"STATUS"=>"D"));
				}
				$action = site_url("produksi/".$act."/post");
				$message = "Data berhasil diproses.";
			} elseif (in_array($act, array("rm_dtl","scrap_dtl","half_dtl","fg_dtl"))) {
				$div = str_replace("_dtl","",$act);
				foreach ($this->input->post('tb_chktblproduksidtl') as $chkitem) {
					$arrid = explode("~", $this->azdgcrypt->decrypt($chkitem));
					$ID_HDR = $arrid[1];
					$result = $this->db->delete('tr_produksi_dtl', array('ID' => $arrid[0],"STATUS"=>"00"));
				}
				$action = site_url("produksi/details/".$div."/".$this->azdgcrypt->crypt($ID_HDR)."/post");
				$message = "Data berhasil diproses.";
			} elseif ($act == "konversi") {
				foreach($this->input->post('tb_chktblkonversi') as $chkitem) { 
					$result = $this->db->delete('tm_konversi_hp', array('id' => $this->azdgcrypt->decrypt($chkitem)));
				}
				
				$action = site_url("/inventory/konversi/post");
				$message = "Data berhasil diproses.";
			} elseif ($act == "konversi_bb") {
				foreach($this->input->post('tb_chktblkonversidtl') as $chkitem) { 
					$arrid = explode("~", $this->azdgcrypt->decrypt($chkitem));
					$ID = $arrid[1];
					$result = $this->db->delete('tm_konversi_bb', array('id' => $arrid[0], 'id_hdr'=>$arrid[1]));
				}
				
				$action = site_url("/inventory/konversi/bb/".$this->azdgcrypt->crypt($ID)."/post");
				$message = "Data berhasil diproses.";
			} elseif ($act == "stockopname") {
				foreach($this->input->post('tb_chktblstockopname') as $chkitem) { 
					$this->db->where("DATE_FORMAT(tgl_stock,'%Y%m%d%H%i')",$this->azdgcrypt->decrypt($chkitem));
					$result = $this->db->delete('tm_stockopname');
				}
				
				$action = site_url("/inventory/stockopname/post");
				$message = "Data berhasil diproses.";
			} elseif ($act == "stockopnameById") {
				foreach($this->input->post('tb_chktblstockopnamedtl') as $chkitem) { 
					$this->db->where("id",$this->azdgcrypt->decrypt($chkitem));
					$result = $this->db->delete('tm_stockopname');
				}
				
				$action = site_url("/inventory/stockopname/preview/".$id."/ajax");
				$message = "Data berhasil diproses.";
			}

			if ($result) {
				return array("status"=>"success","message"=>$message,"_url"=>$action);
			} else {
				return array("status"=>"failed","message"=>$error);
			}
		} elseif ($type == "realisasi") {
			if ($act == "grn") {
				$tgl_realisasi = date('Y-m-d H:i:s');
				if ($this->input->post('tgl_realisasi')) {
					$tgl_realisasi = $this->input->post('tgl_realisasi')." ".$this->input->post('wk_realisasi');
				}
				foreach ($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				if (!$id) {
					$error += 1;
					$message = "Data gagal diproses.";
				} else {
					$query = "SELECT b.jml_satuan, b.kd_satuan, b.id as dtl_id, a.id, c.kd_brg, c.kd_satuan as kd_satuan_barang, unit_price,
							  c.kd_satuan_terkecil, c.nilai_konversi, c.id as id_barang, d.id_gudang as id_warehouse, e.nama as nama_gudang
							  FROM tpb_hdr a 
							  INNER JOIN tpb_dtl b on a.id = b.id_hdr
							  LEFT JOIN tm_barang c on c.id = b.id_barang and c.kode_trader = a.kode_trader
							  LEFT JOIN tm_barang_gudang d on d.id_barang = c.id AND b.id_warehouse = d.id_gudang
							  LEFT JOIN tm_warehouse e on e.id = b.id_warehouse and e.kode_trader = a.kode_trader
							  WHERE a.id = ".$this->azdgcrypt->decrypt($id)." 
							  AND a.jns_inout = 'IN'
							  AND a.status = 'D'
							  AND b.status = '00'
							  ORDER BY b.id ASC";

					$result = $this->db->query($query)->result_array();
					if (count($result) > 0) {
						$x = 0;
						foreach ($result as $value) {
							if ($value['kd_satuan'] != $value['kd_satuan_barang']) {
								if ($value['kd_satuan'] != $value['kd_satuan_terkecil']) {
									$msg_satuan .= "Kd. Barang = ".$value['kd_brg'].", satuannya : ".$value['kd_satuan_barang']." dan ".$value['kd_satuan_terkecil']."<br>";
								}
							}

							if (empty($value['id_barang'])) {
								$msg_barang .= $value['kd_brg']."<br/>";
							}

							if (empty($value['id_warehouse'])) {
								$msg_gudang .= $value['kd_brg']." dan ".$value['nama_gudang']."<br/>";
							}

							if ($value['kd_satuan'] != $value['kd_satuan_terkecil']) {
								$INOUT[$x]['jml_satuan'] = $value['nilai_konversi'] * $value['jml_satuan'];
							} else {
								$INOUT[$x]['jml_satuan'] = $value['jml_satuan'];
							}
							$INOUT[$x]['tipe'] = 'GATE-IN';
							$INOUT[$x]['tgl_realisasi'] = $tgl_realisasi;
							$INOUT[$x]['created_by'] = $this->session->userdata('ID');
							$INOUT[$x]['id_hdr'] = $value['id'];
							$INOUT[$x]['id_dtl'] = $value['dtl_id'];
							$INOUT[$x]['id_brg'] = $value['id_barang'];
							$INOUT[$x]['id_gudang'] = $value['id_warehouse'];
							$INOUT[$x]['kode_trader'] = $KODE_TRADER;


							$logbook[$x]['jml_satuan'] = $INOUT[$x]['jml_satuan'];
							$logbook[$x]['unit_price'] = $value['unit_price'];
							$logbook[$x]['saldo'] = $INOUT[$x]['jml_satuan'];
							$x++;
						}
						if ($msg_satuan) {
							$error += 1;
							$message = "Terdapat kode satuan yang tidak dikenali, yaitu :<br/>".$msg_satuan; 
						} elseif ($msg_barang) {
							$error += 1;
							$message = "Terdapat kode barang yang tidak dikenali yaitu :<br/>".$msg_barang;
						} elseif ($msg_gudang) {
							$error += 1;
							$message = "Terdapat kode barang dengan warehouse yang tidak dikenali yaitu :<br/>".$msg_gudang;
						} else {
							if ($this->session->userdata("TIPE_DOKUMEN") == "1") {
								$DATA['tgl_inout'] = $this->input->post('tgl_grn')." ".$this->input->post('wk_grn');
							}
							$DATA['tgl_realisasi'] = $tgl_realisasi;
							$DATA['status'] = "R";
							$DATA['updated_by'] = $this->session->userdata('ID');
							$DATA['updated_time'] = date('Y-m-d H:i:s');

							#start update and insert
							$this->db->trans_begin();
							$this->db->where(array("ID"=>$this->azdgcrypt->decrypt($id)));
							$this->db->update('tpb_hdr', $DATA);

							$this->db->where(array('id_hdr'=>$this->azdgcrypt->decrypt($id)));
							$this->db->update("tpb_dtl", array("status"=>"04"));
							$result = $this->db->insert_batch('tr_inout', $INOUT);

							// if ($FAS_PERUSAHAAN == "2" || $FAS_PERUSAHAAN == "5") {
							// 	#define data and insert into logbook
							// 	$first_id = $this->db->insert_id();
							// 	$this->insert_logbook('in', $first_id, $logbook);
							// }

							#commit jika transaksi berhasil dan rollback jika gagal
							if ($this->db->trans_status() === FALSE) $this->db->trans_rollback();
							else $this->db->trans_commit();
							
							if (!$result) {
								$error += 1;
								$message = "Data Gagal diproses.";
							}
						}
					} else {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('grn/daftar/post'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif ($act == "gdn") {
				$tgl_realisasi = date('Y-m-d H:i:s');
				if ($this->input->post('tgl_realisasi')) {
					$tgl_realisasi = $this->input->post('tgl_realisasi')." ".$this->input->post('wk_realisasi');
				}

				foreach ($this->input->post('DATA') as $a => $b) {
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				if (!$id) {
					$error += 1;
					$message = "Data gagal diproses.";
				} else {
					$query = "SELECT b.jml_satuan, b.kd_satuan, b.id as dtl_id, a.id, d.id as id_warehouse, c.kd_brg, 
							  c.kd_satuan as kd_satuan_barang, c.kd_satuan_terkecil, c.nilai_konversi, c.id as id_barang,
							  d.saldo, e.nama as nama_gudang, c.jns_brg, f.id_barang as id_barang_konversi
							  FROM tpb_hdr a 
							  INNER JOIN tpb_dtl b on a.id = b.id_hdr
							  LEFT JOIN tm_barang c on c.id = b.id_barang and c.kode_trader = a.kode_trader
							  LEFT JOIN tm_barang_gudang d on d.id_barang = c.id AND b.id_warehouse = d.id_gudang
							  LEFT JOIN tm_warehouse e on e.id = b.id_warehouse and e.kode_trader = a.kode_trader
							  LEFT JOIN tm_konversi_hp f on f.id_barang = b.id_barang
							  WHERE a.id = ".$this->azdgcrypt->decrypt($id)." 
							  AND a.jns_inout = 'OUT'
							  AND a.status = 'D'
							  AND b.status = '00'";
							  
					$result = $this->db->query($query)->result_array();
					if (count($result) > 0) {
						$x = 0;
						foreach ($result as $value) {
							if ($value['kd_satuan'] != $value['kd_satuan_barang']) {
								if ($value['kd_satuan'] != $value['kd_satuan_terkecil']) {
									$msg_satuan .= "Kd. Barang = ".$value['kd_brg'].", satuannya : ".$value['kd_satuan_barang']." dan ".$value['kd_satuan_terkecil']."<br>";
								}
							}

							if (empty($value['id_barang'])) {
								$msg_barang .= $value['kd_brg']."<br/>";
							}

							if (empty($value['id_warehouse'])) {
								$msg_gudang .= $value['kd_brg']." dan ".$value['nama_gudang']."<br/>";
							}

							if (empty($value['id_barang_konversi'])) {
								$msg_konversi .= $value['kd_brg'];
							}

							if ($value['kd_satuan'] != $value['kd_satuan_terkecil']) {
								$INOUT[$x]['jml_satuan'] = $value['nilai_konversi'] * $value['jml_satuan'];
							} else {
								$INOUT[$x]['jml_satuan'] = $value['jml_satuan'];
							}

							$arraytemp[] = $value["id_barang"].'|~|'.$value["id_warehouse"];
							$arraytemp_jumlah[$value["id_barang"].'|~|'.$value["id_warehouse"]]["jumlah"][] = $INOUT[$x]['jml_satuan'];														
							$jum_akhir = array_sum($arraytemp_jumlah[$value["id_barang"]."|~|".$value["id_warehouse"]]["jumlah"]);
							if($jum_akhir > $value['saldo']){
								$outstock .= $value["kd_brg"].' = '.$value['saldo'].'<br/>';
							}

							$INOUT[$x]['tipe'] = 'GATE-OUT';
							$INOUT[$x]['tgl_realisasi'] = $tgl_realisasi;
							$INOUT[$x]['created_by'] = $this->session->userdata('ID');
							$INOUT[$x]['id_hdr'] = $value['id'];
							$INOUT[$x]['id_dtl'] = $value['dtl_id'];
							$INOUT[$x]['id_brg'] = $value['id_barang'];
							$INOUT[$x]['id_gudang'] = $value['id_warehouse'];
							$INOUT[$x]['kode_trader'] = $KODE_TRADER;


							$logbook[$x]['jml_satuan'] = $INOUT[$x]['jml_satuan'];
							$logbook[$x]['unit_price'] = $value['unit_price'];
							$logbook[$x]['jns_brg'] = $value['jns_brg'];
							$logbook[$x]['id_barang'] = $value['id_barang'];
							$x++;
						}
						if ($msg_satuan) {
							$error += 1;
							$message = "Terdapat kode satuan yang tidak dikenali, yaitu : ".$msg_satuan; 
						} elseif ($msg_barang) {
							$error += 1;
							$message = "Terdapat kode barang yang tidak dikenali yaitu :<br/>".$msg_barang;
						} elseif ($msg_gudang) {
							$error += 1;
							$message = "Terdapat kode barang dengan warehouse yang tidak dikenali yaitu :<br/>".$msg_gudang;
						} elseif ($outstock) {
							$dtstock = str_replace(",",", ",substr($outstock,0,strlen($outstock)-1));			
							$dtjumlstock = count(explode(",",$dtstock));
							$error += 1;
							$message = "Terdapat <b>".$dtjumlstock."</b> Barang dengan Jumlah Stock tidak mencukupi.<br/>Jumlah Stock tersedia : <br/>".$dtstock;
						} elseif ($msg_konversi) {
							$error += 1;
							$message = "Kode Barang tidak terdaftar di konversi, yaitu: <br/>".$msg_konversi;
						} else { die('111');
							if ($this->session->userdata("TIPE_DOKUMEN") == "1") {
								$DATA['tgl_inout'] = $this->input->post('tgl_grn')." ".$this->input->post('wk_grn');
							}
							$DATA['tgl_realisasi'] = $tgl_realisasi;
							$DATA['status'] = "R";
							$DATA['updated_by'] = $this->session->userdata('ID');
							$DATA['updated_time'] = date('Y-m-d H:i:s');

							#start update and insert
							$this->db->trans_begin();
							$this->db->where(array("ID"=>$this->azdgcrypt->decrypt($id)));
							$this->db->update('tpb_hdr', $DATA);

							$this->db->where(array('id_hdr'=>$this->azdgcrypt->decrypt($id)));
							$this->db->update("tpb_dtl", array("status"=>"04"));
							$this->db->insert_batch('tr_inout', $INOUT);

							#define data and insert into logbook
							// if ($FAS_PERUSAHAAN == "2" || $FAS_PERUSAHAAN == "5") {
							// 	$first_id = $this->db->insert_id();
							// 	$result = $this->insert_logbook('out', $first_id, $logbook);
							// }

							#commit jika transaksi berhasil dan rollback jika gagal
							if ($this->db->trans_status() === FALSE) $this->db->trans_rollback();
							else $this->db->trans_commit();

							if (!$result) {
								$error += 1;
								$message = "Data Gagal diproses.";
							}
						}
					} else {
						$error += 1;
						$message = "Data gagal diproses.";
					}
				}

				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('gdn/daftar/post'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			} elseif (in_array($act, array("rm","scrap","half","fg"))) {
				foreach ($this->input->post('tb_chktbl'.$act) as $chkitem) {
					if (!$chkitem) {
						$error += 1;
						$message = "Data gagal diproses.";
					} else {
						$query = "SELECT b.jml_satuan, b.kd_satuan, b.id as dtl_id, a.id, b.id_gudang, c.kd_brg, a.tgl_bukti_inout,
								c.kd_satuan as kd_satuan_barang, c.kd_satuan_terkecil, c.nilai_konversi, b.id_barang, d.saldo
								FROM tr_produksi_hdr a 
								INNER JOIN tr_produksi_dtl b on a.id = b.id_hdr 
								LEFT JOIN tm_barang c on c.id = b.id_barang  and c.kode_trader = a.kode_trader
								LEFT JOIN tm_barang_gudang d on c.id = d.id_barang and d.id_gudang = b.id_gudang
								WHERE a.id = ".$this->azdgcrypt->decrypt($chkitem)." 
								AND a.status = 'D'";
						
						$result = $this->db->query($query)->result_array();
						if (count($result) > 0) {
							foreach ($result as $value) {
								++$x;
								if ($value['kd_satuan'] != $value['kd_satuan_barang']) {
									if ($value['kd_satuan'] != $value['kd_satuan_terkecil']) {
										$msg_satuan .= "Kd. Barang = ".$value['kd_brg'].", satuannya : ".$value['kd_satuan_barang']." dan ".$value['kd_satuan_terkecil']."<br>";
									}
								}

								if ($value['kd_satuan'] != $value['kd_satuan_terkecil']) {
									$INOUT[$x]['jml_satuan'] = $value['nilai_konversi'] * $value['jml_satuan'];
								} else {
									$INOUT[$x]['jml_satuan'] = $value['jml_satuan'];
								}

								if ($act == "rm") {
									$arraytemp[] = $value["id_barang"].'|~|'.$value["id_gudang"];
									$arraytemp_jumlah[$value["id_barang"].'|~|'.$value["id_gudang"]]["jumlah"][] = $INOUT[$x]['jml_satuan'];														
									$jum_akhir = array_sum($arraytemp_jumlah[$value["id_barang"]."|~|".$value["id_gudang"]]["jumlah"]);
									if($jum_akhir > $value['saldo']){
										$outstock .= $value["kd_brg"].' = '.$value['saldo'].'<br/>';
									}
									$INOUT[$x]['tipe'] = 'PROCESS_IN';
								} elseif($act == "scrap") {
									$INOUT[$x]['tipe'] = 'SCRAP';
								} elseif ($act == "half") {
									$INOUT[$x]['tipe'] = 'HALF';
								} elseif ($act == "fg") {
									$INOUT[$x]['tipe'] = 'PROCESS_OUT';
								}

								$INOUT[$x]['tgl_realisasi'] = $value['tgl_bukti_inout'];
								$INOUT[$x]['created_by'] = $this->session->userdata('ID');
								$INOUT[$x]['id_produksi_hdr'] = $value['id'];
								$INOUT[$x]['id_produksi_dtl'] = $value['dtl_id'];
								$INOUT[$x]['id_brg'] = $value['id_barang'];
								$INOUT[$x]['id_gudang'] = $value['id_gudang'];
								$INOUT[$x]['kode_trader'] = $KODE_TRADER;
							}
							if ($msg_satuan) {
								$error += 1;
								$message = "Terdapat kode satuan yang tidak dikenali, yaitu : ".$msg_satuan; 
							} elseif ($outstock) {
								$dtstock = str_replace(",",", ",substr($outstock,0,strlen($outstock)-1));			
								$dtjumlstock = count(explode(",",$dtstock));
								$error += 1;
								$message = "Terdapat <b>".$dtjumlstock."</b> Barang dengan Jumlah Stock tidak mencukupi.<br/>Jumlah Stock tersedia : <br/>".$dtstock;
							} else {
								$DATA['status'] = "R";
								$DATA['updated_by'] = $this->session->userdata('ID');
								$DATA['updated_time'] = date('Y-m-d H:i:s');
								$this->db->where(array("ID"=>$this->azdgcrypt->decrypt($chkitem)));
								$this->db->update('tr_produksi_hdr', $DATA);
								$this->db->where(array("ID_HDR"=>$this->azdgcrypt->decrypt($chkitem)));
								$this->db->update('tr_produksi_dtl', array('status'=>"04"));
								$result = $this->db->insert_batch('tr_inout', $INOUT);
								if (!$result) {
									$error += 1;
									$message = "Data Gagal diproses.";
								}
							}
						} else {
							$error += 1;
							$message = "Data gagal diproses.";
						}
					}
				}
				if ($error == 0) {
					return array("status"=>"success","message"=>"Data berhasil diproses.","_url"=>site_url('produksi/'.$act.'/post'));
				}else{
					return array("status"=>"failed","message"=>$message);
				}
			}
		} elseif ($type == "read") {
			if ($act == "barang") {
				$this->load->library('PHPExcel');
				$error = "";

				$arr_jns_barang = array('1','2','3','4','5');
				$arr_gudang = $func->main->get_array("SELECT KODE FROM tm_warehouse WHERE KODE_TRADER=".$this->db->escape($KODE_TRADER),"KODE");
				$arr_barang_validasi = $this->get_data('barang_validasi');
				$arr_gudang_validasi = $this->get_data('gudang_validasi');

				$mandatory = array("0","1","2","4","5","6","7");

				$field = array('KODE_BARANG','JENIS_BARANG','URAIAN_BARANG','KODE_HS','KODE_SATUAN','KODE_SATUAN_TERKECIL','NILAI_KONVERSI','KODE_GUDANG');
				$col = array('0','1','2','3','4','6','7');

				$namaFile = "BARANG_".date('YmdHis');
				$file = "assets/file/upload/";
				$ext = pathinfo($_FILES['fileupload']['name'], PATHINFO_EXTENSION);	
				
				$config['upload_path'] = $file;
				$config['allowed_types'] = 'xls|xlsx';
				$config['remove_spaces'] = TRUE;
				$config['max_size']	= '20000';
				$config['encrypt_name'] = TRUE;
				$config['file_name'] = $namaFile.".".$ext;
				$config['overwrite'] = TRUE;

				$this->load->library('upload' , $config);

				$this->upload->display_errors('' ,'' );
				if(!$this->upload->do_upload("fileupload")){
					$error = str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors()));
					$html = '<div class="alert alert-danger"><strong>Warning !</strong> '.$error.'</div>';
					unlink($file);
					return array("status"=>"failed","message"=>$html);
				}else{
					$data = $this->upload->data();			
					$file = $file.$data['file_name'];
					PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					$objPHPExcel = PHPExcel_IOFactory::load($file);
					$objPHPExcel->setActiveSheetIndex(0);

				 	$proses = FALSE;
					$kosong = FALSE;
					$validasi = FALSE;
					$JnsBarang = FALSE;
					$hs = FALSE;
					$gudang = FALSE;
					foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
						$highestRow         = $worksheet->getHighestRow(); 
						
						if($highestRow>10000){
							unlink($file);
							$error = "File Upload tidak boleh melebih 10.000 baris.";
							break;exit();
						}
						
						$highestColumn      = $worksheet->getHighestColumn(); 
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
						for($row=2; $row <= $highestRow; $row++){
							for($col=0; $col <= ($highestColumnIndex-1); $col++){
								#cek mandatory
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								if(in_array($col,$mandatory)){
									if(trim($cell->getCalculatedValue())==""){
										$kosong = TRUE;	
										$msgkosong = $msgkosong."KOLOM:[".$KOLOM[$col+1].",".$row."], ";
									}
								}
							}

							$cell_jenis = trim($worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());
							if($cell_jenis!=""){
								if(!in_array(trim($cell_jenis),$arr_jns_barang)){
									$JnsBarang = TRUE;
									$msgjnsbarang = $msgjnsbarang.$cell_jenis." (KOLOM:[B".",".$row."]), ";
								}
							}
							
							#cek lokasi
							$cell_gudang = trim($worksheet->getCellByColumnAndRow(7, $row)->getCalculatedValue());
							if($cell_gudang){
								if(!in_array(trim(strtoupper($cell_gudang)),$arr_gudang)){
									$gudang = TRUE;
									$msggudang = $msggudang.$cell_gudang." (KOLOM:[H".",".$row."]), ";
								}
							}
							
							#cek kode hs
							$cell_hs = str_replace(".","",$worksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue());
							if($cell_hs){
								if(!is_numeric($cell_hs)){
									$hs = TRUE;
									$msghs = $msghs.$cell_hs." (KOLOM:[D".",".$row."]), ";
								}
							}
							
						}
						if ($kosong) {
							$msg = "<b>Terdapat data yang kosong pada kolom yang harus diisi:</b> <br />".$msgkosong;
							$error .= $msg."<br />";
						}

						if ($JnsBarang){
							$msg ="<b>Jenis Barang tidak dikenali yaitu:</b> <br />".$msgjnsbarang;
							$error .= $msg."<br />";	
						}

						if ($hs) {
							$msg ="<b>HS harus dalam bentuk angka:</b> <br />".$msgjnsbarang;
							$error .= $msg."<br />";	
						}

						if ($gudang) {
							$msg ="<b>Kode Gudang tidak dikenali yaitu:</b> <br />".$msggudang;
							$error .= $msg."<br />";
						}

						if (!$error) {
							$index = 0;
							for ($row=2; $row <= $highestRow; $row++) {
								for ($col=0; $col <= ($highestColumnIndex-1); $col++) {
									$cell = $worksheet->getCellByColumnAndRow($col, $row);
									$CELLDATA = $cell->getCalculatedValue();
									$DATAEXCEL[$index][$field[$col]] = str_replace("'","",$CELLDATA);
								}
								$index++;
							}

							$berhasil = 0;
							foreach ($DATAEXCEL as $VAL) {
								if (count($arr_barang_validasi[$VAL['KODE_BARANG']]) == 0) {
									$barang['kd_brg'] = $VAL['KODE_BARANG'];
									$barang['jns_brg'] = $VAL['JENIS_BARANG'];
									$barang['nm_brg'] = $VAL['URAIAN_BARANG'];
									$barang['nilai_konversi'] = $VAL['NILAI_KONVERSI'];
									$barang['kd_satuan'] = $VAL['KODE_SATUAN'];
									$barang['kd_satuan_terkecil'] = $VAL['KODE_SATUAN_TERKECIL'];
									$barang['kode_trader'] = $KODE_TRADER;
									
									#insert ke master barang
									$this->db->insert('tm_barang', $barang);
									$id_barang = $this->db->insert_id();

									#insert ke master barang gudnag
									$this->db->insert('tm_barang_gudang', array(
										"id_barang"=> $id_barang,
										"id_gudang"=> $arr_gudang_validasi[$VAL['KODE_GUDANG']]['id']
									));
									$id_gudang = $this->db->insert_id();

									$arr_barang_validasi[$VAL['KODE_BARANG']]['id'] = $id_barang;
									$arr_barang_validasi[$VAL['KODE_BARANG']]['kd_brg'] = $VAL['KODE_BARANG'];
									$arr_barang_validasi[$VAL['KODE_BARANG']]['jns_brg'] = $VAL['JENIS_BARANG'];
									$berhasil += 1;
								} else {
									$id_barang = $arr_barang_validasi[$VAL['KODE_BARANG']]['id'];

									$sql = "SELECT a.id FROM tm_barang_gudang a 
											LEFT JOIN tm_barang b ON b.id = a.id_barang 
											LEFT JOIN tm_warehouse c on c.id = a.id_gudang
											WHERE a.id_barang = ".$this->db->escape($id_barang)." 
											AND c.kode = ".$this->db->escape($VAL['KODE_GUDANG']);
									$hasil = $this->db->query($sql);
									if ($hasil->num_rows() == 0) {
										$this->db->insert('tm_barang_gudang', array(
											"id_barang"=> $id_barang,
											"id_gudang"=> $arr_gudang_validasi[$VAL['KODE_GUDANG']]['id']
										));
										$berhasil += 1;
									}
								}
							}
							$html = '<div class="alert alert-success"><strong>Success !</strong> Sebanyak '.$berhasil.' data berhasil diproses.</div>';
							unlink($file);
							return array("status"=>"success","message"=>$html,"_url"=>site_url('inventory/barang/post'));
						} else {
							$html = '<div class="alert alert-danger"><strong>Warning !</strong> '.$error.'</div>';
							unlink($file);
							return array("status"=>"failed","message"=>$html);
						}
					}		
				}
			} elseif ($act == "stockopname") {
				$this->load->library('PHPExcel');
				$error = "";

				$arr_jns_barang = array('1','2','3','4','5');
				$arr_gudang = $func->main->get_array("SELECT KODE FROM tm_warehouse WHERE KODE_TRADER=".$this->db->escape($KODE_TRADER),"KODE");
				$arr_barang_validasi = $this->get_data('barang_gudang_validasi');

				$mandatory = array("0","1","2","3");

				$field = array('KODE_BARANG','JENIS_BARANG','JUMLAH_STOCKOPNAME','KODE_GUDANG');
				$col = array('0','1','2','3');

				$namaFile = "STOCKOPNAME_".date('YmdHis');
				$file = "assets/file/upload/";
				$ext = pathinfo($_FILES['fileupload']['name'], PATHINFO_EXTENSION);	
				
				$config['upload_path'] = $file;
				$config['allowed_types'] = 'xls|xlsx';
				$config['remove_spaces'] = TRUE;
				$config['max_size']	= '20000';
				$config['encrypt_name'] = TRUE;
				$config['file_name'] = $namaFile.".".$ext;
				$config['overwrite'] = TRUE;

				$this->load->library('upload' , $config);

				$this->upload->display_errors('' ,'' );
				if(!$this->upload->do_upload("fileupload")){
					$error = str_replace("<p>","",str_replace("</p>","",$this->upload->display_errors()));
					$html = '<div class="alert alert-danger"><strong>Warning !</strong> '.$error.'</div>';
					unlink($file);
					return array("status"=>"failed","message"=>$html);
				}else{
					$data = $this->upload->data();			
					$file = $file.$data['file_name'];
					PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					$objPHPExcel = PHPExcel_IOFactory::load($file);
					$objPHPExcel->setActiveSheetIndex(0);

				 	$proses = FALSE;
					$kosong = FALSE;
					$validasi = FALSE;
					$JnsBarang = FALSE;
					$gudang = FALSE;
					$barang = FALSE;

					foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
						$highestRow         = $worksheet->getHighestRow(); 
						
						if($highestRow>10000){
							unlink($file);
							$error = "File Upload tidak boleh melebih 10.000 baris.";
							break;exit();
						}
						
						$highestColumn      = $worksheet->getHighestColumn(); 
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
						for ($row=3; $row <= $highestRow; $row++) {
							for ($col=0; $col <= ($highestColumnIndex-1); $col++) {
								#cek mandatory
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								if (in_array($col,$mandatory)) {
									if (trim($cell->getCalculatedValue())=="") {
										$kosong = TRUE;	
										$msgkosong = $msgkosong."KOLOM:[".$KOLOM[$col+1].",".$row."], ";
									}
								}
							}
							
							#cek gudang
							$cell_gudang = trim($worksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue());
							if ($cell_gudang) {
								if (!in_array(trim(strtoupper($cell_gudang)),$arr_gudang)) {
									$gudang = TRUE;
									$msggudang = $msggudang.$cell_gudang." (KOLOM:[D".",".$row."]), ";
								}
							}

							#validasi jenis barang
							$cell_jenis = trim($worksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());
							if ($cell_jenis!="") {
								if (!in_array(trim($cell_jenis),$arr_jns_barang)) {
									$JnsBarang = TRUE;
									$msgjnsbarang = $msgjnsbarang.$cell_jenis." (KOLOM:[B".",".$row."]), ";
								}
							}

							#validasi barang
							$cell_barang = trim($worksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue());
							if ($cell_barang!="") {
								if (count($arr_barang_validasi[$cell_barang]) == 0) {
									$barang = TRUE;
									$msgbarang = $msgbarang.$cell_barang." (KOLOM:[A".",".$row."]), ";
								} else {
									if (count($arr_barang_validasi[$cell_barang][$cell_gudang]) == 0) {
										$barang = TRUE;
										$msgbarang = $msgbarang."Kode Barang: ".$cell_barang." dgn Kode Gudang: ".$cell_gudang."<br/> ";
									} else {
										if ($arr_barang_validasi[$cell_barang][$cell_gudang]['jns_brg'] != $cell_jenis) {
											$barang = TRUE;
											$msgbarang = $msgbarang."Kode Barang: ".$cell_barang." dgn Jenis Barang: ".$cell_jenis."<br/> ";
										}
									}
								}
							}
							
						}
						if ($kosong) {
							$msg = "<b>Terdapat data yang kosong pada kolom yang harus diisi:</b> <br />".$msgkosong;
							$error .= $msg."<br />";
						}

						if ($JnsBarang){
							$msg ="<b>Jenis Barang tidak dikenali yaitu:</b> <br />".$msgjnsbarang;
							$error .= $msg."<br />";	
						}

						if ($gudang) {
							$msg ="<b>Kode Gudang tidak dikenali yaitu:</b> <br />".$msggudang;
							$error .= $msg."<br />";
						}

						if ($barang) {
							$msg ="<b>Terdapat Kode barang tidak dikenali, yaitu :</b> <br />".$msgbarang;
							$error .= $msg."<br />";
						}

						if (!$error) {
							$index = 0;
							$tgl_stock = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(1,1)->getCalculatedValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);								
								
							if(strpos($tgl_stock,"/")===false) $tgl_stock = $tgl_stock;	
							else $tgl_stock = $this->fungsi->dateformat($tgl_stock);

							$jam = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCellByColumnAndRow(3, 1)->getCalculatedValue(), 'hh:mm');

							for ($row=3; $row <= $highestRow; $row++) {
								for ($col=0; $col <= ($highestColumnIndex-1); $col++) {
									$cell = $worksheet->getCellByColumnAndRow($col, $row);
									$CELLDATA = $cell->getCalculatedValue();

									$DATAEXCEL[$index]['TGL_STOCKOPNAME'] = str_replace("'","",$tgl_stock);
									$DATAEXCEL[$index]['JAM_STOCKOPNAME'] = str_replace("'","",$jam);
									$DATAEXCEL[$index][$field[$col]] = str_replace("'","",$CELLDATA);
								}
								$index++;
							}

							$berhasil = 0;
							foreach ($DATAEXCEL as $VAL) {
								$id_barang = $arr_barang_validasi[$VAL['KODE_BARANG']][$VAL['KODE_GUDANG']]['id_barang'];
								$id_gudang = $arr_barang_validasi[$VAL['KODE_BARANG']][$VAL['KODE_GUDANG']]['id_gudang'];
								$tgl_stock = $VAL['TGL_STOCKOPNAME']." ".$VAL['JAM_STOCKOPNAME'];

								$query = "SELECT id FROM tm_stockopname WHERE id_barang = ".$this->db->escape($id_barang)." AND id_gudang = ".$this->db->escape($id_gudang)." AND kode_trader = ".$this->db->escape($KODE_TRADER)." AND DATE_FORMAT(tgl_stock,'%Y-%m-%d %H:%i') = ".$this->db->escape($tgl_stock);
								$hasil = $this->db->query($query);
								if ($hasil->num_rows() == 0) {
									$stockopname[$berhasil]['tgl_stock'] = $tgl_stock.":00";
									$stockopname[$berhasil]['jml_stockopname'] = $VAL['JUMLAH_STOCKOPNAME'];
									$stockopname[$berhasil]['id_barang'] = $id_barang;
									$stockopname[$berhasil]['id_gudang'] = $id_gudang;
									$stockopname[$berhasil]['kode_trader'] = $KODE_TRADER;
									$berhasil++;
								}
							}
							if ($berhasil > 0) {
								$this->db->insert_batch('tm_stockopname', $stockopname);
							}

							$html = '<div class="alert alert-success"><strong>Success !</strong> Sebanyak '.$berhasil.' data berhasil diproses.</div>';
							unlink($file);
							return array("status"=>"success","message"=>$html,"_url"=>site_url('inventory/stockopname/post'));
						} else {
							$html = '<div class="alert alert-danger"><strong>Warning !</strong> '.$error.'</div>';
							unlink($file);
							return array("status"=>"failed","message"=>$html);
						}
					}		
				}
			}
		}
	}
	
	function get_data($act,$id="") { 
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$KODE_TRADER = $this->session->userdata('KODE_TRADER');
		$FAS_PERUSAHAAN = $this->session->userdata("FAS_PABEAN");
		if (in_array($act, array("barang_validasi","gudang_validasi","barang_gudang_validasi"))) $return = [];
		else $return = "";

		if ($act == "supplier") {
			$query = "SELECT a.nm_supplier, a.almt_supplier, a.kd_negara, b.uraian_negara, a.npwp_supplier
					  FROM reff_supplier a LEFT JOIN reff_negara b on b.kd_negara = a.kd_negara 
					  WHERE a.kd_supplier = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "user") {
			$query = "SELECT email, nama, alamat, telepon, user_role, status as status_user
				FROM tm_user
				WHERE id = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "role") {
			$query = "SELECT uraian FROM tm_role WHERE kode_role = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "warehouse") {
			$query = "SELECT nama, uraian FROM tm_warehouse WHERE id = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "barang") {
			$query = "SELECT a.kd_brg, a.jns_brg, a.nm_brg, a.nilai_konversi, a.kd_hs, a.kd_satuan, a.kd_satuan_terkecil, b.uraian AS ur_kd_satuan, c.uraian AS ur_kd_satuan_terkecil
					FROM tm_barang a LEFT JOIN reff_satuan b ON b.kd_satuan = a.kd_satuan 
					LEFT JOIN reff_satuan c ON c.kd_satuan = a.kd_satuan_terkecil 
					WHERE id = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "barang_gudang") {
			$query = "SELECT id_gudang, id FROM tm_barang_gudang WHERE id_barang = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($query)->result_array();
		} elseif ($act == "header") {
			$query = "SELECT a.no_inout, DATE_FORMAT(a.tgl_inout, '%Y-%m-%d') as tgl_grn, DATE_FORMAT(a.tgl_inout, '%H:%i') as wk_grn,
					  a.source_dokumen, a.partner_id, b.nm_supplier, case a.status when 'D' then 'DRAFT' when 'R' then 'REALISASI' end as status,
					  a.jns_dokumen, a.nomor_aju, a.tgl_daftar, a.no_daftar, a.kd_valuta, c.uraian_valuta
					  FROM tpb_hdr a 
					  LEFT JOIN reff_supplier b ON b.kd_supplier = a.partner_id
					  LEFT JOIN reff_valuta c on c.kode_valuta = a.kd_valuta
					  WHERE a.id = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "details") {
			$arrid = explode("~", $this->azdgcrypt->decrypt($id));
			$query = "SELECT a.id_barang, b.kd_brg, b.nm_brg, c.uraian as jenis_barang, a.kd_satuan, a.kd_negara_asal,
					  a.id_warehouse, d.nama as warehouse_name, a.asal_barang, a.seri_barang, f.uraian_negara as ur_negara_asal,
					  format(a.jml_satuan, ".$this->session->userdata('FORMAT_QTY').") as jml_satuan, 
					  format(a.unit_price, ".$this->session->userdata('FORMAT_CURRENCY').") as unit_price, 
					  format(a.price, ".$this->session->userdata('FORMAT_CURRENCY').") as price
					  FROM tpb_dtl a 
					  INNER JOIN tpb_hdr e ON e.id = a.id_hdr
					  LEFT JOIN tm_barang b on b.id = a.id_barang 
					  LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg AND c.fas_pabean IN('ALL','".$FAS_PERUSAHAAN."')
					  LEFT JOIN tm_warehouse d on d.id = a.id_warehouse
					  LEFT JOIN reff_negara f on f.kd_negara = a.kd_negara_asal
					  WHERE a.id = ".$this->db->escape($arrid[0]);
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "mst_barang_gudang") {
			$query = "SELECT a.id, a.kd_brg, a.nm_brg, b.id_gudang, c.nama as nama_gudang, d.uraian as jns_barang
					  FROM tm_barang a 
					  INNER JOIN tm_barang_gudang b on a.id = b.id_barang
					  LEFT JOIN tm_warehouse c on c.id = b.id_gudang
					  LEFT JOIN reff_jns_barang d on d.kd_jns = a.jns_brg AND d.fas_pabean IN('ALL','".$FAS_PERUSAHAAN."')
					  WHERE a.id = ".$id." 
					  AND b.id_gudang = ".$this->input->post('id_gudang');
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "header_produksi") {
			$query = "SELECT no_bukti_inout, keterangan, DATE_FORMAT(tgl_bukti_inout, '%Y-%m-%d') as tgl_inout, 
					  DATE_FORMAT(tgl_bukti_inout, '%H:%i') as wk_inout,
					  case status
					  	when 'D' then 'DRAFT'
						when 'R' then 'REALISASI'
					  end as status
					  FROM tr_produksi_hdr 
					  WHERE id = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "details_produksi") {
			$arrid = explode("~", $this->azdgcrypt->decrypt($id));
			$query = "SELECT a.jml_satuan, a.kd_satuan, a.keterangan, a.id_barang, a.id_gudang, b.kd_brg, 
					  b.nm_brg, c.uraian as jns_barang, d.nama as nama_gudang, e.id as id_konversi, e.no_konversi
					  FROM tr_produksi_dtl a
					  LEFT JOIN tm_barang b on b.id = a.id_barang
					  LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg AND c.fas_pabean in('ALL','".$FAS_PERUSAHAAN."')
					  LEFT JOIN tm_warehouse d on d.id = a.id_gudang 
					  LEFT JOIN tm_konversi_hp e on e.id = a.id_konversi
					  WHERE a.id_hdr = ".$arrid[1]." and a.id = ".$arrid[0];
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "produksi_bb") {
			$arrid = explode("~", $this->azdgcrypt->decrypt($id));
			$query = "SELECT a.kd_brg, b.uraian as jns_barang, c.id_barang, c.jml_satuan, a.kd_satuan_terkecil as kode_satuan
					  FROM tm_barang a
					  LEFT JOIN reff_jns_barang b on b.kd_jns = a.jns_brg AND b.fas_pabean in('ALL','".$FAS_PERUSAHAAN."')
					  RIGHT JOIN tr_produksi_bb c on a.id = c.id_barang
					  WHERE c.id_dtl = ".$arrid[0]." and c.id_hdr = ".$arrid[1];
			$return = $this->db->query($query)->result_array();
		} elseif ($act == "konversi_bb") {
			$sql = "SELECT a.kd_brg, a.nm_brg, b.uraian as jns_barang, c.jml_satuan, a.kd_satuan_terkecil as kd_satuan, c.id_barang
					FROM tm_barang a
					LEFT JOIN reff_jns_barang b on b.kd_jns = a.jns_brg AND b.fas_pabean in('ALL','".$FAS_PERUSAHAAN."') 
					LEFT JOIN tm_konversi_bb c on a.id = c.id_barang
					WHERE c.id_hdr = ".$id;
			$return = $this->db->query($sql)->result_array();
		} elseif ($act == "combo_role") {
			$query = "SELECT KODE_ROLE, URAIAN FROM tm_role WHERE KODE_ROLE <> '1'";
        	$return = $func->main->get_combobox($query, "KODE_ROLE", "URAIAN", TRUE);
		} elseif ($act == "combo_jns_brg") {
			$query = "SELECT KD_JNS, CONCAT(KD_JNS, ' - ', URAIAN) AS URAIAN FROM reff_jns_barang
					  WHERE FAS_PABEAN IN('ALL','".$this->session->userdata('FAS_PABEAN')."')";
        	$return = $func->main->get_combobox($query, "KD_JNS", "URAIAN", TRUE);
		} elseif ($act == "combo_warehouse") {
			$query = "SELECT ID, NAMA AS URAIAN FROM tm_warehouse WHERE KODE_TRADER = ".$KODE_TRADER;
        	$return = $func->main->get_combobox($query, "ID", "URAIAN", TRUE);
		} elseif ($act == "combo_partner") {
			$query = "SELECT KD_SUPPLIER, NM_SUPPLIER FROM reff_supplier WHERE KODE_TRADER = ".$KODE_TRADER;
        	$return = $func->main->get_combobox($query, "KD_SUPPLIER", "NM_SUPPLIER", TRUE);
		} elseif ($act == "reff_table") {
			$query = "SELECT REFF_CODE, REFF_DESCRIPTION FROM reff_table WHERE REFF_TYPE = ".$this->db->escape($id);
        	$return = $func->main->get_combobox($query, "REFF_CODE", "REFF_DESCRIPTION", TRUE);
		} elseif ($act == "reff_dokumen") {
			$query = "SELECT KODE_DOKUMEN, URAIAN_DOKUMEN FROM reff_dokumen 
					  WHERE FASILITAS = '".$this->session->userdata('FAS_PABEAN')."' 
					  AND TIPE IN('".$id."','ALL')";
        	$return = $func->main->get_combobox($query, "KODE_DOKUMEN", "URAIAN_DOKUMEN", TRUE);
		} elseif ($act == "konversi") {
			$sql = "SELECT a.no_konversi, a.keterangan, b.kd_brg, b.nm_brg, c.uraian as jns_barang, a.id_barang
					FROM tm_konversi_hp a 
					LEFT JOIN tm_barang b on b.id = a.id_barang
					LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg AND c.fas_pabean in('ALL','".$this->session->userdata('FAS_PABEAN')."')
					WHERE a.id = ".$this->azdgcrypt->decrypt($id);
			$return = $this->db->query($sql)->row_array();
		} elseif ($act == "konversi_dtl") {
			$arrid = explode("~", $this->azdgcrypt->decrypt($id));
			$sql = "SELECT FORMAT(a.jml_satuan,".$this->session->userdata('FORMAT_QTY').") as jml_satuan, a.keterangan, b.kd_brg, b.nm_brg, c.uraian as jns_barang, a.id_barang
					FROM tm_konversi_bb a 
					INNER JOIN tm_konversi_hp d on d.id = a.id_hdr
					LEFT JOIN tm_barang b on b.id = a.id_barang
					LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg AND c.fas_pabean in('ALL','".$FAS_PERUSAHAAN."')
					WHERE a.id = ".$arrid[0]." AND a.id_hdr = ".$arrid[1];
			$return = $this->db->query($sql)->row_array();
		} elseif ($act == "setting") {
			$query = "SELECT format_qty, format_currency, tipe_dokumen, show_aju
					  FROM tm_perusahaan WHERE KODE_TRADER = ".$KODE_TRADER;
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "inout") {
			$tgl_awal = $this->input->post('tgl_awal');
			$tgl_akhir = $this->input->post('tgl_akhir');
			$id_barang = $this->input->post('id_barang');
			$tgl_akhir_inout=date('Y-m-d',strtotime($tgl_awal."-1 day"));

			$sqlGetSaldoStock ="SELECT jml_stockopname, DATE_FORMAT(tgl_stock, '%Y-%m-%d') AS tgl_stock
								FROM tm_stockopname
								WHERE id_barang = ".$this->db->escape($id_barang)." 
								AND kode_trader = ".$this->db->escape($KODE_TRADER)."
								AND DATE_FORMAT(tgl_stock, '%Y-%m-%d') <= ".$this->db->escape($tgl_awal)."
							    ORDER BY tgl_stock DESC LIMIT 1";
			
			$RSSTOCKOPNAME=$this->db->query($sqlGetSaldoStock);
			if ($RSSTOCKOPNAME->num_rows() > 0) {
				$RSSTOCKOPNAME = $RSSTOCKOPNAME->row();
				$GETSALDOAWALSTOCK = $RSSTOCKOPNAME->jml_stockopname;
				$TGL_STOCKOPNAME = $RSSTOCKOPNAME->TANGGAL_STOCK;

				$TGLSTOCK = " BETWEEN '".date('Y-m-d',strtotime($TGL_STOCKOPNAME.'+1 day'))."' AND '".$tgl_akhir_inout."'";
			} else {
				$GETSALDOAWALSTOCK = 0;
				$TGL_STOCKOPNAME = "";

				$TGLSTOCK = " <= '".$tgl_akhir_inout."'";
			}
						 
			$sqlGetSaldoIn = "SELECT jml_satuan AS AWAL_SALDO_IN, STR_TO_DATE(MAX(tgl_realisasi),'%Y-%m-%d') AS TGL_IN
							  FROM tr_inout
							  WHERE id_brg = ".$this->db->escape($id_barang)."
							  AND kode_trader = ".$this->db->escape($KODE_TRADER)."
							  AND STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') ".$TGLSTOCK."
							  AND tipe IN ('GATE-IN','PROCESS_OUT','SCRAP','MOVE-IN')
							  GROUP BY id_brg";

			$sqlGetSaldoOut ="SELECT jml_satuan AS AWAL_SALDO_OUT, STR_TO_DATE(MAX(tgl_realisasi),'%Y-%m-%d') AS TGL_OUT
							  FROM tr_inout
							  WHERE id_brg = ".$this->db->escape($id_barang)."
							  AND kode_trader = ".$this->db->escape($KODE_TRADER)."
							  AND STR_TO_DATE(tgl_realisasi,'%Y-%m-%d') ".$TGLSTOCK."
							  AND tipe IN ('GATE-OUT','PROCESS_IN','MOVE-OUT','MUSNAH','RUSAK','SISA-LIMBAH')
	   					      GROUP BY id_brg";
				
			$RSGETSALDOAWALIN = $this->db->query($sqlGetSaldoIn);
			if ($RSGETSALDOAWALIN->num_rows() > 0) {
				$RSGETSALDOAWALIN = $RSGETSALDOAWALIN->row();
				$GETSALDOAWALIN = $RSGETSALDOAWALIN->AWAL_SALDO_IN;
				$TGL_IN = $RSGETSALDOAWALIN->TGL_IN;
			} else {
				$GETSALDOAWALIN = 0;
				$TGL_IN = "";
			}

			$RSGETSALDOAWALOUT = $this->db->query($sqlGetSaldoOut);
			if ($RSGETSALDOAWALOUT->num_rows() > 0) {
				$RSGETSALDOAWALOUT = $RSGETSALDOAWALOUT->row();
				$GETSALDOAWALOUT = $RSGETSALDOAWALOUT->AWAL_SALDO_OUT;
				$TGL_OUT = $RSGETSALDOAWALOUT->TGL_OUT;
			} else {
				$GETSALDOAWALOUT = 0;
				$TGL_OUT = "";
			}

			if($GETSALDOAWALSTOCK > 0){
				$SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT; 
			}else{
				if($TGL_STOCKOPNAME == $tgl_akhir_inout){
					$SALDOAWLGET = $GETSALDOAWALSTOCK;
				}else{
					if($TGL_STOCKOPNAME == $TGL_IN || $TGL_STOCKOPNAME == $TGL_OUT){
						$SALDOAWLGET = $GETSALDOAWALSTOCK;
					}else{
						$SALDOAWLGET = $GETSALDOAWALSTOCK + $GETSALDOAWALIN - $GETSALDOAWALOUT;
					}	
				}
			}	
			$SALDO_AWAL = $SALDOAWLGET;
			$TANGGAL_STOCK = $tgl_awal;
			#============================
			$SQL = "SELECT DATE_FORMAT(a.tgl_realisasi,'%d-%m-%Y %H:%i:%s') TANGGAL, a.tipe,
					CASE a.tipe
						WHEN 'GATE-IN' THEN CONCAT('REALISASI PEMASUKAN (GATE-IN)',' ',b.jns_dokumen,' ',b.no_inout)
						WHEN 'GATE-OUT' THEN CONCAT('REALISASI PENGELUARAN (GATE-OUT)',' ',b.jns_dokumen,' ',b.no_inout)
						WHEN 'PROCESS_IN' THEN IF(c.no_bukti_inout IS NULL,'PRODUKSI MASUK (-)',CONCAT('PRODUKSI MASUK (-)',' ',c.no_bukti_inout))
						WHEN 'PROCESS_OUT' THEN IF(c.no_bukti_inout IS NULL,'PRODUKSI KELUAR (+)',CONCAT('PRODUKSI KELUAR (+)',' ',c.no_bukti_inout))
						WHEN 'SCRAP' THEN IF(c.no_bukti_inout IS NULL,'PRODUKSI SISA (+)',CONCAT('PRODUKSI SISA (+)',' ',c.no_bukti_inout)) 
					END TIPE_URAIAN, a.jml_satuan AS JUMLAH
					FROM tr_inout a
					LEFT JOIN tpb_hdr b ON b.id = a.id_hdr
					LEFT JOIN tr_produksi_hdr c on c.id = a.id_produksi_hdr
					WHERE a.id_brg = ".$this->db->escape($id_barang)." 
					AND a.kode_trader = ".$this->db->escape($KODE_TRADER)."
					AND DATE_FORMAT(a.tgl_realisasi, '%Y-%m-%d') BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
					ORDER BY DATE_FORMAT(a.tgl_realisasi, '%Y-%m-%d') ASC, DATE_FORMAT(a.tgl_realisasi, '%H:%i-%s') ASC";# echo $SQL;die();

			$hasil = $this->db->query($SQL);
			if($hasil->num_rows() > 0){
				$return .= '<br><table width="100%"><tr>';
				// $return .= '<td><a href="javascript:void(0);" onclick="print_report(\'inout\',\'pdf\')" class="btn btn-danger btn-sm"><i class="fa fa-print"></i>&nbsp;Cetak Dokumen PDF</a>&nbsp;<a href="javascript:void(0);" onclick="print_report(\'inout\',\'excel\')" class="btn btn-success btn-sm"><i class="fa fa-print"></i>&nbsp;Cetak Dokumen Excel</a></td>';			
				// if(in_array($this->session->userdata('USER_ROLE'),array("2"))) {#ROLE ADMIN
					// $return .= '<td align="right"><a class="btn btn-info" onclick="updateinout(\'frm_laporan\');" href="javascript:void(0);"><i class="fa fa-exchange"></i> Update Stock Akhir</a></td>';
				// }
				// $return .= '</tr></table>';
			}
			$return .= '<span class="buton"></span>';	
			$return .= '<table class="tabelajax">';
			$return .= '<th width="1px">No</th>';
			$return .= '<th>TANGGAL</th>';
			$return .= '<th>KETERANGAN</th>';
			$return .= '<th>PEMASUKAN</th>';
			$return .= '<th>PENGELUARAN</th>';
			$return .= '<th>SALDO</th>';
			$return .= '</tr>';		
			$return .= '<tr><td>1</td>';
			$return .= '<td>'.$TANGGAL_STOCK.'</td>';		
			$return .= '<td>SALDO AWAL</td>';			
			$return .= '<td>&nbsp;</td>';				
			$return .= '<td>&nbsp;</td>';			
			$return .= '<td align="right">'.number_format($SALDO_AWAL,2).'</td>';	
			$return .= '</tr>';
			$no = 1;
			if($hasil->num_rows() > 0){
				$no=2;
				$SALDO = 0;
				$TOTAL_MASUK = 0;
				$TOTAL_KELUAR = 0;
				$TOTAL_SALDO = 0;
				foreach($hasil->result_array() as $row) {
					$return .= '<tr>';
					$return .= '<td>'.$no.'</td>';
					$return .= '<td>'.$row['TANGGAL'].'</td>';
					$return .= '<td>'.$row['TIPE_URAIAN'].'</td>';
					if (in_array($row['tipe'], array("GATE-IN", "PROCESS_OUT", "SCRAP"))) {
						$return .= '<td align="right">'.number_format($row['JUMLAH'],2).'</td>';
						$return .= '<td>&nbsp;</td>';
						if($no==2){
							$SALDO = (float)$SALDO_AWAL + (float)$row['JUMLAH'];
						}else{
							$SALDO = (float)$SALDO + (float)$row['JUMLAH'];	
						}
						$TOTAL_MASUK = (float)$TOTAL_MASUK+(float)$row['JUMLAH'];
					} else {
						$return .= '<td>&nbsp;</td>';
						$return .= '<td align="right">'.number_format($row['JUMLAH'],2).'</td>';
						if($no==2){ 
							$SALDO = (float)$SALDO_AWAL - (float)$row['JUMLAH'];
						}else{
							$SALDO = (float)$SALDO - (float)$row['JUMLAH'];
						}
						$TOTAL_KELUAR = (float)$TOTAL_KELUAR+(float)$row['JUMLAH'];
					}
					$hastak = ".";
					$x = strpos($SALDO,$hastak);
					if($x !== false){
						$explode = explode(".",$SALDO);
						if(strlen($explode[1]) == 1){
							$SALDO = $SALDO."0";
						}else{
							$SALDO = $SALDO;
						}
					}else{
						$SALDO = $SALDO.".00";
					}
					if(number_format($SALDO,2)=='-0.00'){
						$SALDO = '0.00';
					}
					$TOTAL_SALDO = (float)$TOTAL_SALDO+(float)$SALDO;
					$return .= '<td align="right">'.number_format($SALDO,2).'</td>';
					$return .= '</tr>';	
					$no++;
				}			
				$return .= '<tr>';		
				$return .= '<td colspan="3" align="right"><b>TOTAL :</b></td>';		
				$return .= '<td align="right"><b>'.number_format($TOTAL_MASUK,2).'</b></td>';		
				$return .= '<td align="right"><b>'.number_format($TOTAL_KELUAR,2).'</b></td>';		
				$return .= '<td align="right"><b>'.number_format($SALDO,2).'</b></td>';
				
				$return .= '<tr>';		
			}
			if($no==1) $SALDO = (float)$SALDO_AWAL;
			$return .= '<table>';
		} elseif ($act == "barang_validasi") {
			$sql = "SELECT id, kd_brg, jns_brg FROM tm_barang WHERE kode_trader = ".$this->db->escape($KODE_TRADER);
			$result = $this->db->query($sql);
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $value) {
					$return[$value['kd_brg']]['id'] = $value['id'];
					$return[$value['kd_brg']]['kd_brg'] = $value['kd_brg'];
					$return[$value['kd_brg']]['jns_brg'] = $value['jns_brg'];
				}
			}
		} elseif ($act == "gudang_validasi") {
			$sql = "SELECT id, kode FROM tm_warehouse WHERE kode_trader = ".$this->db->escape($KODE_TRADER);
			$result = $this->db->query($sql);
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $value) {
					$return[$value['kode']]['id'] = $value['id'];
					$return[$value['kode']]['kode'] = $value['kode'];
				}
			}
		} elseif ($act == "barang_gudang_validasi") {
			$sql = "SELECT a.kd_brg, a.jns_brg, b.id_barang, b.id_gudang, c.kode
					  FROM tm_barang a 
					  LEFT JOIN tm_barang_gudang b on b.id_barang = a.id
					  LEFT JOIN tm_warehouse c on c.id = b.id_gudang";
			$result = $this->db->query($sql);
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $value) {
					$return[$value['kd_brg']][$value['kode']]['id_barang'] = $value['id_barang'];
					$return[$value['kd_brg']][$value['kode']]['id_gudang'] = $value['id_gudang'];
					$return[$value['kd_brg']][$value['kode']]['jns_brg'] = $value['jns_brg'];
				}
			}
		} elseif ($act == "stockopname") {
			$query = "SELECT DATE_FORMAT(tgl_stock, '%d %M %Y %H:%i') as tgl_stock
					  FROM tm_stockopname
					  WHERE DATE_FORMAT(tgl_stock, '%Y%m%d%H%i') = ".$this->azdgcrypt->decrypt($id)." LIMIT 1";
			$return = $this->db->query($query)->row_array();
		} elseif ($act == "stockopname_dtl") {
			$id = $this->azdgcrypt->decrypt($id);
			$query = "SELECT a.id_barang, a.id_gudang, b.nm_brg, c.uraian as jenis_barang, d.nama as warehouse_name, b.kd_brg,
					  format(a.jml_stockopname, ".$this->session->userdata('FORMAT_CURRENCY').") as jml_stockopname
					  FROM tm_stockopname a
					  LEFT JOIN tm_barang b on b.id = a.id_barang 
					  LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg AND c.fas_pabean IN('ALL','".$FAS_PERUSAHAAN."')
					  LEFT JOIN tm_warehouse d on d.id = a.id_gudang
					  WHERE a.id = ".$this->db->escape($id);
			$return = $this->db->query($query)->row_array();
		}
		return $return;
	}

	function menu_management($groupid=""){
		$func = get_instance();
		$func->load->model("m_main","main",true);
		if($groupid) {
			$SQL= "SELECT a.menu_id, a.menu_tittle, a.menu_parent_id, a.menu_have_child, b.grant_type,
					f_menuchecked(a.menu_id,'".$this->azdgcrypt->decrypt($groupid)."') AS checked
					FROM tm_menu a 
					LEFT JOIN tm_role_menu b 
						ON b.menu_id = a.menu_id AND a.menu_type = 'A' AND b.role_id = ".$this->azdgcrypt->decrypt($groupid)." 
					WHERE a.menu_parent_id = '0' 
					AND a.menu_fas IN('".$this->session->userdata('FAS_PABEAN')."','ALL')
					ORDER BY a.menu_id ASC";
		} else {
			$SQL= "SELECT menu_id, menu_tittle, menu_parent_id, menu_have_child 
				   FROM tm_menu 
				   WHERE menu_parent_id = '0' 
				   	AND menu_type = 'A' 
					AND menu_fas IN('".$this->session->userdata('FAS_PABEAN')."','ALL')
				   ORDER BY menu_id ASC";
		}
		if($func->main->get_result($SQL)){
			$first=1;
			$second=2;
			$html = '<table class="tabelPopUp" width="100%" id="treeView">';
			$html.= '<thead>';
			$html.= '<tr>';
			$html.= '	<th width="2%"><input type="checkbox" name="checkAllmenu" id="checkAllmenu" class="tb_chk" onclick="menucheckAll(\'form_role\')"/></th>';
			$html.= '	<th width="35%">GRANT NAME</th>';
			$html.= '	<th width="10%">GRANT TYPE</th>';
			$html.= '</tr>';
			$html.= '</thead>';
			$html.= '</tbody>';
			$akses="";
			$child_w="";$child_r="";
			foreach($SQL->result_array() as $parent){
				$html .= '<tr id="node-'.$first.'">';
				$html .= '<td><input type="checkbox" name="checkmenu[]" id="checkmenuParent_'.$parent["menu_id"].'" class="tb_chk" value="'.$parent["menu_id"].'" onclick="menucheckParent(\'form_role\',\''.$parent["menu_id"].'\')" '.$parent["checked"].'/></td>';	
				$html .= '<td>'.strtoupper($parent["menu_tittle"]).'</td>';	
				if($parent['menu_have_child'] == "Y"){
					$html .= '<td><input type="hidden" name="akses_'.$parent["menu_id"].'[]" id="akses'.$parent["menu_id"].'" class="akses_w" value="rw" /></td>';
				} else {
					$html .= '<td><input type="radio" name="akses_'.$parent["menu_id"].'[]" id="akses'.$parent["menu_id"].'" class="akses_w" value="w" '.$child_w.'/> Write';	
					$html .= '&nbsp;';
					$html .= '<input type="radio" name="akses_'.$parent["menu_id"].'[]" id="akses'.$parent["menu_id"].'" class="akses_r" value="r" '.$child_r.'/> Read</td>';	
				}
				$html .= '</tr>';
				
				if($groupid) {
					$query = "SELECT a.menu_id, a.menu_tittle, a.menu_parent_id, b.grant_type,
							  f_menuchecked(a.menu_id,'".$this->azdgcrypt->decrypt($groupid)."') AS checked
							  FROM tm_menu a 
							  LEFT JOIN tm_role_menu b 
							  	ON b.menu_id = a.menu_id AND a.menu_type = 'A' AND b.role_id = '".$this->azdgcrypt->decrypt($groupid)."' 
							  WHERE a.menu_parent_id = '".$parent["menu_id"]."' 
							  AND a.menu_fas IN('".$this->session->userdata('FAS_PABEAN')."','ALL')
							  ORDER BY a.menu_parent_id, a.menu_order ASC";
				} else {
					$query = "SELECT menu_id, menu_tittle, menu_parent_id 
							  FROM tm_menu WHERE menu_parent_id = ".$parent["menu_id"]." 
							  AND menu_fas IN('".$this->session->userdata('FAS_PABEAN')."','ALL')
							  ORDER BY menu_parent_id, menu_order ASC";	
				}  												  							
				if($func->main->get_result($query)){
					foreach($query->result_array() as $child){
						if($first>1) $second = $second+1;
						$html .= '<tr id="node-'.$second.'" class="child-of-node-'.$first.'">';		
						$html .= '<td><input type="checkbox" name="checkmenu[]" id="checkmenuChild_'.$child["menu_parent_id"].'" class="checkmenuChild_'.$child["menu_parent_id"].'" value="'.$child["menu_id"].'" onclick="menucheckChild(\'form_role\',\''.$child["menu_parent_id"].'\')"  '.$child["checked"].'/></td>';				
						$html .= '<td style="background-color:#FFFFCC"><span class="file">&nbsp;&nbsp;'.strtoupper($child["menu_tittle"]).'</span></td>';
						$html .= '<td><input type="radio" name="akses_'.$child["menu_id"].'[]" id="akses'.$child["menu_id"].'" class="akses_w" value="w" '.$child_w.'/> Write';	
						$html .= '&nbsp;';
						$html .= '<input type="radio" name="akses_'.$child["menu_id"].'[]" id="akses'.$child["menu_id"].'" class="akses_r" value="r" '.$child_r.'/> Read</td>';	
						$html .= '</tr>';
						$second++;
					}
				}
				$first = $second-1;
				$first++;
			}			
			$html .= '</tbody>';
			$html .= '</table>';
		}
		return $html;
	}

	function check_gudang_barang($id) {
		$query = "SELECT A.ID_GUDANG, B.NAMA FROM tm_barang_gudang A INNER JOIN tm_warehouse B ON B.ID = A.ID_GUDANG WHERE A.ID_BARANG = ".$id;
		$arrdata = $this->db->query($query)->result_array();
		foreach ($arrdata as $val) {
			$return[$val['ID_GUDANG']]['ID'] = $val['ID_GUDANG'];
			$return[$val['ID_GUDANG']]['NAMA'] = $val['NAMA'];
		}
		return $return;
	}

	function check_status($table, $status, $id) {
		if ($table == "tpb_hdr") {
			$query = "SELECT ID FROM tpb_hdr WHERE ID = ".$this->azdgcrypt->decrypt($id)." AND STATUS = ".$this->db->escape($status);
			$result = $this->db->query($query);
			if($result->num_rows() > 0) {
				return true;
			}
			return false;
		} elseif ($table == "tpb_dtl") {
			$arrid = explode("~", $this->azdgcrypt->decrypt($id));
			$query = "SELECT ID FROM tpb_dtl WHERE ID = ".$arrid[0]." AND STATUS = ".$this->db->escape($status);
			$result = $this->db->query($query);
			if($result->num_rows() > 0) {
				return true;
			}
			return false;
		} elseif($table == "produksi_hdr") {
			$query = "SELECT ID FROM tr_produksi_hdr WHERE ID = ".$this->azdgcrypt->decrypt($id)." AND STATUS = ".$this->db->escape($status);
			$result = $this->db->query($query);
			if($result->num_rows() > 0) {
				return true;
			}
			return false;
		} elseif($table == "produksi_dtl") {
			$arrid = explode("~", $this->azdgcrypt->decrypt($id));
			$query = "SELECT ID FROM tr_produksi_dtl WHERE ID = ".$arrid[0]." AND STATUS = ".$this->db->escape($status);
			$result = $this->db->query($query);
			if($result->num_rows() > 0) {
				return true;
			}
			return false;
		} elseif ($table == "konversi") {
			$query = "SELECT ID FROM tm_konversi_hp WHERE ID = ".$this->azdgcrypt->decrypt($id);
			$result = $this->db->query($query);
			if($result->num_rows() > 0) {
				return true;
			}
			return false;
		} elseif ($table == "konversi_bb") {
			$arrid = explode("~", $this->azdgcrypt->decrypt($id));
			$query = "SELECT ID FROM tm_konversi_bb WHERE ID = ".$arrid[0]." AND ID_HDR = ".$arrid[1];
			$result = $this->db->query($query);
			if($result->num_rows() > 0) {
				return true;
			}
			return false;
		} elseif ($table == "barang_inout") {
			$query = "SELECT ID_BRG FROM tr_inout 
					  WHERE KODE_TRADER = ".$this->session->userdata('KODE_TRADER')." 
					  AND ".$status." = ".$this->azdgcrypt->decrypt($id)." 
					  GROUP BY ".$status."";
			$result = $this->db->query($query);
			if($result->num_rows() > 0) {
				return true;
			}
			return false;
		} elseif ($table == "partner") {
			$query = "SELECT partner_id FROM tpb_hdr 
					  WHERE KODE_TRADER = ".$this->session->userdata('KODE_TRADER')." 
					  AND ".$status." = ".$this->azdgcrypt->decrypt($id)." 
					  GROUP BY ".$status."";
			$result = $this->db->query($query);
			if($result->num_rows() > 0) {
				return true;
			}
			return false;
		}
	}

	private function insert_logbook($tipe, $first_id, $items) {
		$kode_trader = $this->session->userdata('KODE_TRADER');
		if (strtolower($tipe) == "in") {
			$count = count($items);
			for ($i=0; $i < $count; $i++) { 
				if ($i == 0) {
					$last_id = $first_id;
				} else {
					$last_id = $first_id + 1;
				}
				$log[$i]['jml_satuan'] = $items[$i]['jml_satuan'];
				$log[$i]['unit_price'] = $items[$i]['unit_price'];
				$log[$i]['saldo'] = $items[$i]['saldo'];
				$log[$i]['inout_id'] = $last_id;
			}
			$result = $this->db->insert_batch("tr_logbook_in", $log);
		} elseif (strtolower($tipe) == "out") {
			$count = count($items);
			for ($i=0; $i < $count; $i++) { 
				if ($i == 0) {
					$last_id = $first_id;
				} else {
					$last_id = $first_id + 1;
				}

				$sql = "SELECT a.id, a.jml_satuan, a.saldo FROM tr_logbook_in a
						LEFT JOIN tr_inout b on b.id = a.inout_id
						LEFT JOIN tm_barang c on c.id = b.id_brg 
						WHERE c.kode_trader = ".$this->db->escape($kode_trader)."
						AND 
						AND c.
    								AND JNS_BARANG = '".$DETIL["JNS_BARANG"]."' AND KODE_TRADER = '".$KODE_TRADER."'
    								AND (FLAG_TUTUP IS NULL OR FLAG_TUTUP = '') ORDER BY TGL_DOK ASC";
				
			}
		}
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
}