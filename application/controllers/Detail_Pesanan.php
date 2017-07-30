<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property Detail_Pesanan_model $Detail_Pesanan_model
 */


class Detail_Pesanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Detail_Pesanan_model', '', TRUE); //inisialisasi model Pesanan

    }

    public function index()
    {
        echo "Access Denied";
    }

    function detail_pesanan($id_pesanan)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['detail_pesanan'] = $this->Detail_Pesanan_model->get_all_detail_pesanan($id_pesanan); //method get Pesanan
        echo json_encode($response);
    }


    function detail_detail_pesanan($id_detail_pesanan)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_detail_pesanan = $this->Detail_Pesanan_model->getdetail_pesananById($id_detail_pesanan);
        if ($detail_detail_pesanan == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['detail_pesanan'] = $detail_detail_pesanan;
        echo json_encode($response);
    }

    function delete_detail_pesanan($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus detail_pesanan";
        $this->Detail_Pesanan_model->delete_detail_pesanan($id);
        echo json_encode($response);
    }


}
