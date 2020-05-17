<?php
class M_berita extends CI_Model{

	public function get_all_poster()
	{
		$this->db->from("info_poster");
		$this->db->order_by("ID_POSTER", "DESC");
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_pengumuman()
	{
		$this->db->from("pengumuman");
		$this->db->order_by("ID_PENGUMUMAN", "DESC");
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