<?php
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 2/23/15
 * Time: 5:42 PM
 * Proj: prod-new
 */ 

function get_cache($key){
	$CI = &get_instance();
	$CI->load->model('cache_model');
	return $CI->cache_model->get_cache($key);
}

function set_cache($key, $data) {
	$CI = &get_instance();
	$CI->load->model('cache_model');
	return $CI->cache_model->set_cache($key, $data);
}