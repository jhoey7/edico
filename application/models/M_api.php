<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_api extends CI_Model
{
    /**
     * User Login
     * ----------------------------------
     * @param: email address
     * @param: password
     */
    public function user_login($email, $password) {
        $this->db->select("a.id, a.kode_trader, b.fasilitas_perusahaan, b.tipe_dokumen, b.status, a.status as status_user, a.password, b.show_aju");
        $this->db->from('tm_user a');
        $this->db->join('tm_perusahaan b', 'b.kode_trader = a.kode_trader', 'left');
        $this->db->where('a.email', $email);
        $q = $this->db->get();

        if( $q->num_rows() ) 
        {
            $user_pass = $q->row('password');
            if(password_verify($password, $user_pass)) {
                return $q->row();
            }
            return FALSE;
        }else{
            return FALSE;
        }
    }

    public function check_data_tpb($tipe_file, $no_dok_internal, $tgl_dok_internal, $kd_trader) {
        $this->db->select('nomor_dok_internal');
        $this->db->from('t_temp_services_hdr');
        $this->db->where(array('kode_trader'=> $kd_trader, 'tipe_file'=>$tipe_file, 'nomor_dok_internal'=>$no_dok_internal));
        $this->db->where('DATE_FORMAT(tanggal_dok_internal, "%Y-%m-%d") = ', $tgl_dok_internal, true);
        $q = $this->db->get();

        if ($q->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function save_log($message, $data) {
        $log['message'] = json_encode($message);
        $log['data'] = json_encode($data);
        $this->db->insert('t_temp_log_services', $log);
    }

    public function save($tbl, $data, $type) {
        if ($type == "batch") {
            $this->db->insert_batch($tbl, $data);
            return true;
        } else {
            $this->db->insert($tbl, $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function get_logbook_in($kode_trader) {
        $qry = "SELECT a.jns_dokumen as kode_dokumen, a.nomor_aju, a.no_daftar as nomor_daftar, a.tgl_daftar as tanggal_daftar, 
                c.kd_brg as kode_barang, c.jns_brg as jenis_barang, c.nm_brg as uraian_barang, c.kd_satuan_terkecil as kode_satuan, 
                b.saldo, d.jml_satuan 
                FROM tpb_hdr a 
                LEFT JOIN tr_inout d ON d.id_hdr = a.id 
                LEFT JOIN tr_logbook_in b on b.inout_id = d.id 
                LEFT JOIN tm_barang c ON d.id_brg = c.id 
                WHERE b.flag_tutup = 'N' AND b.saldo <> 0";
        $res = $this->db->query($qry);
        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return false;
        }
    }
}
