<?php

class Inventorymutation extends MY_Controller {
	
	private $limit=10;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('inventorymutation_model');
		$this->load->model('inventory_model');
		$this->load->model('uom_model');
		$this->load->model('user_model');
		$this->load->model('uomratio_model');
	}
	public function index($offset=0,$order_column='id',$order_type='desc'){
		
		$inventorymutations = $this->inventorymutation_model->search_paged_list($this->limit,$offset,$order_column,$order_type,NULL,NULL);
		$inventories = $this->inventory_model->get_inventory_dropdown();
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/inventorymutation/index/');
		$config['total_rows'] = $this->inventorymutation_model->count_search('','');
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
		$data['date_search'] = '';
		$data['inventory_search'] = '';
		$data['table'] = $this->table->generate();
		
		$data['inventorymutations'] = $inventorymutations;
		$data['inventories'] = $inventories;
		$data['main_content'] = 'inventorymutation_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('date_search_mutation');
			$this->session->unset_userdata('inventory_search_mutation');
		}
		$date_search = $this->inventorymutation_model->searchterm_handler("date_search_mutation",$this->input->post("date_search"));
		$inventory_search = $this->inventorymutation_model->searchterm_handler("inventory_search_mutation",$this->input->post("inventory_search"));
		
		$inventorymutations = $this->inventorymutation_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$date_search,$inventory_search);
		$inventories = $this->inventory_model->get_inventory_dropdown();
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/inventorymutation/index/');
		$config['total_rows'] = $this->inventorymutation_model->count_search($date_search,$inventory_search);
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
		$data['date_search'] = $date_search;
		$data['inventory_search'] = $inventory_search;
		$data['inventorymutations'] = $inventorymutations;
		$data['inventories'] = $inventories;
		$data['main_content'] = 'inventorymutation_list';
		$this->load->view('includes/template', $data);	

	}

	
	public function add_inventorymutation()
	{	
		$inventories = $this->inventory_model->get_inventory_dropdown();
		
		$uoms = $this->uom_model->get_uom_dropdown();
		$data = array();
		$data['inventories'] = $inventories;
		$data['uoms'] = $uoms;
		$data['main_content'] = 'add_inventorymutation_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		
		$inventorymutation = $this->inventorymutation_model->get_by_id($id);
		
		$inventory = $this->inventory_model->get_by_id($inventorymutation['inventory_id']);
		$uomratio = $this->uomratio_model->get_ratio_by_uom($inventorymutation['uom_id'],$inventory['uom_id']);
			
			if($inventorymutation['type'] == 1){
				$inventory['quantity'] = $inventory['quantity'] + ($inventorymutation['quantity'] * $uomratio);
			}else{
				$inventory['quantity'] = $inventory['quantity'] - ($inventorymutation['quantity'] * $uomratio);
			}
			$this->db->trans_start();
			$this->inventory_model->update($inventory['id'],$inventory);
			$this->inventorymutation_model->delete($id);
			$this->db->trans_complete();
		
		
		$this->index($offset,$order_column,$order_type);
	}
	
	
	
	public function create_inventorymutation(){
		// field name, error message, validation rules
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|numeric');
		$this->form_validation->set_rules('uom_id', 'uom', 'trim|required');
		$this->form_validation->set_rules('inventory_id', 'Inventory', 'trim|required');
		$this->form_validation->set_rules('type', 'Mutation type', 'trim');
		$this->form_validation->set_rules('remarks', 'Remarks', 'trim');	
		
		if($this->form_validation->run() == FALSE){
		
				$this->add_inventorymutation();
		}else{			
			$new_inventorymutation_insert_data = array(
				'quantity' => str_replace(',','.',$this->input->post('quantity')),
				'uom_id' => $this->input->post('uom_id'),
				'inventory_id' => $this->input->post('inventory_id'),			
				'type' => $this->input->post('type'),
				'remarks' => $this->input->post('remarks'),
				'update_by' => $this->session->userdata('id')	,				
			);
			
			$inventory = $this->inventory_model->get_by_id($new_inventorymutation_insert_data['inventory_id']);
			$uomratio = $this->uomratio_model->get_ratio_by_uom($new_inventorymutation_insert_data['uom_id'],$inventory['uom_id']);
			
			if($new_inventorymutation_insert_data['type'] == 0){
				$inventory['quantity'] = $inventory['quantity'] + ($new_inventorymutation_insert_data['quantity'] * $uomratio);
			}else{
				$inventory['quantity'] = $inventory['quantity'] - ($new_inventorymutation_insert_data['quantity'] * $uomratio);
			}
			$this->db->trans_start();
			$this->inventory_model->update($inventory['id'],$inventory);
			$this->inventorymutation_model->create($new_inventorymutation_insert_data);
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE)
			{
				$this->add_inventorymutation();
			}
			else
			{	
				redirect(base_url()."inventorymutation/index");
			}
		}
		
	}

}