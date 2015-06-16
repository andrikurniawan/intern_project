<?php if(!defined('BASEPATH')) die('Die already!');
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 3/30/15
 * Time: 2:30 PM
 * Proj: prod-new
 */
class MY_Log extends CI_Log{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function custom_log($path, $fields, $data) {
		$path = $this->_log_path."/{$path}/";
		if(!file_exists($path)) {
			@mkdir($path, 0775, TRUE);
		}
		$filepath = $path.'log-'.date('Y-m-d').'.csv';
		
		if(!is_array($data)) {
			show_error('Data must be in array value!');
		}
		
		if(count($fields) != count($data)) {
			show_error('Data is not in the same base as fields!');
		}
		
		$new_file = FALSE;
		$_fields = implode(',',$fields);
		if ( ! file_exists($filepath))
		{
			$new_file = TRUE;
		} else {
			$first_row = trim($this->_get_fields($filepath));
			if($first_row != $_fields) {
				show_error("Data fields are not match with earlier data:<br />{$first_row}<br />{$_fields}");
			}
		}
		
		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}
		
		$_data = ($new_file?$_fields.PHP_EOL:'').implode(',', $data).PHP_EOL;

		flock($fp, LOCK_EX);
		fwrite($fp, $_data);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, FILE_WRITE_MODE);
		return TRUE;
	}
	
	public function get_custom_log($path, $date) {
		$path = $this->_log_path."/{$path}/log-{$date}.csv";
		if(!file_exists($path)) {
			return FALSE;
		}
		$_fields = $this->_get_fields($path);
		$fields = explode(',', $_fields);
		
		$first_row = TRUE;
		
		if ( ! $ft = @fopen($path, FOPEN_READ))
		{
			return FALSE;
		}
		$data = array();
		while(($_data = fgets($ft)) !== FALSE) {
			if(!$first_row)
				$data[] = explode(',',$_data);
			else
				$first_row = TRUE;
		}
		fclose($ft);
		$return = array();
		foreach($data as $dt) {
			$ret = array();
			$cnt = count($fields);
			for($i=0; $i<$cnt;$i++){
				$ret[$fields[$i]] = $dt[$i];
			}
			$return[] = $ret;
		}
		return array(
			'fields'	=> $fields,
			'data'		=> $return
		);
	}
	
	protected function _get_fields($filepath) {
		if ( ! $ft = @fopen($filepath, FOPEN_READ))
		{
			return FALSE;
		}
		$first_row = fgets($ft);
		fclose($ft);
		return $first_row;
	}
}

// END OF MY_Log.php File