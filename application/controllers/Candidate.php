<?php

class Candidate extends MY_Controller {
	
	private $limit=1;
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('table','form_validation'));
		$this->load->model('candidate_model');
		$this->load->model('country_model');
		$this->load->model('file_upload_model');
	}
	public function index($offset=0,$order_column='id',$order_type='asc'){
		
		$candidates = $this->candidate_model->get_paged_list($this->limit,$offset,$order_column,$order_type)->result();
		
		$new_order = ($order_type=='asc'?'desc':'asc');
		
		$this->load->library('pagination');
		$config['base_url'] = site_url('/candidate/index/');
		$config['total_rows'] = $this->candidate_model->count_all();
		$config['per_page'] = $this->limit;
		$config['url_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		
		$data['order_column'] = $order_column;
		$data['order_type'] = $order_type;
		$data['offset'] = $offset;
		$data['new_order'] = $new_order;
		$data['name_search'] = '';
		$data['candidates'] = $candidates;
		$data['main_content'] = 'candidate_list';
		$this->load->view('includes/template', $data);	

	}
	
	
	public function search($offset=0,$order_column='id',$order_type='asc'){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->session->unset_userdata('name_search');
		}
		$name_search = $this->candidate_model->searchterm_handler("name_search",$this->input->post("name_search"));

		$new_order = ($order_type=='asc'?'desc':'asc');
		$candidates = $this->candidate_model->search_paged_list($this->limit,$offset,$order_column,$order_type,$name_search)->result();
		$this->load->library('pagination');
		$config['base_url'] = site_url('/candidate/search/');
		$config['total_rows'] = $this->candidate_model->count_search($name_search);
		$config['per_page'] = $this->limit;
		$config['url_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		
		
		$data['order_column'] = $order_column;
		$data['order_type'] = $order_type;
		$data['offset'] = $offset;
		$data['new_order'] = $new_order;
		$data['name_search'] = $name_search;
		$data['table'] = $this->table->generate();
		$data['candidates'] = $candidates;
		$data['main_content'] = 'candidate_list';
		$this->load->view('includes/template', $data);	

	}
	
	public function add_candidate()
	{	
		$countries = array();
		$query = $this->country_model->get_all();
		$countries[''] = '-Please select-';
		foreach($query->result() as $row){
			$countries[$row->id] = $row->name;
		}
		$data['countries'] = $countries;
		$data['upload_error'] = array();
		$data['main_content'] = 'add_candidate_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete($id,$offset=0,$order_column='id',$order_type='asc'){
		$query = $this->file_upload_model->get_by_candidate_id($id);
		foreach($query->result() as $row){
			unlink($row->link_file);
		}
		$this->candidate_model->delete($id);
		$this->index($offset,$order_column,$order_type);
	}
	
	public function update($id){
		$countries = array();
		$query = $this->country_model->get_all();
		$countries[''] = '-Please select-';
		foreach($query->result() as $row){
			$countries[$row->id] = $row->name;
		}
		$query_upload = $this->file_upload_model->get_by_candidate_id($id);
		
		$photo = NULL;
		$cv = NULL;
		foreach($query_upload->result() as $row){
			if($row->file_type == 1){
				$cv = $row;
			}else{
				$photo = $row;
			}
		}
		$data['countries'] = $countries;
		$data['edit_mode'] = 'FALSE';
		$data['upload_error'] = array();
		$data['photo'] = $photo;
		$data['cv'] = $cv;
		$data['candidate'] = $this->candidate_model->get_by_id($id);
		$data['main_content'] = 'update_candidate_view';
		$this->load->view('includes/template', $data);
	}
	
	public function delete_attachment($id_candidate, $id, $link_file){
		$countries = array();
		$query = $this->country_model->get_all();
		$countries[''] = '-Please select-';
		foreach($query->result() as $row){
			$countries[$row->id] = $row->name;
		}
		$this->file_upload_model->delete($id);
		
		unlink($link_file);
		
		$query_upload = $this->file_upload_model->get_by_candidate_id($id_candidate);
		$photo = NULL;
		$cv = NULL;
		foreach($query_upload->result() as $row){
			if($row->file_type == 1){
				$cv = $row;
			}else{
				$photo = $row;
			}
		}
		$data['countries'] = $countries;
		$data['edit_mode'] = 'TRUE';
		$data['upload_error'] = array();
		$data['photo'] = $photo;
		$data['cv'] = $cv;
		$data['candidate'] = $this->candidate_model->get_by_id($id_candidate);
		$data['main_content'] = 'update_candidate_view';
		$this->load->view('includes/template', $data);
	}
	
	
	public function create_candidate()
	{
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('ic_number', 'IC Number', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('experience', 'Experience', 'trim|required');
		$this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
		
		
		if($this->form_validation->run() == FALSE)
		{
				$countries = array();
				$query = $this->country_model->get_all();
				$countries[''] = '-Please select-';
				foreach($query->result() as $row){
					$countries[$row->id] = $row->name;
				}
				
				$data['upload_error'] = array();
				$data['countries'] = $countries;
				$data['main_content'] = 'add_candidate_view';
				$this->load->view('includes/template', $data);
		}else{	
			$this->db->trans_begin();
 		
			$new_candidate_insert_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),			
				'ic_number' => $this->input->post('ic_number'),
				'address' => $this->input->post('address'),
				'country' => $this->input->post('country'),
				'phone_number' => $this->input->post('phone_number'),
				'mobile_number' => $this->input->post('mobile_number'),
				'date_of_birth' => $this->input->post('date_of_birth'),
				'gender' => $this->input->post('gender'),
				'status' => $this->input->post('status'),
				'experience' => $this->input->post('experience'),
				'qualification' => $this->input->post('qualification'),
				'additional_info' => $this->input->post('additional_info'),
			);
			
			if($id = $this->candidate_model->create($new_candidate_insert_data))
			{
					$error_array = array();
					if (!empty($_FILES['resume']['name'])){
					$config['upload_path'] = './upload/cv';
					$config['allowed_types'] = 'doc|pdf|docx';
					$config['file_name'] = 'resume'.$id;
					$config['overwrite'] = true;
					$config['max_size']	= '2000';
			
					$this->load->library('upload', $config);
					$this->upload->initialize($config); 
					if ( ! $this->upload->do_upload("resume"))
					{
						$error = array('error' => $this->upload->display_errors());
						foreach($error as $test){
							$error_array[] = $test;
						}
						$this->db->trans_rollback();
						$countries = array();
						$query = $this->country_model->get_all();
						$countries[''] = '-Please select-';
						foreach($query->result() as $row){
							$countries[$row->id] = $row->name;
						}
						$data['countries'] = $countries;
						$data['upload_error'] = $error_array;
						$data['main_content'] = 'add_candidate_view';
						$this->load->view('includes/template', $data);		
 
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());
						$new_file_insert_data1 = array(
						'file_name' => $data['upload_data']['file_name'],
						'link_file' => './upload/cv/'.$data['upload_data']['file_name'],
						'id_candidate' => $id,			
						'file_type' => 1,
						);
						$this->file_upload_model->create($new_file_insert_data1);
					
			
					}
				}
				
				if (!empty($_FILES['photo']['name'])){
					$config['upload_path'] = './upload/photo';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['file_name'] = 'photo'.$id;
					$config['overwrite'] = true;
					$config['max_size']	= '2000';
			
					$this->load->library('upload', $config);
					$this->upload->initialize($config); 
			
					if ( ! $this->upload->do_upload("photo"))
					{
						$error = array('error' => $this->upload->display_errors());
						foreach($error as $test){
							$error_array[] = $test;
						}
						$this->db->trans_rollback();
 
	 				$countries = array();
					$query = $this->country_model->get_all();
					$countries[''] = '-Please select-';
					foreach($query->result() as $row){
						$countries[$row->id] = $row->name;
					}
					$data['countries'] = $countries;
					$data['upload_error'] = $error_array;
					$data['main_content'] = 'add_candidate_view';
					$this->load->view('includes/template', $data);		
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());
						$new_file_insert_data2 = array(
						'file_name' => $data['upload_data']['file_name'],
						'link_file' =>  './upload/photo/'.$data['upload_data']['file_name'],
						'id_candidate' => $id,			
						'file_type' => 2,
						);
						$this->file_upload_model->create($new_file_insert_data2);
					}
				}
				
				if ($this->db->trans_status() === FALSE)
				 {
				     $this->db->trans_rollback();
				 }
				 else
				 {
				     $this->db->trans_commit();
				 }

				$this->index();
			}
			else
			{
				$countries = array();
				$query = $this->country_model->get_all();
				$countries[''] = '-Please select-';
				foreach($query->result() as $row){
					$countries[$row->id] = $row->name;
				}
				$data['upload_error'] = array();
				$data['countries'] = $countries;
				$data['main_content'] = 'add_candidate_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	
		
	}
	
	
	
	public function edit_candidate()
	{
	
		$candidate_id =  $this->input->post('hidden_id');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('ic_number', 'IC Number', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('experience', 'Experience', 'trim|required');
		$this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
		
		$candidate_update_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),			
				'ic_number' => $this->input->post('ic_number'),
				'address' => $this->input->post('address'),
				'country' => $this->input->post('country'),
				'phone_number' => $this->input->post('phone_number'),
				'mobile_number' => $this->input->post('mobile_number'),
				'date_of_birth' => $this->input->post('date_of_birth'),
				'gender' => $this->input->post('gender'),
				'status' => $this->input->post('status'),
				'experience' => $this->input->post('experience'),
				'qualification' => $this->input->post('qualification'),
				'additional_info' => $this->input->post('additional_info'),
				'id' => $candidate_id			
			);
			
		if($this->form_validation->run() == FALSE)
		{
				$countries = array();
				$query = $this->country_model->get_all();
				$countries[''] = '-Please select-';
				foreach($query->result() as $row){
					$countries[$row->id] = $row->name;
				}
				
				$query_upload = $this->file_upload_model->get_by_candidate_id($candidate_id);
		
				$photo = NULL;
				$cv = NULL;
				foreach($query_upload->result() as $row){
					if($row->file_type == 1){
						$cv = $row;
					}else{
						$photo = $row;
					}
				}
				$data['upload_error'] = array();
				$data['photo'] = $photo;
				$data['cv'] = $cv;		
				$data['upload_error'] = array();
				$data['countries'] = $countries;
				$data['edit_mode'] = 'TRUE';
				$data['candidate'] = $candidate_update_data;
				$data['main_content'] = 'update_candidate_view';
				$this->load->view('includes/template', $data);
		}
		
		else
		{			
			
			if($query = $this->candidate_model->update($candidate_id,$candidate_update_data))
			{
				$error_array = array();
					if (!empty($_FILES['resume']['name'])){
					$config['upload_path'] = './upload/cv';
					$config['allowed_types'] = 'doc|pdf|docx';
					$config['file_name'] = 'resume'.$candidate_id;
					$config['overwrite'] = true;
					$config['max_size']	= '2000';
			
					$this->load->library('upload', $config);
					$this->upload->initialize($config); 
					if ( ! $this->upload->do_upload("resume"))
					{
						$errors = array('error' => $this->upload->display_errors());
						foreach($errors as $error){
							$error_array[] = $error;
						}
						$this->db->trans_rollback();
						$countries = array();
						$query = $this->country_model->get_all();
						$countries[''] = '-Please select-';
						foreach($query->result() as $row){
							$countries[$row->id] = $row->name;
						}
						$data['countries'] = $countries;
						$data['upload_error'] = $error_array;
						$data['main_content'] = 'add_candidate_view';
						$this->load->view('includes/template', $data);		
 
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());
						$new_file_insert_data1 = array(
						'file_name' => $data['upload_data']['file_name'],
						'link_file' => './upload/cv/'.$data['upload_data']['file_name'],
						'id_candidate' => $candidate_id,
						'file_type' => 1,
						);
						$this->file_upload_model->create($new_file_insert_data1);
					
			
					}
				}
				
				if (!empty($_FILES['photo']['name'])){
					$config['upload_path'] = './upload/photo';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['file_name'] = 'photo'.$candidate_id;
					$config['overwrite'] = true;
					$config['max_size']	= '2000';
			
					$this->load->library('upload', $config);
					$this->upload->initialize($config); 
			
					if ( ! $this->upload->do_upload("photo"))
					{
						$errors = array('error' => $this->upload->display_errors());
						foreach($errors as $error){
							$error_array[] = $error;
						}
						$this->db->trans_rollback();
 
	 				$countries = array();
					$query = $this->country_model->get_all();
					$countries[''] = '-Please select-';
					foreach($query->result() as $row){
						$countries[$row->id] = $row->name;
					}
					$data['countries'] = $countries;
					$data['upload_error'] = $error_array;
					$data['main_content'] = 'add_candidate_view';
					$this->load->view('includes/template', $data);		
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());
						$new_file_insert_data2 = array(
						'file_name' => $data['upload_data']['file_name'],
						'link_file' =>  './upload/photo/'.$data['upload_data']['file_name'],
						'id_candidate' => $candidate_id,			
						'file_type' => 2,
						);
						$this->file_upload_model->create($new_file_insert_data2);
					}
				}
				
				if ($this->db->trans_status() === FALSE)
				 {
				     $this->db->trans_rollback();
				 }
				 else
				 {
				     $this->db->trans_commit();
				 }
				$this->index();
			}
			else
			{	
				
				$countries = array();
				$query = $this->country_model->get_all();
				$countries[''] = '-Please select-';
				foreach($query->result() as $row){
					$countries[$row->id] = $row->name;
				}
				
				$data['upload_error'] = array();
				$data['countries'] = $countries;
				$data['edit_mode'] = 'TRUE';
				$data['candidate'] = $member_update_data;
				$data['main_content'] = 'update_candidate_view';
				$this->load->view('includes/template', $data);			
			}
		}
		
	}
	
}