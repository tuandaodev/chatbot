<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stats_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_clients_stat($time_type = 'today') {
        
        if ($time_type == 'today') {
            $time_typeSQL = ' updated >= CURRENT_DATE()';
        }
        if ($time_type == 'week') {
            $time_typeSQL = ' YEARWEEK(updated)= YEARWEEK(CURDATE())';
        }
        if ($time_type == 'month') {
            $time_typeSQL = ' Year(updated)=Year(CURDATE()) AND Month(`updated`)= Month(CURDATE())';
        }

        $query = $this->db->query("SELECT count(*) FROM clients WHERE $time_type");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

}
