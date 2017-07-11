<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chat extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->view('session_check');
        $this->load->model('User_model', '', True);
        $username = $this->_getsessionuser();
        $this->load->model('Message_model');
    }
    
    private function _getsessionuser()
    {
        $p = $this->session->userdata('logged_in');
        return $p['username'];
    }
    
    public function index()
    {
        $this->load->view('temp/testchat');
    }
    
    public function user($p)
    {
        if (empty($p))
        {
            redirect('user/action');
        }

        $gId = $this->_validateGHash($p)[0]['group_id'];
        
        $this->load->model('Message_model');
        
        $limit       = 100;
        $start       = 0;
        $messageData = $this->Message_model->getGroupMessages($limit, $start, $gId);
        
        $uid                 = $this->_getsessionuserid();
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
        $returnData['gId']         = $gId;
        $returnData['sender']      = $uid;
        
        $this->load->view('temp/testchat', $returnData);
    }
    
    
    private function _validateGHash($gHash)
    {
        $this->db->from('tbl_groups');
        $this->db->where('vanity', $gHash);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    private function _getsessionuserid()
    {
        $person = $this->session->userdata('logged_in');
        $userid = $person['uid'];
        return $userid;
    }
}
