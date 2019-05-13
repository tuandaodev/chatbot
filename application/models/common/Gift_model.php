<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_gifts()
    {
        $query = $this->db->query("SELECT * FROM gifts");
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_gift($id)
    {
        $query = $this->db->query("SELECT * FROM gifts WHERE id='$id'");
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function update($data, $id)
    {
        $where = " id = '$id' ";

        return $this->db->update('gifts', $data, $where);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('gifts');
    }
    
    public function insert($data)
    {
        $this->db->insert('gifts', $data);
        $last_id = $this->db->insert_id();
        
        return $last_id;
    }
    
    public function get_gifts_by_ids($ids)
    {
        $query = $this->db->query("SELECT * FROM gifts WHERE id IN ($ids)");
        
//        echo $this->db->last_query();
//        exit;   
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    
}
