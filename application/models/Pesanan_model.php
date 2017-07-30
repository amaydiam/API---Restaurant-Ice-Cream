<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Pesanan_model $Pesanan_model
 */
class Pesanan_model extends CI_Model
{


    public function insertpesanan($pesanan)
    {
        $query = $this->db->insert('pesanan', $pesanan);
        return $query;
    }

    public function updatepesanan($id_pesanan, $pesanan)
    {
        $this->db->where('id_pesanan', $id_pesanan);
        $query = $this->db->update('pesanan', $pesanan);
        return $query;
    }

    function get_pesanan_pelanggan($id_meja,$page, $keyword = null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("pesanan.*,pesanan.id_pesanan as idnya,
            meja.nama_meja,
            (SELECT SUM(jumlah_pesanan * harga_pesanan) from detail_pesanan where detail_pesanan.id_pesanan=idnya) as total_harga");
        $this->db->from('pesanan');
        $this->db->join('meja', 'pesanan.id_meja = meja.id_meja');
        $this->db->where('meja.id_meja', $id_meja);
        $this->db->where('pesanan.status_pesanan', "Menunggu Pesanan");
        $this->db->or_where('pesanan.status_pesanan', "Pesanan Sedang Disiapkan");
        if ($keyword != null) {
            $this->db->like('pesanan.alamat_pesanan', $keyword);
            $this->db->or_like('pesanan.alamat_pesanan', $keyword, 'after');
            $this->db->or_like('pesanan.alamat_pesanan', $keyword, 'before');
            $this->db->group_by('pesanan.id_pesanan');
        }
        $this->db->order_by('pesanan.id_pesanan', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_pesanan_pelayan($page, $keyword = null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("pesanan.*,pesanan.id_pesanan as idnya,
            meja.nama_meja,
            (SELECT SUM(jumlah_pesanan * harga_pesanan) from detail_pesanan where detail_pesanan.id_pesanan=idnya) as total_harga");
        $this->db->from('pesanan');
        $this->db->join('meja', 'pesanan.id_meja = meja.id_meja');
        $this->db->where('pesanan.status_pesanan', "Menunggu Pesanan");
        $this->db->or_where('pesanan.status_pesanan', "Pesanan Sedang Disiapkan");
        if ($keyword != null) {
            $this->db->like('pesanan.alamat_pesanan', $keyword);
            $this->db->or_like('pesanan.alamat_pesanan', $keyword, 'after');
            $this->db->or_like('pesanan.alamat_pesanan', $keyword, 'before');
            $this->db->group_by('pesanan.id_pesanan');
        }
        $this->db->order_by('pesanan.id_pesanan', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_pesanan_kasir($page, $keyword = null)
    {
        if ($page == null || $page == 1) {
            $page = 1;
        }

        $limit = "10";
        $start = ($page - 1) * $limit;
        $this->db
            ->select("pesanan.*,pesanan.id_pesanan as idnya,
            meja.nama_meja,
            (SELECT SUM(jumlah_pesanan * harga_pesanan) from detail_pesanan where detail_pesanan.id_pesanan=idnya) as total_harga");
        $this->db->from('pesanan');
        $this->db->join('meja', 'pesanan.id_meja = meja.id_meja');
        $this->db->where('pesanan.status_pesanan', "Pesanan Sedang Dinikmati");
        if ($keyword != null) {
            $this->db->like('pesanan.alamat_pesanan', $keyword);
            $this->db->or_like('pesanan.alamat_pesanan', $keyword, 'after');
            $this->db->or_like('pesanan.alamat_pesanan', $keyword, 'before');
            $this->db->group_by('pesanan.id_pesanan');
        }
        $this->db->order_by('pesanan.id_pesanan', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_pesanan()
    {
        $this->db
            ->select("pesanan.*,pesanan.id_pesanan as idnya,
            meja.nama_meja,
            (SELECT SUM(jumlah_pesanan * harga_pesanan) from detail_pesanan where detail_pesanan.id_pesanan=idnya) as total_harga");
        $this->db->from('pesanan');
        $this->db->join('meja', 'pesanan.id_meja = meja.id_meja');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getpesananById($id_pesanan)
    {
        $this->db
            ->select("pesanan.*,pesanan.id_pesanan as idnya,
            meja.nama_meja,
            (SELECT SUM(jumlah_pesanan * harga_pesanan) from detail_pesanan where detail_pesanan.id_pesanan=idnya) as total_harga");
        $this->db->from('pesanan');
        $this->db->join('meja', 'pesanan.id_meja = meja.id_meja');
        $this->db->where('pesanan.id_pesanan', $id_pesanan);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getLastpesanan()
    {
        $this->db
            ->select("pesanan.*,pesanan.id_pesanan as idnya,
            meja.nama_meja,
            (SELECT SUM(jumlah_pesanan * harga_pesanan) from detail_pesanan where detail_pesanan.id_pesanan=idnya) as total_harga");
        $this->db->from('pesanan');
        $this->db->join('meja', 'pesanan.id_meja = meja.id_meja');
        $this->db->order_by('pesanan.id_pesanan', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();

        return $query->row_array();
    }

    function delete_pesanan($id)
    {
        $this->db->where('id_pesanan', $id);
        $this->db->delete('pesanan');
    }

}