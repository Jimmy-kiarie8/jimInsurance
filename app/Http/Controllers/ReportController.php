<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Policy;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        // return $request->all();
        $start_date = $request->form['start_date'];
        $end_date = $request->form['end_date'];
        $report = $request->report['Rtype'];
        if ($report == 'premium') {
            return Policy::whereBetween('created_at', [$start_date, $end_date])->where()->get();
        }elseif($report == 'renewal') {
            return 'renewal';
        }elseif($report == 'product') {
            return 'product';
        }else{
            return;
        }
    }
}
