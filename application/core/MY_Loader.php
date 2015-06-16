<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 1/13/15
 * Time: 1:30 PM
 * Proj: private-development
 */
class MY_Loader extends CI_Loader{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function database($params = '', $return = FALSE, $active_record = NULL)
	{
		// Grab the super object
		$CI =& get_instance();

		// Do we even need to load the database class?
		if (class_exists('CI_DB') AND $return == FALSE AND $active_record == NULL AND isset($CI->db) AND is_object($CI->db))
		{
			return FALSE;
		}

		// modified
		log_message('debug', 'Attempting to load Extended DB class');
		$source = APPPATH.'database/'.config_item('subclass_prefix').'DB'.EXT;
		log_message('debug', $source);
		if(file_exists($source)) {
			log_message('debug', "Loading file: {$source}");
			require_once($source);
		}else{
			log_message('debug', "Failed to load Extended DB Class. Loading System DB Class");
			require_once(BASEPATH.'database/DB.php');
		}

		$db =& DB($params, $active_record);
		
		if ($return === TRUE)
		{
			return DB($params, $active_record);
		}

		// Initialize the db variable.  Needed to prevent
		// reference errors with some configurations
		$CI->db = '';

		// Load the DB class
		$CI->db =& DB($params, $active_record);
	}

	// --------------------------------------------------------------------


}

// END OF MY_Loader.php File