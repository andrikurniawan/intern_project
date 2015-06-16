<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Database Result Class
 *
 * This is the platform-independent result class.
 * This class will not be called directly. Rather, the adapter
 * class for the specific database will extend and instantiate it.
 *
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
if( ! class_exists('CI_DB_result'))
	include_once(BASEPATH.'database/DB_result.php');

class MY_DB_result extends CI_DB_result {
	
	/**
	 * Constructor.  Accepts one parameter containing the database
	 * connection settings.
	 *
	 * @param array
	 */
	function __construct()
	{
		log_message('debug', 'Extended Database Driver Class Initialized');
	}
	

	public function single($type, $default = FALSE) {
		$result = $this->result($type);
		if(count($result) === 1) {
			array_merge($result);
			return $result[0];
		}
		return $default;
	}
	
	public function scalar($default = NULL) {
		$row = $this->row_array(0);
		$result = array_shift($row);
		if(empty($result)) $result = $default;
		return $result;
	}
	
	public function col_array($field = NULL) {
		if(empty($field)) {
			$result = $this->result_array();
			$data = array();
			foreach($result as $rslt) {
				$data[] = array_shift($rslt);
			}
			return $data;
		} else {
			$result = $this->result();
			$data = array();
			foreach($result as $rslt) {
				if(!empty($rslt->{$field}))
					$data[] = $rslt->{$field};
				else $data[] = 0;
			}
			return $data;
		}
	}

}
// END DB_result class

/* End of file DB_result.php */
/* Location: ./system/database/DB_result.php */
