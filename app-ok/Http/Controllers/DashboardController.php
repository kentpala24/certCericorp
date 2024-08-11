<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $anio=date('Y');
       $certificados= DB::table('certificados as c')->select(DB::raw('MONTHNAME(c.created_at) as mes'),
       DB::raw('YEAR(c.created_at) as anio'), DB::raw('SUM(c.condicion/2) as total'))
       ->whereYear('c.created_at',$anio)
       ->groupBy(DB::raw('MONTHNAME(c.created_at)'),DB::raw('YEAR(c.created_at)'))->where('c.condicion','=','2')->get();
       $anulados= DB::table('certificados as c')->select(DB::raw('MONTHNAME(c.created_at) as mesa'),
       DB::raw('YEAR(c.created_at) as anioa'), DB::raw('COUNT(c.condicion/2) as totala'))
       ->whereYear('c.created_at',$anio)
       ->groupBy(DB::raw('MONTHNAME(c.created_at)'),DB::raw('YEAR(c.created_at)'))->where('c.condicion','=','0')->get();
       return ['certificados'=>$certificados,'anulados'=>$anulados,'anio'=>$anio];
    }
}
