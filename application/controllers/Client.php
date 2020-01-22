<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {
	public function __construct() {
        parent::__construct();

		$configisg = $this->configisg();

		global $host;
		global $user;
		global $password;
		global $token;

		$host = $configisg['host'];
		$user = $configisg['user'];
		$password = $configisg['password'];
		$token = $configisg['token'];
    }
	
	private function configisg() {
		$apppath =  str_replace("\\", "/", APPPATH);
		$fileconfig = $apppath.'client.txt';echo $fileconfig;die();
		$file = file_get_contents($fileconfig, true);

		$lines = explode("\n", $file);

		$configisg['host'] = preg_replace('/^[^=]*=/', '', $lines[0]);
		$configisg['user'] = preg_replace('/^[^=]*=/', '', $lines[1]);
		$configisg['password'] = preg_replace('/^[^=]*=/', '', $lines[2]);
		$configisg['token'] = preg_replace('/^[^=]*=/', '', $lines[3]);
		return $configisg;
	}

	public function login() {
		global $host, $user, $password, $token;

		$ch     = curl_init();
		$url = $host;
		$email = $user;
		$password = $password;

		$json = json_encode(array("email"=>$email, "password"=>$password));
		$headerPost = array('Content-Type: application/json');
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headerPost);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		$arrData = json_decode($server_output,TRUE);
		curl_close($ch);
		if (count($arrData) > 0) {
			$url =file("list.txt");
			foreach ($url as $sites) {
				$sites = trim($sites);
				$pos = strpos($sites, 'wp-content');
				$newStr = substr($sites,0,$pos );
			}
		}
	}

	public function execute($tipe) {
		
	}

}