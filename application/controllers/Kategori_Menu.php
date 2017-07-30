<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property Kategori_menu_model $Kategori_menu_model
 */


class Kategori_menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Kategori_menu_model', '', TRUE); //inisialisasi model kategori menu

    }

    public function index()
    {
        echo "Access Denied";
    }

    function all_kategori_menu()
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['kategori_menu'] = $this->Kategori_menu_model->get_all_kategori_menu(); //method get kategori menu
        echo json_encode($response);
    }

    function kategori_menu($page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['kategori_menu'] = $this->Kategori_menu_model->get_kategori_menu($page);
        echo json_encode($response);
    }

    function detail_kategori_menu($id_kategori_menu)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_kategori_menu = $this->Kategori_menu_model->getkategori_menuById($id_kategori_menu);
        if ($detail_kategori_menu == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['kategori_menu'] = $detail_kategori_menu;
        echo json_encode($response);
    }

    function addeditkategori_menu()
    {
        $id_kategori_menu = $this->input->post('id_kategori_menu');
        $nama_kategori_menu = $this->input->post('nama_kategori_menu');
        
        $gambar_kategori_menu= $this->input->post('gambar_kategori_menu');


        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if ($nama_kategori_menu != null
            || $gambar_kategori_menu!= null
        ) {
            $kategori_menu = array(
                'nama_kategori_menu' => $nama_kategori_menu,
            );

            $new_name = time();
            $upload_path = APPPATH . '../source/upload/image/gambar_kategori_menu/';

            if ($gambar_kategori_menu == null) {
                $url_gambar_kategori_menu = "";
            } else {

                $image_gambar_kategori_menu = base64_decode(str_replace('data:image/jpg;base64,', '', $gambar_kategori_menu));
                $file_name_gambar_kategori_menu = "gambar_kategori_menu_".$new_name;

                if (file_put_contents($upload_path . $file_name_gambar_kategori_menu . ".jpg", $image_gambar_kategori_menu)) {
                    $url_gambar_kategori_menu = "/source/upload/image/gambar_kategori_menu/" . $file_name_gambar_kategori_menu . ".jpg";
                } else {
                    echo json_encode($response);
                    return;
                }
            }

            $nb = $this->Kategori_menu_model->cek_nama_kategori_menu($nama_kategori_menu);

            if ($id_kategori_menu != null) {
                if (strtolower($nb["nama_kategori_menu"]) == strtolower($nama_kategori_menu) || $nb == null) {
                    $action_kategori_menu = $this->Kategori_menu_model->updatekategori_menu($id_kategori_menu, $kategori_menu);
                    if ($action_kategori_menu) {
                        if ($gambar_kategori_menu != null) {
                            $kategori_menu = array(
                                'gambar_kategori_menu' => $url_gambar_kategori_menu
                            );
                            $this->Kategori_menu_model->updatekategori_menu($id_kategori_menu, $kategori_menu);
                        }

                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil mengedit kategori_menu";
                        $detail_kategori_menu = $this->Kategori_menu_model->getkategori_menuById($id_kategori_menu);
                        $response['kategori_menu'] = $detail_kategori_menu;
                    } else {
                        $response['message'] = "gagal mengedit kategori_menu";
                    }
                } else {
                    $response['message'] = "kategori_menu dengan nama : $nama_kategori_menu , sudah ada...";
                }

            } else {
                if ($nb != null) {
                    $response['message'] = "kategori_menu dengan nama : $nama_kategori_menu , sudah ada...";
                } else {
                    $action_kategori_menu = $this->Kategori_menu_model->insertkategori_menu($kategori_menu);
                    if ($action_kategori_menu) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil menambah kategori_menu";
                        $detail_kategori_menu = $this->Kategori_menu_model->getLastkategori_menu();
                        $response['kategori_menu'] = $detail_kategori_menu;
                        if ($gambar_kategori_menu != null) {
                            $kategori_menu = array(
                                'gambar_kategori_menu' => $url_gambar_kategori_menu
                            );
                            $this->Kategori_menu_model->updatekategori_menu($detail_kategori_menu['id_kategori_menu'], $kategori_menu);
                        }
                     
                    } else {
                        $response['message'] = "gagal menambah kategori_menu";
                    }
                }
            }
        }
        echo json_encode($response);
    }

    function delete_kategori_menu($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus kategori_menu";
        $this->Kategori_menu_model->delete_kategori_menu($id);
        echo json_encode($response);
    }


}
