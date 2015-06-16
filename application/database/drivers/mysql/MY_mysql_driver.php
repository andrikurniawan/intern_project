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
if( ! class_exists('CI_DB_mysql_driver'))
	require_once(BASEPATH.'database/drivers/'.$params['dbdriver'].'/'.$params['dbdriver'].'_driver.php');
/**
 * MySQL Database Adapter Class
 *
 * Note: _DB is an extender class that the app controller
 * creates dynamically based on whether the active record
 * class is being used or not.
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class MY_DB_mysql_driver extends CI_DB_mysql_driver {

	/**
	 * Insert Ignore statement
	 *
	 * Generates a platform-specific insert string from the supplied data
	 *
	 * @access	public
	 * @param	string	the table name
	 * @param	array	the insert keys
	 * @param	array	the insert values
	 * @return	string
	 */
	function _insert_ignore($table, $keys, $values)
	{
		return "INSERT IGNORE INTO ".$table." (".implode(', ', $keys).") VALUES (".implode(', ', $values).")";
	}

	// --------------------------------------------------------------------

	/**
	 * "Insert On Duplicate Keys Update" statement
	 *
	 * @access	public
	 * @param	string	the table name
	 * @param	array	the insert keys
	 * @param	array	the insert values
	 * @param	array	the index keys
	 * @return	string
	 */
	function _insert_on_duplicate_keys_update($table, $keys, $values, $index_keys)
	{
		$set = array();
		for($i=0,$max = count($keys); $i<$max; $i++) {
			if(in_array(trim($keys[$i],'`'), $index_keys)) continue;
			else $set[] = " {$keys[$i]} = {$values[$i]}";
		}
		return "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES (".implode(', ', $values).")"
				. " ON DUPLICATE KEYS UPDATE ".implode(', ', $set);
				;
	}
	
	public function _list_fields($table='', $where=array(), $orwhere=array()) {
		$query = "SHOW FIELDS\nFROM `{$table}`";
		if(!empty($where) || !empty($orwhere)) {
			$query .= "\nWHERE 1\n";
			foreach($where as $fields => $value) {
				if(is_array($value)) {
					foreach($value as $val) {
						$query .= "AND `{$fields}` = '{$val}'\n";
					}
				} else {
					$query .= "AND `{$fields}` = '{$value}'\n";
				}
			}
			if(!empty($orwhere)) {
				$query .= "AND ( FALSE\n";
				foreach($orwhere as $fields => $value) {
					if(is_array($value)) {
						foreach($value as $val) {
							$query .= "OR `{$fields}` = '{$val}'\n";
						}
					} else {
						$query .= "OR `{$fields}` = '{$value}'\n";
					}
				}
				$query .= ")";
			}
		}
		return $query;
	}

}


/* End of file mysql_driver.php */
/* Location: ./system/database/drivers/mysql/mysql_driver.php */