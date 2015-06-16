<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class custom {

    function link_to_anchor($str) {
        return preg_replace('/(http:\/\/)([\w.\/]*)/', '<a href="\1\2" target="_blank">\2</a>', $str);
    }

    function get_age($birthday) {
        list($year, $month, $day) = explode("-", $birthday);
        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0)
            $year_diff--;
        return $year_diff;
    }

}

?>