<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Chatfluel.php');

class Getid extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->model('common/client_model');
    }
    
    // Not Use
    public function index() {
        
        $Chatfluel = new Chatfuel();
        
        $fb_url = $this->input->get('url');
        
        $get_data = callAPI('GET', 'https://api.httzip.com/get-facebook-id?url='.$fb_url, false);
        $get_data = json_decode($get_data, true);
        
        $response = [];
        if (isset($get_data['id']) && !empty($get_data['id'])) {
            $user_attr['user_fb_id'] = $get_data['id'];
            $user_attr['has_fb_id'] = "1";
            
            $messages[] = array('text' => "FB ID của bạn là: " . $user_attr['user_fb_id']);
            $messages[] = array('text' => "Cảm ơn bạn");
            
            $response['set_attributes'] = $user_attr;
            $response['messages'] = $messages;
            
//            $Chatfluel->sendText($messages);
            
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        
        exit();
    }

    public function fbid_by_appid() {
        
        $user_app_id = $this->input->get('user_app_id');

        // Test environment
//        if (!$user_app_id) $user_app_id = "0978126486";
        
        // Options, will load from database table options
//        $page_id = "326208034543057";
//        $access_token = "EAADi8UzxnDQBAMefNXwTO525OPAwZBKgfBnuI9CF3ZBb1VWO4khz4HZBWRXWSIC9mdZCMjYdzacpusBsp9C1UZA6PZAdgqCwbw8I34uuZAFgtcq7LRAZAZCvyDFl4diFtEnZC832neYICSZABsn7sPcpJrwGtyrL1nHEUp4cRVNH7l72y4YgDPjmSrD";
//        $crawler_api = "http://35.240.146.108:8080";
        
        $user_exists_fbid = $this->client_model->get_fbid_by_appid($user_app_id);
        
//        echo "<pre>";
//        print_r($user_exists_fbid);
//        echo "</pre>";
//        exit;
        
        if ($user_exists_fbid) {
            $BOT_ID = $this->option->get_option('chatfuel_bot_id');
            $CUSER_ID = $user_app_id;  //"2373937132677212";
            $CTOKEN = $this->option->get_option('chatfuel_token');
            $BLOCK_GET_USER_INFO = $this->option->get_option('chatfuel_block_get_user_info');

            $call_chat_fuel_url = 'https://api.chatfuel.com/bots/' . $BOT_ID . '/users/' . $CUSER_ID . '/send?chatfuel_token=' . $CTOKEN;
            $call_chat_fuel_url .= '&chatfuel_block_name=' . $BLOCK_GET_USER_INFO;
            $call_chat_fuel_url .= '&user_fb_id=' . $user_exists_fbid;
            $call_chat_fuel_url .= '&has_fb_id=1';

            $data = null;
            $data['chatfuel_block_name'] = $BLOCK_GET_USER_INFO; 
            $data['user_fb_id'] = $user_exists_fbid;

            $get_data_fbuid = callAPI('POST', $call_chat_fuel_url, false);
            $get_data_fbuid = json_decode($get_data_fbuid, true);
            
            exit;
        }
        
        $page_id = $this->option->get_option('page_id');
        $page_access_token = $this->option->get_option('page_access_token');
        $crawler_api = $this->option->get_option('crawler_api_url');
        
        $call_url = 'https://graph.facebook.com/v3.2/' . $page_id . '/conversations?fields=messages{message}&access_token=' . $page_access_token;

        $get_data = callAPI('GET', $call_url, false);
        $get_data = json_decode($get_data, true);
        
//        echo "<pre>";
//        print_r($get_data);
//        echo "</pre>";
//        exit;

        //creating object of SimpleXMLElement
        $user_message = new SimpleXMLElement("<?xml version=\"1.0\"?><user_message></user_message>");

        //function call to convert array to xml
        array_to_xml($get_data,$user_message);

        $parent_obj = null;
        foreach($user_message->xpath('//message[.="' . $user_app_id . '"]') as $item){
            if ($item[0]) {
                //echo $item[0];

                $parent_temp = $item->xpath('../../../..');
                if ($parent_temp[0]) {
                    $parent_obj = $parent_temp[0];
                    break;
                }
            }
        }

        //print_r($parent_obj);

        $id_obj = null;
        if ($parent_obj) {
            $id_obj = $parent_obj->xpath('id');
        }

        if ($id_obj[0]) {
            $id_obj = $id_obj[0];
        }

        $inbox_id = $id_obj->__toString();

        $response['result'] = -2;
        if ($inbox_id) {
            $response['result'] = -1;
            //$call_url = $crawler_api . '/api/get_redirect?url=' . $inbox_url;
            $inbox_id = trim($inbox_id);
            $call_inbox_get_url = 'https://graph.facebook.com/v3.2/' . $inbox_id . '?access_token=' . $page_access_token;
            
            $get_data_inbox_url = callAPI('GET', $call_inbox_get_url, false);
            $get_data_inbox_url = json_decode($get_data_inbox_url, true);

//             print_r($get_data_inbox_url);

            if (isset($get_data_inbox_url['link']) && !empty($get_data_inbox_url['link'])) {
                $response['result'] = 0;

                $inbox_url = trim($get_data_inbox_url['link']);
                $inbox_url = unicode_decode($inbox_url);
                
                $re = '/inbox\/(.*?)\//';
                preg_match($re, $inbox_url, $matches);
                if (isset($matches[0]) && !empty($matches[0])) {
                    $inbox_url = "https://en-gb.facebook.com/" . $page_id . '/' . $matches[0];
                } else {
                    $inbox_url = "https://en-gb.facebook.com/" . $inbox_url;
                }

//                $inbox_url = "https://en-gb.facebook.com/" . $page_id . '/' . $inbox_url;

                $call_fbuid_url = $crawler_api . '/api/get_redirect?url=' . $inbox_url;
                
                $get_data_fbuid = callAPI('GET', $call_fbuid_url, false);
                $get_data_fbuid = json_decode($get_data_fbuid, true);

//                 print_r($get_data_fbuid);
                if (isset($get_data_fbuid['result']) && ($get_data_fbuid['result'] == '1')) {
                    $response['result'] = 1;

                    $url_parts = parse_url($get_data_fbuid['url_redirected']);
                    parse_str($url_parts['query'], $query);

                    $fbuid = $query['selected_item_id'];

                    $response['fbuid'] = $fbuid;

                    // Chatflue response
//                    unset($response['result']);
//                    unset($response['fbuid']);

                    $user_attr['user_fb_id'] = $fbuid;
                    $user_attr['has_fb_id'] = "1";
                    
                    // $messages[] = array('text' => "FB ID của bạn là: " . $user_attr['user_fb_id']);
                    // $messages[] = array('text' => "Đang kiểm tra share bài viết và tag bạn bè. Bạn vui lòng đợi trong giây lát. ^^");
                    
                    $response['set_attributes'] = $user_attr;
                    // $response['messages'] = $messages;

//                    $BOT_ID = "5a5b0d9ee4b0d02fdb4c8b17";
//                    $CUSER_ID = $user_app_id;  //"2373937132677212";
//                    $CTOKEN = "vnbqX6cpvXUXFcOKr5RHJ7psSpHDRzO1hXBY8dkvn50ZkZyWML3YdtoCnKH7FSjC";
//                    $BLOCK_GET_USER_INFO = "Get_user_info";
                    
                    $BOT_ID = $this->option->get_option('chatfuel_bot_id');
                    $CUSER_ID = $user_app_id;  //"2373937132677212";
                    $CTOKEN = $this->option->get_option('chatfuel_token');
                    $BLOCK_GET_USER_INFO = $this->option->get_option('chatfuel_block_get_user_info');

                    $call_chat_fuel_url = 'https://api.chatfuel.com/bots/' . $BOT_ID . '/users/' . $CUSER_ID . '/send?chatfuel_token=' . $CTOKEN;

                    $call_chat_fuel_url .= '&chatfuel_block_name=' . $BLOCK_GET_USER_INFO;
                    $call_chat_fuel_url .= '&user_fb_id=' . $fbuid;
                    $call_chat_fuel_url .= '&has_fb_id=1';

//                    echo $call_chat_fuel_url;

                    $data = null;
                    $data['chatfuel_block_name'] = $BLOCK_GET_USER_INFO; 
                    $data['user_fb_id'] = $fbuid;

                    $get_data_fbuid = callAPI('POST', $call_chat_fuel_url, false);

                    $get_data_fbuid = json_decode($get_data_fbuid, true);
                    
                    // Insert to database
                    if ($user_app_id && $fbuid) {
                        $insert_data['user_app_id'] = $user_app_id;
                        $insert_data['user_fb_id'] = $fbuid;
                        
                        $response['insert_result'] = $this->client_model->insert_update($insert_data);
                    }
                    
                    // On Prod, enable this line
//                    exit();
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }


    // Not Use
    public function by_app_id2() {
        
        $Chatfluel = new Chatfuel();
        
        $user_app_id = $this->input->get('user_app_id');

        // Test environment
        if (!$user_app_id) $user_app_id = "0978126486";
        
        // Options, will load from database table options
        $page_id = "326208034543057";
        $access_token = "EAADi8UzxnDQBAMefNXwTO525OPAwZBKgfBnuI9CF3ZBb1VWO4khz4HZBWRXWSIC9mdZCMjYdzacpusBsp9C1UZA6PZAdgqCwbw8I34uuZAFgtcq7LRAZAZCvyDFl4diFtEnZC832neYICSZABsn7sPcpJrwGtyrL1nHEUp4cRVNH7l72y4YgDPjmSrD";
        $crawler_api = "http://35.240.146.108:8080";


        $call_url = 'https://graph.facebook.com/v3.2/' . $page_id . '/conversations?fields=messages{message}&access_token=' . $access_token;

        $get_data = callAPI('GET', $call_url, false);
        $get_data = json_decode($get_data, true);

        //creating object of SimpleXMLElement
        $user_message = new SimpleXMLElement("<?xml version=\"1.0\"?><user_message></user_message>");

        //function call to convert array to xml
        array_to_xml($get_data,$user_message);

        $parent_obj = null;
        foreach($user_message->xpath('//message[.="' . $user_app_id . '"]') as $item){
            if ($item[0]) {
                //echo $item[0];

                $parent_temp = $item->xpath('../../../..');
                if ($parent_temp[0]) {
                    $parent_obj = $parent_temp[0];
                    break;
                }
                
            }
        }

        //print_r($parent_obj);

        $id_obj = null;
        if ($parent_obj) {
            $id_obj = $parent_obj->xpath('id');
        }

        if ($id_obj[0]) {
            $id_obj = $id_obj[0];
        }

        $inbox_id = $id_obj->__toString();

        $response['result'] = -2;
        if ($inbox_id) {
            $response['result'] = -1;
            //$call_url = $crawler_api . '/api/get_redirect?url=' . $inbox_url;
            $inbox_id = trim($inbox_id);
            $call_inbox_get_url = 'https://graph.facebook.com/v3.2/' . $inbox_id . '?access_token=' . $access_token;

            $get_data_inbox_url = callAPI('GET', $call_inbox_get_url, false);
            $get_data_inbox_url = json_decode($get_data_inbox_url, true);

            // print_r($get_data_inbox_url);

            if (isset($get_data_inbox_url['link']) && !empty($get_data_inbox_url['link'])) {
                $response['result'] = 0;

                $inbox_url = trim($get_data_inbox_url['link']);

                $inbox_url = "https://en-gb.facebook.com/" . $inbox_url;

                $call_fbuid_url = $crawler_api . '/api/get_redirect?url=' . $inbox_url;

                $get_data_fbuid = callAPI('GET', $call_fbuid_url, false);
                $get_data_fbuid = json_decode($get_data_fbuid, true);

                // print_r($get_data_fbuid);

                if (isset($get_data_fbuid['result']) && ($get_data_fbuid['result'] == '1')) {
                    $response['result'] = 1;

                    $url_parts = parse_url($get_data_fbuid['url_redirected']);
                    parse_str($url_parts['query'], $query);

                    $fbuid = $query['selected_item_id'];

                    $response['fbuid'] = $fbuid;

                    // Chatflue response

                    unset($response['result']);
                    unset($response['fbuid']);

                    $user_attr['user_fb_id'] = $fbuid;
                    $user_attr['has_fb_id'] = "1";
                    
                    $messages[] = array('text' => "FB ID của bạn là: " . $user_attr['user_fb_id']);
                    $messages[] = array('text' => "Đang kiểm tra share bài viết và tag bạn bè. Bạn vui lòng đợi trong giây lát. ^^");
                    
                    $response['set_attributes'] = $user_attr;
                    $response['messages'] = $messages;
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

function array_to_xml($array, &$user_message) {
    foreach($array as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $user_message->addChild("$key");
                array_to_xml($value, $subnode);
            }else{
                $subnode = $user_message->addChild("item$key");
                array_to_xml($value, $subnode);
            }
        }else {
            $user_message->addChild("$key",htmlspecialchars("$value"));
        }
    }
}

function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}
function unicode_decode($str) {
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $str);
}