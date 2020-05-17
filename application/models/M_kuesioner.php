<?php
class M_kuesioner extends CI_Model{

	public function get_all($table)
	{
		$this->db->from($table);
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
      $this->db->join('pegawai', 'pegawai.NRP = kuisioner_kelelahan.ID_PEGAWAI');
      $query = $this->db->get();
      return $query->result();    
    }

    function num_ku($where,$table){      
       $query = $this->db->get_where($table,$where);
       return $query->num_rows();
    }

    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }

}