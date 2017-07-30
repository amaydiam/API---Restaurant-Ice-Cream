<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property Sub_kategori_menu_model $Sub_kategori_menu_model
 */

class Sub_kategori_menu_model extends CI_Model
{

        public function insertsub_kategori_menu($sub_kategori_menu)
    {
        $query = $this->db->insert('sub_kategori_menu', $sub_kategori_menu);
        return $query;
    }

    public function updatesub_kategori_menu($id_sub_kategori_menu, $sub_kategori_menu)
    {
        $this->db->where('id_sub_kategori_menu', $id_sub_kategori_menu);
        $query = $this->db->update('sub_kategori_menu', $sub_kategori_menu);
        return $query;
    }


    public function cek_nama_sub_kategori_menu($nama_sub_kategori_menu)
    {
        $this->db
            ->select("*");
        $this->db->from('sub_kategori_menu');
        $this->db->where('nama_sub_kategori_menu', $nama_sub_kategori_menu);
        $query = $this->db->get();

        return $query->row_array();
    }


    function get_sub_kategori_menu($id_kategori_menu,$page,$keyword=null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("sub_kategori_menu.*");
        $this->db->from('sub_kategori_menu');
        $this->db->where('sub_kategori_menu.id_kategori_menu', $id_kategori_menu);
        if($keyword!=null){
            $this->db->like('sub_kategori_menu.nama_sub_kategori_menu', $keyword);
            $this->db->or_like('sub_kategori_menu.nama_sub_kategori_menu', $keyword, 'after');
            $this->db->or_like('sub_kategori_menu.nama_sub_kategori_menu', $keyword, 'before');
            $this->db->group_by('sub_kategori_menu.id_sub_kategori_menu');
        }
        $this->db->order_by('sub_kategori_menu.id_sub_kategori_menu', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_sub_kategori_menu()
    {  $this->db
        ->select("sub_kategori_menu.*");

        $this->db->from('sub_kategori_menu');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getsub_kategori_menuById($id_sub_kategori_menu)
    {
        $this->db
            ->select("sub_kategori_menu.*");
        $this->db->from('sub_kategori_menu');
        $this->db->where('sub_kategori_menu.id_sub_kategori_menu', $id_sub_kategori_menu);
        $query = $this->db->get();

        return $query->row_array();
    }
    public function getLastsub_kategori_menu()
    {

        $this->db
            ->select("sub_kategori_menu.*");
        $this->db->from('sub_kategori_menu');
        $this->db->order_by('sub_kategori_menu.id_sub_kategori_menu', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

    function delete_sub_kategori_menu($id)
    {
        $this->db->where('id_sub_kategori_menu', $id);
        $this->db->delete('sub_kategori_menu');
    }

}