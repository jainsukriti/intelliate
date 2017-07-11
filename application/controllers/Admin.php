<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('admin_check');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->load->model('Admin_model', '', True);
        $this->load->helper('security');
        $this->load->helper('string');
    }

    public function index()
    {
        $this->load->view('head_tag');

        $result_array = $this->Admin_model->getGroupMembers();
        
        $groupData = [];

        foreach ($result_array as $result) 
        {
            $groupData[$result['group_name']][] = $result;
        }
        
        $data['group_data'] = $groupData;

        $this->load->view('admin/admin_header');
        $this->load->view('admin/info', $data);
        $this->load->view('admin/admin_footer');
        $this->load->view('scripts');     
    }
}   