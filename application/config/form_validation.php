<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config = array(
    'reg_guru' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        )
    ),
    'reg_guru_detail' => array(
        array(
            'field' => 'recaptcha_response_field',
            'label' => 'lang:recaptcha_field_name',
            'rules' => 'required|callback_check_captcha'
        )
    ),
    'reg_duta_guru' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email|callback_email_check'
        ),
        array(
            'field' => 'pass',
            'label' => 'Password',
            'rules' => 'required|min_length[6]'
        ),
        array(
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required'
        ),
        array(
            'field' => 'alamat',
            'label' => 'Alamat',
            'rules' => 'required'
        ),
        array(
            'field' => 'kota',
            'label' => 'Kota',
            'rules' => 'required'
        ),
        array(
            'field' => 'hp',
            'label' => 'HP',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'required'
        ),
        array(
            'field' => 'tempatlahir',
            'label' => 'Tempat Lahir',
            'rules' => 'required'
        ),
        array(
            'field' => 'tanggal',
            'label' => 'Tanggal Lahir',
            'rules' => 'required'
        ),
        array(
            'field' => 'bulan',
            'label' => 'Bulan Lahir',
            'rules' => 'required'
        ),
        array(
            'field' => 'tahun',
            'label' => 'Tahun Lahir',
            'rules' => 'required'
        ),
        array(
            'field' => 'recaptcha_response_field',
            'label' => 'lang:recaptcha_field_name',
            'rules' => 'required|callback_check_captcha'
        )
    ),
    'reg_murid' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email|callback_email_check'
        ),
        array(
            'field' => 'pass',
            'label' => 'Password',
            'rules' => 'required|min_length[6]'
        ),
        array(
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required'
        ),
        array(
            'field' => 'alamat',
            'label' => 'Alamat',
            'rules' => 'required'
        ),
        array(
            'field' => 'hp',
            'label' => 'HP',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'recaptcha_response_field',
            'label' => 'lang:recaptcha_field_name',
            'rules' => 'required|callback_check_captcha'
        )
    ),
    'request_guru' => array(
	   array(
            'field' => 'recaptcha_response_field',
            'label' => 'lang:recaptcha_field_name',
            'rules' => 'required|callback_check_captcha'
        )
    ),
    'track_request' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'handphone',
            'label' => 'Handphone',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'code',
            'label' => 'Code',
            'rules' => 'required'
        )
    ),
	'request_sidebar' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'telp',
            'label' => 'Telepon',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required'
        ),
	  array(
            'field' => 'request',
            'label' => 'Request',
            'rules' => 'required'
        ),
	  array(
            'field' => 'matpel',
            'label' => 'Matpel',
            'rules' => 'required'
        )
    ),
     'event_registrasi' => array(
	   array(
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required'
        ),
	   array(
            'field' => 'telp',
            'label' => 'Telepon',
            'rules' => 'required'
        ),
	  array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required'
        ),
	   array(
            'field' => 'recaptcha_response_field',
            'label' => 'lang:recaptcha_field_name',
            'rules' => 'required|callback_check_captcha'
        )
    )
);