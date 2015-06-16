<?php

class Matpel_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_jenjang(){
        $this->db->order_by('jenjang_pendidikan_index','asc');
        return $this->db->get('jenjang_pendidikan');
    }
	
	function get_jenjang_max(){
        $this->db->select_max('jenjang_pendidikan_index');
        return $this->db->get('jenjang_pendidikan')->first_row();
    }
    
    function get_matpel($pend_id,$limit=false){
	   $this->db->order_by('matpel_title','asc');
       $this->db->where('jenjang_pendidikan_id',$pend_id);
       return $this->db->get('matpel');
    }
    
    /* POSTS */
    public function get_jenjang_pendidikan(){
		$this->db->order_by('jenjang_pendidikan_index','ASC');
		return $this->db->get('jenjang_pendidikan');
    }
    
     public function add_jenjang_pendidikan($input){
        $this->db->set('jenjang_pendidikan_title',$input['pend_label']);
        $this->db->set('jenjang_pendidikan_index',$input['pend_index']);
        $this->db->insert('jenjang_pendidikan');
    }
    
     public function get_jenjang_pendidikan_by_id($id){
		$this->db->where('jenjang_pendidikan_id',$id);
		return $this->db->get('jenjang_pendidikan')->first_row();
    }
	
	public function get_jenjang_pendidikan_by_index($index){
		$this->db->where('jenjang_pendidikan_index',$index);
		return $this->db->get('jenjang_pendidikan')->first_row();
    }
    
     public function delete_jenjang_pendidikan($id){
        $this->db->where('jenjang_pendidikan_id',$id);
        $this->db->delete('jenjang_pendidikan');
    }
    
     public function edit_jenjang_pendidikan($input){
        $this->db->set('jenjang_pendidikan_index',$input['pend_index']);
        $this->db->set('jenjang_pendidikan_title',$input['pend_label']);
        $this->db->where('jenjang_pendidikan_id',$input['pend_id']);
        $this->db->update('jenjang_pendidikan');
    }
	
	public function update_jenjang_pendidikan($id, $temp){
        $this->db->set('jenjang_pendidikan_index',$temp);
        $this->db->where('jenjang_pendidikan_id',$id);
        $this->db->update('jenjang_pendidikan');
    }
	
	public function add_matpel($input){
        $this->db->set('jenjang_pendidikan_id',$input['pend_id']);
        $this->db->set('matpel_title',$input['matpel_label']);
        $this->db->insert('matpel');
    }
	
	public function get_matpel_by_id($id){
		$this->db->where('matpel_id',$id);
		return $this->db->get('matpel')->first_row();
    }
	
	public function edit_matpel($input){
        $this->db->set('matpel_title',$input['matpel_label']);
        $this->db->where('matpel_id',$input['matpel_id']);
        $this->db->update('matpel');
    }
	
	public function delete_matpel($id){
        $this->db->where('matpel_id',$id);
        $this->db->delete('matpel');
    }
}