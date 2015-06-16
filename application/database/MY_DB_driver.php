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

if( ! class_exists('CI_DB_driver'))
	require_once(BASEPATH.'database/DB_driver.php');

/**
 * Database Driver Class
 *
 * This is the platform-independent base DB implementation class.
 * This class will not be called directly. Rather, the adapter
 * class for the specific database will extend and instantiate it.
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class MY_DB_driver extends CI_DB_driver{

	public function __construct($params=array()) {
		parent::__construct($params);
		log_message('debug', 'Extended DB Driver has been loaded');
	}
	
	/**
	 * Execute the query
	 *
	 * Accepts an SQL string as input and returns a result object upon
	 * successful execution of a "read" type query.  Returns boolean TRUE
	 * upon successful execution of a "write" type query. Returns boolean
	 * FALSE upon failure, and if the $db_debug variable is set to TRUE
	 * will raise an error.
	 *
	 * @access	public
	 * @param	string	An SQL query string
	 * @param	array	An array of binding data
	 * @return	mixed
	 */
	function query($sql, $binds = FALSE, $return_object = TRUE)
	{
		if ($sql == '')
		{
			if ($this->db_debug)
			{
				log_message('error', 'Invalid query: '.$sql);
				return $this->display_error('db_invalid_query');
			}
			return FALSE;
		}

		// Verify table prefix and replace if necessary
		if ( ($this->dbprefix != '' AND $this->swap_pre != '') AND ($this->dbprefix != $this->swap_pre) )
		{
			$sql = preg_replace("/(\W)".$this->swap_pre."(\S+?)/", "\\1".$this->dbprefix."\\2", $sql);
		}

		// Is query caching enabled?  If the query is a "read type"
		// we will load the caching class and return the previously
		// cached query if it exists
		if ($this->cache_on == TRUE AND stristr($sql, 'SELECT'))
		{
			if ($this->_cache_init())
			{
				$this->load_rdriver();
				if (FALSE !== ($cache = $this->CACHE->read($sql)))
				{
					return $cache;
				}
			}
		}

		// Compile binds if needed
		if ($binds !== FALSE)
		{
			$sql = $this->compile_binds($sql, $binds);
		}

		// Save the  query for debugging
		if ($this->save_queries == TRUE)
		{
			$this->queries[] = $sql;
		}

		// Start the Query Timer
		$time_start = list($sm, $ss) = explode(' ', microtime());

		// Run the Query
		if (FALSE === ($this->result_id = $this->simple_query($sql)))
		{
			if ($this->save_queries == TRUE)
			{
				$this->query_times[] = 0;
			}

			// This will trigger a rollback if transactions are being used
			$this->_trans_status = FALSE;

			if ($this->db_debug)
			{
				// grab the error number and message now, as we might run some
				// additional queries before displaying the error
				$error_no = $this->_error_number();
				$error_msg = $this->_error_message();

				// We call this function in order to roll-back queries
				// if transactions are enabled.  If we don't call this here
				// the error message will trigger an exit, causing the
				// transactions to remain in limbo.
				$this->trans_complete();

				// Log and display errors
				log_message('error', 'Query error: '.$error_msg);
				return $this->display_error(
										array(
												'Error Number: '.$error_no,
												$error_msg,
												$sql
											)
										);
			}

			return FALSE;
		}

		// Stop and aggregate the query time results
		$time_end = list($em, $es) = explode(' ', microtime());
		$this->benchmark += ($em + $es) - ($sm + $ss);

		if ($this->save_queries == TRUE)
		{
			$this->query_times[] = ($em + $es) - ($sm + $ss);
		}

		// Increment the query counter
		$this->query_count++;

		// Was the query a "write" type?
		// If so we'll simply return true
		if ($this->is_write_type($sql) === TRUE)
		{
			// If caching is enabled we'll auto-cleanup any
			// existing files related to this particular URI
			if ($this->cache_on == TRUE AND $this->cache_autodel == TRUE AND $this->_cache_init())
			{
				$this->CACHE->delete();
			}

			return TRUE;
		}

		// Return TRUE if we don't need to create a result object
		// Currently only the Oracle driver uses this when stored
		// procedures are used
		if ($return_object !== TRUE)
		{
			return TRUE;
		}

		// Load and instantiate the result driver

		$driver			= $this->load_rdriver();
		$RES			= new $driver();
		$RES->conn_id	= $this->conn_id;
		$RES->result_id	= $this->result_id;

		if ($this->dbdriver == 'oci8')
		{
			$RES->stmt_id		= $this->stmt_id;
			$RES->curs_id		= NULL;
			$RES->limit_used	= $this->limit_used;
			$this->stmt_id		= FALSE;
		}

		// oci8 vars must be set before calling this
		$RES->num_rows	= $RES->num_rows();

		// Is query caching enabled?  If so, we'll serialize the
		// result object and save it to a cache file.
		if ($this->cache_on == TRUE AND $this->_cache_init())
		{
			// We'll create a new instance of the result object
			// only without the platform specific driver since
			// we can't use it with cached data (the query result
			// resource ID won't be any good once we've cached the
			// result object, so we'll have to compile the data
			// and save it)
			if(file_exists(APPPATH.'database/'.config_item('subclass_prefix').'DB_result.php')) {
				$class = config_item('subclass_prefix').'DB_result';
				$CR = new $class();
			} else {
				$CR = new CI_DB_result();
			}
			$CR->num_rows		= $RES->num_rows();
			$CR->result_object	= $RES->result_object();
			$CR->result_array	= $RES->result_array();

			// Reset these since cached objects can not utilize resource IDs.
			$CR->conn_id		= NULL;
			$CR->result_id		= NULL;

			$this->CACHE->write($sql, $CR);
		}

		return $RES;
	}

	// --------------------------------------------------------------------

	/**
	 * Load the result drivers
	 *
	 * @access	public
	 * @return	string	the name of the result class
	 */
	function load_rdriver()
	{
		$driver = config_item('subclass_prefix').'DB_'.$this->dbdriver.'_result';

		if( ! class_exists($driver))
		{
			$ext_result = APPPATH.'database/'.config_item('subclass_prefix').'DB_result.php';
			if(file_exists($ext_result)) {
				include_once($ext_result);
			}
	
			$ext_driver_path = APPPATH.'database/drivers/'.$this->dbdriver.'/'.config_item('subclass_prefix').$this->dbdriver.'_result.php';
			if(file_exists($ext_driver_path)) {
				include_once($ext_driver_path);
			}
		}
		
		// return to default if not exists

		if ( ! class_exists($driver))
		{
			include_once(BASEPATH.'database/DB_result.php');
			include_once(BASEPATH.'database/drivers/'.$this->dbdriver.'/'.$this->dbdriver.'_result.php');
			$driver = 'CI_DB_'.$this->dbdriver.'_result';
		}
		return $driver;
	}

	// --------------------------------------------------------------------

	public function insert_on_duplicate_keys_update($table, $data, $index_keys) {
		$fields = array();
		$values = array();

		foreach ($data as $key => $val)
		{
			$fields[] = $this->_escape_identifiers($key);
			$values[] = $this->escape($val);
		}

		return $this->_insert_on_duplicate_keys_update($this->_protect_identifiers($table, TRUE, NULL, FALSE), $fields, $values, $index_keys);
	}
}


/* End of file DB_driver.php */
/* Location: ./system/database/DB_driver.php */
