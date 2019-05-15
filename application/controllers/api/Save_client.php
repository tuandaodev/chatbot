<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Save_client extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->model('common/client_model');
    }

    public function index() {

        $messenger_user_id = $this->input->post('messenger_user_id');
        $fb_id = $this->input->post('user_fb_id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $user_phone = $this->input->post('user_phone');
        $user_location = $this->input->post('user_location');
        $gender = $this->input->post('gender');
        
        $date = date('Y/m/Y h:i:s', time());
        
        if (!$messenger_user_id) {
            //$messenger_user_id = "23739371326772123333333";
            return;
        }

        $client_data = array(
            'user_app_id' => $messenger_user_id, 
            'user_fb_id' => $fb_id, 
            'first_name' => $first_name, 
            'last_name' => $last_name, 
            'phone_number' => $user_phone, 
            'location' => $user_location, 
            'gender' => $gender
        );
        
        //print_r($client_data);

        $this->client_model->insert_update($client_data);

        //echo $this->db->last_query();
        exit;

    }
}