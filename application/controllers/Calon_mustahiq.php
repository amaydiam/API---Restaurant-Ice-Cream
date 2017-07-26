<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property Calon_mustahiq_model $Calon_mustahiq_model
 */


class Calon_mustahiq extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Calon_mustahiq_model', '', TRUE); //inisialisasi model calon mustahiq

    }

    public function index()
    {
        echo "Access Denied";
    }

    function all_calon_mustahiq()
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['calon_mustahiq'] = $this->Calon_mustahiq_model->get_all_calon_mustahiq(); //method get calon mustahiq
        echo json_encode($response);
    }

    function calon_mustahiq($page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['calon_mustahiq'] = $this->Calon_mustahiq_model->get_calon_mustahiq($page);
        echo json_encode($response);
    }

    function detail_calon_mustahiq($id_calon_mustahiq)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_calon_mustahiq = $this->Calon_mustahiq_model->getcalon_mustahiqById($id_calon_mustahiq);
        if ($detail_calon_mustahiq == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['calon_mustahiq'] = $detail_calon_mustahiq;
        echo json_encode($response);
    }

    function addeditcalon_mustahiq()
    {
        $id_calon_mustahiq = $this->input->post('id_calon_mustahiq');
        $nama_calon_mustahiq = $this->input->post('nama_calon_mustahiq');
        $alamat_calon_mustahiq = $this->input->post('alamat_calon_mustahiq');
        $latitude_calon_mustahiq = $this->input->post('latitude_calon_mustahiq');
        $longitude_calon_mustahiq = $this->input->post('longitude_calon_mustahiq');
        $no_identitas_calon_mustahiq = $this->input->post('no_identitas_calon_mustahiq');
        $no_telp_calon_mustahiq = $this->input->post('no_telp_calon_mustahiq');
        $id_user_perekomendasi= $this->input->post('id_user_perekomendasi');
        $alasan_perekomendasi_calon_mustahiq= $this->input->post('alasan_perekomendasi_calon_mustahiq');
        $photo_1= $this->input->post('photo_1');
        $photo_2= $this->input->post('photo_2');
        $photo_3= $this->input->post('photo_3');

        $caption_photo_1= $this->input->post('caption_photo_1');
        $caption_photo_2= $this->input->post('caption_photo_2');
        $caption_photo_3= $this->input->post('caption_photo_3');

        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if ($nama_calon_mustahiq != null
            || $alamat_calon_mustahiq != null
            || $latitude_calon_mustahiq != null
            || $longitude_calon_mustahiq != null
            || $no_identitas_calon_mustahiq != null
            || $no_telp_calon_mustahiq != null
            || $id_user_perekomendasi!= null
            || $alasan_perekomendasi_calon_mustahiq!= null
            || $photo_1!= null
            || $photo_2!= null
            || $photo_3!= null
            || $caption_photo_1!= null
            || $caption_photo_2!= null
            || $caption_photo_3!= null
        ) {
            $calon_mustahiq = array(
                'nama_calon_mustahiq' => $nama_calon_mustahiq,
                'alamat_calon_mustahiq' => $alamat_calon_mustahiq,
                'latitude_calon_mustahiq' => $latitude_calon_mustahiq,
                'longitude_calon_mustahiq' => $longitude_calon_mustahiq,
                'no_identitas_calon_mustahiq' => $no_identitas_calon_mustahiq,
                'no_telp_calon_mustahiq' => $no_telp_calon_mustahiq,
                'id_user_perekomendasi' => $id_user_perekomendasi,
                'alasan_perekomendasi_calon_mustahiq' => $alasan_perekomendasi_calon_mustahiq,
                'caption_photo_1' => $caption_photo_1,
                'caption_photo_2' => $caption_photo_2,
                'caption_photo_3' => $caption_photo_3,

            );

            $new_name = time();
            $upload_path = APPPATH . '../source/upload/image/photo_calon_mustahiq/';

            if ($photo_1 == null) {
                $url_photo_1 = "";
            } else {

                $image_photo_1 = base64_decode(str_replace('data:image/jpg;base64,', '', $photo_1));
                $file_name_photo_1 = "photo_1_".$new_name;

                if (file_put_contents($upload_path . $file_name_photo_1 . ".jpg", $image_photo_1)) {
                    $url_photo_1 = "/source/upload/image/photo_calon_mustahiq/" . $file_name_photo_1 . ".jpg";
                } else {
                    echo json_encode($response);
                    return;
                }
            }

            if ($photo_2 == null) {
                $url_photo_2 = "";
            } else {

                $image_photo_2 = base64_decode(str_replace('data:image/jpg;base64,', '', $photo_2));
                $file_name_photo_2 = "photo_2_".$new_name;

                if (file_put_contents($upload_path . $file_name_photo_2 . ".jpg", $image_photo_2)) {
                    $url_photo_2 = "/source/upload/image/photo_calon_mustahiq/" . $file_name_photo_2 . ".jpg";
                } else {
                    echo json_encode($response);
                    return;
                }
            }

            if ($photo_3 == null) {
                $url_photo_3 = "";
            } else {

                $image_photo_3 = base64_decode(str_replace('data:image/jpg;base64,', '', $photo_3));
                $file_name_photo_3 = "photo_3_".$new_name;

                if (file_put_contents($upload_path . $file_name_photo_3 . ".jpg", $image_photo_3)) {
                    $url_photo_3 = "/source/upload/image/photo_calon_mustahiq/" . $file_name_photo_3 . ".jpg";
                } else {
                    echo json_encode($response);
                    return;
                }
            }


            $nb = $this->Calon_mustahiq_model->cek_no_identitas_calon_mustahiq($no_identitas_calon_mustahiq);

            if ($id_calon_mustahiq != null) {
                if (strtolower($nb["no_identitas_calon_mustahiq"]) == strtolower($no_identitas_calon_mustahiq) || $nb == null) {
                    $action_calon_mustahiq = $this->Calon_mustahiq_model->updatecalon_mustahiq($id_calon_mustahiq, $calon_mustahiq);
                    if ($action_calon_mustahiq) {
                        if ($photo_1 != null) {
                            $calon_mustahiq = array(
                                'photo_1' => $url_photo_1
                            );
                            $this->Calon_mustahiq_model->updatecalon_mustahiq($id_calon_mustahiq, $calon_mustahiq);
                        }
                        if ($photo_2 != null) {
                            $calon_mustahiq = array(
                                'photo_2' => $url_photo_2
                            );
                            $this->Calon_mustahiq_model->updatecalon_mustahiq($id_calon_mustahiq, $calon_mustahiq);
                        }
                        if ($photo_3 != null) {
                            $calon_mustahiq = array(
                                'photo_3' => $url_photo_3
                            );
                            $this->Calon_mustahiq_model->updatecalon_mustahiq($id_calon_mustahiq, $calon_mustahiq);
                        }

                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil mengedit calon_mustahiq";
                        $detail_calon_mustahiq = $this->Calon_mustahiq_model->getcalon_mustahiqById($id_calon_mustahiq);
                        $response['calon_mustahiq'] = $detail_calon_mustahiq;
                    } else {
                        $response['message'] = "gagal mengedit calon_mustahiq";
                    }
                } else {
                    $response['message'] = "calon_mustahiq dengan No Identitas : $no_identitas_calon_mustahiq , sudah ada...";
                }

            } else {
                if ($nb != null) {
                    $response['message'] = "calon_mustahiq dengan No Identitas : $no_identitas_calon_mustahiq , sudah ada...";
                } else {
                    $action_calon_mustahiq = $this->Calon_mustahiq_model->insertcalon_mustahiq($calon_mustahiq);
                    if ($action_calon_mustahiq) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil menambah calon_mustahiq";
                        $detail_calon_mustahiq = $this->Calon_mustahiq_model->getLastcalon_mustahiq();
                        $response['calon_mustahiq'] = $detail_calon_mustahiq;
                        if ($photo_1 != null) {
                            $calon_mustahiq = array(
                                'photo_1' => $url_photo_1
                            );
                            $this->Calon_mustahiq_model->updatecalon_mustahiq($detail_calon_mustahiq['id_calon_mustahiq'], $calon_mustahiq);
                        }
                        if ($photo_2 != null) {
                            $calon_mustahiq = array(
                                'photo_2' => $url_photo_2
                            );
                            $this->Calon_mustahiq_model->updatecalon_mustahiq($detail_calon_mustahiq['id_calon_mustahiq'], $calon_mustahiq);
                        }
                        if ($photo_3 != null) {
                            $calon_mustahiq = array(
                                'photo_3' => $url_photo_3
                            );
                            $this->Calon_mustahiq_model->updatecalon_mustahiq($detail_calon_mustahiq['id_calon_mustahiq'], $calon_mustahiq);
                        }
                    } else {
                        $response['message'] = "gagal menambah calon_mustahiq";
                    }
                }
            }
        }
        echo json_encode($response);//untuk pasing data json
    }

    function delete_calon_mustahiq($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus calon_mustahiq";
        $this->Calon_mustahiq_model->delete_calon_mustahiq($id);
        echo json_encode($response);
    }


}
