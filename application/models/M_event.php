<?php
class M_event extends CI_Model{

	public function get_all_event()
	{
		$this->db->from("event");
		$this->db->order_by("ID_EVENT", "DESC");
		$query = $this->db->get();
		return $query->result();
	}

	public function insert($data, $table)
	{
		$this->db->insert($table, $data);
       	return TRUE;
	}

	public function get_daftar_hadir($where)
	{
		$this->db->from("kehadiran_event");
		$this->db->join('pegawai', "pegawai.NRP = kehadiran_event.NRP");
		$this->db->where($where);
		$this->db->group_by('pegawai.NRP');
		$query = $this->db->get();
		return $query->result();
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