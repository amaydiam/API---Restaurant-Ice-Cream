<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Sub_kategori_menu_model $Sub_kategori_menu_model
 */
class Sub_kategori_menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Sub_kategori_menu_model', '', TRUE); //inisialisasi model kategori menu

    }

    public function index()
    {
        echo "Access Denied";
    }

    function all_sub_kategori_menu()
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['sub_kategori_menu'] = $this->Sub_kategori_menu_model->get_all_sub_kategori_menu(); //method get kategori menu
        echo json_encode($response);
    }

    function sub_kategori_menu($id_kategori_menu,$page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['sub_kategori_menu'] = $this->Sub_kategori_menu_model->get_sub_kategori_menu($id_kategori_menu,$page);
        echo json_encode($response);
    }

    function detail_sub_kategori_menu($id_sub_kategori_menu)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_sub_kategori_menu = $this->Sub_kategori_menu_model->getsub_kategori_menuById($id_sub_kategori_menu);
        if ($detail_sub_kategori_menu == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['sub_kategori_menu'] = $detail_sub_kategori_menu;
        echo json_encode($response);
    }

    function addeditsub_kategori_menu()
    {
        //
        $id_sub_kategori_menu = $this->input->post('id_sub_kategori_menu');
        $id_kategori_menu = $this->input->post('id_kategori_menu');
        $nama_sub_kategori_menu = $this->input->post('nama_sub_kategori_menu');
        $gambar_sub_kategori_menu = $this->input->post('gambar_sub_kategori_menu');


        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if (
            $id_kategori_menu != null
            || $nama_sub_kategori_menu != null
            || $gambar_sub_kategori_menu != null
        ) {
            $sub_kategori_menu = array(
                'id_kategori_menu' => $id_kategori_menu,
                'nama_sub_kategori_menu' => $nama_sub_kategori_menu,
            );

            $new_name = time();
            $upload_path = APPPATH . '../source/upload/image/gambar_sub_kategori_menu/';

            if ($gambar_sub_kategori_menu == null) {
                $url_gambar_sub_kategori_menu = "";
            } else {

                $image_gambar_sub_kategori_menu = base64_decode(str_replace('data:image/jpg;base64,', '', $gambar_sub_kategori_menu));
                $file_name_gambar_sub_kategori_menu = "gambar_sub_kategori_menu_" . $new_name;

                if (file_put_contents($upload_path . $file_name_gambar_sub_kategori_menu . ".jpg", $image_gambar_sub_kategori_menu)) {
                    $url_gambar_sub_kategori_menu = "/source/upload/image/gambar_sub_kategori_menu/" . $file_name_gambar_sub_kategori_menu . ".jpg";
                } else {
                    echo json_encode($response);
                    return;
                }
            }

            $nb = $this->Sub_kategori_menu_model->cek_nama_sub_kategori_menu($nama_sub_kategori_menu);

            if ($id_sub_kategori_menu != null) {
                if (strtolower($nb["nama_sub_kategori_menu"]) == strtolower($nama_sub_kategori_menu) || $nb == null) {
                    $action_sub_kategori_menu = $this->Sub_kategori_menu_model->updatesub_kategori_menu($id_sub_kategori_menu, $sub_kategori_menu);
                    if ($action_sub_kategori_menu) {
                        if ($gambar_sub_kategori_menu != null) {
                            $sub_kategori_menu = array(
                                'gambar_sub_kategori_menu' => $url_gambar_sub_kategori_menu
                            );
                            $this->Sub_kategori_menu_model->updatesub_kategori_menu($id_sub_kategori_menu, $sub_kategori_menu);
                        }

                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil mengedit sub_kategori_menu";
                        $detail_sub_kategori_menu = $this->Sub_kategori_menu_model->getsub_kategori_menuById($id_sub_kategori_menu);
                        $response['sub_kategori_menu'] = $detail_sub_kategori_menu;
                    } else {
                        $response['message'] = "gagal mengedit sub_kategori_menu";
                    }
                } else {
                    $response['message'] = "sub_kategori_menu dengan nama : $nama_sub_kategori_menu , sudah ada...";
                }

            } else {
                if ($nb != null) {
                    $response['message'] = "sub_kategori_menu dengan nama : $nama_sub_kategori_menu , sudah ada...";
                } else {
                    $action_sub_kategori_menu = $this->Sub_kategori_menu_model->insertsub_kategori_menu($sub_kategori_menu);
                    if ($action_sub_kategori_menu) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil menambah sub_kategori_menu";
                        $detail_sub_kategori_menu = $this->Sub_kategori_menu_model->getLastsub_kategori_menu();
                        $response['sub_kategori_menu'] = $detail_sub_kategori_menu;
                        if ($gambar_sub_kategori_menu != null) {
                            $sub_kategori_menu = array(
                                'gambar_sub_kategori_menu' => $url_gambar_sub_kategori_menu
                            );
                            $this->Sub_kategori_menu_model->updatesub_kategori_menu($detail_sub_kategori_menu['id_sub_kategori_menu'], $sub_kategori_menu);
                        }

                    } else {
                        $response['message'] = "gagal menambah sub_kategori_menu";
                    }
                }
            }
        }
        echo json_encode($response);
    }

    function delete_sub_kategori_menu($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus sub_kategori_menu";
        $this->Sub_kategori_menu_model->delete_sub_kategori_menu($id);
        echo json_encode($response);
    }


}
