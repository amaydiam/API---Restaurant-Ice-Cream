<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes_url extends CI_Controller
{
    function __construct()
    {
        parent::__construct();


    }

    public function index()
    {
        $response['isSuccess'] = true;
        echo json_encode($response);
    }

}
