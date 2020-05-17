<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Mcu extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_portal');
    }

    public function dataKesehatan_get()
    {
        $id = $this->get("nrp");
        $where = array('ID_EMPLOYEE' => $id, );
        
        $dkt = $this->M_portal->detail_mcu_terbaru($where, "template_mcu_master");
        $dkt2 = $this->M_portal->detail_mcu_terbaru($where, "template_mcu_master2");
        // var_dump($dkt2);

        if ($dkt) {
            $data = array(
                'fitness_status' => $dkt2[0]->FITNESS_STATUS,
                'saran' => $dkt2[0]->SARAN,
                'kolesterol' => $dkt[0]->KOLESTEROL_TOTAL,
                'tekanan_darah' => $dkt[0]->TEKANAN_DARAH,
                'gula_darah' => $dkt[0]->GLUKOSA_PUASA, 
                'asam_urat' => $dkt[0]->ASAM_URAT
            );

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

    public function historisTekananDarah_get()
    {
        $dari = date("Y-m-d", strtotime($this->get("dari")));
        $sampai = date("Y-m-d", strtotime($this->get("sampai")));
        $id = $this->get("nrp");

		$where = array('ID_EMPLOYEE' => $id, 'TGL_KUNJUNGAN >=' => $dari, 'TGL_KUNJUNGAN <=' => $sampai);
        $data = $this->M_portal->historis_tekanan_darah($where, "template_mcu_master");
        
        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data not found"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function historisKolesterol_get()
    {
        $dari = date("Y-m-d", strtotime($this->get("dari")));
        $sampai = date("Y-m-d", strtotime($this->get("sampai")));
        $id = $this->get("nrp");

		$where = array('ID_EMPLOYEE' => $id, 'TGL_KUNJUNGAN >=' => $dari, 'TGL_KUNJUNGAN <=' => $sampai);
        $data = $this->M_portal->historis_kolesterol($where, "template_mcu_master");
        
        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data not found"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function historisGulaDarah_get()
    {
        $dari = date("Y-m-d", strtotime($this->get("dari")));
        $sampai = date("Y-m-d", strtotime($this->get("sampai")));
        $id = $this->get("nrp");

		$where = array('ID_EMPLOYEE' => $id, 'TGL_KUNJUNGAN >=' => $dari, 'TGL_KUNJUNGAN <=' => $sampai);
        $data = $this->M_portal->historis_gula_darah($where, "template_mcu_master");
        
        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data not found"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
}