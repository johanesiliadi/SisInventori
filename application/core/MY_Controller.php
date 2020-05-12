<?php

class MY_Controller extends CI_Controller { 
 
    function __construct() 
    { 
        parent::__construct(); 
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('login'); 
			//echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	
			//die();		
			//$this->load->view('login_form');
		}
    } 
} 
