<?php
class M_user extends CI_Model{

	public function get_all($table)
	{
		$this->db->from($table);
		$query = $this->db->get();
		return $query->result();
  }

  public function get_all2($table)
  {
    $this->db->select("NRP, NAMA_KARYAWAN, GENDER, PHONE, DIVISI, DEPARTMENT");
    $this->db->from($table);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_all_group($table)
  {
    $this->db->from($table);
    $this->db->group_by("NRP");
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
        return true;
    }

    function detail_data($where,$table){      
       $query = $this->db->get_where($table,$where);
       return $query->result();
    }

    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
        return true;
    }

    public function get_jumlah_karyawan($table)
    {
        $where = array('month(TANGGAL_UPDATE) <=' => date("m"), "year(TANGGAL_UPDATE) <=" => date("Y") );
        $this->db->from($table);
        $this->db->where($where);
        $this->db->limit(12);
        $this->db->order_by("TANGGAL_UPDATE", "DESC");
        $q = $this->db->get();
        return $q->result();
    }

    public function get_jumlah_hari_kerja($table)
    {
        $where = array('month(TANGGAL_UPDATE) <=' => date("m"), "year(TANGGAL_UPDATE) <=" => date("Y") );
        $this->db->from($table);
        $this->db->where($where);
        $this->db->limit(12);
        $this->db->order_by("TANGGAL_UPDATE", "DESC");
        $q = $this->db->get();
        return $q->result();
    }

    public function get_sick_employee(){
      $time0 = array( 
        mktime(0, 0, 0, date("m"), date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-1, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-2, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-3, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-4, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-5, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-6, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-7, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-8, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-9, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-10, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-11, date("d"), date("Y")),
      );
      $query = "SELECT 
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[0])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[0]).") AS C0,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[1])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[1]).") AS C1,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[2])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[2]).") AS C2,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[3])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[3]).") AS C3,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[4])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[4]).") AS C4,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[5])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[5]).") AS C5,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[6])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[6]).") AS C6,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[7])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[7]).") AS C7,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[8])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[8]).") AS C8,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[9])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[9]).") AS C9,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[10])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[10]).") AS C10,
        (SELECT COUNT(DISTINCT NRP) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[11])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[11]).") AS C11
      ";
      $q = $this->db->query($query);
      return $q->result();
    }

     public function get_man_day_lost(){
      $time0 = array( 
        mktime(0, 0, 0, date("m"), date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-1, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-2, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-3, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-4, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-5, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-6, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-7, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-8, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-9, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-10, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-11, date("d"), date("Y")),
      );
      $query = "SELECT 
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[0])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[0]).") AS C0,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[1])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[1]).") AS C1,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[2])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[2]).") AS C2,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[3])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[3]).") AS C3,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[4])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[4]).") AS C4,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[5])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[5]).") AS C5,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[6])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[6]).") AS C6,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[7])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[7]).") AS C7,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[8])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[8]).") AS C8,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[9])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[9]).") AS C9,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[10])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[10]).") AS C10,
        (SELECT SUM(TOTAL_DAYS) FROM laporan_cuti_sakit WHERE  month(LEAVE_STARTDATE) = ".date('m', $time0[11])." AND year(LEAVE_STARTDATE) = ".date('Y', $time0[11]).") AS C11
      ";
      $q = $this->db->query($query);
      return $q->result();
    }


    public function get_fitnes_status()
    {
      $time = array(
        mktime(0, 0, 0, date("m"), date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-1, date("d"), date("Y")),
        mktime(0, 0, 0, date("m")-2, date("d"), date("Y"))
      );
      $query = "
        SELECT 
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[0]." AND FITNESS_STATUS = 'FIT') AS FIT0,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[0]." AND FITNESS_STATUS = 'TEMPORARY UNFIT') AS TU0,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[0]." AND FITNESS_STATUS = 'FIT WITH NOTE') AS FWN0,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[0]." AND FITNESS_STATUS = 'UNFIT') AS UF0,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[1]." AND FITNESS_STATUS = 'FIT') AS FIT1,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[1]." AND FITNESS_STATUS = 'TEMPORARY UNFIT') AS TU1,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[1]." AND FITNESS_STATUS = 'FIT WITH NOTE') AS FWN1,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[1]." AND FITNESS_STATUS = 'UNFIT') AS UF1,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[2]." AND FITNESS_STATUS = 'FIT') AS FIT2,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[2]." AND FITNESS_STATUS = 'TEMPORARY UNFIT') AS TU2,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[2]." AND FITNESS_STATUS = 'FIT WITH NOTE') AS FWN2,
        (SELECT COUNT(ID_EMPLOYEE) FROM template_mcu_master2 WHERE YEAR(TGL_KUNJUNGAN) = ".$time[2]." AND FITNESS_STATUS = 'UNFIT') AS UF2
      ";
      
      $q = $this->db->query($query);
      return $q->result();
    }
}