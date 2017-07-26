<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property Mustahiq_model $Mustahiq_model
 */


class Mustahiq extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Mustahiq_model', '', TRUE);

    }

    public function index()
    {
        echo "Access Denied";
    }

    function all_mustahiq()
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['mustahiq'] = $this->Mustahiq_model->get_all_mustahiq();
        echo json_encode($response);
    }

    function mustahiq($page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['mustahiq'] = $this->Mustahiq_model->get_mustahiq($page,false);
        echo json_encode($response);
    }

    function donasi_by_location($lat,$long)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['mustahiq'] = $this->Mustahiq_model->get_mustahiq_by_location($lat,$long);
        echo json_encode($response);
    }

    function donasi($page = null,$keyword=null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['mustahiq'] = $this->Mustahiq_model->get_mustahiq($page,true,$keyword);
        echo json_encode($response);
    }

    function detail_mustahiq($id_mustahiq)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_mustahiq = $this->Mustahiq_model->getmustahiqById($id_mustahiq);
        if ($detail_mustahiq == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['mustahiq'] = $detail_mustahiq;
        echo json_encode($response);
    }

    function addedit_mustahiq()
    {
        $id_mustahiq = $this->input->post('id_mustahiq');
        $id_calon_mustahiq = $this->input->post('id_calon_mustahiq');
        $id_amil_zakat = $this->input->post('id_amil_zakat');
        $status_mustahiq = $this->input->post('status_mustahiq');
        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if (
            $id_calon_mustahiq != null
            || $id_amil_zakat != null
            || $status_mustahiq != null
        ) {
            $mustahiq = array(
                'id_calon_mustahiq' => $id_calon_mustahiq,
                'id_amil_zakat' => $id_amil_zakat,
                'status_mustahiq' => $status_mustahiq
            );

            $nb = $this->Mustahiq_model->cek_id_mustahiq($id_calon_mustahiq);

            if ($id_mustahiq != null) {
                if (strtolower($nb["id_calon_mustahiq"]) == strtolower($id_calon_mustahiq) || $nb == null) {
                    $action_mustahiq = $this->Mustahiq_model->updatemustahiq($id_mustahiq, $mustahiq);
                    if ($action_mustahiq) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil mengedit mustahiq";
                        $detail_mustahiq = $this->Mustahiq_model->getmustahiqById($id_mustahiq);
                        $response['mustahiq'] = $detail_mustahiq;
                    } else {
                        $response['message'] = "gagal mengedit mustahiq";
                    }
                } else {
                    $response['message'] = "mustahiq sudah ada...";
                }

            } else {
                if ($nb != null) {
                    $response['message'] = "mustahiq  sudah ada...";
                } else {
                    $action_mustahiq = $this->Mustahiq_model->insertmustahiq($mustahiq);
                    if ($action_mustahiq) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil menambah mustahiq";
                        $detail_mustahiq = $this->Mustahiq_model->getLastmustahiq();
                        $response['mustahiq'] = $detail_mustahiq;
                    } else {
                        $response['message'] = "gagal menambah mustahiq";
                    }
                }
            }
        }
        echo json_encode($response);
    }

    function delete_mustahiq($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus mustahiq";
        $this->Mustahiq_model->delete_mustahiq($id);
        echo json_encode($response);
    }


    function addrekomendasi($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil merekomendasikan mustahiq";
        $this->Mustahiq_model->addrekomendasi($id);
        echo json_encode($response);
    }




}
