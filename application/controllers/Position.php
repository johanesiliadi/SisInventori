<?php

class Position extends MY_Controller {
	
	private $limit=10;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('position_model');
		$this->load->model('client_model');
		$this->load->model('user_model');
	}
	public function index($offset=0,$order_column='id',$order_type='asc'){
		
		$positions = $this->position_model->search_paged_list($this->limit,$offset,$order_column,$order_type,NULL,NULL)->result();
		$clients = array();
		$query = $this->client_model->get_all();
		$clients[''] = '-Please select-';
		foreach($query->result() as $row){
			$clients[$row->id] = $row->name;
		}
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/position/index/');
		$config['total_rows'] = $this->position_model->count_search('','');
		$config['per_page'] = $this->limit;
		$config['url_segment'] = 3;
		$this->pagination->initialize($config);
		$data = array();
		$data['pagination'] = $this->pagination->create_links();
		
		$new_order = ($order_type=='asc'?'desc':'asc');
		
		$data['order_column'] = $order_column;
		$data['order_type'] = $order_type;
		$data['offset'] = $offset;
		$data['new_order'] = $new_order;
		$data['title_search'] = '';
		$data['company_search'] = '';
		$data['table'] = $this->table->generate();
		
		$data['positions'] = $positions;
		$data['clients'] = $clients;
		$data['main_content'] = 'position_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('title_search_position');
			$this->session->unset_userdata('company_search_position');
		}
		$title_search = $this->position_model->searchterm_handler("title_search_position",$this->input->post("title_search"));
		$company_search = $this->position_model->searchterm_handler("company_search_position",$this->input->post("company_search"));
		
		$positions = $this->position_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$title_search,$company_search)->result();
		$clients = array();
		$query = $this->client_model->get_all();
		$clients[''] = '-Please select-';
		foreach($query->result() as $row){
			$clients[$row->id] = $row->name;
		}
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/position/index/');
		$config['total_rows'] = $this->position_model->count_search($title_search,$company_search);
		$config['per_page'] = $this->limit;
		$config['url_segment'] = 3;
		$this->pagination->initialize($config);
		$data = array();
		$data['pagination'] = $this->pagination->create_links();
		
		$new_order = ($order_type=='asc'?'desc':'asc');
		
		$data['order_column'] = $order_column;
		$data['order_type'] = $order_type;
		$data['offset'] = $offset;
		$data['new_order'] = $new_order;
		$data['title_search'] = $title_search;
		$data['company_search'] = $company_search;
		
		$data['positions'] = $positions;
		$data['clients'] = $clients;
		$data['main_content'] = 'position_list';
		$this->load->view('includes/template', $data);	

	}

	
	public function add_position()
	{	
		$clients = array();
		$query = $this->client_model->get_all();
		$clients[''] = '-Please select-';
		foreach($query->result() as $row){
			$clients[$row->id] = $row->name;
		}
		$users = array();
		$queryUser = $this->user_model->get_all();
		$users[''] = '-Please select-';
		foreach($queryUser->result() as $row){
			$users[$row->id] = $row->first_name.' '.$row->last_name;
		}
		$data = array();
		$data['users'] = $users;
		$data['clients'] = $clients;
		$data['main_content'] = 'add_position_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		$this->position_model->delete($id);
		$this->index($offset,$order_column,$order_type);
	}
	
	public function update($id){
	
		$clients = array();
		$query = $this->client_model->get_all();
		$clients[''] = '-Please select-';
		foreach($query->result() as $row){
			$clients[$row->id] = $row->name;
		}
		$users = array();
		$queryUser = $this->user_model->get_all();
		$users[''] = '-Please select-';
		foreach($queryUser->result() as $row){
			$users[$row->id] = $row->first_name.' '.$row->last_name;
		}
		$data = array();
		$data['users'] = $users;
		$data['clients'] = $clients;
		$data['edit_mode'] = 'FALSE';
		$data['position'] = $this->position_model->get_by_id($id);
		$data['main_content'] = 'update_position_view';
		$this->load->view('includes/template', $data);
	}
	
	public function create_position()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('reference_number', 'Reference Number', 'trim|required|callback_reference_check');
		$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required');
		$this->form_validation->set_rules('responsibility', 'Responsibility', 'trim|required');
		$this->form_validation->set_rules('job_description', 'job_description', 'trim');
		$this->form_validation->set_rules('requirement', 'requirement', 'trim');
		$this->form_validation->set_rules('salary', 'salary', 'trim');
		$this->form_validation->set_rules('contact', 'Contact', 'trim|required');
		$this->form_validation->set_rules('client_id', 'Client', 'trim|required');
		$this->form_validation->set_rules('pic_id', 'Pic', 'trim');	
		$this->form_validation->set_rules('additional_info', 'Additional Info', 'trim');		
		
		if($this->form_validation->run() == FALSE)
		{
		
				$this->add_position();
		}
		
		else
		{			
			$new_position_insert_data = array(
				'reference_number' => $this->input->post('reference_number'),
				'job_title' => $this->input->post('job_title'),
				'job_description' => $this->input->post('job_description'),			
				'responsibility' => $this->input->post('responsibility'),
				'requirement' => md5($this->input->post('requirement')),
				'additional_info' => $this->input->post('additional_info')	,
				'client_id' => $this->input->post('client_id')	,
				'salary' => $this->input->post('salary')	,
				'contact' => $this->input->post('contact')	,
				'status' => $this->input->post('status')	,
				'pic_id' => '' == $this->input->post('pic_id') ? NULL : $this->input->post('pic_id') 					
			);
			
			if($this->position_model->create($new_position_insert_data))
			{
				if('' != $this->input->post('pic_id')){
					
					$pic = $this->user_model->get_by_id($this->input->post('pic_id'));
					$this->send_email($pic->email_address,'New Position', 'You\'re assigned new position'.$this->input->post('reference_number'));
				}
				$this->index();
			}
			else
			{
				$this->add_position();	
			}
		}
		
	}
	
	public function reference_check($str)
	{
		$positionData = $this->position_model->get_position_by_reference($str);
		if (count($positionData) > 0)
		{
			$this->form_validation->set_message('reference_check', 'The reference already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function send_email($to,$subject,$message)
	{	
	
		$config = Array(
		   'protocol' => 'smtp',
		   'smtp_host' => 'ssl://smtp.googlemail.com',
		   'smtp_port' => 465,
		   'smtp_user' => 'johanes03@gmail.com',
		   'smtp_pass' => 'jessica272',
		 );
		 $this->load->library('email', $config);
		 $this->email->set_newline("\r\n");
		
		$this->email->from('fromuser@anyaccount.com', 'Mr. Test');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
		
	}  
	
	public function edit_position()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('reference_number', 'Reference Number', 'trim|required');
		$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required');
		$this->form_validation->set_rules('responsibility', 'Responsibility', 'trim|required');
		$this->form_validation->set_rules('job_description', 'job_description', 'trim');
		$this->form_validation->set_rules('requirement', 'requirement', 'trim');
		$this->form_validation->set_rules('salary', 'salary', 'trim');
		$this->form_validation->set_rules('contact', 'Contact', 'trim|required');
		$this->form_validation->set_rules('client_id', 'Client', 'trim|required');
		$this->form_validation->set_rules('pic_id', 'Pic', 'trim');	
		$this->form_validation->set_rules('additional_info', 'Additional Info', 'trim');	
		
		$position_update_data = array(
				'reference_number' => $this->input->post('reference_number'),
				'job_title' => $this->input->post('job_title'),
				'job_description' => $this->input->post('job_description'),			
				'responsibility' => $this->input->post('responsibility'),
				'requirement' => md5($this->input->post('requirement')),
				'additional_info' => $this->input->post('additional_info')	,
				'client_id' => $this->input->post('client_id')	,
				'salary' => $this->input->post('salary')	,
				'contact' => $this->input->post('contact')	,
				'status' => $this->input->post('status')	,
				'pic_id' => '' == $this->input->post('pic_id') ? NULL : $this->input->post('pic_id') 				);
		
		if($this->form_validation->run() == FALSE)
		{
				$clients = array();
				$query = $this->client_model->get_all();
				$clients[''] = '-Please select-';
				foreach($query->result() as $row){
					$clients[$row->id] = $row->name;
				}
				$users = array();
				$queryUser = $this->user_model->get_all();
				$users[''] = '-Please select-';
				foreach($queryUser->result() as $row){
					$users[$row->id] = $row->first_name.' '.$row->last_name;
				}
				$data = array();
				$data['users'] = $users;
				$data['clients'] = $clients;
				$data['edit_mode'] = 'TRUE';
				$data['position'] = $position_update_data;
				$data['main_content'] = 'update_position_view';
				$this->load->view('includes/template', $data);
		}
		
		else
		{			
			if($query = $this->position_model->update($this->input->post('hidden_id'),$position_update_data))
			{
				if('' != $this->input->post('pic_id')){
					
					$pic = $this->user_model->get_by_id($this->input->post('pic_id'));
					$old_position = $this->position_model->get_by_id($this->input->post('hidden_id'));
					if($old_position->pic_id != $this->input->post('pic_id')){
						$this->send_email($pic->email_address,'New Position', 'You\'re assigned new position'.$this->input->post('reference_number'));
					}
				}
				$this->index();
			}
			else{
				$clients = array();
				$query = $this->client_model->get_all();
				$clients[''] = '-Please select-';
				foreach($query->result() as $row){
					$clients[$row->id] = $row->name;
				}
				$users = array();
				$queryUser = $this->user_model->get_all();
				$users[''] = '-Please select-';
				foreach($queryUser->result() as $row){
					$users[$row->id] = $row->first_name.' '.$row->last_name;
				}
				$data['users'] = $users;
				$data['clients'] = $clients;
				$data['edit_mode'] = 'TRUE';
				$data['position'] = $position_update_data;
				$data['main_content'] = 'update_position_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}

}