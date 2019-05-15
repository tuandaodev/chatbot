<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends Public_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url','facebook'));
       
		$this->load->library(array('form_validation','session'));
    }


    public function index()
    {
        $this->load->view('layout/header', $this->data);
        $this->load->view('home/home', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function login(){
        $this->load->view('facebook/login', $this->data);
    }
    public function doLogin(){
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'required');
        
        if($this->form_validation->run() == TRUE){
            $username = $this->input->post('username');  
            $password = $this->input->post('password');               
            $dataFB = get_fb_user_token($username, $password );
          
            if($dataFB->token &&  $dataFB->message =='ok'){
                // redirect to home
               // $this->session->set_flashdata('fb_token', $dataFB->token);   
                $this->session->set_userdata('fb_token', $dataFB->token);             
                redirect('/', 'refresh');
            }else{              
                $this->data['fb_message'] = $dataFB->message;
                $this->load->view('facebook/login', $this->data);
            }            
           
		}else{
            $this->load->view('facebook/login', $this->data);
        }
    }
    public function loadMoreConversation(){
        
        //$page_id = $this->input->get('page_id'); 
        $page_id ='595462487633935';
        // will get from session
         //$user_fb_token =$this->session->userdata('fb_token');
        
        $user_fb_token ='EAAAAAYsX7TsBAOys0Q2ojLZAbt4JE4Ab9RFqcQd4sheKu6Rx4bfZBz4ZAz8CYcfdi4sp0iRrxnVIXXQetnB46TMrLNTrvmZAevg0kbkNCqAKfZCNuJvMNmNNaIvINKB8KVEGZADYPstHZCNGwZCKZAbwuNt4TqgfXkZCRhKPN196lCsExGOhxBZCQ2gt3jTU8s3dFB4k6IizNsTHJ5Xb0wyJ3Bm';
      // $page_fb_token = get_fb_page_token( $page_id,$user_fb_token);
        $page_fb_token ='EAAAAAYsX7TsBAKMJ304tvQDcNvJ4923BY7qqy2KRe511g6lrwzfTku5Ede3qQ6IhVw8NQAD7t3FfEsxEf6NIx0sabflpigkbpCbEjf2tZAsyTDp4Bhqkj7L8NJfa74stzlRvI6K8vbf6Q4kIcLxI8kwbiOZB6NEMWQkQHjlpzbK1kmoG6q';
       

        $next_url = $this->input->get('url');  
        $all_conversation = get_all_conversation( $page_id, $page_fb_token,$next_url);     
        $next_conversation_url ='';
        if (property_exists($all_conversation->paging, 'next')) {
            $next_conversation_url = $all_conversation->paging->next;
        }
        $conversation_data = $all_conversation->data;        
        $conversation_list = [];
        $conversation_list = get_list_conversation( $conversation_data,$this->session, $user_fb_token);
       

        $this->data['conversation_list'] = $conversation_list;
        $this->data['next_conversation_url'] = $next_conversation_url;
        $this->load->view('facebook/conversation', $this->data);
    }
    public function loadChatMessageConverstation(){


        $page_id = $this->input->get('page_id'); 
        //$page_id ='595462487633935';
        $conversation_id = $this->input->get('conversation_id'); 
        $url = $this->input->get('url'); 
        // will get from session
         //$user_fb_token =$this->session->userdata('fb_token');
       // var_dump($url);exit(0);
        $user_fb_token ='EAAAAAYsX7TsBAOys0Q2ojLZAbt4JE4Ab9RFqcQd4sheKu6Rx4bfZBz4ZAz8CYcfdi4sp0iRrxnVIXXQetnB46TMrLNTrvmZAevg0kbkNCqAKfZCNuJvMNmNNaIvINKB8KVEGZADYPstHZCNGwZCKZAbwuNt4TqgfXkZCRhKPN196lCsExGOhxBZCQ2gt3jTU8s3dFB4k6IizNsTHJ5Xb0wyJ3Bm';
      // $page_fb_token = get_fb_page_token( $page_id,$user_fb_token);
        $page_fb_token ='EAAAAAYsX7TsBAKMJ304tvQDcNvJ4923BY7qqy2KRe511g6lrwzfTku5Ede3qQ6IhVw8NQAD7t3FfEsxEf6NIx0sabflpigkbpCbEjf2tZAsyTDp4Bhqkj7L8NJfa74stzlRvI6K8vbf6Q4kIcLxI8kwbiOZB6NEMWQkQHjlpzbK1kmoG6q';
        $messages_data = get_conversation_messages($conversation_id, $page_fb_token,$url);
      //  var_dump($messages_data);exit(0);
        
        if($messages_data!= null){
            $messages_list = get_list_messages($messages_data->data, $page_id, $this->session, $user_fb_token);
        }else{
            $messages_list =[];
        }
       // var_dump( $messages_data->messages->paging);
       // exit(0);
        $next_conversation_message_url ='';
        if ($messages_data!= null && property_exists($messages_data->paging, 'next')) {
            $next_conversation_message_url = $messages_data->paging->next;

        }
        // var_dump(  $next_conversation_message_url); exit(0);
        $this->data['messages_list'] = $messages_list;
        $this->data['next_conversation_message_url'] = $next_conversation_message_url;
        $this->load->view('facebook/messagelist', $this->data);


    }
   


}
