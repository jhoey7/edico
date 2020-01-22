<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_popup extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	function popup_search($act,$id,$popup,$ajax) {
		$func = get_instance();
		$this->load->library('newtable');
		$KD_USER = $this->session->userdata('ID');
		$KD_TRADER = $this->session->userdata('KODE_TRADER');
        $fas_pabean = $this->session->userdata('FAS_PABEAN');
		$arract = explode("|", str_replace("%7C", "|", $act));
		$showchk = true;
		if($id!="")	$id = "/".str_replace("%7C", "|", $id);
		if($ajax!="") $ajax = "/".$ajax;
		if ($arract[0] == "mst_satuan") {
			$judul = "SATUAN";
			$SQL = "SELECT A.KD_SATUAN AS 'KODE SATUAN', A.URAIAN AS 'URAIAN SATUAN'
					FROM reff_satuan A";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('A.KD_SATUAN', 'KODE SATUAN'),array('A.URAIAN', 'URAIAN')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array());
			$this->newtable->keys(array("KODE SATUAN","URAIAN SATUAN"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		} elseif ($arract[0] == "mst_barang") {
			$judul = "MASTER BARANG";
			$SQL = "SELECT A.ID, A.KD_BRG AS 'KODE BARANG', B.URAIAN AS 'JNS. BARANG', A.NM_BRG AS 'URAIAN BARANG', A.KD_SATUAN_TERKECIL AS 'KODE SATUAN',
					FORMAT(A.STOCK_AKHIR,4) AS 'STOCK AKHIR' 
					FROM tm_barang A LEFT JOIN reff_jns_barang B ON B.kd_jns = A.jns_brg AND b.fas_pabean IN('ALL','".$fas_pabean."') 
					WHERE A.kode_trader = ".$KD_TRADER;
			if ($arract[1] != "") {
				$SQL .= " AND A.jns_brg = ".$this->db->escape($arract[1]);
			}
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('A.KD_BRG', 'KODE BARANG')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array("ID"));
			$this->newtable->keys(array("ID","KODE BARANG","URAIAN BARANG","JNS. BARANG"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		} elseif ($arract[0] == "mst_barang_inout") {
			$judul = "MASTER BARANG";
			$SQL = "SELECT A.ID, A.KD_BRG AS 'KODE BARANG', B.URAIAN AS 'JNS. BARANG', A.NM_BRG AS 'URAIAN BARANG', A.KD_SATUAN_TERKECIL AS 'KODE SATUAN',
					FORMAT(A.STOCK_AKHIR,4) AS 'STOCK AKHIR', A.jns_brg
					FROM tm_barang A LEFT JOIN reff_jns_barang B ON B.kd_jns = A.jns_brg AND b.fas_pabean IN('ALL','".$fas_pabean."') 
					WHERE A.kode_trader = ".$KD_TRADER;
			if ($arract[1] != "") {
				$SQL .= " AND A.jns_brg = ".$this->db->escape($arract[1]);
			}
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('A.KD_BRG', 'KODE BARANG')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array("ID","jns_brg"));
			$this->newtable->keys(array("ID","KODE BARANG","jns_brg"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
		} elseif ($arract[0] == "mst_barang_gudang") {
			$judul = "MASTER GUDANG BARANG";
			$SQL = "SELECT A.ID, A.NAMA AS 'WAREHOUSE', A.URAIAN AS 'URAIAN WAREHOUSE'
					FROM tm_barang_gudang B LEFT JOIN tm_warehouse A ON A.ID = B.ID_GUDANG
					WHERE B.ID_BARANG = ".$arract[1];
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('A.NAMA', 'NAMA WAREHOUSE')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array("ID"));
			$this->newtable->keys(array("ID","WAREHOUSE"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		} elseif ($arract[0] == "mst_satuan_barang") {
			$judul = "MASTER SATUAN";
			$SQL = "SELECT c.KD_SATUAN AS 'KODE SATUAN', c.URAIAN 
					FROM reff_satuan AS c 
					WHERE EXISTS 
					( SELECT 1
						FROM tm_barang AS p
						WHERE (p.kd_satuan = c.kd_satuan OR p.kd_satuan_terkecil = c.kd_satuan)
						AND p.id = ".$arract[1]."
      				)";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('c.KD_SATUAN', 'KODE_SATUAN')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array());
			$this->newtable->keys(array("KODE SATUAN"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		} elseif ($arract[0] == "mst_valuta") {
			$judul = "MASTER VALUTA";
			$SQL = "SELECT KODE_VALUTA AS 'KD. VALUTA', URAIAN_VALUTA AS 'URAIAN' FROM reff_valuta";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('KODE_VALUTA', 'KD. VALUTA'),array('URAIAN_VALUTA', 'UR. VALUTA')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array());
			$this->newtable->keys(array("KD. VALUTA","URAIAN"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		} elseif ($arract[0] == "mst_negara") {
			$judul = "MASTER VALUTA";
			$SQL = "SELECT KD_NEGARA AS 'KD. NEGARA', URAIAN_NEGARA AS 'URAIAN' FROM reff_negara";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('KD_NEGARA', 'KD. NEGARA'),array('URAIAN_NEGARA', 'UR. NEGARA')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array());
			$this->newtable->keys(array("KD. NEGARA","URAIAN"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		} elseif ($arract[0] == "mst_konversi") {
			$judul = "MASTER KONVERSI";
			$SQL = "SELECT a.no_konversi as 'NO. KONVERSI', b.kd_brg as 'KD. BARANG', c.uraian as 'JNS. BARANG', b.kd_satuan_terkecil as 'KD. SATUAN', 
					b.nm_brg as 'URAIAN BARANG', a.id as id_konversi, a.id_barang
					FROM tm_konversi_hp a
					LEFT JOIN tm_barang b on b.id = a.id_barang
					LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg AND FAS_PABEAN IN('ALL','".$this->session->userdata('FAS_PABEAN')."')
					WHERE a.kode_trader = ".$KD_TRADER;
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('a.no_konversi', 'NO. KONVERSI'),array('b.kd_brg', 'KD. BARANG')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array('id_konversi','id_barang'));
			$this->newtable->keys(array("id_konversi","NO. KONVERSI","KD. SATUAN","id_barang","KD. BARANG","JNS. BARANG","URAIAN BARANG"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		} elseif ($arract[0] == "mst_barang_konversi") {
			$judul = "MASTER BARANG";
			$SQL = "SELECT A.ID, A.KD_BRG AS 'KODE BARANG', B.URAIAN AS 'JNS. BARANG', A.NM_BRG AS 'URAIAN BARANG', A.KD_SATUAN_TERKECIL AS 'KODE SATUAN',
					FORMAT(A.STOCK_AKHIR,4) AS 'STOCK AKHIR' 
					FROM tm_barang A LEFT JOIN reff_jns_barang B ON B.kd_jns = A.jns_brg
					WHERE A.kode_trader = ".$KD_TRADER." AND A.jns_brg = ".trim($arract[1]);
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','glyphicon glyphicon-check',$popup));
			$this->newtable->search(array(array('A.KD_BRG', 'KODE BARANG')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array("ID"));
			$this->newtable->keys(array("ID","KODE BARANG","JNS. BARANG","KODE SATUAN"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}
		$this->newtable->tipe_check('radio');
		$this->newtable->multiple_search(false);
		$this->newtable->tipe_proses('button');
		$this->newtable->show_chk($showchk);
		$this->newtable->show_search(true);
		$this->newtable->cidb($this->db);
		$this->newtable->set_formid("tblsearch");
		$this->newtable->set_divid("divtblsearch");
		$this->newtable->rowcount(10);
		$this->newtable->clear(); 
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);			
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post") return $tabel;				 
		else return $arrdata;
	}
	
	function pilih($id,$ajax){
		$arrayReturn = array();
		$arrfield = explode('|',str_replace("%7C", "|", $id));
		if(count($arrfield>0)){
			foreach($this->input->post('tb_chktblsearch') as $chkitem){
				$arrdata[]  = $this->azdgcrypt->decrypt($chkitem);
			}
			$value = implode($arrdata,",");
			$arrvalue = explode("~",$value);
		}
		if($ajax!="") $ajax = str_replace("~","/",$ajax);
		$arrayReturn['arrajax'] = $ajax;
		$arrayReturn['arrvalue'] = $arrvalue;
		$arrayReturn['arrfield'] = $arrfield;
		echo json_encode($arrayReturn);
	}
	
	public function execute($type,$act){
		$post = $this->input->post('term');
		if($type=="mst_negara"){
			if (!$post) return;
			$SQL = "SELECT KD_NEGARA, URAIAN_NEGARA 
					FROM reff_negara 
					WHERE KD_NEGARA LIKE '%".$post."%' OR URAIAN_NEGARA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->KD_NEGARA);
					$NAMA = strtoupper($row->URAIAN_NEGARA);
					if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KODE,"label"=>$NAMA,'NAMA'=>$NAMA);
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$NAMA,"KD_NEGARA"=>$KODE,'NAMA'=>$NAMA);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_satuan"){
			if (!$post) return;
			$SQL = "SELECT KODE_SATUAN, URAIAN_SATUAN
					FROM reff_satuan
					WHERE KODE_SATUAN LIKE '%".$post."%' OR URAIAN_SATUAN LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE_SATUAN = strtoupper($row->KODE_SATUAN);
					$URAIAN_SATUAN = strtoupper($row->URAIAN_SATUAN);
					$arrayDataTemp[] = array("value"=>$URAIAN_SATUAN, 'KODE_SATUAN'=>$KODE_SATUAN);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_port"){
			if (!$post) return;
			$SQL = "SELECT ID, CONCAT(NAMA,'[',ID,']') AS NAMA, NAMA AS GET_NAME
					FROM reff_pelabuhan WHERE ID LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$GET = strtoupper($row->GET_NAME);
					if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KODE,"label"=>$NAMA,"NAMA"=>$GET);	
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$GET,"label"=>$NAMA,"KODE"=>$KODE);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_kemasan"){
			if (!$post) return;
			$SQL = "SELECT ID, CONCAT(NAMA,' [',ID,']') AS NAMA, NAMA AS GET_NAME
					FROM reff_kemasan WHERE ID LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$GET = strtoupper($row->GET_NAME);
					if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KODE,"label"=>$NAMA,'NAMA'=>$GET);
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$GET,"label"=>$NAMA,'KODE'=>$KODE);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_dok_bc"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_kode_dok_bc 
					WHERE KD_PERMIT = ".$this->db->escape(strtoupper($act))."
					AND NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_isocode"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_cont_isocode
					WHERE ID LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_organisasi"){
			if (!$post) return;
			if($act!=""){
				$add_sql = " AND KD_TIPE_ORGANISASI = ".$this->db->escape($act);
			}
			$SQL = "SELECT ID, NAMA, NPWP FROM t_organisasi 
					WHERE NAMA LIKE '%".$post."%' OR NPWP LIKE '%".$post."%'".$add_sql."
					LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$NPWP = strtoupper($row->NPWP);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE,"NPWP"=>$NPWP,"NAMA"=>$NAMA);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_gudang"){
			if (!$post) return;
			$SQL = "SELECT KD_TPS, KD_GUDANG, NAMA_GUDANG FROM reff_gudang 
					WHERE KD_GUDANG LIKE '%".$post."%' OR NAMA_GUDANG LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KD_TPS = strtoupper($row->KD_TPS);
					$KD_GUDANG = strtoupper($row->KD_GUDANG);
					$NM_GUDANG = strtoupper($row->NAMA_GUDANG);
					if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KD_GUDANG,"KD_TPS"=>$KD_TPS,"NM_GUDANG"=>$NM_GUDANG);
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$NM_GUDANG,"KD_TPS"=>$KD_TPS,"NM_GUDANG"=>$NM_GUDANG);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="res_plp"){
			if (!$post) return;
			$SQL = "SELECT A.ID, A.KD_KPBC, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN, A.NO_PLP, A.NO_SURAT, A.TGL_SURAT, A.NM_ANGKUT, 
					DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') AS TGL_PLP, A.NO_VOY_FLIGHT, A.CALL_SIGN, A.TGL_TIBA, A.NO_BC11, A.TGL_BC11
					FROM t_respon_plp_tujuan_v2_hdr A
					WHERE A.NO_PLP LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$PLP = strtoupper($row->NO_PLP);
					$TGL_PLP = $row->TGL_PLP;
					$arrayDataTemp[] = array("value"=>$PLP,"TGL_PLP"=>$TGL_PLP);
				}
			}
			echo json_encode($arrayDataTemp);	
		}
	}
}
?>