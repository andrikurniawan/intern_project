<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 4/9/15
 * Time: 9:45 AM
 * Proj: prod-new
 */
class Feedback_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_questions() {
		$query = "
		SELECT
			COUNT(*) AS cnt,
			from_type,
			to_type
		FROM
			feedback_question_new
		WHERE 1
		GROUP BY from_type, to_type";
		return $this->db->query($query)->result();
	}
	
	public function get_question($code = NULL, $taken = FALSE) {
		
		$where = '';
		if(!empty($code))
			$where .= "			AND a.code = ?
";
		if($taken === FALSE)
			$where .= "			AND a.taken IS NULL
";
		if(strtoupper($taken) === 'ONLY')
			$where .= "			AND a.taken IS NOT NULL
";
		$query = "
		SELECT
			a.*,
			b.id,
			b.type,
			b.question,
			b.title,
			b.sort
		FROM
			feedback a
			LEFT JOIN feedback_question_new b
				ON b.from_type = a.from_type AND b.to_type = a.to_type
		WHERE 1
{$where}
		ORDER BY b.sort ASC
		";
		return $this->db->query($query, $code)->result();
	}
	
	public function check_created($from_type, $from_id, $to_type, $to_id) {
		$this->db->where('from_type', $from_type);
		$this->db->where('from_id', $from_id);
		$this->db->where('to_id', $to_id);
		$this->db->where('to_type', $to_type);
		
		return !!$this->db->get('feedback')->num_rows();
	}
	
	public function get_detail_question($from, $to) {
		$where = 
"			AND from_type = ?
			AND to_type = ?
";
		$query = "
		SELECT
			*
		FROM
			feedback_question_new
		WHERE 1
{$where}
		ORDER BY sort ASC
		";
		return $this->db->query($query, array($from, $to))->result();
	}
	
	public function create_feedback($from_type, $from_id, $to_type, $to_id, $code = NULL) {
		if(empty($code) || strlen($code) < 40)
			$code = hashgenerator(40)[0];
		$insert = array(
			'code'			=> $code,
			'from_type'		=> $from_type,
			'from_id'		=> $from_id,
			'to_type'		=> $to_type,
			'to_id'			=> $to_id
		);
		$this->db->insert('feedback', $insert);
		return $code;
	}
	
	public function get_usertype() {
		return $this->db->get('feedback_user_type')->result();
	}
	
	public function create_question($from_type, $to_type, $type, $title, $question, $sort = NULL) {
		if(!in_array($type, array('rate','text','both'))) $type = 'both';
		if(empty($sort)) {
			$max = $this->db->query('
			SELECT 
				MAX(sort) as srt 
			FROM feedback_question_new 
			WHERE from_type = ? AND to_type = ?',
			array($from_type, $to_type))->row()->srt;
			if(empty($max)) $max = 0;
			$sort = ((int) $max)+1;
		}
		$this->db->insert('feedback_question_new', array(
			'from_type'			=> $from_type,
			'to_type'			=> $to_type,
			'type'				=> $type,
			'title'				=> $title,
			'question'			=> $question,
			'sort'				=> $sort
		));
		return $this->db->insert_id();
	}
	
	public function delete_question($id) {
		$this->db->delete('feedback_question_new', array('id'=>$id));
	}
	
	public function update_question($id, $type, $title, $question, $sort = NULL) {
		$data = array(
			'type'				=> $type,
			'title'				=> $title,
			'question'			=> $question,
		);
		if(!empty($sort) && is_int($sort)) $data['sort'] = $sort;
		$this->db->update('feedback_question_new', $data, array(
			'id'				=> $id
		));
		return !! $this->db->affected_rows();
	}
	
	public function answer_question($data) {
		$feedback = $this->db->get_where('feedback', array('code'=>$data['code']))->row();
		if(empty($feedback)) {
			$this->CI->session->set_flashdata('status.warning', 'Kode feedback yang anda masukan salah!');
			return FALSE;
		}
		$question = $this->db->get_where('feedback_question_new', array('id'=>$data['question_id']))->row();
		if(empty($feedback) || $question->from_type != $feedback->from_type || $question->to_type != $feedback->to_type) {
			$this->CI->session->set_flashdata('status.warning', 'Feedback yang anda masukan salah!');
			return FALSE;
		}
		$this->db->insert('feedback_value', $data);
		return TRUE;
	}
	
	public function mark_done($code) {
		$this->db->update('feedback', array('taken'=>date('Y-m-d H:i:s')), array('code'=>$code));
	}
	
	public function get_feedback_value( $from_type, $to_type, $from_id = NULL, $to_id = NULL ) {
		$responses = $this->get_feedback_response($from_type, $to_type, $from_id, $to_id);
		if(empty($responses)) return NULL;
		$resp = array();
		foreach($responses as $response) {
			$code = $response->code;
			$data = $this->db->where('code', $code)->get('feedback_value');
			if($data->num_rows() == 0) {
				continue;
			}
			foreach($data->result() as $rslt) {
				$resp[$code][] = (object) array_merge((array) $response, (array) $rslt);
			}
//			$test_data = (object) array_merge((array) $response, (array) $data->result());
//			$resp[$code] = $test_data;// $data->result();
		}
		return $resp;
	}
	
	public function get_feedback_response($from_type, $to_type, $from_id = NULL, $to_id = NULL ) {
		if(!empty($from_id)) $this->db->where('from_id', $from_id);
		if(!empty($to_id)) $this->db->where('to_id', $to_id);

		$responses =  $this->db
//				->select('code')
				->from('feedback')
				->where('from_type', $from_type)
				->where('to_type', $to_type)
				->get()->result();
		return $responses;
	}

	public function get_review($from_type, $to_type, $from_id = NULL, $to_id = NULL) {
		if(!empty($from_id)) $this->db->where('from_id', $from_id);
		if(!empty($to_id)) $this->db->where('to_id', $to_id);

		$this->db->join('murid','murid.murid_id=feedback.from_id');
		$this->db->join('feedback_value','feedback_value=feedback.code');
		$this->db->where(array('from_type'=>$from_type, 'to_type'=>$to_type));
		$this->db->where('taken IS NOT NULL', null, false);
		return $this->db->get('feedback');
	}

	public function get_class_review($class_id) {
		return $this->get_feedback_response(9,6,NULL, $class_id);
	}
	
	public function get_class_curated_review($class_id) {
		
	}
	
	public function get_rating($from_type, $to_type, $from_id = NULL, $to_id = NULL) {
		if(!empty($from_id)) $this->db->where('from_id', $from_id);
		if(!empty($to_id)) $this->db->where('to_id', $to_id);
		
		$this->db->select_sum('answer_rate_value', 'rate');
		$this->db->select('COUNT(*) AS counter', FALSE);
		$this->db->join('feedback_value','feedback_value=feedback.code');
		$this->db->where(array('from_type'=>$from_type, 'to_type'=>$to_type));
		$this->db->where('answer_rate_value IS NOT NULL', null, false);
		return $this->db->get('feedback');
	}

	public function get_arr_class_rating($arr_class) {
		$this->db->select_sum('answer_rate_value', 'rate');
		$this->db->select('COUNT(*) AS counter', FALSE);
		$this->db->join('feedback_value','feedback_value.code=feedback.code');
		$this->db->where(array('from_type'=>6, 'to_type'=>9));
		$this->db->where_in('to_id', $arr_class);
		$this->db->where('answer_rate_value IS NOT NULL', null, false);
		return $this->db->get('feedback');
	}

	public function _get_arr_class_review($arr_class) {
		$this->db->join('feedback_value','feedback_value.code=feedback.code');
		$this->db->join('vendor_class_student','vendor_class_student.id=from_id');
		$this->db->join('vendor_class','vendor_class.id=to_id');
		$this->db->where(array('from_type'=>6, 'to_type'=>9));
		$this->db->where_in('to_id', $arr_class);
		$this->db->where('answer_desc IS NOT NULL', null, false);
		return $this->db->get('feedback');
	}
	
	public function get_arr_class_review($arr_class) {
		if(empty($arr_class)) return array();
		$classes = implode(',',$arr_class);
		$query = "
SELECT 
	a.*,
	b.id, 
	b.answer_title, 
	b.answer_desc, 
	c.answer_rate_value,
	d.*,
	e.*
FROM `feedback` a
	LEFT JOIN `feedback_value` b ON b.code = a.code
	LEFT JOIN `feedback_value` c ON c.code = b.code
	LEFT JOIN `vendor_class_student` d ON d.id = a.from_id
	LEFT JOIN `vendor_class` e ON e.id = a.to_id
WHERE 1
	AND a.from_type = 6
	AND a.to_type = 9
	AND b.answer_title IS NOT NULL 
	AND b.answer_desc IS NOT NULL 
	AND c.answer_rate_value IS NOT NULL
	AND a.to_id IN ({$classes})";
		return $this->db->query($query);
	}
	
	public function get_user_rate_review($code) {
		$rate_val = $this->db->select('answer_rate_value')->from('feedback_value')->where('code', 
				$code)->where('question_id',2)->get()->row();
		return empty($rate_val)?0:$rate_val->answer_rate_value;
	}

	public function get_class_testimonial($class_id) {
		/*$this->db->join('feedback_value','feedback_value.code=feedback.code');
		$this->db->join('murid','murid.murid_id=from_id');
		$this->db->where(array('from_type'=>6, 'to_type'=>9));
		$this->db->where('to_id', $class_id);
		$this->db->where('answer_desc IS NOT NULL', null, false);
		return $this->db->get('feedback');*/
		$query =
			"SELECT *
			FROM `feedback` f 
				JOIN `vendor_class_student` s ON s.id = f.from_id 
				JOIN `feedback_value` fv ON fv.code = f.code
			LEFT JOIN (
				SELECT 
					fv2.answer_rate_value, 
					f2.code
				FROM `feedback` f2 
					JOIN `feedback_value` fv2 ON fv2.code = f2.code
				WHERE 1
					AND answer_rate_value IS NOT NULL
					AND fv2.question_id = 2) r ON r.code = f.code
			WHERE 1
				AND (answer_desc IS NOT NULL OR answer_title IS NOT NULL)
				AND fv.question_id = 1
				AND to_id = ?" ;
		return $this->db->query($query, $class_id);
	}
	
	public function sort_question($from, $to, $id, $sort) {
		$this->db->update('feedback_question_new', 
				array(
						'sort'		=>$sort
				), 
				array(
						'from_type'	=> $from,
						'to_type'	=> $to,
						'id'		=> $id
				)
		);
	}
}

// END OF feedback_model.php File