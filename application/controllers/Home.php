<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper('facebook');
    }

    public function index()
    {
        $page_id = $this->option->get_option('page_id');
        
      //  $page_id = '595462487633935';
        // store in session login facebook
        //$user_fb_token =$this->session->userdata('fb_token');
//        $user_fb_token = 'EAAAAAYsX7TsBAOys0Q2ojLZAbt4JE4Ab9RFqcQd4sheKu6Rx4bfZBz4ZAz8CYcfdi4sp0iRrxnVIXXQetnB46TMrLNTrvmZAevg0kbkNCqAKfZCNuJvMNmNNaIvINKB8KVEGZADYPstHZCNGwZCKZAbwuNt4TqgfXkZCRhKPN196lCsExGOhxBZCQ2gt3jTU8s3dFB4k6IizNsTHJ5Xb0wyJ3Bm';

        // $page_fb_token = get_fb_page_token( $page_id,$user_fb_token);
        
//        $page_fb_token = 'EAAAAAYsX7TsBAKMJ304tvQDcNvJ4923BY7qqy2KRe511g6lrwzfTku5Ede3qQ6IhVw8NQAD7t3FfEsxEf6NIx0sabflpigkbpCbEjf2tZAsyTDp4Bhqkj7L8NJfa74stzlRvI6K8vbf6Q4kIcLxI8kwbiOZB6NEMWQkQHjlpzbK1kmoG6q';
        
        $page_access_token = $this->option->get_option('page_access_token');
        
        
        
        $conversation_id = $this->input->get('conversation_id');       
      //  $conversation_id = 't_1363630833788096';



        // $token_page = get_fb_page_token( $page_id,$user_fb_token);
        // $token_page = get_fb_avatar( $page_id,$user_fb_token);
        // $token_page = get_conversation_messages( $conversation_id, $page_fb_token);
        // var_dump($token_page);
        // exit(0);
        // $temp = remove_comma($temp);      
        //var_dump( $token_page->data);
        //  print_r($token_page->messages);
        // print_r($token_page->messages->data);
        //print_r($all_conversation->paging->next);
         //echo $page_fb_token;
        $all_conversation = get_all_conversation($page_id, $page_fb_token);

       //  var_dump( $all_conversation);
       // exit(0);
        $next_conversation_url = '';
        if ($all_conversation!="" && property_exists($all_conversation->paging, 'next')) {
            $next_conversation_url = $all_conversation->paging->next;
        }

        $conversation_list = [];
        if($all_conversation!=''){
            $conversation_data = $all_conversation->data;
        }else{
            $conversation_data =[];
        }
        
      
        $conversation_list = get_list_conversation($conversation_data, $this->session, $user_fb_token);


        if (!isset($conversation_id) || trim($conversation_id) === '') {

            $conversation_id = $conversation_data[0]->id;
        }

         //var_dump($conversation_id);
        // exit(0);

        $messages_data = get_conversation_messages($conversation_id, $page_fb_token);
       // var_dump($messages_data);
       // exit(0);

        if($messages_data!= null){
            $messages_list = get_list_messages($messages_data->messages->data, $page_id, $this->session, $user_fb_token);
        }else{
            $messages_list =[];
        }
      //  var_dump( $messages_data->messages->paging);
       // exit(0);
        $next_conversation_message_url ='';
        if ($messages_data!= null && property_exists($messages_data->messages->paging, 'next')) {
            $next_conversation_message_url = $messages_data->messages->paging->next;

        }
        
        $this->data['messages_list'] = $messages_list;
        $this->data['page_id'] = $page_id;
        $this->data['conversation_id'] = $conversation_id;
        $this->data['next_conversation_url'] = $next_conversation_url;
        $this->data['next_conversation_message_url'] = $next_conversation_message_url;
        $this->data['conversation_list'] = $conversation_list;


        $this->load->view('layout/header', $this->data);
        $this->load->view('home/home', $this->data);
        $this->load->view('layout/footer', $this->data);
    }
}
