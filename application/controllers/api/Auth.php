<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Auth extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth');
    }

    public function admin_get()
    {
        $username = $this->get('username');
        $password = $this->get('password');
        
        $w_admin = array(
			'USERNAME' => $username,
			'PASSWORD' => md5($password)
        );
        
        $data = $this->M_auth->detail_data($w_admin, 'admin');

        if ($data) {
            $this->response([
                'status' => true,
                'message' => "berhasil login"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "login gagal"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    public function dokter_get()
    {
        $username = $this->get('username');
        $password = $this->get('password');
        
        $w_dokter = array(
			'USERNAME' => $username,
			'PASSWORD' => md5($password)
        );
        
        $data = $this->M_auth->detail_data($w_dokter, 'dokter');

        if ($data) {
            $this->response([
                'status' => true,
                'message' => "berhasil login",
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "login gagal"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_get()
    {
        $username = $this->get('username');
        $password = $this->get('password');
		$w_karyawan = array(
			'USERNAME' => $username,
			'PASSWORD' => ($password)
		);
		$w_admin = array(
			'USERNAME' => $username,
			'PASSWORD' => md5($password)
		);
		$w_dokter = array(
			'USERNAME' => $username,
			'PASSWORD' => md5($password)
		);
		$cek_karyawan = $this->M_auth->detail_data($w_karyawan, 'pegawai');
		// $cek_karyawan = $this->httpGet("http://webportal.patria.co.id:24000/apisunfish/autentikasi.php?username=".$username."&password=".$password);
		$cek_admin = $this->M_auth->detail_data($w_admin, 'admin');
		$cek_dokter = $this->M_auth->detail_data($w_dokter, 'dokter');
		// $cek = strlen($cek_karyawan);
		$c_admin = count($cek_admin);
		// var_dump("http://webportal.patria.co.id/apisunfish/autentikasi.php?username=".$username."&password=".$password);
		// var_dump($cek_karyawan);
		// var_dump($c_admin);
		// var_dump($cek_dokter);
		// var_dump($cek);
		// if($cek == 9){
		if($cek_karyawan != null){
            
		    $w = array('NRP' => $username, );
		    $detail_karyawan = $this->M_auth->detail_data($w, 'pegawai');
			$data_session = array(
				'nama' => $detail_karyawan[0]->NAMA_KARYAWAN,
				'status' => "pegawai",
				'id_pegawai' => $username,
				'poin' => $detail_karyawan[0]->POIN,
				// 'nama' => "nama",
				// 'status' => "pegawai",
				// 'id_pegawai' => $username
            );
            $this->response([
                'status' => true,
                'message' => "berhasil login",
                'data' => $data_session
            ], REST_Controller::HTTP_OK);
		}else if($c_admin > 0){
			var_dump("apakah disini");
			foreach ($cek_admin as $s) {
				$data_session = array(
					'status' => "admin",
					'nama' => $s->NAMA
                );
                $this->response([
                    'status' => true,
                    'message' => "berhasil login",
                    'data' => $data_session
                ], REST_Controller::HTTP_OK);
			}
		}else if ($cek_dokter != NULL) {
			foreach ($cek_dokter as $key) {
				$data_session = array(
					'nama' => $key->NAMA,
					'status' => 'dokter', 
					'id_dokter' => $key->ID_DOKTER,
                );
                $this->response([
                    'status' => true,
                    'message' => "berhasil login",
                    'data' => $data_session
                ], REST_Controller::HTTP_OK);
			}
		}else{
            $this->response([
                'status' => false,
                'message' => "login gagal"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function httpGet($url){
	    // persiapkan curl
		$ch = curl_init(); 

	    // set url 
		curl_setopt($ch, CURLOPT_URL, $url);

	    // set user agent    
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

	    // return the transfer as a string 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	    // $output contains the output string 
		$output = curl_exec($ch); 

	    // tutup curl 
		curl_close($ch);      

	    // mengembalikan hasil curl
		return $output;
	}
    
}