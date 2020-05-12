<?php

class Inventory extends MY_Controller {
	
	private $limit=10;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('inventory_model');
		$this->load->model('uom_model');
	}
	public function index($offset=0,$order_column='id',$order_type='asc'){
		
		$inventories = $this->inventory_model->search_paged_list($this->limit,$offset,$order_column,$order_type,NULL,NULL);
		$uoms = $this->uom_model->get_uom_dropdown();
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/inventory/index/');
		$config['total_rows'] = $this->inventory_model->count_search('','');
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
		$data['code_search'] = '';
		$data['table'] = $this->table->generate();
		
		$data['inventories'] = $inventories;
		$data['uoms'] = $uoms;
		$data['main_content'] = 'inventory_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('code_search_position');
			$this->session->unset_userdata('name_search_position');
		}
		$code_search = $this->inventory_model->searchterm_handler("code_search_position",$this->input->post("code_search"));
		$name_search = $this->inventory_model->searchterm_handler("name_search_position",$this->input->post("name_search"));
		
		$inventories = $this->inventory_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$code_search,$name_search);
		$uoms = $this->uom_model->get_uom_dropdown();
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/inventory/index/');
		$config['total_rows'] = $this->inventory_model->count_search($code_search,$name_search);
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
		$data['code_search'] = $code_search;
		$data['name_search'] = $name_search;
		
		$data['inventories'] = $inventories;
		$data['uoms'] = $uoms;
		$data['main_content'] = 'inventory_list';
		$this->load->view('includes/template', $data);	

	}

	
	public function add_inventory(){	
		$uoms = $this->uom_model->get_uom_dropdown();
		$data = array();
		$data['uoms'] = $uoms;
		$data['main_content'] = 'add_inventory_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		$this->inventory_model->delete($id);
		$this->index($offset,$order_column,$order_type);
	}
	
	public function update($id){
	
		$uoms = $this->uom_model->get_uom_dropdown();
		$data = array();
		$data['uoms'] = $uoms;
		$data['edit_mode'] = 'FALSE';
		$data['inventory'] = $this->inventory_model->get_by_id($id);
		$data['main_content'] = 'update_inventory_view';
		$this->load->view('includes/template', $data);
	}
	
	public function create_inventory(){
		// field name, error message, validation rules
		$this->form_validation->set_rules('item_code', 'Item Code', 'trim|required|callback_code_check');
		$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|numeric');
		$this->form_validation->set_rules('uom_id', 'Uom', 'trim|required');		
		
		if($this->form_validation->run() == FALSE){
		
				$this->add_inventory();
		}else{			
			$new_inventory_insert_data = array(
				'item_code' => $this->input->post('item_code'),
				'item_name' => $this->input->post('item_name'),
				'quantity' => str_replace(',','.',$this->input->post('quantity')),			
				'uom_id' => $this->input->post('uom_id'),				
			);
			
			if($this->inventory_model->create($new_inventory_insert_data)){
				redirect(base_url()."inventory/index");
			}else{
				$this->add_inventory();	
			}
		}
		
	}
	
	public function code_check($str){
		$inventoryData = $this->inventory_model->get_code_by_reference($str);
		if (count($inventoryData) > 0){
			$this->form_validation->set_message('code_check', 'Duplicate item code');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function edit_inventory(){
		// field name, error message, validation rules
		$this->form_validation->set_rules('item_code', 'Item Code', 'trim|required');
		$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|numeric');
		$this->form_validation->set_rules('uom_id', 'uom', 'trim|required');		
		
		$inventory_update_data = array(
				'item_code' => $this->input->post('item_code'),
				'item_name' => $this->input->post('item_name'),
				'quantity' => str_replace(',','.',$this->input->post('quantity')),	
				'id' => $this->input->post('hidden_id'),
				'uom_id' => $this->input->post('uom_id'));
		if($this->form_validation->run() == FALSE){
			$uoms = $this->uom_model->get_uom_dropdown();
			$data = array();
			$data['uoms'] = $uoms;
			$data['edit_mode'] = 'TRUE';
			$data['inventory'] = $inventory_update_data;
			$data['main_content'] = 'update_inventory_view';
			$this->load->view('includes/template', $data);
		}else{			
			if($this->inventory_model->update($this->input->post('hidden_id'),$inventory_update_data)){
				redirect(base_url()."inventory/index");
			}else{
				$uoms = $this->uom_model->get_uom_dropdown();
				$data['uoms'] = $uoms;
				$data['edit_mode'] = 'TRUE';
				$data['inventory'] = $inventory_update_data;
				$data['main_content'] = 'update_inventory_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}

}