<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Garda extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_TemplateGarda');
    }

    public function filterKlaim_get()
    {
        $nrp = $this->get("nrp");
		$iw = $this->get('select');
		$dari = date('Y-m-d', strtotime($this->get('dari')));
		$sampai = date('Y-m-d', strtotime($this->get('sampai')));
		$where = array('' => '', );
		if ($iw == 'semua') {
			$where = array('EMP_ID' => $nrp, );
		}else{
			$where = array('EMP_ID' => $nrp, 'MEMBERSHIP' => $iw );
		}
        
        $hasil = $this->M_TemplateGarda->data_garda($where, 'tamplate_garda', $dari, $sampai);
        
        if ($hasil) {
            $data = array(
                'PATIENT_NAME' => $hasil[0]->PATIENT_NAME, 
                'MEMBERSHIP' => $hasil[0]->MEMBERSHIP, 
                'DIAGNOSIS' => $hasil[0]->DIAGNOSIS, 
                'TREATMENT_PLACE' => $hasil[0]->TREATMENT_PLACE, 
                'SUM_OF_ACCEPTED' => $hasil[0]->SUM_OF_ACCEPTED
            );

            $this->response([
                'status' => true,
                'nrp' => $nrp,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => "data not found"
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    public function klaimGarda_get()
    {
        $id = $this->get("nrp");

        $employee_disetujuhi = $this->M_TemplateGarda->sum_employee_accept($id);
        $family_disetujuhi = $this->M_TemplateGarda->sum_family_accept($id);
        
        $this->response([
            'status' => true,
            'nrp' => $id,
            'employee_disetujuhi' => $employee_disetujuhi[0]->N,
            'family_disetujuhi' => $family_disetujuhi[0]->N
        ], REST_Controller::HTTP_OK);
    }
    
}