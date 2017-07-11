<?php
class Admin_model extends CI_Model 
{
	function __construct()
	{
	    parent::__construct();
	}
    function getGroupMembers()
    {
        $this->db->from('tbl_group_members');
        $this->db->join('tbl_users', 'tbl_group_members.actor_id = tbl_users.uid');
        $this->db->join('tbl_groups', 'tbl_groups.group_id= tbl_group_members.group_id');
        $this->db->order_by('tbl_groups.group_id');

        $query = $this->db->get();
        
        return $query->result_array();
    }	


}