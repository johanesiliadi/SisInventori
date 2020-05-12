<?php

class Invoice_model extends MY_Model {

	protected $table_name = "invoice";
	private $primary_key = "id";
	private $invoice_no = "invoice_no";
	private $client_id = "client_id";
	private $payment_id = "payment_id";
	private $status = "status";
	
	public function search_paged_list($limit=10, $offset=0, $order_column ='',$order_type='desc',$invoice_no,$date,$client_id,$status){
		
		$this->db->where('invoice.'.$this->status,'A');
		
		if(!empty($invoice_no)){
				$this->db->like('invoice.'.$this->invoice_no,$invoice_no);
		}
		
		if(!empty($status)){
			if(strcasecmp($status,"1") == 0){	
				$this->db->where($this->payment_id.' is NULL');
			}else if(strcasecmp($status,"2") == 0){
				$this->db->where($this->payment_id.' is not NULL');
			}
		}
		
		if(!empty($date)){
			$this->db->where('date(invoice.invoice_date)',$date);
		}
		
		if(!empty($client_id)){
			$this->db->where('invoice.'.$this->client_id,$client_id);
		}
				
		if(empty($order_column) || empty($order_type)){
			$this->db->order_by('invoice.'.$this->primary_key,'asc');
		}else{
			$this->db->order_by('invoice.'.$order_column,$order_type);
		}
		
		$this->db->select('invoice.*,client.name');
 
		$this->db->from($this->table_name.' invoice');
		$this->db->join('client client', 'client.id = invoice.client_id', 'inner');
		
		$this->db->limit($limit,$offset);
		return $this->db->get()->result_array();
	}
	
	public function count_search($invoice_no,$date,$client_id,$status){
	
		$this->db->where('invoice.'.$this->status,'A');
		if(!empty($invoice_no)){
				$this->db->like('invoice.'.$this->invoice_no,$invoice_no);
		}
		
		if(!empty($status)){
			if(strcasecmp($status,"1") == 0){	
				$this->db->where($this->payment_id.' is NULL');
			}else if(strcasecmp($status,"2") == 0){
				$this->db->where($this->payment_id.' is not NULL');
			}
		}
		
		if(!empty($date)){
			$this->db->where('date(invoice.invoice_date)',$date);
		}
		
		if(!empty($client_id)){
			$this->db->where('invoice.'.$this->client_id,$client_id);
		}
			
		
		$this->db->select('invoice.*,client.name');
		$this->db->join('client client', 'client.id = invoice.client_id', 'inner');
		return $this->db->count_all_results($this->table_name.' invoice');
	}
	
	public function get_invoice_by_number($number){
		
		$this->db->where($this->invoice_no,$number);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0) 
		{ 
		    return $query->row_array();  
		} 
		 
		return null;
	}
	
	public function get_by_number($number){
		
		$this->db->where($this->invoice_no,$number);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0) 
		{ 
		    return $query->row_array();  
		} 
		 
		return null;
	}
	
	public function get_by_client_unreceived($client_id){
		
		$this->db->where($this->status,'A');
		$this->db->where($this->client_id,$client_id);
		$this->db->where($this->payment_id.' is NULL');
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	public function get_by_client_unreceived_penerimaan($id_client,$id_payment){
		
		
		$this->db->where($this->status,'A');
		$this->db->where($this->client_id,$id_client);
		$this->db->where($this->payment_id.' is NULL');
		$this->db->or_where($this->payment_id, $id_payment); 
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	public function get_by_penerimaan_client($id_payment,$id_client){
	
		$this->db->where($this->status,'A');
		$this->db->where($this->payment_id,$id_payment);
		$this->db->where($this->client_id,$id_client);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	public function get_by_penerimaan($id_penerimaan){
	
		$this->db->where($this->status,'A');
		$this->db->where($this->id_penerimaan,$id_penerimaan);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	public function get_by_id($id){
		$this->db->select('invoice.*,client.name');
 
		$this->db->from($this->table_name.' invoice');
		$this->db->join('client client', 'client.id = invoice.client_id', 'inner');
		$this->db->where('invoice.'.$this->primary_key,$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{ 
		    return $query->row_array();  
		} 
		 
		return null;
	}
	
	public function delete_unused(){
		$this->db->where($this->status,'D');
		$this->db->delete($this->table_name);
	}
}