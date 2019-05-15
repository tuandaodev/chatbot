<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Chatfluel.php');

class Shared extends CI_Controller {

    function __construct() {
         parent::__construct();
    }

    public function index($user_app_id) {
        if (!$user_app_id) {
            $res['result'] = 0;
            $res['message'] = "Missing User ID";
            
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }
        
//        $bot_id = "5a5b0d9ee4b0d02fdb4c8b17";
//        $token = "vnbqX6cpvXUXFcOKr5RHJ7psSpHDRzO1hXBY8dkvn50ZkZyWML3YdtoCnKH7FSjC";
        
        $BOT_ID = $this->option->get_option('chatfuel_bot_id');
        $CUSER_ID = $user_app_id;  //"2373937132677212";
        $CTOKEN = $this->option->get_option('chatfuel_token');
        $BLOCK_MAIN_EVENT = $this->option->get_option('chatfuel_block_main_event');
        
        $data['chatfuel_token'] = $CTOKEN;
        
        $error_code = $this->input->get('error_code'); //code=4201
        if ($error_code) {
//            // User didn't share the post
//            $data['chatfuel_block_name'] = "User_not_shared";  //User_not_shared
            $data['has_shared'] = 0;
        } else {
//            // User shared the post
//            $data['chatfuel_block_name'] = "User_shared"; //User_shared
            $data['has_shared'] = 1;
        }
        
        if ($error_code) {
            echo "Chia sẻ bài viết thất bại. Bạn quay lại facebook và thử lại nhé!";
        } else {
            $chatfuel_url = "https://api.chatfuel.com/bots/{$BOT_ID}/users/{$CUSER_ID}/send?chatfuel_token={$CTOKEN}&chatfuel_block_name={$BLOCK_MAIN_EVENT}";
        
            $make_call = callAPI('POST', $chatfuel_url, json_encode($data));
            $response = json_decode($make_call, true);
            
            echo "Chia sẻ bài viết thành công. Bạn quay lại facebook và làm các bước còn lại để tham gia sự kiện nhé!";
        }
        exit;
    }
    
}