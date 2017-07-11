<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');

if(!$this->session->userdata('logged_in')['uid'])
{
	$this->session->set_flashdata('msg', '<div class="alert alert-info">
                                        <button type="button" aria-hidden="true" data-dismiss="alert"  class="close">
                                            <i class="material-icons">close</i>
                                        </button>
                                        <span>You must be logged in to access that page!</span>
                                    </div>');
	redirect("user/login");
}


 ?>