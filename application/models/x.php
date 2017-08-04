<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property Kategori_menu_model $Kategori_menu_model
 */

class Kategori_menu_model extends CI_Model
{

        public function insertkategori_menu($kategori_menu)
    {
        $query = $this->db->insert('kategori_menu', $kategori_menu);
        return $query;
    }

    public function updatekategori_menu($id_kategori_menu, $kategori_menu)
    {
        $this->db->where('id_kategori_menu', $id_kategori_menu);
        $query = $this->db->update('kategori_menu', $kategori_menu);
        return $query;
    }
    //

    public function cek_nama_kategori_menu($nama_kategori_menu)
    {
        $this->db
            ->select("*");
        $this->db->from('kategori_menu');
        $this->db->where('nama_kategori_menu', $nama_kategori_menu);
        $query = $this->db->get();

        return $query->row_array();
    }


    function get_kategori_menu($page,$keyword=null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("kategori_menu.*");
        $this->db->from('kategori_menu');
        if($keyword!=null){
            $this->db->like('kategori_menu.nama_kategori_menu', $keyword);
            $this->db->or_like('kategori_menu.nama_kategori_menu', $keyword, 'after');
            $this->db->or_like('kategori_menu.nama_kategori_menu', $keyword, 'before');
            $this->db->group_by('kategori_menu.id_kategori_menu');
        }
        $this->db->order_by('kategori_menu.id_kategori_menu', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_kategori_menu()
    {  $this->db
        ->select("kategori_menu.*");

        $this->db->from('kategori_menu');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getkategori_menuById($id_kategori_menu)
    {
        $this->db
            ->select("kategori_menu.*");
        $this->db->from('kategori_menu');
        $this->db->where('kategori_menu.id_kategori_menu', $id_kategori_menu);
        $query = $this->db->get();

        return $query->row_array();
    }
    public function getLastkategori_menu()
    {

        $this->db
            ->select("kategori_menu.*");
        $this->db->from('kategori_menu');
        $this->db->order_by('kategori_menu.id_kategori_menu', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

    function delete_kategori_menu($id)
    {
        $this->db->where('id_kategori_menu', $id);
        $this->db->delete('kategori_menu');
    }

}