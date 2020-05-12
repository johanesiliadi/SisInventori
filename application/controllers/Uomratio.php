<?php

class Uomratio extends MY_Controller {
	
	private $limit=10;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('uomratio_model');
		$this->load->model('uom_model');
	}
	public function index($offset=0,$order_column='id',$order_type='asc'){
		
		$uomratios = $this->uomratio_model->search_paged_list($this->limit,$offset,$order_column,$order_type,NULL);
		$uoms = $this->uom_model->get_uom_dropdown();
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/uomratio/index/');
		$config['total_rows'] = $this->uomratio_model->count_search('');
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
		$data['name_search'] = '';
		$data['table'] = $this->table->generate();
		
		$data['uomratios'] = $uomratios;
		$data['uoms'] = $uoms;
		$data['main_content'] = 'uomratio_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('name_search_position');
		}
		$name_search = $this->uomratio_model->searchterm_handler("name_search_position",$this->input->post("name_search"));
		$uomratios = $this->uomratio_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$name_search);
		$uoms = $this->uom_model->get_uom_dropdown();
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/uomratio/index/');
		$config['total_rows'] = $this->uomratio_model->count_search($name_search);
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
		$data['name_search'] = $name_search;
		
		$data['uomratios'] = $uomratios;
		$data['uoms'] = $uoms;
		$data['main_content'] = 'uomratio_list';
		$this->load->view('includes/template', $data);	

	}

	
	public function add_uomratio()
	{	
		$uoms = $this->uom_model->get_uom_dropdown();
		$data = array();
		$data['uoms'] = $uoms;
		$data['main_content'] = 'add_uomratio_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		$this->uomratio_model->delete($id);
		$this->index($offset,$order_column,$order_type);
	}
	
	public function update($id){
	
		$uoms = $this->uom_model->get_uom_dropdown();
		$data = array();
		$data['uoms'] = $uoms;
		$data['edit_mode'] = 'FALSE';
		$data['uomratio'] = $this->uomratio_model->get_by_id($id);
		$data['main_content'] = 'update_uomratio_view';
		$this->load->view('includes/template', $data);
	}
	
	public function create_uomratio()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('name', 'name', 'trim|required|callback_name_check');
		$this->form_validation->set_rules('id_uom1', 'uom 1', 'trim|required');
		$this->form_validation->set_rules('id_uom2', 'uom 2', 'trim|required');
		$this->form_validation->set_rules('ratio1', 'Ratio 1', 'trim|required|numeric');
		$this->form_validation->set_rules('ratio2', 'Ratio 2', 'trim|required|numeric');
		
		if($this->form_validation->run() == FALSE){
		
				$this->add_uomratio();
		}else{			
			$new_uomratio_insert_data = array(
				'name' => $this->input->post('name'),
				'uom_id1' => $this->input->post('id_uom1'),
				'uom_id2' => $this->input->post('id_uom2'),			
				'ratio1' => str_replace(',','.',$this->input->post('ratio1')),			
				'ratio2' => str_replace(',','.',$this->input->post('ratio2')),				
			);
			
			if($this->uomratio_model->create($new_uomratio_insert_data)){
				redirect(base_url()."uomratio/index");
			}else{
				$this->add_uomratio();	
			}
		}
		
	}
	
	public function name_check($str)
	{
		$uomratioData = $this->uomratio_model->get_name_by_reference($str);
		if (count($uomratioData) > 0){
			$this->form_validation->set_message('name_check', 'name sudah ada');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function edit_uomratio()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('id_uom1', 'uom 1', 'trim|required');
		$this->form_validation->set_rules('id_uom2', 'uom 2', 'trim|required');
		$this->form_validation->set_rules('ratio1', 'Ratio 1', 'trim|required|numeric');
		$this->form_validation->set_rules('ratio2', 'Ratio 2', 'trim|required|numeric');
		
		$uomratio_update_data = array(
				'name' => $this->input->post('name'),
				'uom_id1' => $this->input->post('id_uom1'),
				'uom_id2' => $this->input->post('id_uom2'),			
				'ratio1' => str_replace(',','.',$this->input->post('ratio1')),				
				'ratio2' => str_replace(',','.',$this->input->post('ratio2')),	
				'id' => $this->input->post('hidden_id'));
		
		if($this->form_validation->run() == FALSE){
			$uoms = $this->uom_model->get_uom_dropdown();
			$data = array();
			$data['uoms'] = $uoms;
			$data['edit_mode'] = 'TRUE';
			$data['uomratio'] = $uomratio_update_data;
			$data['main_content'] = 'update_uomratio_view';
			$this->load->view('includes/template', $data);
		}else{			
			if($this->uomratio_model->update($this->input->post('hidden_id'),$uomratio_update_data)){	
				redirect(base_url()."uomratio/index");
			}else{
				$uoms = $this->uom_model->get_uom_dropdown();
				$data['uoms'] = $uoms;
				$data['edit_mode'] = 'TRUE';
				$data['uomratio'] = $uomratio_update_data;
				$data['main_content'] = 'update_uomratio_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}

}