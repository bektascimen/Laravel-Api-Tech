<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $report = DB::table('purchase')
            ->select('application.name as ApplicationName', 'os.name as OSName',
                DB::raw('COUNT(purchase.id) as Toplam'),
                DB::raw('COUNT(CASE WHEN purchase.is_canceled = "1" THEN 1 END) AS Iptal'),
                DB::raw('COUNT(CASE WHEN purchase.updated_at > purchase.created_at THEN 1 END) AS Yenilenen'))
            ->join('device', 'device.uId', '=', 'purchase.device_id')
            ->join('application', 'device.appId', '=', 'application.id')
            ->join('os', 'device.osId', '=', 'os.id')
            ->groupBy('os.name', 'application.name')
            ->get();

        return response()->json($report);
    }
}
