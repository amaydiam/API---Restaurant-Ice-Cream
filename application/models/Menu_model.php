<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property Menu_model $menu_model
 */

class Menu_model extends CI_Model
{

        public function insertmenu($menu)
    {
        $query = $this->db->insert('menu', $menu);
        return $query;
    }

    public function updatemenu($id_menu, $menu)
    {
        $this->db->where('id_menu', $id_menu);
        $query = $this->db->update('menu', $menu);
        return $query;
    }


    public function cek_nama_menu($nama_menu)
    {
        $this->db
            ->select("*");
        $this->db->from('menu');
        $this->db->where('nama_menu', $nama_menu);
        $query = $this->db->get();

        return $query->row_array();
    }


    function get_menu($id_sub_kategori_menu,$page,$keyword=null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.id_sub_kategori_menu', $id_sub_kategori_menu);
        if($keyword!=null){
            $this->db->like('menu.nama_menu', $keyword);
            $this->db->or_like('menu.nama_menu', $keyword, 'after');
            $this->db->or_like('menu.nama_menu', $keyword, 'before');
            $this->db->group_by('menu.id_menu');
        }
        $this->db->order_by('menu.id_menu', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_menu()
    {  $this->db
        ->select("menu.*");

        $this->db->from('menu');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getmenuById($id_menu)
    {
        $this->db
            ->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.id_menu', $id_menu);
        $query = $this->db->get();

        return $query->row_array();
    }
    public function getLastmenu()
    {

        $this->db
            ->select("menu.*");
        $this->db->from('menu');
        $this->db->order_by('menu.id_menu', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

    function delete_menu($id)
    {
        $this->db->where('id_menu', $id);
        $this->db->delete('menu');
    }

}