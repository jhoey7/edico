<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Fungsi{

	function FormatHS($varnohs){
		if (!is_null($varnohs)){
			$varresult = '';
			$varresult = substr($varnohs,0,4).".".substr($varnohs,4,2).".".substr($varnohs,6,2).".".substr($varnohs,8,2);
			return $varresult;
		}
	}	
	
	function FormatNPWP($varnpwp){
		$varresult = '';
		$varresult = substr($varnpwp,0,2).".".substr($varnpwp,2,3).".".substr($varnpwp,5,3).".".substr($varnpwp,8,1)."-".substr($varnpwp,9,3).".".substr($varnpwp,12,3);
		return $varresult;
	}	
	
	function FormatDate($vardate){
		$balik="";
		if($vardate!="" && $vardate!="0000-00-00"){
			$pecah1 = explode("-", $vardate);
			$tanggal = intval($pecah1[2]);
			$arrayBulan = array("", "January", "February", "March", "April", "May", "June", "July",
								"August", "September", "October", "November", "December");
			$bulan = $arrayBulan[intval($pecah1[1])];
			//$bulan = intval($pecah[1]);
			$tahun = intval($pecah1[0]);
			$balik = $tanggal." ".$bulan." ".$tahun;
		}
		return $balik;
	}
	
	function FormatDateIndo($vardate){
		$pecah1 = explode("-", $vardate);
		$tanggal = intval($pecah1[2]);
		$arrayBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
							"Agustus", "September", "Oktober", "November", "Desember");
		$bulan = $arrayBulan[intval($pecah1[1])];
		//$bulan = intval($pecah[1]);
		$tahun = intval($pecah1[0]);
		$balik = $tanggal." ".$bulan." ".$tahun;
		return $balik;
	}
	
	function FormatRupiah($angka,$decimal){
		$rupiah=number_format($angka,$decimal,'.',',');		
		return $rupiah;
	}	
	
	function dateformat($date){
		if($date!="" && $date!="0000-00-00"){
			if (strstr($date, "-"))   {
				   $date = preg_split("/[\/]|[-]+/", $date);
				   $date = $date[2]."-".$date[1]."-".$date[0];
				   return $date;
			}
			else if (strstr($date, "/"))   {
				   $date = preg_split("/[\/]|[-]+/", $date);
				   $date = $date[2]."-".$date[1]."-".$date[0];
				   return $date;
			}
			else if (strstr($date, ".")) {
				   $date = preg_split("[.]", $date);
				   $date = $date[2]."-".$date[1]."-".$date[0];
				   return $date;
			}
		}
		return false;
	}
	
	function replace($input,$var){
		if (!is_null($input)){
			$varresult = '';
			$varresult = str_replace($var,'',$input);
			return $varresult;
		}
	}	
	
	function FormatAju($var){
		if (!is_null($var)){
			$varresult = '';
			$varresult = substr($var,0,6)."-".substr($var,6,6)."-".substr($var,12,8)."-".substr($var,20,6);
			return $varresult;
		}
	}
	
	function getkodefas($kode){
		switch($kode){
			case '0': $hasil = "DBY";break;
			case '1': $hasil = "DTP";break;
			case '2': $hasil = "DTG";break;
			case '3': $hasil = "BKL";break;
			case '4': $hasil = "BBS";break;
			default: $hasil = "";break;
		}
		return $hasil;
	}
	
	function transparent_background($filename, $color){
		$img = imagecreatefrompng($filename); 
		$colors = explode(',', $color);
		$remove = imagecolorallocate($img, $colors[0], $colors[1], $colors[2]);
		imagecolortransparent($img, $remove);
		imagepng($img,$filename); 
	}
	
	function massage($tipe="",$msg=""){
		if($tipe=="warning"){
			$ret = '<div class="status warning">
						<p><span>Attention!</span>'.$msg.'</p>
					</div>';						
		}elseif($tipe=="success"){			
			$ret = '<div class="status success">
						<p><span>Success!</span>'.$msg.'</p>
					</div>';	
		}elseif($tipe=="error"){						
			$ret = '<div class="status error">
						<p><span>Error!</span>'.$msg.'</p>
					</div>';			
		}else{						
			$ret = '<div class="status error">
						<p><span>Error!</span>'.$msg.'</p>
					</div>';			
		}	
		return $ret;
	}
	
	function msg($tipe="",$msg=""){
		if($tipe=="warning"){
			$ret = '<p class="msg warn">'.$msg.'</p>';						
		}elseif($tipe=="success"){			
			$ret = '<p class="msg done">'.$msg.'</p>';	
		}elseif($tipe=="error"){	
			$ret = '<p class="msg err">'.$msg.'</p>';	
		}else{					
			$ret = '<p class="msg info">'.$msg.'</p>';	
		}	
		return $ret;
	}

	function formatshortdate($date){
		$arrayBulan = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		$tgl = str_replace(" ", "-", $date);
		$date = preg_split("/[\/]|[-]+/", $tgl);
		if(in_array($date[1], $arrayBulan)){
			$bulan = array_search($date[1],$arrayBulan);
			$date  = $date[2]."-".sprintf('%02d',$bulan)."-".$date[0];
			 return $date;
		}else{
			$this->dateformat($date);
		}
		return false;
	}
}
?>
