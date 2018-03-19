<?php

namespace App\Http\Controllers\Admin;

use App\Models\Court;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CourtController extends Controller
{
    //
    function index(){
         $nameall = Court::where([])->get()->toArray();
         //dd($nameall);
         $names = array_column($nameall, 'name');
         echo json_encode($names,JSON_UNESCAPED_UNICODE);

    }
}
