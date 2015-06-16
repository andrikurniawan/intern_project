<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 10/8/14
 * Time: 4:16 PM
 * Proj: private-development
 */
class Vendor_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_new_register_vendor() {
		return $this->db
			->from('vendor_profile')
			->join('vendor_info', 'vendor_profile.id=vendor_info.vendor_id', 'left')
			->where('vendor_profile.status', 0)
			->order_by('vendor_profile.id','desc')
			->get();
	}
	
	public function get_all_vendor() {
		return $this->db
			->from('vendor_profile')
			->join('vendor_info', 'vendor_profile.id=vendor_info.vendor_id', 'left')
			->order_by('vendor_profile.id','desc')
			->get();
	}
	
	public function get_vendor_detail($id) {
		$vendor = $this->db
			->from('vendor_profile')
			->join('vendor_info', 'vendor_profile.id=vendor_info.vendor_id', 'left')
			->where(array('vendor_profile.id'=>$id))
			->order_by('vendor_profile.id','desc')
			->get()->row();
		if(!empty($vendor)) {
			if(!empty($vendor->vendor_logo)) 
				$vendor->vendor_logo = base_url()."images/vendor/{$id}/{$vendor->vendor_logo}";

			$vendor->class_count = $this->db
					->select('COUNT(*) as cnt')
					->from('vendor_class')
					->where('vendor_id', $id)
					->get()->row()->cnt;
			
			$bank = $this->db
					->select('bank.bank_title')
					->select('vendor_rekening.cabang')
					->select('vendor_rekening.no_rek')
					->select('vendor_rekening.atasnama')
					->from('vendor_rekening')
					->join('bank', 'bank.bank_id = vendor_rekening.bank_id', 'LEFT')
					->where('vendor_rekening.vendor_id', $id)
					->get()->row();
			if(empty($bank)) {
				$bank = array('no_bank'=>'This Account has no bank account!');
			}
			foreach($bank as $key => $value) {
				$k = 'account_'.$key;
				$vendor->{$k} = $value;
			}
			return $vendor;
		}
		return FALSE;
	}
	
	public function get_profile($var) {
		if(empty($var) || !is_array($var)) return FALSE;
		$this->db->where($var);
		return $this->db->get('vendor_profile');
	}

	public function get_empty_uri_profile() {
		return $this->db->query("SELECT * FROM vendor_profile WHERE uri IS NULL OR uri = ''")->result();
	}
	
	public function get_class_id_by_uri($uri) {
		return $this->db->select('id')->where('class_uri', $uri)->get('vendor_class')->scalar();
	}
	
	public function generate_uri($uri) {
		$uri = url_title_2($uri);
		if($this->get_profile(array('uri'=>$uri))->num_rows()) {
			$uris = explode('-',$uri);
			$num = array_pop($uris);
			if(is_numeric($num)) {
				$num = (int)$num;
				$num++;
			} else {
				$num .= '-1';
			}
			array_push($uris, $num);
			$uri = $this->generate_uri(implode(',',$uris));
		}
		return $uri;
	}
	
	public function set_profile($var) {
		$data = array_intersect_key($var, array(
			'id'			=> NULL,
			'email'			=> NULL,
			'password'		=> NULL,
			'name'			=> NULL,
			'uri'			=> NULL,
			'main_phone'	=> NULL,
			'address'		=> NULL
		));

		if(empty($data['uri'])) $data['uri'] = $this->generate_uri($data['name']); 
		if(isset($var['id'])) {
			$this->db->update('vendor_profile', $data, array('id'=>$var['id']));
			$this->set_info(array('vendor_id'=>$var['id'], 'is_institute'=>1));
			return $var['id'];
		} elseif($this->db->insert('vendor_profile', $data)) {
			$id = $this->db->insert_id();
			$this->set_info(array('vendor_id'=>$id, 'is_institute'=>1));
			return $id;
		}
		log_message('error', $this->db->last_query());
		return FALSE;
		
	}
	
	public function update_profile($var) {
		$data = array_intersect_key($var, array(
			'email'			=> NULL,
			'password'		=> NULL,
			'name'			=> NULL,
			'uri'			=> NULL,
			'main_phone'	=> NULL,
			'address'		=> NULL,
			'npwp'			=> NULL,
			'status'		=> NULL,
			'show_address'	=> NULL,
			'show_phone'	=> NULL,
			'show_email'	=> NULL,
		));	
		if($this->db->update('vendor_profile', $data, array('id'=>$var['id']))) {
			return $this->db->affected_rows();
		}
		return FALSE;
	}
	
	public function get_info($var) {
		if(empty($var) || !is_array($var)) return FALSE;
		$this->db->where($var);
		return $this->db->get('vendor_info');
	}
	
	public function set_info($var) {
		$this->db->insert('vendor_info', $var);
	}

	public function update_info($var) {
		$id = $var['id'];
		unset($var['id']);
		if(empty($var)) return 0;
		$this->db->update('vendor_info', $var, array('vendor_id'=>$id));
		return $this->db->affected_rows();
	}
	
	public function set_rekening($var){
		$id = $var['vendor_id'];
		$row = $this->db->where(array('vendor_id'=> $id))->get('vendor_rekening')->num_rows();

		if(empty($row)) {
			$this->db->insert('vendor_rekening', $var);
		} else {
			unset($var['vendor_id']);
			$this->db->update('vendor_rekening', $var, array('vendor_id'=> $id));
		}
		return $this->db->affected_rows();
	}
	
	public function get_bank_list(){
		return $this->db->get('bank')->result();
	}
	
	public function get_rekening($id) {
		return $this->db->where('vendor_id', $id)->get('vendor_rekening')->row();
	}
	
	public function set_socmed($var){
		if(empty($var['id'])) {
			$this->db->insert('vendor_socmed', $var);
		} else {
			$id = $var['id'];
			unset($var['id']);
			$this->db->update('vendor_socmed', $var, array('vendor_id'=> $id));
		}
		return $this->db->affected_rows();
	}
	
	public function get_socmed($id){
		return $this->db->where('vendor_id', $id)->get('vendor_socmed')->row();
	}
	
	public function set_tag($tags, $id) {
		$tags = explode(',',$tags);
		$q = array();
		foreach($tags as &$tag) {
			$tag = trim($tag);
			$q[] = "('{$id}, '{$tag}')";
		}

		$this->db->query('INSERT IGNORE INTO vendor_class_tag (vendor_id, tag_words) VALUES '. implode(',', $q));

		foreach($tags as $tag) {
			$this->db->query("
		INSERT INTO 
		vendor_tag_collections (tag_words, counter) 
		VALUES ('{$tag}', 1) 
		ON DUPLICATE KEY UPDATE counter = counter+1 " );
		}
	}
	public function get_tag($id) {
		return $this->db->query("
			SELECT
				*
			FROM
				vendor_class_tags a
				LEFT JOIN vendor_tag_collections b
					ON a.tag_words = b.tag_words
			WHERE 1
				AND a.vendor_id = ?
		", array($id))->result();
	}
	
	public function check_is_email_exists($email) {
		$guru = $this->db->from('vendor')->where('email', $email)->get();
		if($guru->num_rows() == 1) {
			return $guru->row()->id;
		}
		return FALSE;
	}
	
	public function duplicate_teacher_as_vendor($guru_id) {
		$query = $this->db->query("
			SELECT
-- 				guru_id AS id,
				guru_email AS email,
				guru_password AS password,
				guru_hp AS main_phone,
				guru_alamat AS address
			FROM
				guru
			WHERE 1
				AND guru_id = ?
		", array($guru_id));
		if($query->num_rows() != 1) return FALSE;
		$result = $query->row_array();
		if($this->db->from('vendor_profile')->where('id', $result->id)->get()->num_rows() != 0) return FALSE;
		$this->db->insert('vendor_profile', $result);
		if($this->db->affected_rows() != 1) return FALSE;
		$vendor_id = $this->db->insert_id();
		$this->db->insert('vendor_rel_guru', array('guru_id'=>$guru_id, 'vendor_id'=>$vendor_id));
		return $vendor_id;
	}
	
	public function connect_teacher($guru_id, $vendor_id) {
		$this->db->insert('vendor_rel_guru', array('guru_id'=>$guru_id, 'vendor_id'=>$vendor_id));
		return !!$this->db->affected_rows();
	}
	
	public function approve_vendor($id) {
		$this->db->update('vendor_profile', array('status'=>1), array('id'=>$id));
		return !! $this->db->affected_rows();
	}
	public function reject_vendor($id) {
		$this->db->update('vendor_profile', array('status'=>-1), array('id'=>$id));
		return !! $this->db->affected_rows();
	}
	public function deactivate_vendor($id) {
		$this->db->update('vendor_profile', array('status'=>0), array('id'=>$id));
		return !! $this->db->affected_rows();
	}
	
	public function vendor_search($keywords) {
		$this->db
			->from('vendor_profile')
			->join('vendor_info', 'vendor_profile.id=vendor_info.vendor_id', 'left')
			->order_by('vendor_profile.id','desc');
		foreach($keywords as $keyword)
			$this->db->or_like('vendor_profile.name', $keyword);
		return $this->db->get();
	}

    function get_vendor_by_email($email) {
        $this->db->where('email',$email);
        $result = $this->db->get('vendor_profile');
        if($result->num_rows() > 0){
            return $result->first_row();
        }else{
            return null;
        }
    }

    /*** RESET PASSWORD VENDOR ***/
    function reset_password($email){
        $vendor = $this->get_vendor_by_email($email);
        if(!empty($vendor)){
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $new_pass = implode($pass);
            //update password
            if(!empty($vendor) && $vendor->id > 0){
                $this->db->set('password',md5($new_pass));
                $this->db->where('id',$vendor->id);
                $this->db->update('vendor_profile');
            }else{
                return false;
            }
            //send email
            $this->send_reset_password_email($vendor, $new_pass);
            return true;
        }else{
            return false;
        }
    }

    function send_reset_password_email($vendor,$new_pass){
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
        $this->email->bcc('arie@ruangguru.com');
        $this->email->to($vendor->email);

        $this->email->subject('Reset Password Guru Ruangguru');
        //assigning new pass to guru
        $vendor->new_pass = $new_pass;
        $content = $this->load->view('vendor/auth/reset_pass_email',array('vendor'=>$vendor),TRUE);
        $this->email->message($content);

        $this->email->send();
    }
	
	public function get_csv_fields() {
		$fields1 = $this->db->list_fields('vendor_profile');
		$fields2 = $this->db->list_fields('vendor_info');
		$fields3 = $this->db->list_fields('vendor_rekening');
		$fields = array_merge($fields1, $fields2, $fields3);
		return $fields;
	}

}

// END OF vendor_model.php File