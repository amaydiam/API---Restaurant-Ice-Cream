<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Donasi_model $Donasi_model
 */
class Donasi_model extends CI_Model
{


    public function insertdonasi($donasi)
    {
        $query = $this->db->insert('donasi', $donasi);
        return $query;
    }


    function get_donasi($page, $keyword = null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;

        $this->db
            ->select("donasi.*,
            muzaki.*,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        mustahiq.id_mustahiq as idm,
                        (select avg(rating) from rating_mustahiq where rating_mustahiq.id_mustahiq=idm) as jumlah_rating,
                        calon_mustahiq.*,
                        amil_zakat.*");
        $this->db->from('donasi');
        $this->db->join('mustahiq', 'donasi.id_mustahiq = mustahiq.id_mustahiq');
        $this->db->join('muzaki', 'donasi.id_muzaki = muzaki.id_muzaki');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');

        if ($keyword != null) {
            $this->db->like('muzaki.no_identitas_muzaki', $keyword);
            $this->db->or_like('muzaki.no_identitas_muzaki', $keyword, 'after');
            $this->db->or_like('muzaki.no_identitas_muzaki', $keyword, 'before');
            $this->db->group_by('muzaki.no_identitas_muzaki');
        }
        $this->db->order_by('id_donasi', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_donasi()
    {
        $this->db
            ->select("donasi.*,
            muzaki.*,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        mustahiq.id_mustahiq as idm,
                        (select avg(rating) from rating_mustahiq where rating_mustahiq.id_mustahiq=idm) as jumlah_rating,
                        calon_mustahiq.*,
                        amil_zakat.*");
        $this->db->from('donasi');
        $this->db->join('mustahiq', 'donasi.id_mustahiq = mustahiq.id_mustahiq');
        $this->db->join('muzaki', 'donasi.id_muzaki = muzaki.id_muzaki');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDonasiById($id_donasi)
    {
        $this->db
            ->select("donasi.*,
            muzaki.*,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        calon_mustahiq.*,
                        amil_zakat.*");
        $this->db->from('donasi');
        $this->db->join('mustahiq', 'donasi.id_mustahiq = mustahiq.id_mustahiq');
        $this->db->join('muzaki', 'donasi.id_muzaki = muzaki.id_muzaki');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');
        $this->db->where('id_donasi', $id_donasi);
        $query = $this->db->get();

        return $query->row_array();
    }


    function delete_donasi($id)
    {
        $this->db->where('id_donasi', $id);
        $this->db->delete('donasi');
    }

    public function getLastDonasi()
    {
        $this->db
            ->select("donasi.*,
            muzaki.*,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        calon_mustahiq.*,
                        amil_zakat.*");
        $this->db->from('donasi');
        $this->db->join('mustahiq', 'donasi.id_mustahiq = mustahiq.id_mustahiq');
        $this->db->join('muzaki', 'donasi.id_muzaki = muzaki.id_muzaki');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');
        $this->db->order_by('donasi.id_donasi', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }



}