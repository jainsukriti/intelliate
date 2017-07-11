<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->view('session_check');    
    }

    private function _getsessionuserid()
    {
        $p      = $this->session->userdata('logged_in');
        $userid = $p['uid'];
        return $userid;
    }
    
    public function submit()
    {
        if (!$this->session->userdata('logged_in'))
        {
            exit(json_encode(array(
                'status' => 'error',
                'errormessage' => 'Please log in to submit chat messages'
            )));
        }
        
        $message = $this->input->post('message');
        if ($message == '')
        {
            exit(json_encode(array(
                'status' => 'error',
                'errormessage' => 'Please enter a message to submit'
            )));
        }
        
        $this->load->model('message_model');
        
        $messageData = array(
            'uid' => $this->_getsessionuserid(),
            'message' => $message,
            'datetime' => date('Y-m-d H:i:s')
        );
        
        $returnMessageData          = $this->message_model->insertMessage($messageData);
        $messageData['message_id']  = $returnMessageData;
        $messageData['avatar']      = $this->session->userdata('logged_in')['avatar'];
        $messageData['username']    = $this->session->userdata('logged_in')['username'];
        $messageHtml                = $this->message_model->generateMessageHtml($messageData);
        $messageData['messageHtml'] = $messageHtml;
        $messageData['status']      = "success";
        exit(json_encode($messageData));
    }
    
    public function im()
    {
        if (!$this->session->userdata('logged_in'))
        {
            exit(json_encode(array(
                'status' => 'error',
                'errormessage' => 'Please log in to submit chat messages'
            )));
        }
        
        $message = $this->input->post('message');
        $receiver = $this->input->post('receiver');
        if ($message == '' OR $receiver=='')
        {
            exit(json_encode(array(
                'status' => 'error',
                'errormessage' => 'Somethings went wrong!'
            )));
        }
        
        $this->load->model('message_model');
        
        $messageData = array(
            'sender' => $this->_getsessionuserid(),
            'group_id' => $receiver,
            'message' => $message, 
            'msg_time' => date('Y-m-d H:i:s')
        );
        
        $returnMessageData          = $this->message_model->insertimMessage($messageData);
        $messageData['message_id']  = $returnMessageData;
        $messageData['avatar']      = $this->session->userdata('logged_in')['avatar'];
        $messageData['username']    = $this->session->userdata('logged_in')['username'];
        $messageData['uid']         = $this->session->userdata('logged_in')['uid'];
        $messageHtml                = $this->message_model->generateimMessageHtml($messageData);
        $messageHtmlSelf            = $this->message_model->generateimMessageHtmlSelf($messageData);
        $messageData['messageHtml'] = $messageHtml;
        $messageData['messageHtmlSelf'] = $messageHtmlSelf;
        $messageData['status']      = "success";
        exit(json_encode($messageData));
    }
    

    public function getPaginated()
    {
        $this->load->model('user_model');
        $this->load->model('message_model');
        $pageNum     = $this->uri->segment(4);
        $queryuser   = $this->uri->segment(3);
        $limit       = 10;
        $start       = $pageNum * 10;
        $messageData = $this->message_model->getChatMessagesbyuser($limit, $start,$queryuser);
        
        $returnMessageArray = array();
        foreach ($messageData as $message)
        {
            $userData   = $this->user_model->getUserDataById($message['sender']);
            $newMessage = array(
                'user_id' => $message['receiver'],
                'message' => $message['message'],
                'datetime' => $message['datetime'],
                'avatar' => $userData[0]['avatar'],
                'username' => $userData[0]['username']
            );
            
            $newMessage['messageHtml'] = $this->message_model->generateMessageHtml($newMessage);
            
            array_push($returnMessageArray, $newMessage);
        }
        #echo '<xmp>';
        echo json_encode(array(
            'status' => 'success',
            'messageData' => $returnMessageArray
        ));
        #echo '</xmp>';
    }
}
