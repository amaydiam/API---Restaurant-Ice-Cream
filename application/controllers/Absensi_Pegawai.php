<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Absensi_pegawai_model $Absensi_pegawai_model
 */
class Absensi_pegawai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Absensi_pegawai_model', '', TRUE);

    }

    public function index()
    {
        echo "Access Denied";
    }



    function absen()
    {
        $tipe_pegawai = $this->input->post('tipe_pegawai');
        $id_one_signal = $this->input->post('id_one_signal');

        $response['isSuccess'] = false;
        $response['message'] = "Absensi gagal";

        $absen = array(
            'tipe_pegawai' => $tipe_pegawai,
            'id_one_signal' => $id_one_signal
        );

        $nb = $this->Absensi_pegawai_model->insertabsensi_pegawai($absen);

        if ($nb) {
            $response['isSuccess'] = true;
            $response['message'] = "berhasil absen";
            $response['user'] = $nb;
        }


        echo json_encode($response);
    }


    
    
    

}
