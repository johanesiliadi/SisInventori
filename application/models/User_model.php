<?php

class User_model extends MY_Model {

	 protected $table_name = "user";
	 private $primary_key = "id";
	 private $username = "username";
	 private $name = "name";
	 private $password = "password";

	public function validate()
	{
		$this->db->where($this->username, $this->input->post('username'));
		$this->db->where($this->password, md5($this->input->post('password')));
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() == 1)
		{
			return true;
		}
		
	}
	
	public function get_member_by_username($username){
		
		$this->db->where($this->username,$username);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0) 
		{ 
		    return $query->row_array();  
		} 
		 
		return null;
	}
	
	
	
	public function update_password($user_id,$new_password)
	{	
		$this->db->set($this->password,$new_password);
		$this->db->where($this->primary_key, $user_id);
		$update = $this->db->update($this->table_name);
		return $update;
	}
	 
	
	public function search_paged_list($limit=10, $offset=0, $order_column ='',$order_type='asc',$name, $username){
		if(!empty($name)){
				$this->db->like($this->name,$name);
		}
		if(!empty($username)){
			$this->db->where($this->username,$username);
		}
		
				
		if(empty($order_column) || empty($order_type)){
			$this->db->order_by($this->primary_key,'asc');
		}else{
			$this->db->order_by($order_column,$order_type);
		}
			
		return $this->db->get($this->table_name, $limit,$offset)->result_array();
	}
	
	public function count_all(){
		return $this->db->count_all($this->table_name);
	}
	
	public function count_search($name, $username){
			if(!empty($name)){
				$this->db->like($this->name,$name);
			}
			if(!empty($username)){
				$this->db->where($this->username,$username);
			}
		return $this->db->count_all_results($this->table_name);
	}
}