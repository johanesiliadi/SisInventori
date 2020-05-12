<?php

class Client extends MY_Controller {
	
	private $limit=10;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('client_model');
	}
	public function index($offset=0,$order_column='id',$order_type='asc'){
		
		$clients = $this->client_model->get_paged_list($this->limit,$offset,$order_column,$order_type);
		
		$new_order = ($order_type=='asc'?'desc':'asc');
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/client/index/');
		$config['total_rows'] = $this->client_model->count_all();
		$config['per_page'] = $this->limit;
		$config['url_segment'] = 3;
		$this->pagination->initialize($config);
		$data = array();
		$data['pagination'] = $this->pagination->create_links();
		
		
		$data['order_column'] = $order_column;
		$data['order_type'] = $order_type;
		$data['offset'] = $offset;
		$data['new_order'] = $new_order;
		$data['name_search'] = '';
		$data['clients'] = $clients;
		$data['main_content'] = 'client_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('name_search');
		}
		$name_search = $this->client_model->searchterm_handler("name_search",$this->input->post("name_search"));

		$new_order = ($order_type=='asc'?'desc':'asc');
		$clients = $this->client_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$name_search);
		$this->load->library('pagination');
		
		$config = array();
		$config['base_url'] = site_url('/client/search/');
		$config['total_rows'] = $this->client_model->count_search($name_search);
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
		$data['table'] = $this->table->generate();
		$data['clients'] = $clients;
		$data['main_content'] = 'client_list';
		$this->load->view('includes/template', $data);	

	}
	
	public function add_client()
	{	
		$data = array();
		$data['main_content'] = 'add_client_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		$this->client_model->delete($id);
		$this->index($offset,$order_column,$order_type);
	}
	
	public function update($id){
		$data = array();
		$data['edit_mode'] = 'FALSE';
		$data['client'] = $this->client_model->get_by_id($id);
		$data['main_content'] = 'update_client_view';
		$this->load->view('includes/template', $data);
	}
	
	
	public function create_client()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('remark', 'Remark', 'trim');
		$this->form_validation->set_rules('phone_number1', 'Phone', 'trim|required');
		
		
		if($this->form_validation->run() == FALSE)
		{
				$data = array();
				$data['main_content'] = 'add_client_view';
				$this->load->view('includes/template', $data);
		}
		
		else
		{			
			$new_member_insert_data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('short_name'),
				'address' => $this->input->post('address'),			
				'information' => $this->input->post('remark'),
				'phone' => $this->input->post('phone_number1'),
			);
			
			if($this->client_model->create($new_member_insert_data))
			{
				redirect(base_url()."client/index");
			}
			else
			{
				$data['main_content'] = 'add_client_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}
	
	
	
	public function edit_client()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('remark', 'Remark', 'trim');
		$this->form_validation->set_rules('phone_number1', 'Phone', 'trim|required');
		
		$client_update_data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('short_name'),
				'address' => $this->input->post('address'),			
				'information' => $this->input->post('remark'),
				'phone' => $this->input->post('phone_number1'),
				'id' => $this->input->post('hidden_id')			
			);
		if($this->form_validation->run() == FALSE)
		{
				$data = array();
				$data['edit_mode'] = 'TRUE';
				$data['client'] = $client_update_data;
				$data['main_content'] = 'update_client_view';
				$this->load->view('includes/template', $data);
		}
		
		else
		{			
			
			if($this->client_model->update($this->input->post('hidden_id'),$client_update_data))
			{
				redirect(base_url()."client/index");
			}
			else
			{	
				$data = array();
				$data['edit_mode'] = 'TRUE';
				$data['client'] = $client_update_data;
				$data['main_content'] = 'update_client_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}
	
}