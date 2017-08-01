<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Absensi_meja_model $Absensi_meja_model
 */
class Absensi_meja_model extends CI_Model
{

    public function insertabsensi_meja($absensi_meja)
    {
        $query = $this->db->insert('absensi_meja', $absensi_meja);
        return $query;
    }

    public function getMejaByIdPesanan($id_pesanan)
    {
        $this->db
            ->select("absensi_meja.*");
        $this->db->from('pesanan');
        $this->db->join('absensi_meja', 'pesanan.id_meja = absensi_meja.id_meja');
        $this->db->where('pesanan.id_pesanan', $id_pesanan);
        $this->db->order_by('absensi_meja.id_absensi_meja', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }


}