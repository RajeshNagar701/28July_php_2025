<?php
if (!function_exists('custome_date')) {

    function custome_date($date, $format)
    {
        $date_formated = date($format, strtotime($date));
        return $date_formated;
    }
}
