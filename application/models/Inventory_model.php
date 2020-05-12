<?php

class Inventory_model extends MY_Model {

	protected $table_name = "inventory";
	private $primary_key = "id";
	private $item_code = "item_code";
	private $item_name = "item_name";
	private $quantity = "quantity";
	private $uom_id = "uom_id";
	
	
	public function search_paged_list($limit=10, $offset=0, $order_column ='',$order_type='asc',$item_code,$item_name){
		if(!empty($item_name)){
				$this->db->like('inventory.'.$this->item_name,$item_name);
			}
			
		if(!empty($item_code)){
			$this->db->where('inventory.'.$this->item_code,$item_code);
		}
				
		
		if(empty($order_column) || empty($order_type)){
			$this->db->order_by('inventory.'.$this->primary_key,'asc');
		}else{
			$this->db->order_by('inventory.'.$order_column,$order_type);
		}
		
		$this->db->select('inventory.*,uom.short_name');
 
		$this->db->from($this->table_name.' inventory');
		$this->db->join('uom uom', 'uom.id = inventory.uom_id', 'inner');
		
		
		$this->db->limit($limit,$offset);
		return $this->db->get()->result_array();
	}
	
	public function count_search($item_code,$item_name){
		if(!empty($item_name)){
				$this->db->like('inventory.'.$this->item_name,$item_name);
			}
			
		if(!empty($item_code)){
			$this->db->where('inventory.'.$this->item_code,$item_code);
		}
				
		
		$this->db->select('inventory.*,uom.short_name');
		$this->db->join('uom uom', 'uom.id = inventory.uom_id', 'inner');
		return $this->db->count_all_results($this->table_name.' inventory');
	}
	
	public function get_code_by_reference($code){
		
		$this->db->where($this->item_code,$code);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0){ 
		    return $query->row_array();  
		} 
		 
		return null;
	}
	
	public function get_inventory_dropdown(){
		$inventorys = array();
		$query = $this->inventory_model->get_all();
		$inventorys[''] = '';
		foreach($query as $row){
			$inventorys[$row['id']] = $row['item_code'].' - '.$row['item_name'];
		}
			
		return $inventorys;
	}
}