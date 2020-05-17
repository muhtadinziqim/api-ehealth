<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Pegawai extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
    }

    public function index_get()
    {
        $id = $this->get("nrp");

        if ($id != null) {
            $where = array('NRP' => $id );
            $data = $this->M_user->detail_data($where, "pegawai");
        }else{
            $data = $this->M_user->get_all2("pegawai");
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

    public function numEmployee_get()
    {
        $data = $this->M_user->get_jumlah_karyawan("jumlah_karyawan");

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

    public function numWorkingDay_get()
    {
        $data = $this->M_user->get_jumlah_hari_kerja("work_day");

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
    
    public function numSickEmployee_get()
    {
        $data = $this->M_user->get_sick_employee();

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
    
    public function numManDayLost_get()
    {
        $data = $this->M_user->get_man_day_lost();

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
    
    public function numFitStatus_get()
    {
        $data = $this->M_user->get_fitnes_status();

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