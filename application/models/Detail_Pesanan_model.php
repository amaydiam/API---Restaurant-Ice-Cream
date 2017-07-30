<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Pesanan_model $Pesanan_model
 */
class Detail_pesanan_model extends CI_Model
{


    public function insertdetail_pesanan($detail_pesanan)
    {
        $query = $this->db->insert('detail_pesanan', $detail_pesanan);
        return $query;
    }

    public function updatedetail_pesanan($id_detail_pesanan, $detail_pesanan)
    {
        $this->db->where('id_detail_pesanan', $id_detail_pesanan);
        $query = $this->db->update('detail_pesanan', $detail_pesanan);
        return $query;
    }




    public function get_all_detail_pesanan($id_pesanan)
    {
        $this->db
            ->select("detail_pesanan.*,
            menu.nama_menu,
            (detail_pesanan.jumlah_pesanan * detail_pesanan.harga_pesanan) as total_harga_pesanan");
        $this->db->from('detail_pesanan');
        $this->db->join('pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan');
        $this->db->join('menu', 'detail_pesanan.id_menu= menu.id_menu');
        $this->db->where('detail_pesanan.id_pesanan', $id_pesanan);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getdetail_pesananById($id_detail_pesanan)
    {
        $this->db
            ->select("detail_pesanan.*,
            menu.nama_menu,
            (detail_pesanan.jumlah_pesanan * detail_pesanan.harga_pesanan) as total_harga_pesanan");
        $this->db->from('detail_pesanan');
        $this->db->join('pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan');
        $this->db->join('menu', 'detail_pesanan.id_menu= menu.id_menu');
        $this->db->where('detail_pesanan.id_detail_pesanan', $id_detail_pesanan);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getLastdetail_pesanan()
    {
        $this->db
            ->select("detail_pesanan.*,
            menu.nama_menu,
            (detail_pesanan.jumlah_pesanan * detail_pesanan.harga_pesanan) as total_harga_pesanan");
        $this->db->from('detail_pesanan');
        $this->db->join('pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan');
        $this->db->join('menu', 'detail_pesanan.id_menu= menu.id_menu');
        $this->db->order_by('detail_pesanan.id_detail_pesanan', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

    function delete_detail_pesanan($id)
    {
        $this->db->where('id_detail_pesanan', $id);
        $this->db->delete('detail_pesanan');
    }

}