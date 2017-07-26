<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Rating_Mustahiq_model $Rating_Mustahiq_model
 */
class Rating_Mustahiq_model extends CI_Model
{


    public function insertrating($rating)
    {
        $query = $this->db->insert('rating_mustahiq', $rating);
        return $query;
    }



}