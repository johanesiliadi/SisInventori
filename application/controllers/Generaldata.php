<?php

class Generaldata extends MY_Controller {
	
	private $dbhost = "localhost"; // usually localhost
	private $dbuser = "root";
	private $dbpass = "password";
	private $dbname = "sis_inventori";
	private $sendto = "johanes03@gmail.com";
	private $sendfrom = "Automated Backup <backup@yourdomain.com>";
	private $sendsubject = "Daily Mysql Backup for Sistem inventori";
	private $bodyofemail = "Here is the daily backup.";

	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$data['main_content'] = 'generaldata_list';
		$this->load->view('includes/template', $data);		
	}
	
	function housekeeping(){
		
		$data['main_content'] = 'generaldata_list';
		$this->load->view('includes/template', $data);		
	}
	
	function send_email($to,$subject,$message,$attachment)
	{	
	
		$config = Array(
		   'protocol' => "smtp",
		   'smtp_host' => "ssl://smtp.googlemail.com",
		   'smtp_port' => 465,
		   'smtp_user' => "sis.inventori@gmail.com",
		   'smtp_pass' => "sisinventori",
		 );
		 $this->load->library('email', $config);
		 $this->email->set_newline("\r\n");
		
		$this->email->from('sis.inventori@gmail.com', 'Sistem inventori');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->attach($attachment);
		$this->email->send();
		
	}  
}