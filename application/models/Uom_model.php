<?php

class Uom_model extends MY_Model {

	protected $table_name = "uom";
	private $primary_key = "id";
	private $long_name = "long_name";
	private $short_name = "short_name";
	
	
	public function search_paged_list($limit=10, $offset=0, $order_column ='',$order_type='asc',$name){
		if(!empty($name)){
				$this->db->like($this->long_name,$name);
				$this->db->or_like($this->short_name,$name);
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
				$this->db->like($this->long_name,$name);
				$this->db->or_like($this->short_name,$name);
			}
			
		return $this->db->count_all_results($this->table_name);
	}
	
	public function get_uom_dropdown(){
		$uom = array();
		$query = $this->get_all();
		$uom[''] = '';
		foreach($query as $row){
			$uom[$row['id']] = $row['short_name'];
		}
			
		return $uom;
	}
}