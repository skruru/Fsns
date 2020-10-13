<?php

namespace App\Lib;

use Carbon\Carbon;

class My_func
{
    public static function today()
    {
        $dt = Carbon::now();

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';
        if($m!=''||$y!=''){
            $dt = Carbon::createFromDate($y,$m,01);
        }else{
        $dt = Carbon::createFromDate();
        }

        //今月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        return ['tmY' => $tmY, 'tmM' => $tmM];
    }
}


