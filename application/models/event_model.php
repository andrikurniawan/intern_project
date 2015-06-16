<?php

class Event_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_table($name){
        return $this->db->get($name);
    }
    
     function check_email($email){
        $this->db->where('email_registrasi',$email);
        $result = $this->db->get('registrasi_event');
        if($result->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
     function registrasi_event($input){
        $this->db->set('nama_registrasi',$input['nama']);
        $this->db->set('email_registrasi',$input['email']);
        $this->db->set('telepon_registrasi',$input['telp']);
        $this->db->set('institusi_registrasi',$input['institusi']);
        $this->db->set('status_registrasi',$input['rg_status']);
        $this->db->set('follow_coaching',$input['coaching']);
        $this->db->set('is_verified',0);
        $this->db->set('tgl_registrasi',date("Y-m-d H:i:s"));
	   $this->db->insert('registrasi_event');
        return $this->db->insert_id();
    }
    
    function get_registran($id){
        $this->db->where('id_registrasi',$id);
        return $this->db->get('registrasi_event')->first_row();
    }
    
     function get_registran_all(){
        return $this->db->get('registrasi_event');
    }
    
     function get_registran_limit($page=0){
	   $offset = 20;
        $start = $page*$offset;
        $this->db->limit($offset,$start);
        $this->db->order_by('id_registrasi','asc');
        return $this->db->get('registrasi_event');
    }
    
     function register_verifikasi($id){
	   $this->db->set('is_verified',1);
        $this->db->where('id_registrasi',$id);
        $this->db->update('registrasi_event');
    }

     function delete_registran($id){
        $this->db->where('id_registrasi',$id);
        $this->db->delete('registrasi_event');
    }

     function send_ticket($id){
	   $this->db->set('send_ticket',1);
        $this->db->where('id_registrasi',$id);
        $this->db->update('registrasi_event');
    }
}
?>
