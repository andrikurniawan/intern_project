<?php
/**
 * Created by :
 *
 * User: AndrewMalachel
 * Date: 11/10/14
 * Time: 3:38 PM
 * Proj: private-development
 */

if(!function_exists('arr_uniq')) {
	function arr_uniq($array) {
		return array_merge(array_flip(array_flip($array)));
	}
}

if(!function_exists('url_title_2')) {
	function url_title_2($url) {
		$url = preg_replace('/[^a-z0-9]/','-', strtolower($url));
		$url = str_replace('--', '-', $url);
		return $url;
	}
}

if(!function_exists('mime_content_type')) {

	function mime_content_type($filename) {

		$mime_types = array(

			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',

			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',

			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',

			// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',

			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',

			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',

			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);

		$ext = strtolower(array_pop(explode('.',$filename)));
		if (array_key_exists($ext, $mime_types)) {
			return $mime_types[$ext];
		}
		elseif (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$mimetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			return $mimetype;
		}
		else {
			return 'application/octet-stream';
		}
	}
}

function alphanumeric($type = 'all', $case = 0){
	$case = (int)$case;
	$alphanum = NULL;
	switch($type){
		case 'safe':
			if($case < 0)
				$alphanum = 'abcdefghijkmnpqrtuvwxyz23456789';
			elseif($case > 0) 
				$alphanum = '23456789ABCDEFGHJKLMNPQRSTUVWXY';
			else
				$alphanum = 'abcdefghijkmnpqrtuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXY';
			break;
		case 'hex':
			$alphanum = '0123456789ABCDEF';
			break;
		case 'alphabet':
			$alphanum = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		case 'numeric':
			$alphanum = '0123456789';
			break;
		case 'all':
			$alphanum = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			break;
		default:
			$alphanum = FALSE;
	}
	return $case!==0?($case < 0?strtolower($alphanum):strtoupper($alphanum)):$alphanum;
}

function hashgenerator($length = 20, $type = 'all', $case = 0){
	$alphanum = alphanumeric($type, $case);
	$i = 0;
	$char = '';
	$chars = '';
	while(strlen($char) < $length){
		$ke = mt_rand(0, strlen($alphanum)-1);
		$c = substr($alphanum, $ke, 1);
		$char .= $c;
		if(strlen($char) % 4 == 1) $chars .= ' ';
		$chars .= $c;
	}
	return array($char, trim($chars));
}

function rupiah_format ($number) {
	return 'Rp '.number_format($number,0,',','.').',-';
}

function double_digit($number) {
	$number = (int) $number;
	if($number < 10) {
		$number = '0'.((string)$number);
	}
	return (string)$number;
}

function unique_generator() {
	$CI = &get_instance();
	$q = 'SELECT CONCAT(UPPER(SHA1(UUID())),UPPER(SHA1(FLOOR(RAND()*10000000000)*FLOOR(RAND()*10000000000)))) as code';
	return $CI->db->query($q)->row()->code;
}

function krg() {
	echo "<strong>Kelas.</strong>Ruangguru.com";
}

function kls_url() {
	$base_url = base_url();
	if(strpos($_SERVER['HTTP_HOST'],'kelas.') === FALSE) $base_url = 'http:';
}

function create_pdf($html, $filepath='', $return=TRUE, $delete_old=FALSE) {
	$CI = &get_instance();
	$CI->load->library('dompdf');
	$CI->load->helper('file');
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
//	$CI->dompdf->load_html($html);
	$dompdf->render();
//	$CI->dompdf->render();
	$data = $dompdf->output();
	if(!empty($filepath)) {
		$filepath = array_shift(explode('.pdf', $filepath));
		if(file_exists($filepath.'.pdf') && $delete_old) {
			@unlink($filepath.'.pdf');
		}
		write_file($filepath.'.pdf', $data);
	}
	if($return) {
		return $data;
	}
	return;
}

function custom_log($type, $data) {
	static $_log;

	if(!is_array($data)) $data = (array)$data;
	$_fields = $_data = array();
	
	foreach($data as $k => $v) {
		$_fields[] = $k;
		$_data[] = $v;
	}
	$_log =& load_class('Log');
	$_log->custom_log($type, $_fields, $_data);
}

function get_custom_log($type, $log_time) {
	static $_log;

	$_log =& load_class('Log');
	return $_log->get_custom_log($type, $log_time);
}

function get_my_isp($ip) {
	$cu = curl_init('http://www.whoismyisp.org/ip/'.$ip);
	curl_setopt($cu, CURLOPT_RETURNTRANSFER, TRUE);
	$page = curl_exec($cu);
	curl_close($cu);
	
	preg_match('/\<h1\>(.*)\<\/h1\>/', $page, $search);
	return empty($search[1])?'Not Defined!':$search[1];
}

if(!function_exists('multiexplode')) {
	function multiexplode ($delimiters,$string) {
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
}
