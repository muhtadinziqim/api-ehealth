<?php
class M_panic_button extends CI_Model{

	public function get_all()
	{
		$this->db->from("panic_button");
		$this->db->join("pegawai", "pegawai.NRP = panic_button.ID_PEGAWAI");
		$this->db->order_by("ID_PANIC_BUTTON", "desc");
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
       $query = $this->db->get_where($table,$where);
       return $query->result();
    }

    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }

}