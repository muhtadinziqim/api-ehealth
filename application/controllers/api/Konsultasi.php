<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Konsultasi extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_konsultasi');
    }

    function janji_get()
    {
        $id_pegawai = $this->get("nrp");

        $id_janji = $this->get("id_janji");

        $id_dokter = $this->get("id_dokter");

        if ($id_janji == null) {
            if ($id_pegawai != null) {
                $janji_konsultasi =  $this->M_konsultasi->get_all_pegawai($id_pegawai, "janji_konsultasi");
            }else if($id_dokter != null) {
                $janji_konsultasi = $this->M_konsultasi->get_all_dokter($id_dokter, "janji_konsultasi");
            }
        }else{
            $where = array('ID_JANJI_KONSULTASI' => $id_janji, );
            $janji_konsultasi = $this->M_konsultasi->detail_konsultasi($where, "janji_konsultasi");
        }
        

        if ($janji_konsultasi) {
            $this->response([
                'status' => true,
                'data' => $janji_konsultasi
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function janjiKaryawan_post()
    {
        $data = [
            "ID_DOKTER" => $this->post('id_dokter'),
            "ID_PEGAWAI" => $this->post('nrp'),
            "NAMA_KARYAWAN" => $this->post('nama_karyawan'),
            "TANGGAL" => date("Y-m-d", strtotime($this->post('tanggal'))),
            "JAM_MULAI" => $this->post('jam_mulai'),
            "JAM_SELESAI" => $this->post('jam_selesai'),
            "TEMPAT" => $this->post('tempat'),
            "STATUS_DOKTER" => "Penjadwalan Baru",
            "STATUS_KARYAWAN" => "Menunggu Persetujuan",
            "STATUS" => 0
        ];

        $janji = $this->M_konsultasi->insert($data, "janji_konsultasi");

        if ($janji) {
            $this->response([
                'status' => true,
                'message' => "Data berhasil ditambahkan"
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => "Data gagal ditambahkan"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function janjiDokter_post()
    {
        $data = [
            "ID_DOKTER" => $this->post('id_dokter'),
            "ID_PEGAWAI" => $this->post('nrp'),
            "NAMA_KARYAWAN" => $this->post('nama_karyawan'),
            "TANGGAL" => date("Y-m-d", strtotime($this->post('tanggal'))),
            "JAM_MULAI" => $this->post('jam_mulai'),
            "JAM_SELESAI" => $this->post('jam_selesai'),
            "TEMPAT" => $this->post('tempat'),
            "STATUS_DOKTER" => "Menunggu Persetujuan",
            "STATUS_KARYAWAN" => "Penjadwalan Baru",
            "STATUS" => 0
        ];

        $janji = $this->M_konsultasi->insert($data, "janji_konsultasi");

        if ($janji) {
            $this->response([
                'status' => true,
                'message' => "Data berhasil ditambahkan"
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => "Data gagal ditambahkan"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function janjiKaryawan_put()
    {
        $id = $this->put("id_janji");
        $where = array('ID_JANJI_KONSULTASI' => $id, );

        $data = [
            'TANGGAL' => date('Y-m-d', strtotime($this->put("tanggal"))),
			'JAM_MULAI' => $this->put("jam_mulai"),
			'JAM_SELESAI' => $this->put("jam_selesai"),
			'STATUS_DOKTER' => "Penjadwalan Ulang",
			'STATUS_KARYAWAN' => "Menunggu Persetujuan"
        ];

        $janji = $this->M_konsultasi->update_data($where, $data, "janji_konsultasi");

        if ($janji) {
            $this->response([
                'status' => true,
                'message' => "Data berhasil dirubah"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "Data gagal dirubah"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function janjiDokter_put()
    {
        $id = $this->put("id_janji");
        $where = array('ID_JANJI_KONSULTASI' => $id, );

        $data = [
            'TANGGAL' => date('Y-m-d', strtotime($this->put("tanggal"))),
			'JAM_MULAI' => $this->put("jam_mulai"),
			'JAM_SELESAI' => $this->put("jam_selesai"),
			'STATUS_DOKTER' => "Menunggu Persetujuan",
			'STATUS_KARYAWAN' => "Penjadwalan Ulang"
        ];

        $janji = $this->M_konsultasi->update_data($where, $data, "janji_konsultasi");

        if ($janji) {
            $this->response([
                'status' => true,
                'message' => "Data berhasil dirubah"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "Data gagal dirubah"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function janjiKaryawan_delete()
    {
        $id = $this->delete("id_janji");
        $where = array('ID_JANJI_KONSULTASI' => $id, );

        $janji  = $this->M_konsultasi->delete($where, "janji_konsultasi");
        
        // var_dump($janji);

        if ($janji) {
            $this->response([
                'status' => true,
                'message' => "Data berhasil dihapus"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "Data gagal dihapus"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function konfirmasiPegawai_put()
    {
        $id_janji = $this->put("id_janji");

        $where = array('ID_JANJI_KONSULTASI' => $id_janji, );

        $data = [
            'STATUS_DOKTER' => "Disetujuhi",
            'STATUS_KARYAWAN' => "Disetujuhi"
        ];

        $janji = $this->M_konsultasi->update_data($where, $data, "janji_konsultasi");

        if ($janji) {
            $this->response([
                'status' => true,
                'message' => "Data berhasil dirubah"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "Data gagal dirubah"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function konfirmasiDokter_put()
    {
        $id_janji = $this->put("id_janji");

        $where = array('ID_JANJI_KONSULTASI' => $id_janji, );

        $data = [
			'STATUS_DOKTER' => "Disetujuhi",
            'STATUS_KARYAWAN' => "Disetujuhi"
        ];

        $janji = $this->M_konsultasi->update_data($where, $data, "janji_konsultasi");

        if ($janji) {
            $this->response([
                'status' => true,
                'message' => "Data berhasil dirubah"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "Data gagal dirubah"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function riwayat_get()
    {
        $id_pegawai = $this->get("nrp");

        $id_riwayat = $this->get("id_riwayat");

        $id_dokter = $this->get("id_dokter");

        if ($id_riwayat == null) {
            if ($id_pegawai != null) {
                $riwayat = $this->M_konsultasi->get_all_pegawai($id_pegawai, "riwayat_konsultasi");
            }else if ($id_dokter != null) {
                $riwayat = $this->M_konsultasi->get_all_dokter($id_dokter, "riwayat_konsultasi");
            }
        }else{
            $where = array('ID_RIWAYAT_KONSULTASI' => $id_riwayat, );
            $riwayat = $this->M_konsultasi->detail_riwayat($where, 'riwayat_konsultasi');
        }


        if ($riwayat) {
            $this->response([
                'status' => true,
                'data' => $riwayat
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data tidak ada"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function addNote_post()
    {
        $id = $this->post("id_janji");
        $where = array('ID_JANJI_KONSULTASI' => $id, );
		$data = array('STATUS' => 1, );
        $this->M_konsultasi->update_data($where, $data, "janji_konsultasi");
        
        $data2 = array(
			'ID_JANJI_KONSULTASI' => $id,
			'KONDISI'             => $this->post('kondisi'),
			'CATATAN'             => $this->post('catatan') 
		);
        $note = $this->M_konsultasi->insert($data2, "riwayat_konsultasi");
        
        if ($note) {
            $this->response([
                'status' => true,
                'message' => "Data berhasil ditambah"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "Data gagal didatmbah"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
}