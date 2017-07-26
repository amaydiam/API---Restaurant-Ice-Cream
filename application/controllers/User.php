<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 */
class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('User_model', '', TRUE);

    }

    public function index()
    {
        echo "Access Denied";
    }

    function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');


        $response['isSuccess'] = false;
        $response['message'] = "Username atau Password salah ...";

        $nb = $this->User_model->login($username, $password);

        if ($nb != null) {
            $response['isSuccess'] = true;
            $response['message'] = "berhasil login";
            $response['user'] = $nb;
        }


        echo json_encode($response);
    }

    function register()
    {
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $no_telp = $this->input->post('no_telp');
        $no_identitas = $this->input->post('no_identitas');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = array(
            'username' => $username,
            'password' => $password,
            'nama' => $nama,
            'alamat' => $alamat,
            'no_identitas' => $no_identitas,
            'no_telp' => $no_telp
        );


        $response['isSuccess'] = false;
        $response['message'] = "User ada...";

        $nb = $this->User_model->cekusername($username);

        if ($nb == null) {
            $action = $this->User_model->insertuser($user);
            if ($action) {
                $nb = $this->User_model->login($username, $password);

                if ($nb != null) {
                    $response['isSuccess'] = true;
                    $response['message'] = "berhasil login";
                    $response['user'] = $nb;
                }
                else
                    $response['message'] = "Ada kesalahan...";
            }
            else
                $response['message'] = "Ada kesalahan...";

        }


        echo json_encode($response);
    }



}
