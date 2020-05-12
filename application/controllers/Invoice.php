<?php

class Invoice extends MY_Controller {
	
	private $limit=10;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('invoice_model');
		$this->load->model('client_model');
		$this->load->model('uom_model');
		$this->load->model('inventory_model');
		$this->load->model('item_model');
		$this->load->model('uomratio_model');
	}
	public function index($offset=0,$order_column='id',$order_type='desc'){
		
		$invoices = $this->invoice_model->search_paged_list($this->limit,$offset,$order_column,$order_type,NULL,NULL,NULL,NULL);
		$clients = $this->client_model->get_client_dropdown();
	
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/invoice/index/');
		$config['total_rows'] = $this->invoice_model->count_search('','','','');
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
		$data['client_search'] = '';
		$data['number_search'] = '';
		$data['date_search'] = '';
		$data['status_search'] = '';
		$data['table'] = $this->table->generate();
		
		$data['invoices'] = $invoices;
		$data['clients'] = $clients;
		
		$data['main_content'] = 'invoice_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('client_search_invoice');
			$this->session->unset_userdata('number_search_invoice');
			$this->session->unset_userdata('date_search_invoice');
			$this->session->unset_userdata('status_search_invoice');
		}
		$client_search = $this->invoice_model->searchterm_handler("client_search_invoice",$this->input->post("client_search"));
		$number_search = $this->invoice_model->searchterm_handler("number_search_invoice",$this->input->post("number_search"));
		$date_search = $this->invoice_model->searchterm_handler("date_search_invoice",$this->input->post("date_search"));
		$status_search = $this->invoice_model->searchterm_handler("status_search_invoice",$this->input->post("status_search"));
		
		$invoices = $this->invoice_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$number_search,$date_search,$client_search,$status_search);
		$clients = $this->client_model->get_client_dropdown();
		
		$this->load->library('pagination');
		$config = array();
		$config['base_url'] = site_url('/invoice/index/');
		$config['total_rows'] = $this->invoice_model->count_search($number_search,$date_search,$client_search,$status_search);
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
		$data['client_search'] = $client_search;
		$data['number_search'] = $number_search;
		$data['date_search'] = $date_search;
		$data['status_search'] = $status_search;
		
		$data['invoices'] = $invoices;
		$data['clients'] = $clients;
		$data['main_content'] = 'invoice_list';
		$this->load->view('includes/template', $data);	

	}

	
	public function add_invoice()
	{	
		$clients = $this->client_model->get_client_dropdown();
		$uoms = $this->uom_model->get_uom_dropdown();
		$inventories = $this->inventory_model->get_inventory_dropdown();
		
		$data = array();
		$data['invoice'] = null;
		$data['clients'] = $clients;
		$data['inventories'] = $inventories;
		$data['uoms'] = $uoms;
		$data['main_content'] = 'add_invoice_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		$this->db->trans_start();
		$this->invoice_model->delete($id);
		$items = $this->item_model->get_by_invoice($id);
		foreach($items as $item){
			$this->item_model->delete($item['id']);
			$inventory = $this->inventory_model->get_by_id($item['inventory_id']);
			$uomratio = $this->uomratio_model->get_ratio_by_uom($item['uom_id'],$inventory['uom_id']);
			$inventory['quantity'] = $inventory['quantity'] + ($item['quantity'] * $uomratio);
			
			$this->inventory_model->update($inventory['id'],$inventory);
		}
		$this->db->trans_complete();
		$this->index($offset,$order_column,$order_type);
	}
	
	public function delete_item($id,$invoice_id){
		$item = $this->item_model->get_by_id($id);
		if(strcasecmp($item['status'],"D") == 0){
			$this->item_model->delete($id);
		}
		redirect(base_url()."invoice/update/".$invoice_id);
	}
	
	public function update($id){
	
		$clients = $this->client_model->get_client_dropdown();
		$uoms = $this->uom_model->get_uom_dropdown();
		$inventories = $this->inventory_model->get_inventory_dropdown();
		
		$data = array();
		$data['clients'] = $clients;
		$data['uoms'] = $uoms;
		$data['inventories'] = $inventories;
		$data['items'] = $this->item_model->search_by_invoice($id,array('D','A'));
		$data['total_item'] = $this->item_model->search_total_by_invoice($id,array('D','A'));
		$data['invoice'] = $this->invoice_model->get_by_id($id);
		$data['main_content'] = 'update_invoice_view';
		$this->load->view('includes/template', $data);
	}
	
	public function view($id){
	
		
		$clients = $this->client_model->get_client_dropdown();
		$uoms = $this->uom_model->get_uom_dropdown();
		$inventories = $this->inventory_model->get_inventory_dropdown();
		$data = array();
		$data['clients'] = $clients;
		$data['uoms'] = $uoms;
		$data['inventories'] = $inventories;
		$data['items'] = $this->item_model->search_by_invoice($id,array('A'));
		$data['total_item'] = $this->item_model->search_total_by_invoice($id,array('A'));
		$data['invoice'] = $this->invoice_model->get_by_id($id);
		$data['main_content'] = 'view_invoice_view';
		$this->load->view('includes/template', $data);
	}
	
	public function create_invoice()
	{
		// field name, error message, validation rules
		$this->form_validation->set_rules('invoice_no', 'Number', 'trim|required|callback_number_check');
		$this->form_validation->set_rules('id_client', 'Client', 'trim|required');
		$this->form_validation->set_rules('sales', 'Sales', 'trim');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('remarks', 'Remarks', 'required');	
		
		if($this->form_validation->run() == FALSE){		
			$this->add_invoice();
		}else{			
			$new_invoice_insert_data = array(
				'invoice_no' => $this->input->post('invoice_no'),
				'client_id' => $this->input->post('id_client'),
				'sales' => $this->input->post('sales'),			
				'invoice_date' => $this->input->post('date'),	
				'remarks' => $this->input->post('remarks'),	
				'status' => 'D',
				'update_by' => $this->session->userdata('id')			
			);
			
			if($id = $this->invoice_model->create($new_invoice_insert_data)){
				redirect(base_url()."invoice/update/".$id);
			}else{
				$this->add_invoice();
			}
		}
	
	}
	
	public function number_check($str)
	{
		$invoiceData = $this->invoice_model->get_invoice_by_number($str);
		if (count($invoiceData) > 0){
			$this->form_validation->set_message('number_check', 'Invoice number exists');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function edit_invoice()
	{
		if(isset($_POST['add_item'])){
			$this->form_validation->set_rules('id_inventory', 'Inventory', 'trim|required');
			$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|numeric');
			$this->form_validation->set_rules('id_uom', 'Uom', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required|decimal');
			$this->form_validation->set_rules('discount', 'Discount', 'trim|required|decimal');	
			$this->form_validation->set_rules('nett_price', 'Nett price', 'trim|required|decimal');	
			$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|numeric');	
			
			if($this->form_validation->run() == FALSE){		
				
				$clients = $this->client_model->get_client_dropdown();
				$uoms = $this->uom_model->get_uom_dropdown();
				$inventories = $this->inventory_model->get_inventory_dropdown();
		
				$data = array();
				$data['clients'] = $clients;
				$data['uoms'] = $uoms;
				$data['inventories'] = $inventories;
				$data['items'] = $this->item_model->search_by_invoice($this->input->post('hidden_id'),array('D','A'));
				$data['total_item'] = $this->item_model->search_total_by_invoice($this->input->post('hidden_id'),array('D','A'));
				$data['invoice'] = $this->invoice_model->get_by_id($this->input->post('hidden_id'));
				$data['main_content'] = 'update_invoice_view';
				$this->load->view('includes/template', $data);
			}else{			
				$new_item_insert_data = array(
					'inventory_id' => $this->input->post('id_inventory'),
					'quantity' => str_replace(',','.',$this->input->post('quantity')),
					'uom_id' => $this->input->post('id_uom'),			
					'price' => str_replace(',','.',$this->input->post('price')),
					'discount' => str_replace(',','.',$this->input->post('discount')),	
					'nett_price' => str_replace(',','.',$this->input->post('nett_price')),
					'total' => str_replace(',','.',$this->input->post('total')),	
					'status' => 'D',
					'invoice_id' => $this->input->post('hidden_id')		
				);
				
				if($this->item_model->create($new_item_insert_data))
				{
					redirect(base_url()."invoice/update/".$this->input->post('hidden_id'));
				}
				else
				{	redirect(base_url()."invoice/update/".$this->input->post('hidden_id'));
				}
			}
		}elseif(isset($_POST['ok'])){
			$this->form_validation->set_rules('id_client', 'Client', 'trim|required');
			$this->form_validation->set_rules('sales', 'Sales', 'trim');
			$this->form_validation->set_rules('date', 'Date', 'trim|required');
			$this->form_validation->set_rules('remarks', 'Remarks', 'required');	
			$this->form_validation->set_rules('delivery_fee', 'Delivery Fee', 'trim|required|decimal');	
			$this->form_validation->set_rules('discount_invoice', 'Discount', 'trim|required|decimal');	
			$this->form_validation->set_rules('total_invoice', 'Total', 'trim|required|decimal');	
		
			$invoice_update_data = array(
					'invoice_no' => $this->input->post('invoice_no'),
					'client_id' => $this->input->post('id_client'),
					'sales' => $this->input->post('sales'),			
					'invoice_date' => $this->input->post('date'),	
					'remarks' => $this->input->post('remarks'),	
					'delivery_fee' => str_replace(',','.',$this->input->post('delivery_fee')),
					'discount' => str_replace(',','.',$this->input->post('discount_invoice')),
					'total' => str_replace(',','.',$this->input->post('total_invoice')),
					'status' => 'A',
					'id' => $this->input->post('hidden_id'),
					'update_by' => $this->session->userdata('id')			
				);
			if($this->form_validation->run() == FALSE){		
				
				$clients = $this->client_model->get_client_dropdown();
				$uoms = $this->uom_model->get_uom_dropdown();
				$inventories = $this->inventory_model->get_inventory_dropdown();
		
				$data['clients'] = $clients;
				$data['uoms'] = $uoms;
				$data['inventories'] = $inventories;
				$data['items'] = $this->item_model->search_by_invoice($this->input->post('hidden_id'),array('D','A'));
				$data['total_item'] = $this->item_model->search_total_by_invoice($this->input->post('hidden_id'),array('D','A'));
				$data['invoice'] = $invoice_update_data;
				$data['main_content'] = 'update_invoice_view';
				$this->load->view('includes/template', $data);
			}else{			
				$this->db->trans_start();
				$this->invoice_model->update($this->input->post('hidden_id'),$invoice_update_data);
				$items = $this->item_model->get_by_invoice($this->input->post('hidden_id'));
				foreach($items as $item){
					$item['status'] = 'A';	
					$this->item_model->update($item['id'],$item);
					
					$inventory = $this->inventory_model->get_by_id($item['id_inventory']);
					$uomratio = $this->uomratio_model->get_ratio_by_uom($item['id_uom'],$inventory['id_uom']);
					$inventory['quantity'] = $inventory['quantity'] - ($item['quantity'] * $uomratio);
					
					$this->inventory_model->update($inventory['id'],$inventory);
				}
				
				$this->db->trans_complete();
				
				if($this->db->trans_status() === FALSE){
					redirect(base_url()."invoice/update/".$this->input->post('hidden_id'));
				}else{
					redirect(base_url()."invoice/index");
				}
			}
		}
	}
}