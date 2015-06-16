<?php

class Search_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    function get_kota_all(){
	   $this->db->order_by('lokasi_title','asc');
        return $this->db->get('lokasi');
    }
    
    function get_provinsi_all(){
	   $this->db->order_by('provinsi_title','asc');
        return $this->db->get('provinsi');
    }
    
	function get_provinsi_by_title($word=null){
	   $this->db->like('provinsi_title', $word);
       $result = $this->db->get('provinsi')->first_row();
	   if(!empty ($result)){
			return $result->provinsi_id;
	   }else{
			return 0;
	   }
    }
	
    function get_kota_by_title($word=null){
	   $this->db->like('lokasi_title', $word);
       $result = $this->db->get('lokasi')->first_row();
	    if(!empty($result)){
			return $result->lokasi_id;
		}else{
			return 0;
		}
    }
	
	function get_kategori_by_title($word=null){
	   $this->db->like('jenjang_pendidikan_title', $word);
       $result = $this->db->get('jenjang_pendidikan')->first_row();
	    if(!empty($result)){
			return $result->jenjang_pendidikan_id;
		}else{
			return 0;
		}
    }
	
	function get_matpel_by_title($word=null){
	   $this->db->like('matpel_title', $word);
	   if(strpos($word, 'bahasa') !== false){
		 $this->db->order_by('jenjang_pendidikan_id', 'desc');
	   }
       $result = $this->db->get('matpel')->first_row();
	   if(!empty($result)){
			return $result->matpel_id;
	   }else{
			return 0;
	   }
    }
	
	function get_provinsi_by_lokasi($id){
	   $this->db->where('lokasi_id', $id);
       $result = $this->db->get('lokasi')->first_row();
	   if(!empty($result)){
			return $result->provinsi_id;
	   }else{
			return 0;
	   }
    }
	
	function get_jenjang_by_matpel($id){
	   $this->db->where('matpel_id', $id);
       $result = $this->db->get('matpel')->first_row();
	   if(!empty($result)){
			return $result->jenjang_pendidikan_id;
	   }else{
			return 0;
	   }
    }
	
	function get_meta_tag($uri){
	   $this->db->like('uri', $uri);
       return $result = $this->db->get('meta_tag')->first_row();
    }
    
}