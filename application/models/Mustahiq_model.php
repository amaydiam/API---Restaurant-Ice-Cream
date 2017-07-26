<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Calon_mustahiq_model $Calon_mustahiq_model
 */
class Mustahiq_model extends CI_Model
{


    public function insertmustahiq($mustahiq)
    {
        $query = $this->db->insert('mustahiq', $mustahiq);
        return $query;
    }

    public function updatemustahiq($id_mustahiq, $mustahiq)
    {
        $this->db->where('id_mustahiq', $id_mustahiq);
        $query = $this->db->update('mustahiq', $mustahiq);
        return $query;
    }


    public function cek_no_identitas_mustahiq($no_identitas_mustahiq)
    {
        $this->db
            ->select("*");
        $this->db->from('mustahiq');
        $this->db->where('no_identitas_mustahiq', $no_identitas_mustahiq);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function cek_id_mustahiq($id_calon_mustahiq)
    {
        $this->db
            ->select("*");
        $this->db->from('mustahiq');
        $this->db->where('id_calon_mustahiq', $id_calon_mustahiq);
        $query = $this->db->get();

        return $query->row_array();
    }


    function get_mustahiq($page, $donasi, $keyword = null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("mustahiq.id_mustahiq as idnya,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        mustahiq.id_mustahiq as idm,
                        (select avg(rating) from rating_mustahiq where rating_mustahiq.id_mustahiq=idm) as jumlah_rating,
                         calon_mustahiq.*,
                        calon_mustahiq.id_user_perekomendasi as idnya_id_user_perekomendasi,
                        (SELECT user.nama FROM user WHERE user.id_user = idnya_id_user_perekomendasi) AS nama_perekomendasi_calon_mustahiq,
                        amil_zakat.*,
            (SELECT waktu_donasi FROM donasi WHERE id_mustahiq=idnya  ORDER BY id_donasi DESC LIMIT 0,1) AS waktu_terakhir_donasi");
        $this->db->from('mustahiq');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');
        $this->db->where('calon_mustahiq.status_calon_mustahiq', "Aktif");
        if ($donasi) {
            $this->db->where('mustahiq.status_mustahiq', "Aktif");
        }
        if ($keyword != null) {
            $this->db->like('calon_mustahiq.alamat_calon_mustahiq', $keyword);
            $this->db->or_like('calon_mustahiq.alamat_calon_mustahiq', $keyword, 'after');
            $this->db->or_like('calon_mustahiq.alamat_calon_mustahiq', $keyword, 'before');
            $this->db->group_by('mustahiq.id_mustahiq');
        }
        $this->db->order_by('mustahiq.id_mustahiq', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_mustahiq_by_location($lat, $long)
    {
        $page = 1;

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("mustahiq.id_mustahiq as idnya,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        mustahiq.id_mustahiq as idm,
                        (select avg(rating) from rating_mustahiq where rating_mustahiq.id_mustahiq=idm) as jumlah_rating,
                        calon_mustahiq.*,
                        calon_mustahiq.id_user_perekomendasi as idnya_id_user_perekomendasi,
                        (SELECT user.nama FROM user WHERE user.id_user = idnya_id_user_perekomendasi) AS nama_perekomendasi_calon_mustahiq,
                        amil_zakat.*,
            (SELECT waktu_donasi FROM donasi WHERE id_mustahiq=idnya  ORDER BY id_donasi DESC LIMIT 0,1) AS waktu_terakhir_donasi,
            ( 6371 * acos( cos( radians(".$lat.") ) * cos( radians(latitude_calon_mustahiq) ) *
cos( radians(longitude_calon_mustahiq) - radians(".$long.") ) + sin( radians(".$lat.") ) *
sin( radians(latitude_calon_mustahiq) ) ) ) AS distance");
        $this->db->from('mustahiq');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');
        $this->db->where('calon_mustahiq.status_calon_mustahiq', "Aktif");
        $this->db->where('mustahiq.status_mustahiq', "Aktif");
        $this->db->having('distance <=', '5');

        /*   if ($keyword != null) {
               $this->db->like('calon_mustahiq.alamat_calon_mustahiq', $keyword);
               $this->db->or_like('calon_mustahiq.alamat_calon_mustahiq', $keyword, 'after');
               $this->db->or_like('calon_mustahiq.alamat_calon_mustahiq', $keyword, 'before');
               $this->db->group_by('mustahiq.id_mustahiq');
           }*/
      //  $this->db->order_by('mustahiq.id_mustahiq', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_mustahiq()
    {
        $this->db
            ->select("mustahiq.id_mustahiq as idnya,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        mustahiq.id_mustahiq as idm,
                        (select avg(rating) from rating_mustahiq where rating_mustahiq.id_mustahiq=idm) as jumlah_rating,
                         calon_mustahiq.*,
                        amil_zakat.*,
                        calon_mustahiq.id_user_perekomendasi as idnya_id_user_perekomendasi,
                        (SELECT user.nama FROM user WHERE user.id_user = idnya_id_user_perekomendasi) AS nama_perekomendasi_calon_mustahiq,

            (SELECT waktu_donasi FROM donasi WHERE id_mustahiq=idnya  ORDER BY id_donasi DESC LIMIT 0,1) AS waktu_terakhir_donasi");
        $this->db->from('mustahiq');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');
        $this->db->where('calon_mustahiq.status_calon_mustahiq', "Aktif");
        $this->db->order_by('mustahiq.id_mustahiq', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getmustahiqById($id_mustahiq)
    {
        $this->db
            ->select("mustahiq.id_mustahiq as idnya,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        mustahiq.id_mustahiq as idm,
                        (select avg(rating) from rating_mustahiq where rating_mustahiq.id_mustahiq=idm) as jumlah_rating,
                         calon_mustahiq.*,
                        amil_zakat.*,
                        calon_mustahiq.id_user_perekomendasi as idnya_id_user_perekomendasi,
                        (SELECT user.nama FROM user WHERE user.id_user = idnya_id_user_perekomendasi) AS nama_perekomendasi_calon_mustahiq,

            (SELECT waktu_donasi FROM donasi WHERE id_mustahiq=idnya  ORDER BY id_donasi DESC LIMIT 0,1) AS waktu_terakhir_donasi");
        $this->db->from('mustahiq');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');
        $this->db->where('calon_mustahiq.status_calon_mustahiq', "Aktif");
        $this->db->where('mustahiq.id_mustahiq', $id_mustahiq);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getLastmustahiq()
    {
        $this->db
            ->select("mustahiq.id_mustahiq as idnya,
                        mustahiq.id_mustahiq,
                        mustahiq.status_mustahiq,
                        mustahiq.id_mustahiq as idm,
                        (select avg(rating) from rating_mustahiq where rating_mustahiq.id_mustahiq=idm) as jumlah_rating,
                         calon_mustahiq.*,
                        amil_zakat.*,
                        calon_mustahiq.id_user_perekomendasi as idnya_id_user_perekomendasi,
                        (SELECT user.nama FROM user WHERE user.id_user = idnya_id_user_perekomendasi) AS nama_perekomendasi_calon_mustahiq,

            (SELECT waktu_donasi FROM donasi WHERE id_mustahiq=idnya  ORDER BY id_donasi DESC LIMIT 0,1) AS waktu_terakhir_donasi");
        $this->db->from('mustahiq');
        $this->db->join('calon_mustahiq', 'calon_mustahiq.id_calon_mustahiq = mustahiq.id_calon_mustahiq');
        $this->db->join('amil_zakat', 'amil_zakat.id_amil_zakat = mustahiq.id_amil_zakat');
        $this->db->where('calon_mustahiq.status_calon_mustahiq', "Aktif");
        $this->db->order_by('mustahiq.id_mustahiq', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }


    function delete_mustahiq($id)
    {
        $this->db->where('id_mustahiq', $id);
        $this->db->delete('mustahiq');
    }



}