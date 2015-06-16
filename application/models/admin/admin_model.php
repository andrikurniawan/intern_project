<?php

class Admin_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_table($name){
        return $this->db->get($name);
    }
    
    /*** LOGIN GURU ***/
    function check_login($input){
        $this->db->where('admin_username',$input['username']);
        $this->db->where('admin_password',md5($input['password']));
        $result = $this->db->get('admin');
        if($result->num_rows()>0){
            return $result->first_row();
        }else{
            return null;
        }
    }
    
    /****** UTILITIES *****/
    function get_breadcumb($array) {
        $result = '';
        $numItems = count($array);
        $i = 0;
        foreach ($array as $key => $value) {
            if (++$i === $numItems) {
                $result .= $key; 
            }else{
                $result .= '<a href="'.base_url().'admin/'.$value.'">'.$key.'</a><span class="breadcumb_separator">&gt;</span>';
            }
        }
        return $result;
    }
    
    function get_cs_email(){
         return $this->db->get('cs_email');
    }
    
    /****** SERTIFIKAT *****/
    function get_sertifikat($page=0){
        $offset = 20;
        $start = $page*$offset;
        $this->db->limit($offset,$start);
        $this->db->join('guru','guru_kualifikasi.guru_id=guru.guru_id','left');
        $this->db->order_by('id','desc');
        return $this->db->get('guru_kualifikasi');
    }
    
    public function _deprecated_get_sertifikat_count(){
        return $this->db->count_all_results('guru_sertifikat');
    }
    
    public function get_sertifikat_count(){
//        return $this->db->count_all_results('guru_kualifikasi');
        $this->db->join('guru','guru_kualifikasi.guru_id=guru.guru_id','left');
        $this->db->order_by('id','desc');
        return $this->db->get('guru_kualifikasi')->num_rows();
    }
    
    public function edit_sertifikat_status($id,$status){
        $this->db->set('is_checked',$status,TRUE);
        $this->db->where('id',$id);
        $this->db->update('guru_kualifikasi');
    }

    public function get_guru_ktp($page=0){
        $offset = 20;
        $start = $page*$offset;

        $query = $this->db->query("SELECT * FROM guru WHERE guru_nik_image IS NOT NULL AND length(guru_nik_image)>0
                                    ORDER BY guru_nik_image_modified DESC, guru_id DESC LIMIT $start,$offset");
        return $query;
    }

    public function get_nik_count(){
        $query = $this->db->query("SELECT count(guru_id) as total FROM guru WHERE guru_nik_image IS NOT NULL AND length(guru_nik_image)>0");
        $result = $query->result_array();
        if(sizeof($result>0)) {
            return $result[0]['total'];  

        } else {
            return 0;
        }
    }

    public function change_status_nik($guru_id,$status){
        $this->db->query("UPDATE guru SET guru_nik_verified=$status WHERE guru_id=$guru_id");
    }
    
    /****** REQUEST GURU HOME *****/
    public function get_request_guru_home($page=0){
        $offset = 20;
        $start = $page*$offset;
        $this->db->join('lokasi','lokasi.lokasi_id=request_guru_home.lokasi_id','left');
        $this->db->limit($offset,$start);
        $this->db->order_by('request_guru_home_id','desc');
        return $this->db->get('request_guru_home');
    }
    
    public function get_request_guru_count(){
        return $this->db->count_all_results('request_guru_home');
    }
    
    public function get_request_guru($id){
        $this->db->where('request_guru_home_id',$id);
        return $this->db->get('request_guru_home')->first_row();
    }
    
    public function delete_request_guru($id){
        $this->db->where('request_guru_home_id',$id);
        $this->db->delete('request_guru_home');
    }
    
     public function delete_lamaran_request_guru($id){
        $this->db->where('guru_request_home_id',$id);
        $this->db->delete('guru_lamaran');
    }
    
     public function delete_lamaran_request_by_guru($id_guru, $id){
        $this->db->where('guru_request_home_id',$id);
        $this->db->where('guru_id',$id_guru);
        $this->db->delete('guru_lamaran');
    }
    
     public function get_lamaran_request_guru($id){
        $this->db->where('guru_request_home_id',$id);
        return $this->db->get('guru_lamaran');
    }
    
    public function add_request_guru($input){
        $this->db->set('request_guru_home_title',$input['title']);
        $this->db->set('lokasi_id',$input['lokasi']);
        $this->db->set('request_guru_home_text',$input['text']);
        $this->db->set('request_guru_home_date',date("Y-m-d"));
        $this->db->set('request_guru_home_active',1,TRUE);
        $this->db->insert('request_guru_home');
    }
    
     public function update_request_guru($input){
        $this->db->set('request_guru_home_title',$input['title']);
        $this->db->set('lokasi_id',$input['lokasi']);
        $this->db->set('matpel_id',$input['matpel']);
        $this->db->set('request_guru_home_text',$input['text']);
        $this->db->set('request_guru_home_date',$input['date']);
        $this->db->where('request_guru_home_id',$input['id']);
        $this->db->update('request_guru_home');
    }
    
    public function edit_request_guru_status($id,$status){
        $this->db->set('request_guru_home_active',$status,TRUE);
        $this->db->where('request_guru_home_id',$id);
        $this->db->update('request_guru_home');
    }
    
    //SUBSCRIBE
    public function get_subscribers(){
         return $this->db->get('subscribe');
    }
    
     public function get_subscribers_by_input($input){
		if(!empty($input)){
			$this->db->like('subscriber_nama',$input);
			$this->db->or_like('subscriber_email',$input);
		}
         return $this->db->get('subscribe');
    }
    
     public function edit_email_template($content){
        $this->db->set('sender',$content['sender']);
        $this->db->set('subject',$content['subject']);
        $this->db->set('template_email',$content['template_email']);
        $this->db->update('template_email');
    }
    
    public function get_email_template(){
        return $this->db->get('template_email')->first_row();
    }

    public function add_notification($pesan,$url,$tipe="request", $request_id=0){
        $this->db->query("INSERT INTO admin_notification(request_id,pesan,url,type) VALUES ($request_id,'$pesan','$url','$tipe')");
    }

    public function get_notification($tanggal=null){
        date_default_timezone_set("Asia/Jakarta");
        if($tanggal==null){
            $tanggal = date('Y-m-d');
        }
        $query = $this->db->query("SELECT * FROM admin_notification WHERE date_created LIKE '$tanggal%' ORDER BY date_created DESC");
        return $query->result_array();
    }

    public function get_notif_by_id($id){
        $query = $this->db->query("SELECT * FROM admin_notification WHERE id=$id");

        $result = $query->result_array();
        return $result[0];
    }

    public function update_notif_tindak_lanjut($id,$ops){
        $this->db->query("UPDATE admin_notification SET tindak_lanjut_oleh=$ops WHERE request_id=$id");
    }

    public function change_notif_status($id){
        $this->db->query("UPDATE admin_notification SET status=1 WHERE id=$id");
    }

    public function get_all_messages(){
        $query = $this->db->query("SELECT * FROM admin_message ORDER BY date_created DESC");

        return $query->result_array();
    }

    public function get_message($id){
        $query = $this->db->query("SELECT * FROM admin_message WHERE id=$id");

        $result = $query->result_array();
        return $result[0];
    }

    public function set_message_read($id){
        $query = $this->db->query("UPDATE admin_message SET is_read=1 WHERE id=$id");
    }

    public function get_diskon_setting(){
        $query = $this->db->query("SELECT value FROM setting WHERE name='diskon' LIMIT 1");

        $result = $query->result_array();
        return $result[0]['value'];
    }

    public function set_diskon_rate($rate){
        $this->db->query("UPDATE setting SET value='$rate' WHERE name='diskon'");
    }

    public function get_nama_provinsi($id){
        $query = $this->db->query("SELECT * FROM provinsi WHERE provinsi_id=$id");
        $result = $query->result_array();

        return $result[0];
    }

    public function get_list_kota($prov){
        $query = $this->db->query("SELECT * FROM lokasi WHERE provinsi_id=$prov");
        return $query->result_array();
    }

    public function get_nama_lokasi($id){
        $query = $this->db->query("SELECT * FROM lokasi WHERE lokasi_id=$id");
        $result = $query->result_array();

        return $result[0];   
    }

    public function get_nama_jenjang($id){
        $query = $this->db->query("SELECT * FROM jenjang_pendidikan WHERE jenjang_pendidikan_id=$id");
        $result = $query->result_array();

        return $result[0];  
    }

    public function get_list_matpel($jenjang){
        $query = $this->db->query("SELECT * FROM matpel WHERE jenjang_pendidikan_id=$jenjang");
        return $query->result_array();
    }

    public function get_nama_matpel($id){
        $query = $this->db->query("SELECT * FROM matpel WHERE matpel_id=$id");
        $result = $query->result_array();

        return $result[0];  
    }

    public function create_pengumuman($isi,$tujuan){
        $query = $this->db->query("INSERT INTO admin_pengumuman(isi,tujuan) VALUES ('$isi',$tujuan)");
    }

    public function get_pengumuman(){
        $query = $this->db->query("SELECT * FROM admin_pengumuman ORDER BY date_created DESC");
        return $query->result_array();
    }
    
    public function get_guru_npwp($page=0){
        $offset = 20;
        $start = $page*$offset;

        $query = $this->db->query("SELECT * FROM guru WHERE guru_npwp_image IS NOT NULL AND length(guru_npwp_image)>0
                                    ORDER BY guru_npwp_update DESC, guru_id DESC LIMIT $start,$offset");
        return $query;
    }
    
    public function get_npwp_count(){
        $query = $this->db->query("SELECT count(guru_id) as total FROM guru WHERE guru_npwp_image IS NOT NULL AND length(guru_npwp_image)>0");
        $result = $query->result_array();
        if(sizeof($result>0)) {
            return $result[0]['total'];  

        } else {
            return 0;
        }      
    }
    
    public function change_status_npwp($id,$status){
        $this->db->query("UPDATE guru SET guru_npwp_verified=$status WHERE guru_id=$id");
    }
    
    public function hapus_npwp_guru($guru_id){
        $this->db->query("UPDATE guru SET guru_npwp_verified=0, guru_npwp_image='' WHERE guru_id=$guru_id");
    }
    
    public function get_guru_ket_pajak($page=0){
         $offset = 20;
        $start = $page*$offset;

        $query = $this->db->query("SELECT * FROM guru WHERE guru_ket_pajak_image IS NOT NULL AND length(guru_ket_pajak_image)>0
                                    ORDER BY guru_ket_pajak_updated DESC, guru_id DESC LIMIT $start,$offset");
        return $query;
    }
    
    public function get_ket_pajak_count(){
        $query = $this->db->query("SELECT count(guru_id) as total FROM guru WHERE guru_ket_pajak_image IS NOT NULL AND length(guru_ket_pajak_image)>0");
        $result = $query->result_array();
        if(sizeof($result>0)) {
            return $result[0]['total'];  

        } else {
            return 0;
        }      
    }
    
    public function change_status_ket_pajak($id,$status){
        $this->db->query("UPDATE guru SET guru_ket_pajak_verified=$status WHERE guru_id=$id");
    }
    
    public function hapus_ket_pajak_guru($guru_id){
        $this->db->query("UPDATE guru SET guru_ket_pajak_verified=0, guru_ket_pajak_image='' WHERE guru_id=$guru_id");
    }
}
?>