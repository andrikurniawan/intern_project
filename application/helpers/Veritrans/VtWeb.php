<?php

class Veritrans_VtWeb {

  public static function getRedirectionUrl($params)
  {
    $payloads = array(
        'payment_type' => 'vtweb',
        'vtweb' => array(
          // 'enabled_payments' => array('credit_card'),
          'credit_card_3d_secure' => Veritrans_Config::$is3ds
        )
      );

    if (array_key_exists('item_details', $params)) {
      $gross_amount = 0;
//	 var_dump($params);
//	$gross_amount += $params['item_details']['quantity'] * $params['item_details']['price'];
     foreach ($params['item_details'] as $key => $item) {
//	  var_dump($item);		
       $gross_amount += $item['quantity'] * $item['price'];
     }
      $payloads['transaction_details']['gross_amount'] = $gross_amount;
    }
//    var_dump($payloads);
 //   exit;

    $payloads = array_replace_recursive($payloads, $params);

    if (Veritrans_Config::$isSanitized) {
      Veritrans_Sanitizer::jsonRequest($payloads);
    }
//var_dump($payloads);exit;
    $result = Veritrans_ApiRequestor::post(
        Veritrans_Config::getBaseUrl() . '/charge',
        Veritrans_Config::$serverKey,
        $payloads);

    return $result->redirect_url;
  }
}
