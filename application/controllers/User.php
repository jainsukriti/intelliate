<?php
defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(0);

class User extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->load->model('User_model', '', True);
        $this->load->helper('security');
    }
	public function index()
	{
		redirect('user/action');
	}

	public function login()
	{
		$this->load->view('walkover');
		$data['links'] = $this->_get_menu_guest();
		$this->load->view('head_tag');
		$this->load->view('user/user_header',$data);
		$this->load->view('user/login');
		$this->load->view('scripts');
	}

	public function register()
	{
		$this->load->view('walkover');
		$data['links'] = $this->_get_menu_guest();
		$this->load->view('head_tag');
		$this->load->view('user/user_header',$data);
		$this->load->view('user/register');
		$this->load->view('scripts');
	}

	public function action()
	{
		$this->load->view('session_check');
		$data['links'] = $this->_get_menu_logged();
		$data['owner_groups'] = $this->User_model->getOwnerGroups();
		$data['member_groups'] = $this->User_model->getMemberGroups();
		$this->load->view('head_tag');
		$this->load->view('user/user_header',$data);
		$this->load->view('user/action');
		$this->load->view('scripts');
	}

	public function view($username)
	{		
		$this->load->view('session_check');
		$viewer_id = $this->User_model->getuid($username);
		if(empty($viewer_id))
			redirect('user/profile');
		if($viewer_id == $this->session->userdata('logged_in')['uid'])
			redirect('user/profile');
		$data['viewer_id'] = $viewer_id;
		$data['links'] = $this->_get_menu_logged();
		$user_data = $this->User_model->getUserDataById($viewer_id);
		$data['user']  = $user_data[0];
		$this->load->view('head_tag');
		$this->load->view('user/user_profile_header',$data);
		$this->load->view('user/profile_view');
		$this->load->view('user/user_footer');
		$this->load->view('scripts');
	}

	public function profile()
	{
		$this->load->view('session_check');
		$data['links'] = $this->_get_menu_logged();
		$user_data = $this->User_model->getSessionUserData();
		$data['user']  = $user_data[0];
		$this->load->view('head_tag');
		$this->load->view('user/user_profile_header',$data);
		$this->load->view('user/profile');
		$this->load->view('user/user_footer');
		$this->load->view('scripts');
	}

	public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center" role="alert" ><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Logged Out Successfully!</div>');
        redirect('user/login', 'refresh');
    }

	private function _get_menu_guest()
    {
    	return array(
    			array('link' => base_url().'home',
    				  'icon' => 'home',
    				  'name' =>'Home'),
    			array('link' => base_url().'user/login',
    				  'icon' => 'lock',
    				  'name' => 'Login'),
    			array('link' => base_url().'user/register',
    				  'icon' => 'person_add',
    				  'name' => 'Register')
				);
    }

    private function _get_menu_logged()
    {
    	return array(
    			array('link' => base_url().'home',
    				  'icon' => 'home',
    				  'name' =>'Home'),
    			array('link' => base_url().'user/profile',
    				  'icon' => 'person_add',
    				  'name' =>'Profile'),
    			array('link' => base_url().'user/logout',
    				  'icon' => 'power_settings_new',
    				  'name' => 'Logout')
				);
    }

    private function _get_user_IoTData()
    {
    	$uid = $this->session->userdata('logged_in')['uid'];
    	
    	$firebaseURI = 'https://mainproject-XYZ.firebaseio.com/';

        $fetch_uid = 'user_'.$uid;
        $assoc = [
            'audio'           => $firebaseURI . $fetch_uid . '/audio.json',
            'heartBeat'       => $firebaseURI . $fetch_uid . '/heartBeat.json',
            'humidity'        => $firebaseURI . $fetch_uid . '/humidity.json',
            'lightIntensity'  => $firebaseURI . $fetch_uid . '/lightIntensity.json',
            'temperature'     => $firebaseURI . $fetch_uid . '/temperature.json',
        ];

        $selected = $this->input->get('choice');

        foreach ($assoc as $key => $value) {
            $IoT_data = trim(file_get_contents($value));                  
            $data[$key] = end(json_decode($IoT_data,1));
        }   

        $data['user'] = $fetch_uid;                                           

        return $data;
    }
}
