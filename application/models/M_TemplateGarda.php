<?php
class M_TemplateGarda extends CI_Model{

	public function get_all($table)
	{
		$this->db->from($table);
		$this->db->order_by("ID_TEMPlATE_GARDA", "DESC");
		$query = $this->db->get();
		return $query->result();
	}

	public function insert($data, $table)
	{
		$this->db->insert($table, $data);
       	return TRUE;
	}

	function delete($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    function detail_data($where,$table){      
        $this->db->from($table);
        $this->db->where($where);
		$this->db->order_by("ID_TEMPlATE_GARDA", "DESC");
		$query = $this->db->get();
		return $query->result();
    }

    function data_garda($where,$table, $dari, $sampai){
    	$w2 = array('TREATMENT_FINISH >=' => $dari, 'TREATMENT_FINISH <=' => $sampai);      
        $this->db->from($table);
        $this->db->where($where);
        $this->db->where($w2);
		$this->db->order_by("ID_TEMPlATE_GARDA", "DESC");
		$query = $this->db->get();
		return $query->result();
    }

    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }

    function sum_employee_accept($id){
    	$query = "SELECT SUM(SUM_OF_ACCEPTED) AS 'N' FROM `tamplate_garda` WHERE EMP_ID = ".$id." AND MEMBERSHIP = '1. EMP'";
    	$q = $this->db->query($query);
      	return $q->result();
    }

    function sum_family_accept($id){
    	$query = "SELECT SUM(SUM_OF_ACCEPTED) AS 'N' FROM `tamplate_garda` WHERE EMP_ID = ".$id." AND NOT MEMBERSHIP = '1. EMP'";
    	$q = $this->db->query($query);
      	return $q->result();
    }

}