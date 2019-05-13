<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Options extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->breadcrumbs->unshift(1, "Options", 'admin/options');
        $this->load->model('common/gift_model');
    }

    public function build_gift_message($gifts) {
//        if ($type = 1) {
//            return $this->gift_texts();
//        } else {
            return $this->gift_images($gifts);
//        }
    }
    
    private function gift_images($gifts) {
        $gift_message = '';
        $element = [];
        
        if (count($gifts) > 0) {
            $gift_ids = implode(',', $gifts);
            
            $gift_list = $this->gift_model->get_gifts_by_ids($gift_ids);
            foreach ($gift_list as $gift) {
                $choose_gift_url = base_url() . 'api/gift/choose/XUSER_ID/' . $gift['id'];
                $gift_obj = array(
                    "title" => $gift['name'], 
                    "image_url" => $gift['image_url'],
                    "subtitle"  => $gift['subtitle'],
                    "buttons" => array( array (
                        "type" => "json_plugin_url", //"web_url", 
                        "title" => "Chọn quà này",
                        "url"   =>  $choose_gift_url,
                        ) ),
                    );
                $element[] = $gift_obj;
            }
        } else {
            return $element;
        }
        
        $attachment = array(
            "type"  =>  "template",
            "payload"   => array(
                "template_type" =>  "generic",
                "image_aspect_ratio"    =>  "square",
                "elements"  => $element,
            ),
        );
        
        $messages['attachment'] = $attachment;
        $res['messages'][] = $messages;
        
        header('Content-Type: application/json');
        $gift_message = json_encode($res);
        
        return $gift_message;
    }
    
    // Current Not use
    /*
    private function gift_texts() {
        $gift_message = '';
        $quick_replies = [];
        
        if (count($gifts) > 0) {
            $gift_ids = implode(',', $gifts);

            $gift_list = $this->gift_model->get_gifts_by_ids($gift_ids);
            foreach ($gift_list as $gift) {
                $gift_obj = array("title" => $gift['name'], "set_attributes" => array("user_gift_id" => $gift['id'], "user_gift_name" => $gift['name']));
                $quick_replies[] = $gift_obj;
            }
        } else {
            return $gift_message;
        }
        
        $messages[] = array(
            'text' => "Chọn quà tặng:", 
            "quick_replies" => $quick_replies, 
            "quick_reply_options" => array( "process_text_by_ai" => false, 
                                            "text_attribute_name" => "user_message")
            );

        $res['messages'] = $messages;
        
        $gift_message = json_encode($res);
        return $gift_message;
    }
    */
    
    public function index()
    {
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Title Page */
            $this->page_title->push("Options");
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            // print_r($this->data);
            // exit;

            /* Validate form input */
            $this->form_validation->set_rules('page_id', "Required", 'required');

            /* Data */
            $this->data['message_public']        = (validation_errors()) ? validation_errors() : NULL;
            $this->data['options_text'] = $this->option->get_options_text();
            
            $this->data['gift_type'] = $this->option->get_option_obj('gift_type');
            
            $this->data['gift_list'] = $this->gift_model->get_gifts();
            $this->data['obj_option_gift'] = $this->option->get_option_obj('list_gift');
            $this->data['gift_list_selected'] = unserialize($this->option->get_option('list_gift'));
            
            if ($this->form_validation->run() == TRUE)
            {
                $gifts = $this->input->post('list_gift');
                $gift_type = $this->input->post('gift_type');
                
                //Build Gift Message
                $gift_message = $this->build_gift_message($gifts);
                
                $data = array(
                    'page_id' => $this->input->post('page_id'),
                    'post_id' => $this->input->post('post_id'),
                    'page_access_token' => $this->input->post('page_access_token'),
                    'user_access_token' => $this->input->post('user_access_token'),
                    'crawler_api_url' => $this->input->post('crawler_api_url'),
                    'chatfuel_bot_id' => $this->input->post('chatfuel_bot_id'),
                    'chatfuel_token' => $this->input->post('chatfuel_token'),
                    'chatfuel_block_get_user_info' => $this->input->post('chatfuel_block_get_user_info'),
                    'chatfuel_block_user_shared' => $this->input->post('chatfuel_block_user_shared'),
                    'chatfuel_block_user_not_shared' => $this->input->post('chatfuel_block_user_not_shared'),
                    'chatfuel_block_main_event' => $this->input->post('chatfuel_block_main_event'),
                    'list_gift' => serialize($gifts),
                    'gift_message' => $gift_message,
                    'fb_app_id' => $this->input->post('fb_app_id'),
                    'gift_type' => $gift_type,
                );

                foreach ($data as $key => $value) {
                    $this->option->update_option($key, $value);
                }
                
                redirect('admin/options', 'refresh');
            }
            else
            {
                /* Load Template */
                $this->template->admin_render('admin/options/option', $this->data);
            }
        }
    }
}
