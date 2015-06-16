<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 2/23/15
 * Time: 5:42 PM
 * Proj: prod-new
 */
class Cache_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function set_cache($key, $data, $interval = FALSE) {
		if(empty($interval)) $interval = 60 * 60 * 24 * 7;
		$serialized = serialize($data);
		$compressed = gzcompress($serialized);
		$this->db->delete('cache', array('key'=>$key));
		$expire = time() + $interval;
		$this->db->insert('cache', array(
			'key'				=> $key,
//			'data_serialized'	=> $serialized,
			'data_compressed'	=> $compressed,
			'interval'			=> $interval,
			'expire'			=> date('Y-m-d H:i:s', $expire),
		));
	}
	public function get_cache($key) {
		$this->clear_expire();
		$data = $this->db->query('
		SELECT
			*
		FROM cache
		WHERE 1
			AND `key` = ?', $key);
		if($data->num_rows() == 0) return FALSE;
//		return unserialize($data->row()->data_serialized);
		$row = $data->row();
		$return = unserialize(gzuncompress($row->data_compressed));
		$interval = $row->interval;
		$expire = date('Y-m-d H:i:s', time() + $interval);
		$this->db->simple_query("UPDATE `cache` SET `expire` = '{$expire}' WHERE `key` = '{$key}'");
		return $return;
	}
	
	public function clear_expire() {
		$this->db->simple_query('DELETE FROM `cache` WHERE UNIX_TIMESTAMP(expire) < UNIX_TIMESTAMP(NOW())');
	}
	
}

// END OF cache_model.php File