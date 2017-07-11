<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);  //CUSTOM 

class Ajax extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->load->model('User_model', '', True);
        $this->load->helper('security');
        $this->load->helper('string');
    }
    
    public function index()
    {
        $this->load->view('head_tag');
        $this->load->view('home/index');
        $this->load->view('scripts');
    }
    
    public function register()
    {
        if ($this->input->is_ajax_request())
        {
            
            $this->form_validation->set_rules('full_name', 'Full name', 'required');
            $this->form_validation->set_rules('username', 'Username', 'alpha_numeric|required|is_unique[tbl_users.username]|min_length[5]|max_length[12]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('cnf_password', 'Retyped Password', 'trim|required|matches[password]');
            $this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|is_unique[tbl_users.user_email]');
            
            if ($this->form_validation->run() == False)
            {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => validation_errors()
                ));
                
            }
            else
            {
                $full_name  = $this->input->post('full_name');
                $username   = $this->input->post('username');
                $user_email = $this->input->post('user_email');
                $password   = $this->input->post('password');
                
                
                $data_array = array(
                    'full_name' => $full_name,
                    'username' => $username,
                    'user_email' => $user_email,
                    'password' => md5($password)
                );
                
                
                $id = $this->User_model->addUser($data_array);
                
                $data['id'] = $id;
                
                if ($id)
                {
                    echo json_encode(array(
                        'status' => 'ok',
                        'details' => 'Success'
                    ));
                }
            }
            
        }
    }
    
    public function login()
    {
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
            
            if ($this->form_validation->run() == False)
            {
                echo json_encode(array(
                    'status' => 'fail',
                    'message' => validation_errors()
                ));
            }
            else
            {
                echo json_encode(array(
                    'status' => 'ok'
                ));
            }
        }
    }
    
    public function locaton_ping()
    {
        if ($this->input->is_ajax_request())
        {
            $lat = $data['lat'] = $this->input->post('lat');
            $lng = $data['lng'] = $this->input->post('lng');
            
            $data_array = array(
                'user_lat' => $lat,
                'user_lng' => $lng
            );
            $data['id'] = $this->User_model->save_location($data_array);
            echo json_encode($data);
        }
    }
    
    public function groupNew()
    {
        if ($this->input->is_ajax_request())
        {
            $id = NULL;
            $this->form_validation->set_rules('gName', 'Group Name', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('gCategory', 'Group Category', 'trim|required');
            
            if ($this->input->post('gVanity'))
            {
                $this->form_validation->set_rules('gVanity', 'Group Vanity URL', 'trim|alpha_numeric|is_unique[tbl_groups.vanity]');
                $vanity = $this->input->post('gVanity');
            }
            
            else
            {
                $vanity = random_string('alpha', 5);
            }
            
            if ($this->form_validation->run() == False)
            {
                echo json_encode(array(
                    'status' => 'fail',
                    'message' => validation_errors()
                ));
            }
            else
            {
                
                $group_name     = $this->input->post('gName');
                $logged_in_data = $this->session->userdata('logged_in');
                $creator        = $logged_in_data['uid'];
                $category       = $this->input->post('gCategory');
                
                
                $data_array = array(
                    'group_name' => $group_name,
                    'group_category' => $category,
                    'creator' => $creator,
                    'vanity' => $vanity
                );
                
                
                $id             = $this->User_model->createGroup($data_array);
                $logged_in_data = $this->session->userdata('logged_in');
                $data_array     = array(
                    'group_id' => $id,
                    'actor_id' => $logged_in_data['uid']
                );
                $this->db->insert('tbl_group_members', $data_array);
                
                if ($id)
                {
                    echo json_encode(array(
                        'status' => 'ok',
                        'vanity' => '<h3>Group Created! Group Hash <strong>' . $vanity . '</strong></h3>'
                    ));
                }
                else
                {
                    
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => validation_errors()
                    ));
                    
                }
            }
        }
    }
    
    public function groupJoin()
    {
        if ($this->input->is_ajax_request())
        {
            $id = NULL;
            $this->form_validation->set_rules('gHash', 'Group Hash', 'trim|required');
            
            $gHash = $this->input->post('gHash');
            
            $gHashID = $this->_validateGHash($gHash);
            $gId     = $gHashID[0]['group_id'];
            
            if ($this->form_validation->run() == False OR empty($gId))
            {
                echo json_encode(array(
                    'status' => 'fail',
                    'message' => 'Unable to Process your Request!'
                ));
                die;
            }
            else
            {                
                $group_name     = $this->input->post('gName');
                $logged_in_data = $this->session->userdata('logged_in');
                $creator        = $logged_in_data['uid'];
                $category       = $this->input->post('gCategory');
                
                $actor_id_data = $this->session->userdata('logged_in');
                $data_array    = array(
                    'group_id' => $gId,
                    'actor_id' => $actor_id_data['uid']
                );
                
                $this->db->debug = FALSE;
                @$this->db->insert('tbl_group_members', $data_array);
                
                $id = $this->db->insert_id();
                
                
                if ($id)
                {
                    echo json_encode(array(
                        'status' => 'ok',
                        'message' => '<h3>Successfully Joined!</h3>'
                    ));
                    die;
                }
                else
                {
                    
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'You are already a Participant!'
                    ));
                }
            }
        }
    }
    
    public function groupLeave()
    {
        if ($this->input->is_ajax_request())
        {
            $id = NULL;
            
            $group_id = $this->input->post('group_id');
            
            if (empty($group_id))
            {
                echo json_encode(array(
                    'status' => 'fail',
                    'message' => 'Unable to Process your Request!'
                ));
                die;
            }
            else
            {                
                $this->db->where('group_id', $group_id);
                $logged_in_data = $this->session->userdata('logged_in');
                $this->db->where('actor_id', $logged_in_data['uid']);
                $this->db->delete('tbl_group_members');
                
                $id = $this->db->affected_rows();
                
                if ($id)
                {
                    echo json_encode(array(
                        'status' => 'ok',
                        'message' => 'You left the Group!'
                    ));
                    die;
                }
                else
                {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'You are not a Participant!'
                    ));
                }
            }
        }
    }

    function chat()
    {
        if ($_POST)
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
            
            $username = $this->input->post('username');
            if ($this->form_validation->run() == False)
            {
                $userid = 0;
                $this->output->set_content_type('application/json')->set_output(json_encode($userid));
            }
            else
            {
                $userid = $this->User_model->get_name($username);
                $this->output->set_content_type('application/json')->set_output(json_encode($userid));
            }
        }
    }

    function check_database($password)
    {
        $username = $this->input->post('username');
        
        $result = $this->User_model->login($username, $password);
        
        if ($result)
        {
            $sess_array = array();
            foreach ($result as $row)
            {
                $sess_array = array(
                    'uid' => $row->uid,
                    'full_name' => $row->full_name,
                    'username' => $row->username,
                    'admin' => $row->is_admin,
                    'avatar' => $row->avatar
                );

                $this->session->set_userdata('logged_in', $sess_array);
                
                $setonline = $this->User_model->mark_online($username);                
            }
            return True;
        }
        else
        {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return False;
        }
    }

    function getIoTDataRecent()
    {        
            $uid = $this->session->userdata('logged_in')['uid'];
            $fetch_uid = 'user_'.$uid;
            $assoc = [
                'audio'           => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/audio.json',
                'heartBeat'       => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/heartBeat.json',
                'humidity'        => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/humidity.json',
                'lightIntensity'  => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/lightIntensity.json',
                'temperature'     => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/temperature.json',
            ];
            

            foreach ($assoc as $key => $value) {
                $IoT_data = trim(file_get_contents($value));                  
                $data[$key] = end(json_decode($IoT_data,1));
            }     
            $data['user'] = $fetch_uid;                                           
            echo json_encode($data);                    
    }

    function getIoTDataUser()
    {
        if($this->input->get('viewer'))
        {     
            $viewer_id = $this->input->get('viewer');   
            //$uid = $this->session->userdata('logged_in')['uid'];
            $fetch_uid = 'user_'.$viewer_id;
            $assoc = [
                'audio'           => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/audio.json',
                'heartBeat'       => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/heartBeat.json',
                'humidity'        => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/humidity.json',
                'lightIntensity'  => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/lightIntensity.json',
                'temperature'     => 'https://mainproject-c2cfb.firebaseio.com/'.$fetch_uid.'/temperature.json',
            ];
            

            foreach ($assoc as $key => $value) {
                $IoT_data = trim(file_get_contents($value));                  
                $data[$key] = end(json_decode($IoT_data,1));
            }     
            $data['user'] = $fetch_uid;                                           
            echo json_encode($data);    
        }                


    }






    /*  PRIVATE FUNCTONS */
    
    private function _validateGHash($gHash)
    {
        $this->db->from('tbl_groups');
        $this->db->where('vanity', $gHash);
        
        $query = $this->db->get();
        return $query->result_array();
        
    }
    
    public function test($gHash)
    {
        $data = $this->_validateGHash($gHash);
        print_r($data[0]['group_id']);
    }
}
