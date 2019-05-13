<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gifts extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Title Page :: Common */
        $this->page_title->push("Gifts");
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, "Gifts", 'admin/gifts');

        $this->load->model('common/gift_model');
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Get all gifts */
            $this->data['gift_list'] = $this->gift_model->get_gifts();

            /* Load Template */
            $this->template->admin_render('admin/gifts/index', $this->data);
        }
    }

    public function create() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Tạo quà', 'admin/gifts/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Validate form input */
        $this->form_validation->set_rules('name', 'lang:gifts_name', 'required');

        if ($this->form_validation->run() == TRUE) {
            $insert_data['name'] = $this->input->post('name');
            $insert_data['description'] = $this->input->post('description');
            $insert_data['subtitle'] = $this->input->post('subtitle');
            $insert_data['image_url'] = $this->input->post('image_url');
            $new_gift_id = $this->gift_model->insert($insert_data);
            if ($new_gift_id) {
                redirect('admin/gifts', 'refresh');
            }
        } else {
            $this->data['name'] = array(
                'name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('name')
            );

            $this->data['subtitle'] = array(
                'name' => 'subtitle',
                'id' => 'subtitle',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('subtitle')
            );
            
            $this->data['image_url'] = array(
                'name' => 'image_url',
                'id' => 'image_url',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('image_url')
            );

            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('description')
            );
            
            /* Load Template */
            $this->template->admin_render('admin/gifts/create', $this->data);
        }
    }

    public function delete($id) {
        
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }
        
        $id = (int) $id;
        $this->gift_model->delete($id);
        
        redirect('admin/gifts', 'refresh');
    }

    public function edit($id) {
        $id = (int) $id;

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Tạo quà', 'admin/gifts/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Validate form input */
        $this->form_validation->set_rules('name', 'lang:gifts_name', 'required');

        if ($this->form_validation->run() == TRUE)
        {   
            $update_id = $this->input->post('id');
            $update_data['name'] = $this->input->post('name');
            $update_data['description'] = $this->input->post('description');
            $update_data['subtitle'] = $this->input->post('subtitle');
            $update_data['image_url'] = $this->input->post('image_url');
                $update_id = $this->gift_model->update($update_data, $update_id);
                if ($update_id)
                {
                    // Update thanh cong
                    redirect('admin/gifts', 'refresh');
                } else {
                    // Update khong thanh cong //TODO
                    redirect('admin/gifts', 'refresh');
                }
        }
        else
        {
            $gift_info = $this->gift_model->get_gift($id);
            
            if (!$gift_info) {
                redirect('admin/gifts', 'refresh');
            }
            
            $this->data['id'] = $gift_info['id'];
                    
            $this->data['name'] = array(
                    'name'  => 'name',
                    'id'    => 'name',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'value' => $gift_info['name']
            );
            
            $this->data['subtitle'] = array(
                    'name'  => 'subtitle',
                    'id'    => 'subtitle',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'value' => $gift_info['subtitle']
            );
            
            $this->data['image_url'] = array(
                    'name'  => 'image_url',
                    'id'    => 'image_url',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'value' => $gift_info['image_url']
            );

            $this->data['description'] = array(
                    'name'  => 'description',
                    'id'    => 'description',
                    'type'  => 'text',
    'class' => 'form-control',
                    'value' => $gift_info['description']
            );

            /* Load Template */
            $this->template->admin_render('admin/gifts/edit', $this->data);
        }
    }
}
