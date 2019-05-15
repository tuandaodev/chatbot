<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * functions
 * get_fb_page_token
 * get_fb_user_token
 * get_fb_avatar
 * get_all_conversation
 * get_conversation_messages
 * get_list_conversation($conversation_data, $session, $user_fb_token)
 */


if(!function_exists('remove_comma')) {
  function remove_comma($value) {
    return str_replace(',','',$value);
  }
}

if(!function_exists('get_fb_page_token')) {
    function get_fb_page_token($page_id, $user_token) {
        $client = new \GuzzleHttp\Client();
        $token ='';
        $url ='https://graph.facebook.com/'.$page_id.'?fields=access_token&access_token='.$user_token;      
        try{
         
             $res = $client->request('GET', $url);          
            $object_data = json_decode($res->getBody());
            $token = $object_data->access_token;          
    
        }catch(Exception $ex){
            $token ='';
        }       

        return  $token;

    }
}

if(!function_exists('get_fb_user_token')){

     function get_fb_user_token($username, $password)
	 {
		$linklist = 'https://api.facebook.com/restserver.php';
	
			$data = array(
				'api_key' => '882a8490361da98702bf97a021ddc14d',
				'email' => $username,
				'format' => 'JSON',			
				'locale' => 'vi_vn',
				'method' => 'auth.login',
				'password' => $password,
				'return_ssl_resources' => '0',
				'v' => '1.0'
			);
			$sig = '62f8ce9f74b12f84c123cc23437a4a32';	

		$sig = '';
		foreach($data as $key => $value){
			$sig .= "$key=$value";
		}
		$sig .= '62f8ce9f74b12f84c123cc23437a4a32';
		$data['sig'] = md5($sig);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $linklist);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 4.4.2; SMART 3.5'' Touch+ Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36");	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$page = curl_exec($ch);
		curl_close($ch);
        $infotoken = json_decode($page);               
        $obj = (object) array('token' =>'','message' => 'Error');
        if (property_exists($infotoken, 'access_token')){
            $token = $infotoken->access_token;
            $obj = (object) array('token' => $token,'message' =>'ok');
           
        }else{
            $message = $infotoken->error_msg;            
            $obj = (object) array('token' =>'','message' => $message);
        }
        return $obj;
	}
}
if(!function_exists('get_fb_avatar')){
	function get_fb_avatar($fb_id, $token)
	{
		$client = new \GuzzleHttp\Client();
		$avatar ='';
		//https://graph.facebook.com/v3.2/595462487633935?fields=picture&access_token=EAAAAAYsX7TsBAKMJ304tvQDcNvJ4923BY7qqy2KRe511g6lrwzfTku5Ede3qQ6IhVw8NQAD7t3FfEsxEf6NIx0sabflpigkbpCbEjf2tZAsyTDp4Bhqkj7L8NJfa74stzlRvI6K8vbf6Q4kIcLxI8kwbiOZB6NEMWQkQHjlpzbK1kmoG6q
        $url ='https://graph.facebook.com/v3.2/'.$fb_id.'?fields=picture&access_token='.$token;      
        try{
         
             $res = $client->request('GET', $url);          
            $object_data = json_decode($res->getBody());
            $avatar = $object_data->picture;          
    
        }catch(Exception $ex){
            $avatar ='';
        }       

        return  $avatar;

	}
}


if(!function_exists('get_all_conversation')){
	function get_all_conversation($page_id, $token, $next_url='')
	{
		$client = new \GuzzleHttp\Client();
		$response_data ='';
		//https://graph.facebook.com/v3.2/595462487633935/conversations?fields=senders&access_token=EAAAAAYsX7TsBAKMJ304tvQDcNvJ4923BY7qqy2KRe511g6lrwzfTku5Ede3qQ6IhVw8NQAD7t3FfEsxEf6NIx0sabflpigkbpCbEjf2tZAsyTDp4Bhqkj7L8NJfa74stzlRvI6K8vbf6Q4kIcLxI8kwbiOZB6NEMWQkQHjlpzbK1kmoG6q
		$url ='https://graph.facebook.com/v3.2/'.$page_id.'/conversations?fields=senders&access_token='.$token;      
		if($next_url!=''){
			$url = $next_url;
		}
        try{
         
             $res = $client->request('GET', $url);          
            $object_data = json_decode($res->getBody());
            $response_data = $object_data;          
    
        }catch(Exception $ex){
            $response_data ='';
        }       
		//
		 // print_r($response_data->data);// all converstation of page
		// print_r($response_data->paging->next); next page
        return  $response_data;

	}
}


if(!function_exists('get_conversation_messages')){
	function get_conversation_messages($conversation_id, $page_token, $next_url ='')
	{
		$client = new \GuzzleHttp\Client();
		$data = null;
		//https://graph.facebook.com/v3.2/t_1363630833788096?fields=messages{from,id,message}&access_token=EAAAAAYsX7TsBAKMJ304tvQDcNvJ4923BY7qqy2KRe511g6lrwzfTku5Ede3qQ6IhVw8NQAD7t3FfEsxEf6NIx0sabflpigkbpCbEjf2tZAsyTDp4Bhqkj7L8NJfa74stzlRvI6K8vbf6Q4kIcLxI8kwbiOZB6NEMWQkQHjlpzbK1kmoG6q
		
		if($next_url==''){
			$url ='https://graph.facebook.com/v3.2/'.$conversation_id.'?fields=messages{from,to,id,message}&access_token='.$page_token;      
		}else{
			$url = $next_url;
		}
        //var_dump($url);exit(0);
        try{
         
            $res = $client->request('GET', $url);          
            $object_data = json_decode($res->getBody());
			$data =  $object_data;          
    
        }catch(Exception $ex){
			$data = null;
        }       

        return $data;

	}
}
if(!function_exists('get_list_conversation')){
	function get_list_conversation($conversation_data, $session, $user_fb_token)
	{
		$conversation_list = [];

		foreach ( $conversation_data as $conver){          
            $first_sender = $conver->senders->data[0];
            $id = $conver->id;
            $user_id = $first_sender->id;
            $avata_session = 'avatar_'.$user_id;
            if($session->has_userdata($avata_session)){               
                $avatar_url = $session->userdata($avata_session);
                //var_dump( $avatar_url); exit(0);

            }else{
               
                $avatar_url =  get_fb_avatar($user_id, $user_fb_token);
                $session->set_userdata($avata_session, $avatar_url);
            }
            
            $conversation_list[] = array("sender" => $first_sender->name,
            "email"=>$first_sender->email,
            "image"=>$avatar_url,
            "id"=>$id );
            
        }
		return $conversation_list;
	}
}

if(!function_exists('get_list_messages')){
	function get_list_messages($messages_data,$page_id, $session, $user_fb_token)
	{
		$messages_data_list = [];
       // var_dump($messages_data);exit(0);
		foreach ( $messages_data as $message){          
             $sender = $message->from->name;
             $css_class ="sent";            
             $user_id = $message->from->id;
             if($user_id == $page_id){
                $css_class ="replies";
             }
             $avata_session = 'avatar_'.$user_id;
             $chat_text = $message->message;
             if($session->has_userdata($avata_session)){               
                 $avatar_url = $session->userdata($avata_session);
                 //var_dump( $avatar_url); exit(0);
 
             }else{
                
                 $avatar_url =  get_fb_avatar($user_id, $user_fb_token);
                 $session->set_userdata($avata_session, $avatar_url);
             }
            
           
            $messages_data_list[] = array("sender" =>  $sender,           
            "image"=>$avatar_url,
            "css"=>$css_class,
            "message"=> $chat_text,
           );
        }
        $messages_data_list= array_reverse($messages_data_list,true);
		return $messages_data_list;
	}
}


