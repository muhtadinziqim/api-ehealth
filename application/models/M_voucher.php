<?php
class M_voucher extends CI_Model{

	public function get_all($table)
	{
		$this->db->from($table);
		if ($table = "voucher") {
			$this->db->order_by("ID_VOUCHER", "desc");
		}else{
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_kliam()
	{
		$this->db->from("klaim_voucher");
		$this->db->join("pegawai", "pegawai.ID_PEGAWAI = klaim_voucher.ID_PEGAWAI");
		$this->db->join("voucher", 'voucher.ID_VOUCHER = klaim_voucher.ID_VOUCHER');
		$this->db->order_by("ID_KLAIM_VOUCHER", "desc");
		$q = $this->db->get();
		return $q->result();
	}

	public function get_voucher_saya($where)
	{
		$this->db->select("*, klaim_voucher.STATUS as 'STATUS_V'");
		$this->db->from("klaim_voucher");
		$this->db->join("pegawai", "pegawai.NRP = klaim_voucher.ID_PEGAWAI");
		$this->db->join("voucher", 'voucher.ID_VOUCHER = klaim_voucher.ID_VOUCHER');
		$this->db->where($where);
		$this->db->order_by("ID_KLAIM_VOUCHER", "desc");
		$q = $this->db->get();
		return $q->result();
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