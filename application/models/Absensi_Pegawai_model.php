<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Absensi_pegawai_model $Absensi_pegawai_model
 */
class Absensi_pegawai_model extends CI_Model
{

    public function insertabsensi_pegawai($absensi_pegawai)
    {
        $query = $this->db->insert('absensi_pegawai', $absensi_pegawai);
        return $query;
    }

    public function getPelayan()
    {
        $this->db
            ->select("absensi_pegawai.*");
        $this->db->from('absensi_pegawai');
        $this->db->where('absensi_pegawai.tipe_pegawai', "1");
        $this->db->order_by('absensi_pegawai.id_absensi_pegawai', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getKasir()
    {
        $this->db
            ->select("absensi_pegawai.*");
        $this->db->from('absensi_pegawai');
        $this->db->where('absensi_pegawai.tipe_pegawai', "2");
        $this->db->order_by('absensi_pegawai.id_absensi_pegawai', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

}