<?php
class M_konsultasi extends CI_Model{

	public function get_all($table)
	{
		$where = array('STATUS' => 0, );
		$where2 = array('STATUS' => 1, );
		$this->db->from($table);
		if ($table == "janji_konsultasi") {
			$this->db->join("dokter", "janji_konsultasi.ID_DOKTER = dokter.ID_DOKTER");
			$this->db->join("pegawai", "pegawai.ID_PEGAWAI = janji_konsultasi.ID_PEGAWAI");
			$this->db->where($where);
			$this->db->order_by("ID_JANJI_KONSULTASI", "desc");
		}else if($table == "riwayat_konsultasi"){
			$this->db->join("janji_konsultasi", "janji_konsultasi.ID_JANJI_KONSULTASI = riwayat_konsultasi.ID_JANJI_KONSULTASI");
			$this->db->join("dokter", "janji_konsultasi.ID_DOKTER = dokter.ID_DOKTER");
			$this->db->join("pegawai", "pegawai.ID_PEGAWAI = janji_konsultasi.ID_PEGAWAI");
			$this->db->where($where2);
			$this->db->order_by("ID_RIWAYAT_KONSULTASI", "desc");
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_dokter($id_dokter, $table)
	{
		$where = array('STATUS' => 0, 'dokter.ID_DOKTER' => $id_dokter );
		$where2 = array('STATUS' => 1, 'dokter.ID_DOKTER' => $id_dokter);
		$this->db->from($table);
		if ($table == "janji_konsultasi") {
			$this->db->join("dokter", "janji_konsultasi.ID_DOKTER = dokter.ID_DOKTER");
			// $this->db->join("pegawai", "pegawai.ID_PEGAWAI = janji_konsultasi.ID_PEGAWAI");
			$this->db->where($where);
			$this->db->order_by("ID_JANJI_KONSULTASI", "desc");
		}else if($table == "riwayat_konsultasi"){
			$this->db->join("janji_konsultasi", "janji_konsultasi.ID_JANJI_KONSULTASI = riwayat_konsultasi.ID_JANJI_KONSULTASI");
			$this->db->join("dokter", "janji_konsultasi.ID_DOKTER = dokter.ID_DOKTER");
			// $this->db->join("pegawai", "pegawai.ID_PEGAWAI = janji_konsultasi.ID_PEGAWAI");
			$this->db->where($where2);
			$this->db->order_by("ID_RIWAYAT_KONSULTASI", "desc");
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_pegawai($id_pegawai, $table)
	{
		$where = array('STATUS' => 0, 'janji_konsultasi.ID_PEGAWAI' => $id_pegawai );
		$where2 = array('STATUS' => 1, 'janji_konsultasi.ID_PEGAWAI' => $id_pegawai);
		$this->db->from($table);
		if ($table == "janji_konsultasi") {
			$this->db->join("dokter", "janji_konsultasi.ID_DOKTER = dokter.ID_DOKTER");
			$this->db->where($where);
			$this->db->order_by("ID_JANJI_KONSULTASI", "desc");
		}else if($table == "riwayat_konsultasi"){
			$this->db->join("janji_konsultasi", "janji_konsultasi.ID_JANJI_KONSULTASI = riwayat_konsultasi.ID_JANJI_KONSULTASI");
			$this->db->join("dokter", "janji_konsultasi.ID_DOKTER = dokter.ID_DOKTER");
			$this->db->where($where2);
			$this->db->order_by("ID_RIWAYAT_KONSULTASI", "desc");
		}
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
		return TRUE;
    }

    function detail_data($where,$table){      
        $query = $this->db->get_where($table,$where);
        return $query->result();
    }

    function detail_konsultasi($where, $table)
    {
    	$this->db->from($table);
    	$this->db->join("dokter", "janji_konsultasi.ID_DOKTER = dokter.ID_DOKTER");
		// $this->db->join("pegawai", "pegawai.ID_PEGAWAI = janji_konsultasi.ID_PEGAWAI");
		$this->db->where($where);
    	$query = $this->db->get();
		return $query->result();
    }

    function detail_riwayat($where, $table)
    {
    	$this->db->from($table);
		$this->db->join("janji_konsultasi", "janji_konsultasi.ID_JANJI_KONSULTASI = riwayat_konsultasi.ID_JANJI_KONSULTASI");
    	$this->db->join("dokter", "janji_konsultasi.ID_DOKTER = dokter.ID_DOKTER");
		// $this->db->join("pegawai", "pegawai.ID_PEGAWAI = janji_konsultasi.ID_PEGAWAI");
		$this->db->where($where);
    	$query = $this->db->get();
		return $query->result();
    }

    function update_data($where,$data,$table){
        $this->db->where($where);
		$this->db->update($table,$data);
		return TRUE;
    }

}