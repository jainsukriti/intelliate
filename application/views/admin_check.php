<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');

$p = $this->session->userdata('logged_in');

if(!$p['admin'])
{
	show_404();
}

 ?>