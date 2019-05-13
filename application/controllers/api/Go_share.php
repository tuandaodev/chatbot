<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Chatfluel.php');

class Go_share extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->helper('url');
    }

    public function index($user_app_id) {
        
        $page_id = $this->option->get_option('page_id');
        $post_id = $this->option->get_option('post_id');
        
        $post_url = "https://www.facebook.com/permalink.php?story_fbid={$post_id}&id={$page_id}";

        $app_id = $this->option->get_option('fb_app_id');
        
        $shared_url = base_url() . 'api/shared/' . $user_app_id;
        $share_link = "https://www.facebook.com/dialog/share?app_id={$app_id}&display=page&href={$post_url}&redirect_uri=$shared_url";
        
//        echo $share_link;
//        exit;
        
        echo '<meta http-equiv="refresh" content="0; url=' . $share_link . '" />';
        exit();
    }
    
}