<?php

class Utilities_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_table($table_name){
        return $this->db->get($table_name);
    }
    
    function get_bank(){
        return $this->db->get('bank');
    }
    
    function validate_table_id($table_name,$id){
        $this->db->where($table_name.'_id',$id);
        $result = $this->db->get($table_name);
        return ($result->num_rows()>0)?true:false;
    }
    
    //table source_info
    function get_source_info(){
        $this->db->order_by('source_info_sort','asc');
        return $this->db->get('source_info');
    }

    function add_panduan_guru($nama,$keterangan,$file) {
        $this->db->query("INSERT INTO dokumen_panduan_guru (nama_dokumen,keterangan,url) VALUES ('$nama','$keterangan','$file')");
    }

    function get_panduan_guru(){
        $query = $this->db->query("SELECT * FROM dokumen_panduan_guru ORDER BY date_created DESC");
        return $query->result_array();
    }

    function hapus_dokumen_panduan($id){
        $this->db->query("DELETE FROM dokumen_panduan_guru WHERE id=$id");
    }
	
	function general_journey_log() {
		$id = $this->CI->session->userdata('session_id');
		$time = microtime(TRUE)*1000;
		$from = !empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
		$to = base_url().$this->CI->uri->uri_string();
		$parameter = json_encode(array(
			'post'		=> $_POST,
			'get'		=> $_GET,
			'session'	=> $this->CI->session->all_userdata()
		));
		@$this->db->insert('log_journey', array(
			'id'		=> $id,
			'time'		=> $time,
			'from'		=> $from,
			'to'		=> $to,
			'parameter'	=> $parameter,
		));
	}

}
