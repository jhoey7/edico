<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_table extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}

	function user($act="") {
		$header = "Data User";
		$header_content = "Menampilkan seluruh data User yang terdapat di Data User.";
		$this->load->library('newtable');
		$SQL = "SELECT a.EMAIL, a.NAMA, a.ALAMAT, a.TELEPON, b.uraian as 'USER ROLE', case a.status when '1' then 'ACTIVE' when '0' then 'NON ACTIVE' end as 'STATUS', a.id
				FROM tm_user a INNER JOIN tm_role b on a.user_role = b.kode_role
				WHERE a.kode_trader = ".$this->session->userdata('KODE_TRADER');
		$proses = array(
			'ENTRY'  => array('ADD',"user/add", '0','','fa fa-plus'),
			'UPDATE' => array('GET',site_url()."/users/user/edit", '1','','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/user", 'N','','glyphicon glyphicon-trash')
		);
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('a.nama','NAMA USER'),array('a.email','EMAIL USER')));
		$this->newtable->action(site_url() . "/users/user");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('id'));
		$this->newtable->keys(array("id"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbluser");
		$this->newtable->set_divid("divtbluser");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function role($act="") {
		$header = "Data Role";
		$header_content = "Menampilkan seluruh data Role yang terdapat di Data Role.";
		$this->load->library('newtable');
		$SQL = "SELECT kode_role, uraian AS 'ROLE'
				FROM tm_role
				WHERE kode_role <> '1'";
		$proses = array(
			'ENTRY'  => array('ADD',"role/add", '0','','fa fa-plus'),
			'UPDATE' => array('GET',site_url()."/users/role/edit", '1','','fa fa-edit'),
			// 'DELETE' => array('POST',"execute/process/delete/role", 'N','','glyphicon glyphicon-trash')
		);
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('uraian','ROLE')));
		$this->newtable->action(site_url() . "/users/role");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('kode_role'));
		$this->newtable->keys(array("kode_role"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("kode_role");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblrole");
		$this->newtable->set_divid("divtblrole");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function satuan() {
		$header = "Data Referensi Satuan";
		$header_content = "Menampilkan seluruh data Satuan yang terdapat di Referensi Satuan.";
		$this->load->library('newtable');
		$SQL = "SELECT kd_satuan AS 'KODE SATUAN', uraian AS 'URAIAN SATUAN' 
				FROM reff_satuan";
		$proses = array();
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('kd_satuan','KODE SATUAN'),array('uraian','URAIAN SATUAN')));
		$this->newtable->action(site_url() . "/referensi/satuan");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("kd_satuan"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("kd_satuan");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblsatuan");
		$this->newtable->set_divid("divtblsatuan");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax"))
			return $tabel;
		else
			return $arrdata;
	}

	function negara() {
		$header = "Data Referensi Negara";
		$header_content = "Menampilkan seluruh data Negara yang terdapat di Referensi Negara.";
		$this->load->library('newtable');
		$SQL = "SELECT kd_negara AS 'KODE NEGARA', uraian_negara AS 'URAIAN NEGARA' 
				FROM reff_negara";
		$proses = array();
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('kd_negara','KODE NEGARA'),array('uraian_negara','URAIAN NEGARA')));
		$this->newtable->action(site_url() . "/referensi/negara");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("kd_negara"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("kd_negara");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblnegara");
		$this->newtable->set_divid("divtblnegara");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax"))
			return $tabel;
		else
			return $arrdata;
	}

	function supplier($act="") {
		$header = "Data Referensi Vendor/Customer";
		$header_content = "Menampilkan seluruh data Vendor/Customer.";
		if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}

		$this->load->library('newtable');
		$SQL = "SELECT a.kd_supplier, a.nm_supplier as 'NAMA VENDOR/CUSTOMER', a.almt_supplier as 'ALAMAT VENDOR/CUSTOMER', 
				b.uraian_negara as 'NEGARA VENDOR/CUSTOMER', a.npwp_supplier as 'KODE VENDOR/CUSTOMER' 
				FROM reff_supplier a 
				LEFT JOIN reff_negara b on a.kd_negara = b.kd_negara 
				WHERE a.kode_trader = ".$this->session->userdata('KODE_TRADER');
		$proses = array(
			'ENTRY'  => array('ADD',"supplier/add", '0','','fa fa-plus'),
			'UPDATE' => array('GET',site_url()."/referensi/supplier/edit", '1','','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/supplier", 'N','','glyphicon glyphicon-trash')
		);
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->tipe_check('radio');
		$this->newtable->search(array(array('a.nm_supplier','NAMA SUPPLIER'),array('a.npwp_supplier','NPWP SUPPLIER')));
		$this->newtable->action(site_url() . "/referensi/supplier");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('kd_supplier'));
		$this->newtable->keys(array("kd_supplier"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.kd_supplier");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblsupplier");
		$this->newtable->set_divid("divtblsupplier");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function warehouse($act="") {
		$header = "Data Referensi Warehouse";
		$header_content = "Menampilkan seluruh data Warehouse yang terdapat di Referensi Warehouse.";
		if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}

		$this->load->library('newtable');
		$SQL = "SELECT a.KODE, a.NAMA, a.URAIAN, a.ID 
				FROM tm_warehouse a 
				WHERE a.kode_trader = ".$this->session->userdata('KODE_TRADER');
		$proses = array(
			'ENTRY'  => array('ADD',"warehouse/add", '0','','fa fa-plus'),
			'UPDATE' => array('GET',site_url()."/referensi/warehouse/edit", '1','','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/warehouse", 'N','','glyphicon glyphicon-trash')
		);
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->tipe_check('radio');
		$this->newtable->search(array(array('a.NAMA','NAMA WAREHOUSE')));
		$this->newtable->action(site_url() . "/referensi/warehouse");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('ID'));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.ID");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblwarehouse");
		$this->newtable->set_divid("divtblwarehouse");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function barang($act="") {
		$func = get_instance();
        $func->load->model("m_main", "main", true);
        $kode_trader = $this->session->userdata('KODE_TRADER');
        $fas_pabean = $this->session->userdata('FAS_PABEAN');
        if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}

		$header = "Data Barang";
		$header_content = "Menampilkan seluruh data Barang yang terdapat di Inventory.";
		$this->load->library('newtable');
		$SQL = "SELECT a.kd_brg as 'KODE BARANG', b.uraian as 'JENIS BARANG', a.nm_brg as 'URAIAN BARANG', a.kd_hs as 'KODE HS', a.kd_satuan as 'SATUAN TERBESAR', 
				IF(a.kd_satuan_terkecil <> '', a.kd_satuan_terkecil, IF(a.nilai_konversi = 1, a.kd_satuan, a.kd_satuan_terkecil)) 'SATUAN TERKECIL', 
			    CONCAT('1 ', a.kd_satuan,' = ',a.nilai_konversi,' ',IF(a.kd_satuan_terkecil <> '', a.kd_satuan_terkecil, IF(a.nilai_konversi=1,a.kd_satuan, a.kd_satuan_terkecil))) 'KONVERSI SATUAN', CONCAT('<span style=\"float:right\">',FORMAT(IFNULL(a.stock_akhir,0),".$this->session->userdata('FORMAT_QTY')."),' ',IF(a.kd_satuan_terkecil<>'',a.kd_satuan_terkecil,IF(a.nilai_konversi=1,a.kd_satuan,a.kd_satuan_terkecil)),'</span>') 'STOCK AKHIR', a.id
				FROM tm_barang a LEFT JOIN reff_jns_barang b ON b.kd_jns = a.jns_brg AND b.fas_pabean IN('ALL','".$fas_pabean."')
				WHERE a.kode_trader = ".$this->db->escape($kode_trader);
		$proses = array(
			'ENTRY'  => array('ADD',"barang/add", '0','','fa fa-plus'),
			'UPDATE' => array('EDIT_AJAX',"barang/edit", '1','','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/barang", '1','','glyphicon glyphicon-trash'),
			'UPLOAD' => array('MODAL',"inventory/barang/upload","0","","fa fa-upload")
		);

		$query = "SELECT KD_JNS, URAIAN FROM reff_jns_barang WHERE FAS_PABEAN IN('ALL','".$fas_pabean."')";
		$arr_jns_brg = $func->main->get_combobox($query, "KD_JNS", "URAIAN", TRUE);

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->tipe_check('radio');
		$this->newtable->search(array(array('a.kd_brg','KODE BARANG'),array('a.nm_brg','URAIAN BARANG'),array('a.jns_brg','JENIS BARANG','OPTION',$arr_jns_brg)));
		$this->newtable->action(site_url() . "/inventory/barang");
		$this->newtable->detail(array('PREVIEW','barang/preview'));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('id'));
		$this->newtable->keys(array("id"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblbarang");
		$this->newtable->set_divid("divtblbarang");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function detail_barang($id="") {
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$this->load->library('newtable');
		$SQL = "SELECT a.kode as 'KODE WAREHOUSE', a.nama as 'WAREHOUSE', 
				CONCAT('<span style=\"float:right\">',FORMAT(IFNULL(b.SALDO,0),".$this->session->userdata('FORMAT_QTY')."),'</span>') as 'SALDO'
				FROM tm_warehouse a 
				RIGHT JOIN tm_barang_gudang b ON a.id = b.id_gudang
				WHERE b.id_barang = ".$this->azdgcrypt->decrypt($id);
		$proses = array();

		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('a.nama','WAREHOUSE')));
		$this->newtable->action(site_url() . "/inventory/barang/preview/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.kode");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblbaranggudang");
		$this->newtable->set_divid("divtblbaranggudang");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("content" => $tabel);
		if($this->input->post("ajax"))
			return $tabel;
		else
			return $arrdata;
	}

	function stockopname($act="") {
		$this->load->library('newtable');
        if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}
		$header = "Data Stockopname";
		$header_content = "Menampilkan seluruh data Stockopname yang terdapat di Inventory.";
		$kode_trader = $this->session->userdata('KODE_TRADER');
		$SQL = "SELECT DATE_FORMAT(tgl_stock, '%d %M %Y %H:%i') AS 'TGL. STOCKOPNAME', COUNT(id) AS 'JML. DETIL BARANG', DATE_FORMAT(tgl_stock, '%Y%m%d%H%i') as id
				FROM tm_stockopname 
				WHERE kode_trader = ".$this->db->escape($kode_trader);
		$proses = array(
			// 'ENTRY'  => array('ADD',"stockopname/add", '0','','fa fa-plus'),
			'UPDATE' => array('GET',site_url()."/inventory/stockopname/edit", '1','','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/stockopname", 'N','','glyphicon glyphicon-trash'),
			'UPLOAD' => array('MODAL',"inventory/stockopname/upload","0","","fa fa-upload")
		);

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('tgl_stock','TANGGAL STOCKOPNAME',"DATERANGE")));
		$this->newtable->action(site_url() . "/inventory/stockopname");
		$this->newtable->detail(array('PREVIEW','stockopname/preview'));
		$this->newtable->tipe_check('radio');
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('id'));
		$this->newtable->keys(array("id"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby("tgl_stock");
		$this->newtable->orderby("id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblstockopname");
		$this->newtable->set_divid("divtblstockopname");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function detail_stockopname($id="", $act="") {
		$this->load->library('newtable');
		$fas_pabean = $this->session->userdata('FAS_PABEAN');
		$SQL = "SELECT a.kd_brg AS 'KD. BARANG', b.uraian AS 'JNS. BARANG', a.nm_brg AS 'URAIAN BARANG', 
				CONCAT('<span style=\"float:right\">',FORMAT(IFNULL(c.jml_stockopname,0),".$this->session->userdata('FORMAT_QTY')."),'</span>') AS 'JML. STOCKOPNAME',
				a.kd_satuan_terkecil AS 'KD. SATUAN', d.kode AS 'KD. GUDANG', c.id
				FROM tm_barang a 
				LEFT JOIN reff_jns_barang b on b.kd_jns = a.jns_brg AND b.fas_pabean IN('ALL','".$fas_pabean."')
				LEFT JOIN tm_stockopname c on a.id = c.id_barang AND a.kode_trader = c.kode_trader
				LEFT JOIN tm_warehouse d on d.id = c.id_gudang AND d.kode_trader = c.kode_trader
				WHERE DATE_FORMAT(c.tgl_stock, '%Y%m%d%H%i') = ".$this->azdgcrypt->decrypt($id);

		if ($act == "edit" || $act == "ajax") {
			$proses = array(
				'ENTRY'  => array('MODAL',"inventory/stockopname/add_details/".$id, '0','','fa fa-plus'),
				'UPDATE' => array('EDIT_MODAL_AJAX', "inventory/stockopname/edit_details/".$id, '1','','fa fa-edit'),
				'DELETE' => array('POST',"execute/process/delete/stockopnameById/".$id, 'N','','glyphicon glyphicon-trash')
			);
			if (grant() == "W") {
				$checked = true;
			} else {
				$checked = false;
			}
		} else {
			$checked = false;
		}

		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('a.kd_brg','KD. BARANG'), array('d.kode','KD. GUDANG')));
		$this->newtable->action(site_url() . "/inventory/stockopname/preview/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('id'));
		$this->newtable->keys(array('id'));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("c.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblstockopnamedtl");
		$this->newtable->set_divid("divtblstockopnamedtl");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("content" => $tabel);
		if($this->input->post("ajax") || $act == "ajax")
			return $tabel;
		else
			return $arrdata;
	}

	function konversi($act="") {
		$header = "Data Konversi";
		$header_content = "Menampilkan seluruh data Konversi yang terdapat di Inventory.";
        if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}

		$this->load->library('newtable');
		$SQL = "SELECT a.no_konversi 'NO. KONVERSI', b.kd_brg AS 'KD. BARANG', c.uraian as 'JNS. BARANG', b.nm_brg as 'NAMA BARANG',
				a.keterangan as 'KETERANGAN', a.id, (SELECT COUNT(ID) FROM tm_konversi_bb WHERE id_hdr = a.id) AS 'JML. DETIL BAHAN BAKU'
				FROM tm_konversi_hp a
				LEFT JOIN tm_barang b ON b.id = a.id_barang
				LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg and c.fas_pabean in('ALL','".$this->session->userdata('FAS_PABEAN')."') 
				WHERE a.kode_trader = ".$this->session->userdata('KODE_TRADER');
		$proses = array(
			'ENTRY'  => array('MODAL',"inventory/konversi/add", '0','','fa fa-plus'),
			'UPDATE' => array('EDIT_MODAL_AJAX', "inventory/konversi/edit", '1','','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/konversi", 'N','','glyphicon glyphicon-trash'),
			'PREVIEW' => array('GET',site_url()."/inventory/konversi/preview", '1','','fa fa-search-plus')
		);

		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('a.no_konversi','NO. KONVERSI'),array('b.kd_brg','KODE BARANG')));
		$this->newtable->action(site_url("/inventory/konversi"));
		$this->newtable->detail(array('PREVIEW','konversi/details'));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('id'));
		$this->newtable->keys(array("id"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblkonversi");
		$this->newtable->set_divid("divtblkonversi");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function konversi_bb($act, $id, $ajax="") {
        if (grant() == "W") {
			$checked = true;
			if ($ajax == "details") {
				$checked = false;
			}
		} else {
			$checked = false;
		}

		$this->load->library('newtable');
		$SQL = "SELECT b.kd_brg AS 'KD. BARANG', c.uraian as 'JNS. BARANG', b.nm_brg as 'NAMA BARANG', a.KETERANGAN, 
				CONCAT('<span style=\"float:right;\">',FORMAT(a.jml_satuan,".$this->session->userdata('FORMAT_QTY')."),'</span>') as 'JML. SATUAN', 
				b.kd_satuan_terkecil as 'KD. SATUAN', a.id, a.id_hdr
				FROM tm_konversi_bb a
				LEFT JOIN tm_barang b ON b.id = a.id_barang
				LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg and c.fas_pabean in('ALL','".$this->session->userdata('FAS_PABEAN')."') 
				WHERE a.id_hdr = ".$this->azdgcrypt->decrypt($id);
		$proses = array(
			'ENTRY'  => array('MODAL',"inventory/konversi/bb/add/".$id, '0','','fa fa-plus'),
			'UPDATE' => array('EDIT_MODAL_AJAX', "inventory/konversi/bb/edit/".$id, '1','','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/konversi_bb", 'N','','glyphicon glyphicon-trash')
		);

		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('b.kd_brg','KD. BARANG')));
		$this->newtable->action(site_url() . "/inventory/konversi/".$act."/".$id."/".$ajax);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('id','id_hdr'));
		$this->newtable->keys(array("id","id_hdr"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblkonversidtl");
		$this->newtable->set_divid("divtblkonversidtl");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("content" => $tabel);
		if($this->input->post("ajax") || $ajax == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function tpb_hdr($type, $act="") {
		$func = get_instance();
        $func->load->model("m_main", "main", true);
        if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}

        if ($type == "grn") {
			$header = "Data Good Receive Note";
			$header_content = "Menampilkan seluruh data Data Good Receive Note.";
        } else {
			$header = "Data Good Delivery Note";
			$header_content = "Menampilkan seluruh data Data Good Delivery Note.";
        }

        if ($this->session->userdata('SHOW_AJU') == "Y") {
        	$field = " a.nomor_aju AS 'NO. AJU', ";
        } else {
        	$field = "";
        }


		$this->load->library('newtable');
		$SQL = "SELECT a.no_inout AS 'NO. ".strtoupper($type)."', DATE_FORMAT(a.tgl_inout,'%d %b %Y') AS 'TGL. ".strtoupper($type)."', c.nm_supplier AS 'PARTNER', 
				a.source_dokumen as 'SOURCE DOKUMEN', (SELECT COUNT(ID_HDR) FROM tpb_dtl WHERE ID_HDR = a.id) AS 'JML. DETIL', b.uraian_dokumen AS 'JNS. DOK', 
				".$field." a.no_daftar AS 'NO. DAFTAR', DATE_FORMAT(a.tgl_daftar,'%d %b %Y') AS 'TGL. DAFTAR', 
				DATE_FORMAT(a.tgl_realisasi,'%d %b %Y %H:%i:%s') AS 'TGL. REALISASI', a.id, a.status as status_validasi,
				CASE a.status 
					WHEN 'D' THEN '<span class=\"btn btn-xs btn-orange-alt\">DRAFT</span>'
					WHEN 'R' THEN '<span class=\"btn btn-xs btn-success-alt\">REALISASI</span>'
				END AS STATUS
				FROM tpb_hdr a 
				LEFT JOIN reff_dokumen b on b.kode_dokumen = a.jns_dokumen and b.fasilitas = '".$this->session->userdata('FAS_PABEAN')."'
				LEFT JOIN reff_supplier c ON c.kd_supplier = a.partner_id
				WHERE a.kode_trader = ".$this->session->userdata('KODE_TRADER');
		if ($type == "grn") $SQL .= " AND a.jns_inout = 'IN'";
		else $SQL .= " AND a.jns_inout = 'OUT'";
		$proses = array(
			'ENTRY'  => array('MODAL',$type."/daftar/add", '0','','fa fa-plus'),
			'UPDATE' => array('EDIT_MODAL_AJAX',$type."/daftar/edit", '1','D','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/".$type, '1','D','glyphicon glyphicon-trash'),
			'PREVIEW' => array('GET',site_url()."/".$type."/daftar/preview", '1','','fa fa-search-plus'),
			'REALISASI' => array('EDIT_MODAL_AJAX',$type."/daftar/realisasi", '1','D','glyphicon glyphicon-check')
		);

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->tipe_check('radio');
		$this->newtable->search(array(array('a.no_inout','NOMOR '.strtoupper($type)),array('a.tgl_inout','TANGGAL '.strtoupper($type),"DATERANGE")));
		$this->newtable->action(site_url() . "/".$type."/daftar");
		$this->newtable->detail(array('GET',site_url()."/".$type."/daftar/preview"));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses('button');
		$this->newtable->validasi(array('status_validasi'));
		$this->newtable->hiddens(array('id','status_validasi'));
		$this->newtable->keys(array("id"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbl".$type."hdr");
		$this->newtable->set_divid("divtbl".$type."hdr");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function details($type, $id, $ajax="") {
        if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}
		$this->load->library('newtable');
		$fas_pabean = $this->session->userdata('FAS_PABEAN');
		$SQL = "SELECT a.id, b.kd_brg as 'KODE BARANG', e.uraian as 'JNS. BARANG', b.nm_brg as 'URAIAN BARANG', a.kd_satuan AS 'KD. SATUAN', 
				CONCAT('<span style=\"float: right;\">',format(a.jml_satuan,".$this->session->userdata('FORMAT_QTY')."),'</span>') AS 'JML. SATUAN', 
				CONCAT('<span style=\"float: right;\">',format(a.unit_price,".$this->session->userdata('FORMAT_CURRENCY')."),'</span>') AS 'UNIT PRICE', 
				CONCAT('<span style=\"float: right;\">',format(a.price,".$this->session->userdata('FORMAT_CURRENCY')."),'</span>') AS 'PRICE', 
				d.nama as 'WAREHOUSE', a.status, a.id_hdr
				FROM tpb_dtl a 
				INNER JOIN tpb_hdr c on c.id = a.id_hdr
				LEFT JOIN tm_barang b on b.id = a.id_barang
				LEFT JOIN tm_warehouse d on d.id = a.id_warehouse
				LEFT JOIN reff_jns_barang e on e.kd_jns = b.jns_brg AND e.fas_pabean IN('ALL','".$fas_pabean."')
				WHERE c.id = ".$this->azdgcrypt->decrypt($id);

		if (strtolower($ajax) == "realisasi") {
			$process = array();
			$show_chk = false;
		} else {
			$proses = array(
				'ENTRY'  => array('MODAL',$type."/details/add/".$id, '0','','fa fa-plus'),
				'UPDATE' => array('EDIT_MODAL_AJAX',$type."/details/edit/".$id, '1','00','fa fa-edit'),
				'DELETE' => array('POST',"execute/process/delete/".$type."_details", 'N','00','glyphicon glyphicon-trash')
			);
			if (grant() == "W") {
				$show_chk = true;
			} else {
				$show_chk = false;
			}
		}

		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($show_chk);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('b.kd_brg','KODE BARANG'),array('b.nm_brg','URAIAN BARANG')));
		$this->newtable->action(site_url() . "/".$type."/details/".$id."/".strtolower($ajax));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses('button');
		$this->newtable->validasi(array('status'));
		$this->newtable->hiddens(array('id','status','id_hdr'));
		$this->newtable->keys(array("id","id_hdr"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbl".$type."dtl");
		$this->newtable->set_divid("divtbl".$type."dtl");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("content" => $tabel);
		if($this->input->post("ajax")||$ajax == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function produksi_hdr($type, $act="") {
		$func = get_instance();
        $func->load->model("m_main", "main", true);
        if ($type == "rm") {
			$header = "Data Raw Material";
			$header_content = "Menampilkan seluruh data Raw Material.";
			$title = "PENGELUARAN";
        } elseif ($type == "scrap") {
			$header = "Data Scrap";
			$header_content = "Menampilkan seluruh data Scrap.";
			$title = "PENERIMAAN";
        } elseif ($type == "half") {
			$header = "Data Half Finished";
			$header_content = "Menampilkan seluruh data Half Finished.";
			$title = "PENERIMAAN";
		} elseif ($type == "fg") {
			$header = "Data Finished Goods";
			$header_content = "Menampilkan seluruh data Finished Goods.";
			$title = "PENERIMAAN";
		}
        if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}

		$this->load->library('newtable');
		$SQL = "SELECT a.no_bukti_inout AS 'NO. BUKTI KELUAR', DATE_FORMAT(a.tgl_bukti_inout,'%d %b %Y %H:%i') AS 'TGL. BUKTI KELUAR', 
				(SELECT COUNT(ID_HDR) FROM tr_produksi_dtl WHERE ID_HDR = a.id) AS 'JML. DETIL', a.keterangan AS 'KETERANGAN',
				CASE a.status 
					WHEN 'D' THEN '<span class=\"btn btn-xs btn-orange-alt\">DRAFT</span>'
					WHEN 'R' THEN '<span class=\"btn btn-xs btn-success-alt\">REALISASI</span>'
				END AS STATUS, a.status as status_validasi, a.id
				FROM tr_produksi_hdr a
				WHERE a.kode_trader = ".$this->session->userdata('KODE_TRADER');
		if ($type == "rm") $SQL .= " AND a.jenis_produksi = 'RM'";
		elseif ($type == "scrap") $SQL .= " AND a.jenis_produksi = 'SCRAP'";
		elseif ($type == "half") $SQL .= " AND a.jenis_produksi = 'HALF'";
		elseif ($type == "fg") $SQL .= " AND a.jenis_produksi = 'FG'";
		$proses = array(
			'ENTRY'  => array('MODAL',"produksi/".$type."/add", '0','','fa fa-plus'),
			'EDIT' => array('EDIT_MODAL_AJAX', "produksi/".$type.'/edit', '1','D','fa fa-edit'),
			'DELETE' => array('POST',"execute/process/delete/".$type, 'N','D','glyphicon glyphicon-trash'),
			'PREVIEW' => array('GET',site_url('produksi/'.$type.'/preview'), '1','','fa fa-search-plus'),
			'REALISASI' => array('POST',"execute/process/realisasi/".$type, '1','D','glyphicon glyphicon-check')
		);

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($checked);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->tipe_check('radio');
		$this->newtable->search(array(array('a.no_bukti_inout','NO. BUKTI '.$title),array('a.tgl_bukti_inout','TGL. BUKTI '.$title,"DATERANGE")));
		$this->newtable->action(site_url('produksi/'.$type));
		$this->newtable->detail(array('PREVIEW',$type.'/details'));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses('button');
		$this->newtable->validasi(array('status_validasi'));
		$this->newtable->hiddens(array('id','status_validasi'));
		$this->newtable->keys(array("id"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbl".$type);
		$this->newtable->set_divid("divtbl".$type);
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function produksi_dtl($act, $id="", $ajax="") {
        if (grant() == "W") {
			$checked = true;
		} else {
			$checked = false;
		}
		$this->load->library('newtable');
		$fas_pabean = $this->session->userdata('FAS_PABEAN');

		$SQL = "SELECT b.kd_brg as 'KD. BARANG', b.nm_brg as 'URAIAN BARANG', c.uraian as 'JNS. BARANG', 
				CONCAT('<span style=\"float: right;\">',format(a.jml_satuan,".$this->session->userdata('FORMAT_QTY')."),'</span>') AS 'JML. SATUAN', 
				a.kd_satuan as 'KODE SATUAN', d.nama as 'WAREHOUSE', a.KETERANGAN, a.id, e.id as id_hdr, a.status
				FROM tr_produksi_dtl a
				INNER JOIN tr_produksi_hdr e on e.id = a.id_hdr
				LEFT JOIN tm_barang b on b.id = a.id_barang
				LEFT JOIN reff_jns_barang c on c.kd_jns = b.jns_brg AND c.fas_pabean IN('ALL','".$fas_pabean."')
				LEFT JOIN tm_warehouse d on d.id = a.id_gudang 
				WHERE e.id = ".$this->azdgcrypt->decrypt($id);

		if (strtolower($ajax) == "realisasi") {
			$process = array();
			$show_chk = false;
		} else {
			$proses = array(
				'ENTRY'  => array('MODAL',"produksi/details/".$act."/add/".$id."/".strtolower($ajax), '0','','fa fa-plus'),
				'UPDATE' => array('EDIT_MODAL_AJAX', "produksi/details/".$act."/edit/".$id."/".strtolower($ajax), '1','00','fa fa-edit'),
				'DELETE' => array('POST',"execute/process/delete/".$act."_dtl", 'N','00','glyphicon glyphicon-trash')
			);
			if (grant() == "W") {
				$show_chk = true;
			} else {
				$show_chk = false;
			}
		}

		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($show_chk);
		$this->newtable->show_menu($checked);
		$this->newtable->show_search(true);
		$this->newtable->tipe_check('radio');
		$this->newtable->search(array(array('b.kd_brg','KODE BARANG'),array('b.nm_brg','URAIAN BARANG')));
		$this->newtable->action(site_url("produksi/details/".$act."/".$id."/".strtolower($ajax)));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses('button');
		$this->newtable->validasi(array('status'));
		$this->newtable->hiddens(array('id','status','id_hdr'));
		$this->newtable->keys(array("id","id_hdr"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblproduksidtl");
		$this->newtable->set_divid("divtblproduksidtl");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("content" => $tabel);
		if($this->input->post("ajax")||$ajax == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function logapps() {
		$header = "Data Log Apps";
		$header_content = "Menampilkan seluruh data Log Activity Penggunaan Apps.";
		$this->load->library('newtable');
		$SQL = "SELECT DATE_FORMAT(a.wk_rekam, '%d %M %Y %H:%i:%s') as 'ACTIVITY DATE', a.ip_address as 'IP ADDRESS', 
				a.ACTION, a.remark as 'ACTIVITY', b.nama as 'PIC', a.id
				FROM tm_log_app a 
				INNER JOIN tm_user b on b.id = a.user_id
				WHERE a.KODE_TRADER = ".$this->session->userdata('KODE_TRADER');
		$proses = array();
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('b.nama','PIC'),array('a.wk_rekam','ACTIVITY DATE',"DATERANGE")));
		$this->newtable->action(site_url() . "/users/logapps");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('id'));
		$this->newtable->keys(array("id"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("a.id");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbllogapps");
		$this->newtable->set_divid("divtbllogapps");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("header" => $header, "header_content" => $header_content, "content" => $tabel);
		if($this->input->post("ajax"))
			return $tabel;
		else
			return $arrdata;
	}
}