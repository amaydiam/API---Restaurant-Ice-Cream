<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Muzaki_model $Muzaki_model
 */
class Muzaki_model extends CI_Model
{


    public function insertmuzaki($muzaki)
    {
        $query = $this->db->insert('muzaki', $muzaki);
        return $query;
    }

    public function updatemuzaki($id_muzaki, $muzaki)
    {
        $this->db->where('id_muzaki', $id_muzaki);
        $query = $this->db->update('muzaki', $muzaki);
        return $query;
    }


    public function cek_no_identitas_muzaki($no_identitas_muzaki)
    {
        $this->db
            ->select("*");
        $this->db->from('muzaki');
        $this->db->where('no_identitas_muzaki', $no_identitas_muzaki);
        $query = $this->db->get();

        return $query->row_array();
    }


    function get_muzaki($page, $donasi)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("muzaki.*");
        $this->db->from('muzaki');
        if ($donasi) {
            $this->db->where('validasi_muzaki', "Ya");
            $this->db->where('status_muzaki', "Aktif");
        }
        $this->db->order_by('muzaki.id_muzaki', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_muzaki()
    {
        $this->db
            ->select("*");
        $this->db->from('muzaki');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getMuzakiById($id_muzaki)
    {
        $this->db
            ->select("*");
        $this->db->from('muzaki');
        $this->db->where('id_muzaki', $id_muzaki);
        $query = $this->db->get();

        return $query->row_array();
    }


    function delete_muzaki($id)
    {
        $this->db->where('id_muzaki', $id);
        $this->db->delete('muzaki');
    }

    public function getLastMuzaki()
    {
        $this->db
            ->select("*");
        $this->db->from('muzaki');
        $this->db->order_by('muzaki.id_muzaki', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

}