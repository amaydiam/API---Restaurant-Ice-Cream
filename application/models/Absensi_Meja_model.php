<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Absensi_meja_model $Absensi_meja_model
 */
class Absensi_meja_model extends CI_Model
{

    public function insertabsensi_meja($absensi_meja)
    {
        $query = $this->db->insert('absensi_meja', $absensi_meja);
        return $query;
    }


}