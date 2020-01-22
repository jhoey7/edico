<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_report extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}

	function daftar($tipe, $tgl_awal, $tgl_akhir, $no_aju, $kd_dok, $all, $asal_barang="",$jns_brg="", $date_type="", $no_bc="") {
		$KODE_TRADER = $this->session->userdata('KODE_TRADER');
		if (in_array($tipe, array("pemasukan","pengeluaran","pemasukan_bb","pengeluaran_hp"))) {
			if ($all) {
				$tgl = "a.tgl_daftar";
			} else {
				$tgl = "DATE_FORMAT(a.tgl_realisasi, '%Y-%m-%d')";
			}
			$query = "SELECT CONCAT('BC ',a.jns_dokumen) as jns_dokumen, a.nomor_aju, a.no_daftar, a.tgl_daftar, a.no_inout, a.tgl_inout, b.nm_supplier, 
					  c.kd_brg, c.nm_brg, c.kd_satuan_terkecil as kd_satuan, d.jml_satuan, e.price, e.seri_barang, a.kd_valuta,
					  f.nama as nama_gudang, g.uraian_negara as negara_asal
					  FROM tpb_hdr a 
					  INNER JOIN tpb_dtl e ON a.id = e.id_hdr 
					  LEFT JOIN reff_supplier b ON b.kd_supplier = a.partner_id
					  LEFT JOIN tm_barang c ON e.id_barang = c.id 
					  LEFT JOIN tr_inout d ON a.id = d.id_hdr AND e.id = d.id_dtl AND c.id = d.id_brg
					  LEFT JOIN tm_warehouse f on f.id = d.id_gudang
					  LEFT JOIN reff_negara g on g.kd_negara = e.kd_negara_asal
					  WHERE a.kode_trader = ".$KODE_TRADER." 
					  AND a.status = 'R'";
			if ($date_type == "1") {
				$query .= " AND DATE_FORMAT(a.tgl_realisasi, '%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir);
			} elseif ($date_type == "2") {
				$query .= " AND a.tgl_daftar BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir);
			}

			if ($no_aju) {
				if ($no_bc == "1") {
					$query .= " AND a.nomor_aju = ".$this->db->escape(trim($no_aju));
				} elseif ($no_bc == "2") {
					$query .= " AND a.no_daftar = ".$this->db->escape(trim($no_aju));
				} elseif ($no_bc == "3") {
					$query .= " AND a.no_inout = ".$this->db->escape(trim($no_aju));
				}
			}

			if ($kd_dok) $query .= " AND a.jns_dokumen = ".$this->db->escape(trim($kd_dok));
			if ($asal_barang) $query .= " AND e.asal_barang = ".$this->db->escape(trim($asal_barang));

			if (in_array($tipe, array("pemasukan","pemasukan_bb"))) { 
				$query .= " AND d.tipe = 'GATE-IN'";
			} else {
				$query .= " AND d.tipe = 'GATE-OUT'";
			}

			$query .= " ORDER BY a.tgl_inout, e.seri_barang ASC";

			return $query;
		} elseif ($tipe == "pemakaian_bb") {
			$query = "SELECT no_inout, kd_brg, nm_brg, kd_satuan, jml_satuan, jns_dokumen, partner,
					  DATE_FORMAT(tgl_inout, '%d %M %Y') as tgl_inout
					  FROM laporan
					  WHERE kode_trader = ".$KODE_TRADER." 
					  AND (
						  (tipe='PROCESS_IN' AND jns_brg='1' and jenis_produksi='RM') 
						  OR (tipe='GATE-OUT' AND jns_brg='1' AND jns_dokumen='SUBKONTRAK')
						)
					  AND DATE_FORMAT(tgl_realisasi, '%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir);
			if ($no_aju) {
				if ($no_bc == "1") {
					$query .= " AND no_inout = ".$this->db->escape(trim($no_aju));
				} elseif ($no_bc == "2") {
					$query .= " AND kd_brg = ".$this->db->escape(trim($no_aju));
				}
			}
			$query .= " ORDER BY tgl_inout DESC";
			return $query;
		} elseif ($tipe == "pemakaian_subkon") {
			$query = "SELECT no_inout, kd_brg, nm_brg, kd_satuan, partner, jml_satuan, 
					  DATE_FORMAT(tgl_inout, '%d %M %Y') as tgl_inout
					  FROM laporan
					  WHERE kode_trader = ".$KODE_TRADER." 
					  AND tipe='GATE-OUT' 
					  AND jns_dokumen='SUBKONTRAK'
					  AND DATE_FORMAT(tgl_realisasi, '%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir);
			if ($no_aju) {
				if ($no_bc == "1") {
					$query .= " AND no_inout = ".$this->db->escape(trim($no_aju));
				} elseif ($no_bc == "2") {
					$query .= " AND kd_brg = ".$this->db->escape(trim($no_aju));
				}
			}
			$query .= " ORDER BY tgl_inout DESC";
			return $query;
		} elseif ($tipe == "pemasukan_hp") {
			$query = "SELECT no_inout, kd_brg, nm_brg, kd_satuan, jml_satuan, jns_dokumen, partner,
					  DATE_FORMAT(tgl_inout, '%d %M %Y') as tgl_inout, nama_gudang
					  FROM laporan 
					  WHERE kode_trader = ".$KODE_TRADER." 
					  AND (
						(tipe='PROCESS_OUT' AND jns_brg='6' and jenis_produksi='FG') 
						OR (tipe='GATE-IN' AND jns_brg='6' AND jns_dokumen='SUBKONTRAK')
						)
					  AND DATE_FORMAT(tgl_realisasi, '%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir);
			if ($no_aju) {
				if ($no_bc == "1") {
					$query .= " AND no_inout = ".$this->db->escape(trim($no_aju));
				} elseif ($no_bc == "2") {
					$query .= " AND kd_brg = ".$this->db->escape(trim($no_aju));
				}
			}
			$query .= " ORDER BY tgl_inout DESC";
			return $query;
		} elseif ($tipe == "mutasi") {
			$query = "SELECT kd_brg, jns_brg, nm_brg, kd_satuan_terkecil, id_barang
					  FROM laporan_mutasi
					  WHERE jns_brg = ".$this->db->escape($jns_brg)." 
					  AND DATE_FORMAT(tgl_realisasi, '%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir)."
					  GROUP BY id_barang";
			return $query;
		} elseif ($tipe == "penyelesaian_waste") {
			$query = "SELECT a.no_daftar, a.tgl_daftar, c.kd_brg, c.nm_brg, c.kd_satuan_terkecil as kd_satuan, d.jml_satuan, b.price
					  FROM tpb_hdr a 
					  INNER JOIN tpb_dtl b ON a.id = b.id_hdr 
					  LEFT JOIN tm_barang c ON c.id = b.id_barang 
					  LEFT JOIN tr_inout d ON a.id = d.id_hdr AND c.id = d.id_dtl AND c.id = d.id_brg
					  WHERE a.kode_trader = ".$KODE_TRADER." 
					  AND a.status = 'R'
					  AND DATE_FORMAT(a.tgl_realisasi, '%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir)." 
					  AND a.jns_dokumen = '24'";
			return $query;
		}
	}

	function getTglStockView($tgl_awal, $tgl_akhir) {
		$KODE_TRADER = $this->session->userdata('KODE_TRADER');
        $query = "SELECT DATE_FORMAT(TGL_STOCK, '%Y-%m-%d') AS tgl_stock 
				  FROM tm_stockopname 
				  WHERE KODE_TRADER = ".$KODE_TRADER;
		if ($tgl_awal) {
			$query .= " AND DATE_FORMAT(TGL_STOCK, '%Y-%m-%d') BETWEEN ".$this->db->escape($tgl_awal)." AND ".$this->db->escape($tgl_akhir);
		} else {
			$query .= " AND DATE_FORMAT(TGL_STOCK, '%Y-%m-%d') = ".$this->db->escape($tgl_akhir);
		}
		$query .= " ORDER BY DATE_FORMAT(TGL_STOCK, '%Y-%m-%d') DESC LIMIT 1";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0) {
			$data = $result->row();
			return $data->tgl_stock;
		} else {
			return false;
		}
	}
}