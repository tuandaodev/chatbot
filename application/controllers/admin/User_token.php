<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_token extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Title Page :: Common */
        $this->page_title->push("User Token");
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, "User Token", 'admin/user_token');

        $this->load->model('common/user_token_model');
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Get all user_token */
            $this->data['token_list'] = $this->user_token_model->get_tokens();

            /* Load Template */
            $this->template->admin_render('admin/user_token/index', $this->data);
        }
    }

    public function create() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Token', 'admin/user_token/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Validate form input */
        $this->form_validation->set_rules('value', 'lang:user_token_value', 'required');

        if ($this->form_validation->run() == TRUE) {
            
            $insert_data['value'] = $this->input->post('value');
            $insert_data['status'] = $this->input->post('status') ? $this->input->post('status') : 0;
            
            $new_id = $this->user_token_model->insert($insert_data);
            if ($new_id) {
                redirect('admin/user_token', 'refresh');
            }
        } else {
            $this->data['value'] = array(
                'name' => 'value',
                'id' => 'value',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('value')
            );

            $this->data['status'] = array(
                'name' => 'status',
                'id' => 'status',
                'type' => 'checkbox',
//                'class' => 'form-control',
                'value' => '1',
                'checked' => TRUE,
            );

            /* Load Template */
            $this->template->admin_render('admin/user_token/create', $this->data);
        }
    }

    public function delete($id) {
        
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }
        
        $id = (int) $id;
        $this->user_token_model->delete($id);
        
        redirect('admin/user_token', 'refresh');
    }

    public function edit($id) {
        $id = (int) $id;

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Edit Token', 'admin/user_token/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Validate form input */
        $this->form_validation->set_rules('value', 'lang:user_token_value', 'required');

        if ($this->form_validation->run() == TRUE)
        {   
            $update_id = $this->input->post('id');
            $update_data['value'] = $this->input->post('value');
            $update_data['status'] = $this->input->post('status') ? $this->input->post('status') : 0;
                $update_id = $this->user_token_model->update($update_data, $update_id);
                if ($update_id)
                {
                    // Update thanh cong
                    redirect('admin/user_token', 'refresh');
                } else {
                    // Update khong thanh cong //TODO
                    redirect('admin/user_token', 'refresh');
                }
        }
        else
        {
            $token_info = $this->user_token_model->get_token($id);
            
            if (!$token_info) {
                redirect('admin/user_token', 'refresh');
            }
            
            $this->data['id'] = $token_info['id'];
                    
            $this->data['value'] = array(
                    'name'  => 'value',
                    'id'    => 'value',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'value' => $token_info['value']
            );

            $this->data['status'] = array(
                    'name'  => 'status',
                    'id'    => 'status',
                    'type'  => 'checkbox',
//    'class' => 'form-control',
                    'value' => '1',
                    'checked' => $token_info['status'],
            );

            /* Load Template */
            $this->template->admin_render('admin/user_token/edit', $this->data);
        }
    }
}
