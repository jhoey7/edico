<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
class Users extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load User Model
        $this->load->model('m_api', 'model');
        header("Access-Control-Allow-Origin: *");
    }

    /**
     * User Login API
     * --------------------
     * @param: email
     * @param: password
     * --------------------------
     * @method : POST
     * @link: api/user/login
     */
    public function login_post() {
        # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
        $_POST = $this->security->xss_clean($_POST);
        $headers = $this->input->request_headers();

        if ($headers['Content-Type'] != "application/json") {
            $message = array(
                'status'=> false,
                'message'=> 'Request header must set to Content-Type: application/json'
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } elseif (empty($this->post('email')) || empty($this->post('password'))) {
            $message = array(
                'status'=> false,
                'message'=> 'email dan password wajib diisi.'
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            // Load Login Function
            $output = $this->model->user_login($this->post('email'), $this->post('password'));
            if (!empty($output) AND $output != FALSE) {
                // Load Authorization Token Library

                if ($output->status != "1") {
                    $message = [
                        'status' => FALSE,
                        'message' => "Status perusahaan tidak aktif"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                } elseif ($output->status_user != "1") {
                    $message = [
                        'status' => FALSE,
                        'message' => "Status user tidak aktif"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                } else {

                    $this->load->library('Authorization_Token');

                    // Generate Token
                    $token_data['id'] = $output->id;
                    $token_data['kode_trader'] = $output->kode_trader;
                    $token_data['metode_real'] = $output->tipe_dokumen;
                    $token_data['fas_comp'] = $output->fasilitas_perusahaan;
                    $token_data['show_aju'] = $output->show_aju;
                    $token_data['time'] = time();

                    $user_token = $this->authorization_token->generateToken($token_data);

                    $return_data = [
                        'token' => $user_token,
                    ];

                    // Login Success
                    $message = [
                        'status' => true,
                        'data' => $return_data,
                        'message' => "User login successful"
                    ];
                    $this->db->where(array("id"=>$output->id));
                    $this->db->update('tm_user', array('token'=>$user_token,'expired'=>date('Y-m-d H:i:s', $token_data['time'])));
                    $this->response($message, REST_Controller::HTTP_OK);
                }
            } else {
                // Login Error
                $message = [
                    'status' => FALSE,
                    'message' => "Invalid email or password"
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}