<?php

class Item_model extends MY_Model {

	protected $table_name = "item";
	private $primary_key = "id";
	private $invoice_id = "invoice_id";
	private $status = "status";
	
	
	public function search_by_invoice($invoice_id,$array_status){
		
		
		$this->db->where_in('item.'.$this->status,$array_status);
		$this->db->where('item.'.$this->invoice_id,$invoice_id);
		$this->db->select('item.*,invent.item_name,uom.short_name');
 
		$this->db->from($this->table_name.' item');
		$this->db->join('inventory invent', 'invent.id = item.inventory_id', 'inner');
		$this->db->join('uom uom', 'uom.id = item.uom_id', 'inner');
		return $this->db->get()->result_array();
	}
	
	public function search_total_by_invoice($invoice_id,$array_status){
		
		$this->db->where_in('item.'.$this->status,$array_status);
		$this->db->where('item.'.$this->invoice_id,$invoice_id);
		$this->db->select('sum(item.total) as total_item');
 
		$this->db->from($this->table_name.' item');
		$this->db->join('inventory invent', 'invent.id = item.inventory_id', 'inner');
		$this->db->join('uom uom', 'uom.id = item.uom_id', 'inner');
		return $this->db->get()->row_array();
	}
	
	public function get_by_invoice($invoice_id){
		
		$this->db->where($this->invoice_id,$invoice_id);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	public function delete_unused(){
		$this->db->where($this->status,'D');
		$this->db->delete($this->table_name);
	}
	
}