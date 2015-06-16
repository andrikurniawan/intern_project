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
 * Initialize the database
 *
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 * @param 	string
 * @param 	bool	Determines if active record should be used or not
 */
function &DB($params = '', $active_record_override = NULL)
{
	// Load the DB config file if a DSN string wasn't passed
	if (is_string($params) AND strpos($params, '://') === FALSE)
	{
		// Is the config file in the environment folder?
		if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))
		{
			if ( ! file_exists($file_path = APPPATH.'config/database.php'))
			{
				show_error('The configuration file database.php does not exist.');
			}
		}

		include($file_path);

		if ( ! isset($db) OR count($db) == 0)
		{
			show_error('No database connection settings were found in the database config file.');
		}

		if ($params != '')
		{
			$active_group = $params;
		}

		if ( ! isset($active_group) OR ! isset($db[$active_group]))
		{
			show_error('You have specified an invalid database connection group.');
		}

		$params = $db[$active_group];
	}
	elseif (is_string($params))
	{

		/* parse the URL from the DSN string
		 *  Database settings can be passed as discreet
		 *  parameters or as a data source name in the first
		 *  parameter. DSNs must have this prototype:
		 *  $dsn = 'driver://username:password@hostname/database';
		 */

		if (($dns = @parse_url($params)) === FALSE)
		{
			show_error('Invalid DB Connection String');
		}

		$params = array(
							'dbdriver'	=> $dns['scheme'],
							'hostname'	=> (isset($dns['host'])) ? rawurldecode($dns['host']) : '',
							'username'	=> (isset($dns['user'])) ? rawurldecode($dns['user']) : '',
							'password'	=> (isset($dns['pass'])) ? rawurldecode($dns['pass']) : '',
							'database'	=> (isset($dns['path'])) ? rawurldecode(substr($dns['path'], 1)) : ''
						);

		// were additional config items set?
		if (isset($dns['query']))
		{
			parse_str($dns['query'], $extra);

			foreach ($extra as $key => $val)
			{
				// booleans please
				if (strtoupper($val) == "TRUE")
				{
					$val = TRUE;
				}
				elseif (strtoupper($val) == "FALSE")
				{
					$val = FALSE;
				}

				$params[$key] = $val;
			}
		}
	}

	// No DB specified yet?  Beat them senseless...
	if ( ! isset($params['dbdriver']) OR $params['dbdriver'] == '')
	{
		show_error('You have not selected a database type to connect to.');
	}

	// Load the DB classes.  Note: Since the active record class is optional
	// we need to dynamically create a class that extends proper parent class
	// based on whether we're using the active record class or not.
	// Kudos to Paul for discovering this clever use of eval()

	if ($active_record_override !== NULL)
	{
		$active_record = $active_record_override;
	}
	
	log_message('debug', "Attempting to load Extended DB Driver");
	$extend_driver_path = APPPATH.'database/'.config_item('subclass_prefix').'DB_driver.php';
	$extend_driver = FALSE;
	if(file_exists($extend_driver_path)) {
		log_message('debug', "Loading: {$extend_driver_path}");
		require_once($extend_driver_path);
		$extend_driver = TRUE;
	}
	else {
		log_message('debug', "Failed to load Extended DB Driver. Reverting back to System");
		require_once(BASEPATH.'database/DB_driver.php');
	}
	
	if ( ! isset($active_record) OR $active_record == TRUE)
	{
		log_message('debug', 'Attempting to load Extended DB Active Record File');
		$custom_ar_path = APPPATH.'database/'.config_item('subclass_prefix').'DB_active_rec.php';
		$custom_ar = FALSE;
		if(file_exists($custom_ar_path)) {
			log_message('debug', "Loading : {$custom_ar_path}");
			require_once($custom_ar_path);
			$custom_ar = TRUE;
		}
		else {
			log_message('debug', 'Failed to load Extended DB Active Record File');
			require_once(BASEPATH.'database/DB_active_rec.php');
		}

		if ( ! class_exists('CI_DB'))
		{
			if($custom_ar)
				eval('class CI_DB extends '.config_item('subclass_prefix').'DB_active_record { }');
			else
				eval('class CI_DB extends CI_DB_active_record { }');
		}
	}
	else
	{
		if ( ! class_exists('CI_DB'))
		{
			if($extend_driver)
				eval('class CI_DB extends '.config_item('subclass_prefix').'DB_driver { }');
			else
				eval('class CI_DB extends CI_DB_driver { }');
		}
	}

	log_message('debug', 'Attempting to load Extended '.$params['dbdriver'].' DB Driver File');
	$ext_base_driver = APPPATH.'database/drivers/'.$params['dbdriver'].'/'.config_item('subclass_prefix').$params['dbdriver'].'_driver.php';
	$base_driver = BASEPATH.'database/drivers/'.$params['dbdriver'].'/'.$params['dbdriver'].'_driver.php';
	log_message('debug', $ext_base_driver);
	if(file_exists($ext_base_driver)) {
		log_message('debug', 'Loading: '.$ext_base_driver);
		require_once($ext_base_driver);
		$driver = config_item('subclass_prefix').'DB_'.$params['dbdriver'].'_driver';
	} else {
		log_message('debug', 'Failed to load Extended '.$params['dbdriver'].' DB Driver File');
		require_once($base_driver);
		$driver = 'CI_DB_'.$params['dbdriver'].'_driver';
	}

	// Instantiate the DB adapter
	log_message('debug', 'Using Driver: '.$driver);
	$DB = new $driver($params);

	if ($DB->autoinit == TRUE)
	{
		$DB->initialize();
	}

	if (isset($params['stricton']) && $params['stricton'] == TRUE)
	{
		$DB->query('SET SESSION sql_mode="STRICT_ALL_TABLES"');
	}

	return $DB;
}



/* End of file DB.php */
/* Location: ./system/database/DB.php */