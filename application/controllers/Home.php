<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [];
        
        $this->load->view('layout/header', $data);
        $this->load->view('home/home', $data);
        $this->load->view('layout/footer', $data);
    }
   
}
