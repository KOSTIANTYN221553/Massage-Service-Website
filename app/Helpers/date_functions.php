<?php

if(!function_exists("getLastWeekInfo")){
    function getLastWeekInfo(){
        $ret = array();
        array_push($ret,date("Y-m-d",strtotime("last Sunday")));
        array_push($ret,date("Y-m-d",strtotime("last Saturday")));
        array_push($ret,date("Y-m-d",strtotime("last Week")));
        return $ret;
    }
}

if(!function_exists("getLastMonthInfo")){
    function getLastMonthInfo(){
        $ret = array();
        $start = date("Y-m",strtotime("last Month"));
        $start .= "-01";
        $end = date("Y-m");
        $end .= "-01";
        array_push($ret, $start);
        array_push($ret, $end);
        array_push($ret, date("Y-m-d",strtotime("last Month")));
        return $ret;
    }
}

if (!function_exists("getBeforeDay")) {
    function getBeforeDay($nDay, $date = '')
    {

        if ($date == '') {
            $date = strtotime(date("Y-m-d"));
        } else {
            $date = strtotime($date);
        }
        $date = strtotime("-" . $nDay . " day", $date);
        $date = date("Y-m-d", $date);
        return $date;
    }
}

if (!function_exists("getBeforeMonth")) {
    function getBeforeMonth($nMonth, $date = '')
    {
        if ($date == null || $date == ''  ) {
            $date = strtotime(date("Y-m-d H:i:s"));
        } else {
            $date = strtotime($date);
        }
        $date = strtotime($nMonth . " month", $date);
        $date = date("Y-m-d H:i:s", $date);

        return $date;
    }
}


if (!function_exists("getDayDiff")) {
    function getDayDiff($date1, $date2)
    {

        if ($date1 == '') {
            $date1 = strtotime(date("Y-m-d"));
        } else {
            $date1 = strtotime($date1);
        }
        $date2 = strtotime($date2);
        $date = ($date1 - $date2)/(24*3600);
        $date = number_format($date);
        return $date;
    }
}

if (!function_exists("getDayDiff1")) {
    function getDayDiff1($date1, $date2)
    {

        if ($date1 == '') {
            $date1 = strtotime(date("Y-m-d"));
        } else {
            $date1 = strtotime($date1);
        }
        $date2 = strtotime($date2);
        $date = ($date1 - $date2)/(24*3600);
        return $date;
    }
}



