<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 1/9/15
 * Time: 10:20 AM
 * Proj: private-development
 */
class Point_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	static function _add_type($type_id) {
		$type = array(
			'ADMIN CONTROL',
			'Auto Register',
			'Manual Register',
			'Daily Login',
			'Media Share',
			'Request Guru',
			
		);
	}
	
	private static function _subtract_type($type_id) {
		$type = array(
			'ADMIN CONTROL',
			'Create Voucher',
			'Goodies',
			'Penalties',
			'ADMIN CONTROL',
		);
	}
	
	public function get_user_point($user_id) {
		
	}
	
	public function add_user_point($user_id, $type, $amount) {
		
	}
	
	public function subtract_user_point($user_id, $type, $amount) {
		
	}
	
	public function check_current_balance($from_date, $to_date) {
		
	}
}

// END OF point_model.php File