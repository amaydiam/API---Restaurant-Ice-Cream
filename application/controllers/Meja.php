<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property Meja_model $Meja_model
 */


class Meja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Meja_model', '', TRUE); //inisialisasi model Meja

    }

    public function index()
    {
        echo "Access Denied";
    }

    function all_meja()
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['meja'] = $this->Meja_model->get_all_meja(); //method get Meja
        echo json_encode($response);
    }

    function meja($page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['meja'] = $this->Meja_model->get_meja($page);
        echo json_encode($response);
    }

    function detail_meja($id_meja)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_meja = $this->Meja_model->getmejaById($id_meja);
        if ($detail_meja == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['meja'] = $detail_meja;
        echo json_encode($response);
    }

    function addeditmeja()
    {
        $id_meja = $this->input->post('id_meja');
        $nama_meja = $this->input->post('nama_meja');
      

        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if ($nama_meja != null
        ) {
            $meja = array(
                'nama_meja' => $nama_meja,
               
            );

           
            $nb = $this->Meja_model->cek_nama_meja($nama_meja);

            if ($id_meja != null) {
                if (strtolower($nb["nama_meja"]) == strtolower($nama_meja) || $nb == null) {
                    $action_meja = $this->Meja_model->updatemeja($id_meja, $meja);
                    if ($action_meja) {

                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil mengedit meja";
                        $detail_meja = $this->Meja_model->getmejaById($id_meja);
                        $response['meja'] = $detail_meja;
                    } else {
                        $response['message'] = "gagal mengedit meja";
                    }
                } else {
                    $response['message'] = "meja dengan No Identitas : $nama_meja , sudah ada...";
                }

            } else {
                if ($nb != null) {
                    $response['message'] = "meja dengan No Identitas : $nama_meja , sudah ada...";
                } else {
                    $action_meja = $this->Meja_model->insertmeja($meja);
                    if ($action_meja) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil menambah meja";
                        $detail_meja = $this->Meja_model->getLastmeja();
                        $response['meja'] = $detail_meja;

                    } else {
                        $response['message'] = "gagal menambah meja";
                    }
                }
            }
        }
        echo json_encode($response);//untuk pasing data json
    }

    function delete_meja($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus meja";
        $this->Meja_model->delete_meja($id);
        echo json_encode($response);
    }


}
