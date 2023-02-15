<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use App\Models\UserFrequent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $m = DB::table('user_frequents as t1')
        ->selectRaw("u.id, u.email , concat(f.name, '-', s.name) as frequentbook")
        ->whereRaw('t1.count = (SELECT MAX(t2.count) FROM user_frequents t2 WHERE t2.user_id = t1.user_id)')
        ->join('users as u', 'u.id', 't1.user_id')
        ->join('stations as f', 'f.id', 't1.from_station_id')
        ->join('stations as s', 's.id', 't1.to_station_id')
        ->get();
            
        return response()->json($m);
    }
}
