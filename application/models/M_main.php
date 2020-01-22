<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_main extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	function get_uraian($query, $select){
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$row = $data->row();
			return $row->$select;
		}else{
			return "";
		}
		return 1;
	}
	
	function get_array($query,$key){
		$array_data = array();
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			foreach($data->result_array() as $row){
				$array_data[] = $row[$key];
			}
		}
		return $array_data;
	}
	
	function get_result(&$query){
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$query = $data;
		}else{
			return false;
		}
		return true;
	}
	
	function get_combobox(&$query, $key, $value, $empty = FALSE, &$disable = ""){
		$combobox = array();
		$data = $this->db->query($query);
		if($empty) $combobox[""] = "";
		if($data->num_rows() > 0){
			$kodedis = "";
			$arrdis = array();
			foreach($data->result_array() as $row){
				if(is_array($disable)){
					if($kodedis==$row[$disable[0]]){
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = str_replace("'", "\'", "&nbsp; &nbsp;&nbsp;".$row[$value]);
					}else{
						if(!array_key_exists($row[$disable[0]], $combobox)) $combobox[$row[$disable[0]]] = $row[$disable[1]];
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = str_replace("'", "\'", "&nbsp; &nbsp;&nbsp;".$row[$value]);
					}
					$kodedis = $row[$disable[0]];
					if(!in_array($kodedis, $arrdis)) $arrdis[] = $kodedis;
				}else{
					$combobox[$row[$key]] = str_replace("'", "\'", $row[$value]);
				}
			}
			$disable = $arrdis;
		}
		return $combobox;
	}
	
	function post_to_query($array, $except=""){
		$data = array();
		foreach($array as $a => $b){
			if(is_array($except)){
				if(!in_array($a, $except)) $data[$a] = $b;
			}else{
				$data[$a] = $b;
			}
		}
		return $data;
	}	
	
	function get_log($type,$table){
		$arrdata = array();
		switch($type){
			case "add"	  : 
				$string = "Berhasil <b>menambah</b> data pada tabel ".$table." dengan data sebagai berikut :";
				foreach($_POST as $data => $val){
					if(is_array($val)){
						foreach($val as $data2 => $val2){
							$arrdata[] = "<li>".$data2." = ".$val2."</li>";
						}
					}else{
						$arrdata[] = "<li>".$data." = ".$val."</li>";
					}
				}
			break;
			case "update" : 
				$string = "Berhasil <b>mengupdate</b> data pada tabel ".$table." dengan data sebagai berikut :";
				foreach($_POST as $data => $val){
					if(is_array($val)){
						foreach($val as $data2 => $val2){
							$arrdata[] = "<li>".$data2." = ".$val2."</li>";
						}
					}else{
						$arrdata[] = "<li>".$data." = ".$val."</li>";
					}
				}
			break;
			case "delete" : 
				$string = "Berhasil <b>menghapus</b> data pada tabel ".$table." dengan data sebagai berikut :";
				foreach($_POST as $data => $val){
					if(is_array($val)){
						foreach($val as $data2 => $val2){
							$arrdata[] = "<li> ID = ".$val2."</li>";
						}
					}else{
						$arrdata[] = "<li> ID = ".$val."</li>";
					}
				}
			break;
			case "realisasi" :

			break;
			case "read" : 
				$string = "Berhasil <b>membaca</b> data ".$table;
			break;
		}
		$data = array(
			"IP_ADDRESS" => $this->getIP(0),
			"ACTION"=>strtoupper($type),
			"REMARK" => $string."<ul>".implode($arrdata)."</ul>",
			"WK_REKAM" => date("Y-m-d H:i:s"),
			"USER_ID" => $this->session->userdata('ID'),
			"KODE_TRADER" => $this->session->userdata('KODE_TRADER')
		);
		$this->db->insert('tm_log_app',$data);
	}

	function ducplicate_array($array) {
		$dupe_array = array();
		foreach ($array as $val) {
			if (++$dupe_array[$val] > 1) {
				return true;
			}
		}
		return false;
	}

	function getIP($type){ 
		if (getenv("HTTP_CLIENT_IP") 
			&& strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
			$ip = getenv("HTTP_CLIENT_IP"); 
		else if (getenv("REMOTE_ADDR") 
			&& strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
			$ip = getenv("REMOTE_ADDR"); 
		else if (getenv("HTTP_X_FORWARDED_FOR") 
			&& strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
			$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if (isset($_SERVER['REMOTE_ADDR']) 
			&& $_SERVER['REMOTE_ADDR'] 
			&& strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
			$ip = $_SERVER['REMOTE_ADDR']; 
		else { 
			$ip = "unknown"; 
		return $ip; 
			} 
		if ($type==1) {return md5($ip);} 
		if ($type==0) {return $ip;}
   } 
}
?>