<?php

class Csmodel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function check_email($email){
        $this->db->where('email',$email);
        return ($this->db->get('cs_email')->num_rows()>0)?true:false;
    }
    
    function insert($email){
        $this->db->set('email',$email);
        $this->db->set('status',1,FALSE);
        $this->db->insert('cs_email');
        $this->email($email);
    }
    
    function email($to){
        $this->load->library('email');
	$config['useragent'] = 'Ruangguru Web Service';
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'mail.ruangguru.com';
	$config['smtp_port'] = 25;
	$config['smtp_user'] = 'no-reply@ruangguru.com';
	$config['smtp_pass'] = 'rg1ndones1a';
	$config['priority'] = 1;
	$config['mailtype'] = 'html';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE; 
	$this->email->initialize($config);
	$this->email->from('no-reply@ruangguru.com', 'Ruangguru.com');
	$this->email->to($to);

	$this->email->subject('Coming Soon Ruang Guru');
        $content = $this->load->view('comingsoon/email','',TRUE);
	$this->email->message($content);

	$this->email->send();
    }
}