<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Menu_model $menu_model
 */
class Menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('menu_model', '', TRUE); //inisialisasi model kategori menu

    }

    public function index()
    {
        echo "Access Denied";
    }

    function all_menu()
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['menu'] = $this->menu_model->get_all_menu(); //method get kategori menu
        echo json_encode($response);
    }

    function menu($id_sub_kategori_menu,$page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['menu'] = $this->menu_model->get_menu($id_sub_kategori_menu,$page);
        echo json_encode($response);
    }

    function detail_menu($id_menu)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_menu = $this->menu_model->getmenuById($id_menu);
        if ($detail_menu == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['menu'] = $detail_menu;
        echo json_encode($response);
    }

    function addeditmenu()
    {
        $id_menu = $this->input->post('id_menu');
        $id_sub_kategori_menu = $this->input->post('id_sub_kategori_menu');
        $nama_menu = $this->input->post('nama_menu');
        $harga = $this->input->post('harga_menu');
        $stok = $this->input->post('stok_menu');
        $gambar_menu = $this->input->post('gambar_menu');


        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if (
            $id_sub_kategori_menu != null
            || $nama_menu != null
            || $harga != null
            || $stok != null
            || $gambar_menu != null
        ) {
            $menu = array(
                'id_sub_kategori_menu' => $id_sub_kategori_menu,
                'harga_menu' => $harga,
                'nama_menu' => $nama_menu,
            );

            $new_name = time();
            $upload_path = APPPATH . '../source/upload/image/gambar_menu/';

            if ($gambar_menu == null) {
                $url_gambar_menu = "";
            } else {

                $image_gambar_menu = base64_decode(str_replace('data:image/jpg;base64,', '', $gambar_menu));
                $file_name_gambar_menu = "gambar_menu_" . $new_name;

                if (file_put_contents($upload_path . $file_name_gambar_menu . ".jpg", $image_gambar_menu)) {
                    $url_gambar_menu = "/source/upload/image/gambar_menu/" . $file_name_gambar_menu . ".jpg";
                } else {
                    echo json_encode($response);
                    return;
                }
            }

            $nb = $this->menu_model->cek_nama_menu($nama_menu);

            if ($id_menu != null) {
                if (strtolower($nb["nama_menu"]) == strtolower($nama_menu) || $nb == null) {
                    $action_menu = $this->menu_model->updatemenu($id_menu, $menu);
                    if ($action_menu) {
                        if ($gambar_menu != null) {
                            $menu = array(
                                'gambar_menu' => $url_gambar_menu
                            );
                            $this->menu_model->updatemenu($id_menu, $menu);
                        }

                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil mengedit menu";
                        $detail_menu = $this->menu_model->getmenuById($id_menu);
                        $response['menu'] = $detail_menu;
                    } else {
                        $response['message'] = "gagal mengedit menu";
                    }
                } else {
                    $response['message'] = "menu dengan nama : $nama_menu , sudah ada...";
                }

            } else {
                if ($nb != null) {
                    $response['message'] = "menu dengan nama : $nama_menu , sudah ada...";
                } else {
                    $action_menu = $this->menu_model->insertmenu($menu);
                    if ($action_menu) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil menambah menu";
                        $detail_menu = $this->menu_model->getLastmenu();
                        $response['menu'] = $detail_menu;
                        if ($gambar_menu != null) {
                            $menu = array(
                                'gambar_menu' => $url_gambar_menu
                            );
                            $this->menu_model->updatemenu($detail_menu['id_menu'], $menu);
                        }

                    } else {
                        $response['message'] = "gagal menambah menu";
                    }
                }
            }
        }
        echo json_encode($response);
    }

    function delete_menu($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus menu";
        $this->menu_model->delete_menu($id);
        echo json_encode($response);
    }


}
