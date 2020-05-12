<?php

class MY_Model extends CI_Model { 
 
	protected $table_name = "";
	private $primary_key = "id";
	

	public function get_by_id($id){
		
		$this->db->where($this->primary_key,$id);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0){ 
		    return $query->row_array();  
		} 
		 
		return null;
	}
	
	public function create($array_insert){
		$insert = $this->db->insert($this->table_name, $array_insert);
		if($insert)
			return $this->db->insert_id();
		else
			return NULL;
	}
	
	public function update($id,$array_update){
		$this->db->where($this->primary_key, $id);
		$update = $this->db->update($this->table_name, $array_update);
		return $update;
	}
	
	
	public function delete($id){
		$this->db->where($this->primary_key,$id);
		$this->db->delete($this->table_name);
		
	}
	
	public function get_all(){
		
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	
	 public function searchterm_handler($sessionterm,$searchterm){ 
	    if($searchterm){
	        $this->session->set_userdata($sessionterm, $searchterm);
	       return $searchterm;    
		} elseif($this->session->userdata($sessionterm)){
	        $searchterm = $this->session->userdata($sessionterm);
	        return $searchterm;    
		} else {
			$searchterm =""; 
	       return $searchterm; 
	   }
	 }

	
	public function get_paged_list($limit=10, $offset=0, $order_column ='',$order_type='desc'){
		if(empty($order_column) || empty($order_type))
			$this->db->order_by($this->primary_key,'asc');
		else
			$this->db->order_by($order_column,$order_type);
			
		return $this->db->get($this->table_name, $limit,$offset)->result_array();
	}
	
	
	public function count_all(){
		return $this->db->count_all($this->table_name);
	}
	
} 
