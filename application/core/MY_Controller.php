<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 10/8/14
 * Time: 12:53 PM
 * Proj: private-development
 * 
 * @property Admin_model $admin_model
 * @property Cache_model $cache_model
 * @property Csmodel $csmodel
 * @property Discount_model $discount_model
 * @property Duta_guru_model $duta_guru_model
 * @property Email_model $email_model
 * @property Event_model $event_model
 * @property Feedback_model $feedback_model
 * @property Guru_model $guru_model
 * @property Kelas_model $kelas_model
 * @property Main_model $main_model
 * @property Matpel_model $matpel_model
 * @property Murid_model $murid_model
 * @property Profile_model $profile_model
 * @property Point_model $point_model
 * @property Payment_model $payment_model
 * @property Request_model $request_model
 * @property Utilities_model $utilities_model
 * @property Vendor_class_model $vendor_class_model
 * @property Vendor_model $vendor_model
 */
class MY_Controller extends CI_Controller{
//	var $id;
	var $data = array();
	var $new_design = FALSE;
	var $is_admin = FALSE;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('utility');
		$this->load->library('session');
		$this->load->model('utilities_model');
		$this->data['large_header'] = TRUE;
		
		$this->utilities_model->general_journey_log();
		
		$this->load->helper('cookie');
		$new_design = FALSE;
		if($this->input->cookie('new_design') == 'okeh' || $this->input->get('new_design')=='please') {
			$new_design = TRUE;
		}
		if($new_design) {
			$this->input->set_cookie('new_design','okeh', 3600);
			if(isset($_GET['stop_new_design'])) {
				delete_cookie('new_design');
				$new_design = FALSE;
			}
		}
		$this->load->model('vendor_class_model');
		$this->load->model('vendor_model');
		$this->load->model('main_model');
		$this->data['header_data'] = array(
			'class_level'	=> $this->vendor_class_model->get_class_level_list()->result(),
			'provinsi_list'	=> $this->main_model->get_provinsi_list(),
			'class_category'=> $this->vendor_class_model->get_category_list()->result(),
			'full_location_list' => $this->main_model->get_location_full_list()
		);
		$user['type'] = $this->session->userdata('user_type');
		$user['name'] = $this->session->userdata('user_name');
		$user['email'] = $this->session->userdata('user_email');
		$user['id'] = $this->session->userdata('user_id');

		$this->data['is_logged_in'] = FALSE;
		$this->data['user'] = array();
		if( TRUE 
				&& !empty($user['type']) 
				&& !empty($user['name']) 
				&& !empty($user['email']) 
				&& !empty($user['id']) 
		){
			$this->data['is_logged_in'] = TRUE;
			$this->data['user'] = $user;
		}
//		$this->new_design = $new_design;
		$this->new_design = TRUE;
	}
	
	protected function exec_login($data) {
		$this->exec_logout(FALSE);
		$this->session->set_userdata('user_type', $data['type']);
		$this->session->set_userdata('user_name', $data['name']);
		$this->session->set_userdata('user_email', $data['email']);
		$this->session->set_userdata('user_id', $data['id']);
	}
	
	protected function exec_logout($force = TRUE){
		$this->session->set_userdata('user_type', FALSE);
		$this->session->set_userdata('user_name', FALSE);
		$this->session->set_userdata('user_email', FALSE);
		$this->session->set_userdata('user_id', FALSE);
		$this->session->unset_userdata('user_type');
		$this->session->unset_userdata('user_name');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_id');
		if($force) $this->session->sess_destroy();
	}
	
	protected function _login() {
		
	}
}

class Admin_Controller extends MY_Controller {
	var $admin_id;
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/admin_model');
		$this->is_admin = TRUE;
	}
	
    public function check(){
        $this->id = $this->admin_id = $this->session->userdata('admin_id');
        if( FALSE
				|| empty($this->id) 
				|| empty($this->data['user'])
				|| empty($this->data['user']['type'])
				|| $this->data['user']['type'] != 'admin'
		){
            redirect('admin/user/login');
        }
    }
}

class Guru_Controller extends MY_Controller {
	
}

class Murid_Controller extends MY_Controller {
	
}

class Vendor_Controller extends MY_Controller {
	var $vendor;
	public function __construct() {
		parent::__construct();
		$this->data['user']['type'] = $this->session->userdata('user_type');
		$this->data['user']['name'] = $this->session->userdata('user_name');
		$this->data['user']['email'] = $this->session->userdata('user_email');
		$this->data['user']['id'] = $this->session->userdata('user_id');
		$this->data['large_header'] = FALSE;
		if( FALSE
			|| empty($this->data['user']['type'])
			|| empty($this->data['user']['name'])
			|| empty($this->data['user']['email'])
			|| empty($this->data['user']['id'])
		) {
			$this->session->set_flashdata('status.warning', 'Please login or register first!');
			redirect('vendor/auth/logreg');
			return;
		}
		$this->load->model('vendor_model');
/// <<<<<<< HEAD
		if($this->data['user']['type'] == 'vendor') {
			$vendor = $this->vendor_model->get_profile(array(
				'email'	=> $this->data['user']['email'],
				'id'	=> $this->data['user']['id']
			));
			$vendor_info = $this->vendor_model->get_info(array(
				'vendor_id'	=> $this->data['user']['id']
			))->row();
			if($vendor->num_rows() != 1) {
				$this->session->set_flashdata('status.warning', 'User authentication failed!');
				redirect('vendor/auth/logreg');
				return;
			}
			$this->vendor = $vendor->row();
			$this->data['vendor']['profile'] = $this->vendor;
			$this->data['vendor']['info'] = $vendor_info;
			$socmed = $this->vendor_model->get_socmed($this->vendor->id);
			$rekening = $this->vendor_model->get_rekening($this->vendor->id);
			$progress=0;
			if(!empty($this->vendor->email) &&
				!empty($this->vendor->name) &&
				!empty($this->vendor->main_phone) &&
				!empty($this->vendor->address)){
				$progress+=30;}
			if(!empty($vendor_info->vendor_description)) {
				$progress+=10;}
			if(!empty($vendor_info->vendor_logo)){
				$progress+=10;}
			if(!empty($socmed)){
				$progress+=10;}
			if(!empty($vendor_info->contact_person_name)){
				$progress+=5;}
			if(!empty($vendor_info->contact_person_phone)){
				$progress+=5;}
			if(!empty($vendor_info->contact_person_mobile)){
				$progress+=5;}
			if(!empty($vendor_info->contact_person_email)){
				$progress+=5;}
			if(!empty($rekening)){
				$progress+=20;}
			$this->data['progress'] = $progress;
		} elseif($this->data['user']['type'] == 'admin' && $this->data['user']['id'] != 1) {
			$this->is_admin = TRUE;
			$this->session->set_flashdata('status.warning', 'You are entering this page AS ADMIN!!');
		} else {
				$this->session->set_flashdata('status.warning', 'User authentication failed!');
				redirect('vendor/auth/logreg');
				return;
		}
	}
}

class API_Controller extends MY_Controller {
	public function __construct(){
		parent::__construct();
		header('Content-type: application/json');
	}
	
}

// END OF MY_Controller.php File