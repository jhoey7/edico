<?php  defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('format_terbilang'))
{
	function format_terbilang($num,$dec=4){
		$stext = array(
			"Nol",
			"Satu",
			"Dua",
			"Tiga",
			"Empat",
			"Lima",
			"Enam",
			"Tujuh",
			"Delapan",
			"Sembilan",
			"Sepuluh",
			"Sebelas"
		);
		$say  = array(
			"Ribu",
			"Juta",
			"Milyar",
			"Triliun",
			"Biliun" // remember limitation of float
			
		);
		$w = "";
	
		if ($num <0 ) {
			$w  = "Minus ";
			//make positive
			$num *= -1;
		}
	
		$snum = number_format($num,$dec,",",".");
	   // die($snum);
		$strnum =  explode(".",substr($snum,0,strrpos($snum,",")));
		//parse decimalnya
		$koma = substr($snum,strrpos($snum,",")+1);
	
		$isone = substr($num,0,1)  ==1;
		if (count($strnum)==1) {
			$num = $strnum[0];
			switch (strlen($num)) {
				case 1:
				case 2:
					if (!isset($stext[$strnum[0]])){
						if($num<20){
							$w .=$stext[substr($num,1)]." Belas";
						}else{
							$w .= $stext[substr($num,0,1)]." Puluh ".
								(intval(substr($num,1))==0 ? "" : $stext[substr($num,1)]);
						}
					}else{
						$w .= $stext[$strnum[0]];
					}
					break;
				case 3:
					$w .=  ($isone ? "Seratus" : format_terbilang(substr($num,0,1)) .
						" Ratus").
						" ".(intval(substr($num,1))==0 ? "" : format_terbilang(substr($num,1)));
					break;
				case 4:
					$w .=  ($isone ? "Seribu" : format_terbilang(substr($num,0,1)) .
						" Ribu").
						" ".(intval(substr($num,1))==0 ? "" : format_terbilang(substr($num,1)));
					break;
				default:
					break;
			}
		}else{
			$text = $say[count($strnum)-2];
			$w = ($isone && strlen($strnum[0])==1 && count($strnum) <=2? "Se".strtolower($text) : format_terbilang($strnum[0]).' '.$text);
			array_shift($strnum);
			$i =count($strnum)-2;
			foreach ($strnum as $k=>$v) {
				if (intval($v)) {
					$w.= ' '.format_terbilang($v).' '.($i >=0 ? $say[$i] : "");
				}
				$i--;
			}
		}
		$w = trim($w);
		if ($dec = intval($koma)) {
			$w .= " koma ". format_terbilang($koma);
		}
		return trim($w);
	}
}

if(!function_exists('grant')){
	function grant(){
		$ci =& get_instance();
		$ci->load->database();
		$KD_USER = $ci->session->userdata('ID');
		$KD_GROUP = $ci->session->userdata('USER_ROLE');
		$segs_1 = $ci->uri->segment(1);
		$segs_2 = $ci->uri->segment(2);
		$arrsegs = explode('_',$segs_2);
		if($segs_2!="") $furi = trim($segs_1."/".$arrsegs[0]);
		$return = "";
		if($KD_GROUP=="2"){
			$return = 'W';
		}else{
			$query = "SELECT A.MENU_ID, B.GRANT_TYPE
					  FROM tm_menu A
					  INNER JOIN tm_role_menu B ON B.MENU_ID = A.MENU_ID
					  INNER JOIN tm_user C ON C.USER_ROLE = B.ROLE_ID
					  WHERE C.ID = ".$ci->db->escape($KD_USER)."
					  AND A.MENU_URL LIKE ".$ci->db->escape('%'.$furi.'%');
			$result = $ci->db->query($query); 
			if($result->num_rows() > 0){
				$akses = $result->row()->GRANT_TYPE;
				$return = $akses;
			}
		}
		return $return;
	}
}

if (!function_exists('name_date')){
	function name_date($vardate){
		$pecah1 = explode("-", $vardate);
		$tanggal = intval($pecah1[0]);
		$arrayBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
							"Agustus", "September", "Oktober", "November", "Desember");
		$bulan = $arrayBulan[intval($pecah1[1])];
		$tahun = intval($pecah1[2]);
		$balik = $tanggal." ".$bulan." ".$tahun;
		return $balik;
	}
}

if(!function_exists('validate')){
	function validate($data, $type="TEXT"){
		if(strtoupper(trim($data))==""){
        	$return = NULL;
		} else {
			switch ($type) {
				case "TEXT":
					if (trim($data) != "") $return = trim(strtoupper($data));
					break;
				case "DATE":
					if (trim($data) != ""){
						$arrdate = explode("-",$data);
						$return = $arrdate[0]."-".$arrdate[1]."-".$arrdate[2];
					}
				break;
				case "DATE-S":
					if (trim($data) != ""){
						$return = substr($data,0,4)."-".substr($data,4,2)."-".substr($data,6,2);
						if(substr($data,8,6)!=""){
							$return .= " ".substr($data,8,2).":".substr($data,10,2).":".substr($data,12,2);
						}
					}
				break;
				case "DATETIME":
					if (trim($data) != ""){
						$arrdatetime = explode(" ",$data);
						if($arrdatetime[1]!="") $time = " ".$arrdatetime[1];
						$arrdate = explode("-",$arrdatetime[0]);
						$return = $arrdate[2]."-".$arrdate[1]."-".$arrdate[0].$time;
					}
				break;
			}
		}
		return $return;
	}
}

if(!function_exists('currency')) {
	function currency($data) {
		if(trim($data) == "") {
        	$return = NULL;
		} else {
			$return = str_replace(",", "", $data);
		}
		return trim($return);
	}
}

?>