<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Kuesioner extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kuesioner');
    }

    public function index_get()
    {
        $id = $this->get("nrp");
        $wkp = array('kuisioner_kelelahan.ID_PEGAWAI' => $id, 'TANGGAL' => date('Y-m-d') );
		$kf = $this->M_kuesioner->detail_data($wkp, 'kuisioner_kelelahan');
        
        if ($kf) {
            $this->response([
                'status' => true,
                'data' => $kf
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "belum mengisi kuesioner"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $id = $this->post("nrp");
        $q1 = $this->post('q1');
		$q2 = $this->post('q2');
		$q3 = $this->post('q3');
		$q4 = $this->post('q4');
		$nilai = $q1 + $q2 + $q3 + $q4;

		$data = array(
			'ID_PEGAWAI' => $id, 
			'TANGGAL' => date('Y-m-d'),
			'Q1' => $q1,
			'Q2' => $q2,
			'Q3' => $q3,
			'Q4' => $q4,
			'NILAI' => $nilai, 
		);

        $kf = $this->M_kuesioner->insert($data, 'kuisioner_kelelahan');
        
        if ($kf) {
            $this->response([
                'status' => true,
                'message' => "success"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "failed"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function numKelelahan_get()
    {
        $where = array('TANGGAL' => date('Y-m-d'), 'NILAI >' => "8" );
        $data = $this->M_kuesioner->detail_data($where, 'kuisioner_kelelahan');
        
        $this->response([
            'status' => true,
            'jumlah_kelelahan' => count($data)
        ], REST_Controller::HTTP_OK);
        
    }
    
}