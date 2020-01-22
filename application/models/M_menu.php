<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_menu extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}

	function sidebar(){
		$SQL = "SELECT A.MENU_ID, A.MENU_TITTLE, A.MENU_PARENT_ID, A.MENU_ICON, A.MENU_URL, 
				A.MENU_TYPE, A.MENU_ACTIVE, A.MENU_HAVE_CHILD
				FROM tm_menu A 
				INNER JOIN tm_role_menu B ON B.MENU_ID = A.MENU_ID
				INNER JOIN tm_user C ON C.USER_ROLE = B.ROLE_ID
				WHERE C.ID = ".$this->session->userdata('ID')."
				AND A.MENU_SHOW = 'Y'
				AND A.MENU_FAS IN('ALL','".$this->session->userdata('FAS_PABEAN')."')
				ORDER BY A.MENU_PARENT_ID, A.MENU_ORDER ASC";
		$res = $this->db->query($SQL);
		if($res->num_rows() > 0){
			foreach ($res->result_array() as $row) {
				$parent_id = $row['MENU_PARENT_ID'];
				$data[$parent_id][] = array(
					'MENU_ID' 			=> $row['MENU_ID'],
					'MENU_TITLE' 		=> $row['MENU_TITTLE'],
					'MENU_PARENT_ID' 	=> $row['MENU_PARENT_ID'],
					'MENU_ICON' 		=> $row['MENU_ICON'],
					'MENU_URL' 			=> $row['MENU_URL'],
					'MENU_ACTIVE' 		=> $row['MENU_ACTIVE'],
					'MENU_HAVE_CHILD'	=> $row['MENU_HAVE_CHILD']
				);
			}
		}
		return $data;
	}

	function drawMenu(){
		$data = $this->sidebar();
		return $this->drawMenuContent($data);
	}

	function drawMenuContent($data, $parent = 0, $inc = 0) {
		static $i = 1; 
		$segs = "";
		$segs_1 = $this->uri->segment(1);
		$segs_2 = $this->uri->segment(2);
		if($segs_2!="") $segs = trim($segs_1."/".$segs_2);
		elseif($segs_1!="") $segs = trim($segs_1);
		if(array_key_exists($parent,$data)){
			if ($data[$parent]) {
				$i++;
				$html = "";
				$arrayKeys = array();
				for($c=0;$c<count($data[$parent]);$c++){ 
					$this->db->where('MENU_PARENT_ID', $data[$parent][$c]["MENU_ID"]);
					$this->db->from('tm_menu');
					$count = $this->db->count_all_results();
					$child = $this->drawMenuContent($data, $data[$parent][$c]["MENU_ID"]);
					$href = site_url()."/".$data[$parent][$c]["MENU_URL"];

					if($data[$parent][$c]["MENU_PARENT_ID"] == 0) {
						if($this->uri->segment(1) == $data[$parent][$c]["MENU_ACTIVE"]) {
							if($data[$parent][$c]["MENU_HAVE_CHILD"] == "Y") {
								$html .= '<li class="nav-parent nav-active active">';
								$link = 'href="#"';
							} else {
								$html .= '<li class="active">';
								$link = 'href="'.$href.'"';
							}
						} else {
							if($data[$parent][$c]["MENU_HAVE_CHILD"] == "Y") {
								$html .= '<li class="nav-parent">';
								$link = 'href="#"';
							} else {
								$html .= '<li>';
								$link = 'href="'.$href.'"';
							}
						}
						$html .= '<a '.$link.'><i class="fa fa-'.$data[$parent][$c]["MENU_ICON"].'"></i> <span>'.$data[$parent][$c]["MENU_TITLE"].'</span></a>';
					} else {
						$ID = $this->get_active('ID',$segs);
						if($ID == $data[$parent][$c]["MENU_ID"]){
							$child_class = "class=\"active\"";
						} else {
							$child_class = "";
						}
						$arrayKeys = array_keys($data[$parent]);
						if($arrayKeys[$c] == 0) {
							$html .= '<ul class="children">';
						}
						$html .= '<li '.$child_class.'><a href="'.$href.'"><i class="fa fa-caret-right"></i> ';
						$html .= $data[$parent][$c]["MENU_TITLE"]."</a>";	
					}
					if ($child){
						$i--;
						$html .= $child;
					}
					$html .= '</li>';
					if((count($arrayKeys) -1) == $c){
						$html .= "</ul>";
					}
				}
				return $html;
			}else{
				$html="";
				return false;
			}
		}else{
			return false;	
		}
	}

	function get_active($type,$segs){
		$arrdata = array();
		switch($type){
			case 'ID'	  :
				$SQL = "SELECT IFNULL(MENU_ID,0) AS ID 
						FROM tm_menu WHERE UPPER(MENU_URL) = ".$this->db->escape($segs);
				$result = $this->db->query($SQL);
				if($result->num_rows() > 0) {
					$arrdata = $result->row()->ID;
				}
			break;
			case 'PARENT' :
				$SQL = "SELECT IFNULL(MENU_ID,0) AS ID 
						FROM tm_menu WHERE UPPER(MENU_URL) = ".$this->db->escape($segs);
				$result = $this->db->query($SQL);
				$ID = $result->row()->ID;
				if($ID!=0){
					$QUERY = "SELECT func_active('".$ID."') AS active";
					$exec = $this->db->query($QUERY);
					$ID_PARENT = $exec->row()->active;
					if($ID_PARENT!=""){
						$arrdata = explode(',',$ID_PARENT);
					}
				}
			break;
		}
		return $arrdata;
	}
}