<?php

namespace App\Charts;

use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Carbon;

class MonthlyOrderChart
{
    protected $cart;

    public function __construct(LarapexChart $cart)
    {
        $this->cart = $cart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $currentMonthOrder = Order::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();
        $before_1_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(1))->count();
        $before_2_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(2))->count();
        $before_3_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(3))->count();
        $monthNames = [
            Carbon::now()->format('F'),
            Carbon::now()->subMonth(1)->format('F'),
            Carbon::now()->subMonth(2)->format('F'),
            Carbon::now()->subMonth(3)->format('F'),
        ];


        return $this->cart->barChart()
            ->setTitle('Order Report')
            ->setSubtitle('Current Month')
            ->addData('Orders', [$currentMonthOrder,$before_1_month_order,$before_2_month_order,$before_3_month_order])
            ->setXAxis($monthNames);
        }
}
