<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Berita extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_berita');
    }

    public function index_get()
    {
        $id = $this->get("id_berita");

        if ($id != null) {
            $where = array('ID_PENGUMUMAN' => $id, );
            $berita = $this->M_berita->detail_data($where, 'pengumuman');
        }else{
            $berita = $this->M_berita->get_all_pengumuman();
        }

        if ($berita) {
            $this->response([
                'status' => true,
                'data' => $berita
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function poster_get()
    {
        $poster = $this->M_berita->get_all_poster();

        if ($poster) {
            $this->response([
                'status' => true,
                'data' => $poster
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
}