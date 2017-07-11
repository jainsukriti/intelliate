<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->view('session_check');
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
    
    public function gid($p)
    {
        
        if (empty($p))
        {
            redirect('user/action');
        }
        
        $gId = $this->_validateGHash($p)[0]['group_id'];
        $gName = $this->_validateGHash($p)[0]['group_name'];
        
        
        $this->load->model('Message_model');
        
        $limit       = 100;
        $start       = 0;
        $messageData = $this->Message_model->getGroupMessages($limit, $start, $gId);
        
        $uid = $this->_getsessionuserid();

        $newMessageDataArray = array();

        foreach ($messageData as $message)
        {
            $userData = $this->User_model->getUserDataById($message['sender']);

            if ($message['sender'] == $uid)
            {
                $target = 'me';
            }
            else
            {
                $target = 'them';
            }

            $newMessage = array(
                'message' => $message['message'],
                'msg_time' => $message['msg_time'],
                'avatar' => $userData[0]['avatar'],
                'username' => $userData[0]['username'],
                'uid' => $message['sender'],
                'target' => $target
            );
            
            $newMessage['messageHtml'] = $this->Message_model->generateMessageHtml($newMessage);
            
            array_push($newMessageDataArray, $newMessage);
        }
        
        $returnData['messageData'] = array_reverse($newMessageDataArray);
        $returnData['group_hash']  = $p;
        $returnData['gName']       = $gName;
        $returnData['gId']         = $gId;
        $returnData['sender']      = $uid;
        
        $this->load->view('group/chat', $returnData);
    }
    
    public function info($gHash)
    {
        if (empty($gHash))
        {
            redirect('user/action');
        }
        else
        {
            $gId = $this->_validateGHash($gHash)[0]['group_id'];
            $param['vanity'] = $gHash;
            
            if ($gId)
            {
                $data['members_data'] = $this->User_model->getGroupMembers($gId);
                $this->load->view('head_tag');
                $this->load->view('group/group_header', $param);
                $this->load->view('group/info', $data);
                $this->load->view('group/group_footer');
                $this->load->view('scripts');
            }
            else
            {
                redirect('user/action');
            }
        }
    }
    
    private function _get_menu_guest()
    {
        return array(
            array(
                'link' => base_url() . 'home',
                'icon' => 'home',
                'name' => 'Home'
            ),
            array(
                'link' => base_url() . 'user/login',
                'icon' => 'lock',
                'name' => 'Login'
            ),
            array(
                'link' => base_url() . 'user/register',
                'icon' => 'person_add',
                'name' => 'Register'
            )
        );
    }
    
    private function _get_menu_logged()
    {
        return array(
            array(
                'link' => base_url() . 'home',
                'icon' => 'home',
                'name' => 'Home'
            ),
            array(
                'link' => base_url() . 'user/logout',
                'icon' => 'power_settings_new',
                'name' => 'Logout'
            )
        );
    }
    
    private function _validateGHash($gHash)
    {
        $this->db->from('tbl_groups');
        $this->db->where('vanity', $gHash);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    private function _getsessionuser()
    {
        $p        = $this->session->userdata('logged_in');
        $username = $p['username'];
        return $username;
    }
    
    private function _getsessionuserid()
    {
        $p      = $this->session->userdata('logged_in');
        $userid = $p['uid'];
        return $userid;
    }
    
}
