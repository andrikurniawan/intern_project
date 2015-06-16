<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 12/19/14
 * Time: 3:49 PM
 * Proj: private-development
 */
class Discount_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
	}

	// max use of diskon:
	// 1. 1x use
	// 2. nx uses
	// 3. unlimited uses	

	// diskon scope:
	// 1. class
	// 2. vendor
	// 3. global

	// table needed:
	// 1. discount_main
	//    a. id
	//    b. code => kode diskon
	//    c. class_id
	//    d. is_public
	//    e. scope => class_id|session_id .. session_id are comma separated, * for all session
	//    f. max_amount
	//    g. start_date
	//    h. expire_date
	// 2. discount_usage: code - used by - used datetime - used for
	//    a. discount_id
	//    b. used_by
	//    c. used_when
	// 3. discount_value
	//    a. discount_id
	//    b. type => percent/nominal
	//    c. value
	
	public function check_code($class, $code) {
		$code = strtoupper($code);
		return !!$this->db->from('discount_main')->where(array('class_id'=> $class, 'code'=>$code))->get()->num_rows();
	}
	
	public function get_discount_id($class, $code) {
		return  $this->db
				->select('id')
				->from('discount_main')
				->where(array('class_id'=> $class, 'code'=>$code))
				->get()->scalar();
	}
	
	public function detail_code($class, $code) {
		$code = strtoupper($code);
		if(!is_array($class)) $class = array($class);
		$diskon = $this->db
//				->select('*')
				->from('discount_main')
				->where_in('class_id', $class)
				->where(array('code'=>$code, 'start_date < '=>date('Y-m-d H:i:s'), 'expire_date > '=>date('Y-m-d H:i:s')))
				->get()->row();
		return $diskon;
	}
	
	public function detail_value($discount_id) {
		$diskon = $this->db
				->from('discount_value')
				->where('discount_id', $discount_id)
				->get()->row();
		return $diskon;
	}
	
	public function check_code_available($class, $code) {
		$code = strtoupper($code);
		$diskon = $this->detail_code($class, $code);
		if(empty($diskon)) return 0;
		$id = $diskon->id;
		$max = (int)$diskon->max_amount;
		
		if($max >= 9990)
			return 9999;
		$usage = (int)$this->db
				->select('COUNT(*) as cnt', FALSE)
				->from('discount_usage')
				->where(array('discount_id'=>$id))
				->get()->row()->cnt;
		return $max - $usage;
	}
	
	public function create_general_discount($var) {
		if($this->db->select('COUNT(*) as cnt', FALSE)->get_where('discount_main', array('code'=>$var['code']))->scalar())
			return FALSE;
		$var['code'] = strtoupper($var['code']);
		$this->db->insert('discount_general', $var);
		return !!$this->db->affected_rows()?$var['code']:FALSE;
	}
	
	public function create_general_discount_condition($var) {
		$var['code'] = strtoupper($var['code']);
		$this->db->insert('discount_general_condition', $var);
		return !!$this->db->affected_rows()?$var['code']:FALSE;
	}
	
	public function use_general_discount($code, $invoice, $user_id, $value, $description) {
		$data = array(
			'discount_code'	=> $code,
			'invoice_code'	=> $invoice,
			'used_by'		=> $user_id,
			'used_when'		=> date('Y-m-d H:i:s'),
			'nominal_value'	=> $value,
			'description'	=> $description
		);
		
		$this->db->insert('discount_general_usage', $data);
		return !!$this->db->affected_rows();
	}

	public function create_diskon($var) {
		$var['main']['code'] = strtoupper($var['main']['code']);
		$this->db->trans_begin();
		$this->db->insert('discount_main', $var['main']);
//		$q = $this->db->last_query();
//		log_message('debug', 'QUERY 1: '.$q);
		$id = $this->db->insert_id();
		$var['value']['discount_id'] = $id;
		$this->db->insert('discount_value', $var['value']);
//		$q = $this->db->last_query();
//		log_message('debug', 'QUERY 2: '.$q);
		if($this->db->trans_status() === FALSE) {
			$id = FALSE;
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
//		$q = $this->db->last_query();
//		log_message('debug', 'QUERY 3: '.$q);
		return $id;
	}
	
	public function use_discount($class, $code, $invoice_code, $user_id, $value = 0) {
		$sisa = $this->check_code_available($class, $code);
		if( $sisa > 0 ) {
			$id = $this->get_discount_id($class, $code);
			$data = array(
				'discount_id'=>$id, 
				'invoice_code'=>$invoice_code, 
				'used_by'=>$user_id,
				'used_when'=>date('Y-m-d H:i:s'),
				'nominal_value'=> $value
			);
			$this->db->insert('discount_usage', $data);
		}
	}
	
	public function get_diskon_code_for_global() {
		
	}
	
	public function get_diskon_code_for_vendor() {
		
	}
	
	public function get_diskon_code_for_class($class, $scope='all') {
		$discount = array();
		if($scope != 'all') $this->db->where('scope', $scope);
		$main = $this->db->from('discount_main')->where(array('class_id'=> $class))->get()->result();
		if(count($main) > 0) {
			foreach($main as $disc) {
				$disc_id = $disc->id;
				$value = $this->db->from('discount_value')->where(array('discount_id'=> $disc_id))->get()->row();
				$usage = $this->db->select('COUNT(*) as cnt', FALSE)->from('discount_usage')->where(array('discount_id'=> $disc_id))->get()->scalar(0);
				$discount[] = array(
						'main'	=> $disc,
						'value' => $value,
						'usage'	=> $usage
				);
			}
		}
		
		return $discount;
	}
	
	public function delete_discount($code, $class) {
		$id =@$this->db->select('id')->where('code', $code)->where('class_id', $class)->get('discount_main')->row()->id;
		if(empty($id)) return FALSE;
		$usage = $this->db->get_where('discount_usage', array('discount_id'=>$id));
		if($usage->num_rows() == 0) {
			$this->db->trans_begin();
			$this->db->query('DELETE FROM discount_value WHERE discount_id = ?', $id);
			$this->db->query('DELETE FROM discount_main WHERE id = ?', $id);
			
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
			} else {
				$this->db->trans_commit();
				return TRUE;
			}
		}
		return FALSE;
	}
	
	public function check_discount_usage_by_invoice_class($class_id, $invoice_code) {
		$query = "
		SELECT
			IF(ISNULL(a.nominal_value), '0', a.nominal_value) AS val
		FROM
			discount_usage a
			RIGHT JOIN discount_main b
				ON a.discount_id = b.id
		WHERE 1
			AND b.class_id = ?
			AND a.invoice_code = ?
		";
		$data = $this->db->query($query,array($class_id, $invoice_code))->row();
		if(!empty($data))
			return $data->val;
		else return 0;
	}
}

// END OF discount_model.php File