<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_pemusnahan extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}

	function pemusnahan($aColumns, $sWhere, $sOrder, $sLimit) {
		$query = $this->db->query("
			SELECT a.no_surat, DATE_FORMAT(a.tgl_surat, '%d %b %Y') as tgl_surat, a.kd_kantor_tujuan, a.perihal, a.nm_pemohon, 
			a.id_pemohon, a.no_surat_tugas, a.id
			FROM tr_pemusnahan_hdr a  
			$sWhere
			$sOrder
			$sLimit
		");
		return $query;
	}

	function total_pemusnahan($sIndexColumn, $sWhere, $sOrder){
		$query = $this->db->query("
			SELECT $sIndexColumn
			FROM tr_pemusnahan_hdr a  
			$sWhere
			$sOrder
		");
		return $query;
	}

	function execute($type) {
		$func = get_instance();
		$func->load->model("m_main","main");
		$action = $this->input->post('action');
		$return = array("status"=>"error","message"=>"Simpan data surat Gagal");
		if(strtolower($action)=="save" || strtolower($action)=="update"){
			foreach($this->input->post('data') as $a => $b){
				$HEADER[$a] = $b;
			}
			if(strtolower($action)=="save") {
				$query = "SELECT NO_SURAT FROM tr_pemusnahan_hdr WHERE NO_SURAT = ".$this->db->escape($HEADER['no_surat'])." AND TGL_SURAT = ".$this->db->escape($HEADER['tgl_surat']);
				$result = $this->db->query($query);
				if($result->num_rows() > 0 ) {
					$return = array("status"=>"error","message"=>"Nomor & Tanggal Surat Sudah Pernah Digunakan.");
				} else {
					$exec = $this->db->insert('tr_pemusnahan_hdr', $HEADER);
					if($exec) {
						$ID = $this->db->insert_id();
						$data['HDR_ID'] = $ID;
						$INOUT['TIPE'] = 'MUSNAH';
						$INOUT['SERI_DOK'] = $ID;
						$INOUT['NO_DOK_INTERNAL'] = $HEADER['no_surat'];
						$INOUT['TGL_DOK_INTERNAL'] = $HEADER['tgl_surat'];
						$arrdetil = $this->input->post('DETIL');
						$arrkeys = array_keys($arrdetil);
						for($i=0;$i<count($arrdetil[$arrkeys[0]]);$i++) {
							$seri = (int)$func->main->get_uraian("SELECT MAX(DTL_ID) AS ID FROM tr_pemusnahan_dtl WHERE HDR_ID = ".$ID, "ID") + 1;
							$data['DTL_ID'] = $seri;
							for($j=0;$j<count($arrkeys);$j++) {
								$data[$arrkeys[$j]] = $arrdetil[$arrkeys[$j]][$i];
							}
							$INOUT['KD_BARANG'] = $data['KD_BARANG'];
							$INOUT['JNS_BARANG'] = $data['JNS_BARANG'];
							$INOUT['KD_SATUAN'] = $data['KD_SATUAN'];
							$INOUT['JML_SATUAN'] = $data['JML_SATUAN'];
							$INOUT['TGL_REALISASI'] =  $HEADER['tgl_surat'];
							$INOUT['NO_PROSES'] =  $HEADER['no_surat'];
							$this->db->insert("tr_inout", $INOUT);
							$this->db->insert('tr_pemusnahan_dtl', $data);
						}
						$return = array("status"=>"success","message"=>"Simpan Data Pemusnahan Berhasil.","titlte"=>"Success !!!","url"=>site_url('pemusnahan/daftar'));
					}
				}	
			}
		}
		return json_encode($return);
	}

	function get_data($type, $id) {
		if($type == "header") {
			$query = "SELECT NO_SURAT, DATE_FORMAT(TGL_SURAT, '%d %M %Y') as TGL_SURAT, PERIHAL, KD_KANTOR_TUJUAN, NM_PEMOHON, ID_PEMOHON, NO_SURAT_TUGAS, TELEPON, EMAIL
					  FROM tr_pemusnahan_hdr WHERE ID = ".$id;
			$result = $this->db->query($query)->row_array();
		} elseif($type == "detil") {
			$query = "SELECT a.KD_BARANG, b.URAIAN AS JNS_BARANG, a.KD_SATUAN, a.KONDISI, A.JML_SATUAN, C.NM_BRG
					  FROM tr_pemusnahan_dtl a INNER JOIN reff_jns_barang b ON a.JNS_BARANG = b.KD_JNS 
					  INNER JOIN tm_barang c ON a.KD_BARANG = c.KD_BRG AND a.JNS_BARANG = c.JNS_BRG
					  WHERE a.HDR_ID = ".$id;
			$result = $this->db->query($query)->result_array();
		}
		return $result;
	}
}