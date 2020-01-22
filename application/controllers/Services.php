<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {
	public function __construct() {
        parent::__construct();
    }
	
	function execute($type="",$act="") {
		$this->load->model("m_services");
		$this->m_services->execute($type,$act);
	}
}