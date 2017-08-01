<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Absensi_meja_model $Absensi_meja_model
 */
class Absensi_meja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Absensi_meja_model', '', TRUE);

    }

    public function index()
    {
        echo "Access Denied";
    }



    function absen()
    {
        $id_meja = $this->input->post('id_meja');
        $id_one_signal = $this->input->post('id_one_signal');

        $response['isSuccess'] = false;
        $response['message'] = "Absensi gagal";

        $absen = array(
            'id_meja' => $id_meja,
            'id_one_signal' => $id_one_signal
        );

        $nb = $this->Absensi_meja_model->insertabsensi_meja($absen);

        if ($nb) {
            $response['isSuccess'] = true;
            $response['message'] = "berhasil absen";
            $response['user'] = $nb;
        }


        echo json_encode($response);
    }


    
    
    

}
