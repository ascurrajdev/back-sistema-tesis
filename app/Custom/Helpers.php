<?php
if(!function_exists('getIntervalArray')){
    function getIntervalArray($from, $to){
        $interval = new \DateInterval('P1D');
        $from = date_create($from);
        $to = date_create($to);
        $to->add($interval);
        $period = new \DatePeriod($from, $interval, $to);
        $periodArray = array();
        foreach($period as $date){
            $periodArray[] = $date->format('Y-m-d');
        }
        return $periodArray;
    }
}