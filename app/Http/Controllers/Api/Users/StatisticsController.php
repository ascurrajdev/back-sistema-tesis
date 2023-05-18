<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use DB;

class StatisticsController extends Controller
{
    use ResponseTrait;

    public function index_summary(){
        $initDate = date_create("first day of this month")->format("Y-m-d");
        $endDate = date_create("last day of this month")->format("Y-m-d");
        $reservations = DB::table("reservations")->select(DB::raw("count(*) as cantidad"))->whereRaw("date(created_at) >= ? and date(created_at) <= ?",[$initDate,$endDate])->first();
        $ingresos = DB::table("");
    }
}
