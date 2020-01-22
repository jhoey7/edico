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
}
