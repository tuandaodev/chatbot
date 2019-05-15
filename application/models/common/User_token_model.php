<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_token_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_tokens()
    {
        $query = $this->db->query("SELECT * FROM user_token");
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_token($id)
    {
        $query = $this->db->query("SELECT * FROM user_token WHERE id='$id'");
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function update($data, $id)
    {
        $where = " id = '$id' ";

        return $this->db->update('user_token', $data, $where);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('user_token');
    }
    
    public function insert($data)
    {
        $this->db->insert('user_token', $data);
        $last_id = $this->db->insert_id();
        
        return $last_id;
    }
    
    public function get_random_token()
    {
        $query = $this->db->query("SELECT *
                                    FROM user_token
                                    WHERE status = 1
                                    ORDER BY RAND()
                                    LIMIT 1");
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
}
