<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property Amil_zakat_model $Amil_zakat_model
 */


class Amil_zakat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Amil_zakat_model', '', TRUE);

    }

    public function index()
    {
        echo "Access Denied";
    }

    function all_amil_zakat()
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['amil_zakat'] = $this->Amil_zakat_model->get_all_amil_zakat();
        echo json_encode($response);
    }

    function amil_zakat($page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['amil_zakat'] = $this->Amil_zakat_model->get_amil_zakat($page,false);
        echo json_encode($response);
    }

    function detail_amil_zakat($id_amil_zakat)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_amil_zakat = $this->Amil_zakat_model->getAmil_zakatById($id_amil_zakat);
        if ($detail_amil_zakat == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['amil_zakat'] = $detail_amil_zakat;
        echo json_encode($response);
    }

    function addeditamil_zakat()
    {
        $id_amil_zakat = $this->input->post('id_amil_zakat');
        $nama_amil_zakat = $this->input->post('nama_amil_zakat');
        $alamat_amil_zakat = $this->input->post('alamat_amil_zakat');
        $no_identitas_amil_zakat = $this->input->post('no_identitas_amil_zakat');
        $no_telp_amil_zakat = $this->input->post('no_telp_amil_zakat');
        $validasi_amil_zakat = $this->input->post('validasi_amil_zakat');
        $status_amil_zakat = $this->input->post('status_amil_zakat');
        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if ($nama_amil_zakat != null
            || $alamat_amil_zakat != null
            || $no_identitas_amil_zakat != null
            || $no_telp_amil_zakat != null
            || $validasi_amil_zakat != null
            || $status_amil_zakat != null
        ) {
            $amil_zakat = array(
                'nama_amil_zakat' => $nama_amil_zakat,
                'alamat_amil_zakat' => $alamat_amil_zakat,
                'no_identitas_amil_zakat' => $no_identitas_amil_zakat,
                'no_telp_amil_zakat' => $no_telp_amil_zakat,
                'validasi_amil_zakat' => $validasi_amil_zakat,
                'status_amil_zakat' => $status_amil_zakat

            );

            $nb = $this->Amil_zakat_model->cek_no_identitas_amil_zakat($no_identitas_amil_zakat);

            if ($id_amil_zakat != null) {
                if (strtolower($nb["no_identitas_amil_zakat"]) == strtolower($no_identitas_amil_zakat) || $nb == null) {
                    $action_amil_zakat = $this->Amil_zakat_model->updateamil_zakat($id_amil_zakat, $amil_zakat);
                    if ($action_amil_zakat) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil mengedit amil_zakat";
                    } else {
                        $response['message'] = "gagal mengedit amil_zakat";
                    }
                } else {
                    $response['message'] = "Amil_zakat dengan No Identitas : $no_identitas_amil_zakat , sudah ada...";
                }

            } else {
                if ($nb != null) {
                    $response['message'] = "Amil_zakat dengan No Identitas : $no_identitas_amil_zakat , sudah ada...";
                } else {
                    $action_amil_zakat = $this->Amil_zakat_model->insertamil_zakat($amil_zakat);
                    if ($action_amil_zakat) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil menambah amil_zakat";
                    } else {
                        $response['message'] = "gagal menambah amil_zakat";
                    }
                }
            }
        }
        echo json_encode($response);
    }

    function delete_amil_zakat($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus amil_zakat";
        $this->Amil_zakat_model->delete_amil_zakat($id);
        echo json_encode($response);
    }


}
