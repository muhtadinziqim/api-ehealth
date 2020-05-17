<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Event extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_event');
    }

    public function index_get()
    {
        $id = $this->get("id_event");

        if ($id != null) {
            $where = array('ID_EVENT' => $id, );
            $event = $this->M_event->detail_data($where, 'event');
        }else{
            $event = $this->M_event->get_all_event();
        }

        if ($event) {
            $this->response([
                'status' => true,
                'data' => $event
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function statusKehadiran_get()
    {
        $nrp = $this->get("nrp");
        $id_event = $this->get("id_event");
        $where = array('ID_EVENT' => $id_event, "NRP" => $nrp );

        $status = $this->M_event->detail_data($where, 'kehadiran_event');

        if ($status) {
            $this->response([
                'status' => true,
                'message' => "hadir"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "tidak ada data"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function kehadiran_post()
    {
        $data = [
            "NRP" => $this->post("nrp"),
            "ID_EVENT" => $this->post("id_event"),
            "TANGGAL_WAKTU" => date('Y-m-d H:i:s') 
        ];

        $where = array('NRP' => $this->post('nrp'), 'ID_EVENT' => $this->post('id_event'));
		$ava = $this->M_event->detail_data($where, 'kehadiran_event');

        if (count($ava) > 0) {
            $this->response([
                'status' => false,
                'message' => "id sudah melakukan absensi"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $status = $this->M_event->insert($data, 'kehadiran_event');

            // INPUT POIN
            $w = array('NRP' => $this->post('nrp'), );
            $w2 = array('ID_EVENT' => $this->post('id_event'), );
            $data_p = $this->M_event->detail_data($w, 'pegawai');
            $data_e = $this->M_event->detail_data($w2, 'event');
            $p_awal = $data_p[0]->POIN;
            $p_event = $data_e[0]->POIN;
            $p_now = $p_awal + $p_event;
            $dt = array('POIN' => $p_now, );
            $this->M_event->update_data($w, $dt, 'pegawai');
        }

        if ($status) {
            $this->response([
                'status' => true,
                'message' => "sukses melakukan absensi"
            ], REST_Controller::HTTP_OK);
        }
    }

    public function kehadiran_get()
    {
        $id = $this->get("id_event");
        $where = array('ID_EVENT' => $id, );

        $kehadiran = $this->M_event->get_daftar_hadir($where);

        if ($kehadiran) {
            $this->response([
                'status' => true,
                'data' => $kehadiran
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data not found"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
}