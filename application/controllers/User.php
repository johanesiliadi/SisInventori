<?php

class User extends MY_Controller {
	
	private $limit=10;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('user_model');
	}
	public function index($offset=0,$order_column='id',$order_type='asc'){
		
		$memberships = $this->user_model->get_paged_list($this->limit,$offset,$order_column,$order_type);
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/user/index/');
		$config['total_rows'] = $this->user_model->count_all();
		$config['per_page'] = $this->limit;
		$config['url_segment'] = 3;
		$this->pagination->initialize($config);
		$data = array();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->library('table');
		$this->table->set_empty("&nbsp;");
		$new_order = ($order_type=='asc'?'desc':'asc');
		$this->table->set_heading('No',anchor('/user/index/'.$offset.'/name/'.$new_order, "Full Name"),
		anchor('/user/index/'.$offset.'/username/'.$new_order, "Username"), 'Actions');
		
		$i=0+$offset;
		
		foreach($memberships as $member){
			$this->table->add_row(++$i,$member['name'],
		$member['username'], 
		anchor('/user/view/'.$member['id'], "View")." ".anchor('/user/edit/'.$member['id'], "Edit")
		." ".anchor('/user/delete/'.$member['id'].'/'.$offset.'/'.$order_column.'/'.$order_type, "Delete",
		array('onclick'=>"return confirm('delete user ".$member['name']."?')")));
			
		}
		
		$data['order_column'] = $order_column;
		$data['order_type'] = $order_type;
		$data['offset'] = $offset;
		$data['new_order'] = $new_order;
		$data['name_search'] = '';
		$data['username_search'] = '';
		$data['table'] = $this->table->generate();
		$data['members'] = $memberships;
		$data['main_content'] = 'user_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('name_search_user');
			$this->session->unset_userdata('username_search_user');
		}
		$name_search = $this->user_model->searchterm_handler("name_search_user",$this->input->post("name_search"));
		$username_search = $this->user_model->searchterm_handler("username_search_user",$this->input->post("username_search"));
		
		$new_order = ($order_type=='asc'?'desc':'asc');
		$memberships = $this->user_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$name_search, $username_search);
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/user/search/');
		$config['total_rows'] = $this->user_model->count_search($name_search, $username_search);
		$config['per_page'] = $this->limit;
		$config['url_segment'] = 3;
		$this->pagination->initialize($config);
		$data = array();
		$data['pagination'] = $this->pagination->create_links();
		
		
		
		$data['order_column'] = $order_column;
		$data['order_type'] = $order_type;
		$data['offset'] = $offset;
		$data['new_order'] = $new_order;
		$data['name_search'] = $name_search;
		$data['username_search'] = $username_search;
		$data['table'] = $this->table->generate();
		$data['members'] = $memberships;
		$data['main_content'] = 'user_list';
		$this->load->view('includes/template', $data);	

	}

	public function update_password(){
		$data = array();
		$data['main_content'] = 'update_password_view';
		$this->load->view('includes/template', $data);
	}
	
	
	public function add_user()
	{
		$data = array();
		$data['main_content'] = 'add_user_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		$this->user_model->delete($id);
		$this->index($offset,$order_column,$order_type);
	}
	
	public function update($id){
		$data = array();
		$data['edit_mode'] = 'FALSE';
		$data['user'] = $this->user_model->get_by_id($id);
		$data['main_content'] = 'update_user_view';
		$this->load->view('includes/template', $data);
	}
	
	public function create_user()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		
		if($this->form_validation->run() == FALSE){
				$data = array();
				$data['main_content'] = 'add_user_view';
				$this->load->view('includes/template', $data);
		}else{			
			$new_member_insert_data = array(
				'name' => $this->input->post('name'),
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password'))					
			);
			
			if($this->user_model->create($new_member_insert_data)){
				redirect(base_url()."user/index");
			}else{
				$data['main_content'] = 'add_user_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}
	
	public function edit_password()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('old_password', 'Old password', 'trim|required|min_length[4]|callback_old_password_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		
		
		if($this->form_validation->run() == FALSE){
		
			$this->update_password();
		}else{			
			$new_password = md5($this->input->post('password'));
			if($this->user_model->update_password($this->session->userdata('id'),$new_password)){
				redirect(base_url()."user/index");
			}else{
				$this->update_password();	
			}
		}
		
	}
	
	public function edit_user()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		
		$member_update_data = array(
				'name' => $this->input->post('name'),
				'username' => $this->input->post('hidden_username'),	
				'id' => $this->input->post('hidden_id')			
			);
		
		if($this->form_validation->run() == FALSE){
				$data = array();
				$data['edit_mode'] = 'TRUE';
				$data['user'] = $member_update_data;
				$data['main_content'] = 'update_user_view';
				$this->load->view('includes/template', $data);
		}else{			
			if($this->user_model->update($this->input->post('hidden_id'),$member_update_data)){
				redirect(base_url()."user/index");
			}else{	
				$data['edit_mode'] = 'TRUE';
				$data['user'] = $member_update_data;
				$data['main_content'] = 'update_user_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}
	
	public function username_check($str)
	{
		$memberData = $this->user_model->get_member_by_username($str);
		if (count($memberData) > 0){
			$this->form_validation->set_message('username_check', 'User exists');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function old_password_check($str)
	{
	$memberData = $this->user_model->get_member_by_username($this->session->userdata('username'));

		if (strcmp(md5($str),$memberData['password']) != 0){
			$this->form_validation->set_message('old_password_check', 'Invalid old password');
			return FALSE;
		}else{
			return TRUE;
		}
	}

}