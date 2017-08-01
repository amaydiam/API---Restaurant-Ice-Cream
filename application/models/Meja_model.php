<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property Meja_model $Meja_model
 */

class Meja_model extends CI_Model
{

	function db_conn()
{
	$con=mysqli_connect("localhost","root","","nusantara");
	if(!$con)
	{
		die("tidak dapat melakukan koneksi dengan server");
	}
	return $con;
}

    public function insertmeja($meja)
    {
        $query = $this->db->insert('meja', $meja);
        return $query;
    }

    public function updatemeja($id_meja, $meja)
    {
        $this->db->where('id_meja', $id_meja);
        $query = $this->db->update('meja', $meja);
        return $query;
    }




    public function cek_nama_meja($nama_meja)
    {
        $this->db
            ->select("*");
        $this->db->from('meja');
        $this->db->where('nama_meja', $nama_meja);
        $query = $this->db->get();

        return $query->row_array();
    }


    function get_meja($page,$keyword=null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("meja.*");
        $this->db->from('meja');
        ;
        if($keyword!=null){
            $this->db->like('meja.alamat_meja', $keyword);
            $this->db->or_like('meja.alamat_meja', $keyword, 'after');
            $this->db->or_like('meja.alamat_meja', $keyword, 'before');
            $this->db->group_by('meja.id_meja');
        }
        $this->db->order_by('meja.id_meja', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_meja()
    {  $this->db
        ->select("meja.*");

        $this->db->from('meja');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getmejaById($id_meja)
    {
        $this->db
            ->select("meja.*");
        $this->db->from('meja');
        $this->db->where('meja.id_meja', $id_meja);
        $query = $this->db->get();

        return $query->row_array();
    }
    public function getLastmeja()
    {

        $this->db
            ->select("meja.*");
        $this->db->from('meja');
        $this->db->order_by('meja.id_meja', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

    function delete_meja($id)
    {
        $this->db->where('id_meja', $id);
        $this->db->delete('meja');
    }

}