<?php

class Login extends CI_Controller {
	
	function index(){
		$this->load->view('login_view');		
	}
	
	function home(){
		$data = array();
		$data['main_content'] = 'includes/main_content';
		$this->load->view('includes/template', $data);			
	}
	
	function validate_credentials(){		
		$this->load->model('user_model');
		$query = $this->user_model->validate();
		
		if($query){ // if the user's credentials validated...
			$userData = $this->user_model->get_member_by_username($this->input->post('username'));
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true,
				'name' => $userData['name'],
				'id' => $userData['id'],
			);
			$this->session->set_userdata($data);
			$data['main_content'] = 'includes/main_content';
			$this->load->view('includes/template', $data);		
		}
		else{ // incorrect username or password
			$this->index();
		}
	}	
	
	function logout(){
		$this->session->sess_destroy();
		$this->index();
	}

}