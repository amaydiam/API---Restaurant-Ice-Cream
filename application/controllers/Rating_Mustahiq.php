<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Rating_Mustahiq_model $Rating_Mustahiq_model
 * @property Mustahiq_model $Mustahiq_model
 */
class Rating_mustahiq extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Rating_Mustahiq_model', '', TRUE);
        $this->load->model('Mustahiq_model', '', TRUE);
    }


    public function index()
    {
        echo "Access Denied";
    }


    function addrating()
    {

        $id_mustahiq = $this->input->post('id_mustahiq');
        $rating = $this->input->post('rating');
        $id_user = $this->input->post('id_user');


        $response['isSuccess'] = false;
        $response['message'] = "Error";

        if ($id_mustahiq != null
            && $rating != null
        ) {

            $rating = array(
                'id_mustahiq' => $id_mustahiq,
                'rating' => $rating,
                'id_user' => $id_user,
            );
            $action_rating = $this->Rating_Mustahiq_model->insertrating($rating);

            if ($action_rating) {
                $response['isSuccess'] = true;
                $response['message'] = "Rating telah dikirim";
                $detail_mustahiq = $this->Mustahiq_model->getmustahiqById($id_mustahiq);
                $response['mustahiq'] = $detail_mustahiq;

            } else {
                $response['message'] = "Rating gagal";
            }


        }
        echo json_encode($response);
    }


}
