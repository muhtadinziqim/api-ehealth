<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Dokter extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
    }

    public function index_get()
    {
        $id = $this->get("id_dokter");

        if ($id != null) {
            $where = array('ID_DOKTER' => $id );
            $data = $this->M_user->detail_data($where, "dokter");
        }else{
            $data = $this->M_user->get_all("dokter");
        }

        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
}