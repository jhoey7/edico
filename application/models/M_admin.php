<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_admin extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}

	function daftar($type, $ajax="") {
		$header = "Data Perusahaan";
		$header_content = "Menampilkan seluruh data perusahaan";
		$this->load->library('newtable');
		$SQL = "SELECT A.NAMA, A.ALAMAT, A.TELEPON, CONCAT(A.KODE_ID, ' - ',A.NPWP) AS NPWP, A.BIDANG_USAHA AS 'BIDANG USAHA', B.REFF_DESCRIPTION AS 'STATUS PERUSAHAAN', 
				CASE A.FASILITAS_PERUSAHAAN
					WHEN '1' THEN 'KAWASAN BERKAT'
					WHEN '3' THEN 'KITE'
				END AS 'FASILITAS PERUSAHAAN', A.CREATED_TIME AS 'TANGGAL REGISTRASI', A.KODE_TRADER, A.STATUS 
				FROM reff_table B LEFT JOIN tm_perusahaan A ON B.REFF_CODE = A.STATUS_USAHA AND B.REFF_TYPE = 'JENIS_EKSPORTIR'";
		if ($type == "new") {
			$SQL .= " WHERE A.STATUS = '0'";
			$proses = array(
				'PREVIEW'  	=> array('GET',site_url()."/admin/preview", '1','','glyphicon glyphicon-zoom-in'),
				'APPROVE' 	=> array('POST',"execute/process/save/company", '1','0','glyphicon glyphicon-check'),
				'REJECT' 	=> array('GET',site_url()."/coarri/discharge/detail", '1','','glyphicon glyphicon-remove-circle')
			);
			$this->newtable->show_chk(true);
		} elseif ($type == "approve") {
			$SQL .= " WHERE A.STATUS = '1'";
			$this->newtable->show_chk(false);
		}
		$this->newtable->multiple_search(false);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NAMA','NAMA PERUSAHAAN'),array('A.NPWP','NPWP PERUSAHAAN')));
		$this->newtable->action(site_url() . "/admin/company/".$type);
		$this->newtable->tipe_proses('button');
		$this->newtable->validasi(array('STATUS'));
		$this->newtable->hiddens(array('KODE_TRADER','STATUS'));
		$this->newtable->keys(array("KODE_TRADER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.KODE_TRADER");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblcompany");
		$this->newtable->set_divid("divtblcompany");
		$this->newtable->rowcount(15);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$ajax == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function get_data($id) {
		$id = $this->azdgcrypt->decrypt($id);
		$query = "SELECT A.NAMA, A.ALAMAT, A.TELEPON, A.KODE_ID, A.NPWP, A.BIDANG_USAHA, B.REFF_DESCRIPTION AS STATUS_USAHA, CASE A.FASILITAS_PERUSAHAAN WHEN '1' THEN 'KAWASAN BERIKAT' END AS FASILITAS_PERUSAHAAN, A.NAMA_PEMILIK, A.ALAMAT_PEMILIK, A.TELP_PEMILIK, A.EMAIL, A.JABATAN FROM reff_table B LEFT JOIN tm_perusahaan A ON A.STATUS_USAHA = B.REFF_CODE AND B.REFF_TYPE = 'JENIS_EKSPORTIR' WHERE A.KODE_TRADER = ".$id;
		$return = $this->db->query($query)->row_array();
		return $return;
	}
}