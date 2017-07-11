<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');

if($this->session->userdata('logged_in')['uid'])
{
	redirect("user/action");
}

?>