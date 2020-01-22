<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_home extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	// function signin($uid_, $pwd_){
	// 	$query="SELECT a.id, a.username, a.nama, a.alamat, a.telepon, a.email, a.status, a.user_role, b.uraian, a.password
	// 			FROM tm_user a 
	// 				LEFT JOIN tm_role b ON a.user_role = b.kode_role
	// 			WHERE a.username = ".$this->db->escape($uid_);
	// 	$data = $this->db->query($query);
	// 	if($data->num_rows() > 0) {
	// 		$hash = $data->row();
	// 		if(password_verify($pwd_, $hash->password)) {
	// 			if($hash->status == '0') {
	// 				return 3;
	// 			} else {
	// 				foreach($data->result_array() as $row){
	// 					$datses['LOGGED'] = true;
	// 					$datses['IP'] = $_SERVER['REMOTE_ADDR'];
	// 					$datses['ID'] = $row['id'];
	// 					$datses['USERNAME'] = $row['username'];
	// 					$datses['NAMA'] = $row['nama'];
	// 					$datses['ALAMAT'] = $row['alamat'];
	// 					$datses['TELEPON'] = $row['telepon'];
	// 					$datses['EMAIL'] = $row['email'];
	// 					$datses['STATUS'] = $row['status'];
	// 					$datses['USER_ROLE'] = $row['user_role'];
	// 					$datses['URAIAN_ROLE'] = $row['uraian'];
	// 					$datses['PASSWORD'] = $pwd_;
	// 				}
	// 				date_default_timezone_set('Asia/Jakarta');
	// 				$this->session->set_userdata($datses);
	// 				return 1;
	// 			}
	// 		} else {
	// 			return 2;
	// 		}
	// 	}else{
	// 		return 0;
	// 	}
	// }

	function signin($uid_, $pwd_){
		$query="SELECT a.id, a.nama, a.alamat, a.telepon, a.email, a.status, a.user_role, b.uraian, a.password, a.kode_trader, c.tipe_dokumen,
				c.nama as nama_perusahaan, c.fasilitas_perusahaan as fas_pabean, a.status as status_perusahaan, c.format_currency, c.format_qty, c.show_aju
				FROM tm_user a 
					LEFT JOIN tm_role b ON a.user_role = b.kode_role
					LEFT JOIN tm_perusahaan c ON c.kode_trader = a.kode_trader
				WHERE a.email = ".$this->db->escape($uid_);
		$data = $this->db->query($query);
		if($data->num_rows() > 0) {
			$hash = $data->row();
			if(password_verify($pwd_, $hash->password)) {
				if ($hash->status == '0') {
					return 3;
				} elseif ($hash->status_perusahaan == '0') {
					return 4;
				} else {
					foreach($data->result_array() as $row){
						$datses['LOGGED'] = true;
						$datses['IP'] = $_SERVER['REMOTE_ADDR'];
						$datses['ID'] = $row['id'];
						$datses['NAMA'] = $row['nama'];
						$datses['ALAMAT'] = $row['alamat'];
						$datses['TELEPON'] = $row['telepon'];
						$datses['EMAIL'] = $row['email'];
						$datses['STATUS'] = $row['status'];
						$datses['USER_ROLE'] = $row['user_role'];
						$datses['URAIAN_ROLE'] = $row['uraian'];
						$datses['KODE_TRADER'] = $row['kode_trader'];
						$datses['NAMA_TRADER'] = $row['nama_perusahaan'];
						$datses['FAS_PABEAN'] = $row['fas_pabean'];
						$datses['FORMAT_CURRENCY'] = $row['format_currency'];
						$datses['FORMAT_QTY'] = $row['format_qty'];
						$datses['TIPE_DOKUMEN'] = $row['tipe_dokumen'];
						$datses['SHOW_AJU'] = $row['show_aju'];
						$datses['PASSWORD'] = $pwd_;
					}
					date_default_timezone_set('Asia/Jakarta');
					$this->session->set_userdata($datses);
					return 1;
				}
			} else {
				return 2;
			}
		}else{
			return 0;
		}
	}

	function get_data($type) {
		if($type == "kode_id") {
			$query = "SELECT REFF_CODE, REFF_DESCRIPTION from reff_table WHERE REFF_TYPE = 'KODE_ID'";
			$return = $this->db->query($query)->result_array();
		} elseif($type == "jenis_eksportir") {
			$query = "SELECT REFF_CODE, REFF_DESCRIPTION from reff_table WHERE REFF_TYPE = 'JENIS_EKSPORTIR'";
			$return = $this->db->query($query)->result_array();
		}
		return $return;
	}

	function registration($data) {
		$query = "SELECT NPWP FROM tm_perusahaan WHERE NPWP = ".$this->db->escape($data['npwp'])." OR EMAIL = ".$this->db->escape($data['email']);
		$exec = $this->db->query($query);
		if($exec->num_rows() > 0) {
			return 0;
		} else {
			$this->db->insert('tm_perusahaan',$data);
			return 1;
		}
	}
}