<?php
class Message_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function insertMessage($messageData)
    {   
        if (empty($messageData)) 
        {
            return false;
        }
        
        $this->db->insert('messages', $messageData); 
        return $this->db->insert_id();
    }

    function insertimMessage($messageData)
    {   
        if (empty($messageData)) 
        {
            return false;
        }
        
        $this->db->insert('tbl_messages', $messageData);
        return $this->db->insert_id();
    }
    
    function getChatMessages($limit, $start)
    {
         $this->db->limit($limit, $start);
         $this->db->order_by('msg_id', "desc"); 
         $query = $this->db->get('tbl_messages');
         return $query->result_array();
    }

    function getGroupMessages($limit, $start,$gid)
    {
         if (empty($gid)) 
         {
            return false;
         }
         
         $this->db->limit($limit, $start);
         $this->db->order_by('msg_id', "desc"); 
         $uid = $this->session->userdata('logged_in')['uid'];
         $where = 'group_id='.$gid;
         $this->db->where($where);
         $query = $this->db->get('tbl_messages');
         return $query->result_array();
    }
    
    function generateMessageHtml($messageData)
    {
        $msg_time = new DateTime($messageData['msg_time']);
        $isoDateTime = $msg_time->format(DateTime::ISO8601);
        $messageHtml = '<li class="left clearfix">'
                            .'<span class="chat-img pull-left">'
                                .'<img src="'.base_url().'uploads/dp/thumbs/200x200/'. $messageData['avatar'] . '" alt="User Avatar" class="img-circle img-responsive" style="width:50px" />'
                            .'</span>'
                            .'<div class="chat-body clearfix">'
                                .'<div class="header">'
                                    .'<h4 class="primary-font pull-left">' . $messageData['uid'] . '</h4>'

                                    .'<small class="pull-right  text-muted"><span class="glyphicon glyphicon-time"></span><time class="fancyTime" datetime="' . $isoDateTime . '"></time></small>'
                                .'</div>'
                                .'<h5 class="text-left">'
                                    .htmlentities($messageData['message'])
                                .'</h5>'
                            .'</div>'
                        .'</li>';
        
        return $messageHtml;
    }
    function generateimMessageHtml($messageData)
    {
        $msg_time = new DateTime($messageData['msg_time']);
        $isoDateTime = $msg_time->format(DateTime::ISO8601);
        $messageHtml = '<li class="left clearfix">'
                            .'<span class="chat-img pull-left" style="padding:1%;">'
                                .'<img style="width:50px;" src="'.base_url().'uploads/dp/thumbs/200x200/'. $messageData['avatar'] . '" alt="User Avatar" class="img-circle" />'
                            .'</span>'
                            .'<div class="chat-body clearfix" style="padding:2%;">'
                                .'<div class="header">'
                                    .'<strong class="primary-font pull-left">' . $messageData['username'] . '</strong>'
                                    .'<small class="pull-right  text-muted"><span class="glyphicon glyphicon-time"></span><time class="fancyTime" datetime="' . $isoDateTime . '"></time></small>'
                                .'</div>'
                                .'<p>'
                                    .htmlentities($messageData['message'])
                                .'</p>'
                            .'</div>'
                        .'</li>';

        $messageHtml = '<div class="message-wrapper them">'
              .'<div class="avatar_card animated bounceIn"><img class="avatar_resize" src="'.base_url().'uploads/dp/thumbs/200x200/avatar.png"></div>'
              .'<div class="text-wrapper animated fadeIn">'.htmlentities($messageData['message']).'</div>'
            .'</div>';
        
        return $messageHtml;
    }

    function generateimMessageHtmlSelf($messageData)
    {
        $msg_time = new DateTime($messageData['msg_time']);
        $isoDateTime = $msg_time->format(DateTime::ISO8601);
        $messageHtml = '<li class="left clearfix">'
                            .'<span class="chat-img pull-left" style="padding:1%;">'
                                .'<img style="width:50px;" src="'.base_url().'uploads/dp/thumbs/200x200/'. $messageData['avatar'] . '" alt="User Avatar" class="img-circle" />'
                            .'</span>'
                            .'<div class="chat-body clearfix" style="padding:2%;">'
                                .'<div class="header">'
                                    .'<strong class="primary-font pull-left">' . $messageData['username'] . '</strong>'
                                    .'<small class="pull-right  text-muted"><span class="glyphicon glyphicon-time"></span><time class="fancyTime" datetime="' . $isoDateTime . '"></time></small>'
                                .'</div>'
                                .'<p>'
                                    .htmlentities($messageData['message'])
                                .'</p>'
                            .'</div>'
                        .'</li>';

        $messageHtml = '<div class="message-wrapper me">'
              .'<div class="avatar_card animated bounceIn"><img class="avatar_resize" src="'.base_url().'uploads/dp/thumbs/200x200/avatar.png"></div>'
              .'<div class="text-wrapper animated fadeIn">'.htmlentities($messageData['message']).'</div>'
            .'</div>';
        
        return $messageHtml;
    }
}
