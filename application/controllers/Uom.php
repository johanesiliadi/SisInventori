<?php

class Uom extends MY_Controller {
	
	private $limit=10;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('uom_model');
	}
	public function index($offset=0,$order_column='id',$order_type='asc'){
		
		$uoms = $this->uom_model->get_paged_list($this->limit,$offset,$order_column,$order_type);
		
		$new_order = ($order_type=='asc'?'desc':'asc');
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/uom/index/');
		$config['total_rows'] = $this->uom_model->count_all();
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
		$data['uoms'] = $uoms;
		$data['main_content'] = 'uom_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('name_search');
		}
		$name_search = $this->uom_model->searchterm_handler("name_search",$this->input->post("name_search"));

		$new_order = ($order_type=='asc'?'desc':'asc');
		$uoms = $this->uom_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$name_search);
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/uom/search/');
		$config['total_rows'] = $this->uom_model->count_search($name_search);
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
		$data['uoms'] = $uoms;
		$data['main_content'] = 'uom_list';
		$this->load->view('includes/template', $data);	

	}
	
	public function add_uom()
	{	
		$data = array();
		$data['main_content'] = 'add_uom_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		$this->uom_model->delete($id);
		$this->index($offset,$order_column,$order_type);
	}
	
	public function update($id){
		$data = array();
		$data['edit_mode'] = 'FALSE';
		$data['uom'] = $this->uom_model->get_by_id($id);
		$data['main_content'] = 'update_uom_view';
		$this->load->view('includes/template', $data);
	}
	
	
	public function create_uom()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('short_name', 'Short name', 'trim|required');
		$this->form_validation->set_rules('long_name', 'Long name', 'trim|required');
		
		
		if($this->form_validation->run() == FALSE)
		{
				$data = array();
				$data['main_content'] = 'add_uom_view';
				$this->load->view('includes/template', $data);
		}
		
		else
		{			
			$new_uom_insert_data = array(
				'short_name' => $this->input->post('short_name'),
				'long_name' => $this->input->post('long_name')
			);
			if($this->uom_model->create($new_uom_insert_data))
			{
				redirect(base_url()."uom/index");
			}
			else
			{
				$data = array();
				$data['main_content'] = 'add_uom_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}
	
	
	
	public function edit_uom()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('short_name', 'Short name', 'trim|required');
		$this->form_validation->set_rules('long_name', 'Long name', 'trim|required');
		
		$uom_update_data = array(
				'short_name' => $this->input->post('short_name'),
				'long_name' => $this->input->post('long_name'),
				'id' => $this->input->post('hidden_id')			
			);
			
		if($this->form_validation->run() == FALSE){
				$data = array();
				$data['edit_mode'] = 'TRUE';
				$data['uom'] = $uom_update_data;
				$data['main_content'] = 'update_uom_view';
				$this->load->view('includes/template', $data);
		}else{			
			
			if($this->uom_model->update($this->input->post('hidden_id'),$uom_update_data)){
				redirect(base_url()."uom/index");
			}else
			{	
				$data = array();
				$data['edit_mode'] = 'TRUE';
				$data['uom'] = $uom_update_data;
				$data['main_content'] = 'update_uom_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}
	
}