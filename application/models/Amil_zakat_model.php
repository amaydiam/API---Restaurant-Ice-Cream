<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Amil_zakat_model $Amil_zakat_model
 */
class Amil_zakat_model extends CI_Model
{


    public function insertamil_zakat($amil_zakat)
    {
        $query = $this->db->insert('amil_zakat', $amil_zakat);
        return $query;
    }

    public function updateamil_zakat($id_amil_zakat, $amil_zakat)
    {
        $this->db->where('id_amil_zakat', $id_amil_zakat);
        $query = $this->db->update('amil_zakat', $amil_zakat);
        return $query;
    }


    public function cek_no_identitas_amil_zakat($no_identitas_amil_zakat)
    {
        $this->db
            ->select("*");
        $this->db->from('amil_zakat');
        $this->db->where('no_identitas_amil_zakat', $no_identitas_amil_zakat);
        $query = $this->db->get();

        return $query->row_array();
    }


    function get_amil_zakat($page, $donasi)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("amil_zakat.*");
        $this->db->from('amil_zakat');
        if ($donasi) {
            $this->db->where('validasi_amil_zakat', "Ya");
            $this->db->where('status_amil_zakat', "Aktif");
        }
        $this->db->order_by('amil_zakat.id_amil_zakat', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_amil_zakat()
    {
        $this->db
            ->select("*");
        $this->db->from('amil_zakat');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getAmil_zakatById($id_amil_zakat)
    {
        $this->db
            ->select("*");
        $this->db->from('amil_zakat');
        $this->db->where('id_amil_zakat', $id_amil_zakat);
        $query = $this->db->get();

        return $query->row_array();
    }


    function delete_amil_zakat($id)
    {
        $this->db->where('id_amil_zakat', $id);
        $this->db->delete('amil_zakat');
    }

    public function getLastAmil_zakat()
    {
        $this->db
            ->select("*");
        $this->db->from('amil_zakat');
        $this->db->order_by('amil_zakat.id_amil_zakat', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

}