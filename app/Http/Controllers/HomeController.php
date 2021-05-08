<?php

namespace App\Http\Controllers;

use App\Invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $paid = (Invoices::where('status', 2)->count() / Invoices::count()) * 100;
        $unpaid = (Invoices::where('status', 0)->count() / Invoices::count()) * 100;
        $partlypaid = (Invoices::where('status', 1)->count() / Invoices::count()) * 100;

        $paidCount = Invoices::where('status', 2)->count();
        $unpaidCount = Invoices::where('status', 0)->count();
        $partlypaidCount = Invoices::where('status', 1)->count();

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير بالكامل', 'الفواتير المدفوعة', 'الفواتير الغير مدفوعة', 'الفواتير المدفوعة جزئياً'])
            ->datasets([
                [
                    "label" => "نسبة الفاتورة",
                    'backgroundColor' => '#36A2EB',
                    'hoverBackgroundColor' => '#327eb1',
                    'data' => [100, $paid, $unpaid, $partlypaid]
                ]
            ])
            ->options([
                'legend' => [
                    'display' => false
                ]
            ]);

        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 272])
            ->labels(['المدفوعة', 'الغير مدفوعة', 'المدفوعة جزئياً'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [$paidCount, $unpaidCount, $partlypaidCount]
                ]
            ])
            ->options([]);


        return view('index', compact('chartjs', 'chartjs2'));
    }
}
