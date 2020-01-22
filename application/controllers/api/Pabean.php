<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
class Pabean extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        $this->load->model('m_api', 'model');
    }

    /**
     * Add new Pabean Full Element with API
     * -------------------------
     * @method: POST
     */
    public function realisasi_with_full_element_post() {
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE) {
            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            $headers = $this->input->request_headers();

            $checkTPB = $this->model->check_data_tpb($this->post('tipe_file'), $this->post('nomor_dok_internal'), $this->post('tanggal_dok_internal'), $is_valid_token['data']->kode_trader);

            $error = 0;


            if ($is_valid_token['data']->fas_comp == "3" OR $is_valid_token['data']->fas_comp == "4") {
                if ($this->post('tipe_file') == "IN") {
                    $dok_pabean = array("20","LOKAL","25");
                } else {
                    $dok_pabean = array("30","LOKAL");
                }
            }

            if ($headers['Content-Type'] != "application/json") {
                $message['content_type'] = 'Request header must set to Content-Type: application/json';
                $error += 1;
            } 

            if ($checkTPB) {
                $message['data_exist'] = "Nomor & Tanggal Dokumen Internal sudah ada.";
                $error += 1;
            }

            if (!in_array($this->post('tipe_file'), array("IN","OUT"))) {
                $message['tipe_file'] = "Tipe file tidak di kenali";
                $error += 1;
            } 

            if (!in_array($this->post('kode_dokumen'), $dok_pabean) && !empty($this->post('kode_dokumen'))) {
                $message['kode_dokumen'] = "Kode dokumen tidak di kenali";
                $error += 1;
            } 

            if(empty($this->post('nomor_aju'))) {
                $message['nomor_aju'] = "Nomor Aju harus diisi";
                $error += 1;
            } 

            if (empty($this->post('nomor_daftar'))) {
                $message['nomor_daftar'] = "Nomor Daftar harus diisi";
                $error += 1;
            } 

            if (empty($this->post('tanggal_daftar'))) {
                $message['tanggal_daftar'] = "Tanggal Daftar harus diisi";
                $error += 1;
            } 

            if (empty($this->post('nomor_dok_internal'))) {
                $message['nomor_dok_internal'] = "Nomor Dokumen Internal harus diisi";
                $error += 1;
            } 

            if (empty($this->post('tanggal_dok_internal'))) {
                $message['tanggal_dok_internal'] = "Tanggal Dokumen Internal harus diisi";
                $error += 1;
            } 

            if ($this->post('tipe_file') == "IN" AND empty($this->post('id_vendor')) AND empty($this->post('nama_vendor'))) {
                $message['vendor'] = "ID/Nama Vendor harus diisi";
                $error += 1;
            } 

            if ($this->post('tipe_file') == "OUT" AND empty($this->post('id_customer')) AND empty($this->post('nama_customer'))) {
                $message['customer'] = "ID/Nama Customer harus diisi";
                $error += 1;
            } 

            if (empty($this->post('kode_valuta'))) {
                $message['kode_valuta'] = "Kode valuta harus diisi";
                $error += 1;
            } 

            if (empty($this->post('kurs')) && !is_numeric($this->post('kurs'))) {
                $message['kurs'] = "Kurs harus diisi & berisi numeric";
                $error += 1;
            } 

            $details = $this->post('details');
            for ($i=0; $i < count($details); $i++) {
                if (empty($details[$i]['seri_barang'])) {
                    $message['seri_barang_'.$i] = "Seri barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kode_barang'])) {
                    $message['kode_barang_'.$i] = "Kode barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['jenis_barang'])) {
                    $message['jenis_barang_'.$i] = "Jenis barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['uraian_barang'])) {
                    $message['uraian_barang_'.$i] = "Uraian barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kode_satuan'])) {
                    $message['kode_satuan_'.$i] = "Kode satuan harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['jumlah_satuan'])) {
                    $message['jumlah_satuan_'.$i] = "Jumlah satuan harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['harga_barang'])) {
                    $message['harga_barang_'.$i] = "Harga barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kode_gudang'])) {
                    $message['kode_gudang_'.$i] = "Kode gudang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kondisi_barang'])) {
                    $message['kondisi_barang_'.$i] = "Kondisi barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kode_negara'])) {
                    $message['kode_negara_'.$i] = "Kode negara harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['asal_barang'])) {
                    $message['asal_barang_'.$i] = "Asal barang harus diisi";
                    $error += 1;
                }
            }

            if ($error > 0) {
                $this->model->save_log($message, $this->post());
                $this->response(['status' => FALSE, 'message' => $message ], REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $arrdata['tipe_file'] = $this->post('tipe_file');
                $arrdata['kode_dokumen'] = $this->post('kode_dokumen');
                $arrdata['nomor_aju'] = $this->post('nomor_aju');
                $arrdata['nomor_daftar'] = $this->post('nomor_daftar');
                $arrdata['tanggal_daftar'] = $this->post('tanggal_daftar');
                $arrdata['nomor_dok_internal'] = $this->post('nomor_dok_internal');
                $arrdata['tanggal_dok_internal'] = $this->post('tanggal_dok_internal');
                $arrdata['id_vendor'] = $this->post('id_vendor');
                $arrdata['nama_vendor'] = $this->post('nama_vendor');
                $arrdata['id_customer'] = $this->post('id_customer');
                $arrdata['nama_customer'] = $this->post('nama_customer');
                $arrdata['kode_valuta'] = $this->post('kode_valuta');
                $arrdata['kurs'] = $this->post('kurs');
                $arrdata['file_name'] = $this->post('file_name');
                $arrdata['kode_trader'] = $is_valid_token['data']->kode_trader;
                $arrdata['created_by'] = $is_valid_token['data']->id;
                $id_hdr = $this->model->save('t_temp_services_hdr', $arrdata,'single');

                $details = $this->post('details');
                for ($i=0; $i < count($details); $i++) { 
                    $data_detail[$i]['seri_barang'] = $details[$i]['seri_barang'];
                    $data_detail[$i]['kode_barang'] = $details[$i]['kode_barang'];
                    $data_detail[$i]['jenis_barang'] = $details[$i]['jenis_barang'];
                    $data_detail[$i]['uraian_barang'] = $details[$i]['uraian_barang'];
                    $data_detail[$i]['kode_satuan'] = $details[$i]['kode_satuan'];
                    $data_detail[$i]['jumlah_satuan'] = $details[$i]['jumlah_satuan'];
                    $data_detail[$i]['harga_barang'] = $details[$i]['harga_barang'];
                    $data_detail[$i]['kode_gudang'] = $details[$i]['kode_gudang'];
                    $data_detail[$i]['kode_hs'] = $details[$i]['kode_hs'];
                    $data_detail[$i]['nomor_bl'] = $details[$i]['nomor_bl'];
                    $data_detail[$i]['kondisi_barang'] = $details[$i]['kondisi_barang'];
                    $data_detail[$i]['kode_negara'] = $details[$i]['kode_negara'];
                    $data_detail[$i]['asal_barang'] = $details[$i]['asal_barang'];
                    $data_detail[$i]['id_header'] = $id_hdr;
                }
                $this->model->save('t_temp_services_dtl', $data_detail,'batch');
                $this->response(['status' => TRUE, 'message' => "Data Berhasil Diinsert"], REST_Controller::HTTP_OK);
            }
        } else {
            $this->model->save_log($is_valid_token['message'], $is_valid_token);
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Add new Pabean with API
     * -------------------------
     * @method: POST
     */
    public function create_post() {
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE) {
            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            $headers = $this->input->request_headers();

            $checkTPB = $this->model->check_data_tpb($this->post('tipe_file'), $this->post('nomor_dok_internal'), $this->post('tanggal_dok_internal'), $is_valid_token['data']->kode_trader);

            $error = 0;


            if ($is_valid_token['data']->fas_comp == "3" OR $is_valid_token['data']->fas_comp == "4") {
                if ($this->post('tipe_file') == "IN") {
                    $dok_pabean = array("20","LOKAL","25");
                } else {
                    $dok_pabean = array("30","LOKAL");
                }
            }

            if ($headers['Content-Type'] != "application/json") {
                $message['content_type'] = 'Request header must set to Content-Type: application/json';
                $error += 1;
            } 

            if ($checkTPB) {
                $message['data_exist'] = "Nomor & Tanggal Dokumen Internal sudah ada.";
                $error += 1;
            }

            if (!in_array($this->post('tipe_file'), array("IN","OUT"))) {
                $message['tipe_file'] = "Tipe file tidak di kenali";
                $error += 1;
            } 

            if (!in_array($this->post('kode_dokumen'), $dok_pabean) && !empty($this->post('kode_dokumen'))) {
                $message['kode_dokumen'] = "Kode dokumen tidak di kenali";
                $error += 1;
            } 

            if(empty($this->post('nomor_aju'))) {
                $message['nomor_aju'] = "Nomor Aju harus diisi";
                $error += 1;
            } 

            if (empty($this->post('nomor_daftar'))) {
                $message['nomor_daftar'] = "Nomor Daftar harus diisi";
                $error += 1;
            } 

            if (empty($this->post('tanggal_daftar'))) {
                $message['tanggal_daftar'] = "Tanggal Daftar harus diisi";
                $error += 1;
            } 

            if (empty($this->post('nomor_dok_internal'))) {
                $message['nomor_dok_internal'] = "Nomor Dokumen Internal harus diisi";
                $error += 1;
            } 

            if (empty($this->post('tanggal_dok_internal'))) {
                $message['tanggal_dok_internal'] = "Tanggal Dokumen Internal harus diisi";
                $error += 1;
            } 

            if ($this->post('tipe_file') == "IN" AND empty($this->post('id_vendor')) AND empty($this->post('nama_vendor'))) {
                $message['vendor'] = "ID/Nama Vendor harus diisi";
                $error += 1;
            } 

            if ($this->post('tipe_file') == "OUT" AND empty($this->post('id_customer')) AND empty($this->post('nama_customer'))) {
                $message['customer'] = "ID/Nama Customer harus diisi";
                $error += 1;
            } 

            if (empty($this->post('kode_valuta'))) {
                $message['kode_valuta'] = "Kode valuta harus diisi";
                $error += 1;
            } 

            if (empty($this->post('kurs')) && !is_numeric($this->post('kurs'))) {
                $message['kurs'] = "Kurs harus diisi & berisi numeric";
                $error += 1;
            } 

            $details = $this->post('details');
            for ($i=0; $i < count($details); $i++) {
                if (empty($details[$i]['seri_barang'])) {
                    $message['seri_barang_'.$i] = "Seri barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kode_barang'])) {
                    $message['kode_barang_'.$i] = "Kode barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['jenis_barang'])) {
                    $message['jenis_barang_'.$i] = "Jenis barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['uraian_barang'])) {
                    $message['uraian_barang_'.$i] = "Uraian barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kode_satuan'])) {
                    $message['kode_satuan_'.$i] = "Kode satuan harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['jumlah_satuan'])) {
                    $message['jumlah_satuan_'.$i] = "Jumlah satuan harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['harga_barang'])) {
                    $message['harga_barang_'.$i] = "Harga barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kode_gudang'])) {
                    $message['kode_gudang_'.$i] = "Kode gudang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kondisi_barang'])) {
                    $message['kondisi_barang_'.$i] = "Kondisi barang harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['kode_negara'])) {
                    $message['kode_negara_'.$i] = "Kode negara harus diisi";
                    $error += 1;
                } 

                if(empty($details[$i]['asal_barang'])) {
                    $message['asal_barang_'.$i] = "Asal barang harus diisi";
                    $error += 1;
                }
            }

            if ($error > 0) {
                $this->model->save_log($message, $this->post());
                $this->response(['status' => FALSE, 'message' => $message ], REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $arrdata['tipe_file'] = $this->post('tipe_file');
                $arrdata['kode_dokumen'] = $this->post('kode_dokumen');
                $arrdata['nomor_aju'] = $this->post('nomor_aju');
                $arrdata['nomor_daftar'] = $this->post('nomor_daftar');
                $arrdata['tanggal_daftar'] = $this->post('tanggal_daftar');
                $arrdata['nomor_dok_internal'] = $this->post('nomor_dok_internal');
                $arrdata['tanggal_dok_internal'] = $this->post('tanggal_dok_internal');
                $arrdata['id_vendor'] = $this->post('id_vendor');
                $arrdata['nama_vendor'] = $this->post('nama_vendor');
                $arrdata['id_customer'] = $this->post('id_customer');
                $arrdata['nama_customer'] = $this->post('nama_customer');
                $arrdata['kode_valuta'] = $this->post('kode_valuta');
                $arrdata['kurs'] = $this->post('kurs');
                $arrdata['file_name'] = $this->post('file_name');
                $arrdata['kode_trader'] = $is_valid_token['data']->kode_trader;
                $arrdata['created_by'] = $is_valid_token['data']->id;
                $id_hdr = $this->model->save('t_temp_services_hdr', $arrdata,'single');

                $details = $this->post('details');
                for ($i=0; $i < count($details); $i++) { 
                    $data_detail[$i]['seri_barang'] = $details[$i]['seri_barang'];
                    $data_detail[$i]['kode_barang'] = $details[$i]['kode_barang'];
                    $data_detail[$i]['jenis_barang'] = $details[$i]['jenis_barang'];
                    $data_detail[$i]['uraian_barang'] = $details[$i]['uraian_barang'];
                    $data_detail[$i]['kode_satuan'] = $details[$i]['kode_satuan'];
                    $data_detail[$i]['jumlah_satuan'] = $details[$i]['jumlah_satuan'];
                    $data_detail[$i]['harga_barang'] = $details[$i]['harga_barang'];
                    $data_detail[$i]['kode_gudang'] = $details[$i]['kode_gudang'];
                    $data_detail[$i]['kode_hs'] = $details[$i]['kode_hs'];
                    $data_detail[$i]['nomor_bl'] = $details[$i]['nomor_bl'];
                    $data_detail[$i]['kondisi_barang'] = $details[$i]['kondisi_barang'];
                    $data_detail[$i]['kode_negara'] = $details[$i]['kode_negara'];
                    $data_detail[$i]['asal_barang'] = $details[$i]['asal_barang'];
                    $data_detail[$i]['id_header'] = $id_hdr;
                }
                $this->model->save('t_temp_services_dtl', $data_detail,'batch');
                $this->response(['status' => TRUE, 'message' => "Data Berhasil Diinsert"], REST_Controller::HTTP_OK);
            }
        } else {
            $this->model->save_log($is_valid_token['message'], $is_valid_token);
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    /**
     * Update Pabean with API
     * -------------------------
     * @method: PUT
     */
    public function update_put() {

    }
}