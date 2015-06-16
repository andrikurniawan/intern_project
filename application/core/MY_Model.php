<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 10/10/14
 * Time: 3:19 PM
 * Proj: private-development
 */
class MY_Model extends CI_Model{
	
	var $CI;
	public function __construct()
	{
		parent::__construct();
		$this->CI = &get_instance();
	}
}

// END OF MY_Model.php File