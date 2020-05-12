<?php

class Inventorymutation_model extends MY_Model {

	protected $table_name = "inventory_mutation";
	private $primary_key = "id";
	private $quantity = "quantity";
	
	
	public function search_paged_list($limit=10, $offset=0, $order_column ='',$order_type='desc',$date,$id_inventori){
			
		if(!empty($id_inventori)){
			$this->db->where('inventory_mutation.inventory_id',$id_inventori);
		}
		if(!empty($date)){
			$this->db->where('date(inventory_mutation.update_time)',$date);
		}
				
		if(empty($order_column) || empty($order_type)){
			$this->db->order_by('inventory_mutation.'.$this->primary_key,'desc');
		}else{
			$this->db->order_by('inventory_mutation.'.$order_column,$order_type);
		}
		$this->db->select('inventory_mutation.*,invent.item_name, user.name,uom.short_name');
 
		$this->db->from($this->table_name.' inventory_mutation');
		$this->db->join('inventory invent', 'invent.id = inventory_mutation.inventory_id', 'inner');
		$this->db->join('uom uom', 'uom.id = inventory_mutation.uom_id', 'inner');
		$this->db->join('user user', 'user.id = inventory_mutation.update_by','inner');
		$this->db->limit($limit,$offset);
		return $this->db->get()->result_array();
	}
	
	public function count_search($date,$id_inventori){
			if(!empty($id_inventori)){
			$this->db->where('inventory_mutation.inventory_id',$id_inventori);
		}
		if(!empty($date)){
			$this->db->where('date(inventory_mutation.update_time)',$date);
		}
				
		$this->db->select('inventory_mutation.*,invent.item_name, user.name, uom.short_name');
 
		$this->db->join('inventory invent', 'invent.id = inventory_mutation.inventory_id', 'inner');
		$this->db->join('uom uom', 'uom.id = inventory_mutation.uom_id', 'inner');
		$this->db->join('user user', 'user.id = inventory_mutation.update_by','inner');
		return $this->db->count_all_results($this->table_name.' inventory_mutation');
	}
	
}