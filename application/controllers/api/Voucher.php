<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Voucher extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_voucher');
    }

    public function index_get()
    {

        $voucher = $this->M_voucher->get_all("voucher");

        if ($voucher) {
            $this->response([
                'status' => true,
                'data' => $voucher
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function saya_get()
    {
        $w_karyawan2 = array('klaim_voucher.ID_PEGAWAI' => $this->get("nrp"), );
        $voucher = $this->M_voucher->get_voucher_saya($w_karyawan2);

        if ($voucher) {
            $this->response([
                'status' => true,
                'data' => $voucher
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function reedem_post()
    {
        $id_voucher = $this->post("id_voucher");
        $id_pegawai = $this->post("nrp");

        $data = array(
			'ID_VOUCHER' => $id_voucher,
			'ID_PEGAWAI' => $id_pegawai,
			'TANGGAL_KLAIM' => date('Y-m-d'),
			'STATUS' => "Silahkan Verifikasi Ke - ESR" 
		);

		$klaim = $this->M_voucher->insert($data, 'klaim_voucher');

		$wvoucher = array('ID_VOUCHER' => $id_voucher, );
		$data_voucher = $this->M_voucher->detail_data($wvoucher, "voucher");
		$where = array('NRP' => $id_pegawai, );
		$data_pegawai = $this->M_voucher->detail_data($where, "pegawai");
		$cur_poin = $data_pegawai[0]->POIN;
		$poin_redem = $data_voucher[0]->POIN;
		$poin_now = $cur_poin - $poin_redem;

		$data2 = array('POIN' => $poin_now, );
        $this->M_voucher->update_data($where, $data2, "pegawai");
        
        if ($klaim) {
            $this->response([
                'status' => true,
                'message' => "reedem sukses"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "reedem gagal"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
}