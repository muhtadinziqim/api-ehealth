<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Pannic extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_pannic_button");
        $this->load->model("M_panic_button");
    }

    public function index_post()
    {
        $lat = $this->post('lat');
        $lon = $this->post('lon');
        $waktu = date("Y-m-d H:i:s");
        $id_pegawai = $this->post("nrp");

        $data = array(
                'LATITUDE' => $lat,
                'LONGITUDE' => $lon,
                'WAKTU' => $waktu,
                'ID_PEGAWAI' => $id_pegawai
            );
        
        $dt = $this->M_pannic_button->insert($data, "panic_button");

        if ($dt) {
            $this->response([
                'status' => true,
                'message' => "sukses"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "gagal"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function numInsidenInYear_get()
    {
        $wp = array('WAKTU >=' => date("Y"), );
        $data = $this->M_panic_button->detail_data($wp, 'panic_button');
        
        if ($data) {
            $this->response([
                'status' => true,
                'jumlah_insiden' => count($data)
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_get()
    {
        $tahun = $this->get("year");

        if ($tahun) {
            $wp = array('WAKTU' => 'year('.$tahun.')', );
            $data = $this->M_panic_button->detail_data($wp, 'panic_button');
        }else{
            $data = $this->M_panic_button->get_all('panic_button');
        }
        
        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data not found"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
}