<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property Calon_mustahiq_model $Calon_mustahiq_model
 */

class Calon_mustahiq_model extends CI_Model
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

    public function insertcalon_mustahiq($calon_mustahiq)
    {
        $query = $this->db->insert('calon_mustahiq', $calon_mustahiq);
        return $query;
    }

    public function updatecalon_mustahiq($id_calon_mustahiq, $calon_mustahiq)
    {
        $this->db->where('id_calon_mustahiq', $id_calon_mustahiq);
        $query = $this->db->update('calon_mustahiq', $calon_mustahiq);
        return $query;
    }


    public function cek_no_identitas_calon_mustahiq($no_identitas_calon_mustahiq)
    {
        $this->db
            ->select("*");
        $this->db->from('calon_mustahiq');
        $this->db->where('no_identitas_calon_mustahiq', $no_identitas_calon_mustahiq);
        $query = $this->db->get();

        return $query->row_array();
    }


    function get_calon_mustahiq($page,$keyword=null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("calon_mustahiq.*,user.nama AS nama_perekomendasi_calon_mustahiq");
        $this->db->from('calon_mustahiq');
        $this->db->join('user', 'user.id_user = calon_mustahiq.id_user_perekomendasi');
        $this->db->where("id_calon_mustahiq NOT IN (select id_calon_mustahiq from mustahiq)");
        if($keyword!=null){
            $this->db->like('calon_mustahiq.alamat_calon_mustahiq', $keyword);
            $this->db->or_like('calon_mustahiq.alamat_calon_mustahiq', $keyword, 'after');
            $this->db->or_like('calon_mustahiq.alamat_calon_mustahiq', $keyword, 'before');
            $this->db->group_by('calon_mustahiq.id_calon_mustahiq');
        }
        $this->db->order_by('calon_mustahiq.id_calon_mustahiq', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_all_calon_mustahiq()
    {  $this->db
        ->select("calon_mustahiq.*");

        $this->db->from('calon_mustahiq');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getcalon_mustahiqById($id_calon_mustahiq)
    {
        $this->db
            ->select("calon_mustahiq.*,user.nama AS nama_perekomendasi_calon_mustahiq");
        $this->db->from('calon_mustahiq');
        $this->db->join('user', 'user.id_user = calon_mustahiq.id_user_perekomendasi');
        $this->db->where('calon_mustahiq.id_calon_mustahiq', $id_calon_mustahiq);
        $query = $this->db->get();

        return $query->row_array();
    }
    public function getLastcalon_mustahiq()
    {

        $this->db
            ->select("calon_mustahiq.*,user.nama AS nama_perekomendasi_calon_mustahiq");
        $this->db->from('calon_mustahiq');
        $this->db->join('user', 'user.id_user = calon_mustahiq.id_user_perekomendasi');
        $this->db->order_by('calon_mustahiq.id_calon_mustahiq', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

    function delete_calon_mustahiq($id)
    {
        $this->db->where('id_calon_mustahiq', $id);
        $this->db->delete('calon_mustahiq');
    }

}