<?php

class Client_model extends MY_Model {

	protected $table_name = "client";
	private $primary_key = "id";
	private $name = "name";
	private $code = "code";
	private $address = "address";
	private $phone = "phone";
	private $information = "information";
	
	
	public function search_paged_list($limit=10, $offset=0, $order_column ='',$order_type='asc',$name){
		if(!empty($name)){
				$this->db->like($this->name,$name);
				$this->db->or_like($this->code,$name);
			}
				
		if(empty($order_column) || empty($order_type)){
			$this->db->order_by($this->primary_key,'asc');
		}else{
			$this->db->order_by($order_column,$order_type);
		}
			
		return $this->db->get($this->table_name, $limit,$offset)->result_array();
	}
	
	public function count_search($name){
			if(!empty($name)){
				$this->db->like($this->name,$name);
				$this->db->or_like($this->code,$name);
			}
			
		return $this->db->count_all_results($this->table_name);
	}
	
	public function get_client_dropdown(){
		$clients = array();
		$query = $this->client_model->get_all();
		$clients[''] = '';
		foreach($query as $row){
			$clients[$row['id']] = $row['code'].' - '.$row['name'];
		}
		
		return $clients;
	}
}