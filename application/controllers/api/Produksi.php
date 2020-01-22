<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
class Produksi extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        $this->load->model('m_api', 'model');
    }


    /**
     * Add New Produksi with API
     * -------------------------
     * @method: POST
     */
    public function realisasi_post() {
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

            $checkProduksi = $this->model->check_data_tpb($this->post('tipe_file'), $this->post('nomor_dok_internal'), $this->post('tanggal_dok_internal'), $is_valid_token['data']->kode_trader);


            $error = 0;

            if ($headers['Content-Type'] != "application/json") {
                $message['content_type'] = 'Request header must set to Content-Type: application/json';
                $error += 1;
            } 

            if ($checkProduksi) {
                $message['data_exist'] = "Nomor & Tanggal Produksi sudah ada.";
                $error += 1;
            }

            if (!in_array($this->post('tipe_file'), array("FG","RM","SCRAP","HALF"))) {
                $message['tipe_file'] = "Tipe file tidak di kenali";
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

            $details = $this->post('details');
            for ($i=0; $i < count($details); $i++) {
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

                if(empty($details[$i]['kode_gudang'])) {
                    $message['kode_gudang_'.$i] = "Kode gudang harus diisi";
                    $error += 1;
                }
            }

            if ($error > 0) {
                $this->model->save_log($message, $this->post());
                $this->response(['status' => FALSE, 'message' => $message ], REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $arrdata['tipe_file'] = $this->post('tipe_file');
                $arrdata['nomor_dok_internal'] = $this->post('nomor_dok_internal');
                $arrdata['tanggal_dok_internal'] = $this->post('tanggal_dok_internal');
                $arrdata['file_name'] = $this->post('file_name');
                $arrdata['kode_trader'] = $is_valid_token['data']->kode_trader;
                $arrdata['created_by'] = $is_valid_token['data']->id;
                $id_hdr = $this->model->save('t_temp_services_hdr', $arrdata, 'single');

                $details = $this->post('details');
                for ($i=0; $i < count($details); $i++) { 
                    $data_detail[$i]['kode_barang'] = $details[$i]['kode_barang'];
                    $data_detail[$i]['jenis_barang'] = $details[$i]['jenis_barang'];
                    $data_detail[$i]['uraian_barang'] = $details[$i]['uraian_barang'];
                    $data_detail[$i]['kode_satuan'] = $details[$i]['kode_satuan'];
                    $data_detail[$i]['jumlah_satuan'] = $details[$i]['jumlah_satuan'];
                    $data_detail[$i]['kode_gudang'] = $details[$i]['kode_gudang'];
                    $data_detail[$i]['kode_hs'] = $details[$i]['kode_hs'];
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

}