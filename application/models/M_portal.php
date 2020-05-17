<?php
class M_portal extends CI_Model
{

	public function get_all($table)
	{
		$this->db->from($table);
		if ($table == "mcu_template") {
			$this->db->order_by("ID_MCU_TEMPLATE", "desc");
		} else if ($table == "sop_mcu") {
			$this->db->order_by("ID_SOP_MCU", "desc");
		} else if ($table == "vendor_list") {
			$this->db->order_by("ID_VENDOR_LIST", "desc");
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function insert($data, $table)
	{
		$this->db->insert($table, $data);
		return TRUE;
	}

	function delete($where, $table)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

	function detail_data($where, $table)
	{
		$query = $this->db->get_where($table, $where);
		return $query->result();
	}

	function historis_tekanan_darah($where, $table)
	{
		$this->db->select("TGL_KUNJUNGAN, TEKANAN_DARAH");
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by("TGL_KUNJUNGAN", "ASC");
		$query = $this->db->get();
		return $query->result();
	}

	function historis_kolesterol($where, $table)
	{
		$this->db->select("TGL_KUNJUNGAN, KOLESTEROL_TOTAL");
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by("TGL_KUNJUNGAN", "ASC");
		$query = $this->db->get();
		return $query->result();
	}

	function historis_gula_darah($where, $table)
	{
		$this->db->select("TGL_KUNJUNGAN, GLUKOSA_PUASA");
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by("TGL_KUNJUNGAN", "ASC");
		$query = $this->db->get();
		return $query->result();
	}

	function update_data($where, $data, $table)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	public function detail_mcu_terbaru($where, $table)
	{
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by("TGL_KUNJUNGAN", "DESC");
		$this->db->limit(1);
		$q = $this->db->get();
		return $q->result();
	}
}
