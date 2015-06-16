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
/////////// HELPER ///////////
include_once(APPPATH.'database/REAL_DB_active_record.php');

/**
 * Active Record Class
 *
 * This is the platform-independent base Active Record implementation class.
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class MY_DB_active_record extends REAL_DB_active_record {
	public function table_fields($table_name, $where = array(), $orwhere = array()) {
		$default = array('Field', 'Type', 'Null', 'Key','Default','Extra');
		$kwhere = $this->_clear_array($where, $default);
		$korwhere = $this->_clear_array($orwhere, $default);
		$sql = $this->_list_fields($table_name, $kwhere, $korwhere);
		return $this->query($sql);
	}
	
	private function _clear_array($array, $default) {
		$k_array = array_diff(array_keys($array), $default);
		foreach($k_array as $k) {
			unset($array[$k]);
		}
		return $array;
	}
	
	public function preserve_parameters() {
		$vars = get_object_vars($this);
		$this->_parameters = $vars;
	}
	
	public function restore_parameters() {
		if( ! empty($this->_parameters))
			foreach($this->_parameters as $param_key => $param_value) {
				$this->{$param_key} = $param_value;
			}
		unset($this->_parameters);
		return;
	}

	/**
	 * Insert
	 *
	 * Compiles an insert string and runs the query
	 *
	 * @param string $table the table to insert data into
	 * @param array  $set   an associative array of insert values
	 *
	 * @return CI_DB_active_record
	 */
	function insert($table = '', $set = NULL, $type='normal')
	{
		if( ! in_array($type, array('normal','update','ignore'))) {
			$type = 'normal';
		}
		if (!is_null($set))
		{
			$this->set($set);
		}

		if (count($this->ar_set) == 0)
		{
			if ($this->db_debug)
			{	
				return $this->display_error('db_must_use_set');
			}
			return FALSE;
		}

		if ($table == '')
		{
			if (!isset($this->ar_from[0]))
			{
				if ($this->db_debug)
				{
					return $this->display_error('db_must_set_table');
				}
				return FALSE;
			}

			$table = $this->ar_from[0];
		}
		
		$sql = '';
		switch($type) {
			case	'update'	:
				$indexes = $this->table_fields($table,array(), array('Key'=>'PRI'))->result();
//				$indexes = $this->table_fields($table,array(), array('Key'=>array('PRI', 'UNI')))->result();
				$index_key = array();
				foreach($indexes as $index) {
					$index_key[] = $index->Field;
				}
				if(empty($index_key)) {
					$indexes = $this->table_fields($table,array(), array('Key'=>'UNI'))->result();
					foreach($indexes as $index) {
						$index_key[] = $index->Field;
					}
				}
				$sql = $this->_insert_on_duplicate_keys_update($this->_protect_identifiers($table, TRUE, NULL, FALSE), array_keys($this->ar_set), array_values($this->ar_set), $index_key);
				break;
			case	'ignore'	:
				$sql = $this->_insert_ignore($this->_protect_identifiers($table, TRUE, NULL, FALSE), array_keys($this->ar_set), array_values($this->ar_set));
				break;
			case	'normal'	:
			default				:
				$sql = $this->_insert($this->_protect_identifiers($table, TRUE, NULL, FALSE), array_keys($this->ar_set), array_values($this->ar_set));
		}
		$this->_reset_write();
		return $this->query($sql);
	}

	// --------------------------------------------------------------------
}

/* End of file DB_active_rec.php */
/* Location: ./system/database/DB_active_rec.php */