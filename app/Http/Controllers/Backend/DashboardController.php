<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\DashboardService;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new DashboardService();
    }
    public function index(Request $request)
    {
        if (!$request->has(['chart', 'last'])) {
            return redirect()->route('dashboard_module.dashboard.index', ['chart' => '7_days', 'last' => '7_days']);
        }

        $data =  $this->service->getTopProductsByDays($request);

        $getSalesData =   $this->service->getSalesData();
        $getUserData = $this->service->getUserData();
        $getChartData = $this->service->getChartData($request)['chart'];
        $getTotal = $this->service->getChartData($request)['total'];
        $getTotalOrder = $this->service->getTotalDashboard();


        return view('backend.dashboard.dashboard', compact(
            ['data', 'getSalesData', 'getUserData', 'getChartData', 'getTotal', 'getTotalOrder']
        ));
    }

    public function getSalesData()
    {
        return $this->service->getSalesData();
    }
}
