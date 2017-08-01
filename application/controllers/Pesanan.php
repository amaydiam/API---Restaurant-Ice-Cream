<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Pesanan_model $Pesanan_model
 * @property Detail_Pesanan_model $Detail_Pesanan_model
 * @property Absensi_pegawai_model $Absensi_pegawai_model
 * @property Absensi_meja_model $Absensi_meja_model
 */
class Pesanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Pesanan_model', '', TRUE); //inisialisasi model Pesanan
        $this->load->model('Detail_Pesanan_model', '', TRUE); //inisialisasi model Pesanan
        $this->load->model('Absensi_pegawai_model', '', TRUE); //inisialisasi model Pesanan
        $this->load->model('Absensi_meja_model', '', TRUE); //inisialisasi model Pesanan

    }

    public function index()
    {
        echo "Access Denied";
    }

    function all_pesanan()
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['pesanan'] = $this->Pesanan_model->get_all_pesanan(); //method get Pesanan
        echo json_encode($response);
    }

    function pesanan_pelanggan($id_meja, $page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['pesanan'] = $this->Pesanan_model->get_pesanan_pelanggan($id_meja, $page);
        echo json_encode($response);
    }

    function pesanan_pelayan($page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['pesanan'] = $this->Pesanan_model->get_pesanan_pelayan($page);
        echo json_encode($response);
    }

    function pesanan_kasir($page = null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['pesanan'] = $this->Pesanan_model->get_pesanan_kasir($page);
        echo json_encode($response);
    }


    function detail_pesanan($id_pesanan)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_pesanan = $this->Pesanan_model->getpesananById($id_pesanan);
        if ($detail_pesanan == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['pesanan'] = $detail_pesanan;
        echo json_encode($response);
    }


    function pesanan_baru()
    {
        $id_meja = $this->input->post('id_meja');
        $kode_pesanan = $this->input->post('kode_pesanan');
        $nama_pemesan = $this->input->post('nama_pemesan');
        $catatan = $this->input->post('catatan');
        $pesanan_baru = $this->input->post('pesanan_baru');


        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if ($nama_pemesan != null || $kode_pesanan != null || $nama_pemesan != null || $catatan != null
        ) {
            $pesanan = array(
                'id_meja' => $id_meja,
                'kode_pesanan' => $kode_pesanan,
                'nama_pemesan' => $nama_pemesan,
                'catatan' => $catatan,

            );

            $action_pesanan = $this->Pesanan_model->insertpesanan($pesanan);

            if ($action_pesanan) {
                $response['isSuccess'] = true;
                $response['message'] = "berhasil menambah pesanan";

                $dpesanan = $this->Pesanan_model->getLastpesanan();


                $pb = explode("#", $pesanan_baru);

                for ($i = 0; $i < count($pb); $i++) {

                    if (strlen($pb[$i]) != 0) {

                        $dpb = explode("|", $pb[$i]);

                        $detail_pesanan = array(
                            'id_pesanan' => $dpesanan["id_pesanan"],
                            'id_menu' => $dpb[1],
                            'jumlah_pesanan' => $dpb[2],
                            'harga_pesanan' => $dpb[3],

                        );

                        $this->Detail_Pesanan_model->insertdetail_pesanan($detail_pesanan);

                    }

                }
                $pegawai = $this->Absensi_pegawai_model->getPelayan();
                $this->send_message($pegawai["id_one_signal"]);

            } else {
                $response['message'] = "gagal menambah pesanan";
            }

        }
        echo json_encode($response);//untuk pasing data json
    }


    function addeditpesanan()
    {
        $id_pesanan = $this->input->post('id_pesanan');
        $nama_pesanan = $this->input->post('nama_pesanan');


        $response['isSuccess'] = false;
        $response['message'] = "Error";
        if ($nama_pesanan != null
        ) {
            $pesanan = array(
                'nama_pesanan' => $nama_pesanan,

            );


            $nb = $this->Pesanan_model->cek_nama_pesanan($nama_pesanan);

            if ($id_pesanan != null) {
                if (strtolower($nb["nama_pesanan"]) == strtolower($nama_pesanan) || $nb == null) {
                    $action_pesanan = $this->Pesanan_model->updatepesanan($id_pesanan, $pesanan);
                    if ($action_pesanan) {

                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil mengedit pesanan";
                        $detail_pesanan = $this->Pesanan_model->getpesananById($id_pesanan);
                        $response['pesanan'] = $detail_pesanan;
                    } else {
                        $response['message'] = "gagal mengedit pesanan";
                    }
                } else {
                    $response['message'] = "pesanan dengan No Identitas : $nama_pesanan , sudah ada...";
                }

            } else {
                if ($nb != null) {
                    $response['message'] = "pesanan dengan No Identitas : $nama_pesanan , sudah ada...";
                } else {
                    $action_pesanan = $this->Pesanan_model->insertpesanan($pesanan);
                    if ($action_pesanan) {
                        $response['isSuccess'] = true;
                        $response['message'] = "berhasil menambah pesanan";
                        $detail_pesanan = $this->Pesanan_model->getLastpesanan();
                        $response['pesanan'] = $detail_pesanan;

                    } else {
                        $response['message'] = "gagal menambah pesanan";
                    }
                }
            }
        }
        echo json_encode($response);//untuk pasing data json
    }

    function disiapkan($id)
    {
        $response['isSuccess'] = false;
        $response['message'] = "Eror";
        $pesanan = array(
            'status_pesanan' => "Pesanan Sedang Disiapkan",
        );
        $action_pesanan = $this->Pesanan_model->updatepesanan($id, $pesanan);
        if ($action_pesanan) {
            $response['isSuccess'] = true;
            $response['message'] = "Disiapkan";
            $pelanggan = $this->Absensi_meja_model->getMejaByIdPesanan($id);
            $this->send_message($pelanggan["id_one_signal"]);
        }
        echo json_encode($response);
    }

    function dinikmati($id)
    {
        $response['isSuccess'] = false;
        $response['message'] = "Eror";
        $pesanan = array(
            'status_pesanan' => "Pesanan Sedang Dinikmati",
        );
        $action_pesanan = $this->Pesanan_model->updatepesanan($id, $pesanan);
        if ($action_pesanan) {
            $response['isSuccess'] = true;
            $response['message'] = "Dinikmati";
            $pelanggan = $this->Absensi_meja_model->getMejaByIdPesanan($id);
            $this->send_message($pelanggan["id_one_signal"]);
        }
        echo json_encode($response);
    }

    function dibatalkan($id)
    {
        $response['isSuccess'] = false;
        $response['message'] = "Eror";
        $pesanan = array(
            'status_pesanan' => "Pesanan Dibatalkan",
        );
        $action_pesanan = $this->Pesanan_model->updatepesanan($id, $pesanan);
        if ($action_pesanan) {
            $response['isSuccess'] = true;
            $response['message'] = "Dibatalkan";
            $pelanggan = $this->Absensi_meja_model->getMejaByIdPesanan($id);
            $this->send_message($pelanggan["id_one_signal"]);
            $pegawai = $this->Absensi_pegawai_model->getKasir();
            $this->send_message($pegawai["id_one_signal"]);
        }
        echo json_encode($response);
    }

    function dibayarkan($id)
    {
        $response['isSuccess'] = false;
        $response['message'] = "Eror";
        $pesanan = array(
            'status_pesanan' => "Pesanan Telah Dibayar",
        );
        $action_pesanan = $this->Pesanan_model->updatepesanan($id, $pesanan);
        if ($action_pesanan) {
            $response['isSuccess'] = true;
            $response['message'] = "Dibayar";
        }
        echo json_encode($response);
    }


    function delete_pesanan($id)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil menghapus pesanan";
        $this->Pesanan_model->delete_pesanan($id);
        echo json_encode($response);
    }

    function send_message($user_id)
    {

        $content = array(
            "en" => 'English Message'
        );

        $fields = array(
            'app_id' => "740cf3ca-3833-4d64-abcb-ba8bc169e62c",
            'include_player_ids' => array($user_id),
            'data' => array("foo" => "bar"),
            'contents' => $content
        );

        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MTIyY2NlNjAtMjliNi00NTA2LWE4M2YtOTc2ZDFlZDMzYmNl'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
      //  return $response;


    }


}
