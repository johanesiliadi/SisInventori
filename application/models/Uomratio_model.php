<?php

class Uomratio_model extends MY_Model {

	protected $table_name = "uom_ratio";
	private $primary_key = "id";
	private $uom_id1 = "uom_id1";
	private $uom_id2 = "uom_id2";
	private $name = "name";
	private $ratio1 = "ratio1";
	private $ratio2 = "ratio2";
	
	
	public function search_paged_list($limit=10, $offset=0, $order_column ='',$order_type='asc',$name){
		if(!empty($name)){
				$this->db->like($this->name,$name);
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
			}
			
		return $this->db->count_all_results($this->table_name);
	}
	
	public function get_name_by_reference($name){
		
		$this->db->like($this->name,$name);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0){ 
		    return $query->row_array();  
		} 
		 
		return null;
	}
	
	public function get_ratio_by_uom($uom_id1,$uom_id2){
		
		$this->db->where($this->uom_id1,$uom_id1);
		$this->db->where($this->uom_id2,$uom_id2);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0){ 
		    $ratio = $query->row();  
			if($ratio->ratio1 == 0){
				return 1;
			}else{
				return $ratio->ratio2/$ratio->ratio1;
			}
		}else{
			$this->db->where($this->uom_id1,$uom_id2);
			$this->db->where($this->uom_id2,$uom_id1);
			$query = $this->db->get($this->table_name);
			if ($query->num_rows() > 0){ 
		   		$ratio = $query->row();  
		   		if($ratio->ratio2 == 0){
					return 1;
				}else{
					return $ratio->ratio1/$ratio->ratio2;
				} 
			}else{
				return 1;
			}
		}
		 
		return 1;
	}
}