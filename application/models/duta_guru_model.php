<?php

class Duta_guru_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /***** REGISTRASI DUTA GURU ******/
    function check_email($email){
        $this->db->where('duta_guru_email',$email);
        $result = $this->db->get('duta_guru');
        if($result->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    function get_kota(){
        return $this->db->get('lokasi');
    }
    
    function get_provinsi(){
        return $this->db->get('provinsi');
    }
    
    function insert_duta_guru($input){
        $this->db->set('duta_guru_email',$input['email']);
        $this->db->set('duta_guru_password',md5($input['pass']));
        $this->db->set('duta_guru_nama',$input['nama']);
        $this->db->set('duta_guru_kota',$input['kota']);
        $this->db->set('duta_guru_alamat',$input['alamat']);
        $this->db->set('duta_guru_alamat_domisili',$input['alamat_domisili']);
        $this->db->set('duta_guru_hp',$input['hp']);
        $this->db->set('duta_guru_hp_2',$input['hp_2']);
        $this->db->set('duta_guru_telp_rumah',$input['telp_rumah']);
        $this->db->set('duta_guru_telp_kantor',$input['telp_kantor']);
        $this->db->set('duta_guru_gender',$input['gender']);
        $this->db->set('duta_guru_tempatlahir',$input['tempatlahir']);
        $this->db->set('duta_guru_lahir',$input['lahir']);
        $this->db->set('source_info_id',$input['source_info']);
        $this->db->set('duta_guru_daftar',$input['duta_guru_daftar']);
        $this->db->set('duta_guru_active',1,FALSE);
        $this->db->insert('duta_guru');
        return $this->db->insert_id();
    }
    
    /*** DELETE DUTA GURU ***/
    function delete_duta_guru($id){
        //get murid
        $dutaguru = $this->get_duta_guru_by_id($id);
        if(empty($dutaguru)){
            return;
        }
        //delete pp
        $base_path = $this->config->item('base_url_pp_dutaguru');
        unlink($base_path.$dutaguru->duta_guru_id.'.jpg');
        //delete duta guru
        $query = "DELETE t1
                    FROM duta_guru as t1
                  WHERE t1.duta_guru_id = ".$id;
        $this->db->query($query);
    }   
    
     function delete_pembayaran($pembayaran_id){
        //delete pembayaran
        $query = "DELETE t1
                    FROM pembayaran as t1
                  WHERE t1.pembayaran_id = ".$pembayaran_id;
        $this->db->query($query);
    } 
    
     /*** LOGIN GURU ***/
    function check_login($input){
        $this->db->where('duta_guru_email',$input['email']);
        $this->db->where('duta_guru_password',md5($input['password']));
        $result = $this->db->get('duta_guru');
        if($result->num_rows()>0){
            return $result->first_row()->duta_guru_id;
        }else{
            return null;
        }
    }
    
    function check_duta_guru($email,$id,$password){
        if(!empty($email)){
            $this->db->where('duta_guru_email',$email);
        }
        if(!empty($id)){
            $this->db->where('duta_guru_id',$id);
        }
        if(!empty($password)){
            $this->db->where('duta_guru_password',md5($password));
        }
        $this->db->select('duta_guru_id');
        $result = $this->db->get('duta_guru');
        if($result->num_rows > 0 ){
            return true;
        }else{
            return false;
        }
    }
    
    /*** RESET PASSWORD MURID ***/
    function reset_password($email){
        $duta_guru = $this->get_duta_guru_by_email($email);
        if(!empty($duta_guru)){
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); 
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $new_pass = implode($pass);
            //update password
            if(!empty($duta_guru) && $duta_guru->duta_guru_id > 0){
                $this->db->set('duta_guru_password',md5($new_pass));
                $this->db->where('duta_guru_id',$duta_guru->duta_guru_id);
                $this->db->update('duta_guru');
            }else{
                return false;
            }
            //send email
            $this->send_reset_password_email($duta_guru, $new_pass);
            return true;
        }else{
            return false;
        }
    }
    
    function send_reset_password_email($duta_guru,$new_pass){
        $this->load->library('email');
	$this->email->from('no-reply@ruangguru.com', 'Ruangguru.com');
        $this->email->cc('registrasi@ruangguru.com');
	$this->email->to($duta_guru->duta_guru_email);

	$this->email->subject('Reset Password Duta Guru Ruang Guru');
        //assigning new pass to duta_guru
        $duta_guru->new_pass = $new_pass;
        $content = $this->load->view('front/duta_guru/template/reset_password_email',array('duta_guru'=>$duta_guru),TRUE);
	$this->email->message($content);

	$this->email->send();
    }
    
    /*** EMAIL DUTA GURU ***/
    function email_reg($dutaguru){
        $this->load->library('email');
	$config['useragent'] = 'Ruangguru Web Service';
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'mail.ruangguru.com';
	$config['smtp_port'] = 25;
	$config['smtp_user'] = 'no-reply@ruangguru.com';
	$config['smtp_pass'] = $this->config->item('smtp_password');
	$config['priority'] = 1;
	$config['mailtype'] = 'html';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE; 
	$this->email->initialize($config);
	$this->email->from('no-reply@ruangguru.com', 'Ruangguru.com');
	$this->email->to($dutaguru->duta_guru_email);

	$this->email->subject('Selamat Datang di Ruangguru');
        $content = $this->load->view('front/duta_guru/daftar_email',array('dutaguru'=>$dutaguru),TRUE);
	$this->email->message($content);

	$this->email->send();
    }
    
    function send_email_reg($id){
        $this->db->where('duta_guru_id',$id);
        $dutaguru = $this->db->get('duta_guru');
        if($dutaguru->num_rows() > 0){
            $dutaguru = $dutaguru->first_row();
            $this->email_reg($dutaguru);
        }
    }
    
    /******* DUTA GURU GETTER *****/
    function get_duta_guru_by_id($id){
        $this->db->where('duta_guru_id',$id);
        $this->db->join('lokasi','duta_guru.duta_guru_kota=lokasi.lokasi_id', 'left outer');
        $this->db->join('bank','bank.bank_id = duta_guru.bank_id','left outer');
        //$this->db->join('source_info','duta_guru.source_info_id=source_info.source_info_id', 'left outer');
        return $this->db->get('duta_guru')->first_row();
    }
    
    function get_duta_guru_by_email($email){
        $this->db->where('duta_guru_email',$email);
        $result = $this->db->get('duta_guru');
        if($result->num_rows() > 0){
            return $result->first_row();
        }else{
            return null;
        }
    }    
    
    /*** BIODATA ***/
    function update_pass($guru_id,$oldpass,$pass){
        $this->db->set('duta_guru_password',md5($pass));
        $this->db->where('duta_guru_password',md5($oldpass));
        $this->db->where('duta_guru_id',$guru_id);
        $this->db->update('duta_guru');
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    function update_biodata($id_guru,$input){
        $this->db->set('duta_guru_nama',$input['nama']);
        $this->db->set('duta_guru_gender',$input['gender']);
        $this->db->set('duta_guru_tempatlahir',$input['tempatlahir']);
        $this->db->set('duta_guru_lahir',$input['lahir']);
        $this->db->set('duta_guru_hp',$input['hp']);
        $this->db->set('duta_guru_hp_2',$input['hp_2']);
        $this->db->set('duta_guru_telp_rumah',$input['telp_rumah']);
        $this->db->set('duta_guru_telp_kantor',$input['telp_kantor']);
        $this->db->set('duta_guru_alamat',$input['alamat']);
        $this->db->set('duta_guru_alamat_domisili',$input['alamat_domisili']);
        $this->db->set('duta_guru_kota',$input['kota']);
        $this->db->where('duta_guru_id',$id_guru);
        $this->db->update('duta_guru');
    }
    
    /*** BANK ***/
    function get_duta_guru_bank_by_id($id){
        $this->db->select('bank.*');
        $this->db->select('duta_guru.duta_guru_bank_rekening');
        $this->db->select('duta_guru.duta_guru_bank_pemilik');
        $this->db->join('bank','duta_guru.bank_id=bank.bank_id');
        $this->db->where('duta_guru_id',$id);
        return $this->db->get('duta_guru')->first_row();
    }
    
    function update_bank($id,$input){
        $this->db->set('bank_id',$input['bank']);
        $this->db->set('duta_guru_bank_rekening',$input['rekening']);
        $this->db->set('duta_guru_bank_pemilik',$input['pemilik']);
        $this->db->where('duta_guru_id',$id);
        $this->db->update('duta_guru');
    }
    
    /*** REFERRAL ***/
    function get_murid_referral($id){
        $this->db->join('murid','murid.murid_referral=duta_guru.duta_guru_id');
        $this->db->where('duta_guru_id',$id);
        return $this->db->get('duta_guru');
    }
    
    function get_guru_referral($id){
        $this->db->join('guru','guru.guru_referral=duta_guru.duta_guru_id');
        $this->db->where('duta_guru_id',$id);
        return $this->db->get('duta_guru');
    }
    
    /*** SESSION GETTER ***/
    function ses_get_nama(){
        $id = $this->session->userdata('duta_guru_id');
        if(!empty($id)){
            $this->db->where('duta_guru_id',$id);
            return $this->db->get('duta_guru')->first_row()->duta_guru_nama;
        }else{
            return '';
        }
    }
    
    /*** LIST GURU ***/
    function get_list_guru($duta_guru_id){
        $this->db->where('guru_referral',$duta_guru_id);
        $this->db->where('guru_active',1);
        return $this->db->get('guru');
    }
    
     function get_kelas_list_guru($duta_guru_id, $guru_id){
        $this->db->where('duta_guru_id',$duta_guru_id);
        $this->db->where('guru_id',$guru_id);
        return $this->db->get('kelas')->first_row();
    }
    
     function get_matpel($matpel_id){
        $this->db->where('matpel_id',$matpel_id);
        return $this->db->get('matpel')->first_row();
    }
    
    
    /*** LIST MURID ***/
    function get_list_murid($duta_guru_id){
    	   $this->db->join('murid','murid.murid_id=kelas.murid_id', 'left outer');
        $this->db->join('matpel','matpel.matpel_id=kelas.matpel_id', 'left outer');
	   $this->db->join('jenjang_pendidikan','jenjang_pendidikan.jenjang_pendidikan_id=matpel.jenjang_pendidikan_id', 'left outer');
        $this->db->where('kelas.duta_murid_id',$duta_guru_id);
	   $this->db->group_by('kelas.murid_id');
        return $this->db->get('kelas');
    }
    
    /*** LIST PEMBAYARAN ***/
    function add_pembayaran($input){
        $this->db->set('pembayaran_user_referral',$input['user_referral']);
        $this->db->set('pembayaran_kelas_id',$input['id_kelas']);
        $this->db->set('pembayaran_title',$input['title']);
        $this->db->set('pembayaran_amount',$input['amount']);
        $this->db->set('pembayaran_user_id',$input['duta_guru_id']);
	   if($input['user_refferal']==1){
          $this->db->set('pembayaran_type','DUTA_GURU');
	   } else {
	     $this->db->set('pembayaran_type','DUTA_MURID');
	   }
        $this->db->set('pembayaran_date_verified',$input['date_verified']);
        $this->db->set('pembayaran_status_id',$input['status']);
        return $this->db->insert('pembayaran');
    }
    
     function update_pembayaran($input){
        $this->db->set('pembayaran_title',$input['title']);
        $this->db->set('pembayaran_amount',$input['amount']);
        $this->db->set('pembayaran_user_id',$input['duta_id']);
        $this->db->set('pembayaran_date_verified',$input['date_verified']);
        $this->db->set('pembayaran_status_id',$input['status']);
	   $this->db->where('pembayaran_id',$input['id']);
        return $this->db->update('pembayaran');
    }
    
    function get_pembayaran_data($pembayaran_id){
		$this->db->where('pembayaran_id',$pembayaran_id);
		return $this->db->get('pembayaran')->first_row();
    }
    
    function get_pembayaran($duta_guru_id){
        $this->db->join('pembayaran_status','pembayaran_status.pembayaran_status_id=pembayaran.pembayaran_status_id','left outer');
        $this->db->where('pembayaran_user_id',$duta_guru_id);
        $this->db->order_by('pembayaran_id','desc');
        return $this->db->get('pembayaran');
    }
    
    /*** ADMIN ***/
    function get_duta_guru($page=0){
        $offset = 20;
        $start = $page*$offset;
        $this->db->limit($offset,$start);
        $this->db->order_by('duta_guru_id','desc');
        return $this->db->get('duta_guru');
    }
    
    public function get_duta_guru_count(){
        return $this->db->count_all_results('duta_guru');
    }
    
     function get_duta_guru_new(){
        $this->db->order_by('duta_guru_daftar','desc');
        return $this->db->get('duta_guru');
    }
    
    function get_duta_guru_by_name($name){
        $this->db->like('duta_guru_nama',$name);
        return $this->db->get('duta_guru');
    }
    
}