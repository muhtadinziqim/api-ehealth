<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Poin extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_berita');
    }

    public function index_get()
    {
        $id = $this->get("nrp");

        $w = array('NRP' => $id, );
        $poin = $this->M_berita->detail_data($w, 'pegawai');
        
        if ($poin) {
            $this->response([
                'status' => true,
                'poin' => $poin[0]->POIN
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }
    
}