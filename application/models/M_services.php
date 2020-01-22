<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_services extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}

	public function execute($type, $act) {
		$user_id = "6";
		$qry = "SELECT a.tipe_file, a.kode_dokumen, a.nomor_aju, a.nomor_daftar, a.tanggal_daftar, a.nomor_dok_internal, a.tanggal_dok_internal, a.id_vendor, a.nama_vendor, a.id_customer, a.nama_customer, a.kode_valuta, a.kurs, a.source_dokumen, a.kode_trader, a.created_by, b.id as id_dtl, b.seri_barang, b.kode_barang, b.jenis_barang, b.uraian_barang, b.kode_satuan, b.jumlah_satuan, b.harga_barang, b.kode_gudang, b.nomor_bl, b.kode_hs, b.kondisi_barang, b.kode_negara, b.id_header, b.asal_barang FROM t_temp_services_hdr a LEFT JOIN t_temp_services_dtl b ON a.id = b.id_header WHERE a.use_flag = 'N' AND b.use_flag = 'N'";
		$rslt = $this->db->query($qry);
		if ($rslt->num_rows() > 0) {
			$arrData = array();
			$arraytemp = array();
			$arraytemp_jumlah = array();

			foreach ($rslt->result_array() as $value) {
				if (strtoupper($value['tipe_file']) === "IN" || strtoupper($value['tipe_file']) === "OUT") {

					$arrbrg['kd_brg'] = $value['kode_barang'];
					$arrbrg['jns_brg'] = $value['jenis_barang'];
					$arrbrg['nm_brg'] = $value['uraian_barang'];
					$arrbrg['kd_hs'] = $value['kode_hs'];
					$arrbrg['kd_satuan'] = $value['kode_satuan'];
					$arrbrg['kd_gudang'] = $value['kode_gudang'];
					$arrbrg['kode_trader'] = $value['kode_trader'];
					$arrbrg['jml_satuan'] = $value['jumlah_satuan'];

					$databarang = $this->get_data_barang($arrbrg);
					$supplier_id = $this->get_id_supplier($value['id_vendor'], $value['nama_vendor'], $value['kode_trader']);

					$saldo_kurang = false;
					if (strtoupper($value['tipe_file']) === "OUT") {
						$supplier_id = $this->get_id_supplier($value['id_customer'], $value['nama_customer'], $value['kode_trader']);

						$arraytemp[] = $databarang['id_barang'].'|#|'.$databarang['id_gudang'];
						$arraytemp_jumlah[$databarang['id_barang'].'|#|'.$databarang['id_gudang']]["jumlah"][] = $databarang['jml_satuan'];
						
						$jmlakhir = array_sum($arraytemp_jumlah[$databarang['id_barang']."|#|".$databarang['id_gudang']]["jumlah"]);

						if ($jmlakhir > $databarang['saldo']) {
							$saldo_kurang = true;
						}
					}

					if ($databarang == "satuan tidak dikenali") {
						$this->db->set("msg_error","kode satuan tidak dikenali, periksa kembali kode satuan barangnya di Inventory->Data Barang");
						$this->db->where(array("id"=>$value['id_dtl']));
						$this->db->update("t_temp_services_dtl");
						continue;
					} elseif ($saldo_kurang == true) {
						$this->db->set("msg_error","saldo barang kurang untuk di keluarkan, silahkan periksa saldo barang di Inventory->Data Barang");
						$this->db->where(array("id"=>$value['id_dtl']));
						$this->db->update("t_temp_services_dtl");
						continue;
					} else {
						$key = $value['nomor_dok_internal'];
						if (!in_array($key, $arrData[$key])) {
							$arrData[$key] = array(
								"tipe"=> "pabean",
								"jns_inout"=> $value['tipe_file'],
								"no_inout"=> $value['nomor_dok_internal'],
								"tgl_inout"=> $value['tanggal_dok_internal'],
								"source_dokumen"=> $value['source_dokumen'],
								"tgl_realisasi"=> $value['tanggal_dok_internal'],
								"jns_dokumen"=> $value['kode_dokumen'],
								"nomor_aju"=> $value['nomor_aju'],
								"no_daftar"=> $value['nomor_daftar'],
								"tgl_daftar"=> $value['tanggal_daftar'],
								"kd_valuta"=> $value['kode_valuta'],
								"ndpbm"=> $value["kurs"],
								"created_by"=> $value['created_by'],
								"partner_id"=> $supplier_id,
								"kode_trader"=> $value['kode_trader'],
								"id_header"=> $value['id_header'],
								"details"=> [array(
									"jml_inout"=> $databarang['jml_satuan'],
									"jml_satuan"=> $value['jumlah_satuan'],
									"kd_satuan"=> $value['kode_satuan'],
									"price"=> $value['harga_barang'],
									"asal_barang"=> $value['asal_barang'],
									"seri_barang"=> $value['seri_barang'],
									"kondisi_barang"=> $value['kondisi_barang'],
									"kd_negara_asal"=> $value['kode_negara'],
									"id_barang"=> $databarang['id_barang'],
									"id_gudang"=> $databarang['id_gudang'],
									"id_dtl"=> $value['id_dtl']
								)]
							);
						} else { 
							array_push($arrData[$key]['details'], array(
								"jml_inout"=> $databarang['jml_satuan'],
								"jml_satuan"=> $value['jumlah_satuan'],
								"kd_satuan"=> $value['kode_satuan'],
								"price"=> $value['harga_barang'],
								"asal_barang"=> $value['asal_barang'],
								"seri_barang"=> $value['seri_barang'],
								"kondisi_barang"=> $value['kondisi_barang'],
								"kd_negara_asal"=> $value['kode_negara'],
								"id_barang"=> $databarang['id_barang'],
								"id_gudang"=> $databarang['id_gudang'],
								"id_dtl"=> $value['id_dtl']
							));
						}
					}
				} elseif (in_array(strtoupper($value['tipe_file']), array("FG","RM","HALF","SCRAP"))) {

					$arrbrg['kd_brg'] = $value['kode_barang'];
					$arrbrg['jns_brg'] = $value['jenis_barang'];
					$arrbrg['nm_brg'] = $value['uraian_barang'];
					$arrbrg['kd_hs'] = $value['kode_hs'];
					$arrbrg['kd_satuan'] = $value['kode_satuan'];
					$arrbrg['kd_gudang'] = $value['kode_gudang'];
					$arrbrg['kode_trader'] = $value['kode_trader'];
					$arrbrg['jml_satuan'] = $value['jumlah_satuan'];

					$databarang = $this->get_data_barang($arrbrg);

					$saldo_kurang = false;
					if (strtoupper($value['tipe_file']) === "RM") {

						$arraytemp[] = $databarang['id_barang'].'|#|'.$databarang['id_gudang'];
						$arraytemp_jumlah[$databarang['id_barang'].'|#|'.$databarang['id_gudang']]["jumlah"][] = $databarang['jml_satuan'];
						
						$jmlakhir = array_sum($arraytemp_jumlah[$databarang['id_barang']."|#|".$databarang['id_gudang']]["jumlah"]);

						if ($jmlakhir > $databarang['saldo']) {
							$saldo_kurang = true;
						}
					}

					if ($databarang == "satuan tidak dikenali") {
						$this->db->set("msg_error","kode satuan tidak dikenali, periksa kembali kode satuan barangnya di Inventory->Data Barang");
						$this->db->where(array("id"=>$value['id_dtl']));
						$this->db->update("t_temp_services_dtl");
						continue;
					} elseif ($saldo_kurang == true) {
						$this->db->set("msg_error","saldo barang kurang untuk di keluarkan, silahkan periksa saldo barang di Inventory->Data Barang");
						$this->db->where(array("id"=>$value['id_dtl']));
						$this->db->update("t_temp_services_dtl");
						continue;
					} else {
						$key = $value['nomor_dok_internal'];
						if (!in_array($key, $arrData[$key])) {
							$arrData[$key] = array(
								"tipe"=> "produksi",
								"jns_inout"=> $value['tipe_file'],
								"no_inout"=> $value['nomor_dok_internal'],
								"tgl_inout"=> $value['tanggal_dok_internal'],
								"tgl_realisasi"=> $value['tanggal_dok_internal'],
								"created_by"=> $value['created_by'],
								"kode_trader"=> $value['kode_trader'],
								"id_header"=> $value['id_header'],
								"details"=> [array(
									"jml_inout"=> $databarang['jml_satuan'],
									"jml_satuan"=> $value['jumlah_satuan'],
									"kd_satuan"=> $value['kode_satuan'],
									"id_barang"=> $databarang['id_barang'],
									"id_gudang"=> $databarang['id_gudang'],
									"id_dtl"=> $value['id_dtl']
								)]
							);
						} else { 
							array_push($arrData[$key]['details'], array(
								"jml_inout"=> $databarang['jml_satuan'],
								"jml_satuan"=> $value['jumlah_satuan'],
								"kd_satuan"=> $value['kode_satuan'],
								"id_barang"=> $databarang['id_barang'],
								"id_gudang"=> $databarang['id_gudang'],
								"id_dtl"=> $value['id_dtl']
							));
						}
					}
				}
			}

			if (count($arrData) > 0) {
				$this->proses_realisasi($arrData);
			}
		}
	}

	private function proses_realisasi($arrData) {
		foreach ($arrData as $val) {
			if ($val['tipe'] == "pabean") {
				$tgl_inout = date_format(date_create($val['tgl_inout']),"Ymd");

				$qry = "SELECT id, status, nomor_dok_internal FROM tpb_hdr WHERE kode_trader = ".$this->db->escape($val['kode_trader'])." AND no_inout = ".$this->db->escape($val['no_inout'])." AND DATE_FORMAT(tgl_inout,'%Y%m%d') = ".$this->db->escape($tgl_inout);
				$rslt = $this->db->query($qry);
				if ($rslt->num_rows() > 0) {
					$data = $rslt->row();
					$id_header = $data->id;
					$status = $data->status;
					$nomor_dok_internal = $data->nomor_dok_internal;

					foreach ($val['details'] as $valDtl) {
						$qry = "SELECT seri_barang FROM t_temp_services_dtl WHERE id_header = ".$this->db->escape($id_header)." AND seri_barang = ".$this->db->escape($valDtl['seri_barang']);
						$rslt = $this->db->query($qry);
						if($rslt->num_rows() == 0) {
							$dtl['jml_satuan'] = $valDtl['jml_satuan'];
							$dtl['kd_satuan'] = $valDtl['kd_satuan'];
							$dtl['unit_price'] = $valDtl['price'] / $valDtl['jml_satuan'];
							$dtl['price'] = $valDtl['price'];
							$dtl['asal_barang'] = $valDtl['asal_barang'];
							$dtl['seri_barang'] = $valDtl['seri_barang'];
							$dtl['kondisi_barang'] = $valDtl['kondisi_barang'];
							$dtl['kd_negara_asal'] = $valDtl['kd_negara_asal'];
							$dtl['created_by'] = $val['created_by'];
							$dtl['id_barang'] = $valDtl['id_barang'];
							$dtl['id_warehouse'] = $valDtl['id_gudang'];
							$dtl['id_hdr'] = $id_header;
							$dtl['status'] = ($status == "R") ? "04" : "00";
							$this->db->insert("tpb_dtl", $dtl);
							$id_detail = $this->db->insert_id();

							if ($status == "R") {
								$inout['tipe'] = "GATE-IN";
								if ($val['jns_inout'] == "OUT") $inout['tipe'] = "GATE-OUT";

								$inout['jml_satuan'] = $valDtl['jml_inout'];
								$inout['tgl_realisasi'] = $val['tgl_realisasi'];
								$inout['created_by'] = $val['created_by'];
								$inout['id_hdr'] = $id_header;
								$inout['id_dtl'] = $id_detail;
								$inout['id_brg'] = $valDtl['id_barang'];
								$inout['id_gudang'] = $valDtl['id_gudang'];
								$inout['kode_trader'] = $val['kode_trader'];
								$this->db->insert("tr_inout", $inout);
							}

							$this->db->where(array("id"=>$valDtl['id_dtl']));
							$this->db->update("t_temp_services_dtl", array("use_flag"=>"Y"));
						} else {
							$this->db->where(array("id"=>$valDtl['id_dtl']));
							$this->db->update("t_temp_services_dtl", array("use_flag"=>"E","msg_error"=>"Nomor Dok Internal :".$nomor_dok_internal." dengan Seri Barang :".$valDtl['seri_barang']." sudah ada."));
						}
					}

					$qry = $this->db->get_where('t_temp_services_dtl', array('id_header' => $val['id_header'], 'use_flag' => "N"));
	  				$rslt = $qry->result_array();
	  				if (count($rslt) == 0) {
	  					$this->db->where(array("id"=>$val['id_header']));
						$this->db->update("t_temp_services_hdr", array("use_flag"=>"Y"));
	  				}
				} else {
					$hdr['tgl_realisasi'] = $val['tgl_realisasi'];
					$hdr['jns_inout'] = $val['jns_inout'];
					$hdr['no_inout'] = $val['no_inout'];
					$hdr['tgl_inout'] = $val['tgl_inout'];
					$hdr['source_dokumen'] = $val['source_dokumen'];
					$hdr['tgl_realisasi'] = $val['tgl_realisasi'];
					$hdr['jns_dokumen'] = $val['jns_dokumen'];
					$hdr['nomor_aju'] = $val['nomor_aju'];
					$hdr['no_daftar'] = $val['no_daftar'];
					$hdr['tgl_daftar'] = $val['tgl_daftar'];
					$hdr['kd_valuta'] = $val['kd_valuta'];
					$hdr['ndpbm'] = $val['ndpbm'];
					$hdr['no_inout'] = $val['no_inout'];
					$hdr['status'] = "R";
					$hdr['created_by'] = $val['created_by'];
					$hdr['partner_id'] = $val['partner_id'];
					$hdr['kode_trader'] = $val['kode_trader'];
					
					if ($val['no_inout'] == "" || $val['tgl_inout'] == "") {
						$hdr['status'] = "D";
						unset($hdr['tgl_realisasi']);
					}
					$this->db->insert("tpb_hdr", $hdr);
					$id_header = $this->db->insert_id();

					foreach ($val['details'] as $valDtl) {
						$dtl['jml_satuan'] = $valDtl['jml_satuan'];
						$dtl['kd_satuan'] = $valDtl['kd_satuan'];
						$dtl['unit_price'] = $valDtl['price'] / $valDtl['jml_satuan'];
						$dtl['price'] = $valDtl['price'];
						$dtl['asal_barang'] = $valDtl['asal_barang'];
						$dtl['seri_barang'] = $valDtl['seri_barang'];
						$dtl['kondisi_barang'] = $valDtl['kondisi_barang'];
						$dtl['kd_negara_asal'] = $valDtl['kd_negara_asal'];
						$dtl['created_by'] = $hdr['created_by'];
						$dtl['id_barang'] = $valDtl['id_barang'];
						$dtl['id_warehouse'] = $valDtl['id_gudang'];
						$dtl['id_hdr'] = $id_header;
						$dtl['status'] = ($hdr['status'] == "R") ? "04" : "00";
						$this->db->insert("tpb_dtl", $dtl);
						$id_detail = $this->db->insert_id();

						if ($hdr['status'] == "R") {
							$inout['tipe'] = "GATE-IN";
							if ($hdr['jns_inout'] == "OUT") $inout['tipe'] = "GATE-OUT";

							$inout['jml_satuan'] = $valDtl['jml_inout'];
							$inout['tgl_realisasi'] = $hdr['tgl_realisasi'];
							$inout['created_by'] = $hdr['created_by'];
							$inout['id_hdr'] = $id_header;
							$inout['id_dtl'] = $id_detail;
							$inout['id_brg'] = $valDtl['id_barang'];
							$inout['id_gudang'] = $valDtl['id_gudang'];
							$inout['kode_trader'] = $hdr['kode_trader'];
							$this->db->insert("tr_inout", $inout);
						}

						$this->db->where(array("id"=>$valDtl['id_dtl']));
						$this->db->update("t_temp_services_dtl", array("use_flag"=>"Y"));
					}
				}

				$qry = $this->db->get_where('t_temp_services_dtl', array('id_header' => $val['id_header'], 'use_flag' => "N"));
  				$rslt = $qry->result_array();
  				if (count($rslt) == 0) {
  					$this->db->where(array("id"=>$val['id_header']));
					$this->db->update("t_temp_services_hdr", array("use_flag"=>"Y"));
  				}
			} elseif ($val['tipe'] == "produksi") {
				$tgl_inout = date_format(date_create($val['tgl_inout']),"Ymd");

				$qry = "SELECT id FROM tr_produksi_hdr WHERE kode_trader = ".$this->db->escape($val['kode_trader'])." AND no_bukti_inout = ".$this->db->escape($val['no_inout'])." AND DATE_FORMAT(tgl_bukti_inout, '%Y%m%d') = ".$this->db->escape($tgl_inout);
				$rslt = $this->db->query($qry);
				if($rslt->num_rows() > 0) {
					$data = $rslt->row();
					$id_header = $data->id;

					foreach ($val['details'] as $valDtl) {
						$dtl['jml_satuan'] = $valDtl['jml_satuan'];
						$dtl['kd_satuan'] = $valDtl['kd_satuan'];
						$dtl['id_barang'] = $valDtl['id_barang'];
						$dtl['id_gudang'] = $valDtl['id_gudang'];
						$dtl['status'] = '04';
						$dtl['id_hdr'] = $id_header;
						$this->db->insert('tr_produksi_dtl', $dtl);
						$id_detail = $this->db->insert_id();

						if ($val['jns_inout'] == "FG") {
							$inout['tipe'] = 'PROCESS_OUT';
						} elseif ($val['jns_inout'] == "RM") {
							$inout['tipe'] = 'PROCESS_IN';
						} else {
							$inout['tipe'] = strtoupper($val['jns_inout']);
						}
						$inout['jml_satuan'] = $valDtl['jml_inout'];
						$inout['tgl_realisasi'] = $valDtl['tgl_realisasi'];
						$inout['created_by'] = $val['created_by'];
						$inout['id_brg'] = $valDtl['id_barang'];
						$inout['id_gudang'] = $valDtl['id_gudang'];
						$inout['id_produksi_hdr'] = $id_header;
						$inout['id_produksi_dtl'] = $id_detail;
						$inout['kode_trader'] = $val['kode_trader'];
						$this->db->insert('tr_inout', $inout);

						$this->db->where(array("id"=>$valDtl['id_dtl']));
						$this->db->update("t_temp_services_dtl", array("use_flag"=>"Y"));
					}
				} else {
					$hdr['no_bukti_inout'] = $val['no_inout'];
					$hdr['tgl_bukti_inout'] = $val['tgl_inout'];
					$hdr['status'] = "R";
					$hdr['jenis_produksi'] = $val['jns_inout'];
					$hdr['created_by'] = $val['created_by'];
					$hdr['kode_trader'] = $val['kode_trader'];
					$this->db->insert('tr_produksi_hdr', $hdr);
					$id_header = $this->db->insert_id();

					foreach ($val['details'] as $valDtl) {
						$dtl['jml_satuan'] = $valDtl['jml_satuan'];
						$dtl['kd_satuan'] = $valDtl['kd_satuan'];
						$dtl['id_barang'] = $valDtl['id_barang'];
						$dtl['id_gudang'] = $valDtl['id_gudang'];
						$dtl['status'] = '04';
						$dtl['id_hdr'] = $id_header;
						$this->db->insert('tr_produksi_dtl', $dtl);
						$id_detail = $this->db->insert_id();

						if ($val['jns_inout'] == "FG") {
							$inout['tipe'] = 'PROCESS_OUT';
						} elseif ($val['jns_inout'] == "RM") {
							$inout['tipe'] = 'PROCESS_IN';
						} else {
							$inout['tipe'] = strtoupper($val['jns_inout']);
						}
						$inout['jml_satuan'] = $valDtl['jml_inout'];
						$inout['tgl_realisasi'] = $valDtl['tgl_realisasi'];
						$inout['created_by'] = $val['created_by'];
						$inout['id_brg'] = $valDtl['id_barang'];
						$inout['id_gudang'] = $valDtl['id_gudang'];
						$inout['id_produksi_hdr'] = $id_header;
						$inout['id_produksi_dtl'] = $id_detail;
						$inout['kode_trader'] = $val['kode_trader'];
						$this->db->insert('tr_inout', $inout);

						$this->db->where(array("id"=>$valDtl['id_dtl']));
						$this->db->update("t_temp_services_dtl", array("use_flag"=>"Y"));
					}
				}

				$qry = $this->db->get_where('t_temp_services_dtl', array('id_header' => $val['id_header'], 'use_flag' => "N"));
  				$rslt = $qry->result_array();
  				if (count($rslt) == 0) {
  					$this->db->where(array("id"=>$val['id_header']));
					$this->db->update("t_temp_services_hdr", array("use_flag"=>"Y"));
  				}
			}
		}
	}

	private function get_id_supplier($id, $nama, $kode_trader) {
		if ($id) {
			$qry = "SELECT kd_supplier FROM reff_supplier WHERE kode_trader = ".$this->db->escape($kode_trader)." AND npwp_supplier LIKE '%".$id."%'";
			$rslt = $this->db->query($qry);
			if ($rslt->num_rows() > 0) {
				$data = $rslt->row();
				return $data->kd_supplier;
			} else {
				$this->db->insert('reff_supplier', array(
					"kode_trader" => $kode_trader,
					"npwp_supplier" => $id,
					"nm_supplier" => $nama
				));
				return $this->db->insert_id();
			}
		} else {
			$qry = "SELECT kd_supplier FROM reff_supplier WHERE kode_trader = ".$this->db->escape($kode_trader)." AND nm_supplier LIKE '%".$nama."%'";
			$rslt = $this->db->query($qry);
			if ($rslt->num_rows() > 0) {
				$data = $rslt->row();
				return $data->kd_supplier;
			} else {
				$npwp_supplier = sprintf("%06d", mt_rand(15, 50));
				$this->db->insert('reff_supplier', array(
					"kode_trader" => $kode_trader,
					"npwp_supplier" => $npwp_supplier,
					"nm_supplier" => $nama
				));
				return $this->db->insert_id();
			}
		}
	}

	private function get_data_barang($arrbrg) {
		$qry = "SELECT b.id_barang, b.id_gudang, b.saldo, a.kd_satuan, a.kd_satuan_terkecil, a.nilai_konversi 
				FROM tm_barang a 
				LEFT JOIN tm_barang_gudang b on a.id = b.id_barang 
				LEFT JOIN tm_warehouse c ON c.id = b.id_gudang 
				WHERE a.kode_trader = " . $this->db->escape($arrbrg['kode_trader']) . " 
				AND a.kd_brg = " . $this->db->escape($arrbrg['kd_brg']) . " 
				AND a.jns_brg = " . $this->db->escape($arrbrg['jns_brg']) . " 
				AND c.kode = " . $this->db->escape($arrbrg['kd_gudang']);

		$rslt = $this->db->query($qry);
		if ($rslt->num_rows() > 0) {
			$data = $rslt->row_array();
			if ($arrbrg['kd_satuan'] != $data['kd_satuan']) {
				if ($arrbrg['kd_satuan'] != $data['kd_satuan_terkecil']) {
					return "satuan tidak dikenali";
				} else {
					$return['jml_satuan'] = $arrbrg['jml_satuan'];
				}
			} else {
				$return['jml_satuan'] = $data['nilai_konversi'] * $arrbrg['jml_satuan'];
			}
			$return['id_barang'] = $data['id_barang'];
			$return['id_gudang'] = $data['id_gudang'];
			$return['saldo']  = $data['saldo'];
			return $return;
		} else {
			$qry = "SELECT id FROM tm_warehouse WHERE kode_trader = " . $this->db->escape($arrbrg['kode_trader']) . " AND kode = " . $this->db->escape($arrbrg['kd_gudang']);
			$rslt = $this->db->query($qry);
			if ($rslt->num_rows() > 0) {
				$gudang = $rslt->row();
				$id_gudang = $gudang->id;

				$qry = "SELECT id, kd_satuan, kd_satuan_terkecil, nilai_konversi FROM tm_barang WHERE kode_trader = ".$this->db->escape($arrbrg['kode_trader'])." AND kd_brg = ".$this->db->escape($arrbrg['kd_brg'])." AND jns_brg = ".$this->db->escape($arrbrg['jns_brg']);

				$rslt = $this->db->query($qry);
				if($rslt->num_rows() > 0) {
					$barang = $rslt->row();
					$id_barang = $barang->id;

					if ($arrbrg['kd_satuan'] != $barang->kd_satuan) {
						if ($arrbrg['kd_satuan'] != $barang->kd_satuan_terkecil) {
							return "satuan tidak dikenali";
						} else {
							$return['jml_satuan'] = $arrbrg['jml_satuan'];
						}
					} else {
						$return['jml_satuan'] = $barang->nilai_konversi * $arrbrg['jml_satuan'];
					}
				} else {
					$this->db->insert("tm_barang", array(
						"kd_brg"=> $arrbrg['kd_brg'],
						"jns_brg"=> $arrbrg['jns_brg'],
						"nm_brg"=> $arrbrg['nm_brg'],
						"nilai_konversi"=> 1,
						"kd_hs"=> $arrbrg['kd_hs'],
						"kd_satuan_terkecil"=> $arrbrg['kd_satuan'],
						"kd_satuan"=> $arrbrg['kd_satuan'],
						"kode_trader"=> $arrbrg['kode_trader']
					));
					$id_barang = $this->db->insert_id();
				
					$return['jml_satuan'] = $arrbrg['jml_satuan'];
				}
				
				$this->db->insert("tm_barang_gudang", array("id_barang"=>$id_barang, "id_gudang"=>$id_gudang));

				$return['id_barang'] = $id_barang;
				$return['id_gudang'] = $id_gudang;
				$return['saldo']  = 0;
				return $return;
			} else {
				$this->db->insert("tm_warehouse", array(
					"kode"=>$arrbrg['kd_gudang'], 
					"nama"=>$arrbrg['kd_gudang'],
					"uraian"=>"-",
					"kode_trader"=>$arrbrg['kode_trader']
				));
				$id_gudang = $this->db->insert_id();

				$qry = "SELECT id FROM tm_barang WHERE kode_trader = ".$this->db->escape($arrbrg['kode_trader'])." AND kd_brg = ".$this->db->escape($arrbrg['kd_brg'])." AND jns_brg = ".$this->db->escape($arrbrg['jns_brg']);

				$rslt = $this->db->query($qry);
				if($rslt->num_rows() > 0) {
					$barang = $rslt->row();
					$id_barang = $barang->id;

					if ($arrbrg['kd_satuan'] != $barang->kd_satuan) {
						if ($arrbrg['kd_satuan'] != $barang->kd_satuan_terkecil) {
							return "satuan tidak dikenali";
						} else {
							$return['jml_satuan'] = $arrbrg['jml_satuan'];
						}
					} else {
						$return['jml_satuan'] = $barang->nilai_konversi * $arrbrg['jml_satuan'];
					}
				} else {
					$this->db->insert("tm_barang", array(
						"kd_brg"=> $arrbrg['kd_brg'],
						"jns_brg"=> $arrbrg['jns_brg'],
						"nm_brg"=> $arrbrg['nm_brg'],
						"nilai_konversi"=> 1,
						"kd_hs"=> $arrbrg['kd_hs'],
						"kd_satuan_terkecil"=> $arrbrg['kd_satuan'],
						"kd_satuan"=> $arrbrg['kd_satuan'],
						"kode_trader"=> $arrbrg['kode_trader']
					));
					$id_barang = $this->db->insert_id();

					$return['jml_satuan'] = $arrbrg['jml_satuan'];
				}
				
				$this->db->insert("tm_barang_gudang", array("id_barang"=>$id_barang, "id_gudang"=>$id_gudang));
				
				$return['id_barang'] = $id_barang;
				$return['id_gudang'] = $id_gudang;
				$return['saldo']  = 0;
				return $return;
			}
		}
	}

}