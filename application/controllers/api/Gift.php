<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Chatfluel.php');

class Gift extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->model('common/client_model');
         $this->load->model('common/gift_model');
    }

    public function send_gift($messenger_user_id = '') {
        
        if (!$messenger_user_id) {
            log_message('error', 'send_gift missing $messenger_user_id ' . $messenger_user_id);
            exit;
        }
        
        $client = $this->client_model->get_client_by_appid($messenger_user_id);
        if ($client) {
            $gift_message = $this->option->get_option("gift_message");
            
            $gift_message = str_replace("XUSER_ID", $messenger_user_id, $gift_message);
            header('Content-Type: application/json');
            echo $gift_message;
        } else {
            log_message('error', 'send_gift cannot get $client ' . $messenger_user_id);
        }
        exit;
    }
    
    public function choose_gift($messenger_user_id, $gift_id) {
        
//        $messenger_user_id = $this->input->post('messenger_user_id');
//        $gift_id = $this->input->post('user_gift_id');
        
        $gift_obj = $this->gift_model->get_gift($gift_id);
        
        if (!$gift_obj) {
            log_message('error', 'choose_gift cannot get $gift_obj by gift_id');
            
            $messages[] = array('text' => "Có lỗi xảy ra, bạn vui lòng ấn Tham gia lại sự kiện.");
            $response['messages'] = $messages;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        
        $gift_name = $gift_obj['name'];
        
        if (!$messenger_user_id && !$gift_id) {
            
            log_message('error', 'choose_gift missing $messenger_user_id or $gift_id' . json_encode($_POST));
            
            $messages[] = array('text' => "Có lỗi xảy ra, bạn vui lòng ấn Tham gia lại sự kiện.");
            $response['messages'] = $messages;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        $client_data = array(
            'user_app_id' => $messenger_user_id, 
            'gift_id' => $gift_id, 
            'gift_name' => $gift_name, 
        );
        
        $result = $this->client_model->insert_update($client_data);
        
        if ($result) {
            $messages[] = array('text' => "Chúng tôi đã ghi nhận quà tặng [$gift_name] của bạn và sẽ gửi đến trong thời gian sớm nhất. Cảm ơn bạn!");
            $response['messages'] = $messages;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            
            log_message('error', "Lỗi với Log Query: " . $this->db->last_query());
            
            $messages[] = array('text' => "Có lỗi xảy ra, bạn vui lòng ấn Tham gia lại sự kiện.");
            $response['messages'] = $messages;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        
    }
    
    //old function to save gift on Quick Replies JSON API
    public function save_gift() {

        $messenger_user_id = $this->input->post('messenger_user_id');
        
        $gift_id = $this->input->post('user_gift_id');
        $gift_name = $this->input->post('user_gift_name');
        
        if (!$messenger_user_id) {
            $messages[] = array('text' => json_encode($_POST));
            $response['messages'] = $messages;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        $client_data = array(
            'user_app_id' => $messenger_user_id, 
            'gift_id' => $gift_id, 
            'gift_name' => $gift_name, 
        );
        
        $result = $this->client_model->insert_update($client_data);
        
        if ($result) {
            $messages[] = array('text' => "[Đã Cập nhật quà tặng trên Database]");
            $response['messages'] = $messages;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            
            log_message('error', "Lỗi với Log Query: " . $this->db->last_query());
            
            $messages[] = array('text' => "Có lỗi xảy ra, bạn vui lòng ấn Tham gia lại sự kiện.");
            $response['messages'] = $messages;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}