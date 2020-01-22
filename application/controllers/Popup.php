<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Popup extends CI_Controller {
	public function __construct() {
        parent::__construct();
    }
	
	function popup_search($type="",$id="",$popup="",$ajax=""){
		$this->load->model("m_popup");
		$arrdata = $this->m_popup->popup_search($type,$id,$popup,$ajax);
		if($this->input->post("ajax")){
			echo $arrdata;
		}else{
			echo $this->load->view("popup-table", $arrdata, true);	
		}
	}
	
	function pilih($id="",$ajax=""){
		$this->load->model("m_popup");
		$this->m_popup->pilih($id,$ajax);
	}
	
	function autocomplete($type="",$act=""){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				$this->load->model("m_popup");
				$this->m_popup->execute($type,$act);
			}
		}
	}
}