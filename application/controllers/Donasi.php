<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Donasi_model $Donasi_model
 * @property Muzaki_model $Muzaki_model
 */
class Donasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Donasi_model', '', TRUE);
        $this->load->model('Muzaki_model', '', TRUE);
    }


    public function index()
    {
        echo "Access Denied";
    }


    function donasi($page = null,$keyword=null)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $response['donasi'] = $this->Donasi_model->get_donasi($page,$keyword);
        echo json_encode($response);
    }

    function detail_donasi($id_donasi)
    {
        $response['isSuccess'] = true;
        $response['message'] = "berhasil";
        $detail_donasi = $this->Donasi_model->getDonasiById($id_donasi);
        if ($detail_donasi == null) {
            $response['isSuccess'] = false;
            $response['message'] = "not available";
        }
        $response['donasi'] = $detail_donasi;
        echo json_encode($response);
    }



    function adddonasi()
    {

        $id_mustahiq = $this->input->post('id_mustahiq');
        $nama_muzaki = $this->input->post('nama_muzaki');
        $alamat_muzaki = $this->input->post('alamat_muzaki');
        $no_identitas_muzaki = $this->input->post('no_identitas_muzaki');
        $no_telp_muzaki = $this->input->post('no_telp_muzaki');
        $jumlah_donasi = $this->input->post('jumlah_donasi');

        $foto_bukti_pembayaran = $this->input->post('foto_bukti_pembayaran');

        $response['isSuccess'] = false;
        $response['message'] = "Error";

        if ($id_mustahiq != null
            && $nama_muzaki != null
            && $alamat_muzaki != null
            && $no_identitas_muzaki != null
            && $no_telp_muzaki != null
            && $jumlah_donasi != null
        ) {

            if ($foto_bukti_pembayaran == null) {
                $url_foto_bukti_pembayaran = "";
            } else {

                $image = base64_decode(str_replace('data:image/jpg;base64,', '', $foto_bukti_pembayaran));
                $upload_path = APPPATH . '../source/upload/image/foto_bukti_pembayaran/';
                $new_name = time();
                $file_name = $new_name;

                if (file_put_contents($upload_path . $file_name . ".jpg", $image)) {
                    $url_foto_bukti_pembayaran = "/source/upload/image/foto_bukti_pembayaran/" . $file_name . ".jpg";
                } else {
                    echo json_encode($response);
                    return;
                }
            }

            $muzaki = array(
                'nama_muzaki' => $nama_muzaki,
                'alamat_muzaki' => $alamat_muzaki,
                'no_identitas_muzaki' => $no_identitas_muzaki,
                'no_telp_muzaki' => $no_telp_muzaki
            );

            $action_muzaki = $this->Muzaki_model->insertmuzaki($muzaki);
            if ($action_muzaki) {
                $data_muzaki = $this->Muzaki_model->getLastMuzaki();
                $donasi = array(
                    'id_muzaki' => $data_muzaki["id_muzaki"],
                    'id_mustahiq' => $id_mustahiq,
                    'jumlah_donasi' => $jumlah_donasi,
                    'keterangan' => $url_foto_bukti_pembayaran

                );
                $action_donasi = $this->Donasi_model->insertdonasi($donasi);

                if ($action_donasi) {
                    $response['isSuccess'] = true;
                    $response['message'] = "Donasi telah dikirim";

                    $data_donasi= $this->Donasi_model->getLastDonasi();
                    $detail_donasi = $this->Donasi_model->getDonasiById($data_donasi["id_donasi"]);

                    $response['donasi'] = $detail_donasi;

                }
                else{
                    $response['message'] = "Donasi gagal";
                }

            } else {
                $response['message'] = "Donasi gagal";
            }
        }
        echo json_encode($response);
    }


}
